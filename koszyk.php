<?php

	session_start();
	
	include_once "functions.php"; // _once - sprawdzi, czy ten plik nie został zaincludowany wcześniej

	//echo $_SESSION['login'] . '<br>';

	/*if(isset($_SESSION['zalogowany']))
	{
		//echo '<br>'.$_SESSION['account_error'];
		unset($_SESSION['account_error']);
		//exit();
	}	*/

	if(!(isset($_SESSION['zalogowany'])))
	{
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Księgarnia online</title>
	<link rel="stylesheet" href="style2.css">

	<style>

		/*#content
		{
			width:  100%;
		}*/

	</style>

	<script>

		function show_nav()
		{
			var nav = document.getElementById("nav");
			var content = document.getElementById("content");

			if(nav.style.display == 'none')
			{
				nav.style.display = 'block';
				nav.style.width = '20%';
				content.style.width = '80%';
			}
		}


		function sortuj(sort_type, sort_by) // ta funkcja wyświetla: Ile jest książek w danej kategorii., sortuje dane
		{
			//sort_by - title, price, year ?

			//var alfabetycznie = document.getElementById("title_radio").value;
			//console.log("673->"+alfabetycznie);

			//var content_books__ = document.getElementById("content_books");
			//content_books__.innerHTML = "";


			// NOTE: WARTOŚCI -> TYTUł, CENA, ROK WYDANIA NIE MOGĄ SIĘ POWTARZAĆ

			const rbs = document.querySelectorAll('input[name="sortuj_wg"]');

			let selectedValue;

			for (const rb of rbs) 
			{
                if (rb.checked) 
                {
                    selectedValue = rb.value;
                    break;
                }
            }
            
            console.log("selectedValue ->"+selectedValue);


            number_of_child = document.getElementById("content_books").childElementCount;

            console.log("\n\nnumber_of_child->"+number_of_child);
			//last_book = document.getElementById("content_books").lastChild; 

			//var last_book_id = (last_book.id.substr(4));


			//last_book_id++; // <--- Ilość książek

			//alert("id ostatniej ksiazki -> " + last_book_id);

			// "Dostanie" się do każdego elementu - diva -> tytuł, cena, rok :

			/*

			<div id="content_books">

				<div id="book0" class="book">

					<div class="title">Title1</div>
					<div class="price">Price1</div>
					<div class="year">Year1</div>

				</div>

				<div id="book1" class="book">...</div>
				...
				<div id="book7" class="book">...</div>
			</div>

			*/

			var content_books = document.getElementById("content_books");
			// to jest div przechowujący wszystkie książki

			
			var books = new Array(number_of_child); // ! przechowuje divy -> book0, book1, ...
			var new_books = new Array(number_of_child); // to będą nowe divy - po podmianie

			var titles = new Array(number_of_child); // tytuły książek
			var prices = new Array(number_of_child); // ceny książek
			var years = new Array(number_of_child); // rok wydania książek

			var titles_org = new Array(number_of_child); // tytuły książek
			var prices_org = new Array(number_of_child); // ceny książek
			var years_org = new Array(number_of_child); // rok wydania książek


			for(var i=0; i<number_of_child; i++)
			{
				var book_id = "book";
				var book_id = book_id.concat(i); // id -> book0, book1 ...
				//console.log(book_id);

				var book_element = document.getElementById(book_id); // ✓ TO JEST DOBRZE ! 
				// element -> book0, book1, ...

				//var book_element_first_child = book_element.children[0];
				var book_element_title = book_element.querySelector('.title').innerHTML; // tytuł
				var book_element_price = book_element.querySelector('.price').innerHTML; // cena
				var book_element_year = book_element.querySelector('.year').innerHTML; // rok

				//console.log(book_element_title, book_element_price, book_element_year);
				

				books[i] = book_element; // ✓ TO JEST DOBRZE ! 
				//console.log(books[i]);

				/////////////////////////////////////////////////

				titles_org[i] = book_element_title;
				prices_org[i] = book_element_price;
				years_org[i] = book_element_year;



				titles[i] = book_element_title;
				prices[i] = book_element_price;
				years[i] = book_element_year;

				//console.log(titles[i], prices[i], years[i]);
				console.log("\n\ntytuły->" + titles[i]);
				
			}

			//console.log("\n\nbook_element_title->"+book_element_title);
			//console.log("\n\nbook_element_price->"+book_element_price);
			//console.log("\n\nbook_element_year->"+book_element_year);
		
			console.log("781");
			console.log("----------------------");
			console.log("----------------------");

			for(var x=0; x<number_of_child; x++)
			{
				console.log(books[x]);
			}

			for(var x=0; x<number_of_child; x++)
			{
				console.log(titles[x]);
			}

			for(var x=0; x<number_of_child; x++)
			{
				console.log(prices[x]);
			}

			for(var x=0; x<number_of_child; x++)
			{
				console.log(years[x]);
			}

			//return;


			/*for(var q=0; q<number_of_child; q++)
			{
				console.log("\n\nceny->" + prices[q]);
				
			}

			for(var q=0; q<number_of_child; q++)
			{
				console.log("\n\nlata->" + years[q]);
				
			}*/

			// teraz trzeba posortować te tablice :

			// titles[]	prices[] years[]

			console.log("\n");


			//titles_sorted = titles.sort(); 

			sort_type = "asc";


			if(sort_type == "asc") // sortowanie rosnąca - ASC
			{
				titles_sorted = titles.sort(); 

				//prices_sorted = prices.sort(); 
				//years_sorted = years.sort(); 

				prices_sorted = prices.sort(function(a, b) {
			        return a - b;
			    });

				years_sorted = years.sort(function(a, b) {
			        return a - b;
			    });




				//prices_sorted = prices.sort(); 
				//years_sorted = years.sort(); 
				
				for(var i=0; i<number_of_child; i++)
				{					
					console.log("866 tytuły posortowane->" + titles_sorted[i]);
				}

				for(var i=0; i<number_of_child; i++)
				{					
					console.log("ceny posortowane->" + prices_sorted[i]);
				}

				for(var i=0; i<number_of_child; i++)
				{					
					console.log("lata posortowane->" + years_sorted[i]);
				}
				//return;
			}
			else
			{
				titles_sorted = titles.sort(); 
				titles_sorted.reverse();

				prices_sorted = prices.sort(); 
				prices_sorted.reverse();

				years_sorted = years.sort(); 
				years_sorted.reverse();				
				
				for(var i=0; i<number_of_child; i++)
				{					
					console.log("tytuły posortowane->" + titles_sorted[i]);
				}
			}

			// po tym jak mam posortowane tablice z tytułem, ceną i rokiem : 

			var sorted_titles_id = new Array(number_of_child);
			var sorted_prices_id = new Array(number_of_child);
			var sorted_years_id = new Array(number_of_child);

			console.log("--------------------------------------");


			console.log("titles->"+titles_org);
			console.log("titles_sorted->"+titles_sorted);

			console.log("prices->"+prices_org);
			console.log("prices_sorted->"+prices_sorted);

			console.log("years->"+years_org);
			console.log("years_sorted->"+years_sorted);
			//return;
			var x = 0;

			console.log("\n titles_org[0] -> "+titles_org[0]);
			console.log("\n titles_sorted[0] -> "+titles_sorted[0]);
			//return;

			var k = 0;
			var q = 0;

			var zajete = new Array(10000);

			for(var i=0; i<number_of_child; i++)
			{
				for(var j=0; j<number_of_child; j++)
				{
					/*if(k>=i)
					{
						break;
					}*/

					/*var book_id = "book";
					var book_id = book_id.concat(j); // id -> book0, book1 ...
					//console.log(book_id);

					var book_element = document.getElementById(book_id); // ✓ TO JEST DOBRZE ! 
					// element -> book0, book1, ...

					//var book_element_first_child = book_element.children[0];
					var book_element_title = book_element.querySelector('.title').innerHTML; // tytuł
					var book_element_price = book_element.querySelector('.price').innerHTML; // cena
					var book_element_year = book_element.querySelector('.year').innerHTML; // rok*/








					if((titles_sorted[i] == titles_org[j]) && (sorted_titles_id.includes(j) == false))
					{
						sorted_titles_id[i] = j;

						//zajete[i] = j;



						//x++;
						//break;
					}

					/*if(prices_sorted[i] == prices_org[j])
					{
						sorted_prices_id[i] = j;	
						break;					
					}

					if((years_sorted[i] == years_org[j])&&(j!=zajete[zajete.length-1]))
					{
						sorted_years_id[k] = q;
						//x++;
						//break;
						// https://stackoverflow.com/questions/42070577/javascript-compare-two-arrays-and-return-index-of-matches

						zajete[k] = j;
						
						//j++;
						k++;
						q++;
					}*/

					//k++;
					

				}
				//k++;
				
			}

			//////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////


			console.log("\n\n---sorted_titles_id->");	

			for(var i=0; i<number_of_child; i++)
			{

				console.log(sorted_titles_id[i]);					
			}


			console.log("--------------------------------------");
			console.log("books->");

			for(var x=0; x<number_of_child; x++)
			{
				console.log(books[x]);
			}


			for(i=0; i<number_of_child; i++) // pętla po ilości książek
			{

					//console.log(books[i].querySelector('.title').innerHTML)
				//console.log(books[i].id.substr(4))
				//console.log(sorted_titles_id[i] + "\n\n")

				/*var book_id = "book";
				var book_id = book_id.concat(i); // id -> book0, book1 ...
					//console.log(book_id);

				var book_element = document.getElementById(book_id); // ✓ TO JEST DOBRZE !*/ 



				for(j=0; j<number_of_child; j++) // pętla po ilości książek
				{

					if(selectedValue == "tytul")
					{
						if(sorted_titles_id[i] == books[j].id.substr(4))
						{
							//console.log("-->"+books[j].id.substr(4));
							//console.log("-->"+books[j].id);
							//book_element.innerHTML = books[j].innerHTML;

							new_books[i] = books[j]
							//content_books_test.appendChild(books[j]);

							//book_element.innerHTML = books[j].innerHTML;

							//break;

						}
					}
					if(selectedValue == "cena")
					{
						if(sorted_prices_id[i] == books[j].id.substr(4))
						{
							//console.log("-->"+books[j].id.substr(4));
								//book_element = books[j];


							//content_books_test.appendChild(books[j]);

								//book_element.innerHTML = books[j].innerHTML;

							new_books[i] = books[j]
							//break;

						}
					}

					if(selectedValue == "rok_wydania")
					{
						if(sorted_years_id[i] == books[j].id.substr(4))
						{
							//console.log("-->"+books[j].id.substr(4));
							//book_element = books[j];



							//content_books_test.appendChild(books[j]);


							//console.log("\n1021->"+books[j].children[2].innerHTML);


							//book_elements[i].innerHTML = books[j].innerHTML;

							new_books[i] = books[j]
							//book_element.innerHTML = books[j].innerHTML;

							//break;

						}
					}




					

					
				}

			}


			console.log("new books->");

			for(var x=0; x<number_of_child; x++)
			{
				console.log(new_books[x]);
			}





			// podmiana divów : 
			

			for(i=0; i<number_of_child; i++) 
			{
				books[i] = new_books[i];				
			}
			

			console.log("--------------------------------------");
			console.log("books->");

			for(var x=0; x<number_of_child; x++)
			{
				console.log(books[x]);
			}

			/*console.log("\n\n books ->")

			for(i=0; i<=number_of_child; i++) 
			{
				books[i].innerHTML = new_books[i].innerHTML;	
			}*/


			content_books.innerHTML = "";

			for(i=0; i<number_of_child; i++) 
			{
				//content_books.appendChild(new_books[i]);
				content_books.appendChild(books[i]);
			}





































			return 1;





			for(var i=0; i<number_of_child; i++)
			{
				for(var j=0; j<number_of_child; j++)
				{
					/*if(k>=i)
					{
						break;
					}*/

					/*var book_id = "book";
					var book_id = book_id.concat(j); // id -> book0, book1 ...
					//console.log(book_id);

					var book_element = document.getElementById(book_id); // ✓ TO JEST DOBRZE ! 
					// element -> book0, book1, ...

					//var book_element_first_child = book_element.children[0];
					var book_element_title = book_element.querySelector('.title').innerHTML; // tytuł
					var book_element_price = book_element.querySelector('.price').innerHTML; // cena
					var book_element_year = book_element.querySelector('.year').innerHTML; // rok*/








					if((titles_sorted[i] == titles_org[j]) )
					{
						sorted_titles_id[i] = j;
						//x++;
						break;
					}

					if(prices_sorted[i] == prices_org[j])
					{
						sorted_prices_id[i] = j;	
						break;					
					}

					if((years_sorted[i] == years_org[j])&&(j!=zajete[zajete.length-1]))
					{
						sorted_years_id[k] = q;
						//x++;
						//break;
						// https://stackoverflow.com/questions/42070577/javascript-compare-two-arrays-and-return-index-of-matches

						zajete[k] = j;
						
						//j++;
						k++;
						q++;
					}
					//k++;
					

				}
				//k++;
				
			}
			
			console.log("\n\n---sorted_titles_id->");	

			for(var i=0; i<number_of_child; i++)
			{

				console.log(sorted_titles_id[i]);					
			}

			console.log("\n\n---sorted_prices_id->");	

			for(var i=0; i<number_of_child; i++)
			{

				console.log(sorted_prices_id[i]);					
			}

			console.log("\n\n---sorted_years_id->");	

			for(var i=0; i<number_of_child; i++)
			{

				console.log(sorted_years_id[i]);					
			}
			//return;

			console.log("--------------------------------------");
			console.log("--------------------------------------");
			
			//var content_books_test = document.getElementById("content_books");
			//var child_nodes = content_books_test.childNodes;
			//var c = document.getElementById("content_books").childNodes;
			


			/*var book_elements = new Array(number_of_child);

			for(i=0; i<number_of_child; i++)
			{
				var book_id = "book";
				var book_id = book_id.concat(i); // id -> book0, book1 ...
					//console.log(book_id);

				var book_element = document.getElementById(book_id); // ✓ TO JEST DOBRZE ! 

				book_elements[i] = book_element;
			}*/

			console.log("--------------------------------------");
			console.log("--------------------------------------");
			console.log("books->");

			for(var x=0; x<number_of_child; x++)
			{
				console.log(books[x]);
			}

			//return;
			for(i=0; i<number_of_child; i++) // pętla po ilości książek
			{

					//console.log(books[i].querySelector('.title').innerHTML)
				//console.log(books[i].id.substr(4))
				//console.log(sorted_titles_id[i] + "\n\n")

				/*var book_id = "book";
				var book_id = book_id.concat(i); // id -> book0, book1 ...
					//console.log(book_id);

				var book_element = document.getElementById(book_id); // ✓ TO JEST DOBRZE !*/ 



				for(j=0; j<number_of_child; j++) // pętla po ilości książek
				{

					if(selectedValue == "tytul")
					{
						if(sorted_titles_id[i] == books[j].id.substr(4))
						{
							//console.log("-->"+books[j].id.substr(4));
							//console.log("-->"+books[j].id);
							//book_element.innerHTML = books[j].innerHTML;

							new_books[i] = books[j]
							//content_books_test.appendChild(books[j]);

							//book_element.innerHTML = books[j].innerHTML;

							//break;

						}
					}
					if(selectedValue == "cena")
					{
						if(sorted_prices_id[i] == books[j].id.substr(4))
						{
							//console.log("-->"+books[j].id.substr(4));
								//book_element = books[j];


							//content_books_test.appendChild(books[j]);

								//book_element.innerHTML = books[j].innerHTML;

							new_books[i] = books[j]
							//break;

						}
					}

					if(selectedValue == "rok_wydania")
					{
						if(sorted_years_id[i] == books[j].id.substr(4))
						{
							//console.log("-->"+books[j].id.substr(4));
							//book_element = books[j];



							//content_books_test.appendChild(books[j]);


							//console.log("\n1021->"+books[j].children[2].innerHTML);


							//book_elements[i].innerHTML = books[j].innerHTML;

							new_books[i] = books[j]
							//book_element.innerHTML = books[j].innerHTML;

							//break;

						}
					}




					

					
				}














			}

			console.log("\n\n new books ->")

			for(i=0; i<number_of_child; i++) 
			{
				console.log(new_books[i]);
			}

			console.log("\n\n---sorted_years_id->");	

			for(var i=0; i<number_of_child; i++)
			{

				console.log(sorted_years_id[i]);					
			}


			console.log("\n\n---zajete->");	

			for(var i=0; i<number_of_child; i++)
			{

				console.log(zajete[i]);					
			}

			// podmiana divów : 


			

				/*for(i=0; i<number_of_child; i++) 
				{
					books[i] = new_books[i];				
				}*/
			

			/*console.log("\n\n books ->")

			for(i=0; i<=number_of_child; i++) 
			{
				books[i].innerHTML = new_books[i].innerHTML;	
			}*/


			/*content_books.innerHTML = "";

			for(i=0; i<number_of_child; i++) 
			{
				content_books.appendChild(new_books[i]);
			}*/

			

		}





	</script>

</head>

<body>

	<div id="header_container">
		
		<!-- <div id="header_content"> -->

			<div id="sticky">

				<div id="top_header">

					<div id="top_header_content">

						<div id="header_title">
							
							Księgarnia internetowa

						</div>		
						
						<!--<div id="div_register">
							
							<a class="top-nav-right" href="zarejestruj.php">Zarejestruj</a>
							
						</div> -->

						<!-- <div id="div_log_in">
							
							<a class="top-nav-right" href="zaloguj.php">Zaloguj</a>

						</div> -->

						<ol>	

							<li>
								<a href="zarejestruj.php">Zarejestruj</a>
							</li>

							<li>									
								<?php if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true")) { echo '<a href="account.php">Moje konto</a>';} else { echo '<a href="zaloguj.php">Zaloguj</a>';} ?>
							</li>

						</ol>

					</div>

				</div>

				<div id="header">

					<div id="header_content">

						<!-- <a href="index.php">Strona główna</a> -->

						 <div id="div_search">				

							<form action="index.php" method="get">
								
								<input type="search" name="input_search">

								<input type="submit" value="Szukaj">

							</form>	

						</div>

						<div id="div_logo">				
							
							<img src="logo.png" width="100px">

						</div>

						<!-- 
							<div id="div_log_in">
								
								<a class="top-nav-right" href="zaloguj.php">Zaloguj</a>

							</div> 
						-->
						
						<!--
							<div id="div_register">
								
								<a class="top-nav-right" href="zarejestruj.php">Zarejestruj</a>
								
							</div>
						-->

						<div id="div_cart">
							
							<a class="top-nav-right" href="koszyk.php">Koszyk</a>
							
						</div>

						<!--
							<div id="div_my_account">
								
								<a class="top-nav-right" href="account.php">Moje konto</a>
								
							</div> 
						-->
						
						<div style="clear: both;"></div>

					</div>

				</div>

			</div>

			<div id="top_nav">
				
				<div id="top_nav_content">

					<ol>
						
						<li><a href="index.php">Strona główna</a></li>
						<li><a href="#">Kategorie</a>
							
							 <!-- <ul id="double"> -->
							 <ul>

								<!-- 
									<li class="double"><a href="#">Informatyka</a></li>
									<li class="double"><a href="#">Poezja</a></li>
									<li class="double"><a href="#">Horror</a></li>
									<li class="double"><a href="#">Komiks</a></li> 
								-->

								<?php 
									echo query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories", ""); // wypis kategorii - wewnątrz listy rozwijanej ul
								?>

							</ul> 

						</li>
						<li><a href="#">...</a>
							<ul>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
							</ul>
						</li>
						<li><a href="#">...</a>
							<ul>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
							</ul>
						</li>
						<li><a href="#">...</a>
							<ul>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
							</ul>
						</li>
						<li><a href="#">...</a></li>

					</ol>
			
				</div>

			</div>

		<!-- </div> -->

	</div>
	

	<div id="container">
		
		

		

		<div id="nav">		

			<!-- <h3> Kategorie </h3>
			<hr> -->

			<?php
				
				//echo query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories", ""); // nav - wypis kategorii	

				//echo "<hr>";				
			?>

			<!-- <h3> Sortuj wg </h3> -->

				<!-- <input type="checkbox" name="data_wydania"> -->

				<!-- <label>
					<input type="checkbox" name="data_wydania"> 
						Data wydania
				</label> -->			

				<!--<form action="main.php" method="post">-->
			<!-- <form action="index.php" method="get">


												<?php
													//print_r($_SESSION['Kategorie_array']); // przechowuje kategorie
														//echo "<br> size -> ".count($_SESSION['Kategorie_array']);
													//echo "<br> size -> ".$_SESSION['ilosc_kategorii'];

													//echo "<br><br> --->" . array_values($_SESSION['Kategorie_array'])[6]."<br>"; // wartość konkretnego elementu tablicy
												?>

												
													<?php
														

														/*echo '<select name="select">';
														for($i = 0; $i < $_SESSION['ilosc_kategorii']; $i++) 
														{
														    //if ($value == $row['scpe_grades_status'])
														    //    echo '<option value="'.$value.'" selected>'.$key.'</option>';
														    //else

															$value = array_Values($_SESSION['Kategorie_array'])[$i];


													        echo '<option value="'.$value.'">'.$value.'</option>';
													        //echo $value . '<br>';
														}
														echo '</select>';
														*/

														

													?>
												  
												<?php
													//echo "<br>".$_GET['sortuj_wg']."<br>";
													//echo "<br>".$_GET['sortuj_typ']."<br>";

													/*if(isset($_GET['kategoria']))
													{
														echo '<input type="hidden" name="kategoria_h" value="'.$_GET['kategoria'].'">';
													}*/
												?>

				<br><br>

				<?php
					/*if(isset($_GET['kategoria']))
					{
						echo '<input type="hidden" name="kategoria" value="'.$_GET['kategoria'].'">';
					}*/				
				?>

				<input type="radio" name="sortuj_wg" value="tytul">
					Alfabetycznie<br>

				<input type="radio" name="sortuj_wg" value="cena">
					Cena<br>

				<input type="radio" name="sortuj_wg" value="rok_wydania">
					Data wydania<br>	

				<br><input type="radio" name="sortuj_typ" value="rosnaco">
					Rosnąco<br>

				<input type="radio" name="sortuj_typ" value="malejaco">
					Malejąco<br>

				<br><input type="submit" value="Sortuj">

			</form>	-->				

				<!-- <input id="title_radio" type="radio" name="sortuj_wg" value="tytul">
				<label for="title_radio">Alfabetycznie<br></label>

				<input id="cena_radio" type="radio" name="sortuj_wg" value="cena">
				<label for="cena_radio">Cena<br></label>

				<input id="rok_radio" type="radio" name="sortuj_wg" value="rok_wydania">
				<label for="rok_radio">Data wydania<br></label>

				<br>
				<input type="radio" id="typ_rosnaco" name="sortuj_typ" value="rosnaco">					
				<label for="typ_rosnaco">Rosnąco<br></label>


				<input type="radio" id="typ_malejaca" name="sortuj_typ" value="malejaco">					
				<label for="typ_malejaca">Malejąco<br></label>

				<br><button id="sortowanie" onclick="sortuj()">Sortuj</button> --> <!-- do zmiany! -> js? JQuery ? -->


			<?php

				if(isset($_GET['kategoria'])) 
				{
					$kategoria = $_GET['kategoria']; // <- przyczyna błędu. (już naprawionego ...)		
					
					// Walidacja i sanityzacja danych wprowadzonych od użytkownika :  	
					$kategoria = htmlentities($kategoria, ENT_QUOTES, "UTF-8"); // html entities = encje html'a

					/////////////////////////////////////////////////////////////////////////////////////////////////////////
										
					echo "<b>".$kategoria."</b>";
					echo "<hr>";					
				}
				


			?>

		</div>

		<div id="content">

			<h3>Koszyk</h3>		

			<hr>

			<?php 

				if((isset($_POST['id_ksiazki'])) and (isset($_POST['koszyk_ilosc']))) // dane pochodzące z koszyk_dodaj.php
				{	// && not empty		!empty

					$id_ksiazki = $_POST['id_ksiazki'];
					$ilosc = $_POST['koszyk_ilosc'];					

					// Walidacja i sanityzacja danych wprowadzonych od użytkownika :  	<script>alert("yey");</script>
					$id_ksiazki = htmlentities($id_ksiazki, ENT_QUOTES, "UTF-8");
					$ilosc = htmlentities($ilosc, ENT_QUOTES, "UTF-8");

					$id_klienta = $_SESSION['id'];

					echo '<hr>';

					//add_product_to_cart($id_ksiazki, $ilosc);

					//echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_all_books_search", $search_value);

					$values = array();
					array_push($values, $id_klienta);
					array_push($values, $id_ksiazki);
					array_push($values, $ilosc);

					echo query("INSERT INTO koszyk (id_klienta, id_ksiazki, ilosc) VALUES ('%s', '%s', '%s')", "", $values);  

					echo query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $id_klienta); // dodałem to wstępnie, nie wiem czy to ma tutaj pozostać
				}
				else
				{
					//get_product_from_cart($_SESSION['id']);

					$id_klienta = $_SESSION['id'];

					// Książki które zamówił klient o danym ID : 

					echo query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $id_klienta);

				}
			?>

			<br><a href="submit_order.php">Złóż zamówienie</a>

		</div>		

		<div id="footer">

		</div>

	</div>


	<script>

		/*window.onscroll = function() 
		{
			myFunction()
		};

		var nav = document.getElementById("header");
		var sticky = nav.offsetTop;

		function myFunction() 
		{
		  if (window.pageYOffset >= sticky) 
		  {
		    nav.classList.add("sticky")
		  } 
		  else 
		  {
		    nav.classList.remove("sticky");
		  }
		}*/

	</script>
	
</body>
</html>