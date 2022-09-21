<?php

	session_start();
	
	include_once "functions.php"; // _once - sprawdzi, czy ten plik nie został zaincludowany wcześniej	

	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}	

	/*if(isset($_SESSION['account_error']))
	{
		//echo '<br>'.$_SESSION['account_error'];
		echo '<script>alert("Musisz być zalogowanym aby przeglądać swoje konto!")</script>';
		//exit();
	}*/	

	function get_books_by_id_($id) 
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

	<div id="header_container">
		
		<!-- <div id="header_content"> -->

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

			<div id="top_nav">
				
				<div id="top_nav_content">

					<ol>
						
						<li>
							<a href="index.php">Strona główna</a>
							<div id="test123"></div>

						</li>
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

			<h3> Kategorie </h3>
			<hr>

			<?php
				//include_once "functions.php";
				echo query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories", ""); // nav - wypis kategorii	
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

			</form>	 -->	

		</div>

		<div id="content">

			<h3>Koszyk</h3>

			<?php			

				echo "<hr>";

				if(isset($_GET['id'])) // id_książki
				{
					//echo '<script>alert("660")</script>';

					$id_ksiazki = $_GET['id']; // <- przyczyna błędu. (już naprawionego ...)

					//$_SESSION['kategoria'] = "Horror";
					//$kategoria = $_SESSION['kategoria'];

					echo "<br> id_ksiazki -> ".$id_ksiazki."<br>";

					echo "<hr>";

					////////////////////////////////////////////////////////////////////////////////
					////////////////////////////////////////////////////////////////////////////////
					
					echo "<br>lp." . " 1 <br><br>"; 
					echo "<b>Produkt: </b> ";

					//get_books_by_id($id_ksiazki);		

					$id_ksiazki = htmlentities($id_ksiazki, ENT_QUOTES, "UTF-8"); 

					echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE id_ksiazki='%s'", "get_books_by_id", "$id_ksiazki");		

					///////////////////////////////////////////////////////

					echo '<form action="koszyk.php" method="post">';

							echo '<input type="hidden" name="id_ksiazki" value="'.$id_ksiazki.'">';

							echo "<b>Ilosc: </b> ";

							echo '<select name="koszyk_ilosc">';
							    echo '<option value="1">1</option>';
							    echo '<option value="2">2</option>';
							    echo '<option value="3">3</option>';
							    echo '<option value="4">4</option>';
							    echo '<option value="5">5</option>';
							echo '</select>';

					echo '<br><br><input type="submit" value="Zapisz koszyk">';
				}
			?>	

			

			<?php

				/*if((isset($_POST['id_ksiazki'])) and (isset($_POST['ilosc'])))
				{
					echo "<br> id_ksiazki -> ".$id_ksiazki.'<br>';
					echo "<br> ilosc -> ".$ilosc.'<br>';
				}*/
			?>


			<?php

				/*if((isset($_POST['koszyk_ilosc']))   ) 
				{
					echo '<script>alert("940")</script>';
					echo "<br> 929 id_ksiazki -> ".$_POST['id_ksiazki'].'<br>';
					echo "<br> ilosc -> ".$_POST['koszyk_ilosc'].'<br>';
				}*/

			?>



		</div>		

		<div id="footer">

		</div>

	</div>


	
	
</body>
</html>