-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 03, 2015 at 07:11 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `last_minute_showings`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(150) NOT NULL,
  `salt` varchar(150) NOT NULL,
  `user_type` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '1=admin',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `iso3_code` char(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `iso3_code`) VALUES
(1, 'United States', 'USA');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(60) NOT NULL,
  `token` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('raj@test.com', 'e9b501a148db54039b13e519b30ea980e4b95757dd03bf64350192be12e96d89', '2015-07-29 08:55:41'),
('rajanikantb@mindfiresolutions.com', '6602ca5a1c9cc970e5f3734fe5ba5f8511bff9e7fd7a9b6828e22f73ee67eb63', '2015-07-30 00:16:25');

-- --------------------------------------------------------

--
-- Table structure for table `posting_agent_info`
--

CREATE TABLE IF NOT EXISTS `posting_agent_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT 'showing agent id',
  `card_full_name` varchar(45) NOT NULL COMMENT 'name on the credit card',
  `card_number` varchar(45) NOT NULL COMMENT 'credit card number',
  `expiry_month` tinyint(4) NOT NULL,
  `expiry_year` year(4) NOT NULL COMMENT 'yyyy format',
  `cvv_number` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `showings`
--

CREATE TABLE IF NOT EXISTS `showings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT 'posting agent id',
  `post_date` date NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expiration_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `house_count` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'value will be from 1 to 10',
  `showing_progress` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=accepted by showing agent, 1=approved by posting agent, 2=rejected by posting agent,  3=completed, 4=waiting for payment, 5=payment done',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=inactive, 1=active, 2=cancelled, 3=expired',
  `showing_user_id` int(11) unsigned NOT NULL COMMENT 'showing agent id',
  `search_criteria` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '0=search by name, 1=everyone, 2=agent rating(1+), 3=agent rating(2+), 4=agent rating(3+), 5=agent rating(4+), 6=agent rating(5)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `showing_agent_info`
--

CREATE TABLE IF NOT EXISTS `showing_agent_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT 'posting agent id',
  `bank_name` varchar(45) NOT NULL,
  `account_name` varchar(45) NOT NULL,
  `routing_number` varchar(45) NOT NULL COMMENT 'Routing/SWIFT/IBAN Number',
  `account_number` varchar(45) NOT NULL,
  `account_type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0=savings, 1=checking',
  `holder_type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0=personal, 1=business',
  `mobile_pin_number` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `showing_houses`
--

CREATE TABLE IF NOT EXISTS `showing_houses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `showing_id` int(11) unsigned NOT NULL,
  `address` varchar(255) NOT NULL,
  `list_price` double(10,4) NOT NULL,
  `MLS_number` varchar(45) NOT NULL,
  `customer_email` varchar(45) NOT NULL,
  `customer_phoner_number` varchar(20) NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `state_country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `country_id`, `name`) VALUES
(1, 1, 'Alabama'),
(2, 1, 'Alaska'),
(3, 1, 'Arizona'),
(4, 1, 'Arkansas'),
(5, 1, 'California'),
(6, 1, 'Colorado'),
(7, 1, 'Connecticut'),
(8, 1, 'Delaware'),
(9, 1, 'Florida'),
(10, 1, 'Georgia'),
(11, 1, 'Hawaii'),
(12, 1, 'Idaho'),
(13, 1, 'Illinois'),
(14, 1, 'Indiana'),
(15, 1, 'Iowa'),
(16, 1, 'Kansas'),
(17, 1, 'Kentucky'),
(18, 1, 'Louisiana'),
(19, 1, 'Maine'),
(20, 1, 'Maryland'),
(21, 1, 'Massachusetts'),
(22, 1, 'Michigan'),
(23, 1, 'Minnesota'),
(24, 1, 'Mississippi'),
(25, 1, 'Missouri'),
(26, 1, 'Montana'),
(27, 1, 'Nebraska'),
(28, 1, 'Nevada'),
(29, 1, 'New Hampshire'),
(30, 1, 'New Jersey'),
(31, 1, 'New Mexico'),
(32, 1, 'New York'),
(33, 1, 'North Carolina'),
(34, 1, 'North Dakota'),
(35, 1, 'Ohio'),
(36, 1, 'Oklahoma'),
(37, 1, 'Oregon'),
(38, 1, 'Pennsylvania'),
(39, 1, 'Rhode Island'),
(40, 1, 'South Carolina'),
(41, 1, 'South Dakota'),
(42, 1, 'Tennessee'),
(43, 1, 'Texas'),
(44, 1, 'Utah'),
(45, 1, 'Vermont'),
(46, 1, 'Virginia'),
(47, 1, 'Washington'),
(48, 1, 'West Virginia'),
(49, 1, 'Wisconsin'),
(50, 1, 'Wyoming');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `country_id` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'For now, default is 1 i.e. USA',
  `state_id` tinyint(3) unsigned NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `license_number` varchar(20) NOT NULL,
  `brokerage_firm_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(150) NOT NULL,
  `salt` varchar(150) NOT NULL,
  `notification_preference` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0=email, 1=text, 2=both',
  `user_type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0=not assigned any type, 1=posting agent, 2=showing agent, 3=posting & showing agent (both)',
  `profile_photo` varchar(45) DEFAULT NULL,
  `personal_bio` text,
  `average_rating` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=inactive, 1=active, 2=cancelled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remember_token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `country_id`, `state_id`, `phone_number`, `license_number`, `brokerage_firm_name`, `email`, `password`, `salt`, `notification_preference`, `user_type`, `profile_photo`, `personal_bio`, `average_rating`, `status`, `created_at`, `updated_at`, `remember_token`) VALUES
(2, 'rajanikant', 'beero', 4, 5, '9658786196', '1234', 'mindfire solutions', 'rajanikantb@mindfiresolutions.com', '$2y$10$cawsfDqWP4w1WK28aYuI5u/7cPg/lQeh8qI6B8668BpZcwSsJSMjO', 'LastShowing123$', 0, 0, NULL, NULL, 0, 1, '2015-07-23 12:37:37', '2015-07-30 07:51:06', 'WOzXzc91x97DeArUqydaQpdernSAcFBuIVIl0rSH6BeiNmGSJEOAcmgRSnTg'),
(3, 'pravasini', 'sahoo', 4, 5, '9658786196', '1234', 'mindfire solutions', 'pravasinis@mindfiresolutions.com', '$2y$10$1ISQcO9Ee2rzaBoPFFkGq.bSYIpVL6qAMG7Ri.5yu2blguGEkhlde', 'LastShowing123$', 0, 0, NULL, NULL, 0, 0, '2015-07-24 01:02:14', '2015-07-24 01:04:40', 'nG5YJK9yIPJZQyc6s2SRchefqAcraV6ujstYO5qOZWAbS8BunPZ4CXjJKCfM'),
(4, 'Rajanikant', 'Beero', 4, 0, '3298732309', '98242423422', 'QWERTY', 'raj@test.com', '$2y$10$RHjGxce8CMmtMk6U3SAQmOkVBmXQSgFxzIy87FkP4TOK6EgMJTYrO', 'LastShowing123$', 0, 0, NULL, NULL, 0, 0, '2015-07-24 02:31:28', '2015-07-28 10:26:35', 'Q0yPREwglb5ESZsjgbc3Gl0Vy03RGY37XiHC1yqfRNc25EKSdqbe1ekvMuti');

-- --------------------------------------------------------

--
-- Table structure for table `user_feedback_rating`
--

CREATE TABLE IF NOT EXISTS `user_feedback_rating` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT 'showing agent id',
  `showing_id` int(11) unsigned NOT NULL,
  `client_show_up` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=no, 2=yes',
  `client_submit_offer` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=no, 2=yes, 3=maybe',
  `client_question` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=no, 2=yes',
  `feedback_comment` text NOT NULL,
  `rating_point` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'rating can be from 1 to 5',
  `rating_comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
