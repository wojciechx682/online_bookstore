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
		
		// nick ma składać się tylko ze znaków alfanumerycznych [A-Za-z0-9]
		// (bez polskich znaków)
		// ctype_alnum() - check for alphanumeric characters - sprawdź, czy wszystkie znaki w łańcuchu sa alfanumeryczne // zwraca: TRUE / FALSE				
		//////////////////////////////////////////////////////////////////

		//$imie = str_replace(str_split(' '), '', $imie);
		$imie = trim($imie, " "); // usunięcie spacji na ostatniej pozycji
		$imie = ucfirst($imie);   		

		$name_regex = '/(*UTF8)^[A-ZŁŚŻ]{1}[a-ząęółśżźćń]+$/'; // imię -> "Jakub" ✓✓✓	 	
		// preg_match() sprawdza dopasowanie wzorca do ciągu, TRUE/FALSE

		if(!(preg_match($name_regex, $imie))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_imie'] = "Imię może składać się tylko z liter alfabetu, pierwsza litera powinna być wielka";
		}

		//$nazwisko = str_replace(str_split(' '), '', $nazwisko);
		$nazwisko = trim($nazwisko, " ");
		$nazwisko = ucfirst($nazwisko); 

		if(!(preg_match($name_regex, $nazwisko))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_nazwisko'] = "Nazwisko może składać się tylko z liter alfabetu, pierwsza litera powinna być wielka";
		}			

		//////////////////////////////////////////////////////////////////

		// Sprawdzenie poprawności adresu email :		
	
		// istnieje gotowa funkcja walidująca email -> 
		//       filter_var(zmienna, filtr)
		// - przefiltruj zmienną w sposób określony przez rodzaj filtru (drugi parametr funkcji)		
		// sanityzacja kodu - wyczyszczenie źródła z potencjalnie groźnych zapisów		
		
		$email = str_replace(str_split(' '), '', $email);

		//$email = htmlentities($email, ENT_QUOTES, "UTF-8");

		$email_s = filter_var($email, FILTER_SANITIZE_EMAIL); 
		// email - po procesie sanityzacji. usunięcie znaków kodu źródłowego. 
		// FILTER_SANITIZE_EMAIL - filtr do adresów mailowych	
		
		if((filter_var($email_s, FILTER_VALIDATE_EMAIL) == false) || ($email_s != $email))
		{			
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_email'] = "Podaj poprawny adres e-mail";
		}

		//////////////////////////////////////////////////////////////////		
		// Sprawdzenie poprawności hasła : 		
		
		/*if((strlen($haslo1)<8) || (strlen($haslo1)>20)) // sprawdzenie długości hasła
		{
			$wszystko_OK = false;
			$_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
		}*/

		//////////////////////////////////////////////////////////////////

		// Sprawdzenie, czy hasło zawiera: Jeden duży znak, jeden mały znak, jeden znak specjalny, jedna cyfra

		// hasło - musi zawierać: 
		// przynajmniej JEDNĄ DUŻĄ LITERĘ,    ✓    
		// przynajmniej JEDNĄ MAŁĄ LITERĘ,    ✓
		// przynajmniej JEDEN ZNAK SPECJALNY  ✓
		// conajmniej JEDNĄ CYFRĘ             ✓
		// długość od 8 do 25 znaków           ✓

		$pass_regex = '/^((?=.*[!@#$%^&*-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{8,30}$/';

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

		//////////////////////////////////////////////////////////////////
		// Miejscowosc		

		//$address_regex = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}[a-ząćęłńóśźż]+([\s|\-]?[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż]+){4}$/';
		
		$miejscowosc = ucfirst($miejscowosc); 
		$miejscowosc = trim($miejscowosc, " ");		

		$address_regex = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}[a-ząćęłńóśźż]+([\s|\-]?[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż]+){0,4}$/';

		if(!(preg_match($address_regex, $miejscowosc))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_miejscowosc'] = "Podaj poprawną nazwę miejscowości";
		}

		//////////////////////////////////////////////////////////////////
		// Ulica

		$ulica = ucfirst($ulica); 		
		$ulica = trim($ulica, " ");		

		if(!(preg_match($address_regex, $ulica))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_ulica'] = "Podaj poprawną nazwę ulicy";
		}

		//////////////////////////////////////////////////////////////////
		// Numer domu   		

		$numer_domu = str_replace(str_split(' '), '', $numer_domu);

		$house_number_regex = '/^[0-9]{1,3}+\s?[\/-]?+\s?+[A-Za-z0-9]{0,3}$/'; 
		// 18  18A   18a  18 a  19/7  17/a   19/A      

		if(!(preg_match($house_number_regex, $numer_domu))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_numer_domu'] = "Podaj poprawny numer domu";
		}

		//////////////////////////////////////////////////////////////////
		// kod pocztowy

		$kod_pocztowy = str_replace(str_split(' '), '', $kod_pocztowy);

		$zip_regex = "/^[0-9]{2}[\-]{1}[0-9]{3}$/";

		if(!(preg_match($zip_regex, $kod_pocztowy))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_kod_pocztowy'] = "Podaj poprawny kod pocztowy";
		}

		//////////////////////////////////////////////////////////////////
		// kod-miejscowosc 

		$kod_miejscowosc = ucfirst($kod_miejscowosc); 
		$kod_miejscowosc = trim($kod_miejscowosc, " ");	

		if(!(preg_match($address_regex, $kod_miejscowosc))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_kod_miejscowosc'] = "Podaj poprawną miejscowość";
		}

		//////////////////////////////////////////////////////////////////
		// telefon		

		$telefon = str_replace(str_split('!"#$%&\'()*\'-./:;<>?@[\\]^_{}|~ '), '', $telefon);
		$phone_regex = "/^([+]?[0-9]{2})?[0-9]{9}$/";	

		if(!(preg_match($phone_regex, $telefon))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_telefon'] = "Podaj poprawny numer telefonu";
		}

		//////////////////////////////////////////////////////////////////
		// Checkbox - czy zaakceptowano regulamin ?
			
		// Checkbox - ZAZNACZONY ? Niezaznaczony // echo $_POST['regulamin']; exit(); // on - zaznaczony, (zmienna nie istnieje) - niezaznaczony 		

		if(!isset($_POST['regulamin']))
		{
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_regulamin'] = "Potwierdź akceptację regulaminu";
		}
		
		//////////////////////////////////////////////////////////////////
		// Sprawdzenie zaznaczenie checkbox'a CAPTCHA :
		
		$sekret = "6LcW48gfAAAAALDhZZERPDMpGD5aYMcLJ3s_IszG"; // secret key
		
		// sprawdzenie odpowiedzi googla, czy weryfikacja CAPTCHA się udała :
		
		 // Pobierz zawartośc pliku do zmiennej
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);				
		$odpowiedz = json_decode($sprawdz); // zdekoduj wartość z formatu json
		
		//if(!($odpowiedz->success))        // można także użyć takiego zapisu
		//if($odpowiedz->success == false)  // właściwość success
		//{
		//	$wszystko_OK = false;
		//	$_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem!";
		//}
		
		if ($odpowiedz->success==false)
		{
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem!";
		}
		
		//////////////////////////////////////////////////////////////////
		
		// Zapamiętanie danych z formularza // Formularz pamiętający wprowadzone dane :
		
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

		
		if(isset($_POST['regulamin'])) // zapamiętanie akceptacji regulaminu
		{
			$_SESSION['fr_regulamin'] = true;
		}		

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//sprawdzenie czy taki user (email i hasło) istnieje już w bazie :

		echo query("SELECT id_klienta FROM klienci WHERE email='$email'", "register_verify_email", $email);  // przestawi mi zmienną $_SESSION['wszystko_OK'] na false, jeśli istnieje już taki email

		if($_SESSION['wszystko_OK'] == true) // udana walidacja ?
		{
			/////////////////////////////////////////////////////////////////////////
			// Zrealizowanie zapytania INSERT : 

			$values = array();

			array_push($values, $imie);
			array_push($values, $nazwisko);
			array_push($values, $email);
			array_push($values, $miejscowosc);
			array_push($values, $ulica);
			array_push($values, $numer_domu);
			array_push($values, $kod_pocztowy);
			array_push($values, $kod_miejscowosc);
			array_push($values, $telefon);
			array_push($values, " ");
			array_push($values, " ");
			array_push($values, " ");
			array_push($values, " ");
			array_push($values, " ");
			array_push($values, $haslo_hash);			

			echo query("INSERT INTO klienci (id_klienta, imie, nazwisko, email, miejscowosc, ulica, numer_domu, kod_pocztowy, kod_miejscowosc, telefon, wojewodztwo, kraj, PESEL, data_urodzenia, login, haslo) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "", $values);  // sanityzacja danych -> mysqli_real_escape_string

			exit();

		}
		else    // nieudana walidacja
		{
			//echo "<br> Istnieje już takie konto w BD<br>";
			//echo "<br> wszystko_OK == false <br>";
			//exit();

			/*if(($_SESSION['wszystko_OK'] == true))   // rejestracja.php ...
			{
				$_SESSION['udanarejestracja'] = false;
				header('Location: zaloguj.php');
			}*/

			header('Location: zarejestruj.php');
			exit();
		}

		exit();		

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
			
	}	
?>