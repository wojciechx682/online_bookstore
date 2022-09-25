
function testuj()
{
	console.log("test js");


	var el = document.getElementById("quantity");
	el.value = parseInt(el.value) + 1;
}

function testuj1()
{
	console.log("test js");


	var el = document.getElementById("quantity");
	if(el.value > 0)
	{
		el.value = parseInt(el.value) - 1;
	}
	
}







function testuj2() 
{
	var s = document.getElementById("ddlViewBy");

	//var value = s.value; // atrybut "value" z elementów <option>
	
	var selected_value = s.options[s.selectedIndex].text; // ceny rosnaco, ...
	
	//var selected_value = "nazwy A-Z"; // ceny rosnaco, ...
	//let selected_type = "rosnaco";

	console.log("\nselected value -> " + selected_value);

	///////////////////////////////////////////////////////////////////////////////
		
		//const sort_value = document.querySelectorAll('input[name="sortuj_wg"]'); 
		//const sort_type = document.querySelectorAll('input[name="sortuj_typ"]');	

		/*let selected_value; // tytul, cena, rok_wydania
		let selected_type; // rosnaca, melajaca

		for (const rb of sort_value) 
		{
	        if (rb.checked) 
	        {
	            selected_value = rb.value;
	            break;
	        }
	    }

	    for (const st of sort_type) 
		{
	        if (st.checked) 
	        {
	            selected_type = st.value;
	            break;
	        }
	    }  */


	    /*var s = document.getElementById("select_sortuj_wg");

	    var value = s.options[s.selectedIndex].text;*/    

    //return 0; 
    //exit();

    /*
	    number_of_child = document.getElementById("content_books").childElementCount; 

		var content_books = document.getElementById("content_books");
		
		var books = new Array(number_of_child);      // przechowuje divy -> book0, book1, ...
		var new_books = new Array(number_of_child);  // nowe divy - po podmianie

		var titles = new Array(number_of_child);     // tytuły książek
		var prices = new Array(number_of_child);     // ceny 
		var years = new Array(number_of_child);      //  lata_wydania

		var titles_org = new Array(number_of_child); 
		var prices_org = new Array(number_of_child); 
		var years_org = new Array(number_of_child);  

		for(var i=0; i<number_of_child; i++)
		{
			var book_id = "book";
			var book_id = book_id.concat(i);                     //      id -> book0, book1 ...		

			var book_element = document.getElementById(book_id); // element -> book0, book1, ...		
			
			//////////////////////////////////////////////////////////////////////////////////////
			//books[i] = book_element;                             // divy -> book0, book1, ...	
			//////////////////////////////////////////////////////////////////////////////////////

			switch(selected_value)
			{
				case "nazwy A-Z":
					
					var book_element_title = book_element.querySelector('.title').innerHTML; // tytuł				
					titles_org[i] = book_element_title;
					titles[i] = book_element_title;

					titles_sorted = titles.sort(); 	

					var sorted_titles_id = new Array(number_of_child);		

				case "nazwy Z-A":

					var book_element_title = book_element.querySelector('.title').innerHTML; // tytuł				
					titles_org[i] = book_element_title;
					titles[i] = book_element_title;

					titles_sorted = titles.sort(); 
					titles_sorted.reverse();	

					var sorted_titles_id = new Array(number_of_child);

				case "ceny rosnąco":
					
					var book_element_price = book_element.querySelector('.price').innerHTML; // cena				
					prices_org[i] = book_element_price;
					prices[i] = book_element_price;

					prices_sorted = prices.sort(function(a, b) {
						return a - b;
					});

					var sorted_prices_id = new Array(number_of_child);	

				case "ceny malejąco":

					var book_element_price = book_element.querySelector('.price').innerHTML; // cena				
					prices_org[i] = book_element_price;
					prices[i] = book_element_price;

					prices_sorted = prices.sort(function(a, b) {
						return a - b;
					});

					prices_sorted.reverse();

					var sorted_prices_id = new Array(number_of_child);


				case "Najstarszych":
					
					var book_element_year = book_element.querySelector('.year').innerHTML;   // rok					
					years_org[i] = book_element_year;
					years[i] = book_element_year;	

					years_sorted = years.sort(function(a, b) {
						return a - b;
					});	

					var sorted_years_id = new Array(number_of_child);	  

				case "Najnowszych":
					
					var book_element_year = book_element.querySelector('.year').innerHTML;   // rok					
					years_org[i] = book_element_year;
					years[i] = book_element_year;	

					years_sorted = years.sort(); 
					years_sorted.reverse();	 

					var sorted_years_id = new Array(number_of_child);	
			}		

			books[i] = book_element;                             // divy -> book0, book1, ...	
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

				if((selected_value == "Najnowszych") || (selected_value == "Najstarszych")) 
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

				if((selected_value == "Najnowszych") || (selected_value == "Najstarszych"))
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

		console.log("\n////////////////////////////////////////////////////////////////////////////////////////////////");
		console.log("\nbooks[i] -> ");
		for(i=0; i<number_of_child; i++) 
		{
			books[i] = new_books[i];
			console.log(books[i]);				
		}	


		content_books.innerHTML = "";

		for(i=0; i<number_of_child; i++) 
		{		
			content_books.appendChild(books[i]);
		}

		return 1;
	*/

	number_of_child = document.getElementById("content_books").childElementCount; 

	var content_books = document.getElementById("content_books");
	
	var books = new Array(number_of_child);      // przechowuje divy -> book0, book1, ...
	var new_books = new Array(number_of_child);  // nowe divy - po podmianie

	var titles = new Array(number_of_child);     // tytuły książek
	var prices = new Array(number_of_child);     // ceny 
	var years = new Array(number_of_child);      //  lata_wydania

	var titles_org = new Array(number_of_child); 
	var prices_org = new Array(number_of_child); 
	var years_org = new Array(number_of_child);  

	for(var i=0; i<number_of_child; i++)
	{
		var book_id = "book";
		var book_id = book_id.concat(i);                     //      id -> book0, book1 ...		

		var book_element = document.getElementById(book_id); // element -> book0, book1, ...		
		
		switch(selected_value)
		{
			case "nazwy A-Z":
				
				var book_element_title = book_element.querySelector('.title').innerHTML; // tytuł				
				titles_org[i] = book_element_title;
				titles[i] = book_element_title;

				titles_sorted = titles.sort(); 

				var sorted_titles_id = new Array(number_of_child);

			case "nazwy Z-A":
				
				var book_element_title = book_element.querySelector('.title').innerHTML; // tytuł				
				titles_org[i] = book_element_title;
				titles[i] = book_element_title;

				titles_sorted = titles.sort(); 
				titles_sorted.reverse();

				var sorted_titles_id = new Array(number_of_child);

			case "ceny rosnąco":
				
				var book_element_price = book_element.querySelector('.price').innerHTML; // cena				
				prices_org[i] = book_element_price;
				prices[i] = book_element_price;

				prices_sorted = prices.sort(function(a, b) {
		        	return a - b;
		    	}); 

		    	var sorted_prices_id = new Array(number_of_child);	

			case "ceny malejąco":
				
				var book_element_price = book_element.querySelector('.price').innerHTML; // cena				
				prices_org[i] = book_element_price;
				prices[i] = book_element_price;

				prices_sorted = prices.sort(function(a, b) {
		        	return a - b;
		    	});

				prices_sorted.reverse();

				var sorted_prices_id = new Array(number_of_child);	

			case "Najstarszych":
				
				var book_element_year = book_element.querySelector('.year').innerHTML;   // rok					
				years_org[i] = book_element_year;
				years[i] = book_element_year;

				years_sorted = years.sort(function(a, b) {
		        	return a - b;
		   		});	

		   		var sorted_years_id = new Array(number_of_child); 

			case "Najnowszych":
				
				var book_element_year = book_element.querySelector('.year').innerHTML;   // rok					
				years_org[i] = book_element_year;
				years[i] = book_element_year;	

				years_sorted = years.sort(); 
				years_sorted.reverse();	

				var sorted_years_id = new Array(number_of_child);
		}		

		books[i] = book_element;                             // divy -> book0, book1, ...				
	}	

	/*if(selected_type == "rosnaco") 
	{
		if(selected_value == "nazwy A-Z")
		{			
			titles_sorted = titles.sort(); 			
		}
 
		if(selected_value == "ceny rosnąco")
		{	
			prices_sorted = prices.sort(function(a, b) {
	        	return a - b;
	    	});   	
		}	

		if(selected_value == "Najstarszych")
		{			
			years_sorted = years.sort(function(a, b) {
	        	return a - b;
	   		});	   		
		}		
	}
	else // malejaco
	{
		if(selected_value == "nazwy Z-A")
		{
			titles_sorted = titles.sort(); 
			titles_sorted.reverse();			
		}
		if(selected_value == "ceny malejąco")
		{
			//prices_sorted = prices.sort();

			prices_sorted = prices.sort(function(a, b) {
	        	return a - b;
	    	});

			prices_sorted.reverse();			
		}
		if(selected_value == "Najnowszych")
		{
			years_sorted = years.sort(); 
			years_sorted.reverse();				
		}			
	}	*/

	/*if((selected_value == "nazwy A-Z") || (selected_value == "nazwy Z-A"))
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
	}	*/
	
	var x, k, q = 0;	

	//var zajete = new Array(10000); 

	for(var i=0; i<number_of_child; i++)
	{
		for(var j=0; j<number_of_child; j++)
		{
			if((selected_value == "nazwy A-Z") || (selected_value == "nazwy Z-A"))
			{
				console.log("405");

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
				console.log("438");

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

	console.log("\n////////////////////////////////////////////////////////////////////////////////////////////////");
	console.log("\nbooks[i] -> ");
	for(i=0; i<number_of_child; i++) 
	{
		books[i] = new_books[i];
		console.log(books[i]);				
	}	


	/*for(i=0; i<number_of_child; i++) 
	{
		books[i] = new_books[i];				
	}	*/

	content_books.innerHTML = "";

	for(i=0; i<number_of_child; i++) 
	{		
		content_books.appendChild(books[i]);
	}

	return 1;





}