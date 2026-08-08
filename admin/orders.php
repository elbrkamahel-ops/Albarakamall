<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Admin Orders Page
|--------------------------------------------------------------------------
| File:
| admin/orders.php
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/auth.php';


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

requireAdminLogin();


/*
|--------------------------------------------------------------------------
| Page
|--------------------------------------------------------------------------
*/

$pageTitle = 'إدارة الطلبات | مول البركة';


$adminName =
    $_SESSION['admin_name']
    ?? 'المدير';


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

    <link
        rel="stylesheet"
        href="/admin/assets/css/dashboard.css"
    >

</head>


<body>


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
                class="nav-item"
            >
                الرئيسية
            </a>


            <a
                href="/admin/orders.php"
                class="nav-item active"
            >
                الطلبات
            </a>


            <a
                href="/admin/products.php"
                class="nav-item"
            >
                المنتجات
            </a>


            <a
                href="/admin/categories.php"
                class="nav-item"
            >
                الأقسام
            </a>


            <a
                href="/admin/customers.php"
                class="nav-item"
            >
                العملاء
            </a>


            <a
                href="/admin/settings.php"
                class="nav-item"
            >
                الإعدادات
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
                زيارة الموقع
            </a>


            <a
                href="/admin/logout.php"
                class="nav-item nav-danger"
            >
                تسجيل الخروج
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
                    إدارة الطلبات
                </h1>

                <p>
                    متابعة وإدارة جميع طلبات العملاء
                </p>

            </div>


            <div
                class="header-actions"
            >

                <span
                    class="admin-badge"
                >
                    <?= htmlspecialchars(
                        $adminName,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </span>

            </div>

        </header>


        <!-- Content -->

        <section
            class="dashboard-content"
        >


            <!-- Error -->

            <div
                id="ordersError"
                class="dashboard-error"
                hidden
            ></div>


            <!-- Filters -->

            <div
                class="section-card"
            >

                <div
                    class="section-header"
                >

                    <div>

                        <h2>
                            البحث والتصفية
                        </h2>

                        <p>
                            ابحث عن الطلبات وفلتر النتائج
                        </p>

                    </div>

                </div>


                <form
                    id="ordersFilterForm"
                    style="
                        padding:22px;
                    "
                >

                    <div
                        style="
                            display:grid;
                            grid-template-columns:
                                repeat(
                                    4,
                                    minmax(
                                        0,
                                        1fr
                                    )
                                );
                            gap:14px;
                        "
                    >


                        <!-- Search -->

                        <div
                            class="form-group"
                            style="
                                margin-bottom:0;
                            "
                        >

                            <label
                                class="form-label"
                                for="search"
                            >
                                بحث
                            </label>

                            <input
                                type="search"
                                id="search"
                                name="search"
                                class="form-control"
                                placeholder="رقم الطلب أو اسم العميل أو الهاتف"
                            >

                        </div>


                        <!-- Status -->

                        <div
                            class="form-group"
                            style="
                                margin-bottom:0;
                            "
                        >

                            <label
                                class="form-label"
                                for="status"
                            >
                                الحالة
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="form-control"
                            >

                                <option value="">
                                    كل الحالات
                                </option>

                                <option value="pending">
                                    قيد الانتظار
                                </option>

                                <option value="confirmed">
                                    مؤكد
                                </option>

                                <option value="preparing">
                                    جاري التجهيز
                                </option>

                                <option value="out_for_delivery">
                                    خرج للتوصيل
                                </option>

                                <option value="delivered">
                                    تم التسليم
                                </option>

                                <option value="cancelled">
                                    ملغي
                                </option>

                            </select>

                        </div>


                        <!-- Date From -->

                        <div
                            class="form-group"
                            style="
                                margin-bottom:0;
                            "
                        >

                            <label
                                class="form-label"
                                for="dateFrom"
                            >
                                من تاريخ
                            </label>

                            <input
                                type="date"
                                id="dateFrom"
                                name="date_from"
                                class="form-control"
                            >

                        </div>


                        <!-- Date To -->

                        <div
                            class="form-group"
                            style="
                                margin-bottom:0;
                            "
                        >

                            <label
                                class="form-label"
                                for="dateTo"
                            >
                                إلى تاريخ
                            </label>

                            <input
                                type="date"
                                id="dateTo"
                                name="date_to"
                                class="form-control"
                            >

                        </div>

                    </div>


                    <div
                        style="
                            display:flex;
                            gap:10px;
                            margin-top:18px;
                        "
                    >

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            بحث
                        </button>


                        <button
                            type="button"
                            class="btn btn-secondary"
                            id="resetFilters"
                        >
                            إعادة ضبط
                        </button>

                    </div>

                </form>

            </div>


            <!-- Orders -->

            <div
                class="section-card"
            >

                <div
                    class="section-header"
                >

                    <div>

                        <h2>
                            الطلبات
                        </h2>

                        <p id="ordersSummary">
                            جاري تحميل الطلبات...
                        </p>

                    </div>

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
                                    رقم الطلب
                                </th>

                                <th>
                                    العميل
                                </th>

                                <th>
                                    الهاتف
                                </th>

                                <th>
                                    الإجمالي
                                </th>

                                <th>
                                    الدفع
                                </th>

                                <th>
                                    الحالة
                                </th>

                                <th>
                                    التاريخ
                                </th>

                                <th>
                                    إجراء
                                </th>

                            </tr>

                        </thead>


                        <tbody
                            id="ordersTable"
                        >

                            <tr>

                                <td
                                    colspan="8"
                                >
                                    جاري تحميل الطلبات...
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                <!-- Pagination -->

                <div
                    id="pagination"
                    style="
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        gap:8px;
                        padding:20px;
                        flex-wrap:wrap;
                    "
                ></div>

            </div>

        </section>

    </main>

</div>


<!--
|--------------------------------------------------------------------------
| Order Details Modal
|--------------------------------------------------------------------------
-->

<div
    class="modal"
    id="orderModal"
    aria-hidden="true"
>

    <div
        class="modal-content"
    >

        <div
            class="modal-header"
        >

            <h2>
                تفاصيل الطلب
            </h2>

            <button
                type="button"
                class="btn btn-secondary"
                id="closeModal"
            >
                إغلاق
            </button>

        </div>


        <div
            class="modal-body"
            id="orderDetails"
        >

            جاري تحميل التفاصيل...

        </div>

    </div>

</div>


<script>

'use strict';


const ordersState = {

    page: 1,

    perPage: 20,

    search: '',

    status: '',

    dateFrom: '',

    dateTo: ''

};


const ordersTable =
    document.getElementById(
        'ordersTable'
    );


const ordersSummary =
    document.getElementById(
        'ordersSummary'
    );


const pagination =
    document.getElementById(
        'pagination'
    );


const ordersError =
    document.getElementById(
        'ordersError'
    );


const orderModal =
    document.getElementById(
        'orderModal'
    );


const orderDetails =
    document.getElementById(
        'orderDetails'
    );


/*
|--------------------------------------------------------------------------
| API
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
        await response
            .json()
            .catch(
                () => null
            );


    if (
        !response.ok ||
        !data ||
        data.success !== true
    ) {

        throw new Error(
            data?.message
            ||
            'حدث خطأ أثناء الاتصال بالخادم.'
        );

    }


    return data;

}


/*
|--------------------------------------------------------------------------
| Escape
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
| Currency
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
        Number(
            value || 0
        )
    );

}


/*
|--------------------------------------------------------------------------
| Status
|--------------------------------------------------------------------------
*/

function statusLabel(
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
        ||
        status
        ||
        '-'
    );

}


/*
|--------------------------------------------------------------------------
| Payment
|--------------------------------------------------------------------------
*/

function paymentLabel(
    method
) {

    const labels = {

        cash:
            'دفع عند الاستلام',

        card:
            'بطاقة',

        online:
            'دفع إلكتروني'

    };


    return (
        labels[method]
        ||
        method
        ||
        '-'
    );

}


/*
|--------------------------------------------------------------------------
| Load Orders
|--------------------------------------------------------------------------
*/

async function loadOrders() {

    try {

        ordersError.hidden =
            true;


        ordersTable.innerHTML = `

            <tr>

                <td colspan="8">

                    جاري تحميل الطلبات...

                </td>

            </tr>

        `;


        const params =
            new URLSearchParams({

                page:
                    ordersState.page,

                per_page:
                    ordersState.perPage,

                search:
                    ordersState.search,

                status:
                    ordersState.status,

                date_from:
                    ordersState.dateFrom,

                date_to:
                    ordersState.dateTo

            });


        const data =
            await apiRequest(
                '/api/v1/orders/list.php?'
                +
                params.toString()
            );


        const result =
            data.data
            ||
            {};


        const orders =
            result.orders
            ||
            [];


        const pageInfo =
            result.pagination
            ||
            {};


        renderOrders(
            orders
        );


        renderPagination(
            pageInfo
        );


        ordersSummary.textContent =
            `إجمالي النتائج: ${
                Number(
                    pageInfo.total
                    || 0
                )
            }`;


    } catch (
        error
    ) {

        ordersError.textContent =
            error.message;


        ordersError.hidden =
            false;


        ordersTable.innerHTML = `

            <tr>

                <td colspan="8">

                    تعذر تحميل الطلبات.

                </td>

            </tr>

        `;

    }

}


/*
|--------------------------------------------------------------------------
| Render Orders
|--------------------------------------------------------------------------
*/

function renderOrders(
    orders
) {

    if (
        orders.length === 0
    ) {

        ordersTable.innerHTML = `

            <tr>

                <td colspan="8">

                    لا توجد طلبات مطابقة للبحث.

                </td>

            </tr>

        `;

        return;

    }


    ordersTable.innerHTML =
        orders
            .map(
                order => `

                    <tr>

                        <td>

                            <strong>
                                #${escapeHtml(
                                    order.order_number
                                )}
                            </strong>

                        </td>


                        <td>
                            ${escapeHtml(
                                order.customer?.name
                                ||
                                '-'
                            )}
                        </td>


                        <td>
                            ${escapeHtml(
                                order.customer?.phone
                                ||
                                '-'
                            )}
                        </td>


                        <td>

                            ${formatCurrency(
                                order.financial?.total
                                ||
                                0
                            )}

                            جنيه

                        </td>


                        <td>
                            ${escapeHtml(
                                paymentLabel(
                                    order.payment?.method
                                )
                            )}
                        </td>


                        <td>

                            <span
                                class="
                                    status-badge
                                    status-${escapeHtml(
                                        order.status
                                    )}
                                "
                            >

                                ${escapeHtml(
                                    statusLabel(
                                        order.status
                                    )
                                )}

                            </span>

                        </td>


                        <td>
                            ${escapeHtml(
                                order.created_at
                                ||
                                '-'
                            )}
                        </td>


                        <td>

                            <button
                                type="button"
                                class="btn btn-secondary"
                                onclick="showOrder(
                                    ${Number(
                                        order.id
                                    )}
                                )"
                            >
                                التفاصيل
                            </button>

                        </td>

                    </tr>

                `
            )
            .join('');

}


/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

function renderPagination(
    info
) {

    pagination.innerHTML = '';


    const totalPages =
        Number(
            info.total_pages
            || 0
        );


    const currentPage =
        Number(
            info.page
            || 1
        );


    if (
        totalPages <= 1
    ) {

        return;

    }


    if (
        currentPage > 1
    ) {

        addPageButton(
            'السابق',
            currentPage - 1
        );

    }


    const start =
        Math.max(
            1,
            currentPage - 2
        );


    const end =
        Math.min(
            totalPages,
            currentPage + 2
        );


    for (
        let page = start;
        page <= end;
        page++
    ) {

        addPageButton(
            String(page),
            page,
            page === currentPage
        );

    }


    if (
        currentPage < totalPages
    ) {

        addPageButton(
            'التالي',
            currentPage + 1
        );

    }

}


/*
|--------------------------------------------------------------------------
| Page Button
|--------------------------------------------------------------------------
*/

function addPageButton(
    label,
    page,
    active = false
) {

    const button =
        document.createElement(
            'button'
        );


    button.type =
        'button';


    button.className =
        active
            ? 'btn btn-primary'
            : 'btn btn-secondary';


    button.textContent =
        label;


    button.addEventListener(
        'click',
        () => {

            ordersState.page =
                page;

            loadOrders();

        }
    );


    pagination.appendChild(
        button
    );

}


/*
|--------------------------------------------------------------------------
| Filters
|--------------------------------------------------------------------------
*/

document
    .getElementById(
        'ordersFilterForm'
    )
    .addEventListener(
        'submit',
        event => {

            event.preventDefault();


            ordersState.page =
                1;


            ordersState.search =
                document
                    .getElementById(
                        'search'
                    )
                    .value
                    .trim();


            ordersState.status =
                document
                    .getElementById(
                        'status'
                    )
                    .value;


            ordersState.dateFrom =
                document
                    .getElementById(
                        'dateFrom'
                    )
                    .value;


            ordersState.dateTo =
                document
                    .getElementById(
                        'dateTo'
                    )
                    .value;


            loadOrders();

        }
    );


/*
|--------------------------------------------------------------------------
| Reset
|--------------------------------------------------------------------------
*/

document
    .getElementById(
        'resetFilters'
    )
    .addEventListener(
        'click',
        () => {

            document
                .getElementById(
                    'ordersFilterForm'
                )
                .reset();


            ordersState.page =
                1;

            ordersState.search =
                '';

            ordersState.status =
                '';

            ordersState.dateFrom =
                '';

            ordersState.dateTo =
                '';


            loadOrders();

        }
    );


/*
|--------------------------------------------------------------------------
| Show Order
|--------------------------------------------------------------------------
*/

async function showOrder(
    orderId
) {

    orderModal.classList.add(
        'active'
    );


    orderModal.setAttribute(
        'aria-hidden',
        'false'
    );


    orderDetails.innerHTML = `
        <p>
            جاري تحميل تفاصيل الطلب...
        </p>
    `;


    try {

        const data =
            await apiRequest(
                '/api/v1/orders/show.php?id='
                +
                encodeURIComponent(
                    orderId
                )
            );


        const order =
            data.data?.order;


        if (!order) {

            throw new Error(
                'لم يتم العثور على بيانات الطلب.'
            );

        }


        renderOrderDetails(
            order
        );


    } catch (
        error
    ) {

        orderDetails.innerHTML = `

            <div class="dashboard-error">

                ${escapeHtml(
                    error.message
                )}

            </div>

        `;

    }

}


/*
|--------------------------------------------------------------------------
| Render Order Details
|--------------------------------------------------------------------------
*/

function renderOrderDetails(
    order
) {

    const items =
        order.items
        ||
        [];


    orderDetails.innerHTML = `

        <div
            style="
                display:grid;
                gap:16px;
            "
        >

            <div>

                <strong>
                    رقم الطلب:
                </strong>

                #${escapeHtml(
                    order.order_number
                )}

            </div>


            <div>

                <strong>
                    العميل:
                </strong>

                ${escapeHtml(
                    order.customer?.name
                    ||
                    '-'
                )}

            </div>


            <div>

                <strong>
                    الهاتف:
                </strong>

                ${escapeHtml(
                    order.customer?.phone
                    ||
                    '-'
                )}

            </div>


            <div>

                <strong>
                    العنوان:
                </strong>

                ${escapeHtml(
                    order.address?.address
                    ||
                    '-'
                )}

            </div>


            <div>

                <strong>
                    الحالة:
                </strong>

                <span
                    class="
                        status-badge
                        status-${escapeHtml(
                            order.status
                        )}
                    "
                >

                    ${escapeHtml(
                        statusLabel(
                            order.status
                        )
                    )}

                </span>

            </div>


            <hr>


            <div>

                <strong>
                    المنتجات
                </strong>

            </div>


            <div
                style="
                    display:grid;
                    gap:8px;
                "
            >

                ${
                    items.length
                        ? items
                            .map(
                                item => `

                                    <div
                                        style="
                                            display:flex;
                                            justify-content:space-between;
                                            gap:10px;
                                            padding:10px;
                                            background:#f9fafb;
                                            border-radius:8px;
                                        "
                                    >

                                        <span>

                                            ${escapeHtml(
                                                item.name
                                                ||
                                                '-'
                                            )}

                                            ×

                                            ${Number(
                                                item.quantity
                                                ||
                                                0
                                            )}

                                        </span>

                                        <strong>

                                            ${formatCurrency(
                                                item.total
                                                ||
                                                0
                                            )}

                                            جنيه

                                        </strong>

                                    </div>

                                `
                            )
                            .join('')
                        : '<p>لا توجد منتجات.</p>'
                }

            </div>


            <hr>


            <div>

                الإجمالي الفرعي:

                <strong>
                    ${formatCurrency(
                        order.financial?.subtotal
                        ||
                        0
                    )}
                    جنيه
                </strong>

            </div>


            <div>

                التوصيل:

                <strong>
                    ${formatCurrency(
                        order.financial?.delivery_fee
                        ||
                        0
                    )}
                    جنيه
                </strong>

            </div>


            <div>

                الخصم:

                <strong>
                    ${formatCurrency(
                        order.financial?.discount
                        ||
                        0
                    )}
                    جنيه
                </strong>

            </div>


            <div
                style="
                    font-size:18px;
                    color:#166534;
                "
            >

                الإجمالي:

                <strong>
                    ${formatCurrency(
                        order.financial?.total
                        ||
                        0
                    )}
                    جنيه
                </strong>

            </div>


            <div
                style="
                    margin-top:8px;
                    display:flex;
                    gap:10px;
                    flex-wrap:wrap;
                "
            >

                <button
                    type="button"
                    class="btn btn-primary"
                    onclick="openStatusEditor(
                        ${Number(
                            order.id
                        )},
                        '${escapeHtml(
                            order.status
                        )}'
                    )"
                >
                    تغيير الحالة
                </button>


                ${
                    order.status === 'pending'
                        ? `
                            <button
                                type="button"
                                class="btn btn-danger"
                                onclick="cancelOrder(
                                    ${Number(
                                        order.id
                                    )}
                                )"
                            >
                                إلغاء الطلب
                            </button>
                        `
                        : ''
                }

            </div>

        </div>

    `;

}


/*
|--------------------------------------------------------------------------
| Status Editor
|--------------------------------------------------------------------------
*/

function openStatusEditor(
    orderId,
    currentStatus
) {

    const statuses = [

        ['confirmed', 'مؤكد'],

        ['preparing', 'جاري التجهيز'],

        ['out_for_delivery', 'خرج للتوصيل'],

        ['delivered', 'تم التسليم'],

        ['cancelled', 'ملغي']

    ];


    const options =
        statuses
            .map(
                item => `

                    <option
                        value="${item[0]}"
                        ${
                            currentStatus === item[0]
                                ? 'selected'
                                : ''
                        }
                    >
                        ${item[1]}
                    </option>

                `
            )
            .join('');


    orderDetails.insertAdjacentHTML(
        'beforeend',
        `

            <div
                style="
                    margin-top:18px;
                    padding:15px;
                    background:#f9fafb;
                    border-radius:10px;
                "
            >

                <label
                    class="form-label"
                    for="newOrderStatus"
                >
                    الحالة الجديدة
                </label>

                <select
                    id="newOrderStatus"
                    class="form-control"
                >

                    ${options}

                </select>


                <button
                    type="button"
                    class="btn btn-primary"
                    style="margin-top:10px;"
                    onclick="updateOrderStatus(
                        ${Number(
                            orderId
                        )}
                    )"
                >
                    حفظ الحالة
                </button>

            </div>

        `
    );

}


/*
|--------------------------------------------------------------------------
| Update Status
|--------------------------------------------------------------------------
*/

async function updateOrderStatus(
    orderId
) {

    const select =
        document.getElementById(
            'newOrderStatus'
        );


    if (!select) {

        return;

    }


    const status =
        select.value;


    const csrf =
        document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            ?.getAttribute(
                'content'
            )
            || '';


    try {

        await apiRequest(
            '/api/v1/orders/update-status.php',
            {

                method:
                    'PUT',

                headers: {

                    'Content-Type':
                        'application/json',

                    'X-CSRF-Token':
                        csrf

                },

                body:
                    JSON.stringify({

                        id:
                            orderId,

                        status:
                            status

                    })

            }
        );


        alert(
            'تم تحديث حالة الطلب بنجاح.'
        );


        closeModal();

        loadOrders();


    } catch (
        error
    ) {

        alert(
            error.message
        );

    }

}


/*
|--------------------------------------------------------------------------
| Cancel Order
|--------------------------------------------------------------------------
*/

async function cancelOrder(
    orderId
) {

    const confirmed =
        confirm(
            'هل أنت متأكد من إلغاء هذا الطلب؟'
        );


    if (!confirmed) {

        return;

    }


    const csrf =
        document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            ?.getAttribute(
                'content'
            )
            || '';


    try {

        await apiRequest(
            '/api/v1/orders/cancel.php',
            {

                method:
                    'POST',

                headers: {

                    'Content-Type':
                        'application/json',

                    'X-CSRF-Token':
                        csrf

                },

                body:
                    JSON.stringify({

                        id:
                            orderId

                    })

            }
        );


        alert(
            'تم إلغاء الطلب بنجاح.'
        );


        closeModal();

        loadOrders();


    } catch (
        error
    ) {

        alert(
            error.message
        );

    }

}


/*
|--------------------------------------------------------------------------
| Close Modal
|--------------------------------------------------------------------------
*/

function closeModal() {

    orderModal.classList.remove(
        'active'
    );


    orderModal.setAttribute(
        'aria-hidden',
        'true'
    );

}


document
    .getElementById(
        'closeModal'
    )
    .addEventListener(
        'click',
        closeModal
    );


orderModal.addEventListener(
    'click',
    event => {

        if (
            event.target ===
            orderModal
        ) {

            closeModal();

        }

    }
);


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
        () => {

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
| Initial Load
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        loadOrders();

    }
);

</script>

</body>

</html>
