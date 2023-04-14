<?php

	// koszyk.php - usunięcie książki
	
	session_start();

	include_once "../functions.php";

	if(
		(isset($_POST['id_klienta'])) &&
		(isset($_POST['id_ksiazki'])) &&
		(isset($_POST['ilosc']))
	)
	{
		$id_klienta = $_POST['id_klienta'];
		$id_ksiazki = $_POST['id_ksiazki'];
		$ilosc = $_POST['ilosc'];

			$id_klienta = htmlentities($id_klienta, ENT_QUOTES, "UTF-8");
			$id_ksiazki = htmlentities($id_ksiazki, ENT_QUOTES, "UTF-8");
			$ilosc = htmlentities($ilosc, ENT_QUOTES, "UTF-8");
			$id_klienta = strip_tags($id_klienta);
			$id_ksiazki = strip_tags($id_ksiazki);
			$ilosc = strip_tags($ilosc);

		$cart = [$id_klienta, $id_ksiazki, $ilosc];

		query("DELETE FROM koszyk WHERE id_klienta='%s' AND id_ksiazki='%s'", "", $cart);

		query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta); // funkcja count_cart_quantity - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku (aktualizacja po usunięciu książki)

		header('Location: ___koszyk.php');
		exit();
	}

?>
