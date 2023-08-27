<?php
    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
    require_once "../authenticate-admin.php";

// PRG --> orders.php --> POST (order-id) --> order-details.php ;

    if( $_SERVER['REQUEST_METHOD'] === "POST" ) { // isset($_POST)  ̶&̶&̶ ̶!̶ ̶e̶m̶p̶t̶y̶(̶$̶_̶P̶O̶S̶T̶)̶   POST;

        if ( isset($_POST["book-id"]) && ! empty($_POST["book-id"])
            && isset($_POST["warehouse-id"]) && ! empty($_POST["warehouse-id"])
        ) {  // check if POST value (book-id,
            //                       warehouse-id) exists and is not empty;

            // process the form data and perform necessary validations ;

            $bookId = filter_var($_POST["book-id"], FILTER_SANITIZE_NUMBER_INT); // sanitize input - book-id ;
            $warehouseId = filter_var($_POST["warehouse-id"], FILTER_SANITIZE_NUMBER_INT); //      warehouse-id ;
            // sanitization -> remove all characters except digits, plus and minus sign.

            // validate book-id - ✓ valid integer ;
            $_SESSION["book-id"] = filter_var($bookId, FILTER_VALIDATE_INT); // ✓ it ensures that the value is an integer - book-id ;
            $_SESSION["warehouse-id"] = filter_var($warehouseId, FILTER_VALIDATE_INT);

            // check if there is really a book with that id ;
            $_SESSION['book_exists'] = false;

            unset($_SESSION["book_exists"]);
            // check if there is really an order with that id (post - order-id);
            query("SELECT id_ksiazki FROM ksiazki WHERE id_ksiazki = '%s'", "verifyBookExists", $_SESSION["book-id"]);
            // sprawdzenie, czy ta książka istnieje w bd ; check if there is any book with given POST id; jeśli num_rows > 0    -> przestawi
            // $_SESSION['book_exists'] -> na true ;

            if($bookId === false || $warehouseId === false || $_SESSION["book-id"] === false || $_SESSION["warehouse-id"] === false || $_SESSION['book_exists'] === false || ($_SESSION["book-id"] != $_POST["book-id"]) || ($_SESSION["warehouse-id"] != $_POST["warehouse-id"])) {

                // tutaj trzeba odpowiednio obsłużyć błąd ;
                    // ✓ book-id nie przeszło walidacji, LUB ✓ nie istnieje książka o takim id;
                        // musi być komunikat o błędzie (np okienko) + exit() ! ;
                        //echo "<br><hr> 43 invalid order-id OR order doesnt exist ! <br><hr>";
                        // obsługa błędu - np przekierowanie na poprzednią stronę (orders.php) + wyświetlenie okienka z okmunikatem
                        // na stronie index.php można sprawdzić, czy np ustawiona wartość $_SESSION["error_costam"] ma wartosc true, i wtedy wyswietlic okienko
                        // $_SESSION["error"] = true ;
                unset($_POST, $bookId, $warehouseId, $_SESSION["book-id"], $_SESSION["warehouse-id"], $_SESSION['book-exists']);
                /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                echo "GET ->"; print_r($_GET); echo "<hr><br>";
                echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/
                header('Location: books.php'); exit();

            } else { // input is OK - book-id, warehouse-id passed validation,    there is a book with that ID;
                //               Valid order-id           and           order exist
                // Execute code (such as database updates) here;
                // Perform any required actions with the form data (e.g., database update)

                    // ✓✓✓ valid book-id, book exist in db;
                    //echo "\n 49 SESSION order-id -> " . $_SESSION["book-id"];
                    //echo "<br> 51 Valid order-id and order exist ! <br><hr>"; exit();
                unset($_POST, $bookId, $warehouseId, $_SESSION["book-exists"], $_SESSION["warehouse-id"]);
                // redirect to the page itself
                //header('Location: ___book.php', true, 303);

                //echo "\n69"; exit();

                // Redirect to prevent form resubmission
                header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); exit();
                // to prevent resubmitting the form
            }

        } elseif (isset($_POST["book-id"]) && !empty($_POST["book-id"]) && empty($_SESSION["warehouse-id"])) {

            // \order-details.php --> \book-details.php

            $_SESSION["book-id"] = $_POST["book-id"];

            header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); exit();

        }
        /*else {
            // zmienna POST nie istnieje,   nastąpiło wejście pod http://localhost:8080/online_bookstore/admin/book-details.php bez podania wartości w POST[] ;
                //echo "<br> POST value (book-id) doesnt exist ! <br>" ;

            header('Location: books.php'); exit();
                // $_SESSION["error"] = true ;

        }*/

    } /*elseif (
        $_SERVER['REQUEST_METHOD'] === "GET" && ( (!isset($_SESSION["book-id"]) || empty($_SESSION["book-id"])) && (! isset($_SESSION["warehouse-id"]) || empty($_SESSION["warehouse-id"])) )
    ) {
        header('Location: books.php'); exit();
    }*/

?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>

<body>

<div id="main-container">

    <div id="container">

        <main>

            <?php require "../template/admin/nav.php"; ?>

            <?php require "../template/admin/top-nav.php"; ?>

            <div id="content">

                <h3 class="section-header book-details-section-header">Szczegóły książki</h3>

                <?php if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_SESSION["book-id"]) && isset($_SESSION["warehouse-id"]) ) : ?>

                <?php

                    //$_SESSION["book-id"] = $_GET["book"]; // $_GET -> id_książki - "36";
                    //$_SESSION["warehouse-id"] = $_GET["warehouse"]; // $_GET -> id_magazynu- "1";

                    query("SELECT ks.tytul, ks.cena, ks.rok_wydania, au.imie, au.nazwisko, wd.nazwa_wydawcy, ks.opis, ks.wymiary, ks.ilosc_stron, 
                                        ks.oprawa, ks.stan, ks.rating AS srednia_ocen, ks.image_url,
                                (SELECT COUNT(*) FROM ratings WHERE ratings.id_ksiazki = ks.id_ksiazki) AS liczba_ocen, 
                                (SELECT COUNT(*) FROM koszyk WHERE id_ksiazki='%s' GROUP BY id_ksiazki) AS liczba_klientow_posiadajacych_w_koszyku,
                                (SELECT SUM(ilosc) FROM szczegoly_zamowienia WHERE id_ksiazki='%s' GROUP BY id_ksiazki) AS liczba_sprzedanych_egzemplarzy,						  
                                (SELECT COUNT(*) FROM szczegoly_zamowienia, ksiazki WHERE szczegoly_zamowienia.id_ksiazki = ksiazki.id_ksiazki AND ksiazki.id_ksiazki='%s'
                                GROUP BY szczegoly_zamowienia.id_ksiazki) AS ilosc_zamowien_w_ktorych_wystapila, 
                                kat.nazwa AS nazwa_kategorii, sub.nazwa AS nazwa_subkategorii, magks.ilosc_dostepnych_egzemplarzy, mag.nazwa AS nazwa_magazynu, mag.kraj, mag.wojewodztwo, mag.miejscowosc, mag.ulica, mag.numer_ulicy, mag.kod_pocztowy, mag.kod_miejscowosc
                                    FROM ksiazki AS ks
                                    JOIN autor AS au ON ks.id_autora = au.id_autora
                                    JOIN wydawcy AS wd ON ks.id_wydawcy = wd.id_wydawcy
                                    JOIN subkategorie AS sub ON ks.id_subkategorii = sub.id_subkategorii
                                    JOIN kategorie AS kat ON sub.id_kategorii = kat.id_kategorii
                                    JOIN magazyn_ksiazki AS magks ON ks.id_ksiazki = magks.id_ksiazki
                                    JOIN magazyn AS mag ON magks.id_magazynu = mag.id_magazynu
                                    WHERE ks.id_ksiazki = '%s' AND magks.id_magazynu = '%s'","get_book_details", [$_SESSION["book-id"], $_SESSION["book-id"], $_SESSION["book-id"], $_SESSION["book-id"], $_SESSION["warehouse-id"]]); // LIMIT 1
                        // dane szczegółowe książki i informacje o jej dostępności w magazynie;
                        // szczeółowe informacje o książce;
                        // "różne informacje związane z określoną książką i jej dostępnością w magazynie"

                        // !!! W PRZYSZŁOŚCI -> USUNĄĆ LIMIT 1 - a zamiast tego dodać "id_magazynu" !!
//  funkcje agregujące

                        // Symfonia C++ wydanie V |
                        // 10 (cena) |
                        // 2008 |
                        // Jerzy | Grębosz |
                        // PWN |
                        // Lorem ipsum dolor sit amet, consectetur adipiscing... (opis) |
                        // 411 x 382 x 178 |
                        // 585 |
                        // twarda |
                        // nowa (stan) |
                        // 4 (srednia_ocen) |
                        // csymfoni_wyd_V.png |
                        // 0 (liczba_ocen) |
                        // NULL (ilosc klientów pos. w koszyku) |
                        // NULL (liczba sprzed. egzemplarzy) |
                        // NULL (ilosc zamówień w których wystąpiła) |
                        // Informatyka |
                        // Programowanie |
                        // 0 (! ilość dostępnych egzemplarzy |
                        // magazyn nr 1 |
                        // Polska | Zachodmiopomorskie | Szczecin | Fryderyka Chopina 3 | 800-21 Szczecin
                ?>

                <?php endif; ?>


                <?php if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_SESSION["book-id"]) && !isset($_SESSION["warehouse-id"]) ) : ?>

                    <?php

                        query("SELECT ks.tytul, ks.cena, ks.rok_wydania, au.imie, au.nazwisko, wd.nazwa_wydawcy, ks.opis, ks.wymiary, ks.ilosc_stron,
                                       ks.oprawa, ks.stan, ks.rating AS srednia_ocen, ks.image_url,
                                       (SELECT COUNT(*) FROM ratings WHERE ratings.id_ksiazki = ks.id_ksiazki) AS liczba_ocen,
                                       (SELECT COUNT(*) FROM koszyk WHERE id_ksiazki='%s' GROUP BY id_ksiazki) AS liczba_klientow_posiadajacych_w_koszyku,
                                       (SELECT SUM(ilosc) FROM szczegoly_zamowienia WHERE id_ksiazki='%s' GROUP BY id_ksiazki) AS liczba_sprzedanych_egzemplarzy,
                                       (SELECT COUNT(*) FROM szczegoly_zamowienia, ksiazki WHERE szczegoly_zamowienia.id_ksiazki = ksiazki.id_ksiazki AND ksiazki.id_ksiazki='%s'
                                        GROUP BY szczegoly_zamowienia.id_ksiazki) AS ilosc_zamowien_w_ktorych_wystapila,
                                       kat.nazwa AS nazwa_kategorii, sub.nazwa AS nazwa_subkategorii, magks.ilosc_dostepnych_egzemplarzy, mag.nazwa AS nazwa_magazynu, mag.kraj, mag.wojewodztwo, mag.miejscowosc, mag.ulica, mag.numer_ulicy, mag.kod_pocztowy, mag.kod_miejscowosc
                                FROM ksiazki AS ks
                                         JOIN autor AS au ON ks.id_autora = au.id_autora
                                         JOIN wydawcy AS wd ON ks.id_wydawcy = wd.id_wydawcy
                                         JOIN subkategorie AS sub ON ks.id_subkategorii = sub.id_subkategorii
                                         JOIN kategorie AS kat ON sub.id_kategorii = kat.id_kategorii
                                         JOIN magazyn_ksiazki AS magks ON ks.id_ksiazki = magks.id_ksiazki
                                         JOIN magazyn AS mag ON magks.id_magazynu = mag.id_magazynu
                                WHERE ks.id_ksiazki = '%s' LIMIT 1", "get_book_details",  [$_SESSION["book-id"], $_SESSION["book-id"], $_SESSION["book-id"], $_SESSION["book-id"]]);

                    ?>

                <?php endif; ?>

            </div> <!-- #content -->
        </main>
    </div> <!-- #container -->

</div> <!-- #all-container -->

<script>

        let ordersCount = document.getElementById("book-orders-count-content"); // wstawienie "0" - jeśli wartości zwrócone z BD wynosiły NULL;
        let cartCount = document.getElementById("book-cart-count-content");
        let itemsSold = document.getElementById("book-items-sold-content");

    if (ordersCount.innerHTML === '') {
        ordersCount.innerHTML = "0";
    }
    if (cartCount.innerHTML === '') {
        cartCount.innerHTML = "0";
    }
    if (itemsSold.innerHTML === '') {
        itemsSold.innerHTML = "0";
    }
</script>

</body>
</html>