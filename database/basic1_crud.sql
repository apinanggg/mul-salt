-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2021 at 04:21 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `basic1_crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL COMMENT 'PK คีย์หลักประจำตาราง',
  `cat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อประเภท',
  `cat_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'คำอธิบาย',
  `updated_at` datetime NOT NULL COMMENT 'วันที่แก้ไข',
  `created_at` datetime NOT NULL COMMENT 'วันที่สร้าง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(11) NOT NULL COMMENT 'PK คีย์หลักประจำตาราง',
  `p_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อสินค้า',
  `p_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'คำอธิบาย',
  `p_detail` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียด',
  `p_price` float NOT NULL COMMENT 'ราคาสินค้า',
  `p_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รูปภาพหน้าปก',
  `p_status` enum('true','false') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false' COMMENT 'สถานะ',
  `cat_id` int(11) NOT NULL COMMENT 'FK ตาราง categories',
  `updated_at` datetime NOT NULL COMMENT 'วันที่สร้าง',
  `created_at` datetime NOT NULL COMMENT 'วันที่แก้ไข'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK คีย์หลักประจำตาราง';

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK คีย์หลักประจำตาราง';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
