<?php

	// koszyk - usunięcie książki
	
	session_start();

	include_once "functions.php";			

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

		//query("UPDATE koszyk SET ilosc=ilosc+'%s' WHERE id_klienta='$id_klienta' AND id_ksiazki='$id_ksiazki'", "", $ilosc);

		$values = array();
		array_push($values, $id_klienta);
		array_push($values, $id_ksiazki);
		array_push($values, $ilosc);		

		query("DELETE FROM koszyk WHERE id_klienta='%s' AND id_ksiazki='%s'", "", $values);

		query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta); // funkcja count_cart_quantity - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku (aktualizacja po usunięciu książki)

		header('Location: koszyk.php');
		exit();
	}

?>
