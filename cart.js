/* =========================================================
   مول البركة - نظام السلة
   يعمل بدون PHP
   ========================================================= */

(function () {

    "use strict";


    /* -----------------------------------------------------
       أسماء أماكن التخزين التي نحاول قراءتها
       ----------------------------------------------------- */

    const CART_KEYS = [
        "albaraka_cart",
        "shopping_cart",
        "cart"
    ];


    /* -----------------------------------------------------
       معرفة مكان السلة
       ----------------------------------------------------- */

    function findCartKey() {

        for (const key of CART_KEYS) {

            const value = localStorage.getItem(key);

            if (value !== null) {
                return key;
            }

        }

        return "albaraka_cart";
    }


    let CART_KEY = findCartKey();


    /* -----------------------------------------------------
       قراءة السلة
       ----------------------------------------------------- */

    function getCart() {

        try {

            const data = localStorage.getItem(CART_KEY);

            if (!data) {
                return [];
            }

            const parsed = JSON.parse(data);

            if (Array.isArray(parsed)) {
                return parsed;
            }

            if (typeof parsed === "object" && parsed !== null) {

                return Object.values(parsed);

            }

            return [];

        } catch (error) {

            console.error("Cart read error:", error);

            return [];

        }

    }


    /* -----------------------------------------------------
       حفظ السلة
       ----------------------------------------------------- */

    function saveCart(cart) {

        localStorage.setItem(
            CART_KEY,
            JSON.stringify(cart)
        );

        /* نحاول الحفاظ على التوافق مع المشروع القديم */

        localStorage.setItem(
            "albaraka_cart",
            JSON.stringify(cart)
        );

    }


    /* -----------------------------------------------------
       تنظيف بيانات المنتجات
       ----------------------------------------------------- */

    function normalizeProduct(item) {

        if (!item) {
            return null;
        }


        const id =
            item.id ??
            item.product_id ??
            item.productId ??
            item.code;


        const name =
            item.name ??
            item.product_name ??
            item.title ??
            "منتج";


        const price =
            Number(
                item.price ??
                item.sale_price ??
                item.product_price ??
                0
            );


        const quantity =
            Number(
                item.quantity ??
                item.qty ??
                item.count ??
                1
            );


        const image =
            item.image ??
            item.image_url ??
            item.photo ??
            item.thumbnail ??
            "";


        return {

            id: String(
                id ?? Date.now()
            ),

            name: String(name),

            price: isNaN(price)
                ? 0
                : price,

            quantity:
                quantity > 0
                    ? quantity
                    : 1,

            image: image

        };

    }


    /* -----------------------------------------------------
       الحصول على المنتجات
       ----------------------------------------------------- */

    function getProducts() {

        return getCart()
            .map(normalizeProduct)
            .filter(Boolean);

    }


    /* -----------------------------------------------------
       حفظ المنتجات
       ----------------------------------------------------- */

    function setProducts(products) {

        saveCart(products);

    }


    /* -----------------------------------------------------
       تنسيق السعر
       ----------------------------------------------------- */

    function money(value) {

        return Number(value || 0)
            .toLocaleString("ar-EG") +
            " جنيه";

    }


    /* -----------------------------------------------------
       إجمالي عدد المنتجات
       ----------------------------------------------------- */

    function getCount(products) {

        return products.reduce(
            function (total, item) {

                return total +
                    Number(item.quantity || 0);

            },
            0
        );

    }


    /* -----------------------------------------------------
       إجمالي السعر
       ----------------------------------------------------- */

    function getTotal(products) {

        return products.reduce(
            function (total, item) {

                return total +
                    (
                        Number(item.price || 0) *
                        Number(item.quantity || 0)
                    );

            },
            0
        );

    }


    /* -----------------------------------------------------
       رسم السلة
       ----------------------------------------------------- */

    function renderCart() {

        const area =
            document.getElementById("cartArea");


        if (!area) {
            return;
        }


        const products =
            getProducts();


        /* السلة فارغة */

        if (products.length === 0) {

            area.innerHTML = `

                <div class="box empty">

                    <div class="empty-icon">
                        🛒
                    </div>

                    <h2>
                        السلة فارغة
                    </h2>

                    <p>
                        لم تضف أي منتجات إلى السلة بعد.
                    </p>

                    <a
                        href="index.html"
                        class="shop">

                        ابدأ التسوق

                    </a>

                </div>

            `;

            updateCartBadges(0);

            return;
        }


        let itemsHTML = "";


        products.forEach(function (item, index) {

            const quantity =
                Number(item.quantity || 1);


            const subtotal =
                Number(item.price || 0) *
                quantity;


            const imageHTML =
                item.image

                    ? `
                        <img
                            src="${escapeHTML(item.image)}"
                            class="item-image"
                            alt="${escapeHTML(item.name)}"
                            onerror="this.style.display='none';">
                      `

                    : `
                        <div
                            class="item-image"
                            style="
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:40px;
                            ">
                            🛒
                        </div>
                      `;


            itemsHTML += `

                <div class="cart-item">

                    ${imageHTML}

                    <div class="item-info">

                        <div class="item-name">
                            ${escapeHTML(item.name)}
                        </div>

                        <div class="item-price">
                            ${money(item.price)}
                        </div>

                        <div class="item-total">
                            الإجمالي:
                            ${money(subtotal)}
                        </div>

                    </div>


                    <div>

                        <div class="quantity">

                            <button
                                type="button"
                                onclick="window.cartPlus('${escapeAttribute(item.id)}')">

                                +

                            </button>

                            <span>
                                ${quantity}
                            </span>

                            <button
                                type="button"
                                onclick="window.cartMinus('${escapeAttribute(item.id)}')">

                                −

                            </button>

                        </div>


                        <button
                            type="button"
                            class="remove"
                            onclick="window.cartRemove('${escapeAttribute(item.id)}')">

                            🗑 حذف

                        </button>

                    </div>

                </div>

            `;

        });


        const count =
            getCount(products);


        const total =
            getTotal(products);


        area.innerHTML = `

            <div class="layout">


                <div class="box">

                    ${itemsHTML}

                </div>


                <div class="box summary">

                    <h2>
                        ملخص الطلب
                    </h2>


                    <div class="summary-row">

                        <span>
                            عدد المنتجات
                        </span>

                        <strong>
                            ${count}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            قيمة المنتجات
                        </span>

                        <strong>
                            ${money(total)}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            التوصيل
                        </span>

                        <strong>
                            يحدد عند إتمام الطلب
                        </strong>

                    </div>


                    <div class="total">

                        <span>
                            الإجمالي
                        </span>

                        <span>
                            ${money(total)}
                        </span>

                    </div>


                    <a
                        href="checkout.html"
                        class="checkout"
                        id="checkoutButton">

                        إتمام الطلب

                    </a>


                    <button
                        type="button"
                        class="clear"
                        onclick="window.clearCart()">

                        🗑 تفريغ السلة بالكامل

                    </button>

                </div>

            </div>

        `;


        updateCartBadges(count);

    }


    /* -----------------------------------------------------
       زيادة الكمية
       ----------------------------------------------------- */

    window.cartPlus = function (id) {

        const products =
            getProducts();


        const item =
            products.find(
                product =>
                    String(product.id) === String(id)
            );


        if (item) {

            item.quantity =
                Number(item.quantity || 0) + 1;

        }


        setProducts(products);

        renderCart();

    };


    /* -----------------------------------------------------
       تقليل الكمية
       ----------------------------------------------------- */

    window.cartMinus = function (id) {

        let products =
            getProducts();


        const item =
            products.find(
                product =>
                    String(product.id) === String(id)
            );


        if (!item) {
            return;
        }


        item.quantity =
            Number(item.quantity || 1) - 1;


        if (item.quantity <= 0) {

            products =
                products.filter(
                    product =>
                        String(product.id) !== String(id)
                );

        }


        setProducts(products);

        renderCart();

    };


    /* -----------------------------------------------------
       حذف منتج
       ----------------------------------------------------- */

    window.cartRemove = function (id) {

        let products =
            getProducts();


        products =
            products.filter(
                product =>
                    String(product.id) !== String(id)
            );


        setProducts(products);

        renderCart();

    };


    /* -----------------------------------------------------
       تفريغ السلة
       ----------------------------------------------------- */

    window.clearCart = function () {

        const answer =
            confirm(
                "هل تريد تفريغ السلة بالكامل؟"
            );


        if (!answer) {
            return;
        }


        localStorage.removeItem(
            "albaraka_cart"
        );

        localStorage.removeItem(
            "shopping_cart"
        );

        localStorage.removeItem(
            "cart"
        );


        CART_KEY =
            "albaraka_cart";


        renderCart();

    };


    /* -----------------------------------------------------
       تحديث عداد السلة في الموقع
       ----------------------------------------------------- */

    function updateCartBadges(count) {

        const selectors = [

            ".cart-count",

            "#cartCount",

            "#cart-count",

            "[data-cart-count]"

        ];


        selectors.forEach(function (selector) {

            document
                .querySelectorAll(selector)
                .forEach(function (element) {

                    element.textContent =
                        count;

                });

        });

    }


    /* -----------------------------------------------------
       إرسال السلة إلى checkout
       ----------------------------------------------------- */

    function prepareCheckout() {

        const button =
            document.getElementById(
                "checkoutButton"
            );


        if (!button) {
            return;
        }


        button.addEventListener(
            "click",
            function () {

                const products =
                    getProducts();


                if (products.length === 0) {

                    alert(
                        "السلة فارغة"
                    );

                    return;

                }


                /* حفظ نسخة مؤكدة */

                sessionStorage.setItem(
                    "checkout_cart",
                    JSON.stringify(products)
                );

            }
        );

    }


    /* -----------------------------------------------------
       حماية النصوص
       ----------------------------------------------------- */

    function escapeHTML(value) {

        return String(value)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");

    }


    function escapeAttribute(value) {

        return String(value)
            .replace(/\\/g, "\\\\")
            .replace(/'/g, "\\'");

    }


    /* -----------------------------------------------------
       مزامنة لو السلة اتغيرت من صفحة أخرى
       ----------------------------------------------------- */

    window.addEventListener(
        "storage",
        function () {

            CART_KEY =
                findCartKey();

            renderCart();

        }
    );


    /* -----------------------------------------------------
       بدء التشغيل
       ----------------------------------------------------- */

    document.addEventListener(
        "DOMContentLoaded",
        function () {

            renderCart();

            prepareCheckout();

        }
    );


})();
