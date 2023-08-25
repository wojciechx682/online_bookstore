<?php
    require_once "../authenticate-user.php";

	if( isset($_POST["book-id"]) && !empty($_POST["book-id"]) &&
        isset($_POST["book-amount"]) && !empty($_POST["book-amount"]) ) {

        $bookId = filter_input(INPUT_POST, "book-id", FILTER_SANITIZE_NUMBER_INT);
        $bookAmount = filter_input(INPUT_POST, "book-amount", FILTER_SANITIZE_NUMBER_INT);

		if(($bookAmount < 0) || (!is_numeric($bookAmount)) || ($bookAmount == false)) {
            $bookAmount = 1; // ?
		}

        $book = [$bookAmount, $_SESSION["id"], $bookId];

		query("UPDATE koszyk 
                     SET ilosc='%s' 
                     WHERE id_klienta='%s' AND 
                           id_ksiazki='%s'", "", $book);

        query("SELECT SUM(ilosc) AS suma 
                             FROM koszyk 
                             WHERE id_klienta='%s'", "countCartQuantity", $_SESSION["id"]);
        //  $_SESSION["koszyk_ilosc_ksiazek"] <-- aktualna ilość książek klienta w koszykuksiazki

        query("SELECT ROUND(SUM(ko.ilosc * ks.cena),2) AS suma
               FROM klienci AS kl, koszyk AS ko, ksiazki AS ks
               WHERE kl.id_klienta = '%s' AND kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki
               GROUP BY kl.id_klienta", "countCartSum", $_SESSION["id"]); // <-- $_SESSION["suma_zamowienia"]

        // ------------------------------------------------------------------------------
        $cartData = [
                "koszyk_ilosc_ksiazek" => $_SESSION["koszyk_ilosc_ksiazek"],
                "suma_zamowienia" => $_SESSION["suma_zamowienia"]
        ];

        header('Content-Type: application/json'); // return DATA as JSON ;
        echo json_encode($cartData); exit();






        unset($_POST['id_ksiazki']);
		unset($_POST['koszyk_ilosc']);
		unset($book);
	}

    exit();

// przejście tutaj następuje po wysłaniu formularza (np. przyciskiem ENTER), w którym jest <input> z ilością książek w koszyku.
// dane pochodzące z koszyk.php;
// && not empty; !empty
?>