<?php

session_start();
include_once "../functions.php";

    // plik obsługujący żądanie POST aktualizujące termin dostawy zamówienia ->

    // (!) w książce było info o tym, że znajdują się na stronie pliki PHP obsługujące żądania AJAX,
    // muszę z nich skorzystać bo nie wiem co ma robić i jak wyglądać plik PHP obsługujący żądanie;

    $date = $_POST["order-date"];

    //echo "<br> dateValue -> " . $date;

    //exit();

    query("UPDATE zamowienia SET termin_dostawy='%s', status='W trakcie realizacji' WHERE id_zamowienia = '%s'", " // updateOrder // ", [$date, $_SESSION["order-id"]]);

    // (!) Dodać walidacje daty - tutaj albo w JS !

    // (!) trzeba sprawdzić, czy udało się zrealizować ZAPYTANIE. można użyć do tego nowej funkcji we funkcji query()

    // albo przeczytać strony z książki

?>