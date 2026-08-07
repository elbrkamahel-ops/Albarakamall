<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Dashboard Low Stock API
|--------------------------------------------------------------------------
| File:
| api/v1/dashboard/low-stock.php
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
    $_GET['limit'] ?? 20,
    20
);


$limit = min(
    max(
        $limit,
        1
    ),
    100
);


/*
|--------------------------------------------------------------------------
| Threshold
|--------------------------------------------------------------------------
*/

$threshold = cleanInt(
    $_GET['threshold'] ?? 5,
    5
);


$threshold = min(
    max(
        $threshold,
        0
    ),
    1000
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
    | Low Stock Products
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare(
        "
        SELECT

            p.id,

            p.name,

            p.sku,

            p.image,

            p.stock,

            p.price,

            p.status,

            c.id AS category_id,

            c.name AS category_name

        FROM products p

        LEFT JOIN categories c

            ON c.id = p.category_id

        WHERE p.status = 'active'

        AND p.stock <= :threshold

        ORDER BY

            p.stock ASC,

            p.id DESC

        LIMIT :limit
        "
    );


    $stmt->bindValue(
        ':threshold',
        $threshold,
        PDO::PARAM_INT
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

                $stock =
                    (float)
                    $product['stock'];


                return [

                    'id' =>
                        (int)
                        $product['id'],

                    'name' =>
                        $product['name'],

                    'sku' =>
                        $product['sku'],

                    'image' =>
                        $product['image'],

                    'stock' =>
                        $stock,

                    'price' =>
                        (float)
                        $product['price'],

                    'status' =>
                        $product['status'],

                    'category' => [

                        'id' =>
                            $product['category_id']
                                !== null
                                ? (int)
                                    $product['category_id']
                                : null,

                        'name' =>
                            $product['category_name']

                    ],

                    'stock_status' =>
                        $stock <= 0
                            ? 'out_of_stock'
                            : 'low_stock'

                ];

            },
            $products
        );


    /*
    |--------------------------------------------------------------------------
    | Count
    |--------------------------------------------------------------------------
    */

    $countStmt = $db->prepare(
        "
        SELECT COUNT(*)

        FROM products

        WHERE status = 'active'

        AND stock <= :threshold
        "
    );


    $countStmt->bindValue(
        ':threshold',
        $threshold,
        PDO::PARAM_INT
    );


    $countStmt->execute();


    $total =
        (int)
        $countStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [

            'threshold' =>
                $threshold,

            'products' =>
                $result,

            'count' =>
                count($result),

            'total' =>
                $total

        ],

        'تم تحميل المنتجات منخفضة المخزون بنجاح.'
    );


} catch (Throwable $e) {

    error_log(
        'Dashboard Low Stock API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تحميل المخزون المنخفض.',
        500
    );

}
