<?php

	session_start();

	include_once "functions.php";
	
	//echo $_SESSION['login'] . '<br>';

	/*if(isset($_SESSION['zalogowany']))
	{
		//echo '<br>'.$_SESSION['account_error'];
		unset($_SESSION['account_error']);
		//exit();
	}	*/

	/*if(isset($_SESSION['account_error']))
	{
		//echo '<br>'.$_SESSION['account_error'];
		echo '<script>alert("Musisz być zalogowanym aby przeglądać swoje konto!")</script>';
		//exit();
		unset($_SESSION['account_error']);
	} */

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

			<h3>Koszyk</h3>		

			<hr>

			<?php 
				
				/*
					// WYRZUCIĆ TO ! 
					if((isset($_POST['id_ksiazki'])) and (isset($_POST['koszyk_ilosc']))) 
					{
						$id_ksiazki = $_POST['id_ksiazki'];
						$ilosc = $_POST['koszyk_ilosc'];

						echo '<hr>';

						add_product_to_cart($id_ksiazki, $ilosc);
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

			<form action="order.php" method="post">

				<br>
					Wybierz formę dostawy :
				<br>

				<input type="radio" id="dostawa_kurier_dpd" name="zamowienie_typ_dostawy" value="Kurier DPD"> <!-- value="kurier_dpd" -->
					Kurier DPD<br>
				<input type="radio" id="dostawa_kurier_inpost"  name="zamowienie_typ_dostawy" value="Kurier Inpost"> <!-- value="kurier_inpost" -->
					Kurier Inpost<br> 
				<input type="radio" id="odbior_paczkomaty_inpost" name="zamowienie_typ_dostawy" value="Paczkomaty 24/7 (Inpost)"> <!-- value="odbior_inpost" -->
					Paczkomaty 24/7 (Inpost)<br>	
				<input type="radio" id="odbior_poczta_polska" name="zamowienie_typ_dostawy" value="Odbiór w punkcie (Poczta polska)"> <!-- value="odbior_poczta" -->
					Odbiór w punkcie (Poczta polska)<br>

				<br>
					Wybierz typ płatności :
				<br>

				<input type="radio" name="zamowienie_typ_platnosci" value="Blik"> <!-- value="blik" -->
					Blik<br>

				<input type="radio" name="zamowienie_typ_platnosci" value="Pobranie"> <!-- value="pobranie" --> 
					Pobranie<br>

				<input type="radio" name="zamowienie_typ_platnosci" value="Karta płatnicza (online)"> <!-- value="karta_platnicza" -->
					Karta płatnicza (online)<br>	

				<br><input type="submit" value="Zamawiam">

			</form>

			<!-- <button onclick="test_order()">Wyswietl wartosci formularza</button> -->

		</div>		

		<div id="footer">

		</div>

	</div>
	
</body>
</html>