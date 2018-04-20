-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2018 at 03:59 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

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
(1, 'driver0@sfo.domain.com', '$2y$10$jWWicBx/XJOtbc8UCssgneDaMoWJG3pxBYjg7KJR7/wZnMgpUS9ma', 1, 1, 0, 37.6213129, -122.3789554, 1, 'OAK'),
(2, 'driver1@sfo.domain.com', '$2y$10$rhl78bz2OK9jC95IXqnKPOvKyxkcz67KhgAQNVKILZS2I1WsKCpIu', 1, 1, 0, 37.6213129, -122.3789554, 1, 'OAK'),
(3, 'driver2@sfo.domain.com', '$2y$10$Q424LRW3RSiLTF7emIub4etlMdA5d.IqfRDN/fYKB/rHkGNDLV4F2', 1, 1, 0, 37.6213129, -122.3789554, 1, 'OAK'),
(4, 'driver3@sfo.domain.com', '$2y$10$D16WP1jhEBZIbm79BIvXJ.fRF3USrZfv5NkbYGkKn39p9DU7HqApm', 1, 1, 0, 37.6213129, -122.3789554, 1, 'OAK'),
(5, 'driver4@sfo.domain.com', '$2y$10$g1fufbHOZlCov9g8Uo7sL.9s3JwKkgzaz1qzX7cmD.3YnMIQguJo.', 1, 1, 0, 37.6213129, -122.3789554, 1, 'OAK'),
(6, 'driver5@sfo.domain.com', '$2y$10$xJYN68lbJykkOFFCSCVznOlFXALiZrCfD6qyKFbKgoD5tofRYebAq', 1, 1, 0, 37.6213129, -122.3789554, 1, 'OAK'),
(7, 'driver6@sfo.domain.com', '$2y$10$Vm3Hjvl4ZF64WKvl.QoFg.qXeiz.21zp5bPMB90.aNeIAnooRUTEW', 1, 1, 0, 37.6213129, -122.3789554, 1, 'OAK'),
(8, 'driver7@sfo.domain.com', '$2y$10$eqo5ADiTTuae3E/Q8N0DHOT4fP.GA65U9leGBoLONPb0hdK9iLOPi', 1, 1, 0, 37.6213129, -122.3789554, 1, 'OAK'),
(9, 'driver8@sfo.domain.com', '$2y$10$YAs5nvMvDxjNQ6rit4mZ4eXYgk6yeFOL1yXFsGhSoLryvZwsVgI1.', 1, 1, 0, 37.6213129, -122.3789554, 1, 'OAK'),
(10, 'driver9@sfo.domain.com', '$2y$10$e2w9McNKPqcBOri5VfIeLeEMuI1GPi0maFYwjWgXe7oBw0wbd6m2.', 1, 1, 0, 37.6213129, -122.3789554, 1, 'OAK'),
(11, 'driver0@oak.domain.com', '$2y$10$60bq0VxPq6X1.E2nzn3vN.XmgrtoVdc5S6B1.1pHNZRHByxTnYMtW', 1, 1, 0, 37.7125689, -122.2197428, 1, 'OAK'),
(12, 'driver1@oak.domain.com', '$2y$10$c8RRVVISueyW.Ws1bAkkiufe1gXZoIxd69iMtDXxW7ow9NfMccNo6', 1, 1, 0, 37.7125689, -122.2197428, 1, 'OAK'),
(13, 'driver2@oak.domain.com', '$2y$10$cmj4Mk2qvmWwwZ.4VCXV7.IMzMfScOZBpnyFag4ckPlWW8wDX4tb2', 1, 1, 0, 37.7125689, -122.2197428, 1, 'OAK'),
(14, 'driver3@oak.domain.com', '$2y$10$xEYWe.VDCK1Uvu/JiwR7g.pifvvprHCQmlsvkJVBDHhE7Lcp.FqVu', 1, 1, 0, 37.7125689, -122.2197428, 1, 'OAK'),
(15, 'driver4@oak.domain.com', '$2y$10$JxiMrcNar.QPk4om3xD/QuPKa0F3V51.Cg/Vcwc6gRyr9EbFeb9ya', 1, 1, 0, 37.7125689, -122.2197428, 1, 'OAK'),
(16, 'driver5@oak.domain.com', '$2y$10$DnLFnJhFH.L91Asm15gsTOgr/7tLuKr/mTme9.TUo1Rf4JpbaaHya', 1, 1, 0, 37.7125689, -122.2197428, 1, 'OAK'),
(17, 'driver6@oak.domain.com', '$2y$10$doPZYtr7b.BXhWFX2TTxy.6nfYuf2pZkIE5jpsHikO4sX8atWuEIa', 1, 1, 0, 37.7125689, -122.2197428, 1, 'OAK'),
(18, 'driver7@oak.domain.com', '$2y$10$siIwxWT3rt5T4/shKjCH0ehRWzPjEHMJWr9jmo2iNyN033nzFIuRa', 1, 1, 0, 37.7125689, -122.2197428, 1, 'OAK'),
(19, 'driver8@oak.domain.com', '$2y$10$FERPojxh.vDVvlSlirhtM.uazdaqFXpUOibljwK9FueVHQAQMTD9S', 1, 1, 0, 37.7125689, -122.2197428, 1, 'OAK'),
(20, 'driver9@oak.domain.com', '$2y$10$JJI5j86vejUTBDcAiY144O0eXOjjqyRvPlbyslKQnoUTz1BuDmQPa', 1, 1, 0, 37.7125689, -122.2197428, 1, 'OAK'),
(21, 'driver0@sjc.domain.com', '$2y$10$3U9Q/U/G/yM/na0nN/WkseyX8TzdNrOc/9ipXRG8OPI86kxNntiK.', 1, 1, 0, 37.3639472, -121.92893750000002, 1, 'OAK'),
(22, 'driver1@sjc.domain.com', '$2y$10$SHIJbbuRcH2gjFun/ALqwOi2xZqUvqfUOjyl8Sttn83ltrAqnLYUu', 1, 1, 0, 37.3639472, -121.92893750000002, 1, 'OAK'),
(23, 'driver2@sjc.domain.com', '$2y$10$L3J5JW4K0yUlWl2H8PMzmOvlOENHij2YgSnlLwMcTMwSprMGrduWq', 1, 1, 0, 37.3639472, -121.92893750000002, 1, 'OAK'),
(24, 'driver3@sjc.domain.com', '$2y$10$eJHvLQ5LzfGoOV2EUh0ituZxBNxN.KQOrkvxX0yLJe5p/DSQFUmke', 1, 1, 0, 37.3639472, -121.92893750000002, 1, 'OAK'),
(25, 'driver4@sjc.domain.com', '$2y$10$Am0klGgx59PZBkC3eDAWvunDq9sdP1nk3.LGqF7zcPVk/lDEAYg2i', 1, 1, 0, 37.3639472, -121.92893750000002, 1, 'OAK'),
(26, 'driver5@sjc.domain.com', '$2y$10$JyDBXD91JWfEqXlZGT0cKOjO2uvkDLMmjboGqICM40qfR/V1zBWFK', 1, 1, 0, 37.3639472, -121.92893750000002, 1, 'OAK'),
(27, 'driver6@sjc.domain.com', '$2y$10$WmnvfaBDjOFW/hd69a3bb./SO2bikAtmvi1DXrs/DQv59jNeoFOcW', 1, 1, 0, 37.3639472, -121.92893750000002, 1, 'OAK'),
(28, 'driver7@sjc.domain.com', '$2y$10$moprbkunIyOVBqjDntouLOWWitKn6YOoddtUJx174qS.7PLSmwTWm', 1, 1, 0, 37.3639472, -121.92893750000002, 1, 'OAK'),
(29, 'driver8@sjc.domain.com', '$2y$10$zT.I/FLHnW8Hx1.5b1EoBO3vd.iVhAheRvaj3LSRedFXrwyhs3b5u', 1, 1, 0, 37.3639472, -121.92893750000002, 1, 'OAK'),
(30, 'driver9@sjc.domain.com', '$2y$10$z4Znopk9S/U2beJohwIyruAPZ36NIz6Sy8a.xpffo2KtvNzoSETlS', 1, 1, 0, 37.3639472, -121.92893750000002, 1, 'SFO');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `id_rider` int(11) NOT NULL,
  `id_driver` int(11) NOT NULL,
  `polyline_1` mediumtext,
  `polyline_2` mediumtext,
  `polyline_3` mediumtext,
  `eta_1` int(11) DEFAULT NULL,
  `eta_2` int(11) DEFAULT NULL,
  `eta_3` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `id_rider`, `id_driver`, `polyline_1`, `polyline_2`, `polyline_3`, `eta_1`, `eta_2`, `eta_3`) VALUES
(8, 2, 30, '[{\"lat\":\"37.3639472\",\"lng\":\"-121.92893750000002\",\"eta\":\"0\"},{\"lat\":\"37.366350000000004\",\"lng\":\"-121.92554000000001\",\"eta\":\"31.001240676993458\"},{\"lat\":\"37.363780000000006\",\"lng\":\"-121.92248000000001\",\"eta\":\"61.42648396447066\"},{\"lat\":\"37.36207\",\"lng\":\"-121.91904000000001\",\"eta\":\"122.02218772472372\"},{\"lat\":\"37.36061\",\"lng\":\"-121.91636000000001\",\"eta\":\"181.04515067620906\"},{\"lat\":\"37.35468\",\"lng\":\"-121.91183000000001\",\"eta\":\"240.6881514842828\"},{\"lat\":\"37.34859\",\"lng\":\"-121.9077\",\"eta\":\"300.4224035506048\"},{\"lat\":\"37.343520000000005\",\"lng\":\"-121.90184\",\"eta\":\"360.95492557055843\"},{\"lat\":\"37.33733\",\"lng\":\"-121.89789\",\"eta\":\"420.5813483337068\"},{\"lat\":\"37.3305\",\"lng\":\"-121.89651\",\"eta\":\"480.015221756622\"},{\"lat\":\"37.323930000000004\",\"lng\":\"-121.89371000000001\",\"eta\":\"540.2645270916215\"},{\"lat\":\"37.325050000000005\",\"lng\":\"-121.88567\",\"eta\":\"600.6797886338373\"},{\"lat\":\"37.32725000000001\",\"lng\":\"-121.87759000000001\",\"eta\":\"660.2937736148167\"},{\"lat\":\"37.331610000000005\",\"lng\":\"-121.87856000000001\",\"eta\":\"724.820110511883\"},{\"lat\":\"37.3351874\",\"lng\":\"-121.88107150000002\",\"eta\":\"760.0000000000001\"}]', '[{\"lat\":\"37.3351874\",\"lng\":\"-121.88107150000002\",\"eta\":\"0\"},{\"lat\":\"37.3344\",\"lng\":\"-121.88063000000001\",\"eta\":\"4.009923270110241\"},{\"lat\":\"37.325950000000006\",\"lng\":\"-121.88397\",\"eta\":\"60.80483651126784\"},{\"lat\":\"37.330580000000005\",\"lng\":\"-121.89594000000001\",\"eta\":\"120.34530164530352\"},{\"lat\":\"37.342560000000006\",\"lng\":\"-121.90111000000002\",\"eta\":\"180.04508937277336\"},{\"lat\":\"37.353\",\"lng\":\"-121.91052\",\"eta\":\"241.35198896676394\"},{\"lat\":\"37.364140000000006\",\"lng\":\"-121.91862\",\"eta\":\"301.23073833565763\"},{\"lat\":\"37.373850000000004\",\"lng\":\"-121.92801000000001\",\"eta\":\"360.0565037806767\"},{\"lat\":\"37.37724\",\"lng\":\"-121.94374\",\"eta\":\"420.878659016439\"},{\"lat\":\"37.380750000000006\",\"lng\":\"-121.95916000000001\",\"eta\":\"480.2250079475958\"},{\"lat\":\"37.385160000000006\",\"lng\":\"-121.97455000000001\",\"eta\":\"540.7066345952652\"},{\"lat\":\"37.38944\",\"lng\":\"-121.98967\",\"eta\":\"600.0346913976628\"},{\"lat\":\"37.394180000000006\",\"lng\":\"-122.00604000000001\",\"eta\":\"664.4393233101173\"},{\"lat\":\"37.3975\",\"lng\":\"-122.02074\",\"eta\":\"720.9232213783008\"},{\"lat\":\"37.400920000000006\",\"lng\":\"-122.03635000000001\",\"eta\":\"780.7586064744684\"},{\"lat\":\"37.40444\",\"lng\":\"-122.05222\",\"eta\":\"841.6483064934165\"},{\"lat\":\"37.408010000000004\",\"lng\":\"-122.06753\",\"eta\":\"900.6324847402519\"},{\"lat\":\"37.41377\",\"lng\":\"-122.08204\",\"eta\":\"960.6604430635161\"},{\"lat\":\"37.422270000000005\",\"lng\":\"-122.09404\",\"eta\":\"1020.0923805844635\"},{\"lat\":\"37.431810000000006\",\"lng\":\"-122.10494000000001\",\"eta\":\"1080.1111329658077\"},{\"lat\":\"37.44201\",\"lng\":\"-122.11562\",\"eta\":\"1141.8228770243563\"},{\"lat\":\"37.451660000000004\",\"lng\":\"-122.12594000000001\",\"eta\":\"1200.734642492203\"},{\"lat\":\"37.45937\",\"lng\":\"-122.13885\",\"eta\":\"1260.3970214419005\"},{\"lat\":\"37.467040000000004\",\"lng\":\"-122.15193000000001\",\"eta\":\"1320.4385762466177\"},{\"lat\":\"37.474990000000005\",\"lng\":\"-122.16546000000001\",\"eta\":\"1382.588525420416\"},{\"lat\":\"37.48234\",\"lng\":\"-122.17810000000001\",\"eta\":\"1440.44137461503\"},{\"lat\":\"37.486180000000004\",\"lng\":\"-122.19434000000001\",\"eta\":\"1503.4933773956634\"},{\"lat\":\"37.488200000000006\",\"lng\":\"-122.20960000000001\",\"eta\":\"1560.6090020131833\"},{\"lat\":\"37.493750000000006\",\"lng\":\"-122.22430000000001\",\"eta\":\"1620.8928185100306\"},{\"lat\":\"37.499010000000006\",\"lng\":\"-122.23904000000002\",\"eta\":\"1680.9326450823687\"},{\"lat\":\"37.50869\",\"lng\":\"-122.25004000000001\",\"eta\":\"1741.5547607815342\"},{\"lat\":\"37.51816\",\"lng\":\"-122.26079000000001\",\"eta\":\"1800.8298647950905\"},{\"lat\":\"37.52765\",\"lng\":\"-122.2715\",\"eta\":\"1860.0717496316986\"},{\"lat\":\"37.538000000000004\",\"lng\":\"-122.28172\",\"eta\":\"1921.2724976912111\"},{\"lat\":\"37.5484\",\"lng\":\"-122.29137000000001\",\"eta\":\"1981.32898502732\"},{\"lat\":\"37.558960000000006\",\"lng\":\"-122.30117000000001\",\"eta\":\"2042.3123665869955\"},{\"lat\":\"37.568780000000004\",\"lng\":\"-122.31162\",\"eta\":\"2102.088542820306\"},{\"lat\":\"37.57826\",\"lng\":\"-122.32192\",\"eta\":\"2160.280620793241\"},{\"lat\":\"37.58679\",\"lng\":\"-122.33376000000001\",\"eta\":\"2220.706007093077\"},{\"lat\":\"37.58722\",\"lng\":\"-122.35005000000001\",\"eta\":\"2280.7835499513985\"},{\"lat\":\"37.59237\",\"lng\":\"-122.36464000000001\",\"eta\":\"2341.6505004867886\"},{\"lat\":\"37.600680000000004\",\"lng\":\"-122.37733000000001\",\"eta\":\"2402.3247238379195\"},{\"lat\":\"37.60904\",\"lng\":\"-122.38973000000001\",\"eta\":\"2462.4894291128167\"},{\"lat\":\"37.615370000000006\",\"lng\":\"-122.38810000000001\",\"eta\":\"2520.560429285356\"},{\"lat\":\"37.6213129\",\"lng\":\"-122.3789554\",\"eta\":\"2571.0000000000036\"}]', NULL, 0, 0, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `riders`
--
ALTER TABLE `riders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
