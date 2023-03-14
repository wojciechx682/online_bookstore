
<style>
    body {
        background-color: #565f8c;
        color: white;
        font-size: 150%;
    }
</style>


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

    require "../functions.php";
?>
<hr><br>

<?php
    function queryTwo($query, $fun, $value)
    {
        $type = get_first_word($query); // type = SELECT, INSERT

        require "../connect.php";
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
                    echo "<hr>";
                    echo "<br>";
                    echo "<br> result -->";
                    echo "<br>";
                    echo "<br>";
                    echo "<br>";
                    print_r($result); echo "<br><br>";
                    echo "<br>";
                    echo "<br>";
                    var_dump($result); echo "<br><br>";
                    echo "<br>";
                    echo "<br>";
                    echo "<hr>";
                    echo "<hr>";
                    echo "<br>";
                    echo "<br> result -->";
                    echo "gettype(result) -->";
                    echo "<br>";
                    echo gettype($result); echo "<br><br>";
                    echo "<br>";
                    echo "<br>";
                    echo "<hr>";

                    echo '<span style="color: lightblue;"><br> query ( ) -> ' .$query . '</span><br><hr>';

                    if(gettype($result) != "object") {
                        // INSERT, UPDATE ... result => boolean (bool)

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
                            //echo '<h3>Brak wyników</h3>'; // brak zwróconych rekordów (np 0 zwróconych wierszy)

                            if($fun != "") {   // logowanie.php ✓ -> podany zły email (num_rows ---> 0 (brak) zwr. rekordów;
                                $fun($result);
                            }
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

<!--<script>alert();</script>-->

<?php

//$id = '<script>alert();</script>';
//define('INPUT_SESSION', 4);

$_SESSION["id"] = '140';

//exit();

/*$id = filter_var($_SESSION['id'], FILTER_SANITIZE_STRING);
$id = htmlentities($id, ENT_QUOTES, "UTF-8");
$id = strip_tags($id);*/

//$id = strip_tags(htmlentities(filter_var($_SESSION['id'], FILTER_SANITIZE_STRING), ENT_QUOTES, 'UTF-8'));


echo "<br>sesion id ->".$_SESSION["id"]."<br>";
/*echo "<br>id ->".$id."<br>";*/

// queryTwo("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $_SESSION["id"]); // książki które zamówił klient o danym ID;

/*$_POST["id_ksiazki"] = 1;
$_POST["koszyl_ilosc"] = 1;*/
$id_ksiazki = 1;
$ilosc = 1;
$id_ksiazki = filter_input(INPUT_POST, "id_ksiazki", FILTER_SANITIZE_NUMBER_INT);
$ilosc = filter_input(INPUT_POST, "koszyl_ilosc", FILTER_SANITIZE_NUMBER_INT);
echo "<br> id ksiazki->" . $id_ksiazki. "<br>";
echo "<br> ilosc ->" . $ilosc. "<br>";
$book = [$id_ksiazki, $ilosc];

// ✓ queryTwo("SELECT * FROM koszyk WHERE id_klienta = '%s' AND id_ksiazki = '%s'", "cart_verify_book", $book); // [1, 2]

$book[0] = 1;
$book[1] = $_SESSION["id"];
$book[2] = 1;
//print_r($book);

// ✓ queryTwo("UPDATE koszyk SET ilosc=ilosc+'%s' WHERE id_klienta='%s' AND id_ksiazki='%s'", "", $book); // [1,1,2]

// Array ( [0] => 1 [1] => 140 [2] => 1 )
/*$book = [1,140,1];
print_r($book);*/

// ✓ queryTwo("INSERT INTO koszyk (ilosc, id_klienta, id_ksiazki) VALUES ('%s', '%s', '%s')", "", $book);

/*$book = [33,140,1];
print_r($book);*/
// ✓ queryTwo("UPDATE koszyk SET ilosc='%s' WHERE id_klienta='%s' AND id_ksiazki='%s'", "", $book); // [67,1,2]

// ✓queryTwo("SELECT DISTINCT imie, nazwisko, id_autora FROM autor", "get_authors", $book);

                // queryTwo("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '%s'", "get_books",  $_SESSION['kategoria']); // $_SESSION['kategoria'] = "%a%"; "Informatyka";

               // ✓ queryTwo("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE id_autora='%s'", "get_books", [1]); // [2]

// $search_value = 'php';
// ✓ queryTwo("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_books", $search_value); // $search_value = "php"; "c++"

// ✓ queryTwo("SELECT id_ksiazki, autor.id_autora, tytul, cena, rok_wydania, kategoria FROM ksiazki, autor WHERE ksiazki.id_autora = autor.id_autora AND (autor.imie = '%s' OR autor.nazwisko = '%s')", "advanced_search", [$n, $s]); // THIS IS NOT BEING USED !

// ✓ queryTwo("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_books", "w ");

$email_sanitized = "jason1@wp.pl";

// ---->
//queryTwo("SELECT * FROM klienci WHERE email='%s'", "log_in", $email_sanitized); // $email_sanitized = "jason1@wp.pl";

// $id_klienta = 140;
// ✓ queryTwo("SELECT id_zamowienia, data_zlozenia_zamowienia, status FROM zamowienia WHERE id_klienta = '%s'", "get_orders", $id_klienta); // $id_klienta = 1;

// ✓ queryTwo("INSERT INTO zamowienia (id_zamowienia, id_klienta, data_zlozenia_zamowienia, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, forma_dostarczenia, status) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "get_last_order_id", $order); // $order = [1,"2023-03-09 10:26:04", "2023-03-14", "2023-03-10 10:26:04", "2023-03-14", "Kurier DPD", "W trakcie realizacji"];


// ✓ queryTwo("INSERT INTO platnosci (id_platnosci, id_zamowienia, data_platnosci, kwota, sposob_platnosci) VALUES (NULL, '%s', '%s', '%s', '%s')", "", $payment); // $payment = [524, "2023-03-09 10:26:04", 125.23, "Blik"];

// ✓ queryTwo("SELECT id_zamowienia, id_ksiazki, ilosc FROM szczegoly_zamowienia WHERE id_zamowienia = '%s'", "get_order_details", 840);

// ✓ queryTwo("SELECT tytul, cena, rok_wydania FROM ksiazki WHERE id_ksiazki = '%s'", "order_details_get_book", 1);

// ✓ queryTwo("SELECT id_klienta FROM klienci WHERE email='%s'", "register_verify_email", 'jason777771@wp.pl'); // $email_s = "jason2@wp.pl"; // !!!

/*$user = ["Paweł", "Michalczyk", "pawel133@wp.pl", "Dolna odra", "Słoneczna", 61, "64-600", "Dębno", "505101303", " ", " ", " ", "0000-00-00",  " ", '$2y$10$DyzpDAkZJASZCDcTyDcYReyxU8M99xuI9BFK8hDvCw2SwaZt6oxaS'];

queryTwo("INSERT INTO klienci (id_klienta, imie, nazwisko, email, miejscowosc, ulica, numer_domu, kod_pocztowy, kod_miejscowosc, telefon, wojewodztwo, kraj, PESEL, data_urodzenia, login, haslo) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "register", $user); // $user = ["Paweł", "Michalczyk", "Dolna odra", "Słoneczna", 61, "64-600", "Dębno", " ", " ", " ", "0000-00-00", "505101303", "pawel133@wp.pl", " ", '$2y$10$DyzpDAkZJASZCDcTyDcYReyxU8M99xuI9BFK8hDvCw2SwaZt6oxaS'];*/

// ✓ queryTwo("DELETE FROM koszyk WHERE id_klienta='%s' AND id_ksiazki='%s'", "", $cart); // $cart = [1,1]; [1,2]

// ✓ queryTwo("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", 140); // $id_klienta = 1;

// ✓ queryTwo("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $_SESSION['id']); // przestawi $_SESSION[koszyk_ilosc_ksiazek] => 5

// ✓ queryTwo("SELECT haslo FROM klienci WHERE id_klienta='%s'", "verify_password", $_SESSION['id']); // verify_password

// ✓ queryTwo("UPDATE klienci SET haslo='kocham bekon' WHERE id_klienta='%s'", "", 38); // verify_password

// ✓ queryTwo("SELECT * FROM klienci WHERE email='%s'", "check_email", "jason1@wp.pl");

// ✓ queryTwo("UPDATE klienci SET imie='%s', nazwisko='%s', email='%s', telefon='%s' WHERE id_klienta='%s'", "", ["Jan", "Nowak", "jan.nowak.382@wp.pl", 938092881, 140]);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// index ->
//queryTwo("SELECT DISTINCT imie, nazwisko, id_autora FROM autor", "get_authors", ""); // lista autorów
//
//query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE id_autora='%s'", "get_books", 1);
//
//query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.rating, au.imie, au.nazwisko FROM ksiazki AS ks, autor AS au WHERE ks.id_autora = au.id_autora AND ks.tytul LIKE '%%%s%%'", "get_books", $search_value);
//
//query("SELECT id_ksiazki, autor.id_autora, tytul, cena, rok_wydania, kategoria FROM ksiazki, autor WHERE ksiazki.id_autora = autor.id_autora AND (autor.imie = '%s' OR autor.nazwisko = '%s')", "advanced_search", $values);
//
//query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_books", $wyrazenie);
//}
//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Aktualizacja tabeli --> Szczegóły zamówienia  ✓ (na podstawie tabeli KOSZYK)
//
//queryTwo("SELECT id_klienta, id_ksiazki, ilosc FROM koszyk WHERE id_klienta='%s'", "insert_order_details", $_SESSION['id']); // wstawia dane do tabeli "szczegóły_zamowienia" - na podstawie tabeli koszyk - (zawartości koszyka danego klienta)
//
// query("SELECT tytul, cena, rok_wydania FROM ksiazki WHERE id_ksiazki = '%s'", "order_details_get_book", "1");
//
//// order-details ->
//
//query("SELECT id_zamowienia , id_ksiazki, ilosc FROM szczegoly_zamowienia WHERE id_zamowienia = '%s'", "get_order_details", $order_id);
//
//// (!)  reset password ->
// query("SELECT id_klienta, imie FROM klienci WHERE email='%s'", "check_email", "jason1@wp.pl");
//        // ustawi zmienną       $_SESSION['email_exists'] -> na "true", jeśli jest taki user (email) - (jeśli zwrócono rekordy z BD - result);
//        //                      $_SESSION["imie"];
//
//query("INSERT INTO password_reset_tokens (token_id, token, email, exp_time) VALUES (NULL, '%s', '%s', '%s')", "", $data);
//// wstawienie wpisu do tabeli z tokenami (token + emaiL);
//
//query("SELECT token_id, token, email, exp_time FROM password_reset_tokens WHERE token='%s'", "verify_token", $token_hashed); // $_SESSION["token_verified"] --> true jeśli podany token jest poprawny, $_SESSION["token verified"] = email_klienta_zgodny_z_tokenem;
////   $_SESSION["email"] = $row["email"];
////   $_SESSION["exp_time"] = $row["exp_time"];
//// $_SESSION["token_verified"] = true; (jeśli znaleziono taki token w BD)
//// $_SESSION["email"] = $row["email"];
//// $_SESSION["exp_time"] = $row["exp_time"];
//
//query("UPDATE klienci SET haslo = '%s' WHERE email = '%s'", "", $data);
//
//query("DELETE FROM password_reset_tokens WHERE email='%s'", "", $_SESSION["email"]);
//
//// validate password ->
//
//echo query("UPDATE klienci SET haslo='%s' WHERE id_klienta='%s'", "", $password);
//
//// validate user data ->
//query("SELECT * FROM klienci WHERE email='%s'", "check_email", $email_s); // to przełączy zmienną $_SESSION['email_exists'], jeśli taki email będzie istnieć
//
//query("UPDATE klienci SET imie='%s', nazwisko='%s', email='%s', telefon='%s' WHERE id_klienta='%s'", "", $user_data);


?>


