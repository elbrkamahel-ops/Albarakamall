// =========================
// مول البركة أولاد الجارحي
// =========================

// عدد عناصر السلة
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// تحديث عداد السلة
function updateCartCount() {
    const count = document.getElementById("cart-count");
    if (count) {
        count.textContent = cart.length;
    }
}

// إضافة للسلة
document.querySelectorAll(".add-cart").forEach((btn) => {
    btn.addEventListener("click", () => {

        const product =
            btn.parentElement.querySelector("h3").innerText;

        cart.push(product);

        localStorage.setItem("cart", JSON.stringify(cart));

        updateCartCount();

        showToast(product + " تمت إضافته للسلة");
    });
});

// رسالة احترافية
function showToast(text) {

    const toast = document.createElement("div");

    toast.innerText = text;

    toast.style.position = "fixed";
    toast.style.bottom = "25px";
    toast.style.left = "25px";
    toast.style.background = "#0b7a33";
    toast.style.color = "white";
    toast.style.padding = "15px 25px";
    toast.style.borderRadius = "10px";
    toast.style.boxShadow = "0 5px 15px rgba(0,0,0,.3)";
    toast.style.zIndex = "9999";

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 2500);
}

// زر العودة للأعلى
const topBtn = document.createElement("button");

topBtn.innerHTML = "↑";

topBtn.className = "top-btn";

document.body.appendChild(topBtn);

topBtn.style.position = "fixed";
topBtn.style.bottom = "25px";
topBtn.style.right = "25px";
topBtn.style.width = "50px";
topBtn.style.height = "50px";
topBtn.style.borderRadius = "50%";
topBtn.style.border = "none";
topBtn.style.background = "#0b7a33";
topBtn.style.color = "white";
topBtn.style.fontSize = "22px";
topBtn.style.display = "none";
topBtn.style.cursor = "pointer";

window.addEventListener("scroll", () => {

    if (window.scrollY > 300) {

        topBtn.style.display = "block";

    } else {

        topBtn.style.display = "none";

    }

});

topBtn.onclick = () => {

    window.scrollTo({

        top:0,

        behavior:"smooth"

    });

};

// تحديث السلة عند فتح الصفحة
updateCartCount();
const search=document.getElementById("search");

if(search){

search.addEventListener("keyup",function(){

let value=this.value.toLowerCase();

document.querySelectorAll(".product").forEach(product=>{

let text=product.innerText.toLowerCase();

product.style.display=text.includes(value)?"block":"none";

});

});

}
