/* =========================================================
   مول البركة - Admin Dashboard
   File: admin/assets/js/admin.js
   ========================================================= */


/* =========================================================
   1. DOM Ready
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    initializeAdmin();

});


/* =========================================================
   2. Initialize Admin
   ========================================================= */

function initializeAdmin() {

    setupMobileMenu();

    setupSidebarLinks();

    setupNotifications();

    setupGlobalSearch();

    setupConfirmButtons();

    updateCurrentYear();

}



/* =========================================================
   3. Mobile Menu
   ========================================================= */

function setupMobileMenu() {

    const sidebar =
        document.querySelector(".sidebar");


    if (!sidebar) {

        return;

    }


    let button =
        document.querySelector(
            ".mobile-menu-button"
        );


    /*
    إنشاء زر القائمة تلقائيًا
    */

    if (!button) {

        button =
            document.createElement("button");

        button.className =
            "mobile-menu-button";

        button.type =
            "button";

        button.setAttribute(
            "aria-label",
            "فتح القائمة"
        );

        button.innerHTML =
            "☰";


        const main =
            document.querySelector(
                ".main-content"
            );


        if (main) {

            main.prepend(button);

        }

    }


    button.addEventListener(
        "click",
        function () {

            sidebar.classList.toggle(
                "open"
            );

        }
    );


    /*
    إغلاق القائمة عند اختيار رابط
    */

    const links =
        sidebar.querySelectorAll(
            "a"
        );


    links.forEach(
        function (link) {

            link.addEventListener(
                "click",
                function () {

                    sidebar.classList.remove(
                        "open"
                    );

                }
            );

        }
    );

}



/* =========================================================
   4. Sidebar Links
   ========================================================= */

function setupSidebarLinks() {

    const currentPage =
        window.location.pathname
            .split("/")
            .pop();


    const links =
        document.querySelectorAll(
            ".sidebar-menu a"
        );


    links.forEach(
        function (link) {

            const href =
                link.getAttribute("href");


            if (!href) {

                return;

            }


            const linkPage =
                href
                    .split("/")
                    .pop();


            if (
                linkPage === currentPage
            ) {

                link.classList.add(
                    "active"
                );

            }

        }
    );

}



/* =========================================================
   5. Notification System
   ========================================================= */

function setupNotifications() {

    /*
    النظام الأساسي جاهز
    لا يحتاج إلى تنفيذ إضافي
    */

}



/* =========================================================
   6. Admin Notification
   ========================================================= */

function showAdminNotification(
    message,
    type = "success"
) {


    const old =
        document.querySelector(
            ".admin-notification"
        );


    if (old) {

        old.remove();

    }


    const notification =
        document.createElement(
            "div"
        );


    notification.className =
        "admin-notification";


    notification.setAttribute(
        "role",
        "alert"
    );


    notification.innerHTML = `

        <span>
            ${
                type === "success"
                ? "✓"
                : type === "error"
                ? "!"
                : "i"
            }
        </span>

        <strong>
            ${escapeHTML(message)}
        </strong>

    `;


    notification.style.cssText = `

        position: fixed;

        top: 20px;

        left: 20px;

        z-index: 99999;

        display: flex;

        align-items: center;

        gap: 10px;

        padding: 14px 18px;

        border-radius: 10px;

        background: #ffffff;

        border: 1px solid #e2e7e4;

        box-shadow:
            0 10px 30px rgba(0,0,0,.12);

        color: #17221b;

        font-size: 14px;

    `;


    document.body.appendChild(
        notification
    );


    setTimeout(
        function () {

            notification.remove();

        },
        3500
    );

}



/* =========================================================
   7. Global Search
   ========================================================= */

function setupGlobalSearch() {

    const search =
        document.querySelector(
            "[data-admin-search]"
        );


    if (!search) {

        return;

    }


    search.addEventListener(
        "input",
        function () {

            const value =
                this.value
                    .toLowerCase()
                    .trim();


            const rows =
                document.querySelectorAll(
                    ".admin-table tbody tr"
                );


            rows.forEach(
                function (row) {

                    const text =
                        row.innerText
                            .toLowerCase();


                    row.style.display =
                        text.includes(value)
                        ? ""
                        : "none";

                }
            );

        }
    );

}



/* =========================================================
   8. Confirmation Buttons
   ========================================================= */

function setupConfirmButtons() {

    const buttons =
        document.querySelectorAll(
            "[data-confirm]"
        );


    buttons.forEach(
        function (button) {

            button.addEventListener(
                "click",
                function (event) {

                    const message =
                        button.getAttribute(
                            "data-confirm"
                        );


                    if (
                        !confirm(
                            message ||
                            "هل أنت متأكد؟"
                        )
                    ) {

                        event.preventDefault();

                    }

                }
            );

        }
    );

}



/* =========================================================
   9. Local Storage
   ========================================================= */

function saveAdminData(
    key,
    data
) {

    try {

        localStorage.setItem(
            key,
            JSON.stringify(data)
        );


        return true;

    } catch (error) {

        console.error(
            "Admin Storage Error:",
            error
        );


        return false;

    }

}



function getAdminData(
    key,
    defaultValue = null
) {

    try {

        const data =
            localStorage.getItem(
                key
            );


        if (
            data === null
        ) {

            return defaultValue;

        }


        return JSON.parse(data);

    } catch (error) {

        console.error(
            "Admin Storage Error:",
            error
        );


        return defaultValue;

    }

}



function removeAdminData(
    key
) {

    localStorage.removeItem(
        key
    );

}



/* =========================================================
   10. Currency
   ========================================================= */

function formatCurrency(
    value
) {

    const number =
        Number(value) || 0;


    return (
        number.toLocaleString(
            "ar-EG"
        ) +
        " جنيه"
    );

}



/* =========================================================
   11. Number Formatting
   ========================================================= */

function formatNumber(
    value
) {

    const number =
        Number(value) || 0;


    return number.toLocaleString(
        "ar-EG"
    );

}



/* =========================================================
   12. Date Formatting
   ========================================================= */

function formatDate(
    date
) {

    if (!date) {

        return "-";

    }


    const parsedDate =
        new Date(date);


    if (
        Number.isNaN(
            parsedDate.getTime()
        )
    ) {

        return date;

    }


    return parsedDate.toLocaleDateString(
        "ar-EG",
        {
            year: "numeric",
            month: "long",
            day: "numeric"
        }
    );

}



/* =========================================================
   13. Date & Time
   ========================================================= */

function formatDateTime(
    date
) {

    if (!date) {

        return "-";

    }


    const parsedDate =
        new Date(date);


    if (
        Number.isNaN(
            parsedDate.getTime()
        )
    ) {

        return date;

    }


    return parsedDate.toLocaleString(
        "ar-EG",
        {
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit"
        }
    );

}



/* =========================================================
   14. Generate ID
   ========================================================= */

function generateAdminId(
    prefix = "ID"
) {

    const time =
        Date.now();


    const random =
        Math.floor(
            Math.random() * 10000
        );


    return (
        prefix +
        "-" +
        time +
        "-" +
        random
    );

}



/* =========================================================
   15. Escape HTML
   ========================================================= */

function escapeHTML(
    value
) {

    if (
        value === null ||
        value === undefined
    ) {

        return "";

    }


    return String(value)
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
   16. Empty State
   ========================================================= */

function showEmptyState(
    container,
    message = "لا توجد بيانات"
) {

    if (!container) {

        return;

    }


    container.innerHTML = `

        <tr>

            <td
                colspan="100"
                style="
                    text-align:center;
                    padding:40px;
                "
            >

                <div
                    style="
                        font-size:40px;
                        margin-bottom:10px;
                    "
                >
                    📭
                </div>

                <p>
                    ${escapeHTML(message)}
                </p>

            </td>

        </tr>

    `;

}



/* =========================================================
   17. Loading State
   ========================================================= */

function showLoading(
    container,
    message = "جاري التحميل..."
) {

    if (!container) {

        return;

    }


    container.innerHTML = `

        <tr>

            <td
                colspan="100"
                style="
                    text-align:center;
                    padding:40px;
                "
            >

                <div
                    style="
                        font-size:28px;
                        margin-bottom:10px;
                    "
                >
                    ⏳
                </div>

                <p>
                    ${escapeHTML(message)}
                </p>

            </td>

        </tr>

    `;

}



/* =========================================================
   18. Debounce
   ========================================================= */

function debounce(
    callback,
    delay = 300
) {

    let timer;


    return function (...args) {

        clearTimeout(
            timer
        );


        timer =
            setTimeout(
                function () {

                    callback.apply(
                        this,
                        args
                    );

                },
                delay
            );

    };

}



/* =========================================================
   19. Today
   ========================================================= */

function getToday() {

    const now =
        new Date();


    return now
        .toISOString()
        .split("T")[0];

}



/* =========================================================
   20. Check Date Range
   ========================================================= */

function isDateExpired(
    date
) {

    if (!date) {

        return false;

    }


    return date < getToday();

}



/* =========================================================
   21. Product Availability
   ========================================================= */

function getAvailabilityText(
    available
) {

    return available
        ? "متوفر"
        : "غير متوفر";

}



/* =========================================================
   22. Order Status
   ========================================================= */

function getOrderStatusText(
    status
) {

    const statuses = {

        pending:
            "قيد الانتظار",

        confirmed:
            "تم التأكيد",

        preparing:
            "جاري التجهيز",

        shipping:
            "قيد التوصيل",

        completed:
            "مكتمل",

        cancelled:
            "ملغي"

    };


    return (
        statuses[status] ||
        status ||
        "-"
    );

}



/* =========================================================
   23. Customer Status
   ========================================================= */

function getCustomerStatusText(
    status
) {

    return status === "active"
        ? "نشط"
        : "غير نشط";

}



/* =========================================================
   24. Save Current Page
   ========================================================= */

function saveCurrentAdminPage() {

    saveAdminData(
        "albaraka_current_admin_page",
        window.location.pathname
    );

}



/* =========================================================
   25. Current Year
   ========================================================= */

function updateCurrentYear() {

    const elements =
        document.querySelectorAll(
            "[data-current-year]"
        );


    const year =
        new Date().getFullYear();


    elements.forEach(
        function (element) {

            element.textContent =
                year;

        }
    );

}



/* =========================================================
   26. Close Sidebar on Outside Click
   ========================================================= */

document.addEventListener(
    "click",
    function (event) {

        const sidebar =
            document.querySelector(
                ".sidebar"
            );


        const button =
            document.querySelector(
                ".mobile-menu-button"
            );


        if (
            !sidebar ||
            !sidebar.classList.contains(
                "open"
            )
        ) {

            return;

        }


        if (
            sidebar.contains(
                event.target
            )
        ) {

            return;

        }


        if (
            button &&
            button.contains(
                event.target
            )
        ) {

            return;

        }


        sidebar.classList.remove(
            "open"
        );

    }
);



/* =========================================================
   27. Prevent Invalid Number Input
   ========================================================= */

document.addEventListener(
    "input",
    function (event) {

        const input =
            event.target;


        if (
            input.matches(
                'input[type="number"]'
            )
        ) {

            if (
                Number(input.value) < 0
            ) {

                input.value = 0;

            }

        }

    }
);



/* =========================================================
   28. Public API
   ========================================================= */

window.AlBarakaAdmin = {

    save:
        saveAdminData,

    get:
        getAdminData,

    remove:
        removeAdminData,

    notify:
        showAdminNotification,

    currency:
        formatCurrency,

    number:
        formatNumber,

    date:
        formatDate,

    dateTime:
        formatDateTime,

    id:
        generateAdminId,

    escape:
        escapeHTML,

    today:
        getToday

};
