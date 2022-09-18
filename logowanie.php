<?php
	
	session_start(); // funkcja pozwalająca dokumentowi korzystać z sesji
	// każdy dokument korzystający z sesji, musi posiadać ten wpis na początku.

	include_once "functions.php";	
	
	
	/*
		echo '$_POST[login] = ' . $_POST['login'] . "<br>";
		echo '$_POST[haslo] = ' . $_POST['haslo'] . "<br>";
		echo 'isset $_POST[login] = ' . isset($_POST['login']) . "<br>";
		echo 'isset $_POST[haslo] = ' . isset($_POST['haslo']) . "<br>";
		exit();*/

		// sprawdzamy, czy zmienne login i hasło zostały ustawione (CZY ISTNIEJĄ!) :
		// czy zmienne istnieją - (mogą być puste)



		/*if( ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
			|| ( ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true"))  ) 
		) 
	*/


	if( 
		((!isset($_POST['email'])) || (!isset($_POST['haslo']))) // jeśli zmienne NIE ISTNIEJĄ (mogą być puste !) 
		|| 
		((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true"))  // jeśli jesteśmy zalogowani
		 // Uniemożliwi zalogowanie, poprzez wysłanie żądania POST (z loginem i hasłem) - wtedy, gdy już jesteśmy zalogowani. Np. jeśli zalogowany jest user1, to user2 nie będzie się mógł zalogować
	)
	{
		// przekierowanie do index, jeśli weszliśmy bezpośrednio pod adres "logowanie.php", 

		// jeśli nie ustawiono loginu/hasła,  
		// lub jesteśmy zalogowani
		header('Location: index.php');  
		exit();
	}
	else {   //   zmienne  $_POST['login'],   $_POST['haslo']  - istnieją (mogą być puste),   oraz   NIE jesteśmy zalogowanie

		$email = $_POST['email'];

		//$email = htmlentities($email, ENT_QUOTES, "UTF-8");                // sanityzacja - zamiana na encje - usunięcie znaków kodów źródłowych

		$email_s = filter_var($email, FILTER_SANITIZE_EMAIL); // email - po procesie sanityzacji
		// FILTER_SANITIZE_EMAIL - filtr do adresów mailowych

		
		//if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		if((filter_var($email_s, FILTER_VALIDATE_EMAIL)==false))
		{
			// błąd - związany z email			
			$_SESSION['blad'] = '<span style="color: red">Podaj poprawny adres e-mail</span>';
			header('Location: zaloguj.php');	
			exit();
		}

		query("SELECT * FROM klienci WHERE email='%s'", "log_in", $email); // funkcja log_in (odpowiedzialna za logowanie) uzyska hasło z tablicy $_POST[];

	}		

?>

<link rel="stylesheet" href="style.css">