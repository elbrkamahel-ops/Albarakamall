/* =========================================================
   مول البركة - Supabase Configuration
   ========================================================= */

const SUPABASE_URL = "ضع_رابط_مشروع_سوباباس_هنا";
const SUPABASE_ANON_KEY = "ضع_مفتاح_ANON_هنا";

if (!SUPABASE_URL || !SUPABASE_ANON_KEY) {
    console.error("Supabase configuration is missing.");
}

const supabaseClient = window.supabase.createClient(
    SUPABASE_URL,
    SUPABASE_ANON_KEY
);
