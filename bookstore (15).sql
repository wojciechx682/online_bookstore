-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2023 at 02:12 PM
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
(45, 'Cathy ', 'Tanimura', 'USA', '2008-2023', 'Informatyka');

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
  `opis` varchar(1000) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL COMMENT 'opis książki',
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
(1, 1, 'Symfonia C++ wydanie V ', 55.55, '2010', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent purus elit, tristique posuere mi sit amet, ullamcorper rutrum ante. Aenean tristique urn>a nec erat ullamcorper commodo. Aenean molestie erat sit amet ante semper vulputate. Morbi ante dolor, mollis a justo eget, semper tempus metus. Sed aliquet vestibulum erat elementum tempus. Pellentesque justo massa, rhoncus in rutrum at, iaculis finibus augue. Sed aliquet tempus nulla, id fringilla quam varius dapibus. Mauris ultricies lectus nisi, nec pulvinar diam dapibus at. Morbi tempus tincidunt odio eget tincidunt. Ut quis varius urna, eget posuere magna. Nulla feugiat laoreet ligula, ac efficitur orci pulvinar sed. Pellentesque ligula urna, congue vitae congue et, hendrerit eget sem. Phasellus posuere, ex eu gravida ullamcorper, sapien justo suscipit quam, in varius turpis ex ut quam. Nulla in efficitur quam. Vivamus ut elementum lectus.', 'twarda', 1, 'csymfoni_wyd_V.png', 4.5, 520, '138 x 928 x 281', 'nowa', 1),
(2, 2, 'PHP i MySQL. Od podstaw. Wydanie IV', 54.5, '2016', 'PHP i MySQL to duet, na którym opiera się ogromna większość ciut bardziej zaawansowanych stron w sieci. Czemu zawdzięcza on swą popularność? Niezwykłemu dopasowaniu do potrzeb, łatwej konfiguracji oraz ogromnej społeczności, zawsze chętnej do pomocy. Kiedy zaprzęgniesz ten zestaw do pracy, już po kilku godzinach zobaczysz jej pierwsze efekty!\r\n\r\nCo zrobić, żeby osiągnąć jeszcze więcej? Nic prostszego! Sięgnij po tę książkę i zacznij swoją przygodę z PHP oraz MySQL. Na samym początku dowiesz się, jak przygotować środowisko pracy, oraz poznasz podstawy programowania w języku PHP. Potem płynnie przejdziesz do zdobywania wiedzy na temat programowania obiektowego, wyrażeń regularnych, obsługi formularzy HTML oraz integracji z usługami katalogowymi LDAP. Nauczysz się wykorzystywać mechanizm sesji, technologię AJAX oraz Zend Framework. Po przeprowadzeniu Cię przez komplet informacji na temat PHP autor przedstawi Ci bazę danych MySQL. Poznasz jej mocne elementy, sposoby podłączania klientów or', 'twarda', 2, 'podstawy_PHP.png', 0, 668, '253 x 938 x 029', 'nowa', 2),
(5, 33, 'Mała kaczka w rzece hahahahahaa. Mała kaczka w rzece hahahahahaa', 97.1, '2010', NULL, 'Twarda', 1, '', 4, 240, '432 x 65 x 31', 'nowa', 3),
(6, 22, 'Nadzieja dla mojej dziewczyny', 14.54, '2000', NULL, 'Miękka', 1, '', 0, 358, '460 x 209 x 165', 'nowa', 8),
(7, 33, 'Duchy i lisy', 58.82, '2006', 'Lorem Ipsum', 'twarda', 1, '002.png', 0, 117, '200 x 50 x 426', 'nowa', 3),
(8, 19, 'Witaj w moim kraju', 96.55, '2003', NULL, 'Miękka', 1, '', 4, 263, '117 x 305 x 173', 'nowa', 4),
(9, 23, 'Drzewa i przestępcy', 15.35, '2011', NULL, 'Twarda', 1, '', 2, 866, '453 x 247 x 375', 'nowa', 7),
(10, 17, 'Dzieci w mojej szafie', 31.08, '2012', NULL, 'Twarda', 1, '', 3, 889, '135 x 48 x 339', 'nowa', 5),
(11, 17, 'Demony i sępy', 72.73, '2012', NULL, 'Twarda', 1, '', 0, 896, '51 x 239 x 40', 'nowa', 5),
(12, 17, 'Pokusa na cmentarzu', 59.99, '2005', NULL, 'Miękka', 1, '', NULL, 861, '485 x 307 x 77', 'nowa', 5),
(13, 22, '', 27.11, '2003', NULL, 'Miękka', 1, '', 4, 667, '467 x 104 x 121', 'nowa', 8),
(14, 19, 'Prześladowca bez sumienia', 92.53, '1997', NULL, 'Twarda', 1, '', 0, 652, '294 x 108 x 156', 'nowa', 4),
(16, 19, 'Kobiety i złodzieje', 40.5, '1995', NULL, 'Miękka', 1, '', 4, 336, '178 x 210 x 17', 'nowa', 4),
(18, 18, 'D', 8, '1996', NULL, 'Twarda', 1, '', NULL, 472, '416 x 446 x 483', 'nowa', 6),
(20, 36, 'Świętowanie wodą', 81.59, '2006', NULL, 'Twarda', 1, '', NULL, 293, '76 x 433 x 438', 'nowa', 3),
(21, 23, 'Wrogowie gwiazdy', 16.29, '2014', NULL, 'Twarda', 1, '', 4, 799, '391 x 143 x 40', 'nowa', 7),
(22, 25, 'Biesy i upiory', 85.07, '1993', NULL, 'Miękka', 1, '', 0, 463, '274 x 250 x 430', 'nowa', 5),
(23, 17, 'Sępy i sępy', 45.61, '2008', NULL, 'Miękka', 1, '', 3, 669, '400 x 211 x 353', 'nowa', 5),
(24, 19, 'Wrogowie z determinacją', 81.12, '2003', NULL, 'Twarda', 1, '', 4, 155, '136 x 119 x 188', 'nowa', 4),
(25, 25, 'Symbole w Bibliotece', 20.66, '1995', NULL, 'Miękka', 1, '', 0, 370, '83 x 352 x 45', 'nowa', 5),
(26, 25, 'Pokusa na cmentarzu 2', 87.4, '1994', NULL, 'Miękka', 1, '', 5, 433, '495 x 444 x 238', 'nowa', 5),
(27, 23, 'Bohaterowie i psy', 85.6, '2017', NULL, 'Miękka', 1, '', 4, 108, '359 x 81 x 330', 'nowa', 7),
(28, 19, 'Schronienie w magii', 40.9, '1994', NULL, 'Twarda', 1, '', 0, 840, '407 x 45 x 35', 'nowa', 4),
(29, 19, 'Żołnierze Ognia', 32.16, '2003', NULL, 'Twarda', 1, '', 4, 375, '383 x 404 x 374', 'nowa', 4),
(30, 2, 'A', 7, '2000', NULL, 'miękka', 1, '', 3, 105, '159 x 173 x 390', 'nowa', 6),
(31, 32, 'B', 17, '2002', NULL, 'miękka', 1, '', 0, 151, '431 x 485 x 134', 'nowa', 6),
(32, 32, 'Ą', 13, '2001', NULL, 'twarda', 1, '', 0, 341, '212 x 161 x 171', 'nowa', 6),
(35, 32, 'CSS. Nieoficjalny podręcznik', 89, '2018', 'CSS jest świetnym narzędziem do budowania profesjonalnych stron internetowych. Opanowanie jego tajników może wydawać się dość trudnym zadaniem, jednak wysiłek ten bardzo się opłaca. CSS wciąż zaskakuje nieoczekiwanymi możliwościami, dalece wykraczającymi poza proste ozdabianie stron WWW. Technologia ta pozwala na tworzenie znakomicie wyglądających witryn o przebogatej funkcjonalności. Co jakiś czas pojawiają się nowe narzędzia i modele, jeszcze bardziej poszerzające warsztat projektanta. CSS jest jedną z tych technik, które wymagają nieustannego uczenia się i zapoznawania z nowościami.\r\n\r\nNiniejsza książka to niezwykle wartościowy podręcznik dla projektantów stron o różnym poziomie zaawansowania. Zawarto tu zwięzłe wprowadzenie do języka HTML w zakresie niezbędnym dla każdego, kto chce programować w CSS. Przedstawiono wyczerpujące i dokładne wskazówki tworzenia stron WWW w CSS, wyjaśniając poszczególne niuanse tej technologii. W dobie rozwoju urządzeń mobilnych niezwykle cenne są infor', 'twarda', 1, 'CSS_Nieoficjalny_podręcznik.png', 0, 656, '370 x 337 x 76', 'nowa', 29),
(36, 42, 'CSS od podszewki', 39.5, '2016', 'W ostatnich latach CSS bardzo się rozwinął. Mimo że istnieje od kilku dekad, wciąż jest ważnym elementem warsztatu profesjonalnych projektantów stron internetowych. Co prawda przyswojenie podstaw CSS nie jest specjalnie trudne, ale osiągnięcie prawdziwej biegłości w korzystaniu z tego języka wymaga stałego uczenia się i ciągłych ćwiczeń. Trzeba dobrze zrozumieć wszystkie części kodu CSS, a także sposób, w jaki są do siebie dopasowane. Wysiłek włożony w doskonałe opanowanie języka szybko się zwróci: CSS pozwala zwiększyć wygodę użytkownika, przyspieszyć proces projektowania, uniknąć potencjalnych błędów, a także urozmaicić i ożywić aplikację.\r\n\r\nTa książka jest kompleksowym przewodnikiem po języku CSS dla osób na różnych poziomach biegłości w stosowaniu kaskadowych arkuszy stylów. Zawiera kluczowe informacje o podstawach języka, dzięki czemu będzie nieocenioną pomocą dla początkujących. Szczegółowo opisano tu również nowości i ulepszenia, które pojawiły się w języku na przestrzeni ostat', 'twarda', 1, 'css-od-podszewki-b-iext135439318.webp', 0, 480, '837 x 773 x 253', 'nowa', 1),
(48, 41, 'Czysty kod. Podręcznik dobrego programisty', 49.45, '2014', 'Poznaj najlepsze metody tworzenia doskonałego kodu\r\n\r\nJak pisać dobry kod, a zły przekształcić w dobry?\r\nJak formatować kod, aby osiągnąć maksymalną czytelność?\r\nJak implementować pełną obsługę błędów bez zaśmiecania logiki kodu?\r\nO tym, ile problemów sprawia niedbale napisany kod, wie każdy programista. Nie wszyscy jednak wiedzą, jak napisać ten świetny, „czysty” kod i czym właściwie powinien się on charakteryzować. Co więcej – jak odróżnić dobry kod od złego? Odpowiedź na te pytania oraz sposoby tworzenia czystego, czytelnego kodu znajdziesz właśnie w tej książce. Podręcznik jest obowiązkową pozycją dla każdego, kto chce poznać techniki rzetelnego i efektywnego programowania.\r\n\r\nW książce „Czysty kod. Podręcznik dobrego programisty” szczegółowo omówione zostały zasady, wzorce i najlepsze praktyki pisania czystego kodu. Podręcznik zawiera także kilka analiz przypadków o coraz większej złożoności, z których każda jest doskonałym ćwiczeniem porządkowania zanieczyszczonego bądź nieudaneg', 'miękka', 1, 'czysty-kod-podrecznik-dobrego-programisty-b-iext133438979.webp', 0, 425, '237 x 20 x 167', 'nowa', 1),
(113, 14, 'nowa super ksiazka', 12.12, '2013', '12 12 12 12 12 12 12 ', 'twarda', 2, '00000.jpg', 0, 1212, '121 x 121 x 121', 'nowa', 7),
(114, 40, 'Sztuczna inteligencja od podstaw', 32.57, '2023', 'Nie ma wątpliwości, że sztuczna inteligencja (AI) zrewolucjonizuje w najbliższych dekadach nasze życie. Wśród największych autorytetów świata nauki panuje przekonanie, że stoimy w obliczu przełomu porównywalnego z wynalezieniem i zastosowaniami elektryczności.\r\n\r\nSztuczna inteligencja od podstaw to pozycja, która począwszy od opisu klasycznych metod SI, takich jak algorytm genetyczny, algorytm mrówkowy, systemy ekspertowe czy sztuczne życie, zapoznaje Czytelnika z najbardziej zaawansowanymi modelami opartymi na sztucznych sieciach neuronowych.', 'miękka', 1, 'sztuczna-inteligencja-od-podstaw-b-iext131736947.webp', 0, 192, '210 x 10 x 150', 'nowa', 1),
(115, 1, 'Symfonia C++', 65.55, '2015', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Twarda', 1, 'csymfoni_wyd_V.png', 0, 425, '125 x 730 x 310', 'nowa', 3),
(116, 38, 'PHP i MySQL. Tworzenie stron WWW. Vademecum profesjonalisty', 109, '2021', 'Język PHP i serwer bazy danych MySQL to niezwykle popularne narzędzia o otwartym kodzie źródłowym. Wiele świetnych, dynamicznych stron WWW powstało właśnie dzięki połączeniu tych dwóch narzędzi. Ogromne możliwości PHP oraz elastyczność i szybkość MySQL, bezustanne rozwijanie tych technologii, a także niezawodna i chętna do pomocy społeczność sprawiają, że tworzenie profesjonalnych, interaktywnych witryn WWW z wykorzystaniem synergii PHP i MySQL jest pracą przyjemną, efektywną i satysfakcjonującą!', 'twarda', 1, 'php-i-mysql-tworzenie-stron-www-vademecum-profesjonalisty-b-iext67290707.webp', 0, 712, '125 x 730 x 310', 'nowa', 1),
(117, 39, 'Python od podstaw', 32.7, '2022', 'Ta książka zacznie Twoją przygodę z programowaniem. Prezentuje wiedzę w praktyczny, przystępny i zrozumiały sposób. Pomaga zbudować solidne podwaliny pod naukę języka Python oraz wytyczyć dalszy kierunek. Jeśli chcesz nauczyć się programowania albo zastanawia Cię czym ono jest, to jest to książka dla Ciebie.\r\n\r\nRazem z tą książką wejdziesz krok po kroku do świata języka Python. Pokaże Ci, że programowanie to świetna zabawa, a przy tym znacznie bardziej przydatna i dostępna umiejętność niż może się wydawać. Dowiesz się z niej:', 'miękka', 2, 'python-od-podstaw-b-iext117047464.webp', 0, 312, '200 x 20 x 140', 'nowa', 1),
(118, 2, 'Java - Techniki zaawansowane Wydanie V', 26, '2000', NULL, 'miękka', 1, '', 0, 105, '159 x 173 x 390', 'nowa', 3),
(119, 1, '333 Symfonia C++', 65.55, '2015', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Twarda', 1, '001.png', NULL, 425, '125 x 730 x 310', 'nowa', 4),
(120, 1, 'Symfonia C++', 65.55, '2015', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Twarda', 1, '001.png', NULL, 425, '125 x 730 x 310', 'nowa', 3),
(122, 1, '123 Symfonia C++', 65.55, '2015', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Twarda', 1, '279440432_426598368798280_10347903888580628_n.png', NULL, 425, '125 x 730 x 310', 'nowa', 3),
(123, 1, 'Symfonia C++', 65.55, '2015', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Twarda', 1, 'Java_techniki_zaawansowane.png', NULL, 425, '125 x 730 x 310', 'nowa', 3),
(124, 37, 'Linux dla admina. Najlepsze praktyki. O czym pamiętać podczas projektowania i zarządzania systemami', 56, '2023', 'Popularność systemów linuksowych cały czas rośnie. Mimo to bardzo niewielu administratorów stara się dokładnie opanować sztukę zarządzania Linuksem, większość ogranicza się do kilku rutynowych zadań. Tak administrowane systemy oczywiście mogą dłuższy czas działać poprawnie, jednak dopiero dogłębne zapoznanie się ze sposobem działania Linuksa pozwoli na pełniejsze skorzystanie z jego niesamowitych możliwości.\r\n\r\nTo książka przeznaczona dla profesjonalnych administratorów i użytkowników Linuksa. Dzięki niej szybciej zrozumiesz, w jakim stopniu dobre zarządzanie systemami na poziomie systemu operacyjnego może wynieść działanie infrastruktury biznesowej na zupełnie inny poziom. Znajdziesz tu najlepsze praktyki zarządzania systemami ― począwszy od wyboru optymalnej dystrybucji Linuksa, poprzez zaprojektowanie architektury systemu, skończywszy na strategiach zarządzania przeprowadzanymi w nim poprawkami i aktualizacjami.', 'miękka', 1, 'linux-dla-admina-najlepsze-praktyki-o-czym-pamietac-podczas-projektowania-i-zarzadzania-systemami-b-iext140747274.webp', NULL, 382, '230 x 28 x 160', 'nowa', 34),
(125, 43, 'Podstawy kryptografii', 51.13, '2017', 'Przekonaj się, jak fascynująca jest kryptografia!\r\n\r\nPoznaj historię rozwoju kryptografii\r\nOpanuj jej matematyczne podstawy\r\nRozpracuj najważniejsze algorytmy kryptograficzne\r\nDowiedz się, jak zastosować je w praktyce\r\nKryptografia to dziedzina nauki, której sedno stanowią sposoby bezpiecznego przekazywania informacji. Jest ona niemal tak stara, jak nasza cywilizacja, a dziś rozwija się w sposób niezwykle dynamiczny. Gdy tylko narodziły się pierwsze metody zapisu i komunikowania się, pojawiła się też konieczność zabezpieczenia informacji przed tymi, którzy mogliby wykorzystać je na niekorzyść osób dysponujących tymi informacjami. Od bezpieczeństwa ważnych informacji zależały często losy całych państw i narodów. O rozstrzygnięciach wielkich bitew nierzadko decydowały inteligencja i determinacja pojedynczych osób, które potrafiły odpowiednio skutecznie szyfrować (bądź też deszyfrować) nadawane (lub przechwytywane) komunikaty.', 'miękka', 1, 'podstawy-kryptografii-b-iext135315404.webp', NULL, 328, '240 x 20 x 160', 'nowa', 22),
(126, 44, 'Adobe Photoshop PL. Oficjalny podręcznik. Edycja 2023', 68.48, '2023', '\"Adobe Photoshop\" w pełni zasłużył na miano kultowego. Jest używany przez najsławniejszych artystów. Oferuje wysoce zaawansowane narzędzia do obróbki obrazów cyfrowych, w tym funkcje wzbogacone o algorytmy uczenia maszynowego. Dzięki niemu przygotujesz materiały na potrzeby druku, internetu i wideo. Do tego obecnie korzystanie ze wspaniałych możliwości Photoshopa jest prostsze niż kiedykolwiek wcześniej.\r\n\r\nTo kolejne, zaktualizowane wydanie oficjalnego podręcznika firmy Adobe - najlepszej pomocy do nauki Photoshopa. Zawiera setki przydatnych wskazówek, dzięki którym praca z Photoshopem będzie efektywniejsza i o wiele bardziej satysfakcjonująca. Czytelnik dowie się, jak korygować cyfrowe obrazy, w tym usuwać bez śladu niepotrzebne obiekty ze zdjęć, a także pozna nowe funkcje Photoshopa, takie jak usprawnione narzędzia do tworzenia zaznaczeń, nowe filtry neuronalne i funkcje maskowania dostępne w Adobe Camera Raw. Podręcznik składa się z 15 lekcji, dzięki którym można się nauczyć zarówn', 'miękka', 1, 'adobe-photoshop-pl-oficjalny-podrecznik-edycja-2023-b-iext140836051.webp', NULL, 408, '230 x 15 x 175', 'nowa', 29),
(127, 45, 'Analiza danych z wykorzystaniem SQL-a. Zaawansowane techniki przekształcania danych we wnioski', 45.77, '2022', 'Język SQL został stworzony jako narzędzie do przetwarzania danych. Mimo że zwykle jest używany do pracy z bazami danych, jego możliwości są o wiele większe. Poprawny kod SQL ułatwia przetwarzanie potężnych zbiorów danych z dużą szybkością. Szczególnie obiecującą perspektywą jest zastosowanie języka SQL na wielkich zbiorach danych przechowywanych w chmurze. Dzięki nieco bardziej złożonym konstrukcjom SQL analityk danych może z dużą efektywnością wydobywać z nich wiedzę.\r\n\r\nTa praktyczna książka jest przeznaczona dla analityków danych i danologów, którzy chcą używać SQL-a do eksploracji dużych zbiorów danych. Pokazuje zarówno popularne, jak i nieco mniej znane techniki budowania zapytań SQL, dzięki czemu możliwe staje się rozwiązywanie nawet bardzo zawiłych problemów i optymalne wykorzystanie właściwości tego języka w pracy na danych. W nowy, innowacyjny sposób przedstawiono tu takie pojęcia jak złączenia, funkcje okna, podzapytania i wyrażenia regularne. Zademonstrowano, jak łączyć różn', 'miękka', 1, 'analiza-danych-z-wykorzystaniem-sql-a-zaawansowane-techniki-przeksztalcania-danych-we-wnioski-b-iext138845735.webp', NULL, 304, '240 x 170 x 5', 'nowa', 34);

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
(7, 'Poezja'),
(9, 'Poezja 2');

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
(314, 2, 386, ' wasda ds as das dasd ', '2023-08-31 10:32:10'),
(317, 117, 394, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tempus vehicula leo eget molestie. Duis in ultricies nibh. Maecenas eget dignissim nunc, vitae lobortis turpis.', '2023-08-31 21:14:00'),
(318, 117, 395, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tempus vehicula leo eget molestie. Duis in ultricies nibh. Maecenas eget dignissim nunc, vitae lobortis turpis.', '2023-08-31 21:14:40'),
(319, 117, 396, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tempus vehicula leo eget molestie. Duis in ultricies nibh. Maecenas eget dignissim nunc, vitae lobortis turpis.', '2023-08-31 21:15:16'),
(320, 117, 397, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tempus vehicula leo eget molestie. Duis in ultricies nibh. Maecenas eget dignissim nunc, vitae lobortis turpis.', '2023-08-31 21:15:43'),
(321, 117, 398, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tempus vehicula leo eget molestie. Duis in ultricies nibh. Maecenas eget dignissim nunc, vitae lobortis turpis.', '2023-08-31 21:16:12'),
(322, 2, 400, 'wasda ds as das dasd 2', '2023-09-27 16:25:18'),
(323, 1, 400, 'a sdasdsa da da as das da d', '2023-09-28 08:32:41'),
(324, 48, 402, 'asoid oisa jdoia jdsoijsaoi odsaij asd', '2023-10-20 12:18:55'),
(325, 1, 401, ' sadasdad asdad asdas asasd asd  sadasd', '2023-11-09 12:29:22');

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
(1386, 400, '2023-09-08 04:47:36', '2023-11-12', '2023-11-10 15:15:15', '0000-00-00', 2, 'Wysłano', '', 6),
(1387, 400, '2023-09-27 18:26:03', '2023-10-01', '0000-00-00 00:00:00', '0000-00-00', 1, 'W trakcie realizacji', 'aosid uaosiud oaisudoiusadsa d', 4),
(1388, 402, '2023-10-20 14:18:35', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00', 1, 'Oczekujące na potwierdzenie', '', 4),
(1389, 400, '2023-11-08 14:10:59', '2023-11-29', '0000-00-00 00:00:00', '0000-00-00', 1, 'W trakcie realizacji', '', 6),
(1390, 400, '2023-11-08 14:11:10', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00', 1, 'Oczekujące na potwierdzenie', '', 4),
(1391, 400, '2023-11-09 13:27:43', '2023-11-30', '2023-11-29 15:35:13', '0000-00-00', 1, 'Wysłano', '', 6),
(1392, 401, '2023-11-09 13:32:52', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00', 1, 'Oczekujące na potwierdzenie', '', 4);

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
(1386, 2, 5),
(1387, 2, 10),
(1388, 48, 5),
(1389, 2, 15),
(1390, 2, 166),
(1391, 1, 1),
(1392, 1, 1);

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
(987, 'a2d5f1d9982198c32f94baeb42d113e69d96262477d6929cdb5c9823a8e7c981', 'b7cfr0na@flymail.tk', '2023-09-07 22:20:44');

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
(1048, 1386, '2023-09-08 04:47:36', 399, 2),
(1049, 1387, '2023-09-27 18:26:03', 765, 2),
(1050, 1388, '2023-10-20 14:18:35', 384.95, 1),
(1051, 1389, '2023-11-08 14:10:59', 1137.5, 1),
(1052, 1390, '2023-11-08 14:11:10', 12538, 1),
(1053, 1391, '2023-11-09 13:27:43', 60.55, 1),
(1054, 1392, '2023-11-09 13:32:52', 65.55, 2);

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
(2, 'PWN', 'Warszawa', '02-460', '+48 839 771 829');

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
(299, 2, 4, 386),
(302, 117, 4, 394),
(303, 117, 2, 395),
(304, 117, 4, 396),
(305, 117, 4, 397),
(306, 117, 5, 398),
(307, 2, 4, 400),
(308, 1, 4, 400),
(309, 48, 4, 402),
(310, 1, 5, 401);

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
(386, 1, 4),
(386, 48, 4),
(401, 1, 1),
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
(3, 'Dla dzieci', 1),
(4, 'Fantastyka', 2),
(5, 'Horror', 3),
(6, 'Komiks', 5),
(7, 'Kryminał', 6),
(8, 'Poezja', 7),
(22, 'Cybersecurity', 4),
(23, 'Mobile App Development', 4),
(24, 'Artificial Intelligence', 4),
(25, 'Cloud Computing', 4),
(26, 'Software Engineering', 4),
(27, 'Game Development', 4),
(28, 'Network Administration', 4),
(29, 'UX/UI Design', 4),
(30, 'Game Development 1', 4),
(31, 'Network Administration 2', 4),
(32, 'Cybersecurity 3', 4),
(33, 'Poezja 2', 9),
(34, 'Data bases', 4);

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
(1, 115, '125'),
(1, 116, '125'),
(1, 120, '125'),
(1, 122, '125'),
(1, 123, '125'),
(2, 1, '15'),
(2, 2, '1'),
(2, 7, '15'),
(2, 35, '0'),
(2, 113, '121');

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
  MODIFY `id_autora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id_ksiazki` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_kategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_komentarza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=326;

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
  MODIFY `id_zamowienia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1393;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=989;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id_platnosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1055;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id_metody_platnosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=311;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id_subkategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
