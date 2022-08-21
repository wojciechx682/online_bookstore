<?php

	// Funkcje php - połączenie z bazą danych, 
	//			     wysyłanie zapytań (query) do bazy danych	
	
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

	function get_books($result) 
	{		
		$i = 0;

		while ($row = $result->fetch_assoc()) 
		{		
			$_SESSION['id_ksiazki'] = $row["id_ksiazki"];	 

		  	$_SESSION['tytul'] = $row["tytul"];
		  	$_SESSION['cena'] = $row["cena"];
		  	$_SESSION['rok_wydania'] = $row["rok_wydania"];			  		

		  	echo '<div id="book'.$i.'" class="book">';
		  	echo '<div class="title">'.$_SESSION['tytul'].'</div><br>';
		  	echo '<div class="price">'.$_SESSION['cena'].'</div><br>';
		  	echo '<div class="year">'.$_SESSION['rok_wydania'].'</div><br>';	
		  	echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a>';	
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

	function get_product_from_cart($result)	// order.php
	{
		$_SESSION['suma_zamowienia'] = 0;

		while ($row = $result->fetch_assoc()) 
		{			        
		  	echo $row['tytul'].", || ".$row['cena'].", || ".$row['rok_wydania']." || <b> Ilość : </b> ".$row['ilosc']. "<br>"; 	

		  	$_SESSION['suma_zamowienia'] += $row['ilosc'] * $row['cena'];	  
		}

		$result->free_result(); 	
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
		echo '<script> alert("test123"); </script>'; 
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

		mysqli_report(MYSQLI_REPORT_STRICT); // ?

		try 
		{			
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);				
			 
			if($polaczenie->connect_errno!=0) // błąd połączenia
			{			
				throw new Exception(mysqli_connect_errno()); // rzuć nowy wyjątek			
			}
			else // udane polaczenie
			{	
				if(($type == "SELECT"))
				{	
					//echo "<br><br> -> " . sprintf($query, mysqli_real_escape_string($polaczenie, $value)) . "<br><br>";

					//if($result = $polaczenie->query($query)) // udane zapytanie
					if($result = $polaczenie->query(sprintf($query, mysqli_real_escape_string($polaczenie, $value)))) 
					{
						//////////////////////////////////////////////////////////////////////////////////////////////////////
						
							$num_of_rows = $result->num_rows; // ilość zwróconych wierszy				
							if($num_of_rows>0) // znaleziono rekordy ...
							{
								$fun($result); // wywołanie zewnętrznej funkcji					
							}
							else  // brak zwróconych rekordów
							{				
											//$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
											//$_SESSION['blad'] = '<span style="color: red">Brak wyników</span>';
											//header('Location: index.php');
											//echo '<script>alert("functions - 436");</script>';	
								echo '<h3>Brak wyników</h3>';
								//exit();		  
							}	
						
						/*else // INSERT, UPDATE ...
						{
							$result->free_result();		
						}*/
						
						//////////////////////////////////////////////////////////////////////////////////////////////////////
					}
					else 
					{
						throw new Exception($polaczenie->error);
						//echo $_SESSION['blad'];
					}

					$polaczenie->close();
				}
				else  // INSERT, UPDATE ...
				{

					//echo "<br><br> -> " . sprintf($query, mysqli_real_escape_string($polaczenie, $value)) . "<br><br>";									
					
					// Użycie funkcji mysqli_real_escape_string na tablicy parametrów (wartosci tj. imie, nazwisko, hasło ...)

					for($i = 0; $i < count($value); $i++)
					{					 
						//$value_i = $value[$i];						
						$value[$i] = mysqli_real_escape_string($polaczenie, $value[$i]);
					}

					if($result = $polaczenie->query(vsprintf($query, $value))) //$query - zapytanie, $value - tablica parametrów do vsprintf
					{
						//////////////////////////////////////////////////////////////////////////////////////////////////////
						
						//echo '<script>alert("udało się zmienić dane :)")</script>';
						
						//////////////////////////////////////////////////////////////////////////////////////////////////////
					}
					else 
					{
						throw new Exception($polaczenie->error);

					}

					$polaczenie->close();

					//exit();
				}
			}
		}
		catch(Exception $e) // Exception - wyjątek
		{
			echo '<script>alert("functions - 486");</script>';

			//echo '<span style="color: red;"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</span>'; 
			
			echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</div>';

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