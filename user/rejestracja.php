<?php

	session_start();
	include_once "../functions.php";

	if(
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['imie']) && !empty($_POST['imie']) &&
        isset($_POST['nazwisko']) && !empty($_POST['nazwisko']) &&
        isset($_POST['haslo1']) && !empty($_POST['haslo1']) &&
        isset($_POST['haslo2']) && !empty($_POST['haslo2']) &&
        isset($_POST['miejscowosc']) && !empty($_POST['miejscowosc']) &&
        isset($_POST['ulica']) && !empty($_POST['ulica']) &&
        isset($_POST['numer_domu']) && !empty($_POST['numer_domu']) &&
        isset($_POST['kod_pocztowy']) && !empty($_POST['kod_pocztowy']) &&
        isset($_POST['kod_miejscowosc']) && !empty($_POST['kod_miejscowosc']) &&
        isset($_POST['telefon']) && !empty($_POST['telefon'])
    )
	{
        // data processing, validation and sanitization
        // if the data is correct, a new user account is created
        // (inserting a new record into the customers table)

		$_SESSION['wszystko_OK'] = true; // validation flag

		$imie = $_POST['imie'];
		$nazwisko = $_POST['nazwisko'];
		$email = $_POST['email'];
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

		$miejscowosc = $_POST['miejscowosc']; 
		$ulica = $_POST['ulica'];
		$numer_domu = $_POST['numer_domu'];

		$kod_pocztowy = $_POST['kod_pocztowy'];
		$kod_miejscowosc = $_POST['kod_miejscowosc'];
		$telefon = $_POST['telefon'];		
            //$wojewodztwo = $_POST['wojewodztwo'];
            //$kraj = $_POST['kraj'];
            //$PESEL = $_POST['pesel'];
            //$data_urodzenia = $_POST['data_urodzenia'];

            //$imie = htmlentities($imie, ENT_QUOTES, "UTF-8");
            //$nazwisko = htmlentities($nazwisko, ENT_QUOTES, "UTF-8");
            //$email = htmlentities($email, ENT_QUOTES, "UTF-8");
            //$miejscowosc = htmlentities($miejscowosc, ENT_QUOTES, "UTF-8");
            //$ulica = htmlentities($ulica, ENT_QUOTES, "UTF-8");
            //$numer_domu = htmlentities($numer_domu, ENT_QUOTES, "UTF-8");
            //$kod_pocztowy = htmlentities($kod_pocztowy, ENT_QUOTES, "UTF-8");
            //$kod_miejscowosc = htmlentities($kod_miejscowosc, ENT_QUOTES, "UTF-8");
            //$telefon = htmlentities($telefon, ENT_QUOTES, "UTF-8");
            //$haslo1 = htmlentities($haslo1, ENT_QUOTES, "UTF-8");
            //$haslo2 = htmlentities($haslo2, ENT_QUOTES, "UTF-8");

        // nick should consist only of alphanumeric characters [A-Za-z0-9]
        // (without Polish symbols)
		// ctype_alnum() - check for alphanumeric characters - check if all characters in the string are alphanumeric -> returns: TRUE / FALSE
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		//$imie = str_replace(str_split(' '), '', $imie); // remove all white spaces
		$imie = trim($imie, " "); // remove space in the last position
		$imie = ucfirst(strtolower($imie));	// change all to lowercase, keep first letter uppercase

        $name_regex = '/^[A-ZŁŚŻ]{1}[a-ząęółśżźćń]+$/u';

        // This is a regular expression pattern that matches strings that begin with a single uppercase letter followed by one or more lowercase letters or Polish characters (ąęółśżźćń). It is used to validate and sanitize input data to ensure that it meets certain criteria. In this case, the regular expression is designed to match a valid name in Polish language. The /u at the end is a modifier that specifies that the regular expression is using Unicode characters.

        //    Passing:
        //      "Adam"  "Katarzyna"  "Łukasz"
        //    Not passing:
        //      adam        (lowercase first letter)
        //      Katarzyna1  (contains a number)
        //      _Łukasz     (starts with a special character)
        //      M@gda       (contains a special character)
        //      Ja rek      (contains a space)

        // preg_match() - sprawdza dopasowanie wzorca do ciągu, TRUE/FALSE

		if(!(preg_match($name_regex, $imie))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_imie'] = "Imię może składać się tylko z liter alfabetu, pierwsza litera powinna być wielka";
		}

		if ((strlen($imie)<3) || (strlen($imie)>20))
        {
            $_SESSION['wszystko_OK'] = false;
            $_SESSION['e_imie']="Podaj poprawne imię";
        }

		$nazwisko = trim($nazwisko, " ");
		$nazwisko = ucfirst(strtolower($nazwisko));	

		if(!(preg_match($name_regex, $nazwisko))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_nazwisko'] = "Nazwisko może składać się tylko z liter alfabetu, pierwsza litera powinna być wielka";
		}

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		// Sprawdzenie poprawności adresu email
	
            // istnieje gotowa funkcja walidująca email ->
            //       filter_var(zmienna, filtr)
            // - przefiltruj zmienną w sposób określony przez rodzaj filtru (drugi parametr funkcji)
            // sanityzacja kodu - wyczyszczenie źródła z potencjalnie groźnych zapisów

		$email = str_replace(str_split(' '), '', $email); // remove all white spaces

		//$email = htmlentities($email, ENT_QUOTES, "UTF-8");

		$email_s = filter_var($email, FILTER_SANITIZE_EMAIL); // email - after the sanitization process. removes source code characters to avoid XSS attacks

		if(!filter_var($email_s, FILTER_VALIDATE_EMAIL) || ($email_s != $email))
		{
            // ensures that the email input is sanitized and valid
            // to avoid any potential XSS attacks and other vulnerabilities.
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_email'] = "Podaj poprawny adres e-mail";
		}

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        // Sprawdzenie poprawności hasła :
                                        // if((strlen($haslo1)<8) || (strlen($haslo1)>20)) // sprawdzenie długości hasła
                                        // {
                                        //     $wszystko_OK = false;
                                        //     $_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
                                        // }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		// Sprawdzenie, czy hasło zawiera: jeden duży znak, jeden mały znak, jeden znak specjalny, jedna cyfra, oraz długość od 10 do 30 znaków

		// hasło - musi zawierać: 
            // przynajmniej JEDNĄ DUŻĄ LITERĘ,    ✓     (?=.*[A-Z])
            // przynajmniej JEDNĄ MAŁĄ LITERĘ,    ✓     (?=.*[a-z])
            // przynajmniej JEDEN ZNAK SPECJALNY  ✓     (?=.*[!@#$%^&*-\/\?])
            // conajmniej JEDNĄ CYFRĘ             ✓     (?=.*[0-9])
            // długość od 10 do 30 znaków          ✓     .{10,31}

		$pass_regex = '/^((?=.*[!@#$%^&*-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{10,31}$/'; // https://regex101.com/

		if(!(preg_match($pass_regex, $haslo1))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_haslo'] = "
			Hasło musi posiadać od 10 do 30 znaków, zawierać przynajmniej jedną wielką literę, jedną małą literę, jedną cyfrę oraz jeden znak specjalny (!@#$%^&*-\/\?)";
		}	
		
		// Verifying that both passwords are the same
		
		if($haslo1 != $haslo2)
		{
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_haslo'] = "Podane hasła są różne";
		}

        // Hashing the password, using the latest encryption method in "PASSWORD_DEFAULT"

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Miejscowosc		

		//$address_regex = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}[a-ząćęłńóśźż]+([\s|\-]?[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż]+){4}$/';
		

		$miejscowosc = trim($miejscowosc, " ");
        $miejscowosc = ucfirst($miejscowosc);

        $address_regex = '/^[A-ZĄĆĘŁŃÓŚŹŻ]{1}[a-ząćęłńóśźż]+([\s|\-]?[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż]+){0,4}$/';

        //    Passing:
        //          "Warszawa"  "Kraków"  "Kostrzyn nad odrą"  "Poznań-Garaszewo"
        //    Not passing:
        //           Łódź 1
        //           123 ulica słoneczna
        //           Super długa nazwa miejscowości która nie istnieje
        //           #4A-23A
        //           $@!#$@#$

		if(!(preg_match($address_regex, $miejscowosc))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_miejscowosc'] = "Podaj poprawną nazwę miejscowości";
		}

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Ulica

        //$ulica = trim($ulica, " ");
        //$ulica = ucfirst(strtolower($ulica));

        //$street_regex = '/^[A-ZĄĆĘŁŃÓŚŹŻ]{1}[a-ząćęłńóśźż]*(\s[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż]+){0,2}$/';
        $street_regex = '/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s.-]{3,35}$/';
        //    Passing:
        //          "ul. Warszawska"  "al. Jana Pawła II"  "Plac Grunwaldzki"

        if(!(preg_match($street_regex, $ulica)))
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_ulica'] = "Podaj poprawną nazwę ulicy";
		}

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Numer domu   		

		    $numer_domu = str_replace(str_split(' '), '', $numer_domu);

		//$house_number_regex = '/^[0-9]{1,3}+\s?[\/-]?+\s?+[A-Za-z0-9]{0,3}$/';
		$house_number_regex = '/^[0-9]{1,3}+[A-Z]{0,3}+\s?[\/-]?+\s?+[A-Za-z0-9]{0,3}$/';

        //    Passing:
        //          18  18A   18a  18 a  19/7  17/a   19/A
        //          1   23A   45/2 67B   89C-1 1010   121-123    145E    167F/4    188G   123-AAA
        //    Not passing:
        //           54\AA
        //           AAA-123
        //           AAA-AAA

		if(!(preg_match($house_number_regex, $numer_domu))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_numer_domu'] = "Podaj poprawny numer domu";
		}

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// kod pocztowy

		$kod_pocztowy = str_replace(str_split(' '), '', $kod_pocztowy);

		$zip_regex = "/^[0-9]{2}[\-]{1}[0-9]{3}$/";

		if(!(preg_match($zip_regex, $kod_pocztowy))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_kod_pocztowy'] = "Podaj poprawny kod pocztowy";
		}

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// kod-miejscowosc 

        $kod_miejscowosc = trim($kod_miejscowosc, " ");
        $kod_miejscowosc = ucfirst($kod_miejscowosc);

		if(!(preg_match($address_regex, $kod_miejscowosc))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_kod_miejscowosc'] = "Podaj poprawną miejscowość";
		}

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// telefon		

		$telefon = str_replace(str_split('!"#$%&\'()*\'-./:;<>?@[\\]^_{}|~ '), '', $telefon);

        //         +48 22 123 45 67    -->    +48221234567

		$phone_regex = "/^([+]?[0-9]{2})?[0-9]{9}$/";

        //    Passing:
        //          123456789
        //          48123456789
        //          +48123456789
        //    Not passing:
        //           12345678 (less than 9 digits)
        //           0048123456789 (invalid format)

		if(!(preg_match($phone_regex, $telefon))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_telefon'] = "Podaj poprawny numer telefonu";
		}

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Checkbox - Have the terms and conditions been accepted ?
		// Checkbox - checked ? not checked ?
        //echo "<br> regulamin -> " .$_POST['regulamin'] . "<br>"; exit(); // on - zaznaczony; niezaznaczony -> (zmienna nie istnieje);

		if(!isset($_POST['regulamin']))
		{
            // if checkbox was not checked, it will not exist in $_POST[] variable
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_regulamin'] = "Potwierdź akceptację regulaminu";
		}

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Sprawdzenie zaznaczenie checkbox'a CAPTCHA

		// $secret = "6LcW48gfAAAAALDhZZERPDMpGD5aYMcLJ3s_IszG"; // secret key for recaptcha API, used to authenticate and verify that the reCAPTCHA response sent from your website to Google's servers is valid and coming from your website

        require('C:\xampp\apache\conf\config.php');
        $secret = RECAPTCHA_SECRET_KEY;

        // sprawdzenie odpowiedzi googla, czy weryfikacja CAPTCHA się udała
        // pobranie zawartości pliku do zmiennej

                    //$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                    //$response = json_decode($sprawdz);

        // make HTTP request to  Google reCAPTCHA API to verify the user's response; returns encoded JSON string, that needs to be decoded
        $response = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response'])); // $response - decoded PHP object

                    //if(!($odpowiedz->success))        // można także użyć takiego zapisu
                    //if($odpowiedz->success == false)  // właściwość success
                    //{
                    //	$wszystko_OK = false;
                    //	$_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem!";
                    //}

        if(!$response->success) //  check if "success" property of the $response object is true or false to determine whether the user's response was valid or not.
		{
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_bot'] = "Weryfikacja reCaptcha nie przebiegła pomyślnie";
		}

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		// Zapamiętanie danych z formularza - Formularz pamiętający wprowadzone dane -->
		
            //$_SESSION['fr_nick'] = $nick; // fr - formularz rejestracji
		$_SESSION['fr_imie'] = $imie; 
		$_SESSION['fr_nazwisko'] = $nazwisko;
		$_SESSION['fr_email'] = $email; 
		//$_SESSION['fr_haslo1'] = $haslo1;   // nie przechowujemy haseł w zmiennych sesyjnych.
		//$_SESSION['fr_haslo2'] = $haslo2;

		$_SESSION['fr_miejscowosc'] = $miejscowosc; 
		$_SESSION['fr_ulica'] = $ulica; 
		$_SESSION['fr_numer_domu'] = $numer_domu; 
		$_SESSION['fr_kod_pocztowy'] = $kod_pocztowy; 
		$_SESSION['fr_kod_miejscowosc'] = $kod_miejscowosc; 
            //$_SESSION['fr_wojewodztwo'] = $wojewodztwo;
            //$_SESSION['fr_kraj'] = $kraj;
            //$_SESSION['fr_PESEL'] = $PESEL;
            //$_SESSION['fr_data_urodzenia'] = $data_urodzenia;
		$_SESSION['fr_telefon'] = $telefon; 

		if(isset($_POST['regulamin'])) // remembering the checkbox selection
		{
			$_SESSION['fr_regulamin'] = true;
		}
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		// Sprawdzenie czy taki user (email i hasło) istnieje już w bazie

        //var_dump($_SESSION); exit();

		query("SELECT id_klienta FROM klienci WHERE email='%s'", "register_verify_email", $email_s);  // przestawi mi zmienną $_SESSION['wszystko_OK'] na false, jeśli istnieje już taki email

		if($_SESSION['wszystko_OK']) // udana walidacja
		{
			////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// Zrealizowanie zapytania INSERT : 

            $user = [$imie, $nazwisko, $email, $miejscowosc, $ulica, $numer_domu, $kod_pocztowy, $kod_miejscowosc, $telefon, " ", " ", " ", " ", " ", $haslo_hash];

			query("INSERT INTO klienci (id_klienta, imie, nazwisko, email, miejscowosc, ulica, numer_domu, kod_pocztowy, kod_miejscowosc, telefon, wojewodztwo, kraj, PESEL, data_urodzenia, login, haslo) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "register", $user);  // add new user to database

            unset($_SESSION['wszystko_OK']);

        }
		else // nieudana walidacja
		{
			header('Location: zarejestruj.php');
        }

        exit();
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    }
    else {

        $_SESSION['e_fields'] = "Uzupełnij wszystkie pola";
        header('Location: zarejestruj.php');
    }

    exit();
?>