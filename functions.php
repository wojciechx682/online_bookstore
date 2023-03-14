

<?php

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



	function advanced_search($result)
	{
		get_books($result);
	}

    function get_authors($result)
    {
        // tworzy linki - w których kazdy wyświetli imie i nazwisko autora.
        //
        echo '<h3>Autorzy </h3><hr>';
        echo '<ul id="ul-authors">';

            while ($row = $result->fetch_assoc())
            {
                // load the content from the external template file into string
                $author = file_get_contents("../template/content-authors.php");

                // replace fields in $author string to author data from $result, display result content as HTML
                echo sprintf($author, $row['id_autora'], $row["imie"], $row["nazwisko"]);
            }

        echo '</ul>';
        $result->free_result();
    }



    function get_authors_adv_search($result)
    {
        // header -> advanced_search -> <select> - lista autorów - imie i nazwisko autora

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

	function get_categories($result)
	{
        // header -> top-nav-content - wyświetla listę kategorii; wypisuje elementy listy <li> - wewnątrz kategorii (top_nav);

		$category_name = "Wszystkie";
		echo "\n".'<li><a href="index.php?kategoria='.$category_name.'">'.$category_name.'</a></li>'; // Zamiana na jQuery ? event listener ?
		while ($row = $result->fetch_assoc())
		{
		  	//echo '<li><a href="index.php?kategoria='.$row['kategoria'].' ">'.$row['kategoria'].'</a></li>';
            echo "\n".'<li><a href="index.php?kategoria='.$row['kategoria'].'">'.$row['kategoria'].'</a></li>';
		}
		$result->free_result();
	}

            function get_categories_adv_search($result)
            {
                // header -> advanced_search -> <select> - lista kategorii
                $category_name = "Wszystkie";
                echo "\n".'<option value="'.$category_name.'">'.$category_name.'</option>';
                while ($row = $result->fetch_assoc()) {
                    echo "\n".'<option value="'.$row['kategoria'].'">'.$row['kategoria'].'</option>';
                }
                $result->free_result();
            }



	function get_books($result)
	{
        // content -> wyświetla wszystkie książki

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

            // replace fields in $book string to book data from $result, display result content as HTML
            echo sprintf($book, $i, $row["image_url"], $row["tytul"], $row["cena"], $row["rok_wydania"], $row["imie"], $row["nazwisko"], $row["rating"], $row["id_ksiazki"]); // return zamiast echo ?

		  	$i++;
		}

		$result->free_result();
	}

	function check_email($result)
	{
        // validate_user_data.php - sprawdza, czy istnieje juz taki email, ustawia zmienna sesyjną
		$_SESSION['email_exists'] = true;

            $row = $result->fetch_assoc();    // reset_password.php - resetowanie hasła
            $_SESSION["imie"] = $row["imie"]; // reset_password.php - resetowanie hasła
	}

    function verify_token($result)
    {
        // reset-password-form.php
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

	function count_cart_quantity($result) // add_to_cart.php - zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku
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
            echo sprintf($book, $i, $row["tytul"], $row["cena"], $row["rok_wydania"], $row["id_ksiazki"], $row["id_ksiazki"], $row['id_ksiazki'], $row['ilosc'], $row['id_ksiazki'], $row['id_ksiazki'], $row['id_klienta'], $row['id_ksiazki'], $row['ilosc']);

            $i++;

		  	$_SESSION['suma_zamowienia'] += $row['ilosc'] * $row['cena'];
		}

        echo '<span style="color: #c7c7c7;">';
		    echo "$ _SESSION suma_zamowienia = ".$_SESSION['suma_zamowienia']."<br>";
		    echo "<br> $ _SESSION koszyk_ilosc_ksiazek = ".$_SESSION['koszyk_ilosc_ksiazek']."<br>";
        echo '</span></br>';

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
		  	echo $row['id_klienta'] . ", " .$row['id_ksiazki'] . ", " . $row['ilosc'] . "<br>"; // remove in the future

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

	function get_orders($result) // my_orders.php
	{
		while ($row = $result->fetch_assoc())
		{
		  	echo "id =" . $row['id_zamowienia']." || data = " .$row['data_zlozenia_zamowienia']." || status = ".$row['status']." ";

		  	echo '<a href="order_details.php?order_id='.$row['id_zamowienia'].' "> Szczegóły zamówienia </a><br>';
		}

		$result->free_result();
	}

//	function validate_form()
//	{
//		// echo '<script> alert("test123"); </script>';
//	}

    function get_order_details($result) // order_details.php
    {
//        $_SESSION['order_details_books_id'] = array();
//        $_SESSION['order_details_books_quantity'] = array();

        $_SESSION['order_details_books_id'] = []; // można zamienić na pojedynczą zmienną, bo każda przechowywana wartosć jest taka sama
        $_SESSION['order_details_books_quantity'] = []; // tutaj niekoniecznie

        $i = 0;

        while ($row = $result->fetch_assoc())
        {
            echo "<br><strong>order_id  &rarr;</strong> " .$row['id_zamowienia'].", <strong>book_id  &rarr;</strong> ".$row['id_ksiazki'].", <strong>quantity &rarr;</strong> " .$row['ilosc']. "<br>";

            $_SESSION['order_details_books_id'][$i] =  $row['id_ksiazki']; // przechowuje id książek (tablica)
            //array_push($_SESSION['order_details_books_id'], $row['id_ksiazki']);

            $_SESSION['order_details_books_quantity'][$i] =  $row['ilosc']; // przechowuje ilosc (tablica) ! DO ZROBIENIA W PRZYSZŁOŚCI TAK JAK FUNKCJA order_details_get_book
            //array_push($_SESSION['order_details_books_quantity'], $row['ilosc']);

            $i++;
        }

        $result->free_result();
    }

	function order_details_get_book($result)
	{
        // order_details.php?order_id=518

		while ($row = $result->fetch_assoc())
		{
		  	echo "<br><strong>tytul &rarr;</strong> " . $row['tytul']. ", <strong>cena &rarr;</strong> " .$row['cena'].", <strong>rok_wydania &rarr;</strong> ".$row['rok_wydania']."<br>";
		}

		$result->free_result();
	}

	function verify_password($result) // validate_password.php
	{
		while ($row = $result->fetch_assoc())
		{
		  	$_SESSION['stare_haslo'] = $row['haslo'];
		}
		$result->free_result();
	}

//	function test_fun()
//	{
//		return "123";
//	}


	function log_in($result)
	{
        echo "<br>477";
        //exit();
        // logowanie.php - skrypt logowania, logowanie -> weryfikacja hasła

		$row = $result->fetch_assoc(); // wiersz - pola tabeli = tablica asocjacyjne

		//echo '$_POST[login] = ' . $_POST['login'] . "<br>";
		//echo '$_POST[haslo] = ' . $_POST['haslo'] . "<br>";

		// WERYFIKACJA HASZA : (czy hasze hasła sa identyczne)
		// porównanie hasha podanego przy logowaniu, z hashem zapisanym w bazie danych

		$haslo = $_POST['haslo']; // "zmienne tworzone poza funkcjami są globalne (więcej o funkcjach w manualu), a zmienne tworzone w funkcjach mają zasięg lokalny" - http://www.php.pl/Wortal/Artykuly/PHP/Podstawy/Zmienne-i-stale/Zasieg-zmiennych

		if(password_verify($haslo, $row['haslo'])) // true -> hasze sa takie same (podano poprawne hasło do konta)
		{
			$_SESSION['zalogowany'] = true;
			$_SESSION['id'] = $row['id_klienta'];
			$_SESSION['imie'] = $row['imie'];
			$_SESSION['nazwisko'] = $row['nazwisko'];
			$_SESSION['miejscowosc'] = $row['miejscowosc'];
			$_SESSION['ulica'] = $row['ulica'];
			$_SESSION['numer_domu'] = $row['numer_domu'];
			$_SESSION['kod_pocztowy'] = $row['kod_pocztowy'];
			$_SESSION['kod_miejscowosc'] = $row['kod_miejscowosc'];
			$_SESSION['wojewodztwo'] = $row['wojewodztwo'];
			$_SESSION['kraj'] = $row['kraj'];
			$_SESSION['PESEL'] = $row['PESEL'];
			$_SESSION['data_urodzenia'] = $row['data_urodzenia'];
			$_SESSION['telefon'] = $row['telefon'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['login'] = $row['login'];

			//$_SESSION['koszyk_ilosc_ksiazek'] = query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta);
			//$_SESSION['test123'] = test_fun();
			//$id_klienta = $_SESSION['id'];
			//$_SESSION['test123'] = query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta);

			query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $row['id_klienta']);	// pobranie liczby książek znajdujących się w kosztku

			unset($_SESSION['blad']); // usuwa komunikat o błędzie logowania

			$result->free_result();   // pozbywamy się z pamięci rezultatu zapytania; free(); close();

			header('Location: index.php'); // przekierowanie do strony index.php
            //echo "<br>477";
			exit();
		}
		else  // dobry login, złe hasło
		{
            echo "<br>477";
			$_SESSION['blad'] = '<span style="color: red">Nieprawidłowy e-mail lub hasło</span>'; // błędne dane logowanie -> przekierowanie do index.php + komunikat
			header('Location: zaloguj.php');
			exit();
		}
	}

	function register_verify_email($result)
	{
        // rejestracja (rejestracja.php) - weryfikacja, czy istnieje taki email (czy jest zajęty)
		$_SESSION['wszystko_OK'] = false;
		$_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu email!";
	}

    function register($result)
    {
        // dodanie nowego użytkownika - rejestracja.php
        $_SESSION['udanarejestracja'] = true;
            //unset($_SESSION['wszystko_OK']);
        header('Location: zaloguj.php');
    }

	function cart_verify_book($result)
	{

        // add_to_cart.php -> ta funkcja wykona się tylko, gdy BD zwróci rezultat, czyli ta książka jest już w koszyku
		$_SESSION['book_exists'] = true; // add_to_cart.php - sprawdza, czy książka już istnieje w koszyku (przestawia zmienną - jeśli tak)
        /*echo "<br>448<br>";*/
        //echo $_SESSION['book_exists']; exit();
		$result->free_result();
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

    function get_id($result)
    {
        // order.php -> get_last_order_id($result) -> ustawia id ostatniego zamówienia w zmiennej sesyjnej
        $row = $result->fetch_assoc();
        $_SESSION['last_order_id'] = $row["id_zamowienia"];
        $result->free_result();
    }

    function get_last_order_id($result)
    {
        // order.php - dodawanie zamówień (tabela zamówienia) - pobranie id nowo wstawionego wiersza, korzysta z dodatkowej funkcji w celu zdobycia id nowo wstawianego zamówienia
        query("SELECT id_zamowienia FROM zamowienia ORDER BY id_zamowienia DESC LIMIT 1", "get_id", "");
    }

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// Funkcja ustanawiająca połączenie z bazą danych i realizująca zapytanie sql
    // "służy do uzyskania wyników z bazy danych i przekazania ich do zewnętrznej funkcji w celu dalszej obróbki"

	// $query - zapytanie sql
    // $fun - funkcja wyświetlająca dane
    //        nazwa funkcji, która zostanie wywołana, gdy zapytanie zostanie wykonane pomyślnie.
    // $value - wartość będąca parametrem funkcji sprintf / vsprintf (pojedyncza zmienna lub TABLICA)

    function displayBooks($kategoria)
    {
        // alias dla funkcji query() -> index.php
        if($kategoria == "Wszystkie")
        {
            //query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki", "get_books", "");
            query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.rating, au.imie, au.nazwisko FROM ksiazki AS ks, autor AS au WHERE ks.id_autora = au.id_autora", "get_books", "");
            //query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.rating, au.imie, au.nazwisko FROM ksiazki AS ks, autor AS au WHERE kategoria LIKE '%s' AND ks.id_autora = au.id_autora", "get_books",  $_SESSION['kategoria']);


        }
        else
        {
            //query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '%s'", "get_books", $kategoria);
            query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.rating, au.imie, au.nazwisko FROM ksiazki AS ks, autor AS au WHERE kategoria LIKE '%s' AND ks.id_autora = au.id_autora", "get_books",  $_SESSION['kategoria']);
        }
    }

    // Model - odpowiedzialny za reprezentację danych biznesowych, logikę aplikacji oraz dostęp do bazy danych.
    // W kontekście kodu, który podałeś, funkcja query() odpowiada za wykonanie zapytań do bazy danych, co oznacza, że pełni rolę modelu.

    // $fun - nazwa funkcji, która będzie obsługiwać wynik zapytania.

    function query($query, $fun, $value)
    {
        require "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try
        {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

            if($polaczenie->connect_errno)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else                                  // udane polaczenie
            {
                if(gettype($value) !== "array") { // jeśli to nie jest tablica

                    $value = [$value];            // zrób z niej tablicę
                }

                //if (!is_array($value)) {
                //	$values = [$values];
                //}

                for($i = 0; $i < count($value); $i++)
                {
                    $value[$i] = mysqli_real_escape_string($polaczenie, $value[$i]);
                }

                if($result = $polaczenie->query(vsprintf($query, $value))) // $query - zapytanie, $value - tablica parametrów do vsprintf
                {
                    //print_r($result); echo "<br><br>";
                    //echo "<br><hr><br> query ( ) -> " . $query . "<br><hr>";

                    // można zoptymalizować poniższy kod, bo użycie funkcji jest powtórzone ->
                    if(gettype($result) != "object") {

                        //echo "<br>613<br>"; exit();

                        // INSERT, UPDATE ...

                        if($fun != "") {
                            $fun($result);
                        }

                    } else {  // $result jest obiektem

                        //echo "<br>623<br>"; //exit();
                        // SELECT
                        $num_of_rows = $result->num_rows; // ilość zwróconych wierszy

                        //echo "<br>num_of_rows --> " . $num_of_rows . "<br>";

                        if($num_of_rows>0) // znaleziono rekordy
                        {

                            //echo "<br>625<br>"; //exit();

//                            if ( isset($_POST["year-min"]) && !empty($_POST["year-min"]) && isset($_POST["year-max"]) && !empty($_POST["year-max"])
//                            ) {
//                                echo "<br><hr><br> query ( ) -> " . $query . "<br><hr>"; // testowanie wyszukiwania zaawansowanego
//                                //exit();
//                            }
//
//                            echo "<br><hr><br> num_of_rows -> " . $num_of_rows . "<br><hr>";


                            $fun($result); //
                        }
                        else { // brak zwróconych rekordów

                            //echo '<h3>Brak wyników</h3>'; // brak zwróconych rekordów (np 0 zwróconych wierszy); // zamiast "echo" można użyć "return"

                            if($fun != "" && $fun != "register_verify_email" && $fun != "check_email" && $fun != "verify_token") {   // logowanie.php ✓ -> podany zły email (num_rows ---> 0 (brak) zwr. rekordów;
                                $fun($result);
                            } // z drugiej strony nie chce, aby wywołało funkcję "register_verify_email jesli nie znaleziono takich istniejących maili w BD (przy rejestracji ...) a zatem tutaj funkcja "register_ver_email" nie powinna zostać wykonana !

                             // dla register_verify_email (rejestracja) nie powinna wykonać się funkcja $fun !

                            // Kiedy jest potrzeba aby wywołać funkcję $fun gdy nie zwrócono żadnych rekordw ?
                            // -> dla logowanie.php (patrz wyżej)
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
            echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności]</div>'; // użycie "return" zamisat echo
            echo '<br><span style="color:red">Informacja developerska: </span>'.$e; // wyświetlenie komunikatu błędu - dla deweloperów
            exit(); // (?)
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        //return "<br> query = ".$query.", type = ".$type."<br>";
    }

	function get_first_word($string)
    {
    	// ta funkcja zwraca pierwsze słowo ze stringa
        $arr = explode(' ', trim($string));
        return isset($arr[0]) ? $arr[0] : $string;
    }
?>


