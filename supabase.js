// =====================================================
// AL BARAKA MALL
// SUPABASE CONNECTION
// =====================================================

(function () {

    "use strict";

    const SUPABASE_URL =
        "https://jzxvegxtsdnjrcjagwg.supabase.co";

    const SUPABASE_ANON_KEY =
        "sb_publishable_wmZ2MTo4Kd962taYU0Oceg_r-jP7Byc";

    // -------------------------------------------------
    // التأكد من تحميل مكتبة Supabase
    // -------------------------------------------------

    if (!window.supabase) {

        console.error(
            "Supabase JS library was not loaded."
        );

        window.db = null;

        return;
    }

    // -------------------------------------------------
    // إنشاء الاتصال
    // -------------------------------------------------

    try {

        window.db =
            window.supabase.createClient(
                SUPABASE_URL,
                SUPABASE_ANON_KEY,
                {
                    auth: {
                        persistSession: false,
                        autoRefreshToken: false
                    }
                }
            );

        console.log(
            "Al Baraka Mall - Supabase connected successfully"
        );

    } catch (error) {

        console.error(
            "Supabase connection error:",
            error
        );

        window.db = null;
    }

})();
