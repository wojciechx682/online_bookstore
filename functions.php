
<?php

//  ______  ___   __   __       ________ ___   __   ______        _______  ______  ______  ___   ___  ______  _________ ______  ______   ______
// /_____/\/__/\ /__/\/_/\     /_______/Y__/\ /__/\/_____/\     /_______/\/_____/\/_____/\/___/\/__/\/_____/\/________/Y_____/\/_____/\ /_____/\
// \:::_ \ \::\_\\  \ \:\ \    \__.::._\|::\_\\  \ \::::_\/_    \::: _  \ \:::_ \ \:::_ \ \::.\ \\ \ \::::_\/\__.::.__\|:::_ \ \:::_ \ \\::::_\/_
//  \:\ \ \ \:. `-\  \ \:\ \      \::\ \ \:. `-\  \ \:\/___/\    \::(_)  \/\:\ \ \ \:\ \ \ \:: \/_) \ \:\/___/\ \::\ \  \:\ \ \ \:(_) ) )\:\/___/\
//   \:\ \ \ \:. _    \ \:\ \____ _\::\ \_\:. _    \ \::___\/_    \::  _  \ \:\ \ \ \:\ \ \ \:. __  ( (\_::._\:\ \::\ \  \:\ \ \ \: __ `\ \::___\/_
//    \:\_\ \ \. \`-\  \ \:\/___/Y__\::\__/\. \`-\  \ \:\____/\    \::(_)  \ \:\_\ \ \:\_\ \ \: \ )  \ \ /____\:\ \::\ \  \:\_\ \ \ \ `\ \ \:\____/\
//     \_____\/\__\/ \__\/\_____\|________\/\__\/ \__\/\_____\/     \_______\/\_____\/\_____\/\__\/\__\/ \_____\/  \__\/   \_____\/\_\/ \_\/\_____\/

                        // Funkcje php - połączenie z bazą danych,
                        //			     wysyłanie zapytań (query) do bazy danych

                        // Blokada dostępu do adresu "localhost/../functions.php" przez URL
                        $currentPage = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                        if ($_SERVER['REQUEST_METHOD'] == "GET" && strcmp(basename($currentPage), basename(__FILE__)) == 0)
                        {
                            http_response_code(404);
                            //include('index.php'); // provide your own 404 error page
                            header('Location: index.php');

                            die(); /* remove this if you want to execute the rest of
                                      the code inside the file before redirecting. */
                        }

	/*function advanced_search($result)
	{
        // - .../index2.php
		get_books($result);
	}*/

    function get_authors($result)
    {
        // tworzy elementy listy <li> - w których kazdy wyświetli imie i nazwisko autora ;

            echo '<li>
                      <label>
                         <input type="checkbox" name="author-checkbox" class="author-checkbox" id="all-authors">Wszyscy
                      </label>
                  </li>';

            /*echo "<br>40<br>";*/
            while ($row = $result->fetch_assoc())
            {
                // load the content from the external template file into string
                $author = file_get_contents("../template/content-authors.php");

                // replace fields in $author string to author data from $result, display result content as HTML
                echo sprintf($author, $row['id_autora'], $row["imie"], $row["nazwisko"], $row["imie"], $row["nazwisko"]);
            }

        $result->free_result();
    }

    function get_authors_adv_search($result)
    {
        // \user\index.php - header -> advanced_search -> <select> - lista autorów - imie i nazwisko autora

            /*echo "\n".'<option value="'.$category_name.'">'.$category_name.'</option>';*/
        while ($row = $result->fetch_assoc()) {
            //echo "\n".'<option value="'.$row['id_autora'].'">'.$row['imie']." ".$row['nazwisko'].'</option>';

            // load the content from the external template file into string
            $author = file_get_contents("../template/adv-search-authors.php");

            // replace fields in $author string to author data from $result, display result content as HTML
            echo sprintf($author, $row['id_autora'], $row["imie"], $row["nazwisko"]);
        }
        $result->free_result();

//        while ($row = $result->fetch_assoc())
//        {
//            // load the content from the external template file into string
//            $author = file_get_contents("../template/adv-search-authors.php");
//
//            // replace fields in $author string to author data from $result, display result content as HTML
//            echo sprintf($author, $row['id_autora'], $row["imie"], $row["nazwisko"]);
//        }
//
//        echo '</ul>';
//        $result->free_result();
    }

	function get_categories($result) // \user\index.php - top-nav - ol;
	{
        // header -> n-top-nav-content - wyświetla listę kategorii; wypisuje elementy listy <li> - wewnątrz kategorii (top_nav - n-top-nav-content);

		    $category_name = "Wszystkie";
		/*echo "\n".'<li><a href="index.php?kategoria='.$category_name.'">'.$category_name.'</a></li>';*/ //  ̶Z̶a̶m̶i̶a̶n̶a̶ ̶n̶a̶ ̶j̶Q̶u̶e̶r̶y̶ ̶?̶ ̶e̶v̶e̶n̶t̶ ̶l̶i̶s̶t̶e̶n̶e̶r̶ ̶?̶

		echo "\n".'<li>                
                 <form method="post" action="index.php">
                                <input type="hidden" name="kategoria" value="'.$category_name.'">
                                <button class="submit-book-form" type="submit">'.$category_name.'</button>
                           </form>                          
                </li>';

        /*echo '<span style="float: left;">abc</span>';*/
        /*echo '<div style="clear: both;"></div>';*/

		while ($row = $result->fetch_assoc()) // tyle ile jest kategorii;
		{
		  	                    // echo '<li><a href="index.php?kategoria='.$row['kategoria'].' ">'.$row['kategoria'].'</a></li>';
            // echo "\n".'<li><a href="index.php?kategoria='.$row['nazwa'].'">'.$row['nazwa'].'</a></li>';
            echo "\n".'<li>
                           <form method="post" action="index.php">
                                <input type="hidden" name="kategoria" value="'.$row["nazwa"].'">
                                <button class="submit-book-form" type="submit">'.$row["nazwa"].'</button>
                           </form>
                       </li>';
            // <a href="index.php?kategoria='.$row['nazwa'].'">'.$row['nazwa'].'</a>
            /*<!-- ✓✓✓ GET -> na POST <form> - użycie techniki PRG <-------------------- -->*/

            //echo '<span style="float: left;">abc</span>';
            /*echo '<div style="clear: both;"></div>';*/
		}
        $result->free_result();
	}

    function get_categories_adv_search($result) // \user\index.php
    {
            // header -> advanced_search -> <select> - lista kategorii;
        $category_name = "Wszystkie";
            echo "\n".'<option value="'.$category_name.'">'.$category_name.'</option>';
        while ($row = $result->fetch_assoc()) {
            echo "\n".'<option value="'.$row['nazwa'].'">'.$row['nazwa'].'</option>';
        }
        $result->free_result();
    }

	function get_books($result)
	{
        // content -> wyświetla wszystkie książki

        echo '<div id="content">';
            echo '<div id="content-books">';

        $i = 0;

            while ($row = $result->fetch_assoc())
            {

            //		  	echo '<div id="book'.$i.'" class="book">';
            //			  	echo '<div class="title">'.$_SESSION['tytul'].'</div><br>';
            //			  	echo '<div class="price">'.$_SESSION['cena'].'</div><br>';
            //			  	echo '<div class="year">'.$_SESSION['rok_wydania'].'</div><br>';
            //			  	echo '<form action="add_to_cart.php" method="post">';
            //			  		echo '<input type="hidden" name="id_ksiazki" value="'.$_SESSION['id_ksiazki'].'">';
            //			  		echo '<input type="hidden" name="koszyk_ilosc" id="koszyk_ilosc"  value="1">';
            //			  		echo '<button type="submit" name="your_name" value="your_value" class="btn-link">Dodaj ko koszyka</button>';
            //			  	echo '</form>';
            //		  	echo '</div>';

            //            $book = '
            //                <div id="book%s" class="book">
            //                    <div class="title">%s</div><br>
            //                    <div class="price">%s</div><br>
            //                    <div class="year">%s</div><br>
            //                    <form action="add_to_cart.php" method="post">
            //                        <input type="hidden" name="id_ksiazki" value="%s">
            //                        <input type="hidden" name="koszyk_ilosc" id="koszyk_ilosc"  value="1">
            //                        <button type="submit" name="your_name" value="your_value" class="btn-link">Dodaj ko koszyka</button>
            //                    </form>
            //                </div>
            //            ';

                // load the content from the external template file into string
                $book = file_get_contents("../template/content-books.php");

                    /*if($row["ilosc_egzemplarzy"] == null) {
                        $row["ilosc_egzemplarzy"] = 'niedostępna';
                    } else {
                        if($row["ilosc_egzemplarzy"] > 0) {
                            $row["ilosc_egzemplarzy"] = 'dostępna';
                        }
                    }*/
                $row["ilosc_egzemplarzy"] = ($row["ilosc_egzemplarzy"] === null) ? 'niedostępna' : ($row["ilosc_egzemplarzy"] > 0 ? 'dostępna' : 'niedostępna');

                $button = ($row["ilosc_egzemplarzy"] === 'dostępna') ? '' : 'disabled'; // "Dodaj do koszyka" button;

                // replace fields in $book string to book data from $result, display result content as HTML
                echo sprintf($book, $i, $row["id_ksiazki"], $row["image_url"], $row["tytul"], $row["tytul"], $row["id_ksiazki"], $row["tytul"], $row["cena"], $row["rok_wydania"], $row["imie"], $row["nazwisko"], $row["rating"], $row["ilosc_egzemplarzy"], $row["id_ksiazki"], $button);

                $i++;
            }

            echo '</div>'; // #content-books;
        echo '</div>'; // #content;

		$result->free_result();
	}

    function get_book($result) {

        // get book details on book.php page ;

        $row = $result->fetch_assoc();

       /* echo "<br><br> row --> <br><br>";
        print_r($row);*/

        // load the content from the external template file into string
        $book = file_get_contents("../template/book-page.php");

                // wstaw do Z.S wartości zwrócone z Bazy (!);
                $_SESSION["avg_rating"] = $row["rating"]; // average book rating - "4.25" ;
                $_SESSION["liczba_ocen"] = $row["liczba_ocen"]; // number of reviews ;
                    $_SESSION["rating"] = $row["rating"];     // average book rating - "4.25" ;
                $_SESSION["id_ksiazki"] = $row["id_ksiazki"];

        if ( isset($_SESSION["rate-error"]) ) { // komunikat - błąd przy dodawaniu oceny przez klienta ;

            $message = $_SESSION["rate-error"];
                unset($_SESSION["rate-error"]);

        } elseif ( isset($_SESSION["rate-success"]) ) {

            $message = $_SESSION["rate-success"];
                unset($_SESSION["rate-success"]);

        } else {

            $message = "";
        }

                if( isset($row["liczba_egzemplarzy"]) && ! empty($row["liczba_egzemplarzy"]) ) { // wyświetlenie statusu o dostępności książki (na bazie staów magazynowych) + odpowiednia akcja na przycisku dodania do koszyka (jeśli nie ma ksążki w magazynie - wyłączenie przycisku dodania ksiązki do koszyka);

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
        // ../template/book-page.php ;

        // pobranie komentarzy (treść, data, imie_klienta, ocena (rt)) - należących do tej książki (id_ksiazki);
        query("SELECT km.tresc, km.data, kl.imie, rt.ocena FROM komentarze AS km, klienci AS kl, ratings AS rt WHERE km.id_klienta = kl.id_klienta AND rt.id_klienta = kl.id_klienta AND km.id_ksiazki = rt.id_ksiazki AND km.id_ksiazki = '%s'", "get_comments", $_SESSION["id_ksiazki"]);
        // (!) $_SESSION["comments"]; - ta zmienna zawiera wykorzystany szablon HTML (przechowuje wszystkie komentarze danej książki !);

        $book_page_tabs = file_get_contents("../template/book-page-tabs.php"); // wczytanie szablonu na sekcje (karty) z dodatkowymi informacjami o książce ;

        echo sprintf($book_page_tabs, $row["tytul"], $row["imie"], $row["nazwisko"], $row["nazwa_wydawcy"], $row["ilosc_stron"], $row["rok_wydania"], $row["wymiary"], $row["oprawa"], $row["stan"], $row["id_ksiazki"], $row["rating"], $message, implode($_SESSION["comments"]));

        // file_put_contents("../template/book-page-tabs-modified.php", $modified);
    }

    function get_ratings($result) { // user\book.php   // "ocena", "liczba_ocen" ;

        // wstawia do tablicy sesyjnej - ilości poszczególnych ocen dla książki ->   5 -> 4, 4 -> 26, 3 -> 15, ....
        // $_SESSION["ratings"] -> [5] => 2 [4] => 1, ... ;

        //    ocena      liczba_ocen
        //      5 	         2
        //      4 	         1
        //      3 	         3
        //      2 	         2

        $_SESSION["ratings"] = []; // create new empty array ;

        while($row = $result->fetch_assoc()) { // "ocena", "liczba_ocen";

            $book_rating = $row['ocena'];
            $num_of_ratings = $row['liczba_ocen'];

            $_SESSION['ratings'][$book_rating] = $num_of_ratings;

        }  //  ̶$̶_̶S̶E̶S̶S̶I̶O̶N̶[̶"̶r̶a̶t̶i̶n̶g̶s̶"̶]̶ ̶-̶>̶ ̶[̶5̶]̶ ̶=̶>̶ ̶2̶ ̶[̶4̶]̶ ̶=̶>̶ ̶1̶,̶ ̶.̶.̶.̶ ̶;̶
           // $_SESSION["ratings"] -> Array ( [5] => 2 [4] => 1 [3] => 3 [2] => 2 ) ;

        $result->free_result();
    }

    function verify_rate_exists($result) {

        // function for cheking if comment / or rate already exists for that book made by that clinet
            //$row = $result->fetch_assoc();

        $_SESSION["rate_exists"] = true;
    }

    function get_comments($result) { // "km.treść", "km.data", "km.imie", "km.ocena" ;

        // ̶$̶i̶ ̶=̶ ̶0̶;̶

        // Mauris venenatis quis metus non faucibus. Duis id ... 	2023-06-23 00:30:04 	Adam 	3
        // Maecenas nulla est, semper vestibulum bibendum ac,... 	2023-06-23 00:30:46 	Adam 	4
        // Lorem ipsum dolor sit amet, consectetur adipiscing... 	2023-06-23 00:32:29 	Adam 	5
        // Fusce a laoreet est. Pellentesque habitant morbi t... 	2023-06-23 00:33:11 	Adam 	5
        // Super książka polecam :) 	                            2023-06-23 09:56:58 	Adam 	3
        // Super książka polecam :) 	                            2023-06-23 09:57:34 	Adam 	3

        $_SESSION["comments"] = []; // stworzenie nowej pustej tablicy ;

        while ( $row = $result->fetch_assoc() )
        {
            // load the content from the external template file into string ;
            $comment = file_get_contents("../template/book-comment.php");

            //  ̶r̶e̶p̶l̶a̶c̶e̶ ̶f̶i̶e̶l̶d̶s̶ ̶i̶n̶ ̶$̶b̶o̶o̶k̶ ̶s̶t̶r̶i̶n̶g̶ ̶t̶o̶ ̶b̶o̶o̶k̶ ̶d̶a̶t̶a̶ ̶f̶r̶o̶m̶ ̶$̶r̶e̶s̶u̶l̶t̶,̶ ̶d̶i̶s̶p̶l̶a̶y̶ ̶r̶e̶s̶u̶l̶t̶ ̶c̶o̶n̶t̶e̶n̶t̶ ̶a̶s̶ ̶H̶T̶M̶L̶ ̶;̶ ̶
            $_SESSION["comments"][] = sprintf($comment, $row["imie"], $row["data"], $row["ocena"], $row["tresc"]); //  ̶r̶e̶t̶u̶r̶n̶ ̶

            //$̶i̶+̶+̶;̶
        }

        $result->free_result();
    }

    // ..\user\book - POST ;
    function get_book_id($result) {
        // get highest book-id from db to apply max-range filter in ..\book.php (POST);
            $row = $result->fetch_assoc();
        $_SESSION["max-book-id"] = $row["id_ksiazki"]; // "36"
    }

    // ..\admin\add-book-data, \edit-book-data - POST ;     \user\index.php - advanced-search - prg;
    function get_author_id($result) {
        // get highest author-id from db to apply max-range filter in ..\admin\add-book-data, \edit-book-data (POST), \user\index.php - adv-search - prg;
            $row = $result->fetch_assoc();
        $_SESSION["max-author-id"] = $row["id_autora"]; // "25"
    }

    function get_publisher_id($result) {
        // get highest publisher-id from db to apply max-range filter in ..\admin\add-book-data.php (POST);
            $row = $result->fetch_assoc();
        $_SESSION["max-publisher-id"] = $row["id_wydawcy"]; // "5"
    }

    function get_category_id($result) {
        // get highest category-id from db to apply max-range filter in ..\admin\add-book-data.php (POST);
            $row = $result->fetch_assoc();
        $_SESSION["max-category-id"] = $row["id_kategorii"]; // "7"
    }

    function get_magazine_id($result) {
        // get highest publisher-id from db to apply max-range filter in ..\admin\add-book-data.php, \edit-book-data.php (POST);
            $row = $result->fetch_assoc();
        $_SESSION["max-magazine-id"] = $row["id_magazynu"]; // "2"
    }

	function check_email($result)
	{
        // validate_user_data.php - (zmiana danych usera), sprawdza, czy istnieje juz taki email, ustawia zmienna sesyjną; (zmiana danych konta);
        // remove_account.php     - sprawdza, -----------||--------------  ---------||-----------;  (resetowanie hasła);
		$_SESSION['email_exists'] = true;

            $row = $result->fetch_assoc();    // reset_password.php - resetowanie hasła
            $_SESSION["imie"] = $row["imie"]; // reset_password.php - resetowanie hasła
	}

    function generate_token() {     // remove_account.php; - return      $token_hashed    OR     null;

        try {
            $token = bin2hex(random_bytes(32));    // generate random token;
            $token_hashed = hash("sha256", $token); // hash user token using sha256 algorithm;

            return $token_hashed; // Return the generated token;

        } catch (Exception $e) {
                // Exception handling code
                // You can handle the exception here, log it, display an error message, etc.
                // For example:
                    //echo "Wystąpił błąd podczas generowania tokenu. Spróbuj jeszcze raz";
                // You can also log the error using error_log() or any other logging mechanism.

            return null; // Return null or a default value to indicate failure
        }
    }

    function verify_token($result) // reset-password-form.php ;
    {
                $row = $result->fetch_assoc();
            $_SESSION["token_verified"] = true;
        $_SESSION["email"] = $row["email"];
        $_SESSION["exp_time"] = $row["exp_time"];
    }

//	function get_books_by_id($result) // koszyk_dodaj.php - nieużywane - do wyrzuczenia
//	{
//		while ($row = $result->fetch_assoc())
//		{
//		  	$_SESSION['tytul'] = $row["tytul"];
//		  	$_SESSION['cena'] = $row["cena"];
//		  	$_SESSION['rok_wydania'] = $row["rok_wydania"];
//		  	echo $_SESSION['tytul'].", || ".$_SESSION['cena'].", || ".$_SESSION['rok_wydania']." ";
//		}
//		$result->free_result();
//	}

	function count_cart_quantity($result) // add_to_cart.php - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku; \user\index.php - pobiera ilość książek klienta w koszyku;
	{
		$row = $result->fetch_assoc();

//		if($row['suma'] == NULL) {
//			$_SESSION['koszyk_ilosc_ksiazek'] = 0;
//		}
//		else {
//			$_SESSION['koszyk_ilosc_ksiazek'] = $row['suma'];
//		}

        $_SESSION['koszyk_ilosc_ksiazek'] = ($row['suma'] == NULL) ? 0 : $row['suma']; // SUM(ilosc) AS suma -> $row["suma"];

		$result->free_result();
	}

	function get_product_from_cart($result)	// koszyk.php, order.php
	{
		// $row[] -> kl.id_klienta, 		klient
		//		     ko.id_ksiazki,        	 	     koszyk
		//		     ko.ilosc, 						 koszyk
		//		     ks.tytul, 			    ksiazki
		//		     ks.cena,               ksiazki
		//		     ks.rok_wydania         ksiazki

		$_SESSION['suma_zamowienia'] = 0;

		$i = 0;

		while ($row = $result->fetch_assoc())
		{
//		  	echo '<div id="book'.$i.'"> <span class="book-details">';
//                echo '<div class="title">'.$row['tytul'].'</div>';
//                echo '<div class="price">'.$row['cena'].'</div>';
//                echo '<div class="year">'.$row['rok_wydania'].'</div></span>';
//
//		  		/*echo '<div class="quantity'.'">
//			  			 <b>Ilość = </b>'.$row['ilosc'];
//			  			 echo '<button type="button" onclick="increase()">+</button>';
//						 echo '<button type="button" onclick="decrease()">-</button>';
//	  			echo '</div>';*/
//
//	  			echo '<form class="change_quantity_form" id="change_quantity_form'.$row['id_ksiazki'].'" action="change_cart_quantity.php" method="post">';
//					echo '<input type="hidden" name="id_ksiazki" value="'.$row['id_ksiazki'].'">';
//					echo "<b>Ilosc: </b> ";
//						/*echo '<select name="koszyk_ilosc">';
//						    echo '<option value="1">1</option>';
//						    echo '<option value="2">2</option>';
//						    echo '<option value="3">3</option>';
//						    echo '<option value="4">4</option>';
//						    echo '<option value="5">5</option>';
//						echo '</select>';*/
//					//echo '<input type="text" id="koszyk_ilosc" name="koszyk_ilosc" value="'.$row['ilosc'].'">';
//					echo '<input type="text" id="koszyk_ilosc'.$row['id_ksiazki'].'" name="koszyk_ilosc" value="'.$row['ilosc'].'">';
//					echo '<button type="button" onclick="increase('.$row['id_ksiazki'].')">+</button>';
//					echo '<button type="button" onclick="decrease('.$row['id_ksiazki'].')">-</button>';
//					//echo '<br><br><input type="submit" value="Zapisz koszyk">';
//				echo '</form>';
//
//		  	echo '<form id="remove_book_form" action="remove_book.php" method="post">';
//		  		echo '<input type="hidden" name="id_klienta" value="'.$row['id_klienta'].'">';
//		  		echo '<input type="hidden" name="id_ksiazki" value="'.$row['id_ksiazki'].'">';
//		  		echo '<input type="hidden" name="ilosc" value="'.$row['ilosc'].'">';
//		  		echo '<input type="submit" value="Usuń">';
//		  	echo '</form>';
//		  	echo "<br><hr><br>";
//		  	/*echo '<form action="change_cart_quantity.php" method="post">';
//					echo '<input type="hidden" name="id_ksiazki" value="'.$row['id_ksiazki'].'">';
//					echo "<b>Ilosc: </b> ";
//					echo '<input type="text" id="koszyk_ilosc" name="koszyk_ilosc" value="1">';
//					echo '<button type="button" onclick="increase()">+</button>';
//					echo '<button type="button" onclick="decrease()">-</button>';
//					echo '<br><br><input type="submit" value="Zapisz koszyk">';
//			echo '</form>';*/
//		  	echo '</div>';

            // load the content from the external template file into string
            $book = file_get_contents("../template/cart-products.php");

            // replace fields in $book string to book data from $result
            echo sprintf($book, $i, $row["id_ksiazki"], $row["image_url"], $row["tytul"], $row["tytul"], $row["id_ksiazki"], $row["tytul"], $row["cena"], $row["rok_wydania"], $row["imie"], $row["nazwisko"], $row["id_ksiazki"], $row["id_ksiazki"], $row['id_ksiazki'], $row['ilosc'], $row['id_ksiazki'], $row['id_ksiazki'], $row['id_ksiazki']);

            $i++;

		  	$_SESSION['suma_zamowienia'] += $row['ilosc'] * $row['cena'];
		}

        /*echo '<span style="color: #c7c7c7;">';
		    echo "$ _SESSION suma_zamowienia = ".$_SESSION['suma_zamowienia']."<br>";
		    echo "<br> $ _SESSION koszyk_ilosc_ksiazek = ".$_SESSION['koszyk_ilosc_ksiazek']."<br>";
        echo '</span></br>';*/

		$result->free_result();
	}

//	function remove_product_from_cart($result) // remove_book.php
//	{
//
//	}

//	function add_product_to_cart($id_ksiazki, $quantity) // old (unused) function for adding products to shopping cart
//	{
//        // delete that fucking thing !
//
//		require "connect.php";
//
//		mysqli_report(MYSQLI_REPORT_STRICT);
//
//		try // spróbuj połączyć się z bazą danych
//		{
//
//			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);	// A CO Z "UNIWERSALNĄ" funkcją query(...) !?!?!
//				// @ - operator kontroli błędów - w przypadku blędu, php nie wyświetla informacji o błędzie
//
//			// sprawdzamy, czy udało się połaczyć z bazą danych
//
//			if($polaczenie->connect_errno!=0) // błąd połączenia
//			{
//				// 0  = false           = udane połączenie
//				// !0 = true (1,2, ...) = błąd połączenia
//
//					//echo "[ Błąd połączenia ] (".$conn->connect_errno."), Opis: ".$conn->connect_error;
//				//echo "[ Błąd połączenia ] (".$polaczenie->connect_errno.") <br>";
//				throw new Exception(mysqli_connect_errno()); // rzuć nowy wyjątek
//			}
//			else // udane polaczenie
//			{
//				//echo "<hr> -> kategoria = ".$kategoria."<br>";
//					//$kategorie = $polaczenie->query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC");
//
//                $id_klienta = $_SESSION['id'];
//
//				if($ksiazki = $polaczenie->query(" INSERT INTO koszyk (id_klienta, id_ksiazki, ilosc) VALUES ('$id_klienta', '$id_ksiazki', '$quantity')           ")   )
//				{
//					//$ksiazki->free_result();
//				}
//				else
//				{
//					throw new Exception($polaczenie->error);
//				}
//
//				$polaczenie->close();
//			}
//		}
//		catch(Exception $e) // Exception - wyjątek
//		{
//			//echo '<span style="color: red;"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</span>';
//
//			echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o sprawdzenie serwisu w innym terminie! ]</div>';
//
//			echo '<br><span style="color:red">Informacja developerska: </span>'.$e; // wyświetlenie komunikatu błędu - DLA DEWELOPERÓW
//
//			exit(); // (?)
//		}
//	}

	function insert_order_details($result)
	{
        // order.php -> insert do tabeli szczegoly_zamowienia - na podstawie tabeli koszyk

		$id_zamowienia = $_SESSION['last_order_id']; // id_zamowienia -> get_last_order_id()

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

		  	query("INSERT INTO szczegoly_zamowienia (id_zamowienia, id_ksiazki, ilosc) VALUES ('%s', '%s', '%s')", "", $cart);

		  	// echo '<a href="order_details.php?order_id='.$row['id_zamowienia'].' "> Szczegóły zamówienia </a><br>';
		}

		$result->free_result();
	}

	function get_orders($result) // wywołanie w my_orders.php
	{
        // // zamówienia danego klienta; -- wiele wierszy --> id_zamowienia, data_zloz, status;

        $i = 0;

        // $row[] -->  id_zamowienia,  data_zlozenia_zamowienia,  status, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, forma_dostarczenia;

		while ($row = $result->fetch_assoc()) // tyle ile jest zamówień danego klienta ;
		{
		  	/*echo "numer zamówienia " . $row['id_zamowienia']." || data = " .$row['data_zlozenia_zamowienia']." || status = ".$row['status']." ";

		  	echo '<a href="order_details.php?order_id='.$row['id_zamowienia'].' "> Szczegóły zamówienia </a><br>';

            echo "<br><hr>";

                echo "Szczegóły zamówienia<br><br>";

            query("SELECT id_zamowienia , id_ksiazki, ilosc FROM szczegoly_zamowienia WHERE id_zamowienia = '%s'", "get_order_details", $row['id_zamowienia']); // --> $_SESSION['order_details_books_id'];

            for($i = 0; $i < count($_SESSION['order_details_books_id']); $i++) {
                $book_id = $_SESSION['order_details_books_id'][$i];
                query("SELECT tytul, cena, rok_wydania FROM ksiazki WHERE id_ksiazki = '%s'", "order_details_get_book", $book_id);
            }

            echo <<<EOT
                <br><table id="first-table">
                    <tr>
                        <th>Company</th>
                        <th>Contact</th>
                        <th>Country</th>
                    </tr>
                    <tr>
                        <td>Alfreds Futterkiste</td>
                        <td rowspan="2">Maria Anders</td>
                        <td>Germany</td>
                    </tr>
                    <tr>
                        <td>Centro comercial Moctezuma</td>
                        <!--        <td>Francisco Chang</td>-->
                        <td>Mexico</td>
                    </tr>
                    <tr>
                        <td colspan="2">San Francisco</td>
                        <td>Los Angeles</td>
                    </tr>
                </table><br>
EOT;
            unset($_SESSION['last_order_id']);
            unset($_SESSION['order_details_books_id']);
            unset($_SESSION['order_details_books_quantity']);
            unset($_SESSION['suma_zamowienia']);

            echo "<br><hr>";*/

            get_order_sum("", $row["id_zamowienia"]); // suma zam; --> $_SESSION["order_sum"];
            // ✓ zapisze sumę zamówienia w zmiennej sesyjnej; $_SESSION["order_sum"];

            // load the content from the external template file into string
            $order = file_get_contents("../template/order-details.php"); // widok -> data, status, numer_zamowienia;

            // replace fields in $order string to author data from $result, display result content as HTML;
                //echo sprintf($order, $row['data_zlozenia_zamowienia'], $row["status"], $row["id_zamowienia"], $_SESSION["order_sum"]); // To jest tylko NAGŁÓWEK pojedynczego zamówienia;

            // replace fields in $order string to author data from $result, display result content as HTML;
            echo sprintf($order, $row['data_zlozenia_zamowienia'], $row["status"], $row["id_zamowienia"]); // To jest tylko NAGŁÓWEK pojedynczego zamówienia;

            query("SELECT id_ksiazki, ilosc FROM szczegoly_zamowienia WHERE id_zamowienia = '%s'", "get_order_details", $row['id_zamowienia']); // --> $_SESSION['order_details_books_id'];
            // ✓ pojedyncze wiersze z danymi o książce w tym zamówieniu;
            // wiele wierszy -> "id_ksiazki", "ilosc";


            /*for($i = 0; $i < count($_SESSION['order_details_books_id']); $i++) {
                $book_id = $_SESSION['order_details_books_id'][$i];
                query("SELECT tytul, cena, rok_wydania FROM ksiazki WHERE id_ksiazki = '%s'", "order_details_get_book", $book_id);
            }*/

            $_SESSION["termin_dostawy"] = $row["termin_dostawy"];
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

            if (
                isset($_SESSION["termin_dostawy"]) && !empty($_SESSION["termin_dostawy"])
                && $_SESSION["termin_dostawy"] !== "0000-00-00"
                /*&& $_SESSION["data_wysłania_zamowienia"] === "0000-00-00 00:00:00"
                && $_SESSION["data_dostarczenia"] === "0000-00-00"*/
                && $row["status"] === "W trakcie realizacji"
            ) {
                // status zamówienia to "W trakcie realizacji" --> termin_dostawy;
                $order = file_get_contents("../template/order-sum-order-in-progress.php");
                echo sprintf($order, $_SESSION["termin_dostawy"], $_SESSION["order_sum"]);
            }
            elseif (
                isset($_SESSION["data_wysłania_zamowienia"]) && !empty($_SESSION["data_wysłania_zamowienia"])
                && $_SESSION["termin_dostawy"] !== "0000-00-00"
                && $_SESSION["data_wysłania_zamowienia"] !== "0000-00-00 00:00:00"
                /*&& $_SESSION["data_dostarczenia"] === "0000-00-00"*/
                && $row["status"] === "Wysłano"
            ) {
                // status zamówienia to "Wysłano" --> termin_dostawy, data_wyslania_zamowienia;
                $order = file_get_contents("../template/order-sum-order-sent.php");
                echo sprintf($order, $_SESSION["termin_dostawy"], $_SESSION["data_wysłania_zamowienia"],  $_SESSION["order_sum"]);
            } elseif (
                isset($_SESSION["data_dostarczenia"]) && !empty($_SESSION["data_dostarczenia"])
                && $_SESSION["data_dostarczenia"] !== "0000-00-00"
                && $row["status"] === "Dostarczono"
            ) {
                // status zamówienia to "Dostarczono" (zakończono) --> termin_dostawy?, data_wyslania_zamowienia?, data_dostarczenia;
                $order = file_get_contents("../template/order-sum-order-delivered.php");
                echo sprintf($order, $_SESSION["data_dostarczenia"], $_SESSION["order_sum"]);

            } elseif (
                $row["status"] === "Zarchiwizowane"
            ) {
                $order = file_get_contents("../template/order-sum-order-archived.php");
                echo sprintf($order, $row["komentarz"], $_SESSION["order_sum"]);
            }
            else { // status -> "Oczekujące na potwierdzenie";
                $order = file_get_contents("../template/order-sum.php");
                echo sprintf($order, $_SESSION["order_sum"]);
            }

            echo "</div>";
		}

		$result->free_result();
	}

//	function validate_form()
//	{
//		// echo '<script> alert("test123"); </script>';
//	}

    function get_order_details($result) //  ̶o̶r̶d̶e̶r̶_̶d̶e̶t̶a̶i̶l̶s̶.̶p̶h̶p̶   ___my_orders.php
    {
//        $_SESSION['order_details_books_id'] = array();
//        $_SESSION['order_details_books_quantity'] = array();

        $_SESSION['order_details_books_id'] = []; //
        $_SESSION['order_details_books_quantity'] = []; //

        $i = 0;

        while ($row = $result->fetch_assoc()) // (!) - dla każdej książki (szczegoly_zamowienia) --> wiele wierszy - "id_książki", "ilość"
        {
            // tutaj wyświetla w widoku pojedynczy wiesz (id_ksiazki, obrazek, informacje o książke, ...) w tabeli tego zamówienia;

            /*echo "<br><strong>order_id  &rarr;</strong> " .$row['id_zamowienia'].", <strong>book_id  &rarr;</strong> ".$row['id_ksiazki'].", <strong>quantity &rarr;</strong> " .$row['ilosc']. "<br>";*/
            //echo "<strong>quantity &rarr;</strong> " .$row['ilosc']. "<br>";

            $_SESSION['order_details_books_id'][$i] =  $row['id_ksiazki']; // przechowuje id książek (tablica)
            //array_push($_SESSION['order_details_books_id'], $row['id_ksiazki']);

            $_SESSION['order_details_books_quantity'][$i] =  $row['ilosc']; // przechowuje ilosc (tablica) ! DO ZROBIENIA W PRZYSZŁOŚCI TAK JAK FUNKCJA order_details_get_book
            //array_push($_SESSION['order_details_books_quantity'], $row['ilosc']);

            // load the content from the external template file into string
            /*$order = file_get_contents("../template/order-details-book.php");

            // replace fields in $order string to author data from $result, display result content as HTML
            echo sprintf($order, $row['ilosc']);*/

            query("SELECT tytul, cena, au.imie, au.nazwisko, rok_wydania, image_url FROM ksiazki AS ks, autor AS au WHERE ks.id_autora = au.id_autora AND  ks.id_ksiazki = '%s'", "order_details_get_book", $_SESSION['order_details_books_id'][$i]); // To jest pojedynczy "Wiersz" - w widoku w tabeli - który wyświetla Pojedynczą książkę w Tym zamówieniu

            $i++;
        }

        // load the content from the external template file into string
            // Stopka w tabeli tego zamówienia - wyświetla tylko SUMĘ zamówienia;
        //$order = file_get_contents("../template/order-sum.php");

        // replace fields in $order string to author data from $result, display result content as HTML
        //echo sprintf($order, $_SESSION["order_sum"]); // Stopka w tabeli tego zamówienia - wyświetla tylko SUMĘ zamówienia;

        // sprawdzenie czy te zmienne istnieją, i czy mają wartości ine niż "0000-00-00";
           /* echo "<br> 608 termin dostawy -> <br>" . $_SESSION["termin_dostawy"] . "<br>";
            echo "<br> 608 data wysłania -> <br>" . $_SESSION["data_wysłania_zamowienia"] . "<br>";
            echo "<br> 608 data_dostarczenia-> <br>" . $_SESSION["data_dostarczenia"] . "<br>";*/

        /*if (
            isset($_SESSION["termin_dostawy"]) && !empty($_SESSION["termin_dostawy"])
            && $_SESSION["termin_dostawy"] !== "0000-00-00"
            && $_SESSION["data_wysłania_zamowienia"] === "0000-00-00 00:00:00"
            && $_SESSION["data_dostarczenia"] === "0000-00-00"
        ) {
            // status zamówienia to "W trakcie realizacji" --> termin_dostawy;
            $order = file_get_contents("../template/order-sum-order-in-progress.php");
            echo sprintf($order, $_SESSION["termin_dostawy"], $_SESSION["order_sum"]);
        }
        elseif (
            isset($_SESSION["data_wysłania_zamowienia"]) && !empty($_SESSION["data_wysłania_zamowienia"])
            && $_SESSION["termin_dostawy"] !== "0000-00-00"
            && $_SESSION["data_wysłania_zamowienia"] !== "0000-00-00 00:00:00"
            && $_SESSION["data_dostarczenia"] === "0000-00-00"
        ) {
            // status zamówienia to "Wysłano" --> termin_dostawy, data_wyslania_zamowienia;
            $order = file_get_contents("../template/order-sum-order-sent.php");
            echo sprintf($order, $_SESSION["termin_dostawy"], $_SESSION["data_wysłania_zamowienia"],  $_SESSION["order_sum"]);
        } else if (
            isset($_SESSION["data_dostarczenia"]) && !empty($_SESSION["data_dostarczenia"])
            && $_SESSION["data_dostarczenia"] !== "0000-00-00"
        ) {
            // status zamówienia to "Dostarczono" (zakończono) --> termin_dostawy?, data_wyslania_zamowienia?, data_dostarczenia;
            $order = file_get_contents("../template/order-sum-order-delivered.php");
            echo sprintf($order, $_SESSION["data_dostarczenia"], $_SESSION["order_sum"]);

        }*/


        $result->free_result();
    }

	function order_details_get_book($result)
	{
        // Wyświetla wiersze z książkami w tabeli z danym zamówieniem;

        // order_details.php?order_id=518

        // $j =  0;

       /* print_r($result->fetch_assoc()); echo "<br>";
        print_r($_SESSION["order_details_books_quantity"]); echo "<br><br><br>";
        echo count($_SESSION["order_details_books_quantity"]); echo "<br><br><br>";*/
        //print_r($_SESSION["order_details_books_quantity"]); echo "<br><br><br>";

		while ($row = $result->fetch_assoc())
		{
		  	//echo "<br><strong>tytul &rarr;</strong> " . $row['tytul']. ", <strong>cena &rarr;</strong> " .$row['cena'].", <strong>rok_wydania &rarr;</strong> ".$row['rok_wydania']."<br>";

            // load the content from the external template file into string
            $order = file_get_contents("../template/order-details-book.php");

                //echo "<br> j --> " . $_SESSION['order_details_books_quantity'][$j] . "<br>";
                //echo "<br> j --> " . $j .  "<br>";

            //print_r($_SESSION['order_details_books_quantity']);

            // użyto zapisu "count($_SESSION['order_details_books_quantity'])" - ponieważ w każdej iteracji ta tablica rośnie, i zawiera dokładnie tyle elementów - ile jest wierszy (książek) zamówieniu - stąd można użyć tego zapisu do numeracji (l.p.) -> "1", "2", "3" ...;
                // innymi słowy - zmienna "count($_SESSION['order_details_books_quantity'])" - w danej iteracji posiada ROZMIAR, który OKREŚLA NUMER WIERSZA (1,2,3) -, oraz wartość tej tablicy w danej iteracji przechowuje ILOŚĆ TEJ KONKRETNEJ KSIĄŻKI  w tym zamówieniu;

            // count($_SESSION['order_details_books_quantity']) - rozmiar tablicy w danej iteracji (numer wiersza - 1,2,3 ...);
            // $_SESSION["order_details_books_quantity"][count($_SESSION['order_details_books_quantity'])-1]
                // - ilość egzamplarzy tej książki w tym zamówieniu (w danej iteracji);

            // $_SESSION["order_details_books_id"][count($_SESSION['order_details_books_id'])-1] - id_książki ;

            // replace fields in $order string to author data from $result, display result content as HTML
            echo sprintf($order, count($_SESSION['order_details_books_quantity']),
                $_SESSION["order_details_books_id"][count($_SESSION['order_details_books_id'])-1],
                $row["image_url"], $row['tytul'], $row['imie'], $row['nazwisko'], $row['rok_wydania'],
                count($_SESSION['order_details_books_quantity']),
                $_SESSION["order_details_books_quantity"][count($_SESSION['order_details_books_quantity'])-1],
                count($_SESSION['order_details_books_quantity']),
                $row["cena"]);
		}
		$result->free_result();
	}

    /*function get_order_sum($result = NULL, $order_id) {
        if($result !== NULL && !($result instanceof mysqli_result)) {
            // error
        } else if ($result !== NULL) {
            $row = $result->fetch_assoc();
            return $row["kwota"];
        } else {
             query("SELECT kwota FROM platnosci WHERE id_zamowienia='%s'", "get_order_sum", $order_id);
        }
    }*/

    function get_order_sum($result = null, $order_id = null) {

        if ( ! ($result instanceof mysqli_result) ) { // dla funkcji get_orders() ;
            // $result was not passed, do something else;
            query("SELECT kwota FROM platnosci WHERE id_zamowienia='%s'", "get_order_sum", $order_id);
        } else  { // to się wywoła rekurencyjnie z warunku wyżej - zapisze sumę zamówienia do zmiennej sesyjnej;
            // $result was passed, do something with it;
                $row = $result->fetch_assoc();
            $_SESSION["order_sum"] = $row["kwota"];
        }
    }

	function verify_password($result) // validate_password.php (zmiana hasła); // confirm_password.php (usuwanie konta);
	{
		/*while ($row = $result->fetch_assoc())
		{
		  	$_SESSION['stare_haslo'] = $row['haslo'];
		}
		$result->free_result();*/

        $row = $result->fetch_assoc();
            $_SESSION['stare_haslo'] = $row['haslo']; // hasło klienta w postaci zahashowanej;
        $result->free_result();
	}

	function log_in($result)
	{
        // logowanie.php - skrypt logowania -> weryfikacja hasła;

        // sprawdza, czy istnieje taki email,   jeśli nie - przekierowuje do pliku zaloguj.php + wyświetla komunikat "Niepoprawny e-mail lub hasło";

        // jeśli email istnieje (tzn jest taki klient/pracownik) - następuje weryfikacja hasła - czy podano poprawne hasło ? - za pomocą funkcji porównującej hash hasła zapisany w bazie danych z zahashowanym hasłem otrzymanym w tablicy POST;

        // jeśli hasło było poprawne, i był to KLIENT - następuje pobranie liczby książek znajdujących się w koszyku, zapisanie danych klienta w zmiennych sesyjnych oraz przekierowanie na stronę główną,
        // jeśli hasło było poprawne, i był to PRACOWNIK - następuje zapisanie danych pracownika w zmiennych sesyjnych oraz przekierowanie na stronę główną panelu administratora;

        // w przeciwnym przypadku (jeśli podano błędne dane logowania) - następuje przekierowania na stronę logowania + wyświetlenie komunikatu o błędzie;

		$row = $result->fetch_assoc(); // wiersz - pola tabeli = tablica asocjacyjna;

        if(empty($row)) { // (testowałem) --> to się wykona, ✓✓✓ JEŚLI PODANO ZŁY E-MAIL (nieistniejący) (ponieważ wynika to z kwerendy, WHERE email = '%s' -> 0 zwróconych wierszy) !

            $_SESSION["blad"] = '<span style="color: red; font-weight: bold;">875 Nieprawidłowy e-mail lub hasło</span>';
            // błędne dane logowania (NIEISTNIEJĄCY EMAIL) -> przekierowanie do zaloguj.php + komunikat;
            return;
        }

                                           //echo '\n\n668 $_POST[login] = ' . $_POST['email'] . "<br>";
                                           //echo '$_POST[haslo] = ' . $_POST['haslo'] . "<br>"; exit();

		// WERYFIKACJA HASZA : (czy hasze hasła sa identyczne ?)
		    // porównanie hasha (hasła) podanego przy logowaniu, z hashem zapisanym w bazie danych;

		$haslo = $_POST['haslo']; // "zmienne tworzone poza funkcjami są globalne (więcej o funkcjach w manualu), a zmienne tworzone w funkcjach mają zasięg lokalny" - http://www.php.pl/Wortal/Artykuly/PHP/Podstawy/Zmienne-i-stale/Zasieg-zmiennych

        //echo "<br> haslo = $haslo <br>"; // exit();
        //echo "<br> row  = " . var_dump($row) . " <br>";  exit();

		if(password_verify($haslo, $row['haslo']))
		{
            // true -> hasze sa takie same (podano POPRAWNE HASŁO do konta - email także był poprawny);

			$_SESSION['zalogowany'] = true;

            $id = array_keys($row)[0]; // przyjmie wartość typu String (TEKSTOWĄ) taką jak -> "id_klienta"; "id_pracownika"; (użyto takiego zapisu ponieważ ID w tabeli klienci ma inną NAZWĘ niż w tabeli pracownicy.

			$_SESSION['id'] = $row[$id]; // wartość zmiennej => "id_klienta" lub "id_pracownika"; (tzn np 220, 221, ...);
			$_SESSION['imie'] = $row['imie'];
			$_SESSION['nazwisko'] = $row['nazwisko'];
            $_SESSION['telefon'] = $row['telefon'];
            $_SESSION['email'] = $row['email'];
                $_SESSION['adres_id'] = $row['adres_id'];
                $_SESSION['miejscowosc'] = $row['miejscowosc'];
                $_SESSION['ulica'] = $row['ulica'];
                $_SESSION['numer_domu'] = $row['numer_domu'];
                $_SESSION['kod_pocztowy'] = $row['kod_pocztowy'];
                $_SESSION['kod_miejscowosc'] = $row['kod_miejscowosc'];
                                    /* $_SESSION['wojewodztwo'] = $row['wojewodztwo'];
                                    $_SESSION['kraj'] = $row['kraj'];
			                        $_SESSION['PESEL'] = $row['PESEL'];
			                        $_SESSION['data_urodzenia'] = $row['data_urodzenia']; */


			                        //$_SESSION['login'] = $row['login'];

            if($id === "id_klienta") {

                $_SESSION['user-type'] = "klient";

                query("SELECT SUM(ilosc) AS suma 
                             FROM koszyk 
                             WHERE id_klienta='%s'", "count_cart_quantity", $row['id_klienta']);
                // pobranie liczby książek znajdujących się w kosztku; count_cart_quantity() -> $_SESSION['koszyk_ilosc_ksiazek'] -> zapis do zmiennej;
            }

			unset($_SESSION['blad']); // usuwa komunikat o błędzie logowania; // jest potrzebne, ponieważ mogła nastąpić sytuacja, w której klient podał złe dane (nastąpiło ustawienie zmiennej $_SESSION["blad"]), po czym nastąpiło logowanie pracownika (wszystkie dane były poprawne) - wtedy zmienna $_SESSION["blad"] istnieje, i należy ją usunąć;

			$result->free_result();   // pozbywamy się z pamięci rezultatu zapytania; free(); close();

            if($id === "id_klienta") {
                header('Location: index.php');      // przekierowanie do strony index.php
            } else {
                $_SESSION["stanowisko"] = $row["stanowisko"];
                    $_SESSION['user-type'] = "admin";
                header('Location: ../admin/admin.php'); // pracownik - przekierowanie do strony admin.php
            }
			exit(); // we should use exit() after header_location instruction;
		}
		else  // istniejący e-mail, złe (niepoprawne) hasło;
		{
			$_SESSION['blad'] = '<span style="color: red; font-weight: bold;">Nieprawidłowy e-mail lub hasło</span>'; // błędne dane logowania (niepoprawne HASŁO) -> przekierowanie do zaloguj.php + komunikat;
			header('Location: ___zaloguj.php');
			exit();
		}
	}

	function register_verify_email($result)
	{
        // rejestracja (rejestracja.php) - weryfikacja, czy istnieje taki email (czy jest zajęty);
		$_SESSION['valid'] = false;
		$_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu email!";
	}

    function register($result, $polaczenie) // $polaczenie object - to receive last insert id;
    {
                        /*// dodanie nowego użytkownika - rejestracja.php
                        $_SESSION['udanarejestracja'] = true;
                        // pobranie ID ostatnio wstawionego klienta ->
                            query("SELECT id_klienta FROM klienci ORDER BY id_klienta DESC LIMIT 1", "get_client_id", ""); // $_SESSION['last_client_id'] --> id ostatnio dodanego klienta;
                        //unset($_SESSION['wszystko_OK']); $_SESSION["valid"]
                        header('Location: ___zaloguj.php');*/

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
        $_SESSION['udanarejestracja'] = true;

            // pobranie ID ostatnio wstawionego adresu  ->
            //query("SELECT adres_id FROM adres ORDER BY adres_id DESC LIMIT 1", "get_address_id", "");
            // $_SESSION['last_adres_id'] -> id ostatnio dodanego adresu;

        // pobranie ID ostatnio wstawionego adresu  ->
        $_SESSION['last_adres_id'] = $polaczenie->insert_id;

        //echo "<br> $ SESSION['last_adres_id'] --> " . "<br>";         // 1
        //print_r($_SESSION['last_adres_id']); exit();


                // $_SESSION['last_client_id'] --> id ostatnio dodanego klienta;
                //unset($_SESSION['wszystko_OK']); $_SESSION["valid"]
                //header('Location: ___zaloguj.php');

        echo "<br> 993 <br>";
    }

	function cart_verify_book($result)
	{
        /*echo "<br>1038 -> cart_verify_book <br><hr> -->";
        print_r($result); //exit();*/

        if($result->num_rows) {
                //echo "<br>yes<br>";

            // \user\book.php - check if book with given ID (in POST request) exist, if book exist - return true in that session variable ;
            // add_to_cart.php -> ta funkcja wykona się tylko, gdy BD zwróci rezultat, czyli ta książka jest już w koszyku
            $_SESSION['book_exists'] = true; // add_to_cart.php - sprawdza, czy książka już istnieje w koszyku (przestawia zmienną - jeśli tak)
            /*echo "<br>448<br>";*/
            //echo $_SESSION['book_exists']; exit();
            $result->free_result();

        } else {
                //echo "<br>no<br>";
            // do nothing !
        }

        /*// \user\book.php - check if book with given ID (in POST request) exist, if book exist - return true in that session variable ;
        // add_to_cart.php -> ta funkcja wykona się tylko, gdy BD zwróci rezultat, czyli ta książka jest już w koszyku
		$_SESSION['book_exists'] = true; // add_to_cart.php - sprawdza, czy książka już istnieje w koszyku (przestawia zmienną - jeśli tak)
        //echo "<br>448<br>";
        //echo $_SESSION['book_exists']; exit();
		$result->free_result();*/
	}

    function verifyAuthorExists($result) { // \admin\edit-book-data,    \user\index.php - advanced-search (prg)

        if($result->num_rows) {
            // \admin\edit-book.php - check if author with given ID (in POST request) exist, if author exist - return true in that session variable ;
                $_SESSION['author-exists'] = true;
            $result->free_result();

        } else { // można nawet to zakomentować;
            //echo "<br>no<br>";
            // do nothing !
        }
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

    function verifyCategoryExists($result) { // \admin\edit-book-data,
                                             // \user\index.php - PRG - spr, czy istnieje kategoria o takiej nazwie;
        if($result->num_rows) {
            // \admin\edit-book.php - check if author with given ID (in POST request) exist, if author exist - return true in that session variable ;
                $_SESSION['category-exists'] = true;
            $result->free_result();

        } else { // można nawet to zakomentować;
            //echo "<br>no<br>"; // \user\index.php - można usunąć warunek else, ponieważ $_SESSION['category-exists'] == false;
            // do nothing !
        }
    }

function verifySubcategoryExists($result) { // \user\index.php - prg - spr, czy istnieje pod-kategoria o takiej nazwie;
    if($result->num_rows) {
        $_SESSION['subcategory-exists'] = true;
        $result->free_result();
    } else { // można nawet to zakomentować;
        //echo "<br>no<br>"; // \user\index.php - można usunąć warunek else, ponieważ $_SESSION['subcategory-exists'] == false;
        // do nothing !
    }
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

        $_SESSION['order-exists'] = true;
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

    function get_last_order_id($result, $polaczenie)
    {
                // order.php - dodawanie zamówień (tabela zamówienia)
                // - pobranie id nowo wstawionego wiersza, korzysta z dodatkowej funkcji w celu zdobycia id nowo wstawianego zamówienia
                // query("SELECT id_zamowienia FROM zamowienia ORDER BY id_zamowienia DESC LIMIT 1", "get_id", "");

        // - pobranie id nowo wstawionego wiersza (nowo wstawianego zamówienia);
        $_SESSION['last_order_id'] = $polaczenie->insert_id;
    }

    function get_last_book_id($result, $polaczenie) { // admin\add-book-data.php;
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

    function get_all_orders($result) { // \admin\orders.php - wszystkie zamówienia złożone przez klientów, przypisane do zalogowanego pracownika;

        while($row = $result->fetch_assoc()) {
                        // echo "<br>" . $row["id_zamowienia"] . " | " . $row["data_zlozenia_zamowienia"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["kwota"] . " | " . $row["sposob_platnosci"] . " | " . $row["status"] . "<br><hr>";
            // load the content from the external template file into string
            $order = file_get_contents("../template/admin/orders.php");
            // replace fields in $order string to author data from $result, display result content as HTML
            echo sprintf($order, $row['id_zamowienia'], $row["data_zlozenia_zamowienia"], $row["imie"], $row["nazwisko"], $row["kwota"], $row["sposob_platnosci"], $row['id_zamowienia'], $row["status"], $row['id_zamowienia'], $row['id_zamowienia'], $row['id_zamowienia'], $row['id_zamowienia']);
        }
        $result->free_result();
    }

    function get_all_books($result) { // admin/books;
        while($row = $result->fetch_assoc()) {
            // load the content from the external template file into string
            $book = file_get_contents("../template/admin/books.php");
            // replace fields in $order string to author data from $result, display result content as HTML
            echo sprintf($book, $row['id_ksiazki'], $row["tytul"], $row["nazwa_kategorii"], $row["cena"], $row["imie"], $row["nazwisko"], $row['nazwa_magazynu'], $row["ilosc_dostepnych_egzemplarzy"], $row['id_ksiazki'],  $row['id_ksiazki'], $row['id_magazynu'], $row['id_ksiazki'], $row['id_magazynu'], $row['id_ksiazki']);
        }
        $result->free_result();
    }

    function get_orders_boxes($result) {
        while($row = $result->fetch_assoc()) {
                        //echo "<br>" . $row["id_zamowienia"] . " | " . $row["data_zlozenia_zamowienia"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["kwota"] . " | " . $row["sposob_platnosci"] . " | " . $row["status"] . "<br><hr>";

            // load the content from the external template file into string
            $order = file_get_contents("../template/admin/archive-order-box.php");
            // replace fields in $order string to author data from $result, display result content as HTML
            echo sprintf($order, $row['id_zamowienia'], $row['id_zamowienia'], $row['id_zamowienia'], $row['id_zamowienia'], $row['id_zamowienia']);
        }
        $result->free_result();
    }

    function get_order_details_admin($result) { // \admin\order-details.php
        $i = 0;
                        // $row = $result->fetch_assoc();
        while($row = $result->fetch_assoc()) {
                        // echo "<br>" . $row["id_zamowienia"] . " | " . $row["data_zlozenia_zamowienia"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["kwota"] . " | " . $row["sposob_platnosci"] . " | " . $row["status"] . "<br><hr>";

            // load the content from the external template file into string
            $order = file_get_contents("../template/admin/order-details.php");

            // replace fields in $order string to author data from $result, display result content as HTML
            echo sprintf($order, $i, $row["tytul"], $row["imie"],$row["nazwisko"],$row["rok_wydania"],$row["ilosc"], $row["cena"]);

                        /* if($i === 0) {
                            $order_f = file_get_contents("../template/admin/order-details-footer.php");
                            // replace fields in $order string to author data from $result, display result content as HTML
                            echo sprintf($order_f, $row["kwota"]);
                        } */
            $i++;
        }

        $result->free_result();
    }

    function get_order_sum_admin($result) { // \admin\order-details.php

        $row = $result->fetch_assoc();

        $orderSum = file_get_contents("../template/order-sum.php");

        // replace fields in $order string to author data from $result, display result content as HTML
        echo sprintf($orderSum, $row["kwota"]);

        $result->free_result();
    }

    function get_order_summary($result) { // \admin\order-details.php

            $row = $result->fetch_assoc();

        $_SESSION["status"] = $row["status"];

        $orderSum = file_get_contents("../template/admin/order-summary.php");

        echo sprintf($orderSum, $row["sposob_platnosci"], $row["data_platnosci"], $row["forma_dostarczenia"]);

        $result->free_result();

    }

    function get_employee($result) {
            $row = $result->fetch_assoc();
        $_SESSION["employee_id"] = $row["id_pracownika"];
            $result->free_result();
    }

    function get_employee_id($result) { // ___order.php - pobranie id pracownika z najmniejszą liczbą zamówień;

        $row = $result->fetch_assoc();

        if($row == NULL) { // brak zwroconych. rekordow; (żaden pracownik nie był przypisany do zamówienia);
             query("SELECT id_pracownika FROM pracownicy ORDER BY RAND() LIMIT 1", "get_employee", ""); // wybieramy losowego pracownika; $_SESSION["employee_id"];
        } else {
            $_SESSION["employee_id"] = $row["id_pracownika"];
            $result->free_result();
        }
    }

    function updateOrder($result) { // \admin\order-details.php

        $_SESSION["update-successful"] = false;

    }

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

    function archiveOrder($result) { // \admin\orders.php

        $_SESSION["archive-successful"] = false;

    }

    function get_book_details($result) { // ̶ ̶a̶d̶m̶i̶n̶/̶b̶o̶o̶k̶-̶d̶e̶t̶a̶i̶l̶s̶.̶p̶h̶p̶?̶%̶s̶

        // \admin\book-details.php  $_SESSION["book-id"],
        //                          $_SESSION["warehouse-id"];

        $row = $result->fetch_assoc();

            // $_SESSION["status"] = $row["status"];

        $book = file_get_contents("../template/admin/book-details.php");

            /*echo sprintf($book, $row["tytul"], $row["imie"], $row["nazwisko"], $row["rok_wydania"], $row["cena"], $row["nazwa_wydawcy"], $row["opis"], $row["wymiary"], $row["ilosc_stron"], $row["oprawa"], $row["stan"], $row["srednia_ocen"], $row["image_url"], $row["liczba_ocen"], $row["ile_razy_sprzedana"], $row["nazwa_kategorii"], $row["nazwa_subkategorii"], $row["ilosc_dostepnych_egzemplarzy"], $row["nazwa"], $row["miejscowosc"], $row["numer_ulicy"], $row["kod_pocztowy"] );*/

        echo sprintf($book, $row["image_url"], $row["image_url"], $row["tytul"], $row["imie"], $row["nazwisko"], $row["rok_wydania"], $row["cena"], $row["nazwa_wydawcy"], $row["wymiary"], $row["ilosc_stron"], $row["oprawa"], $row["stan"], $row["opis"], $row["nazwa_kategorii"], $row["nazwa_subkategorii"], $row["srednia_ocen"], $row["liczba_ocen"], $row["ilosc_zamowien_w_ktorych_wystapila"], $row["liczba_klientow_posiadajacych_w_koszyku"], $row["liczba_sprzedanych_egzemplarzy"], $row["nazwa_magazynu"], $row["kraj"], $row["wojewodztwo"], $row["miejscowosc"], $row["ulica"], $row["numer_ulicy"], $row["kod_pocztowy"], $row["kod_miejscowosc"], $row["ilosc_dostepnych_egzemplarzy"]    );

        // pole "ile_razy_sprzedana" - określa liczbę zamówień, w których znalazła się ta książka. (nie jest to liczba sprzedanych sztuk!)

        $result->free_result();
    }

    function createMagazineSelectList($result) { // \admin\add-book.php

        // create <option> elements inside <select> list based on warehouse names in database;
            // <option> elementy - są generowane dynamicznie na podstawie BD i danych o magazynach;
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["id_magazynu"].'">'.$row["nazwa"].'</option>';
        }
            /*echo '<option value="asdasd"></option>';*/ // remove thhat line in the future;
        $result->free_result();
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
        echo json_encode($bookData);
    }

    function updateBookData($result) {
        $_SESSION["update-book-successful"] = false;
    }


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

    function displayBooks($kategoria) // nazwa kategorii (string)
    {
        // alias dla funkcji query() -> index.php
        if($kategoria == "Wszystkie")
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
                            SUM(magazyn_ksiazki.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                        FROM 
                            ksiazki AS ks
                        JOIN 
                            autor AS au ON ks.id_autora = au.id_autora
                        JOIN 
                            subkategorie AS sb ON ks.id_subkategorii = sb.id_subkategorii
                        JOIN 
                            kategorie AS kt ON sb.id_kategorii = kt.id_kategorii
                        LEFT JOIN 
                            magazyn_ksiazki ON magazyn_ksiazki.id_ksiazki = ks.id_ksiazki
                        GROUP BY ks.id_ksiazki", "get_books", ""); // dane o ksiażce + ilość egzemplarzy na stanie
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
                            SUM(magazyn_ksiazki.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                        FROM 
                            ksiazki AS ks
                        JOIN 
                            autor AS au ON ks.id_autora = au.id_autora
                        JOIN 
                            subkategorie AS sb ON ks.id_subkategorii = sb.id_subkategorii
                        JOIN 
                            kategorie AS kt ON sb.id_kategorii = kt.id_kategorii
                        LEFT JOIN 
                            magazyn_ksiazki ON magazyn_ksiazki.id_ksiazki = ks.id_ksiazki
                        WHERE kt.nazwa LIKE '%s'                                   
                        GROUP BY ks.id_ksiazki", "get_books", $_SESSION['kategoria']); // dane o ksiażce + ilość egzemplarzy na stanie

        // WHERE kt.nazwa LIKE '%s'

        }
    }

    function displayBooksWithSubcategory($kategoria, $subcategory) // nazwa kategorii (string), nazwa podkategorii (string)
    {
        // dodanie statusu - "dostępna / niedostępna" -->

        query("SELECT
                        ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, 
                        kt.nazwa, sb.id_kategorii, 
                        au.imie, au.nazwisko,
                        SUM(magazyn_ksiazki.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                    FROM 
                        ksiazki AS ks
                    JOIN 
                        autor AS au ON ks.id_autora = au.id_autora
                    JOIN 
                        subkategorie AS sb ON ks.id_subkategorii = sb.id_subkategorii
                    JOIN 
                        kategorie AS kt ON sb.id_kategorii = kt.id_kategorii
                    LEFT JOIN 
                        magazyn_ksiazki ON magazyn_ksiazki.id_ksiazki = ks.id_ksiazki
                    WHERE kt.nazwa LIKE '%s' AND sb.nazwa LIKE '%s'                                  
                    GROUP BY ks.id_ksiazki", "get_books", [$_SESSION['kategoria'], $_SESSION["subcategory"]]); // dane o ksiażce + ilość egzemplarzy na stanie
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

    function query($query, $fun, $value)
    {
        require "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);



        try
            {
                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

                if($polaczenie->connect_errno) {

                    throw new Exception(mysqli_connect_errno());
                }
                else {

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

                                echo "<br>1747<br>"; // exit();

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

                                    echo "<br>1767<br>";
                                    echo "<br>result --> <br>";


                                    echo "<br><hr><br>";
                                    print_r($result); echo "<br><hr><br>";
                                    var_dump($result);

                                    //exit();

                                    $fun($result);
                                }

                                // check_email - (zmiana danych użytkownika) - validate_user_data.php - SPRAWDZA, CZY ISTNIEJE TAKI EMAIL
                                    // - jeśli istnieje ($result zwrócił rekordy) - ✓ przestawia zmienną $_SESSION['email_exists'] na "true"
                                    // - jeśli NIE istnieje ($result NIE zwrócił rekordów) - NIE POWINNA WYWOŁAĆ SIĘ TA FUNKCJA ($fun - check_email);


                                /*if($fun == "log_in" || $fun == "get_product_from_cart") {   // logowanie.php ✓ -> podany zły email (num_rows ---> 0 (brak) zwr. rekordów;

                                    $fun($result);
                                }*/

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
    }

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


function get_first_word($string)
    {
    	// ta funkcja zwraca pierwsze słowo ze stringa
        $arr = explode(' ', trim($string));
        return isset($arr[0]) ? $arr[0] : $string;
    }
?>


