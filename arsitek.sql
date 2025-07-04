-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jun 2025 pada 07.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

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
-- Struktur dari tabel `file_gambar`
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

--
-- Dumping data untuk tabel `file_gambar`
--

INSERT INTO `file_gambar` (`id`, `deskripsi`, `gambar`, `status_verifikasi`, `tanggal_submit`, `tanggal_verifikasi`, `verifikator_id`, `catatan_verifikasi`) VALUES
(1, 'Desain Denah Lantai 1', 'denah_lantai_1.pdf', 'approved', '2025-06-20 08:00:00', '2025-06-20 10:30:00', 2, 'Desain sudah sesuai dengan spesifikasi'),
(2, 'Tampak Depan Bangunan', 'tampak_depan.jpg', 'approved', '2025-06-21 09:15:00', '2025-06-21 14:20:00', 2, 'Desain tampak depan sudah bagus'),
(3, 'Detail Struktur Atap', 'struktur_atap.dwg', 'approved', '2025-06-22 07:45:00', '2025-06-22 16:10:00', 2, 'Detail struktur sudah sesuai standar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_logs`
--

CREATE TABLE `login_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `status` enum('success','fail') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login_logs`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` enum('proyek','admin','client') NOT NULL DEFAULT 'proyek'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `username`, `password`, `level`) VALUES
(1, 'lingga', 'lingga', '11111', 'proyek'),
(2, 'ian', 'ian', '11111', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas_proyek`
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

--
-- Dumping data untuk tabel `tugas_proyek`
--

INSERT INTO `tugas_proyek` (`id`, `nama_kegiatan`, `deskripsi`, `tgl`, `status`, `status_verifikasi`, `tanggal_submit`, `tanggal_verifikasi`, `verifikator_id`, `catatan_verifikasi`) VALUES
(1, 'Survey Lokasi', 'Melakukan survey dan pengukuran lokasi proyek', '2025-06-15', 'selesai', 'approved', '2025-06-15 08:00:00', '2025-06-15 16:30:00', 2, 'Survey sudah lengkap dan akurat'),
(2, 'Pembuatan Desain Awal', 'Membuat konsep desain awal berdasarkan hasil survey', '2025-06-18', 'selesai', 'approved', '2025-06-18 09:00:00', '2025-06-18 17:00:00', 2, 'Desain awal sudah sesuai brief client'),
(3, 'Revisi Desain', 'Melakukan revisi desain berdasarkan feedback client', '2025-06-20', 'proses', 'approved', '2025-06-20 08:30:00', '2025-06-20 11:00:00', 2, 'Revisi dapat dilanjutkan'),
(4, 'Finalisasi Gambar Kerja', 'Menyelesaikan gambar kerja untuk pelaksanaan', '2025-06-25', 'proses', 'approved', '2025-06-22 10:00:00', '2025-06-22 15:45:00', 2, 'Dapat dilanjutkan ke tahap finalisasi'),
(5, 'Perhitungan RAB', 'Menghitung Rencana Anggaran Biaya proyek', '2025-06-28', 'proses', 'approved', '2025-06-23 08:00:00', '2025-06-23 12:30:00', 2, 'RAB dapat mulai dihitung');

-- --------------------------------------------------------

--
-- Struktur dari tabel `verifikasi_log`
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
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

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Client', 'Demo', 'client_demo', 'client@demo.com', '$2y$10$T4JDiPA62j/UIyd7alP62uPnBaH3A6Ia7ImTbvb6smSSM6X9Yy60q', 'client', '2025-06-07 12:58:37');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `file_gambar`
--
ALTER TABLE `file_gambar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `tugas_proyek`
--
ALTER TABLE `tugas_proyek`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `verifikasi_log`
--
ALTER TABLE `verifikasi_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tipe_item` (`tipe`, `item_id`),
  ADD KEY `fk_verifikasi_verifikator` (`verifikator_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `file_gambar`
--
ALTER TABLE `file_gambar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tugas_proyek`
--
ALTER TABLE `tugas_proyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `verifikasi_log`
--
ALTER TABLE `verifikasi_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Menambahkan foreign key constraints
--
ALTER TABLE `file_gambar`
  ADD CONSTRAINT `fk_file_verifikator` FOREIGN KEY (`verifikator_id`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL;

ALTER TABLE `tugas_proyek`
  ADD CONSTRAINT `fk_tugas_verifikator` FOREIGN KEY (`verifikator_id`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL;

ALTER TABLE `verifikasi_log`
  ADD CONSTRAINT `fk_verifikasi_verifikator` FOREIGN KEY (`verifikator_id`) REFERENCES `petugas` (`id_petugas`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
