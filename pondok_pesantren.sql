-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2025 at 11:07 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pondok_pesantren`
--

-- --------------------------------------------------------

--
-- Table structure for table `santri`
--

CREATE TABLE `santri` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `nomor_hp` varchar(20) NOT NULL,
  `is_aktif` tinyint(1) NOT NULL,
  `kategori_diskon_id` int(11) NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `santri`
--

INSERT INTO `santri` (`id`, `nama`, `kelas`, `nomor_hp`, `is_aktif`, `kategori_diskon_id`, `is_deleted`) VALUES
(2, 'jgsdj', '426', '0989786', 1, NULL, 1),
(3, 'azis', '7', '099', 1, NULL, 1),
(4, 'jhsg', '21', '425346', 1, NULL, 1),
(5, 'ihfsksdnf', '8759', '09977656', 1, NULL, 1),
(6, 'ugiuk', '123', '0998786', 1, NULL, 0),
(7, 'gsh', '45', '098u8y67576', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_tagihan`
--

CREATE TABLE `jenis_tagihan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_diskon`
--

CREATE TABLE `kategori_diskon` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabel untuk menyimpan kategori diskon yang tersedia';

--
-- Dumping data for table `kategori_diskon`
--

INSERT INTO `kategori_diskon` (`id`, `nama`, `is_deleted`) VALUES
(1, 'Anak Yatim', 0),
(2, 'Anak Piatu', 0),
(3, 'Yatim Piatu', 0),
(4, 'Keluarga Tidak Mampu', 0),
(5, 'Prestasi Akademik', 0),
(6, 'Prestasi Non-Akademik', 0),
(7, 'Keluarga Guru/Staff', 0),
(8, 'Saudara Kandung', 0),
(9, 'Beasiswa Khusus', 0),
(10, 'Diskon Umum', 0);

-- --------------------------------------------------------

--
-- Table structure for table `diskon_rule`
--

CREATE TABLE `diskon_rule` (
  `id` int(11) NOT NULL,
  `jenis_tagihan_id` int(11) NOT NULL,
  `kategori_diskon_id` int(11) NOT NULL,
  `diskon_persen` decimal(5,2) NOT NULL DEFAULT 0.00,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabel untuk menyimpan aturan diskon berdasarkan jenis tagihan dan kategori diskon';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kategori_diskon_id` (`kategori_diskon_id`),
  ADD KEY `idx_is_aktif` (`is_aktif`),
  ADD KEY `idx_is_deleted` (`is_deleted`);

--
-- Indexes for table `jenis_tagihan`
--
ALTER TABLE `jenis_tagihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_is_deleted` (`is_deleted`);

--
-- Indexes for table `kategori_diskon`
--
ALTER TABLE `kategori_diskon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_is_deleted` (`is_deleted`);

--
-- Indexes for table `diskon_rule`
--
ALTER TABLE `diskon_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_diskon_rule_unique` (`jenis_tagihan_id`,`kategori_diskon_id`),
  ADD KEY `idx_jenis_tagihan_id` (`jenis_tagihan_id`),
  ADD KEY `idx_kategori_diskon_id` (`kategori_diskon_id`),
  ADD KEY `idx_is_aktif` (`is_aktif`),
  ADD KEY `idx_is_deleted` (`is_deleted`),
  ADD KEY `idx_diskon_rule_active` (`is_aktif`,`is_deleted`),
  ADD KEY `idx_diskon_rule_percentage` (`diskon_persen`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `santri`
--
ALTER TABLE `santri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jenis_tagihan`
--
ALTER TABLE `jenis_tagihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_diskon`
--
ALTER TABLE `kategori_diskon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `diskon_rule`
--
ALTER TABLE `diskon_rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `santri`
--
ALTER TABLE `santri`
  ADD CONSTRAINT `fk_santri_kategori_diskon` FOREIGN KEY (`kategori_diskon_id`) REFERENCES `kategori_diskon` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `diskon_rule`
--
ALTER TABLE `diskon_rule`
  ADD CONSTRAINT `fk_diskon_rule_jenis_tagihan` FOREIGN KEY (`jenis_tagihan_id`) REFERENCES `jenis_tagihan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_diskon_rule_kategori_diskon` FOREIGN KEY (`kategori_diskon_id`) REFERENCES `kategori_diskon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
