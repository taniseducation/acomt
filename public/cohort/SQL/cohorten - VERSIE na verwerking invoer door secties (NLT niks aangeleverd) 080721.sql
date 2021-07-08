-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 08 jul 2021 om 15:37
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
  `volgorde` int NOT NULL,
  `M` int NOT NULL DEFAULT '1',
  `H` int NOT NULL DEFAULT '1',
  `A` int NOT NULL DEFAULT '1',
  `removeTab` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '1111111111',
  `voorzitter` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Gegevens worden geëxporteerd voor tabel `vakken`
--

INSERT INTO `vakken` (`vid`, `vakCode`, `vakNaam`, `volgorde`, `M`, `H`, `A`, `removeTab`, `voorzitter`) VALUES
(1, 'NE', 'Nederlands', 10, 1, 1, 1, '0111111111', 'srt@csg.nl,spy@csg.nl'),
(2, 'EN', 'Engels', 20, 1, 1, 1, '0111111111', 'wkm@csg.nl'),
(3, 'DU', 'Duits', 30, 1, 1, 1, '0111111111', 'luh@csg.nl'),
(4, 'FA', 'Frans', 40, 1, 1, 1, '0001111111', 'grb@csg.nl'),
(5, 'GDL', 'godsdienst', 42, 1, 1, 1, '0001111111', 'zdg@csg.nl'),
(6, 'LO', 'Lichamelijke Opvoeding', 43, 1, 1, 1, '0111111111', 'ksm@csg.nl'),
(7, 'MA', 'maatschappijleer', 45, 1, 1, 1, '0111110111', 'mei@csg.nl'),
(8, 'CKV', 'CKV', 47, 1, 1, 1, '0001111111', 'dnm@csg.nl'),
(9, 'WA', 'wiskunde A', 50, 1, 1, 1, '0001111111', 'war@csg.nl'),
(10, 'WB', 'wiskunde B', 60, 1, 1, 1, '0001111111', 'war@csg.nl'),
(11, 'WC', 'wiskunde C', 70, 1, 1, 1, '0000001111', 'war@csg.nl'),
(12, 'WD', 'wiskunde D', 80, 1, 1, 1, '0001111111', 'war@csg.nl'),
(13, 'WI', 'wiskunde', 81, 1, 1, 1, '0110000000', 'sra@csg.nl'),
(14, 'IF', 'informatica', 90, 1, 1, 1, '0001111111', 'vnr@csg.nl'),
(15, 'NA', 'natuurkunde', 100, 1, 1, 1, '0001111111', 'vnr@csg.nl'),
(16, 'NASK1', 'NaSk1', 101, 1, 1, 1, '0110000000', 'vnr@csg.nl'),
(17, 'SK', 'scheikunde', 110, 1, 1, 1, '0001111111', 'srj@csg.nl'),
(18, 'NASK2', 'NaSk2', 111, 1, 1, 1, '0110000000', 'srj@csg.nl'),
(19, 'BIO', 'biologie', 120, 1, 1, 1, '0111111111', 'sbg@csg.nl,bgr@csg.nl'),
(20, 'NLT', 'Natuur Leven en Technologie', 130, 1, 1, 1, '0001111111', 'bgr@csg.nl'),
(21, 'GS', 'geschiedenis', 140, 1, 1, 1, '0111111111', 'sfl@csg.nl'),
(22, 'AK', 'aardrijkskunde', 150, 1, 1, 1, '0111111111', 'bgm@csg.nl'),
(23, 'EC', 'economie', 160, 1, 1, 1, '0111111111', 'mre@csg.nl'),
(24, 'BECO', 'BECO', 163, 1, 1, 1, '0001111111', 'mre@csg.nl'),
(25, 'KUA', 'Kunst Algemeen', 170, 1, 1, 1, '0001111111', 'dnm@csg.nl'),
(26, 'KUBV', 'Kunst Beeldende Vorming', 171, 1, 1, 1, '0001111111', 'dnm@csg.nl'),
(27, 'BTE', 'BTE', 172, 1, 1, 1, '0110000000', 'mre@csg.nl'),
(28, 'KCKV', 'KCKV', 173, 1, 1, 1, '1100000000', 'dnm@csg.nl'),
(29, 'BV', 'beeldende vorming', 175, 1, 1, 1, '0111111111', ''),
(30, 'PWS', 'Profielwerkstuk', 180, 1, 1, 1, '0111111111', 'fas@csg.nl'),
(31, 'REK', 'Rekenen', 190, 1, 1, 1, '0111111111', 'wsh@csg.nl,vkm@csg.nl');

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
