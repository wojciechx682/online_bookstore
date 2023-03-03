-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 31 Gru 2022, 17:03
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.1.12

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
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int(11) NOT NULL,
  `imie` varchar(255) DEFAULT NULL,
  `nazwisko` varchar(255) DEFAULT NULL,
  `miejscowosc` varchar(255) DEFAULT NULL,
  `ulica` varchar(255) DEFAULT NULL,
  `numer_domu` varchar(10) DEFAULT NULL,
  `kod_pocztowy` varchar(7) DEFAULT NULL,
  `kod_miejscowosc` varchar(255) DEFAULT NULL,
  `wojewodztwo` varchar(255) DEFAULT NULL,
  `kraj` varchar(255) DEFAULT NULL,
  `PESEL` varchar(11) DEFAULT NULL,
  `data_urodzenia` date DEFAULT NULL,
  `telefon` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `haslo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`id_klienta`, `imie`, `nazwisko`, `miejscowosc`, `ulica`, `numer_domu`, `kod_pocztowy`, `kod_miejscowosc`, `wojewodztwo`, `kraj`, `PESEL`, `data_urodzenia`, `telefon`, `email`, `login`, `haslo`) VALUES
(1, 'Jakub', 'Wojciechowski', 'Smolnica', '--', '67/4', '74-400', 'Dębno', 'Zachodniopomorskie', 'Polska', '99082807355', '0000-00-00', '515350960', 'jason1@wp.pl', 'jason1', '$2y$10$WgqXUunJSSyhXUzbtoRceuO3hhwxxShcVlblr/UE2rELhk03KdTPC'),
(3, 'Tomas', 'Edison', 'abcde', 'fghi', 'jklm', '12', 'Dębno', 'asd', 'PL', 'asd', '0000-00-00', '123123123', 'tomas1@wp.pl', 'Tomas111', '$2y$10$wHoW1LjwjDESsTV0JwWkOOYLesP/c4OUV1.emGsA35j3U57jFdk5O'),
(5, 'Adam', 'Kowalski', 'Smolnica', '54', '13', '74-400', 'Dębno', 'Zachodniopomorskie', 'Polska', '11121314150', '0000-00-00', '505 422 309', 'adam_kowal@wp.pl', 'adam3000', '$2y$10$dY1J2B9nFjF6mPdFOV8uQOla/CF2U//IzCuXrHswrWqCC228b8kU2'),
(6, 'Stefan', 'Żyromski', 'Czechociny', 'Studniowa', '15', '45-640', 'Warszawa', 'Czechosłowackie', 'Chiny', '00273827351', '0000-00-00', '530938222', 'stefan2@wp.pl', 'stefan2', '$2y$10$7o7B0nLjcv60H84mvDJqKeXLn3lz5ahf8kPEjhw0c05fWbu2YLYtG'),
(7, 'Hubert', 'Zmysłowski', 'Gorzów', 'Kaliszowa', '59', '34-130', 'Gorzów Wielkopolski', 'Zachodniopomorskie', 'Polska', '99082807355', '0000-00-00', '827938192', 'hubert61312@wp.pl', 'hubert1', '$2y$10$CmV0gCewin/EhtrHN5JL7.Ls2wCt.5Ft0I4b5efvRTM95sN6uj1J.'),
(8, 'Paweł', 'Michalczyk', 'Dolna odra', 'Słoneczna', '61', '64-600', 'Dębno', ' ', ' ', ' ', '0000-00-00', '505101303', 'pawel12@wp.pl', ' ', '$2y$10$RxMXwiozbYXJvA7JSJ6Hku7uCFTvtWKjtbJk48sIUkLyoOi.TbkBu'),
(10, 'Kamil', 'Nowak', 'Szczecin', 'Chopina', '55', '71-450', 'Szczecin', ' ', ' ', ' ', '0000-00-00', '506684852', 'kamil14@wp.pl', ' ', '$2y$10$LaCiEfusa2HnVLQ//w9D2ONzL9t3FJRwiJt5tEy3cygR5IkwVXmeu');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `komentarze`
--

CREATE TABLE `komentarze` (
  `id_komentarza` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `tresc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

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
(1, 1, 1),
(1, 2, 2),
(8, 9, 3),
(8, 21, 4),
(8, 27, 5),
(10, 30, 1),
(10, 31, 2),
(10, 32, 3);

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
  `kategoria` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `oprawa` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `id_wydawcy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `ksiazki`
--

INSERT INTO `ksiazki` (`id_ksiazki`, `id_autora`, `tytul`, `cena`, `rok_wydania`, `kategoria`, `oprawa`, `id_wydawcy`) VALUES
(1, 1, 'Symfonia C++ wydanie V', 59.99, 2005, 'Informatyka', 'miękka', 1),
(2, 2, 'Podstawy PHP', 74.99, 2014, 'Informatyka', 'twarda', 1),
(5, 33, 'Mała kaczka w rzece', 97.1, 2010, 'Dla dzieci', 'Twarda', 1),
(6, 22, 'Nadzieja dla mojej dziewczyny', 14.54, 2000, 'Poezja', 'Miękka', 1),
(7, 33, 'Duchy i lisy', 58.82, 2006, 'Dla dzieci', 'Twarda', 1),
(8, 19, 'Witaj w moim kraju', 96.55, 2003, 'Fantastyka', 'Miękka', 1),
(9, 23, 'Drzewa i przestępcy', 15.35, 2011, 'Kryminał', 'Twarda', 1),
(10, 17, 'Dzieci w mojej szafie', 31.08, 2012, 'Horror', 'Twarda', 1),
(11, 17, 'Demony i sępy', 72.73, 2012, 'Horror', 'Twarda', 1),
(12, 17, 'Pokusa na cmentarzu', 59.99, 2005, 'Horror', 'Miękka', 1),
(13, 22, 'Stając się moim mężem', 27.11, 2003, 'Poezja', 'Miękka', 1),
(14, 19, 'Prześladowca bez sumienia', 92.53, 1997, 'Fantastyka', 'Twarda', 1),
(15, 22, 'Kolega o niebieskich oczach', 79.22, 1996, 'Poezja', 'Twarda', 1),
(16, 19, 'Kobiety i złodzieje', 40.5, 1995, 'Fantastyka', 'Miękka', 1),
(17, 22, 'Żona Radości', 63.49, 2000, 'Poezja', 'Miękka', 1),
(18, 18, 'D', 17, 1996, 'Komiks', 'Twarda', 1),
(20, 33, 'Świętowanie wodą', 81.59, 2006, 'Dla dzieci', 'Twarda', 1),
(21, 23, 'Wrogowie gwiazdy', 16.29, 2014, 'Kryminał', 'Twarda', 1),
(22, 25, 'Biesy i upiory', 85.07, 1993, 'Horror', 'Miękka', 1),
(23, 17, 'Sępy i sępy', 45.61, 2008, 'Horror', 'Miękka', 1),
(24, 19, 'Wrogowie z determinacją', 81.12, 2003, 'Fantastyka', 'Twarda', 1),
(25, 25, 'Symbole w Bibliotece', 20.66, 1995, 'Horror', 'Miękka', 1),
(26, 25, 'Pokusa na cmentarzu 2', 87.4, 1994, 'Horror', 'Miękka', 1),
(27, 23, 'Bohaterowie i psy', 85.6, 2017, 'Kryminał', 'Miękka', 1),
(28, 19, 'Schronienie w magii', 40.9, 1994, 'Fantastyka', 'Twarda', 1),
(29, 19, 'Żołnierze Ognia', 32.16, 2003, 'Fantastyka', 'Twarda', 1),
(30, 2, 'A', 13, 2000, 'Komiks', 'miękka', 1),
(31, 32, 'B', 8, 2002, 'Komiks', 'miękka', 1),
(32, 32, 'C', 19, 2001, 'Komiks', 'twarda', 1),
(33, 19, 'Schronienie w magii 2', 40.9, 1994, 'Średniowiecze', 'Twarda', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `magazyn`
--

CREATE TABLE `magazyn` (
  `id_magazynu` int(11) NOT NULL,
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

INSERT INTO `magazyn` (`id_magazynu`, `kraj`, `wojewodztwo`, `miejscowosc`, `ulica`, `numer_ulicy`, `kod_pocztowy`, `kod_miejscowosc`) VALUES
(1, 'Polska', 'Zachodmiopomorskie', 'Szczecin', 'Fryderyka Chopina ', 3, '800-21', 'Szczecin');

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
(1, 1, '435'),
(1, 2, '235');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `platnosci`
--

CREATE TABLE `platnosci` (
  `id_platnosci` int(11) NOT NULL,
  `id_zamowienia` int(11) NOT NULL,
  `data_platnosci` datetime NOT NULL,
  `kwota` float NOT NULL,
  `sposob_platnosci` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `platnosci`
--

INSERT INTO `platnosci` (`id_platnosci`, `id_zamowienia`, `data_platnosci`, `kwota`, `sposob_platnosci`) VALUES
(82, 85, '2022-12-31 16:45:16', 344.95, 'Blik'),
(83, 86, '2022-12-31 16:46:56', 539.21, 'Pobranie'),
(84, 87, '2022-12-31 16:53:26', 86, 'Karta płatnicza (online)'),
(86, 89, '2022-12-31 17:01:52', 209.97, 'Blik');

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
(85, 1, 2),
(85, 2, 3),
(86, 9, 3),
(86, 21, 4),
(86, 27, 5),
(87, 30, 1),
(87, 31, 2),
(87, 32, 3),
(89, 1, 1),
(89, 2, 2);

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
(1, 'Helion', 'Warszawa', '500-31', '+48 018 938 922');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id_zamowienia` int(11) NOT NULL,
  `id_klienta` int(11) DEFAULT NULL,
  `data_zlozenia_zamowienia` datetime NOT NULL,
  `termin_dostawy` date NOT NULL,
  `data_wysłania_zamowienia` datetime NOT NULL,
  `data_dostarczenia` date NOT NULL,
  `forma_dostarczenia` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `zamowienia`
--

INSERT INTO `zamowienia` (`id_zamowienia`, `id_klienta`, `data_zlozenia_zamowienia`, `termin_dostawy`, `data_wysłania_zamowienia`, `data_dostarczenia`, `forma_dostarczenia`, `status`) VALUES
(85, 1, '2022-12-31 16:45:16', '2023-01-05', '2023-01-01 16:45:16', '2023-01-05', 'Kurier DPD', 'Wysłano'),
(86, 8, '2022-12-31 16:46:56', '2023-01-05', '2023-01-01 16:46:56', '2023-01-05', 'Kurier Inpost', 'W trakcie realizacji'),
(87, 10, '2022-12-31 16:53:26', '2023-01-05', '2023-01-01 16:53:26', '2023-01-05', 'Paczkomaty 24/7 (Inpost)', 'W trakcie realizacji'),
(89, 1, '2022-12-31 17:01:52', '2023-01-05', '2023-01-01 17:01:52', '2023-01-05', 'Odbi&oacute;r w punkcie (Poczta polska)', 'W trakcie realizacji');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id_autora`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id_klienta`);

--
-- Indeksy dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  ADD PRIMARY KEY (`id_komentarza`),
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
  ADD KEY `id_wydawcy` (`id_wydawcy`);

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
-- Indeksy dla tabeli `platnosci`
--
ALTER TABLE `platnosci`
  ADD PRIMARY KEY (`id_platnosci`),
  ADD KEY `id_zamowienia` (`id_zamowienia`);

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
  ADD PRIMARY KEY (`id_wydawcy`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id_zamowienia`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `autor`
--
ALTER TABLE `autor`
  MODIFY `id_autora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  MODIFY `id_komentarza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `ksiazki`
--
ALTER TABLE `ksiazki`
  MODIFY `id_ksiazki` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT dla tabeli `platnosci`
--
ALTER TABLE `platnosci`
  MODIFY `id_platnosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id_zamowienia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Ograniczenia dla zrzutów tabel
--

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
  ADD CONSTRAINT `ksiazki_ibfk_2` FOREIGN KEY (`id_wydawcy`) REFERENCES `wydawcy` (`id_wydawcy`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `magazyn_ksiazki`
--
ALTER TABLE `magazyn_ksiazki`
  ADD CONSTRAINT `magazyn_ksiazki_ibfk_1` FOREIGN KEY (`id_magazynu`) REFERENCES `magazyn` (`id_magazynu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `magazyn_ksiazki_ibfk_2` FOREIGN KEY (`id_ksiazki`) REFERENCES `ksiazki` (`id_ksiazki`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `platnosci`
--
ALTER TABLE `platnosci`
  ADD CONSTRAINT `platnosci_ibfk_1` FOREIGN KEY (`id_zamowienia`) REFERENCES `zamowienia` (`id_zamowienia`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;