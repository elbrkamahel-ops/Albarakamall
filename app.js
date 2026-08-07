/* =========================================================
   مول البركة - app.js
   متجر إلكتروني
========================================================= */

const API_BASE = "api";

let products = [];
let cart = JSON.parse(localStorage.getItem("albaraka_cart") || "[]");

let currentCategory = "all";
let currentSearch = "";


/* =========================================================
   منتجات تجريبية
   سيتم استبدالها بقاعدة البيانات عند المرحلة القادمة
========================================================= */

const demoProducts = [
    {
        id: 1,
        name: "طماطم بلدي",
        category: "خضروات وفاكهة",
        price: 25,
        unit: "كيلو",
        image: "",
        emoji: "🍅"
    },

    {
        id: 2,
        name: "بطاطس",
        category: "خضروات وفاكهة",
        price: 28,
        unit: "كيلو",
        image: "",
        emoji: "🥔"
    },

    {
        id: 3,
        name: "بصل",
        category: "خضروات وفاكهة",
        price: 30,
        unit: "كيلو",
        image: "",
        emoji: "🧅"
    },

    {
        id: 4,
        name: "موز",
        category: "خضروات وفاكهة",
        price: 35,
        unit: "كيلو",
        image: "",
        emoji: "🍌"
    },

    {
        id: 5,
        name: "تفاح",
        category: "خضروات وفاكهة",
        price: 65,
        unit: "كيلو",
        image: "",
        emoji: "🍎"
    },

    {
        id: 6,
        name: "لحمة بلدي",
        category: "لحوم",
        price: 420,
        unit: "كيلو",
        image: "",
        emoji: "🥩"
    },

    {
        id: 7,
        name: "كبدة بلدي",
        category: "جزارة",
        price: 390,
        unit: "كيلو",
        image: "",
        emoji: "🥩"
    },

    {
        id: 8,
        name: "فراخ كاملة",
        category: "دواجن",
        price: 115,
        unit: "كيلو",
        image: "",
        emoji: "🍗"
    },

    {
        id: 9,
        name: "صدور فراخ",
        category: "دواجن",
        price: 180,
        unit: "كيلو",
        image: "",
        emoji: "🍗"
    },

    {
        id: 10,
        name: "أرز فاخر",
        category: "ماركت",
        price: 45,
        unit: "كيلو",
        image: "",
        emoji: "🍚"
    },

    {
        id: 11,
        name: "زيت طعام",
        category: "ماركت",
        price: 85,
        unit: "عبوة",
        image: "",
        emoji: "🫗"
    },

    {
        id: 12,
        name: "لبن كامل الدسم",
        category: "ماركت",
        price: 42,
        unit: "عبوة",
        image: "",
        emoji: "🥛"
    },

    {
        id: 13,
        name: "بيض أبيض",
        category: "ماركت",
        price: 75,
        unit: "كرتونة",
        image: "",
        emoji: "🥚"
    },

    {
        id: 14,
        name: "خبز طازج",
        category: "ماركت",
        price: 25,
        unit: "كيس",
        image: "",
        emoji: "🍞"
    },

    {
        id: 15,
        name: "منظف أرضيات",
        category: "منظفات",
        price: 75,
        unit: "عبوة",
        image: "",
        emoji: "🧴"
    },

    {
        id: 16,
        name: "مناديل ورقية",
        category: "منظفات",
        price: 55,
        unit: "عبوة",
        image: "",
        emoji: "🧻"
    }
];


/* =========================================================
   بدء الموقع
========================================================= */

document.addEventListener("DOMContentLoaded", () => {

    loadProducts();

    updateCartCount();

    renderCart();

    setupSearch();

});


/* =========================================================
   تحميل المنتجات
========================================================= */

async function loadProducts() {

    try {

        const response = await fetch(
            `${API_BASE}/products.php`
        );

        if (!response.ok) {
            throw new Error("API unavailable");
        }

        const data = await response.json();

        if (Array.isArray(data) && data.length) {

            products = data.map(item => ({
                id: Number(item.id),

                name: item.name,

                category: item.c,

                price: Number(item.p),

                unit: item.u || "قطعة",

                image: item.img || "",

                emoji: "🛒"
            }));

        } else {

            products = demoProducts;

        }

    } catch (error) {

        console.log(
            "Using demo products:",
            error
        );

        products = demoProducts;

    }

    renderProducts();

}


/* =========================================================
   عرض المنتجات
========================================================= */

function renderProducts() {

    const grid =
        document.getElementById("productsGrid");

    const noProducts =
        document.getElementById("noProducts");

    if (!grid) return;

    let filtered = [...products];


    /* فلترة القسم */

    if (currentCategory !== "all") {

        filtered =
            filtered.filter(product =>
                product.category === currentCategory
            );

    }


    /* البحث */

    if (currentSearch.trim()) {

        const search =
            currentSearch.trim().toLowerCase();

        filtered =
            filtered.filter(product =>
                product.name
                    .toLowerCase()
                    .includes(search)
            );

    }


    if (!filtered.length) {

        grid.innerHTML = "";

        if (noProducts) {
            noProducts.style.display = "block";
        }

        return;

    }


    if (noProducts) {
        noProducts.style.display = "none";
    }


    grid.innerHTML =
        filtered
            .map(product => createProductCard(product))
            .join("");

}


/* =========================================================
   بطاقة المنتج
========================================================= */

function createProductCard(product) {

    const image = product.image
        ? `
            <img
                src="${escapeHtml(product.image)}"
                alt="${escapeHtml(product.name)}"
                loading="lazy"
            >
        `
        : `
            <span class="product-emoji">
                ${product.emoji || "🛒"}
            </span>
        `;


    return `
        <article
            class="product-card"
            data-product-id="${product.id}"
        >

            <div class="product-image">

                ${image}

                ${
                    product.category === "عروض"
                    ? `
                        <span class="product-badge">
                            عرض
                        </span>
                    `
                    : ""
                }

            </div>


            <div class="product-body">

                <div class="product-category">
                    ${escapeHtml(product.category)}
                </div>


                <h3 class="product-name">
                    ${escapeHtml(product.name)}
                </h3>


                <div class="product-meta">

                    <strong class="product-price">
                        ${formatPrice(product.price)}
                        جنيه
                    </strong>

                    <span class="product-unit">
                        / ${escapeHtml(product.unit)}
                    </span>

                </div>


                <button
                    type="button"
                    class="product-add"
                    onclick="addToCart(${product.id})"
                >
                    🛒 أضف إلى السلة
                </button>

            </div>

        </article>
    `;

}


/* =========================================================
   البحث
========================================================= */

function setupSearch() {

    const input =
        document.getElementById("searchInput");

    if (!input) return;


    input.addEventListener(
        "input",
        function () {

            currentSearch = this.value;

            renderProducts();

        }
    );


    input.addEventListener(
        "keydown",
        function (event) {

            if (event.key === "Enter") {

                searchProducts();

            }

        }
    );

}


function searchProducts() {

    const input =
        document.getElementById("searchInput");

    if (input) {

        currentSearch =
            input.value;

    }

    renderProducts();

    const productsSection =
        document.getElementById("products");

    if (productsSection) {

        productsSection.scrollIntoView({
            behavior: "smooth"
        });

    }

}


/* =========================================================
   فلترة الأقسام
========================================================= */

function filterCategory(category) {

    currentCategory = category;

    document
        .querySelectorAll(".filter-btn")
        .forEach(button => {

            button.classList.remove("active");

        });


    document
        .querySelectorAll(".filter-btn")
        .forEach(button => {

            const text =
                button.textContent.trim();

            if (
                category === "all" &&
                text === "الكل"
            ) {

                button.classList.add("active");

            }

            if (
                category !== "all" &&
                text === category
            ) {

                button.classList.add("active");

            }

        });


    renderProducts();


    const productsSection =
        document.getElementById("products");

    if (productsSection) {

        productsSection.scrollIntoView({
            behavior: "smooth"
        });

    }

}


/* =========================================================
   إضافة منتج للسلة
========================================================= */

function addToCart(productId) {

    const product =
        products.find(
            item => Number(item.id) === Number(productId)
        );


    if (!product) {

        showMessage(
            "المنتج غير موجود"
        );

        return;

    }


    const existing =
        cart.find(
            item => Number(item.id) === Number(productId)
        );


    if (existing) {

        existing.qty += 1;

    } else {

        cart.push({

            id: product.id,

            name: product.name,

            price: Number(product.price),

            unit: product.unit,

            image: product.image || "",

            emoji: product.emoji || "🛒",

            qty: 1

        });

    }


    saveCart();

    updateCartCount();

    renderCart();

    showMessage(
        "تمت إضافة المنتج إلى السلة ✓"
    );

}


/* =========================================================
   زيادة الكمية
========================================================= */

function increaseQuantity(productId) {

    const item =
        cart.find(
            product =>
                Number(product.id) === Number(productId)
        );


    if (!item) return;


    item.qty += 1;

    saveCart();

    updateCartCount();

    renderCart();

}


/* =========================================================
   تقليل الكمية
========================================================= */

function decreaseQuantity(productId) {

    const item =
        cart.find(
            product =>
                Number(product.id) === Number(productId)
        );


    if (!item) return;


    item.qty -= 1;


    if (item.qty <= 0) {

        cart =
            cart.filter(
                product =>
                    Number(product.id) !== Number(productId)
            );

    }


    saveCart();

    updateCartCount();

    renderCart();

}


/* =========================================================
   حذف منتج
========================================================= */

function removeFromCart(productId) {

    cart =
        cart.filter(
            product =>
                Number(product.id) !== Number(productId)
        );


    saveCart();

    updateCartCount();

    renderCart();

}


/* =========================================================
   حفظ السلة
========================================================= */

function saveCart() {

    localStorage.setItem(
        "albaraka_cart",
        JSON.stringify(cart)
    );

}


/* =========================================================
   عدد المنتجات
========================================================= */

function updateCartCount() {

    const count =
        document.getElementById("cartCount");

    if (!count) return;


    const totalQuantity =
        cart.reduce(
            (sum, item) =>
                sum + Number(item.qty),
            0
        );


    count.textContent =
        totalQuantity;

}


/* =========================================================
   إجمالي السلة
========================================================= */

function getCartTotal() {

    return cart.reduce(
        (total, item) =>
            total +
            (
                Number(item.price) *
                Number(item.qty)
            ),
        0
    );

}


/* =========================================================
   عرض السلة
========================================================= */

function renderCart() {

    const container =
        document.getElementById("cartItems");

    const totalElement =
        document.getElementById("cartTotal");

    if (!container) return;


    if (!cart.length) {

        container.innerHTML = `

            <div class="empty-cart">

                <div class="empty-cart-icon">
                    🛒
                </div>

                <h3>
                    السلة فارغة
                </h3>

                <p>
                    أضف المنتجات التي تريد شراءها.
                </p>

            </div>

        `;

    } else {

        container.innerHTML =
            cart
                .map(item => createCartItem(item))
                .join("");

    }


    if (totalElement) {

        totalElement.textContent =      categoryName: "لحوم",
      price: 420,
      unit: "كجم",
      emoji: "🥩",
      description: "لحم بقري طازج"
    },

    {
      id: 10,
      name: "كبدة",
      category: "meat",
      categoryName: "لحوم",
      price: 350,
      unit: "كجم",
      emoji: "🥩",
      description: "كبدة طازجة"
    },

    {
      id: 11,
      name: "مفروم بقري",
      category: "meat",
      categoryName: "لحوم",
      price: 390,
      unit: "كجم",
      emoji: "🥩",
      description: "مفروم طازج وتجهيز حسب الطلب"
    },

    {
      id: 12,
      name: "دجاج كامل",
      category: "poultry",
      categoryName: "دواجن",
      price: 120,
      unit: "كجم",
      emoji: "🍗",
      description: "دجاج طازج"
    },

    {
      id: 13,
      name: "صدور دجاج",
      category: "poultry",
      categoryName: "دواجن",
      price: 180,
      unit: "كجم",
      emoji: "🍗",
      description: "صدور دجاج طازجة"
    },

    {
      id: 14,
      name: "أرز",
      category: "market",
      categoryName: "ماركت",
      price: 40,
      unit: "كجم",
      emoji: "🍚",
      description: "أرز عالي الجودة"
    },

    {
      id: 15,
      name: "سكر",
      category: "market",
      categoryName: "ماركت",
      price: 35,
      unit: "كجم",
      emoji: "🛍️",
      description: "سكر أبيض"
    },

    {
      id: 16,
      name: "زيت طعام",
      category: "market",
      categoryName: "ماركت",
      price: 90,
      unit: "زجاجة",
      emoji: "🫗",
      description: "زيت طعام"
    },

    {
      id: 17,
      name: "مكرونة",
      category: "market",
      categoryName: "ماركت",
      price: 20,
      unit: "عبوة",
      emoji: "🍝",
      description: "مكرونة"
    },

    {
      id: 18,
      name: "تجهيز طلب جزارة",
      category: "butcher",
      categoryName: "جزارة",
      price: 0,
      unit: "حسب الطلب",
      emoji: "🔪",
      description: "تجهيز وتقطيع حسب رغبتك"
    }

  ];


  /* =========================
     السلة
  ========================= */

  let cart = [];

  try {
    cart =
      JSON.parse(
        localStorage.getItem("albaraka_cart")
      ) || [];
  } catch {
    cart = [];
  }


  /* =========================
     العناصر
  ========================= */

  const productsGrid =
    document.getElementById("productsGrid");

  const emptyProducts =
    document.getElementById("emptyProducts");

  const searchInput =
    document.getElementById("searchInput");

  const searchButton =
    document.getElementById("searchBtn");

  const cartButton =
    document.getElementById("cartButton");

  const cartCount =
    document.getElementById("cartCount");

  const cartDrawer =
    document.getElementById("cartDrawer");

  const cartOverlay =
    document.getElementById("cartOverlay");

  const closeCartButton =
    document.getElementById("closeCart");

  const cartItems =
    document.getElementById("cartItems");

  const cartTotal =
    document.getElementById("cartTotal");

  const checkoutButton =
    document.getElementById("checkoutButton");

  const menuButton =
    document.getElementById("menuButton");

  const navigation =
    document.getElementById("navigation");

  const sortProducts =
    document.getElementById("sortProducts");

  const toast =
    document.getElementById("toast");

  const currentYear =
    document.getElementById("currentYear");


  /* =========================
     السنة
  ========================= */

  if (currentYear) {
    currentYear.textContent =
      new Date().getFullYear();
  }


  /* =========================
     حفظ السلة
  ========================= */

  function saveCart() {

    localStorage.setItem(
      "albaraka_cart",
      JSON.stringify(cart)
    );

  }


  /* =========================
     تحديث عدد السلة
  ========================= */

  function updateCartCount() {

    const count =
      cart.reduce(
        (total, item) =>
          total + item.quantity,
        0
      );

    if (cartCount) {
      cartCount.textContent = count;
    }

  }


  /* =========================
     البحث
  ========================= */

  function getFilteredProducts() {

    const query =
      searchInput
        ? searchInput.value
            .trim()
            .toLowerCase()
        : "";

    if (!query) {
      return [...products];
    }

    return products.filter(product => {

      return (
        product.name
          .toLowerCase()
          .includes(query) ||

        product.categoryName
          .toLowerCase()
          .includes(query) ||

        product.description
          .toLowerCase()
          .includes(query)
      );

    });

  }


  /* =========================
     ترتيب المنتجات
  ========================= */

  function sortList(list) {

    const value =
      sortProducts
        ? sortProducts.value
        : "default";

    const result = [...list];

    if (value === "low") {

      result.sort(
        (a, b) => a.price - b.price
      );

    }

    if (value === "high") {

      result.sort(
        (a, b) => b.price - a.price
      );

    }

    return result;

  }


  /* =========================
     عرض المنتجات
  ========================= */

  function renderProducts(list = products) {

    if (!productsGrid) return;

    const sorted =
      sortList(list);

    if (!sorted.length) {

      productsGrid.innerHTML = "";

      if (emptyProducts) {
        emptyProducts.hidden = false;
      }

      return;
    }

    if (emptyProducts) {
      emptyProducts.hidden = true;
    }


    productsGrid.innerHTML =
      sorted.map(product => {

        const cartItem =
          cart.find(
            item => item.id === product.id
          );

        const quantity =
          cartItem
            ? cartItem.quantity
            : 0;

        const priceHTML =
          product.price > 0
            ? `
              <span class="product-price">
                ${product.price}
                <small>جنيه / ${product.unit}</small>
              </span>
            `
            : `
              <span class="product-price">
                حسب الطلب
              </span>
            `;

        return `

          <article
            class="product-card"
            data-id="${product.id}"
          >

            <div class="product-image">

              <span>
                ${product.emoji}
              </span>

              ${
                product.price > 0
                  ? `<span class="product-badge">طازة</span>`
                  : `<span class="product-badge">حسب الطلب</span>`
              }

            </div>


            <div class="product-content">

              <span class="product-category">
                ${product.categoryName}
              </span>

              <h3>
                ${product.name}
              </h3>

              <p class="product-description">
                ${product.description}
              </p>


              <div class="product-bottom">

                ${priceHTML}

                <button
                  class="add-to-cart"
                  type="button"
                  data-product-id="${product.id}"
                  aria-label="إضافة ${product.name} للسلة"
                >
                  ${
                    quantity > 0
                      ? `🛒 ${quantity}`
                      : "+"
                  }
                </button>

              </div>

            </div>

          </article>

        `;

      }).join("");

  }


  /* =========================
     إضافة للسلة
  ========================= */

  function addToCart(productId) {

    const product =
      products.find(
        item => item.id === productId
      );

    if (!product) return;


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
        unit: product.unit,
        emoji: product.emoji,
        quantity: 1
      });

    }


    saveCart();
    updateCartCount();
    renderProducts(
      getFilteredProducts()
    );
    renderCart();

    showToast(
      `تمت إضافة ${product.name} للسلة ✓`
    );

  }


  /* =========================
     تغيير الكمية
  ========================= */

  function changeQuantity(
    productId,
    amount
  ) {

    const item =
      cart.find(
        product =>
          product.id === productId
      );

    if (!item) return;


    item.quantity += amount;


    if (item.quantity <= 0) {

      cart =
        cart.filter(
          product =>
            product.id !== productId
        );

    }


    saveCart();
    updateCartCount();
    renderProducts(
      getFilteredProducts()
    );
    renderCart();

  }


  /* =========================
     حذف منتج
  ========================= */

  function removeFromCart(productId) {

    cart =
      cart.filter(
        item =>
          item.id !== productId
      );

    saveCart();
    updateCartCount();
    renderProducts(
      getFilteredProducts()
    );
    renderCart();

    showToast(
      "تم حذف المنتج من السلة"
    );

  }


  /* =========================
     حساب الإجمالي
  ========================= */

  function getCartTotal() {

    return cart.reduce(
      (total, item) =>
        total +
        item.price * item.quantity,
      0
    );

  }


  /* =========================
     عرض السلة
  ========================= */

  function renderCart() {

    if (!cartItems) return;


    if (!cart.length) {

      cartItems.innerHTML = `

        <div class="cart-empty">

          <div>
            🛒
          </div>

          <h3>
            السلة فارغة
          </h3>

          <p>
            أضف المنتجات التي تريدها
          </p>

        </div>

      `;

      if (cartTotal) {
        cartTotal.textContent =
          "0";
      }

      return;
    }


    cartItems.innerHTML =
      cart.map(item => {

        const itemTotal =
          item.price *
          item.quantity;

        return `

          <div
            class="cart-item"
            data-cart-id="${item.id}"
          >

            <div class="cart-item-image">
              ${item.emoji}
            </div>


            <div>

              <h4>
                ${item.name}
              </h4>

              <div class="cart-item-price">

                ${
                  item.price > 0
                    ? `${item.price} جنيه / ${item.unit}`
                    : "حسب الطلب"
                }

              </div>


              <div class="cart-quantity">

                <button
                  type="button"
                  data-cart-action="increase"
                  data-id="${item.id}"
                >
                  +
                </button>

                <strong>
                  ${item.quantity}
                </strong>

                <button
                  type="button"
                  data-cart-action="decrease"
                  data-id="${item.id}"
                >
                  −
                </button>

              </div>

            </div>


            <div>

              <strong>
                ${
                  item.price > 0
                    ? `${itemTotal} جنيه`
                    : "حسب الطلب"
                }
              </strong>

              <button
                type="button"
                class="cart-remove"
                data-cart-action="remove"
                data-id="${item.id}"
                aria-label="حذف المنتج"
              >
                🗑️
              </button>

            </div>

          </div>

        `;

      }).join("");


    if (cartTotal) {

      cartTotal.textContent =
        getCartTotal()
          .toLocaleString("ar-EG");

    }

  }


  /* =========================
     فتح السلة
  ========================= */

  function openCart() {

    if (!cartDrawer) return;

    cartDrawer.classList.add("active");

    if (cartOverlay) {
      cartOverlay.classList.add("active");
    }

    document.body.style.overflow =
      "hidden";

    renderCart();

  }


  /* =========================
     إغلاق السلة
  ========================= */

  function closeCart() {

    if (cartDrawer) {
      cartDrawer.classList.remove("active");
    }

    if (cartOverlay) {
      cartOverlay.classList.remove("active");
    }

    document.body.style.overflow =
      "";

  }


  /* =========================
     واتساب
  ========================= */

  function sendWhatsAppOrder() {

    if (!cart.length) {

      showToast(
        "السلة فارغة"
      );

      return;
    }


    let message =
      "السلام عليكم 👋%0A" +
      "أريد عمل طلب من مول البركة - أولاد الجارحي%0A%0A";


    cart.forEach((item, index) => {

      const total =
        item.price *
        item.quantity;

      message +=
        `${index + 1}- ${item.name}`;

      message +=
        ` × ${item.quantity}`;

      if (item.price > 0) {

        message +=
          ` = ${total} جنيه`;

      } else {

        message +=
          ` = حسب الطلب`;

      }

      message += "%0A";

    });


    message +=
      `%0Aالإجمالي: ${getCartTotal()} جنيه`;

    message +=
      "%0A%0Aالاسم: ";

    message +=
      "%0Aالعنوان: ";

    message +=
      "%0Aملاحظات: ";


    const whatsappURL =
      `https://wa.me/${WHATSAPP_NUMBER}?text=${message}`;


    window.open(
      whatsappURL,
      "_blank",
      "noopener"
    );

  }


  /* =========================
     الأقسام
  ========================= */

  document
    .querySelectorAll(".category-card")
    .forEach(button => {

      button.addEventListener(
        "click",
        () => {

          document
            .querySelectorAll(".category-card")
            .forEach(item =>
              item.classList.remove("active")
            );

          button.classList.add("active");


          const category =
            button.dataset.category;


          let filtered;


          if (
            !category ||
            category === "all"
          ) {

            filtered =
              products;

          } else {

            filtered =
              products.filter(
                product =>
                  product.category === category
              );

          }


          renderProducts(filtered);


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

    });


  /* =========================
     البحث
  ========================= */

  if (searchInput) {

    searchInput.addEventListener(
      "input",
      () => {

        renderProducts(
          getFilteredProducts()
        );

      }
    );

  }


  if (searchButton) {

    searchButton.addEventListener(
      "click",
      () => {

        renderProducts(
          getFilteredProducts()
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

  }


  /* =========================
     ترتيب المنتجات
  ========================= */

  if (sortProducts) {

    sortProducts.addEventListener(
      "change",
      () => {

        renderProducts(
          getFilteredProducts()
        );

      }
    );

  }


  /* =========================
     أزرار إضافة للسلة
  ========================= */

  document.addEventListener(
    "click",
    event => {

      const button =
        event.target.closest(
          ".add-to-cart"
        );

      if (!button) return;


      const productId =
        Number(
          button.dataset.productId
        );


      addToCart(productId);

    }
  );


  /* =========================
     التحكم في السلة
  ========================= */

  if (cartItems) {

    cartItems.addEventListener(
      "click",
      event => {

        const button =
          event.target.closest(
            "[data-cart-action]"
          );

        if (!button) return;


        const productId =
          Number(
            button.dataset.id
          );


        const action =
          button.dataset.cartAction;


        if (action === "increase") {

          changeQuantity(
            productId,
            1
          );

        }


        if (action === "decrease") {

          changeQuantity(
            productId,
            -1
          );

        }


        if (action === "remove") {

          removeFromCart(
            productId
          );

        }

      }
    );

  }


  /* =========================
     فتح السلة
  ========================= */

  if (cartButton) {

    cartButton.addEventListener(
      "click",
      openCart
    );

  }


  /* =========================
     إغلاق السلة
  ========================= */

  if (closeCartButton) {

    closeCartButton.addEventListener(
      "click",
      closeCart
    );

  }


  if (cartOverlay) {

    cartOverlay.addEventListener(
      "click",
      closeCart
    );

  }


  /* =========================
     إتمام الطلب
  ========================= */

  if (checkoutButton) {

    checkoutButton.addEventListener(
      "click",
      sendWhatsAppOrder
    );

  }


  /* =========================
     قائمة الموبايل
  ========================= */

  if (menuButton && navigation) {

    menuButton.addEventListener(
      "click",
      () => {

        navigation.classList.toggle(
          "open"
        );

      }
    );

  }


  /* =========================
     إغلاق قائمة الموبايل
  ========================= */

  if (navigation) {

    navigation
      .querySelectorAll("a")
      .forEach(link => {

        link.addEventListener(
          "click",
          () => {

            navigation.classList.remove(
              "open"
            );

          }
        );

      });

  }


  /* =========================
     إغلاق السلة بزر ESC
  ========================= */

  document.addEventListener(
    "keydown",
    event => {

      if (event.key === "Escape") {
        closeCart();
      }

    }
  );


  /* =========================
     Toast
  ========================= */

  function showToast(message) {

    if (!toast) return;

    toast.textContent =
      message;

    toast.classList.add(
      "show"
    );


    clearTimeout(
      window.albarakaToastTimer
    );


    window.albarakaToastTimer =
      setTimeout(
        () => {

          toast.classList.remove(
            "show"
          );

        },
        2500
      );

  }


  /* =========================
     تشغيل الموقع
  ========================= */

  renderProducts();

  updateCartCount();

  renderCart();

});
  {
    id: 9,
    name: "ستيك لحمة",
    category: "meat",
    categoryName: "اللحوم",
    price: 480,
    unit: "كيلو",
    emoji: "🥩",
    description: "قطع مختارة للتسوية",
    badge: "مميز"
  },


  /* ================= الطيور ================= */

  {
    id: 10,
    name: "فراخ كاملة",
    category: "poultry",
    categoryName: "الطيور",
    price: 145,
    unit: "كيلو",
    emoji: "🍗",
    description: "فراخ طازة وتجهيز حسب الطلب",
    badge: "طازة"
  },

  {
    id: 11,
    name: "وراك فراخ",
    category: "poultry",
    categoryName: "الطيور",
    price: 165,
    unit: "كيلو",
    emoji: "🍗",
    description: "وراك طازة جاهزة للتجهيز",
    badge: ""
  },

  {
    id: 12,
    name: "صدور فراخ",
    category: "poultry",
    categoryName: "الطيور",
    price: 210,
    unit: "كيلو",
    emoji: "🍗",
    description: "صدور فراخ بدون عظم",
    badge: "عرض"
  },


  /* ================= الماركت ================= */

  {
    id: 13,
    name: "أرز مصري",
    category: "market",
    categoryName: "الماركت",
    price: 38,
    unit: "كيلو",
    emoji: "🍚",
    description: "أرز مصري للاستخدام اليومي",
    badge: ""
  },

  {
    id: 14,
    name: "زيت طعام",
    category: "market",
    categoryName: "الماركت",
    price: 78,
    unit: "عبوة",
    emoji: "🫗",
    description: "زيت طعام عالي الجودة",
    badge: "عرض"
  },

  {
    id: 15,
    name: "بيض أبيض",
    category: "market",
    categoryName: "الماركت",
    price: 185,
    unit: "كرتونة",
    emoji: "🥚",
    description: "بيض طازج",
    badge: "طازة"
  },

  {
    id: 16,
    name: "جبنة بيضاء",
    category: "market",
    categoryName: "الماركت",
    price: 95,
    unit: "كيلو",
    emoji: "🧀",
    description: "جبنة بيضاء مناسبة للفطور",
    badge: ""
  },

  {
    id: 17,
    name: "سكر",
    category: "market",
    categoryName: "الماركت",
    price: 32,
    unit: "كيلو",
    emoji: "🍚",
    description: "سكر للاستخدام اليومي",
    badge: ""
  },


  /* ================= الجزارة ================= */

  {
    id: 18,
    name: "كفتة جاهزة",
    category: "butcher",
    categoryName: "الجزارة",
    price: 430,
    unit: "كيلو",
    emoji: "🥩",
    description: "كفتة مجهزة وجاهزة للتسوية",
    badge: "مميز"
  },

  {
    id: 19,
    name: "برجر لحمة",
    category: "butcher",
    categoryName: "الجزارة",
    price: 410,
    unit: "كيلو",
    emoji: "🍔",
    description: "برجر لحمة مجهز",
    badge: ""
  },

  {
    id: 20,
    name: "شيش طاووق",
    category: "butcher",
    categoryName: "الجزارة",
    price: 290,
    unit: "كيلو",
    emoji: "🍢",
    description: "تجهيز جاهز للشوي",
    badge: "عرض"
  }

];


/* =====================================================
   حالة المتجر
===================================================== */

let currentCategory = "all";
let searchTerm = "";

let cart = JSON.parse(
  localStorage.getItem("albaraka_cart") || "[]"
);

let favorites = JSON.parse(
  localStorage.getItem("albaraka_favorites") || "[]"
);


/* =====================================================
   العناصر
===================================================== */

const productsGrid =
  document.getElementById("productsGrid");

const productSearch =
  document.getElementById("productSearch");

const searchInput =
  document.getElementById("searchInput");

const searchArea =
  document.getElementById("searchArea");

const searchToggle =
  document.getElementById("searchToggle");

const searchClose =
  document.getElementById("searchClose");

const noResults =
  document.getElementById("noResults");

const cartDrawer =
  document.getElementById("cartDrawer");

const cartOverlay =
  document.getElementById("cartOverlay");

const cartItems =
  document.getElementById("cartItems");

const cartTotal =
  document.getElementById("cartTotal");

const cartCount =
  document.getElementById("cartCount");

const cartOpen =
  document.getElementById("cartOpen");

const cartClose =
  document.getElementById("cartClose");

const checkoutBtn =
  document.getElementById("checkoutBtn");

const continueShopping =
  document.getElementById("continueShopping");

const mobileMenuBtn =
  document.getElementById("mobileMenuBtn");

const mobileMenu =
  document.getElementById("mobileMenu");

const toast =
  document.getElementById("toast");

const toastMessage =
  document.getElementById("toastMessage");


/* =====================================================
   تنسيق السعر
===================================================== */

function money(value) {

  return Number(value).toLocaleString("ar-EG") + " ج.م";

}


/* =====================================================
   حفظ البيانات
===================================================== */

function saveCart() {

  localStorage.setItem(
    "albaraka_cart",
    JSON.stringify(cart)
  );

}


function saveFavorites() {

  localStorage.setItem(
    "albaraka_favorites",
    JSON.stringify(favorites)
  );

}


/* =====================================================
   عرض المنتجات
===================================================== */

function renderProducts() {

  if (!productsGrid) return;


  const filtered = products.filter(product => {

    const categoryMatch =
      currentCategory === "all" ||
      product.category === currentCategory;


    const text =
      `${product.name} ${product.categoryName}`
        .toLowerCase();


    const searchMatch =
      !searchTerm ||
      text.includes(searchTerm.toLowerCase());


    return categoryMatch && searchMatch;

  });


  if (!filtered.length) {

    productsGrid.innerHTML = "";

    noResults.classList.add("show");

    return;

  }


  noResults.classList.remove("show");


  productsGrid.innerHTML =
    filtered.map(product => productHTML(product)).join("");

}


/* =====================================================
   HTML المنتج
===================================================== */

function productHTML(product) {

  const isFavorite =
    favorites.includes(product.id);


  return `

    <article class="product-card">

      <div class="product-image">

        ${
          product.badge
            ? `<span class="product-badge">
                 ${product.badge}
               </span>`
            : ""
        }

        <button
          type="button"
          class="favorite-btn"
          onclick="toggleFavorite(${product.id})"
          aria-label="المفضلة"
        >
          ${isFavorite ? "❤️" : "♡"}
        </button>

        <div class="product-emoji">
          ${product.emoji}
        </div>

      </div>


      <div class="product-body">

        <span class="product-category">
          ${product.categoryName}
        </span>

        <h3 class="product-name">
          ${product.name}
        </h3>

        <p class="product-description">
          ${product.description}
        </p>


        <div class="product-footer">

          <div class="product-price">

            <strong>
              ${money(product.price)}
            </strong>

            <small>
              / ${product.unit}
            </small>

          </div>


          <button
            type="button"
            class="add-product"
            onclick="addToCart(${product.id})"
          >
            + أضف للسلة
          </button>

        </div>

      </div>

    </article>

  `;

}


/* =====================================================
   إضافة للسلة
===================================================== */

function addToCart(id) {

  const product =
    products.find(item => item.id === id);


  if (!product) return;


  const existing =
    cart.find(item => item.id === id);


  if (existing) {

    existing.quantity += 1;

  } else {

    cart.push({
      id: id,
      quantity: 1
    });

  }


  saveCart();

  renderCart();

  showToast(
    `تمت إضافة ${product.name} للسلة`
  );

}


/* =====================================================
   تعديل الكمية
===================================================== */

function changeQuantity(id, amount) {

  const item =
    cart.find(product => product.id === id);


  if (!item) return;


  item.quantity += amount;


  if (item.quantity <= 0) {

    cart =
      cart.filter(product => product.id !== id);

  }


  saveCart();

  renderCart();

}


/* =====================================================
   حذف من السلة
===================================================== */

function removeFromCart(id) {

  const product =
    products.find(item => item.id === id);


  cart =
    cart.filter(item => item.id !== id);


  saveCart();

  renderCart();


  if (product) {

    showToast(
      `تم حذف ${product.name} من السلة`
    );

  }

}


/* =====================================================
   عرض السلة
===================================================== */

function renderCart() {

  if (!cartItems) return;


  if (!cart.length) {

    cartItems.innerHTML = `

      <div class="cart-empty">

        <div>
          🛒
        </div>

        <h3>
          السلة فاضية
        </h3>

        <p>
          أضف المنتجات اللي محتاجها.
        </p>

      </div>

    `;

    cartCount.textContent = "0";

    cartTotal.textContent = "0 ج.م";

    return;

  }


  let total = 0;
  let quantityTotal = 0;


  cartItems.innerHTML =
    cart.map(item => {

      const product =
        products.find(
          product => product.id === item.id
        );


      if (!product) return "";


      const itemTotal =
        product.price * item.quantity;


      total += itemTotal;

      quantityTotal += item.quantity;


      return `

        <div class="cart-item">

          <div class="cart-item-image">
            ${product.emoji}
          </div>


          <div class="cart-item-info">

            <strong>
              ${product.name}
            </strong>

            <small>
              ${money(product.price)}
              / ${product.unit}
            </small>


            <div class="cart-controls">

              <button
                type="button"
                onclick="changeQuantity(${product.id}, -1)"
              >
                −
              </button>

              <span>
                ${item.quantity}
              </span>

              <button
                type="button"
                onclick="changeQuantity(${product.id}, 1)"
              >
                +
              </button>

            </div>

          </div>


          <div>

            <strong>
              ${money(itemTotal)}
            </strong>

            <br>

            <button
              type="button"
              class="cart-item-remove"
              onclick="removeFromCart(${product.id})"
            >
              حذف
            </button>

          </div>

        </div>

      `;

    }).join("");


  cartCount.textContent =
    quantityTotal;


  cartTotal.textContent =
    money(total);

}


/* =====================================================
   المفضلة
===================================================== */

function toggleFavorite(id) {

  const index =
    favorites.indexOf(id);


  if (index === -1) {

    favorites.push(id);

    showToast("تمت إضافة المنتج للمفضلة");

  } else {

    favorites.splice(index, 1);

    showToast("تم حذف المنتج من المفضلة");

  }


  saveFavorites();

  renderProducts();

}


/* =====================================================
   الفلاتر
===================================================== */

document
  .querySelectorAll(".filter-btn")
  .forEach(button => {

    button.addEventListener(
      "click",
      () => {

        document
          .querySelectorAll(".filter-btn")
          .forEach(item =>
            item.classList.remove("active")
          );


        button.classList.add("active");


        currentCategory =
          button.dataset.filter;


        renderProducts();


        document
          .getElementById("products")
          .scrollIntoView({
            behavior: "smooth"
          });

      }
    );

  });


/* =====================================================
   أقسام المتجر
===================================================== */

document
  .querySelectorAll(".category-card")
  .forEach(button => {

    button.addEventListener(
      "click",
      () => {
