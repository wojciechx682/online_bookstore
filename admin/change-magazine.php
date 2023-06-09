<?php

session_start(); // admin/books.php
include_once "../functions.php";

    if(isset($_POST["change-magazine"]) && !empty($_POST["change-magazine"])) {

        $warehouseId = filter_var($_POST["change-magazine"], FILTER_VALIDATE_INT); // returns - filtered_value - or - false;

        if($warehouseId) { // $warehouseId passed the filter and is a valid integer;

            query("SELECT ks.id_ksiazki, ks.tytul, ks.cena,
                     kt.nazwa AS nazwa_kategorii, mgk.ilosc_dostepnych_egzemplarzy, au.imie, au.nazwisko, mg.nazwa AS nazwa_magazynu, mg.id_magazynu
                     FROM ksiazki AS ks, subkategorie AS sbk, kategorie AS kt, autor AS au, magazyn_ksiazki AS mgk, magazyn AS mg
                     WHERE ks.id_subkategorii = sbk.id_subkategorii AND sbk.id_kategorii = kt.id_kategorii AND ks.id_autora = au.id_autora AND mgk.id_ksiazki = ks.id_ksiazki AND mgk.id_magazynu = mg.id_magazynu AND mg.id_magazynu='%s'", "get_all_books", $warehouseId); // content of the table;
        } else {   // $warehouseId didn't pass the filter - something went wrong - error (!);

            echo '<span class="admin-books-error" style="display: block;">Wystąpił błąd. Serwer nie zwrócił poprawnych danych. Spróbuj ponownie później</span>';
        }
    }

    // else (?) ;   // z tego co widzę to jeśli wystąpił błąd z id-magazynu, JS obsługuje to wcześniej i wyswietla błąd;
                    // co prawda można to dalej rozbudowywać ale po co ?

?>