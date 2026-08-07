const P = [
  ['طماطم بلدي', 'produce', 25, '🍅'],
  ['بطاطس', 'produce', 22, '🥔'],
  ['موز', 'produce', 35, '🍌'],
  ['تفاح', 'produce', 65, '🍎'],

  ['لحمة كندوز', 'meat', 420, '🥩'],
  ['لحم مفروم', 'butcher', 390, '🥩'],

  ['فراخ كاملة', 'poultry', 145, '🍗'],
  ['وراك فراخ', 'poultry', 165, '🍗'],

  ['أرز مصري', 'market', 38, '🍚'],
  ['زيت طعام', 'market', 78, '🫗'],
  ['بيض أبيض', 'market', 185, '🥚'],
  ['جبنة بيضاء', 'market', 95, '🧀']
].map((x, i) => ({
  id: i + 1,
  n: x[0],
  c: x[1],
  p: x[2],
  e: x[3]
}));


const L = {
  produce: 'خضروات وفاكهة',
  meat: 'اللحوم',
  poultry: 'الطيور',
  market: 'الماركت',
  butcher: 'الجزارة'
};


let cart = JSON.parse(
  localStorage.getItem('albaraka_cart') || '[]'
);

let cat = 'all';


const grid = document.querySelector('#grid');
const search = document.querySelector('#search');
const count = document.querySelector('#count');
const items = document.querySelector('#items');
const total = document.querySelector('#total');


/* =========================
   عرض المنتجات
========================= */

function render() {

  let q = search.value.trim();

  let a = P.filter(x =>
    (cat === 'all' || x.c === cat) &&
    (!q || x.n.includes(q))
  );

  if (!a.length) {

    grid.innerHTML = `
      <div style="
        grid-column:1/-1;
        text-align:center;
        padding:40px;
        color:#7b8b83
      ">
        لا توجد منتجات مطابقة للبحث.
      </div>
    `;

    return;
  }


  grid.innerHTML = a.map(x => `

    <article class="product">

      <div class="pic">
        ${x.e}
      </div>

      <div class="body">

        <label>
          ${L[x.c]}
        </label>

        <h3>
          ${x.n}
        </h3>

        <p>
          جودة مختارة وتجهيز بعناية
        </p>

        <div class="bottom">

          <span class="price">
            ${x.p} ج.م
          </span>

          <button
            class="add"
            onclick="add(${x.id})"
          >
            + أضف
          </button>

        </div>

      </div>

    </article>

  `).join('');
}


/* =========================
   إضافة منتج للسلة
========================= */

function add(id) {

  let x = cart.find(a => a.id === id);

  if (x) {

    x.q++;

  } else {

    cart.push({
      id,
      q: 1
    });

  }

  save();

  openCart();
}


/* =========================
   حفظ السلة
========================= */

function save() {

  localStorage.setItem(
    'albaraka_cart',
    JSON.stringify(cart)
  );

  renderCart();
}


/* =========================
   عرض السلة
========================= */

function renderCart() {

  let n = 0;
  let t = 0;


  if (!cart.length) {

    items.innerHTML = `
      <div class="empty">
        السلة فارغة حاليًا 🛒
      </div>
    `;

  } else {

    items.innerHTML = '';

  }


  cart.forEach(c => {

    let x = P.find(
      p => p.id === c.id
    );

    if (!x) return;


    n += c.q;

    t += x.p * c.q;


    items.innerHTML += `

      <div class="cartItem">

        <span class="e">
          ${x.e}
        </span>

        <div>

          <b>
            ${x.n}
          </b>

          <small>
            ${c.q} × ${x.p} ج.م
          </small>

        </div>

        <button
          onclick="del(${x.id})"
        >
          حذف
        </button>

      </div>

    `;

  });


  count.textContent = n;

  total.textContent =
    t + ' ج.م';
}


/* =========================
   حذف منتج من السلة
========================= */

function del(id) {

  cart = cart.filter(
    x => x.id !== id
  );

  save();
}


/* =========================
   فتح السلة
========================= */

function openCart() {

  document
    .querySelector('#drawer')
    .classList.add('open');

  document
    .querySelector('#shade')
    .style.display = 'block';
}


/* =========================
   إغلاق السلة
========================= */

function closeCart() {

  document
    .querySelector('#drawer')
    .classList.remove('open');

  document
    .querySelector('#shade')
    .style.display = 'none';
}


/* =========================
   اختيار الأقسام
========================= */

document
  .querySelectorAll('.cats button')
  .forEach(b => {

    b.onclick = () => {

      document
        .querySelectorAll('.cats button')
        .forEach(x =>
          x.classList.remove('active')
        );

      b.classList.add('active');

      cat = b.dataset.cat;

      render();
    };

  });


/* =========================
   البحث
========================= */

search.oninput = render;


/* =========================
   فتح السلة
========================= */

document
  .querySelector('#cartBtn')
  .onclick = openCart;


/* =========================
   إغلاق السلة
========================= */

document
  .querySelector('#close')
  .onclick = closeCart;


document
  .querySelector('#shade')
  .onclick = closeCart;


/* =========================
   قائمة الموبايل
========================= */

document
  .querySelector('#menuBtn')
  .onclick = () => {

    document
      .querySelector('#mobile')
      .classList.toggle('open');

  };


/* =========================
   زر البحث
========================= */

document
  .querySelector('#searchBtn')
  .onclick = () => {

    search.focus();

    document
      .querySelector('#products')
      .scrollIntoView({
        behavior: 'smooth'
      });

  };


/* =========================
   إرسال الطلب واتساب
========================= */

document
  .querySelector('#order')
  .onclick = () => {

    if (!cart.length) {

      alert('السلة فارغة');

      return;
    }


    let s =
      'طلب جديد من مول البركة:%0A';


    cart.forEach(c => {

      let x = P.find(
        p => p.id === c.id
      );

      if (!x) return;


      s +=
        `- ${x.n} × ${c.q}%0A`;

    });


    s +=
      `الإجمالي: ${total.textContent}`;


    window.open(
      'https://wa.me/201119511185?text=' + s,
      '_blank'
    );

  };


/* =========================
   تشغيل الموقع
========================= */

render();

renderCart();
