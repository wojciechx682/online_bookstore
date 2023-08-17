
<!-- koszyk.php - AJAX - zmiana liczby egzemplarzy -->

<?php
    // check if user is logged-in, and user-type is "client" - if not, redirect to login page ;
    require_once "../authenticate-user.php";
?>

<?php

// przejście tutaj następuje po wysłaniu formularza (np. przyciskiem ENTER), w którym jest <input> z ilością książek w koszyku.
// dane pochodzące z koszyk.php;
// && not empty; !empty

	if(isset($_POST['book-id']) && !empty($_POST['book-id']) &&
        isset($_POST['book-amount']) && !empty($_POST['book-amount']) ) {

        $bookId = filter_input(INPUT_POST, "book-id", FILTER_SANITIZE_NUMBER_INT);
        $bookAmount = filter_input(INPUT_POST, "book-amount", FILTER_SANITIZE_NUMBER_INT);

		if($bookAmount < 0 || !is_numeric($bookAmount) || $bookAmount == false) {
			$ilosc = 1;
		}

        $book = [$bookAmount, $_SESSION['id'], $bookId];

		query("UPDATE koszyk 
                     SET ilosc='%s' 
                     WHERE id_klienta='%s' AND 
                           id_ksiazki='%s'", "", $book);

        unset($_POST['id_ksiazki']);
		unset($_POST['koszyk_ilosc']);
		unset($book);
	}

    exit();
?>