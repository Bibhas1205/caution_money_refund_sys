-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2023 at 04:23 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `caution_money_refund_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_details`
--

CREATE TABLE `academic_details` (
  `id` int(11) NOT NULL,
  `uroll` varchar(50) NOT NULL,
  `classRoll` int(11) NOT NULL,
  `batch` varchar(10) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `account_holder` varchar(200) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `ifsc_code` varchar(50) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `micr_code` varchar(50) NOT NULL,
  `passbook` varchar(200) NOT NULL,
  `grade_card` varchar(200) NOT NULL,
  `degree_certificate` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin_information`
--

CREATE TABLE `admin_information` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `college` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `salt` varchar(100) NOT NULL,
  `admin_type` varchar(100) NOT NULL,
  `login_token` varchar(300) DEFAULT NULL,
  `remember_token` varchar(300) DEFAULT NULL,
  `exp_remember` varchar(300) DEFAULT NULL,
  `log_dttm` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_information`
--

INSERT INTO `admin_information` (`id`, `name`, `email`, `college`, `password`, `photo`, `salt`, `admin_type`, `login_token`, `remember_token`, `exp_remember`, `log_dttm`) VALUES
(1, 'Tony Stark', 'tonystark@stark.com', 'Dinabandhu Andrews Institute of Technology and Management', 'a3cd45420bbb3388fa2887acd6859bad', 'assets/photos/faculty20230511130451_pic.jpeg', 'a4e21d8d64f98be7343385564e285296', 'cashier', '05a3a51083bc8250b15782c02a2ee88b', '67303f68d0ebe6b127f8a2a56160df30', '1684744750', '2023-05-22'),
(2, 'HOD Ma&#039;am', 'hod@gmail.com', 'Dinnabandhu Andrews Institute of Technoloy and Management', 'df698838e4c6097d766a15e4ad3f424f', 'assets/photos/faculty20230512132715_pic.jpeg', 'c9c278bf22165d9a5271b39f2e66912c', 'hod', '53486831552d4cc753a67f3143ec890a', '4927fb8070a70319669cd3bf0f2cdc36', '1684738765', '2023-05-22'),
(3, 'Librarian Sir', 'library@gmail.com', 'Dinabandhu Andrews Institute of Technology and Management', '86b865fe1df498c2aba354bb8443d353', 'assets/photos/faculty20230522195211_pic.jpeg', '641a10a073e1595209c201d0e845bff5', 'librarian', 'cd0574dbdceedee4dcca4f510276e9c6', '7c2cc51f05dbbefcd39bb15c8a9c3937', '1684739067', '2023-05-22'),
(4, 'Lab Technician', 'lab@gmail.com', 'Dinabandhu Andrews Institute of Technology  and Manangement', '86b080775a8bcb9896207db4b856b8ba', 'assets/photos/faculty20230522195015_pic.jpeg', '65bc6539d48bf15243a96a03e4ea0d7d', 'lab technician', '6325100e972a49e3d8bd368dbb0ee5a6', '3e6d5d4afefb8645c8e828b6aab84ce3', '1683883312', '2023-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `caution_money`
--

CREATE TABLE `caution_money` (
  `stream` varchar(50) NOT NULL,
  `money` int(11) NOT NULL DEFAULT 5000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `caution_money`
--

INSERT INTO `caution_money` (`stream`, `money`) VALUES
('BCA', 5000),
('BBA', 5000),
('BHM', 5000),
('MSC', 10000),
('BMLT', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `new_entry`
--

CREATE TABLE `new_entry` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `uroll` varchar(100) NOT NULL,
  `salt` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `login_token` varchar(200) NOT NULL,
  `remember_token` varchar(200) NOT NULL,
  `exp_remember` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `uroll` varchar(50) NOT NULL,
  `apply` varchar(100) NOT NULL,
  `hod_clearance` varchar(100) NOT NULL,
  `lib_clearance` varchar(100) NOT NULL,
  `lab_clearance` varchar(100) NOT NULL,
  `admin_confirmation` varchar(100) NOT NULL,
  `bank_confirmation` varchar(100) NOT NULL,
  `registration_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `students_information`
--

CREATE TABLE `students_information` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stream` varchar(10) NOT NULL,
  `uroll` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `batch` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(200) NOT NULL,
  `pin` varchar(10) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `salt` varchar(100) NOT NULL,
  `application_date` date NOT NULL DEFAULT current_timestamp(),
  `login_token` varchar(200) NOT NULL,
  `remember_token` varchar(200) NOT NULL,
  `exp_remember` varchar(150) NOT NULL,
  `log_dttm` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_details`
--
ALTER TABLE `academic_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uroll` (`uroll`);

--
-- Indexes for table `admin_information`
--
ALTER TABLE `admin_information`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `admin_type` (`admin_type`);

--
-- Indexes for table `new_entry`
--
ALTER TABLE `new_entry`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`uroll`);

--
-- Indexes for table `students_information`
--
ALTER TABLE `students_information`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `uroll` (`uroll`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_details`
--
ALTER TABLE `academic_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `admin_information`
--
ALTER TABLE `admin_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `new_entry`
--
ALTER TABLE `new_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `students_information`
--
ALTER TABLE `students_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
