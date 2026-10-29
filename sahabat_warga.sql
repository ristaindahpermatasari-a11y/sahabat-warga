-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2026 at 03:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sahabat_warga`
--

-- --------------------------------------------------------

--
-- Table structure for table `distributions`
--

CREATE TABLE `distributions` (
  `id` int(11) NOT NULL,
  `proposal_id` int(11) NOT NULL,
  `status` enum('scheduled','in_progress','completed') DEFAULT 'scheduled',
  `notes` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_type` enum('mitra','petugas') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `program_id` int(11) NOT NULL,
  `mitra_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `criteria` text DEFAULT NULL,
  `coverage_area` varchar(255) DEFAULT NULL,
  `quota` int(11) DEFAULT NULL,
  `status` enum('draft','active','closed') DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`program_id`, `mitra_id`, `title`, `category`, `description`, `criteria`, `coverage_area`, `quota`, `status`, `created_at`) VALUES
(1, 20260002, 'Paket Sembako Bulanan', 'Bantuan Pangan', 'Paket sembako berisi beras 5 kg, minyak goreng 1 liter, gula 1 kg, dan mi instan untuk keluarga prasejahtera.', 'Keluarga kurang mampu atau sangat kurang mampu', 'Kelurahan Jatiwaringin', 50, 'active', '2026-10-29 13:54:09'),
(2, 20260002, 'Bantuan Beras 10 kg', 'Bantuan Pangan', 'Penyaluran beras premium 10 kg untuk keluarga yang belum menerima bantuan pangan lain.', 'Penghasilan di bawah Rp1.000.000 per bulan', 'Kelurahan Jatiwaringin', 40, 'active', '2026-10-29 13:54:09'),
(3, 20260002, 'Subsidi Minyak Goreng 2 Liter', 'Bantuan Pangan', 'Penyaluran minyak goreng kemasan 2 liter untuk membantu kebutuhan dapur keluarga.', 'Keluarga kurang mampu', 'Kelurahan Jatiwaringin', 60, 'active', '2026-10-29 13:54:09'),
(4, 20260002, 'Santunan Lansia Tunggal', 'Bantuan Tunai', 'Bantuan tunai Rp300.000 per bulan untuk lansia yang hidup sendiri tanpa penopang keluarga.', 'Berusia 60 tahun ke atas dan tinggal sendiri', 'Kelurahan Jatiwaringin', 15, 'active', '2026-10-29 13:54:09'),
(5, 20260002, 'Bantuan Perlengkapan Sekolah', 'Pendidikan', 'Paket tas, sepatu, seragam, dan alat tulis untuk anak usia sekolah dari keluarga kurang mampu.', 'Memiliki anak usia sekolah SD sampai SMP', 'Kelurahan Jatiwaringin', 30, 'active', '2026-10-29 13:54:09'),
(6, 20260002, 'Pemeriksaan Kesehatan Gratis', 'Kesehatan', 'Pemeriksaan tekanan darah, gula darah, dan kolesterol gratis bersama tenaga kesehatan puskesmas.', 'Warga usia 45 tahun ke atas', 'RW 06 Kelurahan Jatiwaringin', 80, 'active', '2026-10-29 13:54:09'),
(7, 20260002, 'Paket Makanan Tambahan Lansia', 'Kesehatan', 'Paket makanan bergizi dan susu untuk lansia agar kebutuhan gizi hariannya terpenuhi.', 'Lansia usia 60 tahun ke atas', 'RW 06 Kelurahan Jatiwaringin', 25, 'active', '2026-10-29 13:54:09'),
(8, 20260002, 'Bantuan Perbaikan Rumah Layak Huni', 'Perumahan', 'Bantuan material untuk perbaikan atap, dinding, atau lantai rumah yang rusak.', 'Rumah tidak layak huni dan pemilik berpenghasilan rendah', 'Kelurahan Jatiwaringin', 5, 'active', '2026-10-29 13:54:09'),
(9, 20260002, 'Modal Usaha Mikro', 'Bantuan Tunai', 'Bantuan modal usaha Rp1.500.000 untuk warga yang menjalankan usaha kecil.', 'Memiliki usaha kecil dan penghasilan tidak tetap', 'Kelurahan Jatiwaringin', 10, 'active', '2026-10-29 13:54:09'),
(10, 20260002, 'Paket Pangan Idul Fitri', 'Bantuan Pangan', 'Paket pangan khusus menyambut hari raya untuk keluarga prasejahtera.', 'Keluarga sangat kurang mampu', 'Kelurahan Jatiwaringin', 45, 'draft', '2026-10-29 13:54:09');

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE `proposals` (
  `id` int(11) NOT NULL,
  `reference_code` varchar(100) NOT NULL,
  `program_id` int(11) NOT NULL,
  `petugas_id` int(11) NOT NULL,
  `total_proposed` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT '',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_items`
--

CREATE TABLE `proposal_items` (
  `id` int(11) NOT NULL,
  `proposal_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `selection_status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipients`
--

CREATE TABLE `recipients` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `rt_rw` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `economic_status` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `remember_token` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipients`
--

INSERT INTO `recipients` (`id`, `full_name`, `address`, `rt_rw`, `phone`, `economic_status`, `created_by`, `status`, `remember_token`, `user_id`, `created_at`) VALUES
(1, 'Suparman', 'Jl. Melati No. 12', '01/06', '081318450127', 'Kurang Mampu', 20260001, 'active', NULL, NULL, '2026-10-29 13:54:09'),
(2, 'Sri Wahyuni', 'Jl. Melati No. 18', '01/06', '085711293846', 'Sangat Kurang Mampu', 20260001, 'active', NULL, NULL, '2026-10-29 13:54:09'),
(3, 'Mbah Karto', 'Gang Mawar No. 5', '01/06', '081290374512', 'Lansia Tunggal', 20260001, 'active', NULL, NULL, '2026-10-29 13:54:09'),
(4, 'Agus Setiawan', 'Jl. Kenanga No. 7', '01/06', '087812340965', 'Kurang Mampu', 20260001, 'active', NULL, NULL, '2026-10-29 13:54:09'),
(5, 'Siti Aminah', 'Jl. Anggrek No. 21', '02/06', '081385720194', 'Sangat Kurang Mampu', 20260001, 'active', NULL, NULL, '2026-10-29 13:54:09'),
(6, 'Rohmat Hidayat', 'Gang Kenari No. 3', '02/06', '082114638275', 'Kurang Mampu', 20260001, 'active', NULL, NULL, '2026-10-29 13:54:09'),
(7, 'Nenek Rumini', 'Jl. Anggrek No. 9', '02/06', '085693017428', 'Lansia Tunggal', 20260001, 'active', NULL, NULL, '2026-10-29 13:54:09'),
(8, 'Dedi Kurniawan', 'Jl. Cempaka No. 14', '03/06', '081917253680', 'Kurang Mampu', 20260001, 'active', NULL, NULL, '2026-10-29 13:54:09'),
(9, 'Yuliana Putri', 'Jl. Cempaka No. 26', '03/06', '089612480357', 'Sangat Kurang Mampu', 20260001, 'active', NULL, NULL, '2026-10-29 13:54:09'),
(10, 'Kakek Sarmin', 'Gang Dahlia No. 2', '03/06', '081234906581', 'Lansia Tunggal', 20260001, 'active', NULL, NULL, '2026-10-29 13:54:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('petugas','mitra') NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password_hash`, `role`, `phone`, `status`, `remember_token`, `created_at`) VALUES
(20260001, 'Rista', 'r@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'petugas', '085692345667', 'active', NULL, '2026-10-26 17:32:05'),
(20260002, 'Natania', 'n@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'mitra', '087882863345', 'active', NULL, '2026-10-26 17:32:05'),
(20260003, 'Yandesga', 'yandesga@gmail.com', 'e4d27a7ccdfddff875579a55a403e9d2', 'petugas', '081234568883', 'active', NULL, '2026-10-29 13:35:43'),
(20260004, 'Zahra', 'z@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'mitra', '087665534442', 'active', NULL, '2026-10-29 13:56:19'),
(20260005, 'Demo Mitra', 'demomitra11@gmail.com', 'a5c0a8000b888bd8c447fd56815cdeb4', 'mitra', '087665574663', 'active', NULL, '2026-10-29 14:14:10'),
(20260006, 'Demo Petugas', 'demopetugas11@gmail.com', '3dc40b4bb4c74bbb1eb3254e7ee47cb3', 'petugas', '085647768776', 'active', NULL, '2026-10-29 14:18:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `distributions`
--
ALTER TABLE `distributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposal_id` (`proposal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifications_users` (`user_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`program_id`),
  ADD KEY `mitra_id` (`mitra_id`);

--
-- Indexes for table `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_code` (`reference_code`),
  ADD KEY `program_id` (`program_id`),
  ADD KEY `petugas_id` (`petugas_id`);

--
-- Indexes for table `proposal_items`
--
ALTER TABLE `proposal_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposal_id` (`proposal_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `recipients`
--
ALTER TABLE `recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `distributions`
--
ALTER TABLE `distributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `proposals`
--
ALTER TABLE `proposals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposal_items`
--
ALTER TABLE `proposal_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipients`
--
ALTER TABLE `recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20260007;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `distributions`
--
ALTER TABLE `distributions`
  ADD CONSTRAINT `distributions_ibfk_1` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `distributions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`mitra_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `proposals`
--
ALTER TABLE `proposals`
  ADD CONSTRAINT `proposals_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `proposals_ibfk_2` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `proposal_items`
--
ALTER TABLE `proposal_items`
  ADD CONSTRAINT `proposal_items_ibfk_1` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `proposal_items_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `recipients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipients`
--
ALTER TABLE `recipients`
  ADD CONSTRAINT `recipients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
