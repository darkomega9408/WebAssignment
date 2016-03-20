-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2016 at 04:46 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

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
-- Table structure for table `marriedincest`
--

CREATE TABLE `marriedincest` (
  `Username` varchar(15) NOT NULL,
  `HusbandID` int(11) NOT NULL,
  `WifeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `Username` varchar(15) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `BirthDate` date NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `BirthPlace` varchar(255) DEFAULT NULL,
  `Gender` varchar(6) NOT NULL,
  `Father` int(11) DEFAULT NULL,
  `Level` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`Username`, `MemberID`, `Name`, `BirthDate`, `Address`, `BirthPlace`, `Gender`, `Father`, `Level`) VALUES
('tam', 1, 'venom', '2016-05-03', 'hell', 'hell', 'female', NULL, 0),
('tam', 2, 'snake', '2016-03-11', 'paradise', 'paradise', 'male', 1, 1),
('tam', 4, 'lion', '2016-03-18', 'school', 'school', 'female', 2, 2),
('tam', 5, 'turtle', '2016-03-25', 'river', 'river', 'male', 2, 2),
('tam', 8, 'tamgay', '0000-00-00', NULL, NULL, 'male', 1, 1),
('tam', 9, 'tamgay', '2016-03-02', '34134', 'dasdas', 'male', 1, 1),
('tam', 10, 'tamgay1', '2016-03-02', 'fsd', 'dfsf', 'male', 2, 2);

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
  `Username` varchar(15) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `BirthPlace` varchar(255) DEFAULT NULL,
  `Gender` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Username` varchar(15) NOT NULL,
  `Password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Username`, `Password`) VALUES
('tam', 'tam');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `marriedincest`
--
ALTER TABLE `marriedincest`
  ADD PRIMARY KEY (`Username`,`HusbandID`),
  ADD KEY `HusbandID` (`HusbandID`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`Username`,`MemberID`),
  ADD KEY `MemberID` (`MemberID`),
  ADD KEY `Father` (`Father`);

--
-- Indexes for table `notfamilyperson`
--
ALTER TABLE `notfamilyperson`
  ADD PRIMARY KEY (`Username`,`MemberID`,`ID`),
  ADD KEY `ID` (`ID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `notfamilyperson`
--
ALTER TABLE `notfamilyperson`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `marriedincest`
--
ALTER TABLE `marriedincest`
  ADD CONSTRAINT `marriedincest_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `user` (`Username`),
  ADD CONSTRAINT `marriedincest_ibfk_2` FOREIGN KEY (`HusbandID`) REFERENCES `member` (`MemberID`),
  ADD CONSTRAINT `marriedincest_ibfk_3` FOREIGN KEY (`Username`) REFERENCES `user` (`Username`);

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `user` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_ibfk_2` FOREIGN KEY (`Father`) REFERENCES `member` (`MemberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notfamilyperson`
--
ALTER TABLE `notfamilyperson`
  ADD CONSTRAINT `notfamilyperson_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `user` (`Username`),
  ADD CONSTRAINT `notfamilyperson_ibfk_2` FOREIGN KEY (`MemberID`) REFERENCES `member` (`MemberID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
