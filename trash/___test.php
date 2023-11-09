<?php

    session_start();
    include_once "../functions.php";



    echo "<br><hr><br>";

    // query("SELECT * FROM klienci WHERE id_klienta='%s'", "getClients", "220");

echo "<br><hr><br>";

/*$miejscowosc = "Dębno";
$ulica = "Wyszyńskiego";
$numer_domu = "55";
$kod_pocztowy = "74-400";
$miasto = "Dębno";
$id = "148";
$user_data = [$miejscowosc, $ulica, $numer_domu, $kod_pocztowy, $miasto, $id]; // $id - id_adresu;
    query("UPDATE adres SET miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s' WHERE adres_id='%s'", "", $user_data);*/

echo "<br><hr><br>";

query("SELECT haslo FROM customers WHERE id_klienta='%s'", "verify_password", "220");













































?>

