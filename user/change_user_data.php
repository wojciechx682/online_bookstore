<?php

    // zmiana danych osobowych zalogowanego klienta;

    require_once "../authenticate-user.php";

    if ( (isset($_POST["name"]) &&
          isset($_POST["surname"]) &&
          isset($_POST["email"]) &&
          isset($_POST["phone"])) &&
          (($_POST["name"] != $_SESSION["imie"]) ||
           ($_POST["surname"] != $_SESSION["nazwisko"]) ||
           ($_POST["email"] != $_SESSION["email"]) ||
           ($_POST["phone"] != $_SESSION["telefon"]))) {

        // przesłano wszystkie wymagane zmienne (imię, nazwisko, e-mail, telefon), oraz
        // przynajmniej jedna przesłana wartość jest inna od już istniejących (w sesji)

        // Edycja danych użytkownika --> Imię, Nazwisko, E-mail, Telefon;

        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING); // sanityzacja danych wejściowych
        $surname = filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING);
		$email = $_POST["email"]; // filter_var SANITIZE_EMAIL + validate email
        $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_NUMBER_INT);

        $max_name_length = 255;
        $max_phone_length = 15;

        $name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8"); // zamień pierwszą literę ciągu na wielką, pozostałe zamień na małe litery;
        $surname = mb_convert_case($surname, MB_CASE_TITLE, "UTF-8"); // $surname = ucfirst($surname);

		$valid = true;

        $name_regex = '/^[A-ZŁŚŻ]{1}[a-ząęółśżźćń]+$/u';

        if (!preg_match($name_regex, $name) || preg_match('/[0-9]/', $name) || strlen($name)>$max_name_length || $name !== ucfirst($_POST["name"])) {

            $valid = false;
            $_SESSION["user_data_error_message"] = "Podaj poprawne imię";
        }

        if (!preg_match($name_regex, $surname) || preg_match('/[0-9]/', $surname) || strlen($surname)>$max_name_length || $surname !== ucfirst($_POST["surname"])) {

            $valid = false;
            $_SESSION["user_data_error_message"] = "Podaj poprawne nazwisko";
        }

		$email_s = filter_var($email, FILTER_SANITIZE_EMAIL);

		if (!filter_var($email_s, FILTER_VALIDATE_EMAIL) || ($email_s !== $email)) {

            $valid = false;
            $_SESSION["user_data_error_message"] = "Podaj poprawny adres e-mail";
		}
		else {

            if ($email != $_SESSION["email"]) {

                unset($_SESSION["email-exists"]);
                /*query("SELECT email FROM klienci WHERE BINARY email='%s'", "checkEmail", $email);
                // $_SESSION["email_exists"] --> true / NULL
                query("SELECT email FROM pracownicy WHERE BINARY email='%s'", "checkEmail", $email);*/

                query("SELECT email FROM customers WHERE BINARY email='%s' UNION SELECT email FROM employees WHERE BINARY email='%s'", "checkEmail", [$email, $email]);

                if (isset($_SESSION["email-exists"]) && $_SESSION["email-exists"]) {
                    $valid = false;
                    $_SESSION["user_data_error_message"] = "Istnieje już konto przypisane do tego adresu e-mail";

                    unset($_SESSION["email-exists"]);
                }
            }
		}			

		if (!ctype_digit($phone) || strlen($phone)>$max_phone_length || $phone !== $_POST["phone"]) {
			$valid = false;
			$_SESSION["user_data_error_message"] = "Podaj poprawny numer telefonu";
		}
		
		if ($valid) {

            $user_data = [$name, $surname, $email, $phone, $_SESSION["id"]];

			$updateSuccessful = query("UPDATE customers SET imie='%s', nazwisko='%s', email='%s', telefon='%s' WHERE id_klienta='%s'", "", $user_data); // true / false;

            if ($updateSuccessful) { // == true, jeśli udało się wykonać zapytanie I zmieniło ono stan bazy (wiersze);

                $_SESSION["is_user_data_changed"] = true;

                $_SESSION["imie"] = $name;
                $_SESSION["nazwisko"] = $surname;
                $_SESSION["email"] = $email;
                $_SESSION["telefon"] = $phone;

                unset($_POST, $_SESSION["user_data_error_message"]);

            } else { // nie udało się wykonać zapytania (UPDATE) / stan bazy nie został zmieniony (wiersze - affected_rows)

                $_SESSION["user_data_error_message"] = "Wystąpił błąd. Spróbuj jeszcze raz";
            }
		}
	}
	else { // nie było danych w żądaniu POST lub były one te same co już istniejące w Sesji;

        $_SESSION["user_data_error_message"] = "Podaj dane, które różnią się od istniejących";
	}

    header('Location: account.php', true, 303);
        exit();

?>