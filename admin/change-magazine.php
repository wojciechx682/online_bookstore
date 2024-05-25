<?php
    // admin/books.php;

    require_once "../authenticate-admin.php"; // check if user is logged-in, and user-type is "admin" - if not, redirect to login page;

    if(isset($_POST["change-magazine"]) && !empty($_POST["change-magazine"])) {

        $warehouseId = filter_var($_POST["change-magazine"], FILTER_VALIDATE_INT); // returns - filtered_value - or - false;

        $values = []; //   VALUES USED AS ARGUMENTS;

        if($warehouseId) { // $warehouseId passed the filter and is a valid integer;

            $values[] = $warehouseId;

            $query = "SELECT ks.id_ksiazki, ks.tytul, ks.cena,
                     kt.nazwa AS nazwa_kategorii, mgk.ilosc_dostepnych_egzemplarzy, au.imie, au.nazwisko, mg.nazwa AS nazwa_magazynu, mg.id_magazynu
                     FROM books AS ks, subcategories AS sbk, categories AS kt, author AS au, warehouse_books AS mgk, warehouse AS mg
                     WHERE ks.id_subkategorii = sbk.id_subkategorii AND sbk.id_kategorii = kt.id_kategorii AND ks.id_autora = au.id_autora AND mgk.id_ksiazki = ks.id_ksiazki AND mgk.id_magazynu = mg.id_magazynu AND mg.id_magazynu='%s'";

            if(isset($_POST["admin-search-books-input"]) && ! empty($_POST["admin-search-books-input"])) {

                $bookTitle = filter_var($_POST["admin-search-books-input"], FILTER_SANITIZE_STRING);

                if($bookTitle) {
                    $where[] = " AND ks.tytul LIKE '%%%s%%'";
                    $values[] = $bookTitle;
                }
            }

            if (!empty($where)) {
                $query .= implode(" AND ", $where);
            }

            query($query, "get_all_books", $values);

            // content of the table;
            // książki, które znajdują się w tym magazynie;
            // id_ksiazki	tytul	cena	nazwa_kategorii	ilosc_dostepnych_egzemplarzy	imie	nazwisko	nazwa_magazynu	id_magazynu

            // 1	Symfonia C++ wydanie V	10	Informatyka	0	Jerzy	Grębosz	magazyn nr 1	1
            // 2	PHP i MySQL. Od podstaw. Wydanie IV	75.5	Informatyka	235	Adam	Nowak	magazyn nr 1	1
            // 7	Duchy i lisy	58.82	Dla dzieci	15	Radosław	Walczak	magazyn nr 1	1
            // 36	CSS Nieoficjalny podręcznik	20	Informatyka	265	Cezary	Sokołowski	magazyn nr 1	1

        } else {
                        // $warehouseId didn't pass the filter - something went wrong - error (!);
            echo '<span class="admin-books-error" style="display: block;">Wystąpił błąd. Serwer nie zwrócił poprawnych danych. Spróbuj ponownie później</span>';
        }
    } else {
        echo '<span class="admin-books-error" style="display: block;">Wystąpił błąd. Serwer nie zwrócił poprawnych danych. Spróbuj ponownie później</span>';
        // ✓else (?) ;   // ✓ z tego co widzę to jeśli wystąpił błąd z id-magazynu, JS obsługuje to wcześniej i wyswietla błąd;
        // ✓ co prawda można to dalej rozbudowywać ale po co ?
    }
?>
