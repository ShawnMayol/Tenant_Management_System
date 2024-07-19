-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2024 at 08:54 PM
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
(47, 2, 'Logout', '2024-07-14 14:57:14'),
(48, 1, 'Logout', '2024-07-15 02:53:37'),
(49, 2, 'Login', '2024-07-15 02:54:32'),
(50, 2, 'Approved lease 3', '2024-07-15 03:01:36'),
(51, 1, 'Login', '2024-07-15 03:03:04'),
(52, 2, 'Account Deactivated', '2024-07-15 03:06:57'),
(53, 2, 'Account Activated', '2024-07-15 03:07:21'),
(54, 2, 'Login', '2024-07-15 03:07:34'),
(55, 1, 'Edit announcement 1', '2024-07-15 03:08:25'),
(56, 2, 'Logout', '2024-07-15 03:09:46'),
(57, 2, 'Login', '2024-07-15 03:24:18'),
(58, 2, 'Logout', '2024-07-15 04:00:36'),
(59, 1, 'Logout', '2024-07-15 04:00:40'),
(60, 1, 'Login', '2024-07-15 04:00:50'),
(61, 1, 'Logout', '2024-07-15 06:29:18'),
(62, 1, 'Login', '2024-07-15 06:29:31'),
(63, 1, 'Logout', '2024-07-15 07:29:27'),
(64, 1, 'Login', '2024-07-15 07:30:33'),
(65, 1, 'Logout', '2024-07-15 07:31:55'),
(66, 2, 'Login', '2024-07-15 07:32:03'),
(67, 1, 'Login', '2024-07-15 07:37:17'),
(68, 1, 'Logout', '2024-07-15 07:40:23'),
(69, 1, 'Login', '2024-07-15 07:40:39'),
(70, 2, 'Logout', '2024-07-15 07:42:47'),
(71, 1, 'Login', '2024-07-15 14:16:08'),
(72, 2, 'Login', '2024-07-15 14:17:07'),
(73, 2, 'Logout', '2024-07-15 14:17:26'),
(74, 2, 'Login', '2024-07-15 14:17:31'),
(75, 2, 'Logout', '2024-07-15 14:37:07'),
(76, 1, 'Pinned request 4', '2024-07-15 15:29:18'),
(77, 1, 'Unpinned request 4', '2024-07-15 15:31:22'),
(78, 1, 'Pinned request 4', '2024-07-15 15:31:29'),
(79, 1, 'Unpinned request 4', '2024-07-15 15:47:35'),
(80, 1, 'Pinned request 4', '2024-07-15 15:48:38'),
(81, 1, 'Pinned request 5', '2024-07-15 15:48:48'),
(82, 1, 'Unpinned request 4', '2024-07-15 15:48:52'),
(83, 1, 'Unpinned request 5', '2024-07-15 15:49:00'),
(84, 1, 'Pinned request 4', '2024-07-15 15:50:16'),
(85, 1, 'Pinned request 5', '2024-07-15 15:50:24'),
(86, 1, 'Unpinned request 4', '2024-07-15 15:51:30'),
(87, 2, 'Login', '2024-07-15 16:21:58'),
(88, 1, 'Edit announcement 1', '2024-07-15 16:24:34'),
(89, 1, 'Approved lease 4', '2024-07-15 17:35:11'),
(90, 1, 'Unpinned request 5', '2024-07-15 17:42:16'),
(91, 1, 'Approved lease 5', '2024-07-15 17:48:41'),
(92, 2, 'Logout', '2024-07-15 18:17:21'),
(93, 1, 'Pinned request 6', '2024-07-15 18:28:05'),
(94, 1, 'Approved lease 6', '2024-07-15 19:32:25'),
(95, 1, 'Unpinned request 6', '2024-07-15 20:44:22'),
(96, 1, 'Pinned request 7', '2024-07-15 20:44:53'),
(97, 1, 'Pinned request 6', '2024-07-15 20:44:57'),
(98, 1, 'Login', '2024-07-16 04:14:24'),
(99, 1, 'Pinned request 8', '2024-07-16 09:00:29'),
(100, 1, 'Unpinned request 6', '2024-07-16 09:01:01'),
(101, 1, 'Unpinned request 7', '2024-07-16 09:01:04'),
(102, 1, 'Unpinned request 8', '2024-07-16 09:01:08'),
(103, 1, 'Pinned request 6', '2024-07-16 09:03:35'),
(104, 1, 'Unpinned request 6', '2024-07-16 09:04:53'),
(105, 1, 'Approved lease 7', '2024-07-16 09:46:47'),
(106, 1, 'Approved lease 12', '2024-07-16 09:54:29'),
(107, 1, 'Approved lease 13', '2024-07-16 10:30:38'),
(108, 1, 'Logout', '2024-07-16 12:47:44'),
(109, 1, 'Login', '2024-07-16 12:47:55'),
(110, 2, 'Login', '2024-07-19 03:53:58'),
(111, 2, 'Logout', '2024-07-19 03:59:11'),
(112, 2, 'Login', '2024-07-19 04:04:54'),
(113, 2, 'Pinned request 1', '2024-07-19 04:05:03'),
(114, 2, 'Unpinned request 1', '2024-07-19 04:05:12'),
(115, 2, 'Pinned request 1', '2024-07-19 04:05:14'),
(116, 2, 'Approved lease 18', '2024-07-19 04:34:33'),
(117, 2, 'Logout', '2024-07-19 05:02:57'),
(118, 2, 'Login', '2024-07-19 05:20:35'),
(119, 2, 'Approved lease 1', '2024-07-19 05:22:19'),
(120, 2, 'Logout', '2024-07-19 05:24:09'),
(121, 2, 'Login', '2024-07-19 06:27:53'),
(122, 1, 'Login', '2024-07-19 11:30:50'),
(123, 1, 'Logout', '2024-07-19 11:30:58'),
(124, 2, 'Login', '2024-07-19 11:42:28'),
(125, 1, 'Login', '2024-07-19 12:08:28'),
(126, 1, 'Logout', '2024-07-19 12:13:14'),
(127, 2, 'Pinned request 2', '2024-07-19 12:19:49'),
(128, 2, 'Pinned request 3', '2024-07-19 12:19:54'),
(129, 1, 'Login', '2024-07-19 12:28:28'),
(130, 1, 'Logout', '2024-07-19 13:00:38'),
(131, 2, 'Logout', '2024-07-19 13:00:40'),
(132, 1, 'Login', '2024-07-19 13:00:44'),
(133, 2, 'Login', '2024-07-19 18:01:44'),
(134, 2, 'Logout', '2024-07-19 18:13:27'),
(135, 2, 'Login', '2024-07-19 18:17:12'),
(136, 2, 'Logout', '2024-07-19 18:38:27'),
(137, 2, 'Login', '2024-07-19 18:44:11'),
(138, 2, 'Approved lease 2', '2024-07-19 18:44:21');

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
(1, 'Studio', 6000.00, '25 Square meter', 'Cebu City, Philippines', 2, 'Available', '2025-02-14', '../../uploads/apartment/apartment.jpg', 'A comfortable Studio apartment fit for couples or individuals!'),
(2, '2 Bedroom', 8000.00, '25 Square meter', 'Talamban, Cebu City', 4, 'Occupied', '2025-03-30', '../../uploads/apartment/2bedroom2.jpg', 'A lofty 2 Bedroom apartment perfect for small families.'),
(3, 'Studio', 6500.00, '25 Square meter', 'Talamban, Cebu City', 3, 'Available', '2024-04-12', '../../uploads/apartment/2bedroom.jpg', 'Space-y studio apartment good for 3 people.'),
(4, '3 Bedroom', 9000.00, '50 Square meter', 'LB 468, Talamban, Cebu City ', 4, 'Occupied', '2024-09-30', '../../uploads/apartment/penthouse.jpg', 'Cozy 3 bedroom apartment perfect for families.'),
(5, 'Studio', 6000.00, '20 Square meters', 'Talamban, Cebu City', 2, 'Available', '2024-12-20', '../../uploads/apartment/apartment2.jpg', 'Studio apartment');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_ID` int(11) NOT NULL,
  `lease_ID` int(11) DEFAULT NULL,
  `billStatus` enum('Pending','Paid','Overdue','Paid by Deposit') DEFAULT 'Pending',
  `amountDue` decimal(10,2) NOT NULL DEFAULT 0.00,
  `lateFees` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amountPaid` decimal(10,2) DEFAULT 0.00,
  `dueDate` date NOT NULL,
  `billDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`bill_ID`, `lease_ID`, `billStatus`, `amountDue`, `lateFees`, `amountPaid`, `dueDate`, `billDate`) VALUES
(4, 7, 'Paid by Deposit', 9000.00, 0.00, 9000.00, '2024-07-05', '2024-06-28'),
(5, 7, 'Pending', 9000.00, 0.00, 0.00, '2024-07-21', '2024-07-10'),
(6, 1, 'Paid by Deposit', 9000.00, 0.00, 9000.00, '2024-08-04', '2024-07-28'),
(8, 1, 'Paid by Deposit', 9000.00, 0.00, 9000.00, '2024-08-04', '2024-07-28'),
(9, 1, 'Paid by Deposit', 9000.00, 0.00, 9000.00, '2024-08-04', '2024-07-28'),
(10, 1, 'Paid by Deposit', 9000.00, 0.00, 9000.00, '2024-08-04', '2024-07-28'),
(11, 1, 'Paid by Deposit', 9000.00, 0.00, 9000.00, '2024-08-04', '2024-07-28'),
(12, 1, 'Paid by Deposit', 9000.00, 0.00, 9000.00, '2024-08-04', '2024-07-28'),
(13, 1, 'Paid by Deposit', 9000.00, 0.00, 9000.00, '2024-08-04', '2024-07-28'),
(14, 1, 'Paid by Deposit', 9000.00, 0.00, 9000.00, '2024-08-04', '2024-07-28'),
(15, 1, 'Paid by Deposit', 9000.00, 0.00, 9000.00, '2024-08-04', '2024-07-28');

-- --------------------------------------------------------

--
-- Table structure for table `lease`
--

CREATE TABLE `lease` (
  `lease_ID` int(11) NOT NULL,
  `apartmentNumber` int(11) DEFAULT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `billingPeriod` enum('Weekly','Monthly','Annually') NOT NULL DEFAULT 'Monthly',
  `rentalDeposit` decimal(10,2) NOT NULL,
  `securityDeposit` decimal(10,2) DEFAULT 0.00,
  `leaseStatus` enum('Active','Expired','Terminated') DEFAULT 'Active',
  `reviewedBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lease`
--

INSERT INTO `lease` (`lease_ID`, `apartmentNumber`, `startDate`, `endDate`, `billingPeriod`, `rentalDeposit`, `securityDeposit`, `leaseStatus`, `reviewedBy`, `createdOn`) VALUES
(1, 4, '2024-07-19', '2024-09-30', 'Monthly', 9000.00, 9000.00, 'Active', 2, '2024-07-19 05:22:18'),
(2, 2, '2024-09-30', '2025-03-30', 'Monthly', 0.00, 8000.00, 'Active', 2, '2024-07-19 18:44:21');

-- --------------------------------------------------------

--
-- Table structure for table `maintenancerequests`
--

CREATE TABLE `maintenancerequests` (
  `request_ID` int(11) NOT NULL,
  `tenant_ID` int(11) DEFAULT NULL,
  `apartmentNumber` int(11) DEFAULT NULL,
  `maintenanceType` enum('Plumbing','Electrical','HVAC','General','Other') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requestDate` date NOT NULL DEFAULT curdate(),
  `status` enum('Pending','In Progress','Resolved') NOT NULL DEFAULT 'Pending',
  `completionDate` date DEFAULT NULL,
  `handledBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenancerequests`
--

INSERT INTO `maintenancerequests` (`request_ID`, `tenant_ID`, `apartmentNumber`, `maintenanceType`, `description`, `requestDate`, `status`, `completionDate`, `handledBy`) VALUES
(1, 1, 4, 'Plumbing', 'Leaky faucet in the kitchen', '2024-07-10', 'Resolved', '2024-07-20', 1),
(2, 1, 4, 'Electrical', 'No power in the living room', '2024-07-11', 'Resolved', '2024-07-20', 2),
(3, 1, 4, 'HVAC', 'Air conditioner not cooling', '2024-07-12', 'Resolved', '2024-07-20', 1),
(4, 1, 4, 'General', 'Broken window in the bedroom', '2024-07-13', 'Resolved', '2024-07-20', 1),
(5, 1, 4, 'Other', 'Strange noise in the wallsStrange noise in the wallsStrange noise in the wallsStrange noise in the wallsStrange noise in the wallsStrange noise in the wallsStrange noise in the wallsStrange noise in the walls', '2024-07-14', 'Resolved', '2024-07-20', 1),
(8, 1, 4, 'HVAC', 'alsdhfaeg', '2024-07-20', 'Resolved', '2024-07-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_ID` int(11) NOT NULL,
  `bill_ID` int(11) DEFAULT NULL,
  `receivedBy` int(11) DEFAULT NULL,
  `paymentAmount` decimal(10,2) DEFAULT NULL,
  `proofOfPayment` varchar(255) DEFAULT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `paymentStatus` enum('Pending','Received','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_ID`, `bill_ID`, `receivedBy`, `paymentAmount`, `proofOfPayment`, `paymentDate`, `paymentStatus`) VALUES
(1, 6, 2, 9000.00, 'Paid by Deposit', '2024-07-19 05:22:18', 'Received'),
(2, 8, 2, 9000.00, 'Paid by Deposit', '2024-07-19 05:22:18', 'Received'),
(3, 9, 2, 9000.00, 'Paid by Deposit', '2024-07-19 05:22:18', 'Received'),
(4, 10, 2, 9000.00, 'Paid by Deposit', '2024-07-19 05:22:18', 'Received'),
(5, 11, 2, 9000.00, 'Paid by Deposit', '2024-07-19 05:22:18', 'Received'),
(6, 12, 2, 9000.00, 'Paid by Deposit', '2024-07-19 05:22:18', 'Received'),
(7, 13, 2, 9000.00, 'Paid by Deposit', '2024-07-19 05:22:18', 'Received'),
(8, 14, 2, 9000.00, 'Paid by Deposit', '2024-07-19 05:22:18', 'Received'),
(9, 15, 2, 9000.00, 'Paid by Deposit', '2024-07-19 05:22:18', 'Received');

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
(1, 4, 'Lance', 'Cerenio', 'Majorenos', '2004-11-12', '09159031303', '20010110@usc.edu.ph', '2024-07-19', '../../uploads/request/143063751.png', '../../uploads/request/3NF.png', '../../uploads/request/8tlwrk.jpg', '../../uploads/request/DSC01424-52.jpg', 'Approved', 'short', '2024-07-19', '2024-08-19', 'monthly', 2, 'Need this ASAP', 'Male'),
(2, 2, 'Juan', 'Cruz', 'Dela', '1987-09-12', '09129487128', 'juan@gmail.com', '2024-07-19', '../../uploads/request/identification.jpg', '../../uploads/request/proof of income.png', '../../uploads/request/address.jpg', '../../uploads/request/lease.jpg', 'Approved', 'long', '2024-09-30', '2025-03-30', 'monthly', 1, '', 'Male'),
(3, 2, 'Jose', 'Rizal', '', '1765-12-21', '09817264871', 'jose@mail.com', '2024-07-19', '../../uploads/request/identification.jpg', '../../uploads/request/proof of income.png', '../../uploads/request/address.jpg', '../../uploads/request/reference letter.png', 'Approved', 'long', '2024-07-19', '2025-12-19', 'monthly', 3, 'I really want this apartment ', 'Male');

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
(1, 1, 'Lance', 'Cerenio', 'Majorenos', '2004-11-12', 'Male', '09159031302', '20010110@usc.edu.ph', 'Lessee'),
(2, 1, 'Lance', 'Cerenio', 'Majorenos', '2004-11-12', 'Male', '09159031303', '20010110@usc.edu.ph', 'Occupant'),
(3, 1, 'Shawn', 'Mayol', '', '2024-07-19', 'Male', '12345678910', 'shawngwapo@gmail.com', 'Occupant'),
(4, 2, 'Juan', 'Cruz', 'Dela', '1987-09-12', 'Male', '09129487128', 'juan@gmail.com', 'Lessee'),
(5, 2, 'Juan', 'Cruz', 'Dela', '1987-09-12', 'Male', '09129487128', 'juan@gmail.com', 'Occupant');

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
(1, NULL, 1, 'Admin', '$2y$10$FHJjEueNM5xyn6GJXnGT2.uAz.6f53d3rPBXCHaMCugXh20sjFUza', 'Online', 'Admin', '../../uploads/staff/manager2.jpg'),
(2, NULL, 2, 'CarlOmega2', '$2y$10$50rOwAXNloSGQKqdKGLLyOrAea4I9CdpKUbrYVIdtf7NuLn9274Ia', 'Online', 'Manager', '../../uploads/staff/admin.jpg'),
(3, 1, NULL, 'LanceCerenio1', '$2y$10$TbulMiyxJN/XKJ1tIXxTaOXalfzFF9Lz8zL4EcQ.w46EMjfZ2p5fC', 'Offline', 'Tenant', '../../uploads/tenant/admin.jpg'),
(4, 4, NULL, 'JuanCruz2', '$2y$10$91uDDxswb9LTNv22yjTu1e0khZoL8lSyXdnQtu0LFbkkw7w8ZIOVe', 'Offline', 'Tenant', '../../uploads/tenant/placeholder.jpg');

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
  ADD KEY `lease_ID` (`lease_ID`);

--
-- Indexes for table `lease`
--
ALTER TABLE `lease`
  ADD PRIMARY KEY (`lease_ID`),
  ADD KEY `apartmentNumber` (`apartmentNumber`),
  ADD KEY `lease_ibfk_2` (`reviewedBy`);

--
-- Indexes for table `maintenancerequests`
--
ALTER TABLE `maintenancerequests`
  ADD PRIMARY KEY (`request_ID`),
  ADD KEY `tenant_ID` (`tenant_ID`),
  ADD KEY `apartmentNumber` (`apartmentNumber`),
  ADD KEY `handledBy` (`handledBy`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_ID`),
  ADD KEY `bill_ID` (`bill_ID`),
  ADD KEY `receivedBy` (`receivedBy`);

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
  MODIFY `activity_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `apartment`
--
ALTER TABLE `apartment`
  MODIFY `apartmentNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `lease`
--
ALTER TABLE `lease`
  MODIFY `lease_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `maintenancerequests`
--
ALTER TABLE `maintenancerequests`
  MODIFY `request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `tenant_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `lease`
--
ALTER TABLE `lease`
  ADD CONSTRAINT `lease_ibfk_1` FOREIGN KEY (`apartmentNumber`) REFERENCES `apartment` (`apartmentNumber`),
  ADD CONSTRAINT `lease_ibfk_2` FOREIGN KEY (`reviewedBy`) REFERENCES `staff` (`staff_ID`);

--
-- Constraints for table `maintenancerequests`
--
ALTER TABLE `maintenancerequests`
  ADD CONSTRAINT `maintenancerequests_ibfk_1` FOREIGN KEY (`tenant_ID`) REFERENCES `tenant` (`tenant_ID`),
  ADD CONSTRAINT `maintenancerequests_ibfk_2` FOREIGN KEY (`apartmentNumber`) REFERENCES `apartment` (`apartmentNumber`),
  ADD CONSTRAINT `maintenancerequests_ibfk_3` FOREIGN KEY (`handledBy`) REFERENCES `staff` (`staff_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
