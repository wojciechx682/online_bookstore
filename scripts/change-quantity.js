
function changeQuantity(button, id_ksiazki, amount) {

	//const el = document.querySelector(`#koszyk_ilosc${id_ksiazki}`);

	let form = button.parentNode;

	console.log("\n form -> ", form);

	let el = form.querySelector('input[type="text"]')

	//const el = button.previousElementSibling; // <input type text> - przechowuje ilość książek
	console.log("\n el (input type text) -> ", el);

	const newQuantity = parseInt(el.value) + amount;
	console.log("\n newQuantity -> ", newQuantity);
	//let form = ??? ;


	if (newQuantity >= 1) {
		el.value = newQuantity;													 // koszyk.php,	book.php
		//let form = document.querySelector(`#change_quantity_form${id_ksiazki}`); // (tylko dla) koszyk.php


		//console.log("\n form -> ", form);
		//console.log("\n typeof form -> ", typeof form);

		//form.submit();

		// Trigger the change event
		$(el).trigger("change");

														 // -----||---- koszyk.php
	}
}

function increase(button, id_ksiazki) {
	changeQuantity(button, id_ksiazki, 1);
}

function decrease(button, id_ksiazki) {
	changeQuantity(button, id_ksiazki, -1);
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

