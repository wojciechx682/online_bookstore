
// koszyk.php, book.php;

let increaseBtns = document.querySelectorAll(".increase-btn");
let decreaseBtns = document.querySelectorAll(".decrease-btn");

increaseBtns.forEach(function(button) {
	button.addEventListener("click", function(event) {
		increase(event);
	});
});

decreaseBtns.forEach(function(button) {
	button.addEventListener("click", function(event) {
		decrease(event);
	});
});

function changeQuantity(button, bookId, amount) {

	let form = button.parentNode;
	let input = form.querySelector('input[type="text"]');
	const newQuantity = parseInt(input.value) + amount;

	if (newQuantity >= 1) {
		input.value = newQuantity;
		$(input).trigger("change"); // trigger the change event --> AJAX - change_cart_quantity.js
	}
}

function increase(event) {
		let button = event.currentTarget;
		let bookId = button.value;
	changeQuantity(button, bookId, 1);
}

function decrease(event) {
		let button = event.currentTarget;
		let bookId = button.value;
	changeQuantity(button, bookId, -1);
}

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

