<?php
	
	session_start(); // funkcja pozwalająca dokumentowi korzystać z sesji
	// każdy dokument korzystający z sesji, musi posiadać ten wpis na początku.

	include_once "functions.php";
	
	
	
	/*echo '$_POST[login] = ' . $_POST['login'] . "<br>";
	echo '$_POST[haslo] = ' . $_POST['haslo'] . "<br>";
	echo 'isset $_POST[login] = ' . isset($_POST['login']) . "<br>";
	echo 'isset $_POST[haslo] = ' . isset($_POST['haslo']) . "<br>";
	exit();*/

	// sprawdzamy, czy zmienne login i hasło zostały ustawione (CZY ISTNIEJĄ!) :
	// czy zmienne istnieją - (mogą być puste)

	if((!isset($_POST['login'])) || (!isset($_POST['haslo']))) 
	{
		// przekierowanie do index, jeśli weszliśmy bezpośrednio pod adres "logowanie.php"
		header('Location: index.php');  
		exit();
	}
	else {   //   zmienne  $_POST['login'],   $_POST['haslo']  - istnieją

		$login = $_POST['login'];

		$login = htmlentities($login, ENT_QUOTES, "UTF-8");                // walidacja - zamiana na encje

		query("SELECT * FROM klienci WHERE login='%s'", "log_in", $login); // funkcja log_in (odpowiedzialna za logowanie) uzyska hasło z tablicy $_POST[];

	}		

?>

<link rel="stylesheet" href="style.css">