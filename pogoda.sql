-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 08 Gru 2017, 13:56
-- Wersja serwera: 10.1.28-MariaDB
-- Wersja PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `pogoda`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `app_users`
--

CREATE TABLE `app_users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `roles` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `weather_source` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `app_users`
--

INSERT INTO `app_users` (`id`, `username`, `password`, `email`, `is_active`, `roles`, `weather_source`) VALUES
(1, 'admin', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', 'admin@admin.pl', 1, 'ROLE_USER,ROLE_ADMIN', 'Weatherunlocked');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `base_city` tinyint(1) DEFAULT NULL,
  `geo_lat` decimal(8,2) NOT NULL,
  `geo_lon` decimal(8,2) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `city`
--

INSERT INTO `city` (`id`, `name`, `base_city`, `geo_lat`, `geo_lon`, `user_id`) VALUES
(1, 'Borówki Wielkie Zdrój', 1, '50.00', '50.00', 0),
(2, 'Kraków', NULL, '50.04', '19.56', 1),
(4, 'Łódź', NULL, '51.46', '19.27', 1),
(5, 'Londyn', 1, '51.50', '0.04', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `city_weather`
--

CREATE TABLE `city_weather` (
  `id` int(11) NOT NULL,
  `img` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `temperature` decimal(8,2) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `description` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `wind_speed` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `city_weather`
--

INSERT INTO `city_weather` (`id`, `img`, `temperature`, `city_id`, `description`, `wind_speed`) VALUES
(2, '/assets/icons/PartlyCloudyDay.gif', '5.00', 4, 'Zachmurzenie czesciowe ', '24.00'),
(3, '/assets/icons/PartlyCloudyDay.gif', '5.00', 2, 'Zachmurzenie czesciowe ', '13.00'),
(4, '/assets/icons/PartlyCloudyDay.gif', '5.00', 5, 'Zachmurzenie czesciowe ', '28.00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20171206152948'),
('20171207110847'),
('20171207212833'),
('20171208113033'),
('20171208122933');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C2502824F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_C2502824E7927C74` (`email`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_weather`
--
ALTER TABLE `city_weather`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `city_weather`
--
ALTER TABLE `city_weather`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
