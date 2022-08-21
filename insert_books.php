
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Księgarnia online</title>
	<link rel="stylesheet" href="style.css">	
</head>

<body>

	Księgarnia online<br><br>
	
	
	<?php
		
		//session_start();

		//$var = "You've clicked me !";

	?>

	<button onclick="my_function()"> Wstaw książki do bazy do bazy </button>

	<p id="demo"></p>

	<script>

		function my_function() 
		{
			//document.getElementById("demo").innerHTML = "<?php echo $var; ?>";

			<?php
				//echo 'alert("Tak");';
			?>

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

				$ksiazki_dla_kryminał = array("Żółw Przyszłości", "Najeźdźca oceanu", "Bogowie stworzenia", "Piloci nieznajomego", "Złodzieje i lekarze", "Upiory i wrogowie", "Wygląd w jeziorze", "Chmury Podziemia", "Rozbawiony moimi grzechami", "Niebezpieczeństwo złudzeń", "Królowa na moim podwórku", "Nieznajomy Bestii", "Upiory człowieka", "Nieznajomi z jeziora", "Drzewa i przestępcy", "Najeźdźcy i dziewczyny", "Ceremonia Mężczyzny", "Przypowieść w lesie", "Zło koszmarów", "Ukryty na Wschodzie", "Lew w mieście", "Rycerz Księżyca", "Bogowie Lasu", "Wrogowie gwiazdy", "Bohaterowie i psy", "Mężczyźni i ryby", "Przebudzenie w lesie", "Przewidywanie cieni", "Wyciszony przez wizje", "Nerwowy w moim domu");
				
				$ksiazki_dla_komiks  = array("Zabójca Fortuny", "Najeźdźca utopii", "Ryba Opuszczonych", "Psy Nieba", "Niewolnicy i żołnierze", "Armie i szpiedzy", "Imię bez cła", "Krawędź wieczności", "Ratunek w kopalniach", "Biegnij na Zachód", "Dziedzic chwały", "Przeciwnik Przesilenia", "Armie bez nadziei", "Towarzysze rzeki", "Łowcy i Rycerze", "Bogowie i Rzeźnicy", "Pościg bez wstydu", "Wizja Zagubionych", "Wzmacnianie ciemności", "Rzuć wyzwanie słońcu", "Żółw Rzeczywistości", "Przeciwnik Zmierzchu", "Lekarze smutku", "Kobiety wielkości", "Drzewa i kapłani", "Żółwie i Pająki", "Wola Tęczy", "Pochodzenie wolności", "Krwawienie w mieście", "Śmierć w moim przeznaczeniu" );

				$ksiazki_dla_poezja = array("Gość Wieczności", "Drogi bez strachu", "Kocha z zauroczeniem", "Kochanki Pragnienia", "Sąsiedzi i Miody", "Kochanki I Ukochane", "Źródło szaleństwa", "Wola Tęczy", "Porozmawiaj z jego przyjaciółmi", "Taniec z nim", "Zalotnik mojego podziwu", "Kolega o niebieskich oczach", "Mężowie świtu", "Anioły Gór", "Gołąbki i goście", "Mężowie i słudzy", "Korzeń fortuny", "Korzeń Morza", "Ukarana przez rodziców", "Nadzieja dla mojej dziewczyny", "Książę z zabawnymi skarpetkami", "Żona Radości", "Miody Z Piwnymi Oczami", "Motyle Romansu", "Prawdziwi kochankowie i zalotnicy", "Służący i chłopaki", "Rzeczywistość pasji", "Koniec Zachodu", "Zraniony przez tajemnice", "Stając się moim mężem");

				$rand_year = array(1,2,3,4,5,6,7,8,9,10);

				//echo $authors_names[array_rand($authors_names)] . "<br>";
				//echo $authors_surnames[array_rand($authors_surnames)] . "<br>";
				//echo $okres_tworczosci[array_rand($okres_tworczosci)] . "<br>";
				//echo $authors_narodowosc[array_rand($authors_narodowosc)] . "<br>";
				//echo $rodzaj_tworczosci[array_rand($rodzaj_tworczosci)] . "<br>";


				$authors_id = $polaczenie->query("SELECT id_autora, okres_tworczosci, rodzaj_tworczosci FROM autor");		

				$ilosc_autorow = $authors_id->num_rows;
				
				/*if($ilosc_autorow>0) // == 1		(znaleziono usera o takim loginie)
				{
					$row = $authors_id->fetch_assoc();

					$id_autora = $row['id_autora'];
					$okres_tworczosci = $row['okres_tworczosci'];
					$rodzaj_tworczosci = $row['rodzaj_tworczosci'];	
				}*/

				while ($row = mysql_fetch_assoc($ilosc_autorow)) 
				{
				    
				    echo 'alert("nie");';
				    //echo "console.log(".$row["id_autora"].");";

				    
				}

				exit();

				for($i = 0; $i < $ilosc_autorow; $i++)
				{			
					echo "alert(".$id_autora($i).");";					
				}

				exit();


				for($i = 0; $i < 25; $i++)
				{			
					//echo 'alert("2Tak");';

					$rand_name = $authors_names[array_rand($authors_names)];
					$rand_surname = $authors_surnames[array_rand($authors_surnames)];
					$rand_okres= $okres_tworczosci[array_rand($okres_tworczosci)];
					$rand_okres2= $rand_okres+$rand_year[array_rand($rand_year)];
					$rand_narod = $authors_narodowosc[array_rand($authors_narodowosc)];
					$rand_rodzaj = $rodzaj_tworczosci[array_rand($rodzaj_tworczosci)];

					$result = $polaczenie->query("INSERT INTO ksiazki (id_ksiazki, id_autora, nazwisko, narodowosc, okres_tworczosci, rodzaj_tworczosci) VALUES (NULL, '$rand_name', '$rand_surname', '$rand_narod', '$rand_okres-$rand_okres2', '$rand_rodzaj')");		
				}
				
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

			
		}

	</script>	
	
</body>
</html>





