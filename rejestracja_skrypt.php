<?php

	session_start();
	
	

	include_once "functions.php";

	// walidacja danych rejestracji z formularza : 
	
	/* (isset($_POST['nick'])) &&
	(isset($_POST['email'])) &&
	(isset($_POST['haslo1'])) &&
	(isset($_POST['haslo2'])) */

	if( (isset($_POST['email'])) ) 
	{
		// zmienna $_POST['email'] istnieje ? -> Oznacza to, że nastąpił submit formularza.
		// WYSTARCZY SPRAWDZIĆ TYLKO JEDNO POLE Z FORMULARZA, ale można ten warunek rozbudować		
		//////////////////////////////////////////////////////////////////
		// 1. WALIDACJA DANYCH Z FORMULARZA : 
		// Należy dodać walidację do wszystkich pól formularza rejestracji ! 
		
		// 1. Ustanowienie flagi, która ma wartośc true : 		
		// Udana walidacja? Załóżmy że tak ! 	

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

		//////////////////////////////////////////////////////////////////		
		// Załóżmy, że nick posiada od 3 do 20 znaków : 
		
		// Sprawdzenie długości nicka (loginu): 		
		/*if((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK = false;
			$_SESSION['e_nick'] = "Nick musi posiadać od 3 do 20 znaków!";		
		}*/
		
		// nick ma składać się tylko ze znaków alfanumerycznych (bez polskich znaków itp...)
		// ctype_alnum() - check for alphanumeric characters - sprawdź, czy wszystkie znaki w łańcuchu sa alfanumeryczne
			// zwraca: TRUE / FALSE
				// można też wykorzystać funkcję preg_match() - porównywanie tekstu z wyrażeniem regularnym		
		/*if(ctype_alnum($nick) == false) // znaki alfanumeryczne ?
		{
			$wszystko_OK = false;
			$_SESSION['e_nick'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}*/
		
		//////////////////////////////////////////////////////////////////

		// Walidacja imienia - czy podano poprawne imię	
		
		$name_regex = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}+[a-ząćęłńóśźż]+\s?+$/';	// imię -> "Jakub"

		if(!(preg_match($name_regex, $imie))) // preg_match() sprawdza dopasowanie wzorca do ciągu, TRUE/FALSE
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_imie'] = "Imię może składać się tylko z liter alfabetu";
		}

		if(!(preg_match($name_regex, $nazwisko))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_nazwisko'] = "Nazwisko może składać się tylko z liter alfabetu";
		}			

		//////////////////////////////////////////////////////////////////

		// Sprawdzenie poprawności adresu email :		
	
		// istnieje gotowa funkcja walidująca email -> filter_var(zmienna, filtr)
		// - przefiltruj zmienną w sposób określony przez rodzaj filtru (drugi parametr funkcji)		
		// sanityzacja kodu - wyczyszczenie źródła z potencjalnie groźnych zapisów
		
		$email_s = str_replace(' ', '', $email); // usuwa spacje z adresu email

		$email_s = filter_var($email, FILTER_SANITIZE_EMAIL); // email - po procesie sanityzacji. usunięcie znaków kodu źródłowego. // FILTER_SANITIZE_EMAIL - filtr do adresów mailowych	
		
		if((filter_var($email_s, FILTER_VALIDATE_EMAIL) == false) || ($email_s != $email))
		{
			// błąd - związany z email
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_email'] = "Podaj poprawny adres e-mail!";
		}

		//////////////////////////////////////////////////////////////////		
		// Sprawdzenie poprawności hasła : 		
		
		if((strlen($haslo1)<8) || (strlen($haslo1)>20)) // sprawdzenie długości hasła
		{
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		//sprawdzenie czy oba hasła są identyczne : 
		
		if($haslo1 != $haslo2)
		{
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_haslo'] = "Podane hasła nie są identyczne!";
		}
		
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

		//////////////////////////////////////////////////////////////////

		// Miejscowosc

		$address_regex = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}+[a-ząćęłńóśźż]+\s?[-]?\s?+[A-ZĄĆĘŁŃÓŚŹŻ]?+[a-ząćęłńóśźż]+\s?[-]?\s?+[A-ZĄĆĘŁŃÓŚŹŻ]?+[a-ząćęłńóśźż]+$/'; // miejscowosc, ulica ...

		if(!(preg_match($address_regex, $miejscowosc))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_miejscowosc'] = "Podaj poprawną nazwę miejscowości";
		}

		//////////////////////////////////////////////////////////////////

		// Ulica

		if(!(preg_match($address_regex, $ulica))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_ulica'] = "Podaj poprawną nazwę ulicy";
		}

		////////////////////////////////////////////////

		// Numer domu   		

		$house_number_regex = '/^[0-9]{1,3}+\s?[\/-]?+\s?+[A-Za-z0-9]{0,3}$/'; // numer domu // 18     18A 18a   18 a   19/7   17/a   19/A      

		if(!(preg_match($house_number_regex, $numer_domu))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_numer_domu'] = "Podaj poprawny numer domu";
		}

		//////////////////////////////////////////////////////////////////
		// kod pocztowy

		$zip_regex = "/^[0-9]{2}(?:-[0-9]{3})?$/";

		if(!(preg_match($zip_regex, $kod_pocztowy))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_kod_pocztowy'] = "Podaj poprawny kod pocztowy";
		}

		//////////////////////////////////////////////////////////////////
		// kod - miejscowosc 

		if(!(preg_match($address_regex, $kod_miejscowosc))) 
		{		
			$_SESSION['wszystko_OK'] = false;
			$_SESSION['e_kod_miejscowosc'] = "Podaj poprawną miejscowość";
		}

		//////////////////////////////////////////////////////////////////
		// telefon

		$phone_regex = "/^[+]?[0-9]{5,12}+$/";

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
			$_SESSION['e_regulamin'] = "Potwierdź akceptację regulaminu!";
		}
		
		// Sprawdzenie zaznaczenie checkbox'a CAPTCHA :
		
		$sekret = "6LcW48gfAAAAALDhZZERPDMpGD5aYMcLJ3s_IszG"; // secret key
		
		// sprawdzenie odpowiedzi googla, czy weryfikacja CAPTCHA się udała :
		
		//$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']); // Pobierz zawartośc pliku do zmiennej
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
				
		$odpowiedz = json_decode($sprawdz); // zdekoduj wartość z formatu json
		
		//if(!($odpowiedz->success))        // można także użyć takiego zapisu
		/*if($odpowiedz->success == false)  // właściwość success
		{
			$wszystko_OK = false;
			$_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem!";
		}*/
		
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
		//$_SESSION['fr_haslo1'] = $haslo1; // nie przechowujemy haseł w zmiennych sesyjnych.
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

		
		if(isset($_POST['regulamin'])) // zapamiętanie akceptacji regulaminu
		{
			$_SESSION['fr_regulamin'] = true;
		}		

		//////////////////////////////////////////////////////////////////
		
		//sprawdzenie czy taki user (email i hasło) istnieje już w bazie :
		
		// POŁĄCZENIE Z BAZĄ DANYCH : 

		//////////////////////////////////////////////////////////////////
		
		// sprawdzenie, czy istnieje już taki user (email) w BD :

		query("SELECT id_klienta FROM klienci WHERE email='$email'", "register_verify_email", "$email"); // przestawi flagę $_SESSION['wszystko_ok']; 

		// .................

		if($_SESSION['wszystko_OK'] == true) // poprawna walidacja ? 
		{
			//Poprawna walidacja ✓, wszystkie testy zaliczone, dodajemy użytkownika do bazy
					
			//insert ...
			
			// przekierowanie do podstrony z podziękowaniem za wykonanie rejestracji 
			// echo "<br>Udana walidacja ✓ <br>"; exit();
			
			//if($polaczenie->query("INSERT INTO klienci VALUES (NULL, '$nick', '$haslo_hash', '$email', 100, 100, 100, 14)")) // NULL - dla id 

			//if($polaczenie->query("INSERT INTO klienci (id_klienta, imie, nazwisko, miejscowosc, ulica, numer_domu, kod_pocztowy, kod_miejscowosc, wojewodztwo, kraj, PESEL, data_urodzenia, telefon, email, login, haslo) VALUES (NULL, '$imie', '$nazwisko', '$miejscowosc', '$ulica', '$numer_domu', '$kod_pocztowy', '$kod_miejscowosc', '$wojewodztwo', '$kraj', '$PESEL', '$data_urodzenia', '$telefon', '$email', '$nick', '$haslo_hash')"))	

			$values = array();

			/*$imie = $_POST['imie'];
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
			$haslo2 = $_POST['haslo2'];*/


			array_push($values, $imie);
			array_push($values, $nazwisko);
			array_push($values, $email);
			array_push($values, $miejscowosc);
			array_push($values, $ulica);
			array_push($values, $numer_domu);
			array_push($values, $kod_pocztowy);
			array_push($values, $kod_miejscowosc);
			array_push($values, $telefon);
			array_push($values, "");
			array_push($values, "");
			array_push($values, "");
			array_push($values, "");
			array_push($values, "");
			array_push($values, $haslo_hash);
		
			echo '<script>console.log(310);</script>';

			query("INSERT INTO klienci (id_klienta, imie, nazwisko, email, miejscowosc, ulica, numer_domu, kod_pocztowy, kod_miejscowosc, telefon, wojewodztwo, kraj, PESEL, data_urodzenia, login, haslo) VALUES (NULL, '%s', '%s', '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')

				", "", $values);

			echo '<script>console.log(315);</script>';

			/*if($_SESSION['udanarejestracja'] == true)
			{
				header('Location: zaloguj.php');
				exit();
			}*/
							

			


			

			/*echo query("INSERT INTO koszyk (id_klienta, id_ksiazki, ilosc) VALUES ('$id_klienta', '$id_ksiazki', '$quantity')", "", $values); */


		}

	}









			







		
	
?>