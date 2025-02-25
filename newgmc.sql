-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 01:35 AM
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
-- Table structure for table `fixed_asset`
--

CREATE TABLE `fixed_asset` (
  `asset_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` enum('In Use','Available','Damaged','Disposed') NOT NULL DEFAULT 'In Use',
  `date_issued` date NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `req_id` int(11) NOT NULL,
  `req_number` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `date` date DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`req_id`, `req_number`, `user_id`, `equipment_id`, `qty`, `department`, `remarks`, `date`, `status`) VALUES
(1, 'REQ-81762', 2, 2, 10, 'HIMS', NULL, '2025-02-23', 1),
(2, 'REQ-81762', 2, 6, 10, 'HIMS', NULL, '2025-02-23', 0),
(3, 'REQ-32514', 2, 7, 4, 'HIMS', NULL, '2025-02-23', 1),
(4, 'REQ-32514', 2, 4, 4, 'HIMS', NULL, '2025-02-23', 0),
(5, 'REQ-32514', 2, 5, 4, 'HIMS', NULL, '2025-02-23', 0),
(6, 'REQ-95635', 2, 1, 4, 'HIMS', NULL, '2025-02-23', 2),
(7, 'REQ-95635', 2, 6, 4, 'HIMS', NULL, '2025-02-23', 0),
(8, 'REQ-95635', 2, 2, 4, 'HIMS', NULL, '2025-02-23', 0),
(9, 'REQ-95635', 2, 7, 4, 'HIMS', NULL, '2025-02-23', 0),
(10, 'REQ-95635', 2, 5, 4, 'HIMS', NULL, '2025-02-23', 0),
(11, 'REQ-95635', 2, 3, 4, 'HIMS', NULL, '2025-02-23', 0),
(12, 'REQ-15051', 2, 11, 5, 'HIMS', NULL, '2025-02-23', 0),
(13, 'REQ-15051', 2, 10, 5, 'HIMS', NULL, '2025-02-23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stockin`
--

CREATE TABLE `stockin` (
  `stockin_id` int(11) NOT NULL,
  `controlNO` varchar(100) NOT NULL,
  `equipment_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `category` enum('IT Equipment','Engineering Equipment') NOT NULL,
  `dop` date NOT NULL,
  `dr` date NOT NULL,
  `warranty` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stockin`
--

INSERT INTO `stockin` (`stockin_id`, `controlNO`, `equipment_id`, `qty`, `model`, `category`, `dop`, `dr`, `warranty`) VALUES
(7, 'CN-1', 1, 5, 'DELL P2422H', 'IT Equipment', '2025-02-16', '2025-02-23', 1),
(8, 'CN-1', 7, 5, ' Epson EcoTank L3250', 'IT Equipment', '2025-02-16', '2025-02-23', 0),
(9, 'CN-1', 6, 5, 'Razer DeathAdder V2', 'IT Equipment', '2025-02-16', '2025-02-23', 0),
(10, 'CN-2', 2, 2, 'APC Back-UPS Pro BR1500MS2', 'IT Equipment', '2025-02-21', '2025-02-23', 0),
(11, 'CN-3', 1, 5, 'DELL P2422H', 'IT Equipment', '2025-02-27', '2025-02-23', 0),
(12, 'CN-4', 4, 1, 'ACER PHPSKAS', 'IT Equipment', '2025-02-20', '2025-02-28', 1),
(13, 'CN-4', 2, 1, 'SECURE PFKFS', 'IT Equipment', '2025-02-20', '2025-02-28', 0),
(14, 'CN-5', 10, 5, 'Lincoln Electric POWER MIG 210 MP', 'Engineering Equipment', '2025-02-23', '2025-02-24', 1),
(15, 'CN-5', 10, 5, 'Miller Diversion 180', 'Engineering Equipment', '2025-02-23', '2025-02-24', 0),
(16, 'CN-5', 11, 5, 'Dake 10H', 'Engineering Equipment', '2025-02-23', '2025-02-24', 0),
(17, 'CN-5', 11, 5, 'Baileigh HSP-30A', 'Engineering Equipment', '2025-02-23', '2025-02-24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pword` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` varchar(20) NOT NULL,
  `department` varchar(100) NOT NULL,
  `role` enum('user','superuser','admin','superadmin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `username`, `pword`, `email`, `number`, `department`, `role`) VALUES
(2, 'Rosille Lumangtad', '', '$2y$10$b933nvfTEdxQAgeGmbl4P.hk8firl9BH3VR/.3YPzyqWfG12LKhEi', 'ros@gmail.com', '09063623469', 'HIMS', 'superadmin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `fixed_asset`
--
ALTER TABLE `fixed_asset`
  ADD PRIMARY KEY (`asset_id`),
  ADD KEY `equipment_id` (`equipment_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`req_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `equipment_id` (`equipment_id`);

--
-- Indexes for table `stockin`
--
ALTER TABLE `stockin`
  ADD PRIMARY KEY (`stockin_id`),
  ADD KEY `equipment_id` (`equipment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `fixed_asset`
--
ALTER TABLE `fixed_asset`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `stockin`
--
ALTER TABLE `stockin`
  MODIFY `stockin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fixed_asset`
--
ALTER TABLE `fixed_asset`
  ADD CONSTRAINT `fixed_asset_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`),
  ADD CONSTRAINT `fixed_asset_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE CASCADE;

--
-- Constraints for table `stockin`
--
ALTER TABLE `stockin`
  ADD CONSTRAINT `stockin_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`equipment_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
