<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>متجر مول البركة</title>

<style>
*{box-sizing:border-box;margin:0;padding:0}

body{
font-family:Tahoma,Arial,sans-serif;
background:#f5f8f6;
color:#222;
line-height:1.7
}

a{text-decoration:none;color:inherit}

button{
font-family:inherit;
cursor:pointer
}

.topbar{
background:#f0f6f2;
color:#555;
padding:8px 5%;
font-size:13px
}

.topbar-inner{
max-width:1200px;
margin:auto;
display:flex;
justify-content:space-between
}

.header{
background:#fff;
padding:15px 5%;
border-bottom:1px solid #e5e5e5
}

.header-inner{
max-width:1200px;
margin:auto;
display:flex;
align-items:center;
justify-content:space-between;
gap:20px
}

.logo{
display:flex;
align-items:center;
gap:12px
}

.logo-box{
width:58px;
height:58px;
border-radius:16px;
background:#087f4e;
color:#fff;
display:flex;
align-items:center;
justify-content:center;
font-size:29px;
font-weight:bold
}

.logo h1{
font-size:25px;
color:#087f4e
}

.logo p{
color:#777;
font-size:13px
}

.actions{
display:flex;
gap:10px
}

.action{
background:#f1f6f3;
color:#087f4e;
padding:10px 15px;
border-radius:12px;
font-weight:bold
}

.cart{
position:relative
}

.cart-count{
position:absolute;
top:-9px;
left:-8px;
background:#f2a900;
color:#fff;
width:24px;
height:24px;
border-radius:50%;
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
   
