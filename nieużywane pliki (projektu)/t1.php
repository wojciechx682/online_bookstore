<?php

	session_start();
	
	//echo $_SESSION['login'] . '<br>';

	if(isset($_SESSION['zalogowany']))
	{
		//echo '<br>'.$_SESSION['account_error'];
		unset($_SESSION['account_error']);
		//exit();
	}	

	/*if(isset($_SESSION['account_error']))
	{
		//echo '<br>'.$_SESSION['account_error'];
		echo '<script>alert("Musisz być zalogowanym aby przeglądać swoje konto!")</script>';
		//exit();
	}*/

	// takiego ifa, należy dodać do każdej podstrony do której ma dostęp zalogowany użytkownik
	/*if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}	*/

	function get_categories() // ✓
	{
		// CO ROBI TA FUNKCJA :
			// tworzy linki (a href) -> <a href="index.php?kategoria=Wszystkie">Wszystkie</a>, z kategoriami

		//require_once "connect.php";
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

				//$kategorie = $polaczenie->query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC");

				if($kategorie = $polaczenie->query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC"))
				{
					$ilosc_kategorii = $kategorie->num_rows;

					$_SESSION['ilosc_kategorii'] = $ilosc_kategorii; // przyda się ...

					$_SESSION['Kategorie_array'] = array();	// Tablica przechowująca kategorie ...

					if($ilosc_kategorii>0)
					{						

						$cat = "Wszystkie";

						//echo "<br> ilosc kategorii -> ".$ilosc_kategorii."<br>";

						echo '<a href="index.php?kategoria='.$cat.'">'.$cat.'</a><br><br>';	

						while ($row = $kategorie->fetch_assoc()) 
						{
							    
						    //echo 'alert("nie");';
						  	//echo "console.log(".$row["id_autora"].");";	
						  	

						  	$_SESSION['kategoria'] = $row["kategoria"]; // do zmiany w przyszłości ? Na zmienna i tak 
							  	//echo "->".$_SESSION['kategoria'];

							  	//echo "<br>";
							  	
							  	//echo '<a href="main.php?kategoria='.$kategoria.' ">asdsd</a>';

						  	echo '<a href="index.php?kategoria='.$_SESSION['kategoria'].' ">'.$_SESSION['kategoria'].'</a><br><br>';	

						  	array_push($_SESSION['Kategorie_array'], $row["kategoria"]);

						}

						$kategorie->free_result(); // free() // close();				
						//$kategorie->close(); // free() // close();				
					}
					else  // brak zwróconych rekordów
					{				
						// błędne dane logowanie -> przekierowanie do index.php + komunikat
						$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
						header('Location: index.php');		
						exit();		  
					}						
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
			
			echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</div>';

			echo '<br><span style="color:red">Informacja developerska: </span>'.$e; // wyświetlenie komunikatu błędu - DLA DEWELOPERÓW
			exit(); // (?)
		}
	}

	function get_categories_($result) // $result - wynik zapytania
	{
		$cat = "Wszystkie";
		echo '<a href="index.php?kategoria='.$cat.'">'.$cat.'</a><br><br>';
		while ($row = $result->fetch_assoc()) 
		{ 		  	
		  	echo '<a href="index.php?kategoria='.$row['kategoria'].' ">'.$row['kategoria'].'</a><br><br>';
		}
		$result->free_result(); // free() // close();		
	}

	function get_books_by_categories_($result)
	{

		//$_SESSION['ilosc_ksiazek'] = $ilosc_ksiazek;
			//echo '<script>alert("ilosc ksiazek = " + '.$_SESSION['ilosc_ksiazek'].')</script>';

		$i = 0;

		while ($row = $result->fetch_assoc()) 
		{
			    
		    //echo 'alert("nie");';
		  	//echo "console.log(".$row["id_autora"].");";			  	

		  	$_SESSION['tytul'] = $row["tytul"];
		  	$_SESSION['cena'] = $row["cena"];
		  	$_SESSION['rok_wydania'] = $row["rok_wydania"];

		  	//echo $_SESSION['tytul'].", || ".$_SESSION['cena'].", || ".$_SESSION['rok_wydania']." ";

		  	echo '<div id="book'.$i.'" class="book">';

		  	echo '<div class="title">'.$_SESSION['tytul'].'</div>';
		  	echo '<div class="price">'.$_SESSION['cena'].'</div>';
		  	echo '<div class="year">'.$_SESSION['rok_wydania'].'</div>';
		  	//echo '<div style="clear: both;"></div>';		  	

		  	echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a>';	
		  	echo '</div>';			  	
		  	
		  	//echo '<a href="main.php?kategoria='.$kategoria.' ">asdsd</a>';
		  	//echo '<a href="main.php?kategoria='.$_SESSION['kategoria'].' ">'.$_SESSION['kategoria'].'</a><br><br>';	

		  	$i++;
		}

		$result->free_result(); // free() // close();				
		//$result->close(); // free() // close();		
	}

	function get_books_by_categories($kategoria) # get books by categories # ✓
	{

		//echo '<script>alert("get_books_by_categories")</script>';
		

		// Wyświetla tylko te książki, które należą do danej kategorii

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

				if($ksiazki = $polaczenie->query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '$kategoria'"))
				{
					//echo "<br> udane połączenie <br>";

					$ilosc_ksiazek = $ksiazki->num_rows;
					

					//echo "<br> ilosc_ksiazek -> $ilosc_ksiazek <br><br>";

					if($ilosc_ksiazek>0)
					{

						$_SESSION['ilosc_ksiazek'] = $ilosc_ksiazek;

						//echo '<script>alert("ilosc ksiazek = " + '.$_SESSION['ilosc_ksiazek'].')</script>';

						$i = 0;

						while ($row = $ksiazki->fetch_assoc()) 
						{
							    
						    //echo 'alert("nie");';
						  	//echo "console.log(".$row["id_autora"].");";	
						  	

						  	$_SESSION['tytul'] = $row["tytul"];
						  	$_SESSION['cena'] = $row["cena"];
						  	$_SESSION['rok_wydania'] = $row["rok_wydania"];

						  	//echo $_SESSION['tytul'].", || ".$_SESSION['cena'].", || ".$_SESSION['rok_wydania']." ";

						  	echo '<div id="book'.$i.'" class="book">';

						  	echo '<div class="title">'.$_SESSION['tytul'].'</div>';
						  	echo '<div class="price">'.$_SESSION['cena'].'</div>';
						  	echo '<div class="year">'.$_SESSION['rok_wydania'].'</div>';
						  	//echo '<div style="clear: both;"></div>';

						  	

						  	echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a>';	

						  	echo '</div>';			  	
						  	
						  	//echo '<a href="main.php?kategoria='.$kategoria.' ">asdsd</a>';

						  	//echo '<a href="main.php?kategoria='.$_SESSION['kategoria'].' ">'.$_SESSION['kategoria'].'</a><br><br>';	


						  	$i++;
						}

						$ksiazki->free_result(); // free() // close();				
						//$ksiazki->close(); // free() // close();				
					}
					else  // brak zwróconych rekordów
					{				
						// błędne dane logowanie -> przekierowanie do index.php + komunikat
						$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
						header('Location: index.php');		
						exit();		  
					}						
					
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

	function get_all_books() # get all books # ???
	{
		//echo '<script>alert("get_all_books")</script>';
		//echo '<script>alert("ilosc ksiazek = " + '.$_SESSION['ilosc_ksiazek'].')</script>';

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

				if($ksiazki = $polaczenie->query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki"))
				{
					//echo "<br> udane połączenie <br>";

					$ilosc_ksiazek = $ksiazki->num_rows;
					

					//echo "<br> ilosc_ksiazek -> $ilosc_ksiazek <br><br>";

					if($ilosc_ksiazek>0)
					{
						$i = 0;

						$_SESSION['ilosc_ksiazek'] = $ilosc_ksiazek;

						//echo '<script>alert("ilosc ksiazek = " + '.$_SESSION['ilosc_ksiazek'].')</script>';

						while ($row = $ksiazki->fetch_assoc()) 
						{
							    
						    //echo 'alert("nie");';
						  	//echo "console.log(".$row["id_autora"].");";	
						  	

						  	$_SESSION['tytul'] = $row["tytul"];
						  	$_SESSION['cena'] = $row["cena"];
						  	$_SESSION['rok_wydania'] = $row["rok_wydania"];

						  	//echo $_SESSION['tytul'].", || ".$_SESSION['cena'].", || ".$_SESSION['rok_wydania']." ";

						  	echo '<div id="book'.$i.'" class="book">';

						  	echo '<div class="title">'.$_SESSION['tytul'].'</div>';
						  	echo '<div class="price">'.$_SESSION['cena'].'</div>';
						  	echo '<div class="year">'.$_SESSION['rok_wydania'].'</div>';
						  	//echo '<div style="clear: both;"></div>';

						  	
						  	echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a>';	
						  	echo '</div>';

						  	$i++;						  	
						  	
						  	//echo '<a href="main.php?kategoria='.$kategoria.' ">asdsd</a>';

						  	//echo '<a href="main.php?kategoria='.$_SESSION['kategoria'].' ">'.$_SESSION['kategoria'].'</a><br><br>';	
						}

						$ksiazki->free_result(); // free() // close();				
						//$ksiazki->close(); // free() // close();				
					}
					else  // brak zwróconych rekordów
					{				
						// błędne dane logowanie -> przekierowanie do index.php + komunikat
						$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
						header('Location: index.php');		
						exit();		  
					}						
					
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

	function get_all_books_sorted($sort_by, $sort_typ) # get all books sorted
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

				if($sort_typ == "rosnaco")
				{
					$ksiazki = $polaczenie->query("SELECT * FROM ksiazki ORDER BY $sort_by ASC");
				}
				else
				{
					$ksiazki = $polaczenie->query("SELECT * FROM ksiazki ORDER BY $sort_by DESC");
				}

				if($ksiazki)
				{
					//echo "<br> udane połączenie <br>";

					$ilosc_ksiazek = $ksiazki->num_rows;

					//echo "<br> ilosc_ksiazek -> $ilosc_ksiazek <br><br>";

					if($ilosc_ksiazek>0)
					{
						while ($row = $ksiazki->fetch_assoc()) 
						{
							    
						    //echo 'alert("nie");';
						  	//echo "console.log(".$row["id_autora"].");";	
						  	

						  	$_SESSION['tytul'] = $row["tytul"];
						  	$_SESSION['cena'] = $row["cena"];
						  	$_SESSION['rok_wydania'] = $row["rok_wydania"];

						  	echo $_SESSION['tytul'].", || ".$_SESSION['cena'].", || ".$_SESSION['rok_wydania']." ";		

						  	echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a><br><br>';	

						  	
						  	
						  	//echo '<a href="main.php?kategoria='.$kategoria.' ">asdsd</a>';

						  	//echo '<a href="main.php?kategoria='.$_SESSION['kategoria'].' ">'.$_SESSION['kategoria'].'</a><br><br>';	
						}

						$ksiazki->free_result(); // free() // close();				
						//$ksiazki->close(); // free() // close();				
					}
					else  // brak zwróconych rekordów
					{				
						// błędne dane logowanie -> przekierowanie do index.php + komunikat
						$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
						header('Location: index.php');		
						exit();		  
					}						
					
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

	function get_all_books_sorted_and_category($kategoria, $sort_by, $sort_typ) # get all books sorted and categorized
	{
		//echo '<script>alert("get_all_books_sorted_and_category")</script>';

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

				if($sort_typ == "rosnaco")
				{
					$ksiazki = $polaczenie->query("SELECT * FROM ksiazki WHERE kategoria LIKE '$kategoria' ORDER BY $sort_by ASC");
				}
				else
				{
					$ksiazki = $polaczenie->query("SELECT * FROM ksiazki WHERE kategoria LIKE '$kategoria' ORDER BY $sort_by DESC");
				}

				if($ksiazki)
				{
					//echo "<br> udane połączenie <br>";

					$ilosc_ksiazek = $ksiazki->num_rows;

					//echo "<br> ilosc_ksiazek -> $ilosc_ksiazek <br><br>";

					if($ilosc_ksiazek>0)
					{
						while ($row = $ksiazki->fetch_assoc()) 
						{
							    
						    //echo 'alert("nie");';
						  	//echo "console.log(".$row["id_autora"].");";					  	

						  	$_SESSION['tytul'] = $row["tytul"];
						  	$_SESSION['cena'] = $row["cena"];
						  	$_SESSION['rok_wydania'] = $row["rok_wydania"];

						  	echo $_SESSION['tytul'].", || ".$_SESSION['cena'].", || ".$_SESSION['rok_wydania']." ";						  	
						  	
						  	echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a><br><br>';	
						  	//echo '<a href="main.php?kategoria='.$kategoria.' ">asdsd</a>';

						  	//echo '<a href="main.php?kategoria='.$_SESSION['kategoria'].' ">'.$_SESSION['kategoria'].'</a><br><br>';	
						}

						$ksiazki->free_result(); // free() // close();				
						//$ksiazki->close(); // free() // close();				
					}
					else  // brak zwróconych rekordów
					{				
						// błędne dane logowanie -> przekierowanie do index.php + komunikat
						$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
						header('Location: index.php');		
						exit();		  
					}						
					
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

	function get_all_books_search($search_value) # get all books by search
	{
		//echo '<script>alert("502")</script>';
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
				//SELECT * FROM ksiazki WHERE tytul LIKE '%symfonia%'
				if($ksiazki = $polaczenie->query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%$search_value%'"))
				{
					//echo "<br> udane połączenie <br>";

					$ilosc_ksiazek = $ksiazki->num_rows;

					echo "<br> ilosc_ksiazek -> $ilosc_ksiazek <br><br>";

					if($ilosc_ksiazek>0)
					{
						while ($row = $ksiazki->fetch_assoc()) 
						{
							    
						    //echo 'alert("nie");';
						  	//echo "console.log(".$row["id_autora"].");";	
						  	

						  	$_SESSION['tytul'] = $row["tytul"];
						  	$_SESSION['cena'] = $row["cena"];
						  	$_SESSION['rok_wydania'] = $row["rok_wydania"];

						  	echo $_SESSION['tytul'].", || ".$_SESSION['cena'].", || ".$_SESSION['rok_wydania']." ";

						  	echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a><br><br>';	

						  	
						  	
						  	//echo '<a href="main.php?kategoria='.$kategoria.' ">asdsd</a>';

						  	//echo '<a href="main.php?kategoria='.$_SESSION['kategoria'].' ">'.$_SESSION['kategoria'].'</a><br><br>';	
						}

						$ksiazki->free_result(); // free() // close();				
						//$ksiazki->close(); // free() // close();				
					}
					else  // brak zwróconych rekordów
					{				
						// błędne dane logowanie -> przekierowanie do index.php + komunikat
						$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
						header('Location: index.php');		
						exit();		  
					}						
					
				}
				else 
				{
					//echo '<script>alert("Error")</script>';
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

	/////////////////////////////////////////////////////////////////////////////////////////////

	// Funkcja ustanawiająca połączenie z bazą danych i realizująca zapytanie sql
	// $query - zapytanie sql
    // $fun - funkcja wyświetlająca dane

	function query($query, $fun)
	{	
		$type = get_first_word($query); // type = SELECT, INSERT, ... etc

			//return "<br> query = ".$query.", type = ".$type."<br>";

		//////////////////////////////////////////////////////////////////////////////////////////////////////////
		
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
				if($result = $polaczenie->query($query)) // udane zapytanie
				{
					$num_of_rows = $result->num_rows; // ilość zwróconych wierszy					

					if($num_of_rows>0) // znaleziono rekordy ...
					{	
						/*$cat = "Wszystkie";
						echo '<a href="index.php?kategoria='.$cat.'">'.$cat.'</a><br><br>';
						while ($row = $result->fetch_assoc()) 
						{ 		  	
						  	echo '<a href="index.php?kategoria='.$row['kategoria'].' ">'.$row['kategoria'].'</a><br><br>';
						}
						$result->free_result(); // free() // close();		*/

						////////////////////////////////////////////////////////////////////////////////////////////////////


						//get_categories_($result);

						$fun($result);





					}
					else  // brak zwróconych rekordów
					{				
						$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
						header('Location: index.php');		
						exit();		  
					}						
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


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Księgarnia online</title>
	<link rel="stylesheet" href="style.css">

	<script>


		function moja_funkcja(sort_type, sort_by) // ta funkcja wyświetla: Ile jest książek w danej kategorii., sortuje dane
		{
			//sort_by - title, price, year ?

			//var alfabetycznie = document.getElementById("title_radio").value;
			//console.log("673->"+alfabetycznie);

			//var content_books__ = document.getElementById("content_books");
			//content_books__.innerHTML = "";


			// NOTE: WARTOŚCI -> TYTUł, CENA, ROK WYDANIA NIE MOGĄ SIĘ POWTARZAĆ

			const rbs = document.querySelectorAll('input[name="sortuj_wg"]');

			let selectedValue;

			for (const rb of rbs) 
			{
                if (rb.checked) 
                {
                    selectedValue = rb.value;
                    break;
                }
            }
            
            console.log("selectedValue ->"+selectedValue);


            number_of_child = document.getElementById("content_books").childElementCount;

            console.log("\n\nnumber_of_child->"+number_of_child);
			//last_book = document.getElementById("content_books").lastChild; 

			//var last_book_id = (last_book.id.substr(4));


			//last_book_id++; // <--- Ilość książek

			//alert("id ostatniej ksiazki -> " + last_book_id);

			// "Dostanie" się do każdego elementu - diva -> tytuł, cena, rok :

			/*

			<div id="content_books">

				<div id="book0" class="book">

					<div class="title">Title1</div>
					<div class="price">Price1</div>
					<div class="year">Year1</div>

				</div>

				<div id="book1" class="book">...</div>
				...
				<div id="book7" class="book">...</div>
			</div>

			*/

			var content_books = document.getElementById("content_books");
			// to jest div przechowujący wszystkie książki

			
			var books = new Array(number_of_child); // ! przechowuje divy -> book0, book1, ...
			var new_books = new Array(number_of_child); // to będą nowe divy - po podmianie

			var titles = new Array(number_of_child); // tytuły książek
			var prices = new Array(number_of_child); // ceny książek
			var years = new Array(number_of_child); // rok wydania książek

			var titles_org = new Array(number_of_child); // tytuły książek
			var prices_org = new Array(number_of_child); // ceny książek
			var years_org = new Array(number_of_child); // rok wydania książek


			for(var i=0; i<number_of_child; i++)
			{
				var book_id = "book";
				var book_id = book_id.concat(i); // id -> book0, book1 ...
				//console.log(book_id);

				var book_element = document.getElementById(book_id); // ✓ TO JEST DOBRZE ! 
				// element -> book0, book1, ...

				//var book_element_first_child = book_element.children[0];
				var book_element_title = book_element.querySelector('.title').innerHTML; // tytuł
				var book_element_price = book_element.querySelector('.price').innerHTML; // cena
				var book_element_year = book_element.querySelector('.year').innerHTML; // rok

				//console.log(book_element_title, book_element_price, book_element_year);
				

				books[i] = book_element; // ✓ TO JEST DOBRZE ! 
				//console.log(books[i]);

				/////////////////////////////////////////////////

				titles_org[i] = book_element_title;
				prices_org[i] = book_element_price;
				years_org[i] = book_element_year;



				titles[i] = book_element_title;
				prices[i] = book_element_price;
				years[i] = book_element_year;

				//console.log(titles[i], prices[i], years[i]);
				console.log("\n\ntytuły->" + titles[i]);
				
			}

			//console.log("\n\nbook_element_title->"+book_element_title);
			//console.log("\n\nbook_element_price->"+book_element_price);
			//console.log("\n\nbook_element_year->"+book_element_year);
		
			console.log("781");
			console.log("----------------------");
			console.log("----------------------");

			for(var x=0; x<number_of_child; x++)
			{
				console.log(books[x]);
			}

			for(var x=0; x<number_of_child; x++)
			{
				console.log(titles[x]);
			}

			for(var x=0; x<number_of_child; x++)
			{
				console.log(prices[x]);
			}

			for(var x=0; x<number_of_child; x++)
			{
				console.log(years[x]);
			}

			//return;


			/*for(var q=0; q<number_of_child; q++)
			{
				console.log("\n\nceny->" + prices[q]);
				
			}

			for(var q=0; q<number_of_child; q++)
			{
				console.log("\n\nlata->" + years[q]);
				
			}*/

			// teraz trzeba posortować te tablice :

			// titles[]	prices[] years[]

			console.log("\n");


			//titles_sorted = titles.sort(); 

			sort_type = "asc";


			if(sort_type == "asc") // sortowanie rosnąca - ASC
			{
				titles_sorted = titles.sort(); 

				//prices_sorted = prices.sort(); 
				//years_sorted = years.sort(); 

				prices_sorted = prices.sort(function(a, b) {
			        return a - b;
			    });

				years_sorted = years.sort(function(a, b) {
			        return a - b;
			    });




				//prices_sorted = prices.sort(); 
				//years_sorted = years.sort(); 
				
				for(var i=0; i<number_of_child; i++)
				{					
					console.log("866 tytuły posortowane->" + titles_sorted[i]);
				}

				for(var i=0; i<number_of_child; i++)
				{					
					console.log("ceny posortowane->" + prices_sorted[i]);
				}

				for(var i=0; i<number_of_child; i++)
				{					
					console.log("lata posortowane->" + years_sorted[i]);
				}
				//return;
			}
			else
			{
				titles_sorted = titles.sort(); 
				titles_sorted.reverse();

				prices_sorted = prices.sort(); 
				prices_sorted.reverse();

				years_sorted = years.sort(); 
				years_sorted.reverse();				
				
				for(var i=0; i<number_of_child; i++)
				{					
					console.log("tytuły posortowane->" + titles_sorted[i]);
				}
			}

			// po tym jak mam posortowane tablice z tytułem, ceną i rokiem : 

			var sorted_titles_id = new Array(number_of_child);
			var sorted_prices_id = new Array(number_of_child);
			var sorted_years_id = new Array(number_of_child);

			console.log("--------------------------------------");


			console.log("titles->"+titles_org);
			console.log("titles_sorted->"+titles_sorted);

			console.log("prices->"+prices_org);
			console.log("prices_sorted->"+prices_sorted);

			console.log("years->"+years_org);
			console.log("years_sorted->"+years_sorted);
			//return;
			var x = 0;

			console.log("\n titles_org[0] -> "+titles_org[0]);
			console.log("\n titles_sorted[0] -> "+titles_sorted[0]);
			//return;

			var k = 0;
			var q = 0;

			var zajete = new Array(10000);

			for(var i=0; i<number_of_child; i++)
			{
				for(var j=0; j<number_of_child; j++)
				{
					/*if(k>=i)
					{
						break;
					}*/

					/*var book_id = "book";
					var book_id = book_id.concat(j); // id -> book0, book1 ...
					//console.log(book_id);

					var book_element = document.getElementById(book_id); // ✓ TO JEST DOBRZE ! 
					// element -> book0, book1, ...

					//var book_element_first_child = book_element.children[0];
					var book_element_title = book_element.querySelector('.title').innerHTML; // tytuł
					var book_element_price = book_element.querySelector('.price').innerHTML; // cena
					var book_element_year = book_element.querySelector('.year').innerHTML; // rok*/








					if((titles_sorted[i] == titles_org[j]) && (sorted_titles_id.includes(j) == false))
					{
						sorted_titles_id[i] = j;

						//zajete[i] = j;



						//x++;
						//break;
					}

					/*if(prices_sorted[i] == prices_org[j])
					{
						sorted_prices_id[i] = j;	
						break;					
					}

					if((years_sorted[i] == years_org[j])&&(j!=zajete[zajete.length-1]))
					{
						sorted_years_id[k] = q;
						//x++;
						//break;
						// https://stackoverflow.com/questions/42070577/javascript-compare-two-arrays-and-return-index-of-matches

						zajete[k] = j;
						
						//j++;
						k++;
						q++;
					}*/

					//k++;
					

				}
				//k++;
				
			}

			//////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////


			console.log("\n\n---sorted_titles_id->");	

			for(var i=0; i<number_of_child; i++)
			{

				console.log(sorted_titles_id[i]);					
			}


			console.log("--------------------------------------");
			console.log("books->");

			for(var x=0; x<number_of_child; x++)
			{
				console.log(books[x]);
			}


			for(i=0; i<number_of_child; i++) // pętla po ilości książek
			{

					//console.log(books[i].querySelector('.title').innerHTML)
				//console.log(books[i].id.substr(4))
				//console.log(sorted_titles_id[i] + "\n\n")

				/*var book_id = "book";
				var book_id = book_id.concat(i); // id -> book0, book1 ...
					//console.log(book_id);

				var book_element = document.getElementById(book_id); // ✓ TO JEST DOBRZE !*/ 



				for(j=0; j<number_of_child; j++) // pętla po ilości książek
				{

					if(selectedValue == "tytul")
					{
						if(sorted_titles_id[i] == books[j].id.substr(4))
						{
							//console.log("-->"+books[j].id.substr(4));
							//console.log("-->"+books[j].id);
							//book_element.innerHTML = books[j].innerHTML;

							new_books[i] = books[j]
							//content_books_test.appendChild(books[j]);

							//book_element.innerHTML = books[j].innerHTML;

							//break;

						}
					}
					if(selectedValue == "cena")
					{
						if(sorted_prices_id[i] == books[j].id.substr(4))
						{
							//console.log("-->"+books[j].id.substr(4));
								//book_element = books[j];


							//content_books_test.appendChild(books[j]);

								//book_element.innerHTML = books[j].innerHTML;

							new_books[i] = books[j]
							//break;

						}
					}

					if(selectedValue == "rok_wydania")
					{
						if(sorted_years_id[i] == books[j].id.substr(4))
						{
							//console.log("-->"+books[j].id.substr(4));
							//book_element = books[j];



							//content_books_test.appendChild(books[j]);


							//console.log("\n1021->"+books[j].children[2].innerHTML);


							//book_elements[i].innerHTML = books[j].innerHTML;

							new_books[i] = books[j]
							//book_element.innerHTML = books[j].innerHTML;

							//break;

						}
					}




					

					
				}

			}


			console.log("new books->");

			for(var x=0; x<number_of_child; x++)
			{
				console.log(new_books[x]);
			}





			// podmiana divów : 
			

			for(i=0; i<number_of_child; i++) 
			{
				books[i] = new_books[i];				
			}
			

			console.log("--------------------------------------");
			console.log("books->");

			for(var x=0; x<number_of_child; x++)
			{
				console.log(books[x]);
			}

			/*console.log("\n\n books ->")

			for(i=0; i<=number_of_child; i++) 
			{
				books[i].innerHTML = new_books[i].innerHTML;	
			}*/


			content_books.innerHTML = "";

			for(i=0; i<number_of_child; i++) 
			{
				//content_books.appendChild(new_books[i]);
				content_books.appendChild(books[i]);
			}





































			return 1;





			for(var i=0; i<number_of_child; i++)
			{
				for(var j=0; j<number_of_child; j++)
				{
					/*if(k>=i)
					{
						break;
					}*/

					/*var book_id = "book";
					var book_id = book_id.concat(j); // id -> book0, book1 ...
					//console.log(book_id);

					var book_element = document.getElementById(book_id); // ✓ TO JEST DOBRZE ! 
					// element -> book0, book1, ...

					//var book_element_first_child = book_element.children[0];
					var book_element_title = book_element.querySelector('.title').innerHTML; // tytuł
					var book_element_price = book_element.querySelector('.price').innerHTML; // cena
					var book_element_year = book_element.querySelector('.year').innerHTML; // rok*/








					if((titles_sorted[i] == titles_org[j]) )
					{
						sorted_titles_id[i] = j;
						//x++;
						break;
					}

					if(prices_sorted[i] == prices_org[j])
					{
						sorted_prices_id[i] = j;	
						break;					
					}

					if((years_sorted[i] == years_org[j])&&(j!=zajete[zajete.length-1]))
					{
						sorted_years_id[k] = q;
						//x++;
						//break;
						// https://stackoverflow.com/questions/42070577/javascript-compare-two-arrays-and-return-index-of-matches

						zajete[k] = j;
						
						//j++;
						k++;
						q++;
					}
					//k++;
					

				}
				//k++;
				
			}
			
			console.log("\n\n---sorted_titles_id->");	

			for(var i=0; i<number_of_child; i++)
			{

				console.log(sorted_titles_id[i]);					
			}

			console.log("\n\n---sorted_prices_id->");	

			for(var i=0; i<number_of_child; i++)
			{

				console.log(sorted_prices_id[i]);					
			}

			console.log("\n\n---sorted_years_id->");	

			for(var i=0; i<number_of_child; i++)
			{

				console.log(sorted_years_id[i]);					
			}
			//return;

			console.log("--------------------------------------");
			console.log("--------------------------------------");
			
			//var content_books_test = document.getElementById("content_books");
			//var child_nodes = content_books_test.childNodes;
			//var c = document.getElementById("content_books").childNodes;
			


			/*var book_elements = new Array(number_of_child);

			for(i=0; i<number_of_child; i++)
			{
				var book_id = "book";
				var book_id = book_id.concat(i); // id -> book0, book1 ...
					//console.log(book_id);

				var book_element = document.getElementById(book_id); // ✓ TO JEST DOBRZE ! 

				book_elements[i] = book_element;
			}*/

			console.log("--------------------------------------");
			console.log("--------------------------------------");
			console.log("books->");

			for(var x=0; x<number_of_child; x++)
			{
				console.log(books[x]);
			}

			//return;
			for(i=0; i<number_of_child; i++) // pętla po ilości książek
			{

					//console.log(books[i].querySelector('.title').innerHTML)
				//console.log(books[i].id.substr(4))
				//console.log(sorted_titles_id[i] + "\n\n")

				/*var book_id = "book";
				var book_id = book_id.concat(i); // id -> book0, book1 ...
					//console.log(book_id);

				var book_element = document.getElementById(book_id); // ✓ TO JEST DOBRZE !*/ 



				for(j=0; j<number_of_child; j++) // pętla po ilości książek
				{

					if(selectedValue == "tytul")
					{
						if(sorted_titles_id[i] == books[j].id.substr(4))
						{
							//console.log("-->"+books[j].id.substr(4));
							//console.log("-->"+books[j].id);
							//book_element.innerHTML = books[j].innerHTML;

							new_books[i] = books[j]
							//content_books_test.appendChild(books[j]);

							//book_element.innerHTML = books[j].innerHTML;

							//break;

						}
					}
					if(selectedValue == "cena")
					{
						if(sorted_prices_id[i] == books[j].id.substr(4))
						{
							//console.log("-->"+books[j].id.substr(4));
								//book_element = books[j];


							//content_books_test.appendChild(books[j]);

								//book_element.innerHTML = books[j].innerHTML;

							new_books[i] = books[j]
							//break;

						}
					}

					if(selectedValue == "rok_wydania")
					{
						if(sorted_years_id[i] == books[j].id.substr(4))
						{
							//console.log("-->"+books[j].id.substr(4));
							//book_element = books[j];



							//content_books_test.appendChild(books[j]);


							//console.log("\n1021->"+books[j].children[2].innerHTML);


							//book_elements[i].innerHTML = books[j].innerHTML;

							new_books[i] = books[j]
							//book_element.innerHTML = books[j].innerHTML;

							//break;

						}
					}




					

					
				}














			}

			console.log("\n\n new books ->")

			for(i=0; i<number_of_child; i++) 
			{
				console.log(new_books[i]);
			}

			console.log("\n\n---sorted_years_id->");	

			for(var i=0; i<number_of_child; i++)
			{

				console.log(sorted_years_id[i]);					
			}


			console.log("\n\n---zajete->");	

			for(var i=0; i<number_of_child; i++)
			{

				console.log(zajete[i]);					
			}

			// podmiana divów : 


			

				/*for(i=0; i<number_of_child; i++) 
				{
					books[i] = new_books[i];				
				}*/
			

			/*console.log("\n\n books ->")

			for(i=0; i<=number_of_child; i++) 
			{
				books[i].innerHTML = new_books[i].innerHTML;	
			}*/


			/*content_books.innerHTML = "";

			for(i=0; i<number_of_child; i++) 
			{
				content_books.appendChild(new_books[i]);
			}*/

			

		}





	</script>




</head>

<body>

	<div id="container">
		
		<div id="header">
			<h1> Księgarnia internetowa </h1>
		</div>

		<div id="top-nav">

			<!-- <a href="index.php">Strona główna</a> -->

			<div id="div_search">				

				<form action="index.php" method="get">
					<!-- Wyszukaj : -->
					<input type="text" name="input_search">

					<input type="submit" value="Szukaj">	
				</form>	

			</div>

			<div id="div_log_in">
				
				<a class="top-nav-right" href="zaloguj.php">Zaloguj</a>

			</div>

			<div id="div_register">
				
				<a class="top-nav-right" href="rejestracja.php">Zarejestruj</a>
				
			</div>

			<div id="div_cart">
				
				<a class="top-nav-right" href="koszyk.php">Koszyk</a>
				
			</div>


			<div id="div_my_account">
				
				<a class="top-nav-right" href="account.php">Moje konto</a>
				
			</div>

		</div>

		<div id="nav">			

			<h3> Kategorie </h3>
			<hr>

			<?php
				get_categories(); // nav - wypis kategorii

				echo "<hr>";				
			?>

			<h3> Sortuj wg </h3>

				<!-- <input type="checkbox" name="data_wydania"> -->

				<!-- <label>
					<input type="checkbox" name="data_wydania"> 
						Data wydania
				</label> -->			

				<!--<form action="main.php" method="post">-->
			<!-- <form action="index.php" method="get">


												<?php
													//print_r($_SESSION['Kategorie_array']); // przechowuje kategorie
														//echo "<br> size -> ".count($_SESSION['Kategorie_array']);
													//echo "<br> size -> ".$_SESSION['ilosc_kategorii'];

													//echo "<br><br> --->" . array_values($_SESSION['Kategorie_array'])[6]."<br>"; // wartość konkretnego elementu tablicy
												?>

												
													<?php
														

														/*echo '<select name="select">';
														for($i = 0; $i < $_SESSION['ilosc_kategorii']; $i++) 
														{
														    //if ($value == $row['scpe_grades_status'])
														    //    echo '<option value="'.$value.'" selected>'.$key.'</option>';
														    //else

															$value = array_Values($_SESSION['Kategorie_array'])[$i];


													        echo '<option value="'.$value.'">'.$value.'</option>';
													        //echo $value . '<br>';
														}
														echo '</select>';
														*/

														

													?>
												  
												<?php
													//echo "<br>".$_GET['sortuj_wg']."<br>";
													//echo "<br>".$_GET['sortuj_typ']."<br>";

													/*if(isset($_GET['kategoria']))
													{
														echo '<input type="hidden" name="kategoria_h" value="'.$_GET['kategoria'].'">';
													}*/
												?>

				<br><br>

				<?php
					/*if(isset($_GET['kategoria']))
					{
						echo '<input type="hidden" name="kategoria" value="'.$_GET['kategoria'].'">';
					}*/				
				?>

				<input type="radio" name="sortuj_wg" value="tytul">
					Alfabetycznie<br>

				<input type="radio" name="sortuj_wg" value="cena">
					Cena<br>

				<input type="radio" name="sortuj_wg" value="rok_wydania">
					Data wydania<br>	

				<br><input type="radio" name="sortuj_typ" value="rosnaco">
					Rosnąco<br>

				<input type="radio" name="sortuj_typ" value="malejaco">
					Malejąco<br>

				<br><input type="submit" value="Sortuj">

			</form>	-->	

			

				<input id="title_radio" type="radio" name="sortuj_wg" value="tytul">
				<label for="title_radio">Alfabetycznie<br></label>

				<input id="cena_radio" type="radio" name="sortuj_wg" value="cena">
				<label for="cena_radio">Cena<br></label>

				<input id="rok_radio" type="radio" name="sortuj_wg" value="rok_wydania">
				<label for="rok_radio">Data wydania<br></label>

				<br><input type="radio" name="sortuj_typ" value="rosnaco">
					Rosnąco<br>

				<input type="radio" name="sortuj_typ" value="malejaco">
					Malejąco<br>

				<button id="sortowanie" onclick="moja_funkcja()">moja_funkcja</button>
				
			







		</div>

		<div id="content">

			<button onclick="moja_funkcja('asc')">moja_funkcja()</button>


			<?php			

				echo "<hr>";

				if(isset($_GET['kategoria']))
				{

					//echo '<script>alert("Kategoria jest ustawiona (GET)");</script>';

					$kategoria = $_GET['kategoria']; // <- przyczyna błędu. (już naprawionego ...)

						//$_SESSION['kategoria'] = "Horror";
						//$kategoria = $_SESSION['kategoria'];


					//echo "<br> kategoria -> ".$kategoria."<br>";
					//echo "<hr>";

					////////////////////////////////////////////////////////////////////////////////
					////////////////////////////////////////////////////////////////////////////////
					//echo "<br> Książki -><br><br>"; 
					echo '<div id="content_books">';

					// Sortowanie książek -> 
					if(isset($_GET['sortuj_wg'])) // index.php?sortuj_wg=tytul&sortuj_typ=rosnaco
					{
						//echo '<script>alert("680")</script>';
							//echo "<br> radio - jest ustawione<br>";

						$answer = $_GET['sortuj_wg']; // answer - opcja, która zostałą wybrana
						//echo radio_option_selected;
						
						if ($answer == "tytul") 
						{          
						    //echo 'tytul';   
						    $sort_by = $answer;
						}

						if ($answer == "cena") 
						{          
						    //echo 'cena';  
						    $sort_by = $answer;    
						}

						if ($answer == "rok_wydania") 
						{          
						    //echo 'data_wydania'; 
						    $sort_by = $answer;     
						}

						//echo $sort_by . "<br><br>";

						if(isset($_GET['sortuj_typ']))
						{

							$answer_typ = $_GET['sortuj_typ']; 
							
							if ($answer_typ == "rosnaco") 
							{          							    
							    $sort_typ = $answer_typ;
							}

							if ($answer_typ == "malejaco") 
							{          
							    $sort_typ = $answer_typ;
							}							

							get_all_books_sorted_and_category($kategoria, $sort_by, $sort_typ);
							echo "<br> $kategoria";
							echo "<br> $answer";
							echo "<br> $answer_typ";
						}
					}
					else
					{
						if($kategoria == "Wszystkie")
						{
							get_all_books();
						}
						else
						{
							//get_books_by_categories($kategoria); // funkcja wyświetlająca książki o danej kategorii 							

							echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '$kategoria'", "get_books_by_categories_");
						}
						
					}	

					echo '</div>';

					echo '<div id="content_books_test"></div>';

				}
				else // jeśli nie ustawiono kategorii ... ($_GET kategoria) -> Kategoria = "Wszystkie"
				{
					echo "<br> Książki -><br><br>"; 
					
					echo '<div id="content_books">';
					
					// Sortowanie książek -> 
					if(isset($_GET['sortuj_wg']))
					{
						//echo "<br> radio - jest ustawione<br>";

						$answer = $_GET['sortuj_wg']; // answer - opcja, która zostałą wybrana
						//echo radio_option_selected;
						
						if ($answer == "tytul") 
						{          
						    //echo 'tytul';   
						    $sort_by = $answer;
						}

						if ($answer == "cena") 
						{          
						    //echo 'cena';  
						    $sort_by = $answer;    
						}

						if ($answer == "rok_wydania") 
						{          
						    //echo 'data_wydania'; 
						    $sort_by = $answer;     
						}

						//echo $sort_by . "<br><br>";

						if(isset($_GET['sortuj_typ']))
						{

							$answer_typ = $_GET['sortuj_typ']; 
							
							if ($answer_typ == "rosnaco") 
							{          							    
							    $sort_typ = $answer_typ;
							}

							if ($answer_typ == "malejaco") 
							{          
							    $sort_typ = $answer_typ;
							}

							get_all_books_sorted($sort_by, $sort_typ);
						}								
					}
					else
					{
						if(isset($_GET['input_search']))
						{
							$search_value = $_GET['input_search'];

							//echo '<script>alert("901")</script>';
							get_all_books_search($search_value);

						}
						else
						{
							//get_all_books(); // wyświetl wszystkie książki


							/*include "t2.php";
							$zmienna = "123";
							echo my_fun($zmienna);*/

							echo query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories_");



							/*echo "<br>funkcja get_first_word -> <br>";

							echo get_first_word("SELECT ALL FROM DATABASE");*/






						}
						
					}
					echo '</div>';
				}





			?>	

		</div>		

		<div id="footer">

		</div>

	</div>


	
	
</body>
</html>