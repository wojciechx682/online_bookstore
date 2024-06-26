<?php

    /* The code checks whether the password entered by the user in the "haslo_confirm" and "powtorz_haslo_confirm" fields match, and then checks whether the password matches the one stored in the database by calling the "password_verify" function. If the password does not match, or the password isn't correct - the user is redirected to the "remove_account.php" page.*/

	/*session_start();
	include_once "../functions.php";*/

    require_once "../start-session.php";

	// Do czego służy ten plik ? Zmienić jego nazwę na change password ?

	// jesli wszystkie pola sa ustawione i nie sa puste

	if ( isset($_POST["password"]) && !empty($_POST["password"]) &&
         isset($_POST["confirmPassword"]) && !empty($_POST["confirmPassword"])) {



        // $haslo = $_POST['haslo_confirm']; //  ̶P̶o̶w̶i̶n̶i̶e̶n̶e̶m̶ ̶t̶o̶ ̶j̶a̶k̶o̶ś̶ ̶z̶a̶k̶o̶d̶o̶w̶a̶ć̶ ̶?̶ ̶Z̶a̶s̶z̶y̶f̶r̶o̶w̶a̶ć̶ ̶?̶ ̶T̶a̶k̶ ̶a̶b̶y̶ ̶n̶i̶e̶ ̶b̶y̶ł̶o̶ ̶d̶o̶s̶t̶ę̶p̶n̶e̶,̶ ̶b̶o̶ ̶t̶a̶ ̶z̶m̶i̶e̶n̶n̶a̶ ̶t̶r̶z̶y̶m̶a̶ ̶j̶a̶w̶n̶i̶e̶ ̶h̶a̶s̶ł̶o̶
        // $powtorz_haslo = $_POST['powtorz_haslo_confirm'];

            // $haslo = htmlentities($_POST['haslo_confirm'], ENT_QUOTES, "UTF-8");
            // $powtorz_haslo = htmlentities($_POST['powtorz_haslo_confirm'], ENT_QUOTES, "UTF-8");
            // $nowe_haslo = strip_tags($haslo);
            // $powtorz_haslo = strip_tags($powtorz_haslo);

        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
        $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_STRING);

        $_SESSION["password_confirmed"] = true; // flaga walidująca



        if ($password !== $confirmPassword || $password !== $_POST["password"] || $confirmPassword !== $_POST["confirmPassword"]) {

            $_SESSION["password_confirmed"] = false;


            /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
            echo "GET ->"; print_r($_GET); echo "<hr><br>";
            echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>"; exit();*/
        } else {

            query("SELECT haslo FROM customers WHERE id_klienta='%s'", "verifyPassword", $_SESSION["id"]);
                // ta funkcja ustawia zmienna sesyjna $_SESSION["password_hashed"] ktora przechowuje haslo (hash hasła) z BD;
            // $_SESSION["password_hashed"] --> przechowuje aktualne (zahashowane) hasło z BD;
        }

        if ( !password_verify($password, $_SESSION["password_hashed"])) {
            // true? -> hasze sa takie same (podano poprawne hasło do konta)
            $_SESSION["password_confirmed"] = false; // podane złe hasło;
        }

    } else {
        $_SESSION["password_confirmed"] = false;
    }

    unset($_SESSION["password_hashed"]);

    header('Location: remove_account.php'); // przekierowanie do strony remove_account.php
        exit();
?>