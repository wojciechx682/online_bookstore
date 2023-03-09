<?php

    session_start();

    print_r($_SESSION); echo "<br><br>";

    //$values = [1,2,3];
    $values = "abc";
    $array = "def";
    print_r($values);
    //echo "<br>" . count($values);
    //echo "<br>" . strlen($values);
    echo "<br>" . gettype($values);
//    if(gettype($values) !== "array") {
//        $values = [$values];
//    }
    if (!is_array($values)) {
        $values = [$values];
    }
    echo "<br>";
    print_r($values);
    echo "<br>" .count($values);

    require "functions.php";
?>
<hr><br>

<?php
    function queryTwo($query, $fun, $value)
    {
        $type = get_first_word($query); // type = SELECT, INSERT

        require "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT); // sposób raportowania błędów -> MYSLQI_REPORT_STRICT - zamiast warningów, chcemy rzucać exception (w celu uniknięcia wyświetlania tych warningów - dla użytkowników ... w sekcji catch {} ... )

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
                    print_r($result); echo "<br><br>";

                    if(gettype($result) != "object") {
                        // INSERT, UPDATE ...
                        //echo "result is NOT an object";

                        //echo "<br> type of result -> " . gettype($result) . "<br>";

                        if($fun != "") {

                            $fun($result);
                        }

                    } else {  // $result jest obiektem
                        // SELECT
                        $num_of_rows = $result->num_rows; // ilość zwróconych wierszy

                        if($num_of_rows>0) // znaleziono rekordy
                        {
                            $fun($result);
                        }
                        else {
                            echo '<h3>Brak wyników</h3>'; // brak zwróconych rekordów (np 0 zwróconych wierszy)
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
            echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności]</div>';
            echo '<br><span style="color:red">Informacja developerska: </span>'.$e; // wyświetlenie komunikatu błędu - DLA DEWELOPERÓW (!)
            // zamiast tego użyć klasy error ...
            exit(); // (?)
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////

        //return "<br> query = ".$query.", type = ".$type."<br>";
    }

?>

<br><hr>

<?php

// ✓ queryTwo("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $_SESSION['id']);

// ✓ queryTwo("SELECT * FROM koszyk WHERE id_klienta = '%s' AND id_ksiazki = '%s'", "cart_verify_book", [1,1]); // [1, 2]

// ✓ queryTwo("UPDATE koszyk SET ilosc=ilosc+'%s' WHERE id_klienta='%s' AND id_ksiazki='%s'", "", [1,1,1]); // [1,1,2]

// ✓ queryTwo("INSERT INTO koszyk (ilosc, id_klienta, id_ksiazki) VALUES ('%s', '%s', '%s')", "", [7,1,9]);

// ✓ queryTwo("UPDATE koszyk SET ilosc='%s' WHERE id_klienta='%s' AND id_ksiazki='%s'", "", [42,1,1]); // [67,1,2]

// ✓ queryTwo("SELECT DISTINCT imie, nazwisko, id_autora FROM autor", "get_authors", "");

// ✓ queryTwo("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '%s'", "get_books",  $_SESSION['kategoria']); // $_SESSION['kategoria'] = "%a%"; "Informatyka";

// ✓ queryTwo("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE id_autora='%s'", "get_books", [1]); // [2]

// ✓ queryTwo("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_books", $search_value); // $search_value = "php"; "c++"

// ✓ queryTwo("SELECT id_ksiazki, autor.id_autora, tytul, cena, rok_wydania, kategoria FROM ksiazki, autor WHERE ksiazki.id_autora = autor.id_autora AND (autor.imie = '%s' OR autor.nazwisko = '%s')", "advanced_search", ["Jerzy", "Grębosz"]);

// ✓ queryTwo("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_books", "w ");

// ✓ queryTwo("SELECT * FROM klienci WHERE email='%s'", "log_in", $email_sanitized); // $email_sanitized = "jason1@wp.pl";

// ✓ queryTwo("SELECT id_zamowienia, data_zlozenia_zamowienia, status FROM zamowienia WHERE id_klienta = '%s'", "get_orders", $id_klienta); // $id_klienta = 1;


// ✓ queryTwo("INSERT INTO zamowienia (id_zamowienia, id_klienta, data_zlozenia_zamowienia, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, forma_dostarczenia, status) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "get_last_order_id", $order); // $order = [1,"2023-03-09 10:26:04", "2023-03-14", "2023-03-10 10:26:04", "2023-03-14", "Kurier DPD", "W trakcie realizacji"];

// ✓ queryTwo("INSERT INTO platnosci (id_platnosci, id_zamowienia, data_platnosci, kwota, sposob_platnosci) VALUES (NULL, '%s', '%s', '%s', '%s')", "", $payment); // payment = [524, "2023-03-09 10:26:04", 125.23, "Blik"];

// ✓ queryTwo("SELECT id_zamowienia, id_ksiazki, ilosc FROM szczegoly_zamowienia WHERE id_zamowienia = '%s'", "get_order_details", 822);

// ✓ queryTwo("SELECT tytul, cena, rok_wydania FROM ksiazki WHERE id_ksiazki = '%s'", "order_details_get_book", 2);

// ✓ queryTwo("SELECT id_klienta FROM klienci WHERE email='%s'", "register_verify_email", $email_s); // $email_s = "jason2@wp.pl";

// ✓ queryTwo("INSERT INTO klienci (id_klienta, imie, nazwisko, email, miejscowosc, ulica, numer_domu, kod_pocztowy, kod_miejscowosc, telefon, wojewodztwo, kraj, PESEL, data_urodzenia, login, haslo) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "register", $user); // $user = ["Paweł", "Michalczyk", "Dolna odra", "Słoneczna", 61, "64-600", "Dębno", " ", " ", " ", "0000-00-00", "505101303", "pawel133@wp.pl", " ", '$2y$10$DyzpDAkZJASZCDcTyDcYReyxU8M99xuI9BFK8hDvCw2SwaZt6oxaS'];

// ✓ queryTwo("DELETE FROM koszyk WHERE id_klienta='%s' AND id_ksiazki='%s'", "", $cart); // $cart = [1,1]; [1,2]

// ✓ queryTwo("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta); // $id_klienta = 1;

// ✓ queryTwo("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $_SESSION['id']);

// ✓ queryTwo("SELECT haslo FROM klienci WHERE id_klienta='%s'", "verify_password", $_SESSION['id']);

// ✓ queryTwo("UPDATE klienci SET haslo='kocham bekon' WHERE id_klienta='%s'", "", 38);

// ✓ queryTwo("SELECT * FROM klienci WHERE email='%s'", "check_email", "jason1@wp.pl");

// ✓ queryTwo("UPDATE klienci SET imie='%s', nazwisko='%s', email='%s', telefon='%s' WHERE id_klienta='%s'", "", ["Jan", "Nowak", "jan.nowak.382@wp.pl", 938092881, 41]);









?>