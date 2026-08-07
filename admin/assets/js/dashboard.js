/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Admin Dashboard JavaScript
|--------------------------------------------------------------------------
| File:
| admin/assets/js/dashboard.js
|--------------------------------------------------------------------------
*/

'use strict';


/*
|--------------------------------------------------------------------------
| Configuration
|--------------------------------------------------------------------------
*/

const API = {

    stats:
        '/api/v1/dashboard/stats.php',

    recentOrders:
        '/api/v1/orders/list.php?per_page=5',

    lowStock:
        '/api/v1/dashboard/low-stock.php?limit=5'

};


/*
|--------------------------------------------------------------------------
| Elements
|--------------------------------------------------------------------------
*/

const dashboardLoading =
    document.getElementById(
        'dashboardLoading'
    );


const dashboardError =
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
        ||
        status
        ||
        '-'
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
            API.stats
        );


    const stats =
        data.data
        || data.result
        || {};


    const sales =
        stats.sales
        ??
        stats.total_sales
        ??
        0;


    const orders =
        stats.orders
        ??
        stats.total_orders
        ??
        0;


    const products =
        stats.products
        ??
        stats.total_products
        ??
        0;


    const lowStock =
        stats.low_stock
        ??
        0;


    const salesElement =
        document.getElementById(
            'totalSales'
        );


    const ordersElement =
        document.getElementById(
            'totalOrders'
        );


    const productsElement =
        document.getElementById(
            'totalProducts'
        );


    const lowStockElement =
        document.getElementById(
            'lowStock'
        );


    if (salesElement) {

        salesElement.textContent =
            formatCurrency(
                sales
            );

    }


    if (ordersElement) {

        ordersElement.textContent =
            Number(
                orders
            );

    }


    if (productsElement) {

        productsElement.textContent =
            Number(
                products
            );

    }


    if (lowStockElement) {

        lowStockElement.textContent =
            Number(
                lowStock
            );

    }

}


/*
|--------------------------------------------------------------------------
| Load Recent Orders
|--------------------------------------------------------------------------
*/

async function loadRecentOrders() {

    const data =
        await apiRequest(
            API.recentOrders
        );


    const orders =
        data.data?.orders
        ||
        [];


    const tbody =
        document.getElementById(
            'recentOrders'
        );


    if (!tbody) {

        return;

    }


    if (
        orders.length === 0
    ) {

        tbody.innerHTML = `

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
                order => {

                    return `

                        <tr>

                            <td>
                                #${escapeHtml(
                                    order.order_number
                                )}
                            </td>

                            <td>
                                ${escapeHtml(
                                    order.customer?.name
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

                                <span
                                    class="
                                        status-badge
                                        status-${escapeHtml(
                                            order.status
                                        )}
                                    "
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
                                    ||
                                    '-'
                                )}
                            </td>

                        </tr>

                    `;

                }
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
            API.lowStock
        );


    const products =
        data.data?.products
        ||
        [];


    const tbody =
        document.getElementById(
            'lowStockProducts'
        );


    if (!tbody) {

        return;

    }


    if (
        products.length === 0
    ) {

        tbody.innerHTML = `

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
                product => {

                    const stock =
                        Number(
                            product.stock
                            ||
                            0
                        );


                    const stockLabel =
                        stock <= 0
                            ? 'نفد المخزون'
                            : 'مخزون منخفض';


                    return `

                        <tr>

                            <td>
                                ${escapeHtml(
                                    product.name
                                    ||
                                    '-'
                                )}
                            </td>

                            <td>
                                ${escapeHtml(
                                    product.sku
                                    ||
                                    '-'
                                )}
                            </td>

                            <td>
                                ${stock}
                            </td>

                            <td>

                                <span
                                    class="
                                        status-badge
                                        status-low
                                    "
                                >

                                    ${stockLabel}

                                </span>

                            </td>

                        </tr>

                    `;

                }
            )
            .join('');

}


/*
|--------------------------------------------------------------------------
| Mobile Sidebar
|--------------------------------------------------------------------------
*/

function initializeSidebar() {

    const button =
        document.getElementById(
            'menuButton'
        );


    const layout =
        document.getElementById(
            'adminLayout'
        );


    if (
        !button ||
        !layout
    ) {

        return;

    }


    button.addEventListener(
        'click',
        () => {

            layout.classList.toggle(
                'sidebar-open'
            );

        }
    );

}


/*
|--------------------------------------------------------------------------
| Dashboard Loader
|--------------------------------------------------------------------------
*/

async function loadDashboard() {

    try {

        if (
            dashboardLoading
        ) {

            dashboardLoading.hidden =
                false;

        }


        if (
            dashboardError
        ) {

            dashboardError.hidden =
                true;

        }


        await Promise.all([

            loadStats(),

            loadRecentOrders(),

            loadLowStock()

        ]);


    } catch (
        error
    ) {

        console.error(
            'Dashboard Error:',
            error
        );


        if (
            dashboardError
        ) {

            dashboardError.textContent =
                error.message
                ||
                'حدث خطأ غير متوقع.';

            dashboardError.hidden =
                false;

        }


    } finally {

        if (
            dashboardLoading
        ) {

            dashboardLoading.hidden =
                true;

        }

    }

}


/*
|--------------------------------------------------------------------------
| Initialize
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        initializeSidebar();

        loadDashboard();

    }
);
