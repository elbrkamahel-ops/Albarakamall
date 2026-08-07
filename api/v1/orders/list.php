<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Orders List API
|--------------------------------------------------------------------------
| File:
| api/v1/orders/list.php
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
| Filters
|--------------------------------------------------------------------------
*/

$search = cleanString(
    $_GET['search'] ?? ''
);

$status = cleanString(
    $_GET['status'] ?? ''
);

$dateFrom = cleanString(
    $_GET['date_from'] ?? ''
);

$dateTo = cleanString(
    $_GET['date_to'] ?? ''
);

$page = max(
    1,
    cleanInt(
        $_GET['page'] ?? 1,
        1
    )
);

$limit = cleanInt(
    $_GET['limit'] ?? DEFAULT_PAGE_SIZE,
    DEFAULT_PAGE_SIZE
);

$limit = min(
    max($limit, 1),
    MAX_PAGE_SIZE
);

$offset =
    ($page - 1) * $limit;


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
    | WHERE
    |--------------------------------------------------------------------------
    */

    $where = [];

    $params = [];


    /*
    |--------------------------------------------------------------------------
    | Status Filter
    |--------------------------------------------------------------------------
    */

    if ($status !== '') {

        $allowedStatuses = [

            'pending',
            'confirmed',
            'preparing',
            'out_for_delivery',
            'delivered',
            'cancelled'

        ];


        if (
            in_array(
                $status,
                $allowedStatuses,
                true
            )
        ) {

            $where[] =
                'o.status = :status';

            $params[':status'] =
                $status;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    if ($search !== '') {

        $where[] = "
            (
                o.order_number LIKE :search
                OR o.customer_name LIKE :search
                OR o.customer_phone LIKE :search
            )
        ";

        $params[':search'] =
            '%' .
            $search .
            '%';

    }


    /*
    |--------------------------------------------------------------------------
    | Date From
    |--------------------------------------------------------------------------
    */

    if (
        $dateFrom !== '' &&
        preg_match(
            '/^\d{4}-\d{2}-\d{2}$/',
            $dateFrom
        )
    ) {

        $where[] =
            'DATE(o.created_at) >= :date_from';

        $params[':date_from'] =
            $dateFrom;

    }


    /*
    |--------------------------------------------------------------------------
    | Date To
    |--------------------------------------------------------------------------
    */

    if (
        $dateTo !== '' &&
        preg_match(
            '/^\d{4}-\d{2}-\d{2}$/',
            $dateTo
        )
    ) {

        $where[] =
            'DATE(o.created_at) <= :date_to';

        $params[':date_to'] =
            $dateTo;

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
    | Count Orders
    |--------------------------------------------------------------------------
    */

    $countSql = "

        SELECT COUNT(*)

        FROM orders o

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
    | Orders
    |--------------------------------------------------------------------------
    */

    $sql = "

        SELECT

            o.id,

            o.order_number,

            o.customer_name,

            o.customer_phone,

            o.customer_address,

            o.customer_notes,

            o.subtotal,

            o.shipping,

            o.discount,

            o.total,

            o.status,

            o.created_at,

            o.updated_at

        FROM orders o

        {$whereSql}

        ORDER BY
            o.id DESC

        LIMIT :limit

        OFFSET :offset

    ";


    $stmt =
        $db->prepare(
            $sql
        );


    /*
    |--------------------------------------------------------------------------
    | Bind Filters
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
                            $order['customer_phone'],

                        'address' =>
                            $order['customer_address'],

                        'notes' =>
                            $order['customer_notes']

                    ],

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
                        $order['total'],

                    'status' =>
                        $order['status'],

                    'created_at' =>
                        $order['created_at'],

                    'updated_at' =>
                        $order['updated_at']

                ];

            },
            $orders
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

            'orders' =>
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

        'تم تحميل الطلبات بنجاح.'
    );


} catch (Throwable $e) {

    error_log(
        'Orders List API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تحميل الطلبات.',
        500
    );

}
