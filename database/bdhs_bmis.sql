-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 06, 2018 at 01:01 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.29-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dhis`
--

-- --------------------------------------------------------

--
-- Table structure for table `bdhs_bmis`
--

CREATE TABLE `bdhs_bmis` (
  `id` int(10) UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organisation_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_option_combo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `import_date` date NOT NULL,
  `server` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bdhs_bmis`
--

INSERT INTO `bdhs_bmis` (`id`, `value`, `period`, `period_name`, `organisation_unit`, `category_option_combo`, `import_date`, `server`, `source`, `created_at`, `updated_at`) VALUES
(1, '20.5', '2014', '2014', 'mykF7AaZv9R', NULL, '2018-06-06', NULL, NULL, NULL, NULL),
(2, '15.7', '2014', '2014', 'JhD8UE2rL3c', NULL, '2018-06-06', NULL, NULL, NULL, NULL),
(3, '18.2', '2014', '2014', 'pF3sVE7tZdk', NULL, '2018-06-06', NULL, NULL, NULL, NULL),
(4, '13.7', '2014', '2014', 'Gm10pkyQc1y', NULL, '2018-06-06', NULL, NULL, NULL, NULL),
(5, '19.6', '2014', '2014', 'R1GAfTe6Mkb', NULL, '2018-06-06', NULL, NULL, NULL, NULL),
(6, '20.3', '2014', '2014', 'Y7Hx8L3Jw51', NULL, '2018-06-06', NULL, NULL, NULL, NULL),
(7, '29.8', '2014', '2014', 'PL5pZp4u3MV', NULL, '2018-06-06', NULL, NULL, NULL, NULL),
(8, '19', '2014', '2014', NULL, NULL, '2018-06-06', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bdhs_bmis`
--
ALTER TABLE `bdhs_bmis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bdhs_bmis`
--
ALTER TABLE `bdhs_bmis`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
