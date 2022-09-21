<?php

	session_start();
	
	// takiego ifa, należy dodać do każdej podstrony do której ma dostęp zalogowany użytkownik
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}	

	function get_categories() 
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

						echo '<a href="main.php?kategoria='.$cat.'">'.$cat.'</a><br><br>';	

						while ($row = $kategorie->fetch_assoc()) 
						{
							    
						    //echo 'alert("nie");';
						  	//echo "console.log(".$row["id_autora"].");";	
						  	

						  	$_SESSION['kategoria'] = $row["kategoria"];
						  	//echo "->".$_SESSION['kategoria'];

						  	//echo "<br>";
						  	
						  	//echo '<a href="main.php?kategoria='.$kategoria.' ">asdsd</a>';

						  	echo '<a href="main.php?kategoria='.$_SESSION['kategoria'].' ">'.$_SESSION['kategoria'].'</a><br><br>';	

						  	array_push($_SESSION['Kategorie_array'], $row["kategoria"]);

						}

						$kategorie->free_result(); // free() // close();				
						//$kategorie->close(); // free() // close();				
					}
					else  // brak zwróconych rekordów
					{				
						// błędne dane logowanie -> przekierowanie do index.php + komunikat
						$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
						header('Location: main.php');		
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

	function get_books_by_categories($kategoria) # get books by categories
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

				if($ksiazki = $polaczenie->query("SELECT tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '$kategoria'"))
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

						  	echo $_SESSION['tytul'].", || ".$_SESSION['cena'].", || ".$_SESSION['rok_wydania']."<br><br>";

						  	
						  	
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
						header('Location: main.php');		
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

	function get_all_books() # get all books
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

				if($ksiazki = $polaczenie->query("SELECT tytul, cena, rok_wydania, kategoria FROM ksiazki"))
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

						  	echo $_SESSION['tytul'].", || ".$_SESSION['cena'].", || ".$_SESSION['rok_wydania']."<br><br>";

						  	
						  	
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
						header('Location: main.php');		
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

						  	echo $_SESSION['tytul'].", || ".$_SESSION['cena'].", || ".$_SESSION['rok_wydania']."<br><br>";

						  	
						  	
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
						header('Location: main.php');		
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
		echo '<script>alert("get_all_books_sorted_and_category")</script>';

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

						  	echo $_SESSION['tytul'].", || ".$_SESSION['cena'].", || ".$_SESSION['rok_wydania']."<br><br>";

						  	
						  	
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
						header('Location: main.php');		
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

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Księgarnia online</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>

	<div id="container">


		<div id="header">
			<h1> Księgarnia internetowa </h1>
		</div>


		<div id="nav">

			<!-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
			molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
			numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
			optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
			obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
			nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
			tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
			quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos 
			sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
			recusandae alias error harum maxime adipisci amet laborum. Perspiciatis 
			minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit  -->

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
			<form action="main.php" method="get">


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

			<?php	
	
				//echo session_id(); 
				
				echo "<p>Witaj ".$_SESSION['login'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';
				echo "<br> Dane użytkownika : <br><br>";

				echo "<p><b>Imię</b>: ".$_SESSION['imie'];
				echo "<p><b>Nazwisko</b>: ".$_SESSION['nazwisko'];
				echo "<p><b>Pesel</b>: ".$_SESSION['pesel'];
				echo "<p><b>E-mail</b>: ".$_SESSION['email'];
				echo "<p><b>Login</b>: ".$_SESSION['login'];

				//echo " | <b>Kamień</b>: ".$_SESSION['kamien'];
				//echo " | <b>Zboże</b>: ".$_SESSION['zboze']."</p>";	
				//echo "<p><b>E-mail</b>: ".$_SESSION['email'];
				//echo " | <b>Dni premium</b>: ".$_SESSION['dnipremium']."</p>";	

				/*
				$_SESSION['id'] = $wiersz['id_klienta'];
				$_SESSION['imie'] = $wiersz['imie'];
				$_SESSION['nazwisko'] = $wiersz['nazwisko'];
				$_SESSION['pesel'] = $wiersz['pesel'];
				$_SESSION['email'] = $wiersz['email'];
				$_SESSION['login'] = $wiersz['login'];
				*/

				
				/*if(isset($_SESSION['kategoria']))
				{
					echo "<br><br> zmienna kategoria jest ustawiona -> <br>";
					echo $_SESSION['kategoria'];
					
				}*/


				echo "<hr>";

				if(isset($_GET['kategoria']))
				{
					echo '<script>alert("660")</script>';

					$kategoria = $_GET['kategoria']; // <- przyczyna błędu. (już naprawionego ...)

					//$_SESSION['kategoria'] = "Horror";
					//$kategoria = $_SESSION['kategoria'];


					echo "<br> kategoria -> ".$kategoria."<br>";


					echo "<hr>";

					////////////////////////////////////////////////////////////////////////////////
					////////////////////////////////////////////////////////////////////////////////
					echo "<br> Książki -><br><br>"; 

					// Sortowanie książek -> 
					if(isset($_POST['sortuj_wg']))
					{
						echo '<script>alert("660")</script>';
						//echo "<br> radio - jest ustawione<br>";

						$answer = $_POST['sortuj_wg']; // answer - opcja, która zostałą wybrana
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

						if(isset($_POST['sortuj_typ']))
						{

							$answer_typ = $_POST['sortuj_typ']; 
							
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
						get_books_by_categories($kategoria);
					}			








						
					


				}
				else
				{
					echo "<br> Książki -><br><br>"; 
					

					// Sortowanie książek -> 
					if(isset($_POST['sortuj_wg']))
					{
						//echo "<br> radio - jest ustawione<br>";

						$answer = $_POST['sortuj_wg']; // answer - opcja, która zostałą wybrana
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

						if(isset($_POST['sortuj_typ']))
						{

							$answer_typ = $_POST['sortuj_typ']; 
							
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
						get_all_books();
					}

				}


				






			?>	

		</div>		

		<div id="footer">

		</div>

	</div>


	
	
</body>
</html>