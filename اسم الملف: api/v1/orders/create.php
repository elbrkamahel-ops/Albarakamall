<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Create Order API
|--------------------------------------------------------------------------
| File:
| api/v1/orders/create.php
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../config/database.php';


/*
|--------------------------------------------------------------------------
| Initialize API
|--------------------------------------------------------------------------
*/

initializeApi();


/*
|--------------------------------------------------------------------------
| POST Only
|--------------------------------------------------------------------------
*/

if (requestMethod() !== 'POST') {

    errorResponse(
        'طريقة الطلب غير مسموحة.',
        405
    );

}


/*
|--------------------------------------------------------------------------
| Request Data
|--------------------------------------------------------------------------
*/

$data = getJsonInput();

if (empty($data)) {

    $data = $_POST;

}


/*
|--------------------------------------------------------------------------
| Customer Information
|--------------------------------------------------------------------------
*/

$customerName = cleanString(
    $data['customer_name'] ?? ''
);

$customerPhone = cleanString(
    $data['customer_phone'] ?? ''
);

$customerAddress = cleanString(
    $data['customer_address'] ?? ''
);

$customerNotes = cleanString(
    $data['customer_notes'] ?? ''
);


/*
|--------------------------------------------------------------------------
| Order Items
|--------------------------------------------------------------------------
*/

$items =
    $data['items'] ?? [];


if (
    !is_array($items) ||
    empty($items)
) {

    errorResponse(
        'يجب إضافة منتج واحد على الأقل إلى الطلب.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Validate Customer
|--------------------------------------------------------------------------
*/

if ($customerName === '') {

    errorResponse(
        'اسم العميل مطلوب.',
        422
    );

}

if (
    mb_strlen($customerName) < 2
) {

    errorResponse(
        'اسم العميل غير صحيح.',
        422
    );

}


if ($customerPhone === '') {

    errorResponse(
        'رقم الهاتف مطلوب.',
        422
    );

}


if ($customerAddress === '') {

    errorResponse(
        'عنوان التوصيل مطلوب.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Normalize Phone
|--------------------------------------------------------------------------
*/

$customerPhone =
    preg_replace(
        '/[^0-9+]/',
        '',
        $customerPhone
    );


if (
    strlen($customerPhone) < 8
) {

    errorResponse(
        'رقم الهاتف غير صحيح.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/

try {

    $db =
        getDatabaseConnection();


    /*
    |--------------------------------------------------------------------------
    | Start Transaction
    |--------------------------------------------------------------------------
    */

    $db->beginTransaction();


    /*
    |--------------------------------------------------------------------------
    | Prepare Product Query
    |--------------------------------------------------------------------------
    */

    $productStmt =
        $db->prepare(
            "
            SELECT

                id,

                category_id,

                name,

                sku,

                price,

                stock,

                unit,

                image,

                status

            FROM products

            WHERE id = :id

            LIMIT 1

            FOR UPDATE
            "
        );


    /*
    |--------------------------------------------------------------------------
    | Prepare Order Items
    |--------------------------------------------------------------------------
    */

    $orderItems = [];

    $subtotal = 0;


    /*
    |--------------------------------------------------------------------------
    | Process Items
    |--------------------------------------------------------------------------
    */

    foreach (
        $items as $item
    ) {

        $productId =
            cleanInt(
                $item['product_id'] ?? 0
            );


        $quantity =
            cleanFloat(
                $item['quantity'] ?? 0
            );


        if (
            $productId <= 0
        ) {

            throw new RuntimeException(
                'يوجد منتج غير صالح داخل الطلب.'
            );

        }


        if (
            $quantity <= 0
        ) {

            throw new RuntimeException(
                'كمية أحد المنتجات غير صحيحة.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Get Product
        |--------------------------------------------------------------------------
        */

        $productStmt->execute(
            [
                ':id' =>
                    $productId
            ]
        );


        $product =
            $productStmt->fetch();


        if (
            !$product
        ) {

            throw new RuntimeException(
                'أحد المنتجات غير موجود.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Active Check
        |--------------------------------------------------------------------------
        */

        if (
            $product['status'] !== 'active'
        ) {

            throw new RuntimeException(
                'المنتج "' .
                $product['name'] .
                '" غير متاح حاليًا.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Stock Check
        |--------------------------------------------------------------------------
        */

        $stock =
            (float)
            $product['stock'];


        if (
            $quantity > $stock
        ) {

            throw new RuntimeException(
                'الكمية المطلوبة من "' .
                $product['name'] .
                '" أكبر من المخزون المتاح.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Price
        |--------------------------------------------------------------------------
        */

        $price =
            (float)
            $product['price'];


        $lineTotal =
            $price *
            $quantity;


        /*
        |--------------------------------------------------------------------------
        | Subtotal
        |--------------------------------------------------------------------------
        */

        $subtotal +=
            $lineTotal;


        /*
        |--------------------------------------------------------------------------
        | Store Snapshot
        |--------------------------------------------------------------------------
        */

        $orderItems[] = [

            'product_id' =>
                (int)
                $product['id'],

            'product_name' =>
                $product['name'],

            'sku' =>
                $product['sku'],

            'price' =>
                $price,

            'quantity' =>
                $quantity,

            'unit' =>
                $product['unit'],

            'total' =>
                $lineTotal,

            'image' =>
                $product['image']

        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Shipping
    |--------------------------------------------------------------------------
    */

    $shipping =
        isset(
            $data['shipping']
        )
            ? cleanFloat(
                $data['shipping']
            )
            : 0;


    if (
        $shipping < 0
    ) {

        $shipping = 0;

    }


    /*
    |--------------------------------------------------------------------------
    | Discount
    |--------------------------------------------------------------------------
    */

    $discount =
        isset(
            $data['discount']
        )
            ? cleanFloat(
                $data['discount']
            )
            : 0;


    if (
        $discount < 0
    ) {

        $discount = 0;

    }


    /*
    |--------------------------------------------------------------------------
    | Prevent Invalid Discount
    |--------------------------------------------------------------------------
    */

    if (
        $discount > $subtotal
    ) {

        $discount =
            $subtotal;

    }


    /*
    |--------------------------------------------------------------------------
    | Total
    |--------------------------------------------------------------------------
    */

    $total =
        $subtotal +
        $shipping -
        $discount;


    if (
        $total < 0
    ) {

        $total = 0;

    }


    /*
    |--------------------------------------------------------------------------
    | Order Number
    |--------------------------------------------------------------------------
    */

    $orderNumber =
        generateOrderNumber();


    /*
    |--------------------------------------------------------------------------
    | Insert Order
    |--------------------------------------------------------------------------
    */

    $orderStmt =
        $db->prepare(
            "
            INSERT INTO orders
            (
                order_number,

                customer_name,

                customer_phone,

                customer_address,

                customer_notes,

                subtotal,

                shipping,

                discount,

                total,

                status
            )

            VALUES
            (
                :order_number,

                :customer_name,

                :customer_phone,

                :customer_address,

                :customer_notes,

                :subtotal,

                :shipping,

                :discount,

                :total,

                :status
            )
            "
        );


    $orderStmt->execute(
        [

            ':order_number' =>
                $orderNumber,

            ':customer_name' =>
                $customerName,

            ':customer_phone' =>
                $customerPhone,

            ':customer_address' =>
                $customerAddress,

            ':customer_notes' =>
                $customerNotes ?: null,

            ':subtotal' =>
                $subtotal,

            ':shipping' =>
                $shipping,

            ':discount' =>
                $discount,

            ':total' =>
                $total,

            ':status' =>
                'pending'

        ]
    );


    /*
    |--------------------------------------------------------------------------
    | Order ID
    |--------------------------------------------------------------------------
    */

    $orderId =
        (int)
        $db->lastInsertId();


    /*
    |--------------------------------------------------------------------------
    | Insert Items
    |--------------------------------------------------------------------------
    */

    $itemStmt =
        $db->prepare(
            "
            INSERT INTO order_items
            (
                order_id,

                product_id,

                product_name,

                sku,

                price,

                quantity,

                unit,

                total,

                image
            )

            VALUES
            (
                :order_id,

                :product_id,

                :product_name,

                :sku,

                :price,

                :quantity,

                :unit,

                :total,

                :image
            )
            "
        );


    /*
    |--------------------------------------------------------------------------
    | Update Stock
    |--------------------------------------------------------------------------
    */

    $stockStmt =
        $db->prepare(
            "
            UPDATE products

            SET stock =
                stock - :quantity

            WHERE id = :id

            AND stock >= :quantity
            "
        );


    foreach (
        $orderItems as $orderItem
    ) {

        /*
        | Insert Item
        */

        $itemStmt->execute(
            [

                ':order_id' =>
                    $orderId,

                ':product_id' =>
                    $orderItem['product_id'],

                ':product_name' =>
                    $orderItem['product_name'],

                ':sku' =>
                    $orderItem['sku'],

                ':price' =>
                    $orderItem['price'],

                ':quantity' =>
                    $orderItem['quantity'],

                ':unit' =>
                    $orderItem['unit'],

                ':total' =>
                    $orderItem['total'],

                ':image' =>
                    $orderItem['image']

            ]
        );


        /*
        | Decrease Stock
        */

        $stockStmt->execute(
            [

                ':quantity' =>
                    $orderItem['quantity'],

                ':id' =>
                    $orderItem['product_id']

            ]
        );


        if (
            $stockStmt->rowCount() === 0
        ) {

            throw new RuntimeException(
                'تعذر تحديث مخزون أحد المنتجات.'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Commit
    |--------------------------------------------------------------------------
    */

    $db->commit();


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [

            'order' => [

                'id' =>
                    $orderId,

                'order_number' =>
                    $orderNumber,

                'customer_name' =>
                    $customerName,

                'customer_phone' =>
                    $customerPhone,

                'customer_address' =>
                    $customerAddress,

                'subtotal' =>
                    round(
                        $subtotal,
                        2
                    ),

                'shipping' =>
                    round(
                        $shipping,
                        2
                    ),

                'discount' =>
                    round(
                        $discount,
                        2
                    ),

                'total' =>
                    round(
                        $total,
                        2
                    ),

                'status' =>
                    'pending',

                'items' =>
                    $orderItems

            ]

        ],

        'تم إنشاء الطلب بنجاح.'
    );


} catch (RuntimeException $e) {


    /*
    |--------------------------------------------------------------------------
    | Rollback
    |--------------------------------------------------------------------------
    */

    if (
        $db->inTransaction()
    ) {

        $db->rollBack();

    }


    errorResponse(
        $e->getMessage(),
        422
    );


} catch (Throwable $e) {


    /*
    |--------------------------------------------------------------------------
    | Rollback
    |--------------------------------------------------------------------------
    */

    if (
        isset($db) &&
        $db->inTransaction()
    ) {

        $db->rollBack();

    }


    error_log(
        'Create Order API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء إنشاء الطلب.',
        500
    );

}


/*
|--------------------------------------------------------------------------
| Generate Order Number
|--------------------------------------------------------------------------
*/

function generateOrderNumber(): string
{

    return 'BRK-' .
        date('Ymd') .
        '-' .
        strtoupper(
            bin2hex(
                random_bytes(4)
            )
        );

}
