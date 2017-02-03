-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 23. Jun 2016 um 11:40
-- Server-Version: 5.6.25
-- PHP-Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `db_pejo_shop`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `artikel`
--

CREATE TABLE IF NOT EXISTS `artikel` (
  `ArtikelNr` int(10) unsigned NOT NULL,
  `Bezeichnung` varchar(64) NOT NULL,
  `Beschreibung` varchar(255) DEFAULT NULL,
  `Preis` decimal(11,2) NOT NULL DEFAULT '0.00',
  `Image` varchar(64) NOT NULL,
  `Zutaten` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `artikel`
--

INSERT INTO `artikel` (`ArtikelNr`, `Bezeichnung`, `Beschreibung`, `Preis`, `Image`, `Zutaten`) VALUES
(1, 'Bio Falafel Classic', 'typisch arabisch mit Petersilie, Kreuzkümmel und Koriander', '1.79', 'img/produkt1.png', 'Kichererbsen*, Zwiebeln*, Kartoffeln*, Gewürze*, Knoblauch*, Petersilie*, Rapsöl*, Meersalz. (*Zutaten aus kontrolliert biologischem Anbau)'),
(2, 'Bio Falafel Curry', 'mit einer feinen selbst hergestellten Currymischung', '1.79', './img/produkt2.png', 'Kichererbsen*, Zwiebeln*, Kartoffeln*, Gewürze*, Knoblauch*, Rapsöl*, Meersalz. (*Zutaten aus kontrolliert biologischem Anbau)'),
(3, 'Bio Falafel Paprika', 'mit frischer roter Paprika leicht pikant gewürzt', '1.79', './img/produkt3.png', 'Kichererbsen*, Zwiebeln*, Kartoffeln*, frische rote Paprika*, Gewürze*, Knoblauch*, Rapsöl*, Meersalz. (*Zutaten aus kontrolliert biologischem Anbau)'),
(4, 'Bio-Hummus', 'Kichererbsen-Sesam-Mus', '2.95', './img/produkt4.png', 'Kichererbsen*, Wasser, Sesamsaat*, Rapsöl*, Meersalz, Zitronensäure, Knoblauch*. (*Zutaten aus kontrolliert biologischem Anbau) '),
(5, 'Bio-Auberginen-Mus', 'Auberginen-Sesam-Mus', '2.95', './img/produkt5.png', 'Aubergine*, Sesammus*, Zitronensaft*, Salz, Olivenöl*, Knoblauch*\r\n(*Zutaten aus kontrolliert biologischem Anbau)'),
(6, 'Bio-Tahine', 'Mus aus Sesamsaat mit leicht bitterer und nussiger Note. Ein Klassiker der arabischen Küche, als Grundlage für Sesamsoße und als Zutat zum Kochen und Backen. Vegan und glutenfrei.\r\nInhalt: 165 g ', '2.95', './img/produkt6.png', 'Sesamsaat, geschält und geröstet*\r\n*aus kontrolliert biologischen Anbau / DE-ÖKO-007'),
(7, 'Bio Falafel Classic Fertigmischung', 'typisch arabisch mit Petersilie, Kreuzkümmel und Koriander', '1.79', './img/produkt7.png', 'Kichererbsenschrot*, Kichererbsenmehl*, Gewürze*, Meersalz, Zwiebeln*, Knoblauch*, Petersilie*\r\n* aus kontrolliert biologischen Anbau / DE-ÖKO-007'),
(8, 'Bio Falafel Curry Fertigmischung', 'mit einer feinen selbst hergestellten Currymischung', '1.79', './img/produkt8.png', 'Kichererbsenschrot*, Kichererbsenmehl*, Gewürze*, Meersalz, Zwiebeln*, Knoblauch*\r\n*aus kontrolliert biologischen Anbau / DE-ÖKO-007'),
(9, 'Bio Falafel Paprika Fertigmischung', 'mit frischer roter Paprika leicht pikant gewürzt', '1.79', './img/produkt9.png', 'Kichererbsenschrot*, Kichererbsenmehl*, Gewürze*, Meersalz, Zwiebeln*, rote Paprika*, Knoblauch*. (*aus kontrolliert biologischen Anbau)');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellung`
--

CREATE TABLE IF NOT EXISTS `bestellung` (
  `BestellNr` int(10) unsigned NOT NULL,
  `Kunde` int(10) unsigned NOT NULL,
  `Datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Zahlungsart` set('Kreditkarte','Bankeinzug','PayPal') NOT NULL DEFAULT 'Bankeinzug',
  `Lieferadresse` varchar(255) NOT NULL DEFAULT 'Kundenanschrift'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `bestellung`
--

INSERT INTO `bestellung` (`BestellNr`, `Kunde`, `Datum`, `Zahlungsart`, `Lieferadresse`) VALUES
(1, 1, '2016-06-14 12:29:06', 'Kreditkarte', 'Häuserstr. 3 69126 Heidelberg DE'),
(2, 1, '2016-06-14 12:34:51', 'Kreditkarte', 'Fichtestr. 23 69126 Heidelberg'),
(3, 1, '2016-06-14 12:39:26', 'PayPal', 'Rheinstr. 18 69126 Heidelberg'),
(4, 1, '2016-06-14 12:52:27', 'Kreditkarte', 'Kirschgartenstr. 22 69126 Heidelberg'),
(5, 1, '2016-06-14 12:53:04', 'Kreditkarte', 'Feuerbachstr. 3 69126 Heidelberg'),
(6, 1, '2016-06-14 12:56:20', 'Kreditkarte', 'Fichtestr. 1 69126 Heidelberg DE'),
(7, 1, '2016-06-14 12:56:34', 'PayPal', 'Fichtestr. 23 69126 Heidelberg DE'),
(8, 1, '2016-06-14 12:57:01', 'Kreditkarte', 'Häuserstr. 3 69126 Heidelbeg'),
(9, 1, '2016-06-14 12:58:13', 'Bankeinzug', 'Häuserstr. 6 69126 Heidelbeg'),
(10, 1, '2016-06-14 12:58:26', 'PayPal', 'Häuserstr. 5 69126 Heidelbeg'),
(11, 1, '2016-06-14 14:48:44', 'PayPal', 'Fichtestr. 3 69126 Heidelbeg'),
(12, 1, '2016-06-14 16:11:05', 'PayPal', 'Häuserstr. 21 69126 Heidelbeg'),
(13, 1, '2016-06-15 08:00:06', 'PayPal', 'Häuserstr. 108 69126 Heidelbeg'),
(14, 1, '2016-06-15 14:19:00', 'Kreditkarte', 'Feuerbachstr. 3 69126 Heidelberg DE'),
(15, 1, '2016-06-23 09:33:11', 'Kreditkarte', 'Häuserweg 3'),
(16, 1, '2016-06-23 09:34:01', 'Kreditkarte', 'Häuserweg 3'),
(17, 1, '2016-06-23 09:34:22', 'Kreditkarte', 'Häuserweg 3'),
(18, 1, '2016-06-23 09:35:14', 'Kreditkarte', 'Häuserweg 3');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kommentare`
--

CREATE TABLE IF NOT EXISTS `kommentare` (
  `Komnummer` int(11) NOT NULL,
  `Person` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `Kommentar` varchar(128) COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kunde`
--

CREATE TABLE IF NOT EXISTS `kunde` (
  `KundenNr` int(10) unsigned NOT NULL,
  `Nachname` varchar(64) NOT NULL,
  `Vorname` varchar(64) DEFAULT NULL,
  `Anrede` set('Frau','Herr') DEFAULT NULL,
  `Titel` set('Prof.','Dr.','Dipl.Ing.') DEFAULT NULL,
  `Telefon` varchar(32) DEFAULT NULL,
  `Anschrift` varchar(255) DEFAULT NULL,
  `EMail` varchar(64) NOT NULL,
  `Passwort` varchar(64) DEFAULT NULL,
  `Haendlernachweis` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `kunde`
--

INSERT INTO `kunde` (`KundenNr`, `Nachname`, `Vorname`, `Anrede`, `Titel`, `Telefon`, `Anschrift`, `EMail`, `Passwort`, `Haendlernachweis`) VALUES
(1, 'Preußmann', 'Nicolas', 'Herr', NULL, NULL, 'Fichtestr. 23 69126 Heidelberg', 'nicolas.preussmann@gmail.com', 'abc', ''),
(2, 'Seibicke', 'Jan', 'Herr', NULL, NULL, 'sdsdsd', 'abc@mail.de', '123', ''),
(5, 'Nutzer', 'Unbekannter', 'Herr', 'Prof.', NULL, NULL, '', 'wwwwww', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posten`
--

CREATE TABLE IF NOT EXISTS `posten` (
  `Bestellung` int(10) unsigned NOT NULL,
  `Artikel` int(10) unsigned NOT NULL,
  `Menge` int(11) NOT NULL DEFAULT '0',
  `Preis` decimal(11,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `posten`
--

INSERT INTO `posten` (`Bestellung`, `Artikel`, `Menge`, `Preis`) VALUES
(1, 1, 4, '1.79'),
(1, 2, 1, '1.79'),
(2, 1, 2, '1.79'),
(2, 2, 3, '1.79'),
(3, 1, 3, '1.79'),
(4, 1, 1, '1.79'),
(5, 1, 1, '1.79'),
(5, 2, 1, '1.79'),
(7, 2, 1, '1.79'),
(7, 4, 1, '2.95'),
(8, 1, 1, '1.79'),
(8, 4, 1, '2.95'),
(10, 2, 3, '1.79'),
(10, 4, 1, '2.95'),
(11, 1, 5, '1.79'),
(11, 5, 1, '2.95'),
(12, 1, 6, '1.79'),
(13, 1, 3, '1.79'),
(13, 2, 1, '1.79'),
(14, 1, 1, '1.79'),
(14, 2, 1, '1.79'),
(15, 1, 1, '1.79'),
(15, 2, 1, '1.79'),
(17, 1, 1, '1.79'),
(17, 2, 1, '1.79'),
(18, 2, 1, '1.79'),
(18, 3, 1, '1.79');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezepte`
--

CREATE TABLE IF NOT EXISTS `rezepte` (
  `Reznummer` int(11) NOT NULL,
  `KundNr` int(10) unsigned NOT NULL,
  `RezName` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  `Zutaten` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `RezBeschreibung` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `RezBild` varchar(128) COLLATE latin1_german1_ci NOT NULL,
  `PositiveB` int(11) NOT NULL,
  `NegativeB` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `rezepte`
--

INSERT INTO `rezepte` (`Reznummer`, `KundNr`, `RezName`, `Zutaten`, `RezBeschreibung`, `RezBild`, `PositiveB`, `NegativeB`) VALUES
(13, 1, 'Falafelkuchen', 'Falafelpaste (200g), Kopfsalat, Radischen, Paprika, Salz, Pfeffer, Tomaten, Öl, Schnittlauch', 'die Falafelpaste zu Kugeln kneten und 5-10 Minuten fritieren. Danach Salat waschen, Radischen, Paprika, Tomaten und den Schnittlauch schneiden. alles in eine große Schüssel und mit dem Dressing vermischen', './img/carousel1.png', 70, 12),
(18, 2, 'Falafeleis', 'Sahne, Falafelpaste, Salz, Pfeffer, Tymian, Fladenbrot, Flüssiger Stickstoff', 'Alles klein schneiden oder klein vermatschen und 15 min Flüssigen Stickstoff hinzugeben während man gleichmäßig umrührt. Das ganze danach mit Sahne überziehen und man hat das widerlichste Eis der Welt.', './img/carousel2.png', 6, 1),
(22, 2, 'Falafel mit Krautsalat', 'Falafelpaste, Krautsalat, Salz, Pfeffer, Rosmarin, Currypulver, Peperonie', 'Falafelpaste mit den Gewürzen mischen und in Falafel formen und 5-10 Minuten fritieren. danach den Krautsalat dazu anrichten und die Peperonie dazulegen.', './img/carousel3.png', 0, 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`ArtikelNr`),
  ADD KEY `Bezeichnung` (`Bezeichnung`);

--
-- Indizes für die Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  ADD PRIMARY KEY (`BestellNr`),
  ADD KEY `Kunde` (`Kunde`);

--
-- Indizes für die Tabelle `kommentare`
--
ALTER TABLE `kommentare`
  ADD PRIMARY KEY (`Komnummer`);

--
-- Indizes für die Tabelle `kunde`
--
ALTER TABLE `kunde`
  ADD PRIMARY KEY (`KundenNr`),
  ADD UNIQUE KEY `EMail` (`EMail`),
  ADD UNIQUE KEY `KundenNr` (`KundenNr`),
  ADD KEY `Nachname` (`Nachname`),
  ADD KEY `KundenNr_2` (`KundenNr`);

--
-- Indizes für die Tabelle `posten`
--
ALTER TABLE `posten`
  ADD PRIMARY KEY (`Bestellung`,`Artikel`),
  ADD KEY `Artikel` (`Artikel`);

--
-- Indizes für die Tabelle `rezepte`
--
ALTER TABLE `rezepte`
  ADD UNIQUE KEY `Reznummer` (`Reznummer`),
  ADD KEY `KundNr` (`KundNr`),
  ADD KEY `KundNr_2` (`KundNr`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `artikel`
--
ALTER TABLE `artikel`
  MODIFY `ArtikelNr` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  MODIFY `BestellNr` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT für Tabelle `kunde`
--
ALTER TABLE `kunde`
  MODIFY `KundenNr` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT für Tabelle `rezepte`
--
ALTER TABLE `rezepte`
  MODIFY `Reznummer` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=113;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  ADD CONSTRAINT `bestellung_ibfk_1` FOREIGN KEY (`Kunde`) REFERENCES `kunde` (`KundenNr`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `kommentare`
--
ALTER TABLE `kommentare`
  ADD CONSTRAINT `kommentare_ibfk_1` FOREIGN KEY (`Komnummer`) REFERENCES `rezepte` (`Reznummer`);

--
-- Constraints der Tabelle `posten`
--
ALTER TABLE `posten`
  ADD CONSTRAINT `posten_ibfk_1` FOREIGN KEY (`Artikel`) REFERENCES `artikel` (`ArtikelNr`) ON UPDATE CASCADE,
  ADD CONSTRAINT `posten_ibfk_2` FOREIGN KEY (`Bestellung`) REFERENCES `bestellung` (`BestellNr`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `rezepte`
--
ALTER TABLE `rezepte`
  ADD CONSTRAINT `rezepte_ibfk_1` FOREIGN KEY (`KundNr`) REFERENCES `kunde` (`KundenNr`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
