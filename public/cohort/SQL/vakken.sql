-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 30 mrt 2021 om 10:52
-- Serverversie: 8.0.21-0ubuntu0.20.04.4
-- PHP-versie: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cohorten`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vakken`
--

CREATE TABLE `vakken` (
  `vid` int NOT NULL,
  `vakCode` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `vakNaam` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `volgorde` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `vakken`
--

INSERT INTO `vakken` (`vid`, `vakCode`, `vakNaam`, `volgorde`) VALUES
(1, 'NE', 'Nederlands', 10),
(2, 'EN', 'Engels', 20),
(3, 'DU', 'Duits', 30),
(4, 'FA', 'Frans', 40),
(5, 'GDL', 'godsdienst', 42),
(6, 'LO', 'Lichamelijke Opvoeding', 43),
(7, 'MA', 'maatschappijleer', 45),
(8, 'CKV', 'CKV', 147),
(9, 'WA', 'wiskunde A', 50),
(10, 'WB', 'wiskunde B', 60),
(11, 'WC', 'wiskunde C', 70),
(12, 'WD', 'wiskunde D', 80),
(13, 'WI', 'wiskunde', 81),
(14, 'IF', 'informatica', 90),
(15, 'NA', 'natuurkunde', 100),
(16, 'NASK1', 'NaSk1', 101),
(17, 'SK', 'scheikunde', 110),
(18, 'NASK2', 'NaSk2', 111),
(19, 'BIO', 'biologie', 120),
(20, 'NLT', 'Natuur Leven en Technologie', 130),
(21, 'GS', 'geschiedenis', 140),
(22, 'AK', 'aardrijkskunde', 150),
(23, 'EC', 'economie', 160),
(24, 'BECO', 'BECO', 163),
(25, 'KUA', 'Kunst Algemeen', 170),
(26, 'KUBV', 'Kunst Beeldende Vorming', 171),
(27, 'BTE', 'BTE', 172),
(28, 'KCKV', 'KCKV', 173),
(29, 'BV', 'beeldende vorming', 175),
(30, 'PWS', 'Profielwerkstuk', 180),
(31, 'REK', 'Rekenen', 190);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `vakken`
--
ALTER TABLE `vakken`
  ADD PRIMARY KEY (`vid`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `vakken`
--
ALTER TABLE `vakken`
  MODIFY `vid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
