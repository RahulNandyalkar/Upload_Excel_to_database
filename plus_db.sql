-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2024 at 08:57 AM
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
-- Database: `plus_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `master_id` int(20) NOT NULL,
  `contect_no` varchar(10) NOT NULL,
  `email_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- --------------------------------------------------------

--
-- Table structure for table `employee_directory`
--

CREATE TABLE `employee_directory` (
  `master_id` int(20) NOT NULL,
  `joining_date` date NOT NULL,
  `date_of_birth` varchar(20) NOT NULL,
  `salary` int(11) NOT NULL,
  `marital_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--


-- --------------------------------------------------------

--
-- Table structure for table `employee_mst`
--

CREATE TABLE `employee_mst` (
  `employee_id` int(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `department` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD UNIQUE KEY `master_id` (`master_id`);

--
-- Indexes for table `employee_directory`
--
ALTER TABLE `employee_directory`
  ADD UNIQUE KEY `master_id` (`master_id`);

--
-- Indexes for table `employee_mst`
--
ALTER TABLE `employee_mst`
  ADD PRIMARY KEY (`employee_id`);

--
-- Constraints for dumped tables
--
--
-- Constraints for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD CONSTRAINT `emp_id_con_fk` FOREIGN KEY (`master_id`) REFERENCES `employee_mst` (`employee_id`);

--
-- Constraints for table `employee_directory`
--
ALTER TABLE `employee_directory`
  ADD CONSTRAINT `emp_id_fk` FOREIGN KEY (`master_id`) REFERENCES `employee_mst` (`employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
