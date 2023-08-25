<?php

	require_once "../start-session.php";

	if ( isset($_POST['stare_haslo_edit']) &&
         isset($_POST['nowe_haslo_edit']) &&
         isset($_POST['powtorz_haslo_edit']) &&
         !empty($_POST['stare_haslo_edit']) &&
         !empty($_POST['nowe_haslo_edit']) &&
         !empty($_POST['powtorz_haslo_edit'])) {

		$oldPassword = filter_input(INPUT_POST, "stare_haslo_edit", FILTER_SANITIZE_STRING);
		$newPassword = filter_input(INPUT_POST, "nowe_haslo_edit", FILTER_SANITIZE_STRING);
		$confirmPassword = filter_input(INPUT_POST, "powtorz_haslo_edit", FILTER_SANITIZE_STRING);

		$valid = true;

		query("SELECT haslo FROM klienci WHERE id_klienta='%s'", "verifyPassword", $_SESSION["id"]); // $_SESSION["password_hashed"] <-- hash OR null

		if (password_verify($oldPassword, $_SESSION["password_hashed"])) {

			unset($_SESSION["password_hashed"]);

            $pass_regex = '/^((?=.*[!@#$%^_&*-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{10,31}$/'; // https://regex101.com/ ;

            if (!preg_match($pass_regex, $newPassword)) {
				$valid = false;
                $_SESSION["error_password_message"] = "Hasło musi posiadać od 10 do 30 znaków, zawierać przynajmniej jedną wielką literę, jedną małą literę, jedną cyfrę oraz jeden znak specjalny (!@#$%^&*-\/\?)";
            }

			if($newPassword != $confirmPassword) {
				$valid = false;
				$_SESSION["error_password_message"] = "Podane hasła nie są identyczne";
			}		
			else
			{
				if($oldPassword == $newPassword)
				{
					$valid = false;
					$_SESSION["error_password_message"] = "Podaj hasło które różni się od aktualnego";
				}
			}

			if ($valid) {

				$new_password = password_hash($newPassword, PASSWORD_DEFAULT);

                $password = [$new_password, $_SESSION["id"]];

				$updateSuccessful = query("UPDATE klienci SET haslo='%s' WHERE id_klienta='%s'", "", $password);

				if ($updateSuccessful) {

					$_SESSION["is_password_changed"] = true;

				} else {

					$_SESSION["error_password_message"] = "Wystąpił błąd. Spróbuj jeszcze raz";
				}
			}

			header('Location: ___account.php'); exit();
		}
		else // hasla sa rozne (oldPassword i haslo z BD); // Podano niepoprawne hasło do konta;
		{
			$_SESSION["error_password_message"] = "Wprowadź poprawne hasło";

			unset($_SESSION["password_hashed"]);
			header('Location: ___account.php');
            exit();
		}
	}
	else
	{
		$_SESSION["error_password_message"] = "Uzupełnij wszystkie pola";

		header('Location: ___account.php');
        exit();
	}

?>
