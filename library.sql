-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 04, 2020 at 02:38 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `password` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `password`) VALUES
(111, 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int(7) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `amount` int(100) NOT NULL,
  `page` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `description`, `amount`, `page`) VALUES
(1, 'book_1', 'testing', 1, 1),
(2, 'book_2', 'testing', 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

DROP TABLE IF EXISTS `borrow`;
CREATE TABLE IF NOT EXISTS `borrow` (
  `bookID` int(7) NOT NULL,
  `studentID` int(7) NOT NULL,
  `duration` date NOT NULL,
  KEY `userBorrowed` (`studentID`),
  KEY `borrowedBook` (`bookID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `borrow`
--

INSERT INTO `borrow` (`bookID`, `studentID`, `duration`) VALUES
(1, 1, '2020-07-04');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `password`) VALUES
(1, 'student', '123456');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `borrowedBook` FOREIGN KEY (`bookID`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `userBorrowed` FOREIGN KEY (`studentID`) REFERENCES `student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
