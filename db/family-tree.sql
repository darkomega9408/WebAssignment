-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2016 at 07:04 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

CREATE DATABASE `webassignment`;
USE `webassignment`;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `family-tree`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `marriedincest`
--

CREATE TABLE `marriedincest` (
  `userID` int(11) NOT NULL,
  `HusbandID` int(11) NOT NULL,
  `WifeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `userID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `Name` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `BirthDate` date NOT NULL,
  `Address` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `BirthPlace` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Gender` varchar(6) CHARACTER SET latin1 NOT NULL,
  `Father` int(11) DEFAULT NULL,
  `Level` int(11) DEFAULT '0',
  `Avatar` varchar(255) NOT NULL,
  `Alive` BOOLEAN
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`userID`, `MemberID`, `Name`, `BirthDate`, `Address`, `BirthPlace`, `Gender`, `Father`, `Level`, `Avatar`, `Alive`) VALUES
(2, 1, 'Nguyễn Thành Tâm', '1994-12-15', '345 Red Street', 'Paradise', 'male', NULL, 0, 'http://i.imgur.com/gtWulgo.jpg', false),
(2, 2, 'Nguyễn Xuân Thái', '2016-03-11', '482 Black Street', 'Hotel', 'male', 1, 1, 'http://i.imgur.com/qEei3AS.jpg', false),
(2, 3, 'Lê Đức Quí', '2016-03-18', '382 Pink Street', '382 Pink Street', 'female', 2, 2, 'http://i.imgur.com/6pQf6Ur.jpg', true),
(2, 4, 'Bùi Quang Vinh', '2016-03-25', '583 Yellow Street', '583 Yellow Street', 'male', 2, 2, 'http://i.imgur.com/zEcz4bx.jpg', false),
(2, 5, 'Uzumaki Naruto', '2016-03-10', '333 Leaf Village', '333 Leaf Village', 'male', 1, 1, 'http://i.imgur.com/VRM1KB9.png', false),
(2, 6, 'Michael Jackson', '2016-03-02', '253 NewYork', '253 NewYork', 'male', 1, 1, 'http://i.imgur.com/EYflj2s.jpg', false),
(2, 7, 'Mike Tyson', '2016-03-02', '374 Las Vegas', '374 Las Vegas', 'male', 2, 2, 'http://i.imgur.com/xyNvaBI.jpg', false),
(2, 8, 'Monkey de Luffy', '2016-03-09', 'Big Sea', 'Big Sea', 'male', 5, 2, 'http://i.imgur.com/2noknZD.jpg?1', false);

--
-- Triggers `member`
--
DELIMITER $$
CREATE TRIGGER `triggerAutoLevel` BEFORE INSERT ON `member` FOR EACH ROW BEGIN
IF NEW.Father IS NULL
THEN
	SET NEW.Level = 0;
ELSE
SET NEW.Level = (SELECT Level FROM member WHERE MemberID = NEW.Father) + 1;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notfamilyperson`
--

CREATE TABLE `notfamilyperson` (
  `userID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `BirthPlace` varchar(255) DEFAULT NULL,
  `Gender` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'leducqui', 'leducqui@gmail.com', '123456', 'le duc qui', 'admin'),
(2, 'nguyenthanhtam', 'nguyenthanhtam@gmail.com', '123456', 'nguyen thanh tam', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `adminID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `adminID`) VALUES
(2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `marriedincest`
--
ALTER TABLE `marriedincest`
  ADD PRIMARY KEY (`userID`,`HusbandID`),
  ADD KEY `HusbandID` (`HusbandID`);

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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `adminID` (`adminID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `notfamilyperson`
--
ALTER TABLE `notfamilyperson`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `person` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `marriedincest`
--
ALTER TABLE `marriedincest`
  ADD CONSTRAINT `marriedincest_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `marriedincest_ibfk_2` FOREIGN KEY (`HusbandID`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_ibfk_2` FOREIGN KEY (`Father`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notfamilyperson`
--
ALTER TABLE `notfamilyperson`
  ADD CONSTRAINT `notfamilyperson_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notfamilyperson_ibfk_2` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `person` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`adminID`) REFERENCES `admin` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
