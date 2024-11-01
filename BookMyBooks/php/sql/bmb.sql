-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for bmb
CREATE DATABASE IF NOT EXISTS `bmb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `bmb`;

-- Dumping structure for table bmb.books
CREATE TABLE IF NOT EXISTS `books` (
  `ISBN` varchar(50) NOT NULL DEFAULT '',
  `disabled` enum('0','1') NOT NULL DEFAULT '0',
  `name` varchar(256) NOT NULL,
  `price` float NOT NULL DEFAULT 0,
  `author` varchar(50) NOT NULL,
  `publisher` varchar(50) NOT NULL,
  `publication_year` int(11) NOT NULL,
  `language` varchar(50) NOT NULL DEFAULT '"English"',
  `thumbnail` mediumtext DEFAULT NULL COMMENT 'base64 text',
  `category` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 10,
  `discount` int(11) DEFAULT 0,
  PRIMARY KEY (`ISBN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Provides information about books';

-- Data exporting was unselected.

-- Dumping structure for table bmb.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `name` varchar(50) NOT NULL,
  `status` binary(50) NOT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table bmb.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `details` varchar(50) NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '0',
  `cost` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `delivery_date` timestamp NULL DEFAULT NULL,
  `admin_comments` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for view bmb.publishers
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `publishers` (
	`publisher` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for table bmb.users
CREATE TABLE IF NOT EXISTS `users` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `disabled` enum('1','0') NOT NULL DEFAULT '0',
  `isReset` enum('1','0') NOT NULL DEFAULT '0',
  `isAdmin` enum('1','0') NOT NULL DEFAULT '0',
  `country` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `admin_comments` varchar(50) NOT NULL DEFAULT '',
  `cart` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`cart`)),
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `publishers`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `publishers` AS select publisher FROM books ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
