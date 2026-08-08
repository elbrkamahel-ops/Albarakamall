<?php
declare(strict_types=1);

session_start();

/*
|--------------------------------------------------------------------------
| مول البركة - لوحة تحكم احترافية
| الملف: admin/index.php
|--------------------------------------------------------------------------
*/

/* حماية لوحة التحكم */
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$adminName = $_SESSION['admin_name'] ?? 'مدير مول البركة';
$adminRole = $_SESSION['admin_role'] ?? 'manager';

/*
|--------------------------------------------------------------------------
| محاولة الاتصال بقاعدة البيانات
|--------------------------------------------------------------------------
*/
$db = null;

try {
    $configFile = __DIR__ . '/../config/config.php';

    if (file_exists($configFile)) {
        require_once $configFile;
    }

    /* يدعم PDO */
    if (isset($pdo) && $pdo instanceof PDO) {
        $db = $pdo;
    }

    /* يدعم mysqli */
    elseif (isset($conn) && $conn instanceof mysqli) {
        $db = $conn;
    }

    elseif (isset($mysqli) && $mysqli instanceof mysqli) {
        $db = $mysqli;
    }

} catch (Throwable $e) {
    $db = null;
}

/*
|--------------------------------------------------------------------------
| دوال آمنة
|--------------------------------------------------------------------------
*/

function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function money($value): string
{
    return number_format((float)$value, 2) . ' ج.م';
}

function dbScalar($db, string $sql, $default = 0)
{
    try {

        if ($db instanceof PDO) {
            $stmt = $db->query($sql);

            if ($stmt) {
                $value = $stmt->fetchColumn();

                return $value !== false && $value !== null
                    ? $value
                    : $default;
            }
        }

        if ($db instanceof mysqli) {
            $result = $db->query($sql);

            if ($result && ($row = $result->fetch_row())) {
                return $row[0] ?? $default;
            }
        }

    } catch (Throwable $e) {
        return $default;
    }

    return $default;
}

function dbRows($db, string $sql): array
{
    $rows = [];

    try {

        if ($db instanceof PDO) {
            $stmt = $db->query($sql);

            if ($stmt) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        if ($db instanceof mysqli) {
            $result = $db->query($sql);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
            }
        }

    } catch (Throwable $e) {
        return [];
    }

    return $rows;
}

/*
|--------------------------------------------------------------------------
| الإحصائيات
|--------------------------------------------------------------------------
*/

$productsCount  = (int) dbScalar(
    $db,
    "SELECT COUNT(*) FROM products WHERE active = 1",
    0
);

$customersCount = (int) dbScalar(
    $db,
    "SELECT COUNT(*) FROM customers",
    0
);

$ordersCount = (int) dbScalar(
    $db,
    "SELECT COUNT(*) FROM orders",
    0
);

$categoriesCount = (int) dbScalar(
    $db,
    "SELECT COUNT(*) FROM categories WHERE active = 1",
    0
);

$totalSales = (float) dbScalar(
    $db,
    "SELECT COALESCE(SUM(total),0) FROM orders",
    0
);

$todaySales = (float) dbScalar(
    $db,
    "SELECT COALESCE(SUM(total),0)
     FROM orders
     WHERE DATE(created_at)=CURDATE()",
    0
);

$todayOrders = (int) dbScalar(
    $db,
    "SELECT COUNT(*)
     FROM orders
     WHERE DATE(created_at)=CURDATE()",
    0
);

$lowStock = (int) dbScalar(
    $db,
    "SELECT COUNT(*)
     FROM products
     WHERE active=1 AND stock <= 5",
    0
);

/*
|--------------------------------------------------------------------------
| آخر الطلبات
|--------------------------------------------------------------------------
*/

$recentOrders = dbRows(
    $db,
    "SELECT
        id,
        order_number,
        customer_name,
        customer_mobile,
        total,
        order_status,
        payment_status,
        created_at
     FROM orders
     ORDER BY id DESC
     LIMIT 7"
);

/*
|--------------------------------------------------------------------------
| المنتجات الأكثر ظهورًا
|--------------------------------------------------------------------------
*/

$topProducts = dbRows(
    $db,
    "SELECT
        p.name,
        p.price,
        p.stock,
        p.image,
        p.featured,
        p.offer
     FROM products p
     WHERE p.active = 1
     ORDER BY p.featured DESC, p.id DESC
     LIMIT 6"
);

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<meta name="theme-color" content="#0b7f3f">

<title>لوحة التحكم | مول البركة</title>

<style>

/* =========================================================
   RESET
========================================================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:
        Tahoma,
        Arial,
        sans-serif;

    background:
        #f4f7f6;

    color:#17221c;

    min-height:100vh;
}

/* =========================================================
   VARIABLES
========================================================= */

:root{

    --green:#087f3f;
    --green-dark:#056332;
    --green-light:#e9f7ef;

    --gold:#d9a441;

    --dark:#10241a;

    --text:#17221c;
    --muted:#718078;

    --white:#ffffff;

    --border:#e8eeeb;

    --shadow:
        0 10px 30px rgba(12,42,27,.07);

    --radius:20px;
}

/* =========================================================
   LAYOUT
========================================================= */

.app{
    min-height:100vh;
    display:flex;
}

/* =========================================================
   SIDEBAR
========================================================= */

.sidebar{

    width:270px;

    background:
        linear-gradient(
            180deg,
            #073b25 0%,
            #075c35 45%,
            #087f3f 100%
        );

    color:white;

    position:fixed;

    top:0;
    bottom:0;
    right:0;

    z-index:1000;

    padding:22px 16px;

    overflow-y:auto;

    box-shadow:
        -10px 0 35px rgba(0,0,0,.12);

    transition:.3s;
}

.brand{

    display:flex;

    align-items:center;

    gap:12px;

    padding:
        5px 8px 25px;

    border-bottom:
        1px solid rgba(255,255,255,.13);

    margin-bottom:20px;
}

.brand-logo{

    width:50px;
    height:50px;

    border-radius:15px;

    background:white;

    color:var(--green);

    display:flex;

    align-items:center;
    justify-content:center;

    font-size:25px;
    font-weight:900;

    box-shadow:
        0 8px 20px rgba(0,0,0,.15);
}

.brand-text strong{

    display:block;

    font-size:19px;

}

.brand-text span{

    display:block;

    font-size:11px;

    opacity:.7;

    margin-top:4px;
}

/* =========================================================
   PROFILE
========================================================= */

.profile{

    background:
        rgba(255,255,255,.08);

    border:
        1px solid rgba(255,255,255,.1);

    border-radius:17px;

    padding:14px;

    margin-bottom:20px;
}

.profile-top{

    display:flex;

    align-items:center;

    gap:10px;
}

.avatar{

    width:43px;
    height:43px;

    border-radius:50%;

    background:
        linear-gradient(
            135deg,
            #ffffff,
            #dcefe4
        );

    color:var(--green);

    display:flex;

    align-items:center;
    justify-content:center;

    font-weight:900;
}

.profile-name{

    font-size:14px;
    font-weight:bold;
}

.profile-role{

    font-size:11px;
    opacity:.65;

    margin-top:4px;
}

/* =========================================================
   MENU
========================================================= */

.menu-title{

    font-size:11px;

    color:
        rgba(255,255,255,.45);

    padding:
        10px 12px 8px;

    font-weight:bold;
}

.menu{

    display:flex;

    flex-direction:column;

    gap:5px;
}

.menu a{

    color:white;

    text-decoration:none;

    padding:
        13px 14px;

    border-radius:13px;

    display:flex;

    align-items:center;

    gap:12px;

    font-size:14px;

    transition:.2s;
}

.menu a:hover{

    background:
        rgba(255,255,255,.12);

    transform:
        translateX(-3px);
}

.menu a.active{

    background:white;

    color:var(--green);

    box-shadow:
        0 8px 20px rgba(0,0,0,.12);

    font-weight:bold;
}

.menu-icon{

    width:25px;

    text-align:center;

    font-size:18px;
}

.logout{

    margin-top:20px;

    border-top:
        1px solid rgba(255,255,255,.12);

    padding-top:18px;
}

.logout a{

    color:#ffd7d7 !important;
}

/* =========================================================
   MAIN
========================================================= */

.main{

    flex:1;

    margin-right:270px;

    min-width:0;
}

/* =========================================================
   TOPBAR
========================================================= */

.topbar{

    height:76px;

    background:white;

    border-bottom:
        1px solid var(--border);

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:
        0 30px;

    position:sticky;

    top:0;

    z-index:500;
}

.topbar-title{

    display:flex;

    align-items:center;

    gap:12px;
}

.mobile-menu{

    display:none;

    width:42px;
    height:42px;

    border:0;

    border-radius:12px;

    background:
        var(--green-light);

    color:var(--green);

    font-size:21px;
}

.top-title h1{

    font-size:20px;

    font-weight:900;
}

.top-title p{

    color:var(--muted);

    font-size:11px;

    margin-top:4px;
}

.top-actions{

    display:flex;

    align-items:center;

    gap:10px;
}

.top-button{

    width:42px;
    height:42px;

    border-radius:12px;

    border:
        1px solid var(--border);

    background:white;

    display:flex;

    align-items:center;
    justify-content:center;

    text-decoration:none;

    color:var(--text);

    font-size:18px;

    transition:.2s;
}

.top-button:hover{

    border-color:var(--green);

    color:var(--green);

    transform:translateY(-2px);
}

.notification{

    position:relative;
}

.notification::after{

    content:"";

    position:absolute;

    width:8px;
    height:8px;

    background:#ef4444;

    border:2px solid white;

    border-radius:50%;

    top:7px;
    right:7px;
}

/* =========================================================
   CONTENT
========================================================= */

.content{

    padding:30px;

    max-width:1700px;

    margin:auto;
}

/* =========================================================
   WELCOME
========================================================= */

.welcome{

    background:

        radial-gradient(
            circle at 90% 20%,
            rgba(255,255,255,.2),
            transparent 30%
        ),

        linear-gradient(
            135deg,
            #087f3f,
            #075c35
        );

    color:white;

    border-radius:25px;

    padding:30px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:20px;

    box-shadow:
        0 15px 35px rgba(8,127,63,.18);

    margin-bottom:25px;

    overflow:hidden;

    position:relative;
}

.welcome::after{

    content:"";

    position:absolute;

    width:220px;
    height:220px;

    border-radius:50%;

    border:
        30px solid rgba(255,255,255,.04);

    left:-70px;
    bottom:-100px;
}

.welcome h2{

    font-size:28px;

    margin-bottom:8px;
}

.welcome p{

    opacity:.78;

    font-size:13px;
}

.welcome-badge{

    background:
        rgba(255,255,255,.12);

    border:
        1px solid rgba(255,255,255,.15);

    border-radius:18px;

    padding:18px 22px;

    min-width:190px;

    text-align:center;
}

.welcome-badge strong{

    display:block;

    font-size:23px;

}

.welcome-badge span{

    font-size:11px;

    opacity:.7;
}

/* =========================================================
   STATS
========================================================= */

.stats{

    display:grid;

    grid-template-columns:
        repeat(4,1fr);

    gap:17px;

    margin-bottom:25px;
}

.stat{

    background:white;

    border:
        1px solid var(--border);

    border-radius:19px;

    padding:21px;

    box-shadow:var(--shadow);

    transition:.25s;

    position:relative;

    overflow:hidden;
}

.stat:hover{

    transform:
        translateY(-4px);

    box-shadow:
        0 15px 35px rgba(12,42,27,.11);
}

.stat::after{

    content:"";

    position:absolute;

    width:80px;
    height:80px;

    border-radius:50%;

    background:
        var(--green-light);

    left:-25px;
    bottom:-30px;
}

.stat-top{

    display:flex;

    justify-content:space-between;

    align-items:center;

    position:relative;

    z-index:2;
}

.stat-icon{

    width:47px;
    height:47px;

    border-radius:14px;

    background:
        var(--green-light);

    color:var(--green);

    display:flex;

    align-items:center;
    justify-content:center;

    font-size:21px;
}

.stat-label{

    color:var(--muted);

    font-size:12px;
}

.stat-number{

    font-size:25px;

    font-weight:900;

    margin-top:14px;

    position:relative;

    z-index:2;
}

.stat-footer{

    margin-top:7px;

    color:var(--muted);

    font-size:10px;

    position:relative;

    z-index:2;
}

.stat-warning .stat-icon{

    background:#fff4df;

    color:#c68100;
}

/* =========================================================
   GRID
========================================================= */

.dashboard-grid{

    display:grid;

    grid-template-columns:
        minmax(0,2fr)
        minmax(300px,1fr);

    gap:20px;

    margin-bottom:25px;
}

.card{

    background:white;

    border:
        1px solid var(--border);

    border-radius:20px;

    box-shadow:var(--shadow);

    overflow:hidden;
}

.card-head{

    padding:20px;

    display:flex;

    align-items:center;

    justify-content:space-between;

    border-bottom:
        1px solid var(--border);
}

.card-head h3{

    font-size:16px;

    font-weight:900;
}

.card-head span{

    font-size:11px;

    color:var(--muted);
}

.view-all{

    color:var(--green);

    text-decoration:none;

    font-size:12px;

    font-weight:bold;
}

/* =========================================================
   ORDERS
========================================================= */

.table-wrap{

    width:100%;

    overflow-x:auto;
}

table{

    width:100%;

    border-collapse:collapse;

    min-width:650px;
}

th{

    text-align:right;

    font-size:11px;

    color:var(--muted);

    font-weight:bold;

    padding:
        14px 18px;

    background:#fbfcfc;
}

td{

    padding:
        15px 18px;

    border-top:
        1px solid var(--border);

    font-size:12px;
}

.order-number{

    color:var(--green);

    font-weight:900;
}

.customer{

    font-weight:bold;
}

.customer small{

    display:block;

    color:var(--muted);

    margin-top:3px;

    font-size:10px;
}

.status{

    display:inline-flex;

    padding:
        6px 10px;

    border-radius:30px;

    font-size:10px;

    font-weight:bold;

    background:#eef5f1;

    color:var(--green);
}

.status.pending{

    background:#fff5df;

    color:#b47700;
}

.status.cancelled{

    background:#ffeded;

    color:#d13b3b;
}

.status.completed{

    background:#e9f7ef;

    color:#087f3f;
}

/* =========================================================
   QUICK ACTIONS
========================================================= */

.quick-grid{

    padding:20px;

    display:grid;

    grid-template-columns:
        repeat(2,1fr);

    gap:11px;
}

.quick{

    text-decoration:none;

    color:var(--text);

    background:#fafcfa;

    border:
        1px solid var(--border);

    border-radius:15px;

    padding:17px 13px;

    text-align:center;

    transition:.2s;
}

.quick:hover{

    background:
        var(--green-light);

    border-color:
        #c9e7d5;

    color:var(--green);

    transform:translateY(-2px);
}

.quick-icon{

    font-size:23px;

    margin-bottom:7px;
}

.quick-title{

    font-size:11px;

    font-weight:bold;
}

/* =========================================================
   PRODUCTS
========================================================= */

.products{

    display:grid;

    grid-template-columns:
        repeat(3,1fr);

    gap:14px;

    padding:20px;
}

.product{

    border:
        1px solid var(--border);

    border-radius:16px;

    overflow:hidden;

    background:#fff;

    transition:.2s;
}

.product:hover{

    transform:translateY(-3px);

    box-shadow:
        0 10px 25px rgba(0,0,0,.06);
}

.product-image{

    height:125px;

    background:#f4f7f5;

    display:flex;

    align-items:center;
    justify-content:center;

    overflow:hidden;
}

.product-image img{

    width:100%;
    height:100%;

    object-fit:cover;
}

.product-placeholder{

    font-size:40px;
}

.product-body{

    padding:12px;
}

.product-name{

    font-size:12px;

    font-weight:bold;

    white-space:nowrap;

    overflow:hidden;

    text-overflow:ellipsis;
}

.product-price{

    color:var(--green);

    font-weight:900;

    font-size:13px;

    margin-top:6px;
}

.stock{

    font-size:10px;

    color:var(--muted);

    margin-top:5px;
}

.stock.low{

    color:#d37c00;

    font-weight:bold;
}

/* =========================================================
   SALES BOX
========================================================= */

.sales-box{

    padding:20px;
}

.sales-main{

    font-size:31px;

    font-weight:900;

    color:var(--green);

    margin-bottom:5px;
}

.sales-label{

    font-size:11px;

    color:var(--muted);
}

.sales-line{

    height:1px;

    background:var(--border);

    margin:20px 0;
}

.sales-row{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:10px 0;

    font-size:12px;
}

.sales-row span{

    color:var(--muted);
}

.sales-row strong{

    font-size:13px;
}

/* =========================================================
   FOOTER
========================================================= */

.footer{

    text-align:center;

    padding:
        30px 10px;

    color:#91a099;

    font-size:10px;
}

/* =========================================================
   OVERLAY
========================================================= */

.overlay{

    display:none;

    position:fixed;

    inset:0;

    background:
        rgba(0,0,0,.45);

    z-index:900;
}

/* =========================================================
   MOBILE
========================================================= */

@media(max-width:1100px){

    .stats{

        grid-template-columns:
            repeat(2,1fr);
    }

    .dashboard-grid{

        grid-template-columns:1fr;
    }

}

@media(max-width:800px){

    .sidebar{

        transform:
            translateX(100%);

        width:280px;
    }

    .sidebar.open{

        transform:
            translateX(0);
    }

    .main{

        margin-right:0;
    }

    .mobile-menu{

        display:block;
    }

    .overlay.open{

        display:block;
    }

    .topbar{

        padding:
            0 15px;
    }

    .content{

        padding:17px;
    }

    .welcome{

        padding:22px;

        align-items:flex-start;

        flex-direction:column;
    }

    .welcome h2{

        font-size:22px;
    }

    .welcome-badge{

        width:100%;
    }

}

@media(max-width:560px){

    .stats{

        grid-template-columns:1fr;
    }

    .products{

        grid-template-columns:
            repeat(2,1fr);

        padding:13px;
    }

    .top-title p{

        display:none;
    }

    .top-title h1{

        font-size:16px;
    }

    .top-button{

        width:38px;
        height:38px;
    }

    .welcome{

        border-radius:18px;
    }

    .stat{

        padding:18px;
    }

}

</style>

</head>

<body>

<div class="app">

<!-- =====================================================
     SIDEBAR
====================================================== -->

<aside class="sidebar" id="sidebar">

    <div class="brand">

        <div class="brand-logo">
            ب
        </div>

        <div class="brand-text">

            <strong>مول البركة</strong>

            <span>
                Al Baraka Mall
            </span>

        </div>

    </div>

    <div class="profile">

        <div class="profile-top">

            <div class="avatar">
                <?= e(mb_substr($adminName,0,1,'UTF-8')) ?>
            </div>

            <div>

                <div class="profile-name">
                    <?= e($adminName) ?>
                </div>

                <div class="profile-role">
                    <?= e($adminRole) ?> • متصل الآن
                </div>

            </div>

        </div>

    </div>

    <div class="menu-title">
        الرئيسية
    </div
