-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2023 at 12:54 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bato-maj-dlc`
--

-- --------------------------------------------------------

--
-- Table structure for table `contingents_dlc`
--

CREATE TABLE `contingents_dlc` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `number` tinyint(3) UNSIGNED NOT NULL,
  `school` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contingents_dlc`
--

INSERT INTO `contingents_dlc` (`id`, `number`, `school`, `logo`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'TANDAAY HIGH SCHOOL', NULL, 1, '2023-02-10 01:23:56', '2023-02-10 01:27:49'),
(2, 2, 'MALAWAG NATIONAL HIGH SCHOOL', NULL, 1, '2023-02-10 01:23:59', '2023-02-10 01:27:56'),
(3, 3, 'OCAMPO ACADEMY AND TECHNOLOGICAL INSTITUTE, INC.', NULL, 1, '2023-02-10 01:24:02', '2023-02-10 01:28:33'),
(4, 4, 'SAN VICENTE NATIONAL HIGH SCHOOL', NULL, 1, '2023-02-10 01:24:05', '2023-02-10 01:28:44'),
(5, 5, 'SAN AGUSTIN INTEGRATED SCHOOL', NULL, 1, '2023-02-10 01:24:08', '2023-02-10 01:28:52'),
(6, 6, 'LAGONOY HIGH SCHOOL', NULL, 1, '2023-02-10 01:26:19', '2023-02-10 01:28:58'),
(7, 7, 'MASOLI HIGH SCHOOL', NULL, 1, '2023-02-10 01:26:26', '2023-02-10 01:29:03'),
(8, 8, 'LA PURISIMA NATIONAL HIGH SCHOOL', NULL, 1, '2023-02-10 01:26:30', '2023-02-10 01:29:14'),
(9, 9, 'LYCEO DE PASACAO, INC.', NULL, 1, '2023-02-10 01:26:34', '2023-02-10 01:29:23'),
(10, 10, 'SAGRADA NATIONAL HIGH SCHOOL', NULL, 1, '2023-02-10 01:26:39', '2023-02-10 01:30:01'),
(11, 11, 'SALVACION NATIONAL HIGH SCHOOL', NULL, 1, '2023-02-10 01:26:43', '2023-02-10 01:30:08'),
(12, 12, 'HOLY TRINITY COLLEGE OF CAMARINES SUR', NULL, 1, '2023-02-10 01:26:47', '2023-02-10 01:30:16'),
(13, 13, 'BATO NATIONAL HIGH SCHOOL', NULL, 1, '2023-02-10 01:26:51', '2023-02-10 01:30:23'),
(14, 14, 'ST. JOHN THE BAPTIST INSTITUTE OF BICOL, INC.', NULL, 1, '2023-02-10 01:27:20', '2023-02-10 01:30:34');

-- --------------------------------------------------------

--
-- Table structure for table `contingents_maj`
--

CREATE TABLE `contingents_maj` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `number` tinyint(3) UNSIGNED NOT NULL,
  `school` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contingents_maj`
--

INSERT INTO `contingents_maj` (`id`, `number`, `school`, `logo`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'MASOLI HIGH SCHOOL', NULL, 1, '2023-02-10 01:18:35', '2023-02-10 01:20:11'),
(2, 2, 'TANDAAY HIGH SCHOOL', NULL, 1, '2023-02-10 01:18:40', '2023-02-10 01:20:17'),
(3, 3, 'MALAWAG NATIONAL HIGH SCHOOL', NULL, 1, '2023-02-10 01:18:43', '2023-02-10 01:20:23'),
(4, 4, 'OCAMPO ACADEMY AND TECHNOLOGICAL INSTITUTE, INC.', NULL, 1, '2023-02-10 01:18:47', '2023-02-10 01:20:36'),
(5, 5, 'SAN AGUSTIN INTEGRATED SCHOOL', NULL, 1, '2023-02-10 01:18:50', '2023-02-10 01:20:46'),
(6, 6, 'SALVACION NATIONAL HIGH SCHOOL', NULL, 1, '2023-02-10 01:18:53', '2023-02-10 01:20:53'),
(7, 7, 'ST. JOHN THE BAPTIST INSTITUTE OF BICOL, INC.', NULL, 1, '2023-02-10 01:18:56', '2023-02-10 01:21:05'),
(8, 8, 'SAN VICENTE NAIONAL HIGH SCHOOL', NULL, 1, '2023-02-10 01:19:00', '2023-02-10 01:21:13'),
(9, 9, 'BATO NATIONAL HIGH SCHOOL', NULL, 1, '2023-02-10 01:19:04', '2023-02-10 01:21:21'),
(10, 10, 'DON GREGORIO O. BALATAN INSTITUTE INC.', NULL, 1, '2023-02-10 01:19:08', '2023-02-10 01:21:35'),
(11, 11, 'HOLY TRINITY COLLEGE OF CAMARINES SUR', NULL, 1, '2023-02-10 01:19:15', '2023-02-10 01:21:43'),
(12, 12, 'SAGRADA NATIONAL HIGH SCHOOL', NULL, 1, '2023-02-10 01:19:17', '2023-02-10 01:21:49'),
(13, 13, 'LAGONOY HIGH SCHOOL', NULL, 1, '2023-02-10 01:19:21', '2023-02-10 01:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_dlc`
--

CREATE TABLE `criteria_dlc` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criteria_dlc`
--

INSERT INTO `criteria_dlc` (`id`, `title`, `percentage`, `created_at`, `updated_at`) VALUES
(1, 'MUSICALITY', 40, '2023-02-10 01:38:00', '2023-02-10 01:38:00'),
(2, 'CHOREOGRAPHY (CONTENT)', 30, '2023-02-10 01:38:16', '2023-02-10 01:38:16'),
(3, 'MARCHING AND ALIGNMENT', 10, '2023-02-10 01:38:35', '2023-02-10 01:38:35'),
(4, 'GENERAL EFFECT', 20, '2023-02-10 01:38:45', '2023-02-10 01:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_maj`
--

CREATE TABLE `criteria_maj` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criteria_maj`
--

INSERT INTO `criteria_maj` (`id`, `title`, `percentage`, `created_at`, `updated_at`) VALUES
(1, 'CHOREOGRAPHY (CONTENT)', 40, '2023-02-10 01:36:31', '2023-02-10 01:36:31'),
(2, 'PRECISION AND MASTERY', 30, '2023-02-10 01:36:48', '2023-02-10 01:36:48'),
(3, 'SMOOTHNESS AND GRACEFULLNESS', 10, '2023-02-10 01:37:03', '2023-02-10 01:37:03'),
(4, 'GENERAL EFFECT', 20, '2023-02-10 01:37:11', '2023-02-10 01:37:11');

-- --------------------------------------------------------

--
-- Table structure for table `deductions_dlc`
--

CREATE TABLE `deductions_dlc` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `contingent_id` tinyint(4) UNSIGNED NOT NULL,
  `technical_id` tinyint(3) UNSIGNED NOT NULL,
  `value` float UNSIGNED NOT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deductions_maj`
--

CREATE TABLE `deductions_maj` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `contingent_id` tinyint(4) UNSIGNED NOT NULL,
  `technical_id` tinyint(3) UNSIGNED NOT NULL,
  `value` float UNSIGNED NOT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings_dlc`
--

CREATE TABLE `ratings_dlc` (
  `id` mediumint(9) NOT NULL,
  `judge_id` tinyint(4) UNSIGNED NOT NULL,
  `criteria_id` tinyint(4) UNSIGNED NOT NULL,
  `contingent_id` tinyint(4) UNSIGNED NOT NULL,
  `value` float UNSIGNED NOT NULL DEFAULT 0,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings_maj`
--

CREATE TABLE `ratings_maj` (
  `id` mediumint(9) NOT NULL,
  `judge_id` tinyint(4) UNSIGNED NOT NULL,
  `criteria_id` tinyint(4) UNSIGNED NOT NULL,
  `contingent_id` tinyint(4) UNSIGNED NOT NULL,
  `value` float UNSIGNED NOT NULL DEFAULT 0,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_admin`
--

CREATE TABLE `users_admin` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `number` tinyint(3) UNSIGNED NOT NULL,
  `fullname` varchar(128) NOT NULL,
  `avatar` varchar(128) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_admin`
--

INSERT INTO `users_admin` (`id`, `number`, `fullname`, `avatar`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'SUPER USER', '', 'admin', 'admin', '2023-02-10 01:41:15', '2023-02-11 04:51:45');

-- --------------------------------------------------------

--
-- Table structure for table `users_judge`
--

CREATE TABLE `users_judge` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `number` tinyint(3) UNSIGNED NOT NULL,
  `fullname` varchar(128) NOT NULL,
  `avatar` varchar(128) DEFAULT NULL,
  `is_chairman` tinyint(1) NOT NULL DEFAULT 0,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_judge`
--

INSERT INTO `users_judge` (`id`, `number`, `fullname`, `avatar`, `is_chairman`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'JUDGE 01', NULL, 1, 'judge01', 'judge01', '2023-02-10 01:39:16', '2023-02-10 01:40:21'),
(2, 2, 'JUDGE 02', NULL, 0, 'judge02', 'judge02', '2023-02-10 01:39:48', '2023-02-10 01:39:48'),
(3, 3, 'JUDGE 03', NULL, 0, 'judge03', 'judge03', '2023-02-10 01:40:08', '2023-02-10 01:40:08');

-- --------------------------------------------------------

--
-- Table structure for table `users_technical`
--

CREATE TABLE `users_technical` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `number` tinyint(3) UNSIGNED NOT NULL,
  `fullname` varchar(128) NOT NULL,
  `avatar` varchar(128) DEFAULT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_technical`
--

INSERT INTO `users_technical` (`id`, `number`, `fullname`, `avatar`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'TECHNICAL 01', NULL, 'technical01', 'technical01', '2023-02-10 01:40:48', '2023-02-10 01:40:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contingents_dlc`
--
ALTER TABLE `contingents_dlc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contingents_maj`
--
ALTER TABLE `contingents_maj`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_dlc`
--
ALTER TABLE `criteria_dlc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_maj`
--
ALTER TABLE `criteria_maj`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions_dlc`
--
ALTER TABLE `deductions_dlc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contingent_id` (`contingent_id`),
  ADD KEY `technical_id` (`technical_id`);

--
-- Indexes for table `deductions_maj`
--
ALTER TABLE `deductions_maj`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contingent_id` (`contingent_id`),
  ADD KEY `technical_id` (`technical_id`);

--
-- Indexes for table `ratings_dlc`
--
ALTER TABLE `ratings_dlc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `candidate_id` (`contingent_id`),
  ADD KEY `criteria_id` (`criteria_id`);

--
-- Indexes for table `ratings_maj`
--
ALTER TABLE `ratings_maj`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `candidate_id` (`contingent_id`),
  ADD KEY `criteria_id` (`criteria_id`);

--
-- Indexes for table `users_admin`
--
ALTER TABLE `users_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_judge`
--
ALTER TABLE `users_judge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_technical`
--
ALTER TABLE `users_technical`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contingents_dlc`
--
ALTER TABLE `contingents_dlc`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `contingents_maj`
--
ALTER TABLE `contingents_maj`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `criteria_dlc`
--
ALTER TABLE `criteria_dlc`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `criteria_maj`
--
ALTER TABLE `criteria_maj`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deductions_dlc`
--
ALTER TABLE `deductions_dlc`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deductions_maj`
--
ALTER TABLE `deductions_maj`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings_dlc`
--
ALTER TABLE `ratings_dlc`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings_maj`
--
ALTER TABLE `ratings_maj`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_admin`
--
ALTER TABLE `users_admin`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_judge`
--
ALTER TABLE `users_judge`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_technical`
--
ALTER TABLE `users_technical`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deductions_dlc`
--
ALTER TABLE `deductions_dlc`
  ADD CONSTRAINT `deductions_dlc_ibfk_1` FOREIGN KEY (`contingent_id`) REFERENCES `contingents_dlc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deductions_dlc_ibfk_2` FOREIGN KEY (`technical_id`) REFERENCES `users_technical` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `deductions_maj`
--
ALTER TABLE `deductions_maj`
  ADD CONSTRAINT `deductions_maj_ibfk_1` FOREIGN KEY (`contingent_id`) REFERENCES `contingents_maj` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deductions_maj_ibfk_2` FOREIGN KEY (`technical_id`) REFERENCES `users_technical` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `ratings_dlc`
--
ALTER TABLE `ratings_dlc`
  ADD CONSTRAINT `ratings_dlc_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `users_judge` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_dlc_ibfk_2` FOREIGN KEY (`contingent_id`) REFERENCES `contingents_dlc` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_dlc_ibfk_3` FOREIGN KEY (`criteria_id`) REFERENCES `criteria_dlc` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `ratings_maj`
--
ALTER TABLE `ratings_maj`
  ADD CONSTRAINT `ratings_maj_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `users_judge` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_maj_ibfk_2` FOREIGN KEY (`contingent_id`) REFERENCES `contingents_maj` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_maj_ibfk_3` FOREIGN KEY (`criteria_id`) REFERENCES `criteria_maj` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
