<?php

	session_start();

	include_once "../functions.php";

	// Do czego służy ten plik ? Zmienić jego nazwę na change password ?

	// jesli wszystkie pola sa ustawione i nie sa puste

	if(
        isset($_POST['haslo_confirm']) &&
        isset($_POST['powtorz_haslo_confirm']) &&
        !empty($_POST['haslo_confirm']) &&
        !empty($_POST['powtorz_haslo_confirm'])
    ) {
        //$stare_haslo =  md5($_POST['stare_haslo_edit']);
        //$nowe_haslo =  md5($_POST['nowe_haslo_edit']);
        //$powtorz_haslo =  md5($_POST['powtorz_haslo_edit']);

        //$haslo = $_POST['haslo_confirm']; // Powinienem to jakoś zakodować ? Zaszyfrować ? Tak aby nie było dostępne, bo ta zmienna trzyma jawnie hasło
        //$powtorz_haslo = $_POST['powtorz_haslo_confirm'];

        /*$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
        $powtorz_haslo = htmlentities($powtorz_haslo, ENT_QUOTES, "UTF-8");*/
//            $stare_haslo = strip_tags($stare_haslo);
//            $nowe_haslo = strip_tags($nowe_haslo);
//            $powtorz_haslo = strip_tags($powtorz_haslo);

        $haslo = filter_input(INPUT_POST, "haslo_confirm", FILTER_SANITIZE_STRING);
        $powtorz_haslo = filter_input(INPUT_POST, "powtorz_haslo_confirm", FILTER_SANITIZE_STRING);

        echo " -> " . $haslo . "<br>";
        echo " -> " . $powtorz_haslo . "<br>"; /*exit();*/

        $_SESSION['password_confirmed'] = true;

        $id = $_SESSION["id"];

        if ($haslo !== $powtorz_haslo) {
            $_SESSION['password_confirmed'] = false;
        }

        query("SELECT haslo FROM klienci WHERE id_klienta='%s'", "verify_password", $id); // ta funkcja ustawia zmienna sesyjna $_SESSION['stare_haslo'] ktora przechowuje haslo (hash hasła) z BD // CZY TO BEZPIECZNE ABY ZMIENNA SESYJNA PRZECHOWYWALA ZAHASHOWANE HASLO ?
        // $_SESSION['stare_haslo'] ----> PRZECHOWUJE AKTUALNE (ZAHASHOWANE) HASŁO Z BD !

        if (!password_verify($haslo, $_SESSION['stare_haslo'])) // true? -> hasze sa takie same (podano poprawne hasło do konta)
        {
            $_SESSION['password_confirmed'] = false;

            //$_SESSION['koszyk_ilosc_ksiazek'] = query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta);
            //$_SESSION['test123'] = test_fun();
            //$id_klienta = $_SESSION['id'];
            //$_SESSION['test123'] = query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta);


        }

//        if (!$_SESSION['password_confirmed']) {
//            header('Location: remove_account.php'); // przekierowanie do strony remove_account.php
//            exit();
//        }

        header('Location: remove_account.php'); // przekierowanie do strony remove_account.php
        exit();

    }














?>