-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2025 at 09:52 AM
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
  `equipment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'REQ-56606', 2, 29, 1, 'HIMS', NULL, '2025-03-02', 0),
(2, 'REQ-93139', 2, 29, 1, 'HIMS', NULL, '2025-03-02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stockin`
--

CREATE TABLE `stockin` (
  `stockin_id` int(11) NOT NULL,
  `controlNO` varchar(100) NOT NULL,
  `item` varchar(255) NOT NULL,
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

INSERT INTO `stockin` (`stockin_id`, `controlNO`, `item`, `qty`, `model`, `category`, `dop`, `dr`, `warranty`) VALUES
(29, 'CN-1', 'Laptop', 2, '', 'IT Equipment', '2025-02-28', '2025-02-28', 1),
(30, 'CN-2', 'Printer', 2, '', 'IT Equipment', '2025-02-27', '2025-02-28', 1),
(31, 'CN-2', 'Keyboard', 1, '', 'IT Equipment', '2025-02-27', '2025-02-28', 0),
(32, 'CN-3', 'UPS', 3, '', 'IT Equipment', '2025-02-27', '2025-02-28', 1),
(33, 'CN-3', 'Printer', 2, '', 'IT Equipment', '2025-02-27', '2025-02-28', 0),
(34, 'CN-3', 'Keyboard', 3, '', 'IT Equipment', '2025-02-27', '2025-02-28', 0),
(35, 'CN-4', 'Chuchu', 5, '', 'IT Equipment', '2025-02-28', '2025-02-28', 1),
(36, 'CN-5', 'joanna', 2, '', 'IT Equipment', '2025-03-02', '2025-03-03', 1),
(37, 'CN-5', 'Des', 1, '', 'IT Equipment', '2025-03-02', '2025-03-03', 0),
(38, 'CN-6', 'Chel', 3, '', 'IT Equipment', '2025-03-03', '2025-03-03', 1),
(39, 'CN-6', 'Prince', 2, '', 'IT Equipment', '2025-03-03', '2025-03-03', 0),
(40, 'CN-7', 'Happy', 2, '', 'IT Equipment', '2025-03-03', '2025-03-03', 1),
(41, 'CN-8', 'Rosille', 1, '', 'IT Equipment', '2025-03-03', '2025-03-03', 1);

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
(2, 'Rosille Lumangtad', '', '$2y$10$b933nvfTEdxQAgeGmbl4P.hk8firl9BH3VR/.3YPzyqWfG12LKhEi', 'ros@gmail.com', '09063623469', 'HIMS', 'superadmin'),
(4, 'Joanna Marie Ducut', 'wana', '123', 'wana@gmail.com', '09889887876', 'HIMS ', 'superuser');

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
  ADD KEY `stockin_id` (`stockin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `stockin`
--
ALTER TABLE `stockin`
  ADD PRIMARY KEY (`stockin_id`);

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
-- AUTO_INCREMENT for table `fixed_asset`
--
ALTER TABLE `fixed_asset`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stockin`
--
ALTER TABLE `stockin`
  MODIFY `stockin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`stockin_id`) REFERENCES `stockin` (`stockin_id`),
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
