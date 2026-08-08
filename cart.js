<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>سلة المشتريات | مول البركة</title>

    <meta
        name="description"
        content="سلة مشتريات مول البركة أولاد الجارحي"
    >

    <link
        rel="stylesheet"
        href="style.css"
    >

    <style>

        /* =================================================
           CART PAGE
        ================================================= */

        .cart-page {
            max-width: 1240px;
            margin: 35px auto 70px;
            padding: 0 15px;
        }

        .cart-title {
            margin-bottom: 25px;
        }

        .cart-title span {
            color: #087f3f;
            font-size: 13px;
            font-weight: 900;
        }

        .cart-title h1 {
            margin-top: 4px;
            font-size: 34px;
        }

        .cart-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 350px;
            gap: 20px;
            align-items: start;
        }

        .cart-items-box,
        .cart-summary {
            background: #fff;
            border: 1px solid #e3ebe6;
            border-radius: 22px;
            box-shadow: 0 8px 30px rgba(0,0,0,.04);
        }

        .cart-items-box {
            overflow: hidden;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 90px minmax(0,1fr) auto;
            align-items: center;
            gap: 18px;
            padding: 18px;
            border-bottom: 1px solid #edf1ee;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-image {
            width: 90px;
            height: 90px;
            border-radius: 18px;
            background: #eff9f2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
        }

        .cart-item-info h3 {
            font-size: 17px;
            margin-bottom: 2px;
        }

        .cart-item-info small {
            color: #89948e;
            font-size: 11px;
        }

        .cart-item-price {
            margin-top: 5px;
            color: #087f3f;
            font-weight: 900;
        }

        .quantity-box {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
        }

        .quantity-box button {
            width: 31px;
            height: 31px;
            border: 1px solid #dce7e0;
            background: #fff;
            border-radius: 9px;
            cursor: pointer;
            font-size: 17px;
            font-weight: 900;
        }

        .quantity-box button:hover {
            background: #087f3f;
            color: #fff;
        }

        .quantity-box strong {
            min-width: 28px;
            text-align: center;
        }

        .cart-item-total {
            text-align: left;
            font-weight: 900;
            color: #17221b;
            min-width: 100px;
        }

        .remove-item {
            border: none;
            background: transparent;
            color: #b14d4d;
            cursor: pointer;
            margin-top: 8px;
            font-size: 12px;
        }

        .remove-item:hover {
            text-decoration: underline;
        }

        .cart-summary {
            padding: 22px;
            position: sticky;
            top: 105px;
        }

        .cart-summary h2 {
            font-size: 21px;
            margin-bottom: 18px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 10px 0;
            color: #65726a;
            border-bottom: 1px dashed #e1e8e3;
        }

        .summary-row strong {
            color: #17221b;
        }

        .summary-total {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 17px;
            padding-top: 15px;
            border-top: 2px solid #edf1ee;
        }

        .summary-total span {
            font-weight: 900;
        }

        .summary-total strong {
            color: #087f3f;
            font-size: 25px;
        }

        .checkout-button {
            width: 100%;
            margin-top: 18px;
            min-height: 50px;
            border: none;
            border-radius: 13px;
            background: #087f3f;
            color: #fff;
            cursor: pointer;
            font-weight: 900;
            font-size: 15px;
        }

        .checkout-button:hover {
            background: #056d35;
        }

        .continue-button {
            width: 100%;
            margin-top: 9px;
            min-height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #dce7e0;
            border-radius: 13px;
            color: #08783c;
            background: #fff;
            font-weight: 900;
        }

        .clear-cart-button {
            width: 100%;
            margin-top: 9px;
            min-height: 40px;
            border: none;
            background: transparent;
            color: #a24b4b;
            cursor: pointer;
            font-weight: 700;
        }

        .empty-cart {
            padding: 65px 20px;
            text-align: center;
        }

        .empty-cart-icon {
            font-size: 65px;
            margin-bottom: 10px;
        }

        .empty-cart h2 {
            font-size: 25px;
            margin-bottom: 5px;
        }

        .empty-cart p {
            color: #7b867f;
            margin-bottom: 20px;
        }

        .empty-cart a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 45px;
            padding: 10px 22px;
            background: #087f3f;
            color: #fff;
            border-radius: 12px;
            font-weight: 900;
        }

        .cart-note {
            margin-top: 15px;
            padding: 13px;
            border-radius: 12px;
            background: #eff9f2;
            color: #526158;
            font-size: 12px;
            line-height: 1.8;
        }

        @media (max-width: 800px) {

            .cart-layout {
                grid-template-columns: 1fr;
            }

            .cart-summary {
                position: static;
            }

        }

        @media (max-width: 560px) {

            .cart-page {
                margin-top: 22px;
            }

            .cart-title h1 {
                font-size: 28px;
            }

            .cart-item {
                grid-template-columns: 65px minmax(0,1fr);
                gap: 12px;
                padding: 13px;
            }

            .cart-item-image {
                width: 65px;
                height: 65px;
                font-size: 34px;
            }

            .cart-item-info h3 {
                font-size: 14px;
            }

            .cart-item-total {
                grid-column: 2;
                text-align: right;
                min-width: auto;
            }

            .remove-item {
                display: block;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     TOP BAR
===================================================== -->

<div class="topbar">

    <div>
        🚚 توصيل سريع
    </div>

    <div>
        💳 كاش أو فيزا
    </div>

    <div>
        💬 01119511185
    </div>

</div>


<!-- =====================================================
     HEADER
===================================================== -->

<header class="header">

    <a
        href="index.html"
        class="brand"
    >

        <div class="brand-mark">
            ب
        </div>

        <div class="brand-text">

            <strong>
                مول البركة
            </strong>

            <small>
                أولاد الجارحي
            </small>

        </div>

    </a>


    <div class="search-box">

        <span class="search-icon">
            🔍
        </span>

        <input
            type="text"
            placeholder="ابحث عن منتج..."
            onkeydown="
                if(event.key === 'Enter'){
                    window.location.href =
                    'index.html#products';
                }
            "
        >

    </div>


    <a
        href="index.html"
        class="header-account"
    >
        🏠 الرئيسية
    </a>


    <a
        href="cart.html"
        class="cart-button"
    >

        🛒

        <span>
            السلة
        </span>

        <b id="cartCount">
            0
        </b>

    </a>

</header>


<!-- =====================================================
     NAV
===================================================== -->

<nav class="main-nav">

    <a href="index.html">
        الرئيسية
    </a>

    <a href="index.html#categories">
        الأقسام
    </a>

    <a href="index.html#offers">
        🔥 العروض
    </a>

    <a href="index.html#products">
        المنتجات
    </a>

    <a
        href="cart.html"
        class="active"
    >
        🛒 السلة
    </a>

</nav>


<!-- =====================================================
     CART
===================================================== -->

<main class="cart-page">


    <div class="cart-title">

        <span>
            مول البركة
        </span>

        <h1>
            🛒 سلة المشتريات
        </h1>

    </div>


    <div class="cart-layout">


        <!-- =============================================
             ITEMS
        ============================================== -->

        <section
            class="cart-items-box"
            id="cartItems"
        >

        </section>


        <!-- =============================================
             SUMMARY
        ============================================== -->

        <aside
            class="cart-summary"
            id="cartSummary"
        >

            <h2>
                ملخص الطلب
            </h2>


            <div class="summary-row">

                <span>
                    عدد المنتجات
                </span>

                <strong id="summaryItems">
                    0
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    إجمالي المنتجات
                </span>

                <strong id="summarySubtotal">
                    0 ج.م
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    التوصيل
                </span>

                <strong>
                    يتم تحديده
                </strong>

            </div>


            <div class="summary-total">

                <span>
                    الإجمالي
                </span>

                <strong id="summaryTotal">
                    0 ج.م
                </strong>

            </div>


            <a
                href="checkout.html"
                class="checkout-button"
                id="checkoutButton"
            >

                إكمال الطلب ←

            </a>


            <a
                href="index.html#products"
                class="continue-button"
            >

                مواصلة التسوق

            </a>


            <button
                type="button"
                class="clear-cart-button"
                id="clearCartButton"
            >

                🗑️ تفريغ السلة

            </button>


            <div class="cart-note">

                💬 بعد إتمام البيانات،
                سيتم تجهيز رسالة الطلب
                وإرسالها إلى واتساب
                <strong>01119511185</strong>.

            </div>

        </aside>


    </div>

</main>


<!-- =====================================================
     FOOTER
===================================================== -->

<footer>

    <strong>
        مول البركة – أولاد الجارحي
    </strong>

    <span>
        خضروات • فواكه • لحوم • طيور • ماركت • عطارة
    </span>

    <a
        href="https://wa.me/201119511185"
        target="_blank"
        rel="noopener"
    >
        💬 واتساب: 01119511185
    </a>

</footer>


<!-- =====================================================
     APP
===================================================== -->

<script src="app.js"></script>


<script>

"use strict";


/* =====================================================
   CART PAGE RENDER
===================================================== */

function renderCartPage() {

    const cartItems =
        document.getElementById("cartItems");

    const summaryItems =
        document.getElementById("summaryItems");

    const summarySubtotal =
        document.getElementById("summarySubtotal");

    const summaryTotal =
        document.getElementById("summaryTotal");

    const checkoutButton =
        document.getElementById("checkoutButton");


    if (!cartItems) {
        return;
    }


    const currentCart =
        window.getCart();


    /* ================================================
       EMPTY CART
    ================================================= */

    if (
        !Array.isArray(currentCart) ||
        currentCart.length === 0
    ) {

        cartItems.innerHTML = `

            <div class="empty-cart">

                <div class="empty-cart-icon">
                    🛒
                </div>

                <h2>
                    السلة فارغة
                </h2>

                <p>
                    لم تضف أي منتجات إلى السلة حتى الآن.
                </p>

                <a href="index.html#products">
                    ابدأ التسوق
                </a>

            </div>

        `;


        summaryItems.textContent = "0";

        summarySubtotal.textContent =
            "0 ج.م";

        summaryTotal.textContent =
            "0 ج.م";


        checkoutButton.style.pointerEvents =
            "none";

        checkoutButton.style.opacity =
            "0.5";


        return;

    }


    /* ================================================
       ACTIVE CART
    ================================================= */

    checkoutButton.style.pointerEvents =
        "auto";

    checkoutButton.style.opacity =
        "1";


    let totalItems = 0;

    let totalPrice = 0;


    cartItems.innerHTML =
        currentCart.map(item => {

            const quantity =
                Number(item.quantity || 0);

            const price =
                Number(item.price || 0);

            const itemTotal =
                quantity * price;


            totalItems += quantity;

            totalPrice += itemTotal;


            return `

                <article class="cart-item">


                    <div class="cart-item-image">

                        ${item.emoji || "🛒"}

                    </div>


                    <div class="cart-item-info">

                        <small>
                            ${escapeCartHTML(
                                item.category || ""
                            )}
                        </small>

                        <h3>
                            ${escapeCartHTML(
                                item.name || ""
                            )}
                        </h3>

                        <div class="cart-item-price">

                            ${window.formatPrice(price)}

                            <small>
                                / ${escapeCartHTML(
                                    item.unit || ""
                                )}
                            </small>

                        </div>


                        <div class="quantity-box">

                            <button
                                type="button"
                                onclick="
                                    decreaseQuantity(${item.id})
                                "
                                aria-label="تقليل الكمية"
                            >
                                −
                            </button>


                            <strong>
                                ${quantity}
                            </strong>


                            <button
                                type="button"
                                onclick="
                                    increaseQuantity(${item.id})
                                "
                                aria-label="زيادة الكمية"
                            >
                                +
                            </button>

                        </div>


                        <button
                            type="button"
                            class="remove-item"
                            onclick="
                                removeFromCart(${item.id})
                            "
                        >

                            🗑️ حذف المنتج

                        </button>

                    </div>


                    <div class="cart-item-total">

                        ${window.formatPrice(itemTotal)}

                    </div>


                </article>

            `;

        }).join("");


    summaryItems.textContent =
        totalItems;


    summarySubtotal.textContent =
        window.formatPrice(totalPrice);


    summaryTotal.textContent =
        window.formatPrice(totalPrice);

}


/* =====================================================
   ESCAPE
===================================================== */

function escapeCartHTML(value) {

    return String(value)
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");

}


/* =====================================================
   CLEAR CART
===================================================== */

document
    .getElementById("clearCartButton")
    .addEventListener(
        "click",
        function() {

            const currentCart =
                window.getCart();


            if (
                !Array.isArray(currentCart) ||
                currentCart.length === 0
            ) {

                return;

            }


            const confirmed =
                window.confirm(
                    "هل تريد تفريغ السلة بالكامل؟"
                );


            if (!confirmed) {
                return;
            }


            window.clearCart();

            renderCartPage();

            window.showToast(
                "تم تفريغ السلة"
            );

        }
    );


/* =====================================================
   UPDATE AFTER CART CHANGE
===================================================== */

window.renderCartPage =
    renderCartPage;


/* =====================================================
   START
===================================================== */

document.addEventListener(
    "DOMContentLoaded",
    function() {

        window.updateCartCount();

        renderCartPage();

    }
);

</script>


</body>

</html>
