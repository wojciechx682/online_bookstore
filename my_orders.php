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
			<!-- <a href="edit_data.php">Edytuj dane użytkownika</a><br><br> -->
			<a href="account.php"> ← </a><br><br>
			<a href="my_orders.php">Zamówienia</a>
		</div>

		<div id="content">

			<h3>Zamówienia</h3><hr>

			<?php

				echo '<script> displayNav(); </script>';

				$id_klienta = $_SESSION['id'];

				echo query("SELECT id_zamowienia, data_zlozenia_zamowienia, status FROM zamowienia WHERE id_klienta = '%s'", "get_orders", "$id_klienta");

			?>

			<br><br><a href="logout.php">[ Wyloguj ]</a>

		</div>

<?php require "template/footer.php"; ?>

	</div>
		
</body>
</html>