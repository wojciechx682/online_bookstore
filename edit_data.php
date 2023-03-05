<?php

	session_start();

	include_once "functions.php";

	if(!isset($_SESSION['zalogowany'])) // takiego ifa, należy dodać do każdej podstrony do której ma dostęp zalogowany użytkownik
	{
        //$_SESSION['account_error'] = true;

		header('Location: index.php');
		exit();
	}
?>


<!DOCTYPE HTML> <!-- HTML5 template consistent with the latest W3C standards -->
<html lang="pl">

<?php require "template/head.php"; ?>

<body>

<?php
    require "template/header-container.php"; // header template
?>

	<div id="container">

		<div id="nav">			

			<a href="edit_data.php">Edytuj dane użytkownika</a>

		</div>

		<div id="content">

			<?php

				echo '<script> displayNav(); </script>';

				echo "<p>Witaj ".$_SESSION['login'].'!' ;				
				
				echo "<p><b>Imię</b>: ".$_SESSION['imie'];
				echo "<p><b>Nazwisko</b>: ".$_SESSION['nazwisko'];
				echo "<p><b>Miejscowosc</b>: ".$_SESSION['miejscowosc'];
				echo "<p><b>Ulica</b>: ".$_SESSION['ulica'];
				echo "<p><b>numer_domu</b>: ".$_SESSION['numer_domu'];
				echo "<p><b>kod_pocztowy</b>: ".$_SESSION['kod_pocztowy'];
				echo "<p><b>kod_miejscowosc</b>: ".$_SESSION['kod_miejscowosc'];
				echo "<p><b>wojewodztwo</b>: ".$_SESSION['wojewodztwo'];
				echo "<p><b>kraj</b>: ".$_SESSION['kraj'];
				echo "<p><b>PESEL</b>: ".$_SESSION['PESEL'];
				echo "<p><b>data_urodzenia</b>: ".$_SESSION['data_urodzenia'];
				echo "<p><b>telefon</b>: ".$_SESSION['telefon'];
				echo "<p><b>email</b>: ".$_SESSION['email'];

			?>				

			<hr>
			<h3>Edytuj dane:</h3>

			<form method="post"> <!-- brak atrybutu action, ten sam formularz przetwarza dane -->

				Imie: <input type="text" name="name"><br><br>
				Nazwisko: <input type="text" name="surname"><br><br>
				Miasto: <input type="text" name="city"><br><br>
				Ulica: <input type="text" name="street"><br><br>
				Numer domu: <input type="text" name="house_number"><br><br>
				Kod pocztowy: <input type="text" name="post_code"><br><br>
				Miejscowość: <input type="text" name="city_code"><br><br>
				Województwo: <input type="text" name="province"><br><br>
				Kraj: <input type="text" name="country"><br><br>
				Pesel: <input type="text" name="pesel"><br><br>
				Data urodzenia: <input type="text" name="birth_date"><br><br>
				Telefon: <input type="text" name="phone"><br><br>
				Email: <input type="text" name="email"><br><br>
				Login: <input type="text" name="login"><br><br>

			<!-- <button onclick="test_fun()" >Test</button> -->

			<input type="submit" value="Edytuj dane">	 

			</form>
			
			<?php

				if( ((isset($_POST['name'])) && (!empty($_POST['name']))) &&   
					((isset($_POST['surname'])) && (!empty($_POST['name']))) &&     
					((isset($_POST['city'])) && (!empty($_POST['city']))) &&
					((isset($_POST['street'])) && (!empty($_POST['street']))) &&   
					((isset($_POST['house_number'])) && (!empty($_POST['house_number']))) &&    
					((isset($_POST['post_code'])) && (!empty($_POST['post_code']))) &&    
					((isset($_POST['city_code'])) && (!empty($_POST['city_code']))) &&    
					((isset($_POST['province'])) && (!empty($_POST['province']))) &&    
					((isset($_POST['country'])) && (!empty($_POST['country']))) &&    
					((isset($_POST['pesel'])) && (!empty($_POST['pesel']))) &&    
					((isset($_POST['birth_date'])) && (!empty($_POST['birth_date']))) &&    
					((isset($_POST['phone'])) && (!empty($_POST['phone']))) &&    
					((isset($_POST['email'])) && (!empty($_POST['email']))) &&    
					((isset($_POST['login'])) && (!empty($_POST['login'])))
				)
				{
					$imie = $_POST['name'];
					$nazwisko = $_POST['surname'];
					$miasto = $_POST['city'];
					$ulica = $_POST['street'];
					$numer_domu = $_POST['house_number'];
					$kod_pocztowy = $_POST['post_code'];
					$kod_miejscowosc = $_POST['city_code'];
					$wojewodztwo = $_POST['province'];
					$kraj = $_POST['country'];
					$pesel = $_POST['pesel'];
					$data_urodzenia = $_POST['birth_date'];
					$telefon = $_POST['phone'];
					$email = $_POST['email'];
					$login = $_POST['login'];
					$id = $_SESSION['id'];

						//echo "<br> Imie = ".$imie;

					echo "<br>id = ".$_SESSION['id'];
					echo "<br>";

					////////////////////////////////////////////////////////////////////////////////

					// WALIDACJA I SANITYZACJA DANYCH

					$imie = htmlentities($imie, ENT_QUOTES, "UTF-8"); // html entities = encje html'a
					$nazwisko = htmlentities($nazwisko, ENT_QUOTES, "UTF-8"); 
					$miasto = htmlentities($miasto, ENT_QUOTES, "UTF-8"); 
					$ulica = htmlentities($ulica, ENT_QUOTES, "UTF-8"); 
					$numer_domu = htmlentities($numer_domu, ENT_QUOTES, "UTF-8"); 
					$kod_pocztowy = htmlentities($kod_pocztowy, ENT_QUOTES, "UTF-8"); 
					$kod_miejscowosc = htmlentities($kod_miejscowosc, ENT_QUOTES, "UTF-8"); 
					$wojewodztwo = htmlentities($wojewodztwo, ENT_QUOTES, "UTF-8"); 
					$kraj = htmlentities($kraj, ENT_QUOTES, "UTF-8"); 
					$pesel = htmlentities($pesel, ENT_QUOTES, "UTF-8"); 
					$data_urodzenia = htmlentities($data_urodzenia, ENT_QUOTES, "UTF-8"); 
					$telefon = htmlentities($telefon, ENT_QUOTES, "UTF-8");
					$email = htmlentities($email, ENT_QUOTES, "UTF-8"); 
					$login = htmlentities($login, ENT_QUOTES, "UTF-8"); 					

					echo "<br><br>";
					echo "<br> Imie = ".$imie; 				// <script>alert('imie!')</script>
					echo "<br> nazwisko = ".$nazwisko; // <script>alert('nazwisko!')</script>
					echo "<br> miasto = ".$miasto; // <script>alert('miasto!')</script>
					echo "<br> ulica = ".$ulica; // <script>alert('ulica!')</script>
					echo "<br> numer_domu = ".$numer_domu; // <script>alert('numer_domu!')</script>
					echo "<br> kod_pocztowy = ".$kod_pocztowy; // <script>alert('kod_pocztowy!')</script>
					echo "<br> kod_miejscowosc = ".$kod_miejscowosc; // <script>alert('kod_miejscowosc!')</script>
					echo "<br> wojewodztwo = ".$wojewodztwo; // <script>alert('wojewodztwo!')</script>
					echo "<br> kraj = ".$kraj; // <script>alert('kraj!')</script> 
					echo "<br> pesel = ".$pesel; // <script>alert('pesel!')</script>
					echo "<br> data_urodzenia = ".$data_urodzenia; // <script>alert('data_urodzenia!')</script>
					echo "<br> telefon = ".$telefon; // <script>alert('telefon!')</script>
					echo "<br> email = ".$email; // <script>alert('email!')</script>
					echo "<br> login = ".$login; // <script>alert('login!')</script>
						
					//exit();

					/*$result = $polaczenie->query(
								sprintf("SELECT * FROM klienci WHERE login='%s'", mysqli_real_escape_string($result,$imie))
							)*/


					/*UPDATE klienci SET imie='$imie', nazwisko='$nazwisko', miejscowosc='$miasto', ulica='$ulica', numer_domu='$numer_domu', kod_pocztowy='$kod_pocztowy', kod_miejscowosc='$kod_miejscowosc', wojewodztwo='$wojewodztwo', kraj='$kraj', PESEL='$pesel', data_urodzenia='$data_urodzenia', telefon='$telefon', email='$email', login='$login' WHERE id_klienta='$id'*/

					//echo query(sprintf("SELECT * FROM klienci WHERE login='%s'", mysqli_real_escape_string($polaczenie,$login)), " ");

					//$query = "UPDATE klienci SET imie='%s' WHERE id_klienta='$id'";						

					//$query = sprintf("UPDATE klienci SET imie='%s' WHERE id_klienta='$id'", mysqli_real_escape_string($polaczenie, $imie));
					
					//$result = $polaczenie->query($query);

					//echo "<br> query = ".$query."<br>";
					//exit();

					//echo query($query, " ");

					//echo '<script>alert("Udało się zaktualizować dane :)")</script>';

					//exit();

					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					//echo query("INSERT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki", "get_all_books", "");

					//echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '%s'", "get_books_by_categories", $kategoria);

					//$values = "12345";
					
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					$values = array();					

					$imie = htmlentities($imie, ENT_QUOTES, "UTF-8"); // html entities = encje html'a
					$nazwisko = htmlentities($nazwisko, ENT_QUOTES, "UTF-8"); 
					$miasto = htmlentities($miasto, ENT_QUOTES, "UTF-8"); 
					$ulica = htmlentities($ulica, ENT_QUOTES, "UTF-8"); 
					$numer_domu = htmlentities($numer_domu, ENT_QUOTES, "UTF-8"); 
					$kod_pocztowy = htmlentities($kod_pocztowy, ENT_QUOTES, "UTF-8"); 
					$kod_miejscowosc = htmlentities($kod_miejscowosc, ENT_QUOTES, "UTF-8"); 
					$wojewodztwo = htmlentities($wojewodztwo, ENT_QUOTES, "UTF-8"); 
					$kraj = htmlentities($kraj, ENT_QUOTES, "UTF-8"); 
					$pesel = htmlentities($pesel, ENT_QUOTES, "UTF-8"); 
					$data_urodzenia = htmlentities($data_urodzenia, ENT_QUOTES, "UTF-8"); 
					$telefon = htmlentities($telefon, ENT_QUOTES, "UTF-8");
					$email = htmlentities($email, ENT_QUOTES, "UTF-8"); 
					$login = htmlentities($login, ENT_QUOTES, "UTF-8"); 

					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					array_push($values, $imie);
					array_push($values, $nazwisko);
					array_push($values, $miasto);
					array_push($values, $ulica);
					array_push($values, $numer_domu);
					array_push($values, $kod_pocztowy);
					array_push($values, $kod_miejscowosc);
					array_push($values, $wojewodztwo);
					array_push($values, $kraj);
					array_push($values, $pesel);
					array_push($values, $data_urodzenia);
					array_push($values, $telefon);
					array_push($values, $email);
					array_push($values, $login);

					/*echo "<br> values -> <br>";
					print_r($values);
					echo "<br> values size -> <br>";
					echo count($values);*/

					//exit();

					//echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '%s'", "get_books_by_categories", $kategoria);				

					echo query("UPDATE klienci SET imie='%s', nazwisko='%s', miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s', wojewodztwo='%s', kraj='%s', PESEL='%s', data_urodzenia='%s', telefon='%s', email='%s', login='%s' WHERE id_klienta='$id'", "", $values);

					////////////////////////////////////////////////////////////////////////////////
					// Aktualizacja zmiennych sesyjnych :
					$_SESSION['imie'] = $imie;		
					$_SESSION['nazwisko'] = $nazwisko;		
					$_SESSION['miejscowosc'] = $miasto;		
					$_SESSION['ulica'] = $ulica;		
					$_SESSION['numer_domu'] = $numer_domu;		
					$_SESSION['kod_pocztowy'] = $kod_pocztowy;		
					$_SESSION['kod_miejscowosc'] = $kod_miejscowosc;		
					$_SESSION['wojewodztwo'] = $wojewodztwo;
					$_SESSION['kraj'] = $kraj;		
					$_SESSION['PESEL'] = $pesel;		
					$_SESSION['data_urodzenia'] = $data_urodzenia;		
					$_SESSION['telefon'] = $telefon;		
					$_SESSION['email'] = $email;		
					$_SESSION['login'] = $login;
					////////////////////////////////////////////////////////////////////////////////


					//exit();
					echo "<br> -------------------------------------------------------------------------------------------------------- <br>";

					// $values - powinna być to tablica 
					//exit();

					//"UPDATE klienci SET imie='%s', nazwisko='%s', miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s', wojewodztwo='%s', kraj='%s', PESEL='%s', data_urodzenia='%s', telefon='%s', email='%s', login='%s' WHERE id_klienta='$id'", mysqli_real_escape_string($polaczenie, $imie), mysqli_real_escape_string($polaczenie, $nazwisko), mysqli_real_escape_string($polaczenie, $miasto), mysqli_real_escape_string($polaczenie, $ulica), mysqli_real_escape_string($polaczenie, $numer_domu), mysqli_real_escape_string($polaczenie, $kod_pocztowy), mysqli_real_escape_string($polaczenie, $kod_miejscowosc), mysqli_real_escape_string($polaczenie, $wojewodztwo), mysqli_real_escape_string($polaczenie, $kraj), mysqli_real_escape_string($polaczenie, $pesel), mysqli_real_escape_string($polaczenie, $data_urodzenia), mysqli_real_escape_string($polaczenie, $telefon), mysqli_real_escape_string($polaczenie, $email), mysqli_real_escape_string($polaczenie, $login) 

					/*require "connect.php";
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
							if ($result = $polaczenie->query(sprintf("UPDATE klienci SET imie='%s', nazwisko='%s', miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s', wojewodztwo='%s', kraj='%s', PESEL='%s', data_urodzenia='%s', telefon='%s', email='%s', login='%s' WHERE id_klienta='$id'", mysqli_real_escape_string($polaczenie, $imie), mysqli_real_escape_string($polaczenie, $nazwisko), mysqli_real_escape_string($polaczenie, $miasto), mysqli_real_escape_string($polaczenie, $ulica), mysqli_real_escape_string($polaczenie, $numer_domu), mysqli_real_escape_string($polaczenie, $kod_pocztowy), mysqli_real_escape_string($polaczenie, $kod_miejscowosc), mysqli_real_escape_string($polaczenie, $wojewodztwo), mysqli_real_escape_string($polaczenie, $kraj), mysqli_real_escape_string($polaczenie, $pesel), mysqli_real_escape_string($polaczenie, $data_urodzenia), mysqli_real_escape_string($polaczenie, $telefon), mysqli_real_escape_string($polaczenie, $email), mysqli_real_escape_string($polaczenie, $login) )))  // udane zapytanie
							{
								echo '<script>alert("udało się zmienić dane :)")</script>';
								//$result->free_result();									
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
						
						echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</div>';
						echo '<br><span style="color:red">Informacja developerska: </span>'.$e; // wyświetlenie komunikatu błędu - DLA DEWELOPERÓW
						exit(); // (?)
					}*/

				}
				else
				{
						//header('Location: index.php');
					//echo '<script>alert("Musisz wypełnić wszystkie pola !")</script>';
						//header('Location: edit_data.php');
					//exit();
				}

				

				//exit();

			?>

		</div>

<?php require "template/footer.php"; ?>

	</div>

</body>
</html>