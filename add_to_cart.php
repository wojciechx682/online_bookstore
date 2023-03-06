<?php

	session_start();
	
	include_once "functions.php";

	if(!(isset($_SESSION['zalogowany'])))
	{
        header("Location: index.php?login-error");
		exit();
	}
?>

<?php 

	if( (isset($_POST['id_ksiazki'])) &&      // dane pochodzące z koszyk_dodaj.php
        (isset($_POST['koszyk_ilosc'])) &&
        !(empty($_POST['id_ksiazki'])) &&
        !(empty($_POST['koszyk_ilosc']))
      )
	{

		$id_klienta = $_SESSION['id'];		
		$id_ksiazki = $_POST['id_ksiazki'];
		$ilosc = $_POST['koszyk_ilosc']; // == 1

			// Walidacja i sanityzacja danych wprowadzonych od użytkownika : <script>alert("yey");</script>
		$id_ksiazki = htmlentities($id_ksiazki, ENT_QUOTES, "UTF-8");
		$ilosc = htmlentities($ilosc, ENT_QUOTES, "UTF-8");		

			//add_product_to_cart($id_ksiazki, $ilosc);
			//echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_all_books_search", $search_value);

		$values = array();
		array_push($values, $id_klienta);
		array_push($values, $id_ksiazki);

		//array_push($values, $ilosc);
		/*echo "<br> values = <br>";
		print_r($values);
		echo "<br><br>";*/		

		$_SESSION['book_exists'] = false; // czy książka istnieje w koszyku ? (zakładamy, że nie...);		

		query("SELECT * FROM koszyk WHERE id_klienta = '%s' AND id_ksiazki = '%s'", "cart_verify_book", $values); // sprawdzenie, czy ta książka jest już w koszyku (tego klienta)  
		// -> jeśli num_rows > 0 -> przestawi $_SESSION['book_exists'] -> na true

		if($_SESSION['book_exists'] == true) // boox exists -> update book quantity
		{
			//$update_values = array();
			//array_push($update_values, $ilosc);			

			query("UPDATE koszyk SET ilosc=ilosc+'%s' WHERE id_klienta='$id_klienta' AND id_ksiazki='$id_ksiazki'
				", "", $ilosc);
		}
		else  // insert book to shopping cart
		{
			array_push($values, $ilosc);

			query("INSERT INTO koszyk (id_klienta, id_ksiazki, ilosc) VALUES ('%s', '%s', '%s')", "", $values);  
		}

		query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta); // funkcja count_cart_quantity - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku (aktualizacja po zmianie liczbie książek)

		//echo query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $id_klienta); // dodałem to wstępnie, nie wiem czy to ma tutaj pozostać

		unset($_POST['id_ksiazki']);
		unset($_POST['koszyk_ilosc']);
		unset($values);
	}
		//echo '<a href="index.php?kategoria='.$_SESSION['kategoria'].'">Wróć</a>';
	
	//header('Location: koszyk.php');
	header('Location: index.php?kategoria='.$_SESSION['kategoria'].'');
	exit();

?>

<!--<script src="jquery.js"></script>-->
<script src="nieużywane pliki (projektu)/sortowanie_v2.js"></script>