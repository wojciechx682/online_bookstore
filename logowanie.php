<?php
	
	session_start(); // funkcja pozwalająca dokumentowi korzystać z sesji
	// każdy dokument korzystający z sesji, musi posiadać ten wpis na początku.

	include_once "functions.php";
	
	// sprawdzamy, czy zmienne login i hasło zostały ustawione (CZY ISTNIEJĄ!) :
	
	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}
	else {   //   zmienne  $_POST['login'],   $_POST['haslo']  - istnieją

		$login = $_POST['login'];

		$login = htmlentities($login, ENT_QUOTES, "UTF-8");                // walidacja

		query("SELECT * FROM klienci WHERE login='%s'", "log_in", $login); // funkcja log_in uzyska hasło z tablicy $_POST[];

	}		

?>

<link rel="stylesheet" href="style.css">