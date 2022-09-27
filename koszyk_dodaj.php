<?php

	session_start();
	
	include_once "functions.php"; // _once - sprawdzi, czy ten plik nie został zaincludowany wcześniej	

	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}	

	/*if(isset($_SESSION['account_error']))
	{
		//echo '<br>'.$_SESSION['account_error'];
		echo '<script>alert("Musisz być zalogowanym aby przeglądać swoje konto!")</script>';
		//exit();
	}*/	

	

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Księgarnia online</title>
	<link rel="stylesheet" href="style2.css">

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
							<div id="test123"></div>

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

			<h3> Kategorie </h3>
			<hr>

			<?php
				//include_once "functions.php";
				echo query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories", ""); // nav - wypis kategorii	
				echo "<hr>";				
			?>

			<h3> Sortuj wg </h3>

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
					if(isset($_GET['kategoria']))
					{
						echo '<input type="hidden" name="kategoria" value="'.$_GET['kategoria'].'">';
					}					
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

			</form>	 -->	

		</div>

		<div id="content">

			<h3>Dodaj do koszyka</h3>

			<?php			

				echo "<hr>";

				if(isset($_GET['id'])) // id_książki
				{	
					$id_ksiazki = $_GET['id']; // <- przyczyna błędu. (już naprawionego ...)

					$id_ksiazki = htmlentities($id_ksiazki, ENT_QUOTES, "UTF-8"); 

					//$_SESSION['kategoria'] = "Horror";
					//$kategoria = $_SESSION['kategoria'];

					if(!is_numeric($id_ksiazki) || ($id_ksiazki < 1)) // jeśli $_GET['id'] nie jest liczbą
					{
						echo "Niepoprawny produkt<br>";						
						echo '<a href="index.php?kategoria='.$_SESSION['kategoria'].'">Wróć</a>';
						exit();
					}						

					echo "id_ksiazki -> ".$id_ksiazki."<br>";									
					
					echo "<br>lp." . " 1 <br><br>"; 

					echo "<b>Produkt: </b> ";
					echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE id_ksiazki='%s'", "get_books_by_id", "$id_ksiazki");	// wyświetla produkt (tyul, cena, rok_wydania)

					///////////////////////////////////////////////////////////////////////////

					echo '<form action="add_to_cart.php" method="post">';

							echo '<input type="hidden" name="id_ksiazki" value="'.$id_ksiazki.'">';

							echo "<b>Ilosc: </b> ";

							/*echo '<select name="koszyk_ilosc">';
							    echo '<option value="1">1</option>';
							    echo '<option value="2">2</option>';
							    echo '<option value="3">3</option>';
							    echo '<option value="4">4</option>';
							    echo '<option value="5">5</option>';
							echo '</select>';*/

							echo '<input type="text" id="koszyk_ilosc" name="koszyk_ilosc" value="1">';

							echo '<button type="button" onclick="increase()">+</button>';
							echo '<button type="button" onclick="decrease()">-</button>';


							echo '<br><br><input type="submit" value="Zapisz koszyk">';

					echo '</form>';













				}
			?>	

			

			<?php

				/*if((isset($_POST['id_ksiazki'])) and (isset($_POST['ilosc'])))
				{
					echo "<br> id_ksiazki -> ".$id_ksiazki.'<br>';
					echo "<br> ilosc -> ".$ilosc.'<br>';
				}*/
			?>


			<?php

				/*if((isset($_POST['koszyk_ilosc']))   ) 
				{
					echo '<script>alert("940")</script>';
					echo "<br> 929 id_ksiazki -> ".$_POST['id_ksiazki'].'<br>';
					echo "<br> ilosc -> ".$_POST['koszyk_ilosc'].'<br>';
				}*/

			?>



		</div>		

		<div id="footer">

		</div>

	</div>


	
	
</body>
</html>