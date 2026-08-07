<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Update Order Status API
|--------------------------------------------------------------------------
| File:
| api/v1/orders/update-status.php
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
| PUT / PATCH Only
|--------------------------------------------------------------------------
*/

if (
    requestMethod() !== 'PUT' &&
    requestMethod() !== 'PATCH'
) {

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

requireCsrfToken();


/*
|--------------------------------------------------------------------------
| Request
|--------------------------------------------------------------------------
*/

$data = getJsonInput();

if (empty($data)) {

    $data = $_POST;

}


/*
|--------------------------------------------------------------------------
| Input
|--------------------------------------------------------------------------
*/

$orderId = cleanInt(
    $data['id']
    ?? $data['order_id']
    ?? $_GET['id']
    ?? $_GET['order_id']
    ?? 0
);

$newStatus = cleanString(
    $data['status'] ?? ''
);


/*
|--------------------------------------------------------------------------
| Validate ID
|--------------------------------------------------------------------------
*/

if ($orderId <= 0) {

    errorResponse(
        'رقم الطلب غير صحيح.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Allowed Statuses
|--------------------------------------------------------------------------
*/

$allowedStatuses = [

    'pending',
    'confirmed',
    'preparing',
    'out_for_delivery',
    'delivered',
    'cancelled'

];


if (
    !in_array(
        $newStatus,
        $allowedStatuses,
        true
    )
) {

    errorResponse(
        'حالة الطلب غير صحيحة.',
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
    | Start Transaction
    |--------------------------------------------------------------------------
    */

    $db->beginTransaction();


    /*
    |--------------------------------------------------------------------------
    | Lock Order
    |--------------------------------------------------------------------------
    */

    $orderStmt = $db->prepare(
        "
        SELECT

            id,
            order_number,
            status,
            total

        FROM orders

        WHERE id = :id

        LIMIT 1

        FOR UPDATE
        "
    );


    $orderStmt->execute([
        ':id' => $orderId
    ]);


    $order = $orderStmt->fetch();


    /*
    |--------------------------------------------------------------------------
    | Order Not Found
    |--------------------------------------------------------------------------
    */

    if (!$order) {

        $db->rollBack();

        errorResponse(
            'الطلب غير موجود.',
            404
        );

    }


    $currentStatus =
        $order['status'];


    /*
    |--------------------------------------------------------------------------
    | No Change
    |--------------------------------------------------------------------------
    */

    if (
        $currentStatus === $newStatus
    ) {

        $db->rollBack();

        successResponse(
            [

                'order' => [

                    'id' =>
                        (int)
                        $order['id'],

                    'order_number' =>
                        $order['order_number'],

                    'status' =>
                        $currentStatus

                ]

            ],

            'حالة الطلب لم تتغير.'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Transition Rules
    |--------------------------------------------------------------------------
    */

    $transitions = [

        'pending' => [

            'confirmed',
            'cancelled'

        ],

        'confirmed' => [

            'preparing',
            'cancelled'

        ],

        'preparing' => [

            'out_for_delivery',
            'cancelled'

        ],

        'out_for_delivery' => [

            'delivered'

        ],

        'delivered' => [],

        'cancelled' => []

    ];


    /*
    |--------------------------------------------------------------------------
    | Validate Transition
    |--------------------------------------------------------------------------
    */

    if (
        !in_array(
            $newStatus,
            $transitions[$currentStatus]
                ?? [],
            true
        )
    ) {

        $db->rollBack();

        errorResponse(
            'لا يمكن تغيير حالة الطلب من "' .
            $currentStatus .
            '" إلى "' .
            $newStatus .
            '".',
            409
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Update Status
    |--------------------------------------------------------------------------
    */

    $updateStmt = $db->prepare(
        "
        UPDATE orders

        SET

            status = :status,

            updated_at = CURRENT_TIMESTAMP

        WHERE id = :id
        "
    );


    $updateStmt->execute([

        ':status' =>
            $newStatus,

        ':id' =>
            $orderId

    ]);


    /*
    |--------------------------------------------------------------------------
    | Commit
    |--------------------------------------------------------------------------
    */

    $db->commit();


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

                'old_status' =>
                    $currentStatus,

                'status' =>
                    $newStatus,

                'total' =>
                    (float)
                    $order['total']

            ]

        ],

        'تم تحديث حالة الطلب بنجاح.'
    );


} catch (PDOException $e) {

    if (
        isset($db) &&
        $db->inTransaction()
    ) {

        $db->rollBack();

    }


    error_log(
        'Update Order Status PDO Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تحديث حالة الطلب.',
        500
    );


} catch (Throwable $e) {

    if (
        isset($db) &&
        $db->inTransaction()
    ) {

        $db->rollBack();

    }


    error_log(
        'Update Order Status Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تحديث حالة الطلب.',
        500
    );

}
