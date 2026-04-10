-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2026 at 09:03 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasi_parkir`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_area_parkir`
--

CREATE TABLE `tb_area_parkir` (
  `id_area` bigint UNSIGNED NOT NULL,
  `nama_area` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` int NOT NULL,
  `terisi` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_area_parkir`
--

INSERT INTO `tb_area_parkir` (`id_area`, `nama_area`, `kapasitas`, `terisi`) VALUES
(1, 'Area A', 50, 1),
(2, 'Area B', 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kendaraan`
--

CREATE TABLE `tb_kendaraan` (
  `id_kendaraan` bigint UNSIGNED NOT NULL,
  `plat_nomor` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kendaraan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warna` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pemilik` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_kendaraan`
--

INSERT INTO `tb_kendaraan` (`id_kendaraan`, `plat_nomor`, `jenis_kendaraan`, `warna`, `pemilik`, `id_user`) VALUES
(4, 'T4123ABC', 'motor', 'hitam', 'mas fuad', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_log_aktivitas`
--

CREATE TABLE `tb_log_aktivitas` (
  `id_log` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `aktivitas` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_aktivitas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_log_aktivitas`
--

INSERT INTO `tb_log_aktivitas` (`id_log`, `id_user`, `aktivitas`, `waktu_aktivitas`) VALUES
(1, 1, 'Login', '2026-04-10 02:18:24'),
(2, 1, 'Login', '2026-04-10 02:18:40'),
(3, 1, 'Login', '2026-04-10 02:18:47'),
(4, 3, 'Login', '2026-04-10 02:20:17'),
(5, 1, 'Login', '2026-04-10 02:29:05'),
(6, 1, 'Logout', '2026-04-10 02:46:55'),
(7, 2, 'Login', '2026-04-10 02:47:40'),
(8, 2, 'Logout', '2026-04-10 02:48:03'),
(9, 1, 'Login', '2026-04-10 03:32:28'),
(10, 1, 'Logout', '2026-04-10 03:32:59'),
(11, 1, 'Login', '2026-04-10 03:36:46'),
(12, 1, 'Logout', '2026-04-10 03:39:33'),
(13, 2, 'Login', '2026-04-10 04:00:21'),
(14, 1, 'Login', '2026-04-10 04:17:43'),
(15, 1, 'Logout', '2026-04-10 04:42:51'),
(16, 2, 'Login', '2026-04-10 04:42:58'),
(17, 2, 'Logout', '2026-04-10 06:09:34'),
(18, 1, 'Login', '2026-04-10 06:09:41'),
(19, 1, 'Logout', '2026-04-10 13:13:57'),
(20, 4, 'Login', '2026-04-10 13:14:05'),
(21, 4, 'Logout', '2026-04-10 13:21:09'),
(22, 1, 'Login', '2026-04-10 13:21:29'),
(23, 1, 'Logout', '2026-04-10 13:21:56'),
(24, 2, 'Login', '2026-04-10 13:22:32'),
(25, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:24:12'),
(26, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:24:18'),
(27, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:24:28'),
(28, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:24:48'),
(29, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:25:15'),
(30, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:26:09'),
(31, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:26:17'),
(32, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 13:26:32'),
(33, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:26:32'),
(34, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 13:26:44'),
(35, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:26:44'),
(36, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:26:45'),
(37, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:26:46'),
(38, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:26:47'),
(39, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:27:06'),
(40, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:27:14'),
(41, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:27:34'),
(42, 1, 'Login', '2026-04-10 13:28:08'),
(43, 1, 'GET admin.dashboard [200]', '2026-04-10 13:28:08'),
(44, 1, 'GET admin.users [200]', '2026-04-10 13:28:09'),
(45, 1, 'GET admin.tarifs [200]', '2026-04-10 13:28:11'),
(46, 1, 'GET admin.areas [200]', '2026-04-10 13:28:11'),
(47, 1, 'GET admin.areas.create [200]', '2026-04-10 13:28:14'),
(48, 1, 'GET admin.areas.create [200]', '2026-04-10 13:28:14'),
(49, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:28:15'),
(50, 1, 'GET admin.areas.create [200]', '2026-04-10 13:28:22'),
(51, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:28:22'),
(52, 1, 'POST admin.areas.store [302]', '2026-04-10 13:28:32'),
(53, 1, 'GET admin.areas [200]', '2026-04-10 13:28:32'),
(54, 1, 'GET admin.kendaraans [200]', '2026-04-10 13:28:36'),
(55, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:28:41'),
(56, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:28:51'),
(57, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:28:51'),
(58, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:29:23'),
(59, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:29:24'),
(60, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:29:41'),
(61, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:29:41'),
(62, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:30:00'),
(63, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:30:01'),
(64, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:30:22'),
(65, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:30:23'),
(66, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:30:55'),
(67, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:30:56'),
(68, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:31:08'),
(69, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:31:09'),
(70, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:31:12'),
(71, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:31:12'),
(72, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:31:16'),
(73, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:31:17'),
(74, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:31:26'),
(75, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:31:26'),
(76, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:31:31'),
(77, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:31:32'),
(78, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:31:38'),
(79, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:31:39'),
(80, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:31:44'),
(81, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:31:44'),
(82, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:31:47'),
(83, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:31:47'),
(84, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:31:51'),
(85, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:31:52'),
(86, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:31:54'),
(87, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:31:55'),
(88, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:32:16'),
(89, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:32:16'),
(90, 1, 'GET admin.kendaraans [200]', '2026-04-10 13:33:16'),
(91, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:33:20'),
(92, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:33:36'),
(93, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:33:36'),
(94, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:34:19'),
(95, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:34:19'),
(96, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:34:31'),
(97, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:34:33'),
(98, 2, 'POST petugas.transaksi.process.keluar [200]', '2026-04-10 13:34:37'),
(99, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:34:43'),
(100, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:34:44'),
(101, 2, 'POST petugas.transaksi.process.keluar [302]', '2026-04-10 13:34:46'),
(102, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:34:46'),
(103, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:35:44'),
(104, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:35:44'),
(105, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:36:16'),
(106, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:36:16'),
(107, 1, 'GET admin.users [200]', '2026-04-10 13:36:23'),
(108, 1, 'DELETE admin.users.delete [302]', '2026-04-10 13:36:28'),
(109, 1, 'GET admin.users [200]', '2026-04-10 13:36:28'),
(110, 1, 'GET admin.users [200]', '2026-04-10 13:36:35'),
(111, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:36:35'),
(112, 1, 'GET admin.users [200]', '2026-04-10 13:36:51'),
(113, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:36:51'),
(114, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:36:56'),
(115, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:36:59'),
(116, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:37:05'),
(117, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:37:08'),
(118, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:37:21'),
(119, 1, 'GET admin.users [200]', '2026-04-10 13:37:22'),
(120, 1, 'GET admin.users [200]', '2026-04-10 13:37:22'),
(121, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:37:22'),
(122, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:37:24'),
(123, 1, 'GET admin.users [200]', '2026-04-10 13:37:29'),
(124, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:37:29'),
(125, 1, 'GET admin.users [200]', '2026-04-10 13:37:37'),
(126, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:37:37'),
(127, 1, 'GET admin.users [200]', '2026-04-10 13:37:46'),
(128, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:37:47'),
(129, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:37:58'),
(130, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:38:11'),
(131, 1, 'GET admin.users [200]', '2026-04-10 13:38:11'),
(132, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:38:18'),
(133, 1, 'GET admin.users [200]', '2026-04-10 13:38:18'),
(134, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:38:18'),
(135, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:38:27'),
(136, 1, 'GET admin.users [200]', '2026-04-10 13:38:28'),
(137, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 13:38:45'),
(138, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:38:46'),
(139, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 13:38:53'),
(140, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:38:54'),
(141, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:38:55'),
(142, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:38:56'),
(143, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:39:37'),
(144, 1, 'GET admin.users [200]', '2026-04-10 13:39:37'),
(145, 1, 'GET admin.users [200]', '2026-04-10 13:40:49'),
(146, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:40:49'),
(147, 1, 'GET admin.users [200]', '2026-04-10 13:41:06'),
(148, 1, 'GET admin.users [200]', '2026-04-10 13:41:06'),
(149, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:41:07'),
(150, 1, 'GET admin.users [200]', '2026-04-10 13:41:28'),
(151, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:41:28'),
(152, 1, 'GET admin.users [200]', '2026-04-10 13:41:45'),
(153, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:41:45'),
(154, 1, 'GET admin.tarifs [200]', '2026-04-10 13:41:55'),
(155, 1, 'GET admin.areas [200]', '2026-04-10 13:41:55'),
(156, 1, 'GET admin.kendaraans [200]', '2026-04-10 13:41:55'),
(157, 1, 'GET admin.logs [200]', '2026-04-10 13:41:56'),
(158, 1, 'GET admin.kendaraans [200]', '2026-04-10 13:41:56'),
(159, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:43:13'),
(160, 1, 'PUT admin.kendaraans.update [302]', '2026-04-10 13:43:17'),
(161, 1, 'GET admin.kendaraans [200]', '2026-04-10 13:43:17'),
(162, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:43:19'),
(163, 1, 'PUT admin.kendaraans.update [302]', '2026-04-10 13:43:22'),
(164, 1, 'GET admin.kendaraans [200]', '2026-04-10 13:43:22'),
(165, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:43:24'),
(166, 1, 'PUT admin.kendaraans.update [302]', '2026-04-10 13:43:27'),
(167, 1, 'GET admin.kendaraans [200]', '2026-04-10 13:43:27'),
(168, 1, 'GET admin.kendaraans.edit [200]', '2026-04-10 13:43:28'),
(169, 1, 'GET admin.logs [200]', '2026-04-10 13:43:30'),
(170, 1, 'GET admin.logs [200]', '2026-04-10 13:43:39'),
(171, 1, 'GET admin.logs [200]', '2026-04-10 13:43:41'),
(172, 1, 'GET admin.logs [200]', '2026-04-10 13:43:43'),
(173, 1, 'GET admin.logs [200]', '2026-04-10 13:43:44'),
(174, 1, 'GET admin.logs [200]', '2026-04-10 13:43:46'),
(175, 1, 'GET admin.logs [200]', '2026-04-10 13:43:50'),
(176, 1, 'GET admin.logs [200]', '2026-04-10 13:43:51'),
(177, 1, 'GET admin.logs [200]', '2026-04-10 13:43:52'),
(178, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:43:52'),
(179, 1, 'GET admin.logs [200]', '2026-04-10 13:45:37'),
(180, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:45:37'),
(181, 1, 'GET admin.logs [200]', '2026-04-10 13:48:09'),
(182, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:48:09'),
(183, 1, 'GET admin.logs [200]', '2026-04-10 13:48:32'),
(184, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:48:32'),
(185, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:48:38'),
(186, 2, 'POST petugas.transaksi.process.keluar [200]', '2026-04-10 13:48:41'),
(187, 2, 'GET petugas.transaksi.pending.struk [200]', '2026-04-10 13:48:44'),
(188, 1, 'GET admin.logs [200]', '2026-04-10 13:48:50'),
(189, 1, 'GET admin.logs [200]', '2026-04-10 13:49:08'),
(190, 2, 'POST petugas.transaksi.finalize.keluar [200]', '2026-04-10 13:49:21'),
(191, 2, 'POST petugas.transaksi.process.keluar [302]', '2026-04-10 13:49:21'),
(192, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:49:21'),
(193, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:49:22'),
(194, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:49:27'),
(195, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:49:35'),
(196, 2, 'Logout', '2026-04-10 13:49:41'),
(197, 2, 'Login', '2026-04-10 13:49:53'),
(198, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:49:53'),
(199, 2, 'GET petugas.dashboard [200]', '2026-04-10 13:50:55'),
(200, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:51:25'),
(201, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 13:51:25'),
(202, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:51:26'),
(203, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:52:50'),
(204, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:52:56'),
(205, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:53:00'),
(206, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:53:09'),
(207, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:53:14'),
(208, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:53:19'),
(209, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:53:23'),
(210, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:53:27'),
(211, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:53:36'),
(212, 1, 'GET admin.logs [200]', '2026-04-10 13:55:10'),
(213, 1, 'GET admin.logs [200]', '2026-04-10 13:55:15'),
(214, 1, 'GET admin.logs [200]', '2026-04-10 13:55:17'),
(215, 1, 'GET admin.logs [200]', '2026-04-10 13:55:49'),
(216, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:55:49'),
(217, 1, 'GET admin.logs [200]', '2026-04-10 13:56:11'),
(218, 1, 'GET admin.logs [200]', '2026-04-10 13:56:56'),
(219, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:56:56'),
(220, 1, 'GET admin.logs [200]', '2026-04-10 13:57:17'),
(221, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:57:17'),
(222, 1, 'GET admin.logs [200]', '2026-04-10 13:57:57'),
(223, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:57:57'),
(224, 1, 'GET admin.logs [200]', '2026-04-10 13:58:11'),
(225, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:58:11'),
(226, 1, 'GET admin.logs [200]', '2026-04-10 13:58:26'),
(227, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:58:26'),
(228, 1, 'GET admin.logs [200]', '2026-04-10 13:58:56'),
(229, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:58:56'),
(230, 1, 'GET admin.logs [200]', '2026-04-10 13:59:13'),
(231, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:59:13'),
(232, 1, 'GET admin.logs [200]', '2026-04-10 13:59:14'),
(233, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:59:14'),
(234, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:59:36'),
(235, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:59:40'),
(236, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 13:59:44'),
(237, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:00:02'),
(238, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:00:25'),
(239, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:00:39'),
(240, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:01:43'),
(241, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:02:43'),
(242, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:03:04'),
(243, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:03:24'),
(244, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:03:32'),
(245, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 14:04:20'),
(246, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:04:20'),
(247, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 14:04:30'),
(248, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:04:30'),
(249, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:04:48'),
(250, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:04:53'),
(251, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 14:05:09'),
(252, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:05:10'),
(253, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 14:05:12'),
(254, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:05:12'),
(255, 2, 'GET petugas.dashboard [200]', '2026-04-10 14:05:14'),
(256, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:05:16'),
(257, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:05:19'),
(258, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 14:05:30'),
(259, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:05:30'),
(260, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 14:05:32'),
(261, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:05:32'),
(262, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:05:41'),
(263, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:06:31'),
(264, 2, 'POST petugas.transaksi.process.keluar [200]', '2026-04-10 14:06:34'),
(265, 2, 'GET petugas.transaksi.pending.struk [200]', '2026-04-10 14:06:43'),
(266, 2, 'POST petugas.transaksi.finalize.keluar [200]', '2026-04-10 14:06:53'),
(267, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:06:53'),
(268, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:07:05'),
(269, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:07:19'),
(270, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:07:20'),
(271, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:07:23'),
(272, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:07:47'),
(273, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:09:43'),
(274, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:09:51'),
(275, 1, 'GET admin.logs [500]', '2026-04-10 14:11:47'),
(276, 1, 'GET admin.logs [500]', '2026-04-10 14:11:48'),
(277, 1, 'GET admin.logs [500]', '2026-04-10 14:13:02'),
(278, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:13:02'),
(279, 1, 'GET admin.logs [500]', '2026-04-10 14:14:06'),
(280, 1, 'GET admin.logs [200]', '2026-04-10 14:14:52'),
(281, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:14:52'),
(282, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:14:55'),
(283, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:14:57'),
(284, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:15:51'),
(285, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:15:52'),
(286, 1, 'GET admin.logs [500]', '2026-04-10 14:16:48'),
(287, 1, 'GET admin.logs [500]', '2026-04-10 14:16:48'),
(288, 1, 'GET admin.logs [500]', '2026-04-10 14:16:58'),
(289, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:16:58'),
(290, 1, 'GET admin.logs [500]', '2026-04-10 14:17:18'),
(291, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:17:18'),
(292, 1, 'GET admin.logs [500]', '2026-04-10 14:17:34'),
(293, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:17:34'),
(294, 1, 'GET admin.logs [200]', '2026-04-10 14:17:52'),
(295, 1, 'GET admin.users [200]', '2026-04-10 14:18:05'),
(296, 1, 'GET admin.users.edit [200]', '2026-04-10 14:18:06'),
(297, 1, 'GET admin.users [200]', '2026-04-10 14:18:11'),
(298, 1, 'DELETE admin.users.delete [302]', '2026-04-10 14:18:20'),
(299, 1, 'GET admin.users [200]', '2026-04-10 14:18:20'),
(300, 1, 'GET admin.users.edit [200]', '2026-04-10 14:18:23'),
(301, 1, 'GET admin.users [200]', '2026-04-10 14:18:26'),
(302, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 14:18:51'),
(303, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:18:51'),
(304, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:18:52'),
(305, 2, 'POST petugas.transaksi.process.keluar [200]', '2026-04-10 14:18:58'),
(306, 2, 'GET petugas.transaksi.pending.struk [200]', '2026-04-10 14:18:59'),
(307, 2, 'POST petugas.transaksi.finalize.keluar [200]', '2026-04-10 14:19:21'),
(308, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:19:22'),
(309, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:19:50'),
(310, 1, 'GET admin.users [200]', '2026-04-10 14:19:50'),
(311, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:20:06'),
(312, 1, 'GET admin.users [200]', '2026-04-10 14:20:06'),
(313, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:20:20'),
(314, 2, 'GET petugas.dashboard [200]', '2026-04-10 14:20:22'),
(315, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:20:28'),
(316, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:20:42'),
(317, 1, 'GET admin.users [200]', '2026-04-10 14:20:42'),
(318, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 14:20:52'),
(319, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:20:52'),
(320, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:20:54'),
(321, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:20:56'),
(322, 1, 'GET admin.users [200]', '2026-04-10 14:21:18'),
(323, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:21:18'),
(324, 1, 'GET admin.users [200]', '2026-04-10 14:23:27'),
(325, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:23:27'),
(326, 1, 'GET admin.users [200]', '2026-04-10 14:23:40'),
(327, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:23:40'),
(328, 1, 'GET admin.users [200]', '2026-04-10 14:24:04'),
(329, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:24:04'),
(330, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:25:24'),
(331, 1, 'GET admin.users [200]', '2026-04-10 14:25:57'),
(332, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:26:03'),
(333, 2, 'POST petugas.transaksi.process.keluar [200]', '2026-04-10 14:26:06'),
(334, 2, 'GET petugas.transaksi.pending.struk [200]', '2026-04-10 14:26:10'),
(335, 1, 'GET admin.users [200]', '2026-04-10 14:26:16'),
(336, 1, 'GET admin.users [200]', '2026-04-10 14:26:17'),
(337, 2, 'POST petugas.transaksi.finalize.keluar [200]', '2026-04-10 14:26:48'),
(338, 2, 'POST petugas.transaksi.process.keluar [302]', '2026-04-10 14:26:48'),
(339, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:26:48'),
(340, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:26:51'),
(341, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:26:52'),
(342, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:26:52'),
(343, 1, 'GET admin.users [200]', '2026-04-10 14:28:22'),
(344, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:28:22'),
(345, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:28:31'),
(346, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:28:32'),
(347, 1, 'GET admin.tarifs [200]', '2026-04-10 14:28:34'),
(348, 1, 'GET admin.tarifs.edit [200]', '2026-04-10 14:28:37'),
(349, 1, 'PUT admin.tarifs.update [302]', '2026-04-10 14:28:39'),
(350, 1, 'GET admin.tarifs [200]', '2026-04-10 14:28:39'),
(351, 1, 'GET admin.tarifs.edit [200]', '2026-04-10 14:28:43'),
(352, 1, 'PUT admin.tarifs.update [302]', '2026-04-10 14:28:45'),
(353, 1, 'GET admin.tarifs [200]', '2026-04-10 14:28:45'),
(354, 1, 'GET admin.tarifs [200]', '2026-04-10 14:28:46'),
(355, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:28:47'),
(356, 1, 'GET admin.tarifs [200]', '2026-04-10 14:29:31'),
(357, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:29:32'),
(358, 1, 'GET admin.tarifs [200]', '2026-04-10 14:29:55'),
(359, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:29:56'),
(360, 1, 'GET admin.tarifs [200]', '2026-04-10 14:30:28'),
(361, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:30:29'),
(362, 1, 'GET admin.tarifs [200]', '2026-04-10 14:30:51'),
(363, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:30:52'),
(364, 1, 'GET admin.tarifs [200]', '2026-04-10 14:31:11'),
(365, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:31:11'),
(366, 1, 'GET admin.tarifs [200]', '2026-04-10 14:31:17'),
(367, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:31:17'),
(368, 1, 'GET admin.tarifs [200]', '2026-04-10 14:31:59'),
(369, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:31:59'),
(370, 1, 'GET admin.tarifs [200]', '2026-04-10 14:32:27'),
(371, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:32:27'),
(372, 1, 'GET admin.tarifs [200]', '2026-04-10 14:32:46'),
(373, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:32:46'),
(374, 1, 'GET admin.tarifs [200]', '2026-04-10 14:32:49'),
(375, 1, 'GET admin.tarifs [200]', '2026-04-10 14:33:03'),
(376, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:33:03'),
(377, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:33:45'),
(378, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:33:45'),
(379, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:33:46'),
(380, 1, 'GET admin.tarifs [200]', '2026-04-10 14:33:47'),
(381, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:33:50'),
(382, 1, 'GET admin.tarifs.edit [200]', '2026-04-10 14:34:07'),
(383, 2, 'GET petugas.dashboard [200]', '2026-04-10 14:34:19'),
(384, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:34:27'),
(385, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:34:28'),
(386, 3, 'Login', '2026-04-10 14:34:55'),
(387, 3, 'GET owner.dashboard [200]', '2026-04-10 14:34:55'),
(388, 3, 'GET owner.dashboard [200]', '2026-04-10 14:34:57'),
(389, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:34:58'),
(390, 1, 'GET admin.tarifs.edit [200]', '2026-04-10 14:34:58'),
(391, 3, 'GET owner.rekap [200]', '2026-04-10 14:34:58'),
(392, 3, 'GET owner.dashboard [200]', '2026-04-10 14:35:02'),
(393, 3, 'GET owner.rekap [200]', '2026-04-10 14:35:06'),
(394, 3, 'GET owner.rekap [200]', '2026-04-10 14:35:37'),
(395, 3, 'GET owner.rekap [200]', '2026-04-10 14:35:38'),
(396, 3, 'GET owner.dashboard [200]', '2026-04-10 14:35:39'),
(397, 3, 'GET owner.dashboard [200]', '2026-04-10 14:35:47'),
(398, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:35:48'),
(399, 1, 'GET admin.tarifs.edit [200]', '2026-04-10 14:35:48'),
(400, 3, 'GET owner.rekap [200]', '2026-04-10 14:36:01'),
(401, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:36:23'),
(402, 3, 'GET owner.rekap [200]', '2026-04-10 14:36:23'),
(403, 1, 'GET admin.tarifs.edit [200]', '2026-04-10 14:36:23'),
(404, 3, 'GET owner.rekap [200]', '2026-04-10 14:36:55'),
(405, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:36:56'),
(406, 1, 'GET admin.tarifs.edit [200]', '2026-04-10 14:36:56'),
(407, 1, 'GET admin.logs [200]', '2026-04-10 14:37:12'),
(408, 1, 'GET admin.logs [200]', '2026-04-10 14:37:30'),
(409, 1, 'GET admin.logs [200]', '2026-04-10 14:37:38'),
(410, 1, 'GET admin.logs [200]', '2026-04-10 14:37:48'),
(411, 3, 'GET owner.rekap [200]', '2026-04-10 14:37:49'),
(412, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:37:49'),
(413, 1, 'GET admin.logs [500]', '2026-04-10 14:38:09'),
(414, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:39:22'),
(415, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 14:39:26'),
(416, 2, 'GET petugas.dashboard [200]', '2026-04-10 14:39:27'),
(417, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:39:36'),
(418, 2, 'GET petugas.dashboard [200]', '2026-04-10 14:39:38'),
(419, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:39:40'),
(420, 2, 'GET petugas.dashboard [200]', '2026-04-10 14:39:41'),
(421, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:39:42'),
(422, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:39:57'),
(423, 1, 'GET admin.logs [500]', '2026-04-10 14:39:57'),
(424, 3, 'GET owner.rekap [200]', '2026-04-10 14:39:57'),
(425, 2, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 14:40:11'),
(426, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:40:11'),
(427, 1, 'GET admin.logs [500]', '2026-04-10 14:41:14'),
(428, 3, 'GET owner.rekap [200]', '2026-04-10 14:41:14'),
(429, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:41:14'),
(430, 3, 'GET owner.rekap [200]', '2026-04-10 14:41:31'),
(431, 1, 'GET admin.logs [500]', '2026-04-10 14:41:31'),
(432, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:41:31'),
(433, 3, 'GET owner.rekap [200]', '2026-04-10 14:41:35'),
(434, 1, 'GET admin.logs [500]', '2026-04-10 14:41:35'),
(435, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:41:35'),
(436, 3, 'GET owner.rekap [200]', '2026-04-10 14:42:05'),
(437, 1, 'GET admin.logs [500]', '2026-04-10 14:42:05'),
(438, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:42:06'),
(439, 1, 'GET admin.logs [200]', '2026-04-10 14:42:11'),
(440, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:42:11'),
(441, 3, 'GET owner.rekap [200]', '2026-04-10 14:42:11'),
(442, 1, 'GET admin.kendaraans [200]', '2026-04-10 14:42:14'),
(443, 1, 'GET admin.kendaraans.create [200]', '2026-04-10 14:42:23'),
(444, 1, 'GET admin.kendaraans.create [200]', '2026-04-10 14:42:33'),
(445, 3, 'GET owner.rekap [200]', '2026-04-10 14:42:33'),
(446, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:42:33'),
(447, 1, 'GET admin.kendaraans [200]', '2026-04-10 14:42:52'),
(448, 1, 'DELETE admin.kendaraans.delete [500]', '2026-04-10 14:42:59'),
(449, 1, 'GET admin.logs [200]', '2026-04-10 14:46:11'),
(450, 1, 'GET admin.logs [200]', '2026-04-10 14:46:12'),
(451, 1, 'GET admin.logs [200]', '2026-04-10 14:46:17'),
(452, 1, 'GET admin.logs [200]', '2026-04-10 14:46:21'),
(453, 1, 'GET admin.logs [200]', '2026-04-10 14:46:24'),
(454, 1, 'GET admin.logs [200]', '2026-04-10 14:46:27'),
(455, 1, 'GET admin.logs [200]', '2026-04-10 14:46:31'),
(456, 1, 'GET admin.logs [200]', '2026-04-10 14:46:35'),
(457, 1, 'GET admin.logs [200]', '2026-04-10 14:46:37'),
(458, 1, 'GET admin.logs [200]', '2026-04-10 14:46:42'),
(459, 1, 'GET admin.logs [200]', '2026-04-10 14:46:44'),
(460, 1, 'GET admin.logs [200]', '2026-04-10 14:46:46'),
(461, 1, 'GET admin.logs [200]', '2026-04-10 14:47:19'),
(462, 1, 'GET admin.logs [200]', '2026-04-10 14:47:19'),
(463, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:47:20'),
(464, 3, 'GET owner.rekap [200]', '2026-04-10 14:47:20'),
(465, 3, 'GET owner.rekap [200]', '2026-04-10 14:48:09'),
(466, 1, 'GET admin.logs [200]', '2026-04-10 14:48:09'),
(467, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:48:09'),
(468, 3, 'GET owner.rekap [200]', '2026-04-10 14:48:26'),
(469, 3, 'GET owner.rekap [200]', '2026-04-10 14:48:28'),
(470, 1, 'GET admin.logs [200]', '2026-04-10 14:48:28'),
(471, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:48:28'),
(472, 3, 'GET owner.rekap [200]', '2026-04-10 14:48:32'),
(473, 3, 'GET owner.rekap [200]', '2026-04-10 14:48:37'),
(474, 3, 'GET owner.rekap.download-csv [200]', '2026-04-10 14:48:40'),
(475, 3, 'GET owner.rekap [200]', '2026-04-10 14:48:48'),
(476, 1, 'GET admin.logs [200]', '2026-04-10 14:48:48'),
(477, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:48:48'),
(478, 1, 'GET admin.logs [200]', '2026-04-10 14:48:51'),
(479, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:48:51'),
(480, 3, 'GET owner.rekap [200]', '2026-04-10 14:48:51'),
(481, 1, 'GET admin.logs [200]', '2026-04-10 14:50:10'),
(482, 1, 'GET admin.logs [200]', '2026-04-10 14:50:13'),
(483, 1, 'GET admin.kendaraans [200]', '2026-04-10 14:50:19'),
(484, 1, 'GET admin.areas [200]', '2026-04-10 14:50:19'),
(485, 1, 'DELETE admin.areas.delete [302]', '2026-04-10 14:50:23'),
(486, 1, 'GET admin.areas [200]', '2026-04-10 14:50:24'),
(487, 1, 'DELETE admin.areas.delete [302]', '2026-04-10 14:50:33'),
(488, 1, 'GET admin.areas [200]', '2026-04-10 14:50:33'),
(489, 1, 'GET admin.areas [200]', '2026-04-10 14:52:42'),
(490, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:52:42'),
(491, 3, 'GET owner.rekap [200]', '2026-04-10 14:52:42'),
(492, 1, 'GET admin.areas [200]', '2026-04-10 14:55:19'),
(493, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:55:19'),
(494, 3, 'GET owner.rekap [200]', '2026-04-10 14:55:19'),
(495, 1, 'GET admin.areas [200]', '2026-04-10 14:55:43'),
(496, 3, 'GET owner.rekap [200]', '2026-04-10 14:55:43'),
(497, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:55:43'),
(498, 3, 'GET owner.rekap [200]', '2026-04-10 14:56:05'),
(499, 1, 'GET admin.areas [200]', '2026-04-10 14:56:05'),
(500, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:56:05'),
(501, 1, 'GET admin.areas [200]', '2026-04-10 14:56:13'),
(502, 3, 'GET owner.rekap [200]', '2026-04-10 14:56:13'),
(503, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:56:13'),
(504, 3, 'GET owner.rekap [200]', '2026-04-10 14:56:25'),
(505, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:56:25'),
(506, 3, 'GET owner.rekap [200]', '2026-04-10 14:56:35'),
(507, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:56:35'),
(508, 3, 'GET owner.rekap [200]', '2026-04-10 14:56:46'),
(509, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:56:46'),
(510, 3, 'GET owner.rekap [200]', '2026-04-10 14:57:05'),
(511, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:57:05'),
(512, 3, 'GET owner.rekap [200]', '2026-04-10 14:58:02'),
(513, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:58:02'),
(514, 3, 'GET owner.rekap [200]', '2026-04-10 14:58:14'),
(515, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:58:14'),
(516, 3, 'GET owner.rekap [200]', '2026-04-10 14:58:46'),
(517, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:58:46'),
(518, 3, 'GET owner.rekap [200]', '2026-04-10 14:58:56'),
(519, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:58:56'),
(520, 3, 'GET owner.rekap [200]', '2026-04-10 14:59:41'),
(521, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:59:41'),
(522, 3, 'GET owner.rekap [200]', '2026-04-10 14:59:49'),
(523, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:59:49'),
(524, 3, 'GET owner.rekap [200]', '2026-04-10 14:59:53'),
(525, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 14:59:53'),
(526, 1, 'GET admin.areas [200]', '2026-04-10 15:00:10'),
(527, 1, 'GET admin.areas [200]', '2026-04-10 15:01:11'),
(528, 3, 'GET owner.rekap [200]', '2026-04-10 15:01:11'),
(529, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 15:01:11'),
(530, 1, 'DELETE admin.areas.delete [500]', '2026-04-10 15:01:53'),
(531, 1, 'DELETE admin.areas.delete [302]', '2026-04-10 15:02:58'),
(532, 1, 'GET admin.areas [200]', '2026-04-10 15:02:58'),
(533, 3, 'GET owner.rekap [500]', '2026-04-10 15:02:59'),
(534, 2, 'GET petugas.transaksi.masuk [200]', '2026-04-10 15:02:59'),
(535, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:01'),
(536, 1, 'DELETE admin.kendaraans.delete [302]', '2026-04-10 15:04:06'),
(537, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:06'),
(538, 1, 'DELETE admin.kendaraans.delete [302]', '2026-04-10 15:04:30'),
(539, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:30'),
(540, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:35'),
(541, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:37'),
(542, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:37'),
(543, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:38'),
(544, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:38'),
(545, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:38'),
(546, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:39'),
(547, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:39'),
(548, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:39'),
(549, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:39'),
(550, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:39'),
(551, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:39'),
(552, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:04:40'),
(553, 2, 'GET petugas.transaksi.keluar [500]', '2026-04-10 15:04:48'),
(554, 2, 'GET petugas.transaksi.keluar [500]', '2026-04-10 15:04:52'),
(555, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:12:14'),
(556, 2, 'GET petugas.transaksi.keluar [500]', '2026-04-10 15:12:15'),
(557, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:13:21'),
(558, 2, 'GET petugas.transaksi.keluar [500]', '2026-04-10 15:13:21'),
(559, 2, 'GET petugas.transaksi.keluar [500]', '2026-04-10 15:14:06'),
(560, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:14:06'),
(561, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:14:27'),
(562, 2, 'GET petugas.transaksi.keluar [500]', '2026-04-10 15:14:27'),
(563, 2, 'GET petugas.transaksi.keluar [200]', '2026-04-10 15:14:52'),
(564, 1, 'GET admin.kendaraans [200]', '2026-04-10 15:14:52'),
(565, 1, 'GET admin.dashboard [200]', '2026-04-10 15:38:43'),
(566, 1, 'Logout', '2026-04-10 15:38:49'),
(567, 1, 'Login', '2026-04-10 15:39:05'),
(568, 1, 'GET admin.dashboard [200]', '2026-04-10 15:39:06'),
(569, 1, 'GET admin.users [200]', '2026-04-10 15:39:07'),
(570, 1, 'GET admin.users.create [200]', '2026-04-10 15:39:09'),
(571, 1, 'POST admin.users.store [302]', '2026-04-10 15:39:22'),
(572, 1, 'GET admin.users [200]', '2026-04-10 15:39:22'),
(573, 1, 'GET admin.users.create [200]', '2026-04-10 15:39:25'),
(574, 1, 'POST admin.users.store [302]', '2026-04-10 15:39:38'),
(575, 1, 'GET admin.users [200]', '2026-04-10 15:39:38'),
(576, 1, 'Logout', '2026-04-10 15:39:40'),
(577, 5, 'Login', '2026-04-10 15:39:46'),
(578, 5, 'GET admin.dashboard [200]', '2026-04-10 15:39:47'),
(579, 5, 'GET admin.users [200]', '2026-04-10 15:39:49'),
(580, 5, 'GET admin.users.create [200]', '2026-04-10 15:39:50'),
(581, 5, 'POST admin.users.store [302]', '2026-04-10 15:40:03'),
(582, 5, 'GET admin.users [200]', '2026-04-10 15:40:03'),
(583, 2, 'GET petugas.dashboard [200]', '2026-04-10 15:40:21'),
(584, 2, 'Logout', '2026-04-10 15:40:24'),
(585, 6, 'Login', '2026-04-10 15:40:46'),
(586, 6, 'GET petugas.dashboard [200]', '2026-04-10 15:40:46'),
(587, 6, 'GET petugas.transaksi.masuk [200]', '2026-04-10 15:40:57'),
(588, 6, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 15:41:16'),
(589, 6, 'GET petugas.transaksi.masuk [200]', '2026-04-10 15:41:16'),
(590, 6, 'POST petugas.transaksi.store.masuk [302]', '2026-04-10 15:42:08'),
(591, 6, 'GET petugas.transaksi.masuk [200]', '2026-04-10 15:42:08'),
(592, 6, 'GET petugas.dashboard [200]', '2026-04-10 15:42:11'),
(593, 6, 'GET petugas.transaksi.keluar [200]', '2026-04-10 15:42:14'),
(594, 6, 'GET petugas.dashboard [200]', '2026-04-10 15:42:18'),
(595, 3, 'GET owner.dashboard [200]', '2026-04-10 15:42:55'),
(596, 3, 'GET owner.dashboard [200]', '2026-04-10 15:42:56'),
(597, 5, 'GET admin.logs [200]', '2026-04-10 15:43:16'),
(598, 5, 'GET admin.logs [200]', '2026-04-10 15:43:38'),
(599, 3, 'GET owner.rekap [200]', '2026-04-10 15:43:54'),
(600, 3, 'Logout', '2026-04-10 15:44:25'),
(601, 7, 'Login', '2026-04-10 15:44:39'),
(602, 7, 'GET owner.dashboard [200]', '2026-04-10 15:44:40'),
(603, 7, 'GET owner.rekap [200]', '2026-04-10 15:44:45'),
(604, 5, 'GET admin.tarifs [200]', '2026-04-10 15:45:28'),
(605, 5, 'GET admin.tarifs.create [200]', '2026-04-10 15:45:42'),
(606, 5, 'POST admin.tarifs.store [302]', '2026-04-10 15:45:53'),
(607, 5, 'GET admin.tarifs [200]', '2026-04-10 15:45:53'),
(608, 5, 'GET admin.tarifs.edit [200]', '2026-04-10 15:45:58'),
(609, 5, 'PUT admin.tarifs.update [302]', '2026-04-10 15:46:01'),
(610, 5, 'GET admin.tarifs [200]', '2026-04-10 15:46:01'),
(611, 5, 'DELETE admin.tarifs.delete [302]', '2026-04-10 15:46:06'),
(612, 5, 'GET admin.tarifs [200]', '2026-04-10 15:46:06'),
(613, 5, 'GET admin.kendaraans [200]', '2026-04-10 15:46:12'),
(614, 5, 'DELETE admin.kendaraans.delete [302]', '2026-04-10 15:46:25'),
(615, 5, 'GET admin.kendaraans [200]', '2026-04-10 15:46:25'),
(616, 5, 'DELETE admin.kendaraans.delete [302]', '2026-04-10 15:46:28'),
(617, 5, 'GET admin.kendaraans [200]', '2026-04-10 15:46:28'),
(618, 5, 'DELETE admin.kendaraans.delete [302]', '2026-04-10 15:46:33'),
(619, 5, 'GET admin.kendaraans [200]', '2026-04-10 15:46:33'),
(620, 5, 'DELETE admin.kendaraans.delete [302]', '2026-04-10 15:46:36'),
(621, 5, 'GET admin.kendaraans [200]', '2026-04-10 15:46:36'),
(622, 7, 'GET owner.rekap [200]', '2026-04-10 15:46:43'),
(623, 5, 'GET admin.logs [200]', '2026-04-10 15:47:58'),
(624, 7, 'GET owner.rekap.download-csv [200]', '2026-04-10 16:01:07');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tarif`
--

CREATE TABLE `tb_tarif` (
  `id_tarif` bigint UNSIGNED NOT NULL,
  `id_area` bigint UNSIGNED DEFAULT NULL,
  `jenis_kendaraan` enum('motor','mobil','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif_per_jam` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_tarif`
--

INSERT INTO `tb_tarif` (`id_tarif`, `id_area`, `jenis_kendaraan`, `tarif_per_jam`) VALUES
(1, 1, 'motor', '2000'),
(2, 2, 'mobil', '5000'),
(4, NULL, 'lainnya', '7000');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_parkir` bigint UNSIGNED NOT NULL,
  `id_kendaraan` bigint UNSIGNED NOT NULL,
  `waktu_masuk` datetime NOT NULL,
  `waktu_keluar` datetime DEFAULT NULL,
  `id_tarif` bigint UNSIGNED NOT NULL,
  `durasi_jam` int DEFAULT NULL,
  `biaya_total` decimal(10,0) DEFAULT NULL,
  `status` enum('masuk','keluar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'masuk',
  `id_user` bigint UNSIGNED NOT NULL,
  `id_area` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_parkir`, `id_kendaraan`, `waktu_masuk`, `waktu_keluar`, `id_tarif`, `durasi_jam`, `biaya_total`, `status`, `id_user`, `id_area`) VALUES
(1, 1, '2026-04-10 04:45:06', '2026-04-10 13:23:01', 1, 9, '18000', 'keluar', 2, 1),
(2, 2, '2026-04-10 13:26:32', '2026-04-10 14:06:34', 1, 1, '2000', 'keluar', 2, 2),
(3, 1, '2026-04-10 13:26:44', '2026-04-10 13:34:37', 2, 1, '5000', 'keluar', 2, 2),
(4, 3, '2026-04-10 13:38:53', '2026-04-10 13:48:41', 4, 1, '7000', 'keluar', 2, 3),
(5, 4, '2026-04-10 14:18:51', '2026-04-10 14:18:58', 1, 1, '2000', 'keluar', 2, 3),
(6, 5, '2026-04-10 14:20:52', '2026-04-10 14:26:06', 1, 1, '2000', 'keluar', 2, 2),
(7, 6, '2026-04-10 14:40:11', NULL, 1, NULL, NULL, 'masuk', 2, 2),
(8, 4, '2026-04-10 15:42:08', NULL, 1, NULL, NULL, 'masuk', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','petugas','owner') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_aktif` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama_lengkap`, `username`, `password`, `role`, `status_aktif`) VALUES
(1, 'Administrator', 'admin', '$2y$12$pIR3/9Gt1zaBWuSvLzFK/eMoNhwlo2JkN8rPicPoY09u84tCm4vQu', 'admin', 1),
(2, 'Petugas Parkir', 'petugas', '$2y$12$VZ7dnxLuhKKj4zyhTMkOOeI6WJdRbAG/zbV70dnfWbdNc.P9O.yyy', 'petugas', 1),
(3, 'Owner Parkir', 'owner', '$2y$12$5l59i/i32Nv0PU/uJZnGWu99aq1NF1Bm/psBqqSFzytu.gPwqm9Cq', 'owner', 1),
(4, 'User test admin', 'test admin', '$2y$12$H8m55hWk/z0hT1MBg0hIV.H9s3cjcTo0n5t4v7D4juL9Nwa15Gg/6', 'admin', 0),
(5, 'admin 2', 'admin 2', '$2y$12$MMgbTt.QMCZSteu3RgTIrONcoqtQzdTJ8uNBA0PWMXoRJnrv.HHuK', 'admin', 1),
(6, 'petugas 2', 'petugas 2', '$2y$12$H7HjCEA2GnSX0G7DnMN2MuAd621Rnk5OAkS933XMCn1FaxDBsqcWC', 'petugas', 1),
(7, 'owner 2', 'owner 2', '$2y$12$VdLtqxQdarENhvf/dh3LqOI8q/B8bjWaM/Hz1MUCIzBAXX602bbxy', 'owner', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_area_parkir`
--
ALTER TABLE `tb_area_parkir`
  ADD PRIMARY KEY (`id_area`);

--
-- Indexes for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`),
  ADD UNIQUE KEY `tb_kendaraan_plat_nomor_unique` (`plat_nomor`),
  ADD KEY `tb_kendaraan_id_user_foreign` (`id_user`);

--
-- Indexes for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `tb_log_aktivitas_id_user_foreign` (`id_user`);

--
-- Indexes for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  ADD PRIMARY KEY (`id_tarif`),
  ADD UNIQUE KEY `tb_tarif_id_area_jenis_kendaraan_unique` (`id_area`,`jenis_kendaraan`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_parkir`),
  ADD KEY `tb_transaksi_id_kendaraan_foreign` (`id_kendaraan`),
  ADD KEY `tb_transaksi_id_tarif_foreign` (`id_tarif`),
  ADD KEY `tb_transaksi_id_user_foreign` (`id_user`),
  ADD KEY `tb_transaksi_id_area_foreign` (`id_area`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `tb_user_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_area_parkir`
--
ALTER TABLE `tb_area_parkir`
  MODIFY `id_area` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  MODIFY `id_kendaraan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  MODIFY `id_log` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=625;

--
-- AUTO_INCREMENT for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  MODIFY `id_tarif` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id_parkir` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  ADD CONSTRAINT `tb_kendaraan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`);

--
-- Constraints for table `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  ADD CONSTRAINT `tb_log_aktivitas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`);

--
-- Constraints for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  ADD CONSTRAINT `tb_tarif_id_area_foreign` FOREIGN KEY (`id_area`) REFERENCES `tb_area_parkir` (`id_area`) ON DELETE SET NULL;

--
-- Constraints for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `tb_transaksi_id_tarif_foreign` FOREIGN KEY (`id_tarif`) REFERENCES `tb_tarif` (`id_tarif`) ON DELETE RESTRICT,
  ADD CONSTRAINT `tb_transaksi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
