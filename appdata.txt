-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2012 at 04:21 PM
-- Server version: 5.1.53
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `appdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_users`
--

CREATE TABLE IF NOT EXISTS `active_users` (
  `active_user_database_key` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `active_user_id` int(10) unsigned NOT NULL,
  `active_user_ip_address` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `active_user_session_start_datetime` datetime NOT NULL,
  KEY `active_user_database_key` (`active_user_database_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_key` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `client_database_key` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `modules_installed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `client_max_users_allowed` bigint(20) unsigned NOT NULL,
  `client_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `client_logo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `client_date_created` datetime NOT NULL,
  `client_subscription_valid` tinyint(1) NOT NULL,
  `client_payed_subscriptions` bigint(20) unsigned NOT NULL,
  `client_subscription_valid_till` date NOT NULL,
  `client_note` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `client_database_key` (`client_database_key`),
  UNIQUE KEY `client_key` (`client_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_key`, `client_database_key`, `modules_installed`, `client_max_users_allowed`, `client_name`, `client_email`, `client_logo`, `client_date_created`, `client_subscription_valid`, `client_payed_subscriptions`, `client_subscription_valid_till`, `client_note`) VALUES
(1, 'company.name', 'd7069f67c14802b497d4406c169349ab', 0, 5, 'Client name', 'client.email@domain.com', '', '2012-01-12 12:20:49', 1, 1, '2012-12-31', 'This is client note'),
(16, 'nova.firma', '53d61a0b524eef1ec3768c14d76dad2b', 0, 5, 'Ime Nove Firme', 'client_-la@emaildomain.om', '', '2012-02-23 00:00:00', 1, 1, '2012-12-31', 'This is client creation note');

-- --------------------------------------------------------

--
-- Table structure for table `client_modules`
--

CREATE TABLE IF NOT EXISTS `client_modules` (
  `client_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `module_active` tinyint(1) NOT NULL,
  `module_public` tinyint(3) unsigned NOT NULL,
  KEY `client_key` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `client_modules`
--

INSERT INTO `client_modules` (`client_id`, `module_id`, `module_active`, `module_public`) VALUES
(16, 1, 1, 0),
(16, 2, 1, 0),
(16, 3, 1, 0),
(16, 4, 1, 0),
(16, 7, 1, 1),
(16, 6, 1, 1),
(16, 5, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `module_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `module_deployed` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `name` (`module_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name`, `module_deployed`) VALUES
(1, 'users', 1),
(2, 'privileges', 1),
(3, 'customers', 1),
(4, 'storage', 1),
(5, 'employees', 1),
(6, 'config', 1),
(7, 'desktop', 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_actions`
--

CREATE TABLE IF NOT EXISTS `module_actions` (
  `module_action_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(11) unsigned NOT NULL,
  `module_action_name` varchar(20) NOT NULL,
  `module_action_crud` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`module_action_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `module_actions`
--

INSERT INTO `module_actions` (`module_action_id`, `module_id`, `module_action_name`, `module_action_crud`) VALUES
(1, 1, 'create', 0),
(2, 1, 'update', 0),
(3, 2, 'create', 0),
(4, 2, 'update', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_answers`
--

CREATE TABLE IF NOT EXISTS `ticket_answers` (
  `question_id` bigint(20) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `admin_id` int(10) unsigned NOT NULL,
  `answer` text COLLATE utf8_unicode_ci NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`question_id`,`user_id`),
  KEY `admin_id` (`admin_id`),
  FULLTEXT KEY `answer` (`answer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_questions`
--

CREATE TABLE IF NOT EXISTS `ticket_questions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_key` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `question` text COLLATE utf8_unicode_ci NOT NULL,
  `priority` enum('low','mid','high') COLLATE utf8_unicode_ci NOT NULL,
  `can_other_user_answer` tinyint(4) NOT NULL,
  `ticket_answered` tinyint(4) NOT NULL,
  `creation_date` datetime NOT NULL,
  `solved` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`,`user_id`),
  FULLTEXT KEY `question` (`question`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
