-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 24 Sie 2023, 18:24
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `bookstore`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `adres`
--

CREATE TABLE `adres` (
  `adres_id` int(11) NOT NULL,
  `miejscowosc` varchar(255) NOT NULL,
  `ulica` varchar(255) DEFAULT NULL,
  `numer_domu` varchar(25) NOT NULL,
  `kod_pocztowy` varchar(25) NOT NULL,
  `kod_miejscowosc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `adres`
--

INSERT INTO `adres` (`adres_id`, `miejscowosc`, `ulica`, `numer_domu`, `kod_pocztowy`, `kod_miejscowosc`) VALUES
(32, 'Dębno', 'Mickiewicza', '52', '74-400', 'Dębno'),
(33, 'Chojna', 'Mickiewicza', '52', '74-400', 'Dębno'),
(181, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(182, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(183, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(184, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(185, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(186, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(187, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(188, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(189, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(190, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(191, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(192, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(193, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(194, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(195, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(196, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(197, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(198, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(200, 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno'),
(201, 'Smolnica', '', '67/4', '74-400', 'Dębno');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `autor`
--

CREATE TABLE `autor` (
  `id_autora` int(11) NOT NULL,
  `imie` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `narodowosc` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `okres_tworczosci` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `rodzaj_tworczosci` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `autor`
--

INSERT INTO `autor` (`id_autora`, `imie`, `nazwisko`, `narodowosc`, `okres_tworczosci`, `rodzaj_tworczosci`) VALUES
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
(36, 'Marek', 'Andrzejewski', 'Polska', '1996-1999', 'Poradniki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `formy_dostawy`
--

CREATE TABLE `formy_dostawy` (
  `id_formy_dostawy` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL COMMENT 'forma dostawy',
  `cena` decimal(10,2) NOT NULL COMMENT 'koszt dostawy'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `formy_dostawy`
--

INSERT INTO `formy_dostawy` (`id_formy_dostawy`, `nazwa`, `cena`) VALUES
(1, 'Kurier DPD', '5.00'),
(2, 'Kurier Inpost', '16.50'),
(3, 'Paczkomaty 24/7 (Inpost)', '14.99'),
(4, 'Odbiór w punkcie (Poczta polska)', '9.99'),
(5, 'Odbiór w sklepie (Księgarnia)', '0.00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id_kategorii` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL COMMENT 'nazwa kategorii'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `kategorie`
--

INSERT INTO `kategorie` (`id_kategorii`, `nazwa`) VALUES
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
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
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
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`id_klienta`, `imie`, `nazwisko`, `wojewodztwo`, `kraj`, `PESEL`, `data_urodzenia`, `telefon`, `email`, `login`, `haslo`, `adres_id`) VALUES
(342, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '515039550', 'jakub.wojciechowski.682@gmail.com', NULL, '$2y$10$7cYZCklGN77sksAiEk691.TDRFf9sjWSiuheNAgsgB.WBX31NgqQO', 181),
(343, 'Jan', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak2@wp.pl', NULL, '$2y$10$a5uwQY7GPeU1pKJ/W1YySuTxQvadq5TyDnn.4gEucrZhRKaxmUM/y', 182),
(344, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak5wp.pl', NULL, '$2y$10$dCOhqiZu2ERKFANC26.FoefXkL6T2iXEBxjTUz1o3OnuSa0lbOHAe', 183),
(345, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak3233@wp.pl', NULL, '$2y$10$xtQKPxjc.lS8nQwg7A0pMuW8aWhrx8ETrLxkfLj9FkWHkD3M/3r9a', 184),
(346, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.kowalski313@wp.pl', NULL, '$2y$10$8w8MqQyx3nO6iq787simFuRpgPYXUEHAC85rLs0PsvCzfQWIx9t6C', 185),
(347, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak3@wp.pl', NULL, '$2y$10$hLVtiK/hk1jvemPgsFshB.0lh6NWI/AtHgrlyncX951fGPF/jTmbK', 186),
(348, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak4@wp.pl', NULL, '$2y$10$bYHMA1d570vZyyUvAA9v6ecOykO2Xi1dj4o4kIbe9Vzl33mu6bZGO', 187),
(349, 'Kazimierz', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak6@wp.pl', NULL, '$2y$10$QZj5/Kjyie6jVnrkuSOEXuouhxjETMrYqOjJxednFnYvMa1pgMmIW', 188),
(350, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak7@wp.pl', NULL, '$2y$10$BhDdjS5l5L1YKPUurjrvTOjbI7JcIbyfUZx.BHhcTYfPlkkI7T9SW', 189),
(351, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak8@wp.pl', NULL, '$2y$10$..hf4zhRmWprrvAGyQPgC.EKoYqzvYitp3xge05KYhPieSM./juoK', 190),
(352, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak9@wp.pl', NULL, '$2y$10$2FLYtge6Q4tnpU7rYcA.mOGNDGnLfXgNg1Y9H1YbUcJWYZhFikQwy', 191),
(353, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak10@wp.pl', NULL, '$2y$10$W54Ws8MsKEayne9OVlLoTuB8l0EHYtViVMHJsmGUl2DFXFUZImi4W', 192),
(354, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak11@wp.pl', NULL, '$2y$10$VYNXJH5g.OqtNImxkJbecu4qT60cH.4qVBWL2g5ncMInhjhaeFwSO', 193),
(355, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak12@wp.pl', NULL, '$2y$10$O2X0sIgaoTfFBt8y2ZvN..JRuO4Xc3eXQFmxkEsF70rNUOt4pDtCS', 194),
(356, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak13@wp.pl', NULL, '$2y$10$Tgp35nQd0//76gU5/DxWTOBkiUp0G7AzOZOVqe99TQgfhnetVUCVC', 195),
(357, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak15@wp.pl', NULL, '$2y$10$KNm9Gh.tUFde0LcJLvtqXe5pDn7/iIv94ryna14oewIY1lWrCtHMe', 196),
(358, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak16@wp.pl', NULL, '$2y$10$fKs6lZf182SbdxjCKe6woO5.SxOmyKLSlt//VHo8fdKIbxcx5Xoeq', 197),
(359, 'Adam', 'Nowak', NULL, NULL, NULL, NULL, '505101303', 'adam.nowak200@wp.pl', NULL, '$2y$10$pw0xN7hQ4mW/rTLtgxWKCuVX8AywOEljDWEkwmwN6nVfuaPi3l7dO', 198),
(361, 'Jan', 'Kowalski', NULL, NULL, NULL, NULL, '505101303', 'dft83dh3@spymail.one', NULL, '$2y$10$Vw3Pdeiv7j9gYc.7ZckcnOsvt6DE0SZk0JvkoVosGGdIjjbg7dQRO', 200),
(362, 'Jakub', 'Wojciechowski', NULL, NULL, NULL, NULL, '515350960', 'jakub.wojciechowski.682@gmail.com', NULL, '$2y$10$t0rtETssOrdp/5gHrYc0oeRqrZRnluSjHrpen.l3jVXcO/4yR30AC', 201);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `komentarze`
--

CREATE TABLE `komentarze` (
  `id_komentarza` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `tresc` varchar(255) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `komentarze`
--

INSERT INTO `komentarze` (`id_komentarza`, `id_ksiazki`, `id_klienta`, `tresc`, `data`) VALUES
(255, 1, 342, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', '2023-08-15 15:54:59'),
(256, 35, 342, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', '2023-08-15 17:55:11'),
(257, 1, 343, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', '2023-08-16 13:03:55'),
(258, 114, 342, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', '2023-08-16 15:15:42'),
(259, 114, 343, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit 2', '2023-08-16 15:17:07'),
(260, 1, 347, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', '2023-08-16 16:47:46'),
(261, 1, 348, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit 4', '2023-08-16 22:17:42'),
(262, 2, 342, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', '2023-08-16 22:34:22'),
(263, 2, 343, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', '2023-08-17 01:09:37'),
(264, 1, 349, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit 2', '2023-08-17 02:06:13'),
(265, 116, 342, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit 1', '2023-08-17 05:50:54'),
(266, 48, 342, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', '2023-08-22 03:13:50'),
(268, 36, 342, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', '2023-08-22 06:40:45'),
(269, 36, 362, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', '2023-08-22 07:04:13'),
(270, 36, 348, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', '2023-08-22 07:05:02');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk`
--

CREATE TABLE `koszyk` (
  `id_klienta` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `koszyk`
--

INSERT INTO `koszyk` (`id_klienta`, `id_ksiazki`, `ilosc`) VALUES
(342, 1, 1),
(342, 35, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ksiazki`
--

CREATE TABLE `ksiazki` (
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
-- Zrzut danych tabeli `ksiazki`
--

INSERT INTO `ksiazki` (`id_ksiazki`, `id_autora`, `tytul`, `cena`, `rok_wydania`, `opis`, `oprawa`, `id_wydawcy`, `image_url`, `rating`, `ilosc_stron`, `wymiary`, `stan`, `id_subkategorii`) VALUES
(1, 1, 'Symfonia C++ wydanie V ', 55.55, 2010, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent purus elit, tristique posuere mi sit amet, ullamcorper rutrum ante. Aenean tristique urn>a nec erat ullamcorper commodo. Aenean molestie erat sit amet ante semper vulputate. Morbi ante dolor, mollis a justo eget, semper tempus metus. Sed aliquet vestibulum erat elementum tempus. Pellentesque justo massa, rhoncus in rutrum at, iaculis finibus augue. Sed aliquet tempus nulla, id fringilla quam varius dapibus. Mauris ultricies lectus nisi, nec pulvinar diam dapibus at. Morbi tempus tincidunt odio eget tincidunt. Ut quis varius urna, eget posuere magna. Nulla feugiat laoreet ligula, ac efficitur orci pulvinar sed. Pellentesque ligula urna, congue vitae congue et, hendrerit eget sem. Phasellus posuere, ex eu gravida ullamcorper, sapien justo suscipit quam, in varius turpis ex ut quam. Nulla in efficitur quam. Vivamus ut elementum lectus.', 'twarda', 1, 'csymfoni_wyd_V.png', 3.4, 520, '138 x 928 x 281', 'nowa', 1),
(2, 2, 'PHP i MySQL. Od podstaw. Wydanie IV', 75.5, 2012, 'Java jest dojrzałym językiem programowania, który pozwala na pisanie kodu dla wielu rodzajów komputerów służących do różnych celów i działających na różnych platformach. Jest świetnym wyborem dla programistów, którym zależy na tworzeniu bezpiecznych aplikacji o wyjątkowej jakości. Wokół Javy skupia się duża społeczność, dzięki której język ten wciąż się rozwija, unowocześnia i wzbogaca o nowe elementy. Osoby, które swoje zawodowe życie wiążą z pisaniem programów w Javie, muszą poznać zaawansowane zagadnienia i mniej oczywiste funkcjonalności Javy, również te niedawno zaimplementowane. To konieczność dla każdego profesjonalnego programisty Javy.  Oto kolejne, przejrzane, zaktualizowane i uzupełnione wydanie znakomitego podręcznika dla zawodowych programistów Javy. Znalazł się tu dokładny opis sposobów tworzenia interfejsu użytkownika, stosowania rozwiązań korporacyjnych, sieciowych i zabezpieczeń, a także nowości wprowadzonych w JDK 11. Przedstawiono techniki programowania baz danych or', 'twarda', 2, 'podstawy_PHP.png', 2.5, 748, '253 x 938 x 029', 'nowa', 2),
(5, 33, 'Mała kaczka w rzece hahahahahaa. Mała kaczka w rzece hahahahahaa', 97.1, 2010, NULL, 'Twarda', 1, '', 0, 240, '432 x 65 x 31', 'nowa', 3),
(6, 22, 'Nadzieja dla mojej dziewczyny', 14.54, 2000, NULL, 'Miękka', 1, '', 0, 358, '460 x 209 x 165', 'nowa', 8),
(7, 33, 'Duchy i lisy', 58.82, 2006, 'Lorem Ipsum', 'twarda', 1, '00000.jpg', 4, 117, '200 x 50 x 426', 'nowa', 3),
(8, 19, 'Witaj w moim kraju', 96.55, 2003, NULL, 'Miękka', 1, '', 0, 263, '117 x 305 x 173', 'nowa', 4),
(9, 23, 'Drzewa i przestępcy', 15.35, 2011, NULL, 'Twarda', 1, '', 2, 866, '453 x 247 x 375', 'nowa', 7),
(10, 17, 'Dzieci w mojej szafie', 31.08, 2012, NULL, 'Twarda', 1, '', 3, 889, '135 x 48 x 339', 'nowa', 5),
(11, 17, 'Demony i sępy', 72.73, 2012, NULL, 'Twarda', 1, '', 0, 896, '51 x 239 x 40', 'nowa', 5),
(12, 17, 'Pokusa na cmentarzu', 59.99, 2005, NULL, 'Miękka', 1, '', NULL, 861, '485 x 307 x 77', 'nowa', 5),
(13, 22, 'Stając się moim mężem', 27.11, 2003, NULL, 'Miękka', 1, '', 0, 667, '467 x 104 x 121', 'nowa', 8),
(14, 19, 'Prześladowca bez sumienia', 92.53, 1997, NULL, 'Twarda', 1, '', 0, 652, '294 x 108 x 156', 'nowa', 4),
(16, 19, 'Kobiety i złodzieje', 40.5, 1995, NULL, 'Miękka', 1, '', 4, 336, '178 x 210 x 17', 'nowa', 4),
(18, 18, 'D', 8, 1996, NULL, 'Twarda', 1, '', NULL, 472, '416 x 446 x 483', 'nowa', 6),
(20, 36, 'Świętowanie wodą', 81.59, 2006, NULL, 'Twarda', 1, '', NULL, 293, '76 x 433 x 438', 'nowa', 3),
(21, 23, 'Wrogowie gwiazdy', 16.29, 2014, NULL, 'Twarda', 1, '', 0, 799, '391 x 143 x 40', 'nowa', 7),
(22, 25, 'Biesy i upiory', 85.07, 1993, NULL, 'Miękka', 1, '', 0, 463, '274 x 250 x 430', 'nowa', 5),
(23, 17, 'Sępy i sępy', 45.61, 2008, NULL, 'Miękka', 1, '', 3, 669, '400 x 211 x 353', 'nowa', 5),
(24, 19, 'Wrogowie z determinacją', 81.12, 2003, NULL, 'Twarda', 1, '', 4, 155, '136 x 119 x 188', 'nowa', 4),
(25, 25, 'Symbole w Bibliotece', 20.66, 1995, NULL, 'Miękka', 1, '', 0, 370, '83 x 352 x 45', 'nowa', 5),
(26, 25, 'Pokusa na cmentarzu 2', 87.4, 1994, NULL, 'Miękka', 1, '', 5, 433, '495 x 444 x 238', 'nowa', 5),
(27, 23, 'Bohaterowie i psy', 85.6, 2017, NULL, 'Miękka', 1, '', 1, 108, '359 x 81 x 330', 'nowa', 7),
(28, 19, 'Schronienie w magii', 40.9, 1994, NULL, 'Twarda', 1, '', 0, 840, '407 x 45 x 35', 'nowa', 4),
(29, 19, 'Żołnierze Ognia', 32.16, 2003, NULL, 'Twarda', 1, '', NULL, 375, '383 x 404 x 374', 'nowa', 4),
(30, 2, 'A', 7, 2000, NULL, 'miękka', 1, '', 3, 105, '159 x 173 x 390', 'nowa', 6),
(31, 32, 'B', 17, 2002, NULL, 'miękka', 1, '', 0, 151, '431 x 485 x 134', 'nowa', 6),
(32, 32, 'Ą', 13, 2001, NULL, 'twarda', 1, '', 0, 341, '212 x 161 x 171', 'nowa', 6),
(35, 32, 'Java - Techniki zaawansowane Wydanie V', 50, 2018, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis tortor non sem euismod fermentum. Sed congue ultricies ipsum non porta. Morbi ut interdum ipsum. Morbi cursus diam semper, mattis ante rutrum, feugiat dolor. Nulla semper vulputate elit nec condimentum. Nam vel lacus eu odio facilisis tincidunt. Nullam a neque massa. Ut quis auctor quam. Sed accumsan dui in sem efficitur cursus. Duis vestibulum leo nisi, at fringilla quam dapibus et. Donec euismod velit id dolor pharetra tempor. Nulla auctor dictum urna eu gravida. Donec tristique in mauris tincidunt imperdiet. In at justo vel metus congue iaculis ut aliquam ex. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae', 'twarda', 1, 'Java_techniki_zaawansowane.png', 4, 325, '370 x 337 x 76', 'nowa', 1),
(36, 32, 'CSS Nieoficjalny podręcznik', 20, 2016, 'opis CSS', 'twarda', 1, 'CSS_Nieoficjalny_podręcznik.png', 3.6667, 425, '837 x 773 x 253', 'nowa', 2),
(48, 2, 'phms4v', 65.55, 2015, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'twarda', 1, 'phms4v.jpg', 4, 425, '125 x 730 x 310', 'nowa', 1),
(113, 14, 'nowa super ksiazka', 12.12, 2013, '12 12 12 12 12 12 12 ', 'twarda', 2, '00000.jpg', 0, 1212, '121 x 121 x 121', 'nowa', 7),
(114, 1, '2021 Symfonia C++', 65.55, 2015, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'twarda', 1, 'phms4v.jpg', 4.5, 425, '125 x 730 x 310', 'nowa', 2),
(115, 1, 'Symfonia C++', 65.55, 2015, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Twarda', 1, 'csymfoni_wyd_V.png', 0, 425, '125 x 730 x 310', 'nowa', 3),
(116, 1, '22 Symfonia C++', 65.55, 2015, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'twarda', 1, 'phms4v.jpg', 4, 425, '125 x 730 x 310', 'nowa', 1),
(117, 2, 'la', 25, 2000, NULL, 'miękka', 1, '', 0, 105, '159 x 173 x 390', 'nowa', 24),
(118, 2, 'ła', 26, 2000, NULL, 'miękka', 1, '', 0, 105, '159 x 173 x 390', 'nowa', 24);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `magazyn`
--

CREATE TABLE `magazyn` (
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
-- Zrzut danych tabeli `magazyn`
--

INSERT INTO `magazyn` (`id_magazynu`, `nazwa`, `kraj`, `wojewodztwo`, `miejscowosc`, `ulica`, `numer_ulicy`, `kod_pocztowy`, `kod_miejscowosc`) VALUES
(1, 'magazyn nr 1', 'Polska', 'Zachodmiopomorskie', 'Szczecin', 'Fryderyka Chopina ', 3, '800-21', 'Szczecin'),
(2, 'magazyn nr 2', 'Polska', 'Zachodmiopomorskie', 'Police', 'Fryderyka Chopina ', 3, '800-21', 'Szczecin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `magazyn_ksiazki`
--

CREATE TABLE `magazyn_ksiazki` (
  `id_magazynu` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `ilosc_dostepnych_egzemplarzy` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `magazyn_ksiazki`
--

INSERT INTO `magazyn_ksiazki` (`id_magazynu`, `id_ksiazki`, `ilosc_dostepnych_egzemplarzy`) VALUES
(1, 1, '15'),
(1, 2, '0'),
(1, 7, '15'),
(1, 35, '23'),
(1, 36, '0'),
(1, 48, '60'),
(1, 114, '132'),
(1, 115, '125'),
(1, 116, '125'),
(2, 35, '0'),
(2, 113, '121');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `metody_platnosci`
--

CREATE TABLE `metody_platnosci` (
  `id_metody_platnosci` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL COMMENT 'sposób płatności (np "Przelew tradycyjny", "PayPal", "Karta kredytowa" ...)',
  `oplata` decimal(10,2) DEFAULT 0.00 COMMENT '(np. jeżeli za wybraną metodę płatności jest dodatkowa opłata, tak jak dla płatności za pobraniem)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `metody_platnosci`
--

INSERT INTO `metody_platnosci` (`id_metody_platnosci`, `nazwa`, `oplata`) VALUES
(1, 'Blik', '0.00'),
(2, 'Pobranie', '5.00'),
(3, 'Karta płatnicza (online)', '0.00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `token_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL COMMENT 'adres e-mail klienta',
  `exp_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`token_id`, `token`, `email`, `exp_time`) VALUES
(705, 'aaa 3', 'jakub.wojciechowski.682@gmail.com', '2023-08-19 00:39:37');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `platnosci`
--

CREATE TABLE `platnosci` (
  `id_platnosci` int(11) NOT NULL,
  `id_zamowienia` int(11) NOT NULL,
  `data_platnosci` datetime NOT NULL,
  `kwota` float NOT NULL,
  `id_metody_platnosci` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `platnosci`
--

INSERT INTO `platnosci` (`id_platnosci`, `id_zamowienia`, `data_platnosci`, `kwota`, `id_metody_platnosci`) VALUES
(878, 1216, '2023-08-24 00:19:52', 115.55, 2),
(879, 1217, '2023-08-24 00:22:39', 110.55, 1),
(880, 1218, '2023-08-24 01:00:14', 110.55, 1),
(881, 1219, '2023-08-24 01:01:48', 110.55, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
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
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`id_pracownika`, `imie`, `nazwisko`, `email`, `haslo`, `wynagrodzenie`, `stanowisko`, `data_zatrudnienia`, `telefon`, `adres_id`) VALUES
(4, 'Jan', 'Nowak', 'jan.nowak@wp.pl', '$2y$10$NEm7t60JIe9OD7OdHyHn.OosZRExCCnW13E/mDtH2PJ886IjbrzIu', '2758.00', 'sprzedawca', '2023-04-25', '647918229', 32),
(6, 'Adam', 'Kowalski', 'adam.nowak@wp.pl', '$2y$10$r2v0wivXQWdE2nAwe4vXS.uKGcudxJSRjcFlOL4gtAdMgfle.SiBm', '3758.00', 'sprzedawca', '2023-04-25', '647918229', 33);

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
-- Zrzut danych tabeli `ratings`
--

INSERT INTO `ratings` (`id_oceny`, `id_ksiazki`, `ocena`, `id_klienta`) VALUES
(244, 1, 3, 342),
(245, 35, 4, 342),
(246, 1, 4, 343),
(247, 114, 5, 342),
(248, 114, 4, 343),
(249, 1, 4, 347),
(250, 1, 4, 348),
(251, 2, 4, 342),
(252, 2, 1, 343),
(253, 1, 2, 349),
(254, 116, 4, 342),
(255, 48, 4, 342),
(257, 36, 4, 342),
(258, 36, 3, 362),
(259, 36, 4, 348);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `subkategorie`
--

CREATE TABLE `subkategorie` (
  `id_subkategorii` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL COMMENT 'nazwa podkategorii',
  `id_kategorii` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `subkategorie`
--

INSERT INTO `subkategorie` (`id_subkategorii`, `nazwa`, `id_kategorii`) VALUES
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
(33, 'Poezja 2', 9);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegoly_zamowienia`
--

CREATE TABLE `szczegoly_zamowienia` (
  `id_zamowienia` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `ilosc` smallint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `szczegoly_zamowienia`
--

INSERT INTO `szczegoly_zamowienia` (`id_zamowienia`, `id_ksiazki`, `ilosc`) VALUES
(1216, 1, 1),
(1216, 35, 1),
(1217, 1, 1),
(1217, 35, 1),
(1218, 1, 1),
(1218, 35, 1),
(1219, 1, 1),
(1219, 35, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wydawcy`
--

CREATE TABLE `wydawcy` (
  `id_wydawcy` int(11) NOT NULL,
  `nazwa_wydawcy` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `kod_pocztowy` varchar(6) NOT NULL,
  `telefon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `wydawcy`
--

INSERT INTO `wydawcy` (`id_wydawcy`, `nazwa_wydawcy`, `adres`, `kod_pocztowy`, `telefon`) VALUES
(1, 'Helion', 'Warszawa', '500-31', '+48 018 938 922'),
(2, 'PWN', 'Warszawa', '02-460', '+48 839 771 829');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
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
-- Zrzut danych tabeli `zamowienia`
--

INSERT INTO `zamowienia` (`id_zamowienia`, `id_klienta`, `data_zlozenia_zamowienia`, `termin_dostawy`, `data_wysłania_zamowienia`, `data_dostarczenia`, `id_formy_dostawy`, `status`, `komentarz`, `id_pracownika`) VALUES
(1216, 342, '2023-08-24 00:19:52', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00', 1, 'Oczekujące na potwierdzenie', '', 4),
(1217, 342, '2023-08-24 00:22:39', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00', 1, 'Oczekujące na potwierdzenie', '', 6),
(1218, 342, '2023-08-24 01:00:14', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00', 1, 'Oczekujące na potwierdzenie', '', 4),
(1219, 342, '2023-08-24 01:01:48', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00', 1, 'Oczekujące na potwierdzenie', '', 6);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `adres`
--
ALTER TABLE `adres`
  ADD PRIMARY KEY (`adres_id`);

--
-- Indeksy dla tabeli `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id_autora`);

--
-- Indeksy dla tabeli `formy_dostawy`
--
ALTER TABLE `formy_dostawy`
  ADD PRIMARY KEY (`id_formy_dostawy`);

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id_kategorii`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id_klienta`),
  ADD UNIQUE KEY `adres_id` (`adres_id`),
  ADD KEY `email` (`email`);

--
-- Indeksy dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  ADD PRIMARY KEY (`id_komentarza`),
  ADD UNIQUE KEY `id_ksiazki_2` (`id_ksiazki`,`id_klienta`),
  ADD KEY `id_ksiazki` (`id_ksiazki`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  ADD PRIMARY KEY (`id_klienta`,`id_ksiazki`),
  ADD KEY `id_ksiazki` (`id_ksiazki`);

--
-- Indeksy dla tabeli `ksiazki`
--
ALTER TABLE `ksiazki`
  ADD PRIMARY KEY (`id_ksiazki`),
  ADD KEY `id_autora` (`id_autora`),
  ADD KEY `id_wydawcy` (`id_wydawcy`),
  ADD KEY `id_subkategorii` (`id_subkategorii`);

--
-- Indeksy dla tabeli `magazyn`
--
ALTER TABLE `magazyn`
  ADD PRIMARY KEY (`id_magazynu`);

--
-- Indeksy dla tabeli `magazyn_ksiazki`
--
ALTER TABLE `magazyn_ksiazki`
  ADD PRIMARY KEY (`id_magazynu`,`id_ksiazki`),
  ADD KEY `id_ksiazki` (`id_ksiazki`);

--
-- Indeksy dla tabeli `metody_platnosci`
--
ALTER TABLE `metody_platnosci`
  ADD PRIMARY KEY (`id_metody_platnosci`);

--
-- Indeksy dla tabeli `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `email` (`email`);

--
-- Indeksy dla tabeli `platnosci`
--
ALTER TABLE `platnosci`
  ADD PRIMARY KEY (`id_platnosci`),
  ADD UNIQUE KEY `id_zamowienia` (`id_zamowienia`),
  ADD KEY `sposob_platnosci` (`id_metody_platnosci`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id_pracownika`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `adres_id` (`adres_id`),
  ADD KEY `id_pracownika` (`id_pracownika`);

--
-- Indeksy dla tabeli `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id_oceny`),
  ADD UNIQUE KEY `id_ksiazki` (`id_ksiazki`,`id_klienta`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `subkategorie`
--
ALTER TABLE `subkategorie`
  ADD PRIMARY KEY (`id_subkategorii`),
  ADD KEY `id_kategorii` (`id_kategorii`);

--
-- Indeksy dla tabeli `szczegoly_zamowienia`
--
ALTER TABLE `szczegoly_zamowienia`
  ADD PRIMARY KEY (`id_zamowienia`,`id_ksiazki`),
  ADD KEY `id_ksiazki` (`id_ksiazki`);

--
-- Indeksy dla tabeli `wydawcy`
--
ALTER TABLE `wydawcy`
  ADD PRIMARY KEY (`id_wydawcy`),
  ADD UNIQUE KEY `nazwa_wydawcy` (`nazwa_wydawcy`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id_zamowienia`),
  ADD KEY `id_klienta` (`id_klienta`),
  ADD KEY `id_pracownika` (`id_pracownika`),
  ADD KEY `id_formy_dostawy` (`id_formy_dostawy`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `adres`
--
ALTER TABLE `adres`
  MODIFY `adres_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT dla tabeli `autor`
--
ALTER TABLE `autor`
  MODIFY `id_autora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT dla tabeli `formy_dostawy`
--
ALTER TABLE `formy_dostawy`
  MODIFY `id_formy_dostawy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id_kategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=363;

--
-- AUTO_INCREMENT dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  MODIFY `id_komentarza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- AUTO_INCREMENT dla tabeli `ksiazki`
--
ALTER TABLE `ksiazki`
  MODIFY `id_ksiazki` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT dla tabeli `metody_platnosci`
--
ALTER TABLE `metody_platnosci`
  MODIFY `id_metody_platnosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=778;

--
-- AUTO_INCREMENT dla tabeli `platnosci`
--
ALTER TABLE `platnosci`
  MODIFY `id_platnosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=882;

--
-- AUTO_INCREMENT dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id_pracownika` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id pracownika', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT dla tabeli `subkategorie`
--
ALTER TABLE `subkategorie`
  MODIFY `id_subkategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id_zamowienia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1220;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD CONSTRAINT `address_id` FOREIGN KEY (`adres_id`) REFERENCES `adres` (`adres_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  ADD CONSTRAINT `komentarze_ibfk_1` FOREIGN KEY (`id_ksiazki`) REFERENCES `ksiazki` (`id_ksiazki`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentarze_ibfk_2` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  ADD CONSTRAINT `koszyk_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `koszyk_ibfk_2` FOREIGN KEY (`id_ksiazki`) REFERENCES `ksiazki` (`id_ksiazki`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `ksiazki`
--
ALTER TABLE `ksiazki`
  ADD CONSTRAINT `ksiazki_ibfk_1` FOREIGN KEY (`id_autora`) REFERENCES `autor` (`id_autora`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ksiazki_ibfk_2` FOREIGN KEY (`id_wydawcy`) REFERENCES `wydawcy` (`id_wydawcy`) ON DELETE CASCADE,
  ADD CONSTRAINT `ksiazki_ibfk_3` FOREIGN KEY (`id_subkategorii`) REFERENCES `subkategorie` (`id_subkategorii`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `magazyn_ksiazki`
--
ALTER TABLE `magazyn_ksiazki`
  ADD CONSTRAINT `magazyn_ksiazki_ibfk_1` FOREIGN KEY (`id_magazynu`) REFERENCES `magazyn` (`id_magazynu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `magazyn_ksiazki_ibfk_2` FOREIGN KEY (`id_ksiazki`) REFERENCES `ksiazki` (`id_ksiazki`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`email`) REFERENCES `klienci` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `platnosci`
--
ALTER TABLE `platnosci`
  ADD CONSTRAINT `platnosci_ibfk_1` FOREIGN KEY (`id_zamowienia`) REFERENCES `zamowienia` (`id_zamowienia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `platnosci_ibfk_2` FOREIGN KEY (`id_metody_platnosci`) REFERENCES `metody_platnosci` (`id_metody_platnosci`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD CONSTRAINT `pracownicy_ibfk_1` FOREIGN KEY (`adres_id`) REFERENCES `adres` (`adres_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`id_ksiazki`) REFERENCES `ksiazki` (`id_ksiazki`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `subkategorie`
--
ALTER TABLE `subkategorie`
  ADD CONSTRAINT `subkategorie_ibfk_1` FOREIGN KEY (`id_kategorii`) REFERENCES `kategorie` (`id_kategorii`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `szczegoly_zamowienia`
--
ALTER TABLE `szczegoly_zamowienia`
  ADD CONSTRAINT `szczegoly_zamowienia_ibfk_1` FOREIGN KEY (`id_zamowienia`) REFERENCES `zamowienia` (`id_zamowienia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `szczegoly_zamowienia_ibfk_2` FOREIGN KEY (`id_ksiazki`) REFERENCES `ksiazki` (`id_ksiazki`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zamowienia_ibfk_2` FOREIGN KEY (`id_pracownika`) REFERENCES `pracownicy` (`id_pracownika`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `zamowienia_ibfk_3` FOREIGN KEY (`id_formy_dostawy`) REFERENCES `formy_dostawy` (`id_formy_dostawy`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
