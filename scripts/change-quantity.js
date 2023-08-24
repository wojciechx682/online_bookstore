
// user\koszyk.php, user\book.php;

let buttons = document.querySelectorAll(".increase-btn, .decrease-btn");

console.log("\n\n buttons --> \n\n", buttons);

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

		console.log("\n >= 1 \n");

		input.value = newQuantity;
		$(input).trigger("change"); // trigger the change event --> AJAX - change_cart_quantity.js
	}
}

/*
function increase(event) {
	console.log("\n increase function <--  \n");
		let button = event.currentTarget; // <button>
		let bookId = button.dataset.bookId; 		  // book-id - "value" attribute of <button> element
	changeQuantity(event, bookId, 1);
}

function decrease(event) {
	console.log("\n decrease function <--  \n");
		let button = event.currentTarget;
		let bookId = button.dataset.bookId;
	changeQuantity(event, bookId, -1);
}
*/

/*function increase(id_ksiazki) {
	// increase input form value by 1, and then send <form> --> change_cart_quantity.php
	// `${variable}`   <--- template literals. // document.querySelector(`#my-element-${id}`);
	const el = document.querySelector(`#koszyk_ilosc${id_ksiazki}`);
	el.value = parseInt(el.value) + 1;
	let form = document.querySelector(`#change_quantity_form${id_ksiazki}`);
	form.submit();
}

function decrease(id_ksiazki) {
	// let el = document.getElementById("koszyk_ilosc" + id_ksiazki);
	let el = document.querySelector(`#koszyk_ilosc${id_ksiazki}`);
	if (el.value > 1) {
		el.value = parseInt(el.value) - 1;
	}
	let form = document.querySelector(`#change_quantity_form${id_ksiazki}`);
	form.submit();
}*/

