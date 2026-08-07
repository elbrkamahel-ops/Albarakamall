/* =========================================================
   ALBARAKA MALL - متجر مول البركة
   ملف: script.js
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {

  /* =========================
     بيانات المتجر
  ========================= */

  const WHATSAPP = "201119511185";

  const products = [
    {
      id: 1,
      name: "طماطم طازجة",
      category: "produce",
      price: 25,
      unit: "كجم",
      emoji: "🍅",
      description: "طماطم طازجة مختارة يوميًا"
    },
    {
      id: 2,
      name: "خيار طازج",
      category: "produce",
      price: 30,
      unit: "كجم",
      emoji: "🥒",
      description: "خيار طازج عالي الجودة"
    },
    {
      id: 3,
      name: "بطاطس",
      category: "produce",
      price: 22,
      unit: "كجم",
      emoji: "🥔",
      description: "بطاطس مناسبة للقلي والطبخ"
    },
    {
      id: 4,
      name: "تفاح",
      category: "produce",
      price: 65,
      unit: "كجم",
      emoji: "🍎",
      description: "تفاح طازج ومختار"
    },
    {
      id: 5,
      name: "موز",
      category: "produce",
      price: 35,
      unit: "كجم",
      emoji: "🍌",
      description: "موز طازج"
    },
    {
      id: 6,
      name: "برتقال",
      category: "produce",
      price: 30,
      unit: "كجم",
      emoji: "🍊",
      description: "برتقال طازج"
    },

    {
      id: 7,
      name: "لحم بقري",
      category: "butcher",
      price: 420,
      unit: "كجم",
      emoji: "🥩",
      description: "لحم بقري طازج مجهز حسب الطلب"
    },
    {
      id: 8,
      name: "كبدة",
      category: "butcher",
      price: 350,
      unit: "كجم",
      emoji: "🥩",
      description: "كبدة طازجة"
    },
    {
      id: 9,
      name: "مفروم بقري",
      category: "butcher",
      price: 390,
      unit: "كجم",
      emoji: "🥩",
      description: "مفروم طازج"
    },

    {
      id: 10,
      name: "دجاج كامل",
      category: "poultry",
      price: 120,
      unit: "كجم",
      emoji: "🍗",
      description: "دجاج طازج"
    },
    {
      id: 11,
      name: "صدور دجاج",
      category: "poultry",
      price: 180,
      unit: "كجم",
      emoji: "🍗",
      description: "صدور دجاج طازجة"
    },

    {
      id: 12,
      name: "أرز",
      category: "market",
      price: 40,
      unit: "كجم",
      emoji: "🍚",
      description: "أرز عالي الجودة"
    },
    {
      id: 13,
      name: "سكر",
      category: "market",
      price: 35,
      unit: "كجم",
      emoji: "🛍️",
      description: "سكر أبيض"
    },
    {
      id: 14,
      name: "زيت طعام",
      category: "market",
      price: 90,
      unit: "زجاجة",
      emoji: "🫗",
      description: "زيت طعام"
    },
    {
      id: 15,
      name: "مكرونة",
      category: "market",
      price: 20,
      unit: "عبوة",
      emoji: "🍝",
      description: "مكرونة"
    }
  ];


  /* =========================
     السلة
  ========================= */

  let cart = JSON.parse(localStorage.getItem("albarakaCart")) || [];


  /* =========================
     العناصر
  ========================= */

  const productGrid =
    document.querySelector("#productGrid") ||
    document.querySelector(".product-grid") ||
    document.querySelector(".products");

  const searchInput =
    document.querySelector("#search") ||
    document.querySelector("#searchInput");

  const cartButton =
    document.querySelector("#cartBtn") ||
    document.querySelector(".cart-btn");

  const cartCount =
    document.querySelector("#cartCount") ||
    document.querySelector(".cart-count");


  /* =========================
     حفظ السلة
  ========================= */

  function saveCart() {
    localStorage.setItem(
      "albarakaCart",
      JSON.stringify(cart)
    );
  }


  /* =========================
     عدد المنتجات
  ========================= */

  function updateCartCount() {

    const totalItems = cart.reduce(
      (total, item) => total + item.quantity,
      0
    );

    if (cartCount) {
      cartCount.textContent = totalItems;
    }
  }


  /* =========================
     عرض المنتجات
  ========================= */

  function renderProducts(list = products) {

    if (!productGrid) return;

    if (!list.length) {

      productGrid.innerHTML = `
        <div class="empty-products">
          <div>🔎</div>
          <h3>لم نجد هذا المنتج</h3>
          <p>جرب البحث باسم منتج آخر</p>
        </div>
      `;

      return;
    }

    productGrid.innerHTML = list.map(product => {

      const cartItem = cart.find(
        item => item.id === product.id
      );

      const quantity = cartItem ? cartItem.quantity : 0;

      return `
        <article class="product-card">

          <div class="product-image">
            <span>${product.emoji}</span>
          </div>

          <div class="product-info">

            <span class="product-category">
              ${getCategoryName(product.category)}
            </span>

            <h3>${product.name}</h3>

            <p>${product.description}</p>

            <div class="product-bottom">

              <div class="product-price">
                <strong>${product.price}</strong>
                <small>جنيه / ${product.unit}</small>
              </div>

              <button
                class="add-to-cart"
                data-id="${product.id}"
              >
                ${
                  quantity > 0
                    ? `🛒 ${quantity}`
                    : "أضف للسلة"
                }
              </button>

            </div>

          </div>

        </article>
      `;

    }).join("");

  }


  /* =========================
     اسم القسم
  ========================= */

  function getCategoryName(category) {

    const names = {
      produce: "خضروات وفاكهة",
      butcher: "الجزارة",
      poultry: "طيور ودواجن",
      market: "الماركت"
    };

    return names[category] || "منتجات";
  }


  /* =========================
     إضافة للسلة
  ========================= */

  function addToCart(productId) {

    const product = products.find(
      item => item.id === productId
    );

    if (!product) return;

    const existing = cart.find(
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
    renderProducts();

    showToast("تمت إضافة المنتج إلى السلة 🛒");
  }


  /* =========================
     حذف من السلة
  ========================= */

  function removeFromCart(productId) {

    cart = cart.filter(
      item => item.id !== productId
    );

    saveCart();
    updateCartCount();
    renderProducts();
    renderCart();

  }


  /* =========================
     تغيير الكمية
  ========================= */

  function changeQuantity(productId, amount) {

    const item = cart.find(
      item => item.id === productId
    );

    if (!item) return;

    item.quantity += amount;

    if (item.quantity <= 0) {
      removeFromCart(productId);
      return;
    }

    saveCart();
    updateCartCount();
    renderProducts();
    renderCart();

  }


  /* =========================
     نافذة السلة
  ========================= */

  function createCartModal() {

    if (document.querySelector("#cartModal")) return;

    const modal = document.createElement("div");

    modal.id = "cartModal";

    modal.innerHTML = `
      <div class="cart-overlay"></div>

      <div class="cart-panel">

        <button
          class="cart-close"
          id="closeCart"
        >
          ×
        </button>

        <div class="cart-header">
          <span>🛒</span>
          <div>
            <h2>سلة المشتريات</h2>
            <p>راجع طلبك قبل الإرسال</p>
          </div>
        </div>

        <div id="cartItems"></div>

        <div class="cart-footer">

          <div class="cart-total">
            <span>الإجمالي</span>
            <strong id="cartTotal">0 جنيه</strong>
          </div>

          <button
            class="checkout-btn"
            id="checkoutWhatsApp"
          >
            إتمام الطلب عبر واتساب
          </button>

          <button
            class="clear-cart"
            id="clearCart"
          >
            إفراغ السلة
          </button>

        </div>

      </div>
    `;

    document.body.appendChild(modal);

    document
      .querySelector("#closeCart")
      ?.addEventListener("click", closeCart);

    document
      .querySelector(".cart-overlay")
      ?.addEventListener("click", closeCart);

    document
      .querySelector("#clearCart")
      ?.addEventListener("click", clearCart);

    document
      .querySelector("#checkoutWhatsApp")
      ?.addEventListener(
        "click",
        sendWhatsAppOrder
      );

  }


  /* =========================
     فتح السلة
  ========================= */

  function openCart() {

    createCartModal();

    renderCart();

    const modal =
      document.querySelector("#cartModal");

    if (modal) {
      modal.classList.add("show");
      document.body.classList.add("cart-open");
    }

  }


  /* =========================
     إغلاق السلة
  ========================= */

  function closeCart() {

    const modal =
      document.querySelector("#cartModal");

    if (modal) {
      modal.classList.remove("show");
    }

    document.body.classList.remove("cart-open");

  }


  /* =========================
     عرض محتويات السلة
  ========================= */

  function renderCart() {

    const container =
      document.querySelector("#cartItems");

    const totalElement =
      document.querySelector("#cartTotal");

    if (!container) return;

    if (!cart.length) {

      container.innerHTML = `
        <div class="empty-cart">
          <div>🛒</div>
          <h3>السلة فارغة</h3>
          <p>أضف المنتجات التي تحتاجها إلى السلة</p>
        </div>
      `;

      if (totalElement) {
        totalElement.textContent = "0 جنيه";
      }

      return;
    }


    let total = 0;

    container.innerHTML = cart.map(item => {

      const itemTotal =
        item.price * item.quantity;

      total += itemTotal;

      return `
        <div class="cart-item">

          <div class="cart-item-icon">
            ${item.emoji}
          </div>

          <div class="cart-item-info">

            <h4>${item.name}</h4>

            <span>
              ${item.price} جنيه / ${item.unit}
            </span>

            <strong>
              ${itemTotal} جنيه
            </strong>

          </div>

          <div class="quantity-controls">

            <button
              data-action="increase"
              data-id="${item.id}"
            >
              +
            </button>

            <span>${item.quantity}</span>

            <button
              data-action="decrease"
              data-id="${item.id}"
            >
              −
            </button>

          </div>

          <button
            class="remove-item"
            data-action="remove"
            data-id="${item.id}"
          >
            🗑️
          </button>

        </div>
      `;

    }).join("");


    if (totalElement)
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
