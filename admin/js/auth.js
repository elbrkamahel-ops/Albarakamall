/* =========================================================
   MOL ALBARAKA - ADMIN AUTHENTICATION
   File: admin/js/auth.js
   ========================================================= */

"use strict";


/* =========================================================
   1. CONFIGURATION
   ========================================================= */

const ADMIN_AUTH_CONFIG = {

    /* اسم مفتاح جلسة المدير */
    sessionKey: "albaraka_admin_session",

    /* مدة الجلسة */
    sessionDuration:
        1000 * 60 * 60 * 12, // 12 hours

    /* صفحة تسجيل الدخول */
    loginPage: "login.html",

    /* الصفحة الرئيسية للإدارة */
    dashboardPage: "index.html"

};


/* =========================================================
   2. DEFAULT ADMIN SESSION
   ========================================================= */

/*
   ملاحظة مهمة:

   هذه البيانات مؤقتة للتطوير المحلي فقط.

   عند ربط الموقع بالـ Backend / Database
   سيتم استبدالها بنظام تسجيل دخول حقيقي.
*/

const DEFAULT_ADMIN = {

    id: "admin-001",

    name: "مدير مول البركة",

    username: "admin",

    role: "admin",

    permissions: [

        "dashboard",
        "products",
        "categories",
        "orders",
        "customers",
        "inventory",
        "offers",
        "reports",
        "settings"

    ]

};


/* =========================================================
   3. STORAGE HELPERS
   ========================================================= */

function getAdminSession() {

    try {

        const session =
            localStorage.getItem(
                ADMIN_AUTH_CONFIG.sessionKey
            );

        if (!session) {
            return null;
        }

        return JSON.parse(session);

    } catch (error) {

        console.error(
            "خطأ في قراءة جلسة المدير:",
            error
        );

        return null;
    }

}


function saveAdminSession(session) {

    try {

        localStorage.setItem(

            ADMIN_AUTH_CONFIG.sessionKey,

            JSON.stringify(session)

        );

        return true;

    } catch (error) {

        console.error(
            "خطأ في حفظ جلسة المدير:",
            error
        );

        return false;
    }

}


function clearAdminSession() {

    try {

        localStorage.removeItem(
            ADMIN_AUTH_CONFIG.sessionKey
        );

        return true;

    } catch (error) {

        console.error(
            "خطأ في حذف جلسة المدير:",
            error
        );

        return false;
    }

}


/* =========================================================
   4. SESSION VALIDATION
   ========================================================= */

function isAdminSessionValid() {

    const session =
        getAdminSession();

    if (!session) {
        return false;
    }


    if (
        !session.createdAt ||
        !session.expiresAt
    ) {

        clearAdminSession();

        return false;
    }


    const now =
        Date.now();


    if (
        now >=
        Number(session.expiresAt)
    ) {

        clearAdminSession();

        return false;
    }


    if (
        session.role !== "admin"
    ) {

        clearAdminSession();

        return false;
    }


    return true;

}


/* =========================================================
   5. CREATE SESSION
   ========================================================= */

function createAdminSession(adminData = {}) {

    const now =
        Date.now();


    const session = {

        id:
            adminData.id ||
            DEFAULT_ADMIN.id,

        name:
            adminData.name ||
            DEFAULT_ADMIN.name,

        username:
            adminData.username ||
            DEFAULT_ADMIN.username,

        role:
            adminData.role ||
            DEFAULT_ADMIN.role,

        permissions:
            Array.isArray(
                adminData.permissions
            )
                ? adminData.permissions
                : DEFAULT_ADMIN.permissions,

        createdAt:
            now,

        expiresAt:
            now +
            ADMIN_AUTH_CONFIG.sessionDuration

    };


    saveAdminSession(session);

    return session;

}


/* =========================================================
   6. LOGIN
   ========================================================= */

function adminLogin(username, password) {

    const cleanUsername =
        String(username || "")
            .trim();

    const cleanPassword =
        String(password || "")
            .trim();


    if (
        !cleanUsername ||
        !cleanPassword
    ) {

        return {

            success: false,

            message:
                "يرجى إدخال اسم المستخدم وكلمة المرور."

        };

    }


    /*
       بيانات مؤقتة للتطوير.

       سيتم استبدال هذا الجزء
       بطلب API عند ربط Backend.
    */

    if (
        cleanUsername === "admin" &&
        cleanPassword === "admin123"
    ) {

        const session =
            createAdminSession(
                DEFAULT_ADMIN
            );


        return {

            success: true,

            message:
                "تم تسجيل الدخول بنجاح.",

            session

        };

    }


    return {

        success: false,

        message:
            "اسم المستخدم أو كلمة المرور غير صحيحة."

    };

}


/* =========================================================
   7. LOGOUT
   ========================================================= */

function adminLogout(
    redirect = true
) {

    clearAdminSession();


    if (redirect) {

        window.location.href =
            ADMIN_AUTH_CONFIG.loginPage;

    }

}


/* =========================================================
   8. CURRENT ADMIN
   ========================================================= */

function getCurrentAdmin() {

    if (
        !isAdminSessionValid()
    ) {

        return null;

    }


    return getAdminSession();

}


/* =========================================================
   9. PERMISSIONS
   ========================================================= */

function adminHasPermission(
    permission
) {

    const admin =
        getCurrentAdmin();


    if (!admin) {
        return false;
    }


    if (
        admin.role === "superadmin"
    ) {

        return true;

    }


    if (
        !Array.isArray(
            admin.permissions
        )
    ) {

        return false;

    }


    return admin.permissions.includes(
        permission
    );

}


/* =========================================================
   10. PROTECT ADMIN PAGE
   ========================================================= */

function protectAdminPage() {

    const currentPage =
        window.location.pathname
            .split("/")
            .pop()
            .toLowerCase();


    /*
       إذا كانت الصفحة login
       لا نحتاج حماية.
    */

    if (
        currentPage ===
        ADMIN_AUTH_CONFIG.loginPage
    ) {

        return;

    }


    /*
       التأكد من وجود جلسة صالحة.
    */

    if (
        !isAdminSessionValid()
    ) {

        window.location.href =
            ADMIN_AUTH_CONFIG.loginPage;

        return;

    }


    /*
       تحديث بيانات المدير في الواجهة.
    */

    updateAdminProfile();

}


/* =========================================================
   11. UPDATE ADMIN PROFILE
   ========================================================= */

function updateAdminProfile() {

    const admin =
        getCurrentAdmin();


    if (!admin) {
        return;
    }


    const adminName =
        document.getElementById(
            "adminName"
        );


    if (adminName) {

        adminName.textContent =
            admin.name ||
            "المدير";

    }


    const profileAvatar =
        document.querySelector(
            ".profile-avatar"
        );


    if (profileAvatar) {

        const firstLetter =
            String(
                admin.name ||
                "A"
            ).trim().charAt(0);

        profileAvatar.textContent =
            firstLetter;

    }

}


/* =========================================================
   12. SESSION TIME LEFT
   ========================================================= */

function getSessionTimeLeft() {

    const session =
        getAdminSession();


    if (!session) {
        return 0;
    }


    const remaining =
        Number(
            session.expiresAt
        ) -
        Date.now();


    return Math.max(
        remaining,
        0
    );

}


/* =========================================================
   13. SESSION WARNING
   ========================================================= */

function checkSessionExpiration() {

    const remaining =
        getSessionTimeLeft();


    if (
        remaining <= 0
    ) {

        clearAdminSession();

        /*
           لا نقوم بتحويل الصفحة
           إذا لم تكن داخل لوحة الإدارة.
        */

        const path =
            window.location.pathname
                .toLowerCase();


        if (
            path.includes("/admin/")
        ) {

            window.location.href =
                ADMIN_AUTH_CONFIG.loginPage;

        }

        return;

    }


    /*
       تنبيه قبل انتهاء الجلسة بـ 10 دقائق.
    */

    const tenMinutes =
        1000 * 60 * 10;


    if (
        remaining <= tenMinutes
    ) {

        showSessionWarning();

    }

}


/* =========================================================
   14. SESSION WARNING UI
   ========================================================= */

function showSessionWarning() {

    if (
        document.getElementById(
            "sessionWarning"
        )
    ) {

        return;

    }


    const warning =
        document.createElement(
            "div"
        );


    warning.id =
        "sessionWarning";


    warning.innerHTML = `

        <div
            style="
                position:fixed;
                bottom:20px;
                left:20px;
                z-index:99999;
                max-width:330px;
                padding:15px 18px;
                background:#fff;
                border:1px solid #e3e9e5;
                border-radius:12px;
                box-shadow:0 10px 30px rgba(0,0,0,.12);
                font-family:Tahoma,Arial,sans-serif;
                direction:rtl;
            "
        >

            <strong
                style="
                    display:block;
                    margin-bottom:5px;
                    color:#17231d;
                "
            >
                تنبيه الجلسة
            </strong>

            <span
                style="
                    display:block;
                    color:#7b8880;
                    font-size:12px;
                    line-height:1.7;
                "
            >
                ستنتهي جلسة الإدارة قريباً.
                يرجى تسجيل الدخول مرة أخرى عند انتهاء الجلسة.
            </span>

        </div>

    `;


    document.body.appendChild(
        warning
    );

}


/* =========================================================
   15. LOGOUT BUTTON
   ========================================================= */

function initializeLogoutButton() {

    const logoutButton =
        document.getElementById(
            "logoutButton"
        );


    if (!logoutButton) {
        return;
    }


    logoutButton.addEventListener(
        "click",
        function () {

            const confirmed =
                window.confirm(
                    "هل تريد تسجيل الخروج من لوحة الإدارة؟"
                );


            if (!confirmed) {
                return;
            }


            adminLogout(true);

        }
    );

}


/* =========================================================
   16. AUTO PROTECTION
   ========================================================= */

function initializeAdminAuth() {

    /*
       حماية الصفحة
    */

    protectAdminPage();


    /*
       زر تسجيل الخروج
    */

    initializeLogoutButton();


    /*
       تحديث حالة الجلسة
       كل دقيقة.
    */

    setInterval(
        checkSessionExpiration,
        60 * 1000
    );

}


/* =========================================================
   17. LOGIN PAGE HELPERS
   ========================================================= */

function redirectIfAlreadyLoggedIn() {

    const currentPage =
        window.location.pathname
            .split("/")
            .pop()
            .toLowerCase();


    if (
        currentPage !==
        ADMIN_AUTH_CONFIG.loginPage
    ) {

        return;

    }


    if (
        isAdminSessionValid()
    ) {

        window.location.href =
            ADMIN_AUTH_CONFIG.dashboardPage;

    }

}


/* =========================================================
   18. INITIALIZE
   ========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        redirectIfAlreadyLoggedIn();

        initializeAdminAuth();

    }
);


/* =========================================================
   19. PUBLIC API
   ========================================================= */

window.AlbarakaAdminAuth = {

    login:
        adminLogin,

    logout:
        adminLogout,

    getCurrentAdmin:
        getCurrentAdmin,

    isAuthenticated:
        isAdminSessionValid,

    hasPermission:
        adminHasPermission,

    getSessionTimeLeft:
        getSessionTimeLeft

};


/* =========================================================
   END OF FILE
   ========================================================= */
