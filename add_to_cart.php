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

    // insert book into shopping cart

	if(
        (isset($_POST['id_ksiazki'])) &&      // dane pochodzące z formularza (index.php) po kliknięciu "Dodaj do koszyka"
        (isset($_POST['koszyk_ilosc'])) &&

        !(empty($_POST['id_ksiazki'])) &&    // 23
        !(empty($_POST['koszyk_ilosc']))     //  1
      )
	{
		$id_klienta = $_SESSION['id'];
		$id_ksiazki = $_POST['id_ksiazki']; // user może wpr. dowolną wartość zmieniając atrybut "value" w <input> ...
		$ilosc = $_POST['koszyk_ilosc'];    // 1

        // echo "<br>id_klienta -> ".$id_klienta."<br>";
        // echo "<br>id_ksiazki -> ".$id_ksiazki."<br>";

        $id_ksiazki = htmlentities($id_ksiazki, ENT_QUOTES, "UTF-8"); // walidacja i sanityzacja danych wprowadzonych od użytkownika
        $ilosc = htmlentities($ilosc, ENT_QUOTES, "UTF-8");           // <script>alert("yey");</script>

        $book = [$id_klienta, $id_ksiazki]; // Array ( [0] => 1 [1] => 16 )

		$_SESSION['book_exists'] = false;   // book already in shopping cart ? let's assume that it isn't ...

		query("SELECT * FROM koszyk WHERE id_klienta = '%s' AND id_ksiazki = '%s'", "cart_verify_book", $book); // sprawdzenie, czy ta książka jest już w koszyku tego klienta; jeśli num_rows > 0 -> przestawi $_SESSION['book_exists'] -> na true

        $book[0] = $ilosc;
        $book[1] = $id_klienta;
        $book[2] = $id_ksiazki;

		if($_SESSION['book_exists'] == true) // boox exists ? update book quantity
		{
			query("UPDATE koszyk SET ilosc=ilosc+'%s' WHERE id_klienta='%s' AND id_ksiazki='%s'", "", $book);
		}
		else                                 // insert book to shopping cart
		{
			query("INSERT INTO koszyk (ilosc, id_klienta, id_ksiazki) VALUES ('%s', '%s', '%s')", "", $book);
		}

		query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta);
        // funkcja count_cart_quantity - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku (aktualizacja po zmianie liczbie książek)

		unset($_POST['id_ksiazki']);
		unset($_POST['koszyk_ilosc']);
		unset($book);
		unset($_SESSION['book_exists']);
	}
	
	//header('Location: koszyk.php');
	header('Location: index.php?kategoria='.$_SESSION['kategoria'].'');
	exit();

?>

<!--<script src="jquery.js"></script>-->
<!--<script src="nieużywane pliki (projektu)/sortowanie_v2.js"></script>-->