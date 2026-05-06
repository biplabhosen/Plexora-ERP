-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2026 at 07:21 AM
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
-- Database: `plexora`
--

-- --------------------------------------------------------

--
-- Table structure for table `automation_rules`
--

CREATE TABLE `automation_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `event` enum('order_placed','rfq_created','stock_low') NOT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `action` enum('send_email','notify_supplier','notify_admin','log_only') NOT NULL,
  `target` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `automation_rules`
--

INSERT INTO `automation_rules` (`id`, `name`, `event`, `condition`, `action`, `target`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Order placed email confirmation', 'order_placed', NULL, 'send_email', NULL, 1, '2026-05-04 22:19:09', '2026-05-04 22:19:09'),
(2, 'RFQ created supplier notification', 'rfq_created', NULL, 'notify_supplier', NULL, 1, '2026-05-04 22:19:09', '2026-05-04 22:19:09'),
(3, 'Low stock supplier notification', 'stock_low', NULL, 'notify_supplier', NULL, 1, '2026-05-04 22:19:09', '2026-05-04 22:19:09'),
(4, 'Low stock unresolved admin escalation', 'stock_low', 'unresolved_24h', 'notify_admin', NULL, 1, '2026-05-04 22:19:09', '2026-05-04 22:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('plexora-erp-cache-dashboard.admin.metrics', 'a:19:{s:11:\"totalOrders\";i:17;s:11:\"todayOrders\";i:5;s:14:\"monthlyRevenue\";s:9:\"158540.00\";s:16:\"pendingSuppliers\";i:0;s:8:\"openRfqs\";i:5;s:16:\"lowStockProducts\";i:2;s:19:\"automationRunsToday\";i:84;s:10:\"totalUsers\";i:8;s:14:\"totalCustomers\";i:5;s:11:\"openTickets\";i:4;s:18:\"scheduledCampaigns\";i:8;s:12:\"recentOrders\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:16:\"App\\Models\\Order\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"orders\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:18;s:11:\"customer_id\";i:1;s:12:\"order_number\";s:19:\"ORD-20260506-646951\";s:8:\"subtotal\";s:7:\"3750.00\";s:8:\"discount\";s:5:\"75.00\";s:3:\"tax\";s:4:\"0.00\";s:11:\"grand_total\";s:7:\"3675.00\";s:6:\"status\";s:7:\"pending\";s:5:\"notes\";N;s:10:\"created_at\";s:19:\"2026-05-06 04:44:05\";s:10:\"updated_at\";s:19:\"2026-05-06 04:44:05\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:18;s:11:\"customer_id\";i:1;s:12:\"order_number\";s:19:\"ORD-20260506-646951\";s:8:\"subtotal\";s:7:\"3750.00\";s:8:\"discount\";s:5:\"75.00\";s:3:\"tax\";s:4:\"0.00\";s:11:\"grand_total\";s:7:\"3675.00\";s:6:\"status\";s:7:\"pending\";s:5:\"notes\";N;s:10:\"created_at\";s:19:\"2026-05-06 04:44:05\";s:10:\"updated_at\";s:19:\"2026-05-06 04:44:05\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:8:\"subtotal\";s:9:\"decimal:2\";s:8:\"discount\";s:9:\"decimal:2\";s:3:\"tax\";s:9:\"decimal:2\";s:11:\"grand_total\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"customer\";O:19:\"App\\Models\\Customer\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"customers\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:7:\"Biplab \";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:7:\"Biplab \";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:7:\"user_id\";i:1;s:4:\"name\";i:2;s:5:\"email\";i:3;s:5:\"phone\";i:4;s:7:\"address\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:11:\"customer_id\";i:1;s:12:\"order_number\";i:2;s:8:\"subtotal\";i:3;s:8:\"discount\";i:4;s:3:\"tax\";i:5;s:11:\"grand_total\";i:6;s:6:\"status\";i:7;s:5:\"notes\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:16:\"App\\Models\\Order\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"orders\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:17;s:11:\"customer_id\";i:1;s:12:\"order_number\";s:19:\"ORD-20260506-070301\";s:8:\"subtotal\";s:8:\"14400.00\";s:8:\"discount\";s:6:\"720.00\";s:3:\"tax\";s:4:\"0.00\";s:11:\"grand_total\";s:8:\"13680.00\";s:6:\"status\";s:7:\"pending\";s:5:\"notes\";N;s:10:\"created_at\";s:19:\"2026-05-06 04:38:04\";s:10:\"updated_at\";s:19:\"2026-05-06 04:38:04\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:17;s:11:\"customer_id\";i:1;s:12:\"order_number\";s:19:\"ORD-20260506-070301\";s:8:\"subtotal\";s:8:\"14400.00\";s:8:\"discount\";s:6:\"720.00\";s:3:\"tax\";s:4:\"0.00\";s:11:\"grand_total\";s:8:\"13680.00\";s:6:\"status\";s:7:\"pending\";s:5:\"notes\";N;s:10:\"created_at\";s:19:\"2026-05-06 04:38:04\";s:10:\"updated_at\";s:19:\"2026-05-06 04:38:04\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:8:\"subtotal\";s:9:\"decimal:2\";s:8:\"discount\";s:9:\"decimal:2\";s:3:\"tax\";s:9:\"decimal:2\";s:11:\"grand_total\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"customer\";r:66;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:11:\"customer_id\";i:1;s:12:\"order_number\";i:2;s:8:\"subtotal\";i:3;s:8:\"discount\";i:4;s:3:\"tax\";i:5;s:11:\"grand_total\";i:6;s:6:\"status\";i:7;s:5:\"notes\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:16:\"App\\Models\\Order\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"orders\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:16;s:11:\"customer_id\";i:3;s:12:\"order_number\";s:19:\"ORD-20260506-809160\";s:8:\"subtotal\";s:8:\"93500.00\";s:8:\"discount\";s:7:\"9350.00\";s:3:\"tax\";s:4:\"0.00\";s:11:\"grand_total\";s:8:\"84150.00\";s:6:\"status\";s:7:\"pending\";s:5:\"notes\";N;s:10:\"created_at\";s:19:\"2026-05-06 04:30:28\";s:10:\"updated_at\";s:19:\"2026-05-06 04:30:28\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:16;s:11:\"customer_id\";i:3;s:12:\"order_number\";s:19:\"ORD-20260506-809160\";s:8:\"subtotal\";s:8:\"93500.00\";s:8:\"discount\";s:7:\"9350.00\";s:3:\"tax\";s:4:\"0.00\";s:11:\"grand_total\";s:8:\"84150.00\";s:6:\"status\";s:7:\"pending\";s:5:\"notes\";N;s:10:\"created_at\";s:19:\"2026-05-06 04:30:28\";s:10:\"updated_at\";s:19:\"2026-05-06 04:30:28\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:8:\"subtotal\";s:9:\"decimal:2\";s:8:\"discount\";s:9:\"decimal:2\";s:3:\"tax\";s:9:\"decimal:2\";s:11:\"grand_total\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"customer\";O:19:\"App\\Models\\Customer\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"customers\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:12:\"Mehedi Hasan\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:12:\"Mehedi Hasan\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:7:\"user_id\";i:1;s:4:\"name\";i:2;s:5:\"email\";i:3;s:5:\"phone\";i:4;s:7:\"address\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:11:\"customer_id\";i:1;s:12:\"order_number\";i:2;s:8:\"subtotal\";i:3;s:8:\"discount\";i:4;s:3:\"tax\";i:5;s:11:\"grand_total\";i:6;s:6:\"status\";i:7;s:5:\"notes\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:16:\"App\\Models\\Order\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"orders\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:15;s:11:\"customer_id\";i:1;s:12:\"order_number\";s:19:\"ORD-20260506-664784\";s:8:\"subtotal\";s:7:\"2000.00\";s:8:\"discount\";s:6:\"100.00\";s:3:\"tax\";s:4:\"0.00\";s:11:\"grand_total\";s:7:\"1900.00\";s:6:\"status\";s:7:\"pending\";s:5:\"notes\";N;s:10:\"created_at\";s:19:\"2026-05-06 04:24:31\";s:10:\"updated_at\";s:19:\"2026-05-06 04:24:31\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:15;s:11:\"customer_id\";i:1;s:12:\"order_number\";s:19:\"ORD-20260506-664784\";s:8:\"subtotal\";s:7:\"2000.00\";s:8:\"discount\";s:6:\"100.00\";s:3:\"tax\";s:4:\"0.00\";s:11:\"grand_total\";s:7:\"1900.00\";s:6:\"status\";s:7:\"pending\";s:5:\"notes\";N;s:10:\"created_at\";s:19:\"2026-05-06 04:24:31\";s:10:\"updated_at\";s:19:\"2026-05-06 04:24:31\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:8:\"subtotal\";s:9:\"decimal:2\";s:8:\"discount\";s:9:\"decimal:2\";s:3:\"tax\";s:9:\"decimal:2\";s:11:\"grand_total\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"customer\";r:66;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:11:\"customer_id\";i:1;s:12:\"order_number\";i:2;s:8:\"subtotal\";i:3;s:8:\"discount\";i:4;s:3:\"tax\";i:5;s:11:\"grand_total\";i:6;s:6:\"status\";i:7;s:5:\"notes\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:16:\"App\\Models\\Order\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"orders\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:11:{s:2:\"id\";i:14;s:11:\"customer_id\";i:4;s:12:\"order_number\";s:19:\"ORD-20260506-153352\";s:8:\"subtotal\";s:7:\"2000.00\";s:8:\"discount\";s:6:\"100.00\";s:3:\"tax\";s:4:\"0.00\";s:11:\"grand_total\";s:7:\"1900.00\";s:6:\"status\";s:7:\"pending\";s:5:\"notes\";N;s:10:\"created_at\";s:19:\"2026-05-06 01:52:27\";s:10:\"updated_at\";s:19:\"2026-05-06 01:52:27\";}s:11:\"\0*\0original\";a:11:{s:2:\"id\";i:14;s:11:\"customer_id\";i:4;s:12:\"order_number\";s:19:\"ORD-20260506-153352\";s:8:\"subtotal\";s:7:\"2000.00\";s:8:\"discount\";s:6:\"100.00\";s:3:\"tax\";s:4:\"0.00\";s:11:\"grand_total\";s:7:\"1900.00\";s:6:\"status\";s:7:\"pending\";s:5:\"notes\";N;s:10:\"created_at\";s:19:\"2026-05-06 01:52:27\";s:10:\"updated_at\";s:19:\"2026-05-06 01:52:27\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:8:\"subtotal\";s:9:\"decimal:2\";s:8:\"discount\";s:9:\"decimal:2\";s:3:\"tax\";s:9:\"decimal:2\";s:11:\"grand_total\";s:9:\"decimal:2\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"customer\";O:19:\"App\\Models\\Customer\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"customers\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:4;s:4:\"name\";s:16:\"Aman Amed Durjoy\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:4;s:4:\"name\";s:16:\"Aman Amed Durjoy\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:7:\"user_id\";i:1;s:4:\"name\";i:2;s:5:\"email\";i:3;s:5:\"phone\";i:4;s:7:\"address\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:8:{i:0;s:11:\"customer_id\";i:1;s:12:\"order_number\";i:2;s:8:\"subtotal\";i:3;s:8:\"discount\";i:4;s:3:\"tax\";i:5;s:11:\"grand_total\";i:6;s:6:\"status\";i:7;s:5:\"notes\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"recentRfqs\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:14:\"App\\Models\\Rfq\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:4:\"rfqs\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:5;s:8:\"buyer_id\";i:6;s:11:\"supplier_id\";i:3;s:5:\"title\";s:12:\"Yearly stock\";s:11:\"description\";s:28:\"100 ear buds and 300 adaptor\";s:8:\"quantity\";i:400;s:6:\"status\";s:4:\"open\";s:10:\"created_at\";s:19:\"2026-05-06 02:28:16\";s:10:\"updated_at\";s:19:\"2026-05-06 02:28:16\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:5;s:8:\"buyer_id\";i:6;s:11:\"supplier_id\";i:3;s:5:\"title\";s:12:\"Yearly stock\";s:11:\"description\";s:28:\"100 ear buds and 300 adaptor\";s:8:\"quantity\";i:400;s:6:\"status\";s:4:\"open\";s:10:\"created_at\";s:19:\"2026-05-06 02:28:16\";s:10:\"updated_at\";s:19:\"2026-05-06 02:28:16\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:8:\"quantity\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:5:\"buyer\";O:15:\"App\\Models\\User\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:6;s:4:\"name\";s:16:\"Aman Amed Durjoy\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:6;s:4:\"name\";s:16:\"Aman Amed Durjoy\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:17:\"email_verified_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:2:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:5:\"email\";i:2;s:7:\"role_id\";i:3;s:6:\"status\";i:4;s:8:\"password\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";}s:8:\"supplier\";O:19:\"App\\Models\\Supplier\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"suppliers\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:3;s:12:\"company_name\";s:9:\"Apple Inc\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:3;s:12:\"company_name\";s:9:\"Apple Inc\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:11:\"approved_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:11:{i:0;s:7:\"user_id\";i:1;s:12:\"company_name\";i:2;s:14:\"contact_person\";i:3;s:5:\"phone\";i:4;s:5:\"email\";i:5;s:7:\"address\";i:6;s:13:\"business_type\";i:7;s:13:\"trade_license\";i:8;s:6:\"status\";i:9;s:11:\"approved_by\";i:10;s:11:\"approved_at\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:8:\"buyer_id\";i:1;s:11:\"supplier_id\";i:2;s:5:\"title\";i:3;s:11:\"description\";i:4;s:8:\"quantity\";i:5;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:14:\"App\\Models\\Rfq\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:4:\"rfqs\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:4;s:8:\"buyer_id\";i:1;s:11:\"supplier_id\";i:2;s:5:\"title\";s:8:\"Test RFQ\";s:11:\"description\";s:16:\"test description\";s:8:\"quantity\";i:99;s:6:\"status\";s:4:\"open\";s:10:\"created_at\";s:19:\"2026-05-05 07:46:47\";s:10:\"updated_at\";s:19:\"2026-05-05 07:46:47\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:4;s:8:\"buyer_id\";i:1;s:11:\"supplier_id\";i:2;s:5:\"title\";s:8:\"Test RFQ\";s:11:\"description\";s:16:\"test description\";s:8:\"quantity\";i:99;s:6:\"status\";s:4:\"open\";s:10:\"created_at\";s:19:\"2026-05-05 07:46:47\";s:10:\"updated_at\";s:19:\"2026-05-05 07:46:47\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:8:\"quantity\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:5:\"buyer\";O:15:\"App\\Models\\User\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:12:\"Biplab Hosen\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:12:\"Biplab Hosen\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:17:\"email_verified_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:2:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:5:\"email\";i:2;s:7:\"role_id\";i:3;s:6:\"status\";i:4;s:8:\"password\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";}s:8:\"supplier\";O:19:\"App\\Models\\Supplier\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"suppliers\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:2;s:12:\"company_name\";s:16:\"Proxima Electric\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:2;s:12:\"company_name\";s:16:\"Proxima Electric\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:11:\"approved_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:11:{i:0;s:7:\"user_id\";i:1;s:12:\"company_name\";i:2;s:14:\"contact_person\";i:3;s:5:\"phone\";i:4;s:5:\"email\";i:5;s:7:\"address\";i:6;s:13:\"business_type\";i:7;s:13:\"trade_license\";i:8;s:6:\"status\";i:9;s:11:\"approved_by\";i:10;s:11:\"approved_at\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:8:\"buyer_id\";i:1;s:11:\"supplier_id\";i:2;s:5:\"title\";i:3;s:11:\"description\";i:4;s:8:\"quantity\";i:5;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:14:\"App\\Models\\Rfq\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:4:\"rfqs\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:3;s:8:\"buyer_id\";i:3;s:11:\"supplier_id\";i:2;s:5:\"title\";s:15:\"Electric wiring\";s:11:\"description\";s:26:\"Need 500 bulb and 500 fans\";s:8:\"quantity\";i:1000;s:6:\"status\";s:4:\"open\";s:10:\"created_at\";s:19:\"2026-05-05 06:47:55\";s:10:\"updated_at\";s:19:\"2026-05-05 06:47:55\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:3;s:8:\"buyer_id\";i:3;s:11:\"supplier_id\";i:2;s:5:\"title\";s:15:\"Electric wiring\";s:11:\"description\";s:26:\"Need 500 bulb and 500 fans\";s:8:\"quantity\";i:1000;s:6:\"status\";s:4:\"open\";s:10:\"created_at\";s:19:\"2026-05-05 06:47:55\";s:10:\"updated_at\";s:19:\"2026-05-05 06:47:55\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:8:\"quantity\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:5:\"buyer\";O:15:\"App\\Models\\User\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:12:\"Mehedi Hasan\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:12:\"Mehedi Hasan\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:17:\"email_verified_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:2:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:5:\"email\";i:2;s:7:\"role_id\";i:3;s:6:\"status\";i:4;s:8:\"password\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";}s:8:\"supplier\";r:752;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:8:\"buyer_id\";i:1;s:11:\"supplier_id\";i:2;s:5:\"title\";i:3;s:11:\"description\";i:4;s:8:\"quantity\";i:5;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:14:\"App\\Models\\Rfq\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:4:\"rfqs\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:2;s:8:\"buyer_id\";i:1;s:11:\"supplier_id\";i:2;s:5:\"title\";s:23:\"Enhance electric system\";s:11:\"description\";s:15:\"I need 100 bulb\";s:8:\"quantity\";i:100;s:6:\"status\";s:4:\"open\";s:10:\"created_at\";s:19:\"2026-05-05 05:29:58\";s:10:\"updated_at\";s:19:\"2026-05-05 05:29:58\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:2;s:8:\"buyer_id\";i:1;s:11:\"supplier_id\";i:2;s:5:\"title\";s:23:\"Enhance electric system\";s:11:\"description\";s:15:\"I need 100 bulb\";s:8:\"quantity\";i:100;s:6:\"status\";s:4:\"open\";s:10:\"created_at\";s:19:\"2026-05-05 05:29:58\";s:10:\"updated_at\";s:19:\"2026-05-05 05:29:58\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:8:\"quantity\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:5:\"buyer\";r:702;s:8:\"supplier\";r:752;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:8:\"buyer_id\";i:1;s:11:\"supplier_id\";i:2;s:5:\"title\";i:3;s:11:\"description\";i:4;s:8:\"quantity\";i:5;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:14:\"App\\Models\\Rfq\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:4:\"rfqs\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:1;s:8:\"buyer_id\";i:3;s:11:\"supplier_id\";i:3;s:5:\"title\";s:43:\"RFQ-2026-05-IT Infrastructure Modernization\";s:11:\"description\";s:45:\"I need 200 unit ear buds and 800 unit adaptor\";s:8:\"quantity\";i:1000;s:6:\"status\";s:4:\"open\";s:10:\"created_at\";s:19:\"2026-05-05 05:16:23\";s:10:\"updated_at\";s:19:\"2026-05-05 05:16:23\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:1;s:8:\"buyer_id\";i:3;s:11:\"supplier_id\";i:3;s:5:\"title\";s:43:\"RFQ-2026-05-IT Infrastructure Modernization\";s:11:\"description\";s:45:\"I need 200 unit ear buds and 800 unit adaptor\";s:8:\"quantity\";i:1000;s:6:\"status\";s:4:\"open\";s:10:\"created_at\";s:19:\"2026-05-05 05:16:23\";s:10:\"updated_at\";s:19:\"2026-05-05 05:16:23\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:8:\"quantity\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:5:\"buyer\";r:863;s:8:\"supplier\";r:591;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:8:\"buyer_id\";i:1;s:11:\"supplier_id\";i:2;s:5:\"title\";i:3;s:11:\"description\";i:4;s:8:\"quantity\";i:5;s:6:\"status\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"recentLogs\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:22:\"App\\Models\\WorkflowLog\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:13:\"workflow_logs\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:93;s:18:\"automation_rule_id\";i:3;s:5:\"event\";s:9:\"stock_low\";s:6:\"status\";s:7:\"success\";s:7:\"message\";s:581:\"{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:11:06\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:11:06\"}}}\";s:10:\"created_at\";s:19:\"2026-05-06 05:11:06\";s:10:\"updated_at\";s:19:\"2026-05-06 05:11:06\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:93;s:18:\"automation_rule_id\";i:3;s:5:\"event\";s:9:\"stock_low\";s:6:\"status\";s:7:\"success\";s:7:\"message\";s:581:\"{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:11:06\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:11:06\"}}}\";s:10:\"created_at\";s:19:\"2026-05-06 05:11:06\";s:10:\"updated_at\";s:19:\"2026-05-06 05:11:06\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:14:\"automationRule\";O:25:\"App\\Models\\AutomationRule\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"automation_rules\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:31:\"Low stock supplier notification\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:31:\"Low stock supplier notification\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:1:{s:9:\"is_active\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:4:\"name\";i:1;s:5:\"event\";i:2;s:9:\"condition\";i:3;s:6:\"action\";i:4;s:6:\"target\";i:5;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:18:\"automation_rule_id\";i:1;s:5:\"event\";i:2;s:6:\"status\";i:3;s:7:\"message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:22:\"App\\Models\\WorkflowLog\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:13:\"workflow_logs\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:92;s:18:\"automation_rule_id\";i:3;s:5:\"event\";s:9:\"stock_low\";s:6:\"status\";s:7:\"success\";s:7:\"message\";s:627:\"{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:11:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:11:04\"}}}\";s:10:\"created_at\";s:19:\"2026-05-06 05:11:04\";s:10:\"updated_at\";s:19:\"2026-05-06 05:11:04\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:92;s:18:\"automation_rule_id\";i:3;s:5:\"event\";s:9:\"stock_low\";s:6:\"status\";s:7:\"success\";s:7:\"message\";s:627:\"{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:11:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:11:04\"}}}\";s:10:\"created_at\";s:19:\"2026-05-06 05:11:04\";s:10:\"updated_at\";s:19:\"2026-05-06 05:11:04\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:14:\"automationRule\";r:1096;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:18:\"automation_rule_id\";i:1;s:5:\"event\";i:2;s:6:\"status\";i:3;s:7:\"message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:22:\"App\\Models\\WorkflowLog\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:13:\"workflow_logs\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:91;s:18:\"automation_rule_id\";i:3;s:5:\"event\";s:9:\"stock_low\";s:6:\"status\";s:7:\"success\";s:7:\"message\";s:581:\"{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:10:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:10:03\"}}}\";s:10:\"created_at\";s:19:\"2026-05-06 05:10:03\";s:10:\"updated_at\";s:19:\"2026-05-06 05:10:03\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:91;s:18:\"automation_rule_id\";i:3;s:5:\"event\";s:9:\"stock_low\";s:6:\"status\";s:7:\"success\";s:7:\"message\";s:581:\"{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:10:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:10:03\"}}}\";s:10:\"created_at\";s:19:\"2026-05-06 05:10:03\";s:10:\"updated_at\";s:19:\"2026-05-06 05:10:03\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:14:\"automationRule\";r:1096;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:18:\"automation_rule_id\";i:1;s:5:\"event\";i:2;s:6:\"status\";i:3;s:7:\"message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:22:\"App\\Models\\WorkflowLog\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:13:\"workflow_logs\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:90;s:18:\"automation_rule_id\";i:3;s:5:\"event\";s:9:\"stock_low\";s:6:\"status\";s:7:\"success\";s:7:\"message\";s:627:\"{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:10:01\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:10:01\"}}}\";s:10:\"created_at\";s:19:\"2026-05-06 05:10:01\";s:10:\"updated_at\";s:19:\"2026-05-06 05:10:01\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:90;s:18:\"automation_rule_id\";i:3;s:5:\"event\";s:9:\"stock_low\";s:6:\"status\";s:7:\"success\";s:7:\"message\";s:627:\"{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:10:01\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:10:01\"}}}\";s:10:\"created_at\";s:19:\"2026-05-06 05:10:01\";s:10:\"updated_at\";s:19:\"2026-05-06 05:10:01\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:14:\"automationRule\";r:1096;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:18:\"automation_rule_id\";i:1;s:5:\"event\";i:2;s:6:\"status\";i:3;s:7:\"message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:22:\"App\\Models\\WorkflowLog\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:13:\"workflow_logs\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:89;s:18:\"automation_rule_id\";i:3;s:5:\"event\";s:9:\"stock_low\";s:6:\"status\";s:7:\"success\";s:7:\"message\";s:581:\"{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:09:07\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:09:07\"}}}\";s:10:\"created_at\";s:19:\"2026-05-06 05:09:08\";s:10:\"updated_at\";s:19:\"2026-05-06 05:09:08\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:89;s:18:\"automation_rule_id\";i:3;s:5:\"event\";s:9:\"stock_low\";s:6:\"status\";s:7:\"success\";s:7:\"message\";s:581:\"{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:09:07\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:09:07\"}}}\";s:10:\"created_at\";s:19:\"2026-05-06 05:09:08\";s:10:\"updated_at\";s:19:\"2026-05-06 05:09:08\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:14:\"automationRule\";r:1096;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:18:\"automation_rule_id\";i:1;s:5:\"event\";i:2;s:6:\"status\";i:3;s:7:\"message\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"recentUsers\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:15:\"App\\Models\\User\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:8;s:4:\"name\";s:16:\"Support Supplier\";s:5:\"email\";s:28:\"supplier.support@example.com\";s:17:\"email_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$bhEcUIwxSlUrTIo24kax8OHsVvqNsTqCKhuTBdyJMUf.6AN39GmUq\";s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-05-05 17:15:33\";s:10:\"updated_at\";s:19:\"2026-05-05 17:15:33\";s:7:\"role_id\";i:2;s:6:\"status\";s:6:\"active\";}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:8;s:4:\"name\";s:16:\"Support Supplier\";s:5:\"email\";s:28:\"supplier.support@example.com\";s:17:\"email_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$bhEcUIwxSlUrTIo24kax8OHsVvqNsTqCKhuTBdyJMUf.6AN39GmUq\";s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-05-05 17:15:33\";s:10:\"updated_at\";s:19:\"2026-05-05 17:15:33\";s:7:\"role_id\";i:2;s:6:\"status\";s:6:\"active\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:17:\"email_verified_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:4:\"role\";O:15:\"App\\Models\\Role\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:2;s:4:\"name\";s:8:\"supplier\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:2;s:4:\"name\";s:8:\"supplier\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:1:{i:0;s:5:\"label\";}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:2:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:5:\"email\";i:2;s:7:\"role_id\";i:3;s:6:\"status\";i:4;s:8:\"password\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";}i:1;O:15:\"App\\Models\\User\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:7;s:4:\"name\";s:13:\"Support Buyer\";s:5:\"email\";s:25:\"buyer.support@example.com\";s:17:\"email_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$9i/n5FuoloGK2xgTXE9vFu.z5.ezlXJiCCgGuvvP/Jtg2a0DJiWlC\";s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-05-05 17:15:32\";s:10:\"updated_at\";s:19:\"2026-05-05 17:15:32\";s:7:\"role_id\";i:3;s:6:\"status\";s:6:\"active\";}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:7;s:4:\"name\";s:13:\"Support Buyer\";s:5:\"email\";s:25:\"buyer.support@example.com\";s:17:\"email_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$9i/n5FuoloGK2xgTXE9vFu.z5.ezlXJiCCgGuvvP/Jtg2a0DJiWlC\";s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-05-05 17:15:32\";s:10:\"updated_at\";s:19:\"2026-05-05 17:15:32\";s:7:\"role_id\";i:3;s:6:\"status\";s:6:\"active\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:17:\"email_verified_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:4:\"role\";O:15:\"App\\Models\\Role\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:5:\"buyer\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:5:\"buyer\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:1:{i:0;s:5:\"label\";}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:2:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:5:\"email\";i:2;s:7:\"role_id\";i:3;s:6:\"status\";i:4;s:8:\"password\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";}i:2;O:15:\"App\\Models\\User\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:6;s:4:\"name\";s:16:\"Aman Amed Durjoy\";s:5:\"email\";s:16:\"aman23@gmail.com\";s:17:\"email_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$QTL2de3pGiP76/Oz2wX7nuRyC6xm6ZstqFwFScAXxy/ndtIg9.LRa\";s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-05-05 12:50:26\";s:10:\"updated_at\";s:19:\"2026-05-05 12:50:26\";s:7:\"role_id\";i:5;s:6:\"status\";s:6:\"active\";}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:6;s:4:\"name\";s:16:\"Aman Amed Durjoy\";s:5:\"email\";s:16:\"aman23@gmail.com\";s:17:\"email_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$QTL2de3pGiP76/Oz2wX7nuRyC6xm6ZstqFwFScAXxy/ndtIg9.LRa\";s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-05-05 12:50:26\";s:10:\"updated_at\";s:19:\"2026-05-05 12:50:26\";s:7:\"role_id\";i:5;s:6:\"status\";s:6:\"active\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:17:\"email_verified_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:4:\"role\";O:15:\"App\\Models\\Role\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"roles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:5;s:4:\"name\";s:4:\"user\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:5;s:4:\"name\";s:4:\"user\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:1:{i:0;s:5:\"label\";}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:1:{i:0;s:4:\"name\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:2:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:5:\"email\";i:2;s:7:\"role_id\";i:3;s:6:\"status\";i:4;s:8:\"password\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";}i:3;O:15:\"App\\Models\\User\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:5;s:4:\"name\";s:6:\"Fariha\";s:5:\"email\";s:16:\"fariha@gmail.com\";s:17:\"email_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$a80N1Kk8KrojPkKO0KRsVOP6V93/nWuAZjnPt8lnfdmZCrDbEnaG6\";s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-05-05 11:17:08\";s:10:\"updated_at\";s:19:\"2026-05-05 18:59:58\";s:7:\"role_id\";i:5;s:6:\"status\";s:6:\"active\";}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:5;s:4:\"name\";s:6:\"Fariha\";s:5:\"email\";s:16:\"fariha@gmail.com\";s:17:\"email_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$a80N1Kk8KrojPkKO0KRsVOP6V93/nWuAZjnPt8lnfdmZCrDbEnaG6\";s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-05-05 11:17:08\";s:10:\"updated_at\";s:19:\"2026-05-05 18:59:58\";s:7:\"role_id\";i:5;s:6:\"status\";s:6:\"active\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:17:\"email_verified_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:4:\"role\";r:1636;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:2:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:5:\"email\";i:2;s:7:\"role_id\";i:3;s:6:\"status\";i:4;s:8:\"password\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";}i:4;O:15:\"App\\Models\\User\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:2:\"id\";i:4;s:4:\"name\";s:13:\"Amzad Hossain\";s:5:\"email\";s:17:\"amzad23@gmail.com\";s:17:\"email_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$kvuepx0MDcUemoNTwoitE.AvRypW43bJmB70r33knoQxUInpYiSoa\";s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-05-04 15:09:53\";s:10:\"updated_at\";s:19:\"2026-05-04 15:15:09\";s:7:\"role_id\";i:2;s:6:\"status\";s:6:\"active\";}s:11:\"\0*\0original\";a:10:{s:2:\"id\";i:4;s:4:\"name\";s:13:\"Amzad Hossain\";s:5:\"email\";s:17:\"amzad23@gmail.com\";s:17:\"email_verified_at\";N;s:8:\"password\";s:60:\"$2y$12$kvuepx0MDcUemoNTwoitE.AvRypW43bJmB70r33knoQxUInpYiSoa\";s:14:\"remember_token\";N;s:10:\"created_at\";s:19:\"2026-05-04 15:09:53\";s:10:\"updated_at\";s:19:\"2026-05-04 15:15:09\";s:7:\"role_id\";i:2;s:6:\"status\";s:6:\"active\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:17:\"email_verified_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:4:\"role\";r:1422;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:2:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:5:\"email\";i:2;s:7:\"role_id\";i:3;s:6:\"status\";i:4;s:8:\"password\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:13:\"recentTickets\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:5:{i:0;O:24:\"App\\Models\\SupportTicket\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"support_tickets\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:12:{s:2:\"id\";i:5;s:11:\"customer_id\";i:4;s:8:\"order_id\";i:14;s:11:\"supplier_id\";i:3;s:7:\"subject\";s:12:\"Order status\";s:7:\"message\";s:18:\"Where is my order?\";s:8:\"category\";s:5:\"order\";s:8:\"priority\";s:6:\"medium\";s:6:\"status\";s:4:\"open\";s:11:\"assigned_to\";N;s:10:\"created_at\";s:19:\"2026-05-06 04:05:00\";s:10:\"updated_at\";s:19:\"2026-05-06 04:05:00\";}s:11:\"\0*\0original\";a:12:{s:2:\"id\";i:5;s:11:\"customer_id\";i:4;s:8:\"order_id\";i:14;s:11:\"supplier_id\";i:3;s:7:\"subject\";s:12:\"Order status\";s:7:\"message\";s:18:\"Where is my order?\";s:8:\"category\";s:5:\"order\";s:8:\"priority\";s:6:\"medium\";s:6:\"status\";s:4:\"open\";s:11:\"assigned_to\";N;s:10:\"created_at\";s:19:\"2026-05-06 04:05:00\";s:10:\"updated_at\";s:19:\"2026-05-06 04:05:00\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:8:\"customer\";O:19:\"App\\Models\\Customer\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"customers\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:4;s:4:\"name\";s:16:\"Aman Amed Durjoy\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:4;s:4:\"name\";s:16:\"Aman Amed Durjoy\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:7:\"user_id\";i:1;s:4:\"name\";i:2;s:5:\"email\";i:3;s:5:\"phone\";i:4;s:7:\"address\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:8:\"assignee\";N;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:9:{i:0;s:11:\"customer_id\";i:1;s:8:\"order_id\";i:2;s:11:\"supplier_id\";i:3;s:7:\"subject\";i:4;s:7:\"message\";i:5;s:8:\"category\";i:6;s:8:\"priority\";i:7;s:6:\"status\";i:8;s:11:\"assigned_to\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:24:\"App\\Models\\SupportTicket\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"support_tickets\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:12:{s:2:\"id\";i:4;s:11:\"customer_id\";i:3;s:8:\"order_id\";i:10;s:11:\"supplier_id\";i:2;s:7:\"subject\";s:12:\"order status\";s:7:\"message\";s:5:\"order\";s:8:\"category\";s:5:\"order\";s:8:\"priority\";s:6:\"medium\";s:6:\"status\";s:4:\"open\";s:11:\"assigned_to\";N;s:10:\"created_at\";s:19:\"2026-05-05 17:27:45\";s:10:\"updated_at\";s:19:\"2026-05-05 17:27:45\";}s:11:\"\0*\0original\";a:12:{s:2:\"id\";i:4;s:11:\"customer_id\";i:3;s:8:\"order_id\";i:10;s:11:\"supplier_id\";i:2;s:7:\"subject\";s:12:\"order status\";s:7:\"message\";s:5:\"order\";s:8:\"category\";s:5:\"order\";s:8:\"priority\";s:6:\"medium\";s:6:\"status\";s:4:\"open\";s:11:\"assigned_to\";N;s:10:\"created_at\";s:19:\"2026-05-05 17:27:45\";s:10:\"updated_at\";s:19:\"2026-05-05 17:27:45\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:8:\"customer\";O:19:\"App\\Models\\Customer\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"customers\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:12:\"Mehedi Hasan\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:3;s:4:\"name\";s:12:\"Mehedi Hasan\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:7:\"user_id\";i:1;s:4:\"name\";i:2;s:5:\"email\";i:3;s:5:\"phone\";i:4;s:7:\"address\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:8:\"assignee\";N;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:9:{i:0;s:11:\"customer_id\";i:1;s:8:\"order_id\";i:2;s:11:\"supplier_id\";i:3;s:7:\"subject\";i:4;s:7:\"message\";i:5;s:8:\"category\";i:6;s:8:\"priority\";i:7;s:6:\"status\";i:8;s:11:\"assigned_to\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:24:\"App\\Models\\SupportTicket\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"support_tickets\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:12:{s:2:\"id\";i:3;s:11:\"customer_id\";i:5;s:8:\"order_id\";i:13;s:11:\"supplier_id\";i:5;s:7:\"subject\";s:26:\"Supplier quality complaint\";s:7:\"message\";s:71:\"The supplier shipment did not match the approved product specification.\";s:8:\"category\";s:8:\"supplier\";s:8:\"priority\";s:6:\"medium\";s:6:\"status\";s:4:\"open\";s:11:\"assigned_to\";N;s:10:\"created_at\";s:19:\"2026-05-05 17:15:34\";s:10:\"updated_at\";s:19:\"2026-05-05 17:15:34\";}s:11:\"\0*\0original\";a:12:{s:2:\"id\";i:3;s:11:\"customer_id\";i:5;s:8:\"order_id\";i:13;s:11:\"supplier_id\";i:5;s:7:\"subject\";s:26:\"Supplier quality complaint\";s:7:\"message\";s:71:\"The supplier shipment did not match the approved product specification.\";s:8:\"category\";s:8:\"supplier\";s:8:\"priority\";s:6:\"medium\";s:6:\"status\";s:4:\"open\";s:11:\"assigned_to\";N;s:10:\"created_at\";s:19:\"2026-05-05 17:15:34\";s:10:\"updated_at\";s:19:\"2026-05-05 17:15:34\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:8:\"customer\";O:19:\"App\\Models\\Customer\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:9:\"customers\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:5;s:4:\"name\";s:13:\"Support Buyer\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:5;s:4:\"name\";s:13:\"Support Buyer\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:7:\"user_id\";i:1;s:4:\"name\";i:2;s:5:\"email\";i:3;s:5:\"phone\";i:4;s:7:\"address\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:8:\"assignee\";N;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:9:{i:0;s:11:\"customer_id\";i:1;s:8:\"order_id\";i:2;s:11:\"supplier_id\";i:3;s:7:\"subject\";i:4;s:7:\"message\";i:5;s:8:\"category\";i:6;s:8:\"priority\";i:7;s:6:\"status\";i:8;s:11:\"assigned_to\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:24:\"App\\Models\\SupportTicket\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"support_tickets\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:12:{s:2:\"id\";i:1;s:11:\"customer_id\";i:5;s:8:\"order_id\";i:13;s:11:\"supplier_id\";N;s:7:\"subject\";s:32:\"Delivery delay on order shipment\";s:7:\"message\";s:68:\"My delivery is delayed and I need an updated expected delivery date.\";s:8:\"category\";s:8:\"delivery\";s:8:\"priority\";s:4:\"high\";s:6:\"status\";s:4:\"open\";s:11:\"assigned_to\";N;s:10:\"created_at\";s:19:\"2026-05-05 17:15:33\";s:10:\"updated_at\";s:19:\"2026-05-05 17:15:33\";}s:11:\"\0*\0original\";a:12:{s:2:\"id\";i:1;s:11:\"customer_id\";i:5;s:8:\"order_id\";i:13;s:11:\"supplier_id\";N;s:7:\"subject\";s:32:\"Delivery delay on order shipment\";s:7:\"message\";s:68:\"My delivery is delayed and I need an updated expected delivery date.\";s:8:\"category\";s:8:\"delivery\";s:8:\"priority\";s:4:\"high\";s:6:\"status\";s:4:\"open\";s:11:\"assigned_to\";N;s:10:\"created_at\";s:19:\"2026-05-05 17:15:33\";s:10:\"updated_at\";s:19:\"2026-05-05 17:15:33\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:8:\"customer\";r:2108;s:8:\"assignee\";N;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:9:{i:0;s:11:\"customer_id\";i:1;s:8:\"order_id\";i:2;s:11:\"supplier_id\";i:3;s:7:\"subject\";i:4;s:7:\"message\";i:5;s:8:\"category\";i:6;s:8:\"priority\";i:7;s:6:\"status\";i:8;s:11:\"assigned_to\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:24:\"App\\Models\\SupportTicket\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"support_tickets\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:12:{s:2:\"id\";i:2;s:11:\"customer_id\";i:5;s:8:\"order_id\";i:13;s:11:\"supplier_id\";N;s:7:\"subject\";s:23:\"Payment reflected twice\";s:7:\"message\";s:72:\"The payment gateway appears to have charged me twice for the same order.\";s:8:\"category\";s:7:\"payment\";s:8:\"priority\";s:6:\"urgent\";s:6:\"status\";s:7:\"pending\";s:11:\"assigned_to\";N;s:10:\"created_at\";s:19:\"2026-05-05 17:15:33\";s:10:\"updated_at\";s:19:\"2026-05-05 17:15:33\";}s:11:\"\0*\0original\";a:12:{s:2:\"id\";i:2;s:11:\"customer_id\";i:5;s:8:\"order_id\";i:13;s:11:\"supplier_id\";N;s:7:\"subject\";s:23:\"Payment reflected twice\";s:7:\"message\";s:72:\"The payment gateway appears to have charged me twice for the same order.\";s:8:\"category\";s:7:\"payment\";s:8:\"priority\";s:6:\"urgent\";s:6:\"status\";s:7:\"pending\";s:11:\"assigned_to\";N;s:10:\"created_at\";s:19:\"2026-05-05 17:15:33\";s:10:\"updated_at\";s:19:\"2026-05-05 17:15:33\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:2:{s:8:\"customer\";r:2108;s:8:\"assignee\";N;}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:9:{i:0;s:11:\"customer_id\";i:1;s:8:\"order_id\";i:2;s:11:\"supplier_id\";i:3;s:7:\"subject\";i:4;s:7:\"message\";i:5;s:8:\"category\";i:6;s:8:\"priority\";i:7;s:6:\"status\";i:8;s:11:\"assigned_to\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"ordersChart\";a:2:{s:6:\"labels\";a:7:{i:0;s:6:\"Apr 30\";i:1;s:6:\"May 01\";i:2;s:6:\"May 02\";i:3;s:6:\"May 03\";i:4;s:6:\"May 04\";i:5;s:6:\"May 05\";i:6;s:6:\"May 06\";}s:6:\"series\";a:7:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:1;i:4;i:6;i:5;i:5;i:6;i:5;}}s:12:\"revenueChart\";a:2:{s:6:\"labels\";a:30:{i:0;s:6:\"Apr 07\";i:1;s:6:\"Apr 08\";i:2;s:6:\"Apr 09\";i:3;s:6:\"Apr 10\";i:4;s:6:\"Apr 11\";i:5;s:6:\"Apr 12\";i:6;s:6:\"Apr 13\";i:7;s:6:\"Apr 14\";i:8;s:6:\"Apr 15\";i:9;s:6:\"Apr 16\";i:10;s:6:\"Apr 17\";i:11;s:6:\"Apr 18\";i:12;s:6:\"Apr 19\";i:13;s:6:\"Apr 20\";i:14;s:6:\"Apr 21\";i:15;s:6:\"Apr 22\";i:16;s:6:\"Apr 23\";i:17;s:6:\"Apr 24\";i:18;s:6:\"Apr 25\";i:19;s:6:\"Apr 26\";i:20;s:6:\"Apr 27\";i:21;s:6:\"Apr 28\";i:22;s:6:\"Apr 29\";i:23;s:6:\"Apr 30\";i:24;s:6:\"May 01\";i:25;s:6:\"May 02\";i:26;s:6:\"May 03\";i:27;s:6:\"May 04\";i:28;s:6:\"May 05\";i:29;s:6:\"May 06\";}s:6:\"series\";a:30:{i:0;d:0;i:1;d:0;i:2;d:0;i:3;d:0;i:4;d:0;i:5;d:0;i:6;d:0;i:7;d:0;i:8;d:0;i:9;d:0;i:10;d:0;i:11;d:0;i:12;d:0;i:13;d:0;i:14;d:0;i:15;d:0;i:16;d:0;i:17;d:0;i:18;d:0;i:19;d:0;i:20;d:0;i:21;d:0;i:22;d:0;i:23;d:0;i:24;d:0;i:25;d:0;i:26;d:640;i:27;d:29187;i:28;d:23408;i:29;d:105305;}}s:11:\"topProducts\";a:2:{s:6:\"labels\";a:3:{i:0;s:11:\"Adaptor 30w\";i:1;s:19:\"Super star bulb 12w\";i:2;s:14:\"Apple ear buds\";}s:6:\"series\";a:3:{i:0;i:995;i:1;i:115;i:2;i:95;}}}', 1778044409);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('plexora-erp-cache-settings.modules', 'a:10:{s:15:\"module_products\";b:1;s:16:\"module_inventory\";b:1;s:13:\"module_orders\";b:1;s:10:\"module_crm\";b:1;s:10:\"module_rfq\";b:1;s:15:\"module_workflow\";b:1;s:16:\"module_marketing\";b:1;s:13:\"module_social\";b:1;s:14:\"module_support\";b:1;s:16:\"module_suppliers\";b:1;}', 2093402507);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('marketing','social') NOT NULL,
  `channel` enum('email','sms','facebook','instagram') NOT NULL,
  `name` varchar(255) NOT NULL,
  `audience` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `media_path` varchar(255) DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `status` enum('draft','scheduled','processing','sent','failed') NOT NULL DEFAULT 'draft',
  `trigger_event` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `type`, `channel`, `name`, `audience`, `subject`, `content`, `media_path`, `scheduled_at`, `status`, `trigger_event`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'marketing', 'email', 'Welcome Email', 'event_customer', 'Welcome to Plexora ERP', 'Welcome aboard. Our team is ready to help you source products and manage your orders efficiently.', NULL, NULL, 'scheduled', 'customer_registered', 1, NULL, '2026-05-05 09:05:16', '2026-05-05 09:05:16'),
(2, 'marketing', 'email', 'Order Confirmation Email', 'event_customer', 'Order confirmation from Plexora', 'Your order has been placed successfully. Our team will keep you updated on fulfillment.', NULL, NULL, 'sent', 'order_placed', 1, NULL, '2026-05-05 09:05:16', '2026-05-05 22:44:10'),
(3, 'marketing', 'email', 'RFQ Follow-up Email', 'event_customer', 'Your RFQ is under review', 'We received your RFQ and our team will connect you with the right supplier shortly.', NULL, NULL, 'sent', 'rfq_created', 1, NULL, '2026-05-05 09:05:16', '2026-05-05 20:28:23'),
(4, 'marketing', 'sms', 'Festival Discount Campaign', 'all_customers', NULL, 'Festival discount campaign is live. Reply to connect with our sales desk for enterprise pricing.', NULL, '2026-05-06 10:00:00', 'sent', NULL, 1, NULL, '2026-05-05 09:05:16', '2026-05-05 22:49:36'),
(5, 'social', 'facebook', 'Facebook Product Launch', 'public', NULL, 'Introducing our newest B2B catalog launch with faster fulfillment and richer automation.', NULL, '2026-05-07 12:00:00', 'scheduled', NULL, 1, NULL, '2026-05-05 09:05:16', '2026-05-05 09:05:16'),
(6, 'social', 'instagram', 'Instagram Weekend Promo', 'public', NULL, 'Weekend promo is now live with curated supplier highlights and limited-time pricing.', NULL, '2026-05-08 18:00:00', 'scheduled', NULL, 1, NULL, '2026-05-05 09:05:16', '2026-05-05 09:05:16'),
(7, 'marketing', 'email', 'Welcome Email', 'event_customer', 'Welcome to Plexora ERP', 'Welcome aboard. Our team is ready to help you source products and manage your orders efficiently.', NULL, NULL, 'scheduled', 'customer_registered', 1, NULL, '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(8, 'marketing', 'email', 'Order Confirmation Email', 'event_customer', 'Order confirmation from Plexora', 'Your order has been placed successfully. Our team will keep you updated on fulfillment.', NULL, NULL, 'sent', 'order_placed', 1, NULL, '2026-05-05 12:48:07', '2026-05-05 22:44:10'),
(9, 'marketing', 'email', 'RFQ Follow-up Email', 'event_customer', 'Your RFQ is under review', 'We received your RFQ and our team will connect you with the right supplier shortly.', NULL, NULL, 'sent', 'rfq_created', 1, NULL, '2026-05-05 12:48:07', '2026-05-05 20:28:23'),
(10, 'marketing', 'sms', 'Festival Discount Campaign', 'all_customers', NULL, 'Festival discount campaign is live. Reply to connect with our sales desk for enterprise pricing.', NULL, '2026-05-06 10:00:00', 'scheduled', NULL, 1, NULL, '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(11, 'social', 'facebook', 'Facebook Product Launch', 'public', NULL, 'Introducing our newest B2B catalog launch with faster fulfillment and richer automation.', NULL, '2026-05-07 12:00:00', 'scheduled', NULL, 1, NULL, '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(12, 'social', 'instagram', 'Instagram Weekend Promo', 'public', NULL, 'Weekend promo is now live with curated supplier highlights and limited-time pricing.', NULL, '2026-05-08 18:00:00', 'scheduled', NULL, 1, NULL, '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(13, 'social', 'facebook', 'New Year Campain', 'all_customer', 'Test', 'We launch new campaign', NULL, '2026-05-06 10:50:00', 'sent', NULL, 1, 1, '2026-05-05 22:48:17', '2026-05-05 23:12:18');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_logs`
--

CREATE TABLE `campaign_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `channel` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `message` text DEFAULT NULL,
  `executed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaign_logs`
--

INSERT INTO `campaign_logs` (`id`, `campaign_id`, `channel`, `status`, `message`, `executed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 02:10:56', '2026-05-05 20:10:56', '2026-05-05 20:10:56'),
(2, 8, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 02:10:56', '2026-05-05 20:10:56', '2026-05-05 20:10:56'),
(3, 3, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 02:28:18', '2026-05-05 20:28:18', '2026-05-05 20:28:18'),
(4, 9, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 02:28:18', '2026-05-05 20:28:18', '2026-05-05 20:28:18'),
(5, 3, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 02:28:23', '2026-05-05 20:28:23', '2026-05-05 20:28:23'),
(6, 9, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 02:28:23', '2026-05-05 20:28:23', '2026-05-05 20:28:23'),
(7, 2, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 04:24:35', '2026-05-05 22:24:35', '2026-05-05 22:24:35'),
(8, 8, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 04:24:35', '2026-05-05 22:24:35', '2026-05-05 22:24:35'),
(9, 2, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 04:30:31', '2026-05-05 22:30:31', '2026-05-05 22:30:31'),
(10, 8, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 04:30:32', '2026-05-05 22:30:32', '2026-05-05 22:30:32'),
(11, 2, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 04:38:12', '2026-05-05 22:38:12', '2026-05-05 22:38:12'),
(12, 8, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 04:38:12', '2026-05-05 22:38:12', '2026-05-05 22:38:12'),
(13, 2, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 04:44:10', '2026-05-05 22:44:10', '2026-05-05 22:44:10'),
(14, 8, 'email', 'sent', 'Mock email sent to 1 recipient(s).', '2026-05-06 04:44:10', '2026-05-05 22:44:10', '2026-05-05 22:44:10'),
(15, 4, 'sms', 'sent', 'Mock SMS sent to 4 recipient(s).', '2026-05-06 04:49:36', '2026-05-05 22:49:36', '2026-05-05 22:49:36'),
(16, 13, 'facebook', 'sent', 'Mock Facebook post published without a linked account placeholder.', '2026-05-06 05:12:18', '2026-05-05 23:12:18', '2026-05-05 23:12:18');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, 'Biplab ', 'biplobhosen214@gmail.com', '01682989831', 'Dhaka', '2026-05-05 11:06:37', '2026-05-05 11:06:37'),
(2, NULL, 'Rakib', 'rakib23@gmail.com', '021545455', 'Dhaka', NULL, NULL),
(3, 3, 'Mehedi Hasan', 'mehedi23@gmail.com', '02559899', 'Dhanmondi', '2026-05-05 11:08:47', '2026-05-05 11:08:47'),
(4, 6, 'Aman Amed Durjoy', 'aman23@gmail.com', NULL, NULL, '2026-05-05 06:50:26', '2026-05-05 06:50:26'),
(5, 7, 'Support Buyer', 'buyer.support@example.com', '+8801700000000', 'Dhaka', '2026-05-05 11:15:32', '2026-05-05 11:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `customer_notes`
--

CREATE TABLE `customer_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, '1ca49a34-34c0-41ac-b134-715d1e6a24c8', 'database', 'automation', '{\"uuid\":\"1ca49a34-34c0-41ac-b134-715d1e6a24c8\",\"displayName\":\"App\\\\Jobs\\\\NotifySupplierJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NotifySupplierJob\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\NotifySupplierJob\\\":3:{s:7:\\\"context\\\";a:14:{s:5:\\\"event\\\";s:11:\\\"rfq_created\\\";s:6:\\\"rfq_id\\\";i:3;s:9:\\\"rfq_title\\\";s:15:\\\"Electric wiring\\\";s:8:\\\"buyer_id\\\";i:3;s:10:\\\"buyer_name\\\";s:12:\\\"Mehedi Hasan\\\";s:11:\\\"buyer_email\\\";s:18:\\\"mehedi23@gmail.com\\\";s:11:\\\"supplier_id\\\";i:2;s:13:\\\"supplier_name\\\";s:16:\\\"Proxima Electric\\\";s:14:\\\"supplier_email\\\";s:25:\\\"proximaraiments@gmail.com\\\";s:8:\\\"quantity\\\";i:1000;s:5:\\\"title\\\";s:15:\\\"New RFQ Request\\\";s:7:\\\"subject\\\";s:24:\\\"New RFQ: Electric wiring\\\";s:4:\\\"body\\\";s:84:\\\"A new RFQ titled \'Electric wiring\' has been created and is awaiting supplier review.\\\";s:4:\\\"meta\\\";a:6:{s:6:\\\"RFQ ID\\\";i:3;s:9:\\\"RFQ Title\\\";s:15:\\\"Electric wiring\\\";s:5:\\\"Buyer\\\";s:12:\\\"Mehedi Hasan\\\";s:8:\\\"Supplier\\\";s:16:\\\"Proxima Electric\\\";s:8:\\\"Quantity\\\";i:1000;s:6:\\\"Status\\\";s:4:\\\"open\\\";}}s:6:\\\"target\\\";N;s:5:\\\"queue\\\";s:10:\\\"automation\\\";}\",\"batchId\":null},\"createdAt\":1777963677,\"delay\":null}', 'InvalidArgumentException: View [emails.supplier.workflow] not found. in C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:138\nStack trace:\n#0 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(78): Illuminate\\View\\FileViewFinder->findInPaths(\'emails.supplier...\', Array)\n#1 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(150): Illuminate\\View\\FileViewFinder->find(\'emails.supplier...\')\n#2 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(444): Illuminate\\View\\Factory->make(\'emails.supplier...\', Array)\n#3 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(419): Illuminate\\Mail\\Mailer->renderView(\'emails.supplier...\', Array)\n#4 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(312): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'emails.supplier...\', NULL, NULL, Array)\n#5 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(207): Illuminate\\Mail\\Mailer->send(\'emails.supplier...\', Array, Object(Closure))\n#6 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(200): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(353): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\Mailer))\n#9 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(300): Illuminate\\Mail\\Mailer->sendMailable(Object(App\\Mail\\SupplierWorkflowMail))\n#10 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\PendingMail.php(123): Illuminate\\Mail\\Mailer->send(Object(App\\Mail\\SupplierWorkflowMail))\n#11 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\app\\Jobs\\NotifySupplierJob.php(30): Illuminate\\Mail\\PendingMail->send(Object(App\\Mail\\SupplierWorkflowMail))\n#12 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\NotifySupplierJob->handle()\n#13 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#14 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#15 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#16 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#17 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#18 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\NotifySupplierJob))\n#19 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\NotifySupplierJob))\n#20 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#21 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(136): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\NotifySupplierJob), false)\n#22 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\NotifySupplierJob))\n#23 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\NotifySupplierJob))\n#24 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(129): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\NotifySupplierJob))\n#26 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#27 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#28 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#29 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#30 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'automation,defa...\', Object(Illuminate\\Queue\\WorkerOptions))\n#31 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'automation,defa...\')\n#32 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#33 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#34 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#35 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#36 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#37 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#38 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#39 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#40 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\symfony\\console\\Application.php(1117): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#44 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#46 {main}', '2026-05-05 00:52:09'),
(2, 'aea5f9ca-c40d-471e-867b-f8bc89034a46', 'database', 'automation', '{\"uuid\":\"aea5f9ca-c40d-471e-867b-f8bc89034a46\",\"displayName\":\"App\\\\Jobs\\\\SendCustomerEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendCustomerEmailJob\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\SendCustomerEmailJob\\\":3:{s:7:\\\"context\\\";a:10:{s:5:\\\"event\\\";s:12:\\\"order_placed\\\";s:8:\\\"order_id\\\";i:9;s:12:\\\"order_number\\\";s:19:\\\"ORD-20260505-165327\\\";s:11:\\\"customer_id\\\";i:1;s:13:\\\"customer_name\\\";s:12:\\\"Biplab Hosen\\\";s:14:\\\"customer_email\\\";s:24:\\\"biplobhosen214@gmail.com\\\";s:5:\\\"title\\\";s:34:\\\"Order ORD-20260505-165327 received\\\";s:7:\\\"subject\\\";s:34:\\\"Order ORD-20260505-165327 received\\\";s:4:\\\"body\\\";s:85:\\\"Your order ORD-20260505-165327 has been placed successfully and is now in processing.\\\";s:4:\\\"meta\\\";a:5:{s:8:\\\"Order ID\\\";i:9;s:12:\\\"Order Number\\\";s:19:\\\"ORD-20260505-165327\\\";s:8:\\\"Customer\\\";s:12:\\\"Biplab Hosen\\\";s:11:\\\"Grand Total\\\";s:7:\\\"3136.00\\\";s:6:\\\"Status\\\";s:7:\\\"pending\\\";}}s:6:\\\"target\\\";N;s:5:\\\"queue\\\";s:10:\\\"automation\\\";}\",\"batchId\":null},\"createdAt\":1777967361,\"delay\":null}', 'InvalidArgumentException: View [emails.customer.workflow] not found. in C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:138\nStack trace:\n#0 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(78): Illuminate\\View\\FileViewFinder->findInPaths(\'emails.customer...\', Array)\n#1 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(150): Illuminate\\View\\FileViewFinder->find(\'emails.customer...\')\n#2 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(444): Illuminate\\View\\Factory->make(\'emails.customer...\', Array)\n#3 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(419): Illuminate\\Mail\\Mailer->renderView(\'emails.customer...\', Array)\n#4 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(312): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'emails.customer...\', NULL, NULL, Array)\n#5 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(207): Illuminate\\Mail\\Mailer->send(\'emails.customer...\', Array, Object(Closure))\n#6 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(200): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(353): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\Mailer))\n#9 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(300): Illuminate\\Mail\\Mailer->sendMailable(Object(App\\Mail\\CustomerWorkflowMail))\n#10 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\PendingMail.php(123): Illuminate\\Mail\\Mailer->send(Object(App\\Mail\\CustomerWorkflowMail))\n#11 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\app\\Jobs\\SendCustomerEmailJob.php(30): Illuminate\\Mail\\PendingMail->send(Object(App\\Mail\\CustomerWorkflowMail))\n#12 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\SendCustomerEmailJob->handle()\n#13 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#14 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#15 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#16 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#17 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#18 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\SendCustomerEmailJob))\n#19 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\SendCustomerEmailJob))\n#20 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#21 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(136): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\SendCustomerEmailJob), false)\n#22 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\SendCustomerEmailJob))\n#23 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\SendCustomerEmailJob))\n#24 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(129): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\SendCustomerEmailJob))\n#26 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#27 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#28 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#29 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#30 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'automation,defa...\', Object(Illuminate\\Queue\\WorkerOptions))\n#31 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'automation,defa...\')\n#32 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#33 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#34 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#35 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#36 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#37 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#38 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#39 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#40 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\symfony\\console\\Application.php(1117): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#44 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#46 {main}', '2026-05-05 01:49:21'),
(3, 'dc4b9040-e12f-4905-8b2f-0159b9897eae', 'database', 'automation', '{\"uuid\":\"dc4b9040-e12f-4905-8b2f-0159b9897eae\",\"displayName\":\"App\\\\Jobs\\\\SendCustomerEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendCustomerEmailJob\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\SendCustomerEmailJob\\\":3:{s:7:\\\"context\\\";a:10:{s:5:\\\"event\\\";s:12:\\\"order_placed\\\";s:8:\\\"order_id\\\";i:10;s:12:\\\"order_number\\\";s:19:\\\"ORD-20260505-206595\\\";s:11:\\\"customer_id\\\";i:3;s:13:\\\"customer_name\\\";s:12:\\\"Mehedi Hasan\\\";s:14:\\\"customer_email\\\";s:18:\\\"mehedi23@gmail.com\\\";s:5:\\\"title\\\";s:34:\\\"Order ORD-20260505-206595 received\\\";s:7:\\\"subject\\\";s:34:\\\"Order ORD-20260505-206595 received\\\";s:4:\\\"body\\\";s:85:\\\"Your order ORD-20260505-206595 has been placed successfully and is now in processing.\\\";s:4:\\\"meta\\\";a:5:{s:8:\\\"Order ID\\\";i:10;s:12:\\\"Order Number\\\";s:19:\\\"ORD-20260505-206595\\\";s:8:\\\"Customer\\\";s:12:\\\"Mehedi Hasan\\\";s:11:\\\"Grand Total\\\";s:8:\\\"13500.00\\\";s:6:\\\"Status\\\";s:7:\\\"pending\\\";}}s:6:\\\"target\\\";N;s:5:\\\"queue\\\";s:10:\\\"automation\\\";}\",\"batchId\":null},\"createdAt\":1777968801,\"delay\":null}', 'InvalidArgumentException: View [emails.customer.workflow] not found. in C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:138\nStack trace:\n#0 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(78): Illuminate\\View\\FileViewFinder->findInPaths(\'emails.customer...\', Array)\n#1 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(150): Illuminate\\View\\FileViewFinder->find(\'emails.customer...\')\n#2 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(444): Illuminate\\View\\Factory->make(\'emails.customer...\', Array)\n#3 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(419): Illuminate\\Mail\\Mailer->renderView(\'emails.customer...\', Array)\n#4 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(312): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'emails.customer...\', NULL, NULL, Array)\n#5 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(207): Illuminate\\Mail\\Mailer->send(\'emails.customer...\', Array, Object(Closure))\n#6 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(200): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(353): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\Mailer))\n#9 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(300): Illuminate\\Mail\\Mailer->sendMailable(Object(App\\Mail\\CustomerWorkflowMail))\n#10 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\PendingMail.php(123): Illuminate\\Mail\\Mailer->send(Object(App\\Mail\\CustomerWorkflowMail))\n#11 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\app\\Jobs\\SendCustomerEmailJob.php(30): Illuminate\\Mail\\PendingMail->send(Object(App\\Mail\\CustomerWorkflowMail))\n#12 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\SendCustomerEmailJob->handle()\n#13 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#14 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#15 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#16 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#17 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#18 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\SendCustomerEmailJob))\n#19 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\SendCustomerEmailJob))\n#20 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#21 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(136): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\SendCustomerEmailJob), false)\n#22 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\SendCustomerEmailJob))\n#23 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\SendCustomerEmailJob))\n#24 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(129): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\SendCustomerEmailJob))\n#26 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#27 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#28 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#29 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#30 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'automation,defa...\', Object(Illuminate\\Queue\\WorkerOptions))\n#31 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'automation,defa...\')\n#32 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#33 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#34 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#35 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#36 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#37 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#38 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#39 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#40 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\symfony\\console\\Application.php(1117): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#44 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\Users\\Biplab PC\\Desktop\\Plexora-ERP\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#46 {main}', '2026-05-05 02:13:21');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `status` enum('new','contacted','qualified','converted','lost') NOT NULL DEFAULT 'new',
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `name`, `company`, `email`, `phone`, `source`, `status`, `assigned_to`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Ahmed', 'ABC tiles', 'ahmed23@gmail.com', '208-498-6912', 'abctiles.com', 'converted', 2, NULL, '2026-05-05 07:11:19', '2026-05-05 19:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `message_templates`
--

CREATE TABLE `message_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `channel` enum('email','sms') NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_templates`
--

INSERT INTO `message_templates` (`id`, `name`, `channel`, `subject`, `body`, `created_at`, `updated_at`) VALUES
(1, 'Welcome Email', 'email', 'Welcome to Plexora ERP', 'Thanks for joining Plexora. We are ready to support your B2B buying journey.', '2026-05-05 09:05:16', '2026-05-05 09:05:16'),
(2, 'Order Confirmation Email', 'email', 'Your order has been received', 'Your order is confirmed and our operations team is preparing the next steps.', '2026-05-05 09:05:16', '2026-05-05 09:05:16'),
(3, 'Promotional SMS', 'sms', NULL, 'Festival discount is now live. Contact sales for your custom wholesale rate.', '2026-05-05 09:05:16', '2026-05-05 09:05:16'),
(4, 'Welcome Email', 'email', 'Welcome to Plexora ERP', 'Thanks for joining Plexora. We are ready to support your B2B buying journey.', '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(5, 'Order Confirmation Email', 'email', 'Your order has been received', 'Your order is confirmed and our operations team is preparing the next steps.', '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(6, 'Promotional SMS', 'sms', NULL, 'Festival discount is now live. Contact sales for your custom wholesale rate.', '2026-05-05 12:48:07', '2026-05-05 12:48:07');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_03_105118_create_roles_table', 2),
(5, '2026_05_03_105230_add_role_id_to_users_table', 2),
(6, '2026_05_03_105437_create_suppliers_table', 2),
(7, '2026_05_03_105603_create_products_table', 2),
(8, '2026_05_03_110301_create_orders_table', 3),
(9, '2026_05_03_110325_create_order_items_table', 3),
(10, '2026_05_03_125034_create_customers_table', 3),
(11, '2026_05_04_120000_create_suppliers_table', 4),
(12, '2026_05_05_000000_create_stock_movements_table', 5),
(13, '2026_05_05_010000_create_automation_rules_table', 6),
(14, '2026_05_05_010100_create_workflow_logs_table', 6),
(15, '2026_05_05_010200_create_rfqs_table', 6),
(16, '2026_05_05_150000_create_leads_table', 7),
(17, '2026_05_05_150100_create_customer_notes_table', 7),
(18, '2026_05_05_200000_create_campaigns_table', 8),
(19, '2026_05_05_200100_create_campaign_logs_table', 8),
(20, '2026_05_05_200200_create_message_templates_table', 8),
(21, '2026_05_05_200300_create_social_accounts_table', 8),
(22, '2026_05_05_171221_create_personal_access_tokens_table', 9),
(23, '2026_05_05_231000_create_support_tickets_table', 9),
(24, '2026_05_05_231100_create_support_replies_table', 9),
(25, '2026_05_06_010000_create_settings_table', 10),
(26, '2026_05_06_010100_add_status_to_users_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_number`, `subtotal`, `discount`, `tax`, `grand_total`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'ORD-20260503-947041', 640.00, 0.00, 0.00, 640.00, 'completed', NULL, '2026-05-03 12:50:12', '2026-05-03 12:50:12'),
(2, 1, 'ORD-20260504-673652', 640.00, 0.00, 0.00, 640.00, 'pending', NULL, '2026-05-03 21:56:50', '2026-05-03 21:56:50'),
(3, 1, 'ORD-20260504-259576', 960.00, 60.00, 0.00, 900.00, 'pending', NULL, '2026-05-04 00:16:17', '2026-05-04 00:16:17'),
(4, 1, 'ORD-20260504-346806', 940.00, 40.00, 0.00, 900.00, 'pending', NULL, '2026-05-04 02:03:37', '2026-05-04 02:03:37'),
(5, 1, 'ORD-20260504-532207', 10000.00, 1000.00, 0.00, 9000.00, 'pending', NULL, '2026-05-04 03:13:24', '2026-05-04 03:13:24'),
(6, 3, 'ORD-20260504-641690', 5700.00, 114.00, 0.00, 5586.00, 'pending', NULL, '2026-05-04 09:23:16', '2026-05-04 09:23:16'),
(7, 3, 'ORD-20260504-306393', 12700.00, 539.00, 0.00, 12161.00, 'pending', NULL, '2026-05-04 11:13:18', '2026-05-04 11:13:18'),
(8, 3, 'ORD-20260505-986629', 3200.00, 64.00, 0.00, 3136.00, 'pending', NULL, '2026-05-04 20:31:32', '2026-05-04 20:31:32'),
(9, 1, 'ORD-20260505-165327', 3200.00, 64.00, 0.00, 3136.00, 'pending', NULL, '2026-05-05 01:49:18', '2026-05-05 01:49:18'),
(10, 3, 'ORD-20260505-206595', 15000.00, 1500.00, 0.00, 13500.00, 'pending', NULL, '2026-05-05 02:13:19', '2026-05-05 02:13:19'),
(11, 3, 'ORD-20260505-848657', 3200.00, 64.00, 0.00, 3136.00, 'pending', NULL, '2026-05-05 05:14:16', '2026-05-05 05:14:16'),
(13, 5, 'ORD-SUPPORT-DEMO-001', 500.00, 0.00, 0.00, 500.00, 'confirmed', 'Sample order for support module seeding.', '2026-05-05 11:15:33', '2026-05-05 11:15:33'),
(14, 4, 'ORD-20260506-153352', 2000.00, 100.00, 0.00, 1900.00, 'pending', NULL, '2026-05-05 19:52:27', '2026-05-05 19:52:27'),
(15, 1, 'ORD-20260506-664784', 2000.00, 100.00, 0.00, 1900.00, 'pending', NULL, '2026-05-05 22:24:31', '2026-05-05 22:24:31'),
(16, 3, 'ORD-20260506-809160', 93500.00, 9350.00, 0.00, 84150.00, 'pending', NULL, '2026-05-05 22:30:28', '2026-05-05 22:30:28'),
(17, 1, 'ORD-20260506-070301', 14400.00, 720.00, 0.00, 13680.00, 'pending', NULL, '2026-05-05 22:38:04', '2026-05-05 22:38:04'),
(18, 1, 'ORD-20260506-646951', 3750.00, 75.00, 0.00, 3675.00, 'pending', NULL, '2026-05-05 22:44:05', '2026-05-05 22:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `line_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`, `line_total`, `created_at`, `updated_at`) VALUES
(7, 6, 4, 320.00, 10, 3136.00, '2026-05-04 09:23:16', '2026-05-04 09:23:16'),
(8, 6, 3, 250.00, 10, 2450.00, '2026-05-04 09:23:16', '2026-05-04 09:23:16'),
(9, 7, 5, 100.00, 20, 1900.00, '2026-05-04 11:13:18', '2026-05-04 11:13:18'),
(10, 7, 4, 320.00, 10, 3136.00, '2026-05-04 11:13:18', '2026-05-04 11:13:18'),
(11, 7, 3, 250.00, 30, 7125.00, '2026-05-04 11:13:18', '2026-05-04 11:13:18'),
(12, 8, 4, 320.00, 10, 3136.00, '2026-05-04 20:31:32', '2026-05-04 20:31:32'),
(13, 9, 4, 320.00, 10, 3136.00, '2026-05-05 01:49:18', '2026-05-05 01:49:18'),
(14, 10, 3, 250.00, 60, 13500.00, '2026-05-05 02:13:19', '2026-05-05 02:13:19'),
(15, 11, 4, 320.00, 10, 3136.00, '2026-05-05 05:14:16', '2026-05-05 05:14:16'),
(16, 14, 5, 100.00, 20, 1900.00, '2026-05-05 19:52:27', '2026-05-05 19:52:27'),
(17, 15, 5, 100.00, 20, 1900.00, '2026-05-05 22:24:31', '2026-05-05 22:24:31'),
(18, 16, 5, 100.00, 935, 84150.00, '2026-05-05 22:30:28', '2026-05-05 22:30:28'),
(19, 17, 4, 320.00, 45, 13680.00, '2026-05-05 22:38:04', '2026-05-05 22:38:04'),
(20, 18, 3, 250.00, 15, 3675.00, '2026-05-05 22:44:05', '2026-05-05 22:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `moq` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `supplier_id`, `sku`, `name`, `description`, `price`, `stock`, `moq`, `status`, `created_at`, `updated_at`) VALUES
(3, 2, 'sku-14789630', 'Super star bulb 12w', 'Electric saver led 12w bulb', 250.00, 0, 10, 1, '2026-05-04 07:35:16', '2026-05-05 22:44:05'),
(4, 3, 'sku-14789648', 'Apple ear buds', 'Apple ear buds. Made in california by apple.', 320.00, 45, 10, 1, '2026-05-04 09:20:17', '2026-05-05 22:43:01'),
(5, 3, 'sku-147896378', 'Adaptor 30w', 'Design by apple in california, assemble in China.', 100.00, 5, 20, 1, '2026-05-04 11:11:30', '2026-05-05 22:30:28');

-- --------------------------------------------------------

--
-- Table structure for table `rfqs`
--

CREATE TABLE `rfqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `buyer_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `status` enum('open','quoted','closed') NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rfqs`
--

INSERT INTO `rfqs` (`id`, `buyer_id`, `supplier_id`, `title`, `description`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 3, 'RFQ-2026-05-IT Infrastructure Modernization', 'I need 200 unit ear buds and 800 unit adaptor', 1000, 'open', '2026-05-04 23:16:23', '2026-05-04 23:16:23'),
(2, 1, 2, 'Enhance electric system', 'I need 100 bulb', 100, 'open', '2026-05-04 23:29:58', '2026-05-04 23:29:58'),
(3, 3, 2, 'Electric wiring', 'Need 500 bulb and 500 fans', 1000, 'open', '2026-05-05 00:47:55', '2026-05-05 00:47:55'),
(4, 1, 2, 'Test RFQ', 'test description', 99, 'open', '2026-05-05 01:46:47', '2026-05-05 01:46:47'),
(5, 6, 3, 'Yearly stock', '100 ear buds and 300 adaptor', 400, 'open', '2026-05-05 20:28:16', '2026-05-05 20:28:16');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2026-05-04 06:05:34', '2026-05-04 06:05:34'),
(2, 'supplier', '2026-05-04 06:05:34', '2026-05-04 06:05:34'),
(3, 'buyer', '2026-05-04 06:06:39', '2026-05-04 06:06:39'),
(4, 'marketing_manager', '2026-05-04 06:07:07', '2026-05-04 06:07:07'),
(5, 'user', '2026-05-05 05:17:07', '2026-05-05 05:17:07'),
(6, 'support_agent', '2026-05-05 12:48:06', '2026-05-05 12:48:06');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('iyv0iodEXof7UitsPJdDUhT0LiRuYFvGWt3NXh6Z', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiemZPazJzQ1NqUnU0aDlsMFFWeUVPOW5ESEtRajNBa0gyOTNncmZxZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYW1wYWlnbnMiO3M6NToicm91dGUiO3M6MTU6ImNhbXBhaWducy5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1778044341);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'module_products', '1', '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(2, 'module_inventory', '1', '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(3, 'module_orders', '1', '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(4, 'module_crm', '1', '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(5, 'module_rfq', '1', '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(6, 'module_workflow', '1', '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(7, 'module_marketing', '1', '2026-05-05 12:48:07', '2026-05-05 12:48:07'),
(8, 'module_social', '1', '2026-05-05 12:48:07', '2026-05-05 13:03:02'),
(9, 'module_support', '1', '2026-05-05 12:48:07', '2026-05-05 13:48:46'),
(10, 'module_suppliers', '1', '2026-05-05 12:48:07', '2026-05-05 12:48:07');

-- --------------------------------------------------------

--
-- Table structure for table `social_accounts`
--

CREATE TABLE `social_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `platform` enum('facebook','instagram') NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `access_token` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('in','out','adjustment') NOT NULL,
  `quantity` int(11) NOT NULL,
  `before_stock` int(11) NOT NULL,
  `after_stock` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `product_id`, `user_id`, `type`, `quantity`, `before_stock`, `after_stock`, `reference`, `note`, `created_at`, `updated_at`) VALUES
(1, 4, 3, 'out', 10, 80, 70, NULL, NULL, '2026-05-04 20:31:32', '2026-05-04 20:31:32'),
(2, 4, 1, 'out', 10, 70, 60, NULL, NULL, '2026-05-05 01:49:18', '2026-05-05 01:49:18'),
(3, 3, 3, 'out', 60, 60, 0, NULL, NULL, '2026-05-05 02:13:19', '2026-05-05 02:13:19'),
(4, 4, 3, 'out', 10, 60, 50, NULL, NULL, '2026-05-05 05:14:16', '2026-05-05 05:14:16'),
(5, 5, 6, 'out', 20, 980, 960, NULL, NULL, '2026-05-05 19:52:27', '2026-05-05 19:52:27'),
(6, 5, 1, 'out', 20, 960, 940, NULL, NULL, '2026-05-05 22:24:31', '2026-05-05 22:24:31'),
(7, 5, 3, 'out', 935, 940, 5, NULL, NULL, '2026-05-05 22:30:28', '2026-05-05 22:30:28'),
(8, 4, 1, 'out', 45, 50, 5, NULL, NULL, '2026-05-05 22:38:04', '2026-05-05 22:38:04'),
(9, 4, 1, 'in', 40, 5, 45, NULL, NULL, '2026-05-05 22:43:01', '2026-05-05 22:43:01'),
(10, 3, 1, 'in', 15, 0, 15, NULL, NULL, '2026-05-05 22:43:41', '2026-05-05 22:43:41'),
(11, 3, 1, 'out', 15, 15, 0, NULL, NULL, '2026-05-05 22:44:06', '2026-05-05 22:44:06');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `business_type` varchar(255) DEFAULT NULL,
  `trade_license` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `user_id`, `company_name`, `contact_person`, `phone`, `email`, `address`, `business_type`, `trade_license`, `status`, `created_at`, `updated_at`, `approved_by`, `approved_at`) VALUES
(2, 2, 'Proxima Electric', 'Rakib Hasan', '01863736943', 'rakib23@gmail.com', 'Banani, Dhaka', 'Electronics', NULL, 'approved', '2026-05-04 07:25:30', '2026-05-04 07:28:33', 1, '2026-05-04 07:28:33'),
(3, 4, 'Apple Inc', 'Amzad Hossain', '04569856', 'amzad23@gmail.com', 'California, USA', 'Technology', NULL, 'approved', '2026-05-04 09:12:01', '2026-05-04 09:15:08', 1, '2026-05-04 09:15:08'),
(4, 5, 'Far', 'Amzad Hossain', '208-498-6912', 'fariha@gmail.com', NULL, NULL, NULL, 'rejected', '2026-05-05 06:43:37', '2026-05-05 06:44:35', NULL, NULL),
(5, 8, 'Acme Fulfillment Ltd.', 'Support Supplier', '+8801800000000', 'supplier.support@example.com', 'Chattogram', 'Wholesale', 'TL-2026-ACME', 'approved', '2026-05-05 11:15:33', '2026-05-05 11:15:33', NULL, '2026-05-05 11:15:33');

-- --------------------------------------------------------

--
-- Table structure for table `support_replies`
--

CREATE TABLE `support_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_replies`
--

INSERT INTO `support_replies` (`id`, `support_ticket_id`, `user_id`, `message`, `is_system`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Thank you. Your request has been received. Our team will contact you soon.', 1, '2026-05-05 11:15:33', '2026-05-05 11:15:33'),
(2, 2, NULL, 'Thank you. Your request has been received. Our team will contact you soon.', 1, '2026-05-05 11:15:34', '2026-05-05 11:15:34'),
(3, 3, NULL, 'Thank you. Your request has been received. Our team will contact you soon.', 1, '2026-05-05 11:15:34', '2026-05-05 11:15:34'),
(4, 3, 1, 'refund', 0, '2026-05-05 11:24:49', '2026-05-05 11:24:49'),
(5, 4, NULL, 'Thank you. Your request has been received. Our team will contact you soon.', 1, '2026-05-05 11:27:48', '2026-05-05 11:27:48'),
(6, 4, 3, 'order', 0, '2026-05-05 11:27:56', '2026-05-05 11:27:56'),
(7, 4, 2, 'ORD-20260505-206595', 0, '2026-05-05 11:36:30', '2026-05-05 11:36:30'),
(8, 4, 3, 'ORD-20260505-206595', 0, '2026-05-05 11:37:06', '2026-05-05 11:37:06'),
(9, 4, 1, 'where is my order?', 0, '2026-05-05 11:59:27', '2026-05-05 11:59:27'),
(10, 4, 3, 'where is my order?', 0, '2026-05-05 12:00:32', '2026-05-05 12:00:32'),
(11, 5, NULL, 'Thank you. Your request has been received. Our team will contact you soon.', 1, '2026-05-05 22:05:04', '2026-05-05 22:05:04'),
(12, 5, 6, 'Where is my order?', 0, '2026-05-05 22:06:22', '2026-05-05 22:06:22'),
(13, 4, 2, 'where is my order?', 0, '2026-05-05 22:28:02', '2026-05-05 22:28:02'),
(14, 4, 3, 'where is my order?', 0, '2026-05-05 22:51:41', '2026-05-05 22:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `category` enum('order','payment','delivery','supplier','general') NOT NULL,
  `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
  `status` enum('open','pending','resolved','closed') NOT NULL DEFAULT 'open',
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `customer_id`, `order_id`, `supplier_id`, `subject`, `message`, `category`, `priority`, `status`, `assigned_to`, `created_at`, `updated_at`) VALUES
(1, 5, 13, NULL, 'Delivery delay on order shipment', 'My delivery is delayed and I need an updated expected delivery date.', 'delivery', 'high', 'open', NULL, '2026-05-05 11:15:33', '2026-05-05 11:15:33'),
(2, 5, 13, NULL, 'Payment reflected twice', 'The payment gateway appears to have charged me twice for the same order.', 'payment', 'urgent', 'pending', NULL, '2026-05-05 11:15:33', '2026-05-05 11:15:33'),
(3, 5, 13, 5, 'Supplier quality complaint', 'The supplier shipment did not match the approved product specification.', 'supplier', 'medium', 'open', NULL, '2026-05-05 11:15:34', '2026-05-05 11:15:34'),
(4, 3, 10, 2, 'order status', 'order', 'order', 'medium', 'open', NULL, '2026-05-05 11:27:45', '2026-05-05 11:27:45'),
(5, 4, 14, 3, 'Order status', 'Where is my order?', 'order', 'medium', 'open', NULL, '2026-05-05 22:05:00', '2026-05-05 22:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`, `status`) VALUES
(1, 'Biplab Hosen', 'biplobhosen214@gmail.com', NULL, '$2y$12$Zasa8Z/4NJfxkOkPXdocauiDeNo4P6XeIe6av/iOL2FpbXd6wjgb.', '9lCA67iMkSmnWOJyEDLviz7XJG41EjZAGR6dg9LR4i4uG1ZpQoWPhgzJ622p', '2026-05-03 04:24:50', '2026-05-04 09:05:31', 1, 'active'),
(2, 'Rakib Hasan', 'rakib23@gmail.com', NULL, '$2y$12$EqlwyAGs28jfKjTYKrwIY.d2auPpQuRj5GL.dmlG5JFCxpGSZYAhe', 'Xk0JDgvn8ktrQ8m7naNocsvM53oSZUNET6inPUPCNMHyElY1EqdtUdN8dJK0', '2026-05-04 07:20:50', '2026-05-04 07:28:33', 2, 'active'),
(3, 'Mehedi Hasan', 'mehedi23@gmail.com', NULL, '$2y$12$TciBjo5sPX3QYi4gh7Q5XOJ53G4wYLfcJwRUdgwaX9zlK0NsMqm8O', 'iIgmKJZ3zuDa6AQXRihjkcR85YLvJ6KEV3Ll9ijnYX91hB2NtCFtIeQV1Dnb', '2026-05-04 09:00:41', '2026-05-04 09:00:41', 3, 'active'),
(4, 'Amzad Hossain', 'amzad23@gmail.com', NULL, '$2y$12$kvuepx0MDcUemoNTwoitE.AvRypW43bJmB70r33knoQxUInpYiSoa', NULL, '2026-05-04 09:09:53', '2026-05-04 09:15:09', 2, 'active'),
(5, 'Fariha', 'fariha@gmail.com', NULL, '$2y$12$a80N1Kk8KrojPkKO0KRsVOP6V93/nWuAZjnPt8lnfdmZCrDbEnaG6', NULL, '2026-05-05 05:17:08', '2026-05-05 12:59:58', 5, 'active'),
(6, 'Aman Amed Durjoy', 'aman23@gmail.com', NULL, '$2y$12$QTL2de3pGiP76/Oz2wX7nuRyC6xm6ZstqFwFScAXxy/ndtIg9.LRa', NULL, '2026-05-05 06:50:26', '2026-05-05 06:50:26', 5, 'active'),
(7, 'Support Buyer', 'buyer.support@example.com', NULL, '$2y$12$9i/n5FuoloGK2xgTXE9vFu.z5.ezlXJiCCgGuvvP/Jtg2a0DJiWlC', NULL, '2026-05-05 11:15:32', '2026-05-05 11:15:32', 3, 'active'),
(8, 'Support Supplier', 'supplier.support@example.com', NULL, '$2y$12$bhEcUIwxSlUrTIo24kax8OHsVvqNsTqCKhuTBdyJMUf.6AN39GmUq', NULL, '2026-05-05 11:15:33', '2026-05-05 11:15:33', 2, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `workflow_logs`
--

CREATE TABLE `workflow_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `automation_rule_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(255) NOT NULL,
  `status` enum('success','failed') NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workflow_logs`
--

INSERT INTO `workflow_logs` (`id`, `automation_rule_id`, `event`, `status`, `message`, `created_at`, `updated_at`) VALUES
(1, 2, 'rfq_created', 'success', '{\"rule\":\"RFQ created supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"rfq_created\",\"rfq_id\":1,\"rfq_title\":\"RFQ-2026-05-IT Infrastructure Modernization\",\"buyer_id\":3,\"buyer_name\":\"Mehedi Hasan\",\"buyer_email\":\"mehedi23@gmail.com\",\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"subject\":\"New RFQ: RFQ-2026-05-IT Infrastructure Modernization\",\"body\":\"A new RFQ titled \'RFQ-2026-05-IT Infrastructure Modernization\' has been created and is awaiting supplier review.\"}}', '2026-05-04 23:16:26', '2026-05-04 23:16:26'),
(2, 2, 'rfq_created', 'success', '{\"rule\":\"RFQ created supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"rfq_created\",\"rfq_id\":1,\"rfq_title\":\"RFQ-2026-05-IT Infrastructure Modernization\",\"buyer_id\":3,\"buyer_name\":\"Mehedi Hasan\",\"buyer_email\":\"mehedi23@gmail.com\",\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"subject\":\"New RFQ: RFQ-2026-05-IT Infrastructure Modernization\",\"body\":\"A new RFQ titled \'RFQ-2026-05-IT Infrastructure Modernization\' has been created and is awaiting supplier review.\"}}', '2026-05-04 23:16:33', '2026-05-04 23:16:33'),
(3, 2, 'rfq_created', 'success', '{\"rule\":\"RFQ created supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"rfq_created\",\"rfq_id\":2,\"rfq_title\":\"Enhance electric system\",\"buyer_id\":1,\"buyer_name\":\"Biplab Hosen\",\"buyer_email\":\"biplobhosen214@gmail.com\",\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"proximaraiments@gmail.com\",\"subject\":\"New RFQ: Enhance electric system\",\"body\":\"A new RFQ titled \'Enhance electric system\' has been created and is awaiting supplier review.\"}}', '2026-05-04 23:29:59', '2026-05-04 23:29:59'),
(4, 2, 'rfq_created', 'success', '{\"rule\":\"RFQ created supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"rfq_created\",\"rfq_id\":2,\"rfq_title\":\"Enhance electric system\",\"buyer_id\":1,\"buyer_name\":\"Biplab Hosen\",\"buyer_email\":\"biplobhosen214@gmail.com\",\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"proximaraiments@gmail.com\",\"subject\":\"New RFQ: Enhance electric system\",\"body\":\"A new RFQ titled \'Enhance electric system\' has been created and is awaiting supplier review.\"}}', '2026-05-04 23:30:04', '2026-05-04 23:30:04'),
(5, 2, 'rfq_created', 'success', '{\"rule\":\"RFQ created supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"rfq_created\",\"rfq_id\":3,\"rfq_title\":\"Electric wiring\",\"buyer_id\":3,\"buyer_name\":\"Mehedi Hasan\",\"buyer_email\":\"mehedi23@gmail.com\",\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"proximaraiments@gmail.com\",\"quantity\":1000,\"title\":\"New RFQ Request\",\"subject\":\"New RFQ: Electric wiring\",\"body\":\"A new RFQ titled \'Electric wiring\' has been created and is awaiting supplier review.\",\"meta\":{\"RFQ ID\":3,\"RFQ Title\":\"Electric wiring\",\"Buyer\":\"Mehedi Hasan\",\"Supplier\":\"Proxima Electric\",\"Quantity\":1000,\"Status\":\"open\"}}}', '2026-05-05 00:47:57', '2026-05-05 00:47:57'),
(6, 2, 'rfq_created', 'success', '{\"rule\":\"RFQ created supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"rfq_created\",\"rfq_id\":4,\"rfq_title\":\"Test RFQ\",\"buyer_id\":1,\"buyer_name\":\"Biplab Hosen\",\"buyer_email\":\"biplobhosen214@gmail.com\",\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"proximaraiments@gmail.com\",\"quantity\":99,\"title\":\"New RFQ Request\",\"subject\":\"New RFQ: Test RFQ\",\"body\":\"A new RFQ titled \'Test RFQ\' has been created and is awaiting supplier review.\",\"meta\":{\"RFQ ID\":4,\"RFQ Title\":\"Test RFQ\",\"Buyer\":\"Biplab Hosen\",\"Supplier\":\"Proxima Electric\",\"Quantity\":99,\"Status\":\"open\"}}}', '2026-05-05 01:46:48', '2026-05-05 01:46:48'),
(7, 1, 'order_placed', 'success', '{\"rule\":\"Order placed email confirmation\",\"action\":\"send_email\",\"context\":{\"event\":\"order_placed\",\"order_id\":9,\"order_number\":\"ORD-20260505-165327\",\"customer_id\":1,\"customer_name\":\"Biplab Hosen\",\"customer_email\":\"biplobhosen214@gmail.com\",\"title\":\"Order ORD-20260505-165327 received\",\"subject\":\"Order ORD-20260505-165327 received\",\"body\":\"Your order ORD-20260505-165327 has been placed successfully and is now in processing.\",\"meta\":{\"Order ID\":9,\"Order Number\":\"ORD-20260505-165327\",\"Customer\":\"Biplab Hosen\",\"Grand Total\":\"3136.00\",\"Status\":\"pending\"}}}', '2026-05-05 01:49:21', '2026-05-05 01:49:21'),
(8, 1, 'order_placed', 'success', '{\"rule\":\"Order placed email confirmation\",\"action\":\"send_email\",\"context\":{\"event\":\"order_placed\",\"order_id\":10,\"order_number\":\"ORD-20260505-206595\",\"customer_id\":3,\"customer_name\":\"Mehedi Hasan\",\"customer_email\":\"mehedi23@gmail.com\",\"title\":\"Order ORD-20260505-206595 received\",\"subject\":\"Order ORD-20260505-206595 received\",\"body\":\"Your order ORD-20260505-206595 has been placed successfully and is now in processing.\",\"meta\":{\"Order ID\":10,\"Order Number\":\"ORD-20260505-206595\",\"Customer\":\"Mehedi Hasan\",\"Grand Total\":\"13500.00\",\"Status\":\"pending\"}}}', '2026-05-05 02:13:21', '2026-05-05 02:13:21'),
(9, 1, 'order_placed', 'success', '{\"rule\":\"Order placed email confirmation\",\"action\":\"send_email\",\"context\":{\"event\":\"order_placed\",\"order_id\":11,\"order_number\":\"ORD-20260505-848657\",\"customer_id\":3,\"customer_name\":\"Mehedi Hasan\",\"customer_email\":\"mehedi23@gmail.com\",\"title\":\"Order ORD-20260505-848657 received\",\"subject\":\"Order ORD-20260505-848657 received\",\"body\":\"Your order ORD-20260505-848657 has been placed successfully and is now in processing.\",\"meta\":{\"Order ID\":11,\"Order Number\":\"ORD-20260505-848657\",\"Customer\":\"Mehedi Hasan\",\"Grand Total\":\"3136.00\",\"Status\":\"pending\"}}}', '2026-05-05 05:14:20', '2026-05-05 05:14:20'),
(10, 1, 'order_placed', 'success', '{\"rule\":\"Order placed email confirmation\",\"action\":\"send_email\",\"context\":{\"event\":\"order_placed\",\"order_id\":14,\"order_number\":\"ORD-20260506-153352\",\"customer_id\":4,\"customer_name\":\"Aman Amed Durjoy\",\"customer_email\":\"aman23@gmail.com\",\"title\":\"Order ORD-20260506-153352 received\",\"subject\":\"Order ORD-20260506-153352 received\",\"body\":\"Your order ORD-20260506-153352 has been placed successfully and is now in processing.\",\"meta\":{\"Order ID\":14,\"Order Number\":\"ORD-20260506-153352\",\"Customer\":\"Aman Amed Durjoy\",\"Grand Total\":\"1900.00\",\"Status\":\"pending\"}}}', '2026-05-05 19:54:07', '2026-05-05 19:54:07'),
(11, 1, 'order_placed', 'success', '{\"rule\":\"Order placed email confirmation\",\"action\":\"send_email\",\"context\":{\"event\":\"order_placed\",\"order_id\":14,\"order_number\":\"ORD-20260506-153352\",\"customer_id\":4,\"customer_name\":\"Aman Amed Durjoy\",\"customer_email\":\"aman23@gmail.com\",\"title\":\"Order ORD-20260506-153352 received\",\"subject\":\"Order ORD-20260506-153352 received\",\"body\":\"Your order ORD-20260506-153352 has been placed successfully and is now in processing.\",\"meta\":{\"Order ID\":14,\"Order Number\":\"ORD-20260506-153352\",\"Customer\":\"Aman Amed Durjoy\",\"Grand Total\":\"1900.00\",\"Status\":\"pending\"}}}', '2026-05-05 19:54:07', '2026-05-05 19:54:07'),
(12, 2, 'rfq_created', 'success', '{\"rule\":\"RFQ created supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"rfq_created\",\"rfq_id\":5,\"rfq_title\":\"Yearly stock\",\"buyer_id\":6,\"buyer_name\":\"Aman Amed Durjoy\",\"buyer_email\":\"aman23@gmail.com\",\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"quantity\":400,\"title\":\"New RFQ Request\",\"subject\":\"New RFQ: Yearly stock\",\"body\":\"A new RFQ titled \'Yearly stock\' has been created and is awaiting supplier review.\",\"meta\":{\"RFQ ID\":5,\"RFQ Title\":\"Yearly stock\",\"Buyer\":\"Aman Amed Durjoy\",\"Supplier\":\"Apple Inc\",\"Quantity\":400,\"Status\":\"open\"}}}', '2026-05-05 20:28:17', '2026-05-05 20:28:17'),
(13, 2, 'rfq_created', 'success', '{\"rule\":\"RFQ created supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"rfq_created\",\"rfq_id\":5,\"rfq_title\":\"Yearly stock\",\"buyer_id\":6,\"buyer_name\":\"Aman Amed Durjoy\",\"buyer_email\":\"aman23@gmail.com\",\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"quantity\":400,\"title\":\"New RFQ Request\",\"subject\":\"New RFQ: Yearly stock\",\"body\":\"A new RFQ titled \'Yearly stock\' has been created and is awaiting supplier review.\",\"meta\":{\"RFQ ID\":5,\"RFQ Title\":\"Yearly stock\",\"Buyer\":\"Aman Amed Durjoy\",\"Supplier\":\"Apple Inc\",\"Quantity\":400,\"Status\":\"open\"}}}', '2026-05-05 20:28:23', '2026-05-05 20:28:23'),
(14, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:14:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:14:03\"}}}', '2026-05-05 22:14:03', '2026-05-05 22:14:03'),
(15, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:14:08\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:14:08\"}}}', '2026-05-05 22:14:08', '2026-05-05 22:14:08'),
(16, 1, 'order_placed', 'success', '{\"rule\":\"Order placed email confirmation\",\"action\":\"send_email\",\"context\":{\"event\":\"order_placed\",\"order_id\":15,\"order_number\":\"ORD-20260506-664784\",\"customer_id\":1,\"customer_name\":\"Biplab \",\"customer_email\":\"biplobhosen214@gmail.com\",\"title\":\"Order ORD-20260506-664784 received\",\"subject\":\"Order ORD-20260506-664784 received\",\"body\":\"Your order ORD-20260506-664784 has been placed successfully and is now in processing.\",\"meta\":{\"Order ID\":15,\"Order Number\":\"ORD-20260506-664784\",\"Customer\":\"Biplab \",\"Grand Total\":\"1900.00\",\"Status\":\"pending\"}}}', '2026-05-05 22:24:35', '2026-05-05 22:24:35'),
(17, 1, 'order_placed', 'success', '{\"rule\":\"Order placed email confirmation\",\"action\":\"send_email\",\"context\":{\"event\":\"order_placed\",\"order_id\":16,\"order_number\":\"ORD-20260506-809160\",\"customer_id\":3,\"customer_name\":\"Mehedi Hasan\",\"customer_email\":\"mehedi23@gmail.com\",\"title\":\"Order ORD-20260506-809160 received\",\"subject\":\"Order ORD-20260506-809160 received\",\"body\":\"Your order ORD-20260506-809160 has been placed successfully and is now in processing.\",\"meta\":{\"Order ID\":16,\"Order Number\":\"ORD-20260506-809160\",\"Customer\":\"Mehedi Hasan\",\"Grand Total\":\"84150.00\",\"Status\":\"pending\"}}}', '2026-05-05 22:30:31', '2026-05-05 22:30:31'),
(18, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:32:14\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:32:14\"}}}', '2026-05-05 22:32:15', '2026-05-05 22:32:15'),
(19, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:32:17\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:32:17\"}}}', '2026-05-05 22:32:17', '2026-05-05 22:32:17'),
(20, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:38:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:38:02\"}}}', '2026-05-05 22:38:02', '2026-05-05 22:38:02'),
(21, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:38:09\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:38:09\"}}}', '2026-05-05 22:38:09', '2026-05-05 22:38:09'),
(22, 1, 'order_placed', 'success', '{\"rule\":\"Order placed email confirmation\",\"action\":\"send_email\",\"context\":{\"event\":\"order_placed\",\"order_id\":17,\"order_number\":\"ORD-20260506-070301\",\"customer_id\":1,\"customer_name\":\"Biplab \",\"customer_email\":\"biplobhosen214@gmail.com\",\"title\":\"Order ORD-20260506-070301 received\",\"subject\":\"Order ORD-20260506-070301 received\",\"body\":\"Your order ORD-20260506-070301 has been placed successfully and is now in processing.\",\"meta\":{\"Order ID\":17,\"Order Number\":\"ORD-20260506-070301\",\"Customer\":\"Biplab \",\"Grand Total\":\"13680.00\",\"Status\":\"pending\"}}}', '2026-05-05 22:38:12', '2026-05-05 22:38:12'),
(23, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:39:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:39:03\"}}}', '2026-05-05 22:39:03', '2026-05-05 22:39:03'),
(24, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":4,\"product_name\":\"Apple ear buds\",\"stock\":5,\"moq\":10,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:39:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Apple ear buds\",\"body\":\"Apple ear buds is at 5 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":4,\"Product Name\":\"Apple ear buds\",\"Current Stock\":5,\"MOQ Threshold\":10,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:39:05\"}}}', '2026-05-05 22:39:05', '2026-05-05 22:39:05'),
(25, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:39:08\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:39:08\"}}}', '2026-05-05 22:39:08', '2026-05-05 22:39:08'),
(26, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:40:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:40:02\"}}}', '2026-05-05 22:40:02', '2026-05-05 22:40:02'),
(27, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":4,\"product_name\":\"Apple ear buds\",\"stock\":5,\"moq\":10,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:40:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Apple ear buds\",\"body\":\"Apple ear buds is at 5 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":4,\"Product Name\":\"Apple ear buds\",\"Current Stock\":5,\"MOQ Threshold\":10,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:40:05\"}}}', '2026-05-05 22:40:05', '2026-05-05 22:40:05'),
(28, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:40:07\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:40:07\"}}}', '2026-05-05 22:40:07', '2026-05-05 22:40:07'),
(29, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:41:17\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:41:17\"}}}', '2026-05-05 22:41:17', '2026-05-05 22:41:17'),
(30, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":4,\"product_name\":\"Apple ear buds\",\"stock\":5,\"moq\":10,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:41:22\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Apple ear buds\",\"body\":\"Apple ear buds is at 5 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":4,\"Product Name\":\"Apple ear buds\",\"Current Stock\":5,\"MOQ Threshold\":10,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:41:22\"}}}', '2026-05-05 22:41:22', '2026-05-05 22:41:22'),
(31, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:41:24\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:41:24\"}}}', '2026-05-05 22:41:24', '2026-05-05 22:41:24'),
(32, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:42:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:42:02\"}}}', '2026-05-05 22:42:02', '2026-05-05 22:42:02'),
(33, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":4,\"product_name\":\"Apple ear buds\",\"stock\":5,\"moq\":10,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:42:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Apple ear buds\",\"body\":\"Apple ear buds is at 5 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":4,\"Product Name\":\"Apple ear buds\",\"Current Stock\":5,\"MOQ Threshold\":10,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:42:05\"}}}', '2026-05-05 22:42:05', '2026-05-05 22:42:05'),
(34, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:42:07\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:42:07\"}}}', '2026-05-05 22:42:07', '2026-05-05 22:42:07'),
(35, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:43:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:43:02\"}}}', '2026-05-05 22:43:02', '2026-05-05 22:43:02'),
(36, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":4,\"product_name\":\"Apple ear buds\",\"stock\":45,\"moq\":10,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:43:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Apple ear buds\",\"body\":\"Apple ear buds is at 45 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":4,\"Product Name\":\"Apple ear buds\",\"Current Stock\":45,\"MOQ Threshold\":10,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:43:03\"}}}', '2026-05-05 22:43:03', '2026-05-05 22:43:03'),
(37, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:43:06\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:43:06\"}}}', '2026-05-05 22:43:06', '2026-05-05 22:43:06'),
(38, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:44:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:44:03\"}}}', '2026-05-05 22:44:04', '2026-05-05 22:44:04'),
(39, 1, 'order_placed', 'success', '{\"rule\":\"Order placed email confirmation\",\"action\":\"send_email\",\"context\":{\"event\":\"order_placed\",\"order_id\":18,\"order_number\":\"ORD-20260506-646951\",\"customer_id\":1,\"customer_name\":\"Biplab \",\"customer_email\":\"biplobhosen214@gmail.com\",\"title\":\"Order ORD-20260506-646951 received\",\"subject\":\"Order ORD-20260506-646951 received\",\"body\":\"Your order ORD-20260506-646951 has been placed successfully and is now in processing.\",\"meta\":{\"Order ID\":18,\"Order Number\":\"ORD-20260506-646951\",\"Customer\":\"Biplab \",\"Grand Total\":\"3675.00\",\"Status\":\"pending\"}}}', '2026-05-05 22:44:10', '2026-05-05 22:44:10'),
(40, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:45:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:45:03\"}}}', '2026-05-05 22:45:03', '2026-05-05 22:45:03'),
(41, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:45:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:45:05\"}}}', '2026-05-05 22:45:05', '2026-05-05 22:45:05'),
(42, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:46:01\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:46:01\"}}}', '2026-05-05 22:46:01', '2026-05-05 22:46:01'),
(43, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:46:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:46:03\"}}}', '2026-05-05 22:46:03', '2026-05-05 22:46:03'),
(44, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:47:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:47:03\"}}}', '2026-05-05 22:47:04', '2026-05-05 22:47:04'),
(45, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:47:06\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:47:06\"}}}', '2026-05-05 22:47:06', '2026-05-05 22:47:06'),
(46, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:48:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:48:03\"}}}', '2026-05-05 22:48:03', '2026-05-05 22:48:03'),
(47, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:48:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:48:05\"}}}', '2026-05-05 22:48:05', '2026-05-05 22:48:05'),
(48, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:49:01\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:49:01\"}}}', '2026-05-05 22:49:01', '2026-05-05 22:49:01'),
(49, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:49:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:49:03\"}}}', '2026-05-05 22:49:03', '2026-05-05 22:49:03'),
(50, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:50:01\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:50:01\"}}}', '2026-05-05 22:50:01', '2026-05-05 22:50:01'),
(51, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:50:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:50:04\"}}}', '2026-05-05 22:50:04', '2026-05-05 22:50:04'),
(52, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:51:01\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:51:01\"}}}', '2026-05-05 22:51:01', '2026-05-05 22:51:01'),
(53, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:51:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:51:03\"}}}', '2026-05-05 22:51:03', '2026-05-05 22:51:03'),
(54, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:52:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:52:03\"}}}', '2026-05-05 22:52:03', '2026-05-05 22:52:03'),
(55, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:52:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:52:05\"}}}', '2026-05-05 22:52:05', '2026-05-05 22:52:05'),
(56, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:53:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:53:03\"}}}', '2026-05-05 22:53:03', '2026-05-05 22:53:03'),
(57, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:53:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:53:05\"}}}', '2026-05-05 22:53:05', '2026-05-05 22:53:05'),
(58, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:54:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:54:02\"}}}', '2026-05-05 22:54:02', '2026-05-05 22:54:02'),
(59, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:54:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:54:04\"}}}', '2026-05-05 22:54:05', '2026-05-05 22:54:05'),
(60, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:55:01\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:55:01\"}}}', '2026-05-05 22:55:01', '2026-05-05 22:55:01'),
(61, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:55:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:55:05\"}}}', '2026-05-05 22:55:06', '2026-05-05 22:55:06'),
(62, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:57:06\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:57:06\"}}}', '2026-05-05 22:57:06', '2026-05-05 22:57:06'),
(63, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:57:08\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:57:08\"}}}', '2026-05-05 22:57:08', '2026-05-05 22:57:08'),
(64, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:57:10\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:57:10\"}}}', '2026-05-05 22:57:10', '2026-05-05 22:57:10'),
(65, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:57:12\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:57:12\"}}}', '2026-05-05 22:57:12', '2026-05-05 22:57:12'),
(66, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:58:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:58:04\"}}}', '2026-05-05 22:58:04', '2026-05-05 22:58:04'),
(67, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:58:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:58:05\"}}}', '2026-05-05 22:58:05', '2026-05-05 22:58:05');
INSERT INTO `workflow_logs` (`id`, `automation_rule_id`, `event`, `status`, `message`, `created_at`, `updated_at`) VALUES
(68, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 04:59:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 04:59:02\"}}}', '2026-05-05 22:59:02', '2026-05-05 22:59:02'),
(69, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 04:59:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 04:59:04\"}}}', '2026-05-05 22:59:04', '2026-05-05 22:59:04'),
(70, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:00:01\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:00:01\"}}}', '2026-05-05 23:00:01', '2026-05-05 23:00:01'),
(71, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:00:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:00:03\"}}}', '2026-05-05 23:00:03', '2026-05-05 23:00:03'),
(72, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:01:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:01:04\"}}}', '2026-05-05 23:01:04', '2026-05-05 23:01:04'),
(73, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:01:06\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:01:06\"}}}', '2026-05-05 23:01:07', '2026-05-05 23:01:07'),
(74, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:02:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:02:04\"}}}', '2026-05-05 23:02:05', '2026-05-05 23:02:05'),
(75, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:02:06\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:02:06\"}}}', '2026-05-05 23:02:06', '2026-05-05 23:02:06'),
(76, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:03:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:03:03\"}}}', '2026-05-05 23:03:03', '2026-05-05 23:03:03'),
(77, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:03:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:03:05\"}}}', '2026-05-05 23:03:05', '2026-05-05 23:03:05'),
(78, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:04:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:04:03\"}}}', '2026-05-05 23:04:03', '2026-05-05 23:04:03'),
(79, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:04:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:04:05\"}}}', '2026-05-05 23:04:05', '2026-05-05 23:04:05'),
(80, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:05:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:05:02\"}}}', '2026-05-05 23:05:02', '2026-05-05 23:05:02'),
(81, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:05:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:05:04\"}}}', '2026-05-05 23:05:04', '2026-05-05 23:05:04'),
(82, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:06:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:06:04\"}}}', '2026-05-05 23:06:04', '2026-05-05 23:06:04'),
(83, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:06:06\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:06:06\"}}}', '2026-05-05 23:06:06', '2026-05-05 23:06:06'),
(84, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:07:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:07:03\"}}}', '2026-05-05 23:07:03', '2026-05-05 23:07:03'),
(85, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:07:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:07:05\"}}}', '2026-05-05 23:07:05', '2026-05-05 23:07:05'),
(86, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:08:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:08:02\"}}}', '2026-05-05 23:08:02', '2026-05-05 23:08:02'),
(87, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:08:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:08:04\"}}}', '2026-05-05 23:08:04', '2026-05-05 23:08:04'),
(88, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:09:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:09:04\"}}}', '2026-05-05 23:09:04', '2026-05-05 23:09:04'),
(89, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:09:07\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:09:07\"}}}', '2026-05-05 23:09:08', '2026-05-05 23:09:08'),
(90, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:10:01\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:10:01\"}}}', '2026-05-05 23:10:01', '2026-05-05 23:10:01'),
(91, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:10:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:10:03\"}}}', '2026-05-05 23:10:03', '2026-05-05 23:10:03'),
(92, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:11:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:11:04\"}}}', '2026-05-05 23:11:04', '2026-05-05 23:11:04'),
(93, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:11:06\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:11:06\"}}}', '2026-05-05 23:11:06', '2026-05-05 23:11:06'),
(94, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:12:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:12:02\"}}}', '2026-05-05 23:12:02', '2026-05-05 23:12:02'),
(95, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:12:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:12:04\"}}}', '2026-05-05 23:12:04', '2026-05-05 23:12:04'),
(96, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:13:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:13:04\"}}}', '2026-05-05 23:13:04', '2026-05-05 23:13:04'),
(97, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:13:06\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:13:06\"}}}', '2026-05-05 23:13:06', '2026-05-05 23:13:06'),
(98, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:14:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:14:02\"}}}', '2026-05-05 23:14:02', '2026-05-05 23:14:02'),
(99, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:14:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:14:05\"}}}', '2026-05-05 23:14:05', '2026-05-05 23:14:05'),
(100, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:15:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:15:02\"}}}', '2026-05-05 23:15:03', '2026-05-05 23:15:03'),
(101, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:15:06\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:15:06\"}}}', '2026-05-05 23:15:06', '2026-05-05 23:15:06'),
(102, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:16:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:16:03\"}}}', '2026-05-05 23:16:04', '2026-05-05 23:16:04'),
(103, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:16:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:16:05\"}}}', '2026-05-05 23:16:05', '2026-05-05 23:16:05'),
(104, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:17:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:17:02\"}}}', '2026-05-05 23:17:02', '2026-05-05 23:17:02'),
(105, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:17:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:17:03\"}}}', '2026-05-05 23:17:03', '2026-05-05 23:17:03'),
(106, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:18:03\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:18:03\"}}}', '2026-05-05 23:18:04', '2026-05-05 23:18:04'),
(107, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:18:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:18:05\"}}}', '2026-05-05 23:18:05', '2026-05-05 23:18:05'),
(108, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:19:02\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:19:02\"}}}', '2026-05-05 23:19:03', '2026-05-05 23:19:03'),
(109, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:19:05\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:19:05\"}}}', '2026-05-05 23:19:05', '2026-05-05 23:19:05'),
(110, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:20:01\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:20:01\"}}}', '2026-05-05 23:20:01', '2026-05-05 23:20:01'),
(111, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:20:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:20:04\"}}}', '2026-05-05 23:20:04', '2026-05-05 23:20:04'),
(112, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":3,\"product_name\":\"Super star bulb 12w\",\"stock\":0,\"moq\":10,\"supplier_id\":2,\"supplier_name\":\"Proxima Electric\",\"supplier_email\":\"rakib23@gmail.com\",\"detected_at\":\"2026-05-06 05:21:01\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Super star bulb 12w\",\"body\":\"Super star bulb 12w is at 0 units, which is at or below the MOQ threshold of 10.\",\"meta\":{\"Product ID\":3,\"Product Name\":\"Super star bulb 12w\",\"Current Stock\":0,\"MOQ Threshold\":10,\"Supplier\":\"Proxima Electric\",\"Detected At\":\"2026-05-06 05:21:01\"}}}', '2026-05-05 23:21:01', '2026-05-05 23:21:01'),
(113, 3, 'stock_low', 'success', '{\"rule\":\"Low stock supplier notification\",\"action\":\"notify_supplier\",\"context\":{\"event\":\"stock_low\",\"product_id\":5,\"product_name\":\"Adaptor 30w\",\"stock\":5,\"moq\":20,\"supplier_id\":3,\"supplier_name\":\"Apple Inc\",\"supplier_email\":\"amzad23@gmail.com\",\"detected_at\":\"2026-05-06 05:21:04\",\"title\":\"Inventory Warning\",\"subject\":\"Low stock alert: Adaptor 30w\",\"body\":\"Adaptor 30w is at 5 units, which is at or below the MOQ threshold of 20.\",\"meta\":{\"Product ID\":5,\"Product Name\":\"Adaptor 30w\",\"Current Stock\":5,\"MOQ Threshold\":20,\"Supplier\":\"Apple Inc\",\"Detected At\":\"2026-05-06 05:21:04\"}}}', '2026-05-05 23:21:05', '2026-05-05 23:21:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `automation_rules`
--
ALTER TABLE `automation_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `automation_rules_event_is_active_index` (`event`,`is_active`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaigns_created_by_foreign` (`created_by`),
  ADD KEY `campaigns_scheduled_at_index` (`scheduled_at`),
  ADD KEY `campaigns_status_index` (`status`),
  ADD KEY `campaigns_trigger_event_index` (`trigger_event`),
  ADD KEY `campaigns_is_active_index` (`is_active`);

--
-- Indexes for table `campaign_logs`
--
ALTER TABLE `campaign_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaign_logs_campaign_id_foreign` (`campaign_id`),
  ADD KEY `campaign_logs_executed_at_index` (`executed_at`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_user_id_foreign` (`user_id`);

--
-- Indexes for table `customer_notes`
--
ALTER TABLE `customer_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_notes_user_id_foreign` (`user_id`),
  ADD KEY `customer_notes_customer_id_created_at_index` (`customer_id`,`created_at`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leads_assigned_to_foreign` (`assigned_to`),
  ADD KEY `leads_status_assigned_to_index` (`status`,`assigned_to`);

--
-- Indexes for table `message_templates`
--
ALTER TABLE `message_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `rfqs`
--
ALTER TABLE `rfqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rfqs_buyer_id_status_index` (`buyer_id`,`status`),
  ADD KEY `rfqs_supplier_id_status_index` (`supplier_id`,`status`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `social_accounts`
--
ALTER TABLE `social_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `social_accounts_platform_index` (`platform`),
  ADD KEY `social_accounts_is_active_index` (`is_active`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_movements_user_id_foreign` (`user_id`),
  ADD KEY `stock_movements_product_id_type_index` (`product_id`,`type`),
  ADD KEY `stock_movements_created_at_index` (`created_at`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_user_id_foreign` (`user_id`),
  ADD KEY `suppliers_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `support_replies`
--
ALTER TABLE `support_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_replies_user_id_foreign` (`user_id`),
  ADD KEY `support_replies_support_ticket_id_created_at_index` (`support_ticket_id`,`created_at`),
  ADD KEY `support_replies_is_system_index` (`is_system`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_tickets_assigned_to_foreign` (`assigned_to`),
  ADD KEY `support_tickets_status_created_at_index` (`status`,`created_at`),
  ADD KEY `support_tickets_category_priority_index` (`category`,`priority`),
  ADD KEY `support_tickets_supplier_id_index` (`supplier_id`),
  ADD KEY `support_tickets_customer_id_index` (`customer_id`),
  ADD KEY `support_tickets_order_id_index` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_status_index` (`status`);

--
-- Indexes for table `workflow_logs`
--
ALTER TABLE `workflow_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workflow_logs_automation_rule_id_foreign` (`automation_rule_id`),
  ADD KEY `workflow_logs_event_status_index` (`event`,`status`),
  ADD KEY `workflow_logs_created_at_index` (`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `automation_rules`
--
ALTER TABLE `automation_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `campaign_logs`
--
ALTER TABLE `campaign_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer_notes`
--
ALTER TABLE `customer_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `message_templates`
--
ALTER TABLE `message_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rfqs`
--
ALTER TABLE `rfqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `social_accounts`
--
ALTER TABLE `social_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `support_replies`
--
ALTER TABLE `support_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `workflow_logs`
--
ALTER TABLE `workflow_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `campaigns_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `campaign_logs`
--
ALTER TABLE `campaign_logs`
  ADD CONSTRAINT `campaign_logs_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `customer_notes`
--
ALTER TABLE `customer_notes`
  ADD CONSTRAINT `customer_notes_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rfqs`
--
ALTER TABLE `rfqs`
  ADD CONSTRAINT `rfqs_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rfqs_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `stock_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_movements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `suppliers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_replies`
--
ALTER TABLE `support_replies`
  ADD CONSTRAINT `support_replies_support_ticket_id_foreign` FOREIGN KEY (`support_ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `support_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `support_tickets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `support_tickets_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `support_tickets_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `workflow_logs`
--
ALTER TABLE `workflow_logs`
  ADD CONSTRAINT `workflow_logs_automation_rule_id_foreign` FOREIGN KEY (`automation_rule_id`) REFERENCES `automation_rules` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
