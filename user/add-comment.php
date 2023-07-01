<?php
	
	session_start();

	include_once "../functions.php";

	if( ! isset($_SESSION['zalogowany']) ) {

		$_SESSION["login-error"] = true;
		header("Location: ___zaloguj.php");
		exit();
	}

	if( isset($_POST["comment"]) &&
        !empty($_POST["comment"]) &&
		isset($_POST["star"]) &&
		!empty($_POST["star"])
	  ) {

		$comment = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING); // tresc
		$rate = filter_var(filter_input(INPUT_POST, 'star', FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT); // ocena (1 - ... - 5)

		$comment_data = [$_SESSION["id"], $_SESSION["id_ksiazki"]];

		// sprawdzenie czy klient dodał już komentarz do tej książki -->

		$_SESSION["rate_exists"] = false;

		query("SELECT id_komentarza, id_ksiazki, id_klienta, tresc FROM komentarze WHERE id_klienta = '%s' AND id_ksiazki = '%s' ", "verify_rate_exists", $comment_data);
		// $_SESSION["rate_exists"] => true / false

		// sprawdzenie czy istnieje już dodana ocena w tabela rating dla tej książki - wstawiona przez tego klienta -->
		query("SELECT id_oceny, id_ksiazki, ocena, id_klienta FROM ratings WHERE id_klienta = '%s' AND id_ksiazki = '%s' ", "verify_rate_exists", $comment_data);
		// $_SESSION["rate_exists"] => true / false;

		if($_SESSION["rate_exists"]) {

			$_SESSION["rate-error"] = "<h3 class='data-changed'>Dodałeś już opinię dla tej książki</h3>";
			header('Location: ___book.php?book='.$_SESSION["id_ksiazki"]);
			exit();
		} else {

				$comment_data[] = $comment; // id_klienta, id_ksiazki, tresc

			query("INSERT INTO komentarze (id_komentarza, id_klienta, id_ksiazki, tresc) VALUES (NULL, '%s', '%s', '%s')", "", $comment_data); // dodanie nowego komentarza

				$comment_data[2] = $rate; // id_klienta, id_ksiazki, ocena

			query("INSERT INTO ratings (id_oceny, id_klienta, id_ksiazki, ocena) VALUES (NULL, '%s', '%s', '%s')", "", $comment_data);  // dodanie nowej oceny

			// aktualizacja tabeli "książki" - średnia ocen -->

			query("UPDATE ksiazki 
    					 INNER JOIN (SELECT AVG(ratings.ocena) avg_score, ratings.id_ksiazki 
					     FROM ratings 
					     GROUP BY ratings.id_ksiazki) x ON x.id_ksiazki = ksiazki.id_ksiazki 
						 SET rating = x.avg_score 
					     WHERE ksiazki.id_ksiazki = '%s'", "", $comment_data[1]);

			$_SESSION["rate-success"] = "<h3 class='data-changed'>Twoja opinia została dodana</h3>";

			header('Location: ___book.php?book='.$_SESSION["id_ksiazki"]);
			exit();
		}
	}
	else {
		$_SESSION["rate-error"] = "<h3 class='data-changed'>Uzupełnij wszystkie pola</h3>";
		header('Location: ___book.php?book='.$_SESSION["id_ksiazki"]);
		exit();
	}
?>
