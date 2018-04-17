-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2018 at 08:28 AM
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
  `seats` int(11) NOT NULL DEFAULT '0',
  `working` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `parties` int(11) NOT NULL,
  `des` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `email`, `password`, `seats`, `working`, `locked`, `lat`, `lng`, `parties`, `des`) VALUES
(1, 'driver0@sfo.domain.com', '$2y$10$jWWicBx/XJOtbc8UCssgneDaMoWJG3pxBYjg7KJR7/wZnMgpUS9ma', 1, 1, 0, 37.6213129, -122.3789554, 0, 'OAK'),
(2, 'driver1@sfo.domain.com', '$2y$10$rhl78bz2OK9jC95IXqnKPOvKyxkcz67KhgAQNVKILZS2I1WsKCpIu', 1, 1, 0, 37.6213129, -122.3789554, 0, 'OAK'),
(3, 'driver2@sfo.domain.com', '$2y$10$Q424LRW3RSiLTF7emIub4etlMdA5d.IqfRDN/fYKB/rHkGNDLV4F2', 1, 1, 0, 37.6213129, -122.3789554, 0, 'OAK'),
(4, 'driver3@sfo.domain.com', '$2y$10$D16WP1jhEBZIbm79BIvXJ.fRF3USrZfv5NkbYGkKn39p9DU7HqApm', 1, 1, 0, 37.6213129, -122.3789554, 0, 'OAK'),
(5, 'driver4@sfo.domain.com', '$2y$10$g1fufbHOZlCov9g8Uo7sL.9s3JwKkgzaz1qzX7cmD.3YnMIQguJo.', 1, 1, 0, 37.6213129, -122.3789554, 0, 'OAK'),
(6, 'driver5@sfo.domain.com', '$2y$10$xJYN68lbJykkOFFCSCVznOlFXALiZrCfD6qyKFbKgoD5tofRYebAq', 1, 1, 0, 37.6213129, -122.3789554, 0, 'OAK'),
(7, 'driver6@sfo.domain.com', '$2y$10$Vm3Hjvl4ZF64WKvl.QoFg.qXeiz.21zp5bPMB90.aNeIAnooRUTEW', 1, 1, 0, 37.6213129, -122.3789554, 0, 'OAK'),
(8, 'driver7@sfo.domain.com', '$2y$10$eqo5ADiTTuae3E/Q8N0DHOT4fP.GA65U9leGBoLONPb0hdK9iLOPi', 1, 1, 0, 37.6213129, -122.3789554, 0, 'OAK'),
(9, 'driver8@sfo.domain.com', '$2y$10$YAs5nvMvDxjNQ6rit4mZ4eXYgk6yeFOL1yXFsGhSoLryvZwsVgI1.', 1, 1, 0, 37.6213129, -122.3789554, 0, 'OAK'),
(10, 'driver9@sfo.domain.com', '$2y$10$e2w9McNKPqcBOri5VfIeLeEMuI1GPi0maFYwjWgXe7oBw0wbd6m2.', 1, 1, 0, 37.6213129, -122.3789554, 0, 'OAK'),
(11, 'driver0@oak.domain.com', '$2y$10$60bq0VxPq6X1.E2nzn3vN.XmgrtoVdc5S6B1.1pHNZRHByxTnYMtW', 1, 1, 0, 37.7125689, -122.2197428, 0, 'OAK'),
(12, 'driver1@oak.domain.com', '$2y$10$c8RRVVISueyW.Ws1bAkkiufe1gXZoIxd69iMtDXxW7ow9NfMccNo6', 1, 1, 0, 37.7125689, -122.2197428, 0, 'OAK'),
(13, 'driver2@oak.domain.com', '$2y$10$cmj4Mk2qvmWwwZ.4VCXV7.IMzMfScOZBpnyFag4ckPlWW8wDX4tb2', 1, 1, 0, 37.7125689, -122.2197428, 0, 'OAK'),
(14, 'driver3@oak.domain.com', '$2y$10$xEYWe.VDCK1Uvu/JiwR7g.pifvvprHCQmlsvkJVBDHhE7Lcp.FqVu', 1, 1, 0, 37.7125689, -122.2197428, 0, 'OAK'),
(15, 'driver4@oak.domain.com', '$2y$10$JxiMrcNar.QPk4om3xD/QuPKa0F3V51.Cg/Vcwc6gRyr9EbFeb9ya', 1, 1, 0, 37.7125689, -122.2197428, 0, 'OAK'),
(16, 'driver5@oak.domain.com', '$2y$10$DnLFnJhFH.L91Asm15gsTOgr/7tLuKr/mTme9.TUo1Rf4JpbaaHya', 1, 1, 0, 37.7125689, -122.2197428, 0, 'OAK'),
(17, 'driver6@oak.domain.com', '$2y$10$doPZYtr7b.BXhWFX2TTxy.6nfYuf2pZkIE5jpsHikO4sX8atWuEIa', 1, 1, 0, 37.7125689, -122.2197428, 0, 'OAK'),
(18, 'driver7@oak.domain.com', '$2y$10$siIwxWT3rt5T4/shKjCH0ehRWzPjEHMJWr9jmo2iNyN033nzFIuRa', 1, 1, 0, 37.7125689, -122.2197428, 0, 'OAK'),
(19, 'driver8@oak.domain.com', '$2y$10$FERPojxh.vDVvlSlirhtM.uazdaqFXpUOibljwK9FueVHQAQMTD9S', 1, 1, 0, 37.7125689, -122.2197428, 0, 'OAK'),
(20, 'driver9@oak.domain.com', '$2y$10$JJI5j86vejUTBDcAiY144O0eXOjjqyRvPlbyslKQnoUTz1BuDmQPa', 1, 1, 0, 37.7125689, -122.2197428, 0, 'OAK'),
(21, 'driver0@sjc.domain.com', '$2y$10$3U9Q/U/G/yM/na0nN/WkseyX8TzdNrOc/9ipXRG8OPI86kxNntiK.', 1, 1, 0, 37.3639472, -121.92893750000002, 0, 'OAK'),
(22, 'driver1@sjc.domain.com', '$2y$10$SHIJbbuRcH2gjFun/ALqwOi2xZqUvqfUOjyl8Sttn83ltrAqnLYUu', 1, 1, 0, 37.3639472, -121.92893750000002, 0, 'OAK'),
(23, 'driver2@sjc.domain.com', '$2y$10$L3J5JW4K0yUlWl2H8PMzmOvlOENHij2YgSnlLwMcTMwSprMGrduWq', 1, 1, 0, 37.3639472, -121.92893750000002, 0, 'OAK'),
(24, 'driver3@sjc.domain.com', '$2y$10$eJHvLQ5LzfGoOV2EUh0ituZxBNxN.KQOrkvxX0yLJe5p/DSQFUmke', 1, 1, 0, 37.3639472, -121.92893750000002, 0, NULL),
(25, 'driver4@sjc.domain.com', '$2y$10$Am0klGgx59PZBkC3eDAWvunDq9sdP1nk3.LGqF7zcPVk/lDEAYg2i', 1, 1, 0, 37.3639472, -121.92893750000002, 0, NULL),
(26, 'driver5@sjc.domain.com', '$2y$10$JyDBXD91JWfEqXlZGT0cKOjO2uvkDLMmjboGqICM40qfR/V1zBWFK', 1, 1, 0, 37.3639472, -121.92893750000002, 0, 'OAK'),
(27, 'driver6@sjc.domain.com', '$2y$10$WmnvfaBDjOFW/hd69a3bb./SO2bikAtmvi1DXrs/DQv59jNeoFOcW', 1, 1, 0, 37.3639472, -121.92893750000002, 0, 'OAK'),
(28, 'driver7@sjc.domain.com', '$2y$10$moprbkunIyOVBqjDntouLOWWitKn6YOoddtUJx174qS.7PLSmwTWm', 1, 1, 0, 37.3639472, -121.92893750000002, 0, 'OAK'),
(29, 'driver8@sjc.domain.com', '$2y$10$zT.I/FLHnW8Hx1.5b1EoBO3vd.iVhAheRvaj3LSRedFXrwyhs3b5u', 1, 1, 0, 37.3639472, -121.92893750000002, 0, 'OAK'),
(30, 'driver9@sjc.domain.com', '$2y$10$z4Znopk9S/U2beJohwIyruAPZ36NIz6Sy8a.xpffo2KtvNzoSETlS', 1, 1, 0, 37.3639472, -121.92893750000002, 0, 'OAK');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `id_rider` int(11) NOT NULL,
  `id_driver` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `riders`
--

CREATE TABLE `riders` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `riders`
--

INSERT INTO `riders` (`id`, `email`, `password`) VALUES
(1, 'rider0@lif.domain.com', '$2y$10$.NoOQZfOOSPwYgyfykriWeY0jMS4pcaIcoleEwJdoyPwFrmX.UAkq');

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
  ADD UNIQUE KEY `id_rider` (`id_rider`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
