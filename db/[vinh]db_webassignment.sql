-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2016 at 05:38 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `Address` varchar(255) DEFAULT NULL,
  `BirthPlace` varchar(255) DEFAULT NULL,
  `Gender` varchar(6) CHARACTER SET latin1 NOT NULL,
  `Father` int(11) DEFAULT NULL,
  `Level` int(11) DEFAULT '0',
  `Alive` tinyint(1) NOT NULL DEFAULT '1',
  `Avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`userID`, `MemberID`, `Name`, `BirthDate`, `Address`, `BirthPlace`, `Gender`, `Father`, `Level`, `Alive`, `Avatar`) VALUES
(2, 1, 'Nguyễn Thành Tâm', '1994-12-15', '345 Red Street', 'Paradise', 'male', NULL, 0, 0, 'http://i.imgur.com/gtWulgo.jpg'),
(2, 2, 'Nguyễn Xuân Thái', '2016-03-11', '482 Black Street', 'Hotel', 'male', 1, 1, 1, 'http://i.imgur.com/qEei3AS.jpg'),
(2, 3, 'Lê Đức Quí', '2016-03-18', 'ds', '382 Pink Street', 'female', 2, 2, 1, 'http://i.imgur.com/6pQf6Ur.jpg'),
(2, 4, 'Bùi Quang Vinh', '2016-03-25', '583 Yellow Street', '583 Yellow Street', 'male', 2, 2, 1, 'http://i.imgur.com/zEcz4bx.jpg'),
(2, 5, 'Uzumaki Naruto', '2016-03-10', '333', '333', 'male', 1, 1, 1, 'http://i.imgur.com/VRM1KB9.png'),
(2, 6, 'Michael Jackson', '2016-03-02', '253 NewYork', '253 NewYork', 'male', 1, 1, 1, 'http://i.imgur.com/EYflj2s.jpg'),
(2, 7, 'Mike Tyson', '2016-03-02', '374 Las Vegas', '374 Las Vegas', 'male', 2, 2, 1, 'http://i.imgur.com/xyNvaBI.jpg'),
(2, 8, 'Monkey de Luffy', '2016-03-09', 'Big Sea', 'Big Sea', 'male', 5, 2, 1, 'http://i.imgur.com/2noknZD.jpg?1'),
(2, 10, 'anhdeptrai', '2016-01-01', 'b?nh h?ng h?a', 'tr?i ??t', 'male', 4, 3, 1, 'http://i.imgur.com/zEcz4bx.jpg'),
(2, 14, 'Anh dep trai', '2999-12-21', 'dadada', 'asdasdasdas', 'male', 7, 3, 1, 'http://i.imgur.com/QlKj4Dy.png'),
(2, 15, 'tam gay', '1994-12-13', 'asd', 'zczxczx', 'female', NULL, 0, 1, 'images/avatar-default.png'),
(2, 16, 'asf', '2015-07-07', 'sasa', 'asdas', 'female', NULL, 0, 1, 'images/avatar-default.png'),
(79, 35, 'tam gay', '1213-04-03', 'dada', 'asdasda', 'female', NULL, 0, 1, 'images/avatar-female-default.jpg'),
(79, 40, 'asd', '1212-12-12', 'xzczxcz', 'tào lao', 'female', 35, 1, 1, 'images/avatar-female-default.jpg'),
(81, 36, 'test11', '1994-01-02', 'hòa h?ng', 'asad', 'male', NULL, 0, 0, 'images/avatar-default.png'),
(81, 38, 'test231', '1995-11-11', '', 'heaven', 'female', 36, 1, 1, 'images/avatar-female-default.jpg'),
(81, 39, 'hello tam gay be de', '1996-01-01', '', 'hoho', 'female', 38, 2, 0, 'images/avatar-female-default.jpg'),
(81, 44, 'zaas', '1997-11-11', '', 'asda', 'male', 39, 3, 0, 'images/avatar-default.png'),
(81, 45, 'hihi', '1994-01-03', '', 'z', 'female', 36, 1, 1, 'images/avatar-female-default.jpg');

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
(1, 'leducqui', 'leducqui@gmial.com', '123456', 'le duc qui', 'admin'),
(2, 'nguyenthanhtam', 'nguyenthanhtam@gmail.com', '123456', 'nguyen thanh tam', 'user'),
(3, 'asd', 'adsda@gmail.com', 'asdsad', 'sadsadas', 'user'),
(13, 'tamgay3', 'tamgay3@gmail.com', 'tamgay', 'tamgay', 'guest'),
(15, 'tamgay5', 'tamgay5@gmail.com', 'tamgay', 'tamgay', 'user'),
(16, 'tamgay6', 'tamgay6@gmail.com', 'tamgay', 'tamgay', 'user'),
(17, 'tamgay7', 'tamgay7@gmail.com', 'tamgay', 'tamgay', 'user'),
(18, 'tamgay8', 'tamgay8@gmail.com', 'tamgay', 'tamgay', 'user'),
(19, 'tamgay9', 'tamgay9@gmail.com', 'tamgay', 'tamgay', 'user'),
(20, 'tamgay10', 'tamgay10@gmail.com', 'tamgay', 'tamgay', 'user'),
(21, 'tamgay11', 'tamgay11@gmail.com', 'tamgay', 'tamgay', 'user'),
(22, 'tamgay12', 'tamgay12@gmail.com', 'tamgay', 'tamgay', 'user'),
(23, 'tamgay13', 'tamgay13@gmail.com', 'tamgay', 'tamgay', 'user'),
(24, 'tamgay14', 'tamgay14@gmail.com', 'tamgay', 'tamgay', 'user'),
(25, 'tamgay15', 'tamgay15@gmail.com', 'tamgay', 'tamgay', 'user'),
(26, 'tamgay16', 'tamgay16@gmail.com', 'tamgay', 'tamgay', 'user'),
(27, 'tamgay17', 'tamgay17@gmail.com', 'tamgay', 'tamgay', 'user'),
(28, 'tamgay18', 'tamgay18@gmail.com', 'tamgay', 'tamgay', 'user'),
(29, 'tamgay19', 'tamgay19@gmail.com', 'tamgay', 'tamgay', 'user'),
(30, 'tamgay20', 'tamgay20@gmail.com', 'tamgay', 'tamgay', 'user'),
(31, 'tamgay21', 'tamgay21@gmail.com', 'tamgay', 'tamgay', 'user'),
(32, 'tamgay22', 'tamgay22@gmail.com', 'tamgay', 'tamgay', 'user'),
(33, 'tamgay23', 'tamgay23@gmail.com', 'tamgay', 'tamgay', 'user'),
(34, 'tamgay24', 'tamgay24@gmail.com', 'tamgay', 'tamgay', 'user'),
(35, 'tamgay25', 'tamgay25@gmail.com', 'tamgay', 'tamgay', 'user'),
(36, 'tamgay26', 'tamgay26@gmail.com', 'tamgay', 'tamgay', 'user'),
(37, 'tamgay27', 'tamgay27@gmail.com', 'tamgay', 'tamgay', 'user'),
(38, 'tamgay28', 'tamgay28@gmail.com', 'tamgay', 'tamgay', 'user'),
(39, 'tamgay29', 'tamgay29@gmail.com', 'tamgay', 'tamgay', 'user'),
(40, 'tamgay30', 'tamgay30@gmail.com', 'tamgay', 'tamgay', 'user'),
(41, 'tamgay31', 'tamgay31@gmail.com', 'tamgay', 'tamgay', 'user'),
(42, 'tamgy26', 'tagay26@gmail.com', 'tamgay', 'tamgay', 'user'),
(43, 'tamgy27', 'tamgy27@gmail.com', 'tamgay', 'tamgay', 'user'),
(44, 'tamgy28', 'tamgy28@gmail.com', 'tamgay', 'tamgay', 'user'),
(45, 'tagay29', 'tamga29@gmail.com', 'tamgay', 'tamgay', 'user'),
(46, 'tamay30', 'tagay30@gmail.com', 'tamgay', 'tamgay', 'user'),
(47, 'tamgy31', 'tagay31@gmail.com', 'tamgay', 'tamgay', 'user'),
(54, 'tamy26', 'tgay26@gmail.com', 'tamgay', 'tamgay', 'user'),
(55, 'tamy27', 'tamy27@gmail.com', 'tamgay', 'tamgay', 'user'),
(56, 'tamy28', 'tagy28@gmail.com', 'tamgay', 'tamgay', 'user'),
(57, 'tagy29', 'amga29@gmail.com', 'tamgay', 'tamgay', 'user'),
(58, 'tama30', 'tgay30@gmail.com', 'tamgay', 'tamgay', 'user'),
(59, 'tamg31', 'tgay31@gmail.com', 'tamgay', 'tamgay', 'user'),
(60, 'tam26', 'tga26@gmail.com', 'tamgay', 'tamgay', 'user'),
(61, 'tam27', 'tam27@gmail.com', 'tamgay', 'tamgay', 'user'),
(62, 'tay28', 'tag28@gmail.com', 'tamgay', 'tamgay', 'user'),
(63, 'tag29', 'ama29@gmail.com', 'tamgay', 'tamgay', 'user'),
(64, 'tam30', 'tgy30@gmail.com', 'tamgay', 'tamgay', 'user'),
(65, 'tam31', 'tay31@gmail.com', 'tamgay', 'tamgay', 'user'),
(66, 'tm26', 'ta26@gmail.com', 'tamgay', 'tamgay', 'user'),
(67, 'ta27', 'tm27@gmail.com', 'tamgay', 'tamgay', 'user'),
(68, 'ty28', 'tg28@gmail.com', 'tamgay', 'tamgay', 'user'),
(69, 'tg29', 'aa29@gmail.com', 'tamgay', 'tamgay', 'user'),
(70, 'ta30', 'ty30@gmail.com', 'tamgay', 'tamgay', 'user'),
(71, 'tm31', 'ay31@gmail.com', 'tamgay', 'tamgay', 'user'),
(72, 'hichichic', 'hic@mg.co', '', 'huhuhu', 'user'),
(73, 'asaszxc', 'asdasda', 'wq?sadá', 'sadsadsada', 'user'),
(78, 'vinh dep trai', 'asd@as.sa', 'asd', 'asdasd', 'user'),
(79, 'buiquangvinh', 'deptraicogisai@gmail.com', '123456', 'vinhdeptraiaa', 'user'),
(80, 'da', 'askd@fldsasdas.dsad', 'dasda', 'sada', 'user'),
(81, 'test', 'test@ss.ss', '123456', '', 'user'),
(84, 'thaigay1', 'thaigay@gmail.com', 'thaigay', 'thaigay', 'guest');

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
(13, 2),
(84, 2);

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
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `notfamilyperson`
--
ALTER TABLE `notfamilyperson`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
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
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `person` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
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
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`adminID`) REFERENCES `person` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
