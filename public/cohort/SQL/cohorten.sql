-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 30 mrt 2021 om 10:59
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
-- Tabelstructuur voor tabel `cohorten`
--

CREATE TABLE `cohorten` (
  `cid` int NOT NULL,
  `vakCode` int NOT NULL,
  `niveau` varchar(2) COLLATE utf8_bin NOT NULL,
  `beginjaar` int NOT NULL,
  `actief` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `cohorten`
--
ALTER TABLE `cohorten`
  ADD PRIMARY KEY (`cid`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `cohorten`
--
ALTER TABLE `cohorten`
  MODIFY `cid` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
