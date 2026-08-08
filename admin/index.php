<?php
declare(strict_types=1);

session_start();

/*
|--------------------------------------------------------------------------
| حماية لوحة الإدارة
|--------------------------------------------------------------------------
*/

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$adminName = $_SESSION['admin_name'] ?? 'مدير مول البركة';
$adminRole = $_SESSION['admin_role'] ?? 'manager';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width,initial-scale=1.0">

<meta name="theme-color"
      content="#087f3f">

<title>لوحة التحكم | مول البركة</title>

<style>

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
        sans-serif;

    background:#f4f7f6;
    color:#17221d;
    min-height:100vh;
}

/* =========================
   SIDEBAR
========================= */

.sidebar{

    position:fixed;

    top:0;
    right:0;

    width:270px;
    height:100vh;

    background:
        linear-gradient(
            180deg,
            #087f3f,
            #056b35
        );

    color:white;

    z-index:1000;

    padding:22px 15px;

    overflow-y:auto;

    box-shadow:
        -8px 0 30px rgba(0,0,0,.12);

    transition:.3s;
}

.brand{

    display:flex;
    align-items:center;

    gap:12px;

    padding:10px 8px 25px;

    border-bottom:
        1px solid rgba(255,255,255,.15);

    margin-bottom:18px;
}

.brand-icon{

    width:50px;
    height:50px;

    border-radius:16px;

    background:white;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:27px;
}

.brand-text h2{

    font-size:19px;
    font-weight:900;
}

.brand-text span{

    display:block;

    font-size:11px;

    opacity:.75;

    margin-top:4px;
}

.menu-title{

    font-size:11px;

    color:rgba(255,255,255,.6);

    padding:
        12px
        12px
        8px;
}

.nav-link{

    display:flex;

    align-items:center;

    gap:13px;

    width:100%;

    padding:13px 14px;

    margin:4px 0;

    color:white;

    text-decoration:none;

    border-radius:13px;

    font-size:14px;

    transition:.2s;
}

.nav-link:hover{

    background:
        rgba(255,255,255,.12);

    transform:translateX(-2px);
}

.nav-link.active{

    background:white;

    color:#087f3f;

    font-weight:900;

    box-shadow:
        0 6px 18px rgba(0,0,0,.12);
}

.nav-icon{

    width:30px;

    text-align:center;

    font-size:19px;
}

.logout{

    margin-top:20px;

    border-top:
        1px solid rgba(255,255,255,.15);

    padding-top:18px;
}

.logout a{

    color:#fff;

    text-decoration:none;

    display:flex;

    align-items:center;

    gap:12px;

    padding:13px;

    border-radius:13px;

    background:
        rgba(180,0,0,.18);
}

.logout a:hover{

    background:
        rgba(180,0,0,.3);
}

/* =========================
   MAIN
========================= */

.main{

    margin-right:270px;

    min-height:100vh;

    transition:.3s;
}

/* =========================
   TOPBAR
========================= */

.topbar{

    height:76px;

    background:white;

    border-bottom:
        1px solid #e8ecea;

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:
        0 28px;

    position:sticky;

    top:0;

    z-index:500;
}

.page-title h1{

    font-size:22px;

    color:#123d2b;

    font-weight:900;
}

.page-title p{

    color:#84918b;

    font-size:12px;

    margin-top:5px;
}

.top-actions{

    display:flex;

    align-items:center;

    gap:12px;
}

.icon-btn{

    width:42px;
    height:42px;

    border:1px solid #e4e9e7;

    background:white;

    border-radius:12px;

    display:flex;
    align-items:center;
    justify-content:center;

    cursor:pointer;

    font-size:18px;

    text-decoration:none;

    color:#333;
}

.icon-btn:hover{

    border-color:#087f3f;

    color:#087f3f;
}

.admin-profile{

    display:flex;

    align-items:center;

    gap:10px;

    padding:
        5px 10px;

    background:#f5f8f6;

    border-radius:14px;
}

.avatar{

    width:38px;
    height:38px;

    border-radius:12px;

    background:#087f3f;

    color:white;

    display:flex;
    align-items:center;
    justify-content:center;

    font-weight:bold;
}

.profile-text strong{

    display:block;

    font-size:13px;
}

.profile-text span{

    display:block;

    font-size:10px;

    color:#839089;

    margin-top:2px;
}

/* =========================
   CONTENT
========================= */

.content{

    padding:28px;

    max-width:1500px;

    margin:auto;
}

/* =========================
   WELCOME
========================= */

.welcome{

    background:
        linear-gradient(
            135deg,
            #087f3f,
            #0b9a4c
        );

    color:white;

    border-radius:22px;

    padding:28px;

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:20px;

    margin-bottom:25px;

    box-shadow:
        0 12px 35px rgba(8,127,63,.18);

    position:relative;

    overflow:hidden;
}

.welcome:after{

    content:"🛒";

    position:absolute;

    left:30px;

    bottom:-25px;

    font-size:120px;

    opacity:.10;
}

.welcome h2{

    font-size:27px;

    margin-bottom:9px;
}

.welcome p{

    font-size:13px;

    opacity:.88;
}

.welcome-date{

    background:
        rgba(255,255,255,.12);

    padding:14px 18px;

    border-radius:15px;

    font-size:13px;

    position:relative;

    z-index:2;
}

/* =========================
   STATISTICS
========================= */

.stats{

    display:grid;

    grid-template-columns:
        repeat(4,1fr);

    gap:18px;

    margin-bottom:25px;
}

.stat-card{

    background:white;

    border-radius:19px;

    padding:21px;

    border:
        1px solid #e9eeeb;

    box-shadow:
        0 5px 20px rgba(0,0,0,.04);

    transition:.2s;
}

.stat-card:hover{

    transform:translateY(-3px);

    box-shadow:
        0 12px 25px rgba(0,0,0,.08);
}

.stat-top{

    display:flex;

    align-items:center;

    justify-content:space-between;

    margin-bottom:17px;
}

.stat-icon{

    width:48px;
    height:48px;

    border-radius:15px;

    display:flex;

    align-items:center;
    justify-content:center;

    font-size:23px;

    background:#eaf8f0;
}

.stat-label{

    color:#78847e;

    font-size:12px;
}

.stat-value{

    font-size:25px;

    font-weight:900;

    color:#183d2c;
}

.stat-note{

    font-size:10px;

    color:#88958f;

    margin-top:7px;
}

/* =========================
   GRID
========================= */

.dashboard-grid{

    display:grid;

    grid-template-columns:
        1.5fr 1fr;

    gap:20px;
}

.card{

    background:white;

    border:
        1px solid #e9eeeb;

    border-radius:20px;

    padding:22px;

    box-shadow:
        0 5px 20px rgba(0,0,0,.04);
}

.card-header{

    display:flex;

    align-items:center;

    justify-content:space-between;

    margin-bottom:20px;
}

.card-header h3{

    font-size:17px;

    color:#183d2c;
}

.card-header a{

    color:#087f3f;

    text-decoration:none;

    font-size:12px;

    font-weight:bold;
}

/* =========================
   QUICK ACTIONS
========================= */

.actions{

    display:grid;

    grid-template-columns:
        repeat(2,1fr);

    gap:12px;
}

.action{

    text-decoration:none;

    color:#183d2c;

    border:
        1px solid #edf0ee;

    border-radius:15px;

    padding:17px;

    display:flex;

    align-items:center;

    gap:12px;

    transition:.2s;

    background:#fbfcfb;
}

.action:hover{

    background:#f0faf4;

    border-color:#b8dfc8;

    transform:translateY(-2px);
}

.action-icon{

    width:44px;
    height:44px;

    border-radius:13px;

    background:#eaf8f0;

    display:flex;

    align-items:center;
    justify-content:center;

    font-size:21px;
}

.action strong{

    display:block;

    font-size:13px;

    margin-bottom:4px;
}

.action span{

    display:block;

    color:#87928d;

    font-size:10px;
}

/* =========================
   STATUS
========================= */

.status-list{

    display:flex;

    flex-direction:column;

    gap:12px;
}

.status-item{

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:13px;

    border-radius:13px;

    background:#f8faf9;
}

.status-right{

    display:flex;

    align-items:center;

    gap:10px;
}

.status-dot{

    width:10px;
    height:10px;

    border-radius:50%;

    background:#21a366;
}

.status-name{

    font-size:12px;

    font-weight:bold;
}

.status-count{

    font-size:13px;

    font-weight:900;

    color:#087f3f;
}

/* =========================
   FOOTER
========================= */

.footer{

    text-align:center;

    padding:30px 10px 15px;

    color:#9aa49f
