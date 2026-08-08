/* =========================================
   MOL ALBARAKA - MAIN STORE JAVASCRIPT
========================================= */

const PRODUCTS = [

    {
        id: 1,
        name: "طماطم بلدي",
        category: "vegetables",
        price: 25,
        oldPrice: 30,
        unit: "كيلو",
        image: "🍅",
        sale: true
    },

    {
        id: 2,
        name: "بطاطس",
        category: "vegetables",
        price: 22,
        oldPrice: 27,
        unit: "كيلو",
        image: "🥔",
        sale: true
    },

    {
        id: 3,
        name: "تفاح أحمر",
        category: "vegetables",
        price: 65,
        oldPrice: 75,
        unit: "كيلو",
        image: "🍎",
        sale: true
    },

    {
        id: 4,
        name: "موز",
        category: "vegetables",
        price: 35,
        oldPrice: 40,
        unit: "كيلو",
        image: "🍌",
        sale: false
    },

    {
        id: 5,
        name: "لحمة كندوز",
        category: "meat",
        price: 420,
        oldPrice: 450,
        unit: "كيلو",
        image: "🥩",
        sale: true
    },

    {
        id: 6,
        name: "لحمة مفرومة",
        category: "meat",
        price: 390,
        oldPrice: 420,
        unit: "كيلو",
        image: "🥩",
        sale: true
    },

    {
        id: 7,
        name: "فراخ كاملة",
        category: "chicken",
        price: 135,
        oldPrice: 150,
        unit: "كيلو",
        image: "🐔",
        sale: true
    },

    {
        id: 8,
        name: "وراك فراخ",
        category: "chicken",
        price: 145,
        oldPrice: 160,
        unit: "كيلو",
        image: "🍗",
        sale: false
    },

    {
        id: 9,
        name: "أرز فاخر",
        category: "market",
        price: 38,
        oldPrice: 42,
        unit: "كيلو",
        image: "🍚",
        sale: true
    },

    {
        id: 10,
        name: "زيت طعام",
        category: "market",
        price: 85,
        oldPrice: 95,
        unit: "زجاجة",
        image: "🫒",
        sale: true
    },

    {
        id: 11,
        name: "سكر أبيض",
        category: "market",
        price: 35,
        oldPrice: 38,
        unit: "كيلو",
        image: "🧂",
        sale: false
    },

    {
        id: 12,
        name: "لبن كامل الدسم",
        category: "market",
        price: 42,
        oldPrice: 46,
        unit: "عبوة",
        image: "🥛",
        sale: false
    }

];


/* =========================================
   CART
========================================= */

function getCart(){

    try{

        return JSON.parse(
            localStorage.getItem("baraka_cart") || "[]"
        );

    }catch(error){

        return [];

    }

}


function saveCart(cart){

    localStorage.setItem(
        "baraka_cart",
        JSON.stringify(cart)
    );

}


/* =========================================
   MONEY
========================================= */

function money(value){

    return Number(value).toLocaleString("ar-EG")
        + " ج.م";

}


/* =========================================
   CART COUNT
========================================= */

function updateCartCount(){

    const cart = getCart();

    const count = cart.reduce(
        (total,item) => total + Number(item.qty || 0),
        0
    );

    document
        .querySelectorAll("#count")
        .forEach(element => {

            element.textContent = count;

        });

}


/* =========================================
   ADD PRODUCT
========================================= */

function addToCart(productId){

    const cart = getCart();

    const existing
