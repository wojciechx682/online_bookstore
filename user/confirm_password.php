<?php

    /*The code checks whether the password entered by the user in the "haslo_confirm" and "powtorz_haslo_confirm" fields match, and then checks whether the password matches the one stored in the database by calling the "password_verify" function. If the password does not match, or the password isn't correct - the user is redirected to the "remove_account.php" page.*/

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

        //$haslo = $_POST['haslo_confirm']; // Powinienem to jakoś zakodować ? Zaszyfrować ? Tak aby nie było dostępne, bo ta zmienna trzyma jawnie hasło
        //$powtorz_haslo = $_POST['powtorz_haslo_confirm'];

//        $haslo = htmlentities($_POST['haslo_confirm'], ENT_QUOTES, "UTF-8");
//        $powtorz_haslo = htmlentities($_POST['powtorz_haslo_confirm'], ENT_QUOTES, "UTF-8");
//            $nowe_haslo = strip_tags($haslo);
//            $powtorz_haslo = strip_tags($powtorz_haslo);

        $haslo = filter_input(INPUT_POST, "haslo_confirm", FILTER_SANITIZE_STRING);
        $powtorz_haslo = filter_input(INPUT_POST, "powtorz_haslo_confirm", FILTER_SANITIZE_STRING);

        $_SESSION['password_confirmed'] = true;

        $id = filter_var($_SESSION['id'], FILTER_SANITIZE_NUMBER_INT);

        if ($haslo !== $powtorz_haslo) {
            $_SESSION['password_confirmed'] = false;
        } else {
            query("SELECT haslo FROM klienci WHERE id_klienta='%s'", "verify_password", $id); // ta funkcja ustawia zmienna sesyjna $_SESSION['stare_haslo'] ktora przechowuje haslo (hash hasła) z BD;
            // $_SESSION['stare_haslo'] ----> PRZECHOWUJE AKTUALNE (ZAHASHOWANE) HASŁO Z BD;
        }

        if (!password_verify($haslo, $_SESSION['stare_haslo'])) // true? -> hasze sa takie same (podano poprawne hasło do konta)
        {
            // podane złe hasło
            $_SESSION['password_confirmed'] = false;
        }

        header('Location: remove_account.php'); // przekierowanie do strony remove_account.php
        exit();
    }
?>