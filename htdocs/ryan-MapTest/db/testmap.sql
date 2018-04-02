-- XAMPP -> create database named testmap and upload this testmap.sql in SQL
--
-- Database: `testmap`
--
-- --------------------------------------------------------
--
-- Table structure for table `testAirport`
--

CREATE TABLE `testAirport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `lat` float(11, 7) NULL, 
  `lng` float(11, 7) NULL, 
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- INSERT VALUES for `testAirport` type can be drivers or riders
--

INSERT INTO `testAirport`(`id`, `name`, `address`, `type`, `lat`, `lng`)
	VALUES 
	(1, 'SFO', 'SFO, San Francisco, CA 94612', 'Airport', NULL, NULL),
	(2, 'SJC', '1701 Airport Blvd, San Jose, CA 95110', 'Airport', NULL, NULL),
	(3, 'OAK', '1 Airport Dr, Oakland, CA 94621', 'Airport', NULL, NULL);
