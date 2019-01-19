-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2019 at 03:08 AM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `countrycode` char(2) NOT NULL,
  `city` varchar(255) NOT NULL,
  `streetaddress` varchar(255) NOT NULL,
  `dateofbirth` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `firstname`, `lastname`, `email`, `countrycode`, `city`, `streetaddress`, `dateofbirth`, `username`, `password`, `role`) VALUES
(6, 'Mario', 'Pavse', 'mario_pavse@yahoo.com', 'HR', '', '', '2018-12-25 00:37:06', 'mpavse', '$2y$12$5pAiN.DeV.O4pt8lPsmbm.i8tTVtUsHiACLK3wDnWpwFdi5CIJaDe', 'Administrator'),
(7, 'Ad', 'Min', 'admin@admin.com', 'HR', '', '', '2018-12-27 04:22:04', 'admin', '$2y$12$1hhiAFPH7rGaBudEuEh7m.wu6GXf29H0aZUM9An6aLjsiwvdfcp96', 'Administrator'),
(8, 'Ivo', 'IviÄ‡', 'iivic@vvg.hr', 'HR', '', '', '2018-12-29 01:33:57', 'ivic', '$2y$12$ClY1HrnRjlzh/IHrW9HCR.MRWyzIcAERAxQAapi4uxMh35JgoNWqq', 'Unconfirmed'),
(9, 'Edit', 'Tor', 'edit@edit.hr', 'HR', '', '', '2018-12-27 04:24:25', 'editor', '$2y$12$dodvjHLpSQ0bJ8maLvpgvONLdNE0DUJHYkE0xqSPwELQv/WEAkBoq', 'Editor'),
(10, 'User', 'Resu', 'user@user.hr', 'HR', '', '', '2018-12-27 16:14:57', 'user', '$2y$12$IE93JLx5W77fIS0ySeLt4OdedLnddpJJdZmRC/XzeXP4BTV9upzY6', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
