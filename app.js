/* =========================================================
   مول البركة أولاد الجارحي
   APP.JS - نظام المنتجات والسلة
   ========================================================= */

"use strict";

const PRODUCTS_FILE = "products.json";
const CART_KEY = "albaraka_cart";

let products = [];
let cart = loadCart();
let currentCategory = "الكل";

/* =========================================================
   أدوات عامة
   ========================================================= */

function $(selector) {
    return document.querySelector(selector);
}

function $all(selector) {
    return [...document.querySelectorAll(selector)];
}

function escapeHTML(value) {
    return String(value ?? "")
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");
}

function money(value) {
    return Number(value || 0).toLocaleString("ar-EG") + " جنيه";
}

function loadCart() {
    try {
        const saved = localStorage.getItem(CART_KEY);
        const data = saved ? JSON.parse(saved) : [];

        return Array.isArray(data) ? data : [];
    } catch (error) {
        return [];
    }
}

function saveCart() {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    updateCartUI();
}

function getCartCount() {
    return cart.reduce((total, item) => {
        return total + Number(item.quantity || 0);
    }, 0);
}

function getCartTotal() {
    return cart.reduce((total, item) => {
        return total +
            Number(item.price || 0) *
            Number(item.quantity || 0);
    }, 0);
}

/* =========================================================
   تحميل المنتجات من GitHub
   ========================================================= */

async function loadProducts() {

    try {

        showProductsLoading();

        const response = await fetch(
            PRODUCTS_FILE + "?v=" + Date.now(),
            {
                cache: "no-store"
            }
        );

        if (!response.ok) {
            throw new Error("products.json not found");
        }

        const data = await response.json();

        products = Array.isArray(data.products)
            ? data.products.filter(product => product.active !== false)
            : [];

        window.ALBarakaProducts = products;

        renderCategories();
        renderProducts();
        updateCartUI();

    } catch (error) {

        console.error(error);

        showProductsError();

    }
}

/* =========================================================
   حالة التحميل
   ========================================================= */

function showProductsLoading() {

    const container = getProductsContainer();

    if (!container) return;

    container.innerHTML = `
        <div class="albaraka-loading">
            <div class="loading-spinner"></div>
            <p>جاري تحميل المنتجات...</p>
        </div>
    `;
}

/* =========================================================
   خطأ تحميل المنتجات
   ========================================================= */

function showProductsError() {

    const container = getProductsContainer();

    if (!container) return;

    container.innerHTML = `
        <div class="albaraka-error">
            <div style="font-size:45px">⚠️</div>

            <h3>تعذر تحميل المنتجات</h3>

            <p>
                تأكد من وجود ملف products.json
                في نفس مجلد المتجر.
            </p>

            <button onclick="location.reload()">
                إعادة المحاولة
            </button>
        </div>
    `;
}

/* =========================================================
   العثور على مكان المنتجات
   ========================================================= */

function getProductsContainer() {

    return (
        document.querySelector("#products") ||
        document.querySelector("#productGrid") ||
        document.querySelector(".products-grid") ||
        document.querySelector(".products") ||
        document.querySelector("[data-products]")
    );
}

/* =========================================================
   عرض المنتجات
   ========================================================= */

function renderProducts() {

    const container = getProductsContainer();

    if (!container) {
        console.warn(
            "لم يتم العثور على حاوية المنتجات."
        );
        return;
    }

    let filtered = products;

    if (currentCategory !== "الكل") {

        filtered = products.filter(product => {

            return product.category === currentCategory;

        });

    }

    if (!filtered.length) {

        container.innerHTML = `
            <div class="albaraka-empty">
                <div style="font-size:50px">🛒</div>

                <h3>لا توجد منتجات</h3>

                <p>
                    لا توجد منتجات في هذا القسم حاليًا.
                </p>
            </div>
        `;

        return;
    }

    container.innerHTML = filtered
        .map(product => productHTML(product))
        .join("");

    bindProductButtons();
}

/* =========================================================
   بطاقة المنتج
   ========================================================= */

function productHTML(product) {

    const id = escapeHTML(product.id);
    const name = escapeHTML(product.name);
    const category = escapeHTML(product.category);
    const unit = escapeHTML(product.unit || "قطعة");
    const emoji = escapeHTML(product.emoji || "🛒");

    const price = Number(product.price || 0);

    const image = product.image
        ? `
            <img
                src="${escapeHTML(product.image)}"
                alt="${name}"
                loading="lazy"
                onerror="this.style.display='none'"
            >
        `
        : `
            <div class="product-emoji">
                ${emoji}
            </div>
        `;

    const offer = product.offer
        ? `
            <span class="product-offer">
                🔥 عرض
            </span>
        `
        : "";

    return `
        <article
            class="albaraka-product"
            data-product-id="${id}"
        >

            <div class="product-image">

                ${image}

                ${offer}

            </div>

            <div class="product-info">

                <div class="product-category">
                    ${category}
                </div>

                <h3 class="product-name">
                    ${name}
                </h3>

                <div class="product-unit">
                    ${unit}
                </div>

                <div class="product-bottom">

                    <strong class="product-price">
                        ${money(price)}
                    </strong>

                    <button
                        class="add-product-btn"
                        type="button"
                        data-add-product="${id}"
                    >
                        🛒
                        <span>أضف</span>
                    </button>

                </div>

            </div>

        </article>
    `;
}

/* =========================================================
   أزرار المنتجات
   ========================================================= */

function bindProductButtons() {

    $all("[data-add-product]").forEach(button => {

        button.addEventListener(
            "click",
            function () {

                const id =
                    this.getAttribute(
                        "data-add-product"
                    );

                addToCart(id);

            }
        );

    });
}

/* =========================================================
   إضافة للسلة
   ========================================================= */

function addToCart(productId) {

    const product = products.find(
        item =>
            String(item.id) === String(productId)
    );

    if (!product) {
        showToast("المنتج غير موجود");
        return;
    }

    const existing = cart.find(
        item =>
            String(item.id) === String(product.id)
    );

    if (existing) {

        existing.quantity =
            Number(existing.quantity || 0) + 1;

    } else {

        cart.push({

            id: product.id,

            name: product.name,

            price: Number(product.price || 0),

            unit: product.unit || "قطعة",

            image: product.image || "",

            emoji: product.emoji || "🛒",

            quantity: 1

        });

    }

    saveCart();

    showToast(
        "تمت إضافة " +
        product.name +
        " إلى السلة 🛒"
    );

    animateCart();

}

/* =========================================================
   زيادة الكمية
   ========================================================= */

function increaseCart(productId) {

    const item = cart.find(
        product =>
            String(product.id) === String(productId)
    );

    if (!item) return;

    item.quantity =
        Number(item.quantity || 0) + 1;

    saveCart();

    renderCart();
}

/* =========================================================
   تقليل الكمية
   ========================================================= */

function decreaseCart(productId) {

    const item = cart.find(
        product =>
            String(product.id) === String(productId)
    );

    if (!item) return;

    item.quantity =
        Number(item.quantity || 0) - 1;

    if (item.quantity <= 0) {

        cart = cart.filter(
            product =>
                String(product.id) !== String(productId)
        );

    }

    saveCart();

    renderCart();
}

/* =========================================================
   حذف منتج من السلة
   ========================================================= */

function removeFromCart(productId) {

    cart = cart.filter(
        item =>
            String(item.id) !== String(productId)
    );

    saveCart();

    renderCart();

    showToast("تم حذف المنتج من السلة");
}

/* =========================================================
   تفريغ السلة
   ========================================================= */

function clearCart() {

    if (!cart.length) {
        showToast("السلة فارغة");
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

    showToast("تم إفراغ السلة");
}

/* =========================================================
   تحديث عداد السلة
   ========================================================= */

function updateCartUI() {

    const count = getCartCount();
    const total = getCartTotal();

    $all(
        "#cartCount, .cart-count, [data-cart-count]"
    ).forEach(element => {

        element.textContent = count;

        element.style.display =
            count > 0
                ? ""
                : "none";

    });

    $all(
        "#cartTotal, .cart-total, [data-cart-total]"
    ).forEach(element => {

        element.textContent =
            money(total);

    });
}

/* =========================================================
   عرض السلة
   ========================================================= */

function renderCart() {

    const container =
        document.querySelector("#cartItems") ||
        document.querySelector(".cart-items") ||
        document.querySelector("[data-cart-items]");

    if (!container) return;

    if (!cart.length) {

        container.innerHTML = `
            <div class="empty-cart">

                <div style="font-size:70px">
                    🛒
                </div>

                <h2>
                    السلة فارغة
                </h2>

                <p>
                    أضف المنتجات التي تريدها للمتابعة.
                </p>

                <a href="index.html">
                    ابدأ التسوق
                </a>

            </div>
        `;

        updateCartUI();

        return;
    }

    container.innerHTML =
        cart.map(item => {

            const image = item.image
                ? `
                    <img
                        src="${escapeHTML(item.image)}"
                        alt="${escapeHTML(item.name)}"
                    >
                `
                : `
                    <span>
                        ${escapeHTML(item.emoji || "🛒")}
                    </span>
                `;

            const itemTotal =
                Number(item.price || 0) *
                Number(item.quantity || 0);

            return `
                <div
                    class="cart-item"
                    data-cart-product="${escapeHTML(item.id)}"
                >

                    <div class="cart-item-image">
                        ${image}
                    </div>

                    <div class="cart-item-info">

                        <h3>
                            ${escapeHTML(item.name)}
                        </h3>

                        <small>
                            ${money(item.price)}
                            /
                            ${escapeHTML(item.unit)}
                        </small>

                        <strong>
                            ${money(itemTotal)}
                        </strong>

                    </div>

                    <div class="cart-quantity">

                        <button
                            type="button"
                            onclick="decreaseCart('${escapeHTML(item.id)}')"
                        >
                            −
                        </button>

                        <span>
                            ${item.quantity}
                        </span>

                        <button
                            type="button"
                            onclick="increaseCart('${escapeHTML(item.id)}')"
                        >
                            +
                        </button>

                    </div>

                    <button
                        class="remove-cart-item"
                        type="button"
                        onclick="removeFromCart('${escapeHTML(item.id)}')"
                    >
                        🗑️
                    </button>

                </div>
            `;

        }).join("");

    updateCartUI();

}

/* =========================================================
   تصفية الأقسام
   ========================================================= */

function filterCategory(category) {

    currentCategory = category || "الكل";

    renderProducts();

    $all(
        "[data-category]"
    ).forEach(button => {

        const value =
            button.getAttribute(
                "data-category"
            );

        button.classList.toggle(
            "active",
            value === currentCategory
        );

    });

}

/* =========================================================
   إنشاء الأقسام تلقائيًا
   ========================================================= */

function renderCategories() {

    const containers = [

        document.querySelector(
            "#categories"
        ),

        document.querySelector(
            ".categories"
        ),

        document.querySelector(
            "[data-categories]"
        )

    ].filter(Boolean);

    if (!containers.length) {
        return;
    }

    const categories = [
        "الكل",
        ...new Set(
            products
                .map(product => product.category)
                .filter(Boolean)
        )
    ];

    const html =
        categories.map(category => {

            return `
                <button
                    type="button"
                    data-category="${escapeHTML(category)}"
                    class="${
                        category === "الكل"
                            ? "active"
                            : ""
                    }"
                >
                    ${escapeHTML(category)}
                </button>
            `;

        }).join("");

    containers.forEach(container => {

        container.innerHTML = html;

        container
            .querySelectorAll(
                "[data-category]"
            )
            .forEach(button => {

                button.addEventListener(
                    "click",
                    () => {

                        filterCategory(
                            button.getAttribute(
                                "data-category"
                            )
                        );

                    }
                );

            });

    });

}

/* =========================================================
   فتح السلة
   ========================================================= */

function openCart() {

    const cartPage =
        document.querySelector(
            "#cartPanel"
        );

    if (cartPage) {

        cartPage.classList.add(
            "open"
        );

        renderCart();

        return;
    }

    window.location.href =
        "cart.html";

}

/* =========================================================
   إغلاق السلة
   ========================================================= */

function closeCart() {

    const cartPage =
        document.querySelector(
            "#cartPanel"
        );

    if (cartPage) {

        cartPage.classList.remove(
            "open"
        );

    }

}

/* =========================================================
   أزرار السلة
   ========================================================= */

function bindCartButtons() {

    $all(
        "#cartButton, .cart-button, [data-open-cart]"
    ).forEach(button => {

        button.addEventListener(
            "click",
            function(event) {

                event.preventDefault();

                openCart();

            }
        );

    });

    $all(
        "#closeCart, .close-cart, [data-close-cart]"
    ).forEach(button => {

        button.addEventListener(
            "click",
            function(event) {

                event.preventDefault();

                closeCart();

            }
        );

    });

    $all(
        "#clearCart, .clear-cart, [data-clear-cart]"
    ).forEach(button => {

        button.addEventListener(
            "click",
            function(event) {

                event.preventDefault();

                clearCart();

            }
        );

    });

}

/* =========================================================
   حركة زر السلة
   ========================================================= */

function animateCart() {

    const button =
        document.querySelector(
            "#cartButton, .cart-button"
        );

    if (!button) return;

    button.classList.remove(
        "cart-bounce"
    );

    void button.offsetWidth;

    button.classList.add(
        "cart-bounce"
    );

}

/* =========================================================
   رسالة صغيرة
   ========================================================= */

function showToast(text) {

    let toast =
        document.querySelector(
            "#albarakaToast"
        );

    if (!toast) {

        toast =
            document.createElement(
                "div"
            );

        toast.id =
            "albarakaToast";

        toast.style.cssText = `
            position:fixed;
            right:20px;
            bottom:20px;
            z-index:99999;
            background:#087f3f;
            color:white;
            padding:14px 18px;
            border-radius:12px;
            box-shadow:0 10px 30px rgba(0,0,0,.18);
            font-family:Arial,Tahoma,sans-serif;
            font-size:13px;
            font-weight:bold;
            transform:translateY(20px);
            opacity:0;
            transition:.25s;
        `;

        document.body.appendChild(toast);

    }

    toast.textContent = text;

    requestAnimationFrame(() => {

        toast.style.opacity = "1";

        toast.style.transform =
            "translateY(0)";

    });

    clearTimeout(
        toast._timer
    );

    toast._timer =
        setTimeout(() => {

            toast.style.opacity = "0";

            toast.style.transform =
                "translateY(20px)";

        }, 2500);

}

/* =========================================================
   إحصائيات السلة
   ========================================================= */

function getCartData() {

    return {

        items: [...cart],

        count: getCartCount(),

        total: getCartTotal()

    };

}

/* =========================================================
   بيانات الطلب
   ========================================================= */

function getOrderData(customer = {}) {

    return {

        store:
            "مول البركة أولاد الجارحي",

        whatsapp:
            "01119511185",

        customer: {

            name:
                customer.name || "",

            phone:
                customer.phone || "",

            address:
                customer.address || "",

            notes:
                customer.notes || ""

        },

        payment:
            customer.payment || "cash",

        items:
            cart.map(item => ({

                id:
                    item.id,

                name:
                    item.name,

                price:
                    Number(item.price || 0),

                unit:
                    item.unit,

                quantity:
                    Number(item.quantity || 0),

                total:
                    Number(item.price || 0) *
                    Number(item.quantity || 0)

            })),

        total:
            getCartTotal(),

        createdAt:
            new Date().toISOString()

    };

}

/* =========================================================
   إرسال الطلب إلى واتساب
   ========================================================= */

function sendOrderToWhatsApp(customer = {}) {

    if (!cart.length) {

        showToast(
            "السلة فارغة"
        );

        return;

    }

    const order =
        getOrderData(customer);

    let text =
        "🛒 *طلب جديد - مول البركة أولاد الجارحي*";

    text +=
        "\n\n";

    text +=
        "👤 الاسم: " +
        (order.customer.name || "-");

    text +=
        "\n📞 الهاتف: " +
        (order.customer.phone || "-");

    text +=
        "\n📍 العنوان: " +
        (order.customer.address || "-");

    text +=
        "\n💳 طريقة الدفع: " +
        (
            order.payment === "visa"
                ? "فيزا"
                : "كاش عند الاستلام"
        );

    text +=
        "\n\n🧺 *المنتجات:*";

    order.items.forEach(
        (item, index) => {

            text +=
                "\n" +
                (index + 1) +
                ". " +
                item.name +
                " × " +
                item.quantity +
                " = " +
                item.total +
                " جنيه";

        }
    );

    text +=
        "\n\n💰 *الإجمالي: " +
        order.total +
        " جنيه*";

    if (order.customer.notes) {

        text +=
            "\n📝 ملاحظات: " +
            order.customer.notes;

    }

    const phone =
        "201119511185";

    const url =
        "https://wa.me/" +
        phone +
        "?text=" +
        encodeURIComponent(text);

    window.open(
        url,
        "_blank",
        "noopener"
    );

}

/* =========================================================
   أحداث عامة
   ========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function() {

        loadProducts();

        renderCart();

        bindCartButtons();

    }
);

/* =========================================================
   جعل الدوال متاحة للـHTML
   ========================================================= */

window.addToCart =
    addToCart;

window.increaseCart =
    increaseCart;

window.decreaseCart =
    decreaseCart;

window.removeFromCart =
    removeFromCart;

window.clearCart =
    clearCart;

window.renderCart =
    renderCart;

window.openCart =
    openCart;

window.closeCart =
    closeCart;

window.filterCategory =
    filterCategory;

window.sendOrderToWhatsApp =
    sendOrderToWhatsApp;

window.getCartData =
    getCartData;

window.getOrderData =
    getOrderData;
