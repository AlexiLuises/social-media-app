-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 23, 2021 at 07:04 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arcus`
--

-- --------------------------------------------------------

--
-- Table structure for table `passwordreset`
--

CREATE TABLE `passwordreset` (
  `pwdResetID` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `passwordreset`:
--

-- --------------------------------------------------------

--
-- Table structure for table `postcomments`
--

CREATE TABLE `postcomments` (
  `commentId` int(20) NOT NULL,
  `userId` int(11) NOT NULL,
  `postId` int(20) NOT NULL,
  `commentContent` text NOT NULL,
  `commentDate` text NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `postcomments`:
--

--
-- Dumping data for table `postcomments`
--

INSERT INTO `postcomments` (`commentId`, `userId`, `postId`, `commentContent`, `commentDate`) VALUES
(3, 5, 5, 'bad post my guy', 'Fri 2nd Apr 2021 21:15'),
(13, 5, 3, 'asda is cool', 'Sat 3rd Apr 2021 19:25'),
(14, 5, 2, 'Frogs are pretty neat', 'Sat 3rd Apr 2021 19:54'),
(15, 5, 2, 'Yeah I agree bro', 'Sat 3rd Apr 2021 19:55'),
(16, 5, 3, 'YUh', 'Sat 3rd Apr 2021 20:59'),
(17, 7, 5, 'asda', 'Sat 3rd Apr 2021 21:14');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `Id` bigint(20) NOT NULL,
  `userId` int(11) NOT NULL,
  `postContent` text DEFAULT NULL,
  `postTags` varchar(100) DEFAULT NULL,
  `postImage` varchar(500) DEFAULT NULL,
  `postCommentCount` int(11) DEFAULT NULL,
  `postLikeCount` int(11) DEFAULT NULL,
  `postDate` text NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `posts`:
--

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`Id`, `userId`, `postContent`, `postTags`, `postImage`, `postCommentCount`, `postLikeCount`, `postDate`) VALUES
(2, 4, '          frogsffff', '        #froggie', '', 0, 0, 'Sun 21st Feb 2021 18:40'),
(3, 5, 'Test posts', '    fvaybniosp', '', 0, 0, 'Sun 21st Mar 2021 22:00'),
(4, 5, 'Hi', '#3', NULL, NULL, NULL, 'Mon 29th Mar 2021 01:31'),
(5, 5, 'aaaaaaaaa', '#testingStuff', NULL, NULL, NULL, 'Fri 2nd Apr 2021 21:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userFname` varchar(256) NOT NULL,
  `userLname` varchar(256) NOT NULL,
  `userEmail` varchar(256) NOT NULL,
  `userUid` varchar(256) NOT NULL,
  `userPwd` varchar(256) NOT NULL,
  `userGender` varchar(12) NOT NULL,
  `userPhone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `users`:
--

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userFname`, `userLname`, `userEmail`, `userUid`, `userPwd`, `userGender`, `userPhone`) VALUES
(3, 'Alexi', 'Luises', 'alexi1999@live.com', 'Axi', '$2y$10$2m/lkZlvTFR34Am2ChZSCOTRXCv/VuE1L0S0NwQZ91pYUJJK0tIB.', 'Male', '07393311613'),
(4, 'alex', 'luises', 'AAstra@gmail.com', 'rag', '$2y$10$UO.EaKQpNOMSPbq6f8sQse9PVVi5E2joVTDgGxdm3jlSczryJqDzu', 'male', '07393311614'),
(5, 'test', 'user', 'test@test.net', 'test1', '$2y$10$rYGcAI6.7S3YpD1jXJJJ9OVjMs38MGiONkWYDVaXUGEG1GPZDHx7O', 'ohn', '07777777777'),
(6, 'jean', 'vandamme', 'jvd@gmail.com', 'jvd', '$2y$10$hXlKKjETUH8pr5.rtBLs7e.JBPr6NR5NFZfHs9RFvX011h9HkkI/.', 'Human', '09876543212'),
(7, 'Alexi', 'Luises', 'alexi.alexi@alexi.com', 'asda', '$2y$10$v4Rjaylp0/NWGaCoaUHq/OB/F.w3qTOxuE07fpViMYMw.rZdGtg4m', 'bof', '07132435467');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `passwordreset`
--
ALTER TABLE `passwordreset`
  ADD PRIMARY KEY (`pwdResetID`);

--
-- Indexes for table `postcomments`
--
ALTER TABLE `postcomments`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `postId` (`postId`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `postDate` (`postDate`(768)),
  ADD KEY `postLikeCount` (`postLikeCount`),
  ADD KEY `postCommentCount` (`postCommentCount`),
  ADD KEY `postTags` (`postTags`);
ALTER TABLE `posts` ADD FULLTEXT KEY `postContent` (`postContent`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD KEY `userFname` (`userFname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `passwordreset`
--
ALTER TABLE `passwordreset`
  MODIFY `pwdResetID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `commentId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
