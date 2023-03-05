<?php

	session_start();
	
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true") && (!(isset($_SESSION['udanarejestracja'])))) 
	{
		header("Location: index.php");
		exit();
	}

	elseif((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true") && (isset($_SESSION['udanarejestracja'])) && ($_SESSION['udanarejestracja'] == "true")) // jeśli po pomyślnym utworzeniu nowego konta, nadal jesteśmy zalogowani na stare konto // jeśli stworzyliśmy konto, będąc zalogowanym na inne
	{
		header("Location: logout.php");
		exit();
	}
	elseif(isset($_SESSION['udanarejestracja'])) // jeśli stworzyliśmy konto (normalnie - nie będąc zalogowanym w tym czasie na inne)
	{
		//unset($_SESSION['udanarejestracja']);

		// Usuwanie zmiennych pamiętających wartości wpisane do formularza
		if (isset($_SESSION['fr_imie'])) unset($_SESSION['fr_imie']);
		if (isset($_SESSION['fr_nazwisko'])) unset($_SESSION['fr_nazwisko']);
		if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
		if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
		if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
		if (isset($_SESSION['fr_miejscowosc'])) unset($_SESSION['fr_miejscowosc']);
		if (isset($_SESSION['fr_ulica'])) unset($_SESSION['fr_ulica']);
		if (isset($_SESSION['fr_numer_domu'])) unset($_SESSION['fr_numer_domu']);
		if (isset($_SESSION['fr_kod_pocztowy'])) unset($_SESSION['fr_kod_pocztowy']);
		if (isset($_SESSION['fr_kod_miejscowosc'])) unset($_SESSION['fr_kod_miejscowosc']);
		if (isset($_SESSION['fr_telefon'])) unset($_SESSION['fr_telefon']);		
		if (isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);
		
		// Usuwanie błędów rejestracji
		if (isset($_SESSION['e_imie'])) unset($_SESSION['e_imie']);
		if (isset($_SESSION['e_nazwisko'])) unset($_SESSION['e_nazwisko']);
		if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
		if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
		if (isset($_SESSION['e_miejscowosc'])) unset($_SESSION['e_miejscowosc']);
		if (isset($_SESSION['e_ulica'])) unset($_SESSION['e_ulica']);
		if (isset($_SESSION['e_numer_domu'])) unset($_SESSION['e_numer_domu']);
		if (isset($_SESSION['e_kod_pocztowy'])) unset($_SESSION['e_kod_pocztowy']);
		if (isset($_SESSION['e_kod_miejscowosc'])) unset($_SESSION['e_kod_miejscowosc']);
		if (isset($_SESSION['e_telefon'])) unset($_SESSION['e_telefon']);
		if (isset($_SESSION['e_kod_miejscowosc'])) unset($_SESSION['e_kod_miejscowosc']);		
		if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
		if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);

		if (isset($_SESSION['blad'])) unset($_SESSION['blad']);
	}




	include_once "functions.php"; // _once - sprawdzi, czy ten plik nie został zaincludowany wcześniej

	//query("", "", "");




	//echo $_SESSION['login'] . '<br>';

	/*if(isset($_SESSION['zalogowany']))
	{
		//echo '<br>'.$_SESSION['account_error'];
		unset($_SESSION['account_error']);
		//exit();
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

</head>

<body>

	<div id="header-container">
		
		<!-- <div id="header_content"> -->

			<div id="sticky">

				<div id="top-header">

					<div id="top-header-content">

						<div id="header-title">
							
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

					<div id="header-content">

						<!-- <a href="index.php">Strona główna</a> -->

						 <div id="div-search">

							<form action="index.php" method="get">
								
								<input type="search" name="input_search">

								<input type="submit" value="Szukaj">

							</form>	

						</div>

						<div id="div-logo">
							
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

						<div id="div-cart">
							
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

			<div id="top-nav">
				
				<div id="top-nav-content">

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

			<!-- Formularz Logowania -->

			Księgarnia online<br><br>
			
			<form action="logowanie.php" method="post">
			
				<!-- Login: <br> <input type="text" name="login"> <br> -->
				E-mail: <br> <input type="text" name="email" value="jason1@wp.pl"> <br>
				Hasło: <br> <input type="password" name="haslo"> <br><br>
				
				<input type="submit" value="Zaloguj się">	
					
			</form>
			
			<br><a href="zarejestruj.php">Rejestracja - załóż darmowe konto!</a><br>

			<?php	
				// pokazujemy zawartość tej zmiennej tylko jeśli podano nieprawidłowy login lub hasło ! 
				// czyli, tylko wtedy, gdy taka zmienna ISTNIEJE W SESJI
				
				if(isset($_SESSION['blad']))
				{
					echo '<br>'.$_SESSION['blad'];
				}			
			?>

			<?php 

				if(isset($_SESSION['udanarejestracja']))
				{
					unset($_SESSION['udanarejestracja']);
					
					echo '<br><span style="color: blue;">Rejestracja przebiegła pomyślnie - od teraz możesz zalogować się na swoje konto</span><br>';



				}	

			?>



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