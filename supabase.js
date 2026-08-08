// ================================
// مول البركة - Supabase Connection
// ================================

const SUPABASE_URL = "https://jzxvegxtszdnjrcjagwg.supabase.co";

const SUPABASE_KEY =
  "sb_publishable_wmZ2MTo4Kd962taYU0Oceg_r-jP7Byc";

if (!window.supabase) {
  console.error("Supabase library is not loaded");
  throw new Error("Supabase library is not loaded");
}

const supabaseClient = window.supabase.createClient(
  SUPABASE_URL,
  SUPABASE_KEY
);

// جعل الاتصال متاحاً لكل ملفات الموقع
window.supabaseClient = supabaseClient;

console.log("Al Baraka Supabase connected");
