-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Des 2025 pada 05.47
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
-- Database: `db_laundry_alan_native`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'alan', '04040421245', 'asfasasfsf', '2025-11-28 07:45:26', '2025-11-28 07:54:19'),
(3, 'rio', '124814', 'sdjaksdfasr', '2025-11-28 07:52:45', '2025-11-28 07:54:26'),
(4, 'reza', '3434', 'saf', '2025-11-28 07:52:51', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `levels`
--

INSERT INTO `levels` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'administrator', '2025-11-28 07:10:18', NULL),
(2, 'operator', '2025-11-28 07:10:45', NULL),
(3, 'Pimpinan', '2025-11-28 07:25:57', '2025-12-01 03:13:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `level_menus`
--

CREATE TABLE `level_menus` (
  `id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `level_menus`
--

INSERT INTO `level_menus` (`id`, `level_id`, `menu_id`, `created_at`, `updated_at`) VALUES
(14, 1, 14, '2025-12-01 00:22:47', NULL),
(15, 1, 13, '2025-12-01 00:22:47', NULL),
(16, 1, 12, '2025-12-01 00:22:47', NULL),
(17, 1, 11, '2025-12-01 00:22:47', NULL),
(18, 1, 10, '2025-12-01 00:22:47', NULL),
(19, 1, 9, '2025-12-01 00:22:47', NULL),
(20, 1, 8, '2025-12-01 00:22:47', NULL),
(21, 1, 7, '2025-12-01 00:22:47', NULL),
(22, 1, 6, '2025-12-01 00:22:47', NULL),
(25, 2, 13, '2025-12-01 04:12:43', NULL),
(26, 2, 6, '2025-12-01 04:12:43', NULL),
(27, 3, 14, '2025-12-01 04:12:49', NULL),
(28, 3, 6, '2025-12-01 04:12:49', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `link` varchar(30) NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`id`, `name`, `icon`, `link`, `order`, `created_at`, `updated_at`) VALUES
(6, 'Dashboard', 'bi-house-door', 'dashboard', 1, '2025-11-28 07:39:12', '2025-11-28 07:55:52'),
(7, 'Customer', 'bi bi-person', 'customer', 2, '2025-11-28 07:39:12', '2025-11-28 07:56:08'),
(8, 'service', 'bi bi-gear', 'service', 3, '2025-11-28 07:40:14', '2025-11-28 07:56:19'),
(9, 'level', 'bi bi-stack', 'level', 4, '2025-11-28 07:40:14', '2025-11-28 07:58:46'),
(10, 'user', 'bi-person-circle', 'user', 5, '2025-11-28 07:40:47', '2025-11-28 07:56:46'),
(11, 'tax', 'bi bi-file-earmark', 'tax', 6, '2025-11-28 07:40:47', '2025-11-28 07:57:25'),
(12, 'Menu', 'bi bi-list', 'menu', 7, '2025-11-28 07:41:22', '2025-11-28 07:57:41'),
(13, 'Order', 'bi bi-cart', 'order', 8, '2025-11-28 07:41:22', '2025-11-28 07:57:57'),
(14, 'Report', 'bi bi-clipboard-data', 'laporan-penjualan', 9, '2025-12-01 00:22:15', '2025-12-01 03:20:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `services`
--

INSERT INTO `services` (`id`, `name`, `price`, `description`, `created_at`, `updated_at`) VALUES
(1, 'hanya cuci', 4500, 'assadsf', '2025-11-28 07:48:15', '2025-12-01 03:11:25'),
(2, 'hanya gosok', 5000, 'sdaasdasd', '2025-11-28 07:48:58', '2025-12-01 03:11:32'),
(3, 'cuci dan gosok', 5000, '', '2025-11-28 07:49:12', '2025-12-01 02:50:43'),
(4, 'Laundry besar seperti selimut, karpet, mantel dan ', 7000, '', '2025-11-28 07:53:07', '2025-12-01 03:12:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `taxs`
--

CREATE TABLE `taxs` (
  `id` int(11) NOT NULL,
  `percent` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `taxs`
--

INSERT INTO `taxs` (`id`, `percent`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 10, 1, '2025-11-28 07:44:44', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `trans_orders`
--

CREATE TABLE `trans_orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `order_end_date` date NOT NULL,
  `order_status` tinyint(1) NOT NULL DEFAULT 0,
  `order_pay` int(11) NOT NULL,
  `order_change` int(11) NOT NULL,
  `order_tax` int(11) NOT NULL,
  `order_total` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `trans_orders`
--

INSERT INTO `trans_orders` (`id`, `customer_id`, `order_code`, `order_end_date`, `order_status`, `order_pay`, `order_change`, `order_tax`, `order_total`, `created_at`, `updated_at`) VALUES
(5, 1, 'ORD-0112250005', '2025-12-01', 1, 10000, 4500, 500, 5500, '2025-12-01 07:23:54', '2025-12-01 00:24:05'),
(6, 3, 'ORD-0112250006', '2025-12-01', 1, 10000, 4500, 500, 5500, '2025-12-01 09:20:44', '2025-12-01 02:31:37'),
(7, 4, 'ORD-0112250007', '2025-12-01', 1, 20000, 3500, 1500, 16500, '2025-12-01 09:31:56', '2025-12-01 02:32:36'),
(8, 4, 'ORD-0112250008', '2025-12-01', 1, 50000, 33500, 1500, 16500, '2025-12-01 09:32:21', '2025-12-01 02:32:34'),
(9, 1, 'ORD-0112250009', '2025-12-01', 1, 20000, 12300, 700, 7700, '2025-12-01 10:22:58', '2025-12-01 04:30:29'),
(10, 1, 'ORD-0112250010', '2025-12-01', 1, 20000, 6800, 1200, 13200, '2025-12-01 11:30:18', '2025-12-01 04:30:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `trans_order_details`
--

CREATE TABLE `trans_order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `qty` decimal(10,1) NOT NULL,
  `price` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `trans_order_details`
--

INSERT INTO `trans_order_details` (`id`, `order_id`, `service_id`, `qty`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1.5, 5000, 7500, '2025-11-28 07:49:45', NULL),
(2, 2, 3, 2.0, 9000, 18000, '2025-11-28 07:53:27', NULL),
(3, 3, 4, 1.0, 15000, 15000, '2025-11-28 07:53:58', NULL),
(4, 4, 1, 2.0, 5000, 10000, '2025-11-28 08:17:24', NULL),
(5, 5, 1, 1.0, 5000, 5000, '2025-12-01 00:23:54', NULL),
(6, 6, 1, 1.0, 5000, 5000, '2025-12-01 02:20:44', NULL),
(7, 7, 4, 1.0, 15000, 15000, '2025-12-01 02:31:56', NULL),
(8, 8, 4, 1.0, 15000, 15000, '2025-12-01 02:32:21', NULL),
(9, 9, 4, 1.0, 7000, 7000, '2025-12-01 03:22:58', NULL),
(10, 10, 4, 1.0, 7000, 7000, '2025-12-01 04:30:18', NULL),
(11, 10, 2, 1.0, 5000, 5000, '2025-12-01 04:30:18', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `level_id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'Anugrah Lan Pambudi', 'admin@gmail.com', 'd582f06649b7bb375a5ef3ca8f95c84d4dbec45e', '2025-11-28 07:03:36', NULL),
(2, 2, 'operator', 'operator@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2025-11-28 07:29:30', '2025-12-01 04:13:57'),
(3, 3, 'Pimpinan', 'pimpinan@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2025-12-01 03:17:33', '2025-12-01 04:33:40');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `level_menus`
--
ALTER TABLE `level_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `taxs`
--
ALTER TABLE `taxs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `trans_orders`
--
ALTER TABLE `trans_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `trans_order_details`
--
ALTER TABLE `trans_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `level_menus`
--
ALTER TABLE `level_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `taxs`
--
ALTER TABLE `taxs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `trans_orders`
--
ALTER TABLE `trans_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `trans_order_details`
--
ALTER TABLE `trans_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
