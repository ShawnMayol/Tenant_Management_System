-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2024 at 03:27 PM
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
  `apartmentType` varchar(50) NOT NULL,
  `rentPerMonth` decimal(10,2) NOT NULL,
  `apartmentDimensions` varchar(50) DEFAULT NULL,
  `apartmentAddress` varchar(255) DEFAULT NULL,
  `maxOccupants` int(11) DEFAULT NULL,
  `apartmentStatus` enum('Available','Occupied','Maintenance','Hidden') DEFAULT 'Hidden',
  `apartmentPictures` varchar(255) DEFAULT NULL,
  `apartmentDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apartment`
--

INSERT INTO `apartment` (`apartmentNumber`, `apartmentType`, `rentPerMonth`, `apartmentDimensions`, `apartmentAddress`, `maxOccupants`, `apartmentStatus`, `apartmentPictures`, `apartmentDescription`) VALUES
(1, 'Studio', 1200.00, '20 sqm', 'LB468, Nasipit, Talamban, Cebu', 2, 'Available', '../../uploads/apartment/pic-1.jpg', 'Cozy studio apartment with modern amenities.'),
(2, '1 Bedroom', 1500.00, '30 sqm', 'LB469, Nasipit, Talamban, Cebu', 3, 'Available', '../../uploads/apartment/pic-1.jpg', 'Spacious one-bedroom apartment with scenic views.'),
(3, '2 Bedroom', 2000.00, '50 sqm', '0', 4, 'Available', '../../uploads/apartment/pic-1.jpg', '0'),
(4, '3 Bedroom', 2500.00, '80 sqm', '0', 5, 'Available', '../../uploads/apartment/pic-1.jpg', '0'),
(5, '1 Bedroom', 1600.00, '35 sqm', 'LB484, Nasipit, Talamban, Cebu', 3, 'Available', '../../uploads/apartment/pic-1.jpg', 'Charming one-bedroom apartment in a quiet neighborhood.'),
(6, '2 Bedroom', 2100.00, '60 sqm', 'LB483, Nasipit, Talamban, Cebu', 4, 'Available', '../../uploads/apartment/pic-1.jpg', 'Modern two-bedroom apartment with contemporary design.'),
(7, 'Penthouse', 5000.00, '120 sqm', 'LB482, Nasipit, Talamban, Cebu', 6, 'Hidden', '../../uploads/apartment/pic-1.jpg', 'Exquisite penthouse offering breathtaking city skyline.'),
(8, 'Studio', 1200.00, '25 sqm', 'LB481, Nasipit, Talamban, Cebu', 2, 'Maintenance', '../../uploads/apartment/pic-1.jpg', 'Cozy studio apartment perfect for individuals or couples.'),
(9, '3 Bedroomasdf', 20000.00, '50 sqm', '0', 1, 'Hidden', '../../uploads/apartment/pic-1.jpg', 'asdf'),
(10, 'Mansion', 100.00, '100 sqm', '0', 10, 'Hidden', '../../uploads/apartment/johnwick.jpg', '0'),
(11, 'Studio', 2000.00, '50 sqm', 'LALALALALA', 2, 'Hidden', '../../uploads/apartment/studio.jpg', 'asdjhf aksdfh jashd f aksdhjfkajdh sfklaakjd shfkdj'),
(12, '2 Bedroom', 2000.00, '50 sqm', '0', 2, 'Available', '../../uploads/apartment/studio.jpg', 'a'),
(13, '3 Bedrooma', 2000.00, '50 sqmaa', '0', 2, 'Available', '../../uploads/apartment/studio.jpg', 'new'),
(14, '3 Bedroom', 2000.00, '50 sqmaa', '0', 2, 'Available', '../../uploads/apartment/johncena.jpg', 'a'),
(15, 'Mansion ni Bro', 20000.00, '50 sqm', 'Somewhere in Cebu City', 4, 'Available', '../../uploads/apartment/johncena.jpg', 'Balay ni Lance Cerenio');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_ID` int(11) NOT NULL,
  `paymentMethod` varchar(50) NOT NULL,
  `amountPaid` decimal(10,2) NOT NULL,
  `overpayment` decimal(10,2) DEFAULT 0.00,
  `paymentDate` date NOT NULL
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
  `leaseStatus` enum('approved','expired') DEFAULT 'approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `requestBin` varchar(255) NOT NULL,
  `requestStatus` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `termsOfStay` varchar(10) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `billingPeriod` varchar(11) DEFAULT NULL,
  `occupants` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `gender` enum('Male','Female','Prefer not to say') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_ID`, `apartmentNumber`, `firstName`, `lastName`, `middleName`, `dateOfBirth`, `phoneNumber`, `emailAddress`, `requestDate`, `requestBin`, `requestStatus`, `termsOfStay`, `startDate`, `endDate`, `billingPeriod`, `occupants`, `note`, `gender`) VALUES
(1, 1, 'Elgen', 'Arinasa', 'Mar', '2005-03-21', '6969696969', 'elgenelgen@gmail.com', '2024-07-04', '/uploads/request/23103613.jpg', 'Pending', 'Short', '2024-07-04', '2024-09-12', NULL, NULL, NULL, NULL),
(2, 2, 'Klyde', 'Perante', 'Jemar', '1111-11-11', '111111', 'klyde@a', '2024-07-04', 'uploads/request/23103613.jpg', 'Pending', 'Long', '2024-07-04', '2025-03-04', NULL, NULL, NULL, NULL),
(3, 3, 'Carl', 'Omega', 'Alias', '2222-02-22', '222222222', 'alias314@gmail.com', '2024-07-04', '../../uploads/request/Screenshot 2024-07-02 233356.png', 'Pending', 'Long', '2024-07-05', '2025-01-04', NULL, NULL, NULL, NULL),
(16, 1, 'Lance', 'Cerenio', 'Majorenos', '2004-11-12', '09159031303', '20010110@usc.edu.ph', '2024-07-07', './uploads/request/IM 2 BPMN.png', 'Pending', 'Short', '2024-07-07', '2024-08-07', 'monthly', 1, 'I need this asap', 'Male');

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
  `staffStatus` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `staffRole` varchar(255) NOT NULL,
  `picDirectory` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_ID`, `firstName`, `lastName`, `middleName`, `dateOfBirth`, `phoneNumber`, `emailAddress`, `staffStatus`, `staffRole`, `picDirectory`) VALUES
(1, 'Lance', 'Cerenio', 'Gwapo', '1980-01-01', '09690969696', 'lance@gmail.com', 'Active', 'Admin', NULL),
(2, 'Carl', 'Omega', 'Alias', '1985-03-15', '234-567-8901', 'carl@gmail.com', 'Active', 'Manager', NULL),
(3, 'Klyde', 'Perante', 'Jemar', '1982-08-20', '345-678-9012', 'klyde@gmail.com', 'Active', 'Manager', NULL),
(4, 'Shawn', 'Mayol', 'Jurgen', '1975-11-10', '456-789-0123', 'shawn@gmail.com', 'Active', 'Manager', NULL);

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
  `tenantStatus` enum('Active','Inactive') DEFAULT 'Active',
  `request_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `userRole` enum('Admin','Manager','Tenant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `tenant_ID`, `staff_ID`, `username`, `password`, `userRole`) VALUES
(1, NULL, 1, 'Admin', '$2y$10$hIzSVZMiVRvrzaP3E6pcuO48j5TehF4ObDvHsfuyM.aKHSR9Ke5wa', 'Admin'),
(2, NULL, 2, 'manager1', '$2y$10$gDFFafLJErXytYKfC4C0eO1r.Lqr4jZEU.QnWTZNVRzOCNqyeAFcW', 'Manager'),
(3, NULL, 3, 'manager2', '$2y$10$VvRQYv27EUDMhqE/nAi1I.amqqR/MIkCE8QclUrlkkCV/5ajycDGO', 'Manager'),
(4, NULL, 4, 'manager3', '$2y$10$oR1b.6P8qT6OfgOsXAhheO1wXQ98GhQliLmk9Ywd0x5EYwL6fjyeC', 'Manager'),
(5, 1, NULL, 'John', '$2y$10$hifAqpO.2lcKfbs.tLm.HugdByCU6S.UVDDq4HSZp1JJQXv9.B3jm', 'Tenant'),
(6, 2, NULL, 'Jane', '$2y$10$T0FlqBFlZH8ytA57asIrzet34SNOAYucGixgQoiRDBt0I.1L/RHtG', 'Tenant'),
(7, 3, NULL, 'michael.johnson.3', '$2y$10$SLVd3o1YqzWLCGfRZI4U..CKiniLO9h1M1DZ6CFld.h/z/XvrgpaS', 'Tenant'),
(8, 4, NULL, 'emily.davis.4', '$2y$10$FI4izAoxPqB76NzHxbEsnuOD9AmUB23gi1dpCtcwmScHRJ9Mp7Vue', 'Tenant'),
(9, 5, NULL, 'robert.brown.5', '$2y$10$iqOheV0QIqFciV9.mWtsl.R2GKaNoNaziwfRAZzdODxh4Kn3m6e.e', 'Tenant');

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
  ADD PRIMARY KEY (`bill_ID`);

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
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_ID`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`tenant_ID`),
  ADD KEY `fk_request_id` (`request_ID`);

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
-- AUTO_INCREMENT for table `apartment`
--
ALTER TABLE `apartment`
  MODIFY `apartmentNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lease`
--
ALTER TABLE `lease`
  MODIFY `lease_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `tenant_ID` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `tenant`
--
ALTER TABLE `tenant`
  ADD CONSTRAINT `fk_request_id` FOREIGN KEY (`request_ID`) REFERENCES `request` (`request_ID`);

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
  ADD CONSTRAINT `fk_user_staff` FOREIGN KEY (`staff_ID`) REFERENCES `staff` (`staff_ID`),
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`tenant_ID`) REFERENCES `tenant` (`tenant_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
