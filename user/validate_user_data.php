<?php

	session_start();

	include_once "../functions.php";

    if(
        ( isset($_POST['imie_edit']) && isset($_POST['nazwisko_edit']) && isset($_POST['email_edit']) && isset($_POST['telefon_edit'] ) )
        && (
            ($_POST['imie_edit'] != $_SESSION['imie']) || ($_POST['nazwisko_edit'] != $_SESSION['nazwisko']) || ($_POST['email_edit'] != $_SESSION['email']) || ($_POST['telefon_edit'] != $_SESSION['telefon']) // przynajmniej jedno pole jest inne - od już istniejących wartości
        )
    )
    {   // Edycja danych użytkownika -> Imię, Nazwisko, E-mail, Telefon;

        // jeśli podano dane (POST), i są one różne od tych które były aktualnie ustawione (w Sesji); (✓✓✓ a mówiąc super-dokładnie - to przynajmniej JEDEN input ma inną wartość niż ta co była w sesji - tzn. wprowadzono conajmniej jedną inną wartość - a więc chcemy edytować tą zmienną)

        $imie = filter_input(INPUT_POST, "imie_edit", FILTER_SANITIZE_STRING);
        $nazwisko = filter_input(INPUT_POST, "nazwisko_edit", FILTER_SANITIZE_STRING);
		$email = $_POST['email_edit']; // filter_var SANITIZE_EMAIL + validate email
        $telefon = filter_input(INPUT_POST, "telefon_edit", FILTER_SANITIZE_STRING);

        //$imie = htmlentities($imie, ENT_QUOTES, "UTF-8");
		//$nazwisko = htmlentities($nazwisko, ENT_QUOTES, "UTF-8");
		//$email = htmlentities($email, ENT_QUOTES, "UTF-8");

        /*$email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL); // email - after the sanitization process. removes source code characters to avoid XSS attacks

        if(!filter_var($email_sanitized, FILTER_VALIDATE_EMAIL) || ($email_sanitized != $email))
        {
            // ensures that the email input is sanitized and valid
            // to avoid any potential XSS attacks and other vulnerabilities.
            $_SESSION['wszystko_OK'] = false;
            $_SESSION['e_email'] = "Podaj poprawny adres e-mail";
        }*/

		$validation = true;

//		if(((strlen($imie)<3) || (strlen($nazwisko)<3)))
//		{
//			$validation = false;
//			$_SESSION['error_form'] = "Podaj poprawne dane";
//		}

        $name_regex = '/^[A-ZŁŚŻ]{1}[a-ząęółśżźćń]+$/u';

        if( ! (preg_match($name_regex, $imie)) )
        {
            $validation = false;
            $_SESSION['error_form'] = "Podaj poprawne imię";
        }
        if( ! (preg_match($name_regex, $nazwisko)) )
        {
            $validation = false;
            $_SESSION['error_form'] = "Podaj poprawne nazwisko";
        }

		if( (is_numeric($imie)) || (is_numeric($nazwisko)) )
		{
			$validation = false;
			$_SESSION['error_form'] = "Podaj poprawne dane";		
		}					

		if( (preg_match('/[0-9]/', $imie)) || (preg_match('/[0-9]/', $nazwisko)) )
		{
			$validation = false;
			$_SESSION['error_form'] = "Podaj poprawne dane";		
		}

		$email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL); // sanityzacja email => <script>alert();</script>

		if( ! filter_var($email_sanitized, FILTER_VALIDATE_EMAIL) || ($email_sanitized != $email)) // email nie przeszedł walidacji;
		{						
			$validation = false;
			$_SESSION['error_form'] = "Podaj poprawny adres e-mail";
		}
		else // email przeszedł walidację,  musimy sprawdzić, czy taki email nie jest już zajęty;
		{
			if($email_sanitized != $_SESSION['email']) // czy jest różny od tego co było w polu formularza;
			{
				$_SESSION['email_exists'] = false;

				query("SELECT * FROM klienci WHERE email='%s'", "check_email", $email_sanitized); // to przełączy zmienną $_SESSION['email_exists'] na true, jeśli taki email będzie istnieć (jeśli $result zwróci rekordy);

				if( isset($_SESSION['email_exists']) && $_SESSION["email_exists"]) // <-- działa, testowałem :)
				{
					$validation = false;
					$_SESSION['error_form'] = "E-mail zajęty";
				}
			}
		}			

		if ( ! is_numeric($telefon) )
		{
			$validation = false;
			$_SESSION['error_form'] = "Podaj poprawny telefon";
		}

		if ( strlen($telefon) > 15 )
		{
			$validation = false;
			$_SESSION['error_form'] = "Podaj poprawne telefon";
		}
		
		if( $validation )
		{
//			$values = array();
//			array_push($values, $imie);
//			array_push($values, $nazwisko);
//			array_push($values, $email);
//			array_push($values, $telefon);
//			array_push($values, $_SESSION["id"]);

            $id = filter_var($_SESSION['id'], FILTER_SANITIZE_NUMBER_INT); // id_klienta;

            $user_data = [$imie, $nazwisko, $email, $telefon, $id];

			//$id = $_SESSION['id'];

			query("UPDATE klienci SET imie='%s', nazwisko='%s', email='%s', telefon='%s' WHERE id_klienta='%s'", "", $user_data);

			$_SESSION['validation_passed'] = true;

			$_SESSION['imie'] = $imie;
			$_SESSION['nazwisko'] = $nazwisko;
			$_SESSION['email'] = $email;
			$_SESSION['telefon'] = $telefon;

			unset($_POST['imie_edit']);
			unset($_POST['nazwisko_edit']);
			unset($_POST['email_edit']);
			unset($_POST['telefon_edit']);
			unset($_SESSION['error_form']);

			header('Location: ___account.php');
                exit();
		}
		else // dane nie przeszły walidacji;
		{
			    //echo '<script> alert("Niepoprawne dane") </script>';
			header('Location: ___account.php');
                exit();
		}
	}
	else // nie było danych w żądaniu POST lub były one te same co już istniejące w Sesji;
	{
		    // echo '<script> alert("Uzupełnij wszystkie pola") </script>';

        $_SESSION['error_form'] = "Podaj dane które różnią się od istniejących";
		    header('Location: ___account.php');
                exit();
	}
?>