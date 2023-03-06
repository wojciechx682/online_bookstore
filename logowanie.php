<?php
	
	session_start(); // funkcja pozwalająca dokumentowi korzystać z sesji // każdy dokument korzystający z sesji, musi posiadać ten wpis na początku.

	include_once "functions.php";	

	if(((!isset($_POST['email'])) || (!isset($_POST['haslo']))) || ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true")))
	{  // jeśli nie ustawiono loginu/hasła,                        // lub jesteśmy zalogowani
		header('Location: index.php');  
		exit();
	}
	else {   //   zmienne  $_POST['login'],   $_POST['haslo']  - istnieją (mogą być puste),   oraz   NIE jesteśmy zalogowanie

		$email = $_POST['email'];

		//$email = htmlentities($email, ENT_QUOTES, "UTF-8"); // zamiana na encje - zamiana znaków kodów źródłowych na encje

		$email_s = filter_var($email, FILTER_SANITIZE_EMAIL); // email - po procesie sanityzacji, // FILTER_SANITIZE_EMAIL - filtr do adresów mailowych
		
		//if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		if((filter_var($email_s, FILTER_VALIDATE_EMAIL)==false) || ($email_s != $email))
		{					
			$_SESSION['blad'] = '<span style="color: red">Podaj poprawny adres e-mail</span>';
			header('Location: zaloguj.php');	
			exit();
		}
		else
		{
			query("SELECT * FROM klienci WHERE email='%s'", "log_in", $email); // funkcja log_in (odpowiedzialna za logowanie) uzyska hasło z tablicy $_POST[];

			//query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta); // ustawienie zmienej sesyjnej $_SESSION['koszyk_ilosc_ksiazek']
		}	

	}		

?>

<link rel="stylesheet" href="nieużywane pliki (projektu)/style.css">