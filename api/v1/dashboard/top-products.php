<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Dashboard Top Products API
|--------------------------------------------------------------------------
| File:
| api/v1/dashboard/top-products.php
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
    | Top Products
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare(
        "
        SELECT

            oi.product_id,

            oi.product_name,

            oi.sku,

            oi.image,

            SUM(
                oi.quantity
            ) AS quantity_sold,

            COUNT(
                DISTINCT oi.order_id
            ) AS orders_count,

            COALESCE(
                SUM(oi.total),
                0
            ) AS revenue

        FROM order_items oi

        INNER JOIN orders o

            ON o.id = oi.order_id

        WHERE o.status = 'delivered'

        GROUP BY

            oi.product_id,

            oi.product_name,

            oi.sku,

            oi.image

        ORDER BY

            quantity_sold DESC,

            revenue DESC

        LIMIT :limit
        "
    );


    $stmt->bindValue(
        ':limit',
        $limit,
        PDO::PARAM_INT
    );


    $stmt->execute();


    $products =
        $stmt->fetchAll();


    /*
    |--------------------------------------------------------------------------
    | Format
    |--------------------------------------------------------------------------
    */

    $result =
        array_map(
            function (
                $product
            ) {

                return [

                    'product_id' =>
                        (int)
                        $product['product_id'],

                    'name' =>
                        $product['product_name'],

                    'sku' =>
                        $product['sku'],

                    'image' =>
                        $product['image'],

                    'quantity_sold' =>
                        (float)
                        $product['quantity_sold'],

                    'orders_count' =>
                        (int)
                        $product['orders_count'],

                    'revenue' =>
                        (float)
                        $product['revenue']

                ];

            },
            $products
        );


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [

            'products' =>
                $result,

            'count' =>
                count($result)

        ],

        'تم تحميل المنتجات الأكثر مبيعًا بنجاح.'
    );


} catch (Throwable $e) {

    error_log(
        'Dashboard Top Products API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تحميل المنتجات الأكثر مبيعًا.',
        500
    );

}
