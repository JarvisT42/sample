-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2024 at 04:08 AM
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
-- Database: `gfi_library_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `accession_records`
--

CREATE TABLE `accession_records` (
  `accession_no` varchar(250) NOT NULL,
  `call_number` varchar(250) NOT NULL,
  `book_id` int(11) NOT NULL,
  `book_category` varchar(250) NOT NULL,
  `borrower_id` varchar(250) DEFAULT NULL,
  `status` varchar(250) NOT NULL,
  `damage_description` varchar(250) NOT NULL,
  `damage` enum('yes','no') NOT NULL DEFAULT 'no',
  `repair_description` varchar(250) NOT NULL,
  `repaired` enum('yes','no') DEFAULT NULL,
  `available` enum('yes','no','reserved') NOT NULL DEFAULT 'yes',
  `archive` enum('no','yes') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accession_records`
--

INSERT INTO `accession_records` (`accession_no`, `call_number`, `book_id`, `book_category`, `borrower_id`, `status`, `damage_description`, `damage`, `repair_description`, `repaired`, `available`, `archive`) VALUES
('gfi-01', 'Fil 001.3 H88 2003 aaaaaaa', 39, 'classic books', '1', 'returned', 'serw', 'yes', 'awdw ww', 'yes', 'yes', 'no'),
('gfi-02', 'Fil 001.3 H88 2003 aaaaaaa', 39, 'classic books', 'w-3', 'returned', '', 'no', '', NULL, 'yes', 'no'),
('gfi-03', 'Fil 001.3 H88 2003 aaaaaaa', 39, 'classic books', NULL, '', '', 'no', '', NULL, 'yes', 'no'),
('gfi-04', 'Fil 001.3 H88 2003 aaaaaaa', 39, 'classic books', NULL, '', '', 'no', '', NULL, 'yes', 'no'),
('gfi-05', 'Fil 001.3 H88 2003 aaaaaaa', 39, 'classic books', NULL, '', '', 'no', '', NULL, 'yes', 'no'),
('gfi-06', 'Fil 001.3 H88 2003 aaaaaaa', 39, 'classic books', NULL, '', '', 'no', '', NULL, 'yes', 'no'),
('gfi-07', 'Fil 001.3 H88 2003 aaaaaaa', 39, 'classic books', NULL, '', '', 'no', '', NULL, 'yes', 'no'),
('gfi-08', 'Fil 001.4 H88 2003 ', 43, 'classic books', '1', 'returned', 'ggg ggg', 'yes', '', NULL, 'yes', 'no'),
('gfi-09', 'Fil 001.4 H88 2003 ', 43, 'classic books', 'w-3', 'returned', '', 'no', '', NULL, 'yes', 'no'),
('ggfi-96', 'Fil 001.3 H88 2003 aaaaaaa', 39, 'classic books', NULL, '', '', 'no', '', NULL, 'yes', 'no'),
('ggfi-98', 'Fil 001.3 H88 2003 aaaaaaa', 39, 'classic books', NULL, '', '', 'no', '', NULL, 'yes', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `id` int(11) NOT NULL,
  `Username` varchar(250) NOT NULL,
  `Full_Name` varchar(250) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Password` varchar(250) NOT NULL,
  `Confirm_Password` varchar(250) NOT NULL,
  `role_id` int(11) NOT NULL,
  `Default_Account` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`id`, `Username`, `Full_Name`, `Email`, `Password`, `Confirm_Password`, `role_id`, `Default_Account`) VALUES
(1, 'admingfi', 'Admin', 'admingfi@gmail.com', '$2y$10$l4mRvmkMHWRL94fkC9Fa.uhoWvkBkahNTFEbbBOW6cQdAl6m8wdW6', '$2y$10$l4mRvmkMHWRL94fkC9Fa.uhoWvkBkahNTFEbbBOW6cQdAl6m8wdW6', 1, 'backup'),
(72, 'joshua', 'kent sample', 'kentjoshuazamoradaborbor@gmail.com', '$2y$10$5isCOTmq.lOITqvc01aJZ.enQ4so7ZJrr0zORVokYX0GoTc6sOChi', '$2y$10$5isCOTmq.lOITqvc01aJZ.enQ4so7ZJrr0zORVokYX0GoTc6sOChi', 2, ''),
(73, 'asd', 'assistant', 'assistant@gmail.com', '$2y$10$l4mRvmkMHWRL94fkC9Fa.uhoWvkBkahNTFEbbBOW6cQdAl6m8wdW6', '$2y$10$5oB9gBYEhZrpyP7C1hXaXO3S2lAJ86SZik3g04mFuw6NOP83v6NHO', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `book_replacement`
--

CREATE TABLE `book_replacement` (
  `replacement_id` int(11) NOT NULL,
  `accession_no` varchar(250) NOT NULL,
  `book_id` varchar(250) NOT NULL,
  `category` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE `borrow` (
  `borrow_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `walk_in_id` varchar(250) DEFAULT NULL,
  `role` varchar(250) NOT NULL,
  `accession_no` varchar(250) DEFAULT NULL,
  `book_id` int(11) NOT NULL,
  `Category` varchar(250) NOT NULL,
  `No_Of_Copies` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `date_to_claim` varchar(250) NOT NULL,
  `Time` varchar(255) NOT NULL,
  `Queue` varchar(255) NOT NULL,
  `Issued` varchar(250) NOT NULL,
  `issued_date` date NOT NULL,
  `due_date` date NOT NULL,
  `renew` enum('yes','no') DEFAULT 'no',
  `expected_replacement_date` date DEFAULT NULL,
  `Return_Date` date NOT NULL,
  `Damage_Description` varchar(250) NOT NULL,
  `Over_Due_Fines` decimal(10,2) DEFAULT NULL,
  `Book_Fines` decimal(10,2) DEFAULT NULL,
  `total_fines` decimal(10,2) NOT NULL,
  `book_replaced` enum('yes','no') DEFAULT NULL,
  `Way_Of_Borrow` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow`
--

INSERT INTO `borrow` (`borrow_id`, `student_id`, `faculty_id`, `walk_in_id`, `role`, `accession_no`, `book_id`, `Category`, `No_Of_Copies`, `appointment_id`, `date_to_claim`, `Time`, `Queue`, `Issued`, `issued_date`, `due_date`, `renew`, `expected_replacement_date`, `Return_Date`, `Damage_Description`, `Over_Due_Fines`, `Book_Fines`, `total_fines`, `book_replaced`, `Way_Of_Borrow`, `status`) VALUES
(1413, 1, NULL, NULL, 'Student', 'gfi-01', 39, 'classic books', 0, 2457, '2024-11-18', 'afternoon', '', '', '2024-11-16', '2024-11-07', 'no', NULL, '2024-11-16', 'serw', NULL, NULL, 279.00, NULL, 'online', 'returned'),
(1414, 1, NULL, NULL, 'Student', 'gfi-08', 43, 'classic books', 0, 2457, '2024-11-18', 'afternoon', '', '', '2024-11-16', '2024-11-07', 'no', NULL, '2024-11-16', 'ggg ggg', NULL, NULL, 275.00, NULL, 'online', 'returned'),
(1417, NULL, NULL, 'w-3', 'Student', 'gfi-02', 39, 'classic books', 0, NULL, '2024-11-15', '', '', '', '2024-11-15', '2024-11-16', 'no', NULL, '2024-11-15', '', NULL, NULL, 0.00, NULL, 'Walk-in', 'returned'),
(1418, NULL, NULL, 'w-3', 'Student', 'gfi-09', 43, 'classic books', 0, NULL, '2024-11-15', '', '', '', '2024-11-15', '2024-11-16', 'no', NULL, '2024-11-15', '', NULL, NULL, 0.00, NULL, 'Walk-in', 'returned');

-- --------------------------------------------------------

--
-- Table structure for table `calendar_appointment`
--

CREATE TABLE `calendar_appointment` (
  `appointment_id` int(11) NOT NULL,
  `calendar` varchar(250) NOT NULL,
  `morning` int(11) NOT NULL,
  `afternoon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calendar_appointment`
--

INSERT INTO `calendar_appointment` (`appointment_id`, `calendar`, `morning`, `afternoon`) VALUES
(2399, '2024-09-25', 10, 10),
(2404, '2024-09-27', 10, 10),
(2405, '2024-09-26', 10, 10),
(2406, '2024-10-15', 10, 10),
(2407, '2024-10-08', 10, 10),
(2408, '2024-10-01', 10, 10),
(2411, '2024-09-30', 10, 10),
(2413, '2024-10-02', 10, 10),
(2414, '2024-10-03', 10, 10),
(2415, '2024-10-09', 10, 10),
(2431, '2024-10-23', 10, 10),
(2432, '2024-10-22', 7, 10),
(2433, '2024-10-29', 1, 7),
(2435, '2024-10-21', 10, 10),
(2436, '2024-10-20', 10, 10),
(2438, '2024-10-04', 10, 10),
(2439, '2024-10-16', 10, 10),
(2441, '2024-11-01', 5, 10),
(2442, '2024-10-25', 9, 10),
(2443, '2024-10-26', 8, 6),
(2444, '2024-10-30', 8, 8),
(2445, '2024-10-31', 0, 0),
(2446, '2024-11-02', 10, 10),
(2447, '2024-11-04', 10, 10),
(2448, '2024-11-05', 10, 10),
(2449, '2024-11-06', 10, 10),
(2450, '2024-11-07', 10, 10),
(2451, '2024-11-08', 10, 10),
(2452, '2024-11-15', 8, 10),
(2453, '2024-11-14', 10, 10),
(2454, '2024-11-13', 10, 10),
(2455, '2024-11-12', 10, 10),
(2456, '2024-11-11', 10, 10),
(2457, '2024-11-18', 4, 7),
(2458, '2024-11-19', 2, 7),
(2459, '2024-11-20', -1, 0),
(2460, '2024-11-21', 2, 5),
(2461, '2024-11-22', 3, 10);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course`) VALUES
(1, 'BS Accountancy'),
(2, 'BSBA Financial Management'),
(3, 'BSBA Human Resource Development Management'),
(4, 'BSBA Marketing Management'),
(5, 'BS Entrepreneurship'),
(6, 'BSED English'),
(7, 'BSED Mathematics'),
(8, 'AB Literary and Cultural Studies'),
(9, 'BS Information System'),
(10, 'Bachelor of Physical Education'),
(11, 'BS Office Administration'),
(12, 'BS Criminology'),
(13, 'BS Tourism Management'),
(14, 'BS Management Accounting');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `Faculty_Id` int(11) NOT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Middle_Initial` varchar(6) DEFAULT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `Suffix_Name` varchar(250) DEFAULT NULL,
  `Email_Address` varchar(100) DEFAULT NULL,
  `S_Gender` varchar(6) DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `S_Course` varchar(100) DEFAULT NULL,
  `employment_status` varchar(250) NOT NULL,
  `Mobile_Number` varchar(11) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive','banned') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`Faculty_Id`, `First_Name`, `Middle_Initial`, `Last_Name`, `Suffix_Name`, `Email_Address`, `S_Gender`, `date_of_joining`, `S_Course`, `employment_status`, `Mobile_Number`, `Password`, `status`) VALUES
(11, 'faculty', '', 'daborbor', 'asd', 'faculty@gmail.com', 'male', '2024-11-08', 'BSBA Human Resource Development Management', 'full_time', '6544658978', '$2y$10$6lRgFyZ0YpMCGLG2HCw8C.YyjSN9k4m370O7Ofvn8nhKheqHCQnG2', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_ids`
--

CREATE TABLE `faculty_ids` (
  `faculty_id` int(11) NOT NULL,
  `status` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_ids`
--

INSERT INTO `faculty_ids` (`faculty_id`, `status`, `created_at`) VALUES
(11, 'Taken', '2024-11-15 22:53:34'),
(323, '', '2024-11-15 22:58:20');

-- --------------------------------------------------------

--
-- Table structure for table `library_fines`
--

CREATE TABLE `library_fines` (
  `id` int(11) NOT NULL,
  `fines` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library_fines`
--

INSERT INTO `library_fines` (`id`, `fines`) VALUES
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `most_borrowed_books`
--

CREATE TABLE `most_borrowed_books` (
  `id` int(11) NOT NULL,
  `book_id` varchar(250) NOT NULL,
  `category` varchar(250) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `most_borrowed_books`
--

INSERT INTO `most_borrowed_books` (`id`, `book_id`, `category`, `date`) VALUES
(1, '39', 'classic books', '2024-11-21'),
(228, '39', 'classic books', '2024-11-11'),
(229, '43', 'classic books', '2024-11-11'),
(230, '39', 'classic books', '2024-11-11'),
(231, '43', 'classic books', '2024-11-11'),
(232, '39', 'classic books', '2024-11-11'),
(233, '43', 'classic books', '2024-11-11'),
(234, '39', 'classic books', '2024-11-11'),
(235, '39', 'classic books', '2024-11-11'),
(236, '43', 'classic books', '2024-11-11'),
(237, '39', 'classic books', '2024-11-11'),
(238, '43', 'classic books', '2024-11-11'),
(239, '39', 'classic books', '2024-11-11'),
(240, '43', 'classic books', '2024-11-11'),
(241, '39', 'classic books', '2024-11-13'),
(242, '39', 'classic books', '2024-11-15'),
(243, '43', 'classic books', '2024-11-15'),
(244, '39', 'classic books', '2024-11-15'),
(245, '43', 'classic books', '2024-11-15'),
(246, '39', 'classic books', '2024-11-15'),
(247, '43', 'classic books', '2024-11-15'),
(248, '39', 'classic books', '2024-11-15'),
(249, '39', 'classic books', '2024-11-15'),
(250, '39', 'classic books', '2024-11-15'),
(251, '43', 'classic books', '2024-11-15'),
(252, '39', 'classic books', '2024-11-16'),
(253, '43', 'classic books', '2024-11-16');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'super-admin'),
(2, 'admin'),
(3, 'assistant');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `Student_Id` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Middle_Initial` varchar(6) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Suffix_Name` varchar(250) NOT NULL,
  `Email_Address` varchar(100) NOT NULL,
  `S_Gender` varchar(6) NOT NULL,
  `date_of_joining` date NOT NULL,
  `course_id` int(11) NOT NULL,
  `Mobile_Number` varchar(11) NOT NULL,
  `Year_Level` varchar(250) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `status` enum('active','inactive','banned') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`Student_Id`, `First_Name`, `Middle_Initial`, `Last_Name`, `Suffix_Name`, `Email_Address`, `S_Gender`, `date_of_joining`, `course_id`, `Mobile_Number`, `Year_Level`, `Password`, `status`) VALUES
(1, 'student', 'z', 'gfi', 'jr', 'student@gmail.com', 'male', '2024-10-30', 1, '09978987978', '1st Year', '$2y$10$l4mRvmkMHWRL94fkC9Fa.uhoWvkBkahNTFEbbBOW6cQdAl6m8wdW6', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `students_ids`
--

CREATE TABLE `students_ids` (
  `student_id` int(11) NOT NULL,
  `status` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_ids`
--

INSERT INTO `students_ids` (`student_id`, `status`, `created_at`) VALUES
(1, 'Taken', '2024-11-15 13:12:53'),
(2, 'Taken', '2024-11-15 13:12:53'),
(4, 'Taken', '2024-11-15 13:12:53');

-- --------------------------------------------------------

--
-- Table structure for table `walk_in_borrowers`
--

CREATE TABLE `walk_in_borrowers` (
  `walk_in_id` varchar(250) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `role` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `walk_in_borrowers`
--

INSERT INTO `walk_in_borrowers` (`walk_in_id`, `full_name`, `role`) VALUES
('w-1', 'ramoza', 'Student'),
('w-2', 'ramoza', 'Student'),
('w-3', 'ramoza', 'Student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accession_records`
--
ALTER TABLE `accession_records`
  ADD PRIMARY KEY (`accession_no`);

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `book_replacement`
--
ALTER TABLE `book_replacement`
  ADD PRIMARY KEY (`replacement_id`),
  ADD KEY `accession_no` (`accession_no`);

--
-- Indexes for table `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `accession_no` (`accession_no`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `walk_in_id` (`walk_in_id`);

--
-- Indexes for table `calendar_appointment`
--
ALTER TABLE `calendar_appointment`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`Faculty_Id`);

--
-- Indexes for table `faculty_ids`
--
ALTER TABLE `faculty_ids`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `library_fines`
--
ALTER TABLE `library_fines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `most_borrowed_books`
--
ALTER TABLE `most_borrowed_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`Student_Id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `students_ids`
--
ALTER TABLE `students_ids`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `walk_in_borrowers`
--
ALTER TABLE `walk_in_borrowers`
  ADD PRIMARY KEY (`walk_in_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `borrow`
--
ALTER TABLE `borrow`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1419;

--
-- AUTO_INCREMENT for table `calendar_appointment`
--
ALTER TABLE `calendar_appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2462;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `Faculty_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `library_fines`
--
ALTER TABLE `library_fines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `most_borrowed_books`
--
ALTER TABLE `most_borrowed_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `Student_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students_ids`
--
ALTER TABLE `students_ids`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000002;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD CONSTRAINT `admin_account_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `book_replacement`
--
ALTER TABLE `book_replacement`
  ADD CONSTRAINT `book_replacement_ibfk_1` FOREIGN KEY (`accession_no`) REFERENCES `accession_records` (`accession_no`);

--
-- Constraints for table `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `borrow_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`Student_Id`),
  ADD CONSTRAINT `borrow_ibfk_2` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`Faculty_Id`),
  ADD CONSTRAINT `borrow_ibfk_4` FOREIGN KEY (`accession_no`) REFERENCES `accession_records` (`accession_no`),
  ADD CONSTRAINT `borrow_ibfk_5` FOREIGN KEY (`appointment_id`) REFERENCES `calendar_appointment` (`appointment_id`),
  ADD CONSTRAINT `borrow_ibfk_6` FOREIGN KEY (`walk_in_id`) REFERENCES `walk_in_borrowers` (`walk_in_id`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`Faculty_Id`) REFERENCES `faculty_ids` (`faculty_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`Student_Id`) REFERENCES `students_ids` (`student_id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
