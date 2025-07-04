-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2025 at 01:26 PM
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
-- Database: `arsitek`
--

-- --------------------------------------------------------

--
-- Table structure for table `file_gambar`
--

CREATE TABLE `file_gambar` (
  `id` int(11) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `status_verifikasi` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `tanggal_submit` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_verifikasi` timestamp NULL DEFAULT NULL,
  `verifikator_id` int(11) DEFAULT NULL,
  `catatan_verifikasi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `status` enum('success','fail') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` enum('proyek','admin','client') NOT NULL DEFAULT 'proyek'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `username`, `password`, `level`) VALUES
(1, 'lingga', 'lingga', '11111', 'proyek'),
(2, 'ian', 'ian', '11111', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `rab_proyek`
--

CREATE TABLE `rab_proyek` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `nama_proyek` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `file_rab` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `status` enum('draft','approved','rejected') DEFAULT 'draft',
  `tanggal_upload` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_verifikasi` timestamp NULL DEFAULT NULL,
  `verifikator_id` int(11) DEFAULT NULL,
  `catatan_verifikasi` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `revisi_quota`
--

CREATE TABLE `revisi_quota` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_request` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `revisi_request`
--

CREATE TABLE `revisi_request` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `item_type` enum('tugas','file') NOT NULL,
  `item_id` int(11) NOT NULL,
  `alasan_revisi` text NOT NULL,
  `detail_perubahan` text DEFAULT NULL,
  `file_referensi` varchar(255) DEFAULT NULL,
  `status_revisi` enum('pending','approved','rejected') DEFAULT 'pending',
  `tanggal_request` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_response` timestamp NULL DEFAULT NULL,
  `reviewer_id` int(11) DEFAULT NULL,
  `catatan_reviewer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tugas_proyek`
--

CREATE TABLE `tugas_proyek` (
  `id` int(11) NOT NULL,
  `nama_kegiatan` varchar(200) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `tgl` date NOT NULL,
  `status` enum('proses','selesai','batal') NOT NULL DEFAULT 'proses',
  `status_verifikasi` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `tanggal_submit` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_verifikasi` timestamp NULL DEFAULT NULL,
  `verifikator_id` int(11) DEFAULT NULL,
  `catatan_verifikasi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','client') DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verifikasi_log`
--

CREATE TABLE `verifikasi_log` (
  `id` int(11) NOT NULL,
  `tipe` enum('tugas','file') NOT NULL,
  `item_id` int(11) NOT NULL,
  `status_lama` enum('pending','approved','rejected') DEFAULT NULL,
  `status_baru` enum('pending','approved','rejected') NOT NULL,
  `verifikator_id` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `tanggal_verifikasi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file_gambar`
--
ALTER TABLE `file_gambar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_file_verifikator` (`verifikator_id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `rab_proyek`
--
ALTER TABLE `rab_proyek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rab_client` (`client_id`),
  ADD KEY `fk_rab_verifikator` (`verifikator_id`),
  ADD KEY `fk_rab_creator` (`created_by`);

--
-- Indexes for table `revisi_quota`
--
ALTER TABLE `revisi_quota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_client_date` (`client_id`,`tanggal`),
  ADD KEY `fk_quota_client` (`client_id`);

--
-- Indexes for table `revisi_request`
--
ALTER TABLE `revisi_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_revisi_client` (`client_id`),
  ADD KEY `fk_revisi_reviewer` (`reviewer_id`),
  ADD KEY `idx_item_type_id` (`item_type`,`item_id`);

--
-- Indexes for table `tugas_proyek`
--
ALTER TABLE `tugas_proyek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tugas_verifikator` (`verifikator_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `verifikasi_log`
--
ALTER TABLE `verifikasi_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tipe_item` (`tipe`,`item_id`),
  ADD KEY `fk_verifikasi_verifikator` (`verifikator_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file_gambar`
--
ALTER TABLE `file_gambar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rab_proyek`
--
ALTER TABLE `rab_proyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `revisi_quota`
--
ALTER TABLE `revisi_quota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `revisi_request`
--
ALTER TABLE `revisi_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tugas_proyek`
--
ALTER TABLE `tugas_proyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `verifikasi_log`
--
ALTER TABLE `verifikasi_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `file_gambar`
--
ALTER TABLE `file_gambar`
  ADD CONSTRAINT `fk_file_verifikator` FOREIGN KEY (`verifikator_id`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL;

--
-- Constraints for table `rab_proyek`
--
ALTER TABLE `rab_proyek`
  ADD CONSTRAINT `fk_rab_client` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rab_creator` FOREIGN KEY (`created_by`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_rab_verifikator` FOREIGN KEY (`verifikator_id`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL;

--
-- Constraints for table `revisi_quota`
--
ALTER TABLE `revisi_quota`
  ADD CONSTRAINT `fk_quota_client` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `revisi_request`
--
ALTER TABLE `revisi_request`
  ADD CONSTRAINT `fk_revisi_client` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_revisi_reviewer` FOREIGN KEY (`reviewer_id`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL;

--
-- Constraints for table `tugas_proyek`
--
ALTER TABLE `tugas_proyek`
  ADD CONSTRAINT `fk_tugas_verifikator` FOREIGN KEY (`verifikator_id`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL;

--
-- Constraints for table `verifikasi_log`
--
ALTER TABLE `verifikasi_log`
  ADD CONSTRAINT `fk_verifikasi_verifikator` FOREIGN KEY (`verifikator_id`) REFERENCES `petugas` (`id_petugas`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
