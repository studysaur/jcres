-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 25, 2015 at 02:23 AM
-- Server version: 5.5.42-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `reserves`
--
CREATE DATABASE IF NOT EXISTS `reserves` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `reserves`;

-- --------------------------------------------------------

--
-- Table structure for table `active_guests`
--

CREATE TABLE IF NOT EXISTS `active_guests` (
  `ip` varchar(15) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `active_users`
--

CREATE TABLE IF NOT EXISTS `active_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `annual_training`
--

CREATE TABLE IF NOT EXISTS `annual_training` (
  `userid` varchar(30) NOT NULL,
  `type` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `instructor` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banned_users`
--

CREATE TABLE IF NOT EXISTS `banned_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `credits`
--

CREATE TABLE IF NOT EXISTS `credits` (
  `credit_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `location` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL COMMENT 'Type of Function',
  `hours_worked` decimal(4,2) NOT NULL,
  `money_made` decimal(6,2) NOT NULL,
  `remarks` varchar(80) NOT NULL,
  PRIMARY KEY (`credit_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3835 ;

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE IF NOT EXISTS `details` (
  `detail_num` smallint(4) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `detail_type` varchar(80) NOT NULL,
  `detail_location` varchar(50) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `contact` varchar(40) NOT NULL,
  `num_officers` tinyint(4) NOT NULL,
  `officer_1` varchar(25) NOT NULL,
  `officer_2` varchar(25) NOT NULL,
  `officer_3` varchar(25) NOT NULL,
  `officer_4` varchar(25) NOT NULL,
  `officer_5` varchar(25) NOT NULL,
  `officer_6` varchar(25) NOT NULL,
  `officer_7` varchar(25) NOT NULL,
  `officer_8` varchar(25) NOT NULL,
  `officer_9` varchar(25) NOT NULL,
  `officer_10` varchar(25) NOT NULL,
  `sheet_posted` binary(1) NOT NULL,
  `paid_detail` binary(1) NOT NULL,
  PRIMARY KEY (`detail_num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1433 ;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(80) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=627 ;

-- --------------------------------------------------------

--
-- Table structure for table `Failed_Logins`
--

CREATE TABLE IF NOT EXISTS `Failed_Logins` (
  `date` varchar(40) NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `userid` varchar(32) DEFAULT NULL,
  `userlevel` tinyint(1) unsigned NOT NULL,
  `sort` int(11) NOT NULL,
  `unit_num` varchar(4) DEFAULT NULL,
  `rank` varchar(15) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `phone_home` varchar(12) DEFAULT NULL,
  `phone_work` varchar(12) DEFAULT NULL,
  `phone_cell` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  `probationary` tinyint(1) NOT NULL,
  `photo` varchar(75) NOT NULL DEFAULT 'photo_missing.jpg',
  `display_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `weapon_quals`
--

CREATE TABLE IF NOT EXISTS `weapon_quals` (
  `username` text NOT NULL,
  `officer_name` text NOT NULL,
  `type` enum('Duty','Off-Duty','Backup','Shot Gun','Rifle') NOT NULL,
  `make` text NOT NULL,
  `model` text NOT NULL,
  `serial_num` text NOT NULL,
  `caliber` text NOT NULL,
  `qual_date` date NOT NULL,
  `night_qual_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
