-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 09, 2018 at 08:34 AM
-- Server version: 5.6.39
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `avaco_avarent`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `percentage` float NOT NULL DEFAULT '10',
  `crd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `percentage`, `crd`, `upd`) VALUES
(1, 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e', 20, '2016-07-26 00:00:00', '2018-06-12 12:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brandName` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Active,2:Inactive',
  `crd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `brandId` varchar(255) NOT NULL,
  `categoryName` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Active,2:Inactive',
  `crd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `brandId`, `categoryName`, `status`, `crd`, `upd`) VALUES
(1, '', 'Appliances', 0, '2017-08-29 07:07:33', '2017-09-05 01:37:44'),
(2, '', 'Bikes', 0, '2017-08-29 07:07:59', '2017-09-05 01:37:39'),
(3, '', 'Furniture', 0, '2017-08-29 07:08:37', '2017-09-05 01:37:35'),
(4, '', 'Phones', 0, '2017-08-29 07:09:06', '2017-09-05 01:37:30'),
(6, '', 'Cars', 0, '2017-08-29 08:26:57', '2017-09-05 01:37:23'),
(10, '', 'Audio & Instrument', 1, '2017-09-04 11:39:58', '2017-09-04 11:39:58'),
(11, '', 'Comping', 1, '2017-09-04 11:40:37', '2017-09-05 01:14:59'),
(12, '', 'Computer & office', 1, '2017-09-04 11:41:01', '2018-05-16 06:15:01'),
(13, '', 'hand Tools', 1, '2017-09-04 12:01:26', '2017-09-04 12:01:26'),
(14, '', 'Home', 1, '2017-09-04 12:01:36', '2017-09-04 12:01:36'),
(15, '', 'Home Farm and & Garden', 1, '2017-09-04 12:02:11', '2017-09-04 12:02:11'),
(16, '', 'Medical Equipment', 1, '2017-09-04 12:02:44', '2017-09-04 12:02:44'),
(17, '', 'Construction Equipment', 1, '2017-09-04 12:02:59', '2017-09-04 12:11:36'),
(18, '', 'Parties & Events', 1, '2017-09-04 12:03:19', '2017-09-04 12:03:19'),
(19, '', 'Sporting Goods', 1, '2017-09-04 12:03:36', '2017-09-04 12:03:36'),
(20, '', 'Video', 1, '2017-09-04 12:03:49', '2017-10-02 07:39:22');

-- --------------------------------------------------------

--
-- Table structure for table `catOfBrand`
--

CREATE TABLE `catOfBrand` (
  `id` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `brandId` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Active,0:Inactive',
  `crd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `question` text COLLATE utf8_unicode_ci NOT NULL,
  `answer` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0:inactive;1:active',
  `crd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `senderId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `message` text CHARACTER SET utf8mb4 NOT NULL,
  `senderType` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1:user,0:Admin',
  `notification` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1:Done',
  `postType` enum('0','1') DEFAULT '0' COMMENT '0:text;1:image',
  `crd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paymentDetail`
--

CREATE TABLE `paymentDetail` (
  `id` int(11) NOT NULL,
  `transactionId` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `senderId` int(11) NOT NULL,
  `reciverId` int(11) NOT NULL,
  `payment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `requestPostId` int(11) NOT NULL,
  `paymentType` enum('user','admin') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `adminPercentage` int(11) NOT NULL,
  `paymentStatus` enum('pending','complete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'complete',
  `dataTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(5) NOT NULL DEFAULT '1',
  `crd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `ownerId` int(11) NOT NULL,
  `categoryId` varchar(255) NOT NULL,
  `brandId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL COMMENT 'price/hr',
  `productAge` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL COMMENT '1:New,2:used',
  `productForRental` varchar(255) NOT NULL COMMENT '1:8Hrs,2:12Hrs,3:24Hrs,4:1Week,5:1Month',
  `availStartDate` text NOT NULL,
  `availEndDate` text NOT NULL,
  `totalPrice` varchar(255) NOT NULL,
  `availType` tinyint(4) NOT NULL COMMENT '1:Month,2:Week,3:Hours',
  `instantBooking` varchar(255) NOT NULL COMMENT '1:ON,0:OFF',
  `address` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `isRented` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Active,0:Inactive',
  `crd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `productImages`
--

CREATE TABLE `productImages` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `productImage` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Active,0:Inactive',
  `crd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `givenById` int(11) NOT NULL,
  `receiveById` int(11) NOT NULL,
  `stars` int(11) NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `requestId` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `crd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `renter`
--

CREATE TABLE `renter` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `ownerId` int(11) NOT NULL,
  `bookStartDate` text NOT NULL,
  `price` float NOT NULL,
  `extraPay` varchar(100) NOT NULL,
  `bookEndDate` varchar(20) NOT NULL,
  `bookStartTime` varchar(255) NOT NULL,
  `productForRental` varchar(100) NOT NULL COMMENT ' 1:8Hrs,2:12Hrs,3:24Hrs,4:1Week,5:1Month ',
  `availType` enum('1','2','3') NOT NULL DEFAULT '3' COMMENT '1:Hours,2:Week,3:Month',
  `bookEndTime` varchar(50) NOT NULL,
  `requestType` enum('bookNow','requestToBook') NOT NULL DEFAULT 'requestToBook' COMMENT '1:Book Now,2:RTOBook',
  `requestStatus` enum('pending','accept','reject','modify','complete') NOT NULL DEFAULT 'pending' COMMENT '0:Pending,1:Accept,3:Reject,2:modify,4:Complete',
  `finishStatus` varchar(100) NOT NULL COMMENT '''pending'',''accept'',''sendInvoice''',
  `payStatus` enum('pending','complete') NOT NULL,
  `reviewStatus` enum('pending','complete') NOT NULL DEFAULT 'pending',
  `transactionId` varchar(100) NOT NULL,
  `modifyPrice` float NOT NULL,
  `modifyBookStartTime` varchar(25) NOT NULL,
  `modifyBookEndTime` varchar(25) NOT NULL,
  `modifyBookStartDate` varchar(200) NOT NULL,
  `modifyBookEndDate` varchar(200) NOT NULL,
  `notificationStatus` enum('0','1') NOT NULL DEFAULT '0',
  `modifyAvailType` varchar(11) NOT NULL COMMENT ' 1:Hours,2:Week,3:Month ',
  `modifyProductForRental` varchar(100) NOT NULL,
  `modifyRequestStatus` varchar(11) NOT NULL COMMENT '1:pending,2:accept,3:reject',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Active,0:Inactive',
  `crd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stripeDetail`
--

CREATE TABLE `stripeDetail` (
  `srtripeId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `customerId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bankAccId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cardId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bankId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `crd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `countryCode` varchar(10) NOT NULL,
  `contactNo` varchar(255) NOT NULL DEFAULT '+91',
  `profileImage` varchar(255) NOT NULL,
  `zipCode` varchar(255) NOT NULL,
  `bankAccountStatus` enum('no','yes') NOT NULL DEFAULT 'no',
  `address` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `helpStatus` enum('0','1') NOT NULL DEFAULT '0',
  `socialId` varchar(255) NOT NULL,
  `socialType` varchar(255) NOT NULL,
  `userType` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1: Owner, 2: User',
  `OTP` varchar(255) NOT NULL,
  `otpVerified` varchar(255) NOT NULL DEFAULT '0' COMMENT '1:Active,0:Deactive',
  `emailVerified` varchar(255) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `authToken` varchar(255) NOT NULL,
  `deviceToken` varchar(255) NOT NULL,
  `firebaseToken` text NOT NULL,
  `firebaseId` text NOT NULL,
  `deviceType` varchar(255) NOT NULL DEFAULT '3' COMMENT '1:IOS, 2:Android,3:Website',
  `rating` float NOT NULL DEFAULT '0',
  `notifcationstatus` enum('on','off') NOT NULL DEFAULT 'on',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Active,0:Inactive',
  `crd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `countryCode`, `contactNo`, `profileImage`, `zipCode`, `bankAccountStatus`, `address`, `latitude`, `longitude`, `helpStatus`, `socialId`, `socialType`, `userType`, `OTP`, `otpVerified`, `emailVerified`, `about`, `authToken`, `deviceToken`, `firebaseToken`, `firebaseId`, `deviceType`, `rating`, `notifcationstatus`, `status`, `crd`, `upd`) VALUES
(1, 'test', 'test', 'test@gmail.com', 'f9iHZw4+6t0sPe9VJp3tdyrlACpZHE8DQP05ivWzFXte4hZyj6llEkZUCz/STL3sY3XiWNfaATn0koOT/FnTXQ==', '+1', '8443517651', '', 'San Antonio, TX, USA', 'no', 'San Antonio, TX, USA', '29.424122', '-98.493628', '0', '', '', 2, 'checked', '1', '1', '', '3b3f2c23dad663f82fb4', 'cc2k7FZ8DBI:APA91bHs4DNvS2VJoOWUzNhkZJkcH4vatznqetKZVU2gQ-tCCJ5vTQl4fdgDBVBNcPiwEenR8EWpsn4C8euY1B8mGqwkG2gvu-YRJa3QPRuOicYhIkJ-qON5C5NHwCXYqN6kEb8SYyzDfTLKBuaaQYw2rMse6hVDSQ', 'cc2k7FZ8DBI:APA91bHs4DNvS2VJoOWUzNhkZJkcH4vatznqetKZVU2gQ-tCCJ5vTQl4fdgDBVBNcPiwEenR8EWpsn4C8euY1B8mGqwkG2gvu-YRJa3QPRuOicYhIkJ-qON5C5NHwCXYqN6kEb8SYyzDfTLKBuaaQYw2rMse6hVDSQ', 'YBOyXJS1eiXlBPT0FzQ0v96ifd53', '2', 0, 'on', 1, '2018-07-09 13:08:33', '2018-07-09 13:10:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catOfBrand`
--
ALTER TABLE `catOfBrand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paymentDetail`
--
ALTER TABLE `paymentDetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productImages`
--
ALTER TABLE `productImages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `renter`
--
ALTER TABLE `renter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stripeDetail`
--
ALTER TABLE `stripeDetail`
  ADD PRIMARY KEY (`srtripeId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `catOfBrand`
--
ALTER TABLE `catOfBrand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paymentDetail`
--
ALTER TABLE `paymentDetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productImages`
--
ALTER TABLE `productImages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `renter`
--
ALTER TABLE `renter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stripeDetail`
--
ALTER TABLE `stripeDetail`
  MODIFY `srtripeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
