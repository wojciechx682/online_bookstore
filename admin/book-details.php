<?php
    /*session_start();
    include_once "../functions.php";

    if(!(isset($_SESSION['zalogowany']))) {
        header("Location: ../user/___index2.php?login-error");
        exit();
    }*/

    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
    require_once "../authenticate-admin.php";
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

                <?php

                    $_SESSION["book-id"] = $_GET["book"]; // $_GET -> id_książki - "36";
                    $_SESSION["warehouse-id"] = $_GET["warehouse"]; // $_GET -> id_magazynu- "1";

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
                                    WHERE ks.id_ksiazki = '%s' AND magks.id_magazynu = '%s' LIMIT 1","get_book_details", [$_SESSION["book-id"], $_SESSION["book-id"], $_SESSION["book-id"], $_SESSION["book-id"], $_SESSION["warehouse-id"]]); // dane szczegółowe książki;
                        // !!! W PRZYSZŁOŚCI -> USUNĄĆ LIMIT 1 - a zamiast tego dodać "id_magazynu" !!!
                ?>

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