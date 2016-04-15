-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2016 at 05:42 PM
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
CREATE DATABASE IF NOT EXISTS `webassignment` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `webassignment`;

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
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `contact_number`, `created_at`, `updated_at`) VALUES
(1, 'Lizzie Fisher', 'Glenda.Murray@Ernser.biz', '710-546-7205', NULL, NULL),
(2, 'Waino Gutmann', 'Denesik.Akeem@Kunde.org', '266-848-8238', NULL, NULL),
(3, 'Shirley Schulist', 'zOConnell@Terry.net', '795-404-6809', NULL, NULL),
(4, 'Lillian Will Jr.', 'nPurdy@Hills.org', '790.473.7777x39655', NULL, NULL),
(5, 'Paxton Bayer', 'Magdalen.Flatley@Skiles.com', '+01(9)9312371944', NULL, NULL),
(6, 'Wayne Sawayn', 'Jordon.Little@gmail.com', '(609)276-2804', NULL, NULL),
(7, 'Prof. Juwan Hills Sr.', 'White.Germaine@yahoo.com', '1-326-354-6122x46536', NULL, NULL),
(8, 'Jaylen McClure', 'Reese.Williamson@yahoo.com', '1-523-949-7540', NULL, NULL),
(9, 'Modesta Larkin', 'Kathleen.Blick@Lebsack.org', '1-657-233-0985x7656', NULL, NULL),
(10, 'Marshall Robel', 'Martin.Ernser@yahoo.com', '410-752-6909x0937', NULL, NULL),
(11, 'Noemy Mraz', 'Tyler.McCullough@Abshire.com', '+18(8)8248808032', NULL, NULL),
(12, 'Stephanie D''Amore', 'mGaylord@Weimann.org', '831.066.1189x1270', NULL, NULL),
(13, 'Jules Douglas', 'Theresa.Gusikowski@hotmail.com', '1-018-043-2536', NULL, NULL),
(14, 'Tara Gottlieb', 'Emmanuel.Beahan@gmail.com', '07894189123', NULL, NULL),
(15, 'Prof. Tremayne Roberts', 'Ellie.Mayer@Zboncak.biz', '1-865-154-5531', NULL, NULL),
(16, 'Tamia Ernser', 'Bryon51@hotmail.com', '798-406-7236x16859', NULL, NULL),
(17, 'Kacie Lindgren', 'Angeline.Littel@Schroeder.com', '731-028-0640', NULL, NULL),
(18, 'Mrs. Agustina Schuppe', 'Jessica51@hotmail.com', '871-632-6946x5828', NULL, NULL),
(19, 'Prof. Orval Denesik', 'Henderson.Shields@Kirlin.com', '(418)569-4903x4035', NULL, NULL),
(20, 'Alan Wunsch V', 'Lloyd95@yahoo.com', '1-318-973-7087x2269', NULL, NULL),
(21, 'Victoria Sanford', 'lOrn@Bernier.com', '(982)057-7807', NULL, NULL),
(22, 'Brando Koelpin V', 'Erich70@gmail.com', '+43(1)6423094413', NULL, NULL),
(23, 'Carter Gutmann', 'William.Stracke@yahoo.com', '+43(7)4263732595', NULL, NULL),
(24, 'Rubie Kreiger DVM', 'nLehner@yahoo.com', '488.832.9912x55932', NULL, NULL),
(25, 'Dr. Zachery Daugherty DDS', 'Nettie.Pacocha@hotmail.com', '+83(7)7067909030', NULL, NULL),
(26, 'Merle Bogisich Jr.', 'eAbernathy@hotmail.com', '+49(3)2800128284', NULL, NULL),
(27, 'Muhammad Corwin', 'Ruth35@Anderson.com', '1-622-108-5015x037', NULL, NULL),
(28, 'Geo Schoen I', 'sMayer@gmail.com', '949-124-9953x879', NULL, NULL),
(29, 'Morton Jerde', 'vFay@gmail.com', '(842)554-3181x9621', NULL, NULL),
(30, 'Daphne McCullough', 'Ward.Monica@Schneider.com', '824.212.2263', NULL, NULL),
(31, 'Mia Ratke', 'fLeuschke@Crist.info', '(420)948-6236x77531', NULL, NULL),
(32, 'Bianka McLaughlin', 'Shemar57@Schultz.com', '990-133-6742x6789', NULL, NULL),
(33, 'Mrs. Rita Schiller', 'Robert64@yahoo.com', '(772)797-1931', NULL, NULL);

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
  `Alive` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`userID`, `MemberID`, `Name`, `BirthDate`, `Address`, `BirthPlace`, `Gender`, `Father`, `Alive`) VALUES
(2, 1, 'Nguyễn Thành Tâm', '2016-03-29', '1083 Lạc Long Quân, phường 11, Tân Bình, Hồ Chí Minh', 'Paradise', 'male', NULL, 0),
(2, 2, 'Xuân Thái', '2016-03-11', '482 Black Street', 'Hotel', 'male', 1, 0),
(2, 3, 'Lê Đức Quí', '2016-03-18', '382 Pink Street', '382 Pink Street', 'female', 2, 1),
(2, 4, 'Bùi Quang Vinh', '2016-03-25', '583 Yellow Street', '583 Yellow Street', 'male', 2, 0),
(2, 5, 'Uzumaki Naruto', '2016-03-10', '333 Leaf Village', '333 Leaf Village', 'male', 1, 0),
(2, 6, 'Michael Jackson', '2016-03-02', '253 NewYork', '253 NewYork', 'male', 1, 0),
(2, 7, 'Mike Tyson', '2016-03-02', '374 Las Vegas', '374 Las Vegas', 'male', 2, 0),
(2, 20, 'pink ranger', '1982-01-01', 'blabla', 'blolo', 'female', 7, 1),
(2, 28, 'fasf', '1979-01-01', 'asfsaf', 'afdaf', 'female', 7, 1),
(2, 32, 'batman', '1979-01-01', 'amen', 'omen', 'female', 7, 1),
(2, 85, 'sidavcl', '2014-01-01', 'asada', 'sadsad', 'female', 32, 1),
(2, 88, 'thatlametquadia', '2014-01-01', 'asdsdsg', 'sdgdsgdsgs', 'male', 32, 1),
(3, 34, 'nguoi ay haha', '1979-01-01', '243 lac long quan', '243 lac long quan', 'male', NULL, 1),
(3, 35, 'supergirl', '1979-01-01', '32 new york', '32 new york', 'female', 34, 1),
(3, 36, 'venom snake', '1979-01-01', '242 san francisco', '242 san francisco', 'male', 34, 1),
(3, 37, 'Johnny Clarke', '1974-02-03', '343 rock', '343 rock', 'male', 34, 1),
(8, 38, 'soaicaad', '1980-01-01', '283 lay qua vinh oi', '283 lay qua vinh oi', 'male', NULL, 1),
(8, 39, 'dondoc', '1981-01-01', 'haha', 'huhu', 'male', 38, 1),
(8, 40, 'suunuong', '1999-01-01', 'gaygay', 'gaygay', 'female', 38, 1),
(8, 41, 'suunuong2', '1981-03-12', 'gaygay2', 'gaygay2', 'female', 38, 1),
(8, 42, 'suunuong3', '1981-04-12', 'sadds', 'sadasd', 'female', 41, 1),
(8, 43, 'a', '1993-12-12', '', 'a', 'female', 42, 1),
(8, 44, 'a', '1994-12-12', '', 'a', 'female', 43, 1),
(8, 45, 'a', '1995-12-12', '', 'a', 'female', 44, 1),
(8, 46, 'a', '1996-12-12', '', 'a', 'female', 45, 1),
(9, 52, 'lamngaialamthe', '1979-01-01', 'haha', 'hoho', 'female', NULL, 1),
(9, 53, 'asdasdasdas', '1997-01-01', 'asd', 'sad', 'female', 52, 1),
(9, 54, 'wwwttttfffff', '2000-01-01', 'asdasd', 'asdasd', 'female', 53, 1),
(9, 61, 'asfasf', '2011-01-01', 'asfdaf', 'asffsa', 'female', 54, 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1);

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
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('aeon19944@gmail.com', '840e9da9c5b3b11468aad07b0947c1620492ea74bd2cd20a25b7f23b463aa201', '2016-04-08 22:42:13');

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
(2, 'nguyenthanhtam', 'nguyenthanhtam@gmail.com', '123456', 'nguyen thanh tam', 'user'),
(3, 'jackiechan', 'jackie@gmail.com', 'chan', 'Jackie Chan', 'user'),
(4, 'dragonica', 'hoho@gmail.com', '', 'tiger', 'user'),
(5, 'dcm', 'dcm', '', 'dcm', 'user'),
(6, 'kinhvon', 'coincard@gmail.com', '', 'coin card', 'user'),
(8, 'vinhsieugay', 'vinhsieugay@gmail.com', '123456', 'Vinh Gay', 'user'),
(9, 'anonymous1', 'ano@gmail.com', '123456', 'an danh', 'user'),
(10, 'iamnumberone', 'haha@gmail.com', '123456', 'numberone', 'user');

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
(2, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'aeon19944', 'aeon19944@gmail.com', '$2y$10$dTFqb1D9PfoXa5hF7nG8P.HHx81gAiJgsn9ntaUNOKZylMTeGRcCG', 'bLd6K7ry2mBdr8wbQpGA794dTBdQ8xDEhsYgdJWVhl889kQQf53ReoqyF1MQ', '2016-04-08 22:40:53', '2016-04-08 23:07:59'),
(2, 'suunuong2', 'suunuong2@gmail.com', '$2y$10$TDHsTXc9wJB4ycYBD9BiDOsMjyH0LdMw6xkPIfQ7MoXp3x57kwwrK', 'IciYnJITB0wWexdvZEjbvGYdENtuNr90N1bmiYvvEqa99J8ol6jarAYgT8mt', '2016-04-08 23:17:36', '2016-04-08 23:17:52');

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
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `notfamilyperson`
--
ALTER TABLE `notfamilyperson`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`adminID`) REFERENCES `admin` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
