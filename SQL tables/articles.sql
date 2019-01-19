-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2019 at 03:06 AM
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
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `articleid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shortdisplay` varchar(255) NOT NULL,
  `articledate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `displayed` char(1) NOT NULL,
  `picfilename` varchar(50) NOT NULL,
  `pictext` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`articleid`, `title`, `shortdisplay`, `articledate`, `displayed`, `picfilename`, `pictext`) VALUES
(1, 'Amethystium', 'Amethystium is a music project formed by Norwegian composer Oystein Ramfjord aiming to create and explore emotive imaginary worlds in sound.', '2018-12-29 01:41:40', 'Y', 'Amethystium.jpg', 'Amethystium'),
(2, 'Jean-Michel Jarre', 'Jean-Michel Andre Jarre is a French composer, performer and music producer, regarded as a pioneer of electronic music.', '2018-12-27 04:14:04', 'Y', 'Jarre.jpg', 'Jean-Michel Jarre'),
(4, 'Enigma', 'Enigma is a German electronic musical project founded by Michael Cretu (Romanian musician), David Fairstein and Frank Peterson in 1990.', '2018-12-25 04:54:46', 'Y', 'Enigma.jpg', 'Enigma'),
(5, 'Gregorian', 'Gregorian is a German band headed by Frank Peterson that performs Gregorian chant-inspired versions of modern pop and rock songs.', '2018-12-27 12:51:25', 'Y', 'Gregorian.jpg', 'Gregorian'),
(8, 'dssdfs`d#fsdfsdf', 'Surfing is a surface water sport in which the wave rider, referred to as a surfer, rides on the forward or deep face of a moving wave, which usually carries the surfer towards the shore. Waves suitable for surfing are primarily found in the ocean, but can', '2019-01-17 23:21:05', 'N', 'IMG-20180408-WA0012.jpg', 'sdfsdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`articleid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `articleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
