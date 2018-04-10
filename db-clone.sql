-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2018 at 10:55 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `let_it_fly`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `seats` int(11) NOT NULL DEFAULT '0',
  `working` tinyint(1) NOT NULL DEFAULT '0',
  `driving` tinyint(1) NOT NULL DEFAULT '0',
  `lat` double NOT NULL,
  `lng` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `email`, `password`, `active`, `seats`, `working`, `driving`, `lat`, `lng`) VALUES
(1, 'driver1@domain.com', '$2y$10$TRDV4fuNbqMbeht2HM/IYOgJqggNEZvUWJLIo3aXQVJFP0.9l/k1y', 0, 1, 1, 0, 37.6213129, -122.3789554),
(2, 'driver2@domain.com', '$2y$10$NpReHR4AJpyBXlGOhw/kVuD0OZEXDha6B49pnlcOiCzd163xEvLai', 0, 2, 1, 0, 37.7125689, -122.2197428),
(3, 'driver3@domain.com', '$2y$10$Huvf2FRkYYj7I/VFbALNBu8HfPpJjp.VzBLnZUvtILilAePOh6EvG', 0, 3, 1, 0, 37.3639472, -121.92893750000002),
(4, 'driver4@domain.com', '$2y$10$akm9HefojbgLNvoyzZGleuZCXWFzTdoXJqEhIaj/VCnDIUA4EHm0C', 0, 1, 1, 0, 37.6213129, -122.3789554),
(5, 'driver5@domain.com', '$2y$10$oLKSOlpQ9NQyeBiwWpV50OIb6kgav3gv87CA/Nkk5WUbDgZg4KQK6', 0, 2, 1, 0, 37.7125689, -122.2197428),
(6, 'driver6@domain.com', '$2y$10$bonsr6qF8/IRlHfO1ckvruSS4uDtLiuTsFP44SeFyloFNmdgthGIK', 0, 3, 1, 0, 37.3639472, -121.92893750000002),
(7, 'driver7@domain.com', '$2y$10$wsz.CkUI4VNiYZJCwqtNDetk/AYzVoasgs3RivrJSvZQnVGNLSaLW', 0, 1, 1, 1, 37.6213129, -122.3789554),
(8, 'driver8@domain.com', '$2y$10$M3AQymsppeIcJ0YCDHl6k.9i5/z48ECm7ASbA0W0aiJxSifOUasdy', 0, 2, 1, 1, 37.7125689, -122.2197428),
(9, 'driver9@domain.com', '$2y$10$3RuD1p3byp9MpKfZO2AaMOeM9V7RtlP1I.VhhA6FXwTrh6sYlCJYW', 0, 3, 1, 1, 37.3639472, -121.92893750000002),
(10, 'driver10@domain.com', '$2y$10$TRDV4fuNbqMbeht2HM/IYOgJqggNEZvUWJLIo3aXQVJFP0.9l/k1y', 0, 1, 1, 0, 37.6213129, -122.3789554),
(11, 'driver11@domain.com', '$2y$10$NpReHR4AJpyBXlGOhw/kVuD0OZEXDha6B49pnlcOiCzd163xEvLai', 0, 2, 1, 0, 37.7125689, -122.2197428),
(12, 'driver12@domain.com', '$2y$10$Huvf2FRkYYj7I/VFbALNBu8HfPpJjp.VzBLnZUvtILilAePOh6EvG', 0, 3, 1, 0, 37.3639472, -121.92893750000002),
(13, 'driver13@domain.com', '$2y$10$akm9HefojbgLNvoyzZGleuZCXWFzTdoXJqEhIaj/VCnDIUA4EHm0C', 0, 1, 1, 0, 37.6213129, -122.3789554),
(14, 'driver14@domain.com', '$2y$10$oLKSOlpQ9NQyeBiwWpV50OIb6kgav3gv87CA/Nkk5WUbDgZg4KQK6', 0, 2, 1, 0, 37.7125689, -122.2197428),
(15, 'driver15@domain.com', '$2y$10$bonsr6qF8/IRlHfO1ckvruSS4uDtLiuTsFP44SeFyloFNmdgthGIK', 0, 3, 1, 0, 37.3639472, -121.92893750000002),
(16, 'driver16@domain.com', '$2y$10$wsz.CkUI4VNiYZJCwqtNDetk/AYzVoasgs3RivrJSvZQnVGNLSaLW', 0, 1, 1, 1, 37.6213129, -122.3789554),
(17, 'driver17@domain.com', '$2y$10$M3AQymsppeIcJ0YCDHl6k.9i5/z48ECm7ASbA0W0aiJxSifOUasdy', 0, 2, 1, 1, 37.7125689, -122.2197428),
(18, 'driver18@domain.com', '$2y$10$3RuD1p3byp9MpKfZO2AaMOeM9V7RtlP1I.VhhA6FXwTrh6sYlCJYW', 0, 3, 1, 1, 37.3639472, -121.92893750000002);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `id_rider` int(11) NOT NULL,
  `id_driver` int(11) NOT NULL,
  `airport` varchar(255) NOT NULL,
  `time` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `riders`
--

CREATE TABLE `riders` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `riders`
--

INSERT INTO `riders` (`id`, `email`, `password`, `active`) VALUES
(1, 'ken@domain.com', '$2y$10$GBo5v48sqhnPts3aoGS4M.Ff0VRyYPdn1t6BxV3Mwz3Lmi/y22kHy', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `id_rider` (`id_rider`),
  ADD UNIQUE KEY `id_driver` (`id_driver`);

--
-- Indexes for table `riders`
--
ALTER TABLE `riders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riders`
--
ALTER TABLE `riders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
