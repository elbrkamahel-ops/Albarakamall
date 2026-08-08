/* =========================================================
   مول البركة - أولاد الجارحي
   APP.JS
========================================================= */

"use strict";


/* =========================================================
   WHATSAPP
========================================================= */

const WHATSAPP_NUMBER = "201119511185";


/* =========================================================
   PRODUCTS
========================================================= */

const products = [

    /* ================= خضروات وفواكه ================= */

    {
        id: 1,
        name: "طماطم",
        category: "خضروات وفواكه",
        price: 25,
        unit: "كيلو",
        emoji: "🍅"
    },

    {
        id: 2,
        name: "بطاطس",
        category: "خضروات وفواكه",
        price: 22,
        unit: "كيلو",
        emoji: "🥔"
    },

    {
        id: 3,
        name: "خيار",
        category: "خضروات وفواكه",
        price: 30,
        unit: "كيلو",
        emoji: "🥒"
    },

    {
        id: 4,
        name: "جزر",
        category: "خضروات وفواكه",
        price: 25,
        unit: "كيلو",
        emoji: "🥕"
    },

    {
        id: 5,
        name: "بصل",
        category: "خضروات وفواكه",
        price: 20,
        unit: "كيلو",
        emoji: "🧅"
    },

    {
        id: 6,
        name: "فلفل أخضر",
        category: "خضروات وفواكه",
        price: 35,
        unit: "كيلو",
        emoji: "🫑"
    },

    {
        id: 7,
        name: "تفاح",
        category: "خضروات وفواكه",
        price: 65,
        unit: "كيلو",
        emoji: "🍎"
    },

    {
        id: 8,
        name: "موز",
        category: "خضروات وفواكه",
        price: 35,
        unit: "كيلو",
        emoji: "🍌"
    },

    {
        id: 9,
        name: "برتقال",
        category: "خضروات وفواكه",
        price: 30,
        unit: "كيلو",
        emoji: "🍊"
    },

    {
        id: 10,
        name: "فراولة",
        category: "خضروات وفواكه",
        price: 55,
        unit: "كيلو",
        emoji: "🍓"
    },


    /* ================= اللحوم ================= */

    {
        id: 11,
        name: "لحم بقري",
        category: "لحوم",
        price: 420,
        unit: "كيلو",
        emoji: "🥩"
    },

    {
        id: 12,
        name: "لحم مفروم",
        category: "لحوم",
        price: 390,
        unit: "كيلو",
        emoji: "🥩"
    },

    {
        id: 13,
        name: "كبدة",
        category: "لحوم",
        price: 450,
        unit: "كيلو",
        emoji: "🥩"
    },

    {
        id: 14,
        name: "ستيك",
        category: "لحوم",
        price: 480,
        unit: "كيلو",
        emoji: "🥩"
    },


    /* ================= الطيور ================= */

    {
        id: 15,
        name: "دجاج كامل",
        category: "طيور",
        price: 145,
        unit: "كيلو",
        emoji: "🐔"
    },

    {
        id: 16,
        name: "صدور دجاج",
        category: "طيور",
        price: 220,
        unit: "كيلو",
        emoji: "🍗"
    },

    {
        id: 17,
        name: "وراك دجاج",
        category: "طيور",
        price: 165,
        unit: "كيلو",
        emoji: "🍗"
    },

    {
        id: 18,
        name: "بط",
        category: "طيور",
        price: 190,
        unit: "كيلو",
        emoji: "🦆"
    },


    /* ================= ماركت ================= */

    {
        id: 19,
        name: "أرز",
        category: "ماركت",
        price: 35,
        unit: "كيلو",
        emoji: "🍚"
    },

    {
        id: 20,
        name: "سكر",
        category: "ماركت",
        price: 35,
        unit: "كيلو",
        emoji: "🧂"
    },

    {
        id: 21,
        name: "زيت طعام",
        category: "ماركت",
        price: 75,
        unit: "زجاجة",
        emoji: "🫗"
    },

    {
        id: 22,
        name: "مكرونة",
        category: "ماركت",
        price: 18,
        unit: "عبوة",
        emoji: "🍝"
    },

    {
        id: 23,
        name: "لبن",
        category: "ماركت",
        price: 42,
        unit: "عبوة",
        emoji: "🥛"
    },

    {
        id: 24,
        name: "جبنة",
        category: "ماركت",
        price: 65,
        unit: "عبوة",
        emoji: "🧀"
    },


    /* ================= عطارة ================= */

    {
        id: 25,
        name: "فلفل أسود",
        category: "عطارة",
        price: 45,
        unit: "100 جرام",
        emoji: "🌶️"
    },

    {
        id: 26,
        name: "كمون",
        category: "عطارة",
        price: 40,
        unit: "100 جرام",
        emoji: "🌿"
    },

    {
        id: 27,
        name: "كركم",
        category: "عطارة",
        price: 35,
        unit: "100 جرام",
        emoji: "🌿"
    },

    {
        id: 28,
        name: "قرفة",
        category: "عطارة",
        price: 50,
        unit: "100 جرام",
        emoji: "🌿"
    }

];


/* =========================================================
   CART
========================================================= */

let cart = loadCart();


/* =========================================================
   DOM
========================================================= */

const productGrid =
    document.getElementById("productGrid");

const cartCount =
    document.getElementById("cartCount");

const searchInput =
    document.getElementById("searchInput");


/* =========================================================
   SAVE CART
========================================================= */

function saveCart() {

    try {

        localStorage.setItem(
            "albaraka_cart",
            JSON.stringify(cart)
        );

    } catch (error) {

        console.error(
            "تعذر حفظ السلة:",
            error
        );

    }

}


/* =========================================================
   LOAD CART
========================================================= */

function loadCart() {

    try {

        const saved =
            localStorage.getItem(
                "albaraka_cart"
            );

        if (!saved) {
            return [];
        }

        const parsed =
            JSON.parse(saved);

        if (!Array.isArray(parsed)) {
            return [];
        }

        return parsed;

    } catch (error) {

        console.error(
            "تعذر قراءة السلة:",
            error
        );

        return [];

    }

}


/* =========================================================
   CART COUNT
========================================================= */

function updateCartCount() {

    if (!cartCount) {
        return;
    }

    const count =
        cart.reduce(
            (total, item) =>
                total + Number(item.quantity || 0),
            0
        );

    cartCount.textContent = count;

}


/* =========================================================
   FORMAT PRICE
========================================================= */

function formatPrice(price) {

    return Number(price).toLocaleString(
        "ar-EG"
    ) + " ج.م";

}


/* =========================================================
   RENDER PRODUCTS
========================================================= */

function renderProducts(
    category = "الكل",
    search = ""
) {

    if (!productGrid) {
        return;
    }

    const query =
        String(search)
            .trim()
            .toLowerCase();

    const filtered =
        products.filter(product => {

            const categoryMatch =
                category === "الكل" ||
                product.category === category;

            const searchMatch =
                !query ||
                product.name
                    .toLowerCase()
                    .includes(query) ||
                product.category
                    .toLowerCase()
                    .includes(query);

            return categoryMatch &&
                   searchMatch;

        });


    if (filtered.length === 0) {

        productGrid.innerHTML = `
            <div class="empty-products">
                <div style="font-size:45px;margin-bottom:10px;">
                    🔎
                </div>

                <strong>
                    لا توجد منتجات مطابقة
                </strong>

                <p style="margin-top:5px;">
                    جرب البحث باسم منتج آخر.
                </p>
            </div>
        `;

        return;

    }


    productGrid.innerHTML =
        filtered.map(product => {

            return `

                <article
                    class="product-card"
                    data-product-id="${product.id}"
                >

                    <div class="product-image">

                        ${product.emoji}

                    </div>


                    <div class="product-info">

                        <span class="product-category">
                            ${escapeHTML(product.category)}
                        </span>


                        <h3>
                            ${escapeHTML(product.name)}
                        </h3>


                        <div class="product-price">

                            ${formatPrice(product.price)}

                            <small>
                                / ${escapeHTML(product.unit)}
                            </small>

                        </div>


                        <button
                            class="add-cart"
                            type="button"
                            onclick="addToCart(${product.id})"
                        >

                            🛒 أضف للسلة

                        </button>

                    </div>

                </article>

            `;

        }).join("");

}


/* =========================================================
   ESCAPE HTML
========================================================= */

function escapeHTML(value) {

    return String(value)
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");

}


/* =========================================================
   ADD TO CART
========================================================= */

function addToCart(productId) {

    const product =
        products.find(
            item => item.id === Number(productId)
        );

    if (!product) {
        return;
    }


    const existing =
        cart.find(
            item =>
                Number(item.id) ===
                Number(productId)
        );


    if (existing) {

        existing.quantity =
            Number(existing.quantity || 0) + 1;

    } else {

        cart.push({

            id: product.id,

            name: product.name,

            category: product.category,

            price: product.price,

            unit: product.unit,

            emoji: product.emoji,

            quantity: 1

        });

    }


    saveCart();

    updateCartCount();

    showToast(
        `تم إضافة ${product.name} إلى السلة 🛒`
    );

}


/* =========================================================
   REMOVE FROM CART
========================================================= */

function removeFromCart(productId) {

    cart =
        cart.filter(
            item =>
                Number(item.id) !==
                Number(productId)
        );

    saveCart();

    updateCartCount();

    if (
        typeof window.renderCartPage ===
        "function"
    ) {

        window.renderCartPage();

    }

}


/* =========================================================
   INCREASE
========================================================= */

function increaseQuantity(productId) {

    const item =
        cart.find(
            item =>
                Number(item.id) ===
                Number(productId)
        );

    if (!item) {
        return;
    }

    item.quantity =
        Number(item.quantity || 0) + 1;

    saveCart();

    updateCartCount();

    if (
        typeof window.renderCartPage ===
        "function"
    ) {

        window.renderCartPage();

    }

}


/* =========================================================
   DECREASE
========================================================= */

function decreaseQuantity(productId) {

    const item =
        cart.find(
            item =>
                Number(item.id) ===
                Number(productId)
        );

    if (!item) {
        return;
    }


    item.quantity =
        Number(item.quantity || 0) - 1;


    if (item.quantity <= 0) {

        removeFromCart(productId);

        return;

    }


    saveCart();

    updateCartCount();

    if (
        typeof window.renderCartPage ===
        "function"
    ) {

        window.renderCartPage();

    }

}


/* =========================================================
   CART TOTAL
========================================================= */

function getCartTotal() {

    return cart.reduce(
        (total, item) => {

            return total +
                Number(item.price || 0) *
                Number(item.quantity || 0);

        },
        0
    );

}


/* =========================================================
   CART ITEMS COUNT
========================================================= */

function getCartItemsCount() {

    return cart.reduce(
        (total, item) =>
            total + Number(item.quantity || 0),
        0
    );

}


/* =========================================================
   CLEAR CART
========================================================= */

function clearCart() {

    cart = [];

    saveCart();

    updateCartCount();

}


/* =========================================================
   TOAST
========================================================= */

function showToast(message) {

    const oldToast =
        document.querySelector(".toast");

    if (oldToast) {
        oldToast.remove();
    }


    const toast =
        document.createElement("div");

    toast.className = "toast";

    toast.textContent = message;

    document.body.appendChild(toast);


    setTimeout(() => {

        toast.style.opacity = "0";

        toast.style.transform =
            "translateY(10px)";

        setTimeout(() => {

            toast.remove();

        }, 250);

    }, 2200);

}


/* =========================================================
   FILTERS
========================================================= */

document.addEventListener(
    "click",
    function(event) {

        const filter =
            event.target.closest(
                ".filter"
            );


        if (!filter) {
            return;
        }


        document
            .querySelectorAll(".filter")
            .forEach(button => {

                button.classList.remove(
                    "active"
                );

            });


        filter.classList.add(
            "active"
        );


        const category =
            filter.dataset.filter ||
            "الكل";


        renderProducts(
            category,
            searchInput
                ? searchInput.value
                : ""
        );

    }
);


/* =========================================================
   CATEGORY BUTTONS
========================================================= */

document.addEventListener(
    "click",
    function(event) {

        const categoryButton =
            event.target.closest(
                ".category-card"
            );


        if (!categoryButton) {
            return;
        }


        const category =
            categoryButton.dataset.category;


        document
            .querySelectorAll(".filter")
            .forEach(button => {

                button.classList.toggle(
                    "active",
                    button.dataset.filter ===
                    category
                );

            });


        renderProducts(
            category,
            searchInput
                ? searchInput.value
                : ""
        );


        const productsSection =
            document.getElementById(
                "products"
            );


        if (productsSection) {

            productsSection.scrollIntoView({
                behavior: "smooth"
            });

        }

    }
);


/* =========================================================
   SEARCH
========================================================= */

if (searchInput) {

    searchInput.addEventListener(
        "input",
        function() {

            const activeFilter =
                document.querySelector(
                    ".filter.active"
                );


            const category =
                activeFilter
                    ? activeFilter.dataset.filter
                    : "الكل";


            renderProducts(
                category,
                searchInput.value
            );

        }
    );

}


/* =========================================================
   CART BUTTON ANIMATION
========================================================= */

function animateCart() {

    const button =
        document.querySelector(
            ".cart-button"
        );

    if (!button) {
        return;
    }


    button.animate(
        [
            {
                transform:
                    "scale(1)"
            },

            {
                transform:
                    "scale(1.08)"
            },

            {
                transform:
                    "scale(1)"
            }
        ],
        {
            duration: 300
        }
    );

}


/* =========================================================
   OVERRIDE ADD TO CART FOR ANIMATION
========================================================= */

const originalAddToCart =
    window.addToCart;


window.addToCart = function(productId) {

    originalAddToCart(productId);

    animateCart();

};


/* =========================================================
   WHATSAPP ORDER LINK
========================================================= */

function createWhatsAppLink(
    customer = {},
    payment = "كاش"
) {

    let message =
        "طلب جديد من مول البركة%0A%0A";


    message +=
        "🛒 المنتجات:%0A";


    cart.forEach(item => {

        message +=
            `• ${encodeURIComponent(item.name)}` +
            ` × ${item.quantity}` +
            ` = ${encodeURIComponent(
                formatPrice(
                    item.price *
                    item.quantity
                )
            )}%0A`;

    });


    message +=
        `%0A💰 الإجمالي: ` +
        encodeURIComponent(
            formatPrice(
                getCartTotal()
            )
        );


    message +=
        `%0A💳 طريقة الدفع: ` +
        encodeURIComponent(payment);


    if (customer.name) {

        message +=
            `%0A👤 الاسم: ` +
            encodeURIComponent(
                customer.name
            );

    }


    if (customer.phone) {

        message +=
            `%0A📞 الهاتف: ` +
            encodeURIComponent(
                customer.phone
            );

    }


    if (customer.address) {

        message +=
            `%0A📍 العنوان: ` +
            encodeURIComponent(
                customer.address
            );

    }


    if (customer.notes) {

        message +=
            `%0A📝 ملاحظات: ` +
            encodeURIComponent(
                customer.notes
            );

    }


    return (
        "https://wa.me/" +
        WHATSAPP_NUMBER +
        "?text=" +
        message
    );

}


/* =========================================================
   GLOBAL EXPORTS
========================================================= */

window.products =
    products;

window.getCart =
    () => cart;

window.saveCart =
    saveCart;

window.updateCartCount =
    updateCartCount;

window.addToCart =
    window.addToCart;

window.removeFromCart =
    removeFromCart;

window.increaseQuantity =
    increaseQuantity;

window.decreaseQuantity =
    decreaseQuantity;

window.getCartTotal =
    getCartTotal;

window.getCartItemsCount =
    getCartItemsCount;

window.clearCart =
    clearCart;

window.formatPrice =
    formatPrice;

window.createWhatsAppLink =
    createWhatsAppLink;

window.showToast =
    showToast;


/* =========================================================
   START
========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function() {

        updateCartCount();

        renderProducts();

    }
);
