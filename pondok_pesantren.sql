-- --------------------------------------------------------
-- Database: `pondok_pesantren`
-- Versi Final Fix (Setting + Soft Delete + Unique Key)
-- --------------------------------------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- -------------------------
-- Table structure for table `santri`
-- -------------------------
CREATE TABLE IF NOT EXISTS `santri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `nomor_hp` varchar(20) NOT NULL,
  `is_aktif` tinyint(1) NOT NULL,
  `kategori_diskon_id` int(11) NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------
-- Table structure for table `jenis_tagihan`
-- -------------------------
CREATE TABLE IF NOT EXISTS `jenis_tagihan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------
-- Default data for `jenis_tagihan`
-- -------------------------
INSERT INTO `jenis_tagihan` (`nama`) VALUES
('Semua Santri'),
('Santri TPQ'),
('Santri Maddin'),
('Santri Mukim'),
('Santri Non Mukim'),
('Spesifik Santri');
-- --------------------------------------------------------
-- Table structure for table `tagihan`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `tagihan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tagihan` varchar(255) NOT NULL,
  `jenis_tagihan_id` int(11) NOT NULL,
  `tanggal_tagihan` date NOT NULL,
  `deadline_tagihan` date NOT NULL,
  `target` VARCHAR(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`jenis_tagihan_id`) REFERENCES `jenis_tagihan`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------
-- Table structure for table `kategori_diskon`
-- -------------------------
CREATE TABLE IF NOT EXISTS `kategori_diskon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------
-- Table structure for table `diskon_rule`
-- -------------------------
CREATE TABLE IF NOT EXISTS `diskon_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_tagihan_id` int(11) NOT NULL,
  `kategori_diskon_id` int(11) NOT NULL,
  `diskon_persen` decimal(5,2) NOT NULL DEFAULT 0.00,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_diskon_rule_unique` (`jenis_tagihan_id`,`kategori_diskon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------
-- Table structure for table `setting`
-- -------------------------
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_setting_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------
-- Default data for `setting`
-- -------------------------
INSERT INTO `setting` (`key`, `value`, `deskripsi`) VALUES
('app_name', 'Pondok Pesantren', 'Nama aplikasi sistem manajemen pondok pesantren'),
('app_version', '1.0.0', 'Versi aplikasi'),
('timezone', 'Asia/Jakarta', 'Zona waktu default'),
('currency', 'IDR', 'Mata uang default'),
('per_page', '10', 'Jumlah data per halaman'),
('date_format', 'Y-m-d', 'Format tanggal default'),
('time_format', 'H:i:s', 'Format waktu default');

COMMIT;
