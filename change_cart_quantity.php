
<!-- koszyk - zmiana liczby egzemplarzy -->

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

<?php

	if((isset($_POST['id_ksiazki'])) && (isset($_POST['koszyk_ilosc'])) && !(empty($_POST['id_ksiazki'])) && !(empty($_POST['koszyk_ilosc']))

	) // dane pochodzące z koszyk_dodaj.php
	{	// && not empty		!empty

		$id_klienta = $_SESSION['id'];
		$id_ksiazki = $_POST['id_ksiazki'];
		$ilosc = $_POST['koszyk_ilosc'];

		if($ilosc < 0 || !is_numeric ($ilosc))
		{
			$ilosc = 1;
		}

			// Walidacja i sanityzacja danych wprowadzonych od użytkownika : <script>alert("yey");</script>
		$id_ksiazki = htmlentities($id_ksiazki, ENT_QUOTES, "UTF-8");
		$ilosc = htmlentities($ilosc, ENT_QUOTES, "UTF-8");

			//add_product_to_cart($id_ksiazki, $ilosc);
			//echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_all_books_search", $search_value);

		$values = array();
		array_push($values, $ilosc);
		array_push($values, $id_klienta);
		array_push($values, $id_ksiazki);


		query("UPDATE koszyk SET ilosc='%s' WHERE id_klienta='%s' AND id_ksiazki='%s'", "", $values);

			/*echo "<br> values = <br>";
			print_r($values);
			echo "<br><br>";*/



		unset($_POST['id_ksiazki']);
		unset($_POST['koszyk_ilosc']);
		unset($values);

		query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta); // funkcja count_cart_quantity - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku (aktualizacja po zmianie liczbie książek)

	}

	header('Location: koszyk.php');
	//echo '<a href="index.php?kategoria='.$_SESSION['kategoria'].'">Wróć</a>';

	//header('Location: index.php?kategoria='.$_SESSION['kategoria'].'');
	exit();

?>

<!--<script src="jquery.js"></script>-->
<script src="nieużywane pliki (projektu)/sortowanie_v2.js"></script>