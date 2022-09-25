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

		$_SESSION['book_exists'] = false; // książka istnieje w koszyku;		

		query("SELECT * FROM koszyk WHERE id_klienta = '%s' AND id_ksiazki = '%s'", "cart_verify_book", $values);	// sprawdzenie, czy ta książka jest już w koszyku (tego klienta)  -> num_rows > 0 ?

		if($_SESSION['book_exists'] == true) // boox exists -> update book quantity
		{
			//$update_values = array();
			//array_push($update_values, $ilosc);			

			query("UPDATE koszyk SET ilosc=ilosc+'%s' WHERE id_klienta='$id_klienta' AND id_ksiazki='$id_ksiazki'
				", "", $ilosc);
		}
		else  // insert book to cart
		{
			array_push($values, $ilosc);

			query("INSERT INTO koszyk (id_klienta, id_ksiazki, ilosc) VALUES ('%s', '%s', '%s')", "", $values);  
		}

		

		//echo query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $id_klienta); // dodałem to wstępnie, nie wiem czy to ma tutaj pozostać

		unset($_POST['id_ksiazki']);
		unset($_POST['koszyk_ilosc']);
		unset($values);
		
	}

	header('Location: koszyk.php');
	exit();

?>

<script src="jquery.js"></script>
<script src="sortowanie_v2.js"></script>