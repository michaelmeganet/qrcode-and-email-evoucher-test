-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table ishindata.customers
DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cus_name` varchar(50) NOT NULL,
  `address1` varchar(50) DEFAULT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `address3` varchar(50) DEFAULT NULL,
  `phone` varchar(18) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  KEY `cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table ishindata.customers: ~6 rows (approximately)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`cid`, `cus_name`, `address1`, `address2`, `address3`, `phone`, `email`, `status`) VALUES
	(1, 'Claudio', 'Jl. Sungkai Delta Silicon', 'Cikarang', 'Indonesia', '08973773737', 'mosint.nagant@gmail.com', 'active'),
	(2, 'Chong C.T', 'Malaysia', NULL, NULL, NULL, 'cct3000@gmail.com', 'active'),
	(3, 'Claudio 2', 'Jl. Sungkai', 'Cikarang', 'Indonesia', NULL, 'claudio.christyo@gmail.com', 'active'),
	(4, 'IT PHH Indo', 'Jl. Sungkai', 'Indonesia', NULL, NULL, 'it@phh.co.id', 'active'),
	(10, 'Marni', 'PT. PHH Special Steel', 'Jl. Sungkai', 'Cikarang, Indonesia', '21', 'sales@phh.co.id', 'active'),
	(20, 'Silvi', 'Cicau', 'Cikarang, Bekasi', 'Indonesia', '021123456789', 'test@email.com', 'active');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
