let cart = 0;

const buttons = document.querySelectorAll(".products button");

buttons.forEach(button => {
  button.addEventListener("click", () => {
    cart++;
    document.getElementById("cart-count").innerText = cart;
    alert("تمت إضافة المنتج إلى السلة");
  });
});
