-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2016 at 05:39 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webassignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `userID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `Name` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `BirthDate` date NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `BirthPlace` varchar(255) DEFAULT NULL,
  `Gender` varchar(6) CHARACTER SET latin1 NOT NULL,
  `Father` int(11) DEFAULT NULL,
  `Alive` tinyint(1) NOT NULL DEFAULT '1',
  `Married` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`userID`, `MemberID`, `Name`, `BirthDate`, `Address`, `BirthPlace`, `Gender`, `Father`, `Alive`, `Married`) VALUES
(2, 1, 'Le Duc Qui', '1994-06-11', 'Bien Hoa', 'Ha Noi', 'male', NULL, 1, 1),
(2, 5, 'Uzumaki Naruto', '2016-03-10', '333', '333', 'male', 1, 1, 0),
(2, 6, 'Michael Jackson', '2016-08-12', '253 NewYork', '253 NewYork', 'female', 1, 1, 0),
(2, 63, 'asdasd', '2222-02-22', 'asdasd', 'asdasd', 'male', 1, 1, 0),
(3, 64, 'sdadsa', '1994-01-01', 'dfdsf', 'safsafasf', 'male', NULL, 1, 0),
(3, 66, 'asassf', '1995-01-01', 'dasfsaf', 'asfsasaf', 'female', 64, 1, 1),
(3, 67, 'asfsaf', '1996-01-01', 'asfsaf', 'safsafs', 'female', 66, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notfamilyperson`
--

CREATE TABLE `notfamilyperson` (
  `userID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `Name` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `BirthDate` date NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `BirthPlace` varchar(255) DEFAULT NULL,
  `Gender` varchar(6) NOT NULL,
  `Father` int(11) DEFAULT NULL,
  `Alive` tinyint(1) NOT NULL DEFAULT '1',
  `Avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notfamilyperson`
--

INSERT INTO `notfamilyperson` (`userID`, `MemberID`, `ID`, `Name`, `BirthDate`, `Address`, `BirthPlace`, `Gender`, `Father`, `Alive`, `Avatar`) VALUES
(2, 1, 1, 'Nguyen Phuong', '1994-12-03', 'Vung Tau', 'Vung Tau', 'male', NULL, 1, ''),
(3, 64, 7, '', '0000-00-00', '', '', 'female', NULL, 1, ''),
(3, 66, 9, '', '0000-00-00', '', '', 'female', NULL, 1, 'http://i.imgur.com/KEmU44J.png'),
(3, 67, 10, 'safasf', '2014-01-01', 'zfsaf', 'asfasfas', 'female', NULL, 1, 'http://i.imgur.com/XsUBYKQ.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `ID` int(11) NOT NULL,
  `Username` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`ID`, `Username`, `Email`, `Password`, `Name`, `Role`) VALUES
(1, 'leducqui', 'leducqui@gmial.com', '123456', 'le duc qui', 'admin'),
(2, 'nguyenthanhtam', 'nguyenthanhtam@gmail.com', '123456', 'nguyen thanh tam', 'user'),
(3, 'black', 'black@gmail.com', '123456', 'black man', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`userID`,`MemberID`),
  ADD KEY `MemberID` (`MemberID`),
  ADD KEY `Father` (`Father`);

--
-- Indexes for table `notfamilyperson`
--
ALTER TABLE `notfamilyperson`
  ADD PRIMARY KEY (`userID`,`MemberID`,`ID`),
  ADD KEY `ID` (`ID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `notfamilyperson`
--
ALTER TABLE `notfamilyperson`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `person` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_ibfk_2` FOREIGN KEY (`Father`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notfamilyperson`
--
ALTER TABLE `notfamilyperson`
  ADD CONSTRAINT `notfamilyperson_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `person` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notfamilyperson_ibfk_2` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
