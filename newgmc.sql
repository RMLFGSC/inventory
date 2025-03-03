-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2025 at 01:39 AM
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
-- Database: `newgmc`
--

-- --------------------------------------------------------

--
-- Table structure for table `asset`
--

CREATE TABLE `asset` (
  `asset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `deployment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `equipment_id` int(11) NOT NULL,
  `equip_name` varchar(255) NOT NULL,
  `category` enum('IT Equipment','Engineering Equipment','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `equip_name`, `category`) VALUES
(1, 'Monitor', 'IT Equipment'),
(2, 'UPS', 'IT Equipment'),
(3, 'System Unit', 'IT Equipment'),
(4, 'AVR', 'IT Equipment'),
(5, 'Keyboard', 'IT Equipment'),
(6, 'Mouse', 'IT Equipment'),
(7, 'Printer', 'IT Equipment'),
(8, 'Multimeter', 'Engineering Equipment'),
(9, 'Water Quality Analyzer', 'Engineering Equipment'),
(10, 'Welding Machine', 'Engineering Equipment'),
(11, 'Hydraulic Press', 'Engineering Equipment');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `req_id` int(11) NOT NULL,
  `req_number` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stockin_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `date` date DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`req_id`, `req_number`, `user_id`, `stockin_id`, `qty`, `department`, `remarks`, `date`, `status`) VALUES
(22, 'REQ-59738', 11, 11, 3, 'HIMS', NULL, '2025-03-03', 1),
(23, 'REQ-72928', 11, 12, 12, 'HIMS', NULL, '2025-03-03', 0),
(24, 'REQ-72928', 11, 13, 12, 'HIMS', NULL, '2025-03-03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock_in`
--

CREATE TABLE `stock_in` (
  `stockin_id` int(11) NOT NULL,
  `controlNO` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `category` enum('IT Equipment','Engineering Equipment','','') NOT NULL,
  `dop` date NOT NULL,
  `dr` date NOT NULL,
  `warranty` tinyint(1) NOT NULL,
  `is_posted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_in`
--

INSERT INTO `stock_in` (`stockin_id`, `controlNO`, `item`, `qty`, `category`, `dop`, `dr`, `warranty`, `is_posted`) VALUES
(11, 'CN-1', 'Dell Latitude 7430', 5, 'IT Equipment', '2025-03-01', '2025-03-02', 1, 0),
(12, 'CN-1', 'Cisco Catalyst 9200', 5, 'IT Equipment', '2025-03-01', '2025-03-02', 0, 0),
(13, 'CN-1', 'HP LaserJet Pro MFP M428fdw', 5, 'IT Equipment', '2025-03-01', '2025-03-02', 0, 0),
(14, 'CN-2', 'Lincoln Electric POWER MIG 210 MP', 5, 'Engineering Equipment', '2025-02-26', '2025-03-02', 1, 0),
(15, 'CN-2', 'Caterpillar 320 GC ', 5, 'Engineering Equipment', '2025-02-26', '2025-03-02', 0, 0),
(16, 'CN-2', 'Leica TS16 ', 5, 'Engineering Equipment', '2025-02-26', '2025-03-02', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pword` varchar(255) NOT NULL,
  `number` varchar(20) NOT NULL,
  `department` varchar(100) NOT NULL,
  `role` enum('admin','mmo','engineering','user') NOT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `username`, `pword`, `number`, `department`, `role`, `is_archived`) VALUES
(11, 'Rosille Mae C. Lumangtad', 'rosalinda', '$2y$10$u9TE7uu2RGZOR4WbqBIwA.MsM5M.7OHffVLRSZNZOfv2MzaXf323q', '09889878767', 'HIMS', 'admin', 0),
(12, 'Joanna Mari S. Ducut', 'wana', '$2y$10$pHSWwbyFXrpYavHM/f6do.5y9REzQCm/kJdiTp.woUIuLtn6Bv40W', '09889878767', 'HIMS', 'mmo', 0),
(13, 'Desiree Mae Darish', 'des', '$2y$10$0q0CrniWgY992A97Bc/02OtfV62smGA8eNzU4h7XoOFeXQFcTGJ5.', '09889887678', 'Engineering', 'engineering', 0),
(14, 'Raechelle Mandawe', 'chell', '$2y$10$VmGJP26SMCdTEtgcRWez/.0ixwrjSyLYy97e4FdHJYBioER.rkn82', '09889878768', 'HIMS', 'user', 0),
(15, 'Prince Jay Sayre', 'princess', '$2y$10$BE.508xDG9PlEAGvoMymaeAwJrIBiKnx3fmNWD6y.k2I6Qyl9FrAe', '09889887898', 'HIMS', 'user', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asset`
--
ALTER TABLE `asset`
  ADD PRIMARY KEY (`asset_id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`req_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `stockin_id` (`stockin_id`);

--
-- Indexes for table `stock_in`
--
ALTER TABLE `stock_in`
  ADD PRIMARY KEY (`stockin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asset`
--
ALTER TABLE `asset`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `stock_in`
--
ALTER TABLE `stock_in`
  MODIFY `stockin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asset`
--
ALTER TABLE `asset`
  ADD CONSTRAINT `asset_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`stockin_id`) REFERENCES `stock_in` (`stockin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
