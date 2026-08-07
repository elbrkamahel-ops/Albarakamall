<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Show Product API
|--------------------------------------------------------------------------
| File:
| api/v1/products/show.php
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
| Product ID
|--------------------------------------------------------------------------
*/

$id = cleanInt(
    $_GET['id'] ?? 0
);


if ($id <= 0) {

    errorResponse(
        'رقم المنتج غير صحيح.',
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
    | Get Product
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare(
        "
        SELECT

            p.id,

            p.category_id,

            p.name,

            p.slug,

            p.description,

            p.sku,

            p.price,

            p.old_price,

            p.stock,

            p.unit,

            p.image,

            p.status,

            p.featured,

            p.sort_order,

            p.created_at,

            p.updated_at,

            c.name AS category_name

        FROM products p

        LEFT JOIN categories c

            ON c.id = p.category_id

        WHERE p.id = :id

        LIMIT 1
        "
    );


    $stmt->execute([
        ':id' => $id
    ]);


    $product = $stmt->fetch();


    /*
    |--------------------------------------------------------------------------
    | Not Found
    |--------------------------------------------------------------------------
    */

    if (!$product) {

        errorResponse(
            'المنتج غير موجود.',
            404
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [

            'product' => [

                'id' =>
                    (int)
                    $product['id'],

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

                'name' =>
                    $product['name'],

                'slug' =>
                    $product['slug'],

                'description' =>
                    $product['description'],

                'sku' =>
                    $product['sku'],

                'price' =>
                    (float)
                    $product['price'],

                'old_price' =>
                    $product['old_price']
                        !== null
                        ? (float)
                            $product['old_price']
                        : null,

                'stock' =>
                    (float)
                    $product['stock'],

                'unit' =>
                    $product['unit'],

                'image' =>
                    $product['image'],

                'status' =>
                    $product['status'],

                'featured' =>
                    (int)
                    $product['featured'],

                'sort_order' =>
                    (int)
                    $product['sort_order'],

                'created_at' =>
                    $product['created_at'],

                'updated_at' =>
                    $product['updated_at']

            ]

        ],

        'تم تحميل بيانات المنتج بنجاح.'
    );


} catch (Throwable $e) {

    error_log(
        'Show Product API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تحميل بيانات المنتج.',
        500
    );

}
