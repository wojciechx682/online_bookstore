<?php

	session_start();

	include_once "functions.php";
	
	// takiego ifa, należy dodać do każdej podstrony do której ma dostęp zalogowany użytkownik
	if(!isset($_SESSION['zalogowany']))
	{
			// zastanowić się, co należało by tu zrobić ? 		
		//$_SESSION['account_error'] = true; // ?

		header('Location: index.php');
		exit();
	}
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Księgarnia online</title>
	<link rel="stylesheet" href="style2.css">

	<script src="display_nav.js"></script>		

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

			<!-- <a href="edit_data.php">Edytuj dane użytkownika</a><br><br> -->

			<a href="my_orders.php"> ← </a><br><br>



			<a href="my_orders.php">Zamówienia</a>

		</div>

		<div id="content">

			<h3>Zamówienia</h3><hr>

			<?php

				echo '<script> display_nav(); </script>'; 

				//$id_klienta = $_SESSION['id'];

				//echo query("SELECT id_zamowienia, data_zlozenia_zamowienia, status FROM zamowienia WHERE id_klienta = '$id_klienta'", "get_orders", "$id_klienta");	

				// Książki, które zamówił klient o danym ID :


				if((isset($_GET['order_id']))&&(!empty($_GET['order_id'])))
				{
					echo "<br> order_id id = " . $_GET['order_id'] . "<br>";

					$order_id = $_GET['order_id'];

					echo query("SELECT id_zamowienia , id_ksiazki, ilosc FROM szczegoly_zamowienia WHERE id_zamowienia = '$order_id'", "get_order_details", "$order_id");

					echo "<hr>";
					
					$order_details_books_id = $_SESSION['order_details_books_id'];

					echo "id książek dla danego zamówienia -> <br><br>";

					for($i = 0; $i < count($order_details_books_id); $i++)
					{					 
						$book_id = $order_details_books_id[$i];
						
						echo query("SELECT tytul, cena, rok_wydania FROM ksiazki WHERE id_ksiazki = '$book_id'", "order_details_get_book", "$book_id");
					}

					
					

				}


				
			?>

			<br><br><a href="logout.php">[ Wyloguj ]</a>

		</div>		

		<div id="footer">

		</div>

	</div>
		
</body>
</html>