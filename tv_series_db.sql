-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2025 at 01:21 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tv_series_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tv_series`
--

CREATE TABLE `tv_series` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `channel` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tv_series`
--

INSERT INTO `tv_series` (`id`, `title`, `channel`, `gender`) VALUES
(1, 'The Night Agent', 'AMC', 'Thriller'),
(2, 'Emily in Paris', 'HBO', 'Drama'),
(3, 'Stranger Things', 'Netflix', 'Mystery'),
(4, 'Outer Banks', 'Netflix', 'Action'),
(5, 'Vampire Diaries', 'NBC', 'Romance');

-- --------------------------------------------------------

--
-- Table structure for table `tv_series_intervals`
--

CREATE TABLE `tv_series_intervals` (
  `id` int(11) NOT NULL,
  `id_tv_series` int(11) NOT NULL,
  `week_day` int(11) NOT NULL,
  `show_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tv_series_intervals`
--

INSERT INTO `tv_series_intervals` (`id`, `id_tv_series`, `week_day`, `show_time`) VALUES
(1, 1, 4, '08:00:00'),
(2, 1, 4, '21:00:00'),
(3, 1, 6, '20:00:00'),
(4, 2, 2, '22:00:00'),
(5, 2, 5, '19:30:00'),
(6, 3, 1, '10:00:00'),
(7, 3, 3, '14:00:00'),
(8, 4, 3, '18:00:00'),
(9, 4, 5, '20:00:00'),
(10, 4, 7, '17:00:00'),
(11, 5, 2, '10:00:00'),
(12, 5, 6, '22:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tv_series`
--
ALTER TABLE `tv_series`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tv_series_intervals`
--
ALTER TABLE `tv_series_intervals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tv_series` (`id_tv_series`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tv_series`
--
ALTER TABLE `tv_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tv_series_intervals`
--
ALTER TABLE `tv_series_intervals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tv_series_intervals`
--
ALTER TABLE `tv_series_intervals`
  ADD CONSTRAINT `tv_series_intervals_ibfk_1` FOREIGN KEY (`id_tv_series`) REFERENCES `tv_series` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
