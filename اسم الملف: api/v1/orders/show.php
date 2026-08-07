<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Show Order API
|--------------------------------------------------------------------------
| File:
| api/v1/orders/show.php
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../config/auth.php';


/*
|--------------------------------------------------------------------------
| Initialize API
|--------------------------------------------------------------------------
*/

initializeApi();


/*
|--------------------------------------------------------------------------
| GET Only
|--------------------------------------------------------------------------
*/

if (requestMethod() !== 'GET') {

    errorResponse(
        'طريقة الطلب غير مسموحة.',
        405
    );

}


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

requireAdminLogin();


/*
|--------------------------------------------------------------------------
| Order ID
|--------------------------------------------------------------------------
*/

$id = cleanInt(
    $_GET['id'] ?? 0
);

if ($id <= 0) {

    errorResponse(
        'رقم الطلب غير صحيح.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/

try {

    $db = getDatabaseConnection();


    /*
    |--------------------------------------------------------------------------
    | Get Order
    |--------------------------------------------------------------------------
    */

    $orderStmt = $db->prepare(
        "
        SELECT

            id,
            order_number,
            customer_name,
            customer_phone,
            customer_address,
            customer_notes,
            subtotal,
            shipping,
            discount,
            total,
            status,
            created_at,
            updated_at

        FROM orders

        WHERE id = :id

        LIMIT 1
        "
    );


    $orderStmt->execute([
        ':id' => $id
    ]);


    $order = $orderStmt->fetch();


    if (!$order) {

        errorResponse(
            'الطلب غير موجود.',
            404
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Get Order Items
    |--------------------------------------------------------------------------
    */

    $itemsStmt = $db->prepare(
        "
        SELECT

            id,
            order_id,
            product_id,
            product_name,
            sku,
            price,
            quantity,
            unit,
            total,
            image

        FROM order_items

        WHERE order_id = :order_id

        ORDER BY id ASC
        "
    );


    $itemsStmt->execute([
        ':order_id' => $id
    ]);


    $items = $itemsStmt->fetchAll();


    /*
    |--------------------------------------------------------------------------
    | Format Items
    |--------------------------------------------------------------------------
    */

    $formattedItems =
        array_map(
            function ($item) {

                return [

                    'id' =>
                        (int)
                        $item['id'],

                    'product_id' =>
                        (int)
                        $item['product_id'],

                    'product_name' =>
                        $item['product_name'],

                    'sku' =>
                        $item['sku'],

                    'price' =>
                        (float)
                        $item['price'],

                    'quantity' =>
                        (float)
                        $item['quantity'],

                    'unit' =>
                        $item['unit'],

                    'total' =>
                        (float)
                        $item['total'],

                    'image' =>
                        $item['image']

                ];

            },
            $items
        );


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [

            'order' => [

                'id' =>
                    (int)
                    $order['id'],

                'order_number' =>
                    $order['order_number'],

                'customer' => [

                    'name' =>
                        $order['customer_name'],

                    'phone' =>
                        $order['customer_phone'],

                    'address' =>
                        $order['customer_address'],

                    'notes' =>
                        $order['customer_notes']

                ],

                'financial' => [

                    'subtotal' =>
                        (float)
                        $order['subtotal'],

                    'shipping' =>
                        (float)
                        $order['shipping'],

                    'discount' =>
                        (float)
                        $order['discount'],

                    'total' =>
                        (float)
                        $order['total']

                ],

                'status' =>
                    $order['status'],

                'items' =>
                    $formattedItems,

                'created_at' =>
                    $order['created_at'],

                'updated_at' =>
                    $order['updated_at']

            ]

        ],

        'تم تحميل تفاصيل الطلب بنجاح.'
    );


} catch (Throwable $e) {

    error_log(
        'Show Order API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تحميل تفاصيل الطلب.',
        500
    );

}
