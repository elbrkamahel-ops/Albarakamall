<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<title>السلة | مول البركة</title>

<style>
*{
    box-sizing:border-box;
}

body{
    margin:0;
    background:#f7f9f8;
    color:#18251e;
    font-family:Arial,Tahoma,sans-serif;
}

button,
a,
input{
    font-family:inherit;
}

a{
    text-decoration:none;
}

.top{
    background:#087f3f;
    color:#fff;
    padding:10px 15px;
    text-align:center;
    font-size:12px;
    font-weight:bold;
}

.header{
    background:#fff;
    border-bottom:1px solid #e8eee9;
}

.header-inner{
    max-width:1150px;
    margin:auto;
    min-height:78px;
    padding:12px 18px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
}

.logo-icon{
    width:48px;
    height:48px;
    background:#087f3f;
    color:#fff;
    border-radius:15px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:25px;
    font-weight:900;
}

.logo strong{
    color:#087f3f;
    font-size:20px;
    display:block;
}

.logo small{
    color:#87928c;
    font-size:11px;
}

.back{
    color:#087f3f;
    font-size:13px;
    font-weight:bold;
    background:#eff8f2;
    padding:11px 16px;
    border-radius:12px;
}

.page{
    max-width:1150px;
    margin:auto;
    padding:25px 18px 70px;
}

.title{
    margin-bottom:20px;
}

.title h1{
    margin:0;
    font-size:28px;
}

.title p{
    margin:7px 0 0;
    color:#87928c;
    font-size:13px;
}

.layout{
    display:grid;
    grid-template-columns:1fr 340px;
    gap:20px;
    align-items:start;
}

.box{
    background:#fff;
    border:1px solid #e4ebe6;
    border-radius:20px;
    padding:20px;
}

.box-title{
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #edf1ee;
    padding-bottom:15px;
    margin-bottom:10px;
}

.box-title h2{
    margin:0;
    font-size:18px;
}

.clear{
    border:0;
    background:#fff1f1;
    color:#d84242;
    padding:8px 12px;
    border-radius:9px;
    cursor:pointer;
    font-size:11px;
    font-weight:bold;
}

.item{
    display:grid;
    grid-template-columns:90px 1fr auto;
    gap:15px;
    align-items:center;
    padding:16px 0;
    border-bottom:1px solid #edf1ee;
}

.item:last-child{
    border-bottom:0;
}

.item-image{
    width:90px;
    height:90px;
    background:#f5f8f6;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:45px;
}

.item-info h3{
    margin:0 0 5px;
    font-size:15px;
}

.item-unit{
    color:#929b96;
    font-size:11px;
}

.item-price{
    color:#087f3f;
    font-size:16px;
    font-weight:900;
    margin-top:8px;
}

.controls{
    display:flex;
    align-items:center;
    gap:8px;
    margin-top:10px;
}

.qty-btn{
    width:32px;
    height:32px;
    border:1px solid #dbe6df;
    background:#fff;
    border-radius:9px;
    color:#087f3f;
    font-size:18px;
    cursor:pointer;
}

.qty{
    min-width:28px;
    text-align:center;
    font-weight:bold;
}

.remove{
    margin-top:8px;
    border:0;
    background:none;
    color:#d84242;
    font-size:10px;
    cursor:pointer;
}

.item-total{
    text-align:left;
    font-size:16px;
    font-weight:900;
}

.empty{
    text-align:center;
    padding:55px 15px;
}

.empty-icon{
    font-size:65px;
    margin-bottom:10px;
}

.empty h2{
    margin:0 0 8px;
}

.empty p{
    color:#89948e;
    font-size:13px;
}

.shop{
    display:inline-block;
    background:#087f3f;
    color:#fff;
    padding:13px 25px;
    border-radius:12px;
    font-weight:bold;
    margin-top:10px;
}

.summary{
    position:sticky;
    top:15px;
}

.summary h2{
    margin:0 0 18px;
    font-size:19px;
}

.row{
    display:flex;
    justify-content:space-between;
    padding:10px 0;
    color:#647069;
    font-size:13px;
}

.row.total{
    border-top:1px solid #e8eee9;
    margin-top:8px;
    padding-top:17px;
    color:#18251e;
    font-size:18px;
    font-weight:900;
}

.delivery{
    background:#eff8f2;
    color:#087f3f;
    padding:13px;
    border-radius:12px;
    margin:15px 0;
    font-size:11px;
    line-height:1.7;
}

.checkout{
    width:100%;
    min-height:50px;
    border:0;
    border-radius:13px;
    background:#087f3f;
    color:#fff;
    font-size:15px;
    font-weight:900;
    cursor:pointer;
}

.checkout:hover{
    background:#066b35;
}

.whatsapp{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:7px;
    margin-top:10px;
    width:100%;
    min-height:45px;
    border-radius:12px;
    background:#20b85a;
    color:#fff;
    font-size:13px;
    font-weight:bold;
}

.payment{
    display:flex;
    gap:8px;
    margin-top:15px;
}

.payment span{
    flex:1;
    background:#f7f9f8;
    border:1px solid #e7eee9;
    border-radius:9px;
    padding:10px 5px;
    text-align:center;
    font-size:10px;
}

@media(max-width:800px){

    .layout{
        grid-template-columns:1fr;
    }

    .summary{
        position:static;
    }
}

@media(max-width:550px){

    .page{
        padding:18px 10px 60px;
    }

    .box{
        padding:13px;
        border-radius:16px;
    }

    .item{
        grid-template-columns:65px 1fr;
        gap:10px;
    }

    .item-image{
        width:65px;
        height:65px;
        font-size:32px;
        grid-row:span 2;
    }

    .item-total{
        grid-column:2;
        text-align:right;
    }

    .item-info h3{
        font-size:13px;
    }
}
</style>
</head>

<body>

<div class="top">
    🚚 توصيل سريع | 💳 كاش أو فيزا | 📱 واتساب 01119511185
</div>

<header class="header">
    <div class="header-inner">

        <a href="index.html" class="logo">
            <div class="logo-icon">ب</div>

            <div>
                <strong>مول البركة</strong>
                <small>أولاد الجارحي</small>
            </div>
        </a>

        <a href="index.html" class="back">
            ← متابعة التسوق
        </a>

    </div>
</header>

<main class="page">

    <div class="title">
        <h1>🛒 سلة المشتريات</h1>
        <p>راجع منتجاتك قبل إتمام الطلب</p>
    </div>

    <div class="layout">

        <!-- السلة -->

        <section class="box">

            <div class="box-title">
                <h2 id="itemsTitle">
                    منتجات السلة
                </h2>

                <button
                    class="clear"
                    id="clearCart"
                >
                    حذف الكل
                </button>
            </div>

            <div id="cartItems"></div>

        </section>


        <!-- ملخص الطلب -->

        <aside class="box summary">

            <h2>ملخص الطلب</h2>

            <div class="row">
                <span>عدد المنتجات</span>
                <strong id="summaryCount">0</strong>
            </div>

            <div class="row">
                <span>إجمالي المنتجات</span>
                <strong id="summarySubtotal">0 ج.م</strong>
            </div>

            <div class="row">
                <span>التوصيل</span>
                <strong id="deliveryPrice">يحدد عند الطلب</strong>
            </div>

            <div class="row total">
                <span>الإجمالي</span>
                <strong id="summaryTotal">0 ج.م</strong>
            </div>

            <div class="delivery">
                🚚 سيتم تأكيد بيانات التوصيل والتكلفة النهائية
                معك قبل إرسال الطلب.
            </div>

            <button
                class="checkout"
                id="checkoutBtn"
            >
                إكمال الطلب →
            </button>

            <a
                class="whatsapp"
                href="https://wa.me/201119511185"
                target="_blank"
                rel="noopener"
            >
                💬 التواصل عبر واتساب
            </a>

            <div class="payment">
                <span>💵 كاش</span>
                <span>💳 فيزا</span>
            </div>

        </aside>

    </div>

</main>


<script src="app.js"></script>

<script>

"use strict";

/* =========================================
   رسم السلة
========================================= */

function renderCart(){

    const cart =
        typeof getCart === "function"
        ? getCart()
        : [];

    const container =
        document.getElementById(
            "cartItems"
        );

    const count =
        document.getElementById(
            "summaryCount"
        );

    const subtotal =
        document.getElementById(
            "summarySubtotal"
        );

    const total =
        document.getElementById(
            "summaryTotal"
        );

    const title =
        document.getElementById(
            "itemsTitle"
        );


    if(!container) return;


    /* ===============================
       السلة فارغة
    =============================== */

    if(cart.length === 0){

        container.innerHTML = `

            <div class="empty">

                <div class="empty-icon">
                    🛒
                </div>

                <h2>
                    السلة فاضية
                </h2>

                <p>
                    لسه مفيش منتجات في سلتك.
                    ابدأ التسوق وأضف احتياجاتك.
                </p>

                <a
                    href="index.html"
                    class="shop"
                >
                    ابدأ التسوق
                </a>

            </div>

        `;

        count.textContent = "0";
        subtotal.textContent = "0 ج.م";
        total.textContent = "0 ج.م";

        title.textContent =
            "منتجات السلة";

        return;
    }


    /* ===============================
       المنتجات
    =============================== */

    let html = "";

    let totalItems = 0;

    let totalPrice = 0;


    cart.forEach(item => {

        const quantity =
            Number(item.quantity) || 1;

        const price =
            Number(item.price) || 0;

        const itemTotal =
            quantity * price;

        totalItems += quantity;

        totalPrice += itemTotal;


        html += `

            <article
                class="item"
            >

                <div class="item-image">
                    ${escapeHtml(
                        item.emoji || "🛒"
                    )}
                </div>


                <div class="item-info">

                    <h3>
                        ${escapeHtml(
                            item.name
                        )}
                    </h3>

                    <div class="item-unit">
                        ${escapeHtml(
                            item.unit || "قطعة"
                        )}
                    </div>

                    <div class="item-price">
                        ${formatPrice(price)}
                    </div>


                    <div class="controls">

                        <button
                            class="qty-btn"
                            data-action="minus"
                            data-id="${escapeHtml(
                                item.id
                            )}"
                        >
                            −
                        </button>

                        <span class="qty">
                            ${quantity}
                        </span>

                        <button
                            class="qty-btn"
                            data-action="plus"
                            data-id="${escapeHtml(
                                item.id
                            )}"
                        >
                            +
                        </button>

                    </div>


                    <button
                        class="remove"
                        data-action="remove"
                        data-id="${escapeHtml(
                            item.id
                        )}"
                    >
                        حذف المنتج
                    </button>

                </div>


                <div class="item-total">
                    ${formatPrice(itemTotal)}
                </div>

            </article>

        `;

    });


    container.innerHTML =
        html;


    count.textContent =
        totalItems;


    subtotal.textContent =
        formatPrice(totalPrice);


    total.textContent =
        formatPrice(totalPrice);


    title.textContent =
        "منتجات السلة (" +
        totalItems +
        ")";

}


/* =========================================
   حماية النصوص
========================================= */

function escapeHtml(value){

    return String(value ?? "")
        .replace(/&/g,"&amp;")
        .replace(/</g,"&lt;")
        .replace(/>/g,"&gt;")
        .replace(/"/g,"&quot;")
        .replace(/'/g,"&#039;");

}


/* =========================================
   أزرار السلة
========================================= */

document.addEventListener(
    "click",
    function(event){

        const button =
            event.target.closest(
                "[data-action]"
            );

        if(!button) return;


        const action =
            button.dataset.action;

        const id =
            button.dataset.id;


        if(action === "plus"){

            changeCartQuantity(
                id,
                1
            );

            renderCart();

        }


        if(action === "minus"){

            changeCartQuantity(
                id,
                -1
            );

            renderCart();

        }


        if(action === "remove"){

            removeFromCart(id);

            renderCart();

            showToast(
                "تم حذف المنتج من السلة"
            );

        }

    }
);


/* =========================================
   حذف الكل
========================================= */

document
    .getElementById("clearCart")
    .addEventListener(
        "click",
        function(){

            const cart =
                getCart();

            if(cart.length === 0){

                return;
            }


            const confirmed =
                confirm(
                    "هل تريد حذف جميع المنتجات من السلة؟"
                );


            if(!confirmed){

                return;
            }


            clearCart();

            renderCart();

            showToast(
                "تم تفريغ السلة"
            );

        }
    );


/* =========================================
   إكمال الطلب
========================================= */

document
    .getElementById("checkoutBtn")
    .addEventListener(
        "click",
        function(){

            const cart =
                getCart();


            if(
                !Array.isArray(cart) ||
                cart.length === 0
            ){

                showToast(
                    "أضف منتجات للسلة أولاً"
                );

                return;
            }


            window.location.href =
                "checkout.html";

        }
    );


/* =========================================
   تحديث السلة
========================================= */

window.addEventListener(
    "cartUpdated",
    function(){

        renderCart();

    }
);


document.addEventListener(
    "DOMContentLoaded",
    function(){

        renderCart();

        if(
            typeof updateCartCount ===
            "function"
        ){

            updateCartCount();

        }

    }
);

</script>

</body>
</html>
