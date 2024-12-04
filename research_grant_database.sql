-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 03:35 PM
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
-- Database: `research_grant_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `Admin_ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Phone_Number` varchar(11) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `Department` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Admin_ID`, `Name`, `Phone_Number`, `email`, `Department`) VALUES
(21, 'Shssysn', '2324234234', 'asd@asd.com', 'CS'),
(22, 'asdadawdawdas', '2324234234', 'dsa@asd.com', 'CS'),
(23, 'asdadawdawdas', '2324234234', 'dsa@asd.com', 'CS'),
(24, 'Shssysn', '2324234234', 'dsa@asd.com', 'CS'),
(25, 'Banana peel', '2324234234', 'dsa@asd.com', 'Soul Society');

-- --------------------------------------------------------

--
-- Table structure for table `agencies_information`
--

CREATE TABLE `agencies_information` (
  `Agency_ID` int(11) NOT NULL,
  `Agency_Name` varchar(255) DEFAULT NULL,
  `Contact` varchar(11) DEFAULT NULL,
  `Spokesman` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agencies_information`
--

INSERT INTO `agencies_information` (`Agency_ID`, `Agency_Name`, `Contact`, `Spokesman`) VALUES
(14, 'Wonders ltd', '123212312', 'Ahmed'),
(15, 'Wonders ltd', '1231231212', 'Ahmed'),
(16, 'Wonders ltd', '123123311', 'Ahmed'),
(17, 'Wonders ltd', '1231231212', 'Joov');

-- --------------------------------------------------------

--
-- Table structure for table `applications_information`
--

CREATE TABLE `applications_information` (
  `Application_ID` int(11) NOT NULL,
  `Application_Title` varchar(255) DEFAULT NULL,
  `Submission_Date` date DEFAULT NULL,
  `Status` enum('Pending','Under Review','Approved','Rejected') DEFAULT 'Pending',
  `Details` varchar(225) DEFAULT NULL,
  `Expected_Expense` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications_information`
--

INSERT INTO `applications_information` (`Application_ID`, `Application_Title`, `Submission_Date`, `Status`, `Details`, `Expected_Expense`) VALUES
(17, 'Test application', '2024-05-23', 'Pending', 'details/UML State Diagram Example_ Orthogonal State (1).pdf', 123123),
(18, 'Test', '2024-05-24', 'Pending', 'details/Nasa.pdf', 10000),
(19, 'v2 notification test', '2024-05-24', 'Pending', 'details/Untitled.pdf', 10000),
(20, 'waswas', '2024-05-24', 'Pending', 'details/UML State Diagram Example_ Orthogonal State (1).pdf', 1231230),
(21, 'Notification test', '2024-05-28', 'Pending', 'details/Q1 (1).pdf', 123),
(22, 'This is a test', '2024-11-17', 'Pending', 'details/Assignment 02 SW Metrics Fall 2024.pdf', 1231240);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_information`
--

CREATE TABLE `faculty_information` (
  `Faculty_ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Department` varchar(255) DEFAULT NULL,
  `Phone` varchar(11) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_information`
--

INSERT INTO `faculty_information` (`Faculty_ID`, `Name`, `Department`, `Phone`, `email`) VALUES
(5, 'Tester', 'Software_Engineering', '03330003525', 'asfasf@gmail.com'),
(6, 'KurosakiIchigo', 'Soul Society', '03330003525', 'Kurosaki@bleach.com'),
(7, 'Shayan', 'Air Uni', '03330002525', 'shayandp75@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `granted_requests`
--

CREATE TABLE `granted_requests` (
  `Grant_ID` int(11) NOT NULL,
  `Resources_Granted` varchar(255) DEFAULT NULL,
  `Start_Date` date DEFAULT NULL,
  `Expiry_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `granted_requests`
--

INSERT INTO `granted_requests` (`Grant_ID`, `Resources_Granted`, `Start_Date`, `Expiry_Date`) VALUES
(29, 'grants/A4 use case diagram.pdf', '2024-05-24', '2025-05-24'),
(30, 'grants/ClassDiagram.pdf', '2024-05-24', '2025-05-24'),
(31, 'grants/L10 - Maha Adin-221782-B.pdf', '2024-05-24', '2025-05-24'),
(32, 'grants/SDA-221828-A4-SP24.pdf', '2024-05-24', '2025-05-24'),
(33, 'grants/was.pdf', '2024-05-28', '2025-05-28');

-- --------------------------------------------------------

--
-- Table structure for table `linking_table`
--

CREATE TABLE `linking_table` (
  `Link_ID` int(11) NOT NULL,
  `Faculty_ID` int(11) NOT NULL,
  `Application_ID` int(11) NOT NULL,
  `Agency_ID` int(11) DEFAULT NULL,
  `Project_ID` int(11) DEFAULT NULL,
  `GrantedRequest_ID` int(11) DEFAULT NULL,
  `Admin_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `linking_table`
--

INSERT INTO `linking_table` (`Link_ID`, `Faculty_ID`, `Application_ID`, `Agency_ID`, `Project_ID`, `GrantedRequest_ID`, `Admin_ID`) VALUES
(16, 5, 17, 15, 30, 30, 22),
(17, 6, 18, 14, 29, 29, 21),
(18, 6, 19, 15, 31, 31, 23),
(19, 6, 20, 16, 32, 32, 24),
(20, 6, 21, 17, 33, 33, 25),
(21, 7, 22, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `User_ID` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `Agency` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`User_ID`, `username`, `password`, `phone`, `email`, `Agency`) VALUES
(9, 'Wonders ltd', '$2y$10$28LmxtFSwcEKTJI.CAqQ2Of59JeC.sGMR3qOeYA4yrFZJY4dT38ZW', '12312312312', 'was@was.com', 1),
(10, 'KurosakiIchigo', '$2y$10$sBb11Cr3jv3r4pavBDxqy.e2MyFkQAjKFQnIiYofM7LsxfPqhuT7i', '03330003525', 'Kurosaki@bleach.com', NULL),
(13, 'Tester', '$2y$10$28LmxtFSwcEKTJI.CAqQ2Of59JeC.sGMR3qOeYA4yrFZJY4dT38ZW', '03330003525', 'asfasf@gmail.com', NULL),
(14, 'Shayan', '$2y$10$NgZcsJcy4cSrTQwVXPuiluPIUw0805zLD7suF8D8HlZRQP9aNuWe6', '03330002525', 'shayandp75@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `Project_ID` int(11) NOT NULL,
  `Project_Title` varchar(255) DEFAULT NULL,
  `Start_Date` varchar(11) DEFAULT NULL,
  `End_Date` varchar(11) DEFAULT NULL,
  `Status` enum('Ongoing','Done','Abandoned') DEFAULT 'Ongoing',
  `seen` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`Project_ID`, `Project_Title`, `Start_Date`, `End_Date`, `Status`, `seen`) VALUES
(29, 'Ai', '2024-05-24', '2025-05-24', 'Ongoing', 1),
(30, 'This is the test', '2024-05-24', '2025-05-24', 'Ongoing', 1),
(31, 'notification v2 works', '2024-05-24', '2025-05-24', 'Ongoing', 1),
(32, 'This is the test', '2024-05-24', '2025-05-24', 'Ongoing', 1),
(33, 'works', '2024-05-28', '2025-05-28', 'Ongoing', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `agencies_information`
--
ALTER TABLE `agencies_information`
  ADD PRIMARY KEY (`Agency_ID`);

--
-- Indexes for table `applications_information`
--
ALTER TABLE `applications_information`
  ADD PRIMARY KEY (`Application_ID`);

--
-- Indexes for table `faculty_information`
--
ALTER TABLE `faculty_information`
  ADD PRIMARY KEY (`Faculty_ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `granted_requests`
--
ALTER TABLE `granted_requests`
  ADD PRIMARY KEY (`Grant_ID`);

--
-- Indexes for table `linking_table`
--
ALTER TABLE `linking_table`
  ADD PRIMARY KEY (`Link_ID`),
  ADD KEY `Faculty_ID` (`Faculty_ID`),
  ADD KEY `Application_ID` (`Application_ID`),
  ADD KEY `Agency_ID` (`Agency_ID`),
  ADD KEY `GrantedRequest_ID` (`GrantedRequest_ID`),
  ADD KEY `Project_ID` (`Project_ID`),
  ADD KEY `Admin_ID` (`Admin_ID`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`Project_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `agencies_information`
--
ALTER TABLE `agencies_information`
  MODIFY `Agency_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `applications_information`
--
ALTER TABLE `applications_information`
  MODIFY `Application_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `faculty_information`
--
ALTER TABLE `faculty_information`
  MODIFY `Faculty_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `granted_requests`
--
ALTER TABLE `granted_requests`
  MODIFY `Grant_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `linking_table`
--
ALTER TABLE `linking_table`
  MODIFY `Link_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `Project_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `linking_table`
--
ALTER TABLE `linking_table`
  ADD CONSTRAINT `linking_table_ibfk_1` FOREIGN KEY (`Faculty_ID`) REFERENCES `faculty_information` (`Faculty_ID`),
  ADD CONSTRAINT `linking_table_ibfk_2` FOREIGN KEY (`Application_ID`) REFERENCES `applications_information` (`Application_ID`),
  ADD CONSTRAINT `linking_table_ibfk_3` FOREIGN KEY (`Agency_ID`) REFERENCES `agencies_information` (`Agency_ID`),
  ADD CONSTRAINT `linking_table_ibfk_4` FOREIGN KEY (`GrantedRequest_ID`) REFERENCES `granted_requests` (`Grant_ID`),
  ADD CONSTRAINT `linking_table_ibfk_5` FOREIGN KEY (`Project_ID`) REFERENCES `projects` (`Project_ID`),
  ADD CONSTRAINT `linking_table_ibfk_6` FOREIGN KEY (`Admin_ID`) REFERENCES `admins` (`Admin_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
