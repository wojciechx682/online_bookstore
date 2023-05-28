<?php
session_start();
include_once "../functions.php";

    // plik obsługujący żądanie POST - archiwizujące zamówienie + dodające komentarz (powód);
    // plik PHP obsługujący żądanie AJAX;

    // $orderId = $_POST["order-id"]; // id-zamówienia <input type="hidden">
    // $comment = $_POST["comment"];  // komentarz <textarea>

    // data serialized (string) =>  order-id=1039 & comment=test;

    if(isset($_POST["comment"])  && !empty($_POST["comment"]) && isset($_POST["order-id"]) && !empty($_POST["order-id"])) {

        $_SESSION["update-successful"] = true;

        $comment = filter_var($_POST["comment"],FILTER_SANITIZE_STRING); // sanityzacja (back-end)

        //echo "<br> id -> " . $_POST["order-id"] . "<br>";
        //echo "<br> comment -> " . $_POST["comment"] . "<br>";

        // należy pobrać id ostatnio wstawionego wiersza w tabeli klienci !
        query("UPDATE zamowienia SET komentarz='%s', status='%s' WHERE id_zamowienia = '%s'", "archiveOrder", [$_POST["comment"], "Zarchiwizowane", $_POST["order-id"]]); // "W trakcie realizacji" -> termin_dostawy;
    }

    if( isset($_SESSION["archive-successful"]) && $_SESSION["archive-successful"] === false ) {
        unset($_SESSION["archive-successful"]);
        echo "<span class='archive-success'>Udało się zmienić zarchiwizować zamówienie</span>";
    } else { // ture ;
        echo "<span class='update-failed'>Wystąpił problem. Nie udało się zmienić zarchiwizować zamówienia</span>";
    }

?>