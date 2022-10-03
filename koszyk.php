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

	</script>


	<script src="change_quantity.js"></script> 

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
							
							<a class="top-nav-right" href="koszyk.php">Koszyk

								<?php 
									if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true")) 
									{												
										echo "(".$_SESSION['koszyk_ilosc_ksiazek'].")";										
									}
								?>
							</a>				
														
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

				if(isset($_GET['kategoria']))  // DO USUNIĘCIA
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

				// DO WYRZUCENIA - zamiast tego jest add_to_cart.php
				if((isset($_POST['id_ksiazki'])) && (isset($_POST['koszyk_ilosc'])) && !(empty($_POST['id_ksiazki'])) && !(empty($_POST['koszyk_ilosc']))
                    
				) // dane pochodzące z koszyk_dodaj.php
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

					query("INSERT INTO koszyk (id_klienta, id_ksiazki, ilosc) VALUES ('%s', '%s', '%s')", "", $values); 



					//echo query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $id_klienta); // dodałem to wstępnie, nie wiem czy to ma tutaj pozostać

					unset($_POST['id_ksiazki']);
					unset($_POST['koszyk_ilosc']);

					//header('Location: koszyk.php');
					
					//header("Refresh:0");

					//exit();

					//exit();
				}
				else
				{
					//get_product_from_cart($_SESSION['id']);

					$id_klienta = $_SESSION['id'];

					// Książki które zamówił klient o danym ID : 

					query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $id_klienta);
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