const container = document.querySelector(".cart-container");
const button = document.querySelector(".button-cart");
const close = document.querySelector(".close");
button.addEventListener("click", () => {
	container.classList.toggle("hide");
});
close.addEventListener("click", () => {
	container.classList.toggle("hide");
});
const continueBtn = document.querySelector(".continue");
console.log(continueBtn);
continueBtn.addEventListener("click", () => {
	container.classList.toggle("hide");
});
