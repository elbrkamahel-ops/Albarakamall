<?php
$products = [
    ['id'=>1,'name'=>'طماطم بلدي','category'=>'خضروات','price'=>18,'unit'=>'كجم','emoji'=>'🍅'],
    ['id'=>2,'name'=>'بطاطس','category'=>'خضروات','price'=>22,'unit'=>'كجم','emoji'=>'🥔'],
    ['id'=>3,'name'=>'خيار','category'=>'خضروات','price'=>25,'unit'=>'كجم','emoji'=>'🥒'],
    ['id'=>4,'name'=>'فلفل أخضر','category'=>'خضروات','price'=>35,'unit'=>'كجم','emoji'=>'🫑'],
    ['id'=>5,'name'=>'موز','category'=>'فواكه','price'=>30,'unit'=>'كجم','emoji'=>'🍌'],
    ['id'=>6,'name'=>'تفاح','category'=>'فواكه','price'=>55,'unit'=>'كجم','emoji'=>'🍎'],
    ['id'=>7,'name'=>'برتقال','category'=>'فواكه','price'=>32,'unit'=>'كجم','emoji'=>'🍊'],
    ['id'=>8,'name'=>'فراولة','category'=>'فواكه','price'=>65,'unit'=>'كجم','emoji'=>'🍓'],
    ['id'=>9,'name'=>'صدور فراخ','category'=>'طيور','price'=>145,'unit'=>'كجم','emoji'=>'🍗'],
    ['id'=>10,'name'=>'فراخ كاملة','category'=>'طيور','price'=>125,'unit'=>'كجم','emoji'=>'🐔'],
    ['id'=>11,'name'=>'لحم بقري','category'=>'لحوم','price'=>420,'unit'=>'كجم','emoji'=>'🥩'],
    ['id'=>12,'name'=>'لحم مفروم','category'=>'لحوم','price'=>390,'unit'=>'كجم','emoji'=>'🥩'],
    ['id'=>13,'name'=>'أرز','category'=>'ماركت','price'=>35,'unit'=>'كجم','emoji'=>'🍚'],
    ['id'=>14,'name'=>'سكر','category'=>'ماركت','price'=>30,'unit'=>'كجم','emoji'=>'🧂'],
    ['id'=>15,'name'=>'زيت طعام','category'=>'ماركت','price'=>75,'unit'=>'زجاجة','emoji'=>'🫗'],
    ['id'=>16,'name'=>'بيض','category'=>'ماركت','price'=>85,'unit'=>'طبق','emoji'=>'🥚']
];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<title>مول البركة | تسوق أونلاين</title>

<meta name="description"
content="مول البركة للخضروات والفواكه واللحوم والطيور والماركت">

<style>

*{
box-sizing:border-box;
margin:0;
padding:0;
}

:root{
--green:#087f3d;
--green2:#0a9a4b;
--dark:#142019;
--bg:#f6f8f6;
--orange:#ffb000;
--red:#d92828;
--border:#e3e8e4;
}

body{
font-family:Tahoma,Arial,sans-serif;
background:var(--bg);
color:#18201b;
line-height:1.6;
}

button,
input{
font:inherit;
}

button{
cursor:pointer;
border:0;
}

a{
text-decoration:none;
color:inherit;
}


/* TOP */

.top{
background:var(--green);
color:#fff;
font-size:13px;
}

.topin{
max-width:1200px;
margin:auto;
padding:8px 16px;
display:flex;
justify-content:space-between;
}


/* HEADER */

.header{
background:#fff;
position:sticky;
top:0;
z-index:20;
box-shadow:0 2px 14px #0000000d;
}

.headin{
max-width:1200px;
margin:auto;
padding:13px 16px;
display:flex;
align-items:center;
gap:16px;
}

.logo{
display:flex;
align-items:center;
gap:9px;
min-width:185px;
color:var(--green);
font-weight:900;
font-size:22px;
}

.logoMark{
width:44px;
height:44px;
border-radius:13px;
background:var(--green);
color:#fff;
display:grid;
place-items:center;
font-size:24px;
}

.search{
flex:1;
display:flex;
background:#f3f5f3;
border:1px solid var(--border);
border-radius:13px;
overflow:hidden;
}

.search input{
width:100%;
border:0;
background:transparent;
padding:13px 15px;
outline:0;
}

.search button{
width:54px;
background:var(--green);
color:#fff;
}

.cartBtn{
background:#fff;
border:1px solid var(--border);
border-radius:13px;
padding:10px 14px;
display:flex;
align-items:center;
gap:8px;
font-weight:800;
}

.badge{
background:var(--orange);
color:#111;
border-radius:20px;
min-width:24px;
height:24px;
display:grid;
place-items:center;
font-size:12px;
}


/* NAV */

.nav{
background:#fff;
border-top:1px solid #f0f0f0;
}

.navin{
max-width:1200px;
margin:auto;
display:flex;
gap:8px;
overflow:auto;
padding:8px 16px;
}

.nav button{
white-space:nowrap;
background:#f3f6f3;
border-radius:22px;
padding:8px 16px;
}

.nav button.active,
.nav button:hover{
background:var(--green);
color:#fff;
}


/* MAIN */

.main{
max-width:1200px;
margin:auto;
}


/* HERO */

.hero{
margin:20px 16px;
background:linear-gradient(120deg,#087f3d,#16a45a);
border-radius:24px;
color:#fff;
min-height:250px;
padding:34px;
display:flex;
align-items:center;
justify-content:space-between;
overflow:hidden;
}

.hero h1{
font-size:34px;
margin-bottom:10px;
}

.hero p{
opacity:.95;
margin-bottom:20px;
}

.heroBtn{
background:#fff;
color:var(--green);
padding:12px 22px;
border-radius:12px;
font-weight:900;
}

.heroEmoji{
font-size:120px;
}


/* TITLES */

.sectionTitle{
display:flex;
justify-content:space-between;
align-items:center;
margin:28px 16px 14px;
}

.sectionTitle h2{
font-size:23px;
}


/* CATEGORIES */

.categories{
display:grid;
grid-template-columns:repeat(6,1fr);
gap:12px;
margin:0 16px;
}

.cat{
background:#fff;
border:1px solid var(--border);
border-radius:16px;
padding:18px 10px;
text-align:center;
font-weight:800;
transition:.2s;
}

.cat:hover{
transform:translateY(-2px);
border-color:var(--green);
}

.catIcon{
font-size:34px;
display:block;
margin-bottom:6px;
}


/* PRODUCTS */

.grid{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:15px;
margin:0 16px 35px;
}

.card{
background:#fff;
border:1px solid var(--border);
border-radius:17px;
overflow:hidden;
}

.pic{
height:160px;
background:linear-gradient(135deg,#f1f7f2,#e5f1e8);
display:grid;
place-items:center;
font-size:80px;
}

.cardBody{
padding:14px;
}

.catName{
color:#68736c;
font-size:12px;
}

.card h3{
font-size:17px;
margin:3px 0;
}

.price{
color:var(--green);
font-size:20px;
font-weight:900;
}

.price small{
font-size:12px;
color:#68736c;
font-weight:normal;
}

.add{
width:100%;
margin-top:10px;
padding:10px;
border-radius:10px;
background:var(--green);
color:#fff;
font-weight:900;
}

.add:hover{
background:var(--green2);
}


/* EMPTY */

.empty{
padding:45px;
text-align:center;
background:#fff;
border:1px dashed #ccd4ce;
border-radius:15px;
margin:0 16px 30px;
}


/* FOOTER */

footer{
background:var(--dark);
color:#fff;
padding:30px 16px;
margin-top:40px;
}

.footin{
max-width:1200px;
margin:auto;
display:flex;
justify-content:space-between;
gap:20px;
}


/* CART */

.drawer{
position:fixed;
inset:0;
z-index:50;
display:none;
background:#0007;
}

.drawer.open{
display:block;
}

.cart{
position:absolute;
right:0;
top:0;
height:100%;
width:min(430px,100%);
background:#fff;
display:flex;
flex-direction:column;
box-shadow:-5px 0 25px #0003;
}

.cartHead{
padding:18px;
border-bottom:1px solid var(--border);
display:flex;
justify-content:space-between;
align-items:center;
}

.close{
background:#f1f3f1;
border-radius:9px;
width:38px;
height:38px;
}

.items{
flex:1;
overflow:auto;
padding:14px;
}

.item{
display:grid;
grid-template-columns:58px 1fr auto;
gap:10px;
padding:12px 0;
border-bottom:1px solid var(--border);
}

.itemPic{
width:58px;
height:58px;
background:#f0f5f1;
border-radius:10px;
display:grid;
place-items:center;
font-size:30px;
}

.item h4{
font-size:14px;
}

.itemPrice{
font-weight:900;
color:var(--green);
}

.qty{
display:flex;
align-items:center;
gap:7px;
margin-top:6px;
}

.qty button{
width:27px;
height:27px;
border-radius:7px;
background:#edf2ee;
}

.remove{
color:var(--red);
background:none;
font-size:12px;
}

.cartFoot{
padding:16px;
border-top:1px solid var(--border);
}

.total{
display:flex;
justify-content:space-between;
font-size:20px;
font-weight:900;
margin-bottom:12px;
}

.checkout{
display:block;
text-align:center;
background:var(--green);
color:#fff;
padding:13px;
border-radius:12px;
font-weight:900;
}

.clear{
width:100%;
background:#f4e9e9;
color:var(--red);
padding:9px;
border-radius:10px;
margin-top:8px;
}


/* TOAST */

.toast{
position:fixed;
bottom:20px;
left:50%;
transform:translateX(-50%) translateY(100px);
background:var(--dark);
color:#fff;
padding:12px 18px;
border-radius:12px;
z-index:80;
transition:.25s;
}

.toast.show{
transform:translateX(-50%) translateY(0);
}


/* MOBILE */

@media(max-width:900px){

.grid{
grid-template-columns:repeat(3,1fr);
}

.categories{
grid-template-columns:repeat(3,1fr);
}

}


@media(max-width:600px){

.topin{
font-size:11px;
}

.headin{
gap:8px;
flex-wrap:wrap;
}

.logo{
min-width:auto;
font-size:18px;
}

.logoMark{
width:38px;
height:38px;
}

.search{
order:3;
flex-basis:100%;
}

.hero{
margin-top:12px;
min-height:210px;
padding:23px;
}

.hero h1{
font-size:25px;
}

.heroEmoji{
font-size:75px;
}

.grid{
grid-template-columns:repeat(2,1fr);
gap:10px;
margin-left:10px;
margin-right:10px;
}

.categories{
margin:0 10px;
gap:8px;
}

.sectionTitle{
margin-left:10px;
margin-right:10px;
}

.pic{
height:125px;
font-size:65px;
}

.cardBody{
padding:10px;
}

.card h3{
font-size:14px;
}

.price{
font-size:17px;
}

.footin{
flex-direction:column;
}

}

</style>
</head>

<body>


<div class="top">

<div class="topin">

<span>🚚 توصيل سريع داخل المنطقة</span>

<span>📞 01119511185</span>

</div>

</div>


<header class="header">

<div class="headin">

<a class="logo" href="index.php">

<span class="logoMark">🛒</span>

<span>مول البركة</span>

</a>


<div class="search">

<input
id="search"
type="search"
placeholder="ابحث عن منتج..."
autocomplete="off">

<button
type="button"
onclick="renderProducts()">

🔎

</button>

</div>


<button
class="cartBtn"
type="button"
onclick="openCart()">

🛒 السلة

<span
class="badge"
id="cartCount">

0

</span>

</button>

</div>

</header>


<nav class="nav">

<div class="navin">

<button
class="active"
data-cat="الكل"
onclick="setCategory('الكل',this)">

الكل

</button>


<button
data-cat="خضروات"
onclick="setCategory('خضروات',this)">

🥬 خضروات

</button>


<button
data-cat="فواكه"
onclick="setCategory('فواكه',this)">

🍎 فواكه

</button>


<button
data-cat="لحوم"
onclick="setCategory('لحوم',this)">

🥩 لحوم

</button>


<button
data-cat="طيور"
onclick="setCategory('طيور',this)">

🍗 طيور

</button>


<button
data-cat="ماركت"
onclick="setCategory('ماركت',this)">

🛒 ماركت

</button>

</div>

</nav>


<main class="main">


<section class="hero">

<div>

<h1>
كل احتياجات بيتك في مكان واحد
</h1>

<p>
خضروات وفواكه طازة • لحوم • طيور • منتجات ماركت
</p>

<button
class="heroBtn"
type="button"
onclick="document.getElementById('products').scrollIntoView({behavior:'smooth'})">

تسوق الآن

</button>

</div>


<div class="heroEmoji">

🥬🍎

</div>

</section>



<div class="sectionTitle">

<h2>
الأقسام
</h2>

</div>


<div class="categories">


<button
class="cat"
onclick="setCategory('خضروات')">

<span class="catIcon">🥬</span>

خضروات

</button>


<button
class="cat"
onclick="setCategory('فواكه')">

<span class="catIcon">🍎</span>

فواكه

</button>


<button
class="cat"
onclick="setCategory('لحوم')">

<span class="catIcon">🥩</span>

لحوم

</button>


<button
class="cat"
onclick="setCategory('طيور')">

<span class="catIcon">🍗</span>

طيور

</button>


<button
class="cat"
onclick="setCategory('ماركت')">

<span class="catIcon">🛒</span>

ماركت

</button>


<button
class="cat"
onclick="openCart()">

<span class="catIcon">🛍️</span>

السلة

</button>


</div>



<div
class="sectionTitle"
id="products">

<h2>
المنتجات
</h2>

<span id="resultCount"></span>

</div>


<div
class="grid"
id="productGrid">
</div>


<div
id="empty"
class="empty"
style="display:none">

لا توجد منتجات مطابقة للبحث.

</div>


</main>



<footer>

<div class="footin">


<div>

<h2>
مول البركة
</h2>

<p>
جودة وطزاجة وأسعار مناسبة لبيتك.
</p>

</div>


<div>

<b>
خدمة العملاء
</b>

<p>
01119511185
</p>

</div>


<div>

<b>
العنوان
</b>

<p>
شارع الشيخ عبدالرحمن تاج البنفسج ٩
</p>

</div>


</div>

</footer>



<div
class="drawer"
id="drawer"
onclick="if(event.target===this)closeCart()">


<aside class="cart">


<div class="cartHead">

<h2>
سلة المشتريات
</h2>

<button
class="close"
type="button"
onclick="closeCart()">

✕

</button>

</div>


<div
class="items"
id="cartItems">
</div>


<div class="cartFoot">


<div class="total">

<span>
الإجمالي
</span>

<span id="cartTotal">
0 ج.م
</span>

</div>


<a
class="checkout"
href="checkout.html">

إتمام الطلب

</a>


<button
class="clear"
type="button"
onclick="clearCart()">

تفريغ السلة

</button>


</div>


</aside>

</div>



<div
class="toast"
id="toast">
</div>



<script>

const PRODUCTS =
<?php
echo json_encode(
$products,
JSON_UNESCAPED_UNICODE |
JSON_UNESCAPED_SLASHES
);
?>;


let cart = {};

let currentCategory = 'الكل';


try{

cart =
JSON.parse(
localStorage.getItem('albaraka_cart') || '{}'
);

if(!cart || typeof cart !== 'object'){

cart = {};

}

}catch(e){

cart = {};

}



function saveCart(){

localStorage.setItem(
'albaraka_cart',
JSON.stringify(cart)
);

updateCart();

}



function money(n){

return Number(n).toLocaleString('ar-EG') + ' ج.م';

}



function renderProducts(){

const input =
document.getElementById('search');

const q =
(input.value || '').trim().toLowerCase();


const list =
PRODUCTS.filter(function(p){

const categoryOK =
currentCategory === 'الكل' ||
p.category === currentCategory;


const searchOK =
!q ||
p.name.toLowerCase().includes(q) ||
p.category.toLowerCase().includes(q);


return categoryOK && searchOK;

});


document.getElementById('resultCount').textContent =
list.length + ' منتج';


document.getElementById('empty').style.display =
list.length ? 'none' : 'block';


document.getElementById('productGrid').innerHTML =
list.map(function(p){

return `

<article class="card">

<div class="pic">

${p.emoji}

</div>


<div class="cardBody">

<div class="catName">

${p.category}

</div>


<h3>

${p.name}

</h3>


<div class="price">

${money(p.price)}

<small>
/
${p.unit}
</small>

</div>


<button
class="add"
type="button"
onclick="addToCart(${p.id})">

أضف للسلة 🛒

</button>


</div>

</article>

`;

}).join('');

}



function setCategory(cat,btn){

currentCategory = cat;


document
.querySelectorAll('.nav button')
.forEach(function(b){

b.classList.remove('active');

});


if(btn){

btn.classList.add('active');

}else{

const target =
document.querySelector(
'.nav button[data-cat="'+cat+'"]'
);

if(target){

target.classList.add('active');

}

}


renderProducts();


document
.getElementById('products')
.scrollIntoView({
behavior:'smooth',
block:'start'
});

}



function addToCart(id){

const key = String(id);

cart[key] =
Number(cart[key] || 0) + 1;

saveCart();

showToast(
'تمت إضافة المنتج إلى السلة'
);

}



function changeQty(id,delta){

const key = String(id);

cart[key] =
Number(cart[key] || 0) + delta;


if(cart[key] <= 0){

delete cart[key];

}


saveCart();

}



function removeItem(id){

delete cart[String(id)];

saveCart();

showToast(
'تم حذف المنتج'
);

}



function clearCart(){

cart = {};

saveCart();

showToast(
'تم تفريغ السلة'
);

}



function updateCart(){

const entries =
Object.entries(cart)
.filter(function(entry){

const id = entry[0];

const qty = Number(entry[1]);


return PRODUCTS.some(function(p){

return String(p.id) === String(id);

}) && qty > 0;

});


let count = 0;

let total = 0;


entries.forEach(function(entry){

const id = entry[0];

const qty = Number(entry[1]);


const p =
PRODUCTS.find(function(x){

return String(x.id) === String(id);

});


if(p){

count += qty;

total += p.price * qty;

}

});


document.getElementById('cartCount').textContent =
count;


document.getElementById('cartTotal').textContent =
money(total);



if(!entries.length){

document.getElementById('cartItems').innerHTML =

'<div style="text-align:center;padding:60px 10px;color:#68736c">🛒<br><br>السلة فارغة<br>أضف منتجاتك من المتجر</div>';

return;

}



document.getElementById('cartItems').innerHTML =

entries.map(function(entry){

const id = entry[0];

const qty = Number(entry[1]);


const p =
PRODUCTS.find(function(x){

return String(x.id) === String(id);

});


return `

<div class="item">


<div class="itemPic">

${p.emoji}

</div>


<div>

<h4>
${p.name}
</h4>


<div class="itemPrice">

${money(p.price)}

</div>


<div class="qty">


<button
type="button"
onclick="changeQty(${p.id},-1)">

−

</button>


<b>
${qty}
</b>


<button
type="button"
onclick="changeQty(${p.id},1)">

+

</button>


</div>


</div>


<button
class="remove"
type="button"
onclick="removeItem(${p.id})">

حذف

</button>


</div>

`;

}).join('');

}



function openCart(){

updateCart();

document
.getElementById('drawer')
.classList.add('open');

document.body.style.overflow =
'hidden';

}



function closeCart(){

document
.getElementById('drawer')
.classList.remove('open');

document.body.style.overflow =
'';

}



function showToast(text){

const t =
document.getElementById('toast');

t.textContent =
text;

t.classList.add('show');


clearTimeout(
window.toastTimer
);


window.toastTimer =
setTimeout(function(){

t.classList.remove('show');

},1800);

}



document
.getElementById('search')
.addEventListener(
'input',
renderProducts
);


renderProducts();

updateCart();

</script>


</body>
</html>
