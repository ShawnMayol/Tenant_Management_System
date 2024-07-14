-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2024 at 05:16 PM
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
-- Database: `tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activity_ID` int(11) NOT NULL,
  `staff_ID` int(11) NOT NULL,
  `activityDescription` text NOT NULL,
  `activityTimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activity_ID`, `staff_ID`, `activityDescription`, `activityTimestamp`) VALUES
(1, 1, 'Login', '2024-07-14 08:41:43'),
(2, 2, 'Account created', '2024-07-14 08:45:13'),
(3, 2, 'Login', '2024-07-14 08:51:39'),
(4, 1, 'Post announcement 1', '2024-07-14 08:55:17'),
(5, 2, 'Logout', '2024-07-14 08:58:28'),
(6, 2, 'Login', '2024-07-14 09:01:23'),
(7, 2, 'Logout', '2024-07-14 09:01:38'),
(8, 2, 'Login', '2024-07-14 09:01:44'),
(9, 2, 'Rejected request 1', '2024-07-14 09:04:06'),
(10, 2, 'Approved lease 1', '2024-07-14 09:05:26'),
(11, 1, 'Edit announcement 1', '2024-07-14 09:06:16'),
(12, 2, 'Account Deactivated', '2024-07-14 09:22:42'),
(13, 2, 'Logout', '2024-07-14 09:22:53'),
(14, 2, 'Login', '2024-07-14 09:23:02'),
(15, 2, 'Account Deactivated', '2024-07-14 09:23:50'),
(16, 2, 'Logout', '2024-07-14 09:23:54'),
(17, 2, 'Login', '2024-07-14 09:24:04'),
(18, 2, 'Account Deactivated', '2024-07-14 09:24:45'),
(19, 2, 'Logout', '2024-07-14 09:27:55'),
(20, 2, 'Account Deactivated', '2024-07-14 09:29:15'),
(21, 2, 'Account Activated', '2024-07-14 09:29:47'),
(22, 2, 'Login', '2024-07-14 09:29:51'),
(23, 2, 'Account Deactivated', '2024-07-14 09:30:02'),
(24, 2, 'Account Activated', '2024-07-14 09:30:15'),
(25, 2, 'Login', '2024-07-14 10:07:35'),
(26, 2, 'Logout', '2024-07-14 12:23:38'),
(27, 2, 'Login', '2024-07-14 12:26:45'),
(28, 2, 'Pinned request 2', '2024-07-14 12:26:54'),
(29, 2, 'Approved lease 2', '2024-07-14 12:31:04'),
(30, 1, 'Edit announcement 1', '2024-07-14 12:34:52'),
(31, 2, 'Logout', '2024-07-14 12:55:44'),
(32, 2, 'Login', '2024-07-14 12:55:59'),
(33, 1, 'Changed apartment 2 status to Occupied', '2024-07-14 14:33:12'),
(34, 1, 'Changed apartment 2 status to Maintenance', '2024-07-14 14:33:23'),
(35, 1, 'Changed apartment 2 status to Occupied', '2024-07-14 14:33:29'),
(36, 1, 'Changed apartment 2 status to Occupied', '2024-07-14 14:35:37'),
(37, 1, 'Changed apartment 2 status to Occupied', '2024-07-14 14:35:43'),
(38, 1, 'Changed apartment 2 status to Occupied', '2024-07-14 14:36:04'),
(39, 1, 'Changed apartment 2 status to Select Status', '2024-07-14 14:36:38'),
(40, 1, 'Changed apartment 2 status to Occupied', '2024-07-14 14:36:54'),
(41, 2, 'Changed apartment 3 status to Maintenance', '2024-07-14 14:38:36'),
(42, 2, 'Changed apartment 3 status to Available', '2024-07-14 14:38:38'),
(43, 2, 'Logout', '2024-07-14 14:44:03'),
(44, 2, 'Account Deactivated', '2024-07-14 14:49:32'),
(45, 2, 'Account Activated', '2024-07-14 14:49:52'),
(46, 2, 'Login', '2024-07-14 14:49:58'),
(47, 2, 'Logout', '2024-07-14 14:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_ID` int(11) NOT NULL,
  `target` enum('All','Managers') DEFAULT 'All',
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_ID`, `target`, `title`, `content`, `created_at`, `staff_id`) VALUES
(1, 'All', 'Welcome!!!', 'Thank You for choosing C-Apartments! Enjoy your stay!!!!!', '2024-07-14 08:55:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `apartment`
--

CREATE TABLE `apartment` (
  `apartmentNumber` int(11) NOT NULL,
  `apartmentType` varchar(50) NOT NULL,
  `rentPerMonth` decimal(10,2) NOT NULL,
  `apartmentDimensions` varchar(50) DEFAULT NULL,
  `apartmentAddress` varchar(255) DEFAULT NULL,
  `maxOccupants` int(11) DEFAULT NULL,
  `apartmentStatus` enum('Available','Occupied','Maintenance','Hidden') DEFAULT 'Hidden',
  `availableBy` date DEFAULT NULL,
  `apartmentPictures` varchar(255) DEFAULT NULL,
  `apartmentDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apartment`
--

INSERT INTO `apartment` (`apartmentNumber`, `apartmentType`, `rentPerMonth`, `apartmentDimensions`, `apartmentAddress`, `maxOccupants`, `apartmentStatus`, `availableBy`, `apartmentPictures`, `apartmentDescription`) VALUES
(1, 'Studio', 6000.00, '25 Square meter', 'Cebu City, Philippines', 2, 'Occupied', '2025-01-14', '../../uploads/apartment/apartment.jpg', 'A comfortable Studio apartment fit for couples or individuals!'),
(2, '2 Bedroom', 8000.00, '25 Square meter', 'Talamban, Cebu City', 4, 'Occupied', '2024-08-14', '../../uploads/apartment/2bedroom2.jpg', 'A lofty 2 Bedroom apartment perfect for small families.'),
(3, 'Studio', 6500.00, '25 Square meter', 'Talamban, Cebu City', 3, 'Available', NULL, '../../uploads/apartment/2bedroom.jpg', 'Space-y studio apartment good for 3 people.');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_ID` int(11) NOT NULL,
  `invoice_ID` int(11) DEFAULT NULL,
  `paymentMethod` varchar(50) NOT NULL,
  `amountPaid` decimal(10,2) NOT NULL,
  `overpayment` decimal(10,2) DEFAULT 0.00,
  `outstandingBalance` decimal(10,2) DEFAULT 0.00,
  `paymentDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `fee_ID` int(11) NOT NULL,
  `lease_ID` int(11) DEFAULT NULL,
  `rent` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `maintenance` decimal(10,2) NOT NULL,
  `totalAmount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_ID` int(11) NOT NULL,
  `fee_ID` int(11) DEFAULT NULL,
  `dueDate` date NOT NULL,
  `dateIssued` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lease`
--

CREATE TABLE `lease` (
  `lease_ID` int(11) NOT NULL,
  `apartmentNumber` int(11) DEFAULT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `billingPeriod` varchar(50) NOT NULL,
  `securityDeposit` decimal(10,2) DEFAULT 0.00,
  `leaseStatus` enum('Active','Expired','Terminated') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lease`
--

INSERT INTO `lease` (`lease_ID`, `apartmentNumber`, `startDate`, `endDate`, `billingPeriod`, `securityDeposit`, `leaseStatus`) VALUES
(1, 1, '2024-07-14', '2025-01-14', 'monthly', 6000.00, 'Active'),
(2, 2, '2024-07-14', '2024-08-14', 'monthly', 8000.00, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_ID` int(11) NOT NULL,
  `apartmentNumber` int(11) DEFAULT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `middleName` varchar(255) DEFAULT NULL,
  `dateOfBirth` date NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `requestDate` date NOT NULL,
  `identificationPic` varchar(255) NOT NULL,
  `incomePic` varchar(255) NOT NULL,
  `addressPic` varchar(255) NOT NULL,
  `othersPic` varchar(255) NOT NULL,
  `requestStatus` enum('Pending','Approved','Rejected','Pinned') DEFAULT 'Pending',
  `termsOfStay` varchar(10) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `billingPeriod` varchar(11) DEFAULT NULL,
  `occupants` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `gender` enum('Male','Female','Prefer not to say') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_ID`, `apartmentNumber`, `firstName`, `lastName`, `middleName`, `dateOfBirth`, `phoneNumber`, `emailAddress`, `requestDate`, `identificationPic`, `incomePic`, `addressPic`, `othersPic`, `requestStatus`, `termsOfStay`, `startDate`, `endDate`, `billingPeriod`, `occupants`, `message`, `gender`) VALUES
(1, 1, 'Shawn', 'Mayol', 'Jurgen', '2004-03-19', '09298089931', 'shawn@gmail.com', '2024-07-14', '../../uploads/request/identification.jpg', '../../uploads/request/proof of income.png', '../../uploads/request/address.jpg', '../../uploads/request/reference letter.png', 'Approved', 'long', '2024-07-14', '2025-01-14', 'monthly', 1, 'Can I get this apartment by tomorrow? I will be staying for long term.', 'Male'),
(2, 2, 'Jason', 'Momoa', '', '1987-09-12', '09121231234', 'jason@gmail.com', '2024-07-14', '../../uploads/request/identification.jpg', '../../uploads/request/proof of income.png', '../../uploads/request/address.jpg', '../../uploads/request/lease.jpg', 'Approved', 'short', '2024-07-14', '2024-08-14', 'monthly', 4, 'Lets agree on a lease agreement date by next week.', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_ID` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `middleName` varchar(255) NOT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `staffRole` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_ID`, `firstName`, `lastName`, `middleName`, `dateOfBirth`, `phoneNumber`, `emailAddress`, `staffRole`) VALUES
(1, 'Lance', 'Cerenio', 'Geo', '2005-05-19', '1234567890', 'lance@example.com', 'Admin'),
(2, 'Carl', 'Omega', 'Alias', '2004-05-17', '09298089931', 'carl@gmail.com', 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

CREATE TABLE `tenant` (
  `tenant_ID` int(11) NOT NULL,
  `lease_ID` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `middleName` varchar(255) DEFAULT NULL,
  `dateOfBirth` date NOT NULL,
  `gender` enum('Male','Female','Prefer not to say') DEFAULT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `tenantType` enum('Lessee','Occupant') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`tenant_ID`, `lease_ID`, `firstName`, `lastName`, `middleName`, `dateOfBirth`, `gender`, `phoneNumber`, `emailAddress`, `tenantType`) VALUES
(1, 1, 'Shawn', 'Mayol', 'Jurgen', '2004-03-19', 'Male', '09298089931', 'shawn@gmail.com', 'Lessee'),
(2, 1, 'Shawn', 'Mayol', 'Jurgen', '2004-03-19', 'Male', '09298089931', 'shawn@gmail.com', 'Occupant'),
(3, 2, 'Jason', 'Momoa', '', '1986-10-12', 'Male', '09121231234', 'jason@gmail.com', 'Lessee'),
(4, 2, 'Jason', 'Momoa', '', '1987-09-12', 'Male', '09121231234', 'jason@gmail.com', 'Occupant'),
(5, 2, 'Jane', 'Momoa', '', '1986-12-09', 'Female', '09131231234', 'jane@gmail.com', 'Occupant'),
(6, 2, 'Jimbo', 'Momoa', '', '2004-09-12', 'Male', '09871231234', 'jimbo@gmail.com', 'Occupant'),
(7, 2, 'Joana', 'Momoa', '', '2012-12-09', 'Female', '09121231234', 'Joana@gmail.com', 'Occupant');

-- --------------------------------------------------------

--
-- Table structure for table `transactionlog`
--

CREATE TABLE `transactionlog` (
  `transaction_ID` int(11) NOT NULL,
  `bill_ID` int(11) DEFAULT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `receivedBy` int(11) DEFAULT NULL,
  `transactionStatus` enum('received','pending') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` int(11) NOT NULL,
  `tenant_ID` int(11) DEFAULT NULL,
  `staff_ID` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userStatus` enum('Offline','Online','Deactivated') NOT NULL DEFAULT 'Offline',
  `userRole` enum('Admin','Manager','Tenant') NOT NULL,
  `picDirectory` varchar(255) DEFAULT '../../uploads/staff/placeholder.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `tenant_ID`, `staff_ID`, `username`, `password`, `userStatus`, `userRole`, `picDirectory`) VALUES
(1, NULL, 1, 'Admin', '$2y$10$FHJjEueNM5xyn6GJXnGT2.uAz.6f53d3rPBXCHaMCugXh20sjFUza', 'Online', 'Admin', '../../uploads/staff/admin.jpg'),
(2, NULL, 2, 'CarlOmega2', '$2y$10$cAeL5cy/q3X6m7snluJk3uYSWmF32b5Bixvd5wSBMhyq1VXaeKHVu', 'Offline', 'Manager', '../../uploads/staff/carl.jpg'),
(3, 1, NULL, 'ShawnMayol1', '$2y$10$nWORB8HaJ/HZsrBsyfVP.ukW4jgh2j.2qkEm8WEkfFIMwoZPCr49y', 'Offline', 'Tenant', '../../uploads/tenant/placeholder.jpg'),
(4, 3, NULL, 'JasonMomoa4', '$2y$10$W8qm9rW.UGmz2kH/TjT1MOuKEwgr8iq1Dj.aq0x72E7wJPHWsgUY.', 'Offline', 'Tenant', '../../uploads/tenant/placeholder.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_ID`),
  ADD KEY `staff_ID` (`staff_ID`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_ID`),
  ADD KEY `fk_staff` (`staff_id`);

--
-- Indexes for table `apartment`
--
ALTER TABLE `apartment`
  ADD PRIMARY KEY (`apartmentNumber`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bill_ID`),
  ADD KEY `invoice_ID` (`invoice_ID`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`fee_ID`),
  ADD KEY `lease_ID` (`lease_ID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_ID`),
  ADD KEY `fee_ID` (`fee_ID`);

--
-- Indexes for table `lease`
--
ALTER TABLE `lease`
  ADD PRIMARY KEY (`lease_ID`),
  ADD KEY `apartmentNumber` (`apartmentNumber`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_ID`),
  ADD KEY `apartmentNumber` (`apartmentNumber`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_ID`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`tenant_ID`),
  ADD KEY `lease_ID` (`lease_ID`);

--
-- Indexes for table `transactionlog`
--
ALTER TABLE `transactionlog`
  ADD PRIMARY KEY (`transaction_ID`),
  ADD KEY `bill_ID` (`bill_ID`),
  ADD KEY `user_ID` (`user_ID`),
  ADD KEY `receivedBy` (`receivedBy`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `tenant_ID` (`tenant_ID`),
  ADD KEY `fk_user_staff` (`staff_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activity_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `apartment`
--
ALTER TABLE `apartment`
  MODIFY `apartmentNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `fee_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lease`
--
ALTER TABLE `lease`
  MODIFY `lease_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `tenant_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transactionlog`
--
ALTER TABLE `transactionlog`
  MODIFY `transaction_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`staff_ID`) REFERENCES `staff` (`staff_ID`);

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `fk_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_ID`);

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`invoice_ID`) REFERENCES `invoice` (`invoice_ID`);

--
-- Constraints for table `fees`
--
ALTER TABLE `fees`
  ADD CONSTRAINT `fees_ibfk_1` FOREIGN KEY (`lease_ID`) REFERENCES `lease` (`lease_ID`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`fee_ID`) REFERENCES `fees` (`fee_ID`);

--
-- Constraints for table `lease`
--
ALTER TABLE `lease`
  ADD CONSTRAINT `lease_ibfk_1` FOREIGN KEY (`apartmentNumber`) REFERENCES `apartment` (`apartmentNumber`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`apartmentNumber`) REFERENCES `apartment` (`apartmentNumber`);

--
-- Constraints for table `tenant`
--
ALTER TABLE `tenant`
  ADD CONSTRAINT `tenant_ibfk_1` FOREIGN KEY (`lease_ID`) REFERENCES `lease` (`lease_ID`);

--
-- Constraints for table `transactionlog`
--
ALTER TABLE `transactionlog`
  ADD CONSTRAINT `transactionlog_ibfk_1` FOREIGN KEY (`bill_ID`) REFERENCES `bill` (`bill_ID`),
  ADD CONSTRAINT `transactionlog_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`),
  ADD CONSTRAINT `transactionlog_ibfk_3` FOREIGN KEY (`receivedBy`) REFERENCES `user` (`user_ID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_staff` FOREIGN KEY (`staff_ID`) REFERENCES `staff` (`staff_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`tenant_ID`) REFERENCES `tenant` (`tenant_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
