<?php

	require_once "../authenticate-user.php";

	// insert book into shopping cart;
	// dane pochodzące z formularza (index.php / book.php) po kliknięciu "Dodaj do koszyka";
	// "23" - id książki ;
	//  "1" - ilość egzemplarzy, która ma zostać dodana do koszyka ;

	if ( isset($_POST["book-id"]) && !empty($_POST["book-id"]) &&
		 isset($_POST["book-amount"]) && !empty($_POST["book-amount"]) ) {

/*// validate, sanitize book-id;
$bookId = filter_input(INPUT_POST, "book-id", FILTER_SANITIZE_NUMBER_INT); // "35" or FALSE;
// remove any non-numeric characters. This filter will leave only the numeric characters.
// get highest book-id from database ;
unset($_SESSION["max-book-id"]);
query("SELECT MAX(id_ksiazki) AS id_ksiazki FROM ksiazki", "getBookId", "");
	// $_SESSION["max-book-id"] => "35"
$bookId = filter_var($bookId, FILTER_VALIDATE_INT, [
		'options' => [
			'min_range' => 1,
			'max_range' => $_SESSION["max-book-id"]
		]
	]
);
unset($_SESSION["book_exists"]);
query("SELECT id_ksiazki FROM ksiazki WHERE id_ksiazki = '%s'", "verifyBookExists", $bookId);*/

		$bookId = validateBookId($_POST["book-id"]); // "35" or FALSE; <-- validate book-id - is it valid ID (integer) and is there a book with that ID ?

		if (empty($bookId)) {

			$_SESSION["application-error"] = true; // book-id - nie istnieje taka książka, lub podano niepoprawne dane (book-id);
				header('Location: ' . $_SERVER['REQUEST_URI'], true, 303);
					exit();

		} else { // book-id --> valid, there is book with that ID;

			$bookAmount = filter_var(
				filter_input(INPUT_POST, "book-amount", FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT, [
					'options' => [
						'min_range' => 1
					]
				]
			);

			if (empty($bookAmount) || $bookAmount <= 0 || !is_numeric($bookAmount)) {

				$_SESSION["application-error"] = true; // "ilość" - dane nie przeszły wlaidacji

				unset($bookAmount, $_SESSION["max-book-id"], $_SESSION["book_exists"]);
					header('Location: ' . $_SERVER['REQUEST_URI'], true, 303);
						exit();
			} else {

				// "ilość" - poprawna wartość (int)

				unset($_SESSION["book-available"]);

				query("SELECT ks.id_ksiazki, mgk.ilosc_dostepnych_egzemplarzy FROM ksiazki AS ks, magazyn_ksiazki AS mgk WHERE ks.id_ksiazki = mgk.id_ksiazki AND ks.id_ksiazki = '%s'", "checkBookAvailability", $bookId);

				if (empty($_SESSION["book-available"])) {

					// książka nie dostępna w magazynie
					$_SESSION["application-error"] = true;
						header('Location: ' . $_SERVER['REQUEST_URI'], true, 303);
							exit();

				} else {

					// jeśli książka jest dostępna na magazynie

					unset($_SESSION["book_exists"]);

					query("SELECT id_ksiazki FROM koszyk WHERE id_klienta = '%s' AND id_ksiazki = '%s'", "verifyBookExists", [$_SESSION["id"], $bookId]);
					// sprawdzenie, czy ta książka jest już w koszyku tego klienta; jeśli num_rows > 0 -> przestawi $_SESSION['book_exists'] -> na true ;

					$book = [$bookAmount, $_SESSION["id"], $bookId];

					if($_SESSION["book_exists"]) { // boox exists, update book quantity in shopping_cart ;

						$updatedSuccessful = query("UPDATE koszyk SET ilosc=ilosc+'%s' WHERE id_klienta='%s' AND id_ksiazki='%s'", "", $book);

						if (empty($updatedSuccessful)) {
							$_SESSION["application-error"] = true;
							unset($bookAmount, $_SESSION["max-book-id"], $_SESSION["book_exists"], $_SESSION["book-available"]);
						}

					} else {  // insert book to shopping cart

						$insertSuccessful = query("INSERT INTO koszyk (ilosc, id_klienta, id_ksiazki) VALUES ('%s', '%s', '%s')", "", $book);

						if (empty($insertSuccessful)) {
							$_SESSION["application-error"] = true;
							unset($bookAmount, $_SESSION["max-book-id"], $_SESSION["book_exists"], $_SESSION["book-available"]);
						}
					}

					query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "countCartQuantity", $_SESSION["id"]);

					// funkcja count_cart_quantity - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku (aktualizacja po zmianie liczbie książek)

					unset($_POST, $book, $_SESSION["max-book-id"], $_SESSION["book_exists"], $_SESSION["book-available"]);
				}
			}
		}

	}

	header('Location: ___koszyk.php'); // redirect to "cart" when POST variables were not set;
		exit();
?>

