<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Admin Dashboard
|--------------------------------------------------------------------------
| File:
| admin/index.php
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/auth.php';


/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

requireAdminLogin();


/*
|--------------------------------------------------------------------------
| Page Data
|--------------------------------------------------------------------------
*/

$pageTitle =
    'لوحة التحكم | مول البركة';


$adminName =
    $_SESSION['admin_name']
    ?? 'المدير';


/*
|--------------------------------------------------------------------------
| CSRF Token
|--------------------------------------------------------------------------
*/

$csrfToken =
    $_SESSION['csrf_token']
    ?? '';

?>
<!DOCTYPE html>

<html
    lang="ar"
    dir="rtl"
>

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="robots"
        content="noindex,nofollow"
    >

    <meta
        name="csrf-token"
        content="<?= htmlspecialchars(
            $csrfToken,
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
    >

    <title>
        <?= htmlspecialchars(
            $pageTitle,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </title>


    <!-- Dashboard CSS -->

    <link
        rel="stylesheet"
        href="/admin/assets/css/dashboard.css"
    >

</head>


<body>


<!--
|--------------------------------------------------------------------------
| Dashboard Layout
|--------------------------------------------------------------------------
-->

<div
    class="admin-layout"
    id="adminLayout"
>


    <!--
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    -->

    <aside
        class="admin-sidebar"
        id="adminSidebar"
    >

        <div
            class="sidebar-brand"
        >

            <div
                class="brand-logo"
            >
                البركة
            </div>

            <div
                class="brand-text"
            >

                <strong>
                    مول البركة
                </strong>

                <span>
                    لوحة الإدارة
                </span>

            </div>

        </div>


        <nav
            class="sidebar-nav"
        >

            <a
                href="/admin/"
                class="nav-item active"
            >
                <span>
                    الرئيسية
                </span>
            </a>


            <a
                href="/admin/orders.php"
                class="nav-item"
            >
                <span>
                    الطلبات
                </span>
            </a>


            <a
                href="/admin/products.php"
                class="nav-item"
            >
                <span>
                    المنتجات
                </span>
            </a>


            <a
                href="/admin/categories.php"
                class="nav-item"
            >
                <span>
                    الأقسام
                </span>
            </a>


            <a
                href="/admin/customers.php"
                class="nav-item"
            >
                <span>
                    العملاء
                </span>
            </a>


            <a
                href="/admin/settings.php"
                class="nav-item"
            >
                <span>
                    الإعدادات
                </span>
            </a>


            <div
                class="nav-divider"
            ></div>


            <a
                href="/"
                class="nav-item"
                target="_blank"
                rel="noopener"
            >
                <span>
                    زيارة الموقع
                </span>
            </a>


            <a
                href="/admin/logout.php"
                class="nav-item nav-danger"
            >
                <span>
                    تسجيل الخروج
                </span>
            </a>

        </nav>

    </aside>


    <!--
    |--------------------------------------------------------------------------
    | Main
    |--------------------------------------------------------------------------
    -->

    <main
        class="admin-main"
    >


        <!-- Header -->

        <header
            class="admin-header"
        >

            <button
                type="button"
                class="menu-button"
                id="menuButton"
                aria-label="فتح القائمة"
            >
                ☰
            </button>


            <div
                class="header-title"
            >

                <h1>
                    لوحة التحكم
                </h1>

                <p>
                    مرحبًا <?= htmlspecialchars(
                        $adminName,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </p>

            </div>


            <div
                class="header-actions"
            >

                <span
                    class="admin-badge"
                >
                    مدير
                </span>

            </div>

        </header>


        <!-- Content -->

        <section
            class="dashboard-content"
        >


            <!-- Loading -->

            <div
                id="dashboardLoading"
                class="dashboard-loading"
            >
                جاري تحميل البيانات...
            </div>


            <!-- Error -->

            <div
                id="dashboardError"
                class="dashboard-error"
                hidden
            ></div>


            <!-- Statistics -->

            <div
                class="stats-grid"
                id="statsGrid"
            >

                <article
                    class="stat-card"
                >

                    <span>
                        المبيعات
                    </span>

                    <strong
                        id="totalSales"
                    >
                        0
                    </strong>

                    <small>
                        جنيه
                    </small>

                </article>


                <article
                    class="stat-card"
                >

                    <span>
                        الطلبات
                    </span>

                    <strong
                        id="totalOrders"
                    >
                        0
                    </strong>

                    <small>
                        إجمالي الطلبات
                    </small>

                </article>


                <article
                    class="stat-card"
                >

                    <span>
                        المنتجات
                    </span>

                    <strong
                        id="totalProducts"
                    >
                        0
                    </strong>

                    <small>
                        المنتجات النشطة
                    </small>

                </article>


                <article
                    class="stat-card"
                >

                    <span>
                        المخزون المنخفض
                    </span>

                    <strong
                        id="lowStock"
                    >
                        0
                    </strong>

                    <small>
                        يحتاج مراجعة
                    </small>

                </article>

            </div>


            <!--
            |--------------------------------------------------------------------------
            | Quick Actions
            |--------------------------------------------------------------------------
            -->

            <div
                class="section-card"
            >

                <div
                    class="section-header"
                >

                    <div>

                        <h2>
                            إجراءات سريعة
                        </h2>

                        <p>
                            إدارة المتجر بسرعة
                        </p>

                    </div>

                </div>


                <div
                    class="quick-actions"
                >

                    <a
                        href="/admin/orders.php"
                        class="quick-action"
                    >
                        إدارة الطلبات
                    </a>


                    <a
                        href="/admin/products.php?action=create"
                        class="quick-action"
                    >
                        إضافة منتج
                    </a>


                    <a
                        href="/admin/categories.php"
                        class="quick-action"
                    >
                        إدارة الأقسام
                    </a>

                </div>

            </div>


            <!--
            |--------------------------------------------------------------------------
            | Recent Orders
            |--------------------------------------------------------------------------
            -->

            <div
                class="section-card"
            >

                <div
                    class="section-header"
                >

                    <div>

                        <h2>
                            أحدث الطلبات
                        </h2>

                        <p>
                            آخر الطلبات الواردة
                        </p>

                    </div>


                    <a
                        href="/admin/orders.php"
                        class="section-link"
                    >
                        عرض الكل
                    </a>

                </div>


                <div
                    class="table-wrapper"
                >

                    <table
                        class="admin-table"
                    >

                        <thead>

                            <tr>

                                <th>
                                    الطلب
                                </th>

                                <th>
                                    العميل
                                </th>

                                <th>
                                    الإجمالي
                                </th>

                                <th>
                                    الحالة
                                </th>

                                <th>
                                    التاريخ
                                </th>

                            </tr>

                        </thead>


                        <tbody
                            id="recentOrders"
                        >

                            <tr>

                                <td
                                    colspan="5"
                                >
                                    جاري التحميل...
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>


            <!--
            |--------------------------------------------------------------------------
            | Low Stock
            |--------------------------------------------------------------------------
            -->

            <div
                class="section-card"
            >

                <div
                    class="section-header"
                >

                    <div>

                        <h2>
                            المخزون المنخفض
                        </h2>

                        <p>
                            منتجات تحتاج إلى إعادة تخزين
                        </p>

                    </div>


                    <a
                        href="/admin/products.php?filter=low-stock"
                        class="section-link"
                    >
                        عرض المنتجات
                    </a>

                </div>


                <div
                    class="table-wrapper"
                >

                    <table
                        class="admin-table"
                    >

                        <thead>

                            <tr>

                                <th>
                                    المنتج
                                </th>

                                <th>
                                    SKU
                                </th>

                                <th>
                                    المخزون
                                </th>

                                <th>
                                    الحالة
                                </th>

                            </tr>

                        </thead>


                        <tbody
                            id="lowStockProducts"
                        >

                            <tr>

                                <td
                                    colspan="4"
                                >
                                    جاري التحميل...
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>


        </section>

    </main>

</div>


<!--
|--------------------------------------------------------------------------
| Dashboard JavaScript
|--------------------------------------------------------------------------
-->

<script>

'use strict';


const csrfToken =
    document
        .querySelector(
            'meta[name="csrf-token"]'
        )
        ?.getAttribute(
            'content'
        )
        || '';


const loading =
    document.getElementById(
        'dashboardLoading'
    );


const errorBox =
    document.getElementById(
        'dashboardError'
    );


/*
|--------------------------------------------------------------------------
| API Request
|--------------------------------------------------------------------------
*/

async function apiRequest(
    url,
    options = {}
) {

    const response =
        await fetch(
            url,
            {

                credentials:
                    'same-origin',

                ...options,

                headers: {

                    'Accept':
                        'application/json',

                    ...(options.headers || {})

                }

            }
        );


    const data =
        await response.json()
            .catch(
                () => null
            );


    if (
        !response.ok ||
        !data ||
        data.success !== true
    ) {

        throw new Error(
            data?.message ||
            'حدث خطأ أثناء الاتصال بالخادم.'
        );

    }


    return data;

}


/*
|--------------------------------------------------------------------------
| Format Currency
|--------------------------------------------------------------------------
*/

function formatCurrency(
    value
) {

    return new Intl.NumberFormat(
        'ar-EG',
        {

            minimumFractionDigits:
                2,

            maximumFractionDigits:
                2

        }
    ).format(
        Number(value || 0)
    );

}


/*
|--------------------------------------------------------------------------
| Order Status
|--------------------------------------------------------------------------
*/

function orderStatusLabel(
    status
) {

    const labels = {

        pending:
            'قيد الانتظار',

        confirmed:
            'مؤكد',

        preparing:
            'جاري التجهيز',

        out_for_delivery:
            'خرج للتوصيل',

        delivered:
            'تم التسليم',

        cancelled:
            'ملغي'

    };


    return (
        labels[status]
        || status
        || '-'
    );

}


/*
|--------------------------------------------------------------------------
| Load Statistics
|--------------------------------------------------------------------------
*/

async function loadStats() {

    const data =
        await apiRequest(
            '/api/v1/dashboard/stats.php'
        );


    const stats =
        data.data
        || data.result
        || {};


    document.getElementById(
        'totalSales'
    ).textContent =
        formatCurrency(
            stats.sales
            ?? stats.total_sales
            ?? 0
        );


    document.getElementById(
        'totalOrders'
    ).textContent =
        Number(
            stats.orders
            ?? stats.total_orders
            ?? 0
        );


    document.getElementById(
        'totalProducts'
    ).textContent =
        Number(
            stats.products
            ?? stats.total_products
            ?? 0
        );


    document.getElementById(
        'lowStock'
    ).textContent =
        Number(
            stats.low_stock
            ?? 0
        );

}


/*
|--------------------------------------------------------------------------
| Load Recent Orders
|--------------------------------------------------------------------------
*/

async function loadRecentOrders() {

    const data =
        await apiRequest(
            '/api/v1/orders/list.php?per_page=5'
        );


    const orders =
        data.data?.orders
        || [];


    const tbody =
        document.getElementById(
            'recentOrders'
        );


    if (
        orders.length === 0
    ) {

        tbody.innerHTML =
            `
            <tr>
                <td colspan="5">
                    لا توجد طلبات حتى الآن.
                </td>
            </tr>
            `;

        return;

    }


    tbody.innerHTML =
        orders
            .map(
                order => `

                    <tr>

                        <td>
                            #${escapeHtml(
                                order.order_number
                            )}
                        </td>

                        <td>
                            ${escapeHtml(
                                order.customer?.name
                                || '-'
                            )}
                        </td>

                        <td>
                            ${formatCurrency(
                                order.financial?.total
                                || 0
                            )}
                            جنيه
                        </td>

                        <td>

                            <span
                                class="status-badge status-${escapeHtml(
                                    order.status
                                )}"
                            >
                                ${escapeHtml(
                                    orderStatusLabel(
                                        order.status
                                    )
                                )}
                            </span>

                        </td>

                        <td>
                            ${escapeHtml(
                                order.created_at
                                || '-'
                            )}
                        </td>

                    </tr>

                `
            )
            .join('');

}


/*
|--------------------------------------------------------------------------
| Load Low Stock
|--------------------------------------------------------------------------
*/

async function loadLowStock() {

    const data =
        await apiRequest(
            '/api/v1/dashboard/low-stock.php?limit=5'
        );


    const products =
        data.data?.products
        || [];


    const tbody =
        document.getElementById(
            'lowStockProducts'
        );


    if (
        products.length === 0
    ) {

        tbody.innerHTML =
            `
            <tr>
                <td colspan="4">
                    لا توجد منتجات منخفضة المخزون.
                </td>
            </tr>
            `;

        return;

    }


    tbody.innerHTML =
        products
            .map(
                product => `

                    <tr>

                        <td>
                            ${escapeHtml(
                                product.name
                                || '-'
                            )}
                        </td>

                        <td>
                            ${escapeHtml(
                                product.sku
                                || '-'
                            )}
                        </td>

                        <td>
                            ${Number(
                                product.stock
                                || 0
                            )}
                        </td>

                        <td>

                            <span
                                class="status-badge status-low"
                            >
                                ${
                                    Number(
                                        product.stock
                                        || 0
                                    ) <= 0
                                        ? 'نفد المخزون'
                                        : 'مخزون منخفض'
                                }
                            </span>

                        </td>

                    </tr>

                `
            )
            .join('');

}


/*
|--------------------------------------------------------------------------
| HTML Escape
|--------------------------------------------------------------------------
*/

function escapeHtml(
    value
) {

    return String(
        value ?? ''
    )
        .replace(
            /&/g,
            '&amp;'
        )
        .replace(
            /</g,
            '&lt;'
        )
        .replace(
            />/g,
            '&gt;'
        )
        .replace(
            /"/g,
            '&quot;'
        )
        .replace(
            /'/g,
            '&#039;'
        );

}


/*
|--------------------------------------------------------------------------
| Mobile Menu
|--------------------------------------------------------------------------
*/

document
    .getElementById(
        'menuButton'
    )
    ?.addEventListener(
        'click',
        function () {

            document
                .getElementById(
                    'adminLayout'
                )
                ?.classList.toggle(
                    'sidebar-open'
                );

        }
    );


/*
|--------------------------------------------------------------------------
| Load Dashboard
|--------------------------------------------------------------------------
*/

async function loadDashboard() {

    try {

        loading.hidden =
            false;

        errorBox.hidden =
            true;


        await Promise.all([

            loadStats(),

            loadRecentOrders(),

            loadLowStock()

        ]);


        loading.hidden =
            true;


    } catch (error) {

        loading.hidden =
            true;

        errorBox.textContent =
            error.message;

        errorBox.hidden =
            false;

    }

}


loadDashboard();

</script>


</body>

</html>
