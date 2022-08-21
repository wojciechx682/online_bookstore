<?php

	session_start();

	include_once "functions.php";	
	
	if(!(isset($_SESSION['zalogowany'])))
	{
		header('Location: index.php');
		exit();
	}
?>


<?php

	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Księgarnia online</title>
	<link rel="stylesheet" href="style.css">

	<script src="display_nav.js"></script>		

	<script>


	</script>

</head>

<body>

	<div id="header_container">
		
		<!-- <div id="header_content"> -->

			<div id="top_header">

				<div id="top_header_content">

					<div id="header_title">
						
						Księgarnia internetowa

					</div>		
					
					<!--<div id="div_register">
						
						<a class="top-nav-right" href="rejestracja.php">Zarejestruj</a>
						
					</div> -->

					<!-- <div id="div_log_in">
						
						<a class="top-nav-right" href="zaloguj.php">Zaloguj</a>

					</div> -->

					<ol>	

						<li>
							<a href="rejestracja.php">Zarejestruj</a>
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
							
							<a class="top-nav-right" href="rejestracja.php">Zarejestruj</a>
							
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

			<a href="edit_data.php">Edytuj dane użytkownika</a><br><br>

			<a href="my_orders.php">Zamówienia</a>

		</div>

		<div id="content">

			<h2 style="margin-top: 0px; margin-bottom: 0px;">Moje konto</h2><hr>

			<div class="dane_konta">
				
				Dane konta <hr>

				<div class="edit_data_container">

					<div id="edit_data_left">

						<div class="edit_data_left"> Imię </div> 
						<div class="edit_data_left"> Nazwisko </div> 
						<div class="edit_data_left"> E-mail </div> 
						<div class="edit_data_left"> Telefon </div> 			

					</div>

					<div id="edit_data_right">
						
						<form id="edit_data_form" action="validate_user_data.php" method="post">

							<?php

								echo '<div class="edit_data_right"><input type="text" id="imie_edit" name="imie_edit" value="'.$_SESSION['imie'].'"></div>';
								echo '<div class="edit_data_right"><input type="text" id="nazwisko_edit" name="nazwisko_edit" value="'.$_SESSION['nazwisko'].'"></div>';
								echo '<div class="edit_data_right"><input type="text" id="email_edit" name="email_edit" value="'.$_SESSION['email'].'"></div>';
								echo '<div class="edit_data_right"><input type="text" id="telefon_edit" name="telefon_edit" value="'.$_SESSION['telefon'].'"></div>';

							?>

						</form>

					</div>

					<div style="clear: both;"></div>					

					<div id="edit_data_button">
						
						<button type="submit" form="edit_data_form">Edytuj dane</button>

					</div>

					<?php

						//if((isset($validation)) && ($validation == false) && (isset($_SESSION['error_form'])))
						if((isset($_SESSION['error_form'])))
						{
							echo $_SESSION['error_form'];
							unset($_SESSION['error_form']);
						}
						else
						{
							if((isset($_SESSION['validation_passed'])) && ($_SESSION['validation_passed'] == true))
							{
								echo "Dane zostały zmienione";
								unset($_SESSION['validation_passed']);
							}
						}
					?>

				</div>

				<div id="edit_content">
				
					

				</div>				

			</div>

			<div style="clear: both;"></div>

			<div class="dane_konta">

				Hasło <hr>

				<div class="edit_data_container">					

					<div id="edit_data_left">

							<div class="edit_data_left"> Stare hasło </div> 	
							<div class="edit_data_left"> Nowe hasło </div> 	
							<div class="edit_data_left"> Powtorz hasło </div> 	

					</div>

					<div id="edit_data_right">
							
							<form id="edit_password_form" action="validate_password.php" method="post">

								<?php

									echo '<div class="edit_data_right"><input type="password" id="stare_haslo_edit" name="stare_haslo_edit" "></div>';
									echo '<div class="edit_data_right"><input type="password" id="nowe_haslo_edit" name="nowe_haslo_edit" "></div>';
									echo '<div class="edit_data_right"><input type="password" id="powtorz_haslo_edit" name="powtorz_haslo_edit" "></div>';						

								?>

							</form>

					</div>

					<div style="clear: both;"></div>					

					<div id="edit_data_button">
						
						<button type="submit" form="edit_password_form">Edytuj dane</button>

					</div>


					<?php

						if((isset($_SESSION['validation_password'])) && ($_SESSION['validation_password'] == false) && (isset($_SESSION['error_form_password'])))
						{
							echo $_SESSION['error_form_password'];
							unset($_SESSION['error_form_password']);
						}
						else
						{
							if((isset($_SESSION['validation_passed_p'])) && ($_SESSION['validation_passed_p'] == true))
							{
								echo "Hasło zostało zmienione";
								unset($_SESSION['validation_passed_p']);
							}
						}
					?>

				</div>

			</div>

			
















			<?php		
		
				echo '<script> display_nav(); </script>'; 

				/*echo "<p>Witaj ".$_SESSION['login'].'!' ;				
				
				echo "<p><b>Imię</b>: ".$_SESSION['imie'];
				echo "<p><b>Nazwisko</b>: ".$_SESSION['nazwisko'];
				echo "<p><b>Miejscowosc</b>: ".$_SESSION['miejscowosc'];
				echo "<p><b>Ulica</b>: ".$_SESSION['ulica'];
				echo "<p><b>numer_domu</b>: ".$_SESSION['numer_domu'];
				echo "<p><b>kod_pocztowy</b>: ".$_SESSION['kod_pocztowy'];
				echo "<p><b>kod_miejscowosc</b>: ".$_SESSION['kod_miejscowosc'];
				echo "<p><b>wojewodztwo</b>: ".$_SESSION['wojewodztwo'];
				echo "<p><b>kraj</b>: ".$_SESSION['kraj'];
				echo "<p><b>PESEL</b>: ".$_SESSION['PESEL'];
				echo "<p><b>data_urodzenia</b>: ".$_SESSION['data_urodzenia'];
				echo "<p><b>telefon</b>: ".$_SESSION['telefon'];
				echo "<p><b>email</b>: ".$_SESSION['email'];*/
			?>

			<!-- <br><br><a href="logout.php">[ Wyloguj ]</a> -->

		</div>		

		<div id="footer">

		</div>

	</div>
		
</body>
</html>