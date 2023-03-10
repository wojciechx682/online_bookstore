<?php
	session_start();
	
	if(!isset($_SESSION['udanarejestracja']))
	{
		// jeśli rejestracja się nie udała, przejdź do index.php (strona główna)
		header('Location: index.php');
		
		// kończymy działanie skryptu ! 
		exit();
	}	
	else
	{
		// zmienna $_SESSION['udanarejestracja'] jest ustawiona :
		// rejestracja nastąpiła pomyślnie, usuwamy tą zmienną : 
		unset($_SESSION['udanarejestracja']);
	}
	
	// Usuwamy zmienne, które służyły do zapamiętania wartości w razie nieudanej walidacji
	
	if(isset($_SESSION['fr_nick']))
	{
		unset($_SESSION['fr_nick']);
	}
	if(isset($_SESSION['fr_email']))
	{
		unset($_SESSION['fr_email']);
	}
	if(isset($_SESSION['fr_haslo1']))
	{
		unset($_SESSION['fr_haslo1']);
	}
	if(isset($_SESSION['fr_haslo2']))
	{
		unset($_SESSION['fr_haslo2']);
	}
	if(isset($_SESSION['fr_regulamin']))
	{
		unset($_SESSION['fr_regulamin']);
	}
	
	// Usuwanie błędów rejestracji
	
	if(isset($_SESSION['e_nick']))
	{
		unset($_SESSION['e_nick']);
	}
	if(isset($_SESSION['e_email']))
	{
		unset($_SESSION['e_email']);
	}
	if(isset($_SESSION['e_haslo']))
	{
		unset($_SESSION['e_haslo']);
	}
	if(isset($_SESSION['e_regulamin']))
	{
		unset($_SESSION['e_regulamin']);
	}
	if(isset($_SESSION['e_bot']))
	{
		unset($_SESSION['e_bot']);
	}
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Księgarnia internetowa</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>

	Dziękujemy za rejestrację w serwisie! Możesz już zalogować się na swoje konto! <br><br>

	Tylko martwi ujrzeli koniec wojny  Platon<br><br>
	
	<a href="../user/index.php">Zaloguj się na swoje konto!</a> <br><br>
	
	<form action="../user/zaloguj.php" method="post">
	
		Login: <br> <input type="text" name="login"> <br>
		Hasło: <br> <input type="password" name="haslo"> <br><br>
		
		<input type="submit" value="Zaloguj się">	
			
	</form>
	
	<?php	
		// pokazujemy zawartość tej zmiennej tylko jeśli podano nieprawidłowy login lub hasło ! 
		// czyli, tylko wtedy, gdy taka zmienna ISTNIEJE W SESJI
		
		if(isset($_SESSION['blad']))
		{
			echo $_SESSION['blad'];
		}			
	?>
	
	
	
</body>
</html>