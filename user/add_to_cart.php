<?php
	session_start();
	include_once "../functions.php";
	if(!(isset($_SESSION['zalogowany']))) {
        header("Location: ___index2.php?login-error");
		exit();
	}
?>

<?php

	if( (isset($_POST['id_ksiazki'])) &&     // insert book into shopping cart
        (isset($_POST['koszyk_ilosc'])) &&   // dane pochodzące z formularza (index.php) po kliknięciu "Dodaj do koszyka"
        !(empty($_POST['id_ksiazki'])) &&    // 23
        !(empty($_POST['koszyk_ilosc']))     //  1
      )
	{
		$id_klienta = filter_var($_SESSION['id'], FILTER_SANITIZE_NUMBER_INT);

		/*$id_ksiazki = $_POST['id_ksiazki']; // user może wpr. dowolną wartość zmieniając atrybut "value" w <input> ...
		$ilosc = $_POST['ko szyk_ilosc'];    // 1
			$id_ksiazki = htmlentities($id_ksiazki, ENT_QUOTES, "UTF-8"); // walidacja i sanityzacja danych wprowadzonych od użytkownika
			$ilosc = htmlentities($ilosc, ENT_QUOTES, "UTF-8");           // <script>alert("yey");</script>
			$id_ksiazki = strip_tags($id_ksiazki);
			$ilosc = strip_tags($ilosc);*/

		$id_ksiazki = filter_input(INPUT_POST, "id_ksiazki", FILTER_SANITIZE_NUMBER_INT); // to remove any non-numeric characters. This filter will leave only the numeric characters.
		$ilosc = filter_input(INPUT_POST, "koszyk_ilosc", FILTER_SANITIZE_NUMBER_INT);

			if($ilosc < 0 || !is_numeric ($ilosc))
			{
				$ilosc = 0;
			}

        $book = [$id_klienta, $id_ksiazki];

		$_SESSION['book_exists'] = false;   // book already in shopping cart ? let's assume that it isn't ...

		query("SELECT * FROM koszyk WHERE id_klienta = '%s' AND id_ksiazki = '%s'", "cart_verify_book", $book);
        // sprawdzenie, czy ta książka jest już w koszyku tego klienta; jeśli num_rows > 0 -> przestawi $_SESSION['book_exists'] -> na true

        $book[0] = $ilosc;
        $book[1] = $id_klienta;
        $book[2] = $id_ksiazki;

		if($_SESSION['book_exists'] == true) {                         // boox exists ? update book quantity
			//print_r($book); exit();
			query("UPDATE koszyk SET ilosc=ilosc+'%s' WHERE id_klienta='%s' AND id_ksiazki='%s'", "", $book);
		} else {               										   // insert book to shopping cart
			query("INSERT INTO koszyk (ilosc, id_klienta, id_ksiazki) VALUES ('%s', '%s', '%s')", "", $book);
		}

		query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta);
        // funkcja count_cart_quantity - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku (aktualizacja po zmianie liczbie książek)

        unset($book);
		unset($_POST['id_ksiazki']);
		unset($_POST['koszyk_ilosc']);
		unset($_SESSION['book_exists']);
	}

	header('Location: ___koszyk.php');
	//header('Location: index.php?kategoria='.$_SESSION['kategoria'].'');
	exit();
?>

