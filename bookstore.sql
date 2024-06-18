-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 18, 2024 at 02:35 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `address`
--

CREATE TABLE `address` (
  `adres_id` int(11) NOT NULL,
  `miejscowosc` varchar(255) NOT NULL,
  `ulica` varchar(255) DEFAULT NULL,
  `numer_domu` varchar(25) NOT NULL,
  `kod_pocztowy` varchar(25) NOT NULL,
  `kod_miejscowosc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`adres_id`, `miejscowosc`, `ulica`, `numer_domu`, `kod_pocztowy`, `kod_miejscowosc`) VALUES
(32, 'Dębno', 'Mickiewicza', '52', '74-400', 'Dębno'),
(33, 'Chojna', 'Mickiewicza', '52', '74-400', 'Dębno'),
(223, 'Szczecin', 'Chopina', '123-AAA', '74-400', 'Kostrzyn nad odrą'),
(225, 'Dębno', '', '67/4', '74-400', 'Dębno'),
(226, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(227, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(228, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(229, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(230, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(231, 'Smolnica', '', '67/4', '74-400', 'Dębno'),
(232, 'Smolnica', '', '67/4', '74-400', 'Dębno'),
(241, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(242, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(243, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(244, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(245, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(246, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(247, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(248, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(249, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `author`
--

CREATE TABLE `author` (
  `id_autora` int(11) NOT NULL,
  `imie` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `narodowosc` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `okres_tworczosci` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `rodzaj_tworczosci` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id_autora`, `imie`, `nazwisko`, `narodowosc`, `okres_tworczosci`, `rodzaj_tworczosci`) VALUES
(1, 'Jerzy', 'Grębosz', 'Polska', '2001-2022', 'Literatura techniczna'),
(2, 'Adam', 'Nowak', 'Polska', '2004-2018', 'Powieści'),
(12, 'Kajetan', 'Bąk', 'Polska', '1980-1988', 'Biografie'),
(13, 'Ariel', 'Mazurek', 'Polska', '1995-2003', 'Literatura naukowa'),
(14, 'Kazimierz', 'Maciejewski', 'Polska', '1983-1992', 'Poradniki'),
(15, 'Ksawery', 'Jankowski', 'Polska', '2000-2003', 'Biografie'),
(16, 'Gabriel', 'Cieślak', 'Polska', '1998-2006', 'Rozwój osobisty'),
(17, 'Błażej', 'Adamska', 'Polska', '2002-2005', 'Horror'),
(18, 'Bartosz', 'Woźniak', 'Polska', '1992-1999', 'Komiks'),
(19, 'Emanuel', 'Wójcik', 'Polska', '1993-2003', 'Fantastyka'),
(20, 'Ernest', 'Michalak', 'Polska', '1992-2002', 'Prawo'),
(21, 'Jakub', 'Adamska', 'Polska', '1980-1981', 'Lektury szkolne'),
(22, 'Dobromił', 'Bąk', 'Polska', '1995-2003', 'Poezja'),
(23, 'Jarosław', 'Nowak', 'Polska', '2008-2016', 'Kryminał'),
(24, 'Łukasz', 'Przybylski', 'Polska', '1986-1991', 'Poezja'),
(25, 'Jerzy', 'Mróz', 'Polska', '1991-1995', 'Horror'),
(26, 'Bogumił', 'Andrzejewski', 'Polska', '2009-2015', 'Prawo'),
(27, 'Milan', 'Brzeziński', 'Polska', '2007-2011', 'Informatyka'),
(28, 'Patryk', 'Lis', 'Polska', '1984-1985', 'Dla młodzieży'),
(29, 'Anastazy', 'Zalewski', 'Polska', '1986-1991', 'Dla młodzieży'),
(30, 'Maksymilian', 'Czerwiński', 'Polska', '1981-1988', 'Rozwój osobisty'),
(31, 'Alex', 'Lis', 'Polska', '1981-1988', 'Dla młodzieży'),
(32, 'Cezary', 'Sokołowski', 'Polska', '1997-2000', 'Literatura obyczajowa'),
(33, 'Radosław', 'Walczak', 'Polska', '2002-2012', 'Dla dzieci'),
(34, 'Kamil', 'Laskowska', 'Polska', '1992-1999', 'Informatyka'),
(35, 'Arkadiusz', 'Lewandowski', 'Polska', '2007-2008', 'Nauka języków'),
(36, 'Marek', 'Andrzejewski', 'Polska', '1996-1999', 'Poradniki'),
(37, 'Scott Alan ', 'Miller', 'USA', '2003-2023', 'Informatyka'),
(38, 'Welling ', 'Luke', 'USA', '2005-2023', 'Informatyka'),
(39, 'Moskała ', 'Marcin', 'Polska', '2006-2023', 'Informatyka'),
(40, 'Feliks ', 'Kurp', 'USA', '2008-2023', 'Informatyka'),
(41, 'Martin', 'Robert C', 'USA', '2006-2022', 'Informatyka'),
(42, 'Keith ', 'J. Grant', 'USA', '2012-2023', 'Informatyka'),
(43, 'Marcin', 'Karbowski', 'Polska', '2003-2023', 'Informatyka'),
(44, 'Chavez ', 'Conrad', 'USA', '2010-2023', 'Informatyka'),
(45, 'Cathy ', 'Tanimura', 'USA', '2008-2023', 'Informatyka'),
(46, 'Sylwia', 'Winnik ', 'Polska', '2015-2024', 'Dla dzieci'),
(47, 'Jim', 'Field ', 'USA', '2004-2023', 'Dla dzieci'),
(48, 'Zuzanna', 'Osuchowska', 'Polska', '2015-2023', 'Dla dzieci'),
(49, 'Ben', 'Forta', 'USA', '2005-2024', 'Informatyka');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `books`
--

CREATE TABLE `books` (
  `id_ksiazki` int(11) NOT NULL,
  `id_autora` int(11) NOT NULL,
  `tytul` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `cena` float DEFAULT NULL,
  `rok_wydania` year(4) DEFAULT NULL,
  `opis` mediumtext CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL COMMENT 'opis książki',
  `oprawa` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `id_wydawcy` int(11) NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL COMMENT 'file path to the book image stored on disk',
  `rating` float DEFAULT NULL COMMENT 'srednia ocena książki',
  `ilosc_stron` int(11) DEFAULT NULL,
  `wymiary` varchar(25) DEFAULT NULL,
  `stan` varchar(25) NOT NULL DEFAULT 'nowa',
  `id_subkategorii` int(11) DEFAULT NULL COMMENT 'id podkategorii z tabeli subkategorie'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id_ksiazki`, `id_autora`, `tytul`, `cena`, `rok_wydania`, `opis`, `oprawa`, `id_wydawcy`, `image_url`, `rating`, `ilosc_stron`, `wymiary`, `stan`, `id_subkategorii`) VALUES
(2, 2, 'PHP i MySQL. Od podstaw. Wydanie IV', 54.5, '2016', 'PHP i MySQL to duet, na którym opiera się ogromna większość ciut bardziej zaawansowanych stron w sieci. Czemu zawdzięcza on swą popularność? Niezwykłemu dopasowaniu do potrzeb, łatwej konfiguracji oraz ogromnej społeczności, zawsze chętnej do pomocy. Kiedy zaprzęgniesz ten zestaw do pracy, już po kilku godzinach zobaczysz jej pierwsze efekty!\r\n\r\nCo zrobić, żeby osiągnąć jeszcze więcej? Nic prostszego! Sięgnij po tę książkę i zacznij swoją przygodę z PHP oraz MySQL. Na samym początku dowiesz się, jak przygotować środowisko pracy, oraz poznasz podstawy programowania w języku PHP. Potem płynnie przejdziesz do zdobywania wiedzy na temat programowania obiektowego, wyrażeń regularnych, obsługi formularzy HTML oraz integracji z usługami katalogowymi LDAP. Nauczysz się wykorzystywać mechanizm sesji, technologię AJAX oraz Zend Framework. Po przeprowadzeniu Cię przez komplet informacji na temat PHP autor przedstawi Ci bazę danych MySQL. Poznasz jej mocne elementy, sposoby podłączania klientów or', 'twarda', 2, 'podstawy_PHP.png', 4, 668, '253 x 938 x 029', 'nowa', 2),
(35, 32, 'CSS. Nieoficjalny podręcznik', 89, '2018', 'CSS jest świetnym narzędziem do budowania profesjonalnych stron internetowych. Opanowanie jego tajników może wydawać się dość trudnym zadaniem, jednak wysiłek ten bardzo się opłaca. CSS wciąż zaskakuje nieoczekiwanymi możliwościami, dalece wykraczającymi poza proste ozdabianie stron WWW. Technologia ta pozwala na tworzenie znakomicie wyglądających witryn o przebogatej funkcjonalności. Co jakiś czas pojawiają się nowe narzędzia i modele, jeszcze bardziej poszerzające warsztat projektanta. CSS jest jedną z tych technik, które wymagają nieustannego uczenia się i zapoznawania z nowościami.\r\n\r\nNiniejsza książka to niezwykle wartościowy podręcznik dla projektantów stron o różnym poziomie zaawansowania. Zawarto tu zwięzłe wprowadzenie do języka HTML w zakresie niezbędnym dla każdego, kto chce programować w CSS. Przedstawiono wyczerpujące i dokładne wskazówki tworzenia stron WWW w CSS, wyjaśniając poszczególne niuanse tej technologii. W dobie rozwoju urządzeń mobilnych niezwykle cenne są infor', 'twarda', 1, 'CSS_Nieoficjalny_podręcznik.png', 0, 656, '370 x 337 x 76', 'nowa', 29),
(36, 42, 'CSS od podszewki', 39.5, '2016', 'W ostatnich latach CSS bardzo się rozwinął. Mimo że istnieje od kilku dekad, wciąż jest ważnym elementem warsztatu profesjonalnych projektantów stron internetowych. Co prawda przyswojenie podstaw CSS nie jest specjalnie trudne, ale osiągnięcie prawdziwej biegłości w korzystaniu z tego języka wymaga stałego uczenia się i ciągłych ćwiczeń. Trzeba dobrze zrozumieć wszystkie części kodu CSS, a także sposób, w jaki są do siebie dopasowane. Wysiłek włożony w doskonałe opanowanie języka szybko się zwróci: CSS pozwala zwiększyć wygodę użytkownika, przyspieszyć proces projektowania, uniknąć potencjalnych błędów, a także urozmaicić i ożywić aplikację.\r\n\r\nTa książka jest kompleksowym przewodnikiem po języku CSS dla osób na różnych poziomach biegłości w stosowaniu kaskadowych arkuszy stylów. Zawiera kluczowe informacje o podstawach języka, dzięki czemu będzie nieocenioną pomocą dla początkujących. Szczegółowo opisano tu również nowości i ulepszenia, które pojawiły się w języku na przestrzeni ostat', 'twarda', 1, 'css-od-podszewki-b-iext135439318.webp', 0, 480, '837 x 773 x 253', 'nowa', 1),
(48, 41, 'Czysty kod. Podręcznik dobrego programisty', 49.45, '2014', 'Poznaj najlepsze metody tworzenia doskonałego kodu\r\n\r\nJak pisać dobry kod, a zły przekształcić w dobry?\r\nJak formatować kod, aby osiągnąć maksymalną czytelność?\r\nJak implementować pełną obsługę błędów bez zaśmiecania logiki kodu?\r\nO tym, ile problemów sprawia niedbale napisany kod, wie każdy programista. Nie wszyscy jednak wiedzą, jak napisać ten świetny, „czysty” kod i czym właściwie powinien się on charakteryzować. Co więcej – jak odróżnić dobry kod od złego? Odpowiedź na te pytania oraz sposoby tworzenia czystego, czytelnego kodu znajdziesz właśnie w tej książce. Podręcznik jest obowiązkową pozycją dla każdego, kto chce poznać techniki rzetelnego i efektywnego programowania.\r\n\r\nW książce „Czysty kod. Podręcznik dobrego programisty” szczegółowo omówione zostały zasady, wzorce i najlepsze praktyki pisania czystego kodu. Podręcznik zawiera także kilka analiz przypadków o coraz większej złożoności, z których każda jest doskonałym ćwiczeniem porządkowania zanieczyszczonego bądź nieudaneg', 'miękka', 1, 'czysty-kod-podrecznik-dobrego-programisty-b-iext133438979.webp', 0, 425, '237 x 20 x 167', 'nowa', 1),
(114, 40, 'Sztuczna inteligencja od podstaw', 32.57, '2023', 'Nie ma wątpliwości, że sztuczna inteligencja (AI) zrewolucjonizuje w najbliższych dekadach nasze życie. Wśród największych autorytetów świata nauki panuje przekonanie, że stoimy w obliczu przełomu porównywalnego z wynalezieniem i zastosowaniami elektryczności.\r\n\r\nSztuczna inteligencja od podstaw to pozycja, która począwszy od opisu klasycznych metod SI, takich jak algorytm genetyczny, algorytm mrówkowy, systemy ekspertowe czy sztuczne życie, zapoznaje Czytelnika z najbardziej zaawansowanymi modelami opartymi na sztucznych sieciach neuronowych.', 'miękka', 1, 'sztuczna-inteligencja-od-podstaw-b-iext131736947.webp', 4, 192, '210 x 10 x 150', 'nowa', 1),
(116, 38, 'PHP i MySQL. Tworzenie stron WWW. Vademecum profesjonalisty', 109, '2021', 'Język PHP i serwer bazy danych MySQL to niezwykle popularne narzędzia o otwartym kodzie źródłowym. Wiele świetnych, dynamicznych stron WWW powstało właśnie dzięki połączeniu tych dwóch narzędzi. Ogromne możliwości PHP oraz elastyczność i szybkość MySQL, bezustanne rozwijanie tych technologii, a także niezawodna i chętna do pomocy społeczność sprawiają, że tworzenie profesjonalnych, interaktywnych witryn WWW z wykorzystaniem synergii PHP i MySQL jest pracą przyjemną, efektywną i satysfakcjonującą!', 'twarda', 1, 'php-i-mysql-tworzenie-stron-www-vademecum-profesjonalisty-b-iext67290707.webp', 0, 712, '125 x 730 x 310', 'nowa', 1),
(117, 39, 'Python od podstaw', 32.7, '2022', 'Ta książka zacznie Twoją przygodę z programowaniem. Prezentuje wiedzę w praktyczny, przystępny i zrozumiały sposób. Pomaga zbudować solidne podwaliny pod naukę języka Python oraz wytyczyć dalszy kierunek. Jeśli chcesz nauczyć się programowania albo zastanawia Cię czym ono jest, to jest to książka dla Ciebie.\r\n\r\nRazem z tą książką wejdziesz krok po kroku do świata języka Python. Pokaże Ci, że programowanie to świetna zabawa, a przy tym znacznie bardziej przydatna i dostępna umiejętność niż może się wydawać. Dowiesz się z niej:', 'miękka', 2, 'python-od-podstaw-b-iext117047464.webp', 0, 312, '200 x 20 x 140', 'nowa', 1),
(124, 37, 'Linux dla admina. Najlepsze praktyki. O czym pamiętać podczas projektowania i zarządzania systemami', 56, '2023', 'Popularność systemów linuksowych cały czas rośnie. Mimo to bardzo niewielu administratorów stara się dokładnie opanować sztukę zarządzania Linuksem, większość ogranicza się do kilku rutynowych zadań. Tak administrowane systemy oczywiście mogą dłuższy czas działać poprawnie, jednak dopiero dogłębne zapoznanie się ze sposobem działania Linuksa pozwoli na pełniejsze skorzystanie z jego niesamowitych możliwości.\r\n\r\nTo książka przeznaczona dla profesjonalnych administratorów i użytkowników Linuksa. Dzięki niej szybciej zrozumiesz, w jakim stopniu dobre zarządzanie systemami na poziomie systemu operacyjnego może wynieść działanie infrastruktury biznesowej na zupełnie inny poziom. Znajdziesz tu najlepsze praktyki zarządzania systemami ― począwszy od wyboru optymalnej dystrybucji Linuksa, poprzez zaprojektowanie architektury systemu, skończywszy na strategiach zarządzania przeprowadzanymi w nim poprawkami i aktualizacjami.', 'miękka', 1, 'linux-dla-admina-najlepsze-praktyki-o-czym-pamietac-podczas-projektowania-i-zarzadzania-systemami-b-iext140747274.webp', 0, 382, '230 x 28 x 160', 'nowa', 34),
(125, 43, 'Podstawy kryptografii', 51.13, '2017', 'Przekonaj się, jak fascynująca jest kryptografia!\r\n\r\nPoznaj historię rozwoju kryptografii\r\nOpanuj jej matematyczne podstawy\r\nRozpracuj najważniejsze algorytmy kryptograficzne\r\nDowiedz się, jak zastosować je w praktyce\r\nKryptografia to dziedzina nauki, której sedno stanowią sposoby bezpiecznego przekazywania informacji. Jest ona niemal tak stara, jak nasza cywilizacja, a dziś rozwija się w sposób niezwykle dynamiczny. Gdy tylko narodziły się pierwsze metody zapisu i komunikowania się, pojawiła się też konieczność zabezpieczenia informacji przed tymi, którzy mogliby wykorzystać je na niekorzyść osób dysponujących tymi informacjami. Od bezpieczeństwa ważnych informacji zależały często losy całych państw i narodów. O rozstrzygnięciach wielkich bitew nierzadko decydowały inteligencja i determinacja pojedynczych osób, które potrafiły odpowiednio skutecznie szyfrować (bądź też deszyfrować) nadawane (lub przechwytywane) komunikaty.', 'miękka', 1, 'podstawy-kryptografii-b-iext135315404.webp', NULL, 328, '240 x 20 x 160', 'nowa', 22),
(126, 44, 'Adobe Photoshop PL. Oficjalny podręcznik. Edycja 2023', 68.48, '2023', '\"Adobe Photoshop\" w pełni zasłużył na miano kultowego. Jest używany przez najsławniejszych artystów. Oferuje wysoce zaawansowane narzędzia do obróbki obrazów cyfrowych, w tym funkcje wzbogacone o algorytmy uczenia maszynowego. Dzięki niemu przygotujesz materiały na potrzeby druku, internetu i wideo. Do tego obecnie korzystanie ze wspaniałych możliwości Photoshopa jest prostsze niż kiedykolwiek wcześniej.\r\n\r\nTo kolejne, zaktualizowane wydanie oficjalnego podręcznika firmy Adobe - najlepszej pomocy do nauki Photoshopa. Zawiera setki przydatnych wskazówek, dzięki którym praca z Photoshopem będzie efektywniejsza i o wiele bardziej satysfakcjonująca. Czytelnik dowie się, jak korygować cyfrowe obrazy, w tym usuwać bez śladu niepotrzebne obiekty ze zdjęć, a także pozna nowe funkcje Photoshopa, takie jak usprawnione narzędzia do tworzenia zaznaczeń, nowe filtry neuronalne i funkcje maskowania dostępne w Adobe Camera Raw. Podręcznik składa się z 15 lekcji, dzięki którym można się nauczyć zarówn', 'miękka', 1, 'adobe-photoshop-pl-oficjalny-podrecznik-edycja-2023-b-iext140836051.webp', 4, 408, '230 x 15 x 175', 'nowa', 29),
(127, 45, 'Analiza danych z wykorzystaniem SQL-a. Zaawansowane techniki przekształcania danych we wnioski', 45.77, '2022', 'Język SQL został stworzony jako narzędzie do przetwarzania danych. Mimo że zwykle jest używany do pracy z bazami danych, jego możliwości są o wiele większe. Poprawny kod SQL ułatwia przetwarzanie potężnych zbiorów danych z dużą szybkością. Szczególnie obiecującą perspektywą jest zastosowanie języka SQL na wielkich zbiorach danych przechowywanych w chmurze. Dzięki nieco bardziej złożonym konstrukcjom SQL analityk danych może z dużą efektywnością wydobywać z nich wiedzę.\r\n\r\nTa praktyczna książka jest przeznaczona dla analityków danych i danologów, którzy chcą używać SQL-a do eksploracji dużych zbiorów danych. Pokazuje zarówno popularne, jak i nieco mniej znane techniki budowania zapytań SQL, dzięki czemu możliwe staje się rozwiązywanie nawet bardzo zawiłych problemów i optymalne wykorzystanie właściwości tego języka w pracy na danych. W nowy, innowacyjny sposób przedstawiono tu takie pojęcia jak złączenia, funkcje okna, podzapytania i wyrażenia regularne. Zademonstrowano, jak łączyć różn', 'miękka', 1, 'analiza-danych-z-wykorzystaniem-sql-a-zaawansowane-techniki-przeksztalcania-danych-we-wnioski-b-iext138845735.webp', 0, 304, '240 x 170 x 5', 'nowa', 34),
(129, 46, 'Wanda Panda wita lato', 8.99, '2023', 'Wakacje czas zacząć! Wanda spędzi z rodziną aktywnie letni dzień. Odkryje zapach skoszonej trawy, smak świeżych owoców, ciepły deszczyk i zabawy na świeżym powietrzu. Bo takie właśnie jest lato!\n\n„Wanda Panda\" to seria książeczek dla najmłodszych do rodzinnego czytania i wspólnego odkrywania świata. Autorka skupia się na codzienności małych dzieci, które każdego dnia napotykają różnego rodzaju wyzwania i poznają zaskakujące fakty o sobie samych i o tym, co nas otacza.\n\nKsiążka jest tworzona we współpracy z psychologiem dziecięcym, dzięki czemu może z powodzeniem wspierać dorosłych w wychowaniu najmłodszych.', 'twarda', 3, 'Wanda Panda wita lato.png', NULL, 25, '125 x 730 x 310', 'nowa', 35),
(130, 46, 'Wielka księga łamigłówek przedszkolaka', 19.99, '2023', 'Wyruszcie w edukacyjną przygodę z \"Wielką księgą łamigłówek przedszkolaka\"! To fantastyczna propozycja dla dzieci, które nie lubią się nudzić. Znajdziecie tu fantastyczne łamigłówki, ciekawe zadania, kolorowanki, wyszukiwanki to wspaniały sposób na spędzenie czasu i super zabawę!\n\nZadania wspierają kształtowanie elementarnych umiejętności poznawczych przedszkolaków. Dzięki zadaniom dziecko będzie kształtować logiczne myślenie i rozwijać motorykę dłoni, a przede wszystkim świetnie się bawić!', 'Miekka', 3, 'Wielka księga łamigłówek przedszkolaka.png', NULL, 128, '250 x 215 x 150', 'nowa', 35),
(131, 47, 'Pan Oskar na wakacjach', 25.59, '2023', 'Wyrusz z Panem Oskarem w niezapomnianą podróż! A przy okazji poznaj angielskie słówka.\n\nPan Oskar postanawia udać się na wyprawę życia. Dociera nad morze i w góry, biwakuje, żegluje i zjeżdża na nartach. Przy okazji odwiedza swoich przyjaciół. Dołącz do Oskara oraz jego złotej rybki Kory – wspólnie odkryjcie nie tylko nowe miejsca, ale także angielskie słowa i zwroty.\n\nWesoła, rewelacyjnie zilustrowana opowieść, której dodatkowym atutem jest nauka podstawowych wyrażeń z języka angielskiego. Autorem książki jest znany i ceniony na całym świecie Jim Field (twórca m.in. bestsellerowych picturebooków „Mysz, która chciała być lwem”, „Pandki, które obiecały”).', 'Twarda', 1, 'Pan Oskar na wakacjach.png', NULL, 32, '295 x 255 x 9', 'nowa', 35),
(132, 48, 'Quiz dla 3-latka', 22.42, '2023', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Miekka', 3, 'Quiz dla 3-latka.png', NULL, 20, '125 x 730 x 310', 'nowa', 35),
(133, 49, 'SQL w mgnieniu oka. Opanuj język zapytań w 10 minut dziennie', 38.12, '2020', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Miekka', 1, 'SQL w mgnieniu oka. Opanuj język zapytań w 10 minut dziennie.png', NULL, 256, '240 x 150 x 10', 'nowa', 34);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `id_kategorii` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL COMMENT 'nazwa kategorii'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_kategorii`, `nazwa`) VALUES
(1, 'Dla dzieci'),
(2, 'Fantastyka'),
(3, 'Horror'),
(4, 'Informatyka'),
(5, 'Komiks'),
(6, 'Kryminał'),
(7, 'Poezja');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `id_komentarza` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `tresc` varchar(255) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id_komentarza`, `id_ksiazki`, `id_klienta`, `tresc`, `data`) VALUES
(327, 2, 400, 'Lorem ipsum', '2024-06-01 15:58:53'),
(328, 114, 400, 'asd asd asd ', '2024-06-17 12:27:31');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `customers`
--

CREATE TABLE `customers` (
  `id_klienta` int(11) NOT NULL,
  `imie` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `nazwisko` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `wojewodztwo` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `kraj` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `PESEL` varchar(11) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `data_urodzenia` date DEFAULT NULL,
  `telefon` varchar(15) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `login` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `haslo` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `adres_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id_klienta`, `imie`, `nazwisko`, `wojewodztwo`, `kraj`, `PESEL`, `data_urodzenia`, `telefon`, `email`, `login`, `haslo`, `adres_id`) VALUES
(386, 'Jakub', 'Wojciechowski', NULL, NULL, NULL, NULL, '515350960', 'jakub.wojciechowski.682@gmail.com', NULL, '$2y$10$minrPJkXlc1ZFtcVLfSRwegLIZCeoGO8n3SHhaeNZvmRIN2avZ2EK', 232),
(394, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak123@wp.pl', NULL, '$2y$10$fAsA6qC0wSb6cGVNKhuvtuvixIFShl1Tvs92S6iHEceYpSudEf.sG', 241),
(395, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak3@wp.pl', NULL, '$2y$10$H7ivQoL4jL/zKQlHoLyyOe56WO6r5ddpo.qtuo9pYjwV5MTpj8DIO', 242),
(396, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak4@wp.pl', NULL, '$2y$10$1yzXlIJxaQN0nouBgSypi.ufy2LSQPXqLoDkba8CNMpddA5ct.Mt2', 243),
(397, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak6@wp.pl', NULL, '$2y$10$k0.N9cjgenG6OCX.GFD7le805NCZ1YmG2H0vvOpjaKkeujP9PBoSK', 244),
(398, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak7@wp.pl', NULL, '$2y$10$CNUwLYJr4AKqt3Uaae65y..PNqdMK9fyn8WHHMSYm7sItH0gH2AbS', 245),
(399, 'Jakub', 'Wojciechowski', NULL, NULL, NULL, NULL, '505101303', 'b7cfr0na@flymail.tk', NULL, '$2y$10$SN1ZWv/en9tx8Jz8VfjmXuHC070sD3W5zCISyIZsOL4IChY08EqhW', 246),
(400, 'Jan', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak1@wp.pl', NULL, '$2y$10$YZOyYN6/n.K00N84iX7nbeFBx4HXWVJg9xd6lwuyJFoU2LwyyAvhq', 247),
(401, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak2@wp.pl', NULL, '$2y$10$qAnChO0nbyMRMAubQK/LquCyE.NyGZ7Mma2.cQBxjkJma3D5ZFPaG', 248),
(402, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'afdaycdka@10mail.org', NULL, '$2y$10$XMW5lrhCL6pb//zfxA6eFe3gPZvi5iwazA8.pthaABypLz3vaiM.G', 249);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `delivery_methods`
--

CREATE TABLE `delivery_methods` (
  `id_formy_dostawy` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL COMMENT 'forma dostawy',
  `cena` decimal(10,2) NOT NULL COMMENT 'koszt dostawy'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `delivery_methods`
--

INSERT INTO `delivery_methods` (`id_formy_dostawy`, `nazwa`, `cena`) VALUES
(1, 'Kurier DPD', 5.00),
(2, 'Kurier Inpost', 16.50),
(3, 'Paczkomaty 24/7 (Inpost)', 14.99),
(4, 'Odbiór w punkcie (Poczta polska)', 9.99),
(5, 'Odbiór w sklepie (Księgarnia)', 0.00);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `employees`
--

CREATE TABLE `employees` (
  `id_pracownika` int(11) NOT NULL COMMENT 'id pracownika',
  `imie` varchar(255) NOT NULL,
  `nazwisko` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `wynagrodzenie` decimal(10,2) DEFAULT NULL,
  `stanowisko` varchar(255) NOT NULL,
  `data_zatrudnienia` date DEFAULT current_timestamp(),
  `telefon` varchar(255) NOT NULL COMMENT 'numer telefonu',
  `adres_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id_pracownika`, `imie`, `nazwisko`, `email`, `haslo`, `wynagrodzenie`, `stanowisko`, `data_zatrudnienia`, `telefon`, `adres_id`) VALUES
(4, 'Jan', 'Nowak', 'jan.nowak@wp.pl', '$2y$10$NEm7t60JIe9OD7OdHyHn.OosZRExCCnW13E/mDtH2PJ886IjbrzIu', 2758.00, 'sprzedawca', '2023-04-25', '647918229', 32),
(6, 'Adam', 'Kowalski', 'adam.nowak@wp.pl', '$2y$10$r2v0wivXQWdE2nAwe4vXS.uKGcudxJSRjcFlOL4gtAdMgfle.SiBm', 3758.00, 'sprzedawca', '2023-04-25', '647918229', 33);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `id_zamowienia` int(11) NOT NULL,
  `id_klienta` int(11) DEFAULT NULL,
  `data_zlozenia_zamowienia` datetime NOT NULL,
  `termin_dostawy` date DEFAULT NULL,
  `data_wysłania_zamowienia` datetime NOT NULL,
  `data_dostarczenia` date NOT NULL,
  `id_formy_dostawy` int(11) NOT NULL COMMENT 'forma dostawy (klucz obcy)',
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `komentarz` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL COMMENT 'komentarz do zamówienia - składany po jego usunięciu',
  `id_pracownika` int(11) NOT NULL COMMENT 'pracownik, który obsługuje to zamówienie'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id_zamowienia`, `id_klienta`, `data_zlozenia_zamowienia`, `termin_dostawy`, `data_wysłania_zamowienia`, `data_dostarczenia`, `id_formy_dostawy`, `status`, `komentarz`, `id_pracownika`) VALUES
(1411, 400, '2024-06-01 18:10:11', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00', 1, 'Oczekujące na potwierdzenie', '', 4),
(1412, 400, '2024-06-17 14:24:36', '0000-00-00', '0000-00-00 00:00:00', '2024-06-20', 1, 'Dostarczono', '', 6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_details`
--

CREATE TABLE `order_details` (
  `id_zamowienia` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `ilosc` smallint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id_zamowienia`, `id_ksiazki`, `ilosc`) VALUES
(1411, 2, 4),
(1412, 129, 2),
(1412, 130, 3),
(1412, 131, 2),
(1412, 132, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `token_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL COMMENT 'zahashowany, 12-znakowy token',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL COMMENT 'adres e-mail klienta',
  `exp_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`token_id`, `token`, `email`, `exp_time`) VALUES
(989, 'b50f7a0f22751d8e627da217273cb6c89030567820c72ef7688ad27028c88208', 'adam.nowak1@wp.pl', '2024-06-01 18:31:40');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payments`
--

CREATE TABLE `payments` (
  `id_platnosci` int(11) NOT NULL,
  `id_zamowienia` int(11) NOT NULL,
  `data_platnosci` datetime NOT NULL,
  `kwota` float NOT NULL,
  `id_metody_platnosci` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id_platnosci`, `id_zamowienia`, `data_platnosci`, `kwota`, `id_metody_platnosci`) VALUES
(1073, 1411, '2024-06-01 18:10:11', 329.1, 1),
(1074, 1412, '2024-06-17 14:24:36', 196.39, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id_metody_platnosci` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL COMMENT 'sposób płatności (np "Przelew tradycyjny", "PayPal", "Karta kredytowa" ...)',
  `oplata` decimal(10,2) DEFAULT 0.00 COMMENT '(np. jeżeli za wybraną metodę płatności jest dodatkowa opłata, tak jak dla płatności za pobraniem)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id_metody_platnosci`, `nazwa`, `oplata`) VALUES
(1, 'Blik', 0.00),
(2, 'Pobranie', 5.00),
(3, 'Karta płatnicza (online)', 0.00);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `publishers`
--

CREATE TABLE `publishers` (
  `id_wydawcy` int(11) NOT NULL,
  `nazwa_wydawcy` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `kod_pocztowy` varchar(6) NOT NULL,
  `telefon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`id_wydawcy`, `nazwa_wydawcy`, `adres`, `kod_pocztowy`, `telefon`) VALUES
(1, 'Helion', 'Warszawa', '500-31', '+48 018 938 922'),
(2, 'PWN', 'Warszawa', '02-460', '+48 839 771 829'),
(3, 'Wydawnictwo MUZA S.A.', 'Warszawa\r\n', '03-751', '+48 701 928 732');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ratings`
--

CREATE TABLE `ratings` (
  `id_oceny` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `ocena` int(11) NOT NULL COMMENT 'ocena_książki',
  `id_klienta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id_oceny`, `id_ksiazki`, `ocena`, `id_klienta`) VALUES
(312, 2, 4, 400),
(313, 114, 4, 400);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id_klienta` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`id_klienta`, `id_ksiazki`, `ilosc`) VALUES
(386, 48, 4),
(400, 129, 2),
(400, 130, 3),
(400, 131, 2),
(400, 132, 3),
(402, 48, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `subcategories`
--

CREATE TABLE `subcategories` (
  `id_subkategorii` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL COMMENT 'nazwa podkategorii',
  `id_kategorii` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id_subkategorii`, `nazwa`, `id_kategorii`) VALUES
(1, 'Programowanie', 4),
(2, 'Web development', 4),
(22, 'Cybersecurity', 4),
(23, 'Mobile App Development', 4),
(24, 'Artificial Intelligence', 4),
(25, 'Cloud Computing', 4),
(26, 'Software Engineering', 4),
(27, 'Game Development', 4),
(28, 'Network Administration', 4),
(29, 'UX/UI Design', 4),
(34, 'Data bases', 4),
(35, 'Wiek 3-5', 1),
(36, 'Wiek 6-8', 1),
(37, 'Wiek 9-12', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `warehouse`
--

CREATE TABLE `warehouse` (
  `id_magazynu` int(11) NOT NULL,
  `nazwa` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL COMMENT 'nazwa magazynu',
  `kraj` varchar(255) NOT NULL,
  `wojewodztwo` varchar(255) NOT NULL,
  `miejscowosc` varchar(255) NOT NULL,
  `ulica` varchar(255) NOT NULL,
  `numer_ulicy` int(11) NOT NULL,
  `kod_pocztowy` varchar(255) NOT NULL,
  `kod_miejscowosc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`id_magazynu`, `nazwa`, `kraj`, `wojewodztwo`, `miejscowosc`, `ulica`, `numer_ulicy`, `kod_pocztowy`, `kod_miejscowosc`) VALUES
(1, 'magazyn nr 1', 'Polska', 'Zachodmiopomorskie', 'Szczecin', 'Fryderyka Chopina ', 3, '800-21', 'Szczecin'),
(2, 'magazyn nr 2', 'Polska', 'Zachodmiopomorskie', 'Police', 'Fryderyka Chopina ', 3, '800-21', 'Szczecin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `warehouse_books`
--

CREATE TABLE `warehouse_books` (
  `id_magazynu` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `ilosc_dostepnych_egzemplarzy` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `warehouse_books`
--

INSERT INTO `warehouse_books` (`id_magazynu`, `id_ksiazki`, `ilosc_dostepnych_egzemplarzy`) VALUES
(1, 35, '123'),
(1, 36, '0'),
(1, 48, '60'),
(1, 114, '132'),
(1, 116, '125'),
(1, 124, '125'),
(1, 126, '85'),
(1, 127, '78'),
(2, 2, '1'),
(2, 35, '0'),
(2, 125, '67'),
(2, 129, '50'),
(2, 130, '50'),
(2, 131, '50'),
(2, 132, '50'),
(2, 133, '50');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`adres_id`);

--
-- Indeksy dla tabeli `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id_autora`);

--
-- Indeksy dla tabeli `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id_ksiazki`),
  ADD KEY `id_autora` (`id_autora`),
  ADD KEY `id_wydawcy` (`id_wydawcy`),
  ADD KEY `id_subkategorii` (`id_subkategorii`);

--
-- Indeksy dla tabeli `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_kategorii`);

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_komentarza`),
  ADD UNIQUE KEY `id_ksiazki_2` (`id_ksiazki`,`id_klienta`),
  ADD KEY `id_ksiazki` (`id_ksiazki`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id_klienta`),
  ADD UNIQUE KEY `adres_id` (`adres_id`),
  ADD KEY `email` (`email`);

--
-- Indeksy dla tabeli `delivery_methods`
--
ALTER TABLE `delivery_methods`
  ADD PRIMARY KEY (`id_formy_dostawy`);

--
-- Indeksy dla tabeli `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id_pracownika`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `adres_id` (`adres_id`),
  ADD KEY `id_pracownika` (`id_pracownika`);

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_zamowienia`),
  ADD KEY `id_klienta` (`id_klienta`),
  ADD KEY `id_pracownika` (`id_pracownika`),
  ADD KEY `id_formy_dostawy` (`id_formy_dostawy`);

--
-- Indeksy dla tabeli `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id_zamowienia`,`id_ksiazki`),
  ADD KEY `id_ksiazki` (`id_ksiazki`);

--
-- Indeksy dla tabeli `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD KEY `email` (`email`);

--
-- Indeksy dla tabeli `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id_platnosci`),
  ADD UNIQUE KEY `id_zamowienia` (`id_zamowienia`),
  ADD KEY `sposob_platnosci` (`id_metody_platnosci`);

--
-- Indeksy dla tabeli `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id_metody_platnosci`);

--
-- Indeksy dla tabeli `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`id_wydawcy`),
  ADD UNIQUE KEY `nazwa_wydawcy` (`nazwa_wydawcy`);

--
-- Indeksy dla tabeli `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id_oceny`),
  ADD UNIQUE KEY `id_ksiazki` (`id_ksiazki`,`id_klienta`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`id_klienta`,`id_ksiazki`),
  ADD KEY `id_ksiazki` (`id_ksiazki`);

--
-- Indeksy dla tabeli `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id_subkategorii`),
  ADD KEY `id_kategorii` (`id_kategorii`);

--
-- Indeksy dla tabeli `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`id_magazynu`);

--
-- Indeksy dla tabeli `warehouse_books`
--
ALTER TABLE `warehouse_books`
  ADD PRIMARY KEY (`id_magazynu`,`id_ksiazki`),
  ADD KEY `id_ksiazki` (`id_ksiazki`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `adres_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id_autora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id_ksiazki` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_kategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_komentarza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id_klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=403;

--
-- AUTO_INCREMENT for table `delivery_methods`
--
ALTER TABLE `delivery_methods`
  MODIFY `id_formy_dostawy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id_pracownika` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id pracownika', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_zamowienia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1413;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=990;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id_platnosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1075;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id_metody_platnosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id_subkategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`id_autora`) REFERENCES `author` (`id_autora`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`id_wydawcy`) REFERENCES `publishers` (`id_wydawcy`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_ibfk_3` FOREIGN KEY (`id_subkategorii`) REFERENCES `subcategories` (`id_subkategorii`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_ksiazki`) REFERENCES `books` (`id_ksiazki`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_klienta`) REFERENCES `customers` (`id_klienta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `address_id` FOREIGN KEY (`adres_id`) REFERENCES `address` (`adres_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`adres_id`) REFERENCES `address` (`adres_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `customers` (`id_klienta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_pracownika`) REFERENCES `employees` (`id_pracownika`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`id_formy_dostawy`) REFERENCES `delivery_methods` (`id_formy_dostawy`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`id_zamowienia`) REFERENCES `orders` (`id_zamowienia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`id_ksiazki`) REFERENCES `books` (`id_ksiazki`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`email`) REFERENCES `customers` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`id_zamowienia`) REFERENCES `orders` (`id_zamowienia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`id_metody_platnosci`) REFERENCES `payment_methods` (`id_metody_platnosci`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`id_ksiazki`) REFERENCES `books` (`id_ksiazki`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`id_klienta`) REFERENCES `customers` (`id_klienta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `customers` (`id_klienta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`id_ksiazki`) REFERENCES `books` (`id_ksiazki`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`id_kategorii`) REFERENCES `categories` (`id_kategorii`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `warehouse_books`
--
ALTER TABLE `warehouse_books`
  ADD CONSTRAINT `warehouse_books_ibfk_1` FOREIGN KEY (`id_magazynu`) REFERENCES `warehouse` (`id_magazynu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `warehouse_books_ibfk_2` FOREIGN KEY (`id_ksiazki`) REFERENCES `books` (`id_ksiazki`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
