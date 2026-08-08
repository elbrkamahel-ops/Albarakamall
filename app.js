"use strict";

/* =========================================================
   مول البركة - APP.JS
   السلة + المنتجات + الأسعار + الكميات + التخزين
========================================================= */

const CART_KEY = "albaraka_cart";

/* =========================================================
   أدوات عامة
========================================================= */

function formatPrice(value) {
    const number = Number(value) || 0;
    return number.toLocaleString("ar-EG") + " ج.م";
}

window.formatPrice = formatPrice;


/* =========================================================
   قراءة السلة
========================================================= */

function getCart() {
    try {
        const saved = localStorage.getItem(CART_KEY);

        if (!saved) return [];

        const cart = JSON.parse(saved);

        return Array.isArray(cart) ? cart : [];

    } catch (error) {
        console.error("Cart read error:", error);
        return [];
    }
}

window.getCart = getCart;


/* =========================================================
   حفظ السلة
========================================================= */

function saveCart(cart) {

    try {

        localStorage.setItem(
            CART_KEY,
            JSON.stringify(cart)
        );

        updateCartCount();

        window.dispatchEvent(
            new CustomEvent("cartUpdated")
        );

        return true;

    } catch (error) {

        console.error("Cart save error:", error);

        showToast("تعذر حفظ السلة");

        return false;
    }
}


/* =========================================================
   عدد المنتجات
========================================================= */

function getCartCount() {

    return getCart().reduce(
        (total, item) =>
            total + Number(item.quantity || 0),
        0
    );
}

window.getCartCount = getCartCount;


/* =========================================================
   إجمالي السلة
========================================================= */

function getCartTotal() {

    return getCart().reduce(
        (total, item) => {

            const price =
                Number(item.price) || 0;

            const quantity =
                Number(item.quantity) || 0;

            return total + price * quantity;

        },
        0
    );
}

window.getCartTotal = getCartTotal;


/* =========================================================
   تحديث عداد السلة
========================================================= */

function updateCartCount() {

    const count = getCartCount();

    document
        .querySelectorAll("#cartCount, .cart-count, .ab-cart-count")
        .forEach(element => {

            element.textContent = count;

        });
}

window.updateCartCount = updateCartCount;


/* =========================================================
   تنظيف المنتج
========================================================= */

function normalizeProduct(product) {

    return {

        id:
            String(
                product.id ??
                Date.now()
            ),

        name:
            String(
                product.name ??
                "منتج"
            ),

        price:
            Number(
                product.price
            ) || 0,

        unit:
            String(
                product.unit ??
                "قطعة"
            ),

        category:
            String(
                product.category ??
                "عام"
            ),

        emoji:
            String(
                product.emoji ??
                "🛒"
            ),

        quantity:
            Math.max(
                1,
                Number(product.quantity) || 1
            )

    };
}


/* =========================================================
   إضافة للسلة
========================================================= */

function addToCart(product) {

    const cleanProduct =
        normalizeProduct(product);

    const cart =
        getCart();

    const existing =
        cart.find(
            item =>
                String(item.id) ===
                String(cleanProduct.id)
        );

    if (existing) {

        existing.quantity =
            Number(existing.quantity || 0) +
            Number(cleanProduct.quantity || 1);

    } else {

        cart.push(cleanProduct);

    }

    saveCart(cart);

    showToast(
        "تمت إضافة " +
        cleanProduct.name +
        " إلى السلة 🛒"
    );

    return cart;
}

window.addToCart = addToCart;


/* =========================================================
   حذف منتج
========================================================= */

function removeFromCart(id) {

    const cart =
        getCart().filter(
            item =>
                String(item.id) !==
                String(id)
        );

    saveCart(cart);

    return cart;
}

window.removeFromCart = removeFromCart;


/* =========================================================
   تغيير الكمية
========================================================= */

function changeCartQuantity(id, amount) {

    const cart =
        getCart();

    const item =
        cart.find(
            product =>
                String(product.id) ===
                String(id)
        );

    if (!item) return;

    item.quantity =
        Number(item.quantity || 0) +
        Number(amount || 0);

    if (item.quantity <= 0) {

        removeFromCart(id);

        return;
    }

    saveCart(cart);
}

window.changeCartQuantity =
    changeCartQuantity;


/* =========================================================
   تعيين كمية مباشرة
========================================================= */

function setCartQuantity(id, quantity) {

    const cart =
        getCart();

    const item =
        cart.find(
            product =>
                String(product.id) ===
                String(id)
        );

    if (!item) return;

    const newQuantity =
        Math.floor(
            Number(quantity)
        );

    if (
        !Number.isFinite(newQuantity) ||
        newQuantity <= 0
    ) {

        removeFromCart(id);

        return;
    }

    item.quantity =
        newQuantity;

    saveCart(cart);
}

window.setCartQuantity =
    setCartQuantity;


/* =========================================================
   تفريغ السلة
========================================================= */

function clearCart() {

    try {

        localStorage.removeItem(
            CART_KEY
        );

        updateCartCount();

        window.dispatchEvent(
            new CustomEvent("cartUpdated")
        );

    } catch (error) {

        console.error(
            "Clear cart error:",
            error
        );
    }
}

window.clearCart = clearCart;


/* =========================================================
   إشعار صغير
========================================================= */

function showToast(message) {

    let toast =
        document.getElementById(
            "albarakaToast"
        );

    if (!toast) {

        toast =
            document.createElement("div");

        toast.id =
            "albarakaToast";

        toast.style.cssText = `
            position:fixed;
            right:18px;
            bottom:20px;
            z-index:99999;
            max-width:330px;
            background:#087f3f;
            color:#fff;
            padding:13px 18px;
            border-radius:13px;
            box-shadow:0 10px 35px rgba(0,0,0,.18);
            font-family:Arial,Tahoma,sans-serif;
            font-size:13px;
            font-weight:800;
            transform:translateY(20px);
            opacity:0;
            transition:.25s;
        `;

        document.body.appendChild(toast);
    }

    toast.textContent = message;

    clearTimeout(
        window.albarakaToastTimer
    );

    requestAnimationFrame(() => {

        toast.style.opacity = "1";
        toast.style.transform =
            "translateY(0)";

    });

    window.albarakaToastTimer =
        setTimeout(() => {

            toast.style.opacity = "0";
            toast.style.transform =
                "translateY(20px)";

        }, 2200);
}

window.showToast = showToast;


/* =========================================================
   زر إضافة للسلة تلقائيًا
   لأي زر يحمل data-id
========================================================= */

function initializeAddButtons() {

    document
        .querySelectorAll(
            "[data-id][data-name][data-price]"
        )
        .forEach(button => {

            if (
                button.dataset.cartReady ===
                "true"
            ) {
                return;
            }

            button.dataset.cartReady =
                "true";

            button.addEventListener(
                "click",
                function(event) {

                    event.preventDefault();

                    const product = {

                        id:
                            button.dataset.id,

                        name:
                            button.dataset.name,

                        price:
                            button.dataset.price,

                        unit:
                            button.dataset.unit,

                        category:
                            button.dataset.category,

                        emoji:
                            button.dataset.emoji,

                        quantity:
                            1

                    };

                    addToCart(product);

                }
            );

        });
}


/* =========================================================
   منع الضغط المزدوج على الأزرار
========================================================= */

document.addEventListener(
    "click",
    function(event) {

        const button =
            event.target.closest(
                "button[data-id]"
            );

        if (!button) return;

        if (
            button.dataset.busy ===
            "true"
        ) {
            return;
        }

        button.dataset.busy =
            "true";

        setTimeout(
            () => {
                button.dataset.busy =
                    "false";
            },
            300
        );

    }
);


/* =========================================================
   تشغيل التطبيق
========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function() {

        updateCartCount();

        initializeAddButtons();

    }
);


/* =========================================================
   تحديث العداد عند الرجوع للصفحة
========================================================= */

window.addEventListener(
    "storage",
    function(event) {

        if (
            event.key === CART_KEY
        ) {

            updateCartCount();

        }

    }
);


/* =========================================================
   تحديث عند ظهور الصفحة
========================================================= */

document.addEventListener(
    "visibilitychange",
    function() {

        if (
            document.visibilityState ===
            "visible"
        ) {

            updateCartCount();

        }

    }
);


/* =========================================================
   API عام
========================================================= */

window.AlbarakaStore = {

    getCart,
    saveCart,
    getCartCount,
    getCartTotal,
    addToCart,
    removeFromCart,
    changeCartQuantity,
    setCartQuantity,
    clearCart,
    formatPrice

};
