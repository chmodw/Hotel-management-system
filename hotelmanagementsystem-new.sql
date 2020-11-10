-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2017 at 10:27 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotelmanagementsystem-new`
--

-- --------------------------------------------------------

--
-- Table structure for table `archived_guests`
--

CREATE TABLE `archived_guests` (
  `guest_hotel_id` varchar(60) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `id_type` varchar(20) NOT NULL,
  `id_Number` varchar(20) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `Address` text NOT NULL,
  `check_in` varchar(10) NOT NULL,
  `Check_out` varchar(10) NOT NULL,
  `room_number` int(3) NOT NULL,
  `room_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `archived_guests`
--

INSERT INTO `archived_guests` (`guest_hotel_id`, `first_name`, `last_name`, `gender`, `id_type`, `id_Number`, `phone_number`, `Address`, `check_in`, `Check_out`, `room_number`, `room_type`) VALUES
('006d4491cfadad56203ebce2c3e2955a', 'Chamodya', 'Wimansha', 'male', 'International Passpo', 'sdf', '0772024897', '152 ,pinkattiya,battuluoya', '2017-04-18', '2017-04-18', 1, 'Single-Bed'),
('6e59184e4706efb4301cda5cdcc65b7e', 'Chamodya', 'Wimansha', 'male', 'International Passpo', 'dd', '0772024897', '152 ,pinkattiya,battuluoya', '2017-04-18', '2017-05-22', 2, 'Single-Bed'),
('97a36181138be43c95127e03d3d4a89a', 'Chamodya', 'Wimansha', 'male', 'Identity card', '123456789V', '0772024897', 'Chilaw, Sri lanka', '2017-04-01', '2017-04-30', 4, 'Single-Bed');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `guest_id` varchar(30) NOT NULL,
  `name` text NOT NULL,
  `checkin` text NOT NULL,
  `checkout` text NOT NULL,
  `room` text NOT NULL,
  `number_of_nights` text NOT NULL,
  `billing_address` text NOT NULL,
  `additional` text NOT NULL,
  `payment_type` text NOT NULL,
  `total_amount` text NOT NULL,
  `timee` text NOT NULL,
  `employee_username` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`guest_id`, `name`, `checkin`, `checkout`, `room`, `number_of_nights`, `billing_address`, `additional`, `payment_type`, `total_amount`, `timee`, `employee_username`) VALUES
('006d4491cfadad56203ebce2c3e295', 'Chamodya Wimansha', '2017-04-18', '2017-04-18', '1-Single-Bed', '0', '152 ,pinkattiya,battuluoya', '0', 'Cash', '0', '2017-04-18 14:32', 'admin'),
('4c192773f735fa0906176db077113e', 'Chamodya Wimansha', '2017-04-01', '2017-04-18', '1-Single-Bed', '17', 'Sri Lanka', '55', 'Cash', '684', '2017-04-18 14:24', 'admin'),
('6e59184e4706efb4301cda5cdcc65b', 'Chamodya Wimansha', '2017-04-18', '2017-05-22', '2-Single-Bed', '34', '152 ,pinkattiya,battuluoya', '0', 'Cash', '1258', '2017-05-22 19:11', 'admin'),
('97a36181138be43c95127e03d3d4a8', 'Chamodya Wimansha', '2017-04-01', '2017-04-18', '4-Single-Bed', '17', 'Chilaw, Sri lanka', '0', 'Cash', '629', '2017-04-18 14:27', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `customer_messages`
--

CREATE TABLE `customer_messages` (
  `customerName` text NOT NULL,
  `email` text NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_messages`
--

INSERT INTO `customer_messages` (`customerName`, `email`, `subject`, `message`) VALUES
('rjbsjbh', 'sdhfsdhb', 'sdfhsdhk', 'hdfskhdfkjsdkfnskjdf');

-- --------------------------------------------------------

--
-- Table structure for table `occupied_rooms`
--

CREATE TABLE `occupied_rooms` (
  `guest_hotel_id` varchar(60) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `id_type` varchar(30) NOT NULL,
  `id_Number` varchar(20) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `Address` text NOT NULL,
  `check_in` date NOT NULL,
  `Check_out` date NOT NULL,
  `room_number` int(3) NOT NULL,
  `room_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `occupied_rooms`
--

INSERT INTO `occupied_rooms` (`guest_hotel_id`, `first_name`, `last_name`, `gender`, `id_type`, `id_Number`, `phone_number`, `Address`, `check_in`, `Check_out`, `room_number`, `room_type`) VALUES
('c13ed12c5996ab815abf6982c595954e', 'Chamodya', 'Wimansha', 'male', 'International Passport', 'sdfsdf', '0772024897', '152 ,pinkattiya,battuluoya', '2017-04-18', '2017-04-20', 4, 'Single-Bed'),
('e7d7f0f862f8c5fb2080aaefe3970273', 'Chamodya', 'Wimansha', 'male', 'International Passport', '456', '772024897', '152 ,pinkattiya,battuluoya', '2017-05-03', '2017-05-26', 1, 'Single-Bed');

-- --------------------------------------------------------

--
-- Table structure for table `online`
--

CREATE TABLE `online` (
  `guest_hotel_id` varchar(60) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `id_type` varchar(30) NOT NULL,
  `id_Number` varchar(20) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `Address` text NOT NULL,
  `check_in` date NOT NULL,
  `Check_out` date NOT NULL,
  `room_number` int(3) NOT NULL,
  `room_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `online`
--

INSERT INTO `online` (`guest_hotel_id`, `first_name`, `last_name`, `gender`, `id_type`, `id_Number`, `phone_number`, `Address`, `check_in`, `Check_out`, `room_number`, `room_type`) VALUES
('3468ced14bdc36ff8953679b138b5dc7', '', '', '', 'International Passport', '', '', '', '2017-05-10', '2017-05-26', 2, 'Single-Bed'),
('3e4998b310fd84a74dc866bc41365c22', '', '', '', 'International Passport', '', '', '', '1970-01-01', '1970-01-01', 0, ''),
('49962c7f7ed967545b3eba8b980b8a56', '4444', '', '', 'International Passport', '', '', '', '1970-01-01', '1970-01-01', 0, ''),
('748136c226af701c172291eb0c6f1e6e', '', '', '', 'International Passport', '', '', '', '1970-01-01', '1970-01-01', 0, ''),
('c13ed12c5996ab815abf6982c595954e', 'Chamodya', 'Wimansha', 'male', 'International Passport', 'sdfsdf', '0772024897', '152 ,pinkattiya,battuluoya', '2017-04-18', '2017-04-20', 4, 'Single-Bed'),
('e7d7f0f862f8c5fb2080aaefe3970273', 'Chamodya', 'Wimansha', 'male', 'International Passport', '456', '772024897', '152 ,pinkattiya,battuluoya', '2017-05-03', '2017-05-26', 1, 'Single-Bed');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_no` int(3) NOT NULL,
  `room_type` varchar(10) NOT NULL,
  `price` int(10) NOT NULL,
  `details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_no`, `room_type`, `price`, `details`) VALUES
(1, 'Single-Bed', 37, 'This is the roomm\r\n'),
(2, 'Single-Bed', 37, 'this is the best room'),
(3, 'Single-Bed', 37, ''),
(4, 'Single-Bed', 37, ''),
(5, 'Single-Bed', 37, ''),
(6, 'Single-Bed', 37, ''),
(7, 'Single-Bed', 37, ''),
(8, 'Single-Bed', 37, ''),
(9, 'Single-Bed', 37, ''),
(10, 'Single-Bed', 37, ''),
(11, 'Single-Bed', 37, ''),
(12, 'Single-Bed', 37, ''),
(13, 'Single-Bed', 37, ''),
(14, 'Single-Bed', 37, ''),
(15, 'Single-Bed', 37, ''),
(16, 'Single-Bed', 37, ''),
(17, 'Single-Bed', 37, ''),
(18, 'Single-Bed', 37, ''),
(19, 'Single-Bed', 37, ''),
(20, 'Single-Bed', 37, ''),
(21, 'Single-Bed', 37, ''),
(22, 'Single-Bed', 37, ''),
(23, 'Single-Bed', 37, ''),
(24, 'Single-Bed', 37, ''),
(25, 'Single-Bed', 37, ''),
(26, 'Double-Bed', 99, ''),
(27, 'Double-Bed', 99, ''),
(28, 'Double-Bed', 99, ''),
(29, 'Double-Bed', 99, ''),
(30, 'Double-Bed', 99, ''),
(31, 'Double-Bed', 99, ''),
(32, 'Double-Bed', 99, ''),
(33, 'Double-Bed', 99, ''),
(34, 'Double-Bed', 99, ''),
(35, 'Double-Bed', 99, ''),
(36, 'Double-Bed', 99, ''),
(37, 'Double-Bed', 99, ''),
(38, 'Double-Bed', 99, ''),
(39, 'Double-Bed', 99, ''),
(40, 'Double-Bed', 99, ''),
(41, 'Family', 150, ''),
(42, 'Family', 150, ''),
(43, 'Family', 150, ''),
(44, 'Family', 150, ''),
(45, 'Family', 150, ''),
(46, 'Family', 150, ''),
(47, 'Family', 150, ''),
(48, 'Family', 150, ''),
(49, 'Family', 150, ''),
(50, 'Family', 150, '');

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `no` int(11) NOT NULL,
  `datee` text NOT NULL,
  `timee` text NOT NULL,
  `action` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`no`, `datee`, `timee`, `action`) VALUES
(1, '2017-04-18', '12:30', 'Lunch For room 14'),
(2, '2017-04-18', '20:30', 'sjfnisn');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Full_name` varchar(25) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` char(60) NOT NULL,
  `account_level` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Full_name`, `username`, `password`, `account_level`) VALUES
('admin', 'admin', '$2y$12$xEfTHoPmn.EZ/DzagjZ9jO49TGF5H212hqGAcW671VNGPFi.Zh5wy', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archived_guests`
--
ALTER TABLE `archived_guests`
  ADD PRIMARY KEY (`guest_hotel_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `occupied_rooms`
--
ALTER TABLE `occupied_rooms`
  ADD PRIMARY KEY (`guest_hotel_id`);

--
-- Indexes for table `online`
--
ALTER TABLE `online`
  ADD PRIMARY KEY (`guest_hotel_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_no`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
