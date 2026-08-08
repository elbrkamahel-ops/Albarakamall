// supabase.js
// اتصال مول البركة بقاعدة Supabase

(function () {
  "use strict";

  const SUPABASE_URL =
    "https://jzxvegxtsdznjrcjagwg.supabase.co";

  const SUPABASE_KEY =
    "ضع_هنا_مفتاح_PUBLISHABLE_أو_ANON_من_Supabase";

  if (!window.supabase) {
    console.error("Supabase JS library is not loaded.");
    return;
  }

  window.albarakaSupabase = window.supabase.createClient(
    SUPABASE_URL,
    SUPABASE_KEY
  );

  console.log("Albaraka Supabase initialized");
})();
