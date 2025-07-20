-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2025 at 08:02 AM
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
-- Database: `occurrence_book`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ob_number` varchar(50) NOT NULL,
  `activity` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `ob_number`, `activity`, `timestamp`) VALUES
(1, 10, 'OBOB2/13/06/2025', 'Arrested and detained the suspects.', '2025-06-18 16:05:47'),
(2, 10, 'OBOB1/17/06/2025', 'Raided the suspect premises and collected some evidence.', '2025-06-18 16:07:21');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `ob_number` varchar(100) NOT NULL,
  `nature` text NOT NULL,
  `badge_number` varchar(50) NOT NULL,
  `officer_name` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `ob_number`, `nature`, `badge_number`, `officer_name`, `remarks`, `assigned_at`) VALUES
(9, 'OB1/17/06/2025', 'Rape', 'ERK201', 'Erick Owino', 'COMPLETE THE CASE', '2025-06-17 10:43:19'),
(10, 'OB2/13/06/2025', 'Threat', 'ERK201', 'Erick Owino', 'Follow the case.', '2025-06-18 11:01:11'),
(11, 'OB1/19/06/2025', 'Assault', 'OCS', 'Stephene Ochieng', 'the case should be followed up.', '2025-06-19 07:50:50'),
(12, 'OB1/17/06/2025', 'Rape', '87654321', 'Vincent Otieno Otiende', 'Follow up this case', '2025-06-19 08:18:33'),
(13, 'OB1/19/06/2025', 'Assault', '12345678', 'Vincent Otieno Otiende', 'Assigned this case', '2025-06-19 08:20:25'),
(14, 'OB3/13/06/2025', 'Accident', 'VNOK01', 'Vincent Okumu', '', '2025-06-23 16:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `officer_id` varchar(50) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `badge_number` varchar(50) DEFAULT NULL,
  `rank` varchar(50) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `timestamp`, `officer_id`, `fullname`, `badge_number`, `rank`, `action`, `description`) VALUES
(10, '2025-06-16 20:04:24', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Update Officer', 'Updated officer ID 5: Abala Wanga (Badge: iuyuytt, Rank: Chief Inspector)'),
(12, '2025-06-17 13:32:16', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(13, '2025-06-17 13:33:53', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Register Account', 'New officer account created: Erick Owino (ERK201)'),
(14, '2025-06-17 13:34:13', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Login', 'Successful login'),
(15, '2025-06-17 13:35:19', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Submit Occurrence', 'Submitted a new occurrence with OB number OB1/17/06/2025'),
(16, '2025-06-17 13:36:18', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(17, '2025-06-17 13:36:32', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Login', 'Successful login'),
(18, '2025-06-17 13:38:16', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(19, '2025-06-17 13:38:53', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Login', 'Successful login'),
(20, '2025-06-17 13:42:02', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(21, '2025-06-17 13:42:13', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Login', 'Successful login'),
(22, '2025-06-17 13:43:19', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Assign Case', 'Assigned OB No. OB1/17/06/2025 to Erick Owino (Badge: ERK201) with remarks: COMPLETE THE CASE'),
(23, '2025-06-17 20:19:59', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(24, '2025-06-17 20:20:49', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Login', 'Successful login'),
(25, '2025-06-18 12:18:24', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(26, '2025-06-18 12:18:46', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Login', 'Successful login'),
(27, '2025-06-18 12:23:51', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(28, '2025-06-18 12:24:16', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Login', 'Successful login'),
(29, '2025-06-18 14:00:18', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(30, '2025-06-18 14:00:29', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Login', 'Successful login'),
(31, '2025-06-18 14:01:11', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Assign Case', 'Assigned OB No. OB2/13/06/2025 to Erick Owino (Badge: ERK201) with remarks: Follow the case.'),
(32, '2025-06-18 14:03:01', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(33, '2025-06-18 14:03:21', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Login', 'Successful login'),
(34, '2025-06-18 14:31:04', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(35, '2025-06-18 14:31:14', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Login', 'Successful login'),
(36, '2025-06-18 14:34:41', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(37, '2025-06-18 14:34:48', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Login', 'Successful login'),
(38, '2025-06-18 14:51:08', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(39, '2025-06-18 14:51:33', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Login', 'Successful login'),
(40, '2025-06-18 14:57:59', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Submit Occurrence', 'Submitted a new occurrence with OB number OB1/18/06/2025'),
(41, '2025-06-18 15:07:19', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(42, '2025-06-18 15:07:28', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Login', 'Successful login'),
(43, '2025-06-18 16:19:30', '10', 'Erick Owino', 'ERK201', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(44, '2025-06-18 16:19:41', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Login', 'Successful login'),
(45, '2025-06-18 23:55:00', '11', 'Stephene Ochieng', 'OCS', 'Police Constable', 'Register Account', 'New officer account created: Stephene Ochieng (OCS)'),
(46, '2025-06-18 23:55:52', '11', 'Stephene Ochieng', 'OCS', 'Police Constable', 'Login', 'Successful login'),
(47, '2025-06-19 00:00:34', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Register Account', 'New officer account created: Vincent Okumu (VNOK01)'),
(48, '2025-06-19 00:00:47', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(49, '2025-06-19 00:09:15', '11', 'Stephene Ochieng', 'OCS', 'Police Constable', 'Submit Occurrence', 'Submitted a new occurrence with OB number OB1/19/06/2025'),
(50, '2025-06-19 00:10:37', '11', 'Stephene Ochieng', 'OCS', 'Police Constable', 'Logout', 'User logged out successfully'),
(51, '2025-06-19 00:13:05', '11', 'Stephene Ochieng', 'OCS', 'Police Constable', 'Login', 'Successful login'),
(52, '2025-06-19 00:16:55', '11', 'Stephene Ochieng', 'OCS', 'Police Constable', 'Logout', 'User logged out successfully'),
(53, '2025-06-19 00:30:53', '11', 'Stephene Ochieng', 'OCS', 'Police Constable', 'Login', 'Successful login'),
(54, '2025-06-19 00:46:58', '13', 'Tester 1', 'TESTER1', 'Police Constable', 'Register Account', 'New officer account created: Tester 1 (TESTER1)'),
(55, '2025-06-19 00:47:09', '13', 'Tester 1', 'TESTER1', 'Police Constable', 'Login', 'Successful login'),
(56, '2025-06-19 00:48:23', '13', 'Tester 1', 'TESTER1', 'Police Constable', 'Logout', 'User logged out successfully'),
(57, '2025-06-19 00:49:33', '14', 'Tester2', 'TESTER2', 'Chief Inspector', 'Register Account', 'New officer account created: Tester2 (TESTER2)'),
(58, '2025-06-19 00:49:41', '14', 'Tester2', 'TESTER2', 'Chief Inspector', 'Login', 'Successful login'),
(59, '2025-06-19 00:50:50', '14', 'Tester2', 'TESTER2', 'Chief Inspector', 'Assign Case', 'Assigned OB No. OB1/19/06/2025 to Stephene Ochieng (Badge: OCS) with remarks: the case should be followed up.'),
(60, '2025-06-19 01:12:44', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Register Account', 'New officer account created: Vincent Otieno Otiende (12345678)'),
(61, '2025-06-19 01:12:55', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Login', 'Successful login'),
(62, '2025-06-19 01:13:44', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Login', 'Successful login'),
(63, '2025-06-19 01:15:21', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Submit Occurrence', 'Submitted a new occurrence with OB number OB2/19/06/2025'),
(64, '2025-06-19 01:16:19', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(65, '2025-06-19 01:17:29', '16', 'Vincent Otieno Otiende', '87654321', 'Chief Inspector', 'Register Account', 'New officer account created: Vincent Otieno Otiende (87654321)'),
(66, '2025-06-19 01:17:40', '16', 'Vincent Otieno Otiende', '87654321', 'Chief Inspector', 'Login', 'Successful login'),
(67, '2025-06-19 01:18:33', '16', 'Vincent Otieno Otiende', '87654321', 'Chief Inspector', 'Assign Case', 'Assigned OB No. OB1/17/06/2025 to Vincent Otieno Otiende (Badge: 87654321) with remarks: Follow up this case'),
(68, '2025-06-19 01:18:57', '16', 'Vincent Otieno Otiende', '87654321', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(69, '2025-06-19 01:19:07', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Login', 'Successful login'),
(70, '2025-06-19 01:19:29', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(71, '2025-06-19 01:19:37', '16', 'Vincent Otieno Otiende', '87654321', 'Chief Inspector', 'Login', 'Successful login'),
(72, '2025-06-19 01:20:25', '16', 'Vincent Otieno Otiende', '87654321', 'Chief Inspector', 'Assign Case', 'Assigned OB No. OB1/19/06/2025 to Vincent Otieno Otiende (Badge: 12345678) with remarks: Assigned this case'),
(73, '2025-06-19 01:20:30', '16', 'Vincent Otieno Otiende', '87654321', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(74, '2025-06-19 01:20:38', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Login', 'Successful login'),
(75, '2025-06-20 00:08:01', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(76, '2025-06-20 00:10:01', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(77, '2025-06-20 00:10:17', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(78, '2025-06-20 00:10:20', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(79, '2025-06-20 01:12:41', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Submit Occurrence', 'Submitted a new occurrence with OB number OB1/20/06/2025'),
(80, '2025-06-20 01:18:55', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(81, '2025-06-20 01:19:16', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(82, '2025-06-20 01:41:17', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Submit Occurrence', 'Submitted a new occurrence with OB number OB2/20/06/2025'),
(83, '2025-06-20 01:47:00', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Submit Occurrence', 'Submitted a new occurrence with OB number OB3/20/06/2025'),
(84, '2025-06-20 01:56:26', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(85, '2025-06-20 01:57:19', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(86, '2025-06-20 02:11:17', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(87, '2025-06-20 02:11:43', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(88, '2025-06-20 02:11:53', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(89, '2025-06-20 02:15:07', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(90, '2025-06-20 03:43:56', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(91, '2025-06-20 03:45:00', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(92, '2025-06-20 03:47:26', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Register Account', 'New officer account created: David Ochieng (DAVD01)'),
(93, '2025-06-20 03:47:41', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Login', 'Successful login'),
(94, '2025-06-20 04:06:47', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(95, '2025-06-20 04:07:28', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Login', 'Successful login'),
(96, '2025-06-20 04:07:58', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Login', 'Successful login'),
(97, '2025-06-20 05:24:51', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(98, '2025-06-20 05:26:27', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Login', 'Successful login'),
(99, '2025-06-20 06:17:27', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Login', 'Successful login'),
(100, '2025-06-20 06:18:16', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(101, '2025-06-20 06:18:18', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(102, '2025-06-20 06:18:26', '16', 'Vincent Otieno Otiende', '87654321', 'Chief Inspector', 'Login', 'Successful login'),
(103, '2025-06-20 06:22:55', '16', 'Vincent Otieno Otiende', '87654321', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(104, '2025-06-20 06:23:02', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Login', 'Successful login'),
(105, '2025-06-20 06:25:01', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(106, '2025-06-20 06:25:12', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(107, '2025-06-20 06:25:45', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(108, '2025-06-20 06:25:56', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(109, '2025-06-20 06:26:10', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(110, '2025-06-20 06:26:47', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(111, '2025-06-20 06:27:19', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(112, '2025-06-20 06:27:38', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(113, '2025-06-20 06:36:42', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(114, '2025-06-20 06:44:03', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(115, '2025-06-20 06:44:17', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(116, '2025-06-20 06:45:00', '16', 'Vincent Otieno Otiende', '87654321', 'Chief Inspector', 'Login', 'Successful login'),
(117, '2025-06-20 06:46:20', '16', 'Vincent Otieno Otiende', '87654321', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(118, '2025-06-20 06:46:27', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Login', 'Successful login'),
(119, '2025-06-20 06:54:18', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(120, '2025-06-20 07:08:28', '18', 'Jack Omondi', 'JCK123', 'Inspector of Police', 'Register Account', 'New officer account created: Jack Omondi (JCK123)'),
(121, '2025-06-20 07:09:05', '18', 'Jack Omondi', 'JCK123', 'Inspector of Police', 'Login', 'Successful login'),
(122, '2025-06-20 07:09:12', '18', 'Jack Omondi', 'JCK123', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(123, '2025-06-21 08:01:55', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Login', 'Successful login'),
(124, '2025-06-21 08:02:16', '15', 'Vincent Otieno Otiende', '12345678', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(125, '2025-06-21 08:03:06', '16', 'Vincent Otieno Otiende', '87654321', 'Chief Inspector', 'Login', 'Successful login'),
(126, '2025-06-21 10:40:51', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(127, '2025-06-21 22:46:54', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(128, '2025-06-21 22:49:13', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Submit Occurrence', 'Submitted a new occurrence with OB number OB1/22/06/2025'),
(129, '2025-06-22 01:13:19', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(130, '2025-06-22 01:13:58', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Submit Occurrence', 'Submitted a new occurrence with OB number OB2/22/06/2025'),
(131, '2025-06-22 01:15:10', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(132, '2025-06-22 05:45:30', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(133, '2025-06-22 05:46:09', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(134, '2025-06-22 05:46:16', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(135, '2025-06-22 05:46:28', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(136, '2025-06-22 05:46:32', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(137, '2025-06-22 05:47:26', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Login', 'Successful login'),
(138, '2025-06-22 05:47:41', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(139, '2025-06-22 05:48:02', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Login', 'Successful login'),
(140, '2025-06-22 05:48:04', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Login', 'Successful login'),
(141, '2025-06-22 05:48:18', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(142, '2025-06-22 05:48:23', '17', 'David Ochieng', 'DAVD01', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(143, '2025-06-23 01:25:33', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(144, '2025-06-23 02:06:13', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(145, '2025-06-23 05:39:35', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(146, '2025-06-23 05:40:00', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(147, '2025-06-23 07:03:18', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(148, '2025-06-23 07:04:54', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(149, '2025-06-23 08:10:30', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(150, '2025-06-23 08:11:43', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(151, '2025-06-23 08:14:25', '19', 'Shem Omuombo', 'SOMB01', 'Chief Inspector', 'Register Account', 'New officer account created: Shem Omuombo (SOMB01)'),
(152, '2025-06-23 08:14:52', '19', 'Shem Omuombo', 'SOMB01', 'Chief Inspector', 'Login', 'Successful login'),
(153, '2025-06-23 09:34:00', '19', 'Shem Omuombo', 'SOMB01', 'Chief Inspector', 'Assign Case', 'Assigned OB No. OB3/13/06/2025 to Vincent Okumu (Badge: VNOK01) with remarks: '),
(154, '2025-06-23 11:44:13', '19', 'Shem Omuombo', 'SOMB01', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(155, '2025-06-24 00:07:49', '19', 'Shem Omuombo', 'SOMB01', 'Chief Inspector', 'Login', 'Successful login'),
(156, '2025-06-24 00:08:15', '19', 'Shem Omuombo', 'SOMB01', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(157, '2025-06-24 00:08:32', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Login', 'Successful login'),
(158, '2025-06-24 00:09:24', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Submit Occurrence', 'Submitted a new occurrence with OB number OB1/24/06/2025'),
(159, '2025-06-24 00:10:37', '12', 'Vincent Okumu', 'VNOK01', 'Police Constable', 'Logout', 'User logged out successfully'),
(160, '2025-06-24 00:11:16', '19', 'Shem Omuombo', 'SOMB01', 'Chief Inspector', 'Login', 'Successful login'),
(161, '2025-06-24 14:31:35', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Login', 'Successful login'),
(162, '2025-06-24 14:48:28', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Update Officer', 'Updated officer ID 10: Erick Owino (Badge: ERK201, Rank: Inspector)'),
(163, '2025-06-24 14:49:53', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Update Officer', 'Updated officer ID 10: Erick Owino (Badge: ERK201, Rank: Inspector)'),
(164, '2025-06-24 14:53:51', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Update Officer', 'Updated officer ID 10: Erick Owino (Badge: ERK201, Rank: Inspector, Role: Supervisor)'),
(165, '2025-06-24 14:54:37', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Update Officer', 'Updated officer ID 5: Abala Wanga (Badge: iuyuytt, Rank: Chief Inspector, Role: Admin)'),
(166, '2025-06-24 15:02:27', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(167, '2025-06-24 15:02:33', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Login', 'Successful login'),
(168, '2025-06-24 15:02:35', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(169, '2025-06-24 15:06:03', '20', 'Inspector Ous', 'INSPECTA', 'Inspector of Police', 'Register Account', 'New officer account created: Inspector Ous (INSPECTA)'),
(170, '2025-06-24 15:07:18', '20', 'Inspector Ous', 'INSPECTA', 'Inspector of Police', 'Login', 'Successful login'),
(171, '2025-06-24 15:07:39', '20', 'Inspector Ous', 'INSPECTA', 'Inspector of Police', 'Logout', 'User logged out successfully'),
(172, '2025-06-24 15:07:51', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Login', 'Successful login'),
(173, '2025-06-24 15:08:19', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Update Officer', 'Updated officer ID 20: Inspector Ous (Badge: INSPECTA, Rank: Inspector, Role: Supervisor)'),
(174, '2025-06-24 15:08:24', '5', 'Abala Wanga', 'iuyuytt', 'Chief Inspector', 'Logout', 'User logged out successfully'),
(175, '2025-06-24 15:08:53', '20', 'Inspector Ous', 'INSPECTA', 'Inspector', 'Login', 'Successful login'),
(176, '2025-06-24 16:22:29', '20', 'Inspector Ous', 'INSPECTA', 'Inspector', 'Logout', 'User logged out successfully'),
(177, '2025-06-24 16:23:51', '20', 'Inspector Ous', 'INSPECTA', 'Inspector', 'Login', 'Successful login');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_badge` varchar(20) DEFAULT NULL,
  `recipient_badge` varchar(20) DEFAULT NULL,
  `sender_name` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_badge`, `recipient_badge`, `sender_name`, `message`, `sent_at`) VALUES
(1, 'iuyuytt', 'OCS', 'Abala Wanga', 'Come to my office!', '2025-06-24 14:11:10'),
(2, 'iuyuytt', 'OCS', 'Abala Wanga', 'Come to my office!', '2025-06-24 14:11:10'),
(3, 'iuyuytt', 'OCS', 'Abala Wanga', 'Come to my office!', '2025-06-24 14:11:15'),
(4, 'iuyuytt', 'OCS', 'Abala Wanga', 'Come to my office!', '2025-06-24 14:11:15'),
(5, 'iuyuytt', 'VNOK01', 'Abala Wanga', 'receive once!', '2025-06-24 14:13:25'),
(6, 'iuyuytt', 'VNOK01', 'Abala Wanga', 'receive once!', '2025-06-24 14:13:25');

-- --------------------------------------------------------

--
-- Table structure for table `ob_sequence`
--

CREATE TABLE `ob_sequence` (
  `id` int(11) NOT NULL,
  `ob_date` date NOT NULL,
  `last_sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ob_sequence`
--

INSERT INTO `ob_sequence` (`id`, `ob_date`, `last_sequence`) VALUES
(2, '2025-06-13', 4),
(3, '2025-06-14', 3),
(4, '2025-06-17', 1),
(5, '2025-06-18', 1),
(6, '2025-06-19', 2),
(7, '2025-06-20', 3),
(8, '2025-06-22', 2),
(9, '2025-06-24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `occurrences`
--

CREATE TABLE `occurrences` (
  `id` int(11) NOT NULL,
  `ob_number` varchar(20) NOT NULL,
  `reference_number` varchar(50) DEFAULT NULL,
  `occurrence_date` date NOT NULL,
  `occurrence_time` time NOT NULL,
  `case_file_number` varchar(50) DEFAULT NULL,
  `nature_of_occurrence` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `occurrences`
--

INSERT INTO `occurrences` (`id`, `ob_number`, `reference_number`, `occurrence_date`, `occurrence_time`, `case_file_number`, `nature_of_occurrence`, `remarks`, `user_id`, `created_at`, `status`) VALUES
(11, 'OB1/13/06/2025', 'N/A', '2025-06-13', '13:45:00', '14/2025', 'Assault', 'edfrawsfredg', 2, '2025-06-13 10:45:12', 'Pending'),
(12, 'OB2/13/06/2025', 'N/A', '2025-06-13', '13:58:00', '14/2025', 'Threat', 'sdfdsgf', 2, '2025-06-13 10:59:02', 'Assigned'),
(13, 'OB3/13/06/2025', 'N/A', '2025-06-13', '14:51:00', '14/2025', 'Accident', 'sfdghbfgbfd gh', 2, '2025-06-13 11:51:40', 'Closed'),
(14, 'OB4/13/06/2025', 'N/A', '2025-06-11', '16:00:00', '14/2025', 'Theft', 'Stolen money fraud!', 2, '2025-06-13 13:01:44', 'Pending'),
(16, 'OB1/14/06/2025', 'N/A', '2025-06-07', '14:50:00', '15/2025', 'Fraud', 'trrhgfbghytgbf trehbgf rnhg.', 2, '2025-06-14 11:47:37', 'Pending'),
(17, 'OB2/14/06/2025', 'N/A', '2025-06-03', '15:11:00', '15/2025', 'Theft', 'dfgbfdgd', 2, '2025-06-14 12:11:17', 'Pending'),
(18, 'OB3/14/06/2025', 'N/A', '2025-06-02', '18:41:00', '14/2025', 'nomal theft', 'rtyrrtjyuitykyugjkut76uyjyrut', 5, '2025-06-14 15:41:45', 'Pending'),
(19, 'OB1/17/06/2025', 'REF-123', '2025-06-16', '13:15:00', '14/2025', 'Rape', 'dfgtrhgfyhjjghnnfgnrytr', 10, '2025-06-17 10:35:19', 'Verified'),
(20, 'OB1/18/06/2025', 'N/A', '2025-06-08', '14:57:00', '15/2025', 'Robbery with violence', 'Beaten and robbed.', 10, '2025-06-18 11:57:59', 'Pending'),
(21, 'OB1/19/06/2025', 'N/A', '2025-06-15', '10:08:00', '13/2025', 'Assault', 'Assaulted by armed gang.', 11, '2025-06-19 07:09:15', 'Verified'),
(22, 'OB2/19/06/2025', 'NA', '2025-06-11', '11:13:00', 'NA', 'Threat', 'vfgdcvvbfnhmgvc', 15, '2025-06-19 08:15:21', 'Pending'),
(23, 'OB1/20/06/2025', 'N/A', '2025-06-20', '11:11:00', '14/2025', 'Accident', 'Reported injuries caused by accident.', 12, '2025-06-20 08:12:41', 'Pending'),
(24, 'OB2/20/06/2025', 'REF-123', '2025-06-08', '13:40:00', '12/2025', 'Robbery with violence', 'Recoreded today.', 12, '2025-06-20 08:41:17', 'Pending'),
(25, 'OB3/20/06/2025', 'REF-123', '2025-06-01', '16:51:00', '13/2025', 'Fraud', 'Money fraud.', 12, '2025-06-20 08:47:00', 'Pending'),
(26, 'OB1/22/06/2025', 'NA', '2025-06-22', '08:48:00', 'NA', 'Assault', 'Assaulted by goons.', 12, '2025-06-22 05:49:13', 'Pending'),
(27, 'OB2/22/06/2025', 'N/A', '2025-06-22', '11:13:00', '14/2025', 'Theft', 'TTHHTJJUUYTTHHFF THEESS', 12, '2025-06-22 08:13:58', 'Pending'),
(28, 'OB1/24/06/2025', 'N/A', '2025-06-03', '10:10:00', '14/2025', 'Fraud', 'I want to see it first.', 12, '2025-06-24 07:09:24', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `token`, `expires_at`, `created_at`) VALUES
(1, 18, 'eaea63465e8e0df69aae4b1505bbdb05ae7a221b58a0ed8e4cbd30c2e3001741', '2025-06-23 03:07:16', '2025-06-23 06:07:16'),
(2, 18, '25fba1cc9f3eba63e65697b336f178e0ab34838545c905b5aa35b17defa8e720', '2025-06-23 03:08:52', '2025-06-23 06:08:52'),
(3, 18, 'c474fd825ca2e353a8da3175b8b0ddbf1973d3c6cbc2529fc72cc2e6d3714995', '2025-06-23 03:10:20', '2025-06-23 06:10:20'),
(4, 18, '674c4876c1822ff8941649ae04ef411811eba41f5896386033f4573c30bfc7df', '2025-06-23 03:57:47', '2025-06-23 06:57:47'),
(5, 18, '02d96e2b52b162aae274c830c7e2c4ca1b676505d998f35853a9e7caec9fa0e2', '2025-06-23 04:19:25', '2025-06-23 07:19:25');

-- --------------------------------------------------------

--
-- Table structure for table `public_issues`
--

CREATE TABLE `public_issues` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `department` enum('Police','Chief','MP') NOT NULL,
  `subject` varchar(100) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `public_issues`
--

INSERT INTO `public_issues` (`id`, `user_id`, `department`, `subject`, `contact_number`, `location`, `description`, `status`, `date_submitted`) VALUES
(1, 4, 'Police', 'Assault', '1323422344', 'grdfryh', 'wrwtrgtfertgr', 'Pending', '2025-06-25 08:34:36'),
(2, 4, 'Chief', 'Livestock Theft', '324232', 'usenge', 'rtwregrethyrtghrt', 'Pending', '2025-06-25 08:51:52'),
(3, 4, 'MP', 'Streetlights', '123423', 'rgfergfd', 'sdgbdhfdhdf', 'Pending', '2025-06-25 08:52:29'),
(4, 4, 'MP', 'Road Issues', 'sfgedrfg', 'fghfdrhf', 'fdhfghfhf', 'Pending', '2025-06-25 09:03:04'),
(5, 1, 'Chief', 'Unauthorized Land Use', '2342134', 'wfreg', 'gerfgretgtregtg', 'Pending', '2025-06-25 09:28:36'),
(6, 1, 'Police', 'Assault', '3214214234535', 'asdDAS', 'fsdffre', 'Pending', '2025-06-25 13:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `public_reports`
--

CREATE TABLE `public_reports` (
  `id` int(11) NOT NULL,
  `reporter_name` varchar(100) DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `report_type` enum('security','community','development') DEFAULT NULL,
  `directed_to` enum('police','chief','mp_office') DEFAULT NULL,
  `report_text` text DEFAULT NULL,
  `status` enum('pending','in_progress','resolved') DEFAULT 'pending',
  `received_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `public_users`
--

CREATE TABLE `public_users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `national_id` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `public_users`
--

INSERT INTO `public_users` (`id`, `full_name`, `national_id`, `email`, `phone`, `password_hash`, `created_at`) VALUES
(1, 'Charlse Darwin', '1234567890', 'darwin01@gmail.com', '+254711595962', '$2y$10$RaqXUM7dI9pYb2qQNMVP2eJJR8NkhqWbDjkaZSRCJ/6iDs1tMRzje', '2025-06-24 18:04:42'),
(4, 'Charlse Darwin', '0987654321', 'charlo01@gmail.com', '+254711595962', '$2y$10$d64VCsjFiiQgBrGJh8iep.u3NkfCNTu7AaORag5VWAozqAu97iFqW', '2025-06-24 18:07:54');

-- --------------------------------------------------------

--
-- Table structure for table `report_followups`
--

CREATE TABLE `report_followups` (
  `id` int(11) NOT NULL,
  `report_id` int(11) DEFAULT NULL,
  `actor_id` int(11) DEFAULT NULL,
  `action_taken` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `id_number` varchar(20) NOT NULL,
  `badge_number` varchar(20) NOT NULL,
  `rank` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active',
  `role` varchar(50) NOT NULL DEFAULT 'Officer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `id_number`, `badge_number`, `rank`, `email`, `phone`, `password_hash`, `created_at`, `status`, `role`) VALUES
(2, 'David Ochieng', '39806674', 'qrqr2434', 'Inspector', 'bena@gmail.com', '+254711595963', '$2y$10$q3NUtsv8wb8lcTRP3AHkCecDnco1LtTNNb2rrShX5l2JEDesUV1O2', '2025-06-13 08:06:44', 'inactive', 'Officer'),
(5, 'Abala Wanga', '1234', 'iuyuytt', 'Chief Inspector', 'abalawanga@gmail.com', '+254711595999', '$2y$10$A6Png1nsVdh7JAueRklyKuzHLEF8ZA.SeE5wUBLqROhA8I5xzROAm', '2025-06-14 15:40:54', 'active', 'Admin'),
(10, 'Erick Owino', '071123', 'ERK201', 'Inspector', 'owis12@gmail.com', '+254711595783', '$2y$10$yh9UGMe1wIllQC0vxGg0ueUMIiSAds3yHKlFDvdD76T.Krr27y3W.', '2025-06-17 10:33:53', 'active', 'Supervisor'),
(11, 'Stephene Ochieng', '071159', 'OCS', 'Police Constable', 'ochieng123@gmail.com', '+254711595999', '$2y$10$CUj5vkveerg8Nzx4XEDcU.0oMt5.ZX4Tm3MpOsi.YO/t4Cz3kUA6O', '2025-06-19 06:55:00', 'active', 'Officer'),
(12, 'Vincent Okumu', '07115959', 'VNOK01', 'Police Constable', 'okumu098@gmail.com', '+254711595991', '$2y$10$OSlIvACxcy4jcWv5yr52UO/4WR/wzniH8uM83UjKz1rtNGybi4Cwq', '2025-06-19 07:00:34', 'active', 'Officer'),
(13, 'Tester 1', '1234567890', 'TESTER1', 'Police Constable', 'tester1@gmail.com', '+254710553788', '$2y$10$e/jzz4/Nz6ilxlaFOKI.3.tgPeeTDL7VdSpEDqqHm6/xFMCBVKRtu', '2025-06-19 07:46:58', 'active', 'Officer'),
(14, 'Tester2', '0987654321', 'TESTER2', 'Chief Inspector', 'tester2@gmail.com', '+254710553744', '$2y$10$OGMoek6Il0hWrTNDVfsKvuUt8l49rlcUzB5VqBocDqLAeILZFTVxC', '2025-06-19 07:49:33', 'active', 'Officer'),
(15, 'Vincent Otieno Otiende', '12345678', '12345678', 'Inspector of Police', 'daddyvinceoti@gmail.com', '+254722526697', '$2y$10$.SMRKo1fXvQZfxVEe/lCXOtf8qiiPTl8p0vzrtezK.Sg2KSecmLry', '2025-06-19 08:12:44', 'active', 'Officer'),
(16, 'Vincent Otieno Otiende', '87654321', '87654321', 'Chief Inspector', 'gorvinceoti@gmail.com', '+254780526697', '$2y$10$0NFmPFEue/Z0EYGSkkYbhue46WlXyVaX7cNq.NsI8.vP0UUW9G40.', '2025-06-19 08:17:29', 'active', 'Officer'),
(17, 'David Ochieng', '39806566', 'DAVD01', 'Chief Inspector', 'ouna123@gmail.com', '+254711595933', '$2y$10$oYB3D2GxSNWo3HYnrgP43O45esGSV99//4kAEacky0gGLGth871T.', '2025-06-20 10:47:26', 'active', 'Officer'),
(18, 'Jack Omondi', '39807574', 'JCK123', 'Inspector of Police', 'davidouma558@gmail.com', '0711595963', '$2y$10$3HS/1bcfGJzETonOxNt8H.xh9IbDfztWMKcdjomNWsPq2R4oySBhW', '2025-06-20 14:08:28', 'active', 'Officer'),
(19, 'Shem Omuombo', '39809596', 'SOMB01', 'Chief Inspector', 'omuombo123@gmail.com', '+254711595968', '$2y$10$fGpS4qw0bF75BIV97cuAZeR6Xratn47IoBMafkM6Ql6AIX6DeRVu6', '2025-06-23 15:14:25', 'active', 'Officer'),
(20, 'Inspector Ous', '37805554', 'INSPECTA', 'Inspector', 'oumadave123@gmail.com', '0711595961', '$2y$10$i4cE6WpsKSZ998md67ffCeQvunZcM94pcdf7q/VoxmUdORs8mizIS', '2025-06-24 12:06:03', 'active', 'Supervisor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `badge_number` (`badge_number`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ob_sequence`
--
ALTER TABLE `ob_sequence`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ob_date` (`ob_date`);

--
-- Indexes for table `occurrences`
--
ALTER TABLE `occurrences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ob_number` (`ob_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `public_issues`
--
ALTER TABLE `public_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `public_reports`
--
ALTER TABLE `public_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `public_users`
--
ALTER TABLE `public_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `national_id` (`national_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `report_followups`
--
ALTER TABLE `report_followups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_id` (`report_id`),
  ADD KEY `actor_id` (`actor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `badge_number` (`badge_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ob_sequence`
--
ALTER TABLE `ob_sequence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `occurrences`
--
ALTER TABLE `occurrences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `public_issues`
--
ALTER TABLE `public_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `public_reports`
--
ALTER TABLE `public_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `public_users`
--
ALTER TABLE `public_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `report_followups`
--
ALTER TABLE `report_followups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`badge_number`) REFERENCES `users` (`badge_number`);

--
-- Constraints for table `occurrences`
--
ALTER TABLE `occurrences`
  ADD CONSTRAINT `occurrences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `public_issues`
--
ALTER TABLE `public_issues`
  ADD CONSTRAINT `public_issues_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `public_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_followups`
--
ALTER TABLE `report_followups`
  ADD CONSTRAINT `report_followups_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `public_reports` (`id`),
  ADD CONSTRAINT `report_followups_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
