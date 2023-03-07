<?php

	session_start();	

	include_once "functions.php";	

	if(isset($_POST['email'])) 
	{
		$_SESSION['wszystko_OK'] = true;		

		$imie = $_POST['imie'];
		$nazwisko = $_POST['nazwisko'];
		$email = $_POST['email'];
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
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];

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

        // preg_match() sprawdza dopasowanie wzorca do ciągu, TRUE/FALSE

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

		//$nazwisko = str_replace(str_split(' '), '', $nazwisko);
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
		
		$email = str_replace(str_split(' '), '', $email);

		//$email = htmlentities($email, ENT_QUOTES, "UTF-8");

		$email_s = filter_var($email, FILTER_SANITIZE_EMAIL);  // // email - after the sanitization process. removes source code characters to avoid XSS attacks

		if((filter_var($email_s, FILTER_VALIDATE_EMAIL) == false) || ($email_s != $email))
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

		// Sprawdzenie, czy hasło zawiera: jeden duży znak, jeden mały znak, jeden znak specjalny, jedna cyfra

		// hasło - musi zawierać: 
            // przynajmniej JEDNĄ DUŻĄ LITERĘ,    ✓     (?=.*[A-Z])
            // przynajmniej JEDNĄ MAŁĄ LITERĘ,    ✓     (?=.*[a-z])
            // przynajmniej JEDEN ZNAK SPECJALNY  ✓     (?=.*[!@#$%^&*-\/\?])
            // conajmniej JEDNĄ CYFRĘ             ✓     (?=.*[0-9])
            // długość od 8 do 30 znaków          ✓     .{8,31}

		$pass_regex = '/^((?=.*[!@#$%^&*-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{8,31}$/'; // https://regex101.com/

		if(!(preg_match($pass_regex, $haslo1))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_haslo'] = "
			Hasło musi posiadać od 8 do 30 znaków, zawierać przynajmniej jedną wielką literę, jedną małą literę, jedną cyfrę oraz jeden znak specjalny (!@#$%^&*-\/\?)";			
		}	
		
		// Sprawdzenie czy oba hasła są identyczne : 
		
		if($haslo1 != $haslo2)
		{
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_haslo'] = "Podane hasła są różne";
		}

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Miejscowosc		

		//$address_regex = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}[a-ząćęłńóśźż]+([\s|\-]?[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż]+){4}$/';
		
		$miejscowosc = ucfirst($miejscowosc); 
		$miejscowosc = trim($miejscowosc, " ");		

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

		$kod_miejscowosc = ucfirst($kod_miejscowosc); 
		$kod_miejscowosc = trim($kod_miejscowosc, " ");	

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
		// Checkbox - czy zaakceptowano regulamin ?
			
		// Checkbox - zaznaczony ? niezaznaczony ? // echo $_POST['regulamin']; exit(); // on - zaznaczony, (zmienna nie istnieje) - niezaznaczony

		if(!isset($_POST['regulamin']))
		{
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_regulamin'] = "Potwierdź akceptację regulaminu";
		}

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Sprawdzenie zaznaczenie checkbox'a CAPTCHA :
		
		$sekret = "6LcW48gfAAAAALDhZZERPDMpGD5aYMcLJ3s_IszG";   // secret key
		
		// sprawdzenie odpowiedzi googla, czy weryfikacja CAPTCHA się udała :
		
		 // Pobierz zawartośc pliku do zmiennej
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);				
		$odpowiedz = json_decode($sprawdz); // zdekoduj wartość z formatu JSON
		
		//if(!($odpowiedz->success))        // można także użyć takiego zapisu
		//if($odpowiedz->success == false)  // właściwość success
		//{
		//	$wszystko_OK = false;
		//	$_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem!";
		//}

        if(!$odpowiedz->success)
		{
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem!";
		}

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		// Zapamiętanie danych z formularza - Formularz pamiętający wprowadzone dane -->
		
		//$_SESSION['fr_nick'] = $nick; // fr - formularz rejestracji
		$_SESSION['fr_imie'] = $imie; 
		$_SESSION['fr_nazwisko'] = $nazwisko;
		$_SESSION['fr_email'] = $email; 
		$_SESSION['fr_haslo1'] = $haslo1; // nie przechowujemy haseł w zmiennych sesyjnych.
		$_SESSION['fr_haslo2'] = $haslo2; 		

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

		if(isset($_POST['regulamin']))               // zapamiętanie akceptacji regulaminu
		{
			$_SESSION['fr_regulamin'] = true;
		}
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		// Sprawdzenie czy taki user (email i hasło) istnieje już w bazie

		query("SELECT id_klienta FROM klienci WHERE email='%s'", "register_verify_email", $email);  // przestawi mi zmienną $_SESSION['wszystko_OK'] na false, jeśli istnieje już taki email

		if($_SESSION['wszystko_OK'] == true) // udana walidacja
		{
			////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// Zrealizowanie zapytania INSERT : 

            $user = [$imie, $nazwisko, $email, $miejscowosc, $ulica, $numer_domu, $kod_pocztowy, $kod_miejscowosc, $telefon, " ", " ", " ", " ", " ", $haslo_hash];

			query("INSERT INTO klienci (id_klienta, imie, nazwisko, email, miejscowosc, ulica, numer_domu, kod_pocztowy, kod_miejscowosc, telefon, wojewodztwo, kraj, PESEL, data_urodzenia, login, haslo) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "", $user);  // add new user to database
            exit();
		}
		else    // nieudana walidacja
		{
			/*if(($_SESSION['wszystko_OK'] == true))   // rejestracja.php ...
			{
				$_SESSION['udanarejestracja'] = false;
				header('Location: zaloguj.php');
			}*/

			header('Location: zarejestruj.php');
			exit();
		}
        exit();
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}	
?>