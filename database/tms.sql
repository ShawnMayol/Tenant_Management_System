-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2024 at 06:30 AM
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
-- Table structure for table `apartment`
--

CREATE TABLE `apartment` (
  `apartmentNumber` int(11) NOT NULL,
  `apartmentSize` varchar(50) NOT NULL,
  `apartmentPrice` decimal(10,2) NOT NULL,
  `apartmentStatus` enum('available','unavailable') DEFAULT 'available',
  `maxOccupants` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apartment`
--

INSERT INTO `apartment` (`apartmentNumber`, `apartmentSize`, `apartmentPrice`, `apartmentStatus`, `maxOccupants`) VALUES
(1, 'Studio', 1200.00, 'unavailable', 2),
(2, '1 Bedroom', 1500.00, 'unavailable', 3),
(3, '2 Bedroom', 2000.00, 'available', 4),
(4, '3 Bedroom', 2500.00, 'available', 5),
(5, '1 Bedroom', 1600.00, 'available', 3),
(6, '2 Bedroom', 2100.00, 'available', 4),
(7, 'Penthouse', 5000.00, 'available', 6);

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
  `dueDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lease`
--

CREATE TABLE `lease` (
  `lease_ID` int(11) NOT NULL,
  `tenant_ID` int(11) DEFAULT NULL,
  `apartmentNumber` int(11) DEFAULT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `billingPeriod` varchar(50) NOT NULL,
  `leaseStatus` enum('approved','declined','pending') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lease`
--

INSERT INTO `lease` (`lease_ID`, `tenant_ID`, `apartmentNumber`, `startDate`, `endDate`, `billingPeriod`, `leaseStatus`) VALUES
(1, 1, 1, '2024-01-01', '2025-01-01', 'monthly', 'approved'),
(2, 2, 1, '2024-01-01', '2025-01-01', 'monthly', 'approved'),
(3, 3, 2, '2024-01-01', '2024-07-01', 'weekly', 'approved'),
(4, 4, 2, '2024-01-01', '2024-07-01', 'weekly', 'approved'),
(5, 5, 2, '2024-01-01', '2024-07-01', 'weekly', 'approved');

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
  `requestBin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

CREATE TABLE `tenant` (
  `tenant_ID` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `middleName` varchar(255) DEFAULT NULL,
  `dateOfBirth` date NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `deposit` decimal(10,2) DEFAULT 0.00,
  `tenantStatus` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`tenant_ID`, `firstName`, `lastName`, `middleName`, `dateOfBirth`, `phoneNumber`, `emailAddress`, `deposit`, `tenantStatus`) VALUES
(1, 'John', 'Doe', 'Alpha', '1990-01-01', '12345678901', 'john@example.com', 0.00, 'active'),
(2, 'Jane', 'Smith', 'Beta', '1985-05-15', '0987654321', 'jane@example.com', 0.00, 'active'),
(3, 'Michael', 'Johnson', 'Charlie', '1975-09-30', '5678901234', 'michael.johnson@example.com', 0.00, 'active'),
(4, 'Emily', 'Davis', 'Delta', '2000-12-20', '2345678901', 'emily.davis@example.com', 0.00, 'active'),
(5, 'Robert', 'Brown', 'Echo', '1995-07-10', '3456789012', 'robert.brown@example.com', 0.00, 'active');

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
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userRole` enum('Admin','Manager','Tenant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `tenant_ID`, `username`, `password`, `userRole`) VALUES
(1, NULL, 'admin', '$2y$10$XqKM0gPqnHThUkunuYxz6eEUEDBzwq837/OzKFOpWnats4C.XEwQO', 'Admin'),
(2, NULL, 'manager1', '$2y$10$gDFFafLJErXytYKfC4C0eO1r.Lqr4jZEU.QnWTZNVRzOCNqyeAFcW', 'Manager'),
(3, NULL, 'manager2', '$2y$10$VvRQYv27EUDMhqE/nAi1I.amqqR/MIkCE8QclUrlkkCV/5ajycDGO', 'Manager'),
(4, NULL, 'manager3', '$2y$10$oR1b.6P8qT6OfgOsXAhheO1wXQ98GhQliLmk9Ywd0x5EYwL6fjyeC', 'Manager'),
(5, 1, 'John', '$2y$10$hifAqpO.2lcKfbs.tLm.HugdByCU6S.UVDDq4HSZp1JJQXv9.B3jm', 'Tenant'),
(6, 2, 'Jane', '$2y$10$T0FlqBFlZH8ytA57asIrzet34SNOAYucGixgQoiRDBt0I.1L/RHtG', 'Tenant'),
(7, 3, 'michael.johnson.3', '$2y$10$SLVd3o1YqzWLCGfRZI4U..CKiniLO9h1M1DZ6CFld.h/z/XvrgpaS', 'Tenant'),
(8, 4, 'emily.davis.4', '$2y$10$FI4izAoxPqB76NzHxbEsnuOD9AmUB23gi1dpCtcwmScHRJ9Mp7Vue', 'Tenant'),
(9, 5, 'robert.brown.5', '$2y$10$iqOheV0QIqFciV9.mWtsl.R2GKaNoNaziwfRAZzdODxh4Kn3m6e.e', 'Tenant');

--
-- Indexes for dumped tables
--

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
  ADD KEY `tenant_ID` (`tenant_ID`),
  ADD KEY `apartmentNumber` (`apartmentNumber`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_ID`),
  ADD KEY `apartmentNumber` (`apartmentNumber`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`tenant_ID`);

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
  ADD KEY `tenant_ID` (`tenant_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apartment`
--
ALTER TABLE `apartment`
  MODIFY `apartmentNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `lease_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `tenant_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactionlog`
--
ALTER TABLE `transactionlog`
  MODIFY `transaction_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `lease_ibfk_1` FOREIGN KEY (`tenant_ID`) REFERENCES `tenant` (`tenant_ID`),
  ADD CONSTRAINT `lease_ibfk_2` FOREIGN KEY (`apartmentNumber`) REFERENCES `apartment` (`apartmentNumber`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`apartmentNumber`) REFERENCES `apartment` (`apartmentNumber`);

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
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`tenant_ID`) REFERENCES `tenant` (`tenant_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
