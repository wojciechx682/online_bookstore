<?php

	session_start();
	
	include_once "functions.php"; // _once - sprawdzi, czy ten plik nie został zaincludowany wcześniej

	// sprawdź połączenie z BD :

	query("", "", ""); // w przypadku błędu połączenia z BD, wyświetli komunikat rzuconego wyjątku.	
	// należy dodać to do każdej podstrony, która korzysta z połączenia z bd


	//echo $_SESSION['login'] . '<br>';

	/*if(isset($_SESSION['zalogowany']))
	{
		//echo '<br>'.$_SESSION['account_error'];
		unset($_SESSION['account_error']);
		//exit();
	}	*/	

	/*if(isset($_SESSION['blad'])) {
		echo $_SESSION['blad'];
		exit();
	}*/
?>



<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Księgarnia online</title>

	<link rel="stylesheet" href="style2.css">	

	<!-- <script src="sortowanie_v1.js"></script>	-->
	
	<script src="display_nav.js"></script> <!-- skrypt - wyświetla nav -->

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
						
						<!-- <div id="div_register">
							
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
						
						<li>
							<a href="index.php">Strona główna</a>
							<div id="test_div"></div>

						</li>
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
									echo query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories", ""); // top_nav - wypis kategorii - wewnątrz listy rozwijanej ul
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

			<?php 

				if((isset($_GET['kategoria'])) && (!empty($_GET['kategoria']))) 
				{
					$kategoria = $_GET['kategoria']; // <- przyczyna błędu. (już naprawionego ...)		
					
					// Sanityzacja danych wprowadzonych od użytkownika :  	
					$kategoria = htmlentities($kategoria, ENT_QUOTES, "UTF-8"); // html entities = encje html'a;    // $kategoria = '<script>alert("hahaha");</script>;					
										
					echo "<b>".$kategoria."</b><hr>";									
				}

			?>		

			<!-- <h3> Sortuj wg </h3> -->				
			<h3> Sortowanie </h3>	

				<!-- <h3> Sortuj wg </h3> -->				

				<select id="sortuj_wg" >
					<option value="1">ceny rosnąco</option>
					<option value="2">ceny malejąco</option>
					<option value="3">nazwy A-Z</option>
					<option value="4">nazwy Z-A</option>
					<option value="5">Najnowszych</option>
					<option value="6">Najstarszych</option>
				</select>				

				<br><br><button id="sort_button" onclick="sortuj()">Sortuj</button>				

				<br><br>

				<!-- 
					<input id="title_radio" type="radio" name="sortuj_wg" value="tytul">
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

					<br>
					<button id="sortowanie" onclick="sortuj()">Sortuj</button> 
				-->
				
		</div>

		<div id="content">				

			<?php					

				echo "<hr>";				

				if((isset($_GET['kategoria'])) && !(empty($_GET['kategoria']))) // <a href="index.php?kategoria=Wszystkie">Wszystkie</a>
				{									
					echo '<script> display_nav(); </script>'; // Wywołanie funkcji w skrypcie display_nav.js - wyświetla nav (nawigację) po lewej stroenie -->

					$kategoria = $_GET['kategoria']; 					
					
					$kategoria = htmlentities($kategoria, ENT_QUOTES, "UTF-8"); // html entities = encje html'a	// Sanityzacja danych wprowadzonych od użytkownika :  				
										
					echo '<div id="content_books">';					
					
					if($kategoria == "Wszystkie") 	// ($_GET kategoria) -> Kategoria = "Wszystkie"
					{							
						echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki", "get_books", ""); // get_all_books();							
					}
					else    								// ($_GET kategoria) -> Kategoria = "Dla dzieci" , :Fantastyka", "Informatyka", ...
					{
						echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '%s'", "get_books", $kategoria);							

						/*

							($result = $polaczenie->query(sprintf("UPDATE klienci SET imie='%s', nazwisko='%s', miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s', wojewodztwo='%s', kraj='%s', PESEL='%s', data_urodzenia='%s', telefon='%s', email='%s', login='%s' WHERE id_klienta='$id'", mysqli_real_escape_string($polaczenie, $imie), mysqli_real_escape_string($polaczenie, $nazwisko), mysqli_real_escape_string($polaczenie, $miasto), mysqli_real_escape_string($polaczenie, $ulica), mysqli_real_escape_string($polaczenie, $numer_domu), mysqli_real_escape_string($polaczenie, $kod_pocztowy), mysqli_real_escape_string($polaczenie, $kod_miejscowosc), mysqli_real_escape_string($polaczenie, $wojewodztwo), mysqli_real_escape_string($polaczenie, $kraj), mysqli_real_escape_string($polaczenie, $pesel), mysqli_real_escape_string($polaczenie, $data_urodzenia), mysqli_real_escape_string($polaczenie, $telefon), mysqli_real_escape_string($polaczenie, $email), mysqli_real_escape_string($polaczenie, $login) )))

						*/
					}						

					echo '</div>';					
				}
				else // jeśli nie ustawiono kategorii ... nie ustawiono! ($_GET kategoria) -> $Kategoria  
				{				
					if((isset($_GET['input_search'])) && (!empty($_GET['input_search']))) // pole wyszukiwania
					{		
						echo '<script> display_nav(); </script>'; 
						echo '<div id="content_books">';

						$search_value = $_GET['input_search'];				
						
						$search_value = htmlentities($search_value, ENT_QUOTES, "UTF-8"); // html entities = encje html'a // Sanityzacja danych wprowadzonych od użytkownika :  	<script>alert("yey");</script>	
						
						echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_books", $search_value);						
						echo '</div>';

					}
					else if((isset($_GET['input_search'])) && (empty($_GET['input_search'])))
					{	
						echo '<script> display_nav(); </script>'; 
						echo '<div id="content_books">';
						echo '<h3>Brak wyników</h3>';

						echo '</div>';
					}	
					else
					{
						//////////////////////////////////////////////////////////////////////////////////////////////////
						// STRONA GŁÓWNA //
						//////////////////////////////////////////////////////////////////////////////////////////////////

						//echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki", "get_all_books", "");
						//echo $_SESSION['blad'];

					}					

				}

			?>	

			<!-- Storna główna -->

			<!-- //////////////////////////////////////////////////////////////////////////////////////////////////
				 // STRONA GŁÓWNA //
				 ////////////////////////////////////////////////////////////////////////////////////////////////// -->

				 asdas

		</div>		

		<div id="footer">
			
		</div>

	</div>	

	<script src="jquery.js"></script>
	<script src="sortowanie_v2.js"></script>	
</body>
</html>