<?php

	session_start();

	include_once "functions.php";
	
	//echo $_SESSION['login'] . '<br>';

	/*if(isset($_SESSION['zalogowany']))
	{
		//echo '<br>'.$_SESSION['account_error'];
		unset($_SESSION['account_error']);
		//exit();
	}	

	if(isset($_SESSION['account_error']))
	{
		//echo '<br>'.$_SESSION['account_error'];
		echo '<script>alert("Musisz być zalogowanym aby przeglądać swoje konto!")</script>';
		//exit();
		unset($_SESSION['account_error']);
	}	*/

	if(!(isset($_SESSION['zalogowany'])))
	{
		header('Location: index.php');
		exit();
	}

	// takiego ifa, należy dodać do każdej podstrony do której ma dostęp zalogowany użytkownik
	/*if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}	*/

	/*function get_categories() 
	{
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

					$_SESSION['Kategorie_array'] = array();	

					if($ilosc_kategorii>0)
					{						

						$cat = "Wszystkie";

						echo '<a href="index.php?kategoria='.$cat.'">'.$cat.'</a><br><br>';	

						while ($row = $kategorie->fetch_assoc()) 
						{
							    
						    //echo 'alert("nie");';
						  	//echo "console.log(".$row["id_autora"].");";	
						  	

						  	$_SESSION['kategoria'] = $row["kategoria"];
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
	}*/

	/*function get_books_by_categories($kategoria) # get books by categories
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

				if($ksiazki = $polaczenie->query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '$kategoria'"))
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
	}*/

	/*function get_all_books() # get all books
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

				if($ksiazki = $polaczenie->query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki"))
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
	}*/

	/*function get_all_books_sorted($sort_by, $sort_typ) # get all books sorted
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
	}*/

	/*function get_all_books_search($search_value) # get all books by search
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
	}*/

	/*function get_books_by_id($id) # get books by categories
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

				if($ksiazki = $polaczenie->query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE id_ksiazki=$id"))
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

						  	//echo '<a href="koszyk_dodaj.php?id='.$row['id_ksiazki'].'">Dodaj do koszyka</a><br><br>';				  	
						  	
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
	}*/

	/*function add_product_to_cart($id_ksiazki, $quantity)	
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
	}*/

	/*function get_product_from_cart($id_klienta)	
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
                
                

				if($koszyk = $polaczenie->query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='$id_klienta'"))  
				{

					$ilosc_produktow = $koszyk->num_rows;					

					if($ilosc_produktow>0)
					{
						while ($row = $koszyk->fetch_assoc()) 
						{
							    
						    //echo 'alert("nie");';
						  	//echo "console.log(".$row["id_autora"].");";				  	

						  	
							//id_ksiazki -> 	$row['id_ksiazki']

						  	echo $row['tytul'].", || ".$row['cena'].", || ".$row['rok_wydania']." || <b> Ilość : </b> ".$row['ilosc']. "<br>";
						  	

						  	
						  	
						  	//echo '<a href="main.php?kategoria='.$kategoria.' ">asdsd</a>';

						  	//echo '<a href="main.php?kategoria='.$_SESSION['kategoria'].' ">'.$_SESSION['kategoria'].'</a><br><br>';	
						}

						$koszyk->free_result(); // free() // close();				
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
	}*/
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Księgarnia online</title>
	<link rel="stylesheet" href="style2.css">
	

</head>

<body>

	<div id="header_container">
		
		<!-- <div id="header_content"> -->

			<div id="sticky">

				<div id="top_header">

					<div id="top_header_content">

						<div id="header_title">
							
							Księgarnia internetowa

						</div>		
						
						<!--<div id="div_register">
							
							<a class="top-nav-right" href="zarejestruj.php">Zarejestruj</a>
							
						</div> -->

						<!-- <div id="div_log_in">
							
							<a class="top-nav-right" href="zaloguj.php">Zaloguj</a>

						</div> -->

						<ol>	

							<li>
								<a href="zarejestruj.php">Zarejestruj</a>
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
								
								<a class="top-nav-right" href="zarejestruj.php">Zarejestruj</a>
								
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

			<!-- 
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
				molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
				numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
				optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
				obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
				nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
				tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
				quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos 
				sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
				recusandae alias error harum maxime adipisci amet laborum. Perspiciatis 
				minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit  
			-->

			<h3> Kategorie </h3>
			<hr>

			<?php
				//get_categories(); // nav - wypis kategorii

				echo "<hr>";				
			?>

			<h3> Sortuj wg </h3>

			<!-- <input type="checkbox" name="data_wydania"> -->

			<!-- <label>
				<input type="checkbox" name="data_wydania"> 
					Data wydania
			</label> -->			

			<!--<form action="main.php" method="post">-->
			<form action="index.php" method="get">


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
					if(isset($_GET['kategoria']))
					{
						echo '<input type="hidden" name="kategoria" value="'.$_GET['kategoria'].'">';
					}					
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

			</form>		

		</div>

		<div id="content">

			<h3>Zamówienie</h3>		

			<hr>

			<?php 

				/*
					if((isset($_POST['id_ksiazki'])) and (isset($_POST['koszyk_ilosc']))) 
					{
						$id_ksiazki = $_POST['id_ksiazki'];
						$ilosc = $_POST['koszyk_ilosc'];

						echo '<hr>';

						//add_product_to_cart($id_ksiazki, $ilosc); // PODMIENIĆ NA UŻYCIE FUNKCJI QUERY ! 

						$values = array();

						array_push($id_ksiazki);
						array_push($ilosc);

						echo query("INSERT INTO koszyk (id_klienta, id_ksiazki, ilosc) VALUES ('$id_klienta', '$id_ksiazki', '$quantity')", "", $values); 
					}
					else
					{
						//get_product_from_cart($_SESSION['id']);

						$id_klienta = $_SESSION['id'];

						// (Koszyk) - // Książki które zamówił klient o danym ID :
						echo query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='$id_klienta'", "get_product_from_cart", $_SESSION['id']);
					}
				*/

				//get_product_from_cart($_SESSION['id']);

				$id_klienta = $_SESSION['id'];

				// (Koszyk) - // Książki które zamówił klient o danym ID :
				echo query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='$id_klienta'", "get_product_from_cart", $_SESSION['id']);

			?>

			<!-- <form action="order.php" method="post">

				<br>
					Wybierz formę dostawy :
				<br>

				<input type="radio" name="zamowienie_typ_dostawy" value="kurier_dpd">
					Kurier DPD<br>

				<input type="radio" name="zamowienie_typ_dostawy" value="kurier_inpost">
					Kurier Inpost<br>

				<input type="radio" name="zamowienie_typ_dostawy" value="odbior_inpost">
					Paczkomaty 24/7 (Inpost)<br>	

				<input type="radio" name="zamowienie_typ_dostawy" value="odbior_poczta">
					Odbiór w punkcie (Poczta polska)<br>

				<br>
					Wybierz typ płatności :
				<br>

				<input type="radio" name="zamowienie_typ_platnosci" value="blik">
					Blik<br>

				<input type="radio" name="zamowienie_typ_platnosci" value="pobranie">
					Pobranie<br>

				<input type="radio" name="zamowienie_typ_platnosci" value="karta_platnicza">
					Karta płatnicza (online)<br>	

				<br><input type="submit" value="Sortuj">

			</form> -->


			<?php

				/*if(isset($_POST['zamowienie_typ_dostawy']) && isset($_POST['zamowienie_typ_platnosci']))
				{
					$forma_dostawy = $_POST['zamowienie_typ_dostawy'];

					$forma_platnosci = $_POST['zamowienie_typ_platnosci'];
				}	*/


				/*$forma_dostawy = $_POST['zamowienie_typ_dostawy'];
				$forma_platnosci = $_POST['zamowienie_typ_platnosci'];

				echo "<br>forma_dostawy = " . $forma_dostawy . "<br>";
				echo "forma_platnosci = " . $forma_platnosci . "<br>";*/


				// Zamówienie - dane przesłane metodą POST 
							                       // name = zamowienie_typ_dostawy
				                                   // name = zamowienie_typ_platnosci

				if((isset($_POST['zamowienie_typ_dostawy'])) && (isset($_POST['zamowienie_typ_platnosci'])) 
					&& (!empty($_POST['zamowienie_typ_dostawy'])) && (!empty($_POST['zamowienie_typ_platnosci'])))	 	 
				{
					//echo "<h2>METODA POST - obie zmienne są ustawione i nie są puste</h2>";	
					/*echo "<br> zamowienie_typ_dostawy = " . $_POST['zamowienie_typ_dostawy'] . "<br>";
					echo "<br> zamowienie_typ_platnosci = " . $_POST['zamowienie_typ_platnosci'] . "<br>";
					exit();*/

					// wyświetli wartość atrybutu "value" - (input type radio)
					$forma_dostawy = $_POST['zamowienie_typ_dostawy']; // atrybut "value"	 
					$forma_platnosci = $_POST['zamowienie_typ_platnosci'];		

					$forma_dostawy = htmlentities($forma_dostawy, ENT_QUOTES, "UTF-8");
					$forma_platnosci = htmlentities($forma_platnosci, ENT_QUOTES, "UTF-8");
					
					echo "<br> forma_dostawy = " .$forma_dostawy. "<br>";
					echo "<br> forma_platnosci = " .$forma_platnosci. "<br>";				
					 
					/////////////////////////////////////////////////////////////////////

						// $datetime = new DateTime(); // obiekt klasy DateTime

					$datetime = new DateTimeImmutable(); // DateTimeImmutable - wywołanie metod na obiekcie DateTimeImmutable (np. add) - nie zmieni jego wartości (oryginalnej zmiennej) - w przeciwieństwie do DateTime.

						//$date = $data->format('d-m-Y H:i:s');
						//$datetime = $datetime->format('Y-m-d H:i:s'); // Data i czas serwera 
					                                              // 2022-10-04 13:45:26  <-- Format MySQL'owy

					//echo "<br> data i czas serwera = " . $datetime->format('Y-m-d H:i:s') . "<br>";
						//echo "<br> data i czas serwera = " . $datetime . "<br>";
						

						//echo "<br><br> Data i czas serwera : " . $data->format('d-m-Y H:i:s');
							//echo "<br> Pozostało premium: " . $pozostalo_dni->format('%y lata, %m mies, %d dni, %h godz, %i min, %s sek')   ;

					/*
						$d = $datetime->format('d');
						$m = $datetime->format('m');
						$Y = $datetime->format('Y');

						$H = $datetime->format('H');
						$i = $datetime->format('i');
						$s = $datetime->format('s');
					*/

									//$dzisiaj = $dzien."-".$miesiac."-".$rok." ".$godzina.":".$minuta;
					//$dzisiaj = $Y."-".$m."-".$d." ".$H.":".$i.":".$s;

									//if($result = $polaczenie->query("INSERT INTO zamowienia VALUES (NULL, '$_SESSION['id']', '$data_zlozenia_zamowienia', '$termin_dostawy', '$data_wyslania_zamowienia', '$data_dostarczenia', '$forma_dostarczenia', '$status')"))

					//$data_zlozenia_zamowienia = $dzisiaj;

					$data_zlozenia_zamowienia = $datetime->format('Y-m-d H:i:s'); // Data i czas serwera - format MySQL'owy

					// Data złożenia zamówienia : 
					echo "<br><br> Data złożenia zamówienia = " . $data_zlozenia_zamowienia ."<br>";


					//exit();

					// Termin dostawy
								//echo "<br><br> Termin dostawy : " . date('d-m-Y H:i', strtotime($date. ' +5 days'));
						//echo "<br><br> Termin dostawy : " . date('Y-m-d ', strtotime($date. ' +5 days'));
								//$termin_dostawy = date('d-m-Y H:i', strtotime($date. ' +5 days'));
						//$termin_dostawy = date('Y-m-d ', strtotime($date. ' +5 days'));

					$termin_dostawy = $datetime->add(new DateInterval('P5D')); // + 1 day
					$termin_dostawy = $termin_dostawy->format('Y-m-d');
					echo "<br> Termin dostawy = " . $termin_dostawy."<br>";    // ('Y-m-d H:i:s')


					//echo "<br><br> Data złożenia zamówienia = " . $datetime->format('Y-m-d H:i:s') ."<br>";
					//exit();
					// Data wysłania zamówienia
					//echo "<br><br>Data wysłania zamówienia : " . date('d-m-Y H:i', strtotime($date. ' +1 days'));	
						
					//$data_wyslania_zamowienia = date('d-m-Y H:i', strtotime($date. ' +1 days'));
					$data_wyslania_zamowienia = $datetime->add(new DateInterval('P1D'));
					$data_wyslania_zamowienia = $data_wyslania_zamowienia->format('Y-m-d H:i:s');
					echo "<br>Data wysłania zamówienia : " . $data_wyslania_zamowienia;		

					// Data dostarczenia zamówienia
					//echo "<br><br>Data dostarczenia zamówienia : " . date('Y-m-d', strtotime($date. ' +5 days'));		
					//echo "<br><br>Data dostarczenia zamówienia : " . date('Y-m-d', strtotime($date. ' +5 days'));	

					$data_dostarczenia_zamowienia = $datetime->add(new DateInterval('P5D'));
					$data_dostarczenia_zamowienia = $data_dostarczenia_zamowienia->format('Y-m-d');
					echo "<br><br>Data dostarczenia zamówienia : " . $data_dostarczenia_zamowienia;
					


					//$data_dostarczenia = date('d-m-Y H:i', strtotime($date. ' +5 days'));	
					//$data_dostarczenia = date('Y-m-d', strtotime($date. ' +5 days'));	

					// Data płatności
					//echo "<br><br>Data płatności : " . $dzisiaj ."<br>";

					$data_platnosci = $datetime->format('Y-m-d H:i:s');
					echo "<br><br> Data płatności = " . $data_platnosci ."<br>";

					

					/*
						if($forma_dostawy == "kurier_dpd")
						{
							$forma_dostawy = "Kurier DPD";
						}
						if($forma_dostawy == "kurier_inpost")
						{
							$forma_dostawy = "Kurier Inpost";
						}
						if($forma_dostawy == "odbior_inpost")
						{
							$forma_dostawy = "Paczkomaty 24/7 - Inpost";
						}
						if($forma_dostawy == "odbior_poczta")
						{
							$forma_dostawy = "Odbiór w punkcie (Poczta polska)";
						}

						if($forma_platnosci == "blik")
						{
							$forma_platnosci = "Blik";
						}
						if($forma_platnosci == "pobranie")
						{
							$forma_platnosci = "Pobranie";
						}
						if($forma_platnosci == "karta_platnicza")
						{
							$forma_platnosci = "Karta płatnicza";
						}
					*/

					

					$status_array = array("W trakcie realizacji", "Wysłano", "Dostarczono", "Zrealizowano/Zakończono");

					$status = $status_array[array_rand($status_array)];

					echo "<br><br>Forma dostawy = ". $forma_dostawy;


					echo "<br><br>Status = ". $status;
													

					echo "<br><br>Forma płatności = ". $forma_platnosci;				


					echo "<br><br>Suma zamówienia = ". $_SESSION['suma_zamowienia'];					

					////////////////////////////////////////////////////////////////////////////////////////////////////////////////


					echo "<br><br>->" . $_SESSION['id'];
					echo "<br>" . $data_zlozenia_zamowienia;
					echo "<br>" . $termin_dostawy;
					echo "<br>" . $data_wyslania_zamowienia;
					echo "<br>" . $data_dostarczenia_zamowienia;
					echo "<br>" . $forma_dostawy;
					echo "<br>" . $status;

					$suma_zamowienia = $_SESSION['suma_zamowienia'];

					

					//exit();

					////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					// Aktualizacja tabel: 		Zamowienia,  ✓		


					/*query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $id_klienta);

					query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $id_klienta);

					query("INSERT INTO koszyk (id_klienta, id_ksiazki, ilosc) VALUES ('%s', '%s', '%s')", "", $values); 

					query("INSERT INTO koszyk (id_klienta, id_ksiazki, ilosc) VALUES ('%s', '%s', '%s')", "", $values);  */

					echo "<br>id_klienta = " . $_SESSION['id'] . "<br>";

					$values = array();
					//array_push($values, NULL);
					array_push($values, $id_klienta);
					array_push($values, $data_zlozenia_zamowienia);
					array_push($values, $termin_dostawy);
					array_push($values, $data_wyslania_zamowienia);
					array_push($values, $data_dostarczenia_zamowienia);
					array_push($values, $forma_dostawy);
					array_push($values, $status);

						//query("INSERT INTO koszyk (id_klienta, id_ksiazki, ilosc) VALUES ('%s', '%s', '%s')", "", $values);  
					//query("INSERT INTO zamowienia (id_zamowienia , id_klienta , data_zlozenia_zamowienia, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, forma_dostarczenia, status) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "", $values);

					//query("INSERT INTO zamowienia (id_zamowienia, id_klienta, data_zlozenia_zamowienia, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, forma_dostarczenia, status) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "", $values);

					query("INSERT INTO zamowienia (id_zamowienia, id_klienta, data_zlozenia_zamowienia, termin_dostawy, data_wysłania_zamowienia, data_dostarczenia, forma_dostarczenia, status) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "get_last_order_id", $values); // dodaje nowe zamówienie - wstawia dane do tabeli "zamówienia", // pobiera ID nowo dodanego zamówienia (wiersza) -> $_SESSION['last_order_id']

					// id nowo wstawionego wiersza (id_zamowienia) (tabela zamówienia) :
					echo "<br> last id = " . $_SESSION['last_order_id'] . "<br>";

					

					//exit();

					////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					// Aktualizacja tabel: 		Płatności  ✓	


					unset($values);

					$values = array();

					array_push($values, $_SESSION['last_order_id']); // id_zamowienia
					array_push($values, $data_platnosci);
					array_push($values, $suma_zamowienia);
					array_push($values, $forma_platnosci);						

					query("INSERT INTO platnosci (id_platnosci, id_zamowienia, data_platnosci, kwota, sposob_platnosci) VALUES (NULL, '%s', '%s', '%s', '%s')", "", $values);

					//exit();

					////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// Aktualizacja tabel: 		Szczegóły zamówienia	(na podstawie tabeli KOSZYK)

					// Pobranie koszyka klienta (o danym id) - wstawienie do zmiennych sesyjnych : 

					/*$_SESSION['last_order_id']; // ✓ - id_zamowienia
					$_SESSION['id_ksiazki']; 
					$_SESSION[''];*/


					unset($values);
					//$values = array();
					//array_push($values, $id_klienta); // id_klienta
					//array_push($values, $_SESSION['last_order_id']); // id_zamowienia			

					//query("SELECT id_klienta, id_ksiazki, ilosc FROM koszyk WHERE id_klienta='%s'", "insert_order_details", $values); // wstawia dane do tabeli "szczegóły_zamowienia" - na podstawie tabeli koszyk - (zawartości koszyka danego klienta)

					query("SELECT id_klienta, id_ksiazki, ilosc FROM koszyk WHERE id_klienta='%s'", "insert_order_details", $id_klienta); // wstawia dane do tabeli "szczegóły_zamowienia" - na podstawie tabeli koszyk - (zawartości koszyka danego klienta)





					exit();

					////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
							$id_klienta = $_SESSION['id'];

							//$result = $polaczenie->query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC");
							if($ksiazki = $polaczenie->query(" INSERT INTO zamowienia VALUES (NULL, '$id_klienta', '$data_zlozenia_zamowienia', '$termin_dostawy', '$data_wyslania_zamowienia', '$data_dostarczenia_zamowienia', '$forma_dostawy', '$status')")   )  
							//if($result = $polaczenie->query("INSERT INTO zamowienia VALUES (NULL, '$_SESSION['id']', "23-07-2022", "28-07-2022", "24-07-2022", "28-07-2022", "Kurier DPD", "Wysłano")"))
							{
								//$ilosc_wierszy = $result->num_rows;
								//$_SESSION['ilosc_wierszy'] = $ilosc_wierszy; // przyda się ...
								//$_SESSION['Kategorie_array'] = array();	
								echo "<script>alert('kwerenda działa!')</script>";

								$last_id = $polaczenie->insert_id;
								echo "New record created successfully. Last inserted ID is: " . $last_id;
								exit();

								// aby pobrać id zamówienia (ostatniego) ...	 ->

								if($result = $polaczenie->query("SELECT * FROM zamowienia ORDER BY `id_zamowienia` DESC LIMIT 1"))  						
								{
									$ilosc_wierszy = $result->num_rows;									

									if($ilosc_wierszy>0)
									{		
										while ($row = $result->fetch_assoc()) 
										{											    
										   $_SESSION['id_zamowienia'] = $row["id_zamowienia"];
										   $id_zamowienia = $_SESSION['id_zamowienia'];
										}

										$result->free_result();													
									}
									else  // brak zwróconych rekordów
									{										
										$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
										header('Location: index.php');		
										exit();		  
									}
								}

								////////////////////////////////////////////////////////////////////////////////////////////////////////////////
								
								// Aktualizacja tabel: 		Płatności  ✓		

								$suma_zamowienia = $_SESSION['suma_zamowienia'];

								if($result = $polaczenie->query("INSERT INTO platnosci VALUES (NULL, '$id_zamowienia', '$dzisiaj', '$suma_zamowienia', '$forma_platnosci')"))					
								{									
									echo "<script>alert('dodano wpis do tabeli płatności')</script>";										
								}
								else 
								{
									throw new Exception($polaczenie->error);
								}

								////////////////////////////////////////////////////////////////////////////////////////////////////////////////
								// Aktualizacja tabel: 		Szczegóły zamówienia	(na podstawie tabeli KOSZYK)

								$id_klienta = $_SESSION['id'];

								if($result = $polaczenie->query("SELECT * FROM koszyk WHERE id_klienta=$id_klienta"))
								{
									$ilosc_wierszy = $result->num_rows;

									echo "<script>console.log('ilosc wierszy =');</script>";
									
									if($ilosc_wierszy>0)
									{						

										echo "<script>console.log('ilosc wierszy ='+".$ilosc_wierszy.");</script>";

										//echo '<a href="index.php?kategoria='.$cat.'">'.$cat.'</a><br><br>';	
										echo "<br><br>";

										while ($row = $result->fetch_assoc()) 
										{
											    
										    //echo 'alert("nie");';
										  	//echo "console.log(".$row["id_autora"].");";	
										  	
											echo $row['id_klienta'] . ", " .$row['id_ksiazki'] . ", " . $row['ilosc'] . "<br>";  

											//////////////////////////////////////////////////////////////////////////////////

											//if($ksiazki = $polaczenie->query(" INSERT INTO zamowienia VALUES (NULL, '$id_klienta', '$data_zlozenia_zamowienia', '$termin_dostawy', '$data_wyslania_zamowienia', '$data_dostarczenia', '$forma_dostawy', '$status')")   )  

											$id_ksiazki = $row['id_ksiazki'];
											$ilosc = $row['ilosc'];

											//if($result1 = $polaczenie->query(" INSERT INTO szczegoly_zamowienia VALUES (NULL, '$id_zamowienia', '$id_ksiazki', '$ilosc')"))
											if($result1 = $polaczenie->query(" INSERT INTO szczegoly_zamowienia VALUES ('$id_zamowienia', '$id_ksiazki', '$ilosc')"))
											{
												

												echo "<script>alert('udało się dodać wpis do tabeli szczegoly_zamowienia');</script>";
												
												
																
											}
											else 
											{
												throw new Exception($polaczenie->error);

											}






											//////////////////////////////////////////////////////////////////////////////////







										  	

										}

										$result->free_result(); // free() // close();				
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





















					echo "<br>id zamowienia ->" . $_SESSION['id_zamowienia'];






					exit(); // Zakończ dalsze wykonywanie skryptu ! 					
				}
				else
				{
					echo "<script>alert('Musisz wybrać typ dostawy i formę płatności !');</script>";
					//header('Location: index.php');
					//exit();
				}





			?>
		</div>		

		<div id="footer">

		</div>

	</div>


	
	
</body>
</html>