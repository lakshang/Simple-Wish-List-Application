-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.10-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5328
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for backbone
CREATE DATABASE IF NOT EXISTS `backbone` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `backbone`;

-- Dumping structure for table backbone.list
CREATE TABLE IF NOT EXISTS `list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_list_user` (`user_id`),
  CONSTRAINT `FK_list_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

-- Dumping data for table backbone.list: ~10 rows (approximately)
/*!40000 ALTER TABLE `list` DISABLE KEYS */;
INSERT INTO `list` (`id`, `title`, `url`, `price`, `priority`, `user_id`) VALUES
	(43, 'KAMVAS Pro 12 11.6-inch Digital Graphics Tablet Passive Pen Display Drawing Monitor', 'https://www.aliexpress.com/item/KAMVAS-Pro-12-11-6-inch-Digital-Graphics-Tablet-Passive-Pen-Display-Drawing-Monitor-with-Tilt/32952713376.html', '296', '1', 58),
	(44, 'KKmoon 1080P 2.0MP Wireless WIFI Dome PTZ HD IP Camera Outdoor 5X Optical', 'https://www.aliexpress.com/item/HOMTOM-ZOJI-Z11-IP68-Waterproof-Dust-Proof-10000mAh-Smartphone-4GB-64GB-Octa-Core-Cell-Phone-5/32967132425.html', '73.9', '2', 58),
	(46, 'HOMTOM ZOJI Z11 IP68 Waterproof Dust Proof 10000mAh Smartphone 4GB ', 'https://www.aliexpress.com/item/HOMTOM-ZOJI-Z11-IP68-Waterproof-Dust-Proof-10000mAh-Smartphone-4GB-64GB-Octa-Core-Cell-Phone-5/32967132425.html', '196.00', '1', 58),
	(47, 'INQMEGA HD 1080P Cloud Wireless IP Camera Intelligent Auto Tracking Of Human', 'https://www.aliexpress.com/item/INQMEGA-HD-1080P-Cloud-Wireless-IP-Camera-Intelligent-Auto-Tracking-Of-Human-Home-Security-Surveillance-CCTV/32885045390.html', '18.60', '3', 65),
	(61, 'Baby', 'www.baby.com', '250.00', '1', 66),
	(82, 'LEMFO LEM X 4G Smart Watch Android 7.1', 'https://www.aliexpress.com/item/LEMFO-LEM-X-4G-Smart-Watch-Android-7-1-With-8MP-Camera-GPS-2-03-inch/32918220938.html', '136.40', '3', 58),
	(83, 'LEMFO LEM X 4G Smart Watch Android 7.1', 'https://www.aliexpress.com/item/LEMFO-LEM-X-4G-Smart-Watch-Android-7-1-With-8MP-Camera-GPS-2-03-inch/32918220938.html', '136.49', '2', 65),
	(93, 'test1', 'www.google.com', '255', '1', 68),
	(94, 'test2', 'www.google.com', '77', '2', 68);
/*!40000 ALTER TABLE `list` ENABLE KEYS */;

-- Dumping structure for table backbone.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(50) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

-- Dumping data for table backbone.user: ~4 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `username`, `password`, `name`, `description`) VALUES
	(58, 'admin', 'admin', 'Birthday Gifts', 'Items needed for the birthday.'),
	(65, 'lakshang', 'ass19980813', 'Christmas Gifts', 'Items for Christmas'),
	(66, 'abc', 'abc', 'ABC', 'Birthday Wishlist'),
	(68, 'user', 'user', 'Birthday', 'Des');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for table backbone.wishlist
CREATE TABLE IF NOT EXISTS `wishlist` (
  `wid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wid`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `FK1_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table backbone.wishlist: ~3 rows (approximately)
/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;
INSERT INTO `wishlist` (`wid`, `user_id`) VALUES
	(6, 58),
	(13, 65),
	(14, 66),
	(15, 68);
/*!40000 ALTER TABLE `wishlist` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
