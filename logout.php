<?php
	session_start();
		
	if (isset($_COOKIE['PHPSESSID'])) 
	{
		$cookie_name = "PHPSESSID";
		$cookie_value = $_COOKIE['PHPSESSID'];

		setcookie($cookie_name, $cookie_value, time() - 3600, "/"); 

	    //unset($_COOKIE['PHPSESSID']);
	    //setcookie('key', '', time() - 3600, '/'); // empty value and old timestamp
	}
	//echo $_COOKIE['PHPSESSID'];
	//exit();	  
	// 86400 = 1 day
	// Wylogowanie użytkownika, niszczenie sesji :
		

	if(isset($_SESSION['udanarejestracja']))
	{
		header('Location: zaloguj.php');	
		//exit();
	}	
	else
	{
		header('Location: index.php');	
	}
	


	session_unset(); // niszczy sesje, oraz wszystkie zmienne sesyjne




?>

