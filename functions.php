
<?php

    // Blokada dostępu do adresu "localhost/../functions.php" przez URL
    $currentPage = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if ($_SERVER['REQUEST_METHOD'] == "GET" && strcmp(basename($currentPage), basename(__FILE__)) == 0) {
        http_response_code(404);
        header('Location: index.php');

        die();
    }

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
//
require_once "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

    function getAuthors($result) {
        // get_authors // \user\index.php - left <nav>
        // tworzy elementy listy <li> - w których kazdy wyświetli imie i nazwisko autora;

        // funkcja "get_authors" wykona się tylko, jeśli $result zawiera rekordy - czyli jeśli istnieje conajmniej jeden autor !

        echo '<li>
                <label>
                    <input type="checkbox" name="author-checkbox" class="author-checkbox" id="all-authors">Wszyscy
                </label>
            </li>';

        $author = file_get_contents("../template/content-authors.php"); // load the content from the external template file into string

        while ($row = $result->fetch_assoc()) {   // replace fields in $author string to author data from $result, display result content as HTML
            echo sprintf($author, $row['id_autora'], $row["imie"], $row["nazwisko"], $row["imie"], $row["nazwisko"], $row["ilosc_ksiazek"]);
        }
    }

    function getAuthorsAdvSearch($result) {
        // get_authors_adv_search // \user\index.php - header -> advanced_search -> <select> - lista autorów - imie i nazwisko autora

        $author = file_get_contents("../template/adv-search-authors.php"); // load the content from the external template file into string

        echo sprintf($author, "", "", "");

        while ($row = $result->fetch_assoc()) { // tyle ile jest autorów (imie, nazwisko, id_autora)
            echo sprintf($author, $row["id_autora"], $row["imie"], $row["nazwisko"]); // replace fields in $author string to author data from $result, display result content as HTML
        }
    }

	function getCategories($result) {
	    // \user\index.php - top-nav - ol;
        // wyświetla listę kategorii;   wypisuje elementy listy <li> - wewnątrz kategorii (top_nav - n-top-nav-content);
        $categoryName = "Wszystkie";

        $listItem = file_get_contents("../template/top-nav-categories.php"); // <--- szablon dla elementu listy; // load the content from the external template file into string

        echo sprintf($listItem, $categoryName, $categoryName); // replace fields in $listItem string to category data from $result, display result content as HTML

		while ($row = $result->fetch_assoc()) {// tyle ile jest kategorii (name);
            echo sprintf($listItem, $row["nazwa"], $row["nazwa"]);
		}
    }

    function getCategoriesAdvSearch($result) {
        // get_categories_adv_search // \user\index.php // advanced_search --> <select> - lista kategorii;
        $categoryName = "Wszystkie";

        $category = file_get_contents("../template/adv-search-categories.php"); // load the content from the external template file into string

        echo sprintf($category, $categoryName, $categoryName);

        while ($row = $result->fetch_assoc()) { // tyle ile jest kategorii
            echo sprintf($category, $row["nazwa"], $row["nazwa"]); // replace fields in $author string to author data from $result, display result content as HTML
        }
    }

    function getCategoriesAdmin($result) {

        require "../view/admin/categories-header.php"; // table header;

        $i = 0;

        while($row = $result->fetch_assoc()) {
            $category = file_get_contents("../template/admin/categories.php"); // load the content from the external template file into string
            echo sprintf($category, $row['id_kategorii'], $row["nazwa"], $row["id_kategorii"], $row["id_kategorii"], $row["nazwa"], $row["id_kategorii"]); // replace fields in $order string to author data from $result, display result content as HTML
            $i++;
        }
    }

	function getBooks($result) {
        // get_books - content -> wyświetla wszystkie książki
        // funkcja wykona się, tylko jeśli $result zawiera conajmniej jeden rekord;
        $i = 0;

        while ($row = $result->fetch_assoc()) {

            $book = file_get_contents("../template/content-books.php"); // load the content from the external template file into string
            $row["ilosc_egzemplarzy"] = ($row["ilosc_egzemplarzy"] === null) ? 'niedostępna' : ($row["ilosc_egzemplarzy"] > 0 ? 'dostępna' : 'niedostępna');
            $button = ($row["ilosc_egzemplarzy"] === 'dostępna') ? '' : 'disabled'; // "Dodaj do koszyka" - <button> ;
            echo sprintf($book, $i, $row["id_ksiazki"], $row["image_url"], $row["tytul"], $row["tytul"], $row["id_ksiazki"], $row["tytul"], $row["tytul"], $row["cena"], $row["rok_wydania"], $row["imie"], $row["nazwisko"], $row["ilosc_egzemplarzy"],$row["id_ksiazki"], $button); // replace fields in $book string to book data from $result, display result content as HTML
            $i++;
        }
	}

    function updateBookRates($result) {

        // \book.php - jeśli usunięto komentarze do książki - aktualizacja po wejściu na \user\book.php

        $row = $result->fetch_assoc();

        $_SESSION["rating"] = $row["rating"];
        $_SESSION["liczba_ocen"] = $row["liczba_ocen"];
        $_SESSION["avg_rating"] = $row["rating"];

        if ($row["liczba_ocen"] == 0) {
            query("UPDATE books SET rating = '' WHERE books.id_ksiazki = '%s'", "", $row["id_ksiazki"]);
        }
    }

    function getBook($result) {

        // get book-details on book.php - page ;

        $row = $result->fetch_assoc();

        // id_ksiazki         | 1
        // tytul              | Symfonia C++ wydanie V
        // cena               | 55.55
        // rok_wydania        | 2010
        // id_autora          | 1
        // oprawa             | twarda
        // ilosc_stron        | 520
        // image_url          | csymfoni_wyd_V.png
        // rating             | 4.5
        // wymiary            | 138 x 928 x 281
        // stan               | nowa
        // nazwa              | Informatyka
        // id_kategorii       | 4
        // liczba_komentarzy  | 1
        // liczba_ocen        | 2
        // liczba_egzemplarzy | 15
        // imie               | Jerzy
        // nazwisko           | Grębosz
        // id_autora          | 1
        // id_wydawcy         | 1
        // nazwa_wydawcy      | Helion

        // load the content from the external template file into string
        $book = file_get_contents("../template/book-page.php");

                // wstaw do Z.S wartości zwrócone z Bazy (!);
                $_SESSION["avg_rating"] = $row["rating"];       // average book rating - "4.25" ;
                $_SESSION["rating"] = $row["rating"];           // average book rating - "4.25" ;
                $_SESSION["liczba_ocen"] = $row["liczba_ocen"]; // number of reviews - "2" ;
                $_SESSION["id_ksiazki"] = $row["id_ksiazki"];   // book-id - "1" ;


        if (isset($_SESSION["rate-error"])) { // komunikat - błąd przy dodawaniu oceny przez klienta;

            $message = $_SESSION["rate-error"];
                unset($_SESSION["rate-error"]);

        } elseif (isset($_SESSION["rate-success"])) {

            $message = $_SESSION["rate-success"];
                unset($_SESSION["rate-success"]);

        } else {

            $message = "";
        }

        if (isset($row["liczba_egzemplarzy"]) && !empty($row["liczba_egzemplarzy"])) {
            // wyświetlenie statusu o dostępności książki (na bazie staów magazynowych) + odpowiednia akcja na przycisku dodania do koszyka (jeśli nie ma ksążki w magazynie - wyłączenie przycisku dodania ksiązki do koszyka);

            if($row["liczba_egzemplarzy"] > 0) {
                $status = "dostępna";
                $submit = "enabled";
            } else {
                $status = "niedostępna";
                $submit = "disabled";
            }
        } else {
            $status = "niedostępna";
            $submit = "disabled";
        }

        // replace fields in $book string to book data from $result, display result content as HTML ;
        echo sprintf($book, $row["image_url"], $row["tytul"], $row["tytul"], $row["tytul"], $row["imie"], $row["nazwisko"], $row["rok_wydania"], $row["rating"], $row["liczba_ocen"], $row["liczba_komentarzy"], $row["nazwa_wydawcy"], $row["ilosc_stron"], $row["cena"], $row["id_ksiazki"], $row["id_ksiazki"], $row["id_ksiazki"], $row["id_ksiazki"], $status, $submit);
        // ../template/book-page.php;

        // pobranie komentarzy do książki - (id_klienta, treść, data, imie_klienta, ocena (rt)) - należących do tej książki (id_ksiazki);

        $_SESSION["comments"] = [];

        query("SELECT km.id_klienta, km.tresc, km.data, kl.imie, rt.ocena FROM comments AS km, customers AS kl, ratings AS rt WHERE km.id_klienta = kl.id_klienta AND rt.id_klienta = kl.id_klienta AND km.id_ksiazki = rt.id_ksiazki AND km.id_ksiazki = '%s'", "getComments", $_SESSION["id_ksiazki"]);
        // (!) $_SESSION["comments"]; - ta zmienna zawiera wykorzystany szablon HTML (przechowuje wszystkie komentarze danej książki !);

/*        $_SESSION["comments"] => Array
          (
                [0] =>

                  <section class="comment">
                      <div class="comment-author">Adam</div>                                                       <!-- $row["imie"] - autor komentarza (imie) -->
                      <div class="comment-date">2023-08-15 16:20:16</div>                                          <!-- $row["data"] - 2021-01-01 15:22:34 -->
                      <div class="comment-rate">
                          <span>4</span>                                                                           <!-- $row["ocena"] - "4" -->
                          <div class="comment-rate-inner"></div> <!-- JS - width -> 80 procent -->
                      </div>
                      <div style="clear: both;"></div>
                      <div class="comment-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit 1</div> <!-- $row["tresc"] - "abc..." -->
                  </section>

                  [1] =>

                  <section class="comment">
                      <div class="comment-author">Adam</div>                                                       <!-- $row["imie"] - autor komentarza (imie) -->
                      <div class="comment-date">2023-08-15 16:20:29</div>                                          <!-- $row["data"] - 2021-01-01 15:22:34 -->
                      <div class="comment-rate">
                          <span>5</span>                                                                           <!-- $row["ocena"] - "4" -->
                          <div class="comment-rate-inner"></div> <!-- (!!!) - JS - width -> 80 procent -->
                      </div>
                      <div style="clear: both;"></div>
                      <div class="comment-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit 2</div> <!-- $row["tresc"] - "abc..." -->
                  </section>
        )*/

        $book_page_tabs = file_get_contents("../template/book-page-tabs.php"); // wczytanie szablonu na sekcje (karty) z dodatkowymi informacjami o książce ;

        echo sprintf($book_page_tabs, $row["opis"], $row["tytul"], $row["imie"], $row["nazwisko"], $row["nazwa_wydawcy"], $row["ilosc_stron"], $row["rok_wydania"], $row["wymiary"], ucfirst($row["oprawa"]), ucfirst($row["stan"]), $row["kategoria"], $row["podkategoria"], round($row["rating"],2), $message, implode($_SESSION["comments"]));

    }

    function getRatings($result) {

        // get_ratings // user\book.php   // "ocena", "liczba_ocen";
        // wstawia do tablicy sesyjnej - ilości poszczególnych ocen dla książki ->   5 -> 4,  4 -> 26,  3 -> 15, ....

        // $_SESSION["ratings"] -> [5] => 2 [4] => 1, ... ;

        //    ocena      liczba_ocen
        //      5 	         2
        //      4 	         1
        //     ... 	        ...

        $_SESSION["ratings"] = []; // create new empty array;

        while($row = $result->fetch_assoc()) { // "ocena", "liczba_ocen";

            $book_rating = $row['ocena'];
            $num_of_ratings = $row['liczba_ocen'];

            $_SESSION["ratings"][$book_rating] = $num_of_ratings;
        }
    }

    function verifyRateExists($result = null) { // verify_rate_exists

        // function for cheking if comment / or rate already exists (for that book) made by that clinet

        $_SESSION["rate_exists"] = true;
    }

    function getComments($result) {

        // get_comments // "km.id_klienta", "km.treść", "km.data", "kl.imie", "rt.ocena" ;

        // 342   Mauris venenatis quis metus non faucibus. Duis id ... 	2023-06-23 00:30:04 	Adam 	3
        // 343   Maecenas nulla est, semper vestibulum bibendum ac,... 	2023-06-23 00:30:46 	Adam 	4
        // 343   Lorem ipsum dolor sit amet, consectetur adipiscing... 	2023-06-23 00:32:29 	Adam 	5
        // 345   Fusce a laoreet est. Pellentesque habitant morbi t... 	2023-06-23 00:33:11 	Adam 	5
        // 346   Super książka polecam :) 	                            2023-06-23 09:56:58 	Adam 	3
        // 347   Super książka polecam :) 	                            2023-06-23 09:57:34 	Adam 	3

        $_SESSION["comments"] = []; // stworzenie nowej pustej tablicy ;

        while ($row = $result->fetch_assoc()) // tyle ile jest komentarzy do tej książki;
        {
            // load the content from the external template file into string ;
            $comment = file_get_contents("../template/book-comment.php");

            //  ̶r̶e̶p̶l̶a̶c̶e̶ ̶f̶i̶e̶l̶d̶s̶ ̶i̶n̶ ̶$̶b̶o̶o̶k̶ ̶s̶t̶r̶i̶n̶g̶ ̶t̶o̶ ̶b̶o̶o̶k̶ ̶d̶a̶t̶a̶ ̶f̶r̶o̶m̶ ̶$̶r̶e̶s̶u̶l̶t̶ ̶d̶i̶s̶p̶l̶a̶y̶ ̶r̶e̶s̶u̶l̶t̶ ̶c̶o̶n̶t̶e̶n̶t̶ ̶a̶s̶ ̶H̶T̶M̶L̶ ̶;̶ ̶
            $_SESSION["comments"][] = sprintf($comment, $row["imie"], $row["data"], $row["ocena"], $row["tresc"]);
        }
    }

    // ..\user\book.php - POST ;
    function getBookId($result) { // get_book_id
        // get highest book-id from db to apply max-range filter in \user\book.php (POST);
            $row = $result->fetch_assoc();
        //$_SESSION["max-book-id"] = $row["id_ksiazki"]; // "35"
        return $row["id_ksiazki"];
    }

    function validateBookId($bookId) {

        // \user\book.php
        // \user\add_to_cart.php

        // --> book (ID) exist in database (book exists) ?
        // --> has valid ID (that passing validation) ?


        $bookIdSanitized = filter_var($bookId, FILTER_SANITIZE_NUMBER_INT); // "35" or FALSE; // sanitize book-id; // remove any non-numeric characters. This filter will leave only the numeric characters;

        // get highest book-id from database ;
        $maxBookId = query("SELECT MAX(id_ksiazki) AS id_ksiazki FROM books", "getBookId", "");
        // $_SESSION["max-book-id"] => "35" or NULL;
        // - set variable to be applied in book-id filter below;

        // validate book-id - ✓ valid integer in specific range ;
        $bookIdValidated  = filter_var($bookIdSanitized, FILTER_VALIDATE_INT, [
                'options' => [
                    'min_range' => 1,         // Minimum allowed book-id value
                    'max_range' => $maxBookId // Maximum allowed book-id value (highest book-id in database) ; functions() -> "getBookId()"
                ]
            ]
        ); // ✓ It ensures that the value is an integer within the specified range;


        // check if there is really a book with that id ;
        $bookExists = query("SELECT id_ksiazki FROM books WHERE id_ksiazki = '%s'", "verifyBookExists", $bookIdValidated);
        // $_SESSION["book_exists"] --> true or NULL - zależnie od tego czy książka o takim ID istnieje;

        if (empty($bookIdSanitized) || empty($bookIdValidated) || empty($bookExists) || empty($maxBookId) || ($bookIdValidated != $bookId)) {

                unset($maxBookId, $bookExists);
            return false;
            // error - there is no book with that ID - or - bookID didn't pass validation;
        } else {
            return $bookIdValidated; // book-id - valid and exists (!) - return that ID
        }
    }

    function checkBookAvailability($result) {

        // check if book is available in warehouse
        // add-to-cart.php

        $row = $result->fetch_assoc();

        if ($row["ilosc_dostepnych_egzemplarzy"] > 0) {
            $_SESSION["book-available"] = true;
        }
    }

    function getAuthorId($result) {

        // ..\admin\add-book-data, \edit-book-data - POST ;     \user\index.php - advanced-search - prg;
        // get_author_id

        // wykona się tylko, jeśli zwrócono conajmniej 1 wiersz; (num_rows)

        // get highest author-id from db to apply max-range filter in ..\admin\add-book-data, \edit-book-data (POST), \user\index.php - adv-search - prg;
        $row = $result->fetch_assoc();
        return $row["id_autora"]; // "25"
    }

    function getPublisherId($result) { // get_publisher_id
        // get highest publisher-id from db to apply max-range filter in ..\admin\add-book-data.php (POST);
            $row = $result->fetch_assoc();
        $_SESSION["max-publisher-id"] = $row["id_wydawcy"]; // "5"
    }

    function getCategoryId($result) { // get_category_id
        // get highest category-id from db to apply max-range filter in ..\admin\add-book-data.php (POST);
            $row = $result->fetch_assoc();
        $_SESSION["max-category-id"] = $row["id_kategorii"]; // "7"
    }

    function getMagazineId($result) { // get_magazine_id
        // get highest publisher-id from db to apply max-range filter in ..\admin\add-book-data.php, \edit-book-data.php (POST);
            $row = $result->fetch_assoc();
        $_SESSION["max-magazine-id"] = $row["id_magazynu"]; // "2"
    }

	function checkEmail($result) { // check_email

        // change_user_data.php - (zmiana danych usera), sprawdza, czy istnieje juz taki email, ustawia zmienna sesyjną; (zmiana danych konta);
        // remove_account.php     - sprawdza, -----------||--------------  ---------||-----------;  (resetowanie hasła);
        $_SESSION["email-exists"] = true;
	}

    function resetPasswordCheckEmail($result) { // reset_password.php - resetowanie hasła

        $row = $result->fetch_assoc();
        $_SESSION["email-exists"] = true;
        $_SESSION["imie"] = $row["imie"];

    }

    function generate_token() { // reset_password.php; - return $token | OR | false;

        try {

            $token = bin2hex(random_bytes(8)); // generate random token (16 letters);

            // 16-znakowy, kryptograficznie bezpieczny losowy ciąg heksadecymalny.

            // 8e2fa8c5e828598c
            // 06ab7636f4b3a56d
            // d496c2fdb32d08d8
            // ...

            return $token; // return generated token;

        } catch (Exception $e) {

            return false;
        }
    }

    function verifyToken($result)
    {
        // verify_token
        // reset-password-form.php;
        // check, if there is any token assigned to that e-mail;

            $row = $result->fetch_assoc();
        $_SESSION["token-exists"] = true;
        $_SESSION["email"] = $row["email"];
        $_SESSION["exp-time"] = $row["exp_time"];
        $_SESSION["token"] = $row["token"]; // hashed token (sha256)
    }



    function sendEmail($message, $sendTo, $subject) {

        try {

            $mail = new PHPMailer(true);   // create a new PHPMailer instance, passing `true` enables exceptions;

            $mail->isSMTP();                         // Server settings below, Send using SMTP
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // aby widzieć komunikaty przebiegu wysyłania wiadomośći;

            $mail->Host = 'smtp.gmail.com';          // Set the SMTP server to send through
            $mail->Port = 465;                       // TCP port to connect to;  use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
            $mail->SMTPAuth = true;                  // Enable SMTP authentication

            $mail->Username = 'jakub.wojciechowski.683@gmail.com'; // adres nadawcy; podaj swój adres gmail // SMTP username
            $mail->Password = 'ubkdmiyqcquifysy';                  // podaj swoje HASŁO DO APLIKACJI (!) - gmail; // SMTP password

            $mail->CharSet = 'UTF-8';  // konfiguracja wiadomości
            $mail->setFrom('app.bookstore@gmail.com', 'Księgarnia internetowa'); // nazwa nadawcy (name)
            $mail->addAddress($sendTo); // email ODBIORCY ;
            //$mail->addReplyTo('biuro@domena.pl', 'Biuro');

            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;

            //$user = $_SESSION["imie"];

            $mail->Body = $message;

            //$mail->addAttachment('img/html-ebook.jpg'); // załącznik

            if ($mail->send()) {

                return true;

            } else {

                throw new Exception();

            }

        } catch(Exception $e) {

            $_SESSION["sent-error"] = "Wystąpił błąd. Nie udało się wysłać wiadomości na podany adres e-mail. {$mail->ErrorInfo}"; // $e->getMessage();

            //return false;
        }
    }


	function countCartQuantity($result) {

        // count_cart_quantity // add_to_cart.php - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku;
        // \user\index.php - pobiera ilość książek klienta w koszyku;

		$row = $result->fetch_assoc();

//		if($row['suma'] == NULL) {
//			$_SESSION['koszyk_ilosc_ksiazek'] = 0;
//		}
//		else {
//			$_SESSION['koszyk_ilosc_ksiazek'] = $row['suma'];
//		}

        $_SESSION["koszyk_ilosc_ksiazek"] = ($row["suma"] == NULL) ? 0 : $row["suma"]; // SUM(ilosc) AS suma -> $row["suma"];

		//$result->free_result();

        // !!! $result -> num_rows
        // w przypadku gdy podano id nieistniejącego klienta, zwróci 1 WIERSZ, z wartością NULL (suma == NULL)
	}

    function countCartSum($result) { // count_cart_sum

        // \user\change_cart_quantiyt.php - oblicza sumę (cenę) książek w koszyku klienta;

        $row = $result->fetch_assoc();

        $_SESSION["suma_zamowienia"] = $row["suma"];

    }

	function getProductsFromCart($result) {

        // get_product_from_cart // koszyk.php,  order.php

		// $row[] -> kl.id_klienta, 		klient
		//		     ko.id_ksiazki,        	 	     koszyk
		//		     ko.ilosc, 						 koszyk
		//		     ks.tytul, 			    ksiazki
		//		     ks.cena,               ksiazki
		//		     ks.rok_wydania         ksiazki
        //           ks.image_url           ksiazki
        //           au.imie                         autor
        //           au.nazwisko                     autor

		//$_SESSION["suma_zamowienia"] = 0;

		$i = 0;

        // zapisz do ZS łączną sumę dla wszystkich książek w koszyku klienta -->

        $_SESSION["suma_zamowienia"] = 0;

        query("SELECT ROUND(SUM(ko.ilosc * ks.cena),2) AS suma
                     FROM customers AS kl, shopping_cart AS ko, books AS ks
                     WHERE kl.id_klienta = '%s' AND kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki
                     GROUP BY kl.id_klienta", "countCartSum", $_SESSION["id"]); // <-- $_SESSION["suma_zamowienia"]

		while ($row = $result->fetch_assoc())
		{
            // load the content from the external template file into string
            $book = file_get_contents("../template/cart-products.php");

            // replace fields in $book string to book data from $result
            echo sprintf($book, $i, $row["id_ksiazki"], $row["image_url"], $row["tytul"], $row["tytul"], $row["id_ksiazki"], $row["tytul"], $row["tytul"], $row["cena"], $row["rok_wydania"], $row["imie"], $row["nazwisko"], $row["kategoria"], $row["podkategoria"], $row["id_ksiazki"], $row["id_ksiazki"], $row["id_ksiazki"], $row["ilosc"], $row["id_ksiazki"], $row["id_ksiazki"], $row["id_ksiazki"]);

            $i++;

		}
	}

    function getDeliveryTypes($result) { // \user\submit_order.php - pobierz możliwe formy dostawy z bazy danych;

        $_SESSION["delivery-types"] = [];

        while($row = $result->fetch_assoc()) {

            $_SESSION["delivery-types"][$row["nazwa"]] = ["id" => $row["id"], "cena" => $row["cena"]];
        }

        $result->free_result();
    }

    function getPaymentMethods($result) { // \user\submit_order.php - pobierz możliwe metody płatności z bazy danych;

        $_SESSION["payment-methods"] = [];

        while($row = $result->fetch_assoc()) {

            $_SESSION["payment-methods"][$row["nazwa"]] = ["id" => $row["id"], "oplata" => $row["oplata"]];
        }

        $result->free_result();
    }

	function insertOrderDetails($result) // insert_order_details
	{
        // order.php -> insert do tabeli szczegoly_zamowienia - na podstawie tabeli koszyk

		$id_zamowienia = $_SESSION["last_order_id"]; // id_zamowienia -> get_last_order_id()

		while ($row = $result->fetch_assoc())        // wiersze z tabeli koszyk
		{
		  	//echo $row['id_klienta'] . ", " .$row['id_ksiazki'] . ", " . $row['ilosc'] . "<br>"; // remove in the future

		  	$id_ksiazki = $row['id_ksiazki'];
		  	$ilosc = $row['ilosc'];

//			$values = array();
//			array_push($values, $id_zamowienia); // id_zamowienia
//			array_push($values, $id_ksiazki); // id_ksiazki
//			array_push($values, $ilosc); // id_ksiazki

            $cart = [$id_zamowienia, $id_ksiazki, $ilosc];

		  	query("INSERT INTO order_details VALUES ('%s', '%s', '%s')", "", $cart);

            //query("UPDATE warehouse_books SET ilosc_dostepnych_egzemplarzy=ilosc_dostepnych_egzemplarzy-'%s' WHERE id_ksiazki='%s'", "", [$ilosc, $id_ksiazki]);

		  	// echo '<a href="order_details.php?order_id='.$row['id_zamowienia'].' "> Szczegóły zamówienia </a><br>';
		}

		$result->free_result();
	}

	function getOrders($result) { // get_orders // wywołanie w my_orders.php
            // zamówienia danego klienta; -- wiele wierszy --> id_zamowienia, data_zloz, status, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, forma_dostarczenia, komentarz, suma, sposob_platnosci;
        // id_zamowienia            - 1263
        // data_zlozenia            - 2023-08-29 14:32:31
        // status                   - Oczekujące na potwierdzenie
        // termin_dostawy           - 0000-00-00
        // data_wysłania_zamowienia - 0000-00-00 00:00:00
        // data_dostarczenia        - 0000-00-00
        // komentarz                - ""
        // forma_dostawy            - Kurier DPD
        // suma                     - 301.65
        // sposob_platnosci         - Blik
            $i = 0;
		while ($row = $result->fetch_assoc()) { // dla każdego wiersza z zamówieniem;
                    //getOrderSum("", $row["id_zamowienia"]); // suma zam; --> $_SESSION["order_sum"]; // ?
                    // ✓ zapisze sumę zamówienia w zmiennej sesyjnej; $_SESSION["order_sum"]; // ?
            // load the content from the external template file into string
            $order = file_get_contents("../template/order-details.php"); // <div class="order">
                // pojemnik na zamówienie - div class="order" --> widok nagłówka tabeli z pojedynczym zamówieniem --> data, status, numer_zamówienia (ID), sposób_płatności

            $orderDate = DateTime::createFromFormat('Y-m-d H:i:s', $row["data_zlozenia_zamowienia"])->format('d-m-Y H:i:s');

            // replace fields in $order string to order data from $result, display result content as HTML;
            echo sprintf($order, $row["data_zlozenia_zamowienia"], $row["status"], $row["id_zamowienia"], $row["sposob_platnosci"]); // pojemnik na tabelę z zamówieniem, nagłówek tabeli;
            query("SELECT id_ksiazki, ilosc FROM order_details WHERE id_zamowienia = '%s'", "getOrderDetails", $row["id_zamowienia"]);
            // $row --> ["id_ksiazki"], ["ilosc"] <-- ksiązki wchodzące w skład danego zamówienia (id_zamowienia);
                // --> $_SESSION["order_details_books_id"];
                // ✓ pojedyncze wiersze z danymi o książce w tym zamówieniu;
                // wiele wierszy -> "id_ksiazki", "ilosc";
                    /*for($i = 0; $i < count($_SESSION['order_details_books_id']); $i++) {
                        $book_id = $_SESSION['order_details_books_id'][$i];
                        query("SELECT tytul, cena, rok_wydania FROM ksiazki WHERE id_ksiazki = '%s'", "order_details_get_book", $book_id);
                    }*/

            $_SESSION["termin_dostawy"] = DateTime::createFromFormat('Y-m-d', $row["termin_dostawy"])->format('d-m-Y');
            $_SESSION["data_wysłania_zamowienia"] = $row["data_wysłania_zamowienia"];
            $_SESSION["data_dostarczenia"] = $row["data_dostarczenia"];
                /* echo "<br> 608 termin dostawy -> <br>" . $_SESSION["termin_dostawy"] . "<br>";
                echo "<br> 608 data wysłania -> <br>" . $_SESSION["data_wysłania_zamowienia"] . "<br>";
                echo "<br> 608 data wysłania -> <br>" . $_SESSION["data_wysłania_zamowienia"] . "<br>";
                echo "<br> SUMA ZAMÓWIENIA -> <br>" . $_SESSION["order_sum"] . "<br>"; */

                // load the content from the external template file into string
                // Stopka w tabeli tego zamówienia - wyświetla tylko SUMĘ zamówienia;
            //$order = file_get_contents("../template/order-sum.php");
                // replace fields in $order string to author data from $result, display result content as HTML
            //echo sprintf($order, $_SESSION["order_sum"]);
                // Stopka w tabeli tego zamówienia - wyświetla tylko SUMĘ zamówienia;

            /*$payment = file_get_contents("../template/order-details-payment-method.php");
            echo sprintf($payment, $row["sposob_platnosci"], $row["forma_dostawy"]);*/

            $kosztPlatnosci = ($row["koszt_platnosci"] !== "0.00") ? $row["koszt_platnosci"] : "";

            if(!empty($kosztPlatnosci)) {
                $kosztPlatnosci = sprintf('<div class="order-sum-info"><span>Pobranie</span> %s PLN</div>', $kosztPlatnosci);
            }
            //echo "<br> koszt platnosci --> <br>" . $kosztPlatnosci . "<br>";

            if ( isset($_SESSION["termin_dostawy"]) && !empty($_SESSION["termin_dostawy"]) &&
                $_SESSION["termin_dostawy"] !== "0000-00-00" &&
                /*&& $_SESSION["data_wysłania_zamowienia"] === "0000-00-00 00:00:00"
                && $_SESSION["data_dostarczenia"] === "0000-00-00"*/
                $row["status"] === "W trakcie realizacji" ) {

                    // status zamówienia to "W trakcie realizacji" --> termin_dostawy;
                    $order = file_get_contents("../template/order-sum-order-in-progress.php");
                    echo sprintf($order, $row["forma_dostawy"], $_SESSION["termin_dostawy"], $row["koszt_dostawy"],  $kosztPlatnosci, $row["suma"]);

            }
            elseif ( isset($_SESSION["data_wysłania_zamowienia"]) && !empty($_SESSION["data_wysłania_zamowienia"]) &&
                      $_SESSION["termin_dostawy"] !== "0000-00-00" &&
                      $_SESSION["data_wysłania_zamowienia"] !== "0000-00-00 00:00:00"
                /*&& $_SESSION["data_dostarczenia"] === "0000-00-00"*/
                && $row["status"] === "Wysłano"
            ) {
                // status zamówienia to "Wysłano" --> termin_dostawy, data_wyslania_zamowienia;
                $order = file_get_contents("../template/order-sum-order-sent.php");
                echo sprintf($order, $row["forma_dostawy"], $_SESSION["termin_dostawy"], $_SESSION["data_wysłania_zamowienia"],  $row["koszt_dostawy"],  $kosztPlatnosci, $row["suma"]);
            }
            elseif (
                isset($_SESSION["data_dostarczenia"]) && !empty($_SESSION["data_dostarczenia"])
                && $_SESSION["data_dostarczenia"] !== "0000-00-00"
                && $row["status"] === "Dostarczono"
            ) {
                // status zamówienia to "Dostarczono" (zakończono) --> termin_dostawy?, data_wyslania_zamowienia?, data_dostarczenia;
                $order = file_get_contents("../template/order-sum-order-delivered.php");
                echo sprintf($order, $_SESSION["data_dostarczenia"], $row["koszt_dostawy"], $kosztPlatnosci, $row["suma"]);

            }
            elseif (
                $row["status"] === "Zarchiwizowane"
            ) {
                $order = file_get_contents("../template/order-sum-order-archived.php");
                //echo sprintf($order, $row["komentarz"], $row["suma"]);
                echo sprintf($order, $row["forma_dostawy"], $row["koszt_dostawy"],  $kosztPlatnosci, $row["suma"]);
            }
            else { // status -> "Oczekujące na potwierdzenie";
                $order = file_get_contents("../template/order-sum.php");
                //echo sprintf($order, $_SESSION["order_sum"]);
                echo sprintf($order, $row["forma_dostawy"], $row["koszt_dostawy"],  $kosztPlatnosci, $row["suma"]);
            }

            echo "</div>";

		}

        unset($_SESSION["order_details_books_id"], $_SESSION["order_details_books_quantity"], $_SESSION["termin_dostawy"], $_SESSION["data_wysłania_zamowienia"], $_SESSION["data_dostarczenia"], $_SESSION["book-id"], $_SESSION["avg_rating"], $_SESSION["rating"], $_SESSION["id_ksiazki"], $_SESSION["comments"]);


	}


    function getOrderDetails($result) { // get_order_details //  my_orders.php --> getOrders($result) --> szczegóły_zamówienia (ksążki wchodzące w skład danego zamówienia);
        // $result (!) - szczegóły_zamówienia -->
            //  id_ksiazki |  ilosc
            // -----------------------
            //      35     |    2
            //      48     |    4
        $_SESSION["order_details_books_id"] = [];
        $_SESSION["order_details_books_quantity"] = [];
            $i = 0;
        while ($row = $result->fetch_assoc()) { // (!) - dla każdej książki ! (szczegoly_zamowienia) - wchodzącej w skład danego zamówienia (id_zamowienia) --> wiele wierszy - "id_książki", "ilość";
            // tutaj wyświetla w widoku pojedynczy wiesz (id_ksiazki, obrazek, informacje o książke, ...) w tabeli tego zamówienia;
                    /*echo "<br><strong>order_id  &rarr;</strong> " .$row['id_zamowienia'].", <strong>book_id  &rarr;</strong> ".$row['id_ksiazki'].", <strong>quantity &rarr;</strong> " .$row['ilosc']. "<br>";*/
                    //echo "<strong>quantity &rarr;</strong> " .$row['ilosc']. "<br>";
            $_SESSION["order_details_books_id"][$i] =  $row["id_ksiazki"]; // przechowuje id książek (tablica);
                //array_push($_SESSION['order_details_books_id'], $row['id_ksiazki']);
            $_SESSION["order_details_books_quantity"][$i] =  $row["ilosc"]; // przechowuje ilosc egz książki (tablica);
                //array_push($_SESSION['order_details_books_quantity'], $row['ilosc']);
                    // load the content from the external template file into string
                    /*$order = file_get_contents("../template/order-details-book.php");
                    // replace fields in $order string to author data from $result, display result content as HTML
                    echo sprintf($order, $row['ilosc']);*/
            query("SELECT tytul, cena, au.imie, au.nazwisko, rok_wydania, image_url FROM books AS ks, author AS au WHERE ks.id_autora = au.id_autora AND  ks.id_ksiazki = '%s'", "orderDetailsGetBook", $_SESSION["order_details_books_id"][$i]); // To jest pojedynczy "Wiersz" - w widoku w tabeli - który wyświetla Pojedynczą książkę w Tym zamówieniu
            $i++;
        }
    }

	function orderDetailsGetBook($result) { // order_details_get_book
        // Wyświetla wiersze z książką w tabeli dla danego zamówienia;
            // $result - (pojedyncza książka wchodząca w skład zamówienia) -->
            // ---------------------------------------------------------------
            // tytuł       - Java - Techniki zaawansowane Wydanie V
            // cena        - 50
            // imie        - Cezary
            // nazwisko    - Sokołowski
            // rok_wydania - 2018
            // image_url   - Java_techniki_zaawansowane.png
        // $_SESSION["order_details_books_id"][$i] <-- tablica przechowująca ID książek wchodzących w skład danego zamówienia;
        // $_SESSION["order_details_books_quantity"][$i] <-- tablica przechowująca ILOŚCI EGZEMPLARZY książek wchodzących w skład danego zamówienia;
		$row = $result->fetch_assoc();
        // load the content from the external template file into string
        $order = file_get_contents("../template/order-details-book.php");
            // użyto zapisu "count($_SESSION["order_details_books_quantity"])" - ponieważ w każdej iteracji ta tablica rośnie, i zawiera dokładnie tyle elementów - ile jest wierszy (książek) w zamówieniu - stąd można użyć tego zapisu do numeracji (l.p.) -> "1", "2", "3" ...;
            // innymi słowy - zmienna "count($_SESSION["order_details_books_quantity"])" - w danej iteracji posiada ROZMIAR, który OKREŚLA NUMER WIERSZA (1,2,3) -, oraz wartość tej tablicy w danej iteracji przechowuje ILOŚĆ TEJ KONKRETNEJ KSIĄŻKI w tym zamówieniu;
        // count($_SESSION["order_details_books_quantity"]) <--- rozmiar tablicy w danej iteracji (numer wiersza - 1,2,3 ...);
            // $_SESSION["order_details_books_quantity"][count($_SESSION["order_details_books_quantity"])-1]
                // - ilość egzamplarzy tej książki w tym zamówieniu (w danej iteracji);
        // $_SESSION["order_details_books_id"][count($_SESSION['order_details_books_id'])-1] <-- id_książki ;
            $productNo = count($_SESSION["order_details_books_quantity"]); // "1", "2", "3", ...
            $bookId = $_SESSION["order_details_books_id"][count($_SESSION["order_details_books_id"])-1]; // 25, 48, 12, ...
            $bookQuantity = $_SESSION["order_details_books_quantity"][count($_SESSION["order_details_books_quantity"])-1]; // 2, 8, 5, ...
        // replace fields in $order string to author data from $result, display result content as HTML
        echo sprintf($order, $productNo, $bookId, $row["image_url"], $row["tytul"], $row["tytul"], $row["tytul"], $bookId, $row["tytul"], $row["tytul"], $row["imie"], $row["nazwisko"], $row["rok_wydania"], $productNo, $bookQuantity, $productNo, $row["cena"]);
	}

    function getOrderSum($result = null, $order_id = null) { // get_order_sum

        if (!($result instanceof mysqli_result)) { // dla funkcji get_orders();
            query("SELECT kwota FROM payments WHERE id_zamowienia='%s'", "getOrderSum", $order_id);
        } else  {
            // to się wywoła rekurencyjnie z warunku wyżej - zapisze sumę zamówienia do zmiennej sesyjnej;
            // $result was passed, do something with it;
                $row = $result->fetch_assoc();
            $_SESSION["order_sum"] = $row["kwota"];
        }
    }

	function verifyPassword($result) {   // check, if user provided correct password

        // verify_password // change_password.php (zmiana hasła); // confirm_password.php (usuwanie konta);

		/*while ($row = $result->fetch_assoc())
		{
		  	$_SESSION['stare_haslo'] = $row['haslo'];
		}
		$result->free_result();*/

            $row = $result->fetch_assoc();
        $_SESSION["password_hashed"] = $row["haslo"]; // hasło klienta (lub pracownika) w postaci zahashowanej;
        // $result->free_result();

        //echo "$_SESSION password_hashed = <br>"; echo $_SESSION["password_hashed"]; exit();
	}

	function log_in($result) { // funkcja wykona się tylko, jeśli zwrócono wiersze (czyli wtedy gdy istnieje taki klient/pracownik)

        // logowanie.php - skrypt logowania -> weryfikacja adresu e-mail, hasła;

        // 1. sprawdza, czy istnieje taki email,    jeśli nie - przekierowuje do pliku zaloguj.php + wyświetla komunikat "Niepoprawny e-mail lub hasło";

        // 1.1 jeśli email istnieje (tzn jest taki klient/pracownik) -->

        // 2. następuje weryfikacja hasła - czy podano poprawne hasło ? - za pomocą funkcji porównującej hash hasła zapisany w bazie danych z zahashowanym hasłem otrzymanym w tablicy POST;

        // 3. jeśli hasło było poprawne, i był to KLIENT -
            // 3.1 - następuje POBRANIE LICZBY KSIĄŻEK klienta, znajdujących się W KOSZYKU,
            // - ZAPISANIE DANYCH KLIENTA w ZMIENNYCH SESYJNYCH oraz
            // - PRZEKIEROWANIE NA STRONĘ GŁÓWNĄ,

        // 4 jeśli hasło było poprawne, i był to PRACOWNIK
            // - następuje zapisanie danych pracownika w zmiennych sesyjnych oraz
            // - przekierowanie na stronę główną panelu administratora;

        // w przeciwnym przypadku (jeśli podano błędne dane logowania) - następuje przekierowania na stronę logowania + wyświetlenie komunikatu o błędzie;

        unset($_SESSION["invalid_credentials"]);

		$row = $result->fetch_assoc(); // wiersz - pola tabeli = tablica asocjacyjna;

/*if(empty($row)) { // (testowałem) --> to się wykona, ✓✓✓ JEŚLI PODANO ZŁY E-MAIL (nieistniejący) (ponieważ wynika to z kwerendy, WHERE email = '%s' -> 0 zwróconych wierszy) !

    $_SESSION["blad"] = '<span class="error">Nieprawidłowy e-mail lub hasło</span>';
    // błędne dane logowania (NIEISTNIEJĄCY EMAIL) -> przekierowanie do zaloguj.php + komunikat;
    return;
}*/

		// WERYFIKACJA HASZA : (czy hasze hasła sa identyczne ?)
		    // porównanie hasha (hasła) podanego przy logowaniu, z hashem zapisanym w bazie danych;

		$password = $_POST["password"]; // "zmienne tworzone poza funkcjami są globalne (więcej o funkcjach w manualu), a zmienne tworzone w funkcjach mają zasięg lokalny" - http://www.php.pl/Wortal/Artykuly/PHP/Podstawy/Zmienne-i-stale/Zasieg-zmiennych

        //echo "<br> haslo = $haslo <br>"; // exit();
        //echo "<br> row  = " . var_dump($row) . " <br>";  exit();

		if (password_verify($password, $row["haslo"])) {

            // true -> hasze sa takie same (podano POPRAWNE HASŁO do konta - email także był poprawny);

			$_SESSION["zalogowany"] = true;

            $id = array_keys($row)[0]; // przyjmie wartość typu String (TEKSTOWĄ) taką jak -> "id_klienta"; "id_pracownika"; (użyto takiego zapisu ponieważ ID w tabeli "klienci" ma inną NAZWĘ niż w tabeli "pracownicy". - a klient i pracownik używa tego samego formularza logowania;

			$_SESSION["id"] = $row[$id]; // wartość zmiennej => "id_klienta" lub "id_pracownika"; (tzn np 220, 221, ...);
			$_SESSION["imie"] = $row['imie'];
			$_SESSION["nazwisko"] = $row['nazwisko'];
            $_SESSION["telefon"] = $row['telefon'];
            $_SESSION["email"] = $row['email'];
                $_SESSION["adres_id"] = $row['adres_id'];
                $_SESSION["miejscowosc"] = $row['miejscowosc'];
                $_SESSION["ulica"] = $row['ulica'];
                $_SESSION["numer_domu"] = $row['numer_domu'];
                $_SESSION["kod_pocztowy"] = $row['kod_pocztowy'];
                $_SESSION["kod_miejscowosc"] = $row['kod_miejscowosc'];
                                    /* $_SESSION['wojewodztwo'] = $row['wojewodztwo'];
                                    $_SESSION['kraj'] = $row['kraj'];
			                        $_SESSION['PESEL'] = $row['PESEL'];
			                        $_SESSION['data_urodzenia'] = $row['data_urodzenia']; */
			                        //$_SESSION['login'] = $row['login'];

			//unset($_SESSION["blad"]); // usuwa komunikat o błędzie logowania; // jest potrzebne, ponieważ mogła nastąpić sytuacja, w której klient podał złe dane (nastąpiło ustawienie zmiennej $_SESSION["blad"]), po czym nastąpiło logowanie pracownika (wszystkie dane były poprawne) - wtedy zmienna $_SESSION["blad"] istnieje, i należy ją usunąć;

			//$result->free_result();   // pozbywamy się z pamięci rezultatu zapytania; free(); close();

            if ($id === "id_klienta") {

                $_SESSION["user-type"] = "klient";

                query("SELECT SUM(ilosc) AS suma 
                             FROM shopping_cart 
                             WHERE id_klienta='%s'", "countCartQuantity", $_SESSION["id"]);
                // pobranie liczby książek znajdujących się w kosztku; countCartQuantity() -> $_SESSION['koszyk_ilosc_ksiazek'] -> zapis do zmiennej;

                header('Location: index.php'); // przekierowanie do strony index.php
                    exit();

            } else {
                $_SESSION["stanowisko"] = $row["stanowisko"];
                    $_SESSION['user-type'] = "admin";
                header('Location: ../admin/admin.php');  // pracownik - przekierowanie do strony admin.php
                    exit();
            }

		} else { // istniejący e-mail, złe (niepoprawne) hasło;
			$_SESSION["invalid_credentials"] = '<span class="error">Nieprawidłowy e-mail lub hasło</span>';
            // błędne dane logowania (niepoprawne HASŁO) -> przekierowanie do zaloguj.php + komunikat;
			    header('Location: zaloguj.php');
                    exit();
		}
	}

	function registerVerifyEmail($result) // register_verify_email
	{
        // rejestracja (rejestracja.php) - weryfikacja, czy istnieje taki email (czy jest zajęty);
		$_SESSION["valid"] = false;
		$_SESSION["e_email"] = "Istnieje już konto przypisane do tego adresu email";
	}

    function register($polaczenie) {

        // $polaczenie object - to receive last insert id;

                        /*// dodanie nowego użytkownika - rejestracja.php
                        $_SESSION['udanarejestracja'] = true;
                        // pobranie ID ostatnio wstawionego klienta ->
                            query("SELECT id_klienta FROM klienci ORDER BY id_klienta DESC LIMIT 1", "get_client_id", ""); // $_SESSION['last_client_id'] --> id ostatnio dodanego klienta;
                        //unset($_SESSION['wszystko_OK']); $_SESSION["valid"]
                        header('Location: zaloguj.php');*/

        /*echo "<br> result --> " . "<br>";       // 1
        print_r($result);
        echo "<br> result --> " . "<br>";         // bool(true)
        var_dump($result);
        echo "<br> gettype result --> " . "<br>"; // boolean
        echo gettype($result);

        echo "<br> polaczenie --> " . "<br>";     // MySQL connection object;
        print_r($polaczenie);
        echo "<br><br>";
        print_r($polaczenie->insert_id);          // "134" / integer
        echo "<br>". gettype($polaczenie->insert_id);*/

        // dodanie nowego użytkownika - rejestracja.php
        $_SESSION["udanarejestracja"] = true;

            // pobranie ID ostatnio wstawionego adresu  ->
            //query("SELECT adres_id FROM adres ORDER BY adres_id DESC LIMIT 1", "get_address_id", "");
            // $_SESSION['last_adres_id'] -> id ostatnio dodanego adresu;

        // pobranie ID ostatnio wstawionego adresu  ->
        $_SESSION["last_adres_id"] = $polaczenie->insert_id;

        //echo "<br> $ SESSION['last_adres_id'] --> " . "<br>";         // 1
        //print_r($_SESSION['last_adres_id']); exit();


                // $_SESSION['last_client_id'] --> id ostatnio dodanego klienta;
                //unset($_SESSION['wszystko_OK']); $_SESSION["valid"]
                //header('Location: zaloguj.php');

        //echo "<br> 993 <br>";
    }

	function verifyBookExists($result) {
        // cart_verify_book // zmienić nazwę na "verifyBookExists"
        // \user\book.php - check if book with given ID (in POST request) exist, if book exist - return true in that session variable;
        // add_to_cart.php -> ta funkcja wykona się tylko, gdy BD zwróci rezultat, czyli ta książka jest już w koszyku
        // \admin\book-details.php
        return true;
	}

    function verifyAuthorExists($result) {
        // \admin\edit-book-data,    \user\index.php - advanced-search (prg)
        // \admin\edit-book.php - check if author with given ID (in POST request) exist, if author exist - return true in that session variable;
        //$_SESSION["author-exists"] = true;
        return true;
    }

    function verifyPublisherExists($result) { // \admin\edit-book-data

        if($result->num_rows) {
            // \admin\edit-book.php - check if author with given ID (in POST request) exist, if author exist - return true in that session variable ;
                $_SESSION['publisher-exists'] = true;
            $result->free_result();

        } else { // można nawet to zakomentować;
            //echo "<br>no<br>";
            // do nothing !
        }
    }

    function verifyCategoryExists($result) {
        // funkcja wywołuje się tylko wtedy, gdy $result zwrócił rekordy! ($num_rows > 0);

        // \admin\edit-book-data, - check if author with given ID (in POST request) exist, if author exist - return true in that session variable ;
        // \user\index.php - PRG - spr, czy istnieje kategoria o takiej nazwie;
        // \admin\edit-category-data.php - (zmiana nazwy kategorii) -  czy już istnieje kategoria o takiej nazwie;

        //$_SESSION["category-exists"] = true;

        return true;
    }

    function verifySubcategoryExists($result) {

        // \user\index.php - prg - spr, czy istnieje pod-kategoria o takiej nazwie;

        //$_SESSION["subcategory-exists"] = true;

        return true;
    }

    function verifyWarehouseExists($result) {
        // \admin\add-book-data.php
        if($result->num_rows) {
            // \admin\edit-book.php - check if author with given ID (in POST request) exist, if author exist - return true in that session variable ;
            $_SESSION['warehouse-exists'] = true;
            $result->free_result();

        } else { // można nawet to zakomentować;
            //echo "<br>no<br>";
            // do nothing !
        }

    }

    function orderDetailsVerifyOrderExists($result) { // zwrócono rekordy a więc jest takie zamówienie (admin\order-details.php);
        //echo "\n 1014 - function -> orderDetailsVerifyOrderExists \n\n";


        $row = $result->fetch_assoc();
        $_SESSION["order-date"] = $row["data_zlozenia_zamowienia"];
        $_SESSION["client-name"] = $row["imie"];
        $_SESSION["client-surname"] = $row["nazwisko"];
        //$_SESSION["order-exists"] = true;
        return true;
    }

	function get_var_name($var)
    {
        // do usunięcia

	    foreach($GLOBALS as $var_name => $value)
	    {
	        if ($value === $var)
	        {
	            return $var_name;
	        }
	    }
	    return false;
	}

    /*function get_id($result)
    {
        // order.php -> get_last_order_id($result) -> ustawia id ostatniego zamówienia w zmiennej sesyjnej
            $row = $result->fetch_assoc();
        $_SESSION['last_order_id'] = $row["id_zamowienia"];
            $result->free_result();
    }*/

    function getLastOrderId($connection) // get_last_order_id
    {
        // order.php - dodawanie zamówień (tabela zamówienia)
            // - pobranie id nowo wstawionego wiersza, korzysta z dodatkowej funkcji w celu zdobycia id nowo wstawianego zamówienia
            // query("SELECT id_zamowienia FROM zamowienia ORDER BY id_zamowienia DESC LIMIT 1", "get_id", "");

        // - pobranie id nowo wstawionego wiersza (nowo wstawianego zamówienia);
        $_SESSION["last_order_id"] = $connection->insert_id;
    }

    function get_last_book_id($polaczenie) { // admin\add-book-data.php;
        $_SESSION["last-book-id"] = $polaczenie->insert_id;
    }

    function addBookIntoWarehouse() {
        $_SESSION["add-book-successful"] = true;
    }

    /*function get_address_id($result) // wywołanie w funkcji register(); // rejestracja.php;
    {
        $row = $result->fetch_assoc();
            $_SESSION['last_adres_id'] = $row["adres_id"];
        $result->free_result();
    }*/

    /*function display_order_details($result) {

        // get book details on book.php paeg
        $row = $result->fetch_assoc();
        // echo "<br><br> row --> <br><br>";
        // print_r($row);
        // load the content from the external template file into string
        $orderDetails = file_get_contents("../template/book-page.php");
        // replace fields in $book string to book data from $result, display result content as HTML
        echo sprintf($orderDetails, $row["image_url"], $row["tytul"], $row["tytul"], $row["tytul"], $row["imie"], $row["nazwisko"], $row["rok_wydania"], $row["rating"], $row["liczba_ocen"], $row["liczba_komentarzy"], $row["nazwa_wydawcy"], $row["ilosc_stron"], $row["cena"], $row["id_ksiazki"], $row["id_ksiazki"], $row["id_ksiazki"], $row["id_ksiazki"], $status, $submit);
    }*/

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// admin -->

    function getAllOrders($result) { // get_all_orders // \admin\orders.php;

        // wszystkie zamówienia złożone przez klientów, przypisane do zalogowanego pracownika;

        require "../view/admin/order-header.php"; // table header;

        while($row = $result->fetch_assoc()) {
                        // echo "<br>" . $row["id_zamowienia"] . " | " . $row["data_zlozenia_zamowienia"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["kwota"] . " | " . $row["sposob_platnosci"] . " | " . $row["status"] . "<br><hr>";
            // load the content from the external template file into string
            $order = file_get_contents("../template/admin/orders.php");
            // replace fields in $order string to author data from $result, display result content as HTML
            echo sprintf($order, $row["id_zamowienia"], $row["data_zlozenia_zamowienia"], $row["imie"], $row["nazwisko"], $row["kwota"], $row["metoda_platnosci"], $row["id_zamowienia"], $row["status"], $row["id_zamowienia"], $row["id_zamowienia"], $row["id_zamowienia"], $row["id_zamowienia"]);
        }
        //$result->free_result();
    }

    function get_all_books($result) { // admin/books;
        while($row = $result->fetch_assoc()) {
            // load the content from the external template file into string
            $book = file_get_contents("../template/admin/books.php");
            // replace fields in $order string to author data from $result, display result content as HTML
            echo sprintf($book, $row["id_ksiazki"], $row["tytul"], $row["nazwa_kategorii"], $row["cena"], $row["imie"], $row["nazwisko"], $row["nazwa_magazynu"], $row["ilosc_dostepnych_egzemplarzy"], $row["id_ksiazki"],  $row["id_ksiazki"], $row["id_magazynu"], $row["id_ksiazki"], $row["id_magazynu"], $row["id_ksiazki"], $row["id_ksiazki"], $row["id_magazynu"]);
        }
        //$result->free_result();
    }

    function get_orders_boxes($result) {

        while($row = $result->fetch_assoc()) {
                        //echo "<br>" . $row["id_zamowienia"] . " | " . $row["data_zlozenia_zamowienia"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["kwota"] . " | " . $row["sposob_platnosci"] . " | " . $row["status"] . "<br><hr>";

            // load the content from the external template file into string
            $order = file_get_contents("../template/admin/archive-order-box.php");
            // replace fields in $order string to author data from $result, display result content as HTML
            echo sprintf($order, $row['id_zamowienia'], $row['id_zamowienia'], $row['id_zamowienia'], $row['id_zamowienia'], $row['id_zamowienia']);
        }
        //$result->free_result();
    }

    function getOrderDetailsAdmin($result) { // get_order_details_admin // \admin\order-details.php

        $i = 0;
                        // $row = $result->fetch_assoc();
        while($row = $result->fetch_assoc()) {
                        // echo "<br>" . $row["id_zamowienia"] . " | " . $row["data_zlozenia_zamowienia"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["kwota"] . " | " . $row["sposob_platnosci"] . " | " . $row["status"] . "<br><hr>";

            // load the content from the external template file into string
            $order = file_get_contents("../template/admin/order-details.php");

            // replace fields in $order string to author data from $result, display result content as HTML
            echo sprintf($order, $i, $row["id_ksiazki"], $row["id_magazynu"], $row["tytul"], $row["tytul"], $row["imie"], $row["nazwisko"],$row["rok_wydania"],$row["ilosc"], $row["cena"]);

            $i++;
        }

        //$result->free_result();
    }

    function getOrderSumAdmin($result) { // get_order_sum_admin // \admin\order-details.php

        $row = $result->fetch_assoc();

        $orderSum = file_get_contents("../template/admin/order-sum.php");

        // replace fields in $order string to author data from $result, display result content as HTML
        echo sprintf($orderSum, $row["kwota"]);

        //$result->free_result();
    }

    function getOrderSummary($result) { // get_order_summary // \admin\order-details.php

            $row = $result->fetch_assoc();

        $_SESSION["status"] = $row["status"];

        $orderSum = file_get_contents("../template/admin/order-summary.php");

        echo sprintf($orderSum, $row["metoda_platnosci"], $row["data_platnosci"], $row["forma_dostarczenia"]);

        $result->free_result();

    }

    function get_employee($result) {
            $row = $result->fetch_assoc();
        $_SESSION["employee_id"] = $row["id_pracownika"];
            $result->free_result();
    }

    function getEmployeeId($result) { // get_employee_id // order.php - pobranie id pracownika z najmniejszą liczbą zamówień;

        $row = $result->fetch_assoc();

        /*if($row === null) { // brak zwroconych. rekordow; (żaden pracownik nie był przypisany do żadnego zamówienia);
            // wybieramy losowego pracownika; $_SESSION["employee_id"];
            query("SELECT id_pracownika FROM pracownicy ORDER BY RAND() LIMIT 1", "get_employee", "");
        } else { // istnieje pracownik z najmniejszą liczbą przypisanych zamówień;

            $result->free_result();
        }*/

        $_SESSION["employee_id"] = $row["id_pracownika"];
    }

    /*function updateOrder($result) { // \admin\order-details.php
        $_SESSION["update-successful"] = false;
    }*/

    function showOrderStatusDate($result) {

        $row = $result->fetch_assoc();

        $orderStatus = array_keys($row)[0]; // "termin_dostawy" || "data_dostarczenia"

        switch ($orderStatus) {

            case "termin_dostawy":

                $orderDate = file_get_contents("../template/admin/order-status-date.php");
                echo sprintf($orderDate, "Termin dostawy: ", $row["termin_dostawy"]);

                if(isset(array_keys($row)[1]) & !empty(array_keys($row)[1])) { // "Data wysłania"
                    $sentDate = file_get_contents("../template/admin/order-status-date.php");
                    echo sprintf($sentDate, "Data wysłania: ", $row["data_wysłania_zamowienia"]);
                }
                break;

            case "data_dostarczenia":
                $orderDate = file_get_contents("../template/admin/order-status-date.php");
                echo sprintf($orderDate, "Data dostarczenia: ", $row["data_dostarczenia"]);

                break;
        }

    }

    /*function archiveOrder($result) { // \admin\orders.php
        $_SESSION["archive-successful"] = false; // zamiast Z.S --> zapytanie typu UPDATE -> funkcja query zwraca true/false;
    }*/

    function get_book_details($result) { // ̶ ̶a̶d̶m̶i̶n̶/̶b̶o̶o̶k̶-̶d̶e̶t̶a̶i̶l̶s̶.̶p̶h̶p̶?̶%̶s̶

        // \admin\book-details.php  $_SESSION["book-id"],
        //                          $_SESSION["warehouse-id"];

        $row = $result->fetch_assoc();

            // $_SESSION["status"] = $row["status"];

        $book = file_get_contents("../template/admin/book-details.php");

            /*echo sprintf($book, $row["tytul"], $row["imie"], $row["nazwisko"], $row["rok_wydania"], $row["cena"], $row["nazwa_wydawcy"], $row["opis"], $row["wymiary"], $row["ilosc_stron"], $row["oprawa"], $row["stan"], $row["srednia_ocen"], $row["image_url"], $row["liczba_ocen"], $row["ile_razy_sprzedana"], $row["nazwa_kategorii"], $row["nazwa_subkategorii"], $row["ilosc_dostepnych_egzemplarzy"], $row["nazwa"], $row["miejscowosc"], $row["numer_ulicy"], $row["kod_pocztowy"] );*/

        echo sprintf($book, $row["id_ksiazki"], $row["nazwa_magazynu"], $row["image_url"], $row["image_url"], $row["tytul"], $row["tytul"], $row["imie"], $row["nazwisko"], $row["rok_wydania"], $row["cena"], $row["nazwa_wydawcy"], $row["nazwa_kategorii"], $row["nazwa_subkategorii"], $row["wymiary"], $row["ilosc_stron"], ucfirst($row["oprawa"]), ucfirst($row["stan"]), $row["opis"], $row["srednia_ocen"], $row["liczba_ocen"], $row["ilosc_zamowien_w_ktorych_wystapila"], $row["liczba_klientow_posiadajacych_w_koszyku"], $row["liczba_sprzedanych_egzemplarzy"], $row["nazwa_magazynu"], $row["kraj"], $row["wojewodztwo"], $row["miejscowosc"], $row["ulica"], $row["numer_ulicy"], $row["kod_pocztowy"], $row["kod_miejscowosc"], $row["ilosc_dostepnych_egzemplarzy"]);

        //$_SESSION["warehouse-id"] = $row["nazwa_magazynu"]; // przycisk "edytuj" --> book-details.php --> edit-book.php

        // pole "ile_razy_sprzedana" - określa liczbę zamówień, w których znalazła się ta książka. (nie jest to liczba sprzedanych sztuk!)

        //$result->free_result();
    }

    function createMagazineSelectList($result) { // \admin\add-book.php; \admin\books.php

        // create <option> elements inside <select> list based on warehouse names in database;
            // <option> elementy - są generowane dynamicznie na podstawie BD i danych o magazynach;
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["id_magazynu"].'">'.$row["nazwa"].'</option>';
        }
            /*echo '<option value="asdasd"></option>';*/ // remove thhat line in the future;
        //$result->free_result();
    }

    function createAuthorSelectList($result) { // \admin\add-book.php, \edit-book.php
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["id_autora"].'">'.$row["imie"]. " " . $row["nazwisko"] .'</option>';
        }
        $result->free_result();
    }

    function createPublisherSelectList($result) { // \admin\add-book, \edit-book.php
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["id_wydawcy"].'">'.$row["nazwa_wydawcy"].'</option>';
        }
        $result->free_result();
    }

    function createCategorySelectList($result) { // \admin\add-book.php, edit-book.php;
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["id_kategorii"].'">'.$row["nazwa"].'</option>';
        }
        $result->free_result();
    }

    function createSubcategorySelectList($result) { // \admin\add-book, \edit-book.php
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["id_subkategorii"].'">'.$row["nazwa"].'</option>';
        }
        $result->free_result();
    }

    // powyższe kilka funkcji można zoptymalizować tak, aby była to jedna (np używając tablicy num. a nie assocjacyjnych);

    function countBooksAvailable($result) { // zlicz sumę wszystkich książek w magazynie
        // \admin\admin.php
            $row = $result->fetch_assoc();
        $_SESSION["booksAmount"] = $row["liczba_ksiazek"];
    }

    function countpendingOrders($result) { // \admin\admin.php
        // liczba oczekujących zamówień (pending) --> status = "Oczekujące ..."
            $row = $result->fetch_assoc();
        $_SESSION["pendingOrders"] = $row["liczba_zamowien"];
    }

    function countTotalSales($result) { // zlicz sumę wszystkich książek w magazynie
            // \admin\admin.php
            $row = $result->fetch_assoc();
        $_SESSION["totalSale"] = $row["totalSale"];
    }

    function getSubcategories($result) { //  \admin\edit-book.php,  \user\index.php (!)

        // returns data in JSON format - instead text/html (as all other functions in this code);
            // subcategories - array();
            // add each subcategory - as an object to the array;
            // return array as JSON-encoded response;

        //                     $result ->
        // id_subkategorii	    nazwa	     id_kategorii
        //     1	        Programowanie	     4
        //     2	        Web development	     4

        //          $result for \user\index.php ->
        // id_subkategorii	    nazwa	     nazwa_kategorii AS id_kategorii
        //     1	        Programowanie	                 4
        //     2	        Web development	                 4

        $subcategories = []; // array();

        while($row = $result->fetch_assoc()) {
            // define an associative array (key-value pairs)
/*$subcategory = [
    'id' => $row['id_subkategorii'],
    'name' => $row['nazwa'],
    'category_id' => $row['id_kategorii']
];*/

            $subcategory = [
                0 => $row['id_subkategorii'],
                1 => $row['nazwa'],
                2 => $row['id_kategorii']
            ];

            $subcategories[] = $subcategory; // This line appends the $subcategory array as a new element to the end of the $subcategories array during each iteration of the loop.
        }

        header('Content-Type: application/json'); // return DATA as JSON ;
        echo json_encode($subcategories); // show result data (JSON) ;

        //  json -->
        //
        //  [
        //     {
        //         "id": 1,
        //         "name": "Programowanie",
        //         "category_id": 4
        //     },
        //     {
        //         "id": 2,
        //         "name": "Web development",
        //         "category_id": 4
        //     }
        // ]
    }

    function validateFile($fileName) { // $fileName - name attribute of input type="file";

        $file = $_FILES[$fileName]; // validate and upload file; // sprawdzanie poprawności przesłanych plików

        if (
            isset($file["name"]) && !empty($file["name"]) &&
            isset($file["full_path"]) && !empty($file["full_path"]) &&
            isset($file["type"]) && !empty($file["type"]) &&
            isset($file["tmp_name"]) && !empty($file["tmp_name"]) &&
            $file['error'] === UPLOAD_ERR_OK &&
            $file['size'] !== 0
        ) { // file exists - has been sent (uploaded successfully);

            $filename = $file["name"];    // "001.png";
            $tmpPath = $file["tmp_name"]; // name of temp directory in server that store uploaded file;
                                          // C:\xampp\tmp\php39AB.tmp
            $destPath = "../assets/books/" . $filename; // ../assets/books/001.png;
            // file validation and sanitization;
            try {
                // validate file name
                if(!filter_var($file["name"], FILTER_SANITIZE_STRING)) {
                    throw new RuntimeException('Invalid file name');
                    //return false;
                }
                //   Undefined | Multiple Files | $_FILES Corruption Attack
                //   If this request falls under any of them, treat it invalid.
                // --> (Checking for invalid parameters or corrupted $_FILES array)
                if (
                    !isset($file['error']) ||
                    is_array($file['error'])
                ) {
                    throw new RuntimeException('Invalid parameters');
                    //return false;
                }
                switch ($file['error']) { // Check $_FILES['name']['error'] value.
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new RuntimeException('No file was uploaded'); // 4 - No file was uploaded;
                    case UPLOAD_ERR_INI_SIZE:  // file exceeds the upload_max_filesize directive in php.ini.
                    case UPLOAD_ERR_FORM_SIZE: //  file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form
                        throw new RuntimeException('Exceeded filesize limit');
                    default:
                        throw new RuntimeException('Unknown errors');
                        //return false;
                }

                // check size of file
                if ($file['size'] > 5000000) { // 5 MB
                    throw new RuntimeException('Exceeded filesize limit');
                    //return false;
                }

                // check the file MIME type (only allows "image/jpeg" and "image/png")
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                if (false === $ext = array_search(
                        $finfo->file($file['tmp_name']),
                        array(
                            'jpg' => 'image/jpeg',
                            'png' => 'image/png',
                        ),
                        true
                    )) {
                    throw new RuntimeException('Invalid file format (type)');
                    //return false;
                }

                // Move the uploaded file to the destination path
                    // You should name it uniquely.
                    // On this example, obtain safe unique name from its binary data.

                /*if(substr($fileName, 0, 3) === "add") {
                   // add new book image with unique name
                    if (!move_uploaded_file($tmpPath,
                        sprintf('../assets/books/%s.%s', sha1_file($file['tmp_name']), $ext)
                    )) {
                        throw new RuntimeException('Failed to move uploaded file');
                        //return false;
                    } else {
                        return true;
                    }
                } else { // "edit" - edit book;

                    //$destPath = "../assets/books/" . $_POST["edit-book-image_url"]; // ../assets/books/001.png;

                    if (!move_uploaded_file($tmpPath, $destPath)) {
                        throw new RuntimeException('Failed to move uploaded file');
                        //return false;
                    } else {
                        return true;
                    }
                }*/


                /*if (!move_uploaded_file($tmpPath, $destPath)) {  // A CO Z SANITYZACJĄ NAZWY PLIKU (?)
                    echo '<br>File uploaded successfully.';
                } else {
                    echo '<br>Error moving uploaded file.';
                }*/

                if (!move_uploaded_file($tmpPath, $destPath)) {
                    throw new RuntimeException('Failed to move uploaded file.');
                } else {
                    return true; // file uploaded successfully;
                }

                //echo 'File is uploaded successfully.';

                /*query("UPDATE ksiazki SET tytul='%s', id_autora='%s', rok_wydania='%s', cena='%s', id_wydawcy='%s', image_url='%s', opis='%s', oprawa='%s', ilosc_stron='%s', wymiary='%s', id_subkategorii='%s' WHERE ksiazki.id_ksiazki='%s'", "updateBookData", [$title, $author, $year, $price, $publisher, $filename, $desc, $cover, $pages, $dims, $subcategory, $bookId]);*/

            } catch (RuntimeException $e) {
                //echo $e->getMessage();
                // return false;
            }

        } else {                                   // file was not send (not uploaded);
            // error code (0 if no error occurred);
            //echo 'Error uploading file. (file NOT uploaded) - Error code: ' . $file['error'];
            return false;

        }
    }


    function addBook() {

    }

    function getBookData($result) {

        // returns data in JSON format - instead text/html (as all other functions in this code);
        // subcategories - array();
        // add each subcategory - as an object to the array;
        // return array as JSON-encoded response;

        $bookData = []; // array();

        while($row = $result->fetch_assoc()) {
            $data = [
                'id_ksiazki' => $row['id_ksiazki'],
                'tytul' => $row['tytul'],
                'id_autora' => $row['id_autora'],
                'rok_wydania' => $row['rok_wydania'],
                'cena' => $row['cena'],
                'id_wydawcy' => $row['id_wydawcy'],
                'image_url' => $row['image_url'],
                'opis' => $row['opis'],
                'oprawa' => $row['oprawa'],
                'ilosc_stron' => $row['ilosc_stron'],
                'wymiary' => $row['wymiary'],
                'id_subkategorii' => $row['id_subkategorii'],
                'id_kategorii' => $row['id_kategorii'],
                'id_magazynu' => $row['id_magazynu'],
                'ilosc_egzemplarzy' => $row['ilosc_egzemplarzy']
            ];
            $bookData[] = $data; // what does that line do ? how does it do ?
        }
        //header('Content-Type: application/json');
        //echo json_encode($bookData);
        return $bookData;
    }

    function getCategoryData($result) {  // \admin\edit-category.php

        // returns data in JSON format - instead text/html (as all other functions in this code);
        // return array as JSON-encoded response;

        $categoryData = []; // array();

        while($row = $result->fetch_assoc()) {
            $data = [
                'id_kategorii' => $row['id_kategorii'],
                'nazwa' => $row['nazwa']
            ];
            $categoryData[] = $data; // what does that line do ? how does it do ?
        }
        //header('Content-Type: application/json');
        echo json_encode($categoryData);
    }

    function verifyCategoryNameTaken($result) {

        // \admin\edit-category-data.php

        $_SESSION["categoryNameTaken"] = true;
    }

    function updateBookData($result) { // \admin\edit-boook.php
        $_SESSION["update-book-successful"] = false;
    }

    /*function updateCategoryName($result) {
        $_SESSION["update-category-successful"] = true;
    }*/


    /*function createEditForm($result) {
        $row = $result->fetch_assoc();

        //$_SESSION["status"] = $row["status"];

        $bookForm = file_get_contents("../template/admin/edit-book.php");

        echo sprintf($bookForm, $row["tytul"], $row["rok_wydania"], $row["opis"], $row["ilosc_stron"], $row["wymiary"]);

        $result->free_result();
    }*/

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// Funkcja ustanawiająca połączenie z bazą danych i realizująca zapytanie sql
    // "służy do uzyskania wyników z bazy danych i przekazania ich do zewnętrznej funkcji w celu dalszej obróbki"

	// $query - zapytanie sql
    // $fun - funkcja wyświetlająca dane
    //        nazwa funkcji, która zostanie wywołana, gdy zapytanie zostanie wykonane pomyślnie.
    // $value - wartość będąca parametrem funkcji sprintf / vsprintf (pojedyncza zmienna lub TABLICA)

    function displayBooks($category) // $_SESSION["kategoria"] - nazwa kategorii (string)
    {
        // alias dla funkcji query() -> index.php
        if($category == "Wszystkie")
        {
                                    //query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki", "get_books", "");
                                    /*query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania,
                                    ks.kategoria,
                                    ks.rating, au.imie, au.nazwisko FROM ksiazki AS ks, autor AS au WHERE ks.id_autora = au.id_autora", "get_books", "");/*
                                    //query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.rating, au.imie, au.nazwisko FROM ksiazki AS ks, autor AS au WHERE kategoria LIKE '%s' AND ks.id_autora = au.id_autora", "get_books",  $_SESSION['kategoria']);*/

            /*query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating,
                                     kt.nazwa, sb.id_kategorii,
                                        au.imie, au.nazwisko
                                     FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb
                                     WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii
                                     ", "get_books", "");*/

            // dodanie statusu - "dostępna / niedostępna" -->

            query("SELECT
                            ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, 
                            kt.nazwa, sb.id_kategorii, 
                            au.imie, au.nazwisko,
                            SUM(warehouse_books.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                        FROM 
                            books AS ks
                        JOIN 
                            author AS au ON ks.id_autora = au.id_autora
                        JOIN 
                            subcategories AS sb ON ks.id_subkategorii = sb.id_subkategorii
                        JOIN 
                            categories AS kt ON sb.id_kategorii = kt.id_kategorii
                        LEFT JOIN 
                            warehouse_books ON warehouse_books.id_ksiazki = ks.id_ksiazki
                        GROUP BY ks.id_ksiazki", "getBooks", ""); // dane o ksiażce + ilość egzemplarzy na stanie
        }
        else
        {
            //query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '%s'", "get_books", $kategoria);
            /*query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, kt.nazwa, sb.id_kategorii, au.imie, au.nazwisko
                         FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb
                         WHERE kt.nazwa LIKE '%s' AND ks.id_autora = au.id_autora
                         AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii", "get_books",  $_SESSION['kategoria']);*/

            // dodanie statusu - "dostępna / niedostępna" -->

            query("SELECT
                            ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, 
                            kt.nazwa, sb.id_kategorii, 
                            au.imie, au.nazwisko,
                            SUM(warehouse_books.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                        FROM 
                            books AS ks
                        JOIN 
                            author AS au ON ks.id_autora = au.id_autora
                        JOIN 
                            subcategories AS sb ON ks.id_subkategorii = sb.id_subkategorii
                        JOIN 
                            categories AS kt ON sb.id_kategorii = kt.id_kategorii
                        LEFT JOIN 
                            warehouse_books ON warehouse_books.id_ksiazki = ks.id_ksiazki
                        WHERE kt.nazwa LIKE '%s'                                   
                        GROUP BY ks.id_ksiazki", "getBooks", $_SESSION["category"]); // dane o ksiażce + ilość egzemplarzy na stanie

        // WHERE kt.nazwa LIKE '%s'

        }
    }

    function displayBooksWithSubcategory($category, $subcategory) // nazwa kategorii (string), nazwa podkategorii (string)
    {
        // dodanie statusu - "dostępna / niedostępna" -->

        query("SELECT
                        ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, 
                        kt.nazwa, sb.id_kategorii, 
                        au.imie, au.nazwisko,
                        SUM(warehouse_books.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                    FROM 
                        books AS ks
                    JOIN 
                        author AS au ON ks.id_autora = au.id_autora
                    JOIN 
                        subcategories AS sb ON ks.id_subkategorii = sb.id_subkategorii
                    JOIN 
                        categories AS kt ON sb.id_kategorii = kt.id_kategorii
                    LEFT JOIN 
                        warehouse_books ON warehouse_books.id_ksiazki = ks.id_ksiazki
                    WHERE kt.nazwa LIKE '%s' AND sb.nazwa LIKE '%s'                                  
                    GROUP BY ks.id_ksiazki", "getBooks", [$_SESSION["category"], $_SESSION["subcategory"]]); // dane o ksiażce + ilość egzemplarzy na stanie
    }


    // Model - odpowiedzialny za reprezentację danych biznesowych, logikę aplikacji oraz dostęp do bazy danych.
    // W kontekście kodu, który podałeś, funkcja query() odpowiada za wykonanie zapytań do bazy danych, co oznacza, że pełni rolę modelu.

    // $fun - nazwa funkcji, która będzie obsługiwać wynik zapytania.

    function getClients($result) {

        while ( $row = $result->fetch_row() ) {
            foreach ($row as $value) {
                if($value != ' ') {
                    echo $value . "<br>";
                }

            }

        }

    }

function query($query, $fun, $values) {

// $query - SQL - "SELECT imie, nazwisko FROM klienci";

// $fun   - callback function
// - wywołaj funkcję tylko wtedy, jeśli $result --> - jest obiektem, który posiada conajmniej jeden wiersz (num_rows) <-- zapytania typu SELECT
//                                                  - posiada wartość == "true" (bool) <-- dla zapytań INSERT, UPDATE, DELETE
//                                                    ORAZ stan BD został zmieniony (zaktualizowany, wstawiony, usunięty wiersz)

// jeśli nie udało się wykonać zapytania, $result zwróci false;
// ---------------------------------------------------------------------------------------------------------------------

    require "connect.php";

    mysqli_report(MYSQLI_REPORT_STRICT);

    try {

        $connection = new mysqli($host, $db_user, $db_password, $db_name);

        if ($connection->connect_errno) {

            throw new Exception(mysqli_connect_errno()); // failed to connect to DB;

        } else {

            if (!is_array($values)) {
                $values = [$values];
            }

            for($i = 0; $i < count($values); $i++) {
                $values[$i] = mysqli_real_escape_string($connection, $values[$i]);
            }

            if ($result = $connection->query(vsprintf($query, $values))) {

                if ($result instanceof mysqli_result) {

                    if ($result->num_rows) {

                        //$fun($result);
                        return $fun($result);

                    } /*else {

                        // nie zrwócono żadnych wierszy ! (SELECT)
                    }*/

                } elseif ($result === true) { // (bool - true) - dla zapytań INSERT, UPDATE, DELETE ...

                    if ($connection->affected_rows) { // && $fun

                        if ($fun) {

                            $fun($connection); // jeśli wymagane jest pobranie id ostatnio wstawionego wiersza - wywołaj funkcję;

                        } else {

                            return true;

                        }

                    } else {

                        return false;

                    }
                }

            } else {

                throw new Exception($connection->error);

            }

            $connection->close();

        }

    } catch(Exception $e) {

        return false;

    }

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// backup

/*function query($query, $fun, $value)
{
    // obsługa błędów,
    // bezpieczeństwo - SQL injection

    require "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try
    {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

        if($polaczenie->connect_errno) {

            throw new Exception(mysqli_connect_errno());
        }
        else { // udane połączenie





            if(gettype($value) !== "array") { // jeśli to nie jest tablica

                $value = [$value];            // zrób z niej tablicę
            }
            //if (!is_array($value)) {
            //	$values = [$values];
            //}
            for($i = 0; $i < count($value); $i++) { // sanitization;

                $value[$i] = mysqli_real_escape_string($polaczenie, $value[$i]);
            }

            if($result = $polaczenie->query(vsprintf($query, $value))) // $query - zapytanie,
            {                                                          // $value - tablica parametrów do vsprintf

                // zamiana na switch ?

                //echo "<br><br> query() --> " . $query . "<br><br>";



                // można zoptymalizować poniższy kod, bo użycie funkcji jest powtórzone ->
                if(gettype($result) != "object") { // ̶b̶r̶a̶k̶ ̶z̶w̶r̶ó̶c̶o̶n̶y̶c̶h̶ ̶w̶y̶n̶i̶k̶ó̶w̶

                    // $result nie jest obiektem, jest to wartość logiczna "1" ;
                    // result print_r -->
                    //    1
                    // result var_dump-->
                    //    bool(true)
                    //gettype(result) -->
                    //    boolean
                    // ✓✓✓ INSERT, UPDATE ... (bez dodatkowej funkcji) ;

                    //echo "<br>1390 - result NIE jest obiektem ! (jest true/false) - boolean <br>";

                    //echo '<script>console.log("INSERT, UPDATE - 1379 - result NIE jest obiektem - \n\n'.$query.'\n\n")</script>';
                    //echo '<script>console.log("INSERT, UPDATE - 1379 - result NIE jest obiektem - \n\n")</script>';
                    // echo '<script>console.log("'.$query.'\n\n")</script>';

                    if($fun != "") {

                        // pytanie -> czy każda funkcja typu INSERT/UPDATE (korzystająca z + dod.funkcji) wymaga $polaczenie w jakimś celu ?

                        // ✓✓✓ INSERT, UPDATE  + dodatkowa_funkcja;

                        //echo '<script>console.log("INSERT, UPDATE + dodatkowa_funkcja - 1385 - result NIE jest obiektem - \n\n")</script>';
                        //echo '<script>console.log("'.$query.'\n\n")</script>';

                        //echo "<br>1394<br>";;

                        //echo "<br> 1388 <br>"; exit();

                        $fun($result, $polaczenie);
                    }

                } else {  // $result jest obiektem

                    //echo "<br>1403 - result jest obiektem<br>";

                    //echo '<script>console.log("SELECT - 1397 - result jest obiektem - \n\n")</script>';
                    //echo '<script>console.log("'.$query.'\n\n")</script>';

                    //echo "<br>623<br>"; //exit();
                    // SELECT
                    $num_of_rows = $result->num_rows; // ilość zwróconych wierszy

                    //echo "<br>num_of_rows --> " . $num_of_rows . "<br>";

                    if($num_of_rows > 0) // znaleziono rekordy
                    {

                        //echo '<script>console.log("SELECT - 1409 - result jest obiektem, num_of_rows > 0 - \n\n")</script>';
                        //echo '<script>console.log("'.$query.'\n\n")</script>';
                        //echo "<br>1416 - znaleziono rekordy - num_rows >  0 <br>"; exit();

                        //echo "<br>625<br>"; //exit();

                        //                            if ( isset($_POST["year-min"]) && !empty($_POST["year-min"]) && isset($_POST["year-max"]) && !empty($_POST["year-max"])
                        //                            ) {
                        //                                echo "<br><hr><br> query ( ) -> " . $query . "<br><hr>"; // testowanie wyszukiwania zaawansowanego
                        //                                //exit();
                        //                            }
                        //
                        //                            echo "<br><hr><br> num_of_rows -> " . $num_of_rows . "<br><hr>";

                        if($fun != "") {

                            // echo '<script>console.log("SELECT - 1409 - result jest obiektem, num_of_rows > 0 + dodatkowa funkcja - \n\n")</script>';

                            $fun($result); // register_verify_email (rejestracja - sprawdzenie czy email jest zajęty ?),
                        }

                    }
                    else { // brak zwróconych rekordów

                        //echo "<br>1747<br>"; // exit();

                        //echo '<h3>Brak wyników</h3>'; // brak zwróconych rekordów (np 0 zwróconych wierszy); // zamiast "echo" można użyć "return"

                        //echo "<br>1435 - brak zwróconych rekordów - num_rows == 0 <br>"; exit();

                        //echo '<script>console.log("SELECT - 1432 - result jest obiektem, \n brak zwróconych rekordów - num_rows == 0 - \n\n")</script>';
                        //echo '<script>console.log("'.$query.'\n\n")</script>';


                        if($fun != "" && $fun != "register_verify_email" && $fun != "check_email" && $fun != "verify_token" && $fun != "aaa" && $fun != "verify_rate_exists"
                            && $fun != "orderDetailsVerifyOrderExists"

                        ) {   // logowanie.php ✓ -> podany zły email (num_rows ---> 0 (brak) zwr. rekordów;

                            // echo '<script>console.log("SELECT - 1432 - result jest obiektem, \n brak zwróconych rekordów - num_rows == 0\n\n wywołanie dodatkowej funkcji - \n\n")</script>';
                            //echo '<script>console.log("'.$query.'\n\n")</script>';

                            // orderDetailsVerifyOrderExists - admin/order-details.php - PRG

                            //echo "<br>1767<br>";
                            //echo "<br>result --> <br>";
                            //echo "<br><hr><br>";
                            //print_r($result); echo "<br><hr><br>";
                            //var_dump($result);

                            //exit();

                            $fun($result);
                        }

                        // check_email - (zmiana danych użytkownika) - validate_user_data.php - SPRAWDZA, CZY ISTNIEJE TAKI EMAIL
                        // - jeśli istnieje ($result zwrócił rekordy) - ✓ przestawia zmienną $_SESSION['email_exists'] na "true"
                        // - jeśli NIE istnieje ($result NIE zwrócił rekordów) - NIE POWINNA WYWOŁAĆ SIĘ TA FUNKCJA ($fun - check_email);




                        // z drugiej strony nie chce, aby wywołało funkcję "register_verify_email jesli nie znaleziono takich istniejących maili w BD (przy rejestracji ...) a zatem tutaj funkcja "register_ver_email" nie powinna zostać wykonana !

                        // dla register_verify_email (rejestracja) nie powinna wykonać się funkcja $fun !

                        // Kiedy jest potrzeba aby wywołać funkcję $fun gdy nie zwrócono żadnych rekordw ?
                        // -> dla logowanie.php (patrz wyżej)

                        // (!) dla dodawania książek NIE DZIAŁA !
                    }
                }
            }
            else // nie udało się zrealizować zapytania
            {
                throw new Exception($polaczenie->error);
            }

            $polaczenie->close();
        }
    }
    catch(Exception $e) // exception - wyjątek; przechwycenie i obsługa wyjątku;
    {
        echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności ] </div>'; // użycie "return" zamisat echo
        echo '<br><span style="color:red">Informacja developerska: </span>'.$e; // wyświetlenie komunikatu błędu - dla deweloperów
        exit(); // (?)
    }

    //exit();

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //return "<br> query = ".$query.", type = ".$type."<br>";
}*/


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*function query($query, $fun, $value)
{
    require "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try
    {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

        if($polaczenie->connect_errno) {
            throw new Exception(mysqli_connect_errno());
        }

        if(!is_array($value)) {
            $value = [$value];
        }

        foreach($value as &$val) {
            $val = mysqli_real_escape_string($polaczenie, $val);
        }
        unset($val);

        if($result = $polaczenie->query(vsprintf($query, $value)))
        {
            if(!is_object($result)) {
                if($fun != "") {
                    $fun($result);
                }
            } else {
                $num_of_rows = $result->num_rows;

                if($num_of_rows > 0) {
                    $fun($result);
                } else {
                    if($fun != "" && !in_array($fun, ["register_verify_email", "check_email", "verify_token", "cart_verify_book", "verify_rate_exists"])) {
                        $fun($result);
                    }
                }
            }
        } else {
            throw new Exception($polaczenie->error);
        }

        $polaczenie->close();
    }
    catch(Exception $e)
    {
        echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności ] </div>';
        echo '<br><span style="color:red">Informacja developerska: </span>'.$e;
        exit();
    }
}*/
?>


