-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2021 at 07:50 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.11

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

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `Id` bigint(20) NOT NULL,
  `postId` bigint(20) NOT NULL,
  `userId` int(11) NOT NULL,
  `postContent` text NOT NULL,
  `postTags` varchar(100) NOT NULL,
  `postImage` varchar(500) NOT NULL,
  `postCommentCount` int(11) NOT NULL,
  `postLikeCount` int(11) NOT NULL,
  `postDate` text NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`Id`, `postId`, `userId`, `postContent`, `postTags`, `postImage`, `postCommentCount`, `postLikeCount`, `postDate`) VALUES
(1, 0, 4, '            work', '           #coursework', '', 0, 0, '0000-00-00 00:00:00'),
(2, 0, 4, '          frogs', '        #froggie', '', 0, 0, 'Sun 21st Feb 2021 18:40'),
(3, 0, 5, 'Test posts', '    fvaybniosp', '', 0, 0, 'Sun 21st Mar 2021 22:00');

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
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userFname`, `userLname`, `userEmail`, `userUid`, `userPwd`, `userGender`, `userPhone`) VALUES
(3, 'Alexi', 'Luises', 'alexi1999@live.com', 'Axi', '$2y$10$2m/lkZlvTFR34Am2ChZSCOTRXCv/VuE1L0S0NwQZ91pYUJJK0tIB.', 'Male', '07393311613'),
(4, 'alex', 'luises', 'AAstra@gmail.com', 'rag', '$2y$10$UO.EaKQpNOMSPbq6f8sQse9PVVi5E2joVTDgGxdm3jlSczryJqDzu', 'male', '07393311614'),
(5, 'test', 'user', 'test@test.net', 'test1', '$2y$10$rYGcAI6.7S3YpD1jXJJJ9OVjMs38MGiONkWYDVaXUGEG1GPZDHx7O', 'ohn', '07777777777');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `passwordreset`
--
ALTER TABLE `passwordreset`
  ADD PRIMARY KEY (`pwdResetID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `postId` (`postId`),
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
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `passwordreset`
--
ALTER TABLE `passwordreset`
  MODIFY `pwdResetID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
