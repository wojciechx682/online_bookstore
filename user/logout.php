<?php
	session_start();

	if (isset($_SESSION['zalogowany']) && isset($_SESSION['udanarejestracja'])) // jeśli stworzyliśmy konto, będąc zalogowanym na inne;
	{
			session_unset();
			session_destroy();
		session_start();
		$_SESSION['udanarejestracja'] = true;
			header('Location: ___zaloguj.php');
				exit();
	}
	elseif (isset($_SESSION["password_confirmed"])) { // redirect from remove_password.php (usunięcie konta klienta)
			session_unset();
			session_destroy();
		session_start();
		$_SESSION["deleted-successfully"] = true;
			header('Location: ___zaloguj.php');
				exit();
	}
	else // wylogowanie z konta poprzez naciśnięcie "wyloguj" przez użytkowika
	{
		if (isset($_COOKIE['PHPSESSID'])) {
			setcookie("PHPSESSID", "", time() - 3600, "/");
		}

		session_unset();
		session_destroy();

		if(isset($_POST["reset-password-form"])) {
			header('Location: ___reset_password.php');
		} else {
			header('Location: ___zaloguj.php');
				exit();
		}
	}
?>

