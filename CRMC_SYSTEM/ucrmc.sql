-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2024 at 02:49 PM
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
-- Database: `ucrmc`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseID` int(11) NOT NULL,
  `courseName` varchar(100) NOT NULL,
  `departmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `courseName`, `departmentID`) VALUES
(1, 'Bachelor of Science in Information Techonology', 8),
(2, 'Bachelor of Science in Accountancy', 9),
(3, 'Bachelor of Secondary Education major in Mathematics', 12),
(4, 'Bachelor of Science in Accounting Technology', 9);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentID` int(11) NOT NULL,
  `departmentName` varchar(50) NOT NULL,
  `departmentLogo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentID`, `departmentName`, `departmentLogo`) VALUES
(8, 'College of Computer Studies', 'uploads/ccs.png'),
(9, 'College of Commerce', 'uploads/commerce.png'),
(11, 'College of Criminal Justice Education', 'uploads/CCJE.png'),
(12, 'College of Teacher Education', 'uploads/CTE.png');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `gradeID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `subjectID` int(11) NOT NULL,
  `prelim` int(11) NOT NULL,
  `midterm` int(11) NOT NULL,
  `semifinal` int(11) NOT NULL,
  `final` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `gwa` double NOT NULL,
  `remark` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`gradeID`, `studentID`, `courseID`, `subjectID`, `prelim`, `midterm`, `semifinal`, `final`, `total`, `gwa`, `remark`) VALUES
(2, 5, 1, 1, 95, 94, 93, 91, 93, 1.3, 'PASSED'),
(3, 5, 1, 4, 96, 97, 98, 96, 97, 1.2, 'PASSED'),
(4, 6, 1, 1, 94, 94, 92, 95, 94, 1.3, 'PASSED'),
(5, 8, 2, 6, 85, 84, 80, 75, 81, 1.7, 'PASSED');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `semesterID` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `yearLevel` int(11) NOT NULL,
  `subjectID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`semesterID`, `semester`, `yearLevel`, `subjectID`) VALUES
(6, 2, 1, 3),
(7, 1, 3, 1),
(8, 2, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `departmentID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `yearLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `firstName`, `lastName`, `photo`, `birthdate`, `age`, `email`, `password`, `contact`, `address`, `departmentID`, `courseID`, `yearLevel`) VALUES
(5, 'John', 'Nico Edisan', 'uploads/nico.jpg', '2015-01-08', 21, 'nicxsician@gmail.com', 'nicxsassassin', '0921564564', 'Bungtod Bogo City, Cebu', 8, 1, 3),
(6, 'Dhaniel', 'Malinao', 'uploads/dhaniel.jpg', '2002-02-26', 21, 'dhaniel@gmail.com', 'dhaniel123', '095465464', 'Bungtod Bogo City, Cebu', 8, 1, 3),
(7, 'Izzy', 'Baliguat', 'uploads/izzy.jpg', '2004-04-03', 19, 'izzy@gmail.com', 'izzy123', '095465464', 'Toledo City, Cebu', 12, 3, 3),
(8, 'Avelline ', 'Alegada', 'uploads/BaliguatIDCard.png', '2003-11-26', 20, 'ave@gmail.com', 'ave12345', '095654654341', 'Toledo City, Cebu', 9, 2, 3),
(9, 'Betty', 'Maluya', 'uploads/betty.jpg', '2002-09-11', 21, 'betty@gmail.com', 'betty123', '0951321321', 'Cebu City, Cebu', 9, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subjectID` int(11) NOT NULL,
  `subjectName` varchar(100) NOT NULL,
  `courseID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subjectID`, `subjectName`, `courseID`) VALUES
(1, 'Elective 1', 0),
(2, 'Elective 1', 1),
(3, 'Fundamentals of Accounting 1', 2),
(4, 'Application Development', 1),
(5, 'World of Mathematics', 3),
(6, 'Tax', 2);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacherID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `departmentID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `subjectID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacherID`, `firstName`, `lastName`, `photo`, `birthdate`, `age`, `email`, `password`, `contact`, `address`, `departmentID`, `courseID`, `subjectID`) VALUES
(22, 'Leonard', 'Balabat', 'uploads/balabat.jpg', '2001-12-02', 22, 'balabat@gmail.com', 'balabat123', '09552076754', 'Gairan Bogo City, Cebu', 8, 1, 1),
(24, 'Windel', 'Pelayo', 'uploads/win.jpg', '1997-12-12', 26, 'windel@gmail.com', 'windel123', '09552076754', 'Libertad, Bogo City, Cebu', 8, 1, 4),
(25, 'Rengie', 'Gomes', 'uploads/tick.png', '2002-03-02', 21, 'gomes@gmail.com', 'gomes123', '095465464', 'Libertad, Bogo City, Cebu', 12, 3, 5),
(26, 'Jessa', 'Pianar', 'uploads/commerce.png', '1995-02-24', 28, 'jessa@gmail.com', 'jessa123', '09564564', 'Gairan Bogo City, Cebu', 9, 2, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseID`),
  ADD KEY `course_ibfk_1` (`departmentID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentID`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`gradeID`),
  ADD KEY `courseID` (`courseID`),
  ADD KEY `studentID` (`studentID`),
  ADD KEY `subjectID` (`subjectID`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`semesterID`),
  ADD KEY `subjectID` (`subjectID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`),
  ADD KEY `departmentID` (`departmentID`),
  ADD KEY `courseID` (`courseID`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subjectID`),
  ADD KEY `courseID` (`courseID`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacherID`),
  ADD KEY `subjectID` (`subjectID`),
  ADD KEY `departmentID` (`departmentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `gradeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `semesterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`);

--
-- Constraints for table `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `grade_ibfk_1` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`),
  ADD CONSTRAINT `grade_ibfk_2` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`),
  ADD CONSTRAINT `grade_ibfk_3` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`);

--
-- Constraints for table `semester`
--
ALTER TABLE `semester`
  ADD CONSTRAINT `semester_ibfk_1` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
