<?php
declare(strict_types=1);
session_start();

/* =========================================================
   حماية لوحة الإدارة
   ========================================================= */
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$adminName = $_SESSION['admin_name'] ?? 'مدير مول البركة';
$adminRole = $_SESSION['admin_role'] ?? 'manager';

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="theme-color" content="#0b7f3f">
<meta name="robots" content="noindex,nofollow">

<title>لوحة تحكم مول البركة</title>

<style>

/* =========================================================
   RESET
   ========================================================= */

*{
    box-sizing:border-box;
    margin:0;
    padding:0;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:
        Tahoma,
        Arial,
        "Segoe UI",
        sans-serif;

    background:#f5f7f9;
    color:#17212b;
    min-height:100vh;
}

a{
    text-decoration:none;
    color:inherit;
}

button{
    font-family:inherit;
    border:0;
    cursor:pointer;
}

/* =========================================================
   VARIABLES
   ========================================================= */

:root{
    --green:#087f3f;
    --green-dark:#056331;
    --green-light:#e9f8ef;

    --orange:#f59e0b;
    --red:#dc2626;
    --blue:#2563eb;
    --purple:#7c3aed;

    --dark:#111827;
    --dark2:#1f2937;

    --text:#17212b;
    --muted:#718096;

    --white:#ffffff;
    --border:#e5e7eb;

    --shadow:
        0 10px 30px rgba(15,23,42,.07);

    --shadow-hover:
        0 18px 45px rgba(15,23,42,.13);

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
            #063f27 0%,
            #075d35 45%,
            #087f3f 100%
        );

    color:white;
    position:fixed;
    right:0;
    top:0;
    bottom:0;
    z-index:1000;

    display:flex;
    flex-direction:column;

    transition:.3s ease;

    box-shadow:
        -10px 0 35px rgba(0,0,0,.10);
}

.brand{
    padding:25px 22px 20px;
    border-bottom:1px solid rgba(255,255,255,.12);
}

.brand-logo{
    display:flex;
    align-items:center;
    gap:13px;
}

.brand-icon{
    width:52px;
    height:52px;

    background:white;
    color:var(--green);

    border-radius:16px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:27px;
    box-shadow:0 8px 25px rgba(0,0,0,.15);
}

.brand-title{
    font-size:20px;
    font-weight:900;
}

.brand-sub{
    font-size:11px;
    opacity:.65;
    margin-top:4px;
}

.sidebar-content{
    padding:18px 13px;
    overflow-y:auto;
    flex:1;
}

.menu-title{
    color:rgba(255,255,255,.45);
    font-size:11px;
    font-weight:bold;
    padding:15px 14px 8px;
}

.menu{
    list-style:none;
}

.menu li{
    margin:4px 0;
}

.menu a{
    display:flex;
    align-items:center;
    gap:12px;

    padding:13px 15px;

    border-radius:13px;

    color:rgba(255,255,255,.82);

    font-size:14px;
    font-weight:700;

    transition:.2s;
}

.menu a:hover{
    background:rgba(255,255,255,.11);
    color:white;
    transform:translateX(-3px);
}

.menu a.active{
    background:white;
    color:var(--green);

    box-shadow:
        0 8px 20px rgba(0,0,0,.12);
}

.menu-icon{
    width:27px;
    height:27px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:18px;
}

.badge{
    margin-right:auto;

    min-width:23px;
    height:23px;

    padding:0 6px;

    border-radius:20px;

    background:#ef4444;
    color:white;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:10px;
}

.sidebar-footer{
    padding:15px;
    border-top:1px solid rgba(255,255,255,.1);
}

.admin-mini{
    display:flex;
    align-items:center;
    gap:10px;
}

.admin-avatar{
    width:40px;
    height:40px;

    border-radius:13px;

    background:rgba(255,255,255,.15);

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:18px;
}

.admin-name{
    font-size:12px;
    font-weight:bold;
}

.admin-role{
    font-size:10px;
    opacity:.6;
    margin-top:3px;
}

/* =========================================================
   MAIN
   ========================================================= */

.main{
    width:calc(100% - 270px);
    margin-right:270px;
    min-height:100vh;
}

/* =========================================================
   TOPBAR
   ========================================================= */

.topbar{
    height:78px;

    background:white;

    border-bottom:1px solid var(--border);

    display:flex;
    align-items:center;

    justify-content:space-between;

    padding:0 28px;

    position:sticky;
    top:0;

    z-index:900;
}

.top-left{
    display:flex;
    align-items:center;
    gap:14px;
}

.mobile-menu{
    display:none;

    width:42px;
    height:42px;

    border-radius:12px;

    background:#f3f4f6;

    font-size:20px;
}

.search{
    width:320px;

    height:43px;

    background:#f6f7f9;

    border:1px solid #edf0f2;

    border-radius:13px;

    display:flex;
    align-items:center;

    padding:0 14px;

    gap:10px;

    color:#9ca3af;
}

.search input{
    width:100%;
    border:0;
    outline:0;
    background:transparent;

    font-family:inherit;
}

.top-actions{
    display:flex;
    align-items:center;
    gap:10px;
}

.icon-btn{
    width:43px;
    height:43px;

    border-radius:13px;

    background:#f5f7f9;

    display:flex;
    align-items:center;
    justify-content:center;

    position:relative;

    font-size:18px;
}

.notification-dot{
    position:absolute;

    top:8px;
    left:8px;

    width:8px;
    height:8px;

    border-radius:50%;

    background:#ef4444;

    border:2px solid white;
}

.view-store{
    background:var(--green);
    color:white;

    padding:12px 17px;

    border-radius:12px;

    font-size:12px;
    font-weight:bold;
}

/* =========================================================
   CONTENT
   ========================================================= */

.content{
    padding:28px;
    max-width:1600px;
    margin:auto;
}

/* =========================================================
   WELCOME
   ========================================================= */

.welcome{
    background:
        linear-gradient(
            120deg,
            #063f27,
            #087f3f 55%,
            #10a85b
        );

    color:white;

    border-radius:25px;

    padding:28px 30px;

    min-height:190px;

    position:relative;
    overflow:hidden;

    box-shadow:
        0 15px 40px rgba(8,127,63,.18);

    margin-bottom:25px;
}

.welcome:before{
    content:"";

    position:absolute;

    width:280px;
    height:280px;

    border-radius:50%;

    background:rgba(255,255,255,.07);

    left:-80px;
    top:-110px;
}

.welcome:after{
    content:"";

    position:absolute;

    width:200px;
    height:200px;

    border-radius:50%;

    background:rgba(255,255,255,.05);

    left:170px;
    bottom:-130px;
}

.welcome-content{
    position:relative;
    z-index:2;
}

.welcome-small{
    font-size:13px;
    opacity:.8;
    margin-bottom:8px;
}

.welcome h1{
    font-size:30px;
    margin-bottom:9px;
}

.welcome p{
    font-size:14px;
    opacity:.82;
}

.welcome-date{
    margin-top:20px;

    display:inline-flex;
    align-items:center;

    gap:8px;

    background:rgba(255,255,255,.12);

    padding:9px 14px;

    border-radius:12px;

    font-size:11px;
}

/* =========================================================
   SECTION HEADER
   ========================================================= */

.section-header{
    display:flex;
    align-items:center;
    justify-content:space-between;

    margin:28px 0 15px;
}

.section-title{
    font-size:19px;
    font-weight:900;
}

.section-sub{
    color:var(--muted);
    font-size:11px;
    margin-top:5px;
}

.link{
    color:var(--green);
    font-size:12px;
    font-weight:bold;
}

/* =========================================================
   STATS
   ========================================================= */

.stats{
    display:grid;

    grid-template-columns:
        repeat(4,1fr);

    gap:17px;
}

.stat{
    background:white;

    border:1px solid var(--border);

    border-radius:20px;

    padding:20px;

    box-shadow:var(--shadow);

    transition:.25s;

    position:relative;
    overflow:hidden;
}

.stat:hover{
    transform:translateY(-4px);
    box-shadow:var(--shadow-hover);
}

.stat-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.stat-icon{
    width:48px;
    height:48px;

    border-radius:15px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:22px;
}

.green{
    background:#e8f8ef;
    color:#087f3f;
}

.blue{
    background:#eaf1ff;
    color:#2563eb;
}

.orange{
    background:#fff5df;
    color:#d97706;
}

.purple{
    background:#f1eaff;
    color:#7c3aed;
}

.stat-change{
    font-size:10px;
    font-weight:bold;
    color:#16a34a;
}

.stat-number{
    font-size:28px;
    font-weight:900;
    margin-top:17px;
}

.stat-label{
    color:var(--muted);
    font-size:12px;
    margin-top:5px;
}

/* =========================================================
   QUICK ACTIONS
   ========================================================= */

.quick-grid{
    display:grid;

    grid-template-columns:
        repeat(6,1fr);

    gap:13px;
}

.quick{
    background:white;

    border:1px solid var(--border);

    border-radius:17px;

    padding:18px 10px;

    text-align:center;

    box-shadow:var(--shadow);

    transition:.2s;
}

.quick:hover{
    transform:translateY(-4px);
    border-color:#ccebd9;
    box-shadow:var(--shadow-hover);
}

.quick-icon{
    width:44px;
    height:44px;

    margin:0 auto 10px;

    border-radius:14px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:var(--green-light);

    color:var(--green);

    font-size:20px;
}

.quick span{
    display:block;

    font-size:11px;
    font-weight:bold;
}

/* =========================================================
   DASHBOARD GRID
   ========================================================= */

.dashboard-grid{
    display:grid;

    grid-template-columns:
        minmax(0,1.7fr)
        minmax(300px,1fr);

    gap:20px;

    margin-top:20px;
}

/* =========================================================
   CARD
   ========================================================= */

.card{
    background:white;

    border:1px solid var(--border);

    border-radius:20px;

    box-shadow:var(--shadow);

    overflow:hidden;
}

.card-header{
    padding:19px 20px;

    border-bottom:1px solid #f0f2f4;

    display:flex;
    justify-content:space-between;
    align-items:center;
}

.card-title{
    font-size:15px;
    font-weight:900;
}

.card-body{
    padding:20px;
}

/* =========================================================
   ORDERS
   ========================================================= */

.orders{
    width:100%;
    border-collapse:collapse;
}

.orders th{
    text-align:right;

    color:#9aa3af;

    font-size:10px;
    font-weight:bold;

    padding:10px;

    background:#fafbfc;
}

.orders td{
    padding:13px 10px;

    border-top:1px solid #f0f2f4;

    font-size:11px;
}

.order-id{
    color:var(--green);
    font-weight:900;
}

.customer{
    font-weight:bold;
}

.status{
    display:inline-flex;

    padding:6px 9px;

    border-radius:20px;

    font-size:9px;

    font-weight:bold;
}

.pending{
    background:#fff5df;
    color:#b45309;
}

.completed{
    background:#e8f8ef;
    color:#087f3f;
}

.cancelled{
    background:#feecec;
    color:#dc2626;
}

/* =========================================================
   ACTIVITY
   ========================================================= */

.activity{
    display:flex;
    flex-direction:column;
}

.activity-item{
    display:flex;

    gap:12px;

    padding:14px 0;

    border-bottom:1px solid #f0f2f4;
}

.activity-item:last-child{
    border-bottom:0;
}

.activity-icon{
    width:38px;
    height:38px;

    border-radius:12px;

    background:var(--green-light);

    display:flex;
    align-items:center;
    justify-content:center;

    color:var(--green);

    flex-shrink:0;
}

.activity-text{
    font-size:11px;
    line-height:1.7;
}

.activity-time{
    color:#9ca3af;
    font-size:9px;
    margin-top:3px;
}

/* =========================================================
   PERFORMANCE
   ========================================================= */

.performance{
    margin-top:20px;
}

.performance-row{
    margin-bottom:18px;
}

.performance-info{
    display:flex;
    justify-content:space-between;

    margin-bottom:7px;

    font-size:11px;
}

.progress{
    height:8px;

    background:#eef1f3;

    border-radius:20px;

    overflow:hidden;
}

.progress-bar{
    height:100%;

    border-radius:20px;

    background:
        linear-gradient(
            90deg,
            #087f3f,
            #17ad61
        );
}

/* =========================================================
   FOOTER
   ========================================================= */

.footer{
    text-align:center;

    padding:30px 0 15px;

    color:#9ca3af;

    font-size:10px;
}

/* =========================================================
   MOBILE
   ========================================================= */

@media(max-width:1100px){

    .stats{
        grid-template-columns:
            repeat(2,1fr);
    }

    .quick-grid{
        grid-template-columns:
            repeat(3,1fr);
    }

}

@media(max-width:800px){

    .sidebar{
        transform:translateX(100%);
    }

    .sidebar.open{
        transform:translateX(0);
    }

    .main{
        width:100%;
        margin-right:0;
    }

    .mobile-menu{
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .search{
        display:none;
    }

    .view-store{
        display:none;
    }

    .topbar{
        padding:0 15px;
    }

    .content{
        padding:15px;
    }

    .dashboard-grid{
        grid-template-columns:1fr;
    }

}

@media(max-width:520px){

    .stats{
        grid-template-columns:
            1fr 1fr;

        gap:10px;
    }

    .stat{
        padding:15px;
    }

    .stat-number{
        font-size:23px;
    }

    .quick-grid{
        grid-template-columns:
            repeat(2,1fr);
    }

    .welcome{
        padding:23px;
        min-height:175px;
    }

    .welcome h1{
        font-size:24px;
    }

    .section-title{
        font-size:17px;
    }

    .orders{
        min-width:620px;
    }

    .table-scroll{
        overflow-x:auto;
    }

}

</style>
</head>

<body>

<div class="app">

<!-- =====================================================
     SIDEBAR
     ===================================================== -->

<aside class="sidebar" id="sidebar">

    <div class="brand">

        <div class="brand-logo">

            <div class="brand-icon">
                🛒
            </div>

            <div>
                <div class="brand-title">
                    مول البركة
                </div>

                <div class="brand-sub">
                    نظام إدارة المتجر
                </div>
            </div>

        </div>

    </div>


    <div class="sidebar-content">

        <div class="menu-title">
            الرئيسية
        </div>

        <ul class="menu">

            <li>
                <a href="index.php" class="active">
                    <span class="menu-icon">📊</span>
                    لوحة التحكم
                </a>
            </li>

        </ul>


        <div class="menu-title">
            إدارة المتجر
        </div>

        <ul class="menu">

            <li>
                <a href="orders.php">
                    <span class="menu-icon">🛍️</span>
                    الطلبات
                    <span class="badge">5</span>
                </a>
            </li>

            <li>
                <a href="products.php">
                    <span class="menu-icon">📦</span>
                    المنتجات
                </a>
            </li>

            <li>
                <a href="categories.php">
                    <span class="menu-icon">🗂️</span>
                    الأقسام
                </a>
            </li>

            <li>
                <a href="customers.php">
                    <span class="menu-icon">👥</span>
                    العملاء
                </a>
            </li>

            <li>
                <a href="offers.html">
                    <span class="menu-icon">🏷️</span>
                    العروض
                </a>
            </li>

            <li>
                <a href="inventory.html">
                    <span class="menu-icon">📊</span>
                    المخزون
                </a>
            </li>

        </ul>


        <div class="menu-title">
            التقارير
        </div>

        <ul class="menu">

            <li>
                <a href="reports.html">
                    <span class="menu-icon">📈</span>
                    التقارير
                </a>
            </li>

        </ul>


        <div class="menu-title">
            النظام
        </div>

        <ul class="menu">

            <li>
                <a href="settings.html">
                    <span class="menu-icon">⚙️</span>
                    الإعدادات
                </a>
            </li>

            <li>
                <a href="../index.html" target="_blank">
                    <span class="menu-icon">🌐</span>
                    زيارة المتجر
                </a>
            </li>

            <li>
                <a href="logout.php">
                    <span class="menu-icon">🚪</span>
                    تسجيل الخروج
                </a>
            </li>

        </ul>

    </div>


    <div class="sidebar-footer">

        <div class="admin-mini">

            <div class="admin-avatar">
                👤
            </div>

            <div>

                <div class="admin-name">
                    <?= e($adminName) ?>
                </div>

                <div class="admin-role">
                    <?= e($adminRole) ?>
                </div>

            </div>

        </div>

    </div>

</aside>


<!-- =====================================================
     MAIN
     ===================================================== -->

<main class="main">


<!-- TOPBAR -->

<header class="topbar">

    <div class="top-left">

        <button
            class="mobile-menu"
            onclick="toggleSidebar()">
            ☰
        </button>

        <div class="search">

            🔎

            <input
                type="search"
                placeholder="ابحث في لوحة التحكم...">

        </div>

    </div>


    <div class="top-actions">

        <a
            href="../index.html"
            target="_blank"
            class="view-store">
            🌐 زيارة المتجر
        </a>

        <button class="icon-btn">
            🔔
            <span class="notification-dot"></span>
        </button>

        <div class="icon-btn">
            👤
        </div>

    </div>

</header>


<!-- CONTENT -->

<section class="content">


<!-- WELCOME -->

<div class="welcome">

    <div class="welcome-content">

        <div class="welcome-small">
            لوحة الإدارة الرئيسية
        </div>

        <h1>
            أهلاً بك في مول البركة 👋
        </h1>

        <p>
            تحكم كامل في المبيعات والطلبات والمنتجات والعملاء والمخزون من مكان واحد.
        </p>

        <div class="welcome-date">
            📅
            <span id="today"></span>
        </div>

    </div>

</div>


<!-- STATS -->

<div class="section-header">

    <div>
        <div class="section-title">
            نظرة عامة
        </div>

        <div class="section-sub">
            ملخص أداء المتجر
        </div>
    </div>

</div>


<div class="stats">

    <div class="stat">

        <div class="stat-top">

            <div class="stat-icon green">
                💰
            </div>

            <div class="stat-change">
                ↑ 12.5%
            </div>

        </div>

        <div class="stat-number">
            0 ج.م
        </div>

        <div class="stat-label">
            إجمالي المبيعات
        </div>

    </div>


    <div class="stat">

        <div class="stat-top">

            <div class="stat-icon blue">
                🛍️
            </div>

            <div class="stat-change">
                ↑ 8.2%
            </div>

        </div>

        <div class="stat-number">
            0
        </div>

        <div class="stat-label">
            إجمالي الطلبات
        </div>

    </div>


    <div class="stat">

        <div class="stat-top">

            <div class="stat-icon orange">
                📦
            </div>

            <div class="stat-change">
                متاح
            </div>

        </div>

        <div class="stat-number">
            0
        </div>

        <div class="stat-label">
            المنتجات
        </div>

    </div>


    <div class="stat">

        <div class="stat-top">

            <div class="stat-icon purple">
                👥
            </div>

            <div class="stat-change">
                جديد
            </div>

        </div>

        <div class="stat-number">
            0
        </div>

        <div class="stat-label">
            العملاء
        </div>

    </div>

</div>


<!-- QUICK ACTIONS -->

<div class="section-header">

    <div>
        <div class="section-title">
            الوصول السريع
        </div>

        <div class="section-sub">
            أهم أدوات الإدارة
        </div>
    </div>

</div>


<div class="quick-grid">

    <a href="orders.php" class="quick">

        <div class="quick-icon">
            🛍️
        </div>

        <span>
            الطلبات
        </span>

    </a>


    <a href="products.php" class="quick">

        <div class="quick-icon">
            📦
        </div>

        <span>
            المنتجات
        </span>

    </a>


    <a href="categories.php" class="quick">

        <div class="quick-icon">
            🗂️
        </div>

        <span>
            الأقسام
        </span>

    </a>


    <a href="customers.php" class="quick">

        <div class="quick-icon">
            👥
        </div>

        <span>
            العملاء
        </span>

    </a>


    <a href="offers.html" class="quick">

        <div class="quick-icon">
            🏷️
        </div>

        <span>
            العروض
        </span>

    </a>


    <a href="settings.html" class="quick">

        <div class="quick-icon">
            ⚙️
        </div>

        <span>
            الإعدادات
        </span>

    </a>

</div>


<!-- DASHBOARD -->

<div class="dashboard-grid">


<!-- ORDERS -->

<div class="card">

    <div class="card-header">

        <div>

            <div class="card-title">
                أحدث الطلبات
            </div>

            <div class="section-sub">
                آخر العمليات على المتجر
            </div>

        </div>

        <a
            href="orders.php"
            class="link">
            عرض الكل
        </a>

    </div>


    <div class="card-body">

        <div class="table-scroll">

            <table class="orders">

                <thead>

                <tr>

                    <th>
                        رقم الطلب
                    </th>

                    <th>
                        العميل
                    </th>

                    <th>
                        الإجمالي
                    </th>

                    <th>
                        الحالة
                    </th>

                </tr>

                </thead>


                <tbody>

                <tr>

                    <td class="order-id">
                        #1001
                    </td>

                    <td class="customer">
                        لا توجد طلبات
                    </td>

                    <td>
                        0 ج.م
                    </td>

                    <td>
                        <span class="status pending">
                            انتظار
                        </span>
                    </td>

                </tr>


                <tr>

                    <td class="order-id">
                        #1000
                    </td>

                    <td>
                        —
                    </td>

                    <td>
                        0 ج.م
                    </td>

                    <td>
                        <span class="status completed">
                            مكتمل
                        </span>
                    </td>

                </tr>


                </tbody>

            </table>

        </div>

    </div>

</div>


<!-- ACTIVITY -->

<div class="card">

    <div class="card-header">

        <div class="card-title">
            آخر النشاطات
        </div>

        <span>
            🔔
        </span>

    </div>


    <div class="card-body">

        <div class="activity">


            <div class="activity-item">

                <div class="activity-icon">
                    🛒
                </div>

                <div class="activity-text">

                    <strong>
                        لوحة التحكم جاهزة
                    </strong>

                    <div>
                        تم تشغيل نظام إدارة مول البركة.
                    </div>

                    <div class="activity-time">
                        الآن
                    </div>

                </div>

            </div>


            <div class="activity-item">

                <div class="
