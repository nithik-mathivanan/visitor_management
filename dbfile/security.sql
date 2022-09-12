-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2022 at 11:15 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `security`
--

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `device_name` varchar(255) NOT NULL,
  `serial_no` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `device_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entry`
--

CREATE TABLE `entry` (
  `id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `in_time` datetime NOT NULL,
  `out_time` datetime NOT NULL,
  `ic_number` varchar(50) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `person_count` int(11) NOT NULL,
  `visit_reason` varchar(255) NOT NULL,
  `delay_reason` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `feed_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `feed_id` varchar(255) NOT NULL,
  `feed_name` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `license_plate_number` varchar(255) NOT NULL,
  `location_id` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `object_classification` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `time_zone` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `ui_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `location_address` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `last_login` datetime NOT NULL,
  `status` varchar(10) NOT NULL,
  `site_code` varchar(50) NOT NULL,
  `role_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `user_id`, `username`, `password`, `created_at`, `created_by`, `updated_at`, `updated_by`, `last_login`, `status`, `site_code`, `role_id`) VALUES
(1, 1, 'nithik', '$2y$10$6dga7knX3H4DBU7UGIqNduZH6qNMD1xmNjiXfciNr4uTc1k7dc7/q', '2022-02-15 11:27:21', 0, '2022-02-15 11:27:21', 0, '2022-02-15 11:27:21', '1', 'CHENNAI01', 1),
(3, 2, 'priyanka', '$2y$10$6dga7knX3H4DBU7UGIqNduZH6qNMD1xmNjiXfciNr4uTc1k7dc7/q', '2022-02-15 14:58:55', 0, '2022-02-15 14:58:55', 0, '2022-02-15 14:58:55', '', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'MyApp', '7d63b5de69f5f02c902336e8c289e0ec4ced5559d136a5daa004a767bbd3e887', '[\"*\"]', NULL, '2022-02-15 07:26:57', '2022-02-15 07:26:57'),
(2, 'App\\Models\\User', 1, 'MyApp', '3a7da06d6e3efcac7df5b0d4b629d07224ee7b680f10fc5cb85c01a992bbeb84', '[\"*\"]', NULL, '2022-02-15 07:27:16', '2022-02-15 07:27:16'),
(3, 'App\\Models\\User', 1, 'MyApp', 'dbe18da0f43067950264655eb96cf62ab749527483ac764d296f5b135be47ce7', '[\"*\"]', NULL, '2022-02-15 07:31:01', '2022-02-15 07:31:01'),
(4, 'App\\Models\\User', 1, 'MyApp', '0216de98bbb41d3fcd4903b477fb63d1c6997993523152a15dee91a6c642b404', '[\"*\"]', NULL, '2022-02-15 07:35:49', '2022-02-15 07:35:49'),
(5, 'App\\Models\\User', 1, 'MyApp', '508ad24b783f30dca8402b4de7e3297cec362d0a8a42b1bd0dd2a285c0e194b4', '[\"*\"]', NULL, '2022-02-15 07:36:32', '2022-02-15 07:36:32'),
(6, 'App\\Models\\User', 1, 'MyApp', 'fb5e577b7e084e0f2964b1839f3c166addc186961abd44ce09aca1b8d19a5c45', '[\"*\"]', NULL, '2022-02-15 07:36:57', '2022-02-15 07:36:57'),
(7, 'App\\Models\\User', 1, 'MyApp', 'fb4de4e50bad3787f552c0b45c094845427d592d7a05d2a723ecebef1f0625d8', '[\"*\"]', NULL, '2022-02-15 07:37:00', '2022-02-15 07:37:00'),
(8, 'App\\Models\\User', 1, 'MyApp', 'b027d10c6dc3d4728c77a56646c2d8eee20092fb26d4d39844fd127fa78f737b', '[\"*\"]', NULL, '2022-02-15 07:40:44', '2022-02-15 07:40:44'),
(9, 'App\\Models\\User', 1, 'MyApp', 'abf3be187eb070a753602d9777ca3e22778b06ac983ca1aa949c221539889149', '[\"*\"]', NULL, '2022-02-15 07:41:02', '2022-02-15 07:41:02'),
(10, 'App\\Models\\User', 1, 'MyApp', 'bc70ec70f563c5a52155e7ebb297fc293fd5922255d2116106e2c05ffcc23b10', '[\"*\"]', NULL, '2022-02-15 07:41:12', '2022-02-15 07:41:12'),
(11, 'App\\Models\\User', 1, 'MyApp', '44e52e8aa53b02ff727541f7f98aaf6bd21b5ed6acffd373b3a7ccaec8ae4fb1', '[\"*\"]', NULL, '2022-02-15 07:44:12', '2022-02-15 07:44:12'),
(12, 'App\\Models\\User', 1, 'MyApp', 'aee01d40f0da2838b9b2725405b1369dc86cc2347055e0dc02d3b5c289407178', '[\"*\"]', NULL, '2022-02-15 07:44:36', '2022-02-15 07:44:36'),
(13, 'App\\Models\\User', 1, 'MyApp', 'd54ab7fc893c28dba9b199fc94e1c929b93e22d9a0f13da94e8786d4481a052e', '[\"*\"]', NULL, '2022-02-15 07:55:14', '2022-02-15 07:55:14'),
(14, 'App\\Models\\User', 1, 'MyApp', '90ae4f75c122c115f92be5029a8b271ba53f5ebc889dcda40fad5ba1b03fb43d', '[\"*\"]', NULL, '2022-02-15 07:55:26', '2022-02-15 07:55:26'),
(15, 'App\\Models\\User', 1, 'MyApp', 'd0004e201efc6fca8531142144e6a5b02a351f3b1b21f152bd4789eec8c2a122', '[\"*\"]', NULL, '2022-02-15 07:57:37', '2022-02-15 07:57:37'),
(16, 'App\\Models\\User', 1, 'MyApp', '05c9bbfedfa6aac163c6ab75d22e7257939c86ef7acce61b98f3d60e3806b01d', '[\"*\"]', NULL, '2022-02-15 07:58:10', '2022-02-15 07:58:10'),
(17, 'App\\Models\\User', 1, 'MyApp', 'ef1bcee8f1172971a35f049fc2812c165fd759a7a0dd4708637bd9c76b99844a', '[\"*\"]', NULL, '2022-02-15 07:58:20', '2022-02-15 07:58:20'),
(18, 'App\\Models\\User', 1, 'MyApp', 'c626b4d2fca03d4e8c1d7b651b4129a0e4c5bf6a4565379cd5da0c99f51f7e1e', '[\"*\"]', NULL, '2022-02-15 07:58:27', '2022-02-15 07:58:27'),
(19, 'App\\Models\\User', 1, 'MyApp', '83cd144b132eade149cf7eff4c514c69cbc8a24511ba029a8e0af7fe7656d6a1', '[\"*\"]', NULL, '2022-02-15 07:58:49', '2022-02-15 07:58:49'),
(20, 'App\\Models\\User', 1, 'MyApp', '14a4e1818f9a198c7de185b5c5de070e925937d12d1b7c2437b9c274729f0dd1', '[\"*\"]', NULL, '2022-02-15 08:03:22', '2022-02-15 08:03:22'),
(21, 'App\\Models\\User', 1, 'MyApp', 'a524b55a37f6f309357e7e3895eade6f99e9ab74f1d83bbbb6471af76d01e420', '[\"*\"]', NULL, '2022-02-15 08:09:24', '2022-02-15 08:09:24'),
(22, 'App\\Models\\User', 1, 'MyApp', 'd683abd8f5e679a423f8a410800c6e6bcc03e2cb9f10c02accd07169540a3598', '[\"*\"]', NULL, '2022-02-15 08:10:58', '2022-02-15 08:10:58'),
(23, 'App\\Models\\User', 1, 'MyApp', '3ae5d06bf7518c5a5713b09b6e10a8588461dd398064acf2780e299ece970e87', '[\"*\"]', NULL, '2022-02-15 08:11:11', '2022-02-15 08:11:11'),
(24, 'App\\Models\\User', 1, 'MyApp', 'b73f2dae69ff037bb17ba724325d9ee6faf923da948d84a1f6b62f2d4ca85bbe', '[\"*\"]', NULL, '2022-02-15 08:11:40', '2022-02-15 08:11:40'),
(25, 'App\\Models\\User', 1, 'MyApp', '83c57a0549d323d90a59e8d7653ffadf496e2d687564172ed6deccb293c46259', '[\"*\"]', NULL, '2022-02-15 08:12:02', '2022-02-15 08:12:02'),
(26, 'App\\Models\\User', 1, 'MyApp', 'f47b12906bf783d9da38884ae23e995ef9b84730eab6bb3800e79fd3a63af6c1', '[\"*\"]', NULL, '2022-02-15 08:12:20', '2022-02-15 08:12:20'),
(27, 'App\\Models\\User', 1, 'MyApp', '342ebd5439876288a3560daab7c4c5150ec45f51259e51abcb1bbecb953bd1fa', '[\"*\"]', NULL, '2022-02-15 08:12:38', '2022-02-15 08:12:38'),
(28, 'App\\Models\\User', 1, 'MyApp', '1878e435a1c6c85184e07eb78531dd723bec498225d96c7ed301624ed8253dff', '[\"*\"]', NULL, '2022-02-15 08:12:53', '2022-02-15 08:12:53'),
(29, 'App\\Models\\User', 1, 'MyApp', '4b68272e9a45525728ba661b5021cfa841d00bf7caf7fac2604f45abf07023f8', '[\"*\"]', NULL, '2022-02-15 08:13:09', '2022-02-15 08:13:09'),
(30, 'App\\Models\\User', 1, 'MyApp', '4f10452497fbe4219d9e94527378ecb848f50d8ab487bbfb7ebc767400ce564a', '[\"*\"]', NULL, '2022-02-15 08:14:14', '2022-02-15 08:14:14'),
(31, 'App\\Models\\User', 1, 'MyApp', 'd9a26175b44e5494f3f85f02cfb97a028ada66c2d694093b2a7c2e6cf4e79284', '[\"*\"]', NULL, '2022-02-15 08:14:37', '2022-02-15 08:14:37'),
(32, 'App\\Models\\User', 1, 'MyApp', '4b386d53f691309ef4f88ca4de9db0035dd3ce16cd57db04050e698ea0ee7c12', '[\"*\"]', NULL, '2022-02-15 08:15:07', '2022-02-15 08:15:07'),
(33, 'App\\Models\\User', 1, 'MyApp', '6770c714b1195c22e5b636aea18981b2c21c1d1225b62ccbb97979bde58f840d', '[\"*\"]', NULL, '2022-02-15 08:15:32', '2022-02-15 08:15:32'),
(34, 'App\\Models\\User', 1, 'MyApp', 'acf0ab067fd4caf4260f96f8865f404af796dfc16eb28d8ebc02086599ad9c8c', '[\"*\"]', NULL, '2022-02-15 08:15:49', '2022-02-15 08:15:49'),
(35, 'App\\Models\\User', 1, 'MyApp', 'c2097c4e9478a81ad908bf51f6dae1c3ed29027a1b27aeca1d01b042ffc8cd5a', '[\"*\"]', NULL, '2022-02-15 08:16:09', '2022-02-15 08:16:09'),
(36, 'App\\Models\\User', 1, 'MyApp', '13965e12116822373f8080c7bd68ec1cc6871dfbe1f70924073b8e31ec51db03', '[\"*\"]', NULL, '2022-02-15 08:17:19', '2022-02-15 08:17:19'),
(37, 'App\\Models\\User', 1, 'MyApp', 'b04a6a323ec72ae4f0f96fdd37b65b39fe0c7b399d07edebfb19ec549ef8a204', '[\"*\"]', NULL, '2022-02-15 08:18:04', '2022-02-15 08:18:04'),
(38, 'App\\Models\\User', 1, 'MyApp', 'd7e5e9bbd01e073dd46780b42947f90ff93a58f80ec8d2b0b8faff883754954e', '[\"*\"]', NULL, '2022-02-15 08:19:48', '2022-02-15 08:19:48'),
(39, 'App\\Models\\User', 1, 'MyApp', 'bd07b56ad197206300319c1e64209bbca876e7539f274e91b84dc255f7fbf3ad', '[\"*\"]', NULL, '2022-02-15 08:21:06', '2022-02-15 08:21:06'),
(40, 'App\\Models\\User', 1, 'MyApp', '05c7cd011741652087a027cc785256258316946ea9ae973705c1b40be67eba3d', '[\"*\"]', NULL, '2022-02-15 08:21:36', '2022-02-15 08:21:36'),
(41, 'App\\Models\\User', 1, 'MyApp', '4ae3755d862e7c5aa7ffcbcc0bfb7a16575e6f6c8f343e03d93d08e4773d028a', '[\"*\"]', NULL, '2022-02-15 08:21:49', '2022-02-15 08:21:49'),
(42, 'App\\Models\\User', 1, 'MyApp', 'addccbdc38e967bb092a58a46c3f74aa92b8a7820e6e60f764e0040b39048bab', '[\"*\"]', NULL, '2022-02-15 08:22:00', '2022-02-15 08:22:00'),
(43, 'App\\Models\\User', 1, 'MyApp', '60b8b013dfa624277298f9e3dcc6dfca32aa5feaa0ea1a822f167c426adf3ca4', '[\"*\"]', NULL, '2022-02-15 08:22:14', '2022-02-15 08:22:14'),
(44, 'App\\Models\\User', 1, 'MyApp', '0c5d710c44c4de7ce86d8d6d43d184e20a345e5839610e75a52e4aa9aa2276ae', '[\"*\"]', NULL, '2022-02-15 08:23:00', '2022-02-15 08:23:00'),
(45, 'App\\Models\\User', 1, 'MyApp', '6dd1e3ed5c20d5fe5804f7da7a6deb86004790a26877a5cd0525d845ae3050d8', '[\"*\"]', NULL, '2022-02-15 08:23:03', '2022-02-15 08:23:03'),
(46, 'App\\Models\\User', 1, 'MyApp', 'e2754fb763845a221b1251749d1bff67a8d87d8faaa8bd8242da34d5a2c6b5c8', '[\"*\"]', NULL, '2022-02-15 08:23:29', '2022-02-15 08:23:29'),
(47, 'App\\Models\\User', 1, 'MyApp', 'a2bca837b4a51409890c6c67e383052a02f27de41509f44373f23277412bd738', '[\"*\"]', NULL, '2022-02-15 08:23:51', '2022-02-15 08:23:51'),
(48, 'App\\Models\\User', 1, 'MyApp', '464f5398dfd8dcf64f555916f8a0860019c0ab91b4239d263521ed33d3df0a79', '[\"*\"]', NULL, '2022-02-15 08:26:22', '2022-02-15 08:26:22'),
(49, 'App\\Models\\User', 1, 'MyApp', '128571c7333f4eb9499f22c22fb48950c5bf8e6ead314518928710e05616a537', '[\"*\"]', NULL, '2022-02-15 08:26:36', '2022-02-15 08:26:36'),
(50, 'App\\Models\\User', 1, 'MyApp', '150f7d421084ddde38ba93f55afc9b86d1d118c1f76ba4ec340a7aa92ea5c9a5', '[\"*\"]', NULL, '2022-02-15 08:28:08', '2022-02-15 08:28:08'),
(51, 'App\\Models\\User', 3, 'MyApp', '1d33ab48e711f1f3d2afe77facefc920a981e54c7b1de8052e53a1acee797d8f', '[\"*\"]', NULL, '2022-02-15 08:30:18', '2022-02-15 08:30:18'),
(52, 'App\\Models\\User', 3, 'MyApp', '3e96dff6d483818854dcad3c2130ece4138d610852001cd8af3a289c9d3a55b2', '[\"*\"]', NULL, '2022-02-15 08:44:09', '2022-02-15 08:44:09'),
(53, 'App\\Models\\User', 3, 'MyApp', '659eb15b4fdd92177d7f9fd2de4cff27def6ff8ff4101641c1a9551bc1dc7952', '[\"*\"]', NULL, '2022-02-16 00:02:39', '2022-02-16 00:02:39'),
(54, 'App\\Models\\User', 3, 'MyApp', 'd49f3de7231603ab9ee43a5ca0e0d6311fb2cb1ea90a804b25de72bde1e14f2f', '[\"*\"]', NULL, '2022-02-16 00:03:24', '2022-02-16 00:03:24'),
(55, 'App\\Models\\User', 3, 'MyApp', 'ea331c33b576ce655daa1343f412786168b535a8e0e47df6153ab5fce1325195', '[\"*\"]', NULL, '2022-02-16 00:06:56', '2022-02-16 00:06:56');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_permission` varchar(255) NOT NULL,
  `total_in_hours` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_permission`, `total_in_hours`, `created_at`, `updated_at`) VALUES
(1, 'System Admin', '{\"visitors\":1,\"users\":1,\"track_cctv\":1,\"manage_cctv\":0,\"entry\":0,\"locations\":0,\"roles\":1}', 8, '2022-02-15 11:30:21', '2022-02-15 11:30:21'),
(2, 'Security Guard', '{\"visitors\":0,\"users\":0,\"track_cctv\":1,\"manage_cctv\":0,\"entry\":0,\"locations\":1,\"roles\":1}', 8, '2022-02-15 11:30:21', '2022-02-15 11:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `permission_name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `permission_name`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Manage Visitors', '2022-02-15 11:32:37', '2022-02-15 11:32:37', 1, 1),
(2, 'Manage Users', '2022-02-15 11:32:37', '2022-02-15 11:32:37', 1, 1),
(3, 'Track CCTV', '2022-02-15 11:34:17', '2022-02-15 11:34:17', 1, 1),
(4, 'Manage CCTV', '2022-02-15 11:34:17', '2022-02-15 11:34:17', 1, 1),
(5, 'Manage Entry', '2022-02-15 11:35:47', '2022-02-15 11:35:47', 1, 1),
(6, 'Manage Locations', '2022-02-15 11:35:47', '2022-02-15 11:35:47', 1, 1),
(7, 'Manage Roles', '2022-02-15 11:36:35', '2022-02-15 11:36:35', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `unmatched`
--

CREATE TABLE `unmatched` (
  `id` int(11) NOT NULL,
  `vehicle_no` varchar(50) NOT NULL,
  `vehicle_images` varchar(255) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
