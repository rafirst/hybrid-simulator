-- phpMyAdmin SQL Dump
-- Database: `hybrid_simulator`
-- Compatible with MySQL 5.7, 8.0, 8.4 & MariaDB

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `hybrid_simulator` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `hybrid_simulator`;

-- --------------------------------------------------------
-- Table structure for table `settings`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `settings`
-- --------------------------------------------------------

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'app_title', 'HYBRID SYSTEM SIMULATOR', 'string', 'Judul utama aplikasi simulator', NOW(), NOW()),
(2, 'app_subtitle', 'Panduan interaktif memahami sistem penggerak ramah lingkungan.', 'string', 'Sub judul penjelasan simulator', NOW(), NOW()),
(3, 'upload_password', 'Dms1234', 'string', 'Password proteksi untuk upload model 3D baru', NOW(), NOW()),
(4, 'default_body_color', 'blue', 'string', 'Warna bawaan bodi (red, white, blue)', NOW(), NOW()),
(5, 'default_body_opacity', '0.50', 'float', 'Tingkat transparansi bodi bawaan (0.00 - 1.00)', NOW(), NOW()),
(6, 'enable_audio', 'true', 'boolean', 'Mengaktifkan efek suara sistem dan mesin', NOW(), NOW()),
(7, 'enable_logging', 'true', 'boolean', 'Mencatat aktivitas interaksi simulasi pengguna', NOW(), NOW()),
(8, 'max_speed_dial', '180', 'integer', 'Batas maksimal pembacaan speedometer (km/h)', NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `vehicle_models`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `vehicle_models`;
CREATE TABLE IF NOT EXISTS `vehicle_models` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Toyota Veloz Hybrid 3D',
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'model/gltf-binary',
  `file_size` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `default_color` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blue',
  `default_opacity` decimal(3,2) NOT NULL DEFAULT 0.50,
  `meta_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `vehicle_models`
-- --------------------------------------------------------

INSERT INTO `vehicle_models` (`id`, `name`, `file_name`, `file_path`, `mime_type`, `file_size`, `is_active`, `default_color`, `default_opacity`, `meta_data`, `created_at`, `updated_at`) VALUES
(1, 'Toyota Veloz Hybrid 3D', 'Veloz.glb', 'models/Veloz.glb', 'model/gltf-binary', 5410884, 1, 'blue', 0.50, '{\"scale\": 31.0, \"author\": \"Hybrid Simulator Team\", \"has_xray\": true, \"version\": \"2.0\", \"position_offset\": {\"mg2\": [-5.2, -3.0, 0], \"engine\": [-12.2, -1.6, 0], \"battery\": [1.8, -3.15, 0]}}', NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `simulation_logs`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `simulation_logs`;
CREATE TABLE IF NOT EXISTS `simulation_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `session_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gear` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `speed` int(11) NOT NULL DEFAULT 0,
  `engine_active` tinyint(1) NOT NULL DEFAULT 0,
  `mg2_active` tinyint(1) NOT NULL DEFAULT 0,
  `battery_active` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `simulation_logs_session_id_index` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
