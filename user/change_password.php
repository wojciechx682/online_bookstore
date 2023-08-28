<?php

	// zmiana hasła zalogowanego klienta;

	require_once "../authenticate-user.php";

	if ( isset($_POST["oldPassword"]) &&
         isset($_POST["newPassword"]) &&
         isset($_POST["confirmPassword"]) &&
         !empty($_POST["oldPassword"]) &&
         !empty($_POST["newPassword"]) &&
         !empty($_POST["confirmPassword"])) {

$oldPassword = filter_input(INPUT_POST, "oldPassword", FILTER_SANITIZE_STRING); // ?
$newPassword = filter_input(INPUT_POST, "newPassword", FILTER_SANITIZE_STRING);
$confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_STRING);

		/*$oldPassword = $_POST["oldPassword"];
		$newPassword = $_POST["newPassword"];
		$confirmPassword = $_POST["confirmPassword"];*/

		$valid = true;

		unset($_SESSION["password_hashed"]); // remove variable, if was set before;
		query("SELECT haslo FROM klienci WHERE id_klienta='%s'", "verifyPassword", $_SESSION["id"]); // $_SESSION["password_hashed"] <-- hash - OR - null

		if (isset($_SESSION["password_hashed"]) && !empty($_SESSION["password_hashed"])) {

			if (password_verify($oldPassword, $_SESSION["password_hashed"])) { // czy user podał poprawne hasło;

				unset($_SESSION["password_hashed"]);

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

					$password = [$newPassword, $_SESSION["id"]];

					$updateSuccessful = query("UPDATE klienci SET haslo='%s' WHERE id_klienta='%s'", "", $password);

					if ($updateSuccessful) {

						unset($_POST, $_SESSION["change_password_error_message"]);

						$_SESSION["is_password_changed"] = true;

					} else {

						$_SESSION["change_password_error_message"] = "11 Wystąpił błąd. Spróbuj jeszcze raz";
					}
				}

			} else { // podano niepoprawne hasło do konta

				$_SESSION["change_password_error_message"] = "Wprowadź poprawne hasło";

				unset($_POST, $_SESSION["password_hashed"]);
					/*header('Location: ___account.php');
						exit();*/
			}

		} else { // nie udało się pobrać hasła dla podanego ID klienta; (np nie istnieje klient o takim id / pole hasła w bd jest puste)

			unset($_POST);

			$_SESSION["change_password_error_message"] = "Wystąpił błąd. Spróbuj jeszcze raz";
		}

	} else {

		$_SESSION["change_password_error_message"] = "Uzupełnij wszystkie pola";
	}

	header('Location: ___account.php', true, 303);
		exit();

?>
