<?php	

				//session_start(); 	

				require_once "connect2.php"; 		

				$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);	

				$authors_names = array("Krystian", "Eustachy", "Lucjan", "Arkadiusz", "Juliusz", "Konrad", "Mikołaj", "Antoni", "Cyprian", "Mirosław", "Dawid", "Karol", "Patryk", "Oskar", "Patryk", "Milan", "Krzysztof", "Mateusz", "Fabian", "Ryszard", "Andrzej", "Eryk", "Dorian", "Amir", "Anatol", "Ksawery", "Maciej", "Miron", "Kajetan", "Amadeusz", "Heronim", "Aleksander", "Daniel", "Grzegorz", "Alan", "Henryk", "Kewin", "Martin", "Igor", "Igor", "Juliusz", "Konrad", "Patryk", "Klaudiusz", "Gniewomir", "Łukasz", "Robert", "Klaudiusz", "Allan", "Ernest", "Bruno", "Juliusz", "Alex", "Grzegorz", "Bogumił", "Denis", "Maksymilian", "Allan", "Jakub", "Dariusz", "Bronisław", "Marcel", "Marek", "Gracjan", "Artur", "Dobromił", "Maurycy", "Błażej", "Emanuel", "Ksawery", "Alek", "Leszek", "Heronim", "Robert", "Kordian", "Diego", "Emanuel", "Natan", "Kajetan", "Aleks", "Alexander", "Ernest", "Maksymilian", "Alek", "Marcin", "Jerzy", "Albert", "Radosław", "Cezary", "Jakub", "Jakub", "Arkadiusz", "Konstanty", "Miłosz", "Kuba", "Gabriel", "Mikołaj", "Denis", "Filip", "Alojzy", "Emil", "Alan", "Adrian", "Bartosz", "Dariusz", "Ryszard", "Julian", "Bogumił", "Jan", "Daniel", "Bronisław", "Kryspin", "Robert", "Kuba", "Maksymilian", "Jędrzej", "Eugeniusz", "Kuba", "Ernest", "Kazimierz", "Józef", "Dobromił", "Julian", "Piotr", "Anatol", "Gniewomir", "Daniel", "Mikołaj", "Robert", "Antoni", "Korneliusz", "Eugeniusz", "Radosław", "Mateusz", "Leonardo", "Krzysztof", "Olgierd", "Amadeusz", "Krystian", "Dawid", "Martin", "Adam", "Leszek", "Klaudiusz", "Arkadiusz", "Ariel", "Anastazy", "Mariusz", "Piotr", "Bogumił", "Jarosław", "Bolesław", "Błażej", "Kamil", "Henryk", "Kordian", "Maurycy", "Marcin", "Alfred", "Czesław", "Konstanty", "Eugeniusz", "Paweł", "Janusz", "Gabriel", "Kajetan", "Cyprian", "Artur", "Remigiusz", "Piotr", "Borys", "Leonardo", "Jarosław", "Marcin", "Denis", "Oskar", "Ignacy", "Gniewomir", "Czesław", "Henryk", "Patryk", "Przemysław", "Krystian", "Anastazy", "Emil", "Radosław", "Jerzy", "Miron", "Ludwik", "Alfred", "Kazimierz", "Diego", "Alexander", "Anatol", "Paweł", "Mirosław", "Cezary", "Denis", "Gracjan", "Norbert", "Oskar", "Albert", "Hubert", "Kamil", "Bronisław", "Miłosz", "Jacek", "Jakub", "Bartosz", "Ernest", "Oskar", "Bronisław", "Gniewomir", "Ksawery", "Oktawian", "Bartłomiej", "Jarosław", "Antoni", "Alojzy", "Janusz", "Ignacy", "Ernest", "Mirosław", "Emil", "Norbert", "Dawid", "Konstanty", "Cezary", "Kryspin", "Albert", "Amadeusz", "Korneliusz", "Eugeniusz", "Ludwik", "Krystian", "Konrad", "Anatol", "Alek", "Jarosław", "Daniel", "Grzegorz", "Ryszard", "Daniel", "Marcin", "Olaf", "Florian", "Łukasz", "Leszek", "Dorian", "Eugeniusz");

				$authors_surnames = array("Wysocki", "Pawlak", "Adamska", "Piotrowski", "Kaźmierczak", "Witkowski", "Borkowski", "Szewczyk", "Sikora", "Głowacka", "Piotrowski", "Adamska", "Pietrzak", "Zieliński", "Ostrowski", "Zalewski", "Dąbrowski", "Wysocki", "Wiśniewski", "Bąk", "Nowak", "Czerwiński", "Jaworski", "Głowacka", "Kowalczyk", "Szewczyk", "Michalak", "Jankowski", "Krajewska", "Wójcik", "Krawczyk", "Przybylski", "Pawlak", "Witkowski", "Lewandowski", "Sawicki", "Wróblewski", "Szczepański", "Maciejewski", "Baran", "Krupa", "Lewandowski", "Laskowska", "Gajewska", "Włodarczyk", "Borkowski", "Szulc", "Wasilewska", "Kołodziej", "Kowalczyk", "Zalewski", "Witkowski", "Makowski", "Kołodziej", "Jasiński", "Górski", "Brzeziński", "Wójcik", "Sikora", "Jasiński", "Laskowska", "Sokołowski", "Pawlak", "Duda", "Michalak", "Zieliński", "Krajewska", "Mazurek", "Kubiak", "Kwiatkowski", "Zawadzki", "Lewandowski", "Jankowski", "Mróz", "Błaszczyk", "Nowak", "Kowalski", "Ostrowski", "Witkowski", "Wójcik", "Cieślak", "Maciejewski", "Andrzejewski", "Duda", "Borkowski", "Mróz", "Andrzejewski", "Sadowska", "Borkowski", "Przybylski", "Andrzejewski", "Rutkowski", "Kaczmarczyk", "Szewczyk", "Szulc", "Lis", "Zakrzewska", "Zakrzewska", "Szulc", "Kozłowski", "Makowski", "Kwiatkowski", "Mazurek", "Wysocki", "Sikora", "Pietrzak", "Chmielewski", "Malinowski", "Lewandowski", "Szymański", "Szczepański", "Duda", "Czerwiński", "Górecki", "Andrzejewski", "Stępień", "Czarnecki", "Brzeziński", "Makowski", "Szymański", "Malinowski", "Wróblewski", "Sikora", "Kucharski", "Szczepański", "Szymański", "Adamska", "Laskowska", "Andrzejewski", "Baranowski", "Wójcik", "Kamiński", "Lewandowski", "Wróblewski", "Kozłowski", "Krawczyk", "Włodarczyk", "Jakubowski", "Borkowski", "Czerwiński", "Szewczyk", "Szulc", "Stępień", "Pietrzak", "Dąbrowski", "Duda", "Makowski", "Jakubowski", "Kucharski", "Kubiak", "Laskowska", "Chmielewski", "Jankowski", "Kołodziej", "Marciniak", "Szewczyk", "Jankowski", "Witkowski", "Cieślak", "Borkowski", "Sokołowski", "Brzeziński", "Tomaszewski", "Duda", "Kołodziej", "Zalewski", "Czerwiński", "Mazurek", "Sobczak", "Kamiński", "Borkowski", "Sawicki", "Wojciechowski", "Kucharski", "Adamska", "Bąk", "Stępień", "Maciejewski", "Błaszczyk", "Sikorska", "Jakubowski", "Wasilewska", "Mróz", "Marciniak", "Zalewski", "Mazur", "Wiśniewski", "Kozłowski", "Walczak", "Szymczak", "Marciniak", "Zakrzewska", "Jakubowski", "Kaczmarczyk", "Nowak", "Jakubowski", "Szczepański", "Pietrzak", "Andrzejewski", "Wiśniewski", "Chmielewski", "Woźniak", "Krawczyk", "Mazurek", "Szymański", "Duda", "Sobczak", "Baran", "Baranowski", "Sadowska", "Jankowski", "Walczak", "Lewandowski", "Chmielewski", "Zalewski", "Krupa", "Ziółkowska", "Jakubowski", "Laskowska", "Mazurek", "Ostrowski", "Nowak", "Szczepański", "Jakubowski", "Walczak", "Kołodziej", "Szczepański", "Baranowski", "Sobczak", "Szymański", "Brzeziński", "Wojciechowski", "Duda", "Lis", "Górecki", "Szulc", "Marciniak", "Rutkowski", "Szymczak", "Zalewski", "Czerwiński", "Piotrowski", "Lis", "Kowalski", "Zalewski", "Pawlak", "Michalak", "Pietrzak", "Kucharski", "Maciejewski");

				$okres_tworczosci = array("1980", "1981", "1982", "1983", "1984", "1985", "1986", "1987", "1988", "1989", "1990", "1991", "1992", "1993", "1994", "1995", "1996", "1997", "1998", "1999", "2000", "2001", "2002", "2003", "2004", "2005", "2006", "2007", "2008", "2009");

				//echo $okres_tworczosci[array_rand($okres_tworczosci)];	

				$authors_narodowosc = array("Polska");

				$rodzaj_tworczosci = array("Biografie", "Biznes, ekonomia, marketing", "Dla dzieci", "Dla młodzieży", "Fantastyka", "Horror", "Informatyka", "Komiks", "Kryminał", "Literatura techniczna", "Literatura naukowa", "Kuchnia i diety", "Lektury szkolne", "Literatura obyczajowa", "Nauka języków", "Podręczniki akademickie", "Podręczniki szkolne", "Poezja", "Poradniki", "Prawo", "Rozwój osobisty", "Turystyka i podróże");





				$ksiazki_dla_dzieci = array("Królik Zagadek", "Królik na Księżycu", "Duchy na Księżycu", "Ropuchy Marzeń", "Królowie i lisy", "Niemowlęta i myszy", "Okno Fantazji", "Kapelusz Excelsiora", "Niesamowite życie mojej rodziny", "Powrót z moją matką", "Księżniczka Ognia", "Mała kaczka w rzece", "Tygrysy mojego domu", "Niedźwiedzie Deszczu", "Duchy i lisy", "Szczenięta I Dzieci", "Świeca w lesie", "Miasto Księżyca", "Prezent od mojego kota", "Świętowanie wodą", "Mysz mojego domu", "Chłopiec moich marzeń", "Króliki Magii", "Psy Fantazji", "Psy i lisy", "Smoki i myszy", "Miasto Księżyca", "Światło gwiazd", "Zazdrosny o moją wyobraźnię", "Przygoda mojego przyjaciela");

				$ksiazki_fantastyka = array("Krasnolud Bogów", "Prześladowca bez sumienia", "Poszukiwacze epoki", "Żółwie Wieczności", "Kobiety i złodzieje", "Wrogowie i łowcy", "Klęska Szeptów", "Pochodzenie tajemnic", "Oślepiony w moim domu", "Witaj w moim kraju", "Jastrząb Złota", "Koń bez honoru", "Krasnoludy Zarazy", "Wrogowie z determinacją", "Roboty i Strażnicy", "Armie i trolle", "Jedność Wschodu", "Wieża Palisady", "Spotkanie w przyszłości", "Schronienie na świecie", "Człowiek z nieśmiertelnością", "Kość Natury", "Ludzie z kamienia", "Żołnierze Ognia", "Spadkobiercy i gobliny", "Węże i zaklinacze", "Drzewo Ziemi", "Nazwa Czasu", "Schronienie w magii", "Oślepieni w przeszłości");

				$ksiazki_horror = array("Kruk we mgle", "Sąsiad z uśmiechem", "Zombie z białymi włosami", "Wrony Góry", "Sępy i sępy", "Studenci i nietoperze", "Pokusa w antykwariacie", "Pokusa na cmentarzu", "Przetrwanie mojej śmierci", "Boi się dołów", "Gość w mojej szafie", "Mutant Nocy", "Sąsiedzi na moim dachu", "Obcy Nocy", "Drzewa i psy", "Demony i sępy", "Symbole w Bibliotece", "Praca nad rzeką", "Pokora na północy", "Trzęsąc się w oceanie", "Wybryk Piekła", "Duch Nocy", "Demony bez zębów", "Dzieci w mojej szafie", "Psy i szczury", "biesy i upiory", "Ręce w kryptach", "Ozdoby podczas Halloween", "Nawiedzony przez wzgórza", "Zepsuty w moich koszmarach");

				$ksiazki_kryminał = array("Żółw Przyszłości", "Najeźdźca oceanu", "Bogowie stworzenia", "Piloci nieznajomego", "Złodzieje i lekarze", "Upiory i wrogowie", "Wygląd w jeziorze", "Chmury Podziemia", "Rozbawiony moimi grzechami", "Niebezpieczeństwo złudzeń", "Królowa na moim podwórku", "Nieznajomy Bestii", "Upiory człowieka", "Nieznajomi z jeziora", "Drzewa i przestępcy", "Najeźdźcy i dziewczyny", "Ceremonia Mężczyzny", "Przypowieść w lesie", "Zło koszmarów", "Ukryty na Wschodzie", "Lew w mieście", "Rycerz Księżyca", "Bogowie Lasu", "Wrogowie gwiazdy", "Bohaterowie i psy", "Mężczyźni i ryby", "Przebudzenie w lesie", "Przewidywanie cieni", "Wyciszony przez wizje", "Nerwowy w moim domu");
				
				$ksiazki_komiks  = array("Zabójca Fortuny", "Najeźdźca utopii", "Ryba Opuszczonych", "Psy Nieba", "Niewolnicy i żołnierze", "Armie i szpiedzy", "Imię bez cła", "Krawędź wieczności", "Ratunek w kopalniach", "Biegnij na Zachód", "Dziedzic chwały", "Przeciwnik Przesilenia", "Armie bez nadziei", "Towarzysze rzeki", "Łowcy i Rycerze", "Bogowie i Rzeźnicy", "Pościg bez wstydu", "Wizja Zagubionych", "Wzmacnianie ciemności", "Rzuć wyzwanie słońcu", "Żółw Rzeczywistości", "Przeciwnik Zmierzchu", "Lekarze smutku", "Kobiety wielkości", "Drzewa i kapłani", "Żółwie i Pająki", "Wola Tęczy", "Pochodzenie wolności", "Krwawienie w mieście", "Śmierć w moim przeznaczeniu" );

				$ksiazki_poezja = array("Gość Wieczności", "Drogi bez strachu", "Kocha z zauroczeniem", "Kochanki Pragnienia", "Sąsiedzi i Miody", "Kochanki I Ukochane", "Źródło szaleństwa", "Wola Tęczy", "Porozmawiaj z jego przyjaciółmi", "Taniec z nim", "Zalotnik mojego podziwu", "Kolega o niebieskich oczach", "Mężowie świtu", "Anioły Gór", "Gołąbki i goście", "Mężowie i słudzy", "Korzeń fortuny", "Korzeń Morza", "Ukarana przez rodziców", "Nadzieja dla mojej dziewczyny", "Książę z zabawnymi skarpetkami", "Żona Radości", "Miody Z Piwnymi Oczami", "Motyle Romansu", "Prawdziwi kochankowie i zalotnicy", "Służący i chłopaki", "Rzeczywistość pasji", "Koniec Zachodu", "Zraniony przez tajemnice", "Stając się moim mężem");

				$rand_year = array(1,2,3,4,5,6,7,8,9,10);

				//echo $authors_names[array_rand($authors_names)] . "<br>";
				//echo $authors_surnames[array_rand($authors_surnames)] . "<br>";
				//echo $okres_tworczosci[array_rand($okres_tworczosci)] . "<br>";
				//echo $authors_narodowosc[array_rand($authors_narodowosc)] . "<br>";
				//echo $rodzaj_tworczosci[array_rand($rodzaj_tworczosci)] . "<br>";


				// Pobranie danych autora, potrzebnych do wstawienia książek - dane ksiazek zaleza od autora - rok, kategoria ksiazki.
				$authors_id = $polaczenie->query("SELECT id_autora, okres_tworczosci, rodzaj_tworczosci FROM autor");	

				//$ilosc_autorow = $authors_id->num_rows;				

				$id_autoroow_tablica = array();
				$okres_tworczosci_tablica = array();
				$rodzaj_tworczosci_tablica = array();

				/*if($ilosc_autorow>0) // == 1		
				{
					$row = $authors_id->fetch_assoc();

					$id_autora = $row['id_autora'];
					$okres_tworczosci = $row['okres_tworczosci'];
					$rodzaj_tworczosci = $row['rodzaj_tworczosci'];	

					echo $id_autora . " ";
					echo $okres_tworczosci. " ";
					echo $rodzaj_tworczosci. "<br><br>";
				}*/

				while ($row = $authors_id->fetch_assoc()) 
				{				    
				    //echo 'alert("nie");';
				    
				    $id_autora = $row['id_autora'];
					$okres_tworczosci = $row['okres_tworczosci'];
					$rodzaj_tworczosci = $row['rodzaj_tworczosci'];	

					echo $id_autora . " ";
					echo $okres_tworczosci. " ";
					echo $rodzaj_tworczosci. "<br><br>";	

					array_push($id_autoroow_tablica, $id_autora);
					array_push($okres_tworczosci_tablica, $okres_tworczosci);
					array_push($rodzaj_tworczosci_tablica, $rodzaj_tworczosci);
				}

				echo "<br>";

				//echo " 1 tablica -> ". print_r($id_autoroow_tablica[1]) . "<br><br>";
				echo " ". print_r($id_autoroow_tablica) . "<br><br>";
				echo " ". print_r($okres_tworczosci_tablica) . "<br><br>";
				echo "  ". print_r($rodzaj_tworczosci_tablica).  "<br><br>";
				//exit();

				/*for($i = 0; $i < $ilosc_autorow; $i++)
				{			
					echo "alert(".$id_autora($i).");";
					
				}*/

				//exit();

				$kategorie = array("Dla dzieci", "Fantastyka", "Horror", "Kryminał", "Komiks", "Poezja");

				$oprawa = array("Twarda", "Miękka");

				for($i = 0; $i < 23; $i++)
				{			
					//echo 'alert("2Tak");';

					$rand_ksiazki_dla_dzieci = $ksiazki_dla_dzieci[array_rand($ksiazki_dla_dzieci)];
					$rand_ksiazki_fantastyka = $ksiazki_fantastyka[array_rand($ksiazki_fantastyka)];
					$rand_ksiazki_horror= $ksiazki_horror[array_rand($ksiazki_horror)];
					$rand_ksiazki_kryminał = $ksiazki_kryminał[array_rand($ksiazki_kryminał)];
					$rand_ksiazki_komiks = $ksiazki_komiks[array_rand($ksiazki_komiks)];
					$rand_ksiazki_poezja = $ksiazki_poezja[array_rand($ksiazki_poezja)];


					$random_category = $kategorie[array_rand($kategorie)];

					//$random_category = "dla_dzieci";


					if($random_category == "Dla dzieci")
					{
						//echo "TaK ! ";
						// wybierz tylko te id autorów, którzy tworzą takie książki ->
						$authors_id_dzieci = $polaczenie->query("SELECT id_autora FROM autor WHERE rodzaj_tworczosci LIKE '%dzieci%'");	

						$result_array = array();						

						/*if($ilosc_autorow>0) // == 1		
						{
							$row = $authors_id->fetch_assoc();

							$id_autora = $row['id_autora'];
							$okres_tworczosci = $row['okres_tworczosci'];
							$rodzaj_tworczosci = $row['rodzaj_tworczosci'];	

							echo $id_autora . " ";
							echo $okres_tworczosci. " ";
							echo $rodzaj_tworczosci. "<br><br>";
						}*/

						while ($row = $authors_id_dzieci->fetch_assoc()) 
						{				    
						    //echo 'alert("nie");';						    
						    $id_autora_dla_dzieci = $row['id_autora'];					
							array_push($result_array, $id_autora_dla_dzieci);						
						}

						$rand_ksiazki = $ksiazki_dla_dzieci[array_rand($ksiazki_dla_dzieci)];
					}

					if($random_category == "Fantastyka")
					{
						// wybierz tylko te id autorów, którzy tworzą takie książki ->
						$authors_id_fantastyka = $polaczenie->query("SELECT id_autora FROM autor WHERE rodzaj_tworczosci LIKE '%fantastyka%'");	

						$result_array = array();			
						
						while ($row = $authors_id_fantastyka->fetch_assoc()) 
						{				    
						    //echo 'alert("nie");';
						    
						    $id_autora_fantastyka = $row['id_autora'];					
							array_push($result_array, $id_autora_fantastyka);						
						}

						$rand_ksiazki = $ksiazki_fantastyka[array_rand($ksiazki_fantastyka)];
					}

					if($random_category == "Horror")
					{
						// wybierz tylko te id autorów, którzy tworzą takie książki ->
						$authors_id_horror = $polaczenie->query('SELECT id_autora FROM autor WHERE rodzaj_tworczosci LIKE "%horror%"');	

						$result_array= array();			
						
						while ($row = $authors_id_horror->fetch_assoc()) 
						{				    
						    //echo 'alert("nie");';
						    
						    $id_autora_horror = $row['id_autora'];					
							array_push($result_array, $id_autora_horror);							
						}

						$rand_ksiazki = $ksiazki_horror[array_rand($ksiazki_horror)];
					}

					if($random_category == "Kryminał")
					{
						// wybierz tylko te id autorów, którzy tworzą takie książki ->
						$authors_id_kryminał = $polaczenie->query('SELECT id_autora FROM autor WHERE rodzaj_tworczosci LIKE "%kryminał%"');	

						$result_array =  array();			
						
						while ($row = $authors_id_kryminał->fetch_assoc()) 
						{				    
						    //echo 'alert("nie");';
						    
						    $id_autora_kryminał = $row['id_autora'];					
							array_push($result_array, $id_autora_kryminał);							
						}

						$rand_ksiazki = $ksiazki_kryminał[array_rand($ksiazki_kryminał)];
					}

					if($random_category == "Komiks")
					{
						// wybierz tylko te id autorów, którzy tworzą takie książki ->
						$authors_id_komiks = $polaczenie->query('SELECT id_autora FROM autor WHERE rodzaj_tworczosci LIKE "%komiks%"');	

						$result_array =  array();			
						
						while ($row = $authors_id_komiks->fetch_assoc()) 
						{				    
						    //echo 'alert("nie");';
						    
						    $id_autora_komiks = $row['id_autora'];					
							array_push($result_array, $id_autora_komiks);							
						}

						$rand_ksiazki = $ksiazki_komiks[array_rand($ksiazki_komiks)];
					}

					if($random_category == "Poezja")
					{
						// wybierz tylko te id autorów, którzy tworzą takie książki ->
						$authors_id_poezja = $polaczenie->query('SELECT id_autora FROM autor WHERE rodzaj_tworczosci LIKE "%poezja%"');	

						$result_array =  array();			
						
						while ($row = $authors_id_poezja->fetch_assoc()) 
						{				    
						    //echo 'alert("nie");';
						    
						    $id_autora_poezja = $row['id_autora'];					
							array_push($result_array, $id_autora_poezja);							
						}

						$rand_ksiazki = $ksiazki_poezja[array_rand($ksiazki_poezja)];
					}

					// result_array - przechowuje id autorów, zależnie od tego jaka wylosowana była kategoria.

					// kategorie - znamy ja. mamy ją wylosowaną.

					//$random_category

					//$result_array // tablica przechowująca id autorów (zależnie od wylosowanej kategori)	

					$random_author = $result_array[array_rand($result_array)];

					$okres_tworczosci_tego_autora = $polaczenie->query("SELECT okres_tworczosci FROM autor WHERE id_autora = '$random_author'");

					$row = $okres_tworczosci_tego_autora->fetch_assoc();

					$okres_tworczosci = $row['okres_tworczosci'];

					//$rand_ksiazki // przechowuje losowy tytul ksiazki (zależnie od wylosowanej kategori)

					$rand_cena = rand(1000,10000) / 100;

					$okres_tworczosci_rok = substr($okres_tworczosci, 0, 4);

					$oprawa_ = $oprawa[array_rand($oprawa)];

					$id_wydawcy = 1;

					$rok_wydania = $okres_tworczosci_rok + $rand_year[array_rand($rand_year)];

					$result = $polaczenie->query("INSERT INTO ksiazki (id_ksiazki, id_autora, tytul, cena, rok_wydania, kategoria, oprawa, id_wydawcy) VALUES (NULL, '$random_author', '$rand_ksiazki', '$rand_cena', '$rok_wydania', '$random_category', '$oprawa_', '$id_wydawcy')");	
				}

				/*$tablica_tablic = array($rand_ksiazki_dla_dzieci, $rand_ksiazki_fantastyka);

				echo '<br><br>';
				echo '<br><br>';
				echo '<br><br>';
				echo '<br><br>';
				echo '<br><br>';

				print_r($tablica_tablic[0]);*/

				echo "category = " . $random_category."<br>";

				echo "<br> -> id autorow -> <br>" ;				

				print_r($result_array);

				echo "<br> -> ksiazki -> <br>" ;

				print_r($rand_ksiazki);

				

				echo "<br> -> id autorow RAND -> <br>" ;				
			
				print_r($result_array[array_rand($result_array)]);

				echo "<br> -> rand_cena -> <br>" ;				
			
				echo $rand_cena;

				echo "<br> -> okres_tworczosci_tego_autora -> <br>" ;
			
				echo $okres_tworczosci;



				exit();
				
				//echo 'alert("Tak");';

				/*

					INSERT INTO 'ksiazki' ('idksiazki', 'id_autora', 'tytul', 'cena', 'rok_wydania', 'kategoria', 'oprawa', 'id_wydawcy') VALUES
					(1, 'Jan', 'Michalak', 'Zaawansowane programowanie w PHP', 47.29),
					(2, 'Andrzej', 'Krawczyk', 'Windows 8 PL. Zaawansowana administracja systemem', 49.99),
					(3, 'Paweł', 'Jakubowski', 'HTML5. Tworzenie witryn', 53.65),
					(4, 'Tomasz', 'Kowalski', 'Urządzenia techniki komputerowej', 34.15),
					(5, 'Łukasz', 'Pasternak', 'PHP. Tworzenie nowoczesnych stron WWW', 29.99);

					INSERT INTO ksiazki (id_ksiazki, id_autora, tytul, cena, rok_wydania, kategoria, oprawa, id_wydawcy) VALUES (NULL, id_autora, tytl, cena, rok_wydania, kategoria, oprawa, id_wydawcy)






					$cars = array("Volvo", "BMW", "Toyota");
					echo "I like " . $cars[0] . ", " . $cars[1] . " and " . $cars[2] . ".";

					authors_names = array("Korneliusz", "Jan", "Hubert", "Gabriel", "Grzegorz", "Damian", "Artur", "Korneliusz", "Mieszko", "Paweł", "Mirosław", "Konstanty", "Florian", "Alan", "Marcin", "Marian", "Ludwik", "Antoni", "Ireneusz", "Ernest", "Mieszko", "Arkadiusz", "Ariel", "Oktawian", "Czesław");

					authors_surnames = array("Walczak", "Walczak", "Jankowski", "Stępień", "Baran", "Wojciechowski", "Kozłowski", "Marciniak", "Krawczyk", "Mróz", "Błaszczyk", "Kaźmierczak", "Górski", "Krawczyk", "Lewandowski", "Chmielewski", "Szymczak", "Kołodziej", "Zieliński", "Sikorska", "Duda", "Rutkowski", "Lis", "Wójcik", "Marciniak");

					auuthors_narodowosc = array("Polska");

					auuthors_narodowosc = array("Polska");

					"1989", "1988", "1984", "1981", "1976", "2018", "1977", "1994", "1977", "1992", "1987", "1988", "1996", "2015", "1975", "1992", "1988", "1991", "1976", "1978", "1980", "1992", "1977", "2008", "2001"

				*/

			?>
