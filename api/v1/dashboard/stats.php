<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Dashboard Statistics API
|--------------------------------------------------------------------------
| File:
| api/v1/dashboard/stats.php
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
| Database
|--------------------------------------------------------------------------
*/

try {

    $db = getDatabaseConnection();


    /*
    |--------------------------------------------------------------------------
    | Products Count
    |--------------------------------------------------------------------------
    */

    $productsStmt = $db->query(
        "
        SELECT COUNT(*)
        FROM products
        "
    );

    $products =
        (int)
        $productsStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Active Products
    |--------------------------------------------------------------------------
    */

    $activeProductsStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM products

        WHERE status = 'active'
        "
    );

    $activeProducts =
        (int)
        $activeProductsStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Categories Count
    |--------------------------------------------------------------------------
    */

    $categoriesStmt = $db->query(
        "
        SELECT COUNT(*)
        FROM categories
        "
    );

    $categories =
        (int)
        $categoriesStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Active Categories
    |--------------------------------------------------------------------------
    */

    $activeCategoriesStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM categories

        WHERE status = 'active'
        "
    );

    $activeCategories =
        (int)
        $activeCategoriesStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Orders Count
    |--------------------------------------------------------------------------
    */

    $ordersStmt = $db->query(
        "
        SELECT COUNT(*)
        FROM orders
        "
    );

    $orders =
        (int)
        $ordersStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Pending Orders
    |--------------------------------------------------------------------------
    */

    $pendingStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM orders

        WHERE status = 'pending'
        "
    );

    $pendingOrders =
        (int)
        $pendingStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Processing Orders
    |--------------------------------------------------------------------------
    */

    $processingStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM orders

        WHERE status IN
        (
            'confirmed',
            'preparing',
            'out_for_delivery'
        )
        "
    );

    $processingOrders =
        (int)
        $processingStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Delivered Orders
    |--------------------------------------------------------------------------
    */

    $deliveredStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM orders

        WHERE status = 'delivered'
        "
    );

    $deliveredOrders =
        (int)
        $deliveredStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Cancelled Orders
    |--------------------------------------------------------------------------
    */

    $cancelledStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM orders

        WHERE status = 'cancelled'
        "
    );

    $cancelledOrders =
        (int)
        $cancelledStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Total Sales
    |--------------------------------------------------------------------------
    */

    $salesStmt = $db->query(
        "
        SELECT

            COALESCE(
                SUM(total),
                0
            )

        FROM orders

        WHERE status = 'delivered'
        "
    );

    $totalSales =
        (float)
        $salesStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Today's Sales
    |--------------------------------------------------------------------------
    */

    $todaySalesStmt = $db->query(
        "
        SELECT

            COALESCE(
                SUM(total),
                0
            )

        FROM orders

        WHERE status = 'delivered'

        AND DATE(created_at) =
            CURRENT_DATE
        "
    );

    $todaySales =
        (float)
        $todaySalesStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Today's Orders
    |--------------------------------------------------------------------------
    */

    $todayOrdersStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM orders

        WHERE DATE(created_at) =
            CURRENT_DATE
        "
    );

    $todayOrders =
        (int)
        $todayOrdersStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    | يتم احتساب العملاء من أرقام الهاتف
    |--------------------------------------------------------------------------
    */

    $customersStmt = $db->query(
        "
        SELECT COUNT(DISTINCT customer_phone)

        FROM orders

        WHERE customer_phone IS NOT NULL

        AND customer_phone != ''
        "
    );

    $customers =
        (int)
        $customersStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Low Stock
    |--------------------------------------------------------------------------
    */

    $lowStockStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM products

        WHERE stock <= 5

        AND status = 'active'
        "
    );

    $lowStockProducts =
        (int)
        $lowStockStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Out Of Stock
    |--------------------------------------------------------------------------
    */

    $outOfStockStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM products

        WHERE stock <= 0

        AND status = 'active'
        "
    );

    $outOfStockProducts =
        (int)
        $outOfStockStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [

            'overview' => [

                'products' =>
                    $products,

                'active_products' =>
                    $activeProducts,

                'categories' =>
                    $categories,

                'active_categories' =>
                    $activeCategories,

                'orders' =>
                    $orders,

                'customers' =>
                    $customers

            ],


            'orders' => [

                'pending' =>
                    $pendingOrders,

                'processing' =>
                    $processingOrders,

                'delivered' =>
                    $deliveredOrders,

                'cancelled' =>
                    $cancelledOrders,

                'today' =>
                    $todayOrders

            ],


            'sales' => [

                'total' =>
                    $totalSales,

                'today' =>
                    $todaySales

            ],


            'inventory' => [

                'low_stock' =>
                    $lowStockProducts,

                'out_of_stock' =>
                    $outOfStockProducts

            ]

        ],

        'تم تحميل إحصائيات لوحة التحكم بنجاح.'
    );


} catch (Throwable $e) {

    error_log(
        'Dashboard Stats API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تحميل إحصائيات لوحة التحكم.',
        500
    );

}        "
        SELECT COUNT(*)
        FROM categories
        "
    );

    $categories =
        (int)
        $categoriesStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Active Categories
    |--------------------------------------------------------------------------
    */

    $activeCategoriesStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM categories

        WHERE status = 'active'
        "
    );

    $activeCategories =
        (int)
        $activeCategoriesStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Orders Count
    |--------------------------------------------------------------------------
    */

    $ordersStmt = $db->query(
        "
        SELECT COUNT(*)
        FROM orders
        "
    );

    $orders =
        (int)
        $ordersStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Pending Orders
    |--------------------------------------------------------------------------
    */

    $pendingStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM orders

        WHERE status = 'pending'
        "
    );

    $pendingOrders =
        (int)
        $pendingStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Processing Orders
    |--------------------------------------------------------------------------
    */

    $processingStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM orders

        WHERE status IN
        (
            'confirmed',
            'preparing',
            'out_for_delivery'
        )
        "
    );

    $processingOrders =
        (int)
        $processingStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Delivered Orders
    |--------------------------------------------------------------------------
    */

    $deliveredStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM orders

        WHERE status = 'delivered'
        "
    );

    $deliveredOrders =
        (int)
        $deliveredStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Cancelled Orders
    |--------------------------------------------------------------------------
    */

    $cancelledStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM orders

        WHERE status = 'cancelled'
        "
    );

    $cancelledOrders =
        (int)
        $cancelledStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Total Sales
    |--------------------------------------------------------------------------
    */

    $salesStmt = $db->query(
        "
        SELECT

            COALESCE(
                SUM(total),
                0
            )

        FROM orders

        WHERE status = 'delivered'
        "
    );

    $totalSales =
        (float)
        $salesStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Today's Sales
    |--------------------------------------------------------------------------
    */

    $todaySalesStmt = $db->query(
        "
        SELECT

            COALESCE(
                SUM(total),
                0
            )

        FROM orders

        WHERE status = 'delivered'

        AND DATE(created_at) =
            CURRENT_DATE
        "
    );

    $todaySales =
        (float)
        $todaySalesStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Today's Orders
    |--------------------------------------------------------------------------
    */

    $todayOrdersStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM orders

        WHERE DATE(created_at) =
            CURRENT_DATE
        "
    );

    $todayOrders =
        (int)
        $todayOrdersStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    | يتم احتساب العملاء من أرقام الهاتف
    |--------------------------------------------------------------------------
    */

    $customersStmt = $db->query(
        "
        SELECT COUNT(DISTINCT customer_phone)

        FROM orders

        WHERE customer_phone IS NOT NULL

        AND customer_phone != ''
        "
    );

    $customers =
        (int)
        $customersStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Low Stock
    |--------------------------------------------------------------------------
    */

    $lowStockStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM products

        WHERE stock <= 5

        AND status = 'active'
        "
    );

    $lowStockProducts =
        (int)
        $lowStockStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Out Of Stock
    |--------------------------------------------------------------------------
    */

    $outOfStockStmt = $db->query(
        "
        SELECT COUNT(*)

        FROM products

        WHERE stock <= 0

        AND status = 'active'
        "
    );

    $outOfStockProducts =
        (int)
        $outOfStockStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [

            'overview' => [

                'products' =>
                    $products,

                'active_products' =>
                    $activeProducts,

                'categories' =>
                    $categories,

                'active_categories' =>
                    $activeCategories,

                'orders' =>
                    $orders,

                'customers' =>
                    $customers

            ],


            'orders' => [

                'pending' =>
                    $pendingOrders,

                'processing' =>
                    $processingOrders,

                'delivered' =>
                    $deliveredOrders,

                'cancelled' =>
                    $cancelledOrders,

                'today' =>
                    $todayOrders

            ],


            'sales' => [

                'total' =>
                    $totalSales,

                'today' =>
                    $todaySales

            ],


            'inventory' => [

                'low_stock' =>
                    $lowStockProducts,

                'out_of_stock' =>
                    $outOfStockProducts

            ]

        ],

        'تم تحميل إحصائيات لوحة التحكم بنجاح.'
    );


} catch (Throwable $e) {

    error_log(
        'Dashboard Stats API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تحميل إحصائيات لوحة التحكم.',
        500
    );

}            slug,
            status

        FROM categories

        WHERE id = :id

        LIMIT 1

        FOR UPDATE
        "
    );


    $categoryStmt->execute([
        ':id' => $id
    ]);


    $category = $categoryStmt->fetch();


    /*
    |--------------------------------------------------------------------------
    | Not Found
    |--------------------------------------------------------------------------
    */

    if (!$category) {

        $db->rollBack();

        errorResponse(
            'القسم غير موجود.',
            404
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Check Products
    |--------------------------------------------------------------------------
    */

    $productsStmt = $db->prepare(
        "
        SELECT COUNT(*)

        FROM products

        WHERE category_id = :category_id
        "
    );


    $productsStmt->execute([
        ':category_id' => $id
    ]);


    $productsCount =
        (int)
        $productsStmt->fetchColumn();


    /*
    |--------------------------------------------------------------------------
    | Prevent Delete If Products Exist
    |--------------------------------------------------------------------------
    */

    if ($productsCount > 0) {

        $db->rollBack();

        errorResponse(
            'لا يمكن حذف القسم لأنه يحتوي على ' .
            $productsCount .
            ' منتج. انقل المنتجات إلى قسم آخر أولًا.',
            409
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Delete Category
    |--------------------------------------------------------------------------
    */

    $deleteStmt = $db->prepare(
        "
        DELETE FROM categories

        WHERE id = :id
        "
    );


    $deleteStmt->execute([
        ':id' => $id
    ]);


    /*
    |--------------------------------------------------------------------------
    | Verify Delete
    |--------------------------------------------------------------------------
    */

    if (
        $deleteStmt->rowCount() === 0
    ) {

        throw new RuntimeException(
            'تعذر حذف القسم.'
        );

    }


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

            'deleted' =>
                true,

            'category' => [

                'id' =>
                    (int)
                    $category['id'],

                'name' =>
                    $category['name'],

                'slug' =>
                    $category['slug']

            ]

        ],

        'تم حذف القسم بنجاح.'
    );


} catch (PDOException $e) {

    if (
        isset($db) &&
        $db->inTransaction()
    ) {

        $db->rollBack();

    }


    error_log(
        'Delete Category PDO Error: ' .
        $e->getMessage()
    );


    if (
        $e->getCode() === '23000'
    ) {

        errorResponse(
            'لا يمكن حذف القسم لأنه مرتبط ببيانات أخرى.',
            409
        );

    }


    errorResponse(
        'حدث خطأ أثناء حذف القسم.',
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
        'Delete Category Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء حذف القسم.',
        500
    );

}
