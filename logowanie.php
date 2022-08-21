<?php
	
	session_start(); // funkcja pozwalająca dokumentowi korzystać z sesji
	// każdy dokument korzystający z sesji, musi posiadać ten wpis na początku.
	
	// sprawdzamy, czy zmienne login i hasło zostały ustawione (CZY ISTNIEJĄ!) :
	
	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}

		//session_start();	
	/*
	if (isset($_COOKIE['PHPSESSID'])) 
	{
		$cookie_name = "PHPSESSID";
		$cookie_value = $_COOKIE['PHPSESSID'];

		setcookie($cookie_name, $cookie_value, time() - 3600, "/"); 

	    //unset($_COOKIE['PHPSESSID']);
	    //setcookie('key', '', time() - 3600, '/'); // empty value and old timestamp
	    session_unset(); // niszczy sesje, oraz wszystkie zmienne sesyjne	
		header('Location: index.php');	
		exit();
	}
	*/
		//echo $_COOKIE['PHPSESSID'];
		//exit();	  
		// 86400 = 1 day
		// Wylogowanie użytkownika, niszczenie sesji :
		//session_unset(); // niszczy sesje, oraz wszystkie zmienne sesyjne	
		//header('Location: index.php');	
		//exit();

	require "connect.php"; // umieść zawartość pliku connect.php wewnątrz zaloguj.php
		// include	include_once	require 	require_once
		// (ostrzerzenie)		 	(błąd krytyczny)
		
		// połączenie z bazą danych, sprawdzenie czy istnieje taki user w bazie 
		
		// stworzenie obiektu reprezentującego połączenie :	
		// obiekt klasy mysqli	
			// mysqli - metoda będąca konstruktorem
		
		//echo "<br> Dane połączeniowe z bazą danych : <br>".$host." ".$db_user." ".$db_password." ".$db_name."<br><br>";		

	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try // spróbuj połączyć się z bazą danych
	{
		
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);		
			// @ - operator kontroli błędów - w przypadku blędu, php nie wyświetla informacji o błędzie
		
		// sprawdzamy, czy udało się połaczyć z bazą danych
		 
		if($polaczenie->connect_errno!=0) // błąd połączenia
		{
			// 0  = false           = udane połączenie
			// !0 = true (1,2, ...) = błąd połączenia
			
				//echo "[ Błąd połączenia ] (".$conn->connect_errno."), Opis: ".$conn->connect_error;		
			//echo "[ Błąd połączenia ] (".$polaczenie->connect_errno.") <br>";	
			throw new Exception(mysqli_connect_errno()); // rzuć nowy wyjątek			
		}
		else // udane polaczenie
		{
			// sprawdzamy czy istnieje taki user w bazie danych
			
			// odczytujemy dane z formularza
			$login = $_POST['login'];
			$haslo = $_POST['haslo'];
				//echo "udalo sie polaczyc z baza <br>".$login.'<br> '.$haslo;
			
			// ochrona przed wstrzykiwaniem SQL :
			
			$login = htmlentities($login, ENT_QUOTES, "UTF-8"); // html entities = encje html'a
			// dla zahaszowanego hasła, usuwamy htmlentities :
			//$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8"); // END_QUOTES - mówi, żebyśmy zamieniali na encje cudzysłowia i apostrofy
					
			//$sql = "SELECT * FROM uzytkownicy WHERE user = '$login' AND pass = '$haslo'";		
			 
			if ($result = $polaczenie->query(
			sprintf("SELECT * FROM klienci WHERE login='%s'",
			mysqli_real_escape_string($polaczenie,$login)))) // czy w zapytaniu wystąpił błąd ? (np. literówka)
			{	
				// zmienna przechowująca ilość userów o takim loginie i haśle (ilość zwróconych rekordów)
									   //num_rows = number of rows - liczba zwróconych wierszy
				$ilu_userow = $result->num_rows;
				
				if($ilu_userow>0) // == 1		(znaleziono usera o takim loginie)
				{
					$wiersz = $result->fetch_assoc(); // tablica asocjacyjna				
					// fetch assoc = przynieś dane i włóż je do tablicy asocjacyjnej				
					// tablica asocjacyjna - zamiast indeksów tablicy, używamy nazw kolumn z bazy danych				
					
					// WERYFIKACJA HASZA : (czy hasze hasła sa identyczne)
					// porównanie hasha podanego przy logowaniu, z hashem zapisanym w bazie danych : 
					
					if(password_verify($haslo, $wiersz['haslo'])) // true -> hasze sa takie same (podano poprawne hasło do konta)
					{			
						// istnieje taki user, udalo sie zalogowac

						echo '<script>console.log(107);</script>';

						$_SESSION['zalogowany'] = true;						
						
						//$user = $wiersz['user'];					
							//echo "<br><br> User_login = ".$user."<br>";		
						$_SESSION['id'] = $wiersz['id_klienta'];
						$_SESSION['imie'] = $wiersz['imie'];
						$_SESSION['nazwisko'] = $wiersz['nazwisko'];
						$_SESSION['miejscowosc'] = $wiersz['miejscowosc'];
						$_SESSION['ulica'] = $wiersz['ulica'];
						$_SESSION['numer_domu'] = $wiersz['numer_domu'];
						$_SESSION['kod_pocztowy'] = $wiersz['kod_pocztowy'];
						$_SESSION['kod_miejscowosc'] = $wiersz['kod_miejscowosc'];
						$_SESSION['wojewodztwo'] = $wiersz['wojewodztwo'];
						$_SESSION['kraj'] = $wiersz['kraj'];
						$_SESSION['PESEL'] = $wiersz['PESEL'];
						$_SESSION['data_urodzenia'] = $wiersz['data_urodzenia'];
						$_SESSION['telefon'] = $wiersz['telefon'];
						$_SESSION['email'] = $wiersz['email'];
						$_SESSION['login'] = $wiersz['login'];
						//$_SESSION['dnipremium'] = $wiersz['dnipremium'];
						
						unset($_SESSION['blad']);
						
						// pozbywamy się z pamięci rezultatu zapytania
						$result->free_result(); // free() // close();				
						
						// przekierowanie do strony main.php :
						header('Location: index.php');	
						exit();		
					}
					else  // dobry login, złe hasło
					{				
						// błędne dane logowanie -> przekierowanie do index.php + komunikat
						$_SESSION['blad'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
						header('Location: zaloguj.php');	
						exit();					  
					}
				}
				else  // nie ma takiego usera (login) // zły login, obojętnie jakie hasło ...
				{				
					// błędne dane logowanie -> przekierowanie do index.php + komunikat
					$_SESSION['blad'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
					header('Location: zaloguj.php');	
					exit();					  
				}			  
				
				//echo "<br>Połączenie jest poprawne<br>";
				//echo "<br>";			
			}
			
			else 
			{
				throw new Exception($polaczenie->error);
			}			
			
			$polaczenie->close();	//zamykamy połączenie
		}
	}
	catch(Exception $e) // Exception - wyjątek
	{
		//echo '<span style="color: red;"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</span>'; 
		
		echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</div>';

		echo '<br><span style="color:red">Informacja developerska: </span>'.$e; // wyświetlenie komunikatu błędu - DLA DEWELOPERÓW
	}
		

?>

<link rel="stylesheet" href="style.css">