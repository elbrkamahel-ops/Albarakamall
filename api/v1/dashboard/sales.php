<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Dashboard Sales API
|--------------------------------------------------------------------------
| File:
| api/v1/dashboard/sales.php
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
| Period
|--------------------------------------------------------------------------
*/

$period = cleanString(
    $_GET['period'] ?? '30'
);


$allowedPeriods = [

    '7',
    '30',
    '90'

];


if (
    !in_array(
        $period,
        $allowedPeriods,
        true
    )
) {

    $period = '30';

}


$days =
    (int)
    $period;


/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/

try {

    $db = getDatabaseConnection();


    /*
    |--------------------------------------------------------------------------
    | Daily Sales
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare(
        "
        SELECT

            DATE(created_at) AS sale_date,

            COUNT(*) AS orders_count,

            COALESCE(
                SUM(total),
                0
            ) AS sales

        FROM orders

        WHERE status = 'delivered'

        AND created_at >=
            DATE_SUB(
                CURRENT_DATE,
                INTERVAL :days DAY
            )

        GROUP BY
            DATE(created_at)

        ORDER BY
            sale_date ASC
        "
    );


    $stmt->bindValue(
        ':days',
        $days,
        PDO::PARAM_INT
    );


    $stmt->execute();


    $rows =
        $stmt->fetchAll();


    /*
    |--------------------------------------------------------------------------
    | Prepare Dates
    |--------------------------------------------------------------------------
    */

    $salesByDate = [];


    foreach (
        $rows as $row
    ) {

        $salesByDate[
            $row['sale_date']
        ] = [

            'date' =>
                $row['sale_date'],

            'sales' =>
                (float)
                $row['sales'],

            'orders' =>
                (int)
                $row['orders_count']

        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Fill Missing Dates
    |--------------------------------------------------------------------------
    */

    $result = [];


    $startDate =
        new DateTime(
            '-' .
            ($days - 1) .
            ' days'
        );


    $endDate =
        new DateTime();


    $currentDate =
        clone $startDate;


    while (
        $currentDate <= $endDate
    ) {

        $date =
            $currentDate->format(
                'Y-m-d'
            );


        if (
            isset(
                $salesByDate[$date]
            )
        ) {

            $result[] =
                $salesByDate[$date];

        } else {

            $result[] = [

                'date' =>
                    $date,

                'sales' =>
                    0,

                'orders' =>
                    0

            ];

        }


        $currentDate->modify(
            '+1 day'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Total Sales
    |--------------------------------------------------------------------------
    */

    $totalStmt = $db->prepare(
        "
        SELECT

            COALESCE(
                SUM(total),
                0
            )

        FROM orders

        WHERE status = 'delivered'

        AND created_at >=
            DATE_SUB(
                CURRENT_DATE,
                INTERVAL :days DAY
            )
        "
    );


    $totalStmt->bindValue(
        ':days',
        $days,
        PDO::PARAM_INT
    );


    $totalStmt->execute();


    $totalSales =
        (float)
        $totalStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Total Orders
    |--------------------------------------------------------------------------
    */

    $ordersStmt = $db->prepare(
        "
        SELECT COUNT(*)

        FROM orders

        WHERE status = 'delivered'

        AND created_at >=
            DATE_SUB(
                CURRENT_DATE,
                INTERVAL :days DAY
            )
        "
    );


    $ordersStmt->bindValue(
        ':days',
        $days,
        PDO::PARAM_INT
    );


    $ordersStmt->execute();


    $totalOrders =
        (int)
        $ordersStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Average Order
    |--------------------------------------------------------------------------
    */

    $averageOrder =
        $totalOrders > 0
            ? $totalSales /
                $totalOrders
            : 0;


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [

            'period' =>
                $days,

            'summary' => [

                'sales' =>
                    $totalSales,

                'orders' =>
                    $totalOrders,

                'average_order' =>
                    round(
                        $averageOrder,
                        2
                    )

            ],

            'data' =>
                $result

        ],

        'تم تحميل إحصائيات المبيعات بنجاح.'
    );


} catch (Throwable $e) {

    error_log(
        'Dashboard Sales API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تحميل إحصائيات المبيعات.',
        500
    );

}
