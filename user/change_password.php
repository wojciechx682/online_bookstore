<?php

// zmiana hasła zalogowanego klienta, / pracownika;

//require_once "../authenticate-user.php";
require_once "../start-session.php";

$userType = $_SESSION["user-type"] ?? null; // $userType = isset($_SESSION["user-type"]) ? $_SESSION["user-type"] : null;

switch ($userType) {
	case "klient":
		$table = "klienci";
		$column = "id_klienta";
		break;
	case "admin":
		$table = "pracownicy";
		$column = "id_pracownika";
		break;
	default:
		// Przekieruj do strony logowania lub innej strony błędu, ponieważ brak jest zalogowanego użytkownika
		$_SESSION["login-error"] = true;
		header("Location: zaloguj.php");
		exit();
}

/*if (isset($_SESSION["user-type"]) && $_SESSION["user-type"] === "klient") {

	// ...

} elseif (isset($_SESSION["user-type"]) && $_SESSION["user-type"] === "admin") {

	// ...

} else {
}*/

	if ( isset($_POST["oldPassword"]) &&
		isset($_POST["newPassword"]) &&
		isset($_POST["confirmPassword"]) &&
		!empty($_POST["oldPassword"]) &&
		!empty($_POST["newPassword"]) &&
		!empty($_POST["confirmPassword"])) {

		$oldPassword = filter_input(INPUT_POST, "oldPassword", FILTER_SANITIZE_STRING);
		$newPassword = filter_input(INPUT_POST, "newPassword", FILTER_SANITIZE_STRING);
		$confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_STRING);

		$valid = true;

			unset($_SESSION["password_hashed"]); // remove variable, if was set before;
		query("SELECT haslo FROM %s WHERE %s='%s'", "verifyPassword", [$table, $column, $_SESSION["id"]]);
		// $_SESSION["password_hashed"] <-- hash - OR - null

		if (isset($_SESSION["password_hashed"]) && !empty($_SESSION["password_hashed"])) {

			if (password_verify($oldPassword, $_SESSION["password_hashed"])) { // czy user podał poprawne hasło;

				$pass_regex = '/^((?=.*[!@#$%^&_*+-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{10,31}$/'; // https://regex101.com/ ;
				// hasło - musi zawierać:
					// przynajmniej JEDNĄ DUŻĄ LITERĘ,    ✓     (?=.*[A-Z])
					// przynajmniej JEDNĄ MAŁĄ LITERĘ,    ✓     (?=.*[a-z])
					// przynajmniej JEDEN ZNAK SPECJALNY  ✓     (?=.*[!@#$%^&_*+-\/\?])
					// conajmniej JEDNĄ CYFRĘ             ✓     (?=.*[0-9])
					// długość od 10 do 30 znaków          ✓     .{10,31}

				if (!preg_match($pass_regex, $newPassword)) {
					$valid = false;
					$_SESSION["change_password_error_message"] = "Hasło musi posiadać od 10 do 30 znaków, zawierać przynajmniej jedną wielką literę, jedną małą literę, jedną cyfrę oraz jeden znak specjalny (!@#$%^&_*+-\/\?)";
				}

				if ($newPassword !== $confirmPassword) {
					$valid = false;
					$_SESSION["change_password_error_message"] = "Podane hasła nie są identyczne";

				} else {
					if($oldPassword === $newPassword) {
						$valid = false;
						$_SESSION["change_password_error_message"] = "Podaj hasło które różni się od aktualnego";
					}
				}

				if ($valid) {

					$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

					//$password = [$newPassword, $_SESSION["id"]];

					$updateSuccessful = query("UPDATE %s SET haslo='%s' WHERE %s='%s'", "", [$table, $newPassword, $column, $_SESSION["id"]]);

					if ($updateSuccessful) {

						unset($_SESSION["change_password_error_message"]);

						$_SESSION["is_password_changed"] = true;

					} else {

						$_SESSION["change_password_error_message"] = "Wystąpił błąd. Spróbuj jeszcze raz";
					}
				}

			} else { // podano niepoprawne hasło do konta

				$_SESSION["change_password_error_message"] = "Wprowadź poprawne hasło";
			}

			unset($_SESSION["password_hashed"]);

		} else { // nie udało się pobrać hasła dla podanego ID klienta; (np nie istnieje klient o takim id / pole hasła w bd jest puste)

			$_SESSION["change_password_error_message"] = "Wystąpił błąd. Spróbuj jeszcze raz";
		}

	} else {

		$_SESSION["change_password_error_message"] = "Uzupełnij wszystkie pola";
	}

	unset($_POST);
		header('Location: account.php', true, 303);
			exit();

// ___reset_password - odzyskiwanie hasła -->

/*elseif ( )*/

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




?>
