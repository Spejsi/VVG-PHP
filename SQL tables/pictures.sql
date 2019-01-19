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
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `articleid` int(11) NOT NULL,
  `picindex` int(11) NOT NULL,
  `picfilename` varchar(50) NOT NULL,
  `pictext` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`articleid`, `picindex`, `picfilename`, `pictext`) VALUES
(0, 1, 'Amethystium-01.jpg', 'Amethystium - Aphelion'),
(0, 2, 'Amethystium-02.jpg', 'Amethystium - Odonata'),
(0, 3, 'Amethystium-03.jpg', 'Amethystium - Evermind'),
(0, 4, 'Amethystium-04.jpg', 'Amethystium - Issabliss'),
(0, 5, 'Amethystium-05.jpg', 'Amethystium - Transience'),
(2, 1, 'Jarre-01_1.jpg', 'Oxygene'),
(2, 2, 'Jarre-02_1.jpg', 'Les Chants Magnetiques'),
(2, 3, 'Jarre-03_1.jpg', 'Rendez-Vous'),
(2, 4, 'Jarre-04_1.jpg', 'Oxygene 7-13'),
(2, 5, 'Jarre-05_1.jpg', 'Chronologie'),
(5, 1, 'Gregorian - Masters of Chant 01.png', 'Masters of Chant chapter 1'),
(5, 2, 'Gregorian - Masters of Chant 02.png', 'Masters of Chant chapter 2'),
(5, 3, 'Gregorian - Masters of Chant 03.png', 'Masters of Chant chapter 3'),
(5, 4, 'Gregorian - Epic Chants.png', 'Epic Chants'),
(5, 5, 'Gregorian - The Dark Side of the Chant_1.png', 'The Dark Side of the Chant'),
(1, 1, 'Amethystium-01.jpg', 'Amethystium - Aphelion'),
(1, 2, 'Amethystium-02.jpg', 'Amethystium - Odonata'),
(1, 3, 'Amethystium-03.jpg', 'Amethystium - Evermind'),
(1, 4, 'Amethystium-04.jpg', 'Amethystium - Issabliss'),
(1, 5, 'Amethystium-05.jpg', 'Amethystium - Transience');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
