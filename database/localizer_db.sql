-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2026 at 12:02 PM
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
-- Database: `localizer_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `preview_url` text DEFAULT NULL,
  `type` enum('government','company','all') NOT NULL DEFAULT 'government',
  `is_coming_soon` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `title`, `subtitle`, `description`, `link`, `badge`, `preview_url`, `type`, `is_coming_soon`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(7, ' \"عنوان الكارد\",', ' \"عنوان فرعي\",', ' \"وصف الكارد\",', 'https://wellconcept.co/wp/portlu-light/minimal-portfolio-onepage/', ' \"جديد\",', NULL, 'company', 1, 1, 0, '2026-01-06 20:38:31', '2026-01-06 20:38:31'),
(8, ' \"عنوان الكارد\",', ' \"عنوان فرعي\",', ' \"وصف الكارد\",', 'https://wellconcept.co/wp/portlu-light/minimal-portfolio-onepage/', ' \"جديد\",', NULL, 'company', 1, 1, 0, '2026-01-06 20:42:42', '2026-01-06 20:42:42'),
(9, ' \"عنوان الكارد\",', ' \"عنوان فرعي\",', ' \"وصف الكارد\",', 'https://wellconcept.co/wp/portlu-light/minimal-portfolio-onepage/', ' \"جديد\",', NULL, 'company', 1, 1, 0, '2026-01-06 20:47:47', '2026-01-06 20:47:47'),
(10, ' \"عنوان الكارد\",', ' \"عنوان فرعي\",', ' \"وصف الكارد\",', 'https://wellconcept.co/wp/portlu-light/minimal-portfolio-onepage/', ' \"جديد\",', NULL, 'company', 1, 1, 0, '2026-01-06 20:51:43', '2026-01-06 20:51:43'),
(11, ' \"عنوان الكارد\",', ' \"عنوان فرعي\",', ' \"وصف الكارد\",', 'https://wellconcept.co/wp/portlu-light/minimal-portfolio-onepage/', ' \"جديد\",', 'http://willene-unmiasmatic-tiffaney.ngrok-free.dev/storage/cards/f382ZTTt4Wa9CuejQIrDK4FSvdnkmaZBw10NJdVv.jpg', 'company', 1, 1, 0, '2026-01-06 20:55:37', '2026-01-06 20:55:37'),
(12, ' \"عنوان الكارد\",', ' \"عنوان فرعي\",', ' \"وصف الكارد\",', 'https://wellconcept.co/wp/portlu-light/minimal-portfolio-onepage/', ' \"جديد\",', 'http://willene-unmiasmatic-tiffaney.ngrok-free.dev/storage/cards/Zt1zSPtFszUFG4Kxg8SuutWT0i4Qa5SIop493go2.jpg', 'company', 1, 1, 0, '2026-01-06 21:00:33', '2026-01-06 21:00:33'),
(13, ' \"عنوان الكارد\",', ' \"عنوان فرعي\",', ' \"وصف الكارد\",', 'https://wellconcept.co/wp/portlu-light/minimal-portfolio-onepage/', ' \"جديد\",', 'http://willene-unmiasmatic-tiffaney.ngrok-free.dev/storage/cards/IY70HOKN146iW7gSqpR8ZADfisP3U16jng3GSz8g.jpg', 'company', 1, 1, 0, '2026-01-06 21:12:33', '2026-01-06 21:12:33'),
(28, 'بلا صورة و  بلا رابط', 'بلا صورة و  بلا رابط', 'بلا صورة و  بلا رابط', '', NULL, NULL, 'government', 0, 1, 1, '2026-01-12 07:47:26', '2026-01-12 07:47:26'),
(31, 'مع صورة وبلا رابط', 'مع صورة وبلا رابط', 'مع صورة وبلا رابط', '', NULL, 'http://willene-unmiasmatic-tiffaney.ngrok-free.dev/storage/cards/card_6964b86b77607.jpg', 'company', 0, 1, 1, '2026-01-12 08:01:31', '2026-01-12 08:01:31'),
(32, 'مع رابط وبلا صورة', 'مع رابط وبلا صورة', 'مع رابط وبلا صورة', 'https://www.google.com/', NULL, NULL, 'government', 0, 1, 1, '2026-01-12 08:06:43', '2026-01-12 08:06:43'),
(33, 'مع صورة ومع رابط', 'مع صورة ومع رابط', 'مع صورة ومع رابط', 'https://www.google.com/', NULL, 'http://willene-unmiasmatic-tiffaney.ngrok-free.dev/storage/cards/card_6964be86e48be.jpg', 'all', 0, 1, 1, '2026-01-12 08:27:34', '2026-01-12 08:27:34');

-- --------------------------------------------------------

--
-- Table structure for table `legislations`
--

CREATE TABLE `legislations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `rate` int(10) UNSIGNED NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `legislations`
--

INSERT INTO `legislations` (`id`, `name`, `email`, `rate`, `review`, `created_at`, `updated_at`) VALUES
(2, 'فاطمة علي', 'fatima@example.com', 4, 'تجربة جيدة جداً، لكن يمكن تحسين بعض النقاط', '2025-12-21 17:12:31', '2025-12-21 17:12:31'),
(3, 'محمد خالد', NULL, 5, 'رائع جداً، شكراً لكم على هذه الخدمة المميزة', '2025-12-21 17:12:31', '2025-12-21 17:12:31'),
(4, 'سارة أحمد', 'sara@example.com', 3, 'جيد ولكن يحتاج إلى بعض التحسينات', '2025-12-21 17:12:31', '2025-12-21 17:12:31'),
(5, 'أحمد محمد', 'ahmed@example.com', 5, 'خدمة ممتازة وسريعة، أنصح الجميع بالاستفادة منها', '2026-01-07 07:09:42', '2026-01-07 07:09:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth-token', '5923d6a39d939d58f19c0d9e11fdf6528ffda00aa8aae49373130c7078dbc6d4', '[\"*\"]', NULL, NULL, '2025-12-21 17:28:10', '2025-12-21 17:28:10'),
(2, 'App\\Models\\User', 1, 'auth-token', 'b964123468362048300aed2a32ea1ee044b6cb83d827fd7a94f2cbab3911a1d0', '[\"*\"]', NULL, NULL, '2026-01-06 12:07:22', '2026-01-06 12:07:22'),
(3, 'App\\Models\\User', 1, 'auth-token', 'fc4dfde6694f6b07d39a6f855ba5b8fe5c27ac6132fd7dc3e567dd78dfef6526', '[\"*\"]', NULL, NULL, '2026-01-06 12:17:18', '2026-01-06 12:17:18'),
(4, 'App\\Models\\User', 1, 'auth-token', '2f22a66bf5bbeb34ede7b6d485058a0900a39c670ce61cbdb4ba8a7f11590ade', '[\"*\"]', NULL, NULL, '2026-01-06 12:36:26', '2026-01-06 12:36:26'),
(5, 'App\\Models\\User', 1, 'auth-token', 'b144334b25dc16f982b51e3954d5d43afdd945904a1216a007f67f45f6a6e57b', '[\"*\"]', NULL, NULL, '2026-01-06 12:49:59', '2026-01-06 12:49:59'),
(6, 'App\\Models\\User', 1, 'auth-token', 'e8dcf42f7cdbe535d6923f9dd42642c07905a8a4eb0dfc2df0e49d41fdba2055', '[\"*\"]', NULL, NULL, '2026-01-06 12:55:57', '2026-01-06 12:55:57'),
(7, 'App\\Models\\User', 1, 'auth-token', '65c706cb118bdef21fd6870d8ff14efb0097723d5c1c6427c8047ca016762447', '[\"*\"]', NULL, NULL, '2026-01-06 13:23:53', '2026-01-06 13:23:53'),
(9, 'App\\Models\\User', 1, 'auth-token', '7380830a81f9c0cc8f6731fb149e8eaeed694f4f542795f1cddbfc88a72fc989', '[\"*\"]', '2026-01-07 07:10:05', NULL, '2026-01-07 06:57:27', '2026-01-07 07:10:05'),
(10, 'App\\Models\\User', 1, 'auth-token', '1da2238819afa5e7aa35f81dd5f2fb556393094f25c7c73617cf56728a40acc6', '[\"*\"]', NULL, NULL, '2026-01-07 10:02:03', '2026-01-07 10:02:03'),
(11, 'App\\Models\\User', 1, 'auth-token', '105f08377c972e849e308ebd500bcb162ac85f5e494537389a109fe3b3997dfe', '[\"*\"]', NULL, NULL, '2026-01-07 10:18:28', '2026-01-07 10:18:28'),
(12, 'App\\Models\\User', 1, 'auth-token', '8ac3dfe9c9e9b9700e9e3434fa9e53037cacb64d0326cc686e769bb14d1980ef', '[\"*\"]', NULL, NULL, '2026-01-07 11:12:40', '2026-01-07 11:12:40'),
(13, 'App\\Models\\User', 1, 'auth-token', '84d80fab8371692e0361f717705cfc92cffdcc1dbe3278468d187d3c6d2325d1', '[\"*\"]', '2026-01-12 07:54:22', NULL, '2026-01-11 08:47:06', '2026-01-12 07:54:22'),
(14, 'App\\Models\\User', 1, 'auth-token', '9c2d713d6d750589da2ea0e7880e7d2040c30c63ad33bf5149026c9e4306d02a', '[\"*\"]', '2026-01-11 09:14:55', NULL, '2026-01-11 09:06:05', '2026-01-11 09:14:55'),
(15, 'App\\Models\\User', 1, 'auth-token', 'd9869acc46cb552508426047717025c3bc112e15a2bf2701b34335565c2217c4', '[\"*\"]', '2026-01-11 11:52:27', NULL, '2026-01-11 11:47:26', '2026-01-11 11:52:27'),
(16, 'App\\Models\\User', 1, 'auth-token', 'a7949cc8faadc735b395352e87fea1e3b5f58116897b4ff386a18c3daaf784df', '[\"*\"]', '2026-01-11 12:20:08', NULL, '2026-01-11 12:19:50', '2026-01-11 12:20:08'),
(17, 'App\\Models\\User', 1, 'auth-token', 'fee2d8227f8a0446ecfc7ea1eb7a09e2e06c1a852fd490e4a2614677d4b9028f', '[\"*\"]', '2026-01-11 12:43:56', NULL, '2026-01-11 12:26:34', '2026-01-11 12:43:56'),
(18, 'App\\Models\\User', 1, 'auth-token', '844ad97b0eee2f9abbe3217d2d79f9cd32add142b3a04650316395fae00f6bc1', '[\"*\"]', '2026-01-11 13:01:00', NULL, '2026-01-11 12:56:58', '2026-01-11 13:01:00'),
(19, 'App\\Models\\User', 1, 'auth-token', 'ba6d615678c964bfcc12ce8dc9af9f98cd37397cbbdc7662a3ffb99f9e5ace2e', '[\"*\"]', '2026-01-12 09:09:37', NULL, '2026-01-12 06:50:52', '2026-01-12 09:09:37');

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
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@localizer.com', NULL, '$2y$12$0Ss.vnw8ArYO.04AMiu2w.GgS0BVYQhfp.CkOUSpyH..CrV3BRLBC', 'admin', NULL, '2025-12-21 17:12:31', '2025-12-21 17:12:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cards_type_index` (`type`),
  ADD KEY `cards_is_active_index` (`is_active`),
  ADD KEY `cards_order_index` (`order`);

--
-- Indexes for table `legislations`
--
ALTER TABLE `legislations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legislations_rate_index` (`rate`),
  ADD KEY `legislations_email_index` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_token_index` (`token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `users_email_index` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `legislations`
--
ALTER TABLE `legislations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
