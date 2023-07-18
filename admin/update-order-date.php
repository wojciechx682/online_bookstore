<?php

/*session_start();
include_once "../functions.php";*/

// check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
require_once "../authenticate-admin.php";

    // plik obsługujący żądanie POST aktualizujące termin dostawy zamówienia;
        // $date = $_POST["order-date"]; // termin dostawy
        // $dispDate = $_POST["dispatch-date"]; // data swysyłki
        // data serialized (string) =>  order-date=2023-05-17&dispatch-date=2023-05-18;
            // walidacja + sanityzacja danych ?

    $_SESSION["update-successful"] = true;

    if(isset($_POST["order-date"]) && !empty($_POST["order-date"]) ) { // termin_dostawy

        query("UPDATE zamowienia SET termin_dostawy='%s', status='W trakcie realizacji' WHERE id_zamowienia = '%s'", "updateOrder", [$_POST["order-date"], $_SESSION["order-id"]]);  // "W trakcie realizacji" -> termin_dostawy;
    }
    if(isset($_POST["dispatch-date"]) && !empty($_POST["dispatch-date"])) { // data_wysłania

        query("UPDATE zamowienia SET data_wysłania_zamowienia='%s', status='Wysłano' WHERE id_zamowienia = '%s'", "updateOrder", [$_POST["dispatch-date"], $_SESSION["order-id"]] );  // "Wysłano" -> data_wyslania_zamowienia;
    }
    if(isset($_POST["delivered-date"]) && !empty($_POST["delivered-date"]) ) { // data_dostarczenia;

        query("UPDATE zamowienia SET data_dostarczenia='%s', status='Dostarczono' WHERE id_zamowienia = '%s'", "updateOrder", [$_POST["delivered-date"], $_SESSION["order-id"]] );  // "Dostarczono" -> data_dostarczenia;
    }

    if(isset($_SESSION["update-successful"]) && $_SESSION["update-successful"] === false) {
            unset($_SESSION["update-successful"]);
        echo "<span class='update-success'>Udało się zmienić status zamówienia</span>";
        //echo "<br><br>"; var_dump($_POST);
        // array(3) { ["order-date"]=> string(10) "2023-05-22" ["dispatch-date"]=> string(0) "" ["delivered-date"]=> string(0) "" }
    } else { // ture ;
        echo "<span class='update-failed'>Wystąpił problem. Nie udało się zmienić statusu zamówienia</span>";
    }

    // (!) Dodać walidacje daty - tutaj albo w JS;
    // ✓ trzeba sprawdzić, czy udało się zrealizować ZAPYTANIE. można użyć do tego nowej funkcji we funkcji query();
?>
