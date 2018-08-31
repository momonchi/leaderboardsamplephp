-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.34-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for leaderboarddb
CREATE DATABASE IF NOT EXISTS `leaderboarddb` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `leaderboarddb`;

-- Dumping structure for table leaderboarddb.main_leader_board
CREATE TABLE IF NOT EXISTS `main_leader_board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(255) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '0',
  `score_type` enum('easy','medium','hard') NOT NULL DEFAULT 'easy',
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table leaderboarddb.main_leader_board: ~0 rows (approximately)
/*!40000 ALTER TABLE `main_leader_board` DISABLE KEYS */;
/*!40000 ALTER TABLE `main_leader_board` ENABLE KEYS */;

-- Dumping structure for table leaderboarddb.normalize_score
CREATE TABLE IF NOT EXISTS `normalize_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(255) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '0',
  `score` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table leaderboarddb.normalize_score: ~0 rows (approximately)
/*!40000 ALTER TABLE `normalize_score` DISABLE KEYS */;
/*!40000 ALTER TABLE `normalize_score` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
