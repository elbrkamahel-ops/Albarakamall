<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    jsonResponse(
        [
            'success' => false,
            'error' => 'method_not_allowed'
        ],
        405
    );

}


$data =
    getJsonInput();


$name =
    cleanString(
        $data['name'] ?? ''
    );


$mobile =
    cleanPhone(
        $data['mobile'] ?? ''
    );


$address =
    cleanString(
        $data['address'] ?? ''
    );


$payment =
    cleanString(
        $data['payment'] ?? 'cash'
    );


$items =
    $data['items'] ?? [];


if (
    $name === '' ||
    $mobile === '' ||
    $address === '' ||
    !is_array($items) ||
    count($items) === 0
) {

    jsonResponse(
        [
            'success' => false,
            'error' => 'invalid_order_data'
        ],
        422
    );

}


if (!in_array(
    $payment,
    ['cash', 'card'],
    true
)) {

    jsonResponse(
        [
            'success' => false,
            'error' => 'invalid_payment_method'
        ],
        422
    );

}


try {

    $pdo = db();

    $pdo->beginTransaction();


    $subtotal = 0;

    $orderItems = [];


    /*
       نقرأ الأسعار من قاعدة البيانات،
       وليس من المتصفح.

       هذا مهم جدًا لمنع العميل من
       تعديل السعر من JavaScript.
    */

    $productStmt =
        $pdo->prepare(
            "
            SELECT
                id,
                name,
                price,
                unit,
                stock

            FROM products

            WHERE id = ?

            AND active = 1

            FOR UPDATE
            "
        );


    foreach ($items as $item) {

        $productId =
            (int)(
                $item['id'] ?? 0
            );


        $quantity =
            (float)(
                $item['qty'] ?? 0
            );


        if (
            $productId <= 0 ||
            $quantity <= 0
        ) {

            throw new Exception(
                'invalid_item'
            );

        }


        $productStmt->execute(
            [$productId]
        );


        $product =
            $productStmt->fetch();


        if (!$product) {

            throw new Exception(
                'product_not_found'
            );

        }


        if (
            (float)$product['stock']
            < $quantity
        ) {

            throw new Exception(
                'insufficient_stock'
            );

        }


        $price =
            (float)$product['price'];


        $itemSubtotal =
            $price * $quantity;


        $subtotal +=
            $itemSubtotal;


        $orderItems[] = [

            'product_id' =>
                (int)$product['id'],

            'product_name' =>
                $product['name'],

            'product_price' =>
                $price,

            'quantity' =>
                $quantity,

            'unit' =>
                $product['unit'],

            'subtotal' =>
                $itemSubtotal

        ];

    }


    /*
       مصاريف التوصيل من إعدادات المتجر
    */

    $settingsStmt =
        $pdo->prepare(
            "
            SELECT setting_value

            FROM settings

            WHERE setting_key = ?
            "
        );


    $settingsStmt->execute(
        ['delivery_fee']
    );


    $deliveryRow =
        $settingsStmt->fetch();


    $deliveryFee =
        $deliveryRow
        ? (float)$deliveryRow['setting_value']
        : 0;


    $discount = 0;


    $total =
        $subtotal +
        $deliveryFee -
        $discount;


    /*
       إنشاء رقم الطلب
    */

    $orderNumber =
        'ALB-' .
        date('Ymd-His') .
        '-' .
        random_int(
            100,
            999
        );


    /*
       إنشاء العميل
    */

    $customerStmt =
        $pdo->prepare(
            "
            INSERT INTO customers
            (
                name,
                mobile,
                address
            )

            VALUES
            (
                ?,
                ?,
                ?
            )
            "
        );


    $customerStmt->execute(
        [
            $name,
            $mobile,
            $address
        ]
    );


    $customerId =
        (int)$pdo->lastInsertId();


    /*
       إنشاء الطلب
    */

    $orderStmt =
        $pdo->prepare(
            "
            INSERT INTO orders
            (
                order_number,
                customer_id,
                customer_name,
                customer_mobile,
                customer_address,
                payment_method,
                payment_status,
                order_status,
                subtotal,
                delivery_fee,
                discount,
                total
            )

            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                'pending',
                'new',
                ?,
                ?,
                ?,
                ?
            )
            "
        );


    $orderStmt->execute(
        [
            $orderNumber,
            $customerId,
            $name,
            $mobile,
            $address,
            $payment,
            $subtotal,
            $deliveryFee,
            $discount,
            $total
        ]
    );


    $orderId =
        (int)$pdo->lastInsertId();


    /*
       تفاصيل الطلب
    */

    $itemStmt =
        $pdo->prepare(
            "
            INSERT INTO order_items
            (
                order_id,
                product_id,
                product_name,
                product_price,
                quantity,
                unit,
                subtotal
            )

            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            )
            "
        );


    $stockStmt =
        $pdo->prepare(
            "
            UPDATE products

            SET stock =
                stock - ?

            WHERE id = ?
            "
        );


    foreach ($orderItems as $orderItem) {

        $itemStmt->execute(
            [
                $orderId,
                $orderItem['product_id'],
                $orderItem['product_name'],
                $orderItem['product_price'],
                $orderItem['quantity'],
                $orderItem['unit'],
                $orderItem['subtotal']
            ]
        );


        $stockStmt->execute(
            [
                $orderItem['quantity'],
                $orderItem['product_id']
            ]
        );

    }


    $pdo->commit();


    /*
       الدفع بالكارت سيتم ربطه ببوابة
       دفع حقيقية في مرحلة الدفع.
    */

    jsonResponse(
        [
            'success' => true,

            'order_id' =>
                $orderNumber,

            'total' =>
                $total,

            'payment' =>
                $payment
        ],
        201
    );


} catch (Throwable $e) {

    if (
        isset($pdo) &&
        $pdo->inTransaction()
    ) {

        $pdo->rollBack();

    }


    jsonResponse(
        [
            'success' => false,
            'error' => $e->getMessage()
        ],
        400
    );

}
