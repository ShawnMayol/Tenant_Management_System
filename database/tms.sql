-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2024 at 11:43 AM
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
(2, '10 Bedrooms', 1500.00, '30 sqm', 'LB469, Nasipit, Talamban, Cebu', 3, 'Available', '../../uploads/apartment/pic-1.jpg', 'Spacious one-bedroom apartment with scenic views.'),
(3, '2 Bedroom', 2000.00, '50 sqm', '0', 4, 'Hidden', '../../uploads/apartment/pic-1.jpg', '0'),
(4, '3 Bedroom', 2500.00, '80 sqm', 'Cebu City, Philippines', 5, 'Available', '../../uploads/apartment/pic-1.jpg', 'Very nice place and cheap'),
(5, '1 Bedroom', 1600.00, '35 sqm', 'LB484, Nasipit, Talamban, Cebu', 3, 'Available', '../../uploads/apartment/pic-1.jpg', 'Charming one-bedroom apartment in a quiet neighborhood.'),
(6, '2 Bedroom', 2100.00, '60 sqm', 'LB483, Nasipit, Talamban, Cebu', 4, 'Available', '../../uploads/apartment/pic-1.jpg', 'Modern two-bedroom apartment with contemporary design.'),
(7, 'Penthouse', 5000.00, '120 sqm', 'LB482, Nasipit, Talamban, Cebu', 6, 'Available', '../../uploads/apartment/pic-1.jpg', 'Exquisite penthouse offering breathtaking city skyline.'),
(8, 'Studio', 1200.00, '25 sqm', 'LB481, Nasipit, Talamban, Cebu', 2, 'Maintenance', '../../uploads/apartment/pic-1.jpg', 'Cozy studio apartment perfect for individuals or couples.'),
(9, '3 Bedroom', 20000.00, '50 sqm', '0', 1, 'Available', '../../uploads/apartment/pic-1.jpg', 'asdf'),
(10, 'Studio', 100.00, '100 sqm', 'Cebu City, Philippines', 10, 'Available', '../../uploads/apartment/studio.jpg', 'Lorem Ipsum Imaizumin'),
(11, 'Studio', 2000.00, '50 sqm', 'LALALALALA', 2, 'Available', '../../uploads/apartment/studio.jpg', 'asdjhf aksdfh jashd f aksdhjfkajdh sfklaakjd shfkdj'),
(12, '2 Bedroom', 2000.00, '50 sqm', '0', 2, 'Available', '../../uploads/apartment/studio.jpg', 'a'),
(13, '3 Bedroom', 2000.00, '50 sqm', 'USC - Talamban, Nasipit, Cebu', 2, 'Available', '../../uploads/apartment/studio.jpg', 'Brand new 3 bedroom Apartment, cheap and affordable !'),
(14, '3 Bedroom', 2000.00, '50 sqmaa', 'Cybergalaxy, Milkyway', 2, 'Available', '../../uploads/apartment/Acer_Wallpaper_04_3840x2400.jpg', 'Somewhere in planet Nemek'),
(15, 'Mansion ni Bro', 20000.00, '50 sqm', 'Somewhere in Cebu City', 4, 'Maintenance', '../../uploads/apartment/Acer_Wallpaper_03_3840x2400.jpg', 'Balay ni Lance Cerenio'),
(16, '1 Bedroomasdjf', 1000.00, '20 sqm', 'USC - Talamban, Nasipit, Cebu', 1, 'Maintenance', '../../uploads/apartment/Acer_Wallpaper_04_3840x2400.jpg', 'Cheap and affordable 1 bedroom apartment for individuals.');

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
  `requestBin` varchar(255) NOT NULL,
  `requestStatus` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
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

INSERT INTO `request` (`request_ID`, `apartmentNumber`, `firstName`, `lastName`, `middleName`, `dateOfBirth`, `phoneNumber`, `emailAddress`, `requestDate`, `requestBin`, `requestStatus`, `termsOfStay`, `startDate`, `endDate`, `billingPeriod`, `occupants`, `message`, `gender`) VALUES
(1, 1, 'Elgen', 'Arinasa', 'Mar', '2005-03-21', '6969696969', 'elgenelgen@gmail.com', '2024-07-04', '/uploads/request/23103613.jpg', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 'Klyde', 'Perante', 'Jemar', '1111-11-11', '111111', 'klyde@a', '2024-07-04', 'uploads/request/23103613.jpg', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, 'Carl', 'Omega', 'Alias', '2222-02-22', '222222222', 'alias314@gmail.com', '2024-07-04', '../../uploads/request/Screenshot 2024-07-02 233356.png', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, 'Shawn', 'Cuime', 'J', '3333-03-31', '3333333', 'shawn2@gmail.com', '2024-07-04', '../../uploads/request/Screenshot 2024-07-03 234828.png', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, 'Shawn', 'Veloso', 'Clifford', '5555-05-05', '2342341', 'shv@gmail.com', '2024-07-04', '../../uploads/request/Screenshot 2024-07-03 143157.png', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, 'Nil', 'Alvarez', 'Benedict', '2411-11-24', '124235', 'alv@a', '2024-07-04', '../../tms3/App/uploads/request/Screenshot 2024-07-03 234828.png', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 8, 'asdf', 'adfg', 'asdg', '0000-00-00', '6969696969', 'email@email.com', '2024-07-04', '../../App/uploads/request/Screenshot 2024-07-03 143157.png', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 'John', 'Cena', '', '1141-12-12', '1111111', 'jc@gmail.com', '2024-07-04', '../../App/uploads/request/johncena.jpg', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 4, 'John', 'Wick', '', '1212-12-12', '1241245124', 'a@a', '2024-07-04', '../../uploads/request/johnwick.jpg', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 4, 'ja', 'asdf', 'adf', '1111-11-11', '6969696969', 'email@email.com', '2024-07-04', '/uploads/request/johncena.jpg', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 4, 'ja', 'asdf', 'adf', '1111-11-11', '6969696969', 'email@email.com', '2024-07-04', '../../uploads/request/johncena.jpg', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 4, 'ja', 'asdf', 'adf', '1111-11-11', '6969696969', 'email@email.com', '2024-07-04', '../../App/uploads/request/johncena.jpg', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 4, 'ja', 'asdf', 'adf', '1111-11-11', '6969696969', 'email@email.com', '2024-07-04', '../../tms3/App/uploads/request/johncena.jpg', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 3, 'Shawn', 'Mayol', 'Cuime', '2004-03-19', '09298089931', 'email@gmail.com', '2024-07-04', '../../tms3/App/uploads/request/23103613.jpg', 'Pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 5, 'Shawn', 'Cerenio', 'Majorenos', '3231-01-21', '09298089931', 'lancegwapo@gmail.com', '2024-07-06', '../../uploads/request/johncena.jpg', 'Pending', 'short', '2024-07-06', '2024-08-06', 'monthly', 1, 'Is there aircon and wifi?', ''),
(18, 6, 'Elgen', 'Arinasa', 'Mar', '2005-03-10', '6969696969', 'elgeneglenegln@gmail.com', '2024-07-06', '../../uploads/request/Acer_Wallpaper_03_3840x2400.jpg', 'Pending', 'short', '2024-07-06', '2024-08-06', 'monthly', 1, 'Is there aircon and wifi?', 'Male'),
(19, 3, 'Shawn', 'Mayol', 'Jurgen', '2004-03-19', '6969696969', 'shawn@gmail.com', '2024-07-06', '../../uploads/request/Acer_Wallpaper_01_3840x2400.jpg', 'Pending', 'long', '2024-07-06', '2025-01-06', 'monthly', 2, 'Looking for good neighborhood.', 'Female'),
(20, 6, 'Lance', 'Cerenio', 'Majorenos', '9122-09-01', '12345678910', 'lancegwapo@gmail.com', '2024-07-06', '../../uploads/request/Acer_Wallpaper_03_3840x2400.jpg', 'Pending', 'short', '2024-07-06', '2024-08-06', 'monthly', 1, 'Please accept me', 'Prefer not to say'),
(21, 2, 'John', 'Newman', '', '1007-09-20', '12345678910', 'jhon@gmail.com', '2024-07-06', '../../uploads/request/Acer_Wallpaper_05_3840x2400.jpg', 'Pending', 'short', '2024-07-06', '2024-08-06', 'monthly', 1, 'Hi', 'Male'),
(22, 1, 'John', 'Newman', '', '2001-09-07', '09876541234', 'newman@gmail.com', '2024-07-06', '../../uploads/request/Acer_Wallpaper_02_3840x2400.jpg', 'Pending', 'long', '2024-07-08', '2025-01-06', 'monthly', 1, 'Hello, what are the commodities that comes with this apartment? ', 'Prefer not to say');

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
  `staffStatus` enum('Active','Inactive','Fired') NOT NULL DEFAULT 'Active',
  `staffRole` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_ID`, `firstName`, `lastName`, `middleName`, `dateOfBirth`, `phoneNumber`, `emailAddress`, `staffStatus`, `staffRole`) VALUES
(1, 'Lance', 'Cerenio', 'Gwapo', '1980-01-01', '09690969696', 'lance@gmail.com', 'Active', 'Admin'),
(2, 'Carl', 'Omega', 'Alias', '1985-03-15', '234-567-8901', 'carl@gmail.com', 'Active', 'Manager'),
(3, 'Klyde', 'Perante', 'Jemar', '1982-08-20', '345-678-9012', 'klyde@gmail.com', 'Active', 'Manager'),
(4, 'Shawn', 'Mayol', 'Jurgen', '1975-11-10', '456-789-0123', 'shawn@gmail.com', 'Active', 'Manager');

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
  `tenantStatus` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`tenant_ID`, `firstName`, `lastName`, `middleName`, `dateOfBirth`, `phoneNumber`, `emailAddress`, `deposit`, `tenantStatus`) VALUES
(1, 'John', 'Doe', 'Alpha', '1990-01-01', '12345678901', 'john@example.com', 0.00, 'Active'),
(2, 'Jane', 'Smith', 'Beta', '1985-05-15', '0987654321', 'jane@example.com', 0.00, 'Active'),
(3, 'Michael', 'Johnson', 'Charlie', '1975-09-30', '5678901234', 'michael.johnson@example.com', 0.00, 'Active'),
(4, 'Emily', 'Davis', 'Delta', '2000-12-20', '2345678901', 'emily.davis@example.com', 0.00, 'Active'),
(5, 'Robert', 'Brown', 'Echo', '1995-07-10', '3456789012', 'robert.brown@example.com', 0.00, 'Active');

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
  `userRole` enum('Admin','Manager','Tenant') NOT NULL,
  `picDirectory` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `tenant_ID`, `staff_ID`, `username`, `password`, `userRole`, `picDirectory`) VALUES
(1, NULL, 1, 'ADMIN', '$2y$10$hIzSVZMiVRvrzaP3E6pcuO48j5TehF4ObDvHsfuyM.aKHSR9Ke5wa', 'Admin', NULL),
(2, NULL, 2, 'Carl', '$2y$10$eS6heJGqoSJJRFhO9Zh/L.lHLTau7knx81bZIkO4/e9xzDGQyeDN6', 'Manager', NULL),
(3, NULL, 3, 'manager2', '$2y$10$VvRQYv27EUDMhqE/nAi1I.amqqR/MIkCE8QclUrlkkCV/5ajycDGO', 'Manager', NULL),
(4, NULL, 4, 'manager3', '$2y$10$oR1b.6P8qT6OfgOsXAhheO1wXQ98GhQliLmk9Ywd0x5EYwL6fjyeC', 'Manager', NULL),
(5, 1, NULL, 'John', '$2y$10$hifAqpO.2lcKfbs.tLm.HugdByCU6S.UVDDq4HSZp1JJQXv9.B3jm', 'Tenant', NULL),
(6, 2, NULL, 'Jane', '$2y$10$T0FlqBFlZH8ytA57asIrzet34SNOAYucGixgQoiRDBt0I.1L/RHtG', 'Tenant', NULL),
(7, 3, NULL, 'michael.johnson.3', '$2y$10$SLVd3o1YqzWLCGfRZI4U..CKiniLO9h1M1DZ6CFld.h/z/XvrgpaS', 'Tenant', NULL),
(8, 4, NULL, 'emily.davis.4', '$2y$10$FI4izAoxPqB76NzHxbEsnuOD9AmUB23gi1dpCtcwmScHRJ9Mp7Vue', 'Tenant', NULL),
(9, 5, NULL, 'robert.brown.5', '$2y$10$iqOheV0QIqFciV9.mWtsl.R2GKaNoNaziwfRAZzdODxh4Kn3m6e.e', 'Tenant', NULL);

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
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_ID`);

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
  ADD KEY `tenant_ID` (`tenant_ID`),
  ADD KEY `fk_user_staff` (`staff_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activity_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `apartment`
--
ALTER TABLE `apartment`
  MODIFY `apartmentNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`staff_ID`) REFERENCES `staff` (`staff_ID`);

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
  ADD CONSTRAINT `fk_user_staff` FOREIGN KEY (`staff_ID`) REFERENCES `staff` (`staff_ID`),
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`tenant_ID`) REFERENCES `tenant` (`tenant_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
