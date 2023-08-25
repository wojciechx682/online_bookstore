<?php

    require_once "../start-session.php";

    if ( (isset($_POST["imie_edit"]) &&
          isset($_POST["nazwisko_edit"]) &&
          isset($_POST["email_edit"]) &&
          isset($_POST["telefon_edit"])) &&
          (($_POST["imie_edit"] != $_SESSION["imie"]) ||
           ($_POST["nazwisko_edit"] != $_SESSION["nazwisko"]) ||
           ($_POST["email_edit"] != $_SESSION["email"]) ||
           ($_POST["telefon_edit"] != $_SESSION["telefon"]))) {

        // przesłano wszystkie wymagane zmienne (imię, nazwisko, e-mail, telefon), oraz
        // przynajmniej jedna przesłana wartość jest inna od już istniejących (w sesji)

        // Edycja danych użytkownika --> Imię, Nazwisko, E-mail, Telefon;

        $name = filter_input(INPUT_POST, "imie_edit", FILTER_SANITIZE_STRING);
        $surname = filter_input(INPUT_POST, "nazwisko_edit", FILTER_SANITIZE_STRING);
		$email = $_POST["email_edit"]; // filter_var SANITIZE_EMAIL + validate email
        $phone = filter_input(INPUT_POST, "telefon_edit", FILTER_SANITIZE_NUMBER_INT);

        //$name = ucfirst($name);
        //$surname = ucfirst($surname);

        $name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
        $surname = mb_convert_case($surname, MB_CASE_TITLE, "UTF-8");

		$valid = true;

        $name_regex = '/^[A-ZŁŚŻ]{1}[a-ząęółśżźćń]+$/u';

        if (!preg_match($name_regex, $name) || is_numeric($name) || preg_match('/[0-9]/', $name)) {
            $valid = false;
            $_SESSION["user_data_error_message"] = "Podaj poprawne imię";
        }

        if (!preg_match($name_regex, $surname) || is_numeric($surname) || preg_match('/[0-9]/', $surname)) {
            $valid = false;
            $_SESSION["user_data_error_message"] = "Podaj poprawne nazwisko";
        }

		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		if (!filter_var($email, FILTER_VALIDATE_EMAIL) || ($email != $_POST["email_edit"])) {
            $valid = false;
            $_SESSION["user_data_error_message"] = "Podaj poprawny adres e-mail";
		}
		else
		{
            if ($email != $_SESSION["email"]) {

                query("SELECT email FROM klienci WHERE email='%s'", "check_email", $email); // $_SESSION["email_exists"] --> true/false
                query("SELECT email FROM pracownicy WHERE email='%s'", "check_email", $email);

                if (isset($_SESSION["email-exists"]) && $_SESSION["email-exists"]) {
                    $valid = false;
                    $_SESSION["user_data_error_message"] = "Istnieje już konto przypisane do tego adresu e-mail";
                }
                unset($_SESSION["email-exists"], $_SESSION["given-email"]);
            }

		}			

		if (!is_numeric($phone) || strlen($phone)>15) {
			$valid = false;
			$_SESSION["user_data_error_message"] = "Podaj poprawny numer telefonu";
		}
		
		if ( $valid ) {

            $user_data = [$name, $surname, $email, $phone, $_SESSION["id"]];

			query("UPDATE klienci SET imie='%s', nazwisko='%s', email='%s', telefon='%s' WHERE id_klienta='%s'", "", $user_data);

            $_SESSION["is_user_data_changed"] = true;

			$_SESSION["imie"] = $name;
			$_SESSION["nazwisko"] = $surname;
			$_SESSION["email"] = $email;
			$_SESSION["telefon"] = $phone;

			unset($_POST, $_SESSION["user_data_error_message"]);

			header('Location: ___account.php');
                exit();
		}
		else
		{
			header('Location: ___account.php');
                exit();
		}
	}
	else // nie było danych w żądaniu POST lub były one te same co już istniejące w Sesji;
	{
		    // echo '<script> alert("Uzupełnij wszystkie pola") </script>';

        $_SESSION["user_data_error_message"] = "Podaj dane które różnią się od istniejących";
		    header('Location: ___account.php');
                exit();
	}
?>