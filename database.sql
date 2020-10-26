-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql311.epizy.com
-- Creato il: Ott 26, 2020 alle 14:43
-- Versione del server: 5.6.48-88.0
-- Versione PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_24328203_san_francesco_di_paola_lugo`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Annate`
--

CREATE TABLE `Annate` (
  `Anno_inizio` year(4) NOT NULL COMMENT 'Es. anno 2018-2019 -> Anno_inizio = 2018',
  `Tema_nome` varchar(30) NOT NULL COMMENT 'Es. "Ci prendo gusto!"',
  `Tema_url` varchar(300) NOT NULL COMMENT 'Es. "https://acr.azionecattolica.it/iniziativa-annuale/ci-prendo-gusto"',
  `Colore` varchar(30) NOT NULL DEFAULT 'black' COMMENT 'Il nome di un colore CSS o una rappresentazione RGB in esadecimale'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Le "annate" raggruppano squadre che competono fra di esse in un anno scolastico';

-- --------------------------------------------------------

--
-- Struttura della tabella `Giochi`
--

CREATE TABLE `Giochi` (
  `Nome` varchar(30) NOT NULL COMMENT 'Il nome del gioco',
  `Squadra_ID` int(11) DEFAULT NULL COMMENT 'L''ID della squadra il cui capo ha aggiunto questo gioco all''elenco (NULL = squadra eliminata)',
  `Indoor` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Il gioco viene organizzato al chiuso?',
  `Note` varchar(5000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Uno o più giochi vengono impiegati in una o più giornate.';

-- --------------------------------------------------------

--
-- Struttura della tabella `Giornate`
--

CREATE TABLE `Giornate` (
  `Data` date NOT NULL COMMENT 'Giorno, mese e anno dell''elemento in questione.',
  `Squadra_ID` int(11) NOT NULL COMMENT 'L''ID della squadra il cui capo ha registrato i risultati di questa giornata all''elenco',
  `Note` varchar(5000) NOT NULL DEFAULT 'Nessuna informazione aggiuntiva disponibile.' COMMENT 'Informazioni aggiuntive a discrezione dei caposquadra'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Un caposquadra gestisce qui le informazioni relative a una giornata in cui sono stati svolte una o più partite e in cui ciascuna squadra ha effettuato una certa prestazione.';

-- --------------------------------------------------------

--
-- Struttura della tabella `Partite`
--

CREATE TABLE `Partite` (
  `ID` int(11) NOT NULL COMMENT 'Un identificativo numerico unico per ogni partita',
  `Gioco_Nome` varchar(30) NOT NULL COMMENT 'Il nome (univoco) del gioco scelto per la partita',
  `Giornata_Data` date NOT NULL COMMENT 'La data della giornata in cui si è svolta la partita'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Una o più partite a un gioco vengono svolte in una giornata.';

-- --------------------------------------------------------

--
-- Struttura della tabella `Prestazioni`
--

CREATE TABLE `Prestazioni` (
  `ID` int(11) NOT NULL COMMENT 'Un identificativo numerico univoco per ogni prestazione',
  `Squadra_ID` int(11) NOT NULL COMMENT 'L''ID della squadra che ha effettuato la prestazione',
  `Giornata_Data` date NOT NULL COMMENT 'La giornata nella quale è stata effettuata la prestazione',
  `Punteggio` int(11) NOT NULL COMMENT 'Il punteggio raggiunto'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Il punteggio che una squadra consegue in una certa giornata.';

-- --------------------------------------------------------

--
-- Struttura della tabella `Squadre`
--

CREATE TABLE `Squadre` (
  `ID` int(11) NOT NULL COMMENT 'Identifica univocamente la squadra',
  `Annata_Anno_inizio` year(4) NOT NULL COMMENT 'Il primo dei due anni solari in cui la squadra ha giocato',
  `Nome` varchar(30) NOT NULL COMMENT 'Il nome con cui la squadra è conosciuta',
  `Caposquadra` varchar(30) NOT NULL COMMENT 'Lo pseudonimo del caposquadra',
  `Password` varchar(30) NOT NULL COMMENT 'La password con la quale il caposquadra accede all''applicativo',
  `Colore` varchar(30) NOT NULL DEFAULT 'black' COMMENT 'Il nome di un colore CSS o una rappresentazione RGB in esadecimale'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Più squadre competono in una singola annata giocando nelle varie giornate.';

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Annate`
--
ALTER TABLE `Annate`
  ADD PRIMARY KEY (`Anno_inizio`);

--
-- Indici per le tabelle `Giochi`
--
ALTER TABLE `Giochi`
  ADD PRIMARY KEY (`Nome`),
  ADD KEY `Squadra_ID` (`Squadra_ID`);

--
-- Indici per le tabelle `Giornate`
--
ALTER TABLE `Giornate`
  ADD PRIMARY KEY (`Data`),
  ADD KEY `Squadra_ID` (`Squadra_ID`);

--
-- Indici per le tabelle `Partite`
--
ALTER TABLE `Partite`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Gioco_Nome` (`Gioco_Nome`),
  ADD KEY `Giornata_Data` (`Giornata_Data`);

--
-- Indici per le tabelle `Prestazioni`
--
ALTER TABLE `Prestazioni`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Squadra_ID` (`Squadra_ID`),
  ADD KEY `Giornata_Data` (`Giornata_Data`);

--
-- Indici per le tabelle `Squadre`
--
ALTER TABLE `Squadre`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Annata_Anno_inizio` (`Annata_Anno_inizio`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Partite`
--
ALTER TABLE `Partite`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Un identificativo numerico unico per ogni partita';

--
-- AUTO_INCREMENT per la tabella `Prestazioni`
--
ALTER TABLE `Prestazioni`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Un identificativo numerico univoco per ogni prestazione';

--
-- AUTO_INCREMENT per la tabella `Squadre`
--
ALTER TABLE `Squadre`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifica univocamente la squadra';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
