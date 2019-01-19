-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2019 at 03:07 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `paragraphs`
--

CREATE TABLE `paragraphs` (
  `articleid` int(11) NOT NULL,
  `paragraphindex` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `paragraphtext` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paragraphs`
--

INSERT INTO `paragraphs` (`articleid`, `paragraphindex`, `title`, `paragraphtext`) VALUES
(0, 1, 'New Age albums', 'Odonata (2001)\r\nAphelion (2003)\r\nEvermind (2004)\r\nIsabliss (2008)\r\nTransience (2014)'),
(0, 2, 'Info', 'Amethystium is a music project formed by Norwegian composer Oystein Ramfjord aiming to create and explore emotive imaginary worlds in sound. Primarily electronic-based, the compositions traverse a span of moods that includes both light and darkness, bliss and melancholy. They range from the purely relaxing to the subtly intense, creating dreamlike and evocative musical journeys.\r\n\r\nMembers: Oystein Ramfjord'),
(2, 1, 'New age albums', 'Deserted Palace (1972)\r\nLes Granges BrulÃ©es (1973)\r\nOxygene (1976)\r\nEquinoxe (1978)\r\nMagnetic Fields (1981)\r\nMusic For Supermarkets (1983)\r\nZoolook (1984)\r\nRendez-Vous (1986)\r\nRevolutions (1988)\r\nWaiting For Cousteau (1990)\r\nChronologie (1993)\r\nOxygene 7-13 (1997)\r\nMetamorphoses (2000)\r\nSessions 2000 (2002)\r\nGeometry Of Love (2003)\r\nTÃ©o & TÃ©a (2007)\r\nOxygene (New Master Recording) (2007)'),
(2, 2, 'Info', 'Jean-Michel AndrÃ© Jarre is a French composer, performer and music producer, regarded as a pioneer of electronic music. He is well-known for huge outdoor shows which feature lights, projections, lasers and fireworks. Some of his most recognized work includes albums like Oxygene, Equinoxe, Magnetic Fields, Zoolook, Rendez-Vous, Chronologie, Oxygene 7-13 and Metamorphoses.'),
(5, 1, 'New age albums', '1999: Masters of Chant\r\n2001: Masters of Chant Chapter II\r\n2002: Masters of Chant Chapter III\r\n2003: Masters of Chant Chapter IV\r\n2004: The Dark Side (Masters of Chant V)\r\n2006: Masters of Chant Chapter V\r\n2007: Masters of Chant Chapter VI\r\n2009: Masters of Chant Chapter VII\r\n2010: Dark Side of the Chant\r\n2011: Masters of Chant Chapter VIII\r\n2012: Epic Chants\r\n2013: Masters of Chant Chapter IX\r\n2014: Winter Chants\r\n2015: Masters of Chant X: The Final Chapter\r\n2017: Holy Chants'),
(5, 2, 'Info', 'Gregorian is a German band headed by Frank Peterson that performs Gregorian chant-inspired versions of modern pop and rock songs. The band features both vocal harmony and instrumental accompaniment. They competed in Unser Lied fÃ¼r Stockholm the German national selection for the Eurovision Song Contest 2016 with the song \"Masters of Chant\". They placed 5th in the first round of the public voting, missing the top 3. They gained 9.06% of the public vote.'),
(1, 1, 'New Age albums', 'Odonata (2001)\r\nAphelion (2003)\r\nEvermind (2004)\r\nIsabliss (2008)\r\nTransience (2014)'),
(1, 2, 'Info', 'Amethystium is a music project formed by Norwegian composer Oystein Ramfjord aiming to create and explore emotive imaginary worlds in sound. Primarily electronic-based, the compositions traverse a span of moods that includes both light and darkness, bliss and melancholy. They range from the purely relaxing to the subtly intense, creating dreamlike and evocative musical journeys.\r\n\r\nMembers: Oystein Ramfjord');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
