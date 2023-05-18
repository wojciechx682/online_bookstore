<?php

session_start();
include_once "../functions.php";

    // plik obsługujący żądanie POST aktualizujące termin dostawy zamówienia ->

    // (!) w książce było info o tym, że znajdują się na stronie pliki PHP obsługujące żądania AJAX,
    // muszę z nich skorzystać bo nie wiem co ma robić i jak wyglądać plik PHP obsługujący żądanie ;

    // $date = $_POST["order-date"]; // termin dostawy
    // $dispDate = $_POST["dispatch-date"]; // data wysyłki
    // data serialized (string) =>  order-date=2023-05-17&dispatch-date=2023-05-18 ;

                                                            // echo "<br> dateValue -> " . $date; // "dateValue -> 2023-05-16" ;
                                                            // exit() ;

    $_SESSION["update-successful"] = true;

    if(isset($_POST["order-date"])) {
        query("UPDATE zamowienia SET termin_dostawy='%s', status='W trakcie realizacji' WHERE id_zamowienia = '%s'", "updateOrder", [$_POST["order-date"], $_SESSION["order-id"]]);
    }

    if(isset($_POST["dispatch-date"])) {
        query("UPDATE zamowienia SET data_wysłania_zamowienia='%s', status='Wysłano' WHERE id_zamowienia = '%s'", "updateOrder", [$_POST["dispatch-date"], $_SESSION["order-id"]] );
    }

    if(isset($_POST["delivered-date"])) {
        // walidacja + sanityzacja danych ?
        query("UPDATE zamowienia SET data_dostarczenia='%s', status='Dostarczono' WHERE id_zamowienia = '%s'", "updateOrder", [$_POST["delivered-date"], $_SESSION["order-id"]] );
    }

    if(isset($_SESSION["update-successful"]) && $_SESSION["update-successful"] === false ) {
        unset($_SESSION["update-successful"]);
        echo "<span class='update-success'>Udało się zmienić status zamówienia</span>";
    } else { // ture
        echo "<span class='update-failed'>Wystąpił problem. Nie udało się zmienić statusu zamówienia</span>";
    }

    // var_dump($_SESSION);

    // exit();

    // (!) Dodać walidacje daty - tutaj albo w JS !

    // (!) trzeba sprawdzić, czy udało się zrealizować ZAPYTANIE. można użyć do tego nowej funkcji we funkcji query()

    // albo przeczytać strony z książki

?>