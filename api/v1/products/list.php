<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Products List API
|--------------------------------------------------------------------------
| File:
| api/v1/products/list.php
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
| Filters
|--------------------------------------------------------------------------
*/

$search = cleanString(
    $_GET['search'] ?? ''
);

$categoryId = cleanInt(
    $_GET['category_id'] ?? 0
);

$status = cleanString(
    $_GET['status'] ?? 'active'
);

$featured = isset($_GET['featured'])
    ? cleanString($_GET['featured'])
    : '';

$page = max(
    1,
    cleanInt($_GET['page'] ?? 1, 1)
);

$limit = cleanInt(
    $_GET['limit'] ?? DEFAULT_PAGE_SIZE,
    DEFAULT_PAGE_SIZE
);

$limit = min(
    max($limit, 1),
    MAX_PAGE_SIZE
);

$offset = ($page - 1) * $limit;


/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/

try {

    $db = getDatabaseConnection();


    /*
    |--------------------------------------------------------------------------
    | Base WHERE
    |--------------------------------------------------------------------------
    */

    $where = [];

    $params = [];


    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    if ($status !== '') {

        if (
            in_array(
                $status,
                ['active', 'inactive'],
                true
            )
        ) {

            $where[] =
                'p.status = :status';

            $params[':status'] =
                $status;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    if ($categoryId > 0) {

        $where[] =
            'p.category_id = :category_id';

        $params[':category_id'] =
            $categoryId;

    }


    /*
    |--------------------------------------------------------------------------
    | Featured
    |--------------------------------------------------------------------------
    */

    if (
        $featured !== '' &&
        in_array(
            $featured,
            ['0', '1'],
            true
        )
    ) {

        $where[] =
            'p.featured = :featured';

        $params[':featured'] =
            (int) $featured;

    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    if ($search !== '') {

        $where[] = "
            (
                p.name LIKE :search
                OR p.sku LIKE :search
                OR p.description LIKE :search
            )
        ";

        $params[':search'] =
            '%' . $search . '%';

    }


    /*
    |--------------------------------------------------------------------------
    | WHERE SQL
    |--------------------------------------------------------------------------
    */

    $whereSql = '';

    if (!empty($where)) {

        $whereSql =
            ' WHERE ' .
            implode(
                ' AND ',
                $where
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Count
    |--------------------------------------------------------------------------
    */

   $countSql = "

        SELECT COUNT(*)

        FROM products p

        {$whereSql}

    ";


    $countStmt =
        $db->prepare(
            $countSql
        );


    $countStmt->execute(
        $params
    );


    $total =
        (int)
        $countStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    $sql = "

        SELECT

            p.id,

            p.category_id,

            c.name AS category_name,

            c.slug AS category_slug,

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

            p.updated_at

        FROM products p

        LEFT JOIN categories c
            ON c.id = p.category_id

        {$whereSql}

        ORDER BY

            p.sort_order ASC,

            p.id DESC

        LIMIT :limit

        OFFSET :offset

    ";


    $stmt =
        $db->prepare(
            $sql
        );


    /*
    |--------------------------------------------------------------------------
    | Bind Parameters
    |--------------------------------------------------------------------------
    */

    foreach (
        $params as $key => $value
    ) {

        $stmt->bindValue(
            $key,
            $value
        );

    }


    $stmt->bindValue(
        ':limit',
        $limit,
        PDO::PARAM_INT
    );


    $stmt->bindValue(
        ':offset',
        $offset,
        PDO::PARAM_INT
    );


    $stmt->execute();


    $products =
        $stmt->fetchAll();


    /*
    |--------------------------------------------------------------------------
    | Format Products
    |--------------------------------------------------------------------------
    */

    $result =
        array_map(
            function (
                $product
            ) {

                return [

                    'id' =>
                        (int)
                        $product['id'],

                    'category_id' =>
                        $product['category_id']
                            !== null
                            ? (int)
                                $product['category_id']
                            : null,

                    'category_name' =>
                        $product['category_name'],

                    'category_slug' =>
                        $product['category_slug'],

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
                        (bool)
                        $product['featured'],

                    'sort_order' =>
                        (int)
                        $product['sort_order'],

                    'created_at' =>
                        $product['created_at'],

                    'updated_at' =>
                        $product['updated_at']

                ];

            },
            $products
        );


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    $totalPages =
        $total > 0
            ? (int)
                ceil(
                    $total / $limit
                )
            : 0;


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [

            'products' =>
                $result,

            'pagination' => [

                'page' =>
                    $page,

                'limit' =>
                    $limit,

                'total' =>
                    $total,

                'total_pages' =>
                    $totalPages

            ]

        ],

        'تم تحميل المنتجات بنجاح.'
    );


} catch (Throwable $e) {

    error_log(
        'Products List API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تحميل المنتجات.',
        500
    );

}
