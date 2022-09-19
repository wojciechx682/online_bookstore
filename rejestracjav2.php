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


		/*$imie = htmlentities($imie, ENT_QUOTES, "UTF-8"); 
		$nazwisko = htmlentities($nazwisko, ENT_QUOTES, "UTF-8"); 
		$email = htmlentities($email, ENT_QUOTES, "UTF-8");
		$miejscowosc = htmlentities($miejscowosc, ENT_QUOTES, "UTF-8");
		$ulica = htmlentities($ulica, ENT_QUOTES, "UTF-8");
		$numer_domu = htmlentities($numer_domu, ENT_QUOTES, "UTF-8");
		$kod_pocztowy = htmlentities($kod_pocztowy, ENT_QUOTES, "UTF-8");
		$kod_miejscowosc = htmlentities($kod_miejscowosc, ENT_QUOTES, "UTF-8");
		$telefon = htmlentities($telefon, ENT_QUOTES, "UTF-8");
		$haslo1 = htmlentities($haslo1, ENT_QUOTES, "UTF-8");
		$haslo2 = htmlentities($haslo2, ENT_QUOTES, "UTF-8");*/
		
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

			header('Location: rejestracja.php');
			exit();
		}

		exit();



		






		

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










		//sprawdzenie czy taki user (email i hasło) istnieje już w bazie :

		
		// POŁĄCZENIE Z BAZĄ DANYCH : 
		
		require_once "connect.php";
		
		mysqli_report(MYSQLI_REPORT_STRICT); // ustawiamy sposób raportowania błędów
		// MYSQLI_REPORT_STRICT - zamiast warningów, chcemy rzucać EXCEPTION
		
		try // spróbuj połączyć się z bazą danych
		{
			//$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			
			if($polaczenie->connect_errno!=0) // błąd połączenia
			{
				// 0  = false           = udane połączenie
				// !0 = true (1,2, ...) = błąd połączenia				
					//echo "[ Błąd połączenia ] (".$conn->connect_errno."), Opis: ".$conn->connect_error;		
				//echo "[ Błąd połączenia ] (".$polaczenie->connect_errno.") <br>";		
				throw new Exception(mysqli_connect_errno()); // rzuć nowy wyjątek
			}
			else	// udane połączenie
			{
				// Sprawdzenie istnienia maila w bazie,
				// Czy email juz istnieje ?				
				$rezultat = $polaczenie->query("SELECT id_klienta FROM klienci WHERE email='$email'");
				
				if(!$rezultat) 
				{
					throw new Exception($polaczenie->error); // opis błędu który zostanie wygenerowany
				}
				
				$ile_takich_maili = $rezultat->num_rows; // sprawdzenie ilości takich maili
				
				if($ile_takich_maili>0)
				{
					$wszystko_OK = false;
					$_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu email!";
				}		
				
													
				
				/*
				// Sprawdzenie, czy istnieje już taki login (czy jest zarezerwowany) ?
				$rezultat = $polaczenie->query("SELECT id_klienta FROM klienci WHERE login='$nick'");
				
				if(!$rezultat) 
				{
					throw new Exception($polaczenie->error); // opis błędu który zostanie wygenerowany
				}
				
				$ile_takich_nickow = $rezultat->num_rows; // sprawdzenie ilości takich userów
				
				if($ile_takich_nickow>0)
				{
					$wszystko_OK = false;
					$_SESSION['e_nick'] = "Istnieje już gracz o takim nicku! Wybierz inny.";
				}	*/

				if($wszystko_OK == true) // poprawna walidacja ? 
				{
					//Poprawna walidacja ✓, wszystkie testy zaliczone, dodajemy użytkownika do bazy
					
					//insert ...
					
					// przekierowanie do podstrony z podziękowaniem za wykonanie rejestracji 
					// echo "<br>Udana walidacja ✓ <br>"; exit();
					
					//if($polaczenie->query("INSERT INTO klienci VALUES (NULL, '$nick', '$haslo_hash', '$email', 100, 100, 100, 14)")) // NULL - dla id 

					//if($polaczenie->query("INSERT INTO klienci (id_klienta, imie, nazwisko, miejscowosc, ulica, numer_domu, kod_pocztowy, kod_miejscowosc, wojewodztwo, kraj, PESEL, data_urodzenia, telefon, email, login, haslo) VALUES (NULL, '$imie', '$nazwisko', '$miejscowosc', '$ulica', '$numer_domu', '$kod_pocztowy', '$kod_miejscowosc', '$wojewodztwo', '$kraj', '$PESEL', '$data_urodzenia', '$telefon', '$email', '$nick', '$haslo_hash')"))	

					if($polaczenie->query("INSERT INTO klienci (id_klienta, imie, nazwisko, email, miejscowosc, ulica, numer_domu, kod_pocztowy, kod_miejscowosc, telefon, wojewodztwo, kraj, PESEL, data_urodzenia, login, haslo) VALUES (NULL, '$imie', '$nazwisko', '$email','$miejscowosc', '$ulica', '$numer_domu', '$kod_pocztowy', '$kod_miejscowosc', '$telefon', ' ', ' ', ' ', ' ', ' ', '$haslo_hash')"))					
					{
						// zapytanie się udało ✓
						$_SESSION['udanarejestracja'] = true;

						header('Location: zaloguj.php');

						//header('Location: zaloguj.php');
					}
					else // nie udało się wykonać zapytania INSERT
					{						
						throw new Exception($polaczenie->error); // rzucamy wyjątek
					}
					
				}						
				
				$polaczenie->close(); // zamknięice połączenia
			}		
			
		}
		catch(Exception $e) // Exception - wyjątek
		{
			//echo '<span style="color: red;"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</span>'; 
			
			echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</div>';

			echo '<br><span style="color:red">Informacja developerska: </span>'.$e; // wyświetlenie komunikatu błędu - DLA DEWELOPERÓW
		}
		
			
	}
	
	/*
	if(
	(empty($_POST['nick'])) &&
	(empty($_POST['email'])) &&
	(empty($_POST['haslo1'])) &&
	(empty($_POST['haslo2']))	
	) 
	{	
		echo "<br> Zmienne są puste ! <br>";		
	}
	else
	{
		echo "<br> Zmienne nie są puste <br>";
	}*/
	
?>



<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Księgarnia online</title>
	<link rel="stylesheet" href="style.css">


	<script src="https://www.google.com/recaptcha/api.js"></script>
	
	
</head>

<body>

	<div id="header_container">
		
		<!-- <div id="header_content"> -->

			<div id="top_header">

				<div id="top_header_content">

					<div id="header_title">
						
						Księgarnia internetowa

					</div>		
					
					<!--<div id="div_register">
						
						<a class="top-nav-right" href="rejestracja.php">Zarejestruj</a>
						
					</div> -->

					<!-- <div id="div_log_in">
						
						<a class="top-nav-right" href="zaloguj.php">Zaloguj</a>

					</div> -->

					<ol>	

						<li>
							<a href="rejestracja.php">Zarejestruj</a>
						</li>

						<li>									
							<?php if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == "true")) { echo '<a href="account.php">Moje konto</a>';} else { echo '<a href="zaloguj.php">Zaloguj</a>';} ?>
						</li>

					</ol>

				</div>

			</div>

			<div id="header">

				<div id="header_content">

					<!-- <a href="index.php">Strona główna</a> -->

					 <div id="div_search">				

						<form action="index.php" method="get">
							
							<input type="search" name="input_search">

							<input type="submit" value="Szukaj">

						</form>	

					</div>

					<div id="div_logo">				
						
						<img src="logo.png" width="100px">

					</div>

					<!-- 
						<div id="div_log_in">
							
							<a class="top-nav-right" href="zaloguj.php">Zaloguj</a>

						</div> 
					-->
					
					<!--
						<div id="div_register">
							
							<a class="top-nav-right" href="rejestracja.php">Zarejestruj</a>
							
						</div>
					-->

					<div id="div_cart">
						
						<a class="top-nav-right" href="koszyk.php">Koszyk</a>
						
					</div>

					<!--
						<div id="div_my_account">
							
							<a class="top-nav-right" href="account.php">Moje konto</a>
							
						</div> 
					-->
					
					<div style="clear: both;"></div>

				</div>

			</div>

			<div id="top_nav">
				
				<div id="top_nav_content">

					<ol>
						
						<li><a href="index.php">Strona główna</a></li>
						<li><a href="#">Kategorie</a>
							
							 <!-- <ul id="double"> -->
							 <ul>

								<!-- 
									<li class="double"><a href="#">Informatyka</a></li>
									<li class="double"><a href="#">Poezja</a></li>
									<li class="double"><a href="#">Horror</a></li>
									<li class="double"><a href="#">Komiks</a></li> 
								-->

								<?php 
									echo query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories", ""); // wypis kategorii - wewnątrz listy rozwijanej ul
								?>

							</ul> 

						</li>
						<li><a href="#">...</a>
							<ul>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
							</ul>
						</li>
						<li><a href="#">...</a>
							<ul>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
							</ul>
						</li>
						<li><a href="#">...</a>
							<ul>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
								<li><a href="#">...</a></li>
							</ul>
						</li>
						<li><a href="#">...</a></li>

					</ol>
			
				</div>

			</div>

		<!-- </div> -->

	</div>

	<div id="container">		

		<div id="nav">
			
		</div>

		<div id="content">

			<!-- Formularz rejestracji -->	
			
			<!-- <form method="post"> -->
			<form method="post" action="rejestracja.php">
				<!-- brak atrybutu action - ten sam plik rejestracja.php przetwarza formularz		
				bez atrybutu action, domyślnie - ten sam plik otrzyma post'em przesłane dane 
								WALIZACJA DANYCH W W TYM SAMYM PLIKU ! (rejestracja.php) -->

				Stwórz nowe konto klienta<br><hr>

				Imię: <br> <input type="text" name="imie" value="<?php 		
					if(isset($_SESSION['fr_imie']))
					{
						echo $_SESSION['fr_imie'];
						unset($_SESSION['fr_imie']);
					}		
				?>"> <br>		
				
				<?php		
					if(isset($_SESSION['e_imie'])) // błąd z imieniem użytkownika ...
					{
						echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
						unset($_SESSION['e_imie']);
					}		
				?>

				Nazwisko: <br> <input type="text" name="nazwisko" value="<?php 		
					if(isset($_SESSION['fr_nazwisko']))
					{
						echo $_SESSION['fr_nazwisko'];
						unset($_SESSION['fr_nazwisko']);
					}		
				?>"> <br>		
				
				<?php		
					if(isset($_SESSION['e_nazwisko'])) // błąd z naziwskiem użytkownika ...
					{
						echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
						unset($_SESSION['e_nazwisko']);
					}		
				?>

				E-mail: <br> <input type="text" name="email" value="<?php 		
					if(isset($_SESSION['fr_email']))
					{
						echo $_SESSION['fr_email'];
						unset($_SESSION['fr_email']);
					}		
				?>"> <br>
				<?php		
					if(isset($_SESSION['e_email'])) // błąd z nickiem użytkownika ...
					{
						echo '<div class="error">'.$_SESSION['e_email'].'</div>';
						unset($_SESSION['e_email']);
					}		
				?>

				<!-- Nickname: <br> <input type="text" name="nick" value="<?php /* 		
					if(isset($_SESSION['fr_nick']))
					{
						echo $_SESSION['fr_nick'];
						unset($_SESSION['fr_nick']);
					}		
				 */ ?>"> <br> -->	
				
				<?php		
					/*if(isset($_SESSION['e_nick'])) // błąd z nickiem użytkownika ...
					{
						echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
						unset($_SESSION['e_nick']);
					} */
				?>

				

				Hasło: <br> <input type="password" name="haslo1"><br>

				value="<?php 	
					if(isset($_SESSION['fr_haslo1']))
					{
						echo $_SESSION['fr_haslo1'];
						unset($_SESSION['fr_haslo1']);
					}

					// do usunięcia w przyszłości - nie przechowujemy haseł w zmiennych sesyjnych			
				?>"

				<?php		
					if(isset($_SESSION['e_haslo'])) // błąd z nickiem użytkownika ...
					{
						echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
						unset($_SESSION['e_haslo']);
					}		
				?>
				Powtórz hasło: <br> <input type="password" name="haslo2"

				value="<?php 	
					if(isset($_SESSION['fr_haslo2']))
					{
						echo $_SESSION['fr_haslo2'];
						unset($_SESSION['fr_haslo2']);
					}

					// do usunięcia w przyszłości - nie przechowujemy haseł w zmiennych sesyjnych			
				?>"><br>

				<br><hr>

				Dane adresowe <br><br>

				Miasto: <br> <input type="text" name="miejscowosc" value="<?php 		
					if(isset($_SESSION['fr_miejscowosc']))
					{
						echo $_SESSION['fr_miejscowosc'];
						unset($_SESSION['fr_miejscowosc']);
					}		
				?>"> <br>		
				
				<?php		
					if(isset($_SESSION['e_miejscowosc'])) 
					{
						echo '<div class="error">'.$_SESSION['e_miejscowosc'].'</div>';
						unset($_SESSION['e_miejscowosc']);
					}		
				?>

				Ulica: <br> <input type="text" name="ulica" value="<?php 		
					if(isset($_SESSION['fr_ulica']))
					{
						echo $_SESSION['fr_ulica'];
						unset($_SESSION['fr_ulica']);
					}		
				?>"> <br>		
				
				<?php		
					if(isset($_SESSION['e_ulica'])) 
					{
						echo '<div class="error">'.$_SESSION['e_ulica'].'</div>';
						unset($_SESSION['e_ulica']);
					}		
				?>


				Numer domu: <br> <input type="text" name="numer_domu" value="<?php 		
					if(isset($_SESSION['fr_numer_domu']))
					{
						echo $_SESSION['fr_numer_domu'];
						unset($_SESSION['fr_numer_domu']);
					}		
				?>"> <br>		
				
				<?php		
					if(isset($_SESSION['e_numer_domu'])) 
					{
						echo '<div class="error">'.$_SESSION['e_numer_domu'].'</div>';
						unset($_SESSION['e_numer_domu']);
					}		
				?>

				<br><hr><br>

				Kod pocztowy: <br> <input type="text" name="kod_pocztowy" value="<?php 		
					if(isset($_SESSION['fr_kod_pocztowy']))
					{
						echo $_SESSION['fr_kod_pocztowy'];
						unset($_SESSION['fr_kod_pocztowy']);
					}		
				?>"> <br>		
				
				<?php		
					if(isset($_SESSION['e_kod_pocztowy'])) 
					{
						echo '<div class="error">'.$_SESSION['e_kod_pocztowy'].'</div>';
						unset($_SESSION['e_kod_pocztowy']);
					}		
				?>

				Miejscowość: <br> <input type="text" name="kod_miejscowosc" value="<?php 		
					if(isset($_SESSION['fr_kod_miejscowosc']))
					{
						echo $_SESSION['fr_kod_miejscowosc'];
						unset($_SESSION['fr_kod_miejscowosc']);
					}		
				?>"> <br>		
				
				<?php		
					if(isset($_SESSION['e_kod_miejscowosc'])) 
					{
						echo '<div class="error">'.$_SESSION['e_kod_miejscowosc'].'</div>';
						unset($_SESSION['e_kod_miejscowosc']);
					}		
				?>

				<!-- Województwo: <br> <input type="text" name="wojewodztwo" value="<?php /* 		
					if(isset($_SESSION['fr_kod_wojewodztwo']))
					{
						echo $_SESSION['fr_kod_wojewodztwo'];
						unset($_SESSION['fr_kod_wojewodztwo']);
					}		
				*/ ?>"> <br>		
				
				<?php /*		
					if(isset($_SESSION['e_kod_wojewodztwo'])) 
					{
						echo '<div class="error">'.$_SESSION['e_kod_wojewodztwo'].'</div>';
						unset($_SESSION['e_kod_wojewodztwo']);
					} */		
				?>

				Kraj: <br> <input type="text" name="kraj" value="<?php /*		
					if(isset($_SESSION['fr_kraj']))
					{
						echo $_SESSION['fr_kraj'];
						unset($_SESSION['fr_kraj']);
					}	*/	
				?>"> <br>		
				
				<?php	/*	
					if(isset($_SESSION['e_kraj'])) 
					{
						echo '<div class="error">'.$_SESSION['e_kraj'].'</div>';
						unset($_SESSION['e_kraj']);
					}	*/	
				?> -->

				<!-- Pesel: <br> <input type="text" name="pesel" value="<?php /* 		
					if(isset($_SESSION['fr_pesel']))
					{
						echo $_SESSION['fr_pesel'];
						unset($_SESSION['fr_pesel']);
					}		
				*/ ?>"> <br>	-->	
				
				<?php /*		
					if(isset($_SESSION['e_pesel'])) 
					{
						echo '<div class="error">'.$_SESSION['e_pesel'].'</div>';
						unset($_SESSION['e_pesel']);
					}		
				*/ ?>

				<!-- Data urodzenia: <br> <input type="text" name="data_urodzenia" value="<?php /*		
					if(isset($_SESSION['fr_data_urodzenia']))
					{
						echo $_SESSION['fr_data_urodzenia'];
						unset($_SESSION['fr_data_urodzenia']);
					}		
				*/ ?>"> <br>		
				
				<?php /*		
					if(isset($_SESSION['e_data_urodzenia'])) 
					{
						echo '<div class="error">'.$_SESSION['e_data_urodzenia'].'</div>';
						unset($_SESSION['e_data_urodzenia']);
					}	*/	
				?> -->

				Telefon: <br> <input type="text" name="telefon" value="<?php 		
					if(isset($_SESSION['fr_telefon']))
					{
						echo $_SESSION['fr_telefon'];
						unset($_SESSION['fr_telefon']);
					}		
				?>"> <br>		
				
				<?php		
					if(isset($_SESSION['e_telefon'])) 
					{
						echo '<div class="error">'.$_SESSION['e_telefon'].'</div>';
						unset($_SESSION['e_telefon']);
					}		
				?>

				<hr>

				
			
				<label>
					<input type="checkbox" name="regulamin" <?php
					
						if(isset($_SESSION['fr_regulamin']))
						{
							echo "checked";
							unset($_SESSION['fr_regulamin']);
						}
					
					?>> Akceptuję regulamin
				</label>
				<?php		
					if(isset($_SESSION['e_regulamin'])) // błąd z akceptacją regulaminu (checkbox) ...
					{
						echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
						unset($_SESSION['e_regulamin']);
					}		
				?>	
				<br>	
						
				<div class="g-recaptcha" data-sitekey="6LcW48gfAAAAAGUsG8FaLDe_j8U6ZPbECr8egdx1"></div>		
				
				<?php		
					if(isset($_SESSION['e_bot'])) // błąd z re'captcha ...
					{
						echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
						unset($_SESSION['e_bot']);
					}		
				?>			
				
				<br>		
				<input type="submit" value="Zarejestruj się" >		
			
				<!-- reCAPTCHA (v2 !!!)

					klucze reCAPTCHA (v2 !!!) :
						Site key = klucz jawny (HTML)
						Secret key = klucz tajny (PHP)		
								
					Tworzenie reCaptcha:

						google.com/recaptcha

						-> v3 Admin Console 
						-> Utwórz + (google.com/recaptcha/admin/create)

					etykieta: "XAMPP"
					nazwa domeny : "localhost"

					Site Key   :    	(html)
					Secret Key : 		(PHP)	

					Umieszceznie reCAPTCHA w html :			
					-> v3 Documentation
				-->
				
				<!-- reCAPTCHA (v2) - konto jan.nowak.6820@gmail.com

					klucze reCAPTCHA (v2) :
						Site key = klucz jawny (HTML)
						Secret key = klucz tajny (PHP)		
								
					Tworzenie reCaptcha:

						google.com/recaptcha

						-> v3 Admin Console 
						-> Utwórz + (google.com/recaptcha/admin/create)

					etykieta: "XAMPP"
					nazwa domeny : "localhost"

					Site Key   : 6LcW48gfAAAAAGUsG8FaLDe_j8U6ZPbECr8egdx1   	(html)
					Secret Key : 6LcW48gfAAAAALDhZZERPDMpGD5aYMcLJ3s_IszG		(PHP)	

					Umieszceznie reCAPTCHA w html :			
					-> v3 Documentation
				-->
				
			</form>	
			
		</div>		

		<div id="footer">

		</div>

	</div>


	
	
</body>
</html>