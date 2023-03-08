<?php
	
	session_start(); // a function that allows a document to use a session ; every document that uses a session must have this entry at the beginning.

	include_once "functions.php";	

	if(
            ((!isset($_POST['email'])) || (!isset($_POST['haslo']))) ||                  // jeśli nie ustawiono loginu/hasła
            ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true")))   // lub jesteśmy zalogowani
	{
        // ✓ spełni się jeśli wejdziemy bezpośrednio w link /logowanie.php (jeśli będziemy zalogowani, ORAZ jeśli nie będziemy zalogowani)

		header('Location: index.php');  
		exit();
	}
	else {   //   zmienne  $_POST['login'], $_POST['haslo']  - istnieją (mogą być puste),   ORAZ (AND)  NIE jesteśmy zalogowani

		$email = $_POST['email'];

		// $email = htmlentities($email, ENT_QUOTES, "UTF-8"); // zamiana na encje - zamiana znaków kodów źródłowych na encje

		$email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL); // email - po procesie sanityzacji, // FILTER_SANITIZE_EMAIL - filtr do adresów mailowych

        echo "<br> email &rarr; " . $email;
        echo "<br> email_sanitized &rarr; " . $email_sanitized;
        //exit();

		//if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		if((filter_var($email_sanitized, FILTER_VALIDATE_EMAIL)==false) || ($email_sanitized != $email))
		{					
			$_SESSION['blad'] = '<span style="color: red">Podaj poprawny adres e-mail</span>';
			header('Location: zaloguj.php');	
			exit();
		}
		else // email is correct
		{
			query("SELECT * FROM klienci WHERE email='%s'", "log_in", $email_sanitized); // funkcja log_in (odpowiedzialna za logowanie) uzyska hasło z tablicy $_POST[];

			//query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta); // ustawienie zmienej sesyjnej $_SESSION['koszyk_ilosc_ksiazek']
		}	

	}		

?>

<link rel="stylesheet" href="nieużywane pliki (projektu)/style.css">