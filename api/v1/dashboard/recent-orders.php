<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Dashboard Recent Orders API
|--------------------------------------------------------------------------
| File:
| api/v1/dashboard/recent-orders.php
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
| Limit
|--------------------------------------------------------------------------
*/

$limit = cleanInt(
    $_GET['limit'] ?? 10,
    10
);


$limit = min(
    max(
        $limit,
        1
    ),
    50
);


/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/

try {

    $db = getDatabaseConnection();


    /*
    |--------------------------------------------------------------------------
    | Recent Orders
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare(
        "
        SELECT

            o.id,

            o.order_number,

            o.customer_name,

            o.customer_phone,

            o.total,

            o.status,

            o.created_at

        FROM orders o

        ORDER BY
            o.id DESC

        LIMIT :limit
        "
    );


    $stmt->bindValue(
        ':limit',
        $limit,
        PDO::PARAM_INT
    );


    $stmt->execute();


    $orders =
        $stmt->fetchAll();


    /*
    |--------------------------------------------------------------------------
    | Format Orders
    |--------------------------------------------------------------------------
    */

    $result =
        array_map(
            function (
                $order
            ) {

                return [

                    'id' =>
                        (int)
                        $order['id'],

                    'order_number' =>
                        $order['order_number'],

                    'customer' => [

                        'name' =>
                            $order['customer_name'],

                        'phone' =>
                            $order['customer_phone']

                    ],

                    'total' =>
                        (float)
                        $order['total'],

                    'status' =>
                        $order['status'],

                    'created_at' =>
                        $order['created_at']

                ];

            },
            $orders
        );


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [

            'orders' =>
                $result,

            'count' =>
                count($result)

        ],

        'تم تحميل أحدث الطلبات بنجاح.'
    );


} catch (Throwable $e) {

    error_log(
        'Dashboard Recent Orders API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تحميل أحدث الطلبات.',
        500
    );

}
