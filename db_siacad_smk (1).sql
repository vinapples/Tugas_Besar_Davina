-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2026 at 06:01 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_siacad_smk`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int NOT NULL,
  `nip` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_guru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nip`, `nama_guru`, `jenis_kelamin`, `user_id`) VALUES
(1, '198501012010011001', 'Budi Santoso, M.Kom', 'L', 2),
(2, '198803152012012002', 'Siti Rahma, S.Pd', 'P', 3),
(3, '199005202015011003', 'Ahmad Rizki, S.T', 'L', 4),
(4, '199208102018012004', 'Dewi Lestari, M.Pd', 'P', 5),
(8, '0984671', 'Matthias Von Herdhartt', 'L', 31),
(12, '0087', 'Khairy', 'L', 43),
(14, '777744', 'Preman Pasar', 'L', 61);

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id` int NOT NULL,
  `kode_mapel` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_mapel` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `guru_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id`, `kode_mapel`, `nama_mapel`, `guru_id`) VALUES
(1, 'MP001', 'Pemrograman Web dan Perangkat Bergerak', 1),
(2, 'MP002', 'Pemodelan Perangkat Lunak', 2),
(3, 'MP003', 'Basis Data', 3),
(4, 'MP004', 'Pemrograman Berorientasi Objek', 4),
(11, 'MP010', 'Seni Budayaa', 8),
(12, 'MP011', 'Seni Budaya', 12),
(14, 'MP005', 'Sejarah', 14);

-- --------------------------------------------------------

--
-- Table structure for table `mengajar`
--

CREATE TABLE `mengajar` (
  `id` int NOT NULL,
  `mapel_id` int NOT NULL,
  `siswa_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mengajar`
--

INSERT INTO `mengajar` (`id`, `mapel_id`, `siswa_id`) VALUES
(1, 12, 1),
(2, 11, 1),
(3, 4, 1),
(4, 3, 1),
(5, 2, 1),
(6, 1, 1),
(7, 12, 2),
(8, 11, 2),
(9, 4, 2),
(10, 3, 2),
(11, 2, 2),
(12, 1, 2),
(13, 12, 3),
(14, 11, 3),
(15, 4, 3),
(16, 3, 3),
(17, 2, 3),
(18, 1, 3),
(19, 12, 4),
(20, 11, 4),
(21, 4, 4),
(22, 3, 4),
(23, 2, 4),
(24, 1, 4),
(25, 12, 5),
(26, 11, 5),
(27, 4, 5),
(28, 3, 5),
(29, 2, 5),
(30, 1, 5),
(31, 12, 11),
(32, 11, 11),
(33, 4, 11),
(34, 3, 11),
(35, 2, 11),
(36, 1, 11),
(37, 12, 18),
(38, 11, 18),
(39, 4, 18),
(40, 3, 18),
(41, 2, 18),
(42, 1, 18),
(43, 12, 19),
(44, 11, 19),
(45, 4, 19),
(46, 3, 19),
(47, 2, 19),
(48, 1, 19),
(49, 12, 20),
(50, 11, 20),
(51, 4, 20),
(52, 3, 20),
(53, 2, 20),
(54, 1, 20),
(55, 12, 23),
(56, 11, 23),
(57, 4, 23),
(58, 3, 23),
(59, 2, 23),
(60, 1, 23),
(61, 12, 24),
(62, 11, 24),
(63, 4, 24),
(64, 3, 24),
(65, 2, 24),
(66, 1, 24),
(67, 14, 3),
(68, 14, 23),
(69, 14, 19),
(70, 14, 25),
(71, 14, 26),
(72, 1, 27),
(73, 14, 27);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_rapor`
--

CREATE TABLE `nilai_rapor` (
  `id` int NOT NULL,
  `siswa_id` int NOT NULL,
  `mapel_id` int NOT NULL,
  `nilai_kkm` int DEFAULT '75',
  `nilai_pengetahuan` int DEFAULT NULL,
  `nilai_keterampilan` int DEFAULT NULL,
  `keterangan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai_rapor`
--

INSERT INTO `nilai_rapor` (`id`, `siswa_id`, `mapel_id`, `nilai_kkm`, `nilai_pengetahuan`, `nilai_keterampilan`, `keterangan`) VALUES
(1, 1, 1, 75, 85, 90, 'Tuntas'),
(2, 2, 2, 75, 78, 80, 'Tuntas'),
(3, 3, 3, 75, 90, 88, 'Tuntas'),
(4, 4, 4, 75, 70, 75, 'Tidak Tuntas'),
(6, 25, 14, 75, 80, 90, 'Tuntas'),
(7, 23, 14, 75, 95, 90, 'Tuntas'),
(8, 27, 14, 75, 95, 90, 'Tuntas');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int NOT NULL,
  `nis` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_siswa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kelas` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama_siswa`, `kelas`, `jenis_kelamin`, `user_id`) VALUES
(1, '2223001', 'Andi Wijaya', 'XII RPL 1', 'L', 7),
(2, '2223002', 'Bunga Citra', 'XII RPL 1', 'P', 8),
(3, '2223003', 'Candra Gunawan', 'XII RPL 2', 'L', 9),
(4, '2223004', 'Dina Maya', 'XII RPL 2', 'P', 10),
(5, '2223005', 'Eka Putra', 'XII RPL 2', 'L', 11),
(11, '00931370', 'Mingyu Hidaya', 'XI RPL 2', 'L', 30),
(18, '908766', 'Tataa', 'XI RPL 1', 'P', 44),
(19, '99484', 'Genyas', 'XI RPL 1', 'P', 45),
(20, '09875', 'Raka', 'XI RPL 1', 'L', 46),
(23, '453653467', 'depay', 'XI RPL 2', 'L', 49),
(24, '009', 'Khairy', 'XI RPL 1', 'L', 51),
(25, '887769', 'Khairy Gantenggg', 'X PPLG 1', 'L', 58),
(26, '998877', 'Tataaror', 'XI RPL 3', 'P', 62),
(27, '4444666', 'Naya', 'XI AK 2', 'P', 63);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','guru','siswa') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin0123', 'hash_pass_1', 'admin', '2026-08-23 03:07:35'),
(2, 'guru_budi', '$2y$10$hashpassguru1', 'guru', '2026-08-23 03:12:14'),
(3, 'guru_siti', '$2y$10$hashpassguru2', 'guru', '2026-08-23 03:12:14'),
(4, 'guru_ahmad', '$2y$10$hashpassguru3', 'guru', '2026-08-23 03:12:14'),
(5, 'guru_dewi', '$2y$10$hashpassguru4', 'guru', '2026-08-23 03:12:14'),
(7, 'siswa_andi', '$2y$10$hashpasssiswa1', 'siswa', '2026-08-23 03:12:14'),
(8, 'siswa_bunga', '$2y$10$hashpasssiswa2', 'siswa', '2026-08-23 03:12:14'),
(9, 'siswa_candra', '$2y$10$hashpasssiswa3', 'siswa', '2026-08-23 03:12:14'),
(10, 'siswa_dina', '$2y$10$hashpasssiswa4', 'siswa', '2026-08-23 03:12:14'),
(11, 'siswa_eka', '$2y$10$hashpasssiswa5', 'siswa', '2026-08-23 03:12:14'),
(30, 'Mingyu90900', '$2y$10$10nIkXipzhjWWck10kXWZu2l8FCcW32dL1eudMhSXMNM/qdGoGh/m', 'siswa', '2026-09-14 06:06:24'),
(31, 'mark9090', '$2y$10$BSF.cToRyuupn555xDu1sOImjKfRR94MkidV.IHjYYLk50QORUm8S', 'guru', '2026-09-14 06:11:18'),
(43, 'Khaiii', '$2y$10$lVnhxwelrYeyJV8gDynPO.TaoEOcftju91IUUtzZUzqgb0Sz8YZC6', 'guru', '2026-09-28 05:41:43'),
(44, 'tata77', '$2y$10$kVbhWGXS8z4yaRqCqqWbKOq/rzSTogtzhbhB8wb3aEQXRssdVZ05a', 'siswa', '2026-09-29 00:34:17'),
(45, 'genyas889', '$2y$10$vmGhk4AGvJY.c.R34DYZp.YCprLpK8Kn666mWOEIi/BDi99Vyvq4y', 'siswa', '2026-10-05 05:11:39'),
(46, 'raka2230', '$2y$10$kPlVu1FgXShUW69EI3NMC.c7UiuBdmZYV2nIwAjf.B.7uCtGR6Tky', 'siswa', '2026-10-05 05:12:48'),
(49, 'marcus depay', '$2y$10$TlCsqC4nJkRBLZGJ0wlGFeZjVqAc7PKgeV7xg/56xSOo.3UACYfIi', 'siswa', '2026-10-05 05:23:04'),
(50, 'genyaslucu', '$2y$10$VyKPnQ6.6RfEkdXp4FjY5ukcbRij6o1wsnW7I8Xj48yoQCHinYC1i', 'admin', '2026-10-05 14:29:42'),
(51, 'khaii33', '$2y$10$3TPp0ID2DB8bMZRXtervpOWm1.NvSKsBExTlxeuqGgRlTf94.L.qO', 'siswa', '2026-10-06 00:27:52'),
(52, 'genyas55', '1234', 'admin', '2026-10-06 00:32:50'),
(58, 'khaigntggg', '$2y$10$nnkukCQIjokZ4zjMegllpubizzA/YZLx5aV0kBU2iC9XFnGOQDUfy', 'siswa', '2026-10-13 12:03:01'),
(61, 'aslam', '$2y$10$lrKRhg9pVKnFQgFOeOkaF.ZU/UQmKkcKcoD/NidfctxHYXtsredsK', 'guru', '2026-10-18 13:52:52'),
(62, 'tataror', '$2y$10$CUpEopo3VN1cx5LhlCgKmerjbwpNfkS6Jysbools8ei4Bykuc5456', 'siswa', '2026-10-18 13:53:30'),
(63, 'nayor', '$2y$10$RQUB6Z5hnfXBnd7aFKvHDO6uPAZPb1A/edW1SOIvBLCsXce/bFwiy', 'siswa', '2026-10-19 07:16:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indexes for table `mengajar`
--
ALTER TABLE `mengajar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `mapel_id` (`mapel_id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `mengajar`
--
ALTER TABLE `mengajar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `mapel`
--
ALTER TABLE `mapel`
  ADD CONSTRAINT `mapel_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  ADD CONSTRAINT `nilai_rapor_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_rapor_ibfk_2` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
