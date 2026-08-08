<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>سلة المشتريات | مول البركة</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f7f6;
            color: #222;
            font-family:
                Tahoma,
                Arial,
                sans-serif;
        }

        a {
            text-decoration: none;
        }

        .topbar {
            background: #00843d;
            min-height: 110px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 5%;
            gap: 20px;
        }

        .logo {
            color: #d4a72c;
            font-size: 30px;
            font-weight: 900;
            white-space: nowrap;
        }

        .continue-shopping {
            background: white;
            color: #087b3d;
            padding: 16px 28px;
            border-radius: 16px;
            font-size: 20px;
            font-weight: bold;
            display: inline-block;
        }

        .page {
            width: min(1100px, 94%);
            margin: 35px auto 70px;
        }

        .title {
            font-size: 38px;
            font-weight: 900;
            margin: 0 0 30px;
        }

        .cart-box {
            background: white;
            border-radius: 22px;
            padding: 25px;
            box-shadow: 0 8px 35px rgba(0,0,0,.07);
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item:last-child {
            border-bottom: 0;
        }

        .item-image {
            width: 95px;
            height: 95px;
            border-radius: 18px;
            background: #f1f7f3;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            font-size: 45px;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 8px;
        }

        .item-unit {
            color: #777;
            margin-bottom: 8px;
        }

        .item-price {
            color: #087f3f;
            font-weight: bold;
            font-size: 18px;
        }

        .quantity {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f3f5f4;
            padding: 6px;
            border-radius: 14px;
        }

        .quantity button {
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 10px;
            background: #087f3f;
            color: white;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
        }

        .quantity span {
            min-width: 35px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .item-total {
            min-width: 120px;
            text-align: center;
            font-weight: 900;
            color: #222;
            font-size: 18px;
        }

        .remove {
            border: 0;
            background: #fff0f0;
            color: #c62828;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            font-size: 20px;
            cursor: pointer;
        }

        .summary {
            margin-top: 25px;
            background: #f7faf8;
            border-radius: 18px;
            padding: 22px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 20px;
            margin-bottom: 12px;
        }

        .summary-total {
            border-top: 1px solid #ddd;
            padding-top: 15px;
            font-size: 27px;
            font-weight: 900;
            color: #087f3f;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .checkout {
            flex: 1;
            border: 0;
            background: #087f3f;
            color: white;
            padding: 17px;
            border-radius: 14px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .clear {
            border: 0;
            background: #eee;
            color: #333;
            padding: 17px 25px;
            border-radius: 14px;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
        }

        .empty {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 75px;
            margin-bottom: 15px;
        }

        .empty h2 {
            font-size: 30px;
            margin: 10px 0;
        }

        .empty p {
            color: #777;
            font-size: 17px;
        }

        .empty a {
            display: inline-block;
            margin-top: 15px;
            background: #087f3f;
            color: white;
            padding: 15px 30px;
            border-radius: 13px;
            font-weight: bold;
        }

        .loading {
            text-align: center;
            padding: 70px 20px;
            color: #777;
            font-size: 22px;
        }

        .error {
            text-align: center;
            padding: 50px 20px;
            color: #b3261e;
        }

        .toast {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 999999;
            background: #087f3f;
            color: white;
            padding: 14px 20px;
            border-radius: 13px;
            box-shadow: 0 10px 30px rgba(0,0,0,.2);
            opacity: 0;
            transform: translateY(20px);
            transition: .25s;
            font-weight: bold;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 700px) {

            .topbar {
                min-height: 90px;
                padding: 15px 4%;
            }

            .logo {
                font-size: 23px;
            }

            .continue-shopping {
                padding: 12px 15px;
                font-size: 15px;
            }

            .page {
                width: 94%;
                margin-top: 25px;
            }

            .title {
                font-size: 30px;
            }

            .cart-box {
                padding: 15px;
            }

            .cart-item {
                flex-wrap: wrap;
                gap: 12px;
            }

            .item-image {
                width: 75px;
                height: 75px;
            }

            .item-info {
                min-width: calc(100% - 100px);
            }

            .item-name {
                font-size: 18px;
            }

            .quantity {
                margin-right: 85px;
            }

            .item-total {
                min-width: auto;
                margin-right: auto;
            }

            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<header class="topbar">

    <div class="logo">
        🛒 مول البركة
    </div>

    <a
        href="index.html"
        class="continue-shopping"
    >
        ← متابعة التسوق
    </a>

</header>


<main class="page">

    <h1 class="title">
        🛒 سلة المشتريات
    </h1>

    <div
        id="cartContent"
        class="cart-box"
    >

        <div class="loading">
            جاري تحميل السلة...
        </div>

    </div>

</main>


<div
    id="toast"
    class="toast"
></div>


<script>

"use strict";

/* =====================================================
   إعدادات المتجر
===================================================== */

const CART_KEY = "albaraka_cart";
const PRODUCTS_FILE = "products.json";


/* =====================================================
   قراءة السلة فورًا
===================================================== */

let cart = [];

try {

    const saved =
        localStorage.getItem(CART_KEY);

    if (saved) {

        const parsed =
            JSON.parse(saved);

        if (Array.isArray(parsed)) {
            cart = parsed;
        }

    }

} catch (error) {

    console.error(
        "خطأ في قراءة السلة:",
        error
    );

    cart = [];

}


/* =====================================================
   أدوات
===================================================== */

function money(value) {

    return Number(value || 0)
        .toLocaleString("ar-EG") +
        " جنيه";

}


function escapeHTML(value) {

    return String(value ?? "")
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");

}


function saveCart() {

    localStorage.setItem(
        CART_KEY,
        JSON.stringify(cart)
    );

}


function cartCount() {

    return cart.reduce(
        (total, item) =>
            total +
            Number(item.quantity || 0),
        0
    );

}


function cartTotal() {

    return cart.reduce(
        (total, item) =>
            total +
            Number(item.price || 0) *
            Number(item.quantity || 0),
        0
    );

}


/* =====================================================
   رسالة
===================================================== */

function toast(message) {

    const element =
        document.getElementById("toast");

    element.textContent = message;

    element.classList.add("show");

    clearTimeout(
        element._timer
    );

    element._timer =
        setTimeout(
            function() {

                element.classList.remove(
                    "show"
                );

            },
            2200
        );

}


/* =====================================================
   تحديث بيانات المنتجات من products.json
===================================================== */

async function syncProducts() {

    try {

        const response =
            await fetch(
                PRODUCTS_FILE +
                "?v=" +
                Date.now(),
                {
                    cache: "no-store"
                }
            );

        if (!response.ok) {
            throw new Error(
                "products.json غير موجود"
            );
        }

        const data =
            await response.json();

        const products =
            Array.isArray(data.products)
                ? data.products
                : [];

        /*
         * تحديث السعر والاسم والوحدة والصورة
         * الموجودة في السلة من products.json
         */

        cart = cart
            .map(function(item) {

                const product =
                    products.find(
                        function(p) {
                            return String(p.id) ===
                                String(item.id);
                        }
                    );

                if (!product) {
                    return item;
                }

                return {

                    ...item,

                    name:
                        product.name ||
                        item.name,

                    price:
                        Number(
                            product.price ??
                            item.price ??
                            0
                        ),

                    unit:
                        product.unit ||
                        item.unit ||
                        "قطعة",

                    image:
                        product.image ||
                        item.image ||
                        "",

                    emoji:
                        product.emoji ||
                        item.emoji ||
                        "🛒"

                };

            })
            .filter(function(item) {

                /*
                 * لو المنتج تم تعطيله في products.json
                 * لا نحذفه من السلة تلقائيًا.
                 */

                return item;

            });

        saveCart();

    } catch (error) {

        console.warn(
            "تعذر تحديث المنتجات من products.json:",
            error
        );

        /*
         * حتى لو فشل products.json
         * السلة ستظهر بالبيانات المحفوظة.
         */

    }

}


/* =====================================================
   عرض السلة
===================================================== */

function renderCart() {

    const container =
        document.getElementById(
            "cartContent"
        );

    if (!container) {
        return;
    }


    /* السلة فارغة */

    if (!cart.length) {

        container.innerHTML = `

            <div class="empty">

                <div class="empty-icon">
                    🛒
                </div>

                <h2>
                    السلة فارغة
                </h2>

                <p>
                    أضف المنتجات التي تريدها
                    للمتابعة.
                </p>

                <a href="index.html">
                    ابدأ التسوق
                </a>

            </div>

        `;

        return;

    }


    /* المنتجات */

    let html = "";


    cart.forEach(
        function(item) {

            const id =
                escapeHTML(item.id);

            const name =
                escapeHTML(item.name);

            const unit =
                escapeHTML(
                    item.unit ||
                    "قطعة"
                );

            const quantity =
                Number(
                    item.quantity || 1
                );

            const price =
                Number(
                    item.price || 0
                );

            const total =
                price * quantity;


            let imageHTML;


            if (item.image) {

                imageHTML = `

                    <img
                        src="${escapeHTML(item.image)}"
                        alt="${name}"
                        onerror="
                            this.style.display='none';
                            this.parentElement.innerHTML='${escapeHTML(item.emoji || "🛒")}';
                        "
                    >

                `;

            } else {

                imageHTML =
                    escapeHTML(
                        item.emoji ||
                        "🛒"
                    );

            }


            html += `

                <div
                    class="cart-item"
                    data-id="${id}"
                >

                    <div class="item-image">
                        ${imageHTML}
                    </div>


                    <div class="item-info">

                        <div class="item-name">
                            ${name}
                        </div>

                        <div class="item-unit">
                            ${unit}
                        </div>

                        <div class="item-price">
                            ${money(price)}
                        </div>

                    </div>


                    <div class="quantity">

                        <button
                            type="button"
                            onclick="changeQuantity('${id}', -1)"
                        >
                            −
                        </button>

                        <span>
                            ${quantity}
                        </span>

                        <button
                            type="button"
                            onclick="changeQuantity('${id}', 1)"
                        >
                            +
                        </button>

                    </div>


                    <div class="item-total">
                        ${money(total)}
                    </div>


                    <button
                        type="button"
                        class="remove"
                        onclick="removeItem('${id}')"
                    >
                        🗑️
                    </button>

                </div>

            `;

        }
    );


    /* الملخص */

    html += `

        <div class="summary">

            <div class="summary-row">

                <span>
                    عدد المنتجات
                </span>

                <strong>
                    ${cartCount()}
                </strong>

            </div>


            <div class="summary-row summary-total">

                <span>
                    الإجمالي
                </span>

                <strong>
                    ${money(cartTotal())}
                </strong>

            </div>


            <div class="actions">

                <button
                    type="button"
                    class="checkout"
                    onclick="goCheckout()"
                >
                    إتمام الطلب
                </button>

                <button
                    type="button"
                    class="clear"
                    onclick="clearCart()"
                >
                    إفراغ السلة
                </button>

            </div>

        </div>

    `;


    container.innerHTML = html;

}


/* =====================================================
   تغيير الكمية
===================================================== */

function changeQuantity(
    productId,
    amount
) {

    const item =
        cart.find(
            function(product) {

                return String(product.id) ===
                    String(productId);

            }
        );


    if (!item) {
        return;
    }


    item.quantity =
        Number(item.quantity || 0) +
        Number(amount);


    if (item.quantity <= 0) {

        cart =
            cart.filter(
                function(product) {

                    return String(product.id) !==
                        String(productId);

                }
            );

    }


    saveCart();

    renderCart();

}


/* =====================================================
   حذف منتج
===================================================== */

function removeItem(productId) {

    cart =
        cart.filter(
            function(item) {

                return String(item.id) !==
                    String(productId);

            }
        );


    saveCart();

    renderCart();

    toast(
        "تم حذف المنتج من السلة"
    );

}


/* =====================================================
   إفراغ السلة
===================================================== */

function clearCart() {

    if (!cart.length) {

        toast(
            "السلة فارغة"
        );

        return;

    }


    if (
        !confirm(
            "هل تريد إفراغ السلة بالكامل؟"
        )
    ) {

        return;

    }


    cart = [];

    saveCart();

    renderCart();

    toast(
        "تم إفراغ السلة"
    );

}


/* =====================================================
   الذهاب لإتمام الطلب
===================================================== */

function goCheckout() {

    if (!cart.length) {

        toast(
            "السلة فارغة"
        );

        return;

    }


    /*
     * نحاول فتح checkout.html
     */

    window.location.href =
        "checkout.html";

}


/* =====================================================
   التشغيل
===================================================== */

document.addEventListener(
    "DOMContentLoaded",
    async function() {

        /*
         * مهم:
         * نعرض السلة أولًا مباشرة.
         * لا ننتظر products.json.
         */

        renderCart();


        /*
         * بعدها نحدّث الأسعار والبيانات
         * من products.json.
         */

        await syncProducts();


        /*
         * إعادة العرض بعد التحديث.
         */

        renderCart();

    }
);


/* =====================================================
   إتاحة الدوال
===================================================== */

window.changeQuantity =
    changeQuantity;

window.removeItem =
    removeItem;

window.clearCart =
    clearCart;

window.goCheckout =
    goCheckout;

</script>

</body>
</html>
