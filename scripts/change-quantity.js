
let buttons = document.querySelectorAll(".increase-btn, .decrease-btn");

buttons.forEach(button => {
	button.addEventListener("click", () => {
		let amount = button.classList.contains("increase-btn") ? 1 : -1;
		changeQuantity(button, amount);
	});
});

function changeQuantity(button, amount) {

	let form = button.parentNode;
	let input = form.querySelector('input[type="text"]');
	const newQuantity = parseInt(input.value) + amount;

	if (newQuantity >= 1) {
		input.value = newQuantity;
		$(input).trigger("change");
	}
}
