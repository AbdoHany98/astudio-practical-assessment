-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 09:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `astudio`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('text','date','number','select') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Priority', 'select', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(2, 'Difficulty', 'select', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(3, 'Due Date', 'date', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(4, 'Budget', 'number', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(5, 'Client Notes', 'text', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(6, 'Priority', 'text', '2025-03-06 17:08:27', '2025-03-06 17:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_values`
--

CREATE TABLE `attribute_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `entity_id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_values`
--

INSERT INTO `attribute_values` (`id`, `attribute_id`, `entity_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'High', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(2, 2, 1, 'Easy', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(3, 3, 1, '2025-04-02', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(4, 4, 1, '29013', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(5, 5, 1, 'Sample text for Client Notes on project Website Redesign', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(6, 1, 2, 'Medium', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(7, 2, 2, 'Hard', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(8, 3, 2, '2025-04-09', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(9, 4, 2, '5909', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(10, 5, 2, 'Sample text for Client Notes on project Mobile App Development', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(11, 1, 3, 'High', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(12, 2, 3, 'Medium', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(13, 3, 3, '2025-03-20', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(14, 4, 3, '23783', '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(15, 5, 3, 'Sample text for Client Notes on project Database Migration', '2025-03-06 17:08:27', '2025-03-06 17:08:27');

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
('laravel_cache_7719a1c782a1ba91c031a682a0a2f8658209adbf', 'i:1;', 1741143920),
('laravel_cache_7719a1c782a1ba91c031a682a0a2f8658209adbf:timer', 'i:1741143920;', 1741143920);

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
(4, '2025_03_04_004444_create_projects_table', 1),
(5, '2025_03_04_004622_create_timesheets_table', 1),
(6, '2025_03_04_010726_create_attributes_table', 1),
(7, '2025_03_04_010733_create_attribute_values_table', 1),
(8, '2025_03_04_012213_create_project_user_table', 2),
(9, '2025_03_04_012637_create_oauth_auth_codes_table', 3),
(10, '2025_03_04_012638_create_oauth_access_tokens_table', 3),
(11, '2025_03_04_012639_create_oauth_refresh_tokens_table', 3),
(12, '2025_03_04_012640_create_oauth_clients_table', 3),
(13, '2025_03_04_012641_create_oauth_personal_access_clients_table', 3),
(14, '2025_03_05_041951_alter_table__users_add_is_admin_column', 4);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0442f45373cc464de4945a2f63bf4962d053a3fdd1da11b5985b94c7e823a9602d55084b0c3996a8', 5, 1, 'API Token', '[]', 1, '2025-03-06 15:32:02', '2025-03-06 15:32:14', '2026-03-06 17:32:02'),
('139f7f28e538d1a61c2d624e7eaf30670ef811ac94c1911f60bcbd208a88d7d8d622e1f2b23e8dcd', 2, 1, 'API Token', '[]', 0, '2025-03-06 18:08:02', '2025-03-06 18:08:02', '2026-03-06 20:08:02'),
('17b43bce2493a83e9020fa4a5c32f4f4a434e8f4085877a169b7dcdfcff47d180af417b748dd7318', 29, 1, 'API Token', '[]', 0, '2025-03-05 01:10:56', '2025-03-05 01:10:56', '2026-03-05 03:10:56'),
('18c290534199da126261090a6e301666fd36ecc153bacc2aa9f69784920d8edafa7f03d0a3a43531', 1, 1, 'API Token', '[]', 0, '2025-03-05 01:31:14', '2025-03-05 01:31:15', '2026-03-05 03:31:14'),
('3101bc2f4fcaff59e560ae8f46d210c7011c744ee6a0568cce3b117dc0193ec3e0c862552194a81c', 3, 1, 'API Token', '[]', 0, '2025-03-05 02:53:38', '2025-03-05 02:53:38', '2026-03-05 04:53:38'),
('3c82bd47ce0dad7955175d2ae47d2804b6e17f575cd027ca46840fab95d1a4b61dfac4f7cdf9224a', 38, 1, 'API Token', '[]', 0, '2025-03-05 01:05:09', '2025-03-05 01:05:09', '2026-03-05 03:05:09'),
('592b8da3f71695a952165295a6c1120d7ef95eb6db909ee7a2f14ef59a9f3052fdb6d78ee391ff84', 1, 1, 'API Token', '[]', 0, '2025-03-05 02:50:06', '2025-03-05 02:50:06', '2026-03-05 04:50:06'),
('5c2c45dbe7d919723947be4c9d371989731dd8214cc8e795b564a0867c37a5ada1c68b4eafd12f85', 1, 1, 'API Token', '[]', 0, '2025-03-06 18:12:45', '2025-03-06 18:12:45', '2026-03-06 20:12:45'),
('84ab509e6face3564fe6cc51e3649eb539e1eacb88c14ad06fba4062bccb7ad47dc5065855c24437', 29, 1, 'API Token', '[]', 0, '2025-03-05 01:11:22', '2025-03-05 01:11:22', '2026-03-05 03:11:22'),
('88ce11ec8040c80cfd9f7c44e764e317186bb2f9b0cf0197a77fa4cadefc172f8ed2be78c89f91f7', 4, 1, 'API Token', '[]', 0, '2025-03-05 15:26:25', '2025-03-05 15:26:25', '2026-03-05 17:26:25'),
('8a7b1958681488fb678c78d1d73e065fb0f0e826816b3aba287f6ab2decd941516625b9dff5e8eff', 40, 1, 'API Token', '[]', 1, '2025-03-05 01:06:03', '2025-03-05 01:13:49', '2026-03-05 03:06:03'),
('9dc64fce329aa0b251012bf82e7f1d4d491569155b1b5e4b8132f8192354bd3469d3e9a1db6256dc', 3, 1, 'API Token', '[]', 0, '2025-03-05 15:01:07', '2025-03-05 15:01:07', '2026-03-05 17:01:07'),
('a5d93f7dc56331d6bfbdff8db47bd5359482093c8790b0cd517344a4aa09d22d53226787aa9618c2', 39, 1, 'API Token', '[]', 0, '2025-03-05 01:05:27', '2025-03-05 01:05:27', '2026-03-05 03:05:27'),
('a6af7435af81a9f9cf29ca664defcd4cfcb6017bd79096e2725e6e704ec022e068f05e10c9fc02dc', 2, 1, 'API Token', '[]', 0, '2025-03-05 02:29:11', '2025-03-05 02:29:11', '2026-03-05 04:29:11'),
('aa1a366d39d67e7eb180242050b16f3d2de6de29cabab4f3b5bd361f124bca8953ca4601da4ff65e', 29, 1, 'API Token', '[]', 0, '2025-03-05 01:11:59', '2025-03-05 01:11:59', '2026-03-05 03:11:59'),
('ad2596873257d9d9b3ab1e38e10857631a917c3fc558e689fade85abfdbdd0cebdd90e42d59a020c', 1, 1, 'API Token', '[]', 0, '2025-03-05 15:01:38', '2025-03-05 15:01:38', '2026-03-05 17:01:38'),
('bb6fe23963113592f572006ab1141df8d2cf708a6603b87a25238b289b1c21b1aa53f2a48b55d4f1', 6, 1, 'API Token', '[]', 0, '2025-03-06 15:31:44', '2025-03-06 15:31:44', '2026-03-06 17:31:44'),
('c410d68f5f6c08b4d9411a71b8a0878b404e3823851f2cba54a5cfc2cd1c58920b0e455ec507cdd0', 1, 1, 'API Token', '[]', 1, '2025-03-05 01:30:23', '2025-03-05 01:30:40', '2026-03-05 03:30:23'),
('f0b59896318deb7c6b376ecbf76d3835caa473bb54fac470f33c19aea5994af0940d029bcfaae43f', 2, 1, 'API Token', '[]', 0, '2025-03-05 02:50:31', '2025-03-05 02:50:31', '2026-03-05 04:50:31'),
('ff78478261fda3f9b5da7f03eb9f54dc28fa2b8a64993c1f34ebe3423d4cf99ae4a62ab22a2028e4', 5, 1, 'API Token', '[]', 0, '2025-03-06 15:31:25', '2025-03-06 15:31:25', '2026-03-06 17:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'addgTPfq74sMxZWA8FLwU898boGreGN9wTE03FYa', NULL, 'http://localhost', 1, 0, 0, '2025-03-03 23:27:09', '2025-03-03 23:27:09'),
(2, NULL, 'Laravel Password Grant Client', 'oRXEGwpOHNVkEim1LROjdCLXIqtaIpygnPP53g9C', 'users', 'http://localhost', 0, 1, 0, '2025-03-03 23:27:09', '2025-03-03 23:27:09');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-03-03 23:27:09', '2025-03-03 23:27:09');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Website Redesign', 'in_progress', '2025-03-06 17:08:26', '2025-03-06 17:08:26'),
(2, 'Mobile App Development', 'planning', '2025-03-06 17:08:26', '2025-03-06 17:08:26'),
(3, 'Database Migration', 'not_started', '2025-03-06 17:08:26', '2025-03-06 17:08:26');

-- --------------------------------------------------------

--
-- Table structure for table `project_user`
--

CREATE TABLE `project_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_user`
--

INSERT INTO `project_user` (`id`, `user_id`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-03-06 17:08:26', '2025-03-06 17:08:26'),
(2, 4, 1, '2025-03-06 17:08:26', '2025-03-06 17:08:26'),
(3, 3, 1, '2025-03-06 17:08:26', '2025-03-06 17:08:26'),
(4, 1, 2, '2025-03-06 17:08:26', '2025-03-06 17:08:26'),
(5, 3, 2, '2025-03-06 17:08:26', '2025-03-06 17:08:26'),
(6, 3, 3, '2025-03-06 17:08:26', '2025-03-06 17:08:26'),
(7, 1, 3, '2025-03-06 17:08:26', '2025-03-06 17:08:26'),
(8, 2, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(9, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(10, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(11, 2, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(12, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(13, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(14, 2, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(15, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(16, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(17, 2, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(18, 2, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(19, 2, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(20, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(21, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(22, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(23, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(24, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(25, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(26, 2, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(27, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(28, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27');

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
('sYg6kPoB0ifUCrnC8B20isYN8Dpihj1vSJP1fkxV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT1g4Nk9lOFF6djlWeVc2UFFBU1ZLd21rSjBVbU9sc3JPTFRwOTNaRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1741125808);

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE `timesheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `hours` decimal(5,2) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timesheets`
--

INSERT INTO `timesheets` (`id`, `name`, `date`, `hours`, `user_id`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 'Worked on Website Redesign - Code review', '2025-02-14', 7.00, 1, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(2, 'Worked on Website Redesign - Frontend development', '2025-02-26', 8.00, 2, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(3, 'Worked on Website Redesign - Backend integration', '2025-03-06', 8.00, 3, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(4, 'Worked on Mobile App Development - Code review', '2025-02-04', 5.00, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(5, 'Worked on Database Migration - Bug fixing', '2025-02-24', 5.00, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(6, 'Worked on Mobile App Development - Documentation', '2025-02-28', 2.00, 1, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(7, 'Worked on Website Redesign - Research', '2025-02-04', 2.00, 1, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(8, 'Worked on Database Migration - Client meeting', '2025-03-02', 1.00, 3, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(9, 'Worked on Database Migration - Client meeting', '2025-02-05', 2.00, 1, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(10, 'Worked on Website Redesign - Documentation', '2025-02-24', 5.00, 1, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(11, 'Worked on Database Migration - Code review', '2025-02-05', 4.00, 2, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(12, 'Worked on Database Migration - Testing', '2025-02-21', 4.00, 3, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(13, 'Worked on Database Migration - Research', '2025-02-27', 5.00, 3, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(14, 'Worked on Database Migration - Code review', '2025-02-06', 5.00, 1, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(15, 'Worked on Database Migration - Documentation', '2025-03-05', 8.00, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(16, 'Worked on Mobile App Development - Client meeting', '2025-02-13', 5.00, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(17, 'Worked on Database Migration - Deployment preparation', '2025-02-19', 7.00, 3, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(18, 'Worked on Database Migration - Documentation', '2025-02-21', 4.00, 3, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(19, 'Worked on Database Migration - Backend integration', '2025-03-03', 6.00, 1, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(20, 'Worked on Website Redesign - Code review', '2025-02-07', 8.00, 1, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(21, 'Worked on Website Redesign - Code review', '2025-02-05', 1.00, 2, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(22, 'Worked on Database Migration - Documentation', '2025-02-22', 1.00, 1, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(23, 'Worked on Database Migration - Client meeting', '2025-02-06', 8.00, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(24, 'Worked on Mobile App Development - Backend integration', '2025-03-02', 5.00, 3, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(25, 'Worked on Database Migration - Bug fixing', '2025-02-16', 2.00, 1, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(26, 'Worked on Website Redesign - Bug fixing', '2025-03-03', 4.00, 3, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(27, 'Worked on Mobile App Development - Client meeting', '2025-02-21', 7.00, 3, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(28, 'Worked on Database Migration - Code review', '2025-02-18', 3.00, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(29, 'Worked on Website Redesign - Bug fixing', '2025-02-18', 1.00, 3, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(30, 'Worked on Website Redesign - Backend integration', '2025-02-17', 7.00, 2, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(31, 'Worked on Website Redesign - Code review', '2025-02-17', 5.00, 2, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(32, 'Worked on Mobile App Development - Testing', '2025-02-06', 3.00, 2, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(33, 'Worked on Mobile App Development - Research', '2025-02-15', 3.00, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(34, 'Worked on Database Migration - Bug fixing', '2025-03-06', 7.00, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(35, 'Worked on Website Redesign - Testing', '2025-02-20', 1.00, 3, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(36, 'Worked on Mobile App Development - Client meeting', '2025-02-28', 5.00, 3, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(37, 'Worked on Mobile App Development - Frontend development', '2025-02-18', 3.00, 1, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(38, 'Worked on Mobile App Development - Documentation', '2025-02-12', 4.00, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(39, 'Worked on Database Migration - Client meeting', '2025-02-07', 7.00, 3, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(40, 'Worked on Website Redesign - Bug fixing', '2025-03-04', 8.00, 1, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(41, 'Worked on Website Redesign - Testing', '2025-03-02', 7.00, 1, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(42, 'Worked on Mobile App Development - Frontend development', '2025-03-06', 8.00, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(43, 'Worked on Mobile App Development - Frontend development', '2025-03-05', 8.00, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(44, 'Worked on Database Migration - Documentation', '2025-02-14', 1.00, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(45, 'Worked on Mobile App Development - Documentation', '2025-02-27', 2.00, 2, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(46, 'Worked on Website Redesign - Research', '2025-02-10', 6.00, 3, 1, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(47, 'Worked on Database Migration - Testing', '2025-03-04', 8.00, 3, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(48, 'Worked on Mobile App Development - Code review', '2025-02-17', 6.00, 4, 2, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(49, 'Worked on Database Migration - Backend integration', '2025-02-12', 8.00, 4, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27'),
(50, 'Worked on Database Migration - Design implementation', '2025-02-22', 2.00, 3, 3, '2025-03-06 17:08:27', '2025-03-06 17:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`, `is_admin`) VALUES
(1, 'Admin', 'User', 'admin@example.com', '$2y$12$GwjA.OXMJV4j7NssF5HrSek82qtXoqNAoSA3AKl..iH7NvUlHSJla', '2025-03-06 17:08:25', '2025-03-06 17:08:25', 1),
(2, 'John', 'Doe', 'john@example.com', '$2y$12$UA/Ky2HJ2Aeu/Xob9wVTwub5IOoRsJRrF1NChmr2zyPioU8VXty7K', '2025-03-06 17:08:25', '2025-03-06 17:08:25', 0),
(3, 'Jane', 'Smith', 'jane@example.com', '$2y$12$7GSn0TL97sMCdtVmtu5zm.1PGoSO7oeUtC1D1zLlsApIYM5maGHFK', '2025-03-06 17:08:25', '2025-03-06 17:08:25', 0),
(4, 'Mike', 'Johnson', 'mike@example.com', '$2y$12$WEyj3ag/52YuaTQwZIAB8.pG7BkpPxMY9o5XIKYdGaYf461Vz3dza', '2025-03-06 17:08:25', '2025-03-06 17:08:25', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_values_attribute_id_foreign` (`attribute_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_user`
--
ALTER TABLE `project_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_user_user_id_foreign` (`user_id`),
  ADD KEY `project_user_project_id_foreign` (`project_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timesheets_user_id_foreign` (`user_id`),
  ADD KEY `timesheets_project_id_foreign` (`project_id`);

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
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `attribute_values`
--
ALTER TABLE `attribute_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project_user`
--
ALTER TABLE `project_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD CONSTRAINT `attribute_values_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_user`
--
ALTER TABLE `project_user`
  ADD CONSTRAINT `project_user_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD CONSTRAINT `timesheets_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timesheets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
