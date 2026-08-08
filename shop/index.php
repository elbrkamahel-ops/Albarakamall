<?php
// مول البركة - متجر المنتجات
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>مول البركة | المتجر</title>

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
    color:#222;
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

/* ================= TOP ================= */

.topbar{
    background:#087f4e;
    color:#fff;
    padding:8px 15px;
    font-size:13px;
}

.topbar-inner{
    max-width:1200px;
    margin:auto;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* ================= HEADER ================= */

.header{
    background:#fff;
    border-bottom:1px solid #e5e5e5;
    position:sticky;
    top:0;
    z-index:1000;
}

.header-inner{
    max-width:1200px;
    margin:auto;
    padding:14px 15px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
}

.logo{
    display:flex;
    align-items:center;
    gap:12px;
}

.logo-box{
    width:58px;
    height:58px;
    border-radius:17px;
    background:#087f4e;
    color:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:30px;
    font-weight:bold;
}

.logo h1{
    color:#087f4e;
    font-size:25px;
}

.logo p{
    color:#777;
    font-size:12px;
}

.header-actions{
    display:flex;
    align-items:center;
    gap:10px;
}

.action-btn{
    border:0;
    background:#eef8f2;
    color:#087f4e;
    padding:10px 15px;
    border-radius:12px;
    font-weight:bold;
}

.cart-button{
    position:relative;
}

.cart-count{
    position:absolute;
    top:-9px;
    left:-8px;
    min-width:25px;
    height:25px;
    padding:0 5px;
    background:#f2a900;
    color:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:12px;
    font-weight:bold;
}

/* ================= NAV ================= */

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

.nav a{
    white-space:nowrap;
    padding:13px 18px;
    font-weight:bold;
}

.nav a:hover{
    background:#064d30;
}

/* ================= CONTAINER ================= */

.container{
    max-width:1200px;
    margin:auto;
    padding:25px 15px;
}

/* ================= HERO ================= */

.hero{
    min-height:360px;
    background:linear-gradient(135deg,#e7f8ef,#fff6d8);
    border-radius:28px;
    padding:45px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:30px;
    overflow:hidden;
}

.hero-text{
    max-width:650px;
}

.hero-badge{
    display:inline-block;
    background:#fff;
    color:#087f4e;
    padding:8px 16px;
    border-radius:30px;
    font-weight:bold;
    margin-bottom:15px;
}

.hero h2{
    color:#087f4e;
    font-size:45px;
    line-height:1.4;
}

.hero p{
    color:#666;
    font-size:18px;
    margin-top:10px;
}

.hero-art{
    width:230px;
    height:230px;
    flex-shrink:0;
    border-radius:50%;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:100px;
    box-shadow:0 15px 40px rgba(0,0,0,.07);
}

/* ================= TITLES ================= */

.section-title{
    text-align:center;
    margin:45px 0 22px;
}

.section-title h2{
    color:#087f4e;
    font-size:30px;
}

.section-title p{
    color:#777;
}

/* ================= CATEGORIES ================= */

.categories{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
}

.category{
    background:#fff;
    border:1px solid #e2ebe6;
    border-radius:20px;
    padding:25px 12px;
    text-align:center;
    transition:.2s;
}

.category:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 30px rgba(0,0,0,.08);
}

.category-icon{
    font-size:55px;
}

.category h3{
    color:#087f4e;
    margin-top:5px;
}

.category p{
    color:#888;
    font-size:13px;
}

.category-link{
    display:inline-block;
    margin-top:10px;
    background:#087f4e;
    color:#fff;
    padding:7px 15px;
    border-radius:9px;
    font-size:13px;
}

/* ================= PRODUCTS ================= */

.products{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
}

.product{
    background:#fff;
    border:1px solid #e2ebe6;
    border-radius:20px;
    padding:13px;
    overflow:hidden;
    transition:.2s;
}

.product:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(0,0,0,.07);
}

.product-image{
    height:160px;
    background:#f0f7f3;
    border-radius:15px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:75px;
    margin-bottom:12px;
}

.product h3{
    font-size:17px;
}

.product-description{
    color:#888;
    font-size:13px;
}

.product-price{
    color:#087f4e;
    font-size:19px;
    font-weight:bold;
    margin:7px 0;
}

.add-to-cart{
    width:100%;
    border:0;
    background:#087f4e;
    color:#fff;
    padding:11px;
    border-radius:11px;
    font-weight:bold;
    transition:.2s;
}

.add-to-cart:hover{
    background:#06683f;
}

/* ================= CART ================= */

.cart-section{
    margin-top:50px;
    background:#fff;
    border:1px solid #e2ebe6;
    border-radius:22px;
    padding:25px;
}

.cart-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    margin-bottom:20px;
}

.cart-header h2{
    color:#087f4e;
}

.clear-cart{
    border:0;
    background:#eee;
    color:#555;
    padding:8px 14px;
    border-radius:9px;
}

.cart-empty{
    text-align:center;
    color:#888;
    padding:30px 10px;
}

.cart-item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    padding:15px 0;
    border-bottom:1px solid #eee;
}

.cart-info{
    display:flex;
    align-items:center;
    gap:12px;
    min-width:190px;
}

.cart-icon{
    width:55px;
    height:55px;
    flex-shrink:0;
    border-radius:12px;
    background:#f0f7f3;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:30px;
}

.cart-name{
    font-weight:bold;
}

.cart-unit-price{
    color:#888;
    font-size:13px;
}

.quantity{
    display:flex;
    align-items:center;
    gap:8px;
}

.quantity button{
    width:34px;
    height:34px;
    border:0;
    border-radius:8px;
    background:#087f4e;
    color:#fff;
    font-size:20px;
}

.quantity-number{
    min-width:30px;
    text-align:center;
    font-weight:bold;
}

.cart-item-total{
    color:#087f4e;
    font-weight:bold;
    min-width:90px;
    text-align:center;
}

.remove-item{
    border:0;
    background:#f8eeee;
    color:#c33;
    padding:7px 10px;
    border-radius:8px;
}

.cart-summary{
    margin-top:20px;
    border-top:2px solid #eee;
    padding-top:20px;
}

.total-row{
    display:flex;
    justify-content:space-between;
    color:#087f4e;
    font-size:22px;
    font-weight:bold;
}

.checkout-button{
    width:100%;
    margin-top:18px;
    border:0;
    background:#f2a900;
    color:#fff;
    padding:15px;
    border-radius:12px;
    font-size:18px;
    font-weight:bold;
}

.checkout-button:hover{
    background:#d89300;
}

/* ================= INFO ================= */

.info{
    background:#fff;
    border:1px solid #e2ebe6;
    border-radius:20px;
    text-align:center;
    padding:25px;
    margin-top:40px;
}

.info h2{
    color:#087f4e;
}

.info p{
    color:#666;
}

/* ================= FOOTER ================= */

.footer{
    background:#075d3a;
    color:#fff;
    text-align:center;
    margin-top:50px;
    padding:35px 15px;
}

.footer p{
    color:#dcefe5;
    margin-top:5px;
}

/* ================= TOAST ================= */

.toast{
    position:fixed;
    right:20px;
    bottom:20px;
    z-index:9999;
    background:#087f4e;
    color:#fff;
    padding:14px 20px;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,.2);
    transform:translateY(100px);
    opacity:0;
    pointer-events:none;
    transition:.3s;
}

.toast.show{
    transform:translateY(0);
    opacity:1;
}

/* ================= MOBILE ================= */

@media(max-width:900px){

    .categories,
    .products{
        grid-template-columns:repeat(2,1fr);
    }

    .hero h2{
        font-size:34px;
    }

    .hero-art{
        width:170px;
        height:170px;
        font-size:70px;
    }

    .cart-item{
        flex-wrap:wrap;
    }

}

@media(max-width:600px){

    .topbar-inner{
        flex-direction:column;
        gap:2px;
    }

    .header-inner{
        flex-direction:column;
    }

    .header-actions{
        width:100%;
        justify-content:center;
    }

    .hero{
        min-height:auto;
        padding:30px 18px;
        flex-direction:column;
        text-align:center;
    }

    .hero h2{
        font-size:30px;
    }

    .hero p{
        font-size:15px;
    }

    .hero-art{
        width:140px;
        height:140px;
        font-size:58px;
    }

    .container{
        padding:18px 10px;
    }

    .categories,
    .products{
        grid-template-columns:1fr 1fr;
        gap:10px;
    }

    .category{
        padding:18px 7px;
    }

    .category-icon{
        font-size:42px;
    }

    .category h3{
        font-size:14px;
    }

    .product{
        padding:9px;
    }

    .product-image{
        height:110px;
        font-size:50px;
    }

    .product h3{
        font-size:14px;
    }

    .product-price{
        font-size:16px;
    }

    .add-to-cart{
        padding:9px 4px;
        font-size:12px;
    }

    .cart-header{
        flex-direction:column;
    }

    .cart-item{
        align-items:flex-start;
    }

    .cart-info{
        width:100%;
    }

    .cart-item-total{
        min-width:auto;
    }

}

/* ================= VERY SMALL ================= */

@media(max-width:380color:#fff;
width:24px;
height:24px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
font-size:12px
}

.nav{
background:#075d3a;
color:#fff
}

.nav-inner{
max-width:1200px;
margin:auto;
display:flex;
overflow-x:auto
}

.nav a{
padding:13px 18px;
white-space:nowrap;
font-weight:bold
}

.nav a:hover{
background:#064c30
}

.container{
max-width:1200px;
margin:auto;
padding:25px 15px
}

/* HERO */

.hero{
background:linear-gradient(135deg,#e8f8ef,#fff5d7);
border-radius:25px;
padding:40px;
display:flex;
align-items:center;
justify-content:space-between;
gap:25px;
margin-bottom:35px
}

.hero-text{
max-width:650px
}

.badge{
display:inline-block;
background:#fff;
color:#087f4e;
padding:7px 14px;
border-radius:30px;
font-weight:bold;
margin-bottom:12px
}

.hero h2{
font-size:40px;
line-height:1.4;
color:#087f4e
}

.hero p{
color:#666;
font-size:17px;
margin-top:10px
}

.hero-art{
width:210px;
height:210px;
border-radius:50%;
background:#fff;
display:flex;
align-items:center;
justify-content:center;
font-size:95px
}

/* TITLES */

.section-title{
text-align:center;
margin:35px 0 20px
}

.section-title h2{
font-size:29px;
color:#087f4e
}

.section-title p{
color:#777
}

/* CATEGORIES */

.categories{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:18px
}

.category{
background:#fff;
border:1px solid #e3ebe6;
border-radius:18px;
padding:25px 12px;
text-align:center;
transition:.2s
}

.category:hover{
transform:translateY(-4px);
box-shadow:0 10px 25px rgba(0,0,0,.08)
}

.category-icon{
font-size:50px
}

.category h3{
color:#087f4e;
margin-top:5px
}

.category p{
font-size:13px;
color:#888;
margin:3px 0 13px
}

.shop-btn{
display:inline-block;
background:#087f4e;
color:#fff;
padding:8px 15px;
border-radius:9px;
font-size:13px
}

/* PRODUCTS */

.products{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:18px
}

.product{
background:#fff;
border:1px solid #e3ebe6;
border-radius:18px;
padding:13px;
overflow:hidden
}

.product-image{
height:145px;
border-radius:14px;
background:#f0f7f3;
display:flex;
align-items:center;
justify-content:center;
font-size:68px;
margin-bottom:12px
}

.product h3{
font-size:17px
}

.product p{
font-size:13px;
color:#888
}

.price{
font-size:18px;
font-weight:bold;
color:#087f4e;
margin:7px 0
}

.add-btn{
width:100%;
border:0;
background:#087f4e;
color:#fff;
padding:10px;
border-radius:10px;
font-weight:bold
}

.add-btn:hover{
background:#06683f
}

/* CART */

.cart-section{
margin-top:45px;
background:#fff;
border:1px solid #e3ebe6;
border-radius:20px;
padding:25px
}

.cart-head{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:15px
}

.cart-head h2{
color:#087f4e
}

.clear-btn{
border:0;
background:#eee;
color:#555;
padding:8px 13px;
border-radius:9px
}

.cart-empty{
text-align:center;
color:#888;
padding:25px
}

.cart-item{
display:flex;
align-items:center;
justify-content:space-between;
gap:15px;
padding:13px 0;
border-bottom:1px solid #eee
}

.cart-info{
display:flex;
align-items:center;
gap:10px
}

.cart-icon{
width:50px;
height:50px;
border-radius:10px;
background:#f0f7f3;
display:flex;
align-items:center;
justify-content:center;
font-size:27px
}

.cart-name{
font-weight:bold
}

.cart-price{
color:#087f4e;
font-weight:bold
}

.quantity{
display:flex;
align-items:center;
gap:7px
}

.quantity button{
width:31px;
height:31px;
border:0;
border-radius:7px;
background:#087f4e;
color:#fff;
font-size:18px
}

.quantity span{
min-width:25px;
text-align:center;
font-weight:bold
}

.cart-total{
display:flex;
justify-content:space-between;
padding-top:20px;
font-size:21px;
font-weight:bold;
color:#087f4e
}

.checkout-btn{
width:100%;
border:0;
background:#f2a900;
color:#fff;
padding:14px;
border-radius:11px;
font-size:17px;
font-weight:bold;
margin-top:18px
}

.checkout-btn:hover{
background:#d89400
}

.info{
margin-top:40px;
background:#fff;
border-radius:18px;
padding:25px;
text-align:center;
border:1px solid #e3ebe6
}

.info h2{
color:#087f4e
}

.footer{
margin-top:50px;
background:#075d3a;
color:#fff;
text-align:center;
padding:30px 15px
}

.footer p{
color:#dcefe5;
margin-top:5px
}

/* MOBILE */

@media(max-width:900px){

.categories,
.products{
grid-template-columns:repeat(2,1fr)
}

.hero h2{
font-size:32px
}

.hero-art{
width:160px;
height:160px;
font-size:70px
}

}

@media(max-width:600px){

.topbar-inner{
flex-direction:column;
align-items:center;
gap:3px
}

.header-inner{
flex-direction:column
}

.actions{
width:100%;
justify-content:center
}

.hero{
flex-direction:column;
text-align:center;
padding:30px 18px
}

.hero h2{
font-size:28px
}

.hero-art{
width:135px;
height:135px;
font-size:58px
}

.container{
padding:18px 10px
}

.categories,
.products{
grid-template-columns:1fr 1fr;
gap:9px
}

.category{
padding:17px 7px
}

.category-icon{
font-size:40px
}

.product{
padding:9px
}

.product-image{
height:105px;
font-size:45px
}

.cart-item{
flex-wrap:wrap
}

.cart-head{
flex-direction:column;
gap:10px
}

}
</style>
</head>

<body>

<div class="topbar">
<div class="topbar-inner">
<span>🚚 توصيل حتى باب البيت</span>
<span>📞 01119511185</span>
</div>
</div>


<header class="header">

<div class="header-inner">

<a href="../" class="logo">

<div class="logo-box">ب</div>

<div>
<h1>مول البركة</h1>
<p>كل احتياجات بيتك</p>
</div>

</a>


<div class="actions">

<a href="../" class="action">
الرئيسية
</a>

<a href="#cart" class="action cart">
🛒 السلة
<span id="cartCount" class="cart-count">0</span>
</a>

</div>

</div>

</header>


<nav class="nav">

<div class="nav-inner">

<a href="../">الرئيسية</a>
<a href="#categories">الأقسام</a>
<a href="#vegetables">🥬 خضروات وفاكهة</a>
<a href="#meat">🥩 اللحوم</a>
<a href="#chicken">🍗 الدواجن</a>
<a href="#market">🛒 الماركت</a>
<a href="#cart">🛒 السلة</a>

</div>

</nav>


<main class="container">


<section class="hero">

<div class="hero-text">

<span class="badge">
🔥 عروض مول البركة
</span>

<h2>
كل احتياجات بيتك
<br>
في مكان واحد
</h2>

<p>
خضروات وفاكهة طازجة،
لحوم، دواجن، جزارة وماركت
بسهولة من متجر مول البركة.
</p>

</div>

<div class="hero-art">
🛒🍎
</div>

</section>


<section id="categories">

<div class="section-title">

<h2>تسوق حسب القسم</h2>

<p>اختر القسم الذي تريده</p>

</div>


<div class="categories">


<a class="category" href="#vegetables">

<div class="category-icon">🥬</div>

<h3>الخضروات والفاكهة</h3>

<p>طازجة يومياً</p>

<span class="shop-btn">تسوق الآن</span>

</a>


<a class="category" href="#meat">

<div class="category-icon">🥩</div>

<h3>اللحوم والجزارة</h3>

<p>لحوم مختارة</p>

<span class="shop-btn">تسوق الآن</span>

</a>


<a class="category" href="#chicken">

<div class="category-icon">🍗</div>

<h3>الدواجن والطيور</h3>

<p>طازة ومختارة</p>

<span class="shop-btn">تسوق الآن</span>

</a>


<a class="category" href="#market">

<div class="category-icon">🛒</div>

<h3>الماركت</h3>

<p>مستلزمات البيت</p>

<span class="shop-btn">تسوق الآن</span>

</a>


</div>

</section>


<section id="vegetables">

<div class="section-title">

<h2>🥬 الخضروات والفاكهة</h2>

<p>منتجات طازجة</p>

</div>


<div class="products">


<div class="product">

<div class="product-image">🍎</div>

<h3>تفاح طازج</h3>

<p>جودة ممتازة</p>

<div class="price">25 جنيه</div>

<button class="add-btn"
onclick="addToCart('تفاح طازج','🍎',25)">
أضف للسلة
</button>

</div>


<div class="product">

<div class="product-image">🍅</div>

<h3>طماطم</h3>

<p>طازجة يومياً</p>

<div class="price">15 جنيه</div>

<button class="add-btn"
onclick="addToCart('طماطم','🍅',15)">
أضف للسلة
</button>

</div>


<div class="product">

<div class="product-image">🥒</div>

<h3>خيار</h3>

<p>طازج ومختار</p>

<div class="price">20 جنيه</div>

<button class="add-btn"
onclick="addToCart('خيار','🥒',20)">
أضف للسلة
</button>

</div>


<div class="product">

<div class="product-image">🥔</div>

<h3>بطاطس</h3>

<p>جودة ممتازة</p>

<div class="price">18 جنيه</div>

<button class="add-btn"
onclick="addToCart('بطاطس','🥔',18)">
أضف للسلة
</button>

</div>


</div>

</section>


<section id="meat">

<div class="section-title">

<h2>🥩 اللحوم والجزارة</h2>

<p>لحوم مختارة بعناية</p>

</div>


<div class="products">


<div class="product">

<div class="product-image">🥩</div>

<h3>لحوم بلدي</h3>

<p>تجهيز حسب الطلب</p>

<div class="price">450 جنيه</div>

<button class="add-btn"
onclick="addToCart('لحوم بلدي','🥩',450)">
أضف للسلة
</button>

</div>


<div class="product">

<div class="product-image">🍖</div>

<h3>لحمة مفرومة</h3>

<p>طازجة ومجهزة</p>

<div class="price">400 جنيه</div>

<button class="add-btn"
onclick="addToCart('لحمة مفرومة','🍖',400)">
أضف للسلة
</button>

</div>


</div>

</section>


<section id="chicken">

<div class="section-title">

<h2>🍗 الدواجن والطيور</h2>

<p>طازة ومختارة</p>

</div>


<div class="products">


<div class="product">

<div class="product-image">🐔</div>

<h3>دجاج طازج</h3>

<p>تجهيز حسب الطلب</p>

<div class="price">120 جنيه</div>

<button class="add-btn"
onclick="addToCart('دجاج طازج','🐔',120)">
أضف للسلة
</button>

</div>


<div class="product">

<div class="product-image">🥚</div>

<h3>بيض</h3>

<p>عبوة 30 بيضة</p>

<div class="price">150 جنيه</div>

<button class="add-btn"
onclick="addToCart('بيض','🥚',150)">
أضف للسلة
</button>

</div>


</div>

</section>


<section id="market">

<div class="section-title">

<h2>🛒 الماركت</h2>

<p>كل مستلزمات البيت</p>

</div>


<div class="products">


<div class="product">

<div class="product-image">🥫</div>

<h3>منتجات غذائية</h3>

<p>اختيارات متنوعة</p>

<div class="price">50 جنيه</div>

<button class="add-btn"
onclick="addToCart('منتجات غذائية','🥫',50)">
أضف للسلة
</button>

</div>


<div class="product">

<div class="product-image">🧃</div>

<h3>مشروبات</h3>

<p>اختيارات متنوعة</p>

<div class="price">30 جنيه</div>

<button class="add-btn"
onclick="addToCart('مشروبات','🧃',30)">
أضف للسلة
</button>

</div>


</div>

</section>


<!-- CART -->

<section class="cart-section" id="cart">

<div class="cart-head">

<h2>🛒 سلة المشتريات</h2>

<button class="clear-btn" onclick="clearCart()">
تفريغ السلة
</button>

</div>


<div id="cartItems">

<div class="cart-empty">
السلة فارغة حالياً.
</div>

</div>


<div class="cart-total">

<span>الإجمالي</span>

<span>
<span id="cartTotal">0</span>
جنيه
</span>

</div>


<button class="checkout-btn" onclick="checkout()">
إتمام الطلب
</button>

</section>


<section class="info">

<h2>📞 اطلب بسهولة</h2>

<p>
خدمة العملاء:
<strong>01119511185</strong>
</p>

<p>
📍 شارع الشيخ عبدالرحمن تاج البنفسج 9
</p>

</section>


</main>


<footer class="footer">

<h2>مول البركة</h2>

<p>كل احتياجات بيتك في مكان واحد</p>

<p>📞 01119511185</p>

<p>© 2026 مول البركة - جميع الحقوق محفوظة</p>

</footer>


<script>

let cart = [];


/* إضافة منتج */

function addToCart(name,icon,price){

let existing =
cart.find(function(item){
return item.name === name;
});


if(existing){

existing.quantity++;

}else{

cart.push({
name:name,
icon:icon,
price:Number(price),
quantity:1
});

}


saveCart();

renderCart();

document.getElementById("cart").scrollIntoView({
behavior:"smooth"
});

}


/* زيادة */

function increase(index){

cart[index].quantity++;

saveCart();

renderCart();

}


/* نقص */

function decrease(index){

if(cart[index].quantity > 1){

cart[index].quantity--;

}else{

cart.splice(index,1);

}

saveCart();

renderCart();

}


/* حذف */

function removeItem(index){

cart.splice(index,1);

saveCart();

renderCart();

}


/* تفريغ */

function clearCart(){

cart=[];

saveCart();

renderCart();

}


/* عرض السلة */

function renderCart(){

let container =
document.getElementById("cartItems");

let countElement =
document.getElementById("cartCount");

let totalElement =
document.getElementById("cartTotal");


if(cart.length === 0){

container.innerHTML =
'<div class="cart-empty">السلة فارغة حالياً.</div>';

countElement.textContent="0";

totalElement.textContent="0";

return;

}


let html="";

let total=0;

let count=0;


cart.forEach(function(item,index){

let itemTotal =
item.price * item.quantity;

total += itemTotal;

count += item.quantity;


html += `

<div class="cart-item">

<div class="cart-info">

<div class="cart-icon">
${item.icon}
</div>

<div>

<div class="cart-name">
${item.name}
</div>

<div>
${item.price} جنيه
</div>

</div>

</div>


<div class="quantity">

<button onclick="decrease(${index})">
−
</button>

<span>
${item.quantity}
</span>

<button onclick="increase(${index})">
+
</button>

</div>


<div class="cart-price">
${itemTotal} جنيه
</div>


<button
class="clear-btn"
onclick="removeItem(${index})">
حذف
</button>

</div>

`;

});


container.innerHTML=html;

countElement.textContent=count;

totalElement.textContent=total;

}


/* حفظ */

function saveCart(){

localStorage.setItem(
"albaraka_cart",
JSON.stringify(cart)
);

}


/* تحميل */

function loadCart(){

let saved =
localStorage.getItem("albaraka_cart");


if(saved){

try{

cart=JSON.parse(saved);

}catch(error){

cart=[];

}

}


renderCart();

}


/* إتمام الطلب */

function checkout(){

if(cart.length === 0){

alert("السلة فارغة. أضف منتجاً أولاً.");

return;

}


/* الانتقال إلى صفحة الطلب */

window.location.href="checkout.html";

}


/* تشغيل */

loadCart();

</script>

</body>
</html>border-radius:50%;
font-size:12px;
display:flex;
align-items:center;
justify-content:center
}

.nav{
background:#087f4e;
color:white
}

.nav-inner{
max-width:1200px;
margin:auto;
display:flex;
overflow-x:auto
}

.nav a{
padding:15px 20px;
white-space:nowrap;
font-weight:bold
}

.nav a:hover{
background:#06683f
}

.container{
max-width:1200px;
margin:auto;
padding:30px 20px
}

.hero{
background:linear-gradient(135deg,#e9f8f0,#fff8dc);
border-radius:28px;
padding:45px 30px;
margin-bottom:35px;
display:flex;
align-items:center;
justify-content:space-between;
gap:30px
}

.hero-text{
max-width:650px
}

.badge{
display:inline-block;
background:#fff;
padding:8px 16px;
border-radius:30px;
color:#087f4e;
font-weight:bold;
margin-bottom:15px
}

.hero h2{
font-size:42px;
line-height:1.35;
color:#087f4e;
margin-bottom:12px
}

.hero p{
color:#666;
font-size:17px
}

.hero-art{
font-size:100px;
background:#fff;
border-radius:50%;
width:220px;
height:220px;
display:flex;
align-items:center;
justify-content:center
}

.section-title{
text-align:center;
margin:35px 0 22px
}

.section-title h2{
color:#087f4e;
font-size:30px
}

.section-title p{
color:#777
}

.categories{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:18px
}

.category{
background:#fff;
border:1px solid #e6eee9;
border-radius:20px;
padding:25px 15px;
text-align:center;
transition:.2s
}

.category:hover{
transform:translateY(-4px);
box-shadow:0 12px 28px rgba(0,0,0,.08)
}

.category-icon{
font-size:52px
}

.category h3{
color:#087f4e
}

.category p{
color:#888;
font-size:14px;
margin:5px 0 15px
}

.shop-btn{
display:inline-block;
background:#087f4e;
color:#fff;
padding:9px 17px;
border-radius:10px
}

.products{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:18px
}

.product{
background:#fff;
border:1px solid #e6eee9;
border-radius:18px;
padding:14px
}

.product-image{
height:150px;
border-radius:14px;
background:#f1f7f3;
display:flex;
align-items:center;
justify-content:center;
font-size:70px;
margin-bottom:12px
}

.product h3{
font-size:17px
}

.product p{
font-size:13px;
color:#888
}

.price{
color:#087f4e;
font-size:18px;
font-weight:bold;
margin:8px 0
}

.add-btn{
width:100%;
border:0;
background:#087f4e;
color:#fff;
padding:10px;
border-radius:10px;
font-weight:bold
}

.add-btn:hover{
background:#06683f
}

/* CART */

.cart-section{
margin-top:50px;
background:#fff;
border-radius:22px;
padding:25px;
border:1px solid #e6eee9
}

.cart-title{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px
}

.cart-title h2{
color:#087f4e
}

.clear-btn{
border:0;
background:#eee;
color:#555;
padding:9px 15px;
border-radius:10px
}

.cart-empty{
text-align:center;
padding:30px;
color:#888
}

.cart-item{
display:flex;
align-items:center;
justify-content:space-between;
gap:15px;
padding:15px 0;
border-bottom:1px solid #eee
}

.cart-item-info{
display:flex;
align-items:center;
gap:12px
}

.cart-item-icon{
width:55px;
height:55px;
border-radius:12px;
background:#f1f7f3;
display:flex;
align-items:center;
justify-content:center;
font-size:30px
}

.cart-item h3{
font-size:16px
}

.cart-item small{
color:#888
}

.quantity{
display:flex;
align-items:center;
gap:8px
}

.quantity button{
border:0;
width:32px;
height:32px;
border-radius:8px;
background:#087f4e;
color:#fff;
font-size:18px
}

.quantity span{
min-width:25px;
text-align:center;
font-weight:bold
}

.cart-total{
display:flex;
justify-content:space-between;
font-size:21px;
font-weight:bold;
color:#087f4e;
padding-top:20px
}

.checkout-btn{
width:100%;
margin-top:20px;
border:0;
background:#f2a900;
color:#fff;
padding:14px;
border-radius:12px;
font-size:17px;
font-weight:bold
}

.info{
margin-top:40px;
background:#fff;
border-radius:20px;
padding:25px;
text-align:center;
border:1px solid #e6eee9
}

.info h2{
color:#087f4e
}

.footer{
margin-top:55px;
background:#075d3a;
color:#fff;
text-align:center;
padding:35px 20px
}

.footer p{
color:#dcefe5;
margin-top:5px
}

@media(max-width:900px){

.categories,
.products{
grid-template-columns:repeat(2,1fr)
}

.hero h2{
font-size:34px
}

.hero-art{
width:160px;
height:160px;
font-size:70px
}

}

@media(max-width:600px){

.topbar-inner{
flex-direction:column;
align-items:center
}

.header-inner{
flex-direction:column
}

.actions{
width:100%;
justify-content:center
}

.hero{
text-align:center;
flex-direction:column
}

.hero h2{
font-size:29px
}

.hero-art{
width:140px;
height:140px;
font-size:60px
}

.container{
padding:20px 12px
}

.categories,
.products{
grid-template-columns:1fr 1fr;
gap:10px
}

.category{
padding:18px 8px
}

.product{
padding:10px
}

.product-image{
height:105px;
font-size:45px
}

.cart-item{
align-items:flex-start;
flex-direction:column
}

.cart-title{
flex-direction:column;
gap:10px
}

}
</style>
</head>

<body>

<div class="topbar">
<div class="topbar-inner">
<span>🚚 توصيل طلباتك حتى باب البيت</span>
<span>📞 خدمة العملاء: 01119511185</span>
</div>
</div>

<header class="header">
<div class="header-inner">

<a href="../" class="logo">
<div class="logo-box">ب</div>
<div>
<h1>مول البركة</h1>
<p>كل احتياجات بيتك</p>
</div>
</a>

<div class="actions">
<a href="../" class="action">الرئيسية</a>

<a href="#cart" class="action cart">
🛒 السلة
<span class="cart-count" id="cartCount">0</span>
</a>
</div>

</div>
</header>

<nav class="nav">
<div class="nav-inner">

<a href="../">الرئيسية</a>
<a href="#categories">جميع الأقسام</a>
<a href="#vegetables">🥬 الخضروات والفاكهة</a>
<a href="#meat">🥩 اللحوم والجزارة</a>
<a href="#chicken">🍗 الدواجن والطيور</a>
<a href="#market">🛒 الماركت</a>
<a href="#cart">🛒 السلة</a>

</div>
</nav>

<main class="container">

<section class="hero">

<div class="hero-text">

<span class="badge">🔥 عروض مول البركة</span>

<h2>
كل احتياجات بيتك
<br>
بأسعار مميزة
</h2>

<p>
خضروات وفاكهة طازجة،
لحوم، دواجن، جزارة وماركت
— كل ما تحتاجه في مكان واحد.
</p>

</div>

<div class="hero-art">
🛒🍎
</div>

</section>


<section id="categories">

<div class="section-title">

<h2>تسوق حسب الأقسام</h2>

<p>اختار القسم وابدأ التسوق</p>

</div>

<div class="categories">

<a class="category" href="#vegetables">

<div class="category-icon">🥬</div>

<h3>الخضروات والفاكهة</h3>

<p>طازجة يومياً</p>

<span class="shop-btn">تسوق الآن</span>

</a>


<a class="category" href="#meat">

<div class="category-icon">🥩</div>

<h3>اللحوم والجزارة</h3>

<p>لحوم طازجة ومختارة</p>

<span class="shop-btn">تسوق الآن</span>

</a>


<a class="category" href="#chicken">

<div class="category-icon">🍗</div>

<h3>الدواجن والطيور</h3>

<p>طازة ومختارة</p>

<span class="shop-btn">تسوق الآن</span>

</a>


<a class="category" href="#market">

<div class="category-icon">🛒</div>

<h3>الماركت</h3>

<p>مستلزمات البيت</p>

<span class="shop-btn">تسوق الآن</span>

</a>

</div>

</section>


<section id="vegetables">

<div class="section-title">

<h2>🥬 الخضروات والفاكهة</h2>

<p>منتجات طازجة يومياً</p>

</div>

<div class="products">


<div class="product">

<div class="product-image">🍎</div>

<h3>تفاح طازج</h3>

<p>جودة ممتازة</p>

<div class="price">25 جنيه</div>

<button class="add-btn"
onclick="addToCart('تفاح طازج','🍎',25)">
أضف للسلة
</button>

</div>


<div class="product">

<div class="product-image">🍅</div>

<h3>طماطم</h3>

<p>طازجة يومياً</p>

<div class="price">15 جنيه</div>

<button class="add-btn"
onclick="addToCart('طماطم','🍅',15)">
أضف للسلة
</button>    gap: 10px;
    align-items: center;
}

.action {
    padding: 11px 17px;
    border-radius: 12px;
    background: #f1f6f3;
    color: #087f4e;
    font-weight: bold;
}

/* NAV */

.nav {
    background: #087f4e;
    color: white;
}

.nav-inner {
    max-width: 1200px;
    margin: auto;
    display: flex;
    overflow-x: auto;
}

.nav a {
    padding: 16px 22px;
    white-space: nowrap;
    font-weight: bold;
}

.nav a:hover {
    background: #06683f;
}

/* PAGE */

.container {
    max-width: 1200px;
    margin: auto;
    padding: 35px 20px;
}

/* TITLE */

.title {
    text-align: center;
    margin-bottom: 35px;
}

.title h2 {
    font-size: 35px;
    color: #087f4e;
    margin-bottom: 10px;
}

.title p {
    color: #777;
    font-size: 16px;
}

/* CATEGORIES */

.categories {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.category {
    background: white;
    border-radius: 22px;
    padding: 30px 20px;
    text-align: center;
    border: 1px solid #e8eee9;
    transition: .25s;
}

.category:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,.08);
}

.icon {
    font-size: 55px;
    margin-bottom: 15px;
}

.category h3 {
    color: #087f4e;
    font-size: 20px;
    margin-bottom: 8px;
}

.category p {
    color: #888;
    margin-bottom: 18px;
}

.category button {
    border: 0;
    background: #087f4e;
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
}

/* PRODUCTS */

.section {
    margin-top: 55px;
}

.section-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-title h2 {
    color: #087f4e;
    font-size: 25px;
}

.products {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}

.product {
    background: white;
    border-radius: 18px;
    padding: 18px;
    border: 1px solid #e8eee9;
}

.product-image {
    height: 150px;
    background: #f1f7f3;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 65px;
    margin-bottom: 15px;
}

.product h3 {
    font-size: 17px;
    margin-bottom: 8px;
}

.price {
    color: #087f4e;
    font-weight: bold;
    font-size: 19px;
    margin-bottom: 12px;
}

.add {
    width: 100%;
    border: none;
    background: #087f4e;
    color: white;
    padding: 11px;
    border-radius: 10px;
    font-weight: bold;
}

/* FOOTER */

.footer {
    margin-top: 60px;
    background: #075d3a;
    color: white;
    padding: 35px 20px;
    text-align: center;
}

.footer h2 {
    margin-bottom: 10px;
}

.footer p {
    margin: 7px;
    color: #e0f2e8;
}

/* MOBILE */

@media (max-width: 900px) {

    .categories {
        grid-template-columns: repeat(2, 1fr);
    }

    .products {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 600px) {

    .header-inner {
        flex-direction: column;
        text-align: center;
    }

    .actions {
        width: 100%;
        justify-content: center;
    }

    .title h2 {
        font-size: 28px;
    }

    .categories {
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .category {
        padding: 20px 10px;
    }

    .products {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .product {
        padding: 10px;
    }

    .product-image {
        height: 110px;
        font-size: 45px;
    }

}

</style>
</head>

<body>

<header class="header">

<div class="header-inner">

<div class="logo">

<div class="logo-box">ب</div>

<div>
<h1>مول البركة</h1>
<p>كل احتياجات بيتك</p>
</div>

</div>

<div class="actions">

<a class="action" href="/">الرئيسية</a>

<a class="action" href="#cart">
🛒 السلة
</a>

</div>

</div>

</header>


<nav class="nav">

<div class="nav-inner">

<a href="/">الرئيسية</a>

<a href="#vegetables">🥬 الخضروات والفاكهة</a>

<a href="#meat">🥩 اللحوم والجزارة</a>

<a href="#chicken">🍗 الدواجن والطيور</a>

<a href="#market">🛒 الماركت</a>

</div>

</nav>


<main class="container">


<section class="title">

<h2>متجر مول البركة</h2>

<p>
اختار القسم الذي تريد الشراء منه
</p>

</section>


<section class="categories">

<?php foreach ($categories as $category): ?>

<a href="<?= htmlspecialchars($category['link']) ?>" class="category">

<div class="icon">
<?= $category['icon'] ?>
</div>

<h3>
<?= htmlspecialchars($category['name']) ?>
</h3>

<p>
<?= htmlspecialchars($category['desc']) ?>
</p>

<button>
تسوق الآن
</button>

</a>

<?php endforeach; ?>

</section>


<section class="section" id="vegetables">

<div class="section-title">

<h2>🥬 الخضروات والفاكهة</h2>

</div>

<div class="products">

<div class="product">

<div class="product-image">
🍎
</div>

<h3>تفاح طازج</h3>

<div class="price">
السعر حسب الوزن
</div>

<button class="add">
أضف للسلة
</button>

</div>


<div class="product">

<div class="product-image">
🍅
</div>

<h3>طماطم</h3>

<div class="price">
السعر حسب الوزن
</div>

<button class="add">
أضف للسلة
</button>

</div>


<div class="product">

<div class="product-image">
🥒
</div>

<h3>خيار</h3>

<div class="price">
السعر حسب الوزن
</div>

<button class="add">
أضف للسلة
</button>

</div>


<div class="product">

<div class="product-image">
🥔
</div>

<h3>بطاطس</h3>

<div class="price">
السعر حسب الوزن
</div>

<button class="add">
أضف للسلة
</button>

</div>

</div>

</section>


<section class="section" id="meat">

<div class="section-title">

<h2>🥩 اللحوم والجزارة</h2>

</div>

<div class="products">

<div class="product">

<div class="product-image">
🥩
</div>

<h3>لحوم بلدي</h3>

<div class="price">
السعر حسب الوزن
</div>

<button class="add">
أضف للسلة
</button>

</div>

<div class="product">

<div class="product-image">
🍖
</div>

<h3>لحمة مفرومة</h3>

<div class="price">
السعر حسب الوزن
</div>

<button class="add">
أضف للسلة
</button>

</div>

</div>

</section>


<section class="section" id="chicken">

<div class="section-title">

<h2>🍗 الدواجن والطيور</h2>

</div>

<div class="products">

<div class="product">

<div class="product-image">
🐔
</div>

<h3>دجاج طازج</h3>

<div class="price">
السعر حسب الوزن
</div>

<button class="add">
أضف للسلة
</button>

</div>

<div class="product">

<div class="product-image">
🥚
</div>

<h3>بيض</h3>

<div class="price">
السعر حسب العبوة
</div>

<button class="add">
أضف للسلة
</button>

</div>

</div>

</section>


<section class="section" id="market">

<div class="section-title">

<h2>🛒 الماركت</h2>

</div>

<div class="products">

<div class="product">

<div class="product-image">
🥫
</div>

<h3>منتجات غذائية</h3>

<div class="price">
أسعار مميزة
</div>

<button class="add">
أضف للسلة
</button>

</div>

<div class="product">

<div class="product-image">
🧃
</div>

<h3>مشروبات</h3>

<div class="price">
أسعار مميزة
</div>

<button class="add">
أضف للسلة
</button>

</div>

</div>

</section>


</main>


<footer class="footer">

<h2>مول البركة</h2>

<p>كل احتياجات بيتك في مكان واحد</p>

<p>📞 خدمة العملاء: 01119511185</p>

<p>📍 شارع الشيخ عبدالرحمن تاج البنفسج 9</p>

<p>© 2026 مول البركة - جميع الحقوق محفوظة</p>

</footer>


</body>
</html>    color:#7c8781;
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
   
