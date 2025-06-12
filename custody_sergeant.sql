-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 12 يونيو 2025 الساعة 15:19
-- إصدار الخادم: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `custody_sergeant`
--

-- --------------------------------------------------------

--
-- بنية الجدول `kashf`
--

CREATE TABLE `kashf` (
  `id` int(11) NOT NULL,
  `الصنف` varchar(50) NOT NULL,
  `وحدة_القياس` varchar(20) NOT NULL,
  `عدد_الجاهز` int(5) NOT NULL,
  `عدد_يحتاج_صيانة` int(5) NOT NULL,
  `عدد_تالف` int(5) NOT NULL,
  `مكان_وجود_العهدة` varchar(30) NOT NULL,
  `الجهة_التي_تتبعها_العهدة` varchar(50) NOT NULL,
  `تأربخ_الادخال` date NOT NULL,
  `اسم_الشخص_المسؤول_عن_العهدة` varchar(45) NOT NULL,
  `اسم_الشخص_المسؤول_على_القسم` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `kashf`
--

INSERT INTO `kashf` (`id`, `الصنف`, `وحدة_القياس`, `عدد_الجاهز`, `عدد_يحتاج_صيانة`, `عدد_تالف`, `مكان_وجود_العهدة`, `الجهة_التي_تتبعها_العهدة`, `تأربخ_الادخال`, `اسم_الشخص_المسؤول_عن_العهدة`, `اسم_الشخص_المسؤول_على_القسم`) VALUES
(1, 'طابعة', '-----', 7, 6, 5, 'المخزن الرئيسي', 'القسم', '2025-05-27', 'محمد', '0'),
(21, 'كمبيوتر', '---', 4, 0, 0, 'المخزن الرئيسي', 'عبس', '2025-06-10', 'ابوعلي', 'ابومحمد'),
(22, 'جوال', 'لايوجد', 20, 1, 0, 'المخزن الرئيسي', 'القسم', '2025-06-11', 'حسن', '0');

-- --------------------------------------------------------

--
-- بنية الجدول `users_tb`
--

CREATE TABLE `users_tb` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Date_Added` date NOT NULL,
  `user_level` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'viewer',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users_tb`
--

INSERT INTO `users_tb` (`user_id`, `username`, `password`, `Date_Added`, `user_level`, `created_at`) VALUES
(1, 'وعدالله', '$2y$10$yJ9bKXFBWv3ev0tH7N5qeuH8LINLwBlDE3DZxo3lHQ5flFC83jn.i', '2025-05-30', 'admin', '2025-05-30 18:59:19'),
(3, '1111', '$2y$10$cFo9vFv0fRndXUsUAgdWvuIQFrmtLWF9CJaIHU7IqimB7wHNYaKAq', '2025-05-31', 'editor', '2025-05-31 03:01:49'),
(4, 'باسل', '$2y$10$s8QIJcki8sf2Puvhx9C0TuoOJPY.xX2NbWCbK4m6p/l9afmCt/IhW', '2025-06-09', 'admin', '2025-06-09 13:08:02'),
(5, 'علي', '$2y$10$0L17dxmtTIKDFxzsCkxxSuc113YbhxmHPXT7i1PrxA9BqRnvbfFli', '2025-06-09', 'admin', '2025-06-09 13:24:43'),
(9, 'محمد', '$2y$10$wZZf/YxJHxCu.w1VFNQepOryXsPw8DbPLZjhVCGEGS0VuVVbFeYIy', '2025-06-09', 'viewer', '2025-06-09 13:27:06'),
(13, 'عبدالفتاح', '$2y$10$HdfwMtbIMuenPVqUVldHjeSW8y3/erVwIWOrX455yO53hPZEra6i.', '2025-06-12', 'admin', '2025-06-12 15:16:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kashf`
--
ALTER TABLE `kashf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_tb`
--
ALTER TABLE `users_tb`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kashf`
--
ALTER TABLE `kashf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users_tb`
--
ALTER TABLE `users_tb`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
