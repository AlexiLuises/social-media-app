-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2021 at 12:11 AM
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
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `likeId` int(11) NOT NULL,
  `userId` varchar(11) NOT NULL,
  `postId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `likes`:
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
  `postLikeCount` int(11) NOT NULL DEFAULT 0,
  `postDate` text NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `posts`:
--

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
  `userPhone` varchar(11) NOT NULL,
  `profilePicture` varchar(200) NOT NULL DEFAULT './photos/default.png',
  `creationDate` text DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `users`:
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likeId`);

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
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passwordreset`
--
ALTER TABLE `passwordreset`
  MODIFY `pwdResetID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `commentId` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
