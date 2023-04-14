
<!-- koszyk - zmiana liczby egzemplarzy -->

<?php
	session_start();
	include_once "../functions.php";
	if(!(isset($_SESSION['zalogowany']))) {
		header('Location: ___index2.php');
		exit();
	}
?>

<?php

	if(
        (isset($_POST['id_ksiazki'])) &&    // przejście tutaj następuje po wysłaniu formularza (np. przyciskiem ENTER), w którym jest <input> z ilością książek w koszyku.
        (isset($_POST['koszyk_ilosc'])) &&  // dane pochodzące z koszyk.php

        !(empty($_POST['id_ksiazki'])) &&   // && not empty  !empty
        !(empty($_POST['koszyk_ilosc']))
      )
	{
		$id_klienta = $_SESSION['id'];
		$id_ksiazki = $_POST['id_ksiazki'];
		$ilosc = $_POST['koszyk_ilosc'];

		if($ilosc < 0 || !is_numeric ($ilosc))
		{
			$ilosc = 1;
		}

            // walidacja i sanityzacja danych wprowadzonych od użytkownika; <script>alert("yey");</script>
            $id_ksiazki = htmlentities($id_ksiazki, ENT_QUOTES, "UTF-8");
            $ilosc = htmlentities($ilosc, ENT_QUOTES, "UTF-8");
            $id_ksiazki = strip_tags($id_ksiazki);
            $ilosc = strip_tags($ilosc);

        $book = [$ilosc, $id_klienta, $id_ksiazki];

		query("UPDATE koszyk SET ilosc='%s' WHERE id_klienta='%s' AND id_ksiazki='%s'", "", $book);

        unset($_POST['id_ksiazki']);
		unset($_POST['koszyk_ilosc']);
		unset($book);

		query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta); // funkcja count_cart_quantity - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku (aktualizacja po zmianie liczbie książek)
	}

	header('Location: ___koszyk.php');
	//echo '<a href="index.php?kategoria='.$_SESSION['kategoria'].'">Wróć</a>';
	//header('Location: index.php?kategoria='.$_SESSION['kategoria'].'');
	exit();
?>