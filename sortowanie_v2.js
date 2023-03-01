$('#sortuj_wg').on('change', function() {
	sortuj();
});

function testuj()
{
	/*var el = document.getElementById("add_quan");
	el.innerHTML = "123";*/
}

function sortuj()
{
	var s = document.getElementById("sortuj_wg");
	var selected_value = s.options[s.selectedIndex].text;

	console.log("selected_value->", selected_value);

	number_of_child = document.getElementById("content_books").childElementCount;

	console.log("number_of_child->", number_of_child);

	var content_books = document.getElementById("content_books");

	console.log("content_books ->", content_books);

	var books = new Array(number_of_child);      // przechowuje divy -> book0, book1, ...
	var new_books = new Array(number_of_child);  // nowe divy - po podmianie

	var titles = new Array(number_of_child);     // tytuły książek
	var prices = new Array(number_of_child);     // ceny
	var years = new Array(number_of_child);      // lata_wydania

	var titles_org = new Array(number_of_child); // oryginały
	var prices_org = new Array(number_of_child);
	var years_org = new Array(number_of_child);

	for(var i=0; i<number_of_child; i++)
	{
		var book_id = "book";
		var book_id = book_id.concat(i);                     //      id -> book0, book1 ...

		var book_element = document.getElementById(book_id); // element -> book0, book1, ...

		console.log("book el -> ", book_element);
		switch(selected_value)
		{
			case "nazwy A-Z":

				var book_element_title = book_element.querySelector('.title').innerHTML; // tytuł
				titles_org[i] = book_element_title;
				titles[i] = book_element_title;

			case "nazwy Z-A":

				var book_element_title = book_element.querySelector('.title').innerHTML; // tytuł
				titles_org[i] = book_element_title;
				titles[i] = book_element_title;

			case "ceny rosnąco":

				var book_element_price = book_element.querySelector('.price').innerHTML; // cena
				prices_org[i] = book_element_price;
				prices[i] = book_element_price;

			case "ceny malejąco":

				var book_element_price = book_element.querySelector('.price').innerHTML; // cena
				prices_org[i] = book_element_price;
				prices[i] = book_element_price;

			case "Najstarszych":

				var book_element_year = book_element.querySelector('.year').innerHTML;   // rok
				years_org[i] = book_element_year;
				years[i] = book_element_year;

			case "Najnowszych":

				var book_element_year = book_element.querySelector('.year').innerHTML;   // rok
				years_org[i] = book_element_year;
				years[i] = book_element_year;
		}

		books[i] = book_element; // divy -> book0, book1, ...
	}

	if(selected_value == "nazwy A-Z")
	{
		//titles_sorted = titles.sort(); // ERROR ! --> A, B, D, Ą - to nie jest poprawne sortowanie ...
		//titles_sorted = titles.sort((a, b) => a.localeCompare(b)); // ✓ ponieważ tytuły zawierają polskie znaki
		titles_sorted = titles.sort(function(a,b) {
			return a.localeCompare(b);
		});
		//console.log("titles_sorted->", titles_sorted);
	}

	else if(selected_value == "ceny rosnąco")
	{
		prices_sorted = prices.sort(function(a, b) {
			return a - b;
		});
	}

	else if(selected_value == "Najstarszych")
	{
		years_sorted = years.sort(function(a, b) {
			return a - b;
		});
	}

	else if(selected_value == "nazwy Z-A")
	{
		//titles_sorted = titles.sort();
		titles_sorted = titles.sort(function(a,b) {
			return a.localeCompare(b);
		});
		titles_sorted.reverse();
	}

	else if(selected_value == "ceny malejąco")
	{
		//prices_sorted = prices.sort();

		prices_sorted = prices.sort(function(a, b) {
			return a - b;
		});

		prices_sorted.reverse();
	}

	else if(selected_value == "Najnowszych")
	{
		years_sorted = years.sort();
		years_sorted.reverse();
	}

	if((selected_value == "nazwy A-Z") || (selected_value == "nazwy Z-A"))
	{
		var sorted_titles_id = new Array(number_of_child);
	}

	if((selected_value == "ceny rosnąco") || (selected_value == "ceny malejąco"))
	{
		var sorted_prices_id = new Array(number_of_child);
	}

	if((selected_value == "Najstarszych") || (selected_value == "Najnowszych"))
	{
		var sorted_years_id = new Array(number_of_child);
	}

	var x, k, q = 0;

	for(var i=0; i<number_of_child; i++)
	{
		for(var j=0; j<number_of_child; j++)
		{
			if((selected_value == "nazwy A-Z") || (selected_value == "nazwy Z-A"))
			{
				if((titles_sorted[i] == titles_org[j]) && (sorted_titles_id.includes(j) == false))
				{
					sorted_titles_id[i] = j;
				}
			}

			if((selected_value == "ceny rosnąco") || (selected_value == "ceny malejąco"))
			{
				if((prices_sorted[i] == prices_org[j]) && (sorted_prices_id.includes(j) == false))
				{
					sorted_prices_id[i] = j;
				}
			}

			if((selected_value == "Najstarszych") || (selected_value == "Najnowszych"))
			{
				if((years_sorted[i] == years_org[j]) && (sorted_years_id.includes(j) == false))
				{
					sorted_years_id[i] = j;
				}
			}
		}
	}

	for(i=0; i<number_of_child; i++)
	{
		for(j=0; j<number_of_child; j++)
		{

			if((selected_value == "nazwy A-Z") || (selected_value == "nazwy Z-A"))
			{
				if(sorted_titles_id[i] == books[j].id.substr(4))
				{
					new_books[i] = books[j];
				}
			}

			if((selected_value == "ceny rosnąco") || (selected_value == "ceny malejąco"))
			{
				if(sorted_prices_id[i] == books[j].id.substr(4))
				{
					new_books[i] = books[j];
				}
			}

			if((selected_value == "Najstarszych") || (selected_value == "Najnowszych"))
			{
				if(sorted_years_id[i] == books[j].id.substr(4))
				{
					new_books[i] = books[j];
				}
			}
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////////////
	// Podmiana divów :

	for(i=0; i<number_of_child; i++)
	{
		books[i] = new_books[i];
	}

	content_books.innerHTML = "";

	for(i=0; i<number_of_child; i++)
	{
		content_books.appendChild(books[i]);
	}

	//return 1;
}
