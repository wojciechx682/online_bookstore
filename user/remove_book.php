<?php
		// koszyk.php - usunięcie książki ;
	session_start();
	include_once "../functions.php";

if( ! isset($_SESSION['zalogowany']) ) {

	$_SESSION["login-error"] = true;
	header("Location: ___zaloguj.php");
	exit();
}

	if(
		isset($_POST['id_ksiazki']) /*&&
		isset($_POST['id_klienta']) &&
		isset($_POST['ilosc'])*/ &&
		! empty($_POST["id_ksiazki"])

	)
	{
		$id_klienta = $_SESSION['id'];

		$id_ksiazki = filter_input(INPUT_POST, "id_ksiazki", FILTER_SANITIZE_NUMBER_INT);

			// $id_ksiazki = $_POST['id_ksiazki'];
			/*$ilosc = $_POST['ilosc'];*/

			/*$id_klienta = htmlentities($id_klienta, ENT_QUOTES, "UTF-8");
			$id_ksiazki = htmlentities($id_ksiazki, ENT_QUOTES, "UTF-8");
			$ilosc = htmlentities($ilosc, ENT_QUOTES, "UTF-8");
			$id_klienta = strip_tags($id_klienta);
			$id_ksiazki = strip_tags($id_ksiazki);
			$ilosc = strip_tags($ilosc);*/

		$cart = [$id_klienta, $id_ksiazki];

		query("DELETE FROM koszyk 
					 WHERE id_klienta='%s' AND 
					       id_ksiazki='%s'", "", $cart);

		unset($_POST['id_ksiazki']);
		unset($cart);

		query("SELECT SUM(ilosc) AS suma 
					 FROM koszyk
					 WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta);
					 // funkcja count_cart_quantity - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku (aktualizacja po usunięciu książki);

	}

	header('Location: ___koszyk.php');
	exit();
?>
