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

$orderId = cleanInt(
    $_GET['id']
    ?? $_GET['order_id']
    ?? 0
);


if ($orderId <= 0) {

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
            customer_email,

            address,
            city,
            area,
            notes,

            subtotal,
            delivery_fee,
            discount,
            total,

            payment_method,
            payment_status,

            status,

            created_at,
            updated_at

        FROM orders

        WHERE id = :id

        LIMIT 1
        "
    );


    $orderStmt->execute([
        ':id' => $orderId
    ]);


    $order = $orderStmt->fetch();


    /*
    |--------------------------------------------------------------------------
    | Not Found
    |--------------------------------------------------------------------------
    */

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
            product_id,

            product_name,
            sku,
            image,

            price,
            quantity,
            total

        FROM order_items

        WHERE order_id = :order_id

        ORDER BY id ASC
        "
    );


    $itemsStmt->execute([
        ':order_id' => $orderId
    ]);


    $items =
        $itemsStmt->fetchAll();


    /*
    |--------------------------------------------------------------------------
    | Format Items
    |--------------------------------------------------------------------------
    */

    $formattedItems =
        array_map(
            function (
                $item
            ) {

                return [

                    'id' =>
                        (int)
                        $item['id'],

                    'product_id' =>
                        $item['product_id']
                            !== null
                            ? (int)
                                $item['product_id']
                            : null,

                    'name' =>
                        $item['product_name'],

                    'sku' =>
                        $item['sku'],

                    'image' =>
                        $item['image'],

                    'price' =>
                        (float)
                        $item['price'],

                    'quantity' =>
                        (float)
                        $item['quantity'],

                    'total' =>
                        (float)
                        $item['total']

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

                    'email' =>
                        $order['customer_email']

                ],


                'address' => [

                    'address' =>
                        $order['address'],

                    'city' =>
                        $order['city'],

                    'area' =>
                        $order['area'],

                    'notes' =>
                        $order['notes']

                ],


                'financial' => [

                    'subtotal' =>
                        (float)
                        $order['subtotal'],

                    'delivery_fee' =>
                        (float)
                        $order['delivery_fee'],

                    'discount' =>
                        (float)
                        $order['discount'],

                    'total' =>
                        (float)
                        $order['total']

                ],


                'payment' => [

                    'method' =>
                        $order['payment_method'],

                    'status' =>
                        $order['payment_status']

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
