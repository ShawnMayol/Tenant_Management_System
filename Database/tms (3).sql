-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2024 at 05:08 PM
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
(1, 2, 'Logout', '2024-07-12 15:23:42'),
(2, 2, 'Login', '2024-07-12 15:27:36'),
(3, 1, 'Login', '2024-07-12 15:30:21'),
(4, 2, 'Changed apartment 16 status to Maintenance', '2024-07-12 15:45:01'),
(5, 2, 'Logout', '2024-07-12 15:45:57'),
(6, 2, 'Login', '2024-07-12 15:47:58'),
(7, 1, 'Logout', '2024-07-12 16:38:55'),
(8, 2, 'Rejected request 3', '2024-07-12 16:46:32'),
(9, 2, 'Pinned request 5', '2024-07-12 17:05:30'),
(10, 2, 'Unpinned request 5', '2024-07-12 17:05:36'),
(11, 2, 'Pinned request 4', '2024-07-12 17:06:37'),
(12, 2, 'Unpinned request 4', '2024-07-12 17:08:37'),
(13, 2, 'Pinned request 5', '2024-07-12 17:08:52'),
(14, 2, 'Pinned request 4', '2024-07-12 17:09:02'),
(15, 1, 'Login', '2024-07-12 17:26:08'),
(16, 2, 'Login', '2024-07-13 02:13:02'),
(17, 2, 'Logout', '2024-07-13 05:00:14'),
(18, 2, 'Login', '2024-07-13 05:02:48'),
(19, 2, 'Finalized lease 1', '2024-07-13 06:46:21'),
(20, 2, 'Finalized lease 2', '2024-07-13 06:56:45'),
(21, 2, 'Finalized lease 3', '2024-07-13 07:02:43'),
(22, 2, 'Finalized lease 4', '2024-07-13 07:22:10'),
(23, 2, 'Finalized lease 5', '2024-07-13 07:27:54'),
(24, 2, 'Finalized lease 6', '2024-07-13 07:45:30'),
(25, 2, 'Approved lease 7', '2024-07-13 07:55:04'),
(26, 2, 'Changed apartment 16 status to Maintenance', '2024-07-13 07:59:19'),
(27, 2, 'Changed apartment 16 status to Available', '2024-07-13 07:59:23'),
(28, 2, 'Logout', '2024-07-13 08:00:33'),
(29, 1, 'Login', '2024-07-13 08:00:39'),
(30, 1, 'Logout', '2024-07-13 08:02:19'),
(31, 3, 'Login', '2024-07-13 08:02:30'),
(32, 3, 'Logout', '2024-07-13 08:08:22'),
(33, 2, 'Login', '2024-07-13 08:10:28'),
(34, 2, 'Logout', '2024-07-13 09:09:52'),
(35, 1, 'Login', '2024-07-13 09:09:57'),
(36, 1, 'Logout', '2024-07-13 11:02:12'),
(37, 2, 'Login', '2024-07-13 11:02:17'),
(38, 2, 'Logout', '2024-07-13 11:04:04'),
(39, 1, 'Login', '2024-07-13 11:04:09'),
(40, 1, 'Logout', '2024-07-13 11:09:37'),
(41, 2, 'Login', '2024-07-13 11:09:43'),
(42, 2, 'Logout', '2024-07-13 12:13:21'),
(43, 1, 'Login', '2024-07-13 12:13:25'),
(44, 1, 'Logout', '2024-07-13 12:25:36'),
(45, 2, 'Login', '2024-07-13 12:25:40'),
(46, 2, 'Delete announcement 5', '2024-07-13 14:36:12'),
(47, 2, 'Delete announcement 3', '2024-07-13 14:36:21'),
(48, 2, 'Post announcement 7', '2024-07-13 14:37:56'),
(49, 2, 'Edit announcement 7', '2024-07-13 14:39:28'),
(50, 2, 'Logout', '2024-07-13 14:40:32'),
(51, 1, 'Login', '2024-07-13 14:40:37'),
(52, 1, 'Post announcement 8', '2024-07-13 14:42:36'),
(53, 1, 'Edit announcement 8', '2024-07-13 14:42:45'),
(54, 1, 'Delete announcement 7', '2024-07-13 14:42:51'),
(55, 2, 'Login', '2024-07-13 14:49:19'),
(56, 2, 'Logout', '2024-07-13 14:58:50'),
(57, 4, 'Login', '2024-07-13 14:58:57'),
(58, 4, 'Logout', '2024-07-13 14:59:48'),
(59, 4, 'Login', '2024-07-13 14:59:55'),
(60, 4, 'Edit announcement 8', '2024-07-13 15:00:05'),
(61, 4, 'Logout', '2024-07-13 15:06:15');

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
(1, 'All', 'Test', 'TESTSETSETSET', '2024-07-13 13:06:19', 2),
(2, 'All', 'Test', 'TESTSETSETSET', '2024-07-13 13:06:24', 2),
(4, 'All', 'AKSDFHJAKLSDHF', 'ASLKDFJAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '2024-07-13 13:55:02', 2),
(8, 'All', 'AAAAAAAAFAFASF', 'STOP', '2024-07-13 14:42:36', 1);

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
(1, 'Studio', 1200.00, '20 sqm', 'LB468, Nasipit, Talamban, Cebu', 2, 'Hidden', NULL, '../../uploads/apartment/pic-1.jpg', 'Cozy studio apartment with modern amenities.'),
(2, '10 Bedrooms', 1500.00, '30 sqm', 'LB469, Nasipit, Talamban, Cebu', 3, 'Available', NULL, '../../uploads/apartment/pic-1.jpg', 'Spacious one-bedroom apartment with scenic views.'),
(3, '2 Bedroom', 2000.00, '50 sqm', '0', 4, 'Hidden', NULL, '../../uploads/apartment/pic-1.jpg', '0'),
(4, '3 Bedroom', 2500.00, '80 sqm', 'Cebu City, Philippines', 5, 'Available', NULL, '../../uploads/apartment/pic-1.jpg', 'Very nice place and cheap'),
(5, '1 Bedroom', 1600.00, '35 sqm', 'LB484, Nasipit, Talamban, Cebu', 3, 'Available', NULL, '../../uploads/apartment/pic-1.jpg', 'Charming one-bedroom apartment in a quiet neighborhood.'),
(6, '2 Bedroom', 2100.00, '60 sqm', 'LB483, Nasipit, Talamban, Cebu', 4, 'Available', NULL, '../../uploads/apartment/pic-1.jpg', 'Modern two-bedroom apartment with contemporary design.'),
(7, 'Penthouse', 5000.00, '120 sqm', 'LB482, Nasipit, Talamban, Cebu', 6, 'Available', NULL, '../../uploads/apartment/pic-1.jpg', 'Exquisite penthouse offering breathtaking city skyline.'),
(8, 'Studio', 1200.00, '25 sqm', 'LB481, Nasipit, Talamban, Cebu', 2, 'Available', NULL, '../../uploads/apartment/pic-1.jpg', 'Cozy studio apartment perfect for individuals or couples.'),
(9, '3 Bedroom', 20000.00, '50 sqm', '0', 1, 'Available', NULL, '../../uploads/apartment/pic-1.jpg', 'asdf'),
(10, 'Studio', 1500.00, '100 sqm', 'Cebu City, Philippines', 10, 'Available', NULL, '../../uploads/apartment/studio.jpg', 'Lorem Ipsum Imaizumin'),
(11, 'Studio', 2000.00, '50 sqm', 'LALALALALA', 2, 'Available', NULL, '../../uploads/apartment/studio.jpg', 'asdjhf aksdfh jashd f aksdhjfkajdh sfklaakjd shfkdj'),
(12, '2 Bedroom', 2000.00, '50 sqm', '0', 2, 'Available', NULL, '../../uploads/apartment/studio.jpg', 'a'),
(13, '3 Bedroom', 2000.00, '50 sqm', 'USC - Talamban, Nasipit, Cebu', 2, 'Occupied', '2024-08-13', '../../uploads/apartment/studio.jpg', 'Brand new 3 bedroom Apartment, cheap and affordable !'),
(14, '3 Bedroom', 2000.00, '50 sqmaa', 'Cybergalaxy, Milkyway', 2, 'Available', NULL, '../../uploads/apartment/2bedroom2.jpg', 'Somewhere in planet Nemek'),
(15, 'Mansion ni Bro', 6000.00, '50 sqm', 'Somewhere in Cebu City', 4, 'Maintenance', '2024-07-20', '../../uploads/apartment/penthouse.jpg', 'Balay ni Lance Cerenio'),
(16, '1 Bedroom', 1000.00, '20 sqm', 'USC - Talamban, Nasipit, Cebu', 1, 'Available', NULL, '../../uploads/apartment/apartment.jpg', 'Cheap and affordable 1 bedroom apartment for individuals.'),
(17, 'Studio', 3000.00, '25 sqm', 'Cebu City, Philippines', 2, 'Available', NULL, '../../uploads/apartment/apartment2.jpg', 'A nice studio apartment.'),
(18, 'Studio', 2500.00, '25 sqm', 'Cebu City, Philippines', 2, 'Available', NULL, '../../uploads/apartment/apartment.jpg', 'A nice apartment');

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

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_ID`, `fee_ID`, `dueDate`, `dateIssued`) VALUES
(1, 1, '2024-08-01', '2024-07-25'),
(2, 2, '2024-08-01', '2024-07-25'),
(3, 3, '2024-08-01', '2024-07-25'),
(4, 4, '2024-08-01', '2024-07-25'),
(5, 5, '2024-08-01', '2024-07-25');

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
  `leaseStatus` enum('active','expired','terminated') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lease`
--

INSERT INTO `lease` (`lease_ID`, `apartmentNumber`, `startDate`, `endDate`, `billingPeriod`, `securityDeposit`, `leaseStatus`) VALUES
(1, 8, '2024-07-12', '2025-01-12', 'monthly', 1200.00, 'active'),
(2, 8, '2024-07-12', '2025-01-12', 'monthly', 1200.00, 'active'),
(3, 8, '2024-07-12', '2025-01-12', 'monthly', 1200.00, 'active'),
(4, 5, '2024-07-12', '2024-08-12', 'monthly', 1600.00, 'active'),
(5, 16, '2024-07-13', '2024-08-13', 'monthly', 1000.00, 'active'),
(6, 2, '2024-07-13', '2024-08-13', 'monthly', 1500.00, 'active'),
(7, 13, '2024-07-13', '2024-08-13', 'monthly', 2000.00, 'active');

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
(1, 2, 'Shawn', 'Cerenio', 'Majorenos', '2008-03-19', '09280903371', 'ex@gmail.com', '2024-07-11', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', 'Rejected', 'short', '2024-07-11', '2024-08-11', 'monthly', 1, '', 'Prefer not to say'),
(2, 8, 'Elgen', 'Arinasa', 'Mar', '2001-04-29', '09121231234', 'elgen@gmail.com', '2024-07-12', '../../uploads/request/identification.jpg', '../../uploads/request/proof of income.png', '../../uploads/request/address.jpg', '../../uploads/request/reference letter.png', 'Rejected', 'long', '2024-07-12', '2025-01-12', 'monthly', 2, 'I really need this apartment by next week. ', 'Male'),
(3, 16, 'John', 'Doe', '', '2004-09-15', '09121235678', 'john@gmail.com', '2024-07-12', '../../uploads/request/identification.jpg', '../../uploads/request/proof of income.png', '../../uploads/request/address.jpg', '../../uploads/request/reference letter.png', 'Rejected', 'short', '2024-07-12', '2024-08-12', 'monthly', 1, 'Please I need this apartment', 'Female'),
(4, 8, 'Shawn', 'Mayol', '', '2004-03-19', '09290009931', 'shawn@gmail.com', '2024-07-12', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', 'Approved', 'long', '2024-07-12', '2025-01-12', 'monthly', 1, 'Test', 'Male'),
(5, 5, 'John', 'Doe', '', '2004-09-17', '09280987654', 'john@gmail.com', '2024-07-12', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', 'Approved', 'short', '2024-07-12', '2024-08-12', 'monthly', 3, 'plsplsplsplspls', 'Female'),
(6, 16, 'Shawn', 'Mayol', 'Majorenos', '1111-11-11', '09298089931', 'lances@gmail.com', '2024-07-13', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', 'Approved', 'short', '2024-07-13', '2024-08-13', 'monthly', 1, 'asdf', 'Male'),
(7, 2, 'Elgen', 'Cerenio', 'Mar', '2312-12-31', '09298089931', 'lances@gmail.com', '2024-07-13', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', 'Approved', 'short', '2024-07-13', '2024-08-13', 'monthly', 1, '', 'Male'),
(8, 13, 'Lance', 'Arinasa', 'Mar', '1111-11-11', '09298089931', 'ex@gmail.com', '2024-07-13', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', '../../uploads/request/lease.jpg', 'Approved', 'short', '2024-07-13', '2024-08-13', 'monthly', 1, '', 'Male');

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
(2, 'Carl', 'Omega', 'Alias', '1985-03-15', '234-567-8901', 'carl@gmail.com', 'Inactive', 'Manager'),
(3, 'Klyde', 'Perante', 'Jemar', '1982-08-20', '345-678-9012', 'klyde@gmail.com', 'Inactive', 'Manager'),
(4, 'Shawn', 'Mayol', 'Jurgen', '1975-11-10', '456-789-0123', 'shawn@gmail.com', 'Inactive', 'Manager');

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
(1, 1, 'Shawn', 'Mayol', '', '2004-03-19', 'Male', '09290009931', 'shawn@gmail.com', 'Lessee'),
(2, 2, 'Shawn', 'Mayol', '', '2004-03-19', 'Male', '09290009931', 'shawn@gmail.com', 'Lessee'),
(3, 3, 'Shawn', 'Mayol', '', '2004-03-19', 'Male', '09290009931', 'shawn@gmail.com', 'Lessee'),
(4, 4, 'John', 'Doe', '', '2004-09-17', 'Female', '09280987654', 'john@gmail.com', 'Lessee'),
(5, 5, 'Shawn', 'Mayol', 'Majorenos', '1111-11-11', 'Male', '09298089931', 'lances@gmail.com', 'Lessee'),
(6, 5, 'Shawn', 'Mayol', 'Majorenos', '1111-11-11', 'Male', '09298089931', 'lances@gmail.com', 'Occupant'),
(7, 6, 'Elgen', 'Cerenio', 'Mar', '2312-12-31', 'Male', '09298089931', 'lances@gmail.com', 'Lessee'),
(8, 6, 'Elgen', 'Cerenio', 'Mar', '2312-12-31', 'Male', '09298089931', 'lances@gmail.com', 'Occupant'),
(9, 6, 'Jane', 'asdf', '', '1111-11-11', 'Female', '09871234567', 'jane@gmail.com', 'Occupant'),
(10, 6, 'asdf', 'adsf', '', '3123-11-12', 'Prefer not to say', '09876541234', 'jane@gmail.com', 'Occupant'),
(11, 7, 'Lance', 'Arinasa', 'Mar', '1111-11-11', 'Male', '09298089931', 'ex@gmail.com', 'Lessee'),
(12, 7, 'Lance', 'Arinasa', 'Mar', '1111-11-11', 'Male', '09298089931', 'ex@gmail.com', 'Occupant');

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
(1, NULL, 1, 'ADMIN', '$2y$10$hIzSVZMiVRvrzaP3E6pcuO48j5TehF4ObDvHsfuyM.aKHSR9Ke5wa', 'Admin', '../../uploads/staff/emp.jpg'),
(2, NULL, 2, 'Carl', '$2y$10$eS6heJGqoSJJRFhO9Zh/L.lHLTau7knx81bZIkO4/e9xzDGQyeDN6', 'Manager', '../../uploads/staff/carl.jpg'),
(3, NULL, 3, 'Klyde', '$2y$10$f9WfysGC/vkTnOmU5TfuwOb/8RmGY0R1K4Eiutmj6u5dWxehUKaOG', 'Manager', '../../uploads/staff/manager2.jpg'),
(4, NULL, 4, 'shawn', '$2y$10$SMkc1Osm9/wtNigHngOXEO3q0ySo8GPXp2nCycHqDnJj6CiJCloj6', 'Manager', '../../uploads/staff/manager3.jpg'),
(5, 1, NULL, 'john', '$2y$10$hifAqpO.2lcKfbs.tLm.HugdByCU6S.UVDDq4HSZp1JJQXv9.B3jm', 'Tenant', '../../uploads/staff/placeholder.jpg'),
(6, 2, NULL, 'Jane', '$2y$10$T0FlqBFlZH8ytA57asIrzet34SNOAYucGixgQoiRDBt0I.1L/RHtG', 'Tenant', '../../uploads/staff/placeholder.jpg'),
(7, 3, NULL, 'michael.johnson.3', '$2y$10$SLVd3o1YqzWLCGfRZI4U..CKiniLO9h1M1DZ6CFld.h/z/XvrgpaS', 'Tenant', '../../uploads/staff/placeholder.jpg'),
(8, 4, NULL, 'emily.davis.4', '$2y$10$FI4izAoxPqB76NzHxbEsnuOD9AmUB23gi1dpCtcwmScHRJ9Mp7Vue', 'Tenant', '../../uploads/staff/placeholder.jpg'),
(9, 5, NULL, 'robert.brown.5', '$2y$10$iqOheV0QIqFciV9.mWtsl.R2GKaNoNaziwfRAZzdODxh4Kn3m6e.e', 'Tenant', '../../uploads/staff/placeholder.jpg');

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
  MODIFY `activity_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `apartment`
--
ALTER TABLE `apartment`
  MODIFY `apartmentNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `invoice_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lease`
--
ALTER TABLE `lease`
  MODIFY `lease_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `tenant_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  ADD CONSTRAINT `fk_user_staff` FOREIGN KEY (`staff_ID`) REFERENCES `staff` (`staff_ID`),
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`tenant_ID`) REFERENCES `tenant` (`tenant_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
