<?php

	// Funkcje php - połączenie z bazą danych, 
	//			     wysyłanie zapytań (query) do bazy danych	
	

	// Blokada dostępu do adresu "localhost/../functions.php" przez URL
	$currentPage = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if ($_SERVER['REQUEST_METHOD'] == "GET" && strcmp(basename($currentPage), basename(__FILE__)) == 0)
	{
	    http_response_code(404);
	    //include('index.php'); // provide your own 404 error page
	    header('Location: index.php');

	    die(); /* remove this if you want to execute the rest of
	              the code inside the file before redirecting. */
	}

	function get_categories($result) // wypisuje elementy listy <li> - wewnątrz kategorii (top_nav)
	{
		$cat = "Wszystkie";
		echo '<li><a href="index.php?kategoria='.$cat.'">'.$cat.'</a></li>'; // Zamiana na jQuery ? event listener ? 
		while ($row = $result->fetch_assoc()) 
		{ 		  	
		  	//echo '<a href="index.php?kategoria='.$row['kategoria'].' ">'.$row['kategoria'].'</a><br><br>';

		  	echo '<li><a href="index.php?kategoria='.$row['kategoria'].' ">'.$row['kategoria'].'</a></li>';

		  	//echo '<li><a href="index.php?kategoria=">Informatyka</a></li>';
		}
		$result->free_result(); 		
	}

	function get_books($result) // content -> wyświetla wszystkie książki
	{		
		$i = 0;

		while ($row = $result->fetch_assoc()) 
		{	
			// zapisywanie danych książek do zmiennych sesyjnych

			$_SESSION['id_ksiazki'] = $row["id_ksiazki"];	
		  	$_SESSION['tytul'] = $row["tytul"];
		  	$_SESSION['cena'] = $row["cena"];
		  	$_SESSION['rok_wydania'] = $row["rok_wydania"];			  		

		  	echo '<div id="book'.$i.'" class="book">';
			  	echo '<div class="title">'.$_SESSION['tytul'].'</div><br>';
			  	echo '<div class="price">'.$_SESSION['cena'].'</div><br>';
			  	echo '<div class="year">'.$_SESSION['rok_wydania'].'</div><br>';	
			  	//echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a>';	

			  	echo '<form action="add_to_cart.php" method="post">';

			  		echo '<input type="hidden" name="id_ksiazki" value="'.$_SESSION['id_ksiazki'].'">';

			  		echo '<input type="hidden" id="koszyk_ilosc" name="koszyk_ilosc" value="1">';

			  		//echo '<br><br><input type="submit" value="Dodaj do koszyka">';

			  		//echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a>';	

			  		echo '<button type="submit" name="your_name" value="your_value" class="btn-link">Dodaj ko koszyka</button>';

			  	echo '</form>';


			  
			  		



		  	echo '</div>';			  	 		

		  	$i++;
		}

		$result->free_result();		
	}		

	function check_email($result) // validate_user_data.php - sprawdza, czy istnieje juz taki email
	{
		$_SESSION['email_exists'] = true; 
	}

	function get_books_by_id($result) // koszyk_dodaj.php
	{
		while ($row = $result->fetch_assoc()) 
		{
		  	$_SESSION['tytul'] = $row["tytul"];
		  	$_SESSION['cena'] = $row["cena"];
		  	$_SESSION['rok_wydania'] = $row["rok_wydania"];

		  	echo $_SESSION['tytul'].", || ".$_SESSION['cena'].", || ".$_SESSION['rok_wydania']." ";

		  	//echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a><br><br>';		  	
		  	//echo '<a href="main.php?kategoria='.$kategoria.' ">asdsd</a>';
		  	//echo '<a href="main.php?kategoria='.$_SESSION['kategoria'].' ">'.$_SESSION['kategoria'].'</a><br><br>';	
		}

		$result->free_result();
	}

	function count_cart_quantity($result) // zapisuje do zmiennej sesyjnej ilość książek klienta w koszyku
	{
		//SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta=1;

		$row = $result->fetch_assoc();

		//$_SESSION['koszyk_ilosc_ksiazek'] = $row['suma'];
		//$_SESSION['koszyk_ilosc_ksiazek'] = "123";

		if($row['suma'] == NULL)
		{
				//echo "0";
			//return "0";
			$_SESSION['koszyk_ilosc_ksiazek'] = 0;
		}
		else {
				//return $row['suma'];
				//return "1";
			//echo $row['suma'];
			$_SESSION['koszyk_ilosc_ksiazek'] = $row['suma'];
		}

		

		$result->free_result();		
	}

	function get_product_from_cart($result)	// order.php
	{
		// $row[] -> kl.id_klienta, 		klient
		//		     ko.id_ksiazki,        	 	     koszyk
		//		     ko.ilosc, 						 koszyk
		//		     ks.tytul, 			    ksiazki
		//		     ks.cena,               ksiazki
		//		     ks.rok_wydania         ksiazki

		$_SESSION['suma_zamowienia'] = 0;

		$i = 0;

		while ($row = $result->fetch_assoc()) 
		{			        
		  	/*echo $row['tytul'].", || ".$row['cena'].", || ".$row['rok_wydania']." || <b> Ilość : </b> ".$row['ilosc'] ;

		  	echo '<button class="cart_remove_book" type="button">Usuń</button>';*/

		  	echo '<div id="book'.$i.'">';
		  	echo '<div class="title">'.$row['tytul'].'</div>';
		  	echo '<div class="price">'.$row['cena'].'</div>';
		  	echo '<div class="year">'.$row['rok_wydania'].'</div>';	

		  		/*echo '<div class="quantity'.'">

			  			 <b>Ilość = </b>'.$row['ilosc'];

			  			 echo '<button type="button" onclick="increase()">+</button>';
						 echo '<button type="button" onclick="decrease()">-</button>';


	  			echo '</div>';*/

	  			echo '<form class="change_quantity_form" id="change_quantity_form'.$row['id_ksiazki'].'" action="change_cart_quantity.php" method="post">';

					echo '<input type="hidden" name="id_ksiazki" value="'.$row['id_ksiazki'].'">';

					echo "<b>Ilosc: </b> ";

						/*echo '<select name="koszyk_ilosc">';
						    echo '<option value="1">1</option>';
						    echo '<option value="2">2</option>';
						    echo '<option value="3">3</option>';
						    echo '<option value="4">4</option>';
						    echo '<option value="5">5</option>';
						echo '</select>';*/

					//echo '<input type="text" id="koszyk_ilosc" name="koszyk_ilosc" value="'.$row['ilosc'].'">';
					echo '<input type="text" id="koszyk_ilosc'.$row['id_ksiazki'].'" name="koszyk_ilosc" value="'.$row['ilosc'].'">';

					echo '<button type="button" onclick="increase('.$row['id_ksiazki'].')">+</button>';
					echo '<button type="button" onclick="decrease('.$row['id_ksiazki'].')">-</button>';


					//echo '<br><br><input type="submit" value="Zapisz koszyk">';

				echo '</form>';



		  	echo '<form id="remove_book_form" action="remove_book.php" method="post">';
		  		
		  		echo '<input type="hidden" name="id_klienta" value="'.$row['id_klienta'].'">';
		  		echo '<input type="hidden" name="id_ksiazki" value="'.$row['id_ksiazki'].'">';
		  		echo '<input type="hidden" name="ilosc" value="'.$row['ilosc'].'">';

		  		echo '<input type="submit" value="Usuń">';

		  	echo '</form>';

		  	////////////////////////////////////////////////////////////////////////////////////

		  	echo "<br><hr><br>";
		  	
		  	/*echo '<form action="change_cart_quantity.php" method="post">';

					echo '<input type="hidden" name="id_ksiazki" value="'.$row['id_ksiazki'].'">';

					echo "<b>Ilosc: </b> ";

					

					echo '<input type="text" id="koszyk_ilosc" name="koszyk_ilosc" value="1">';

					echo '<button type="button" onclick="increase()">+</button>';
					echo '<button type="button" onclick="decrease()">-</button>';


					echo '<br><br><input type="submit" value="Zapisz koszyk">';

			echo '</form>';*/


		  		
		  	echo '</div>';



			//echo "<br>"; 	

			$i++;

		  	$_SESSION['suma_zamowienia'] += $row['ilosc'] * $row['cena'];	  
		}

		echo "<br> $ _SESSION suma_zamowienia = " ;
		echo $_SESSION['suma_zamowienia'] . "<br>";

		echo "<br> $ _SESSION koszyk_ilosc_ksiazek = " ;
		echo $_SESSION['koszyk_ilosc_ksiazek'] . "<br>";

		$result->free_result(); 	
	}

	function remove_product_from_cart($result) //remove_book.php
	{




	}

	function add_product_to_cart($id_ksiazki, $quantity)	
	{
		require "connect.php";		

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
				//echo "<hr> -> kategoria = ".$kategoria."<br>";
					//$kategorie = $polaczenie->query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC");
                
                $id_klienta = $_SESSION['id'];

				if($ksiazki = $polaczenie->query(" INSERT INTO koszyk (id_klienta, id_ksiazki, ilosc) VALUES ('$id_klienta', '$id_ksiazki', '$quantity')           ")   )  
				{
					//$ksiazki->free_result();												
				}
				else 
				{
					throw new Exception($polaczenie->error);
				}

				$polaczenie->close();
			}
		}
		catch(Exception $e) // Exception - wyjątek
		{
			//echo '<span style="color: red;"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</span>'; 
			
			echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o sprawdzenie serwisu w innym terminie! ]</div>';

			echo '<br><span style="color:red">Informacja developerska: </span>'.$e; // wyświetlenie komunikatu błędu - DLA DEWELOPERÓW

			exit(); // (?)
		}
	}

	function get_orders($result)
	{
		while ($row = $result->fetch_assoc()) 
		{
		  	echo "id =" . $row['id_zamowienia']." || data = " .$row['data_zlozenia_zamowienia']." || status = ".$row['status']." ";

		  	
		  	echo '<a href="order_details.php?order_id='.$row['id_zamowienia'].' "> Szczegóły zamówienia </a><br>';


		  	//echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a><br><br>';		  	
		  	//echo '<a href="main.php?kategoria='.$kategoria.' ">asdsd</a>';
		  	//echo '<a href="main.php?kategoria='.$_SESSION['kategoria'].' ">'.$_SESSION['kategoria'].'</a><br><br>';	
		}

		$result->free_result();
	}

	function validate_form()
	{
		//echo '<script> alert("test123"); </script>'; 
	}

	function get_order_details($result)
	{

		$_SESSION['order_details_books_id'] = array();
		$_SESSION['order_details_books_quantity'] = array();

		while ($row = $result->fetch_assoc()) 
		{
		  	//echo "<br>id_szczegoly_zamowienia  =" . $row['id_szczegoly_zamowienia']. " || id_zamowienia  = " .$row['id_zamowienia']." || id_ksiazki  = ".$row['id_ksiazki']." ilosc =  " .$row['ilosc']. "<br>";
		  	echo "<br>id_szczegoly_zamowienia  = || id_zamowienia  = " .$row['id_zamowienia']." || id_ksiazki  = ".$row['id_ksiazki']." ilosc =  " .$row['ilosc']. "<br>";

	  		
	  		array_push($_SESSION['order_details_books_id'], $row['id_ksiazki']); // przechowuje id książek (tablica)

	  		array_push($_SESSION['order_details_books_quantity'], $row['ilosc']); // przechowuje ilosc (tablica) ! DO ZROBIENIA W PRZYSZŁOŚCI TAK JAK FUNKCJA order_details_get_book

		  	//echo '<a href="order_details.php?order_id='.$row['id_zamowienia'].' "> Szczegóły zamówienia </a>';
		  	//echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a><br><br>';		  	
		  	//echo '<a href="main.php?kategoria='.$kategoria.' ">asdsd</a>';
		  	//echo '<a href="main.php?kategoria='.$_SESSION['kategoria'].' ">'.$_SESSION['kategoria'].'</a><br><br>';	
		}

		$result->free_result();
	}

	function order_details_get_book($result)
	{
		while ($row = $result->fetch_assoc()) 
		{
		  	echo "<br> tytul  =" . $row['tytul']. " || cena  = " .$row['cena']." || rok_wydania  = ".$row['rok_wydania']."<br>";
		}

		$result->free_result();
	}

	function verify_password($result)
	{
		while ($row = $result->fetch_assoc()) 
		{
		  	//echo "<br> haslo  =" . $row['haslo']. " <br>";
		  	$_SESSION['stare_haslo'] = $row['haslo'];
		}

		$result->free_result();
	}

	function test_fun()
	{
		return "123";
	}

	// skrypt logowania (logowanie.php) - logowanie, weryfikacja hasła :
	function log_in($result)
	{
		$row = $result->fetch_assoc(); // wiersz (BD) - pola tabeli = tablica asocjacyjne

		//echo '$_POST[login] = ' . $_POST['login'] . "<br>";
		//echo '$_POST[haslo] = ' . $_POST['haslo'] . "<br>";		
		//exit();

		// WERYFIKACJA HASZA : (czy hasze hasła sa identyczne)
		// porównanie hasha podanego przy logowaniu, z hashem zapisanym w bazie danych : 		

		$haslo = $_POST['haslo'];			

		if(password_verify($haslo, $row['haslo'])) // true -> hasze sa takie same (podano poprawne hasło do konta)
		{	
			$_SESSION['zalogowany'] = true;			
			$_SESSION['id'] = $row['id_klienta'];
			$_SESSION['imie'] = $row['imie'];
			$_SESSION['nazwisko'] = $row['nazwisko'];
			$_SESSION['miejscowosc'] = $row['miejscowosc'];
			$_SESSION['ulica'] = $row['ulica'];
			$_SESSION['numer_domu'] = $row['numer_domu'];
			$_SESSION['kod_pocztowy'] = $row['kod_pocztowy'];
			$_SESSION['kod_miejscowosc'] = $row['kod_miejscowosc'];
			$_SESSION['wojewodztwo'] = $row['wojewodztwo'];
			$_SESSION['kraj'] = $row['kraj'];
			$_SESSION['PESEL'] = $row['PESEL'];
			$_SESSION['data_urodzenia'] = $row['data_urodzenia'];
			$_SESSION['telefon'] = $row['telefon'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['login'] = $row['login'];			

			//$_SESSION['koszyk_ilosc_ksiazek'] = query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta); 

			//$_SESSION['test123'] = test_fun();

			//$id_klienta = $_SESSION['id'];
			//$_SESSION['test123'] = query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta);

			query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $row['id_klienta']);
			
			unset($_SESSION['blad']);
			
			// pozbywamy się z pamięci rezultatu zapytania
			$result->free_result(); // free() // close();				
			
			// przekierowanie do strony index.php :
			header('Location: index.php');	
			exit();		
		}
		else  // dobry login, złe hasło
		{		
			// błędne dane logowanie -> przekierowanie do index.php + komunikat
			$_SESSION['blad'] = '<span style="color: red">Nieprawidłowy e-mail lub hasło</span>';
			header('Location: zaloguj.php');	
			exit();					  
		}

	}

	function register_verify_email($result) // rejestracja (rejestracja_skrypt.php) - weryfikacja czy istnieje taki email
	{
		$_SESSION['wszystko_OK'] = false;
		$_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu email!";
	}	

	function cart_verify_book($result) // add_to_cart.php - sprawdza, czy książka już istnieje w koszyku (przestawia zmienną - jeśli tak)
	{ 
		$_SESSION['book_exists'] = true;

		$result->free_result();
	}


	function get_var_name($var) {

	    foreach($GLOBALS as $var_name => $value) 
	    {
	        if ($value === $var) 
	        {
	            return $var_name;
	        }
	    }
	    return false;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////

	// Funkcja ustanawiająca połączenie z bazą danych i realizująca zapytanie sql
	// $query - zapytanie sql
    // $fun - funkcja wyświetlająca dane
    // $value - wartość będąca parametrem funkcji sprintf / vsprintf (pojedyncza zmienna lub TABLICA)

	function query($query, $fun, $value)
	{	
		$type = get_first_word($query); // type = SELECT, INSERT, ... etc

			//return "<br> query = ".$query.", type = ".$type."<br>";

		//////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		// $query -> "SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%$search_value%'"

		//echo "<br> query = " . $query . "<br>" ; 

		require "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);  // sposób raportowania błędów -> MYSLQI_REPORT_STRICT - zamiast warningów, chcemy rzucać exception

		try 
		{			
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);			
			 
			if($polaczenie->connect_errno!=0) // błąd połączenia
			{			
				throw new Exception(mysqli_connect_errno()); // rzuć nowy wyjątek			
			}
			else // udane polaczenie
			{	
				//if(($type == "SELECT"))
				//if(($type == "SELECT"))
				if(!is_array($value)) // jeśli value to pojedyncza zmienna (nie tablica)
				{	
					//echo "<br><br> -> " . sprintf($query, mysqli_real_escape_string($polaczenie, $value)) . "<br><br>";

					//echo "<br> query = $query <br>"; exit();
					//if($result = $polaczenie->query($query)) // udane zapytanie
					if($result = $polaczenie->query(sprintf($query, mysqli_real_escape_string($polaczenie, $value)))) 
					{
						//////////////////////////////////////////////////////////////////////////////////////////////////////
						
							$num_of_rows = $result->num_rows; // ilość zwróconych wierszy	

							//echo '<script>console.log('.$num_of_rows.');</script>';

							if($num_of_rows>0) // znaleziono rekordy ...  // == 1
							{							

								$fun($result); // wywołanie zewnętrznej funkcji	



								// np. wywołanie funkcji, która zweryfikuje hasło, ... i wykona dalsze instrukcje tj. skrypt logowanie.php			
							}
							else  // brak zwróconych rekordów
							{			

											//$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
											//$_SESSION['blad'] = '<span style="color: red">Brak wyników</span>';
											//header('Location: index.php');
											//echo '<script>alert("functions - 436");</script>';	
								
								if ((get_var_name($value) == "email") && ($fun != "register_verify_email")) // jeśli to było logowanie - (wywołanie funkcji query() z logowanie.php)
								{
									// to sie wykona tylko dla skryptu logowania (logowanie.php)

									$_SESSION['blad'] = '<span style="color: red">Nieprawidłowy e-mail lub hasło</span>';
									header('Location: zaloguj.php');	
									exit();		

								}
								elseif((get_var_name($value) == "email") && ($fun == "register_verify_email"))  // to sie wykona tylko dla skryptu rejestracji (register_verify_email.php)
								{

									// ...  nic nie rób

								}	
								/*elseif((get_var_name($value) == "asdasd") && ($fun == "count_cart_quantity"))  // to sie wykona tylko dla skryptu rejestracji (register_verify_email.php)
								{

									// ...  nic nie rób
									//echo "var name = " . get_var_name($value) . "<br>";
									echo "00";

								}	*/
								else 
								{ 
									echo '<h3>Brak wyników</h3>';
								}

								  
							}			
											
						//////////////////////////////////////////////////////////////////////////////////////////////////////
					}
					else 
					{
						throw new Exception($polaczenie->error);
						//echo $_SESSION['blad'];
					}

					$polaczenie->close(); // Czy przenieść to poniżej aby nie pisać tego dwa razy ?
				}
				//else  // INSERT, UPDATE ...
				//elseif(($type == "INSERT") || ($type == "UPDATE"))  // INSERT, UPDATE ...
				elseif(is_array($value))  // INSERT, UPDATE ...
				{

					//echo "<br><br> -> " . sprintf($query, mysqli_real_escape_string($polaczenie, $value)) . "<br><br>";						
					
					// Użycie funkcji mysqli_real_escape_string na tablicy parametrów (wartosci tj. imie, nazwisko, hasło ...)

					for($i = 0; $i < count($value); $i++)
					{					 
						//$value_i = $value[$i];						
						$value[$i] = mysqli_real_escape_string($polaczenie, $value[$i]);

						//echo "<br> -> $value[$i]";
						
					}
					//exit();

					if($result = $polaczenie->query(vsprintf($query, $value))) //$query - zapytanie, $value - tablica parametrów do vsprintf
					{
						if($type != "DELETE") // koszyk.php - usuwanie książek 
						{
							//////////////////////////////////////////////////////////////////////////////////////////////////////
							
							//echo '<script>alert("udało się zmienić dane :)")</script>';
							
							//////////////////////////////////////////////////////////////////////////////////////////////////////

							// DLA ZAPYTANIA SELECT (z wykorzystaniem WIĘCEJ NIŻ JEDNEJ zmiennej w WHERE condition - zastosowanie - przy koszykach.php) :
							$num_of_rows = $result->num_rows; // ilość zwróconych wierszy
							if($num_of_rows>0) // znaleziono rekordy ...  // == 1
							{					
								$fun($result); // wywołanie zewnętrznej funkcji	
								// wywołanie funkcji cart_verify_book -> przestawi zmienną $_SESSION['book_exists'] na TRUE (co oznacza że książka ta istnieje w koszyku tego usera)
									// np. wywołanie funkcji, która zweryfikuje hasło, ... i wykona dalsze instrukcje tj. skrypt logowanie.php			
							}
							else 
							{
								if((isset($_SESSION['wszystko_OK'])))   // rejestracja.php ...
								{
									unset($_SESSION['wszystko_OK']);
									$_SESSION['udanarejestracja'] = true;
									//unset($_SESSION['wszystko_OK']);
									header('Location: zaloguj.php');

								}
							}

						}
						

						



					}
					else // nie udało się zrealizować zapytania
					{
						throw new Exception($polaczenie->error);

					}

					$polaczenie->close();

					//exit();
				}
				else // test połączenia z bazą danych - wyświetlanie wyjątku w przypadku błędu
				{
					// ?
				}
			}
		}
		catch(Exception $e) // Exception - wyjątek
		{
			//echo '<script>alert("functions - 486");</script>';

			//echo '<span style="color: red;"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</span>'; 
			
			echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności]</div>';

			echo '<br><span style="color:red">Informacja developerska: </span>'.$e; // wyświetlenie komunikatu błędu - DLA DEWELOPERÓW
			exit(); // (?)
		}

		//////////////////////////////////////////////////////////////////////////////////////////////////////////

		//return "<br> query = ".$query.", type = ".$type."<br>";
	}


	function get_first_word($string)
    {
    	// ta funkcja zwraca pierwsze słowo ze stringa 
        $arr = explode(' ', trim($string));
        return isset($arr[0]) ? $arr[0] : $string;
    }
?>