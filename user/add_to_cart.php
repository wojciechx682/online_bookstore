<?php
	// check if user is logged-in, and user-type is "client" - if not, redirect to login page ;
	require_once "../authenticate-user.php";
?>

<?php

	// insert book into shopping cart;
	// dane pochodzące z formularza (index.php / book.php) po kliknięciu "Dodaj do koszyka";
	// "23" - id książki ;
	//  "1" - ilość egzemplarzy, która ma zostać dodana do koszyka ;

	if ( isset($_POST['book-id']) && !empty($_POST['book-id']) &&
		 isset($_POST['book-amount']) && !empty($_POST['book-amount']) ) {

		/*echo "<br> post book-id --> <br>" . $_POST["book-id"] . "<br>";
		echo "<br> post book-id --> <br>" . $_POST['book-amount'] . "<br>"; exit();*/

		// validate, sanitize book-id;

		$bookId = filter_input(INPUT_POST, "book-id", FILTER_SANITIZE_NUMBER_INT); // "35" or FALSE;
			// remove any non-numeric characters. This filter will leave only the numeric characters.

		// get highest book-id from database ;
		query("SELECT id_ksiazki FROM ksiazki ORDER BY id_ksiazki DESC LIMIT 1", "get_book_id", "");
			// $_SESSION["max-book-id"] => "35"

		$bookId = filter_var($bookId, FILTER_VALIDATE_INT, [
				'options' => [
					'min_range' => 1,
					'max_range' => $_SESSION["max-book-id"]
				]
			]
		);

		$_SESSION['book_exists'] = false;

		query("SELECT id_ksiazki FROM ksiazki WHERE id_ksiazki = '%s'", "cart_verify_book", $bookId);

		if ($bookId === false || $_SESSION['book_exists'] === false || ($bookId != $_POST['book-id'])) {

			unset($_SESSION["max-book-id"], $_SESSION['book_exists']);
				header('Location: ___koszyk.php', true, 303);
					exit();
		}

		$bookAmount = filter_var(
			filter_input(INPUT_POST, "book-amount", FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT, [
				'options' => [
					'min_range' => 1
				]
			]
		);

		if ($bookAmount === false || $bookAmount < 0 || !is_numeric($bookAmount)) {
			unset($bookAmount, $_SESSION["max-book-id"], $_SESSION['book_exists']);
				header('Location: ___koszyk.php', true, 303);
					exit();
		}

		$_SESSION['book_exists'] = false; // book already in shopping cart ? let's assume that it isn't ...

		query("SELECT * FROM koszyk WHERE id_klienta = '%s' AND id_ksiazki = '%s'", "cart_verify_book", [$_SESSION["id"], $bookId]);

        // sprawdzenie, czy ta książka jest już w koszyku tego klienta; jeśli num_rows > 0 -> przestawi $_SESSION['book_exists'] -> na true ;       ;

		$book = [$bookAmount, $_SESSION["id"], $bookId];

		if($_SESSION['book_exists']) { // boox exists, update book quantity in shopping_cart ;

			query("UPDATE koszyk SET ilosc=ilosc+'%s' WHERE id_klienta='%s' AND id_ksiazki='%s'", "", $book);

		} else {               										   // insert book to shopping cart
			query("INSERT INTO koszyk (ilosc, id_klienta, id_ksiazki) VALUES ('%s', '%s', '%s')", "", $book);
		}

		query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $_SESSION["id"]);

        // funkcja count_cart_quantity - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku (aktualizacja po zmianie liczbie książek)

        unset($_POST, $book, $_SESSION['book_exists']);
	}

	header('Location: ___koszyk.php'); // redirect to "cart" when POST variables were not set;
	exit();
?>

