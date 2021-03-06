-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 16, 2013 at 11:07 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `53d61a0b524eef1ec3768c14d76dad2b`
--
CREATE DATABASE IF NOT EXISTS `53d61a0b524eef1ec3768c14d76dad2b` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `53d61a0b524eef1ec3768c14d76dad2b`;

-- --------------------------------------------------------

--
-- Table structure for table `acg`
--

CREATE TABLE IF NOT EXISTS `acg` (
  `acg_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `acg_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `acg_created_user_id` mediumint(8) unsigned NOT NULL,
  `acg_global_access` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`acg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acg`
--

INSERT INTO `acg` (`acg_id`, `acg_name`, `acg_created_user_id`, `acg_global_access`) VALUES
(1, 'Test', 1, 255);

-- --------------------------------------------------------

--
-- Table structure for table `acgl`
--

CREATE TABLE IF NOT EXISTS `acgl` (
  `acg_id` smallint(5) unsigned NOT NULL,
  `module_id` smallint(5) unsigned NOT NULL,
  `action_id` smallint(5) unsigned NOT NULL,
  `access` tinyint(3) unsigned NOT NULL,
  KEY `acg_id` (`acg_id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acgl`
--

INSERT INTO `acgl` (`acg_id`, `module_id`, `action_id`, `access`) VALUES
(1, 1, 1, 1),
(1, 2, 1, 1),
(1, 1, 2, 1),
(1, 2, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `acl`
--

CREATE TABLE IF NOT EXISTS `acl` (
  `user_id` mediumint(8) unsigned NOT NULL,
  `module_id` smallint(5) unsigned NOT NULL,
  `action_id` smallint(5) unsigned NOT NULL,
  `access` tinyint(3) unsigned NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `module_id` (`module_id`),
  KEY `action_id` (`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `customer_code` int(10) unsigned NOT NULL,
  `customer_sales_type` tinyint(3) unsigned NOT NULL,
  `customer_tax_enabled` tinyint(3) unsigned NOT NULL,
  `customer_vat_value` tinyint(3) unsigned NOT NULL,
  `customer_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `customer_telephone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customer_telephone2` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customer_mobile` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customer_mobile2` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customer_contact_person` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customer_country` int(10) unsigned NOT NULL,
  `customer_zip_code` int(8) unsigned NOT NULL,
  `customer_city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customer_address` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `customer_email_address` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `customer_company_number` int(10) unsigned NOT NULL,
  `customer_company_vat_number` int(10) unsigned NOT NULL,
  `customer_company_tax_number` int(10) unsigned NOT NULL,
  `customer_since` date NOT NULL,
  `customer_bank_account` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `customer_bank_account2` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `customer_bank_account3` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `customer_currency` tinyint(3) unsigned NOT NULL,
  `customer_credit_limit` decimal(20,4) NOT NULL,
  `customer_credit_status` tinyint(3) unsigned NOT NULL,
  `customer_note` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_code`, `customer_sales_type`, `customer_tax_enabled`, `customer_vat_value`, `customer_name`, `customer_telephone`, `customer_telephone2`, `customer_mobile`, `customer_mobile2`, `customer_contact_person`, `customer_country`, `customer_zip_code`, `customer_city`, `customer_address`, `customer_email_address`, `customer_company_number`, `customer_company_vat_number`, `customer_company_tax_number`, `customer_since`, `customer_bank_account`, `customer_bank_account2`, `customer_bank_account3`, `customer_currency`, `customer_credit_limit`, `customer_credit_status`, `customer_note`) VALUES
(1, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-17', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(2, 1, 3, 0, 0, 'First Customer Name 1', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person 1', 1, 11000, 'Belgrade', 'Customer Address 1', 'email@customer.com', 9844456, 323493, 242342, '2012-01-17', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(3, 1, 1, 0, 0, 'First Customer Name 2', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person 2', 1, 11000, 'Belgrade', 'Customer Address 2', 'email@customer.com', 9844456, 323493, 242342, '2012-01-17', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(4, 1, 1, 0, 0, 'First Customer Name 3', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person 3', 1, 11000, 'Belgrade', 'Customer Address 3', 'email@customer.com', 9844456, 323493, 242342, '2012-01-17', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(5, 1, 3, 0, 0, 'First Customer Name 4', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person 4', 1, 11000, 'Belgrade', 'Customer Address 4', 'email@customer.com', 9844456, 323493, 242342, '2012-01-17', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(6, 1, 1, 0, 0, 'First Customer Name 5', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person 5', 1, 11000, 'Belgrade', 'Customer Address 5', 'email@customer.com', 9844456, 323493, 242342, '2012-01-17', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(7, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(8, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 0, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '0.0000', 0, 'This is customer note'),
(9, 1, 3, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(10, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(11, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(12, 1, 2, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(13, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(14, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(15, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(16, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(17, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(18, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(19, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(20, 1, 1, 0, 0, 'First Customer Name', '55430296420', '55430296420', '020349204829348', '', 'Promena Kontakt osobe', 0, 0, 'Sarajevo', 'Address at bosna', 'email@bosna.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '0.0000', 0, 'This is customer note'),
(21, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(22, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(23, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(24, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(25, 1, 1, 0, 0, 'First Customer Name', '022-223-556', '022-223-556', '064-665-222', '', 'Customer Contact Person', 1, 11000, 'Belgrade', 'Customer Address', 'email@customer.com', 9844456, 323493, 242342, '2012-01-20', '987222332321421', '233123245435324', '', 0, '20000.0000', 1, 'This is customer note'),
(26, 0, 1, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(27, 0, 2, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(28, 0, 0, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(29, 0, 0, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(30, 0, 0, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(31, 0, 0, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(32, 0, 0, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(33, 0, 1, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(34, 0, 0, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(35, 0, 1, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(36, 0, 0, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(37, 0, 0, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(38, 0, 0, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(39, 0, 0, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(40, 0, 1, 0, 0, '0', '0', '0', '0', '0', '0', 0, 0, '0', '0', '0', 0, 0, 0, '0000-00-00', '0', '0', '0', 0, '0.0000', 0, '0'),
(41, 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', '', 0, 0, 0, '0000-00-00', '', '', '', 0, '0.0000', 0, ''),
(42, 4294967295, 1, 0, 0, '9023494809284', '084294802', '084294802', '8942308490', '284092', '84092', 0, 0, 'Beigrad', 'adresa ulica', 'email@email.com', 3284789, 4294967295, 2874328937, '0000-00-00', '2384798278982437298748972', '8273947239874', '98274892347', 0, '0.0000', 0, 'napomena'),
(43, 4294967295, 1, 0, 0, '89798789798', '79', '79', '8789789789', '7897', '78979', 0, 0, '', '', '', 0, 0, 0, '0000-00-00', '', '', '', 0, '0.0000', 0, ''),
(44, 4294967295, 1, 0, 0, '89798789798', '79', '79', '8789789789', '7897', '78979', 0, 0, '89789789789', '9878978979283', '98789279', 8789, 78979823, 79273498, '0000-00-00', '8908', '09809', '82034809', 0, '0.0000', 0, '9893080932809'),
(45, 4294967295, 1, 0, 18, 'Klijent Promena', '79', '79', '8789789789', '7897', '78979', 1, 0, '89789789789', '9878978979283', '98789279', 8789, 78979823, 79273498, '0000-00-00', '8908', '09809', '82034809', 1, '0.0000', 0, '9893080932809'),
(46, 8348931, 1, 0, 0, 'Crna Gora Klijent', 'u9', 'u9', '8u89', 'u89', 'u', 2, 0, '', '', '', 0, 0, 0, '0000-00-00', '', '', '', 3, '0.0000', 0, ''),
(47, 3224, 1, 0, 0, 'Bosna Klijent', '897389472', '897389472', '98789237498', '8924798', 'Kontakt osoba klijenta', 3, 0, 'safsafasf', 'sdaklfjakf', 'enjakds@dakljds.cs', 238947398, 4294967295, 4294967295, '0000-00-00', '324242423', '2423423', '4234234', 4, '0.0000', 0, 'napomena klijenta'),
(48, 3224, 1, 0, 0, 'Novi klijent 2', '897389472 2', '897389472 2', '98789237498', '8924798', 'Kontakt osoba klijenta 2', 0, 0, 'safsafasf', 'sdaklfjakf', 'enjakds@dakljds.cs', 238947398, 4294967295, 4294967295, '0000-00-00', '324242423', '2423423', '4234234', 0, '0.0000', 0, 'napomena klijenta 2');

-- --------------------------------------------------------

--
-- Table structure for table `data_holder`
--

CREATE TABLE IF NOT EXISTS `data_holder` (
  `data_holder_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `data_holder_user_id` int(10) unsigned NOT NULL,
  `data_holder_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`data_holder_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_holder_columns`
--

CREATE TABLE IF NOT EXISTS `data_holder_columns` (
  `data_holder_column_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `data_holder_id` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `data_holder_column_user_id` int(10) unsigned NOT NULL,
  `data_holder_column_position_index` tinyint(3) unsigned NOT NULL,
  `data_holder_column_header_text` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `data_holder_column_data_field` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `data_holder_column_visible` tinyint(3) unsigned NOT NULL,
  `data_holder_column_custom_header_text` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_holder_column_custom_header` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`data_holder_column_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Dumping data for table `data_holder_columns`
--

INSERT INTO `data_holder_columns` (`data_holder_column_id`, `data_holder_id`, `data_holder_column_user_id`, `data_holder_column_position_index`, `data_holder_column_header_text`, `data_holder_column_data_field`, `data_holder_column_visible`, `data_holder_column_custom_header_text`, `data_holder_column_custom_header`) VALUES
(1, 'customersDataHolder', 1, 10, 'city', 'customer_city', 1, 'null', 0),
(2, 'customersDataHolder', 1, 22, 'creditLimit', 'customer_credit_limit', 1, 'null', 0),
(3, 'customersDataHolder', 1, 13, 'companyNumber', 'customer_company_number', 1, 'null', 0),
(4, 'customersDataHolder', 1, 2, 'name', 'customer_name', 1, 'null', 0),
(5, 'customersDataHolder', 1, 18, 'bankAccount', 'customer_bank_account', 1, 'null', 0),
(6, 'customersDataHolder', 1, 23, 'ID', 'customer_id', 0, 'null', 0),
(7, 'customersDataHolder', 1, 16, 'since', 'customer_since', 1, 'Клијент од', 1),
(8, 'customersDataHolder', 1, 11, 'city', 'customer_address', 1, 'null', 0),
(9, 'customersDataHolder', 1, 19, 'bankAccount 2', 'customer_bank_account2', 1, 'Банковни рачун 2', 1),
(10, 'customersDataHolder', 1, 12, 'email', 'customer_email_address', 1, 'null', 0),
(11, 'customersDataHolder', 1, 20, 'bankAccount 3', 'customer_bank_account3', 1, 'Банковни рачун 3', 1),
(12, 'customersDataHolder', 1, 6, 'mobile 2', 'customer_mobile2', 1, 'Телефон 2', 1),
(13, 'customersDataHolder', 1, 17, 'note', 'customer_note', 1, 'null', 0),
(14, 'customersDataHolder', 1, 9, 'zipCode', 'customer_zip_code', 1, 'null', 0),
(15, 'customersDataHolder', 1, 3, 'phone', 'customer_telephone', 1, 'null', 0),
(16, 'customersDataHolder', 1, 21, 'currency', 'customer_currency', 1, 'null', 0),
(17, 'customersDataHolder', 1, 5, 'mobile', 'customer_mobile', 1, 'null', 0),
(18, 'customersDataHolder', 1, 14, 'companyVatNumber', 'customer_company_vat_number', 1, 'null', 0),
(19, 'customersDataHolder', 1, 15, 'companyTaxNumber', 'customer_company_tax_number', 1, 'null', 0),
(20, 'customersDataHolder', 1, 7, 'contactPerson 2', 'customer_contact_person', 1, 'Контакт особа', 1),
(21, 'customersDataHolder', 1, 8, 'country', 'customer_country', 1, 'null', 0),
(22, 'customersDataHolder', 1, 4, 'phone 2', 'customer_telephone2', 1, 'Telefon 2', 1),
(23, 'customersDataHolder', 1, 1, 'type', 'customer_sales_type', 1, 'null', 0),
(24, 'customersDataHolder', 1, 0, 'code', 'customer_code', 1, 'null', 0);

-- --------------------------------------------------------

--
-- Table structure for table `desktop_appearance`
--

CREATE TABLE IF NOT EXISTS `desktop_appearance` (
  `desktop_appearance_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `desktop_appearance_user_id` int(10) unsigned NOT NULL,
  `desktop_appearance_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `desktop_appearance_default` tinyint(3) unsigned NOT NULL,
  `desktop_appearance_icon_size` mediumint(8) unsigned NOT NULL,
  `desktop_appearance_font_size` mediumint(8) unsigned NOT NULL,
  `desktop_appearance_controll_button_size` mediumint(8) unsigned NOT NULL,
  `desktop_appearance_wallpaper_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `desktop_appearance_wallpaper_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desktop_appearance_wallpaper_color` bigint(20) NOT NULL,
  `desktop_appearance_window_background_color` int(10) unsigned NOT NULL,
  `desktop_appearance_window_background_alpha` decimal(2,1) NOT NULL,
  `desktop_appearance_window_border_color` mediumint(8) unsigned NOT NULL,
  `desktop_appearance_window_border_alpha` decimal(2,1) NOT NULL,
  `desktop_appearance_taskbar_position` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `desktop_appearance_taskbar_label_visible` tinyint(3) unsigned NOT NULL,
  `desktop_appearance_taskbar_thickness` mediumint(8) unsigned NOT NULL,
  `desktop_appearance_taskbar_color` int(10) unsigned NOT NULL,
  `desktop_appearance_taskbar_alpha` decimal(2,1) NOT NULL,
  PRIMARY KEY (`desktop_appearance_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `desktop_appearance`
--

INSERT INTO `desktop_appearance` (`desktop_appearance_id`, `desktop_appearance_user_id`, `desktop_appearance_name`, `desktop_appearance_default`, `desktop_appearance_icon_size`, `desktop_appearance_font_size`, `desktop_appearance_controll_button_size`, `desktop_appearance_wallpaper_type`, `desktop_appearance_wallpaper_url`, `desktop_appearance_wallpaper_color`, `desktop_appearance_window_background_color`, `desktop_appearance_window_background_alpha`, `desktop_appearance_window_border_color`, `desktop_appearance_window_border_alpha`, `desktop_appearance_taskbar_position`, `desktop_appearance_taskbar_label_visible`, `desktop_appearance_taskbar_thickness`, `desktop_appearance_taskbar_color`, `desktop_appearance_taskbar_alpha`) VALUES
(4, 1, 'Default Theme', 1, 96, 14, 32, 'image', 'http://hidefwalls.com/wp-content/g/hd-2/at-the-beach-hd-wallpaper-1920x1200.jpg', 0, 16777215, '1.0', 39423, '0.6', 'taskbar-bottom-position', 1, 32, 39423, '1.0'),
(5, 1, 'Pink Theme', 0, 96, 14, 32, '', '0', 0, 16777215, '1.0', 16751052, '1.0', 'taskbar-left-position', 0, 48, 16751052, '1.0'),
(6, 1, 'Green Theme', 0, 96, 14, 32, '', '0', 0, 16773119, '1.0', 26112, '1.0', 'taskbar-top-position', 1, 32, 26112, '1.0');

-- --------------------------------------------------------

--
-- Table structure for table `desktop_icons`
--

CREATE TABLE IF NOT EXISTS `desktop_icons` (
  `desktop_icon_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `desktop_icon_user_id` int(10) unsigned NOT NULL,
  `desktop_icon_x` decimal(20,4) unsigned NOT NULL,
  `desktop_icon_y` decimal(20,4) unsigned NOT NULL,
  `desktop_icon_image_url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `desktop_icon_resource_type` tinyint(3) unsigned NOT NULL,
  `desktop_icon_resource_url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`desktop_icon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `employee_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `employee_economics_id` int(10) unsigned NOT NULL,
  `employee_code` int(10) unsigned NOT NULL,
  `employee_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_gender` tinyint(3) unsigned NOT NULL,
  `employee_birth_date` date NOT NULL,
  `employee_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_social_security_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_personal_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_passport_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_hired` tinyint(3) unsigned NOT NULL,
  `employee_hire_date` date NOT NULL,
  `employee_fire_date` date NOT NULL,
  `employee_title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `employee_personal_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_personal_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `employee_business_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_business_phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_business_phone_extension` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `employee_contract_type` tinyint(3) unsigned NOT NULL,
  `employee_working_scenario_id` tinyint(3) unsigned NOT NULL,
  `employee_note` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`employee_id`),
  KEY `employee_working_scenario_id` (`employee_working_scenario_id`),
  KEY `employee_economics_id` (`employee_economics_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_economics_id`, `employee_code`, `employee_name`, `employee_last_name`, `employee_gender`, `employee_birth_date`, `employee_address`, `employee_social_security_number`, `employee_personal_number`, `employee_passport_number`, `employee_hired`, `employee_hire_date`, `employee_fire_date`, `employee_title`, `employee_personal_email`, `employee_personal_phone`, `employee_business_email`, `employee_business_phone`, `employee_business_phone_extension`, `employee_contract_type`, `employee_working_scenario_id`, `employee_note`) VALUES
(1, 0, 345, 'Test', '', 2, '0000-00-00', '', '', '', '', 0, '0000-00-00', '0000-00-00', '', '', '', '', '', '', 0, 2, 'null'),
(2, 22, 995, 'Novi', 'Test', 1, '0000-00-00', 'Adrea', '4354353535353', '', '', 1, '0000-00-00', '0000-00-00', '', '', '', '', '', '', 2, 1, 'null'),
(3, 27, 888887, '', '', 1, '2012-04-09', '', '', '', '', 0, '2011-12-01', '2012-04-30', '', '', '', '', '', '', 1, 1, 'null'),
(4, 27, 0, 'Ime Zaposlenog', '', 1, '0000-00-00', '', '', '', '', 0, '0000-00-00', '0000-00-00', '', '', '', '', '', '', 0, 1, 'null'),
(5, 24, 45646, '', '', 0, '0000-00-00', '', '', '', '', 0, '0000-00-00', '0000-00-00', '', '', '', '', '', '', 0, 0, 'null'),
(6, 21, 0, '', '', 0, '0000-00-00', '', '', '', '', 0, '0000-00-00', '0000-00-00', '', '', '', '', '', '', 0, 0, 'null');

-- --------------------------------------------------------

--
-- Table structure for table `employees_item_charge_costs`
--

CREATE TABLE IF NOT EXISTS `employees_item_charge_costs` (
  `employee_item_charge_cost_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_item_charge_id` int(10) unsigned NOT NULL,
  `employee_item_charge_amount_spent` decimal(20,4) NOT NULL,
  `employee_item_charge_date` date NOT NULL,
  KEY `employee_item_charge_cost_id` (`employee_item_charge_cost_id`),
  KEY `employee_item_charge_id` (`employee_item_charge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employees_working_scenario`
--

CREATE TABLE IF NOT EXISTS `employees_working_scenario` (
  `employee_working_scenario_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_working_scenario_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`employee_working_scenario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employees_working_scenario`
--

INSERT INTO `employees_working_scenario` (`employee_working_scenario_id`, `employee_working_scenario_name`) VALUES
(1, 'Prvi radni scenarijo'),
(2, 'Drugi radni scenarijo');

-- --------------------------------------------------------

--
-- Table structure for table `employees_working_scenario_details`
--

CREATE TABLE IF NOT EXISTS `employees_working_scenario_details` (
  `employees_working_scenario_day_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employees_working_scenario_id` int(10) unsigned NOT NULL,
  `employees_working_scenario_day` tinyint(3) unsigned NOT NULL,
  `employees_working_scenario_day_type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `employees_working_scenario_day_first_shift` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `employees_working_scenario_day_second_shift` tinyint(3) unsigned NOT NULL,
  `employees_working_scenario_day_third_shift` tinyint(3) unsigned NOT NULL,
  `employees_working_scenario_first_shift_start` bigint(20) unsigned NOT NULL,
  `employees_working_scenario_first_shift_end` bigint(20) unsigned NOT NULL,
  `employees_working_scenario_second_shift_start` bigint(20) unsigned NOT NULL,
  `employees_working_scenario_second_shift_end` bigint(20) unsigned NOT NULL,
  `employees_working_scenario_third_shift_start` bigint(20) unsigned NOT NULL,
  `employees_working_scenario_third_shift_end` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`employees_working_scenario_day_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `employees_working_scenario_details`
--

INSERT INTO `employees_working_scenario_details` (`employees_working_scenario_day_id`, `employees_working_scenario_id`, `employees_working_scenario_day`, `employees_working_scenario_day_type`, `employees_working_scenario_day_first_shift`, `employees_working_scenario_day_second_shift`, `employees_working_scenario_day_third_shift`, `employees_working_scenario_first_shift_start`, `employees_working_scenario_first_shift_end`, `employees_working_scenario_second_shift_start`, `employees_working_scenario_second_shift_end`, `employees_working_scenario_third_shift_start`, `employees_working_scenario_third_shift_end`) VALUES
(1, 1, 5, 1, 1, 0, 0, 540, 1020, 0, 0, 0, 0),
(2, 1, 2, 1, 1, 0, 0, 540, 1020, 0, 0, 0, 0),
(3, 1, 3, 1, 1, 0, 0, 540, 1020, 0, 0, 0, 0),
(4, 1, 1, 1, 1, 0, 0, 540, 1020, 0, 0, 0, 0),
(5, 1, 7, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 1, 4, 1, 1, 0, 0, 540, 1020, 0, 0, 0, 0),
(7, 1, 6, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 2, 3, 1, 1, 0, 0, 420, 900, 0, 0, 0, 0),
(9, 2, 1, 1, 1, 0, 0, 420, 900, 0, 0, 0, 0),
(10, 2, 5, 2, 1, 0, 0, 540, 1145, 0, 0, 0, 0),
(11, 2, 4, 2, 1, 0, 0, 540, 1080, 0, 0, 0, 0),
(12, 2, 6, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 2, 7, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 2, 2, 1, 1, 0, 0, 420, 900, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `employees_work_days`
--

CREATE TABLE IF NOT EXISTS `employees_work_days` (
  `employee_work_day_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_work_sheet_id` int(10) unsigned NOT NULL,
  `employee_work_day_type` tinyint(3) unsigned NOT NULL,
  `employee_work_day_date` date NOT NULL,
  `employee_work_day` tinyint(3) unsigned NOT NULL,
  `employee_work_day_wage` decimal(20,2) NOT NULL,
  `employee_work_day_first_shift` tinyint(3) unsigned NOT NULL,
  `employee_work_day_second_shift` tinyint(3) unsigned NOT NULL,
  `employee_work_day_third_shift` tinyint(3) unsigned NOT NULL,
  `employee_work_day_first_shift_start` bigint(20) unsigned NOT NULL,
  `employee_work_day_first_shift_end` bigint(20) unsigned NOT NULL,
  `employee_work_day_second_shift_start` bigint(20) unsigned NOT NULL,
  `employee_work_day_second_shift_end` bigint(20) unsigned NOT NULL,
  `employee_work_day_third_shift_start` bigint(20) unsigned NOT NULL,
  `employee_work_day_third_shift_end` bigint(20) unsigned NOT NULL,
  `employee_work_day_first_shift_overtime` bigint(20) unsigned NOT NULL,
  `employee_work_day_second_shift_overtime` bigint(20) unsigned NOT NULL,
  `employee_work_day_third_shift_overtime` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`employee_work_day_id`),
  KEY `employee_working_sheet_id` (`employee_work_sheet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=64 ;

--
-- Dumping data for table `employees_work_days`
--

INSERT INTO `employees_work_days` (`employee_work_day_id`, `employee_work_sheet_id`, `employee_work_day_type`, `employee_work_day_date`, `employee_work_day`, `employee_work_day_wage`, `employee_work_day_first_shift`, `employee_work_day_second_shift`, `employee_work_day_third_shift`, `employee_work_day_first_shift_start`, `employee_work_day_first_shift_end`, `employee_work_day_second_shift_start`, `employee_work_day_second_shift_end`, `employee_work_day_third_shift_start`, `employee_work_day_third_shift_end`, `employee_work_day_first_shift_overtime`, `employee_work_day_second_shift_overtime`, `employee_work_day_third_shift_overtime`) VALUES
(1, 1, 4, '2012-05-20', 7, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 3, '2012-05-23', 3, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(3, 1, 2, '2012-04-26', 4, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(4, 1, 5, '2012-05-10', 4, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(5, 1, 1, '2012-04-30', 1, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(6, 1, 3, '2012-05-22', 2, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(7, 1, 4, '2012-05-12', 6, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 1, 1, '2012-05-01', 2, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(9, 1, 1, '2012-05-08', 2, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(10, 1, 1, '2012-04-24', 2, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(11, 1, 1, '2012-04-25', 3, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(12, 1, 4, '2012-05-05', 6, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 1, 4, '2012-04-29', 7, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 1, 4, '2012-05-13', 7, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 1, 1, '2012-05-17', 4, '0.00', 0, 1, 1, 540, 1020, 355, 905, 1115, 170, 0, 0, 0),
(16, 1, 1, '2012-05-02', 3, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(17, 1, 2, '2012-04-27', 5, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(18, 1, 1, '2012-05-04', 5, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(19, 1, 5, '2012-05-11', 5, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(20, 1, 1, '2012-05-03', 4, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(21, 1, 1, '2012-05-18', 5, '0.00', 0, 1, 1, 540, 1020, 500, 1015, 1140, 210, 0, 0, 0),
(22, 1, 1, '2012-04-23', 1, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(23, 1, 4, '2012-05-06', 7, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(24, 1, 1, '2012-05-07', 1, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(25, 1, 4, '2012-04-28', 6, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(26, 1, 1, '2012-05-14', 1, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(27, 1, 1, '2012-05-09', 3, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(28, 1, 1, '2012-05-16', 3, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(29, 1, 3, '2012-05-21', 1, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(30, 1, 1, '2012-05-15', 2, '0.00', 1, 0, 0, 540, 1020, 0, 0, 0, 0, 0, 0, 0),
(31, 1, 4, '2012-05-19', 6, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(32, 2, 1, '2012-06-20', 3, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 150, 0, 0),
(33, 2, 1, '2012-05-23', 3, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 0, 0, 0),
(34, 2, 4, '2012-06-10', 7, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(35, 2, 2, '2012-05-25', 5, '0.00', 1, 0, 0, 540, 1145, 0, 0, 0, 0, 0, 0, 0),
(36, 2, 2, '2012-06-01', 5, '0.00', 1, 0, 0, 540, 1145, 0, 0, 0, 0, 0, 0, 0),
(37, 2, 4, '2012-06-09', 6, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(38, 2, 1, '2012-06-12', 2, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 0, 0, 0),
(39, 2, 1, '2012-06-13', 3, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 0, 0, 0),
(40, 2, 2, '2012-06-14', 4, '0.00', 1, 0, 0, 540, 1080, 0, 0, 0, 0, 0, 0, 0),
(41, 2, 1, '2012-05-21', 1, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 0, 0, 0),
(42, 2, 1, '2012-06-11', 1, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 0, 0, 0),
(43, 2, 4, '2012-06-03', 7, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(44, 2, 1, '2012-06-18', 1, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 245, 0, 0),
(45, 2, 2, '2012-06-21', 4, '0.00', 1, 0, 0, 540, 1080, 0, 0, 0, 0, 0, 0, 0),
(46, 2, 4, '2012-06-02', 6, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(47, 2, 4, '2012-06-17', 7, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(48, 2, 4, '2012-06-16', 6, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(49, 2, 1, '2012-05-22', 2, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 0, 0, 0),
(50, 2, 1, '2012-06-04', 1, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 0, 0, 0),
(51, 2, 2, '2012-06-15', 5, '0.00', 1, 0, 0, 540, 1145, 0, 0, 0, 0, 0, 0, 0),
(52, 2, 2, '2012-06-08', 5, '0.00', 1, 0, 0, 540, 1145, 0, 0, 0, 0, 0, 0, 0),
(53, 2, 2, '2012-05-31', 4, '0.00', 1, 0, 0, 540, 1080, 0, 0, 0, 0, 0, 0, 0),
(54, 2, 2, '2012-05-24', 4, '0.00', 1, 0, 0, 540, 1080, 0, 0, 0, 0, 0, 0, 0),
(55, 2, 1, '2012-06-19', 2, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 295, 0, 0),
(56, 2, 2, '2012-06-07', 4, '0.00', 1, 0, 0, 540, 1080, 0, 0, 0, 0, 0, 0, 0),
(57, 2, 1, '2012-05-28', 1, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 0, 0, 0),
(58, 2, 1, '2012-05-29', 2, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 0, 0, 0),
(59, 2, 4, '2012-05-27', 7, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(60, 2, 1, '2012-06-06', 3, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 0, 0, 0),
(61, 2, 4, '2012-05-26', 6, '0.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(62, 2, 1, '2012-05-30', 3, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 0, 0, 0),
(63, 2, 1, '2012-06-05', 2, '0.00', 1, 0, 0, 420, 900, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee_contract_history`
--

CREATE TABLE IF NOT EXISTS `employee_contract_history` (
  `employee_contract_history_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` mediumint(8) unsigned NOT NULL,
  `employee_contract_event_type` tinyint(3) unsigned NOT NULL,
  `employee_contract_type` tinyint(3) unsigned NOT NULL,
  `employee_contract_start` date NOT NULL,
  `employee_contract_end` date NOT NULL,
  PRIMARY KEY (`employee_contract_history_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employee_economics`
--

CREATE TABLE IF NOT EXISTS `employee_economics` (
  `employee_economics_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_economics_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `employee_daily_wage` decimal(20,4) unsigned NOT NULL,
  `employee_first_shift_hour_wage` decimal(20,4) unsigned NOT NULL,
  `employee_second_shift_hour_wage` decimal(20,4) unsigned NOT NULL,
  `employee_third_shift_hour_wage` decimal(20,4) unsigned NOT NULL,
  `employee_weekly_wage` decimal(20,4) unsigned NOT NULL,
  `employee_monthly_wage` decimal(20,4) unsigned NOT NULL,
  `employee_first_shift_hour_overtime_wage` decimal(20,4) unsigned NOT NULL,
  `employee_second_shift_hour_overtime_wage` decimal(20,4) unsigned NOT NULL,
  `employee_third_shift_hour_overtime_wage` decimal(20,4) unsigned NOT NULL,
  `employee_business_phone_limit` decimal(20,4) unsigned NOT NULL,
  `employee_gas_limit` decimal(20,4) unsigned NOT NULL,
  `employee_car_amortisation` decimal(20,4) unsigned NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`employee_economics_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `employee_economics`
--

INSERT INTO `employee_economics` (`employee_economics_id`, `employee_economics_name`, `employee_daily_wage`, `employee_first_shift_hour_wage`, `employee_second_shift_hour_wage`, `employee_third_shift_hour_wage`, `employee_weekly_wage`, `employee_monthly_wage`, `employee_first_shift_hour_overtime_wage`, `employee_second_shift_hour_overtime_wage`, `employee_third_shift_hour_overtime_wage`, `employee_business_phone_limit`, `employee_gas_limit`, `employee_car_amortisation`) VALUES
(21, 'Obezbedjenje', '400.0000', '300.0000', '0.0000', '0.0000', '4556.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000'),
(22, 'Spremacica Dva', '0.0000', '589.8800', '0.0000', '345.0000', '34.0000', '456.0000', '54546.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000'),
(23, 'Direktor', '80.0000', '345.0000', '345.0000', '560.0000', '456.0000', '456.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000'),
(24, 'Ekonomika 24', '350.0000', '0.0000', '256.0000', '0.0000', '456.0000', '100.2300', '345.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000'),
(25, 'Ekonomika Promena', '0.0000', '0.0000', '567.0000', '456.0000', '456.0000', '345.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000'),
(26, 'Nova Ekonomika', '300.0000', '400.0000', '100.0000', '200.0000', '12000.0000', '500.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000'),
(27, 'Glavni Direktor', '14005.0000', '0.0000', '1000.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000'),
(28, 'dodato', '100.0000', '232.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000');

-- --------------------------------------------------------

--
-- Table structure for table `employee_item_charges`
--

CREATE TABLE IF NOT EXISTS `employee_item_charges` (
  `employee_item_charge_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) unsigned NOT NULL,
  `employee_item_charged` tinyint(3) unsigned NOT NULL,
  `employee_item_charge_storage_id` int(10) unsigned NOT NULL,
  `employee_item_charge_item_id` int(10) unsigned NOT NULL,
  `employee_item_charge_type` tinyint(3) unsigned NOT NULL,
  `employee_item_charge_description` text COLLATE utf8_unicode_ci NOT NULL,
  `employee_item_charge_monthly_value` decimal(20,4) NOT NULL,
  `employee_item_charge_start_date` date NOT NULL,
  PRIMARY KEY (`employee_item_charge_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employee_work_sheet`
--

CREATE TABLE IF NOT EXISTS `employee_work_sheet` (
  `employee_work_sheet_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) unsigned NOT NULL,
  `employee_work_sheet_date_start` date NOT NULL,
  `employee_work_sheet_date_end` date NOT NULL,
  `employee_work_sheet_work_time_total` bigint(20) unsigned NOT NULL,
  `employee_work_sheet_business_trip_time_total` bigint(20) unsigned NOT NULL,
  `employee_work_sheet_sick_time_total` bigint(20) unsigned NOT NULL,
  `employee_work_sheet_work_overtime_total` bigint(20) unsigned NOT NULL,
  `employee_work_sheet_first_shift_time_total` mediumint(8) unsigned NOT NULL,
  `employee_work_sheet_second_shift_time_total` mediumint(8) unsigned NOT NULL,
  `employee_work_sheet_third_shift_time_total` mediumint(8) unsigned NOT NULL,
  `employee_work_sheet_first_shift_overtime_total` mediumint(8) unsigned NOT NULL,
  `employee_work_sheet_second_shift_overtime_total` mediumint(8) unsigned NOT NULL,
  `employee_work_sheet_third_shift_overtime_total` mediumint(8) unsigned NOT NULL,
  `employee_work_sheet_num_days_total` int(11) NOT NULL,
  `employee_work_sheet_work_days_total` mediumint(8) unsigned NOT NULL,
  `employee_work_sheet_business_trip_days_total` mediumint(8) unsigned NOT NULL,
  `employee_work_sheet_sick_days_total` mediumint(8) unsigned NOT NULL,
  `employee_work_sheet_vacation_days_total` int(10) unsigned NOT NULL,
  `employee_work_sheet_not_working_days_total` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`employee_work_sheet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employee_work_sheet`
--

INSERT INTO `employee_work_sheet` (`employee_work_sheet_id`, `employee_id`, `employee_work_sheet_date_start`, `employee_work_sheet_date_end`, `employee_work_sheet_work_time_total`, `employee_work_sheet_business_trip_time_total`, `employee_work_sheet_sick_time_total`, `employee_work_sheet_work_overtime_total`, `employee_work_sheet_first_shift_time_total`, `employee_work_sheet_second_shift_time_total`, `employee_work_sheet_third_shift_time_total`, `employee_work_sheet_first_shift_overtime_total`, `employee_work_sheet_second_shift_overtime_total`, `employee_work_sheet_third_shift_overtime_total`, `employee_work_sheet_num_days_total`, `employee_work_sheet_work_days_total`, `employee_work_sheet_business_trip_days_total`, `employee_work_sheet_sick_days_total`, `employee_work_sheet_vacation_days_total`, `employee_work_sheet_not_working_days_total`) VALUES
(1, 4, '2012-04-23', '2012-05-23', 8790, 960, 1440, 0, 10080, 1065, 1005, 0, 0, 0, 31, 16, 2, 3, 2, 8),
(2, 4, '2012-05-21', '2012-06-21', 7200, 5120, 0, 2165, 12320, 0, 0, 690, 0, 0, 32, 15, 9, 0, 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `storages`
--

CREATE TABLE IF NOT EXISTS `storages` (
  `storage_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `storage_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `storage_type` tinyint(3) unsigned NOT NULL,
  `storage_address` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`storage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `storage_contents`
--

CREATE TABLE IF NOT EXISTS `storage_contents` (
  `storage_id` mediumint(8) unsigned NOT NULL,
  `storage_item_id` int(10) unsigned NOT NULL,
  `storage_item_amount` decimal(20,4) NOT NULL,
  `storage_item_price` decimal(20,4) NOT NULL,
  KEY `storage_id` (`storage_id`),
  KEY `storage_item_id` (`storage_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `storage_items`
--

CREATE TABLE IF NOT EXISTS `storage_items` (
  `storage_item_id` int(10) unsigned NOT NULL,
  `storage_item_code` mediumint(8) unsigned NOT NULL,
  `storage_item_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `storage_item_descrition` text COLLATE utf8_unicode_ci NOT NULL,
  `storage_item_category` tinyint(3) unsigned NOT NULL,
  `storage_item_order_quantity` mediumint(8) unsigned NOT NULL,
  `storage_item_volume` decimal(20,4) NOT NULL,
  `storage_item_weight` decimal(20,4) NOT NULL,
  `storage_item_type` tinyint(3) unsigned NOT NULL,
  `storage_item_unit_of_measure` tinyint(3) unsigned NOT NULL,
  `storage_item_display_decimal` tinyint(3) unsigned NOT NULL,
  `storage_item_bar_code` int(10) unsigned NOT NULL,
  `storage_item_tax_percent` tinyint(3) unsigned NOT NULL,
  KEY `storage_item_id` (`storage_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `storage_item_categories`
--

CREATE TABLE IF NOT EXISTS `storage_item_categories` (
  `storage_item_category_id` mediumint(8) unsigned NOT NULL,
  `storage_item_category_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `storage_item_category_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `storage_item_category_type` tinyint(3) unsigned NOT NULL,
  KEY `storage_item_category_id` (`storage_item_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_acg_id` tinyint(3) unsigned NOT NULL,
  `user_type` tinyint(3) unsigned NOT NULL,
  `user_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_creation_date` datetime NOT NULL,
  `user_gender` tinyint(3) unsigned NOT NULL,
  `user_phone_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_mobile_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_email` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_acg_id`, `user_type`, `user_name`, `user_last_name`, `username`, `password`, `user_creation_date`, `user_gender`, `user_phone_number`, `user_mobile_number`, `user_email`) VALUES
(1, 1, 1, 'Test', 'Test', 'admin', 'a2b353d963105c59669ce43ba2559c42', '0000-00-00 00:00:00', 1, NULL, NULL, 'email@user.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
