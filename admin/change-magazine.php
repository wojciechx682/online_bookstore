<?php

session_start();
include_once "../functions.php";

    // admin/books.php

    //print_r($_POST);

    if(isset($_POST["change-magazine"]) && !empty($_POST["change-magazine"])) {
        //echo $_POST["change-magazine"];

        //$warehouseId = $_POST["change-magazine"];

        $warehouseId = filter_var($_POST["change-magazine"], FILTER_VALIDATE_INT);

        if($warehouseId) {
            // $warehouseId passed the filter and is a valid integer;
            query("SELECT ks.id_ksiazki, ks.tytul, ks.cena,
                     kt.nazwa AS nazwa_kategorii, mgk.ilosc_dostepnych_egzemplarzy, au.imie, au.nazwisko, mg.nazwa AS nazwa_magazynu, mg.id_magazynu
                     FROM ksiazki AS ks, subkategorie AS sbk, kategorie AS kt, autor AS au, magazyn_ksiazki AS mgk, magazyn AS mg
                     WHERE ks.id_subkategorii = sbk.id_subkategorii AND sbk.id_kategorii = kt.id_kategorii AND ks.id_autora = au.id_autora AND mgk.id_ksiazki = ks.id_ksiazki AND mgk.id_magazynu = mg.id_magazynu AND mg.id_magazynu='%s'", "get_all_books", $warehouseId); // content of the table;
        } else {
            // $warehouseId didn't pass the filter - something went wrong - error (!);
            echo '<span class="admin-books-error" style="display: block;">Wystąpił błąd. Serwer nie zwrócił poprawnych danych. Spróbuj ponownie później</span>'; // This was never tested (!)
        }

        /*echo "<br> warehouseId = " . $warehouseId . "<br>";
        echo "<br> isset(warehouseId) = " . isset($warehouseId) . "<br>";
        echo "<br> empty(warehouseId) = " . empty($warehouseId) . "<br>";*/


        /*query("SELECT ks.id_ksiazki, ks.tytul, ks.cena,
                     kt.nazwa AS nazwa_kategorii, mgk.ilosc_dostepnych_egzemplarzy, au.imie, au.nazwisko, mg.nazwa AS nazwa_magazynu, mg.id_magazynu
                     FROM ksiazki AS ks, subkategorie AS sbk, kategorie AS kt, autor AS au, magazyn_ksiazki AS mgk, magazyn AS mg
                     WHERE ks.id_subkategorii = sbk.id_subkategorii AND sbk.id_kategorii = kt.id_kategorii AND ks.id_autora = au.id_autora AND mgk.id_ksiazki = ks.id_ksiazki AND mgk.id_magazynu = mg.id_magazynu AND mg.id_magazynu='%s'", "get_all_books", "");*/ // content of the table;
    }

?>