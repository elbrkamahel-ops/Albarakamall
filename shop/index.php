<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>متجر مول البركة | تسوق الآن</title>

<meta name="description"
content="متجر مول البركة للخضروات والفاكهة واللحوم والدواجن والماركت">

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
    font-family:Tahoma,Arial,sans-serif;
    background:#f5f7f6;
    color:#202522;
    line-height:1.7;
}

button,
input,
select{
    font-family:inherit;
}

a{
    text-decoration:none;
    color:inherit;
}

.container{
    width:min(1200px,calc(100% - 30px));
    margin:auto;
}

/* TOP */

.top{
    background:#eef5f1;
    border-bottom:1px solid #dfe8e2;
    color:#526159;
    font-size:12px;
}

.top-inner{
    min-height:38px;
    display:flex;
    align-items:center;
    justify-content:space-between;
}

/* HEADER */

.header{
    background:#fff;
}

.header-inner{
    min-height:92px;
    display:flex;
    align-items:center;
    gap:18px;
}

.logo{
    min-width:205px;
    display:flex;
    align-items:center;
    gap:10px;
}

.logo-box{
    width:58px;
    height:58px;
    border-radius:16px;
    background:#087b45;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    font-size:14px;
}

.logo-text strong{
    display:block;
    color:#087b45;
    font-size:22px;
}

.logo-text small{
    display:block;
    color:#7c8781;
    font-size:10px;
}

.search{
    flex:1;
    height:48px;
    display:flex;
    border:2px solid #087b45;
    border-radius:10px;
    overflow:hidden;
    background:#fff;
}

.search input{
    width:100%;
    border:0;
    outline:0;
    padding:0 15px;
    font-size:13px;
}

.search button{
    width:55px;
    border:0;
    background:#087b45;
    color:#fff;
    font-size:18px;
    cursor:pointer;
}

.header-action{
    display:flex;
    align-items:center;
    gap:7px;
    white-space:nowrap;
}

.action-icon{
    width:44px;
    height:44px;
    border-radius:50%;
    background:#eaf6ef;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
}

.action-text small{
    display:block;
    color:#89938e;
    font-size:9px;
}

.action-text strong{
    display:block;
    font-size:11px;
}

.cart{
    position:relative;
}

.cart-count{
    position:absolute;
    top:-7px;
    right:-6px;
    width:21px;
    height:21px;
    border-radius:50%;
    background:#f0a800;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:10px;
}

/* NAV */

.nav{
    background:#087b45;
    color:#fff;
}

.nav-inner{
    display:flex;
    overflow-x:auto;
    scrollbar-width:none;
}

.nav-inner::-webkit-scrollbar{
    display:none;
}

.nav a{
    min-height:50px;
    padding:0 18px;
    display:flex;
    align-items:center;
    justify-content:center;
    white-space:nowrap;
    font-size:12px;
    font-weight:bold;
}

.nav a:hover,
.nav a.active{
    background:#056337;
}

/* PAGE TITLE */

.page-title{
    margin-top:22px;
    background:linear-gradient(120deg,#eaf8ef,#fff);
    border-radius:20px;
    padding:30px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    overflow:hidden;
}

.page-title small{
    color:#087b45;
    font-size:11px;
    font-weight:bold;
}

.page-title h1{
    font-size:34px;
    margin:5px 0;
}

.page-title h1 span{
    color:#087b45;
}

.page-title p{
    color:#6d7972;
    font-size:12px;
}

.title-icon{
    font-size:85px;
}

/* TOOLBAR */

.toolbar{
    margin-top:20px;
    background:#fff;
    border:1px solid #e1e8e3;
    border-radius:14px;
    padding:14px;
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

.toolbar-title{
    font-weight:bold;
    font-size:13px;
}

.categories-filter{
    display:flex;
    gap:7px;
    flex-wrap:wrap;
}

.filter-btn{
    border:1px solid #dce6df;
    background:#fff;
    color:#506059;
    border-radius:20px;
    padding:7px 13px;
    font-size:10px;
    cursor:pointer;
}

.filter-btn:hover,
.filter-btn.active{
    background:#087b45;
    color:#fff;
    border-color:#087b45;
}

.sort{
    margin-right:auto;
    border:1px solid #dce6df;
    background:#fff;
    border-radius:8px;
    padding:8px 12px;
    font-size:10px;
    outline:0;
}

/* STORE */

.store-layout{
    margin-top:20px;
    display:grid;
    grid-template-columns:210px 1fr;
    gap:18px;
}

/* SIDEBAR */

.sidebar{
    background:#fff;
    border:1px solid #e1e8e3;
    border-radius:15px;
    padding:15px;
    height:max-content;
    position:sticky;
    top:15px;
}

.sidebar h3{
    font-size:14px;
    margin-bottom:12px;
    color:#087b45;
}

.side-item{
    width:100%;
    border:0;
    background:transparent;
    padding:10px 7px;
    text-align:right;
    border-radius:8px;
    color:#526059;
    cursor:pointer;
    font-size:11px;
}

.side-item:hover,
.side-item.active{
    background:#eaf6ef;
    color:#087b45;
    font-weight:bold;
}

/* PRODUCTS */

.products{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:15px;
}

.product{
    background:#fff;
    border:1px solid #e1e8e3;
    border-radius:15px;
    overflow:hidden;
    transition:.2s;
    position:relative;
}

.product:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 28px rgba(0,0,0,.08);
}

.product-badge{
    position:absolute;
    top:10px;
    right:10px;
    background:#f0a800;
    color:#fff;
    padding:4px 8px;
    border-radius:12px;
    font-size:8px;
    z-index:2;
}

.product-image{
    height:190px;
    background:#f1f7f3;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:78px;
}

.product-info{
    padding:14px;
}

.product-category{
    color:#8a958f;
    font-size:9px;
}

.product h2{
    font-size:14px;
    margin:3px 0 5px;
}

.product-description{
    color:#7a8580;
    font-size:9px;
    min-height:24px;
}

.price-row{
    margin-top:8px;
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.price{
    color:#087b45;
    font-size:19px;
    font-weight:bold;
}

.price small{
    font-size:9px;
    color:#7c8781;
    font-weight:normal;
}

.add-btn{
    width:100%;
    height:40px;
    border:0;
    border-radius:8px;
    margin-top:10px;
    background:#087b45;
    color:#fff;
    cursor:pointer;
    font-size:10px;
    font-weight:bold;
}

.add-btn:hover{
    background:#056337;
}

/* EMPTY */

.empty{
    display:none;
    background:#fff;
    border:1px solid #e1e8e3;
    border-radius:15px;
    padding:50px 20px;
    text-align:center;
    grid-column:1/-1;
}

.empty-icon{
    font-size:50px;
}

.empty h2{
    margin:10px 0 4px;
}

.empty p{
    color:#89938e;
    font-size:11px;
}

/* CART BAR */

.cart-bar{
    position:fixed;
    left:18px;
    bottom:18px;
    z-index:100;
    background:#087b45;
   
