-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 12:41 AM
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
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `id` int(11) NOT NULL,
  `Username` varchar(250) NOT NULL,
  `Full_Name` varchar(250) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Password` varchar(250) NOT NULL,
  `Confirm_Password` varchar(250) NOT NULL,
  `Default_Account` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`id`, `Username`, `Full_Name`, `Email`, `Password`, `Confirm_Password`, `Default_Account`) VALUES
(1, 'admingfi', 'Admin', 'admingfi@gmail.com', '$2y$10$xTHe7vBvAWjabxhoC6ufyOeqyAcOQLoZgvXwjISUFGPBF52F43u3C', '$2y$10$xTHe7vBvAWjabxhoC6ufyOeqyAcOQLoZgvXwjISUFGPBF52F43u3C', 'backup'),
(72, 'joshua', 'kent sample', 'kentjoshuazamoradaborbor@gmail.com', '$2y$10$5isCOTmq.lOITqvc01aJZ.enQ4so7ZJrr0zORVokYX0GoTc6sOChi', '$2y$10$5isCOTmq.lOITqvc01aJZ.enQ4so7ZJrr0zORVokYX0GoTc6sOChi', ''),
(73, 'asd', 'dennis', 'asd@gmail.com', '$2y$10$5oB9gBYEhZrpyP7C1hXaXO3S2lAJ86SZik3g04mFuw6NOP83v6NHO', '$2y$10$5oB9gBYEhZrpyP7C1hXaXO3S2lAJ86SZik3g04mFuw6NOP83v6NHO', '');

-- --------------------------------------------------------

--
-- Table structure for table `book_replacement`
--

CREATE TABLE `book_replacement` (
  `id` int(11) NOT NULL,
  `book_id` varchar(250) NOT NULL,
  `category` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_replacement`
--

INSERT INTO `book_replacement` (`id`, `book_id`, `category`, `status`) VALUES
(1, '1', 'asd', ''),
(2, '1', 'asd', ''),
(3, '1', 'asd', ''),
(4, '1', 'asd', ''),
(5, '2', 'list of existing filipiniana books and references', ''),
(6, '1', 'asd', ''),
(7, '1', 'list of existing filipiniana books and references', ''),
(8, '1', 'asd', ''),
(9, '1', 'asd', ''),
(10, '1', 'asd', ''),
(11, '1', 'list of existing filipiniana books and references', ''),
(12, '1', 'asd', ''),
(13, '1', 'asd', ''),
(14, '1', 'asd', ''),
(15, '1', 'list of existing filipiniana books and references', ''),
(16, '1', 'asd', ''),
(17, '1', 'asd', ''),
(18, '1', 'asd', ''),
(19, '1', 'list of existing filipiniana books and references', ''),
(20, '1', 'asd', ''),
(21, '1', 'list of existing filipiniana books and references', '');

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE `borrow` (
  `id` int(11) NOT NULL,
  `role` varchar(250) NOT NULL,
  `student_id` int(11) NOT NULL,
  `walk_in_id` int(11) NOT NULL,
  `Full_Name` varchar(255) NOT NULL,
  `Course` varchar(250) NOT NULL,
  `book_id` int(11) NOT NULL,
  `Category` varchar(250) NOT NULL,
  `Title` varchar(250) NOT NULL,
  `Author` varchar(250) NOT NULL,
  `No_Of_Copies` int(11) NOT NULL,
  `Borrow` varchar(250) NOT NULL,
  `Date_To_Claim` varchar(250) NOT NULL,
  `Time` varchar(255) NOT NULL,
  `Queue` varchar(255) NOT NULL,
  `Issued` varchar(250) NOT NULL,
  `Issued_Date` varchar(250) NOT NULL,
  `Due_Date` varchar(250) NOT NULL,
  `Return_Date` varchar(250) NOT NULL,
  `Damage_Description` varchar(250) NOT NULL,
  `Over_Due_Fines` varchar(250) NOT NULL,
  `Book_Fines` varchar(250) NOT NULL,
  `Total_Fines` varchar(250) NOT NULL,
  `cover_image` longblob NOT NULL,
  `Way_Of_Borrow` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow`
--

INSERT INTO `borrow` (`id`, `role`, `student_id`, `walk_in_id`, `Full_Name`, `Course`, `book_id`, `Category`, `Title`, `Author`, `No_Of_Copies`, `Borrow`, `Date_To_Claim`, `Time`, `Queue`, `Issued`, `Issued_Date`, `Due_Date`, `Return_Date`, `Damage_Description`, `Over_Due_Fines`, `Book_Fines`, `Total_Fines`, `cover_image`, `Way_Of_Borrow`, `status`) VALUES
(1158, 'Student', 0, 1, 'wwwwwwwwwwww', '', 1, 'asd', '', '', 0, '', '2024-10-25', '', '', '', '2024-10-25', '2024-10-25', '2024-10-25', '', '0', '0', '0', '', 'walk-in', 'returned'),
(1159, 'Student', 0, 1, 'wwwwwwwwwwww', '', 1, 'list of existing filipiniana books and references', '', '', 0, '', '2024-10-25', '', '', '', '2024-10-25', '2024-10-25', '', '', '0', '0', '0', '', 'walk-in', 'lost'),
(1160, 'Student', 176, 0, '', '', 1, 'asd', '', '', 0, '', '2024-10-31', 'morning', '', '', '2024-10-25', '', '2024-10-25', 'a', '0', '0', '', '', 'online', 'returned'),
(1161, 'Student', 176, 0, '', '', 1, 'list of existing filipiniana books and references', '', '', 0, '', '2024-10-31', 'morning', '', '', '2024-10-25', '', '2024-10-25', '', '0', '0', '', '', 'online', 'lost'),
(1162, 'Student', 176, 0, '', '', 1, 'asd', '', '', 0, '', '2024-10-26', 'afternoon', '', '', '2024-10-25', '', '', '', '', '', '', '', 'online', 'borrowed'),
(1163, 'Student', 176, 0, '', '', 1, 'list of existing filipiniana books and references', '', '', 0, '', '2024-10-26', 'afternoon', '', '', '2024-10-25', '', '', '', '0', '0', '', '', 'online', 'lost');

-- --------------------------------------------------------

--
-- Table structure for table `calendar_appointment`
--

CREATE TABLE `calendar_appointment` (
  `id` int(11) NOT NULL,
  `calendar` varchar(250) NOT NULL,
  `morning` int(11) NOT NULL,
  `afternoon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calendar_appointment`
--

INSERT INTO `calendar_appointment` (`id`, `calendar`, `morning`, `afternoon`) VALUES
(2398, '2024-09-24', 10, 10),
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
(2441, '2024-11-01', 10, 10),
(2442, '2024-10-25', 9, 10),
(2443, '2024-10-26', 8, 6),
(2444, '2024-10-30', 8, 8),
(2445, '2024-10-31', 4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `Course` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`Course`) VALUES
('BS Accountancy'),
('BSBA Financial Management'),
('BSBA Human Resource Development Management'),
('BSBA Marketing Management'),
('BS Entrepreneurship'),
('BSED English'),
('BSED Mathematics'),
('AB Literary and Cultural Studies'),
('BS Information System'),
('Bachelor of Physical Education'),
('BS Office Administration'),
('BS Criminology'),
('BS Tourism Management'),
('BS Management Accounting');

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
(1, '5', 'thesis bmr', '2024-07-15'),
(2, '5', 'thesis bmr', '2024-07-20'),
(3, '5', 'thesis bmr', '2024-11-12'),
(4, '7', 'list of existing Filipiniana books and references', '2024-06-23'),
(5, '2', 'thesis bmr', '2024-01-24'),
(6, '6', 'list of existing Filipiniana books and references', '2024-08-19'),
(7, '8', 'thesis bmr', '2024-09-07'),
(8, '10', 'list of existing Filipiniana books and references', '2024-02-13'),
(9, '1', 'thesis bmr', '2024-04-29'),
(10, '4', 'list of existing Filipiniana books and references', '2024-05-02'),
(11, '7', 'thesis bmr', '2024-12-30'),
(12, '3', 'list of existing Filipiniana books and references', '2024-01-31'),
(13, '6', 'thesis bmr', '2024-03-17'),
(14, '9', 'list of existing Filipiniana books and references', '2024-08-22'),
(15, '2', 'thesis bmr', '2024-09-10'),
(16, '5', 'list of existing Filipiniana books and references', '2024-07-05'),
(17, '8', 'thesis bmr', '2024-11-09'),
(18, '4', 'list of existing Filipiniana books and references', '2024-06-11'),
(19, '1', 'thesis bmr', '2024-02-18'),
(20, '10', 'list of existing Filipiniana books and references', '2024-10-27'),
(21, '9', 'thesis bmr', '2024-04-01'),
(22, '3', 'list of existing Filipiniana books and references', '2024-05-14'),
(23, '7', 'thesis bmr', '2024-12-25'),
(24, '6', 'list of existing Filipiniana books and references', '2024-07-17'),
(25, '2', 'thesis bmr', '2024-06-12'),
(26, '8', 'list of existing Filipiniana books and references', '2024-01-26'),
(27, '4', 'thesis bmr', '2024-03-22'),
(28, '5', 'list of existing Filipiniana books and references', '2024-09-28'),
(29, '1', 'thesis bmr', '2024-11-02'),
(30, '9', 'list of existing Filipiniana books and references', '2024-12-05'),
(31, '10', 'thesis bmr', '2024-02-15'),
(32, '7', 'list of existing Filipiniana books and references', '2024-04-20'),
(33, '3', 'thesis bmr', '2024-10-19'),
(34, '6', 'list of existing Filipiniana books and references', '2024-08-16'),
(35, '8', 'thesis bmr', '2024-09-25'),
(36, '2', 'list of existing Filipiniana books and references', '2024-05-11'),
(37, '5', 'thesis bmr', '2024-07-23'),
(38, '4', 'list of existing Filipiniana books and references', '2024-12-13'),
(39, '9', 'thesis bmr', '2024-06-06'),
(40, '1', 'list of existing Filipiniana books and references', '2024-11-18'),
(41, '7', 'thesis bmr', '2024-01-08'),
(42, '3', 'list of existing Filipiniana books and references', '2024-03-09'),
(43, '6', 'thesis bmr', '2024-04-12'),
(44, '10', 'list of existing Filipiniana books and references', '2024-07-21'),
(45, '8', 'thesis bmr', '2024-10-15'),
(46, '5', 'list of existing Filipiniana books and references', '2024-02-18'),
(47, '4', 'thesis bmr', '2024-05-27'),
(48, '2', 'list of existing Filipiniana books and references', '2024-06-19'),
(49, '1', 'thesis bmr', '2024-08-10'),
(50, '9', 'list of existing Filipiniana books and references', '2024-09-12'),
(51, '3', 'thesis bmr', '2024-11-07'),
(52, '6', 'list of existing Filipiniana books and references', '2024-03-30'),
(53, '10', 'thesis bmr', '2024-12-19'),
(54, '8', 'list of existing Filipiniana books and references', '2024-01-11'),
(55, '7', 'thesis bmr', '2024-02-23'),
(56, '4', 'list of existing Filipiniana books and references', '2024-04-06'),
(63, '1', 'list of existing filipiniana books and references', '2024-10-23'),
(66, '1', 'list of existing filipiniana books and references', '2024-10-24'),
(67, '2', 'list of existing filipiniana books and references', '2024-10-24'),
(69, '1', 'list of existing filipiniana books and references', '2024-10-24'),
(71, '1', 'list of existing filipiniana books and references', '2024-10-24'),
(76, '1', 'list of existing filipiniana books and references', '2024-10-24'),
(82, '1', 'list of existing filipiniana books and references', '2024-10-25'),
(84, '1', 'list of existing filipiniana books and references', '2024-10-25'),
(85, '2', 'list of existing filipiniana books and references', '2024-10-25'),
(87, '1', 'bookcategory sample', '2024-10-25'),
(90, '1', 'bookcategory sample', '2024-10-25'),
(92, '1', 'bookcategory sample', '2024-10-25'),
(94, '1', 'bookcategory sample', '2024-10-25'),
(96, '1', 'bookcategory sample', '2024-10-25'),
(97, '1', 'asd', '2024-10-25'),
(98, '1', 'bookcategory sample', '2024-10-25'),
(99, '1', 'asd', '2024-10-25'),
(100, '1', 'bookcategory sample', '2024-10-25'),
(101, '1', 'asd', '2024-10-25'),
(102, '1', 'list of existing filipiniana books and references', '2024-10-25'),
(103, '1', 'asd', '2024-10-25'),
(104, '1', 'asd', '2024-10-25'),
(105, '1', 'list of existing filipiniana books and references', '2024-10-25'),
(106, '1', 'asd', '2024-10-25'),
(107, '1', 'asd', '2024-10-25'),
(108, '1', 'list of existing filipiniana books and references', '2024-10-25'),
(109, '1', 'asd', '2024-10-25'),
(110, '1', 'list of existing filipiniana books and references', '2024-10-25'),
(111, '1', 'asd', '2024-10-25'),
(112, '1', 'list of existing filipiniana books and references', '2024-10-25');

-- --------------------------------------------------------

--
-- Table structure for table `registertbl`
--

CREATE TABLE `registertbl` (
  `Id` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Middle_Initial` varchar(6) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `User_Name` varchar(250) NOT NULL,
  `Email_Address` varchar(100) NOT NULL,
  `S_Gender` varchar(6) NOT NULL,
  `Birth_Date` date NOT NULL,
  `S_Course` varchar(100) NOT NULL,
  `Id_Number` varchar(20) NOT NULL,
  `Mobile_Number` varchar(11) NOT NULL,
  `School_Id_Image1` longblob NOT NULL,
  `School_Id_Image2` longblob NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Confirm_Password` varchar(250) NOT NULL,
  `Register_Status` varchar(250) NOT NULL,
  `Identifier` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `Id` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Middle_Initial` varchar(6) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `User_Name` varchar(250) NOT NULL,
  `Email_Address` varchar(100) NOT NULL,
  `S_Gender` varchar(6) NOT NULL,
  `Birth_Date` date NOT NULL,
  `S_Course` varchar(100) NOT NULL,
  `Id_Number` varchar(20) NOT NULL,
  `Mobile_Number` varchar(11) NOT NULL,
  `Year_Level` varchar(250) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Confirm_Password` varchar(250) NOT NULL,
  `Register_Status` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `Identifier` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`Id`, `First_Name`, `Middle_Initial`, `Last_Name`, `User_Name`, `Email_Address`, `S_Gender`, `Birth_Date`, `S_Course`, `Id_Number`, `Mobile_Number`, `Year_Level`, `Password`, `Confirm_Password`, `Register_Status`, `status`, `Identifier`) VALUES
(73, 'ngg', 'ngg', 'ngg', 'ngg', 'kjoshuazamoradaborbor@gmail.com', 'male', '2024-09-25', 'BS Office Administration', '54987', '65465464556', '', '$2y$10$iI96tieWxJq3YEdR2PJCy.rpZ6HkiW3xWNIUNWYfqmQRQW5EzbC92', '$2y$10$iI96tieWxJq3YEdR2PJCy.rpZ6HkiW3xWNIUNWYfqmQRQW5EzbC92', 'Approve', 'inactive', ''),
(175, 'asd', '32', 'asd', '', 'asd@gmail.com', 'male', '2024-10-23', 'BSBA Financial Management', '1', '0998765656', '1st Year', '$2y$10$b0RULur7CgeuO89XM0KF7usxLufkaswU1ZOTTZQvigpYs5sggG/S2', '', '', 'inactive', ''),
(176, 'kent joshua', 'z', 'daborbor', '', 'kentjoshuazamoradaborbor@gmail.com', 'male', '2024-07-04', 'BS Accountancy', '1', '0998765656', '2nd Year', '$2y$10$sgYvij.3aLsqHqlC1/NFku3LsQAqFqybr1lot1KGNIDbh0tCA96YK', '', '', 'active', ''),
(177, 'George', 'A.', 'Geanga', '', 'anthonygeanga@gmail.com', 'male', '2024-10-25', 'BS Information System', '1', '0912312312', '4th Year', '$2y$10$yRVlz2nAj0EStvPamboVFex6UPA7gh7wPLpzgyHyReJbjso/Cyo3S', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `students_id`
--

CREATE TABLE `students_id` (
  `id` int(11) NOT NULL,
  `student_id` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_id`
--

INSERT INTO `students_id` (`id`, `student_id`, `status`) VALUES
(1, '123456789', 'Taken'),
(8, '1', 'Taken'),
(9, '2', 'Taken'),
(11, '12', '');

-- --------------------------------------------------------

--
-- Table structure for table `walk_in_borrow`
--

CREATE TABLE `walk_in_borrow` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(250) NOT NULL,
  `Student` varchar(250) NOT NULL,
  `Categories` varchar(250) NOT NULL,
  `Title` varchar(250) NOT NULL,
  `Author` varchar(250) NOT NULL,
  `No_Of_Copies` int(11) NOT NULL,
  `Borrow` varchar(250) NOT NULL,
  `Date_To_Claim` varchar(250) NOT NULL,
  `Time` varchar(250) NOT NULL,
  `Queue` varchar(250) NOT NULL,
  `Issued` varchar(250) NOT NULL,
  `Issued_Date` varchar(250) NOT NULL,
  `Due_Date` varchar(250) NOT NULL,
  `Return_Date` varchar(250) NOT NULL,
  `Fines` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_replacement`
--
ALTER TABLE `book_replacement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendar_appointment`
--
ALTER TABLE `calendar_appointment`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `registertbl`
--
ALTER TABLE `registertbl`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `students_id`
--
ALTER TABLE `students_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `walk_in_borrow`
--
ALTER TABLE `walk_in_borrow`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `book_replacement`
--
ALTER TABLE `book_replacement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `borrow`
--
ALTER TABLE `borrow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1164;

--
-- AUTO_INCREMENT for table `calendar_appointment`
--
ALTER TABLE `calendar_appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2446;

--
-- AUTO_INCREMENT for table `library_fines`
--
ALTER TABLE `library_fines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `most_borrowed_books`
--
ALTER TABLE `most_borrowed_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `registertbl`
--
ALTER TABLE `registertbl`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `students_id`
--
ALTER TABLE `students_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `walk_in_borrow`
--
ALTER TABLE `walk_in_borrow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
