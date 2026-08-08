<?php
/*
|--------------------------------------------------------------------------
| مول البركة - المتجر
|--------------------------------------------------------------------------
*/

$products = [

    [
        'id'=>1,
        'name'=>'طماطم بلدي',
        'category'=>'خضروات',
        'price'=>18,
        'unit'=>'كجم',
        'emoji'=>'🍅'
    ],

    [
        'id'=>2,
        'name'=>'بطاطس',
        'category'=>'خضروات',
        'price'=>22,
        'unit'=>'كجم',
        'emoji'=>'🥔'
    ],

    [
        'id'=>3,
        'name'=>'خيار',
        'category'=>'خضروات',
        'price'=>25,
        'unit'=>'كجم',
        'emoji'=>'🥒'
    ],

    [
        'id'=>4,
        'name'=>'فلفل أخضر',
        'category'=>'خضروات',
        'price'=>35,
        'unit'=>'كجم',
        'emoji'=>'🫑'
    ],

    [
        'id'=>5,
        'name'=>'تفاح طازج',
        'category'=>'فواكه',
        'price'=>55,
        'unit'=>'كجم',
        'emoji'=>'🍎'
    ],

    [
        'id'=>6,
        'name'=>'موز',
        'category'=>'فواكه',
        'price'=>30,
        'unit'=>'كجم',
        'emoji'=>'🍌'
    ],

    [
        'id'=>7,
        'name'=>'برتقال',
        'category'=>'فواكه',
        'price'=>32,
        'unit'=>'كجم',
        'emoji'=>'🍊'
    ],

    [
        'id'=>8,
        'name'=>'فراولة',
        'category'=>'فواكه',
        'price'=>65,
        'unit'=>'كجم',
        'emoji'=>'🍓'
    ],

    [
        'id'=>9,
        'name'=>'لحم بقري',
        'category'=>'لحوم',
        'price'=>420,
        'unit'=>'كجم',
        'emoji'=>'🥩'
    ],

    [
        'id'=>10,
        'name'=>'لحم مفروم',
        'category'=>'لحوم',
        'price'=>390,
        'unit'=>'كجم',
        'emoji'=>'🥩'
    ],

    [
        'id'=>11,
        'name'=>'فراخ كاملة',
        'category'=>'طيور',
        'price'=>125,
        'unit'=>'كجم',
        'emoji'=>'🐔'
    ],

    [
        'id'=>12,
        'name'=>'صدور فراخ',
        'category'=>'طيور',
        'price'=>145,
        'unit'=>'كجم',
        'emoji'=>'🍗'
    ],

    [
        'id'=>13,
        'name'=>'بيض',
        'category'=>'ماركت',
        'price'=>85,
        'unit'=>'طبق',
        'emoji'=>'🥚'
    ],

    [
        'id'=>14,
        'name'=>'أرز',
        'category'=>'ماركت',
        'price'=>35,
        'unit'=>'كجم',
        'emoji'=>'🍚'
    ],

    [
        'id'=>15,
        'name'=>'سكر',
        'category'=>'ماركت',
        'price'=>30,
        'unit'=>'كجم',
        'emoji'=>'🧂'
    ],

    [
        'id'=>16,
        'name'=>'زيت طعام',
        'category'=>'ماركت',
        'price'=>75,
        'unit'=>'زجاجة',
        'emoji'=>'🫗'
    ]

];

?>

<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

<title>
مول البركة | المتجر
</title>


<style>

/* =====================================================
   RESET
===================================================== */

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

    background:#f5f7f6;

    color:#202820;

    line-height:1.7;
}

button,
input{
    font-family:inherit;
}

button{
    cursor:pointer;
}

a{
    text-decoration:none;
    color:inherit;
}


/* =====================================================
   TOP BAR
===================================================== */

.topbar{
    background:#087f45;
    color:#fff;
    padding:8px 15px;
    font-size:12px;
}

.topbar-inner{
    max-width:1200px;
    margin:auto;

    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:10px;
}


/* =====================================================
   HEADER
===================================================== */

.header{
    background:#fff;

    position:sticky;
    top:0;

    z-index:1000;

    border-bottom:1px solid #e2e7e3;

    box-shadow:
        0 3px 15px rgba(0,0,0,.05);
}

.header-inner{
    max-width:1200px;
    margin:auto;

    padding:12px 15px;

    display:flex;
    align-items:center;

    gap:15px;
}


/* LOGO */

.logo{
    display:flex;
    align-items:center;
    gap:9px;

    min-width:180px;
}

.logo-icon{
    width:48px;
    height:48px;

    border-radius:14px;

    background:#087f45;

    color:#fff;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:25px;
}

.logo-text strong{
    display:block;

    color:#087f45;

    font-size:21px;
}

.logo-text span{
    display:block;

    color:#7b857f;

    font-size:10px;
}


/* SEARCH */

.search{
    flex:1;

    height:46px;

    display:flex;

    border:2px solid #087f45;

    border-radius:11px;

    overflow:hidden;

    background:#fff;
}

.search input{
    width:100%;

    border:0;

    outline:0;

    padding:0 14px;

    font-size:13px;
}

.search button{
    width:55px;

    border:0;

    background:#087f45;

    color:#fff;

    font-size:19px;
}


/* CART BUTTON */

.cart-button{
    position:relative;

    border:0;

    background:#eaf6ef;

    color:#087f45;

    border-radius:12px;

    padding:11px 15px;

    font-weight:bold;

    white-space:nowrap;
}

.cart-count{
    position:absolute;

    top:-8px;

    left:-7px;

    min-width:24px;

    height:24px;

    padding:0 5px;

    border-radius:50%;

    background:#f2a900;

    color:#fff;

    display:flex;

    align-items:center;
    justify-content:center;

    font-size:11px;

    font-weight:bold;
}


/* =====================================================
   NAVIGATION
===================================================== */

.nav{
    background:#075d3a;

    color:#fff;
}

.nav-inner{
    max-width:1200px;
    margin:auto;

    display:flex;

    overflow-x:auto;
}

.nav button{
    border:0;

    background:transparent;

    color:#fff;

    padding:12px 18px;

    white-space:nowrap;

    font-weight:bold;

    font-size:12px;
}

.nav button:hover,
.nav button.active{
    background:#064c30;
}


/* =====================================================
   MAIN
===================================================== */

.container{
    max-width:1200px;

    margin:auto;

    padding:20px 15px 50px;
}


/* =====================================================
   HERO
===================================================== */

.hero{
    background:
        linear-gradient(
            120deg,
            #e7f8ee,
            #fff7dc
        );

    border-radius:24px;

    padding:38px;

    min-height:280px;

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:20px;

    overflow:hidden;
}

.hero-text{
    max-width:650px;
}

.hero-badge{
    display:inline-block;

    background:#fff;

    color:#087f45;

    padding:7px 14px;

    border-radius:20px;

    font-weight:bold;

    margin-bottom:10px;

    font-size:12px;
}

.hero h1{
    color:#087f45;

    font-size:38px;

    line-height:1.4;

    margin-bottom:8px;
}

.hero p{
    color:#69736d;

    font-size:15px;

    margin-bottom:18px;
}

.hero-button{
    border:0;

    background:#087f45;

    color:#fff;

    padding:12px 22px;

    border-radius:11px;

    font-weight:bold;
}

.hero-art{
   
