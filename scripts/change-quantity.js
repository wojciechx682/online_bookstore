
function changeQuantity(id_ksiazki, amount) {

	const el = document.querySelector(`#koszyk_ilosc${id_ksiazki}`);
	const newQuantity = parseInt(el.value) + amount;

	if (newQuantity >= 1) {
		el.value = newQuantity;
		let form = document.querySelector(`#change_quantity_form${id_ksiazki}`); // (tylko dla) koszyk.php
		form.submit();															 // -----||---- koszyk.php
	}
}

function increase(id_ksiazki) {
	changeQuantity(id_ksiazki, 1);
}

function decrease(id_ksiazki) {
	changeQuantity(id_ksiazki, -1);
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

