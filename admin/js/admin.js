/* =========================================================
   MOL ALBARAKA - ADMIN DASHBOARD
   File: admin/js/admin.js
   ========================================================= */

"use strict";


/* =========================================================
   1. DASHBOARD DATA
   ========================================================= */

const dashboardData = {

    sales: {
        total: 0,
        growth: 0
    },

    orders: {
        today: 0,
        new: 0
    },

    customers: {
        total: 0
    },

    products: {
        total: 0
    },

    lowStock: [],

    recentOrders: [],

    notifications: []

};


/* =========================================================
   2. DOM HELPERS
   ========================================================= */

function getElement(id) {

    return document.getElementById(id);

}


function formatNumber(number) {

    return new Intl.NumberFormat(
        "ar-EG"
    ).format(
        Number(number) || 0
    );

}


function formatCurrency(number) {

    return `${formatNumber(number)} ج.م`;

}


/* =========================================================
   3. CURRENT DATE
   ========================================================= */

function updateCurrentDate() {

    const dateElement =
        getElement("currentDate");

    if (!dateElement) {
        return;
    }


    const today =
        new Date();


    const formattedDate =
        today.toLocaleDateString(
            "ar-EG",
            {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric"
            }
        );


    dateElement.textContent =
        formattedDate;

}


/* =========================================================
   4. UPDATE STATISTICS
   ========================================================= */

function updateStatistics() {

    const totalSales =
        getElement("totalSales");

    const todayOrders =
        getElement("todayOrders");

    const totalCustomers =
        getElement("totalCustomers");

    const totalProducts =
        getElement("totalProducts");


    if (totalSales) {

        totalSales.textContent =
            formatCurrency(
                dashboardData.sales.total
            );

    }


    if (todayOrders) {

        todayOrders.textContent =
            formatNumber(
                dashboardData.orders.today
            );

    }


    if (totalCustomers) {

        totalCustomers.textContent =
            formatNumber(
                dashboardData.customers.total
            );

    }


    if (totalProducts) {

        totalProducts.textContent =
            formatNumber(
                dashboardData.products.total
            );

    }


    const orderBadge =
        getElement("newOrdersCount");


    if (orderBadge) {

        orderBadge.textContent =
            formatNumber(
                dashboardData.orders.new
            );

    }

}


/* =========================================================
   5. LOW STOCK
   ========================================================= */

function renderLowStock() {

    const container =
        getElement("lowStockList");


    if (!container) {
        return;
    }


    if (
        !dashboardData.lowStock.length
    ) {

        container.innerHTML = `

            <div class="empty-state">
                لا توجد منتجات منخفضة المخزون
            </div>

        `;

        return;

    }


    container.innerHTML =
        dashboardData.lowStock
            .map(product => `

                <div class="stock-item">

                    <div class="stock-image">

                        ${
                            product.image

                            ? `
                                <img
                                    src="${escapeHTML(product.image)}"
                                    alt="${escapeHTML(product.name)}"
                                >
                            `

                            : `
                                <span
                                    style="
                                        width:100%;
                                        height:100%;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        font-size:18px;
                                    "
                                >
                                    📦
                                </span>
                            `
                        }

                    </div>


                    <div class="stock-info">

                        <strong>
                            ${escapeHTML(product.name)}
                        </strong>

                        <span>
                            ${escapeHTML(product.unit || "وحدة")}
                        </span>

                    </div>


                    <span class="stock-count">

                        متبقي
                        ${formatNumber(product.quantity)}

                    </span>

                </div>

            `)
            .join("");

}


/* =========================================================
   6. RECENT ORDERS
   ========================================================= */

function renderRecentOrders() {

    const table =
        getElement(
            "recentOrdersTable"
        );


    if (!table) {
        return;
    }


    if (
        !dashboardData.recentOrders.length
    ) {

        table.innerHTML = `

            <tr>

                <td colspan="7">

                    <div class="table-empty">

                        لا توجد طلبات حالياً

                    </div>

                </td>

            </tr>

        `;

        return;

    }


    table.innerHTML =
        dashboardData.recentOrders
            .map(order => `

                <tr>

                    <td>
                        <strong>
                            #${escapeHTML(order.id)}
                        </strong>
                    </td>


                    <td>
                        ${escapeHTML(order.customer)}
                    </td>


                    <td>
                        ${formatNumber(order.items)}
                    </td>


                    <td>
                        <strong>
                            ${formatCurrency(order.total)}
                        </strong>
                    </td>


                    <td>

                        <span
                            class="status ${getStatusClass(order.status)}"
                        >
                            ${getStatusText(order.status)}
                        </span>

                    </td>


                    <td>
                        ${escapeHTML(order.date)}
                    </td>


                    <td>

                        <a
                            href="pages/orders.html?id=${encodeURIComponent(order.id)}"
                            class="table-action"
                            title="عرض الطلب"
                        >
                            →
                        </a>

                    </td>

                </tr>

            `)
            .join("");

}


/* =========================================================
   7. ORDER STATUS
   ========================================================= */

function getStatusClass(status) {

    const classes = {

        new:
            "status-new",

        processing:
            "status-processing",

        ready:
            "status-ready",

        delivery:
            "status-delivery",

        completed:
            "status-completed",

        cancelled:
            "status-cancelled"

    };


    return classes[status] ||
        "status-new";

}


function getStatusText(status) {

    const texts = {

        new:
            "جديد",

        processing:
            "قيد التجهيز",

        ready:
            "جاهز",

        delivery:
            "جاري التوصيل",

        completed:
            "مكتمل",

        cancelled:
            "ملغي"

    };


    return texts[status] ||
        "غير محدد";

}


/* =========================================================
   8. SALES CHART
   ========================================================= */

function renderSalesChart(days = 7) {

    const chart =
        getElement("salesChart");


    if (!chart) {
        return;
    }


    const labels =
        generateChartLabels(days);


    const values =
        generateChartValues(days);


    const maxValue =
        Math.max(
            ...values,
            1
        );


    chart.innerHTML = `

        <div
            class="simple-chart"
            style="
                width:100%;
                min-height:240px;
                display:flex;
                align-items:flex-end;
                gap:8px;
                padding:20px 5px 5px;
            "
        >

            ${values.map(
                (value, index) => {

                    const height =
                        Math.max(
                            8,
                            (value / maxValue) * 100
                        );


                    return `

                        <div
                            style="
                                flex:1;
                                height:220px;
                                display:flex;
                                flex-direction:column;
                                justify-content:flex-end;
                                align-items:center;
                                gap:8px;
                            "
                        >

                            <span
                                style="
                                    color:#7b8880;
                                    font-size:9px;
                                "
                            >
                                ${formatNumber(value)}
                            </span>


                            <div
                                title="${formatCurrency(value)}"
                                style="
                                    width:100%;
                                    max-width:45px;
                                    height:${height}%;
                                    min-height:8px;
                                    border-radius:8px 8px 3px 3px;
                                    background:
                                        linear-gradient(
                                            180deg,
                                            #176b45,
                                            #0f4f32
                                        );
                                    transition:height .4s ease;
                                "
                            ></div>


                            <span
                                style="
                                    color:#7b8880;
                                    font-size:9px;
                                    white-space:nowrap;
                                "
                            >
                                ${labels[index]}
                            </span>

                        </div>

                    `;

                }
            ).join("")}

        </div>

    `;

}


/* =========================================================
   9. CHART LABELS
   ========================================================= */

function generateChartLabels(days) {

    const labels = [];

    const today =
        new Date();


    for (
        let i = days - 1;
        i >= 0;
        i--
    ) {

        const date =
            new Date(today);


        date.setDate(
            today.getDate() - i
        );


        labels.push(
            date.toLocaleDateString(
                "ar-EG",
                {
                    weekday: "short"
                }
            )
        );

    }


    return labels;

}


/* =========================================================
   10. CHART VALUES
   ========================================================= */

function generateChartValues(days) {

    /*
       في حالة عدم وجود مبيعات
       نعرض الرسم بقيم صفرية.

       عند ربط API سيتم استبدال
       هذه البيانات بالبيانات الحقيقية.
    */

    return Array(
        days
    ).fill(0);

}


/* =========================================================
   11. SALES PERIOD
   ========================================================= */

function initializeSalesPeriod() {

    const select =
        getElement(
            "salesPeriod"
        );


    if (!select) {
        return;
    }


    select.addEventListener(
        "change",
        function () {

            const days =
                Number(
                    this.value
                ) || 7;


            renderSalesChart(days);

        }
    );

}


/* =========================================================
   12. SIDEBAR
   ========================================================= */

function initializeSidebar() {

    const sidebar =
        document.querySelector(
            ".admin-sidebar"
        );


    const toggle =
        getElement(
            "sidebarToggle"
        );


    if (
        !sidebar ||
        !toggle
    ) {

        return;

    }


    let overlay =
        document.querySelector(
            ".sidebar-overlay"
        );


    if (!overlay) {

        overlay =
            document.createElement(
                "div"
            );


        overlay.className =
            "sidebar-overlay";


        document.body.appendChild(
            overlay
        );

    }


    function openSidebar() {

        sidebar.classList.add(
            "open"
        );

        overlay.classList.add(
            "active"
        );

        document.body.style.overflow =
            "hidden";

    }


    function closeSidebar() {

        sidebar.classList.remove(
            "open"
        );

        overlay.classList.remove(
            "active"
        );

        document.body.style.overflow =
            "";

    }


    toggle.addEventListener(
        "click",
        function () {

            if (
                sidebar.classList.contains(
                    "open"
                )
            ) {

                closeSidebar();

            } else {

                openSidebar();

            }

        }
    );


    overlay.addEventListener(
        "click",
        closeSidebar
    );


    document
        .querySelectorAll(
            ".nav-item"
        )
        .forEach(item => {

            item.addEventListener(
                "click",
                function () {

                    if (
                        window.innerWidth <=
                        768
                    ) {

                        closeSidebar();

                    }

                }
            );

        });


    window.addEventListener(
        "resize",
        function () {

            if (
                window.innerWidth > 768
            ) {

                closeSidebar();

            }

        }
    );

}


/* =========================================================
   13. NOTIFICATIONS
   ========================================================= */

function initializeNotifications() {

    const button =
        getElement(
            "notificationsButton"
        );


    const panel =
        getElement(
            "notificationPanel"
        );


    const close =
        getElement(
            "closeNotifications"
        );


    const list =
        getElement(
            "notificationList"
        );


    if (
        !button ||
        !panel
    ) {

        return;

    }


    renderNotifications(
        list
    );


    button.addEventListener(
        "click",
        function (event) {

            event.stopPropagation();

            panel.hidden =
                !panel.hidden;

        }
    );


    if (close) {

        close.addEventListener(
            "click",
            function () {

                panel.hidden =
                    true;

            }
        );

    }


    document.addEventListener(
        "click",
        function (event) {

            if (
                panel.hidden
            ) {

                return;

            }


            if (
                !panel.contains(event.target) &&
                !button.contains(event.target)
            ) {

                panel.hidden =
                    true;

            }

        }
    );

}


/* =========================================================
   14. RENDER NOTIFICATIONS
   ========================================================= */

function renderNotifications(
    container
) {

    if (!container) {
        return;
    }


    if (
        !dashboardData.notifications.length
    ) {

        container.innerHTML = `

            <div class="empty-state">

                لا توجد إشعارات جديدة

            </div>

        `;

        return;

    }


    container.innerHTML =
        dashboardData.notifications
            .map(notification => `

                <div
                    style="
                        padding:15px;
                        border-bottom:1px solid #e3e9e5;
                    "
                >

                    <strong
                        style="
                            display:block;
                            color:#17231d;
                            font-size:12px;
                            margin-bottom:3px;
                        "
                    >
                        ${escapeHTML(notification.title)}
                    </strong>

                    <span
                        style="
                            display:block;
                            color:#7b8880;
                            font-size:10px;
                        "
                    >
                        ${escapeHTML(notification.message)}
                    </span>

                </div>

            `)
            .join("");

}


/* =========================================================
   15. NOTIFICATION DOT
   ========================================================= */

function updateNotificationDot() {

    const dot =
        getElement(
            "notificationDot"
        );


    if (!dot) {
        return;
    }


    if (
        dashboardData.notifications.length
    ) {

        dot.style.display =
            "block";

    } else {

        dot.style.display =
            "none";

    }

}


/* =========================================================
   16. ESCAPE HTML
   ========================================================= */

function escapeHTML(value) {

    return String(
        value ?? ""
    )
        .replace(
            /&/g,
            "&amp;"
        )
        .replace(
            /</g,
            "&lt;"
        )
        .replace(
            />/g,
            "&gt;"
        )
        .replace(
            /"/g,
            "&quot;"
        )
        .replace(
            /'/g,
            "&#039;"
        );

}


/* =========================================================
   17. LOAD DASHBOARD DATA
   ========================================================= */

async function loadDashboardData() {

    /*
       حالياً نستخدم البيانات المحلية.

       في المرحلة القادمة سيتم ربط هذه الوظيفة
       بالـ Backend / API / Database.
    */


    dashboardData.sales = {

        total: 0,

        growth: 0

    };


    dashboardData.orders = {

        today: 0,

        new: 0

    };


    dashboardData.customers = {

        total: 0

    };


    dashboardData.products = {

        total: 0

    };


    dashboardData.lowStock = [];

    dashboardData.recentOrders = [];

    dashboardData.notifications = [];


    updateStatistics();

    renderLowStock();

    renderRecentOrders();

    renderSalesChart(7);

    updateNotificationDot();

}


/* =========================================================
   18. NAVIGATION ACTIVE STATE
   ========================================================= */

function initializeNavigation() {

    const currentPath =
        window.location.pathname
            .toLowerCase();


    document
        .querySelectorAll(
            ".nav-item"
        )
        .forEach(item => {

            const href =
                item.getAttribute(
                    "href"
                );


            if (!href) {
                return;
            }


            const cleanHref =
                href
                    .split("?")[0]
                    .toLowerCase();


            if (
                currentPath.includes(
                    cleanHref
                        .replace(
                            "pages/",
                            ""
                        )
                )
            ) {

                document
                    .querySelectorAll(
                        ".nav-item"
                    )
                    .forEach(nav => {

                        nav.classList.remove(
                            "active"
                        );

                    });


                item.classList.add(
                    "active"
                );

            }

        });

}


/* =========================================================
   19. KEYBOARD SHORTCUTS
   ========================================================= */

function initializeKeyboardShortcuts() {

    document.addEventListener(
        "keydown",
        function (event) {

            /*
               Ctrl + Shift + D
               العودة للوحة التحكم
            */

            if (
                event.ctrlKey &&
                event.shiftKey &&
                event.key.toLowerCase() === "d"
            ) {

                event.preventDefault();

                window.location.href =
                    "index.html";

            }

        }
    );

}


/* =========================================================
   20. INITIALIZE DASHBOARD
   ========================================================= */

async function initializeDashboard() {

    updateCurrentDate();

    initializeSidebar();

    initializeNotifications();

    initializeSalesPeriod();

    initializeNavigation();

    initializeKeyboardShortcuts();

    await loadDashboardData();

}


/* =========================================================
   21. START
   ========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        initializeDashboard();

    }
);


/* =========================================================
   22. PUBLIC API
   ========================================================= */

window.AlbarakaAdmin = {

    refresh:
        loadDashboardData,

    updateStatistics:
        updateStatistics,

    renderOrders:
        renderRecentOrders,

    renderInventory:
        renderLowStock,

    formatCurrency:
        formatCurrency,

    formatNumber:
        formatNumber

};


/* =========================================================
   END OF FILE
   ========================================================= */
