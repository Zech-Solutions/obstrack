-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for obstrack_db
CREATE DATABASE IF NOT EXISTS `obstrack_db` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `obstrack_db`;

-- Dumping structure for table obstrack_db.tbl_barangays
CREATE TABLE IF NOT EXISTS `tbl_barangays` (
  `brgy_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `name` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`brgy_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table obstrack_db.tbl_barangays: ~0 rows (approximately)

-- Dumping structure for table obstrack_db.tbl_obstructions
CREATE TABLE IF NOT EXISTS `tbl_obstructions` (
  `obstruction_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `detail` text NOT NULL,
  `obstruction_type_id` char(36) DEFAULT NULL,
  `brgy_id` char(36) DEFAULT NULL,
  `location` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`location`)),
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `reported_by` char(36) NOT NULL DEFAULT '',
  `reported_to` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`reported_to`)),
  `status` enum('PENDING','WIP','COMPLETED','REJECTED') DEFAULT 'PENDING',
  `approval_status` enum('PENDING','APPROVED','REJECTED') DEFAULT 'PENDING',
  `actioned_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `is_anonymous` int(1) DEFAULT NULL,
  PRIMARY KEY (`obstruction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table obstrack_db.tbl_obstructions: ~0 rows (approximately)

-- Dumping structure for table obstrack_db.tbl_obstruction_actions
CREATE TABLE IF NOT EXISTS `tbl_obstruction_actions` (
  `obstruction_action_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `obstruction_id` char(36) NOT NULL,
  `actioned_by` char(36) NOT NULL,
  `detail` text DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `status` enum('WIP','COMPLETED') DEFAULT 'WIP',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`obstruction_action_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table obstrack_db.tbl_obstruction_actions: ~0 rows (approximately)

-- Dumping structure for table obstrack_db.tbl_obstruction_types
CREATE TABLE IF NOT EXISTS `tbl_obstruction_types` (
  `obstruction_type_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`obstruction_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table obstrack_db.tbl_obstruction_types: ~0 rows (approximately)

-- Dumping structure for table obstrack_db.tbl_requests
CREATE TABLE IF NOT EXISTS `tbl_requests` (
  `request_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `brgy_id` char(36) NOT NULL,
  `message` text NOT NULL,
  `obstruction_id` text NOT NULL,
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`files`)),
  `request_by` char(36) NOT NULL DEFAULT '',
  `approved_by` char(36) DEFAULT '',
  `status` enum('PENDING','APPROVED','REJECTED') DEFAULT 'PENDING',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table obstrack_db.tbl_requests: ~0 rows (approximately)

-- Dumping structure for table obstrack_db.tbl_users
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `brgy_id` char(36) DEFAULT NULL,
  `role` enum('ROOT','ADMIN','USER','DILG') NOT NULL DEFAULT 'USER',
  `username` varchar(50) NOT NULL DEFAULT '0',
  `password` text NOT NULL,
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `middle_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `dob` date DEFAULT NULL,
  `gender` varchar(1) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table obstrack_db.tbl_users: ~1 rows (approximately)
INSERT INTO `tbl_users` (`user_id`, `brgy_id`, `role`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `dob`, `gender`, `created_at`, `updated_at`, `deleted_at`) VALUES
	('1d96e12b-4071-4958-a584-a450cf063fa4', NULL, 'ROOT', 'root', '$2y$10$hI6lk9nnSVjxBs67DfrvneK793Kkn9ZLyppChsgklkW1UFhxTi/ru', 'Admin', 'I', 'Strator', '2001-01-01', 'M', '2024-05-26 14:30:25', '2024-05-26 14:31:06', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
