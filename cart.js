/* =========================================
   AlbarakaMall
   Shopping Cart System
========================================= */

(function () {

    "use strict";


    /* =========================================
       Storage Key
    ========================================= */

    const CART_KEY = "albaraka_cart";


    /* =========================================
       Get Cart
    ========================================= */

    function getCart() {

        try {

            const savedCart =
                localStorage.getItem(CART_KEY);

            if (!savedCart) {
                return [];
            }

            const cart =
                JSON.parse(savedCart);

            if (!Array.isArray(cart)) {
                return [];
            }

            return cart;

        } catch (error) {

            console.error(
                "خطأ في قراءة السلة:",
                error
            );

            return [];
        }
    }


    /* =========================================
       Save Cart
    ========================================= */

    function saveCart(cart) {

        try {

            localStorage.setItem(
                CART_KEY,
                JSON.stringify(cart)
            );

        } catch (error) {

            console.error(
                "خطأ في حفظ السلة:",
                error
            );
        }
    }


    /* =========================================
       Format Price
    ========================================= */

    function formatPrice(price) {

        const number =
            Number(price) || 0;

        return number.toLocaleString(
            "ar-EG"
        );
    }


    /* =========================================
       Elements
    ========================================= */

    const cartItems =
        document.getElementById(
            "cartItems"
        );

    const emptyCart =
        document.getElementById(
            "emptyCart"
        );

    const cartCount =
        document.getElementById(
            "cartCount"
        );

    const subtotal =
        document.getElementById(
            "subtotal"
        );

    const shipping =
        document.getElementById(
            "shipping"
        );

    const total =
        document.getElementById(
            "total"
        );

    const checkoutBtn =
        document.getElementById(
            "checkoutBtn"
        );

    const notification =
        document.getElementById(
            "cartNotification"
        );


    /* =========================================
       Notification
    ========================================= */

    let notificationTimer = null;

    function showNotification(message) {

        if (!notification) {
            return;
        }

        notification.textContent =
            message;

        notification.classList.add(
            "show"
        );

        clearTimeout(
            notificationTimer
        );

        notificationTimer =
            setTimeout(function () {

                notification.classList.remove(
                    "show"
                );

            }, 2200);
    }


    /* =========================================
       Calculate Count
    ========================================= */

    function getProductsCount(cart) {

        return cart.reduce(
            function (total, item) {

                return total +
                    (Number(item.quantity) || 0);

            },
            0
        );
    }


    /* =========================================
       Calculate Subtotal
    ========================================= */

    function getSubtotal(cart) {

        return cart.reduce(
            function (total, item) {

                const price =
                    Number(item.price) || 0;

                const quantity =
                    Number(item.quantity) || 0;

                return total +
                    (price * quantity);

            },
            0
        );
    }


    /* =========================================
       Shipping
    ========================================= */

    function calculateShipping(subtotalValue) {

        /*
          في هذه المرحلة الشحن مجاني.
          سنضيف نظام الشحن لاحقًا.
        */

        if (subtotalValue <= 0) {
            return 0;
        }

        return 0;
    }


    /* =========================================
       Update Cart Badge
    ========================================= */

    function updateCartBadges() {

        const cart =
            getCart();

        const count =
            getProductsCount(cart);


        /*
          ندعم أكثر من اسم لعداد السلة
          حتى نستطيع ربطه بواجهة المتجر.
        */

        const selectors = [
            "#cartCountBadge",
            "#cartBadge",
            ".cart-count",
            ".cart-badge",
            "[data-cart-count]"
        ];


        selectors.forEach(
            function (selector) {

                const elements =
                    document.querySelectorAll(
                        selector
                    );

                elements.forEach(
                    function (element) {

                        element.textContent =
                            count;

                        if (count > 0) {

                            element.style.display =
                                "";

                        } else {

                            element.style.display =
                                "none";
                        }

                    }
                );
            }
        );
    }


    /* =========================================
       Render Cart
    ========================================= */

    function renderCart() {

        const cart =
            getCart();


        if (!cartItems) {
            updateCartBadges();
            return;
        }


        /*
          Empty Cart
        */

        if (cart.length === 0) {

            cartItems.innerHTML = "";

            if (emptyCart) {
                emptyCart.style.display =
                    "block";
            }

            if (checkoutBtn) {
                checkoutBtn.disabled =
                    true;
            }

        } else {

            if (emptyCart) {
                emptyCart.style.display =
                    "none";
            }

            if (checkoutBtn) {
                checkoutBtn.disabled =
                    false;
            }


            cartItems.innerHTML =
                cart.map(
                    function (item, index) {

                        return createCartItem(
                            item,
                            index
                        );

                    }
                ).join("");
        }


        updateSummary(
            cart
        );

        updateCartBadges();
    }


    /* =========================================
       Create Cart Item
    ========================================= */

    function createCartItem(
        item,
        index
    ) {

        const name =
            escapeHTML(
                item.name ||
                "منتج"
            );


        const price =
            Number(item.price) || 0;


        const quantity =
            Math.max(
                1,
                Number(item.quantity) || 1
            );


        const itemTotal =
            price * quantity;


        const image =
            item.image ||
            item.img ||
            "";


        const imageHTML =
            image
                ? `
                    <img
                        src="${escapeAttribute(image)}"
                        alt="${escapeAttribute(name)}"
                        onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=&quot;no-image&quot;>🛍️</div>';"
                    >
                  `
                : `
                    <div class="no-image">
                        🛍️
                    </div>
                  `;


        return `
            <article
                class="cart-item"
                data-index="${index}"
            >

                <div class="cart-item-image">
                    ${imageHTML}
                </div>


                <div class="cart-item-info">

                    <h3 class="cart-item-name">
                        ${name}
                    </h3>


                    <div class="cart-item-price">

                        ${formatPrice(price)}
                        ج.م

                        <span class="cart-item-unit">
                            / للمنتج
                        </span>

                    </div>


                    <div class="quantity-control">

                        <button
                            type="button"
                            class="quantity-btn"
                            data-action="increase"
                            data-index="${index}"
                            aria-label="زيادة الكمية"
                        >
                            +
                        </button>


                        <span
                            class="quantity-value"
                        >
                            ${quantity}
                        </span>


                        <button
                            type="button"
                            class="quantity-btn"
                            data-action="decrease"
                            data-index="${index}"
                            aria-label="تقليل الكمية"
                        >
                            −
                        </button>

                    </div>

                </div>


                <div class="cart-item-actions">

                    <div class="cart-item-total">

                        ${formatPrice(itemTotal)}
                        ج.م

                    </div>


                    <button
                        type="button"
                        class="remove-btn"
                        data-action="remove"
                        data-index="${index}"
                    >
                        🗑 حذف المنتج
                    </button>

                </div>

            </article>
        `;
    }


    /* =========================================
       Update Summary
    ========================================= */

    function updateSummary(cart) {

        const count =
            getProductsCount(cart);

        const subtotalValue =
            getSubtotal(cart);

        const shippingValue =
            calculateShipping(
                subtotalValue
            );

        const totalValue =
            subtotalValue +
            shippingValue;


        if (cartCount) {

            cartCount.textContent =
                count;
        }


        if (subtotal) {

            subtotal.textContent =
                formatPrice(
                    subtotalValue
                );
        }


        if (shipping) {

            shipping.textContent =
                shippingValue > 0
                    ? `${formatPrice(shippingValue)} ج.م`
                    : "مجاني";
        }


        if (total) {

            total.textContent =
                formatPrice(
                    totalValue
                );
        }
    }


    /* =========================================
       Increase Quantity
    ========================================= */

    function increaseQuantity(index) {

        const cart =
            getCart();


        if (!cart[index]) {
            return;
        }


        cart[index].quantity =
            (Number(
                cart[index].quantity
            ) || 1) + 1;


        saveCart(cart);

        renderCart();

        showNotification(
            "تمت زيادة الكمية"
        );
    }


    /* =========================================
       Decrease Quantity
    ========================================= */

    function decreaseQuantity(index) {

        const cart =
            getCart();


        if (!cart[index]) {
            return;
        }


        const currentQuantity =
            Number(
                cart[index].quantity
            ) || 1;


        if (currentQuantity <= 1) {

            removeItem(index);

            return;
        }


        cart[index].quantity =
            currentQuantity - 1;


        saveCart(cart);

        renderCart();

        showNotification(
            "تم تقليل الكمية"
        );
    }


    /* =========================================
       Remove Item
    ========================================= */

    function removeItem(index) {

        const cart =
            getCart();


        if (!cart[index]) {
            return;
        }


        const productName =
            cart[index].name ||
            "المنتج";


        cart.splice(
            index,
            1
        );


        saveCart(cart);

        renderCart();

        showNotification(
            `تم حذف ${productName} من السلة`
        );
    }


    /* =========================================
       Event Delegation
    ========================================= */

    if (cartItems) {

        cartItems.addEventListener(
            "click",
            function (event) {

                const button =
                    event.target.closest(
                        "[data-action]"
                    );


                if (!button) {
                    return;
                }


                const action =
                    button.dataset.action;


                const index =
                    Number(
                        button.dataset.index
                    );


                if (
                    Number.isNaN(index)
                ) {
                    return;
                }


                if (
                    action ===
                    "increase"
                ) {

                    increaseQuantity(
                        index
                    );

                }


                if (
                    action ===
                    "decrease"
                ) {

                    decreaseQuantity(
                        index
                    );

                }


                if (
                    action ===
                    "remove"
                ) {

                    removeItem(
                        index
                    );

                }

            }
        );
    }


    /* =========================================
       Checkout
    ========================================= */

    if (checkoutBtn) {

        checkoutBtn.addEventListener(
            "click",
            function () {

                const cart =
                    getCart();


                if (
                    cart.length === 0
                ) {

                    showNotification(
                        "السلة فارغة"
                    );

                    return;
                }


                /*
                  صفحة الدفع سيتم إنشاؤها
                  في المرحلة الثانية.
                */

                showNotification(
                    "سيتم تجهيز صفحة إتمام الطلب في المرحلة القادمة"
                );
            }
        );
    }


    /* =========================================
       Escape HTML
    ========================================= */

    function escapeHTML(value) {

        return String(value)
            .replace(
                /&/g,
                "&amp;"
            )
            .replace(
                /</g,
                "&lt;"
            )
            .replace(
                />/g,
                "&gt;"
            )
            .replace(
                /"/g,
                "&quot;"
            )
            .replace(
                /'/g,
                "&#039;"
            );
    }


    /* =========================================
       Escape Attribute
    ========================================= */

    function escapeAttribute(value) {

        return escapeHTML(
            value
        );
    }


    /* =========================================
       Public Add To Cart Function
    ========================================= */

    window.AlbarakaCart = {

        add: function (product) {

            if (
                !product ||
                typeof product !==
                "object"
            ) {

                return false;
            }


            const cart =
                getCart();


            const productId =
                product.id ??
                product.productId ??
                product._id ??
                product.name;


            const existingIndex =
                cart.findIndex(
                    function (item) {

                        const itemId =
                            item.id ??
                            item.productId ??
                            item._id ??
                            item.name;


                        return String(
                            itemId
                        ) === String(
                            productId
                        );

                    }
                );


            if (
                existingIndex !== -1
            ) {

                cart[
                    existingIndex
                ].quantity =
                    (
                        Number(
                            cart[
                                existingIndex
                            ].quantity
                        ) || 1
                    ) + 1;

            } else {

                cart.push({

                    id:
                        product.id ??
                        product.productId ??
                        product._id ??
                        Date.now(),

                    name:
                        product.name ||
                        product.title ||
                        "منتج",

                    price:
                        Number(
                            product.price
                        ) || 0,

                    image:
                        product.image ||
                        product.img ||
                        "",

                    quantity: 1

                });
            }


            saveCart(cart);

            updateCartBadges();

            showNotification(
                "تمت إضافة المنتج إلى السلة"
            );


            return true;
        },


        get: function () {

            return getCart();

        },


        clear: function () {

            saveCart([]);

            renderCart();

        },


        count: function () {

            return getProductsCount(
                getCart()
            );

        },


        total: function () {

            return getSubtotal(
                getCart()
            );

        }

    };


    /* =========================================
       Initialize
    ========================================= */

    document.addEventListener(
        "DOMContentLoaded",
        function () {

            renderCart();

        }
    );


})();
