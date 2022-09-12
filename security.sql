-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2022 at 08:20 AM
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
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(100) NOT NULL,
  `shift_id` int(10) NOT NULL,
  `location_id` varchar(100) NOT NULL,
  `geo_location` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `date_time` datetime NOT NULL,
  `status` int(10) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `shift_id`, `location_id`, `geo_location`, `photo`, `date_time`, `status`, `Created_at`, `Updated_at`) VALUES
(8, 47, 8, '61c1bb102c679d1f3e946011', '5423758934279082390/4238423648923', NULL, '2022-05-23 15:16:35', 0, '2022-05-25 09:46:35', '2022-05-25 09:46:35'),
(9, 45, 8, '61c1bb102c679d1f3e946011', '5423758934279082390/4238423648923', NULL, '2022-05-24 18:32:44', 0, '2022-05-25 13:02:44', '2022-05-25 13:02:44'),
(11, 45, 8, '61c1bb102c679d1f3e946011', '5423758934279082390/4238423648923', NULL, '2022-05-26 18:32:44', 0, '2022-05-25 13:02:44', '2022-05-25 13:02:44'),
(12, 47, 8, '61c1bb102c679d1f3e946011', '5423758934279082390/4238423648923', NULL, '2022-05-26 18:32:44', 0, '2022-05-25 13:02:44', '2022-05-25 13:02:44'),
(13, 47, 8, '61c1bb102c679d1f3e946011', '5423758934279082390/4238423648923', NULL, '2022-05-27 18:32:44', 0, '2022-05-25 13:02:44', '2022-05-25 13:02:44'),
(14, 47, 7, '61c1bb102c679d1f3e946011', '5423758934279082390/4238423648923', NULL, '2022-05-27 18:32:44', 0, '2022-05-25 13:02:44', '2022-05-25 13:02:44');

-- --------------------------------------------------------

--
-- Table structure for table `block_list`
--

CREATE TABLE `block_list` (
  `id` int(11) NOT NULL,
  `vehicle_no` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `date_time` datetime NOT NULL,
  `created_by` int(100) NOT NULL,
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `camera`
--

CREATE TABLE `camera` (
  `id` int(11) NOT NULL,
  `feed_id` varchar(100) NOT NULL,
  `feed_name` varchar(100) NOT NULL,
  `location_id` varchar(100) NOT NULL,
  `gateway_id` varchar(100) NOT NULL,
  `audio` varchar(10) NOT NULL,
  `recording` varchar(200) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `camera`
--

INSERT INTO `camera` (`id`, `feed_id`, `feed_name`, `location_id`, `gateway_id`, `audio`, `recording`, `Created_at`, `Updated_at`) VALUES
(1, '61c40e032c679d1f3e96a72e', 'Entry Camera', '61c1bb102c679d1f3e946011', '61c1bb2c2c679d1f3e946025', '0', '{\"mode\":\"manual\",\"days\":0,\"status\":true,\"schedule\":[]}', '2022-04-05 06:58:55', '2022-06-14 05:16:34'),
(2, '61c40e402c679d1f3e96a79a', 'Exit Camera', '61c1bb102c679d1f3e946011', '61c1bb632c679d1f3e94604c', '0', '{\"mode\":\"manual\",\"days\":0,\"status\":false,\"schedule\":[]}', '2022-04-05 07:00:38', '2022-04-05 07:00:38'),
(40, '61b2f51f2c679d1f3e811923', 'Entry Camera', '625d697b540f6015daf77f3f', '61af1efb2c679d1f3e52aa7c', '0', '{\"mode\":\"manual\",\"days\":0,\"status\":false,\"schedule\":[]}', '2022-04-19 09:10:30', '2022-04-19 09:10:30'),
(41, '61b2e8112c679d1f3e80d05a', 'Exit Camera', '625d697b540f6015daf77f3f', '61b1c27d2c679d1f3e7a7b02', '0', '{\"mode\":\"manual\",\"days\":0,\"status\":true,\"schedule\":[]}', '2022-04-19 09:10:31', '2022-04-19 09:10:31'),
(42, '61b2e8112c679d1f3e80d0', 'Entry Camera', 'SD686S5A565', '61b1c27d2c679d1f3e7a7b0', '0', '{\"mode\":\"manual\",\"days\":0,\"status\":true,\"schedule\":[]}', '2022-04-19 09:10:31', '2022-04-19 09:10:31'),
(43, '61b2e8112c679d1f3e80d1', 'Exit Camera', 'SD686S5A565', '61b1c27d2c679d1f3e7a7b0', '0', '{\"mode\":\"manual\",\"days\":0,\"status\":true,\"schedule\":[]}', '2022-04-19 08:29:31', '2022-04-19 09:10:31');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `admin_id` int(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mobile` varchar(12) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `token` varchar(1000) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`, `admin_id`, `email`, `mobile`, `address`, `token`, `status`, `Created_at`, `Updated_at`) VALUES
(2, 'The Brownstone', 47, 'brown@gmail.com', '7878852966', 'singapore', '17a0a2daa7f9b2c9c9b62365960877cc3b8026f02591d146001ea97cbd3b868f243c882f57796e96b0305917ddbaa656ee70fb61da87c37e13c01717bf23463394ea6721b15805d6bf3a1a38208d3304a56ae44596fee95dfcbbdeb32f0b0e0af32c1ab60818e1681cb2984403f4c7a4c45f7ae042d0cae47b0551066cb2412cb540ae6e36a71fee6dff6f5d6a25223ca47a57370b4af19e75aa3212fd4447eb9603e439718d729766a9a67714624080dff7cc3e9296cf296588c838f7187ca7811fb380006f3a8561edf6e5b6d5533f4a04f010abe1ba4e1968001cd0b93c1bfa758f7da2f5841edc297a428d45b6d503604d422795b7938211b5c0cfd8b45b', 0, '2022-04-08 12:26:48', '2022-04-29 00:40:50'),
(27, 'LPR', NULL, 'lpr@gmail.com', '7878852960', 'singapore', '04d854693d4ec24639d3af8d10ae7bd99ea8abac4c272fb3e21fc1a0c4bb6f651ce0404ea6b7c8e6f0b1f8a9d198a1025bfb1f620d63b29eb02459378a2edeb6e7601777a25e0945a48607e35e0585799e8bad177cdf35a98e4d599cfe59bdc815386f678da5794a0c8cb47a0478006374abce701259a80a0d09be32b5347a28ce6f5a93b09db9daeae79cbde84a9b24b91a5ba8ed9c84a68b340e237816a6ed218dc4d758bd25a22b9d51b89ff33c79626fd45293a6f3e94c1faa3afe8e944518f03bd05b2fb9c0019b54744802c7c1c53e81f89fee940d0f499a9ccc818a96e9ae4ce15f19351f0b4514aa340eeeb743546201fd49ad01ab19222d3d689890', 0, '2022-04-08 08:49:38', '2022-04-08 08:49:38'),
(69, 'Rivervale', NULL, 'lpor@gmail.com', '7878852910', 'singapore', 'b27db9f67cdb6282af5f486c89ff1f418885ed0ed485502adfeae11aa314f6f8c6e2637272c2b8ed67a412e8a561d4baf9f2f3382ca97f828753ce766b640295dc87ecefac1778acd5c124fe560689cfba969fd4ba6fe78d61536fe72ebcd624bd5e80efd166ec8c75bb541417701225cd8d9bcf2fa7ba28e7cf006806ddab2af9825c7c1031bdf716b84e7e932207c051db7ed3a5d1d6c1ca48a9a555c1a0b8eb345492c53b52f8a8ddaf937fb14507aeea4ae64119005facea0669f0a7a2b7e6bb7a63ed2040db29d60d95d17a3bab6aab3d195b82158760b904317135e83c8ddb662a3349b655335737888d5720cb734494edffaef728e0dc6d5e75f4a4d8', 0, '2022-04-19 09:10:26', '2022-04-19 09:10:26'),
(70, 'Trichy Location', NULL, 'trichy@gmail.com', '7878852989', 'singapore', 'b27db9f67cdb6282af5f486c89ff1f418885e', 0, '2022-04-19 09:10:26', '2022-04-19 09:10:26');

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
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `user_id`, `first_name`, `last_name`, `email`, `email_verified_at`, `photo`, `phone`, `remember_token`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 1, 'Nithik', 'Mathivanan', 'nithiknike@gmail.com', '2022-02-09 13:04:30', NULL, '7373852811', NULL, '2022-02-09 13:05:33', '2022-02-18 13:05:37', 0),
(3, 9, 'Priyanka', 'kaalimuthu', 'prinku@gmail.com', NULL, NULL, '9292856711', NULL, '2022-02-17 14:08:52', '2022-06-27 01:22:58', 0),
(5, 12, 'Mullai', NULL, NULL, NULL, NULL, NULL, NULL, '2022-02-18 02:31:05', '2022-02-23 01:36:01', 0),
(6, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-02-18 02:42:28', '2022-02-18 02:42:28', 0),
(9, 18, 'vargeesh', 'raja', 'vargeesh@gmail.com', NULL, NULL, '9788514142', NULL, '2022-03-28 05:32:28', '2022-03-28 05:32:28', 0),
(10, 19, 'mullai', 'nadhan', 'mullai@gmail.com', NULL, NULL, '9788114142', NULL, '2022-03-29 01:08:05', '2022-03-29 01:08:05', 0),
(11, 21, 'karthik', 'venugopalan', 'karthik@gmail.com', NULL, '2022_04_08_10_56_06_WhatsApp Image 2021-12-27 at 12.11.40 PM (1).jpeg', '7878412366', NULL, '2022-04-08 05:19:47', '2022-04-08 05:26:06', 0),
(35, 45, 'Kathir', 'kaalimuthu', 'csea201115@gmail.com', NULL, NULL, '7878852966', NULL, '2022-04-28 14:40:42', '2022-06-27 01:27:27', 0),
(37, 47, 'kathir', 'venkatachalam', 'syed@techcmantix.com', NULL, NULL, '7878852961', NULL, '2022-04-29 00:40:50', '2022-04-29 00:40:50', 0),
(45, 55, 'jai', 'aakash', 'jai@gmail.com', NULL, NULL, '88801236987', NULL, '2022-05-30 07:04:44', '2022-05-30 07:04:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `entry`
--

CREATE TABLE `entry` (
  `id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `location_id` varchar(100) NOT NULL,
  `in_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `ic_number` varchar(50) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `unit_no` varchar(100) DEFAULT NULL,
  `capture_image` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `person_count` int(11) DEFAULT NULL,
  `visit_reason` varchar(255) NOT NULL,
  `delay_reason` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `entry_feed` int(11) DEFAULT NULL,
  `entry_type` int(10) NOT NULL DEFAULT 1,
  `exit_feed` int(11) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entry`
--

INSERT INTO `entry` (`id`, `visitor_id`, `location_id`, `in_time`, `out_time`, `ic_number`, `contact_person`, `unit_no`, `capture_image`, `role`, `person_count`, `visit_reason`, `delay_reason`, `created_at`, `updated_at`, `updated_by`, `created_by`, `entry_feed`, `entry_type`, `exit_feed`, `vehicle_no`, `is_deleted`) VALUES
(5, 16, '5ffd55dbc4d908074058a469', '2022-02-28 14:20:00', '2022-03-30 18:15:01', '6648785621', 'Berg', '', NULL, NULL, 2, '1', 'Traffic', '2022-03-01 11:26:24', '2022-03-30 18:15:01', 9, 9, 13, 1, 14, 'TN48CF0981', 0),
(6, 17, '5ffd55dbc4d908074058a469', '2022-03-03 09:20:00', '2022-03-03 11:10:00', '6648785621', 'Ronald', '', NULL, NULL, 2, '1', 'Traffic', '2022-03-01 11:30:26', '2022-03-01 11:30:26', 9, 9, 15, 1, 16, NULL, 0),
(7, 18, '5ffd55dbc4d908074058a469', '2022-03-03 17:00:00', '2022-03-08 04:34:41', '6648785621', 'Charles', '', NULL, NULL, 2, '1', 'Traffic', '2022-03-01 11:32:06', '2022-03-17 18:54:36', 9, 9, 17, 1, 12, NULL, 0),
(8, 19, '5ffd55dbc4d908074058a469', '2022-03-03 14:10:00', '2022-03-03 15:10:00', '6648785621', 'Jay Cutler', '', NULL, NULL, 2, '1', 'Traffic', '2022-03-01 11:49:26', '2022-03-01 11:49:26', 9, 9, 18, 1, NULL, NULL, 0),
(12, 23, '5ffd55dbc4d908074058a469', '2022-03-01 14:10:00', '2022-03-01 15:10:00', '664878566', 'bruce wayne', '', NULL, NULL, 2, '1', NULL, '2022-03-14 09:11:14', '2022-03-14 09:11:14', 9, 9, NULL, 2, NULL, NULL, 0),
(13, 24, '5ffd55dbc4d908074058a469', '2022-03-14 18:28:25', NULL, '664878566', 'Victor', '', NULL, NULL, 2, '1', 'Customer Delayed', '2022-03-14 18:28:25', '2022-03-17 20:47:53', 9, 9, 15, 1, 12, 'SGN 1000', 0),
(14, 16, '5ffd55dbc4d908074058a469', '2022-03-14 18:31:28', NULL, '4342222341', 'samule', '', NULL, NULL, 1, '2', NULL, '2022-03-14 18:31:28', '2022-03-14 18:31:28', 9, 9, 17, 1, NULL, 'SGN 1001', 0),
(16, 26, '5ffd55dbc4d908074058a469', '2022-03-14 18:34:26', '2022-03-30 18:03:07', '664878566', 'Becky', '', NULL, NULL, 2, '1', NULL, '2022-03-14 18:34:26', '2022-03-30 18:03:07', 9, 9, NULL, 2, 13, NULL, 0),
(17, 15, '5ffd55dbc4d908074058a469', '2022-03-22 22:28:55', '2022-03-23 14:08:52', '664878566', 'Victor', '', NULL, NULL, 2, '1', 'Customer Delayed', '2022-03-22 22:28:55', '2022-03-23 14:08:52', 9, 9, NULL, 2, NULL, 'TN48CF0981', 0),
(18, 24, '5ffd55dbc4d908074058a469', '2022-03-23 13:33:37', NULL, '664878566', 'Victor', '', NULL, NULL, 2, '1', 'Customer Delayed', '2022-03-23 13:33:37', '2022-03-23 13:33:37', 9, 9, NULL, 2, NULL, 'SGN 1000', 0),
(19, 15, '5ffd55dbc4d908074058a469', '2022-03-23 13:35:13', '2022-03-23 14:00:02', '664878566', 'Becky', '', NULL, NULL, 2, '1', NULL, '2022-03-23 13:35:13', '2022-03-23 14:00:02', 9, 9, NULL, 2, NULL, 'TN48CF0981', 0),
(21, 29, '5ffd55dbc4d908074058a469', '2022-03-30 14:04:19', NULL, '664878566', 'Rossie', NULL, '2022_03_30_06_04_19_military-officer-attention-position-full-length-image-army-man-standing-44818877.jpg', NULL, 2, '1', NULL, '2022-03-30 14:04:19', '2022-03-30 14:04:19', 19, 19, NULL, 2, NULL, 'TN22CF2211', 0),
(22, 29, '5ffd55dbc4d908074058a469', '2022-03-30 15:39:25', NULL, '664878566', 'Rossie', NULL, '416935.jpg', NULL, 2, '1', NULL, '2022-03-30 15:39:25', '2022-03-30 15:39:25', 19, 19, NULL, 2, NULL, 'TN22CF2211', 0),
(23, 29, '5ffd55dbc4d908074058a469', '2022-04-30 15:41:21', NULL, '664878566', 'Rossie', NULL, '395071.jpg', NULL, 2, '1', NULL, '2022-03-30 15:41:21', '2022-03-30 15:41:21', 19, 19, NULL, 2, NULL, 'TN22CF2211', 0),
(24, 17, '5ffd55dbc4d908074058a469', '2022-05-01 15:41:21', NULL, '664878566', 'triple H', NULL, NULL, NULL, 2, '1', NULL, '2022-03-31 21:47:49', '2022-03-31 21:47:49', 19, 19, NULL, 2, NULL, 'TN22CF2211', 0),
(25, 17, '5ffd55dbc4d908074058a469', '2022-05-02 15:41:21', NULL, '664878566', 'triple H', NULL, NULL, NULL, 2, '1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 19, 19, 30, 2, 31, 'TN22CF2211', 0),
(198, 16, '5ffd55dbc4d908074058a469', '2022-05-03 15:41:21', NULL, '664878566', 'Becky', NULL, NULL, NULL, 2, '1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 19, 19, 30, 2, 31, 'TN22CF6618', 0);

-- --------------------------------------------------------

--
-- Table structure for table `entry_local`
--

CREATE TABLE `entry_local` (
  `id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `location_id` varchar(100) NOT NULL,
  `in_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `ic_number` varchar(50) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `unit_no` varchar(100) DEFAULT NULL,
  `capture_image` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `person_count` int(11) DEFAULT NULL,
  `visit_reason` varchar(255) NOT NULL,
  `delay_reason` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `entry_feed` int(11) DEFAULT NULL,
  `entry_type` int(10) NOT NULL DEFAULT 1,
  `exit_feed` int(11) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entry_local`
--

INSERT INTO `entry_local` (`id`, `visitor_id`, `location_id`, `in_time`, `out_time`, `ic_number`, `contact_person`, `unit_no`, `capture_image`, `role`, `person_count`, `visit_reason`, `delay_reason`, `created_at`, `updated_at`, `updated_by`, `created_by`, `entry_feed`, `entry_type`, `exit_feed`, `vehicle_no`, `is_deleted`) VALUES
(5, 16, '5ffd55dbc4d908074058a469', '2022-02-28 14:20:00', '2022-03-30 18:15:01', '6648785621', 'Berg', '', NULL, NULL, 2, '1', 'Traffic', '2022-03-01 11:26:24', '2022-03-30 18:15:01', 9, 9, 13, 1, 14, 'TN48CF0981', 0),
(6, 17, '5ffd55dbc4d908074058a469', '2022-03-03 09:20:00', '2022-03-03 11:10:00', '6648785621', 'Ronald', '', NULL, NULL, 2, '1', 'Traffic', '2022-03-01 11:30:26', '2022-03-01 11:30:26', 9, 9, 15, 1, 16, NULL, 0),
(7, 18, '5ffd55dbc4d908074058a469', '2022-03-03 17:00:00', '2022-03-08 04:34:41', '6648785621', 'Charles', '', NULL, NULL, 2, '1', 'Traffic', '2022-03-01 11:32:06', '2022-03-17 18:54:36', 9, 9, 17, 1, 12, NULL, 0),
(8, 19, '5ffd55dbc4d908074058a469', '2022-03-03 14:10:00', '2022-03-03 15:10:00', '6648785621', 'Jay Cutler', '', NULL, NULL, 2, '1', 'Traffic', '2022-03-01 11:49:26', '2022-03-01 11:49:26', 9, 9, 18, 1, NULL, NULL, 0),
(12, 23, '5ffd55dbc4d908074058a469', '2022-03-01 14:10:00', '2022-03-01 15:10:00', '664878566', 'bruce wayne', '', NULL, NULL, 2, '1', NULL, '2022-03-14 09:11:14', '2022-03-14 09:11:14', 9, 9, NULL, 2, NULL, NULL, 0),
(13, 24, '5ffd55dbc4d908074058a469', '2022-03-14 18:28:25', NULL, '664878566', 'Victor', '', NULL, NULL, 2, '1', 'Customer Delayed', '2022-03-14 18:28:25', '2022-03-17 20:47:53', 9, 9, 15, 1, 12, 'SGN 1000', 0),
(14, 16, '5ffd55dbc4d908074058a469', '2022-03-14 18:31:28', NULL, '4342222341', 'samule', '', NULL, NULL, 1, '2', NULL, '2022-03-14 18:31:28', '2022-03-14 18:31:28', 9, 9, 17, 1, NULL, 'SGN 1001', 0),
(16, 26, '5ffd55dbc4d908074058a469', '2022-03-14 18:34:26', '2022-03-30 18:03:07', '664878566', 'Becky', '', NULL, NULL, 2, '1', NULL, '2022-03-14 18:34:26', '2022-03-30 18:03:07', 9, 9, NULL, 2, 13, NULL, 0),
(17, 15, '5ffd55dbc4d908074058a469', '2022-03-22 22:28:55', '2022-03-23 14:08:52', '664878566', 'Victor', '', NULL, NULL, 2, '1', 'Customer Delayed', '2022-03-22 22:28:55', '2022-03-23 14:08:52', 9, 9, NULL, 2, NULL, 'TN48CF0981', 0),
(18, 24, '5ffd55dbc4d908074058a469', '2022-03-23 13:33:37', NULL, '664878566', 'Victor', '', NULL, NULL, 2, '1', 'Customer Delayed', '2022-03-23 13:33:37', '2022-03-23 13:33:37', 9, 9, NULL, 2, NULL, 'SGN 1000', 0),
(19, 15, '5ffd55dbc4d908074058a469', '2022-03-23 13:35:13', '2022-03-23 14:00:02', '664878566', 'Becky', '', NULL, NULL, 2, '1', NULL, '2022-03-23 13:35:13', '2022-03-23 14:00:02', 9, 9, NULL, 2, NULL, 'TN48CF0981', 0),
(21, 29, '5ffd55dbc4d908074058a469', '2022-03-30 14:04:19', NULL, '664878566', 'Rossie', NULL, '2022_03_30_06_04_19_military-officer-attention-position-full-length-image-army-man-standing-44818877.jpg', NULL, 2, '1', NULL, '2022-03-30 14:04:19', '2022-03-30 14:04:19', 19, 19, NULL, 2, NULL, 'TN22CF2211', 0),
(22, 29, '5ffd55dbc4d908074058a469', '2022-03-30 15:39:25', NULL, '664878566', 'Rossie', NULL, '416935.jpg', NULL, 2, '1', NULL, '2022-03-30 15:39:25', '2022-03-30 15:39:25', 19, 19, NULL, 2, NULL, 'TN22CF2211', 0),
(23, 29, '5ffd55dbc4d908074058a469', '2022-04-30 15:41:21', NULL, '664878566', 'Rossie', NULL, '395071.jpg', NULL, 2, '1', NULL, '2022-03-30 15:41:21', '2022-03-30 15:41:21', 19, 19, NULL, 2, NULL, 'TN22CF2211', 0),
(24, 17, '5ffd55dbc4d908074058a469', '2022-05-01 15:41:21', NULL, '664878566', 'triple H', NULL, NULL, NULL, 2, '1', NULL, '2022-03-31 21:47:49', '2022-03-31 21:47:49', 19, 19, NULL, 2, NULL, 'TN22CF2211', 0),
(25, 17, '5ffd55dbc4d908074058a469', '2022-05-02 15:41:21', NULL, '664878566', 'triple H', NULL, NULL, NULL, 2, '1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 19, 19, 30, 2, 31, 'TN22CF2211', 0);

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
  `feed_id` varchar(1000) NOT NULL,
  `feed_name` varchar(255) NOT NULL,
  `images` varchar(1000) DEFAULT NULL,
  `license_plate_number` varchar(255) DEFAULT NULL,
  `location_id` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `object_classification` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `time_zone` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `ui_type` varchar(255) DEFAULT NULL,
  `from_host` varchar(100) DEFAULT NULL,
  `from_host_ip` varchar(100) DEFAULT NULL,
  `auth_type` varchar(100) DEFAULT NULL,
  `auth_params_addTo` varchar(100) DEFAULT NULL,
  `_id` varchar(100) DEFAULT NULL,
  `clips` varchar(100) DEFAULT NULL,
  `mapped_to_entry` int(10) NOT NULL DEFAULT 0,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`id`, `feed_id`, `feed_name`, `images`, `license_plate_number`, `location_id`, `location_name`, `object_classification`, `time`, `date_time`, `time_zone`, `type`, `ui_type`, `from_host`, `from_host_ip`, `auth_type`, `auth_params_addTo`, `_id`, `clips`, `mapped_to_entry`, `Created_at`, `Updated_at`) VALUES
(12, '61adf3402c679d1f3e3dcb1d', 'Exit Camera', 'image0_6221a0b3f9daac7c430a3fa9', 'SGN 1000', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', NULL, 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d10bf9daac7c4309f77a', NULL, 34, '2022-03-01 05:46:27', '2022-03-17 15:17:53'),
(13, '61adf3402c679d1f3e3dcb7c', 'Entry Camera', 'image0_6221a0c7f9daac7c430a3faa', 'TN48CF0982', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', NULL, 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d193f9daac7c4309f782', NULL, 0, '2022-03-01 05:47:06', '2022-03-30 12:33:08'),
(14, '5ffe7588c4d90807406042d4', 'Exit Camera', 'image0_6221a0caf9daac7c430a3fab', 'TN48CF0981', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', NULL, 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d1c6f9daac7c4309f787', NULL, 5, '2022-03-01 05:47:34', '2022-03-30 12:45:01'),
(15, '61adf3402c679d1f3e3dcb7c', 'Entry Camera', 'image0_6221a0caf9daac7c430a3fac', 'SGN 01211', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', NULL, 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d1f0f9daac7c4309f78c', NULL, 1, '2022-03-01 05:48:03', '2022-03-01 05:48:03'),
(16, '5ffe7588c4d90807406042d4', 'Exit Camera', 'image0_6221a0d3f9daac7c430a3fad', 'SGN 01211', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', NULL, 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d1fff9daac7c4309f78d', NULL, 0, '2022-03-01 05:48:35', '2022-03-17 02:52:35'),
(17, '61adf3402c679d1f3e3dcb7c', 'Entry Camera', 'image0_6221a0d5f9daac7c430a3fae', 'SGN 1000', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', NULL, 'Asia/Singapore', 'traffic', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d225f9daac7c4309f78e', NULL, 0, '2022-03-01 05:49:05', '2022-03-01 05:49:05'),
(18, '61adf3402c679d1f3e312cb7c', 'Entry Camera', 'image0_6221a0e5f9daac7c430a3faf', NULL, '5ffd55dbc4d1108074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', NULL, 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d225f9daac7c4309f7112', NULL, 0, '2022-03-01 06:15:51', '2022-03-01 06:15:51'),
(29, '61b2f51f2c679d1f3e811923', 'Entry Camera', 'image0_6221a0e5f9daac7c430a3faf', NULL, '625d697b540f6015daf77f3f', 'The Rivervale', 'LPR, p:0.0%', '1645859079190', NULL, 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d225f9daac7c4309f7112', NULL, 0, '2022-03-01 06:15:51', '2022-03-01 06:15:51'),
(30, '61b2f51f2c679d1f3e811923', 'Entry Camera', 'image0_6221a0e5f9daac7c430a3faf', NULL, '5ffd55dbc4d908074058a469', 'The Rivervale', 'LPR, p:0.0%', '1645859079190', NULL, 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d225f9daac7c4309f7112', NULL, 25, '2022-03-01 06:15:51', '2022-03-01 06:15:51'),
(31, '5ffe7588c4d90807406042d4', 'Exit Camera', 'image0_6221a0d3f9daac7c430a3fad', 'SGN 01211', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', NULL, 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d1fff9daac7c4309f78d', NULL, 25, '2022-03-01 05:48:35', '2022-03-17 02:52:35'),
(32, '61b2f51f2c679d1f3e811923', 'Entry Camera', 'image0_6221a0e5f9daac7c430a3faf', 'TN45CF6618', '5ffd55dbc4d908074058a469', 'The Rivervale', 'LPR, p:0.0%', '1645859079190', NULL, 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d225f9daac7c4309f7112', NULL, 25, '2022-03-01 06:15:51', '2022-03-01 06:15:51'),
(33, '5ffe7588c4d90807406042d4', 'Exit Camera', 'image0_6221a0d3f9daac7c430a3fad', 'TN45CF6618', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', NULL, 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d1fff9daac7c4309f78d', NULL, 25, '2022-03-01 05:48:35', '2022-03-17 02:52:35'),
(34, '61adf34023Ac679d1f3e312cb121', 'Entry Camera', NULL, NULL, '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079192', '2022-02-26 15:04:39', 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d225f9daac7c419f711123', NULL, 0, '2022-08-04 05:46:36', '2022-08-04 05:46:36'),
(35, '61adf34023Ac679d1f3e312cb121', 'Entry Camera', NULL, NULL, '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079192', '2022-02-26 15:04:39', 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d225f9daac7c419f711123', NULL, 0, '2022-08-04 07:44:15', '2022-08-04 07:44:15'),
(36, '61b2e8112c679d1f3e80d0', 'Entry Camera', NULL, NULL, 'SD686S5A565', 'Trichy', 'LPR, p:0.0%', '1645859079192', '2022-02-26 15:04:39', 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d225f9daac7c419f711123', NULL, 0, '2022-08-04 08:17:12', '2022-08-04 08:17:12');

-- --------------------------------------------------------

--
-- Table structure for table `feed_cloud`
--

CREATE TABLE `feed_cloud` (
  `id` int(11) NOT NULL,
  `feed_id` varchar(1000) NOT NULL,
  `feed_name` varchar(255) NOT NULL,
  `images` varchar(1000) DEFAULT NULL,
  `license_plate_number` varchar(255) DEFAULT NULL,
  `location_id` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `object_classification` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `time_zone` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `ui_type` varchar(255) DEFAULT NULL,
  `from_host` varchar(100) DEFAULT NULL,
  `from_host_ip` varchar(100) DEFAULT NULL,
  `auth_type` varchar(100) DEFAULT NULL,
  `auth_params_addTo` varchar(100) DEFAULT NULL,
  `_id` varchar(100) DEFAULT NULL,
  `clips` varchar(100) DEFAULT NULL,
  `mapped_to_entry` int(10) NOT NULL DEFAULT 0,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feed_cloud`
--

INSERT INTO `feed_cloud` (`id`, `feed_id`, `feed_name`, `images`, `license_plate_number`, `location_id`, `location_name`, `object_classification`, `time`, `date_time`, `time_zone`, `type`, `ui_type`, `from_host`, `from_host_ip`, `auth_type`, `auth_params_addTo`, `_id`, `clips`, `mapped_to_entry`, `Created_at`, `Updated_at`) VALUES
(12, '61adf3402c679d1f3e3dcb1d', 'Exit Camera', 'image0_6221a0b3f9daac7c430a3fa9', 'SGN 1000', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', '2022-07-13 11:16:27', 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d10bf9daac7c4309f77a', NULL, 34, '2022-03-01 05:46:27', '2022-03-17 15:17:53'),
(13, '61adf3402c679d1f3e3dcb7c', 'Entry Camera', 'image0_6221a0c7f9daac7c430a3faa', 'TN48CF0982', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', '2022-07-13 11:16:27', 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d193f9daac7c4309f782', NULL, 0, '2022-03-01 05:47:06', '2022-03-30 12:33:08'),
(14, '5ffe7588c4d90807406042d4', 'Exit Camera', 'image0_6221a0caf9daac7c430a3fab', 'TN48CF0981', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', '2022-07-13 12:16:27', 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d1c6f9daac7c4309f787', NULL, 5, '2022-03-01 05:47:34', '2022-03-30 12:45:01'),
(15, '61adf3402c679d1f3e3dcb7c', 'Entry Camera', 'image0_6221a0caf9daac7c430a3fac', 'SGN 01211', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', '2022-07-13 11:16:27', 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d1f0f9daac7c4309f78c', NULL, 1, '2022-03-01 05:48:03', '2022-03-01 05:48:03'),
(16, '5ffe7588c4d90807406042d4', 'Exit Camera', 'image0_6221a0d3f9daac7c430a3fad', 'SGN 01211', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', '2022-07-13 11:16:27', 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d1fff9daac7c4309f78d', NULL, 0, '2022-03-01 05:48:35', '2022-03-17 02:52:35'),
(17, '61adf3402c679d1f3e3dcb7c', 'Entry Camera', 'image0_6221a0d5f9daac7c430a3fae', 'SGN 1000', '5ffd55dbc4d908074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', '2022-07-13 14:16:27', 'Asia/Singapore', 'traffic', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d225f9daac7c4309f78e', NULL, 0, '2022-03-01 05:49:05', '2022-03-01 05:49:05'),
(18, '61adf3402c679d1f3e312cb7c', 'Entry Camera', 'image0_6221a0e5f9daac7c430a3faf', NULL, '5ffd55dbc4d1108074058a469', 'LPR Testing', 'LPR, p:0.0%', '1645859079190', '2022-07-13 15:16:27', 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d225f9daac7c4309f7112', NULL, 0, '2022-03-01 06:15:51', '2022-03-01 06:15:51'),
(29, '61b2f51f2c679d1f3e811923', 'Entry Camera', 'image0_6221a0e5f9daac7c430a3faf', NULL, '625d697b540f6015daf77f3f', 'The Rivervale', 'LPR, p:0.0%', '1645859079190', '2022-07-13 18:16:27', 'Asia/Singapore', 'license_plate', 'license_plate', 'spectramsg1.duranc.com', '51.152.239.160', 'no_auth', 'heades', '6219d225f9daac7c4309f7112', NULL, 0, '2022-03-01 06:15:51', '2022-03-01 06:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `feed_interval`
--

CREATE TABLE `feed_interval` (
  `id` int(11) NOT NULL,
  `location_id` varchar(50) NOT NULL,
  `feed_interval` int(50) NOT NULL COMMENT 'in seconds',
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `feed_json`
--

CREATE TABLE `feed_json` (
  `id` int(11) NOT NULL,
  `feed_id` varchar(255) NOT NULL,
  `json` varchar(10000) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feed_json`
--

INSERT INTO `feed_json` (`id`, `feed_id`, `json`, `Created_at`, `Updated_at`) VALUES
(2, '61adf3402c679d1f3e3dcb7c', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"52.152.239.161\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"header\",\"_id\":\"6219d10bf9daac7c4309f77a\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf3402c679d1f3e3dcb7c\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d908074058a469\",\"locationName\":\"LPR Testing\",\"license_plate_number\":null,\"timezone\":\"Asia\\/Singapore\",\"clips\":null,\"images\":{}}', '2022-02-28 05:26:02', '2022-02-28 05:26:02'),
(3, '61adf3402c679d1f3e3dcb1d', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"52.152.239.162\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d10bf9daac7c4309f77a\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf3402c679d1f3e3dcb1d\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d908074058a4233\",\"locationName\":\"LPR Testing\",\"license_plate_number\":null,\"timezone\":\"Asia\\/Singapore\",\"clips\":null,\"images\":{}}', '2022-02-28 05:30:20', '2022-02-28 05:30:20'),
(4, '61adf3402c679d1f3e3dcb1d', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d10bf9daac7c4309f77a\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf3402c679d1f3e3dcb1d\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d908074058a4233\",\"locationName\":\"LPR Testing\",\"license_plate_number\":null,\"timezone\":\"Asia\\/Singapore\",\"clips\":null,\"images\":{}}', '2022-03-01 05:16:38', '2022-03-01 05:16:38'),
(5, '61adf3402c679d1f3e3dcb1d', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d10bf9daac7c4309f77a\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf3402c679d1f3e3dcb1d\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d908074058a469\",\"locationName\":\"LPR Testing\",\"license_plate_number\":null,\"timezone\":\"Asia\\/Singapore\",\"clips\":null,\"images\":{}}', '2022-03-01 05:46:27', '2022-03-01 05:46:27'),
(6, '61adf3402c679d1f3e3dcb7c', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d193f9daac7c4309f782\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf3402c679d1f3e3dcb7c\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d908074058a469\",\"locationName\":\"LPR Testing\",\"license_plate_number\":null,\"timezone\":\"Asia\\/Singapore\",\"clips\":null,\"images\":{}}', '2022-03-01 05:47:06', '2022-03-01 05:47:06'),
(7, '5ffe7588c4d90807406042d4', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d1c6f9daac7c4309f787\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"5ffe7588c4d90807406042d4\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d908074058a469\",\"locationName\":\"LPR Testing\",\"license_plate_number\":null,\"timezone\":\"Asia\\/Singapore\",\"clips\":null,\"images\":{}}', '2022-03-01 05:47:34', '2022-03-01 05:47:34'),
(8, '61adf3402c679d1f3e3dcb7c', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d1f0f9daac7c4309f78c\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf3402c679d1f3e3dcb7c\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d908074058a469\",\"locationName\":\"LPR Testing\",\"license_plate_number\":null,\"timezone\":\"Asia\\/Singapore\",\"clips\":null,\"images\":{}}', '2022-03-01 05:48:03', '2022-03-01 05:48:03'),
(9, '5ffe7588c4d90807406042d4', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d1fff9daac7c4309f78d\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"5ffe7588c4d90807406042d4\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d908074058a469\",\"locationName\":\"LPR Testing\",\"license_plate_number\":null,\"timezone\":\"Asia\\/Singapore\",\"clips\":null,\"images\":{}}', '2022-03-01 05:48:35', '2022-03-01 05:48:35'),
(10, '61adf3402c679d1f3e3dcb7c', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c4309f78e\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf3402c679d1f3e3dcb7c\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d908074058a469\",\"locationName\":\"LPR Testing\",\"license_plate_number\":null,\"timezone\":\"Asia\\/Singapore\",\"clips\":null,\"images\":{}}', '2022-03-01 05:49:05', '2022-03-01 05:49:05'),
(11, '61adf3402c679d1f3e312cb7c', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c4309f7112\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf3402c679d1f3e312cb7c\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d1108074058a469\",\"locationName\":\"LPR Testing\",\"license_plate_number\":null,\"timezone\":\"Asia\\/Singapore\",\"clips\":null,\"images\":{}}', '2022-03-01 06:15:51', '2022-03-01 06:15:51'),
(12, '61adf34023Ac679d1f3e312cb7c', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c4309f711123\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf34023Ac679d1f3e312cb7c\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d1108074890858a469\",\"locationName\":\"LPR Testing\",\"license_plate_number\":null,\"timezone\":\"Asia\\/Singapore\",\"clips\":null,\"images\":{}}', '2022-03-01 06:16:27', '2022-03-01 06:16:27'),
(13, '61adf34023Ac679d1f3e312cb121', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c419f711123\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf34023Ac679d1f3e312cb121\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d1108074890858a423\",\"locationName\":\"LPR Testing\",\"timezone\":\"Asia\\/Singapore\",\"clips\":null}', '2022-03-02 04:11:22', '2022-03-02 04:11:22'),
(14, '61adf34023Ac679d1f3e312cb121', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c419f711123\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf34023Ac679d1f3e312cb121\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d1108074890858a423\",\"locationName\":\"LPR Testing\",\"timezone\":\"Asia\\/Singapore\",\"clips\":null}', '2022-03-02 04:12:22', '2022-03-02 04:12:22'),
(15, '61adf34023Ac679d1f3e312cb121', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c419f711123\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf34023Ac679d1f3e312cb121\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d1108074890858a423\",\"locationName\":\"LPR Testing\",\"timezone\":\"Asia\\/Singapore\"}', '2022-03-02 04:18:34', '2022-03-02 04:18:34'),
(16, '61adf34023Ac679d1f3e312cb121', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c419f711123\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf34023Ac679d1f3e312cb121\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d1108074890858a423\",\"locationName\":\"LPR Testing\",\"timezone\":\"Asia\\/Singapore\"}', '2022-03-02 04:30:32', '2022-03-02 04:30:32'),
(17, '61adf34023Ac679d1f3e312cb121', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c419f711123\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf34023Ac679d1f3e312cb121\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d1108074890858a423\",\"locationName\":\"LPR Testing\",\"timezone\":\"Asia\\/Singapore\"}', '2022-03-02 04:31:40', '2022-03-02 04:31:40'),
(18, '61adf34023Ac679d1f3e312cb121', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c419f711123\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf34023Ac679d1f3e312cb121\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d1108074890858a423\",\"locationName\":\"LPR Testing\",\"timezone\":\"Asia\\/Singapore\",\"clip\":null,\"images\":{}}', '2022-03-03 09:07:12', '2022-03-03 09:07:12'),
(19, '61adf34023Ac679d1f3e312cb121', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c419f711123\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079190\",\"feedId\":\"61adf34023Ac679d1f3e312cb121\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d1108074890858a423\",\"locationName\":\"LPR Testing\",\"timezone\":\"Asia\\/Singapore\",\"clip\":null,\"images\":{}}', '2022-03-03 09:45:54', '2022-03-03 09:45:54'),
(20, '61adf34023Ac679d1f3e312cb121', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c419f711123\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079192\",\"feedId\":\"61adf34023Ac679d1f3e312cb121\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d908074058a469\",\"locationName\":\"LPR Testing\",\"timezone\":\"Asia\\/Singapore\",\"clip\":null,\"images\":{}}', '2022-08-04 05:46:36', '2022-08-04 05:46:36'),
(21, '61adf34023Ac679d1f3e312cb121', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c419f711123\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079192\",\"feedId\":\"61adf34023Ac679d1f3e312cb121\",\"feedName\":\"Entry Camera\",\"locationId\":\"5ffd55dbc4d908074058a469\",\"locationName\":\"LPR Testing\",\"timezone\":\"Asia\\/Singapore\",\"clip\":null,\"images\":{}}', '2022-08-04 07:44:15', '2022-08-04 07:44:15'),
(22, '61adf34023Ac679d1f3e312cb121', '{\"from_host\":\"spectramsg1.duranc.com\",\"from_host_ip\":\"51.152.239.160\",\"auth_type\":\"no_auth\",\"auth_params_addTo\":\"heades\",\"_id\":\"6219d225f9daac7c419f711123\",\"object_classification\":\"LPR, p:0.0%\",\"type\":\"license_plate\",\"uiType\":\"license_plate\",\"time\":\"1645859079192\",\"feedId\":\"61adf34023Ac679d1f3e312cb121\",\"feedName\":\"Entry Camera\",\"locationId\":\"SD686S5A565\",\"locationName\":\"Trichy\",\"timezone\":\"Asia\\/Singapore\",\"clip\":null,\"images\":{}}', '2022-08-04 07:47:12', '2022-08-04 07:47:12');

-- --------------------------------------------------------

--
-- Table structure for table `feed_local`
--

CREATE TABLE `feed_local` (
  `id` int(11) NOT NULL,
  `feed_id` varchar(1000) NOT NULL,
  `feed_name` varchar(255) NOT NULL,
  `images` varchar(1000) DEFAULT NULL,
  `license_plate_number` varchar(255) DEFAULT NULL,
  `location_id` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `object_classification` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `time_zone` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `ui_type` varchar(255) DEFAULT NULL,
  `from_host` varchar(100) DEFAULT NULL,
  `from_host_ip` varchar(100) DEFAULT NULL,
  `auth_type` varchar(100) DEFAULT NULL,
  `auth_params_addTo` varchar(100) DEFAULT NULL,
  `_id` varchar(100) DEFAULT NULL,
  `clips` varchar(100) DEFAULT NULL,
  `mapped_to_entry` int(10) NOT NULL DEFAULT 0,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gateway`
--

CREATE TABLE `gateway` (
  `id` int(11) NOT NULL,
  `gateway_id` varchar(50) NOT NULL,
  `gateway_name` varchar(50) NOT NULL,
  `location_id` varchar(50) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gateway`
--

INSERT INTO `gateway` (`id`, `gateway_id`, `gateway_name`, `location_id`, `Created_at`, `updated_at`) VALUES
(4, '61c1bb2c2c679d1f3e946025', 'Entry Gateway', '61c1bb102c679d1f3e946011', '2022-04-05 06:32:19', '2022-06-14 05:08:40'),
(5, '61c1bb632c679d1f3e94604c', 'Exit Gateway', '61c1bb102c679d1f3e946011', '2022-04-05 06:32:19', '2022-04-05 06:32:19'),
(54, '61af1efb2c679d1f3e52aa7c', 'Entry Gateway', '625d697b540f6015daf77f3f', '2022-04-19 09:10:29', '2022-04-19 09:10:29'),
(55, '61b1c27d2c679d1f3e7a7b02', 'Exit Gateway', '625d697b540f6015daf77f3f', '2022-04-19 09:10:29', '2022-04-19 09:10:29'),
(57, '61b1c27d2c679d1f3e7a7b0', 'Entry Gateway', 'SD686S5A565', '2022-04-19 09:10:29', '2022-04-19 09:10:29'),
(58, '61b1c27d2c679d1f3e7a7b1', 'Exit Gateway', 'SD686S5A565', '2022-04-19 09:10:29', '2022-04-19 09:10:29');

-- --------------------------------------------------------

--
-- Table structure for table `link`
--

CREATE TABLE `link` (
  `id` int(11) NOT NULL,
  `link_id` varchar(100) NOT NULL,
  `start` varchar(100) NOT NULL,
  `perpetual` varchar(10) NOT NULL,
  `feed_id` varchar(100) NOT NULL,
  `end` varchar(50) NOT NULL,
  `link` varchar(1000) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `link`
--

INSERT INTO `link` (`id`, `link_id`, `start`, `perpetual`, `feed_id`, `end`, `link`, `Created_at`, `Updated_at`) VALUES
(1, '624c73d9540f6015da7671c6', '2022-04-05T16:52:00.000Z', '1', '61c40e032c679d1f3e96a72e', '2022-04-05T16:52:33.145Z', '\"https:\\/\\/vision.spectra.com.sg\\/feed\\/embed\\/61c40e032c679d1f3e96a72e\\/?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InNoYXJlIjp7Il9pZCI6IjYyNGM3M2Q5NTQwZjYwMTVkYTc2NzFjNiIsInN0YXJ0IjoiMjAyMi0wNC0wNVQxNjo1MjowMC4wMDBaIiwiZW5kIjoiMjAyMi0wNC0wNVQxNjo1MjozMy4xNDVaIiwicGVycGV0dWFsIjp0cnVlLCJmZWVkSWQiOiI2MWM0MGUwMzJjNjc5ZDFmM2U5NmE3MmUifX0sImlhdCI6MTY0OTE3NzU2MX0.iwevS2NjTE8zmneGdzC0ncvdZdGSZStJADQsess6w88\"', '2022-04-06 01:16:16', '2022-04-06 01:16:16');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `client_id` int(10) NOT NULL,
  `location_id` varchar(50) NOT NULL,
  `location_name` varchar(50) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `street` varchar(100) NOT NULL,
  `street2` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postal` varchar(10) NOT NULL,
  `country` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_local` int(10) NOT NULL DEFAULT 0,
  `timezone` varchar(50) NOT NULL,
  `Created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `client_id`, `location_id`, `location_name`, `latitude`, `longitude`, `street`, `street2`, `city`, `state`, `postal`, `country`, `phone`, `url`, `is_local`, `timezone`, `Created_at`, `updated_at`) VALUES
(2, 2, '61c1bb102c679d1f3e946011', 'The Brownstone', '1.4458093', '103.8272035', '', '150 Canberra Dr,', 'stone', 'Singapore', '768079', 'Singapore', '7878962000', NULL, 0, 'Singapore', '2022-04-08 02:48:44', '2022-06-14 02:27:02'),
(4, 27, '5ffd55dbc4d908074058a469', 'LPR Testing', '1.3455', '103.72547', 'Condo', 'Singapore', 'Singapore', 'Singapore', '648156', 'Singapore', '', NULL, 0, 'Asia/Singapore', '2022-04-08 08:49:39', '2022-04-08 08:49:39'),
(37, 69, '625d697b540f6015daf77f3f', 'The Rivervale', '1.3807896', '103.8983277', '7 Rivervale Link, ', '', 'Singapore', 'Singapore', '545119', 'Singapore', '', NULL, 0, 'Singapore', '2022-04-19 09:10:27', '2022-04-19 09:10:27'),
(39, 70, 'SD686S5A565', 'Trichy Location', '1.3807896', '103.8983277', '7 Rivervale Link, ', '', 'Singapore', 'Singapore', '545119', 'Singapore', '', 'http://192.168.1.10/security_monitoring/api/admin/', 1, 'Singapore', '2022-04-19 09:10:27', '2022-04-19 09:10:27');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_id` int(11) NOT NULL,
  `user_type` int(10) NOT NULL DEFAULT 0,
  `client_id` int(11) DEFAULT NULL,
  `feed_type` varchar(10) NOT NULL DEFAULT 'DEFAULT',
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `location_mapped` varchar(100) DEFAULT NULL,
  `logged_location` int(10) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT '0',
  `site_code` varchar(50) DEFAULT NULL,
  `role_id` int(10) NOT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `is_deleted` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `user_type`, `client_id`, `feed_type`, `username`, `password`, `location_mapped`, `logged_location`, `created_at`, `created_by`, `updated_at`, `updated_by`, `last_login`, `status`, `site_code`, `role_id`, `otp`, `is_deleted`) VALUES
(1, 0, 2, 'DEFAULT', 'nithik', '$2y$10$XsS/XA5Qskahg.f0TXDwoefO7p/Solh29AMYCKyextdgyKE7KZJ82', NULL, NULL, '2022-02-15 11:27:21', 0, '2022-06-27 11:40:16', 0, '2022-02-15 11:27:21', '0', 'CHENNAI01', 1, '106', 0),
(9, 0, 0, 'DEFAULT', 'Priyanka', '$2y$10$9d8NbLQo4c0HKhstTHd3Lee6fzfFUX5UXu0NyQsvCry5isvHdWxKG', '1,3', NULL, '2022-02-17 19:38:52', 1, '2022-06-27 06:52:58', 1, NULL, '0', NULL, 2, NULL, 0),
(12, 0, 2, 'DEFAULT', 'Hema', '$2y$10$ufDMGr1CrHEzlz9IhKOQ8uS9oGl08qcJEkDXYGf9xlLkb3kAMd7Hy', NULL, NULL, '2022-02-18 08:01:05', 1, '2022-06-27 11:10:39', 9, NULL, '0', NULL, 1, '9516', 0),
(18, 0, 2, 'DEFAULT', 'vargeesh', '$2y$10$qMb5vAQOK4oxnQeZ4Pqr4unLjOgpGzjnxsiHrZnvPZPIi/IqSdBwK', NULL, NULL, '2022-03-28 11:02:28', 9, '2022-03-28 11:13:10', 9, NULL, '0', NULL, 1, NULL, 0),
(19, 0, 2, 'DEFAULT', 'mullai', '$2y$10$hzUtb30AOnVn4I/mAXMdCusNJr2N0zJqAhU8XH22vC9yYMb2NIou2', '3,4', NULL, '2022-03-29 06:38:05', 18, '2022-03-29 06:38:05', 18, NULL, '0', NULL, 1, NULL, 0),
(20, 0, NULL, 'DEFAULT', 'super_admin', '$2y$10$ufDMGr1CrHEzlz9IhKOQ8uS9oGl08qcJEkDXYGf9xlLkb3kAMd7Hy', NULL, NULL, '2022-04-07 10:03:40', NULL, '2022-04-07 10:03:40', 0, '2022-04-07 10:03:40', '0', NULL, 0, NULL, 0),
(45, 0, 0, 'DEFAULT', 'kathir', '$2y$10$rZzqfitVMwNk5AZ4lZ5ARO./3vRSYqnuxMS5G/JVL5sw8GIFmcIzO', '1,3', NULL, '2022-04-28 20:10:42', 20, '2022-06-27 06:57:27', 45, NULL, '0', NULL, 2, NULL, 0),
(47, 0, 2, 'DEFAULT', 'syed', '$2y$10$NNRY2kfCsy1jq/shse1gcOqpNqFrDcnH5ffFKOdWMureg8eal9Ibm', '2', NULL, '2022-04-29 06:10:50', 20, '2022-04-29 06:10:50', 20, NULL, '0', NULL, 2, NULL, 0),
(55, 1, 2, 'DEFAULT', 'Jai', '$2y$10$SlCjhWFZiz8y4gEVqqs2h.GCxDxwMOivRIFueNWy42cLYg2LVMHwq', '2,4', NULL, '2022-05-30 12:34:44', 20, '2022-05-30 12:34:44', 20, NULL, '0', NULL, 2, NULL, 0);

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
-- Table structure for table `purpose`
--

CREATE TABLE `purpose` (
  `purpose_id` int(11) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `minutes` varchar(10) DEFAULT NULL,
  `is_deleted` int(10) NOT NULL DEFAULT 0,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purpose`
--

INSERT INTO `purpose` (`purpose_id`, `purpose`, `minutes`, `is_deleted`, `Created_at`, `Updated_at`) VALUES
(1, 'Visitor', '120', 0, '2022-02-21 05:43:17', '2022-02-21 05:43:17'),
(2, 'Delivery', '30', 0, '2022-02-21 05:49:07', '2022-02-21 05:49:07'),
(3, 'Contractor', '60', 0, '2022-03-30 08:09:29', '2022-03-30 08:09:29'),
(4, 'Other', '60', 0, '2022-03-30 08:09:29', '2022-03-30 08:09:29');

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
  `updated_at` datetime NOT NULL,
  `is_deleted` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_permission`, `total_in_hours`, `created_at`, `updated_at`, `is_deleted`) VALUES
(0, 'Super Admin', '{\"visitors\":1,\"users\":1,\"track_cctv\":1,\"manage_cctv\":1,\"entry\":1,\"locations\":1,\"roles\":1}', 8, '2022-04-07 10:06:07', '2022-04-07 10:06:07', 0),
(1, 'System Admin', '{\"visitors\":0,\"users\":0,\"track_cctv\":1,\"manage_cctv\":0,\"entry\":0,\"locations\":1,\"roles\":1}', 5, '2022-02-15 11:30:21', '2022-02-17 19:56:49', 0),
(2, 'Security Guard', '{\"visitors\":0,\"users\":0,\"track_cctv\":1,\"manage_cctv\":0,\"entry\":0,\"locations\":1,\"roles\":1}', 6, '2022-02-15 11:30:21', '2022-02-21 09:31:04', 0),
(3, 'Assistant Admin', '{\"visitors\":1,\"users\":0,\"track_cctv\":1,\"manage_cctv\":0,\"entry\":0,\"locations\":1,\"roles\":1}', 8, '2022-02-17 10:33:57', '2022-02-17 10:33:57', 0),
(4, 'Assistant Manager', '{\"visitors\":0,\"users\":0,\"track_cctv\":1,\"manage_cctv\":0,\"entry\":0,\"locations\":1,\"roles\":1}', 11, '2022-02-17 10:36:13', '2022-02-17 10:36:13', 0),
(5, 'General Manager', '{\"visitors\":0,\"users\":0,\"track_cctv\":1,\"manage_cctv\":0,\"entry\":0,\"locations\":1,\"roles\":1}', 11, '2022-02-17 11:14:32', '2022-02-17 19:58:19', 0),
(6, 'Administrator', '{\"visitors\":0,\"users\":0,\"track_cctv\":1,\"manage_cctv\":0,\"entry\":0,\"locations\":1,\"roles\":1}', 6, '2022-02-17 15:57:02', '2022-02-17 15:57:02', 0);

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
-- Table structure for table `security`
--

CREATE TABLE `security` (
  `security_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `security_code` varchar(10) DEFAULT NULL,
  `shift` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `security`
--

INSERT INTO `security` (`security_id`, `user_id`, `security_code`, `shift`, `created_at`, `updated_at`) VALUES
(3, 55, '8546', '6', '2022-05-30 07:04:44', '2022-05-31 16:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `security_setting`
--

CREATE TABLE `security_setting` (
  `id` int(11) NOT NULL,
  `user_id` int(100) NOT NULL,
  `location_id` varchar(200) NOT NULL,
  `entry_camera` varchar(200) NOT NULL,
  `exit_camera` varchar(200) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `id` int(11) NOT NULL,
  `shift_name` varchar(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `day_cross` int(11) NOT NULL DEFAULT 0,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id`, `shift_name`, `start_time`, `end_time`, `day_cross`, `Created_at`, `Updated_at`) VALUES
(6, 'Night Shift', '22:00:00', '06:00:00', 1, '2022-05-25 01:41:24', '2022-05-25 01:43:00'),
(7, 'Morning Shift', '06:00:00', '14:00:00', 0, '2022-05-25 01:43:29', '2022-05-25 01:43:29'),
(8, 'Noon Shift', '14:00:00', '22:00:00', 0, '2022-05-25 01:44:04', '2022-05-25 01:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_setting`
--

CREATE TABLE `smtp_setting` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `driver` varchar(100) NOT NULL,
  `host` varchar(100) NOT NULL,
  `port` int(100) NOT NULL,
  `encryption` int(100) NOT NULL,
  `from_address` int(100) NOT NULL,
  `from_name` int(100) NOT NULL,
  `current_active` int(10) NOT NULL DEFAULT 0,
  `Created_at` int(11) NOT NULL,
  `Updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `smtp_setting`
--

INSERT INTO `smtp_setting` (`id`, `location_id`, `email`, `password`, `driver`, `host`, `port`, `encryption`, `from_address`, `from_name`, `current_active`, `Created_at`, `Updated_at`) VALUES
(1, 0, 'nithik@techcmantix.com', 'nithikmrtom', '2022-5-31 08:16:49', '2022-5-31 08:16:49', 0, 0, 587, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `vehicle_no_1` varchar(100) DEFAULT NULL,
  `vehicle_no_2` varchar(100) DEFAULT NULL,
  `vehicle_no_3` varchar(100) DEFAULT NULL,
  `contact_no` varchar(100) NOT NULL,
  `ic_number` varchar(100) DEFAULT NULL,
  `location_id` varchar(100) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `unit_name`, `name`, `vehicle_no_1`, `vehicle_no_2`, `vehicle_no_3`, `contact_no`, `ic_number`, `location_id`, `Created_at`, `Updated_at`) VALUES
(3, '378298', 'nithik', 'TN432345', NULL, NULL, '7878963211', '43242334', '123456', '2022-05-13 02:35:49', '2022-05-13 02:35:49'),
(4, '3782981', 'kamal', 'TN4323453', NULL, NULL, '7878963212', '43242334', '123456', '2022-05-13 05:59:02', '2022-05-13 05:59:02'),
(11, '3782918', 'sathya', 'TN04398', NULL, 'TN04398', '8787654211', NULL, '61c1bb102c679d1f3e946011', '2022-05-13 14:35:10', '2022-05-13 14:35:10'),
(12, '3782980', 'dhana', 'TN043981', NULL, NULL, '8787654212', NULL, '61c1bb102c679d1f3e946011', '2022-05-13 14:35:10', '2022-05-13 14:35:10'),
(13, '3782982', 'jeyan', 'TN043981', 'TN04398', NULL, '8787654212', NULL, '61c1bb102c679d1f3e946011', '2022-05-13 14:35:10', '2022-05-13 14:35:10');

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
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `visitor_id` int(11) NOT NULL,
  `visitor_name` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_by` int(10) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`visitor_id`, `visitor_name`, `mobile`, `email`, `created_by`, `Created_at`, `Updated_at`) VALUES
(15, 'Steeven', '7373852870', NULL, 9, '2022-03-01 05:54:18', '2022-03-01 05:54:18'),
(16, 'Marcus', '7373852817', 'marcus@gmail.com', 9, '2022-03-01 05:56:24', '2022-03-01 05:56:24'),
(17, 'Stephnie', '7373852816', NULL, 9, '2022-03-01 06:00:26', '2022-03-31 08:17:49'),
(18, 'Mathew', '7373852812', NULL, 9, '2022-03-01 06:02:06', '2022-03-01 06:02:06'),
(19, 'Phil Heath', '7373854811', NULL, 9, '2022-03-01 06:19:26', '2022-03-01 06:19:26'),
(20, 'Messi', '7376854811', NULL, 9, '2022-03-04 02:46:45', '2022-03-04 02:46:45'),
(23, 'maratha', '7376854890', NULL, 9, '2022-03-14 03:41:14', '2022-03-14 03:41:14'),
(24, 'Danial', '3636852877', NULL, 9, '2022-03-14 07:28:24', '2022-03-14 07:28:24'),
(26, 'Falcon', '7476854890', NULL, 9, '2022-03-14 07:34:26', '2022-03-14 07:34:26'),
(29, 'marques', '7373852887', NULL, 19, '2022-03-30 00:34:19', '2022-03-30 00:34:19');

-- --------------------------------------------------------

--
-- Table structure for table `visitors_local`
--

CREATE TABLE `visitors_local` (
  `visitor_id` int(11) NOT NULL,
  `visitor_name` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_by` int(10) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `block_list`
--
ALTER TABLE `block_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `camera`
--
ALTER TABLE `camera`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `entry`
--
ALTER TABLE `entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entry_local`
--
ALTER TABLE `entry_local`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed_cloud`
--
ALTER TABLE `feed_cloud`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed_interval`
--
ALTER TABLE `feed_interval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed_json`
--
ALTER TABLE `feed_json`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed_local`
--
ALTER TABLE `feed_local`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway`
--
ALTER TABLE `gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link`
--
ALTER TABLE `link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`);

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
-- Indexes for table `purpose`
--
ALTER TABLE `purpose`
  ADD PRIMARY KEY (`purpose_id`);

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
-- Indexes for table `security`
--
ALTER TABLE `security`
  ADD PRIMARY KEY (`security_id`);

--
-- Indexes for table `security_setting`
--
ALTER TABLE `security_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smtp_setting`
--
ALTER TABLE `smtp_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`visitor_id`);

--
-- Indexes for table `visitors_local`
--
ALTER TABLE `visitors_local`
  ADD PRIMARY KEY (`visitor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `block_list`
--
ALTER TABLE `block_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `camera`
--
ALTER TABLE `camera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `entry`
--
ALTER TABLE `entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `entry_local`
--
ALTER TABLE `entry_local`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `feed_cloud`
--
ALTER TABLE `feed_cloud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `feed_interval`
--
ALTER TABLE `feed_interval`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feed_json`
--
ALTER TABLE `feed_json`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `feed_local`
--
ALTER TABLE `feed_local`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `gateway`
--
ALTER TABLE `gateway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `link`
--
ALTER TABLE `link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

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
-- AUTO_INCREMENT for table `purpose`
--
ALTER TABLE `purpose`
  MODIFY `purpose_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `security`
--
ALTER TABLE `security`
  MODIFY `security_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `security_setting`
--
ALTER TABLE `security_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `smtp_setting`
--
ALTER TABLE `smtp_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `visitor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `visitors_local`
--
ALTER TABLE `visitors_local`
  MODIFY `visitor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
