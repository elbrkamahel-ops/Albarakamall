/* =====================================================
   مول البركة - متجر إلكتروني
   Albaraka Mall
===================================================== */

const WHATSAPP = "201119511185";

const products = [

  {
    id: 1,
    name: "طماطم بلدي",
    category: "produce",
    categoryName: "خضروات وفاكهة",
    price: 25,
    unit: "كيلو",
    emoji: "🍅",
    description: "طماطم طازة مختارة يوميًا",
    badge: "طازة"
  },

  {
    id: 2,
    name: "بطاطس",
    category: "produce",
    categoryName: "خضروات وفاكهة",
    price: 22,
    unit: "كيلو",
    emoji: "🥔",
    description: "بطاطس مختارة بجودة ممتازة",
    badge: ""
  },

  {
    id: 3,
    name: "موز",
    category: "produce",
    categoryName: "خضروات وفاكهة",
    price: 35,
    unit: "كيلو",
    emoji: "🍌",
    description: "موز طازج مناسب للبيت",
    badge: "عرض"
  },

  {
    id: 4,
    name: "تفاح",
    category: "produce",
    categoryName: "خضروات وفاكهة",
    price: 65,
    unit: "كيلو",
    emoji: "🍎",
    description: "تفاح طازج مختار",
    badge: ""
  },

  {
    id: 5,
    name: "برتقال",
    category: "produce",
    categoryName: "خضروات وفاكهة",
    price: 30,
    unit: "كيلو",
    emoji: "🍊",
    description: "برتقال طازج وعصير",
    badge: "جديد"
  },

  {
    id: 6,
    name: "خيار",
    category: "produce",
    categoryName: "خضروات وفاكهة",
    price: 28,
    unit: "كيلو",
    emoji: "🥒",
    description: "خيار طازج يوميًا",
    badge: ""
  },


  /* ================= اللحوم ================= */

  {
    id: 7,
    name: "لحمة كندوز",
    category: "meat",
    categoryName: "اللحوم",
    price: 420,
    unit: "كيلو",
    emoji: "🥩",
    description: "لحوم مختارة وتجهيز حسب الطلب",
    badge: "مميز"
  },

  {
    id: 8,
    name: "لحم مفروم",
    category: "meat",
    categoryName: "اللحوم",
    price: 390,
    unit: "كيلو",
    emoji: "🥩",
    description: "مفروم طازج وتجهيز يومي",
    badge: ""
  },

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
