<?php

    // logowanie - warto użyć  HTTPS / SSL;

    // "Limit login attempts: Prevent brute force attacks by limiting the number of login attempts allowed within a certain time period.";

	session_start(); // a function that allows a document to use a session ; every document that uses a session must have this entry at the beginning.

    // print_r($_SESSION); echo "<br>";
    // print_r($_POST);

	include_once "../functions.php";

	if(
            ((!isset($_POST['email'])) || (!isset($_POST['haslo']))) ||                  // jeśli nie ustawiono loginu/hasła
            ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true")))   // lub jesteśmy zalogowani
	{
        // ✓ spełni się jeśli wejdziemy bezpośrednio w link /logowanie.php (jeśli będziemy zalogowani, ORAZ jeśli nie będziemy zalogowani)

       /* echo "15<br>";*/
		header('Location: index.php');
		exit();
	}
	else {   //   zmienne  $_POST['login'], $_POST['haslo']  - istnieją (mogą być puste),   ORAZ (AND)  NIE jesteśmy zalogowani

        /*echo "<br>22<br>";*/

        //$email = $_POST['email']; // " jason1@wp.pl "

		// $email = htmlentities($email, ENT_QUOTES, "UTF-8"); // zamiana na encje - zamiana znaków kodów źródłowych na encje

		$email_sanitized = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL); // email - po procesie sanityzacji, // FILTER_SANITIZE_EMAIL - filtr do adresów mailowych

        /*echo "<br> email &rarr; " . $_POST["email"];
        echo "<br> email_sanitized &rarr; " . $email_sanitized;*/
        //exit();

		//if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		if(!filter_var($email_sanitized, FILTER_VALIDATE_EMAIL) || ($email_sanitized != $_POST["email"]))
		{
            /*echo "37<br>";*/
			$_SESSION['blad'] = '<span class="error">Podaj poprawny adres e-mail</span>';
			header('Location: zaloguj.php');
			exit();
		}
		else // email is correct;   (email is valid)
		{
            /*echo "<br><br>45<br>";*/

			query("SELECT * FROM klienci WHERE email='%s'", "log_in", $email_sanitized); // funkcja log_in (odpowiedzialna za logowanie) uzyska hasło z tablicy $_POST[];

            //echo "48<br>";

            //print_r($_SESSION); echo "<br>";
            //print_r($_POST);

			//query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta); // ustawienie zmienej sesyjnej $_SESSION['koszyk_ilosc_ksiazek']
		}
	}

?>

<!--<link rel="stylesheet" href="../nieużywane%20pliki%20(projektu)/style.css">-->