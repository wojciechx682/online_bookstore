


function increase()
{
	console.log("increase js");

	var el = document.getElementById("koszyk_ilosc");

	el.value = parseInt(el.value) + 1;
	//console.log(el.value);	
}


function decrease()
{
	console.log("decrease js");

	var el = document.getElementById("koszyk_ilosc");

	if(el.value > 1)
	{
		el.value = parseInt(el.value) - 1;
	}

	//console.log(el.value);
	
}

