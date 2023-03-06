<?php
	session_start();
	include_once "functions.php";
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
?>


<!DOCTYPE HTML>
<html lang="pl">

<?php require "template/head.php"; ?>

<body>

<?php require "template/header-container.php"; ?>

	<div id="container">		

		<div id="nav">

			<a href="my_orders.php"> ← </a><br><br>

			<a href="my_orders.php">Zamówienia</a>

		</div>

		<div id="content">

			<h3>Zamówienia</h3><hr>

			<?php

				echo '<script> displayNav(); </script>';

				//$id_klienta = $_SESSION['id'];

				//echo query("SELECT id_zamowienia, data_zlozenia_zamowienia, status FROM zamowienia WHERE id_klienta = '%s'", "get_orders", "$_SESSION["id"]"); // Książki, które zamówił klient o danym ID

				if((isset($_GET['order_id']))&&(!empty($_GET['order_id'])))
				{
					echo "<br> order_id id = " . $_GET['order_id'] . "<br>";

                    $order_id = htmlentities($_GET['order_id'], ENT_QUOTES, "UTF-8");

                    query("SELECT id_zamowienia , id_ksiazki, ilosc FROM szczegoly_zamowienia WHERE id_zamowienia = '%s'", "get_order_details", "$order_id");

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