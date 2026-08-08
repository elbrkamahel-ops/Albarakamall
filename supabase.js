import { createClient } from "@supabase/supabase-js";

const supabaseUrl = "ضع_رابط_مشروعك_هنا";
const supabaseAnonKey = "ضع_مفتاح_anon_هنا";

export const supabase = createClient(
  supabaseUrl,
  supabaseAnonKey
);
