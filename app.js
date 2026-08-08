/* =====================================================
   ALBARAKA MALL
   Store Main JavaScript
===================================================== */

const products = [

    {
        id: 1,
        name: "أرز فاخر 1 كيلو",
        category: "grocery",
        categoryName: "بقالة",
        price: 35,
        oldPrice: 42,
        unit: "للكيلو",
        image: "🍚",
        rating: 4.8,
        badge: "خصم"
    },

    {
        id: 2,
        name: "طماطم طازجة",
        category: "vegetables",
        categoryName: "خضروات وفاكهة",
        price: 25,
        oldPrice: 30,
        unit: "للكيلو",
        image: "🍅",
        rating: 4.9,
        badge: "عرض"
    },

    {
        id: 3,
        name: "تفاح أحمر",
        category: "vegetables",
        categoryName: "خضروات وفاكهة",
        price: 65,
        oldPrice: 75,
        unit: "للكيلو",
        image: "🍎",
        rating: 4.8,
        badge: "خصم"
    },

    {
        id: 4,
        name: "موز طازج",
        category: "vegetables",
        categoryName: "خضروات وفاكهة",
        price: 35,
        oldPrice: 40,
        unit: "للكيلو",
        image: "🍌",
        rating: 4.7,
        badge: ""
    },

    {
        id: 5,
        name: "برتقال طازج",
        category: "vegetables",
        categoryName: "خضروات وفاكهة",
        price: 30,
        oldPrice: 38,
        unit: "للكيلو",
        image: "🍊",
        rating: 4.7,
        badge: "عرض"
    },

    {
        id: 6,
        name: "لحمة بقري طازجة",
        category: "meat",
        categoryName: "اللحوم",
        price: 390,
        oldPrice: 430,
        unit: "للكيلو",
        image: "🥩",
        rating: 4.9,
        badge: "خصم"
    },

    {
        id: 7,
        name: "فراخ كاملة",
        category: "chicken",
        categoryName: "دواجن",
        price: 145,
        oldPrice: 160,
        unit: "للكيلو",
        image: "🍗",
        rating: 4.8,
        badge: "عرض"
    },

    {
        id: 8,
        name: "لبن كامل الدسم",
        category: "dairy",
        categoryName: "ألبان",
        price: 38,
        oldPrice: 42,
        unit: "1 لتر",
        image: "🥛",
        rating: 4.8,
        badge: ""
    },

    {
        id: 9,
        name: "جبنة بيضاء",
        category: "dairy",
        categoryName: "ألبان",
        price: 75,
        oldPrice: 85,
        unit: "500 جرام",
        image: "🧀",
        rating: 4.7,
        badge: "خصم"
    },

    {
        id: 10,
        name: "عصير برتقال",
        category: "drinks",
        categoryName: "مشروبات",
        price: 30,
        oldPrice: 35,
        unit: "1 لتر",
        image: "🧃",
        rating: 4.6,
        badge: ""
    },

    {
        id: 11,
        name: "مياه معدنية",
        category: "drinks",
        categoryName: "مشروبات",
        price: 8,
        oldPrice: 10,
        unit: "1.5 لتر",
        image: "💧",
        rating: 4.8,
        badge: "عرض"
    },

    {
        id: 12,
        name: "منظف أرضيات",
        category: "cleaning",
        categoryName: "منظفات",
        price: 55,
        oldPrice: 65,
        unit: "1 لتر",
        image: "🧴",
        rating: 4.6,
        badge: "خصم"
    },

    {
        id: 13,
        name: "خبز طازج",
        category: "bakery",
        categoryName: "مخبوزات",
        price: 15,
        oldPrice: 18,
        unit: "عبوة",
        image: "🍞",
        rating: 4.9,
        badge: ""
    },

    {
        id: 14,
        name: "سكر أبيض 1 كيلو",
        category: "grocery",
        categoryName: "بقالة",
        price: 32,
        oldPrice: 36,
        unit: "للكيلو",
        image: "🧂",
        rating: 4.7,
        badge: ""
    },

    {
        id: 15,
        name: "زيت طعام",
        category: "grocery",
        categoryName: "بقالة",
        price: 75,
        oldPrice: 82,
        unit: "1 لتر",
        image: "🫗",
        rating: 4.8,
        badge: "عرض"
    }

];


/* =====================================================
   CART
===================================================== */

let cart = JSON.parse(
    localStorage.getItem("albarakaCart")
) || [];


/* =====================================================
   DOM
===================================================== */

const productsGrid =
    document.getElementById("productsGrid");

const noProducts =
    document.getElementById("noProducts");

const cartCount =
    document.getElementById("cartCount");

const searchInput =
    document.getElementById("searchInput");

const mobileSearchInput =
    document.getElementById("mobileSearchInput");

const searchButton =
    document.getElementById("searchButton");

const mobileSearchButton =
    document.getElementById("mobileSearchButton");

const toast =
    document.getElementById("toast");

const toastMessage =
    document.getElementById("toastMessage");


/* =====================================================
   FORMAT PRICE
===================================================== */

function formatPrice(price) {

    return Number(price).toLocaleString("ar-EG") + " ج.م";

}


/* =====================================================
   RENDER PRODUCTS
===================================================== */

function renderProducts(
    category = "all",
    searchTerm = ""
) {

    if (!productsGrid) {
        return;
    }

    const search =
        searchTerm
            .trim()
            .toLowerCase();

    let filteredProducts =
        products.filter(product => {

            const categoryMatch =
                category === "all" ||
                product.category === category;

            const searchMatch =
                !search ||
                product.name
                    .toLowerCase()
                    .includes(search) ||
                product.categoryName
                    .toLowerCase()
                    .includes(search);

            return categoryMatch &&
                   searchMatch;

        });


    productsGrid.innerHTML = "";


    if (filteredProducts.length === 0) {

        if (noProducts) {
            noProducts.hidden = false;
        }

        return;

    }


    if (noProducts) {
        noProducts.hidden = true;
    }


    filteredProducts.forEach(product => {

        const card =
            document.createElement("article");

        card.className =
            "product-card";


        card.innerHTML = `

            <div class="product-image">

                ${
                    product.badge
                    ?
                    `
                    <span class="product-badge">
                        ${product.badge}
                    </span>
                    `
                    :
                    ""
                }

                <button
                    class="product-favorite"
                    type="button"
                    data-favorite="${product.id}"
                    aria-label="إضافة للمفضلة"
                >
                    ♡
                </button>

                <span>
                    ${product.image}
                </span>

            </div>


            <div class="product-info">

                <span class="product-category">
                    ${product.categoryName}
                </span>

                <h3 class="product-name">
                    ${product.name}
                </h3>

                <div class="product-rating">
                    ★★★★★
                    <span>
                        ${product.rating}
                    </span>
                </div>


                <div class="product-bottom">

                    <div>

                        <div class="product-price">
                            ${formatPrice(product.price)}
                        </div>

                        <div class="product-unit">
                            ${product.unit}
                        </div>

                    </div>


                    <button
                        class="add-cart"
                        type="button"
                        data-product-id="${product.id}"
                        aria-label="إضافة إلى السلة"
                    >
                        +
                    </button>

                </div>

            </div>

        `;


        productsGrid.appendChild(card);

    });


    attachProductEvents();

}


/* =====================================================
   PRODUCT EVENTS
===================================================== */

function attachProductEvents() {

    const buttons =
        document.querySelectorAll(
            ".add-cart"
        );


    buttons.forEach(button => {

        button.addEventListener(
            "click",
            () => {

                const id =
                    Number(
                        button.dataset.productId
                    );

                addToCart(id);

            }
        );

    });


    const favoriteButtons =
        document.querySelectorAll(
            ".product-favorite"
        );


    favoriteButtons.forEach(button => {

        button.addEventListener(
            "click",
            () => {

                if (
                    button.textContent.trim()
                    === "♡"
                ) {

                    button.textContent =
                        "♥";

                    showToast(
                        "تمت الإضافة للمفضلة ❤️"
                    );

                } else {

                    button.textContent =
                        "♡";

                    showToast(
                        "تمت الإزالة من المفضلة"
                    );

                }

            }
        );

    });

}


/* =====================================================
   ADD TO CART
===================================================== */

function addToCart(productId) {

    const product =
        products.find(
            item => item.id === productId
        );


    if (!product) {
        return;
    }


    const existing =
        cart.find(
            item => item.id === productId
        );


    if (existing) {

        existing.quantity += 1;

    } else {

        cart.push({

            id: product.id,

            name: product.name,

            price: product.price,

            image: product.image,

            unit: product.unit,

            quantity: 1

        });

    }


    saveCart();

    updateCartCount();

    showToast(
        `تمت إضافة ${product.name} إلى السلة 🛒`
    );

}


/* =====================================================
   SAVE CART
===================================================== */

function saveCart() {

    localStorage.setItem(
        "albarakaCart",
        JSON.stringify(cart)
    );

}


/* =====================================================
   CART COUNT
===================================================== */

function updateCartCount() {

    if (!cartCount) {
        return;
    }


    const total =
        cart.reduce(
            (sum, item) =>
                sum + item.quantity,
            0
        );


    cartCount.textContent =
        total;


    const cartTotal =
        cart.reduce(
            (sum, item) =>
                sum +
                (item.price * item.quantity),
            0
        );


    const cartPrice =
        document.querySelector(
            ".cart-text strong"
        );


    if (cartPrice) {

        cartPrice.textContent =
            formatPrice(cartTotal);

    }

}


/* =====================================================
   FILTER BUTTONS
===================================================== */

const productTabs =
    document.querySelectorAll(
        ".product-tab"
    );


productTabs.forEach(tab => {

    tab.addEventListener(
        "click",
        () => {

            productTabs.forEach(
                item =>
                    item.classList.remove(
                        "active"
                    )
            );


            tab.classList.add(
                "active"
            );


            const category =
                tab.dataset.category;


            const search =
                searchInput
                    ? searchInput.value
                    : "";


            renderProducts(
                category,
                search
            );

        }
    );

});


/* =====================================================
   CATEGORY CARDS
===================================================== */

const categoryCards =
    document.querySelectorAll(
        ".category-card"
    );


categoryCards.forEach(card => {

    card.addEventListener(
        "click",
        () => {

            const category =
                card.dataset.category;


            productTabs.forEach(
                tab => {

                    tab.classList.toggle(
                        "active",
                        tab.dataset.category
                        === category
                    );

                }
            );


            const productsSection =
                document.getElementById(
                    "products"
                );


            renderProducts(
                category
            );


            if (productsSection) {

                productsSection.scrollIntoView({
                    behavior: "smooth"
                });

            }

        }
    );

});


/* =====================================================
   SEARCH
===================================================== */

function performSearch(inputElement) {

    if (!inputElement) {
        return;
    }


    const term =
        inputElement.value.trim();


    productTabs.forEach(tab => {

        tab.classList.toggle(
            "active",
            tab.dataset.category === "all"
        );

    });


    renderProducts(
        "all",
        term
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


/* =====================================================
   DESKTOP SEARCH
===================================================== */

if (searchButton) {

    searchButton.addEventListener(
        "click",
        () => {

            performSearch(
                searchInput
            );

        }
    );

}


if (searchInput) {

    searchInput.addEventListener(
        "keydown",
        event => {

            if (
                event.key === "Enter"
            ) {

                performSearch(
                    searchInput
                );

            }

        }
    );

}


/* =====================================================
   MOBILE SEARCH
===================================================== */

if (mobileSearchButton) {

    mobileSearchButton.addEventListener(
        "click",
        () => {

            performSearch(
                mobileSearchInput
            );

        }
    );

}


if (mobileSearchInput) {

    mobileSearchInput.addEventListener(
        "keydown",
        event => {

            if (
                event.key === "Enter"
            ) {

                performSearch(
                    mobileSearchInput
                );

            }

        }
    );

}


/* =====================================================
   NEWSLETTER
===================================================== */

const newsletterForm =
    document.getElementById(
        "newsletterForm"
    );


if (newsletterForm) {

    newsletterForm.addEventListener(
        "submit",
        event => {

            event.preventDefault();


            const email =
                document.getElementById(
                    "newsletterEmail"
                ).value.trim();


            if (!email) {
                return;
            }


            showToast(
                "تم تسجيل بريدك بنجاح 📩"
            );


            newsletterForm.reset();

        }
    );

}


/* =====================================================
   TOAST
===================================================== */

function showToast(message) {

    if (!toast || !toastMessage) {
        return;
    }


    toastMessage.textContent =
        message;


    toast.classList.add(
        "show"
    );


    clearTimeout(
        window.toastTimer
    );


    window.toastTimer =
        setTimeout(
            () => {

                toast.classList.remove(
                    "show"
                );

            },
            2500
        );

}


/* =====================================================
   INITIALIZE
===================================================== */

document.addEventListener(
    "DOMContentLoaded",
    () => {

        renderProducts();

        updateCartCount();

    }
);
