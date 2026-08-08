<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* =========================
   المنتجات
========================= */

$products = [
    1 => [
        'name' => 'طماطم بلدي',
        'category' => 'خضروات',
        'price' => 25,
        'emoji' => '🍅'
    ],
    2 => [
        'name' => 'بطاطس',
        'category' => 'خضروات',
        'price' => 30,
        'emoji' => '🥔'
    ],
    3 => [
        'name' => 'خيار',
        'category' => 'خضروات',
        'price' => 35,
        'emoji' => '🥒'
    ],
    4 => [
        'name' => 'موز',
        'category' => 'فواكه',
        'price' => 45,
        'emoji' => '🍌'
    ],
    5 => [
        'name' => 'تفاح',
        'category' => 'فواكه',
        'price' => 70,
        'emoji' => '🍎'
    ],
    6 => [
        'name' => 'برتقال',
        'category' => 'فواكه',
        'price' => 40,
        'emoji' => '🍊'
    ],
    7 => [
        'name' => 'فراخ كاملة',
        'category' => 'طيور',
        'price' => 150,
        'emoji' => '🍗'
    ],
    8 => [
        'name' => 'لحمة بلدي',
        'category' => 'لحوم',
        'price' => 420,
        'emoji' => '🥩'
    ],
    9 => [
        'name' => 'أرز',
        'category' => 'ماركت',
        'price' => 35,
        'emoji' => '🍚'
    ],
    10 => [
        'name' => 'سكر',
        'category' => 'ماركت',
        'price' => 30,
        'emoji' => '🧂'
    ],
    11 => [
        'name' => 'فلفل أسود',
        'category' => 'عطارة',
        'price' => 25,
        'emoji' => '🌶️'
    ],
    12 => [
        'name' => 'كمون',
        'category' => 'عطارة',
        'price' => 30,
        'emoji' => '🌿'
    ]
];

/* =========================
   عمليات السلة
========================= */

if (isset($_GET['action'], $_GET['id'])) {

    $action = $_GET['action'];
    $id = (int) $_GET['id'];

    if (isset($products[$id])) {

        if ($action === 'add') {
            $_SESSION['cart'][$id] =
                ($_SESSION['cart'][$id] ?? 0) + 1;
        }

        if ($action === 'plus') {
            $_SESSION['cart'][$id] =
                ($_SESSION['cart'][$id] ?? 0) + 1;
        }

        if ($action === 'minus') {
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]--;

                if ($_SESSION['cart'][$id] <= 0) {
                    unset($_SESSION['cart'][$id]);
                }
            }
        }

        if ($action === 'remove') {
            unset($_SESSION['cart'][$id]);
        }
    }

    header('Location: index.php');
    exit;
}

if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header('Location: index.php');
    exit;
}

/* =========================
   حساب السلة
========================= */

$cartCount = 0;
$cartTotal = 0;

foreach ($_SESSION['cart'] as $id => $qty) {

    if (isset($products[$id])) {
        $cartCount += $qty;
        $cartTotal += $products[$id]['price'] * $qty;
    }
}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>مول البركة أولاد الجارحي</title>

<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Tahoma, Arial, sans-serif;
    background: #f5f7f5;
    color: #222;
}

/* HEADER */

header {
    background: #00843d;
    color: white;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 3px 15px rgba(0,0,0,.15);
}

.header {
    max-width: 1250px;
    margin: auto;
    min-height: 75px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 10px 15px;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    white-space: nowrap;
}

.search {
    flex: 1;
    max-width: 600px;
}

.search input {
    width: 100%;
    border: none;
    outline: none;
    padding: 14px 20px;
    border-radius: 30px;
    font-size: 15px;
}

.cart-button {
    position: relative;
    border: none;
    background: white;
    color: #00843d;
    padding: 13px 18px;
    border-radius: 15px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
}

.cart-count {
    position: absolute;
    top: -8px;
    left: -8px;
    background: #e53935;
    color: white;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
}

/* HERO */

.hero {
    max-width: 1250px;
    margin: 25px auto;
    padding: 45px 30px;
    border-radius: 25px;
    background: linear-gradient(135deg,#00843d,#00a94f);
    color: white;
    box-shadow: 0 8px 30px rgba(0,0,0,.12);
}

.hero h1 {
    font-size: 38px;
    margin: 0 0 12px;
}

.hero p {
    font-size: 18px;
}

/* CATEGORIES */

.categories {
    max-width: 1250px;
    margin: 25px auto;
    padding: 0 15px;
    display: flex;
    gap: 10px;
    overflow-x: auto;
}

.category {
    background: white;
    padding: 13px 20px;
    border-radius: 30px;
    white-space: nowrap;
    cursor: pointer;
    box-shadow: 0 3px 12px rgba(0,0,0,.07);
}

.category:hover {
    background: #00843d;
    color: white;
}

/* PRODUCTS */

.products {
    max-width: 1250px;
    margin: auto;
    padding: 0 15px 60px;
}

.products h2 {
    font-size: 28px;
}

.grid {
    display: grid;
    grid-template-columns:
        repeat(4, minmax(0,1fr));
    gap: 18px;
}

.product {
    background: white;
    border-radius: 18px;
    padding: 15px;
    box-shadow: 0 4px 18px rgba(0,0,0,.07);
    transition: .2s;
}

.product:hover {
    transform: translateY(-4px);
}

.product-image {
    height: 180px;
    border-radius: 15px;
    background: #f1f4f1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 80px;
}

.category-name {
    color: #777;
    font-size: 13px;
    margin-top: 12px;
}

.product h3 {
    margin: 7px 0;
}

.price {
    color: #00843d;
    font-size: 20px;
    font-weight: bold;
}

.add {
    display: block;
    width: 100%;
    margin-top: 12px;
    padding: 12px;
    background: #00843d;
    color: white;
    border-radius: 12px;
    text-decoration: none;
    text-align: center;
    font-weight: bold;
}

.add:hover {
    background: #006b32;
}

/* CART DRAWER */

.overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.5);
    display: none;
    z-index: 1999;
}

.overlay.active {
    display: block;
}

.cart {
    position: fixed;
    top: 0;
    left: -430px;
    width: 420px;
    max-width: 94%;
    height: 100vh;
    background: white;
    z-index: 2000;
    transition: .3s;
    display: flex;
    flex-direction: column;
    box-shadow: 5px 0 25px rgba(0,0,0,.2);
}

.cart.active {
    left: 0;
}

.cart-head {
    background: #00843d;
    color: white;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.cart-head h2 {
    margin: 0;
}

.close {
    border: none;
    background: white;
    color: #00843d;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 20px;
}

.cart-items {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
}

.cart-item {
    border-bottom: 1px solid #eee;
    padding: 15px 0;
}

.cart-item-name {
    font-weight: bold;
    font-size: 16px;
}

.cart-item-price {
    color: #00843d;
    font-weight: bold;
    margin: 5px 0;
}

.cart-controls {
    display: flex;
    align-items: center;
    gap: 8px;
}

.cart-controls a {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #00843d;
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.remove {
    margin-right: auto;
    color: #d32f2f !important;
    background: transparent !important;
    width: auto !important;
}

.cart-footer {
    padding: 18px;
    border-top: 1px solid #eee;
}

.total {
    display: flex;
    justify-content: space-between;
    font-size: 21px;
    font-weight: bold;
    margin-bottom: 15px;
}

.checkout {
    display: block;
    text-align: center;
    background: #00843d;
    color: white;
    text-decoration: none;
    padding: 15px;
    border-radius: 12px;
    font-weight: bold;
}

.clear {
    display: block;
    text-align: center;
    margin-top: 8px;
    color: #d32f2f;
    text-decoration: none;
    padding: 8px;
}

.empty {
    text-align: center;
    padding: 60px 20px;
    color: #777;
}

.empty-icon {
    font-size: 70px;
}

/* MOBILE */

@media(max-width:900px) {

    .grid {
        grid-template-columns:
            repeat(2, minmax(0,1fr));
    }

    .hero h1 {
        font-size: 28px;
    }

}

@media(max-width:600px) {

    .header {
        flex-wrap: wrap;
    }

    .logo {
        font-size: 19px;
    }

    .search {
        order: 3;
        flex-basis: 100%;
    }

    .grid {
        grid-template-columns: repeat(2,1fr);
        gap: 10px;
    }

    .product {
        padding: 10px;
    }

    .product-image {
        height: 130px;
        font-size: 60px;
    }

    .hero {
        margin: 15px;
        padding: 30px 20px;
    }

}

</style>

</head>

<body>


<header>

<div class="header">

<div class="logo">
🛒 مول البركة
</div>

<div class="search">
<input
type="text"
id="search"
placeholder="ابحث عن خضروات، فواكه، لحوم، ماركت...">
</div>

<button
class="cart-button"
onclick="openCart()">

🛒 السلة

<span class="cart-count">
<?php echo $cartCount; ?>
</span>

</button>

</div>

</header>


<section class="hero">

<h1>
أهلاً بك في مول البركة 🛒
</h1>

<p>
خضروات وفواكه طازة • لحوم • طيور • ماركت • عطارة
</p>

<p>
اطلب كل احتياجات بيتك بسهولة
</p>

</section>


<div class="categories">

<div class="category">
🥬 خضروات
</div>

<div class="category">
🍎 فواكه
</div>

<div class="category">
🥩 لحوم
</div>

<div class="category">
🍗 طيور
</div>

<div class="category">
🛒 ماركت
</div>

<div class="category">
🌿 عطارة
</div>

</div>


<section class="products">

<h2>
منتجاتنا
</h2>

<div class="grid" id="products">

<?php foreach ($products as $id => $product): ?>

<div
class="product"
data-name="<?php echo htmlspecialchars($product['name']); ?>"
data-category="<?php echo htmlspecialchars($product['category']); ?>">

<div class="product-image">
<?php echo $product['emoji']; ?>
</div>

<div class="category-name">
<?php echo htmlspecialchars($product['category']); ?>
</div>

<h3>
<?php echo htmlspecialchars($product['name']); ?>
</h3>

<div class="price">
<?php echo number_format($product['price']); ?> جنيه
</div>

<a
class="add"
href="index.php?action=add&id=<?php echo $id; ?>">

➕ أضف للسلة

</a>

</div>

<?php endforeach; ?>

</div>

</section>


<!-- OVERLAY -->

<div
class="overlay"
id="overlay"
onclick="closeCart()">
</div>


<!-- CART -->

<div
class="cart"
id="cart">

<div class="cart-head">

<h2>
🛒 سلة مشترياتك
</h2>

<button
class="close"
onclick="closeCart()">
×
</button>

</div>


<div class="cart-items">

<?php if (empty($_SESSION['cart'])): ?>

<div class="empty">

<div class="empty-icon">
🛒
</div>

<h3>
السلة فارغة
</h3>

<p>
أضف منتجاتك المفضلة للبدء
</p>

</div>

<?php else: ?>

<?php foreach ($_SESSION['cart'] as $id => $qty): ?>

<?php if (isset($products[$id])): ?>

<?php
$p = $products[$id];
$subtotal = $p['price'] * $qty;
?>

<div class="cart-item">

<div class="cart-item-name">
<?php echo htmlspecialchars($p['name']); ?>
</div>

<div class="cart-item-price">
<?php echo number_format($subtotal); ?> جنيه
</div>

<div class="cart-controls">

<a
href="index.php?action=minus&id=<?php echo $id; ?>">
−
</a>

<strong>
<?php echo $qty; ?>
</strong>

<a
href="index.php?action=plus&id=<?php echo $id; ?>">
+
</a>

<a
class="remove"
href="index.php?action=remove&id=<?php echo $id; ?>">
حذف
</a>

</div>

</div>

<?php endif; ?>

<?php endforeach; ?>

<?php endif; ?>

</div>


<?php if (!empty($_SESSION['cart'])): ?>

<div class="cart-footer">

<div class="total">

<span>
الإجمالي
</span>

<span>
<?php echo number_format($cartTotal); ?> جنيه
</span>

</div>

<a
class="checkout"
href="checkout.php">

إتمام الطلب

</a>

<a
class="clear"
href="index.php?clear=1"
onclick="return confirm('هل تريد تفريغ السلة؟');">

تفريغ السلة

</a>

</div>

<?php endif; ?>

</div>


<script>

/* فتح السلة */

function openCart() {

    document
    .getElementById('cart')
    .classList
    .add('active');

    document
    .getElementById('overlay')
    .classList
    .add('active');

}


/* إغلاق السلة */

function closeCart() {

    document
    .getElementById('cart')
    .classList
    .remove('active');

    document
    .getElementById('overlay')
    .classList
    .remove('active');

}


/* البحث */

document
.getElementById('search')
.addEventListener('input', function () {

    let value =
        this.value
        .trim()
        .toLowerCase();

    document
    .querySelectorAll('.product')
    .forEach(function(product) {

        let name =
            product.dataset.name
            .toLowerCase();

        let category =
            product.dataset.category
            .toLowerCase();

        if (
            name.includes(value) ||
            category.includes(value)
        ) {

            product.style.display = '';

        } else {

            product.style.display = 'none';

        }

    });

});

</script>

</body>
</html>
