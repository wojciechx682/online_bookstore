<?php
    // dodać zabezpieczenie przed ponownym przesłaniem formularza (patrz /learn_php );

	session_start();
	include_once "functions.php";
    if(!(isset($_SESSION['zalogowany'])))
    {
        header("Location: index.php?login-error");
        exit();
    }
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "template\head.php"; ?>

<body>

<?php require "template\header-container.php"; ?>

	<div id="container">		

		<div id="nav">

		</div>

		<div id="content">

			<h3>Zamówienie</h3>		

			<hr>

			<?php

                $id_klienta = $_SESSION["id"];

				// query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $_SESSION['id']); // // Książki które zamówił klient o danym ID;

                if( (isset($_POST['zamowienie_typ_dostawy'])) &&
                    (isset($_POST['zamowienie_typ_platnosci'])) &&

                    (!empty($_POST['zamowienie_typ_dostawy'])) &&
                    (!empty($_POST['zamowienie_typ_platnosci']))
                  )
				{
//					echo "<h2>METODA POST - obie zmienne są ustawione i nie są puste</h2>";
//					echo "<br> zamowienie_typ_dostawy = " . $_POST['zamowienie_typ_dostawy'] . "<br>";
//					echo "<br> zamowienie_typ_platnosci = " . $_POST['zamowienie_typ_platnosci'] . "<br>";
//					exit();

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





					//exit();

					////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					//require_once "connect.php";

//					require "connect.php";
//
//					mysqli_report(MYSQLI_REPORT_STRICT);
//
//					try // spróbuj połączyć się z bazą danych
//					{
//						$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
//							// @ - operator kontroli błędów - w przypadku blędu, php nie wyświetla informacji o błędzie
//
//						// sprawdzamy, czy udało się połaczyć z bazą danych
//
//						if($polaczenie->connect_errno!=0) // błąd połączenia
//						{
//							// 0  = false           = udane połączenie
//							// !0 = true (1,2, ...) = błąd połączenia
//
//								//echo "[ Błąd połączenia ] (".$conn->connect_errno."), Opis: ".$conn->connect_error;
//							//echo "[ Błąd połączenia ] (".$polaczenie->connect_errno.") <br>";
//							throw new Exception(mysqli_connect_errno()); // rzuć nowy wyjątek
//						}
//						else // udane polaczenie
//						{
//							$id_klienta = $_SESSION['id'];
//
//							//$result = $polaczenie->query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC");
//							if($ksiazki = $polaczenie->query(" INSERT INTO zamowienia VALUES (NULL, '$id_klienta', '$data_zlozenia_zamowienia', '$termin_dostawy', '$data_wyslania_zamowienia', '$data_dostarczenia_zamowienia', '$forma_dostawy', '$status')")   )
//							//if($result = $polaczenie->query("INSERT INTO zamowienia VALUES (NULL, '$_SESSION['id']', "23-07-2022", "28-07-2022", "24-07-2022", "28-07-2022", "Kurier DPD", "Wysłano")"))
//							{
//								//$ilosc_wierszy = $result->num_rows;
//								//$_SESSION['ilosc_wierszy'] = $ilosc_wierszy; // przyda się ...
//								//$_SESSION['Kategorie_array'] = array();
//								echo "<script>alert('kwerenda działa!')</script>";
//
//								$last_id = $polaczenie->insert_id;
//								echo "New record created successfully. Last inserted ID is: " . $last_id;
//								exit();
//
//								// aby pobrać id zamówienia (ostatniego) ...	 ->
//
//								if($result = $polaczenie->query("SELECT * FROM zamowienia ORDER BY `id_zamowienia` DESC LIMIT 1"))
//								{
//									$ilosc_wierszy = $result->num_rows;
//
//									if($ilosc_wierszy>0)
//									{
//										while ($row = $result->fetch_assoc())
//										{
//										   $_SESSION['id_zamowienia'] = $row["id_zamowienia"];
//										   $id_zamowienia = $_SESSION['id_zamowienia'];
//										}
//
//										$result->free_result();
//									}
//									else  // brak zwróconych rekordów
//									{
//										$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
//										header('Location: index.php');
//										exit();
//									}
//								}
//
//								////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//								// Aktualizacja tabel: 		Płatności  ✓
//
//								$suma_zamowienia = $_SESSION['suma_zamowienia'];
//
//								if($result = $polaczenie->query("INSERT INTO platnosci VALUES (NULL, '$id_zamowienia', '$dzisiaj', '$suma_zamowienia', '$forma_platnosci')"))
//								{
//									echo "<script>alert('dodano wpis do tabeli płatności')</script>";
//								}
//								else
//								{
//									throw new Exception($polaczenie->error);
//								}
//
//								////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//								// Aktualizacja tabel: 		Szczegóły zamówienia	(na podstawie tabeli KOSZYK)
//
//								$id_klienta = $_SESSION['id'];
//
//								if($result = $polaczenie->query("SELECT * FROM koszyk WHERE id_klienta=$id_klienta"))
//								{
//									$ilosc_wierszy = $result->num_rows;
//
//									echo "<script>console.log('ilosc wierszy =');</script>";
//
//									if($ilosc_wierszy>0)
//									{
//
//										echo "<script>console.log('ilosc wierszy ='+".$ilosc_wierszy.");</script>";
//
//										//echo '<a href="index.php?kategoria='.$cat.'">'.$cat.'</a><br><br>';
//										echo "<br><br>";
//
//										while ($row = $result->fetch_assoc())
//										{
//
//										    //echo 'alert("nie");';
//										  	//echo "console.log(".$row["id_autora"].");";
//
//											echo $row['id_klienta'] . ", " .$row['id_ksiazki'] . ", " . $row['ilosc'] . "<br>";
//
//											//////////////////////////////////////////////////////////////////////////////////
//
//											//if($ksiazki = $polaczenie->query(" INSERT INTO zamowienia VALUES (NULL, '$id_klienta', '$data_zlozenia_zamowienia', '$termin_dostawy', '$data_wyslania_zamowienia', '$data_dostarczenia', '$forma_dostawy', '$status')")   )
//
//											$id_ksiazki = $row['id_ksiazki'];
//											$ilosc = $row['ilosc'];
//
//											//if($result1 = $polaczenie->query(" INSERT INTO szczegoly_zamowienia VALUES (NULL, '$id_zamowienia', '$id_ksiazki', '$ilosc')"))
//											if($result1 = $polaczenie->query(" INSERT INTO szczegoly_zamowienia VALUES ('$id_zamowienia', '$id_ksiazki', '$ilosc')"))
//											{
//
//
//												echo "<script>alert('udało się dodać wpis do tabeli szczegoly_zamowienia');</script>";
//
//
//
//											}
//											else
//											{
//												throw new Exception($polaczenie->error);
//
//											}
//											//////////////////////////////////////////////////////////////////////////////////
//
//										}
//
//										$result->free_result(); // free() // close();
//										//$kategorie->close(); // free() // close();
//									}
//									else  // brak zwróconych rekordów
//									{
//										// błędne dane logowanie -> przekierowanie do index.php + komunikat
//										$_SESSION['blad'] = '<span style="color: red">Nie udało się pobrać danych z bazy danych !</span>';
//										header('Location: index.php');
//										exit();
//									}
//								}
//								else
//								{
//									throw new Exception($polaczenie->error);
//
//								}
//							}
//							else
//							{
//								throw new Exception($polaczenie->error);
//
//							}
//
//							$polaczenie->close();
//						}
//					}
//					catch(Exception $e) // Exception - wyjątek
//					{
//						//echo '<span style="color: red;"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</span>';
//
//						echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności i prosimy o rejestrację w innym terminie! ]</div>';
//
//						echo '<br><span style="color:red">Informacja developerska: </span>'.$e; // wyświetlenie komunikatu błędu - DLA DEWELOPERÓW
//						exit(); // (?)
//					}
//
//					echo "<br>id zamowienia ->" . $_SESSION['id_zamowienia'];
//
//					exit(); // Zakończ dalsze wykonywanie skryptu !
				}
				else
				{
					echo "<script>alert('Musisz wybrać typ dostawy i formę płatności !');</script>";
					//header('Location: index.php');
					//exit();
				}
			?>

		</div>

        <?php require "template/footer.php"; ?>

	</div>


	
	
</body>
</html>