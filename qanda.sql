-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 09 apr 2013 om 02:25
-- Serverversie: 5.5.27
-- PHP-versie: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `qanda`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `user_id`, `name`, `date_created`) VALUES
(1, 1, 9, 'Op de website www.google.nl kun je veel informatie vinden over deze vraag.', '2013-04-05 10:12:39'),
(2, 1, 7, 'blabalbalbalbalblablaa', '2013-04-09 00:28:19'),
(3, 1, 7, 'Testststststst', '2013-04-09 00:45:52'),
(4, 4, 10, 'De blauwe banaan is een aardrijkskundige naam voor het Europese kerngebied.', '2013-04-09 01:52:47');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Gegevens worden uitgevoerd voor tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `url`) VALUES
(1, 'Computers & Internet', 'computers-en-internet'),
(2, 'Elektronica', 'elektronica'),
(3, 'Entertainment & Muziek', 'entertainment-en-muziek'),
(4, 'Eten & Drinken', 'eten-en-drinken'),
(5, 'Financien & Werk', 'financien-&-werk'),
(6, 'Huis & Tuin', 'huis-en-tuin'),
(7, 'Kunst & Cultuur', 'kunst-en-cultuur'),
(8, 'Maatschappij', 'maatschappij'),
(9, 'Persoon & Gezondheid', 'persoon-en-gezondheid'),
(10, 'Sport, spel & recreatie', 'sport-spel-en-recreatie'),
(11, 'Vakantie & Reizen', 'vakantie-en-reizen'),
(12, 'Overig', 'overig');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `questions`
--

INSERT INTO `questions` (`id`, `category_id`, `user_id`, `name`, `url`, `tags`, `date_created`) VALUES
(1, 12, 7, 'Wat is de beste manier taart te maken met behulp van een taartenbakmachine?', 'wat-is-de-beste-manier-taart-te-maken-met-behulp-van-een-taartenbakmachine', '24kitchen;bakkerij;taarten', '2013-04-04 05:10:20'),
(2, 1, 7, 'Waar kan ik Google Chrome downloaden op het internet?', 'waar-kan-ik-google-chrome-downloaden-op-het-internet', 'google;chrome;internet', '2013-04-05 22:36:33'),
(3, 11, 7, 'Zijn er bootverbindingen tussen de Caribische eilanden?', 'zijn-er-bootverbindingen-tussen-de-caribische-eilanden', 'curacao;zonnig;vakantie', '2013-04-08 18:54:24'),
(4, 4, 10, 'Waarom wordt de blauwe banaan de BLAUWE banaan genoemd?', 'waarom-wordt-de-blauwe-banaan-de-blauwe-banaan-genoemd', 'fruit;banaan;gezond', '2013-04-09 01:44:10');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `admin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Gegevens worden uitgevoerd voor tabel `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `email`, `hash`, `salt`, `last_login`, `active`, `admin`) VALUES
(7, 'Fons', 'Hettema', 'fons@pitgroup.nl', '70e0f7de01b33ef80a658265ac2c03670c7fa7b1', 'f;H4F%]}', '0000-00-00 00:00:00', 1, 0),
(9, 'Joost', 'Hettema', 'joostth7@hotmail.com', 'eac2507fc2d9beb660322c958212d799ddca88b3', 'I\\3q1N4&', '0000-00-00 00:00:00', 1, 0),
(10, 'jobba88', '', 'bla@bla.com', '88c5569c1e62f48353f26cc499ef7e83085dbd5d', '%To5eP7L', '0000-00-00 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `total` int(11) NOT NULL,
  `votes` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `votes`
--

INSERT INTO `votes` (`id`, `question_id`, `answer_id`, `total`, `votes`) VALUES
(1, 1, 0, 5, 1),
(2, NULL, 1, 3, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
