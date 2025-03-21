-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2023 at 01:59 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sa000848470`
--

-- --------------------------------------------------------

--
-- Table structure for table `emp`
--

DROP TABLE IF EXISTS emp;


CREATE TABLE `emp` (
  `Name` varchar(50) DEFAULT NULL,
  `Location` varchar(25) DEFAULT NULL,
  `Floor` int(11) DEFAULT NULL,
  `Cubical` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp`
--

INSERT INTO `emp` (`Name`, `Location`, `Floor`, `Cubical`) VALUES
('Jack Coulter ', 'john', 2, '2-042'),
('Tom Ford', 'john', 3, '3-028'),
('Andrew S', 'john', 4, '4-032'),
('Mike T', 'john', 5, '5-029'),
('SR. Dan', 'john', 6, '6-059'),
('Sandra B', 'nebo', 1, '1-031'),
('Johnson Bell', 'nebo', 2, '2-061'),
('Danny T', 'vansickle', 1, '1-071'),
('Frank O', 'vansickle', 2, '2-091');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
