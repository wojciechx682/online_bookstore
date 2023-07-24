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

    $format = 'Y-m-d'; // expected date format (YYYY-MM-DD)
    $todaysDate = date('Y-m-d'); // dzisiejsza data (Y-m-d) --> "2021-01-01";

    if(isset($_POST["order-date"]) && ! empty($_POST["order-date"])) { // termin_dostawy

        $orderDate = DateTime::createFromFormat($format, $_POST["order-date"]);

        // check if the date was parsed successfully and if it's a valid date
        if ( ! $orderDate || $orderDate->format($format) !== $_POST["order-date"]
             || $_POST["order-date"] < $todaysDate ) {
            // Invalid date format or an invalid date - or orderDate is previous that today's Date;
            echo "<span class='update-failed'>Wystąpił problem. Nie udało się zmienić statusu zamówienia</span>";
        } else {
            // valid date

            $_SESSION["order-date"] = $_POST["order-date"];

            query("UPDATE zamowienia SET termin_dostawy='%s', data_wysłania_zamowienia='', data_dostarczenia='', status='W trakcie realizacji' WHERE id_zamowienia = '%s'", "updateOrder", [$_POST["order-date"], $_SESSION["order-id"]]);
            // "W trakcie realizacji" -> termin_dostawy;
        }
    }
    if(isset($_POST["dispatch-date"]) && ! empty($_POST["dispatch-date"])) { // data_wysłania

        $dispatchDate = DateTime::createFromFormat($format, $_POST["dispatch-date"]);

        // check if the date was parsed successfully and if it's a valid date
        if ( ! $dispatchDate || $dispatchDate->format($format) !== $_POST["dispatch-date"]
             || $_POST["dispatch-date"] < $todaysDate) {
            // Invalid date format or an invalid date - or dispatchDate is previous that today's Date;
            echo "<span class='update-failed'>Wystąpił problem. Nie udało się zmienić statusu zamówienia</span>";
        } else {
            // valid date

            //$_SESSION["dispatch-date"] = $_POST["dispatch-date"];
            $_SESSION["dispatch-date"] = $_POST["dispatch-date"] . " " . $_POST["dispatch-time"];

            query("UPDATE zamowienia SET data_wysłania_zamowienia='%s', data_dostarczenia='', status='Wysłano' WHERE id_zamowienia = '%s'", "updateOrder", [$_SESSION["dispatch-date"], $_SESSION["order-id"]] );
            // "Wysłano" -> data_wyslania_zamowienia;
        }
    }
    if(isset($_POST["delivered-date"]) && ! empty($_POST["delivered-date"])) { // data_dostarczenia;

        $deliveredDate = DateTime::createFromFormat($format, $_POST["delivered-date"]);

        // check if the date was parsed successfully and if it's a valid date
        if ( ! $deliveredDate || $deliveredDate->format($format) !== $_POST["delivered-date"]
             || $_POST["delivered-date"] < $todaysDate) {
            // Invalid date format or an invalid date
            echo "<span class='update-failed'>Wystąpił problem. Nie udało się zmienić statusu zamówienia</span>";
        } else {
            // valid date

            $_SESSION["delivered-date"] = $_POST["delivered-date"];

            query("UPDATE zamowienia SET data_dostarczenia='%s', termin_dostawy='', data_wysłania_zamowienia='', status='Dostarczono' WHERE id_zamowienia = '%s'", "updateOrder", [$_POST["delivered-date"], $_SESSION["order-id"]] );
            // "Dostarczono" -> data_dostarczenia;
        }
    }

/*$_SESSION["update-successful"] = true;*/

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
