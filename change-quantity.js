
function increase(id_ksiazki) {

		// let el = document.getElementById("koszyk_ilosc" + id_ksiazki);
		// `${variable}`   <--- template literals. // document.querySelector(`#my-element-${id}`);

	let el = document.querySelector(`#koszyk_ilosc${id_ksiazki}`);

	el.value = parseInt(el.value) + 1;

		// let form = document.getElementById("change_quantity_form" + id_ksiazki);

	let form = document.querySelector(`#change_quantity_form${id_ksiazki}`)

	form.submit();
}

function decrease(id_ksiazki) {

		// let el = document.getElementById("koszyk_ilosc" + id_ksiazki);

	let el = document.querySelector(`#koszyk_ilosc${id_ksiazki}`);

	if (el.value > 1)
	{
		el.value = parseInt(el.value) - 1;
	}

	let form = document.querySelector(`#change_quantity_form${id_ksiazki}`);

	form.submit();
}



