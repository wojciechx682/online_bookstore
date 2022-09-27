


function increase(id_ksiazki)
{	
	var el = document.getElementById("koszyk_ilosc"+id_ksiazki);

	el.value = parseInt(el.value) + 1;

	var form = document.getElementById("change_quantity_form"+id_ksiazki).submit();		
}


function decrease(id_ksiazki)
{
	

	var el = document.getElementById("koszyk_ilosc"+id_ksiazki);

	if(el.value > 1)
	{
		el.value = parseInt(el.value) - 1;
	}

	var form = document.getElementById("change_quantity_form"+id_ksiazki).submit();	

	//console.log(el.value);
	
}

