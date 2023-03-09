<?php
	session_start();
		
	if (isset($_COOKIE['PHPSESSID'])) 
	{
//		$cookie_name = "PHPSESSID";
//		$cookie_value = $_COOKIE['PHPSESSID'];
//
//		setcookie($cookie_name, $cookie_value, time() - 3600, "/");

	    //unset($_COOKIE['PHPSESSID']);
	    //setcookie('key', '', time() - 3600, '/'); // empty value and old timestamp
	}
	//echo $_COOKIE['PHPSESSID'];
	//exit();	  
	// 86400 = 1 day
	// Wylogowanie użytkownika, niszczenie sesji :
		

	if(isset($_SESSION['zalogowany']) && isset($_SESSION['udanarejestracja'])) /// jeśli stworzyliśmy konto, będąc zalogowanym na inne
	{

		session_unset();   // unset all session variables
		session_destroy(); // destroy the session
		session_start();
		$_SESSION['udanarejestracja'] = true;
		header('Location: zaloguj.php');
	}	
	else // wylogowanie z konta poprzez naciśnięcie "wyloguj" przez użytkowika
	{
		session_unset();
		session_destroy();
		header('Location: zaloguj.php');
	}

	//session_unset(); // niszczy sesje, oraz wszystkie zmienne sesyjne
	
?>

