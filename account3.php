<?php

	/*session_start();	

	include_once "functions.php";	
	
	if(!(isset($_SESSION['zalogowany'])))
	{
		header('Location: index.php');
		exit();
	}*/
?>
<div id="nav">			

	<a href="edit_data.php">Edytuj dane użytkownika</a><br><br>

	<a href="my_orders.php">Zamówienia</a><br><br>

	<a href="logout.php"> [ Wyloguj ]</a>

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
