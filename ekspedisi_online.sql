-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Bulan Mei 2026 pada 12.25
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
-- Database: `ekspedisi_online`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `branches`
--

INSERT INTO `branches` (`id`, `code`, `name`, `city`, `address`, `phone`, `email`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'JKT-01', 'Cabang Jakarta Pusat', 'Jakarta', 'Jl. Raya Jakarta No.1', '021-5550001', 'jakarta@ekspedisiku.id', 1, '2026-05-01 04:09:22', '2026-05-01 04:09:22'),
(2, 'BDG-01', 'Cabang Bandung', 'Bandung', 'Jl. Raya Bandung No.1', '022-5550002', 'bandung@ekspedisiku.id', 1, '2026-05-01 04:09:22', '2026-05-02 09:02:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `city`, `photo`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Toko Sinar Jaya', 'sinar.jaya@gmail.com', '08111111111', 'Jl. Sudirman No.10, Jakarta', 'Jakarta', 'profiles/customers/T9GvrxVSsRl2S6RQcKM04y1x0N0A3iQmaQfX7mmo.png', NULL, '$2y$12$CsCwSsbCvI7IyLFy0caQ9ekU.g6QSjqPZc8An0JtTJDOPZKN7HTVK', NULL, '2026-05-01 04:09:26', '2026-05-04 08:21:55'),
(7, 'rizqy', 'rizqy@gmail.com', '0895', 'jl kecamatan', 'bogor', 'profiles/customers/lqFc0uyCN9uwq67KLHMKuca6x01lUiYEBeKlBLrp.png', NULL, '$2y$12$PLYyo9YKVFCIPu1O78abfuqSsnPg.ZMqytOZBCB2II0Rtz.S9ttnO', NULL, '2026-05-01 04:38:49', '2026-05-04 08:20:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_05_01_000001_create_all_tables', 1),
(2, '2026_05_02_133424_add_midtrans_fields_to_shipments_table', 2),
(3, '2026_05_02_140233_make_receiver_id_nullable_in_shipments_table', 3),
(4, '2026_05_02_141025_update_payment_methods_enum_in_payments_table', 4),
(5, '2026_05_02_141433_add_receiver_details_to_shipments_table', 5),
(6, '2026_05_02_142255_add_sender_details_to_shipments_table', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` bigint(20) UNSIGNED NOT NULL,
  `received_by` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_number` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_method` enum('cash','bank_transfer','e_wallet','midtrans','cash_on_pickup') NOT NULL DEFAULT 'cash',
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `payment_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`id`, `shipment_id`, `received_by`, `payment_number`, `amount`, `payment_method`, `payment_status`, `payment_date`, `notes`, `created_at`, `updated_at`) VALUES
(6, 11, NULL, 'PAY-69F606345F318', 10000.00, 'midtrans', 'pending', '2026-05-02', NULL, '2026-05-02 07:12:04', '2026-05-02 07:12:04'),
(7, 12, NULL, 'PAY-69F6069D74ABB', 10000.00, 'midtrans', 'pending', '2026-05-02', NULL, '2026-05-02 07:13:49', '2026-05-02 07:13:49'),
(8, 13, NULL, 'PAY-69F60A56452D9', 10000000.00, 'midtrans', 'pending', '2026-05-02', NULL, '2026-05-02 07:29:42', '2026-05-02 07:29:42'),
(14, 19, NULL, 'PAY-69F6222D6A693', 25000.00, 'midtrans', 'pending', '2026-05-02', NULL, '2026-05-02 09:11:25', '2026-05-02 09:11:25'),
(15, 20, NULL, 'PAY-69F8BACF5D14F', 25000.00, 'midtrans', 'pending', '2026-05-04', NULL, '2026-05-04 08:27:11', '2026-05-04 08:27:11'),
(16, 21, NULL, 'PAY-69F9EEC4E4F7F', 14400.00, 'midtrans', 'pending', '2026-05-05', NULL, '2026-05-05 06:21:08', '2026-05-05 06:21:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `origin_city` varchar(255) NOT NULL,
  `destination_city` varchar(255) NOT NULL,
  `price_per_kg` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estimated_days` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `routes`
--

INSERT INTO `routes` (`id`, `origin_city`, `destination_city`, `price_per_kg`, `estimated_days`, `created_at`, `updated_at`) VALUES
(1, 'Jakarta', 'Bandung', 8000.00, 1, '2026-05-01 04:09:22', '2026-05-01 04:09:22'),
(2, 'Jakarta', 'Surabaya', 12000.00, 2, '2026-05-01 04:09:22', '2026-05-01 04:09:22'),
(3, 'Jakarta', 'Medan', 18000.00, 3, '2026-05-01 04:09:22', '2026-05-01 04:09:22'),
(4, 'Jakarta', 'Makassar', 20000.00, 4, '2026-05-01 04:09:22', '2026-05-01 04:09:22'),
(5, 'Jakarta', 'Yogyakarta', 10000.00, 2, '2026-05-01 04:09:22', '2026-05-01 04:09:22'),
(6, 'Bandung', 'Jakarta', 8000.00, 1, '2026-05-01 04:09:22', '2026-05-01 04:09:22'),
(7, 'Bandung', 'Surabaya', 13000.00, 2, '2026-05-01 04:09:22', '2026-05-01 04:09:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price_multiplier` decimal(5,2) NOT NULL DEFAULT 1.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price_multiplier`, `created_at`, `updated_at`) VALUES
(1, 'Reguler', 'Pengiriman standar 3-7 hari kerja', 1.00, '2026-05-01 04:09:22', '2026-05-01 04:09:22'),
(2, 'Express', 'Pengiriman cepat 1-2 hari kerja', 1.80, '2026-05-01 04:09:22', '2026-05-01 04:09:22'),
(3, 'Same Day', 'Pengiriman hari yang sama (dalam kota)', 2.50, '2026-05-01 04:09:22', '2026-05-01 04:09:22'),
(4, 'Kargo', 'Untuk barang berat dan volume besar', 0.85, '2026-05-01 04:09:22', '2026-05-01 04:09:22'),
(5, 'COD', 'Bayar di tempat, jangkauan area tertentu', 1.20, '2026-05-01 04:09:22', '2026-05-01 04:09:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('OoExJdAXhic6LifMbpyflPV4klS9lmQH4m4WaJRc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT1lkalkzNE9HWTY3anZkcHI4VHRnTHJKeGNZQ2JCS01kTUZ0Y0szeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZWxhbmdnYW4vcGVuZ2lyaW1hbi8yMS9iYXlhciI7czo1OiJyb3V0ZSI7czoyMjoiY3VzdG9tZXIuc2hpcG1lbnRzLnBheSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTU6ImxvZ2luX2N1c3RvbWVyXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1778055055),
('WJ0gWijUBjilssHD82ex6cg8NpTps7G2gL0OJKyk', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid25JMHdPR2RIMmF1TmtqUFZLWVdNNEt2NEJTbGdFYkt2U0Mxa21tWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wYXltZW50cyI7czo1OiJyb3V0ZSI7czoyMDoiYWRtaW4ucGF5bWVudHMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1777909481),
('y04yXjJ9ROK2QFBokE1sSo4x85BWX5Ai5TuiGnGE', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia3ROU3hNVXJhR3BoSkIxRWZZaEJGSk5rVDNrUmdnT2p3UjFLWGJSRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1777987744);

-- --------------------------------------------------------

--
-- Struktur dari tabel `shipments`
--

CREATE TABLE `shipments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tracking_number` varchar(255) NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `sender_phone` varchar(255) DEFAULT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_name` varchar(255) DEFAULT NULL,
  `receiver_phone` varchar(255) DEFAULT NULL,
  `origin_branch_id` bigint(20) UNSIGNED NOT NULL,
  `destination_branch_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `courier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `route_id` bigint(20) UNSIGNED DEFAULT NULL,
  `origin_city` varchar(255) NOT NULL,
  `destination_city` varchar(255) NOT NULL,
  `sender_address` text NOT NULL,
  `receiver_address` text NOT NULL,
  `description` text DEFAULT NULL,
  `total_weight` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','picked_up','in_transit','arrived_at_branch','out_for_delivery','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','partial','paid') NOT NULL DEFAULT 'unpaid',
  `snap_token` varchar(255) DEFAULT NULL,
  `payment_url` varchar(255) DEFAULT NULL,
  `shipment_date` date NOT NULL,
  `estimated_delivery_date` date DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `shipments`
--

INSERT INTO `shipments` (`id`, `tracking_number`, `sender_id`, `sender_name`, `sender_phone`, `receiver_id`, `receiver_name`, `receiver_phone`, `origin_branch_id`, `destination_branch_id`, `vehicle_id`, `courier_id`, `service_id`, `created_by`, `route_id`, `origin_city`, `destination_city`, `sender_address`, `receiver_address`, `description`, `total_weight`, `total_price`, `status`, `payment_status`, `snap_token`, `payment_url`, `shipment_date`, `estimated_delivery_date`, `delivered_at`, `photo`, `notes`, `created_at`, `updated_at`) VALUES
(9, 'SPX69F604DBAD09C', 7, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, 3, NULL, NULL, 'bogor', 'bogor', 'jl kecamatan', 'rui\n0896\njl bogor', NULL, 1.00, 25000.00, 'pending', 'unpaid', NULL, NULL, '2026-05-02', NULL, NULL, NULL, NULL, '2026-05-02 07:06:19', '2026-05-02 07:06:19'),
(10, 'SPX69F6051B6E2BD', 7, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, 1, NULL, NULL, 'bogor', 'bogor', 'jl kecamatan', 'Rizqy Muhammad\n089577\njl bo', NULL, 1.00, 10000.00, 'pending', 'unpaid', NULL, NULL, '2026-05-02', NULL, NULL, NULL, NULL, '2026-05-02 07:07:23', '2026-05-02 07:07:23'),
(11, 'SPX69F606344C83B', 7, NULL, NULL, NULL, 'Rizqy Muhammad', '089577', 1, 1, NULL, 6, 1, NULL, NULL, 'bogor', 'bogor', 'jl kecamatan', 'jl bo', NULL, 1.00, 10000.00, 'out_for_delivery', 'unpaid', NULL, NULL, '2026-05-02', NULL, NULL, NULL, NULL, '2026-05-02 07:12:04', '2026-05-02 09:19:08'),
(12, 'SPX69F6069D691C8', 7, NULL, NULL, NULL, NULL, NULL, 2, 2, NULL, NULL, 1, NULL, NULL, 'bogor', 'bogor', 'jl kecamatan', 'Rizqy Muhammad\n089577\nj; h', NULL, 1.00, 10000.00, 'pending', 'unpaid', NULL, NULL, '2026-05-02', NULL, NULL, NULL, NULL, '2026-05-02 07:13:49', '2026-05-02 07:13:49'),
(13, 'SPX69F60A562F049', 7, 'rizqy', '089589899', NULL, 'risi', '372819', 2, 2, NULL, NULL, 1, NULL, NULL, 'bogor', 'bumi', 'jl kecamatan', 'anteroit', NULL, 1000.00, 10000000.00, 'pending', 'unpaid', NULL, NULL, '2026-05-02', NULL, NULL, NULL, NULL, '2026-05-02 07:29:42', '2026-05-02 07:29:42'),
(19, 'SPX69F6222D60718', 7, 'rizqy', '0895', NULL, 'Penerima Paket', '6765765', 1, 1, 2, 6, 3, NULL, NULL, 'bogor', 'bumi', 'jl kecamatan', 'jalan', NULL, 1.00, 25000.00, 'delivered', 'unpaid', '7ef3cf83-e504-4808-b619-bfd4c961a77f', 'https://app.sandbox.midtrans.com/snap/v4/redirection/af94e992-6a74-4013-9a06-92176498f798', '2026-05-02', NULL, '2026-05-02 09:14:13', NULL, NULL, '2026-05-02 09:11:25', '2026-05-02 09:23:27'),
(20, 'SPX69F8BACF50127', 1, 'Toko Sinar Jaya', '08111111111', NULL, 'galio', '0985342314', 2, 2, NULL, NULL, 3, NULL, NULL, 'Jakarta', 'semarang', 'Jl. Sudirman No.10, Jakarta', 'jl kampis', NULL, 1.00, 25000.00, 'pending', 'unpaid', '5aa5efde-b04d-4449-bb3e-bcdf3f090138', 'https://app.sandbox.midtrans.com/snap/v4/redirection/4256dafb-7081-4248-b85d-0d4202eff898', '2026-05-04', NULL, NULL, NULL, NULL, '2026-05-04 08:27:11', '2026-05-04 08:27:13'),
(21, 'SPX69F9EEC4C775B', 1, 'Toko Sinar Jaya', '08111111111', NULL, 'Rizqy Muhammad', '068768', 1, 2, NULL, NULL, 2, NULL, NULL, 'Jakarta', 'bandung', 'Jl. Sudirman No.10, Jakarta', 'jl', NULL, 1.00, 14400.00, 'pending', 'unpaid', 'e5b3a334-b796-4399-980f-bc0e75f1c8e4', 'https://app.sandbox.midtrans.com/snap/v4/redirection/e5b3a334-b796-4399-980f-bc0e75f1c8e4', '2026-05-05', NULL, NULL, NULL, NULL, '2026-05-05 06:21:08', '2026-05-06 01:10:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `shipment_items`
--

CREATE TABLE `shipment_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `weight` decimal(10,2) NOT NULL DEFAULT 0.00,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `shipment_items`
--

INSERT INTO `shipment_items` (`id`, `shipment_id`, `item_name`, `description`, `quantity`, `weight`, `photo`, `created_at`, `updated_at`) VALUES
(9, 9, 'mobil mainan', NULL, 1, 1.00, NULL, '2026-05-02 07:06:19', '2026-05-02 07:06:19'),
(10, 10, 'mobil mainan', NULL, 1, 1.00, NULL, '2026-05-02 07:07:23', '2026-05-02 07:07:23'),
(11, 11, 'mobil mainan', NULL, 1, 1.00, NULL, '2026-05-02 07:12:04', '2026-05-02 07:12:04'),
(12, 12, 'mobil mainan', NULL, 1, 1.00, NULL, '2026-05-02 07:13:49', '2026-05-02 07:13:49'),
(13, 13, 'bulan', NULL, 1, 1000.00, NULL, '2026-05-02 07:29:42', '2026-05-02 07:29:42'),
(19, 19, 'asteroit', NULL, 1, 1.00, NULL, '2026-05-02 09:11:25', '2026-05-02 09:11:25'),
(20, 20, 'besi', NULL, 1, 1.00, NULL, '2026-05-04 08:27:11', '2026-05-04 08:27:11'),
(21, 21, 'mobil mainan', NULL, 1, 1.00, NULL, '2026-05-05 06:21:08', '2026-05-05 06:21:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `shipment_trackings`
--

CREATE TABLE `shipment_trackings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` bigint(20) UNSIGNED NOT NULL,
  `recorded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','picked_up','in_transit','arrived_at_branch','out_for_delivery','delivered','cancelled') NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `checked_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `shipment_trackings`
--

INSERT INTO `shipment_trackings` (`id`, `shipment_id`, `recorded_by`, `status`, `location`, `description`, `checked_at`, `created_at`, `updated_at`) VALUES
(34, 9, NULL, 'pending', NULL, 'Permintaan penjemputan paket dibuat oleh pengirim.', '2026-05-02 07:06:19', '2026-05-02 07:06:19', '2026-05-02 07:06:19'),
(35, 10, NULL, 'pending', NULL, 'Permintaan penjemputan paket dibuat oleh pengirim.', '2026-05-02 07:07:23', '2026-05-02 07:07:23', '2026-05-02 07:07:23'),
(36, 11, NULL, 'pending', NULL, 'Permintaan penjemputan paket dibuat oleh pengirim.', '2026-05-02 07:12:04', '2026-05-02 07:12:04', '2026-05-02 07:12:04'),
(37, 12, NULL, 'pending', NULL, 'Permintaan penjemputan paket dibuat oleh pengirim.', '2026-05-02 07:13:49', '2026-05-02 07:13:49', '2026-05-02 07:13:49'),
(38, 13, NULL, 'pending', NULL, 'Permintaan penjemputan paket dibuat oleh pengirim.', '2026-05-02 07:29:42', '2026-05-02 07:29:42', '2026-05-02 07:29:42'),
(44, 11, 3, 'picked_up', 'Cabang Jakarta Pusat', 'Paket telah ditugaskan ke kurir Kurir Andi.', '2026-05-02 09:05:19', '2026-05-02 09:05:19', '2026-05-02 09:05:19'),
(45, 11, 6, 'out_for_delivery', NULL, 'di bumi', '2026-05-02 09:09:02', '2026-05-02 09:09:02', '2026-05-02 09:09:02'),
(46, 19, NULL, 'pending', NULL, 'Permintaan penjemputan paket dibuat oleh pengirim.', '2026-05-02 09:11:25', '2026-05-02 09:11:25', '2026-05-02 09:11:25'),
(47, 19, 3, 'picked_up', 'Cabang Jakarta Pusat', 'Paket telah ditugaskan ke kurir Kurir Andi.', '2026-05-02 09:12:27', '2026-05-02 09:12:27', '2026-05-02 09:12:27'),
(48, 19, 6, 'out_for_delivery', NULL, 'di bulan menuju bumi', '2026-05-02 09:13:21', '2026-05-02 09:13:21', '2026-05-02 09:13:21'),
(49, 19, 6, 'delivered', NULL, 'sudah sampe', '2026-05-02 09:14:13', '2026-05-02 09:14:13', '2026-05-02 09:14:13'),
(52, 20, NULL, 'pending', NULL, 'Permintaan penjemputan paket dibuat oleh pengirim.', '2026-05-04 08:27:11', '2026-05-04 08:27:11', '2026-05-04 08:27:11'),
(53, 21, NULL, 'pending', NULL, 'Permintaan penjemputan paket dibuat oleh pengirim.', '2026-05-05 06:21:08', '2026-05-05 06:21:08', '2026-05-05 06:21:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role` enum('admin','branch_admin','courier','manager') NOT NULL DEFAULT 'courier',
  `photo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `branch_id`, `role`, `photo`, `is_active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin EkspedisiKu', 'admin@ekspedisiku.id', '081200000001', 1, 'admin', 'profiles/Ow66WnKkPX2AR2HvncadU2FEVf4RSCy71FOxt9fE.png', 1, NULL, '$2y$12$.A5K0OOENi5CVTpwov8LXO7KHZcLYiyy63dGG3k0K2.RWklh5YNVS', NULL, '2026-05-01 04:09:23', '2026-05-04 08:14:01'),
(2, 'Budi Manager Bandung', 'managerjkt@ekspedisiku.id', '081200000002', 1, 'manager', NULL, 1, NULL, '$2y$12$Vl/a75AupuKuhDTWZ2vZUeQTbvSSkq76BKK.ii/JiO/P8jHkzEon6', NULL, '2026-05-01 04:09:23', '2026-05-04 07:15:30'),
(3, 'Siti cabang Jakarta', 'cabangjkt@ekspedisiku.id', '081222425884', 1, 'branch_admin', NULL, 1, NULL, '$2y$12$FMeBXHBbTB0SIJODFskrC.sn0SKikNKjTWtkvxbV8NrywpmtK3xPK', NULL, '2026-05-01 04:09:23', '2026-05-04 07:13:34'),
(4, 'Ahmad cabang Bandung', 'cabangbdg@ekspedisiku.id', '081213698968', 2, 'branch_admin', NULL, 1, NULL, '$2y$12$6OWMnM7VV45Ny6rcGIg3V.P38qtdcYxuk0q49wV4TXUteK4nnBZYK', NULL, '2026-05-01 04:09:24', '2026-05-04 07:13:27'),
(6, 'Kurir Andi', 'andijkt@ekspedisku.id', '081355406105', 1, 'courier', 'profiles/mgfk7Lkbn1C17q1on6LY73BCgNDyqkd6H8T0it5M.png', 1, NULL, '$2y$12$I/ZdO.ZQH6loPjDDD.jtGe2w9XOKIPkndcdT5wjbW2Nw1QevnvQxC', NULL, '2026-05-01 04:09:24', '2026-05-04 06:18:03'),
(7, 'Kurir Beni', 'benibdg@ekspedisku.id', '081376376755', 2, 'courier', NULL, 1, NULL, '$2y$12$RY91Ka2Sj4bikM49wZXlte5ZgqLkhuom.mgLSEbMl8ZHnHw0yd1wK', NULL, '2026-05-01 04:09:25', '2026-05-04 06:18:17'),
(10, 'Sofi Manager Bandung', 'managerbdg@ekspedisiku.id', '081222425884', 2, 'manager', NULL, 1, NULL, '$2y$12$t5GPdfGKHpgn7NheGmxesOg3SMGvmiZsHV8BcvINwOsLP/l3ZMtHi', NULL, '2026-05-04 07:14:56', '2026-05-04 07:14:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plate_number` varchar(20) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `type` enum('truck','van','motorcycle') NOT NULL DEFAULT 'van',
  `capacity_kg` decimal(10,2) NOT NULL DEFAULT 0.00,
  `driver_name` varchar(255) DEFAULT NULL,
  `status` enum('available','in_use','maintenance') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `vehicles`
--

INSERT INTO `vehicles` (`id`, `branch_id`, `plate_number`, `brand`, `type`, `capacity_kg`, `driver_name`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'B 7788 ABC', 'Mitsubishi', 'van', 2000.00, 'Andi Pratama', 'in_use', '2026-05-01 04:09:22', '2026-05-01 04:09:22'),
(3, 2, 'D 4455 QWE', 'Toyota', 'van', 1500.00, 'Beni', 'available', '2026-05-01 04:09:22', '2026-05-04 07:30:44'),
(5, NULL, 'L 5678 GHI', 'Isuzu', 'truck', 8000.00, NULL, 'maintenance', '2026-05-01 04:09:22', '2026-05-04 07:31:07');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_code_unique` (`code`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_payment_number_unique` (`payment_number`),
  ADD KEY `payments_shipment_id_foreign` (`shipment_id`),
  ADD KEY `payments_received_by_foreign` (`received_by`);

--
-- Indeks untuk tabel `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shipments_tracking_number_unique` (`tracking_number`),
  ADD KEY `shipments_sender_id_foreign` (`sender_id`),
  ADD KEY `shipments_receiver_id_foreign` (`receiver_id`),
  ADD KEY `shipments_origin_branch_id_foreign` (`origin_branch_id`),
  ADD KEY `shipments_destination_branch_id_foreign` (`destination_branch_id`),
  ADD KEY `shipments_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `shipments_courier_id_foreign` (`courier_id`),
  ADD KEY `shipments_service_id_foreign` (`service_id`),
  ADD KEY `shipments_created_by_foreign` (`created_by`),
  ADD KEY `shipments_route_id_foreign` (`route_id`);

--
-- Indeks untuk tabel `shipment_items`
--
ALTER TABLE `shipment_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipment_items_shipment_id_foreign` (`shipment_id`);

--
-- Indeks untuk tabel `shipment_trackings`
--
ALTER TABLE `shipment_trackings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipment_trackings_shipment_id_foreign` (`shipment_id`),
  ADD KEY `shipment_trackings_recorded_by_foreign` (`recorded_by`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_branch_id_foreign` (`branch_id`);

--
-- Indeks untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicles_plate_number_unique` (`plate_number`),
  ADD KEY `vehicles_branch_id_foreign` (`branch_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `shipment_items`
--
ALTER TABLE `shipment_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `shipment_trackings`
--
ALTER TABLE `shipment_trackings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_courier_id_foreign` FOREIGN KEY (`courier_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `shipments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `shipments_destination_branch_id_foreign` FOREIGN KEY (`destination_branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `shipments_origin_branch_id_foreign` FOREIGN KEY (`origin_branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `shipments_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shipments_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `shipments_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shipments_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `shipments_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `shipment_items`
--
ALTER TABLE `shipment_items`
  ADD CONSTRAINT `shipment_items_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `shipment_trackings`
--
ALTER TABLE `shipment_trackings`
  ADD CONSTRAINT `shipment_trackings_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `shipment_trackings_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
