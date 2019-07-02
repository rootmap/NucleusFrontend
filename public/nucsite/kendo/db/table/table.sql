-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2014 at 03:33 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pos_multi`
--

-- --------------------------------------------------------

--
-- Table structure for table `asset`
--

CREATE TABLE IF NOT EXISTS `asset` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(20) NOT NULL,
  `asset_type_id` int(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) NOT NULL,
  `make` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `service_tag` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `asset`
--

INSERT INTO `asset` (`id`, `uid`, `asset_type_id`, `name`, `serial_number`, `make`, `model`, `service_tag`, `date`, `status`) VALUES
(8, 1, 1, 'asesa', 'sadasd', 'sadasdas', 'sadasdas', 'dasdasd', '2014-07-16', 1),
(12, 1, 2, 'Device 1', 'asdsad', 'asdasdasd', 'asdasd', 'sadasdas', '2014-07-16', 1),
(13, 1, 2, 'Device 2', 'asdsad', 'asdasdasd', 'asdasd', 'sadasdas', '2014-07-16', 1),
(14, 1, 2, 'Device 3', 'asdsad', 'asdasdasd', 'asdasd', 'sadasdas', '2014-07-16', 1),
(15, 1, 2, 'Device 4', 'asdsad', 'asdasdasd', 'asdasd', 'sadasdas', '2014-07-16', 1),
(20, 1, 3, 'Ipad 3', '312312312', 'China', 'Ipad 2', 'Ipad 2', '2014-07-16', 1),
(21, 1, 3, 'Ipad 4', '3243243', 'China', 'Ipad 4', 'Ipad 4', '2014-07-16', 1),
(22, 1, 4, 'Shampo', '414480', 'Bhola', 'Unknown', 'Frnd', '2014-07-22', 1),
(23, 1, 4, 'Back Covcer', '414480', '414480', '414480', '414480', '2014-07-26', 1),
(24, 5, 2, 'Iphone 4 S', '414480', 'Back Covcer', 'Back Covcer', 'Back Covcer', '2014-08-18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `asset_type`
--

CREATE TABLE IF NOT EXISTS `asset_type` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `asset_type`
--

INSERT INTO `asset_type` (`id`, `uid`, `name`, `date`, `status`) VALUES
(1, 1, 'Computer', '2014-07-16', 1),
(2, 1, 'Mobile', '2014-07-16', 1),
(3, 1, 'Pad', '2014-07-16', 1),
(4, 1, 'Electronics', '2014-07-16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `barcode`
--

CREATE TABLE IF NOT EXISTS `barcode` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name_code` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `buyback`
--

CREATE TABLE IF NOT EXISTS `buyback` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(20) DEFAULT NULL,
  `cashier_id` int(20) NOT NULL,
  `cid` int(20) DEFAULT NULL,
  `buyback_id` int(20) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `carrier` varchar(255) DEFAULT NULL,
  `imei` varchar(255) DEFAULT NULL,
  `type_color` varchar(255) DEFAULT NULL,
  `gig` varchar(255) DEFAULT NULL,
  `conditions` varchar(255) DEFAULT NULL,
  `price` varchar(25) DEFAULT NULL,
  `payment_method` int(2) DEFAULT NULL,
  `diagnostic` int(2) NOT NULL,
  `work_completed` int(2) NOT NULL,
  `invoice` int(2) NOT NULL,
  `date` date DEFAULT NULL,
  `datetime` varchar(255) NOT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `buyback`
--

INSERT INTO `buyback` (`id`, `uid`, `cashier_id`, `cid`, `buyback_id`, `model`, `carrier`, `imei`, `type_color`, `gig`, `conditions`, `price`, `payment_method`, `diagnostic`, `work_completed`, `invoice`, `date`, `datetime`, `status`) VALUES
(1, 5, 2, 1, 1412200436, 'Ipone 4s', 'AT  T', '35777781023', 'White', 'null', '', '50', 3, 0, 0, 0, '2014-10-01', '2014-10-01 23:54', 1),
(2, 5, 2, 1, 1412201517, 'Ipone 4s', 'AT  T', '35777781023', 'White', 'null', '', '100', 4, 0, 0, 0, '2014-10-02', '2014-10-02 00:12', 1),
(3, 5, 2, 1, 1412208586, 'Ipone 4s', 'AT  T', 'sdfsfdsf', 'White', 'null', '', '100', 3, 0, 0, 0, '2014-10-02', '2014-10-02 02:10', 1),
(4, 5, 2, 1, 1412208636, 'Ipone 4s', 'AT  T', '35777781023', 'White', 'null', '', '100', 4, 0, 0, 0, '2014-10-02', '2014-10-02 02:10', 1),
(5, 5, 2, 1, 1412271670, 'Ipone 4s', 'AT  T', '35777781023', 'White', 'null', '', '10', 3, 0, 0, 0, '2014-10-02', '2014-10-02 19:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cashier`
--

CREATE TABLE IF NOT EXISTS `cashier` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` int(2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cashier`
--

INSERT INTO `cashier` (`id`, `name`, `username`, `password`, `email`, `gender`, `date`, `status`) VALUES
(1, 'Md Fahad Bhuyian', 'cashier', 'e7a4bc4ec90cdbfe6e4eeb06141782fc', 'mdmahamodurzaman@gmail.com', 1, '2014-09-19', 1),
(2, 'Md Fahad Admin', 'admin', '77d5d7b77bb86c84273f770a398a2e2f', 'f.bhuyian@gmail.com', 1, '2014-09-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `checkin`
--

CREATE TABLE IF NOT EXISTS `checkin` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `photo` text,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `checkin`
--

INSERT INTO `checkin` (`id`, `name`, `photo`, `date`, `status`) VALUES
(4, 'iPhone', 'checkin_14033062221.png', '2014-09-30', 1),
(5, 'IPad', 'checkin_14033062602.png', '2014-06-21', 1),
(6, 'IPod', 'checkin_14033062803.png', '2014-06-21', 1),
(7, 'Other', 'checkin_14033062894.png', '2014-06-21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `checkin_network`
--

CREATE TABLE IF NOT EXISTS `checkin_network` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `checkin_network`
--

INSERT INTO `checkin_network` (`id`, `checkin_id`, `name`, `date`, `status`) VALUES
(1, 4, 'AT & T', '2014-06-21', 1),
(2, 4, 'Sprint', '2014-06-21', 1),
(3, 4, 'T-Mobile', '2014-06-21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `checkin_price`
--

CREATE TABLE IF NOT EXISTS `checkin_price` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `barcode` varchar(20) NOT NULL,
  `checkin_id` int(20) DEFAULT NULL,
  `checkin_version_id` int(20) NOT NULL,
  `checkin_problem_id` int(20) NOT NULL,
  `input_by` int(20) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `checkin_price`
--

INSERT INTO `checkin_price` (`id`, `barcode`, `checkin_id`, `checkin_version_id`, `checkin_problem_id`, `input_by`, `name`, `date`, `status`) VALUES
(1, '1411599977', 4, 1, 6, 0, '100', '2014-09-25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `checkin_problem`
--

CREATE TABLE IF NOT EXISTS `checkin_problem` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `checkin_problem`
--

INSERT INTO `checkin_problem` (`id`, `checkin_id`, `name`, `date`, `status`) VALUES
(1, 4, 'Battery Replacement', '2014-06-21', 1),
(2, 4, 'Broken Screen', '2014-10-02', 1),
(3, 4, 'Other', '2014-06-21', 1),
(4, 5, 'Broken Front Camera', '2014-08-26', 1),
(5, 4, 'Broken Microphone', '2014-09-05', 1),
(6, 4, 'Cas', '2014-09-25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `checkin_request`
--

CREATE TABLE IF NOT EXISTS `checkin_request` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(20) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `device_id` int(20) DEFAULT NULL,
  `model_id` int(20) DEFAULT NULL,
  `color_id` int(20) DEFAULT NULL,
  `network_id` int(20) DEFAULT NULL,
  `problem_id` int(20) DEFAULT NULL,
  `warrenty` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `status` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `checkin_request`
--

INSERT INTO `checkin_request` (`id`, `checkin_id`, `first_name`, `last_name`, `email`, `phone`, `device_id`, `model_id`, `color_id`, `network_id`, `problem_id`, `warrenty`, `date`, `status`) VALUES
(21, 1408492951, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 2, 1, 1, 2, '2014-08-20', 1),
(22, 1408756754, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 2, 1, 1, 0, '2014-08-23', 1),
(23, 1408757093, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 2, 1, 1, 0, '2014-08-23', 0),
(24, 1409093762, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 4, 3, 2, 0, '2014-08-27', 0),
(25, 1409095813, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 2, 1, 1, 0, '2014-08-27', 0),
(26, 1409097359, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 4, 3, 2, 0, '2014-08-27', 0),
(28, 1410205675, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 4, 3, 5, 0, '2014-09-08', 1),
(30, 1412063315, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 4, 3, 2, 0, '2014-09-30', 1),
(32, 1412064036, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 4, 3, 2, 0, '2014-09-30', 1),
(33, 1412193185, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 4, 3, 2, 0, '2014-10-01', 0),
(34, 1412205981, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 4, 3, 2, 0, '2014-10-02', 0),
(35, 1412206137, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 4, 3, 5, 0, '2014-10-02', 0),
(36, 1412206161, 'Md Mahamodur Zaman', 'Bhuyian', 'contact@amsitsoft.com', '01927608261', 4, 1, 4, 3, 2, 0, '2014-10-02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `checkin_request_ticket`
--

CREATE TABLE IF NOT EXISTS `checkin_request_ticket` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `cid` int(20) NOT NULL,
  `checkin_id` int(20) NOT NULL,
  `uid` int(20) NOT NULL,
  `work_approved` int(1) DEFAULT NULL,
  `diagnostic` int(2) NOT NULL,
  `invoice` int(2) NOT NULL,
  `work_completed` int(2) NOT NULL,
  `type_color` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `imei` varchar(255) DEFAULT NULL,
  `even_been` int(1) DEFAULT NULL,
  `tested_before` varchar(255) DEFAULT NULL,
  `dented` int(1) DEFAULT NULL,
  `previously_repaired` int(1) DEFAULT NULL,
  `broken_home` int(1) DEFAULT NULL,
  `broken_volume` int(1) DEFAULT NULL,
  `broken_vibrate` int(1) DEFAULT NULL,
  `broken_charge_port` int(1) DEFAULT NULL,
  `broken_headphone` int(1) DEFAULT NULL,
  `broken_digitizer` int(1) DEFAULT NULL,
  `broken_ear_speaker` int(1) DEFAULT NULL,
  `broken_microphone` int(1) DEFAULT NULL,
  `broken_proximity` int(1) DEFAULT NULL,
  `broken_wifi` int(1) DEFAULT NULL,
  `broken_back_camera` int(1) DEFAULT NULL,
  `broken_front_camera` int(1) DEFAULT NULL,
  `tested_after` varchar(255) DEFAULT NULL,
  `tech_notes` varchar(255) DEFAULT NULL,
  `lcdstatus` int(2) NOT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `checkin_request_ticket`
--

INSERT INTO `checkin_request_ticket` (`id`, `cid`, `checkin_id`, `uid`, `work_approved`, `diagnostic`, `invoice`, `work_completed`, `type_color`, `password`, `imei`, `even_been`, `tested_before`, `dented`, `previously_repaired`, `broken_home`, `broken_volume`, `broken_vibrate`, `broken_charge_port`, `broken_headphone`, `broken_digitizer`, `broken_ear_speaker`, `broken_microphone`, `broken_proximity`, `broken_wifi`, `broken_back_camera`, `broken_front_camera`, `tested_after`, `tech_notes`, `lcdstatus`, `date`, `status`) VALUES
(1, 1, 0, 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2014-08-19', 1),
(2, 1, 0, 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2014-08-19', 1),
(3, 1, 0, 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2014-08-19', 1),
(4, 1, 1408397314, 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2014-08-19', 1),
(5, 1, 1408397314, 5, 1, 0, 0, 0, 'White', 'asd123', '35777781023', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '2014-08-19', 1),
(6, 1, 1408477067, 5, 1, 1, 0, 0, 'White', 'asd123', '35777781023', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'I Have Been Facing Serious Virus Problem', 0, '2014-08-19', 1),
(7, 1, 1408490414, 8, 0, 0, 0, 1, NULL, 'asd123', '35777781023', 0, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '2014-08-20', 1),
(8, 1, 1408492951, 5, 0, 0, 0, 0, NULL, 'asd123', '35777781023', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '2014-08-20', 0),
(9, 1, 1408756754, 5, 0, 0, 0, 0, NULL, 'asd123', '35777781023', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '2014-08-23', 1),
(10, 1, 1408757093, 5, 0, 0, 0, 0, NULL, 'F@h@d555ooo', '35777781023', 0, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '2014-08-23', 1),
(11, 1, 1409093762, 5, 0, 0, 0, 0, NULL, 'F@h@d555ooo', '35777781023', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '2014-08-27', 1),
(12, 1, 1409095813, 5, 0, 0, 0, 0, NULL, 'asd123', '35777781023', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '2014-08-27', 1),
(13, 1, 1409097359, 5, 0, 0, 0, 0, NULL, 'asd123', '35777781023', 0, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '2014-08-27', 1),
(14, 1, 1409442143, 5, 0, 0, 0, 0, NULL, 'F@h@d555ooo', '35777781023', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '2014-08-31', 1),
(15, 1, 1410205675, 5, 0, 0, 0, 0, NULL, 'asd123', '35777781023', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '2014-09-08', 1),
(16, 1, 1410208131, 5, 0, 0, 0, 0, NULL, 'asd123', '35777781023', 0, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '2014-09-08', 1),
(17, 1, 1412060771, 5, 1, 0, 0, 0, NULL, 'asd123', '35777781023', 0, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'I Have Been Facing Serious Virus Problem', 1, '2014-09-30', 1),
(18, 1, 1412063315, 5, 0, 0, 0, 0, NULL, 'asd123', '35777781023', 0, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 1, '2014-09-30', 1),
(19, 1, 1412063982, 5, 0, 0, 0, 0, NULL, 'F@h@d555ooo', 'sdfsfdsf', 0, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 2, '2014-09-30', 1),
(20, 1, 1412064036, 5, 0, 0, 0, 0, NULL, 'asd123', 'sdfsfdsf', 0, 'sdfsdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 2, '2014-09-30', 1),
(21, 1, 1412193185, 5, 0, 0, 0, 0, NULL, 'asd123', '35777781023', 0, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 1, '2014-10-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `checkin_version`
--

CREATE TABLE IF NOT EXISTS `checkin_version` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `checkin_version`
--

INSERT INTO `checkin_version` (`id`, `checkin_id`, `name`, `date`, `status`) VALUES
(1, 4, '5S', '2014-06-21', 1),
(2, 4, '5C', '2014-06-21', 1),
(3, 4, '5', '2014-06-21', 1),
(4, 4, '4S', '2014-06-21', 1),
(5, 4, '4', '2014-06-21', 1),
(6, 4, '3GS', '2014-06-21', 1),
(7, 4, '3G', '2014-06-21', 1),
(8, 5, 'Mini Retina', '2014-06-21', 1),
(9, 5, 'Mini', '2014-06-21', 1),
(10, 5, 'Air', '2014-06-21', 1),
(11, 5, '4', '2014-06-21', 1),
(12, 5, '3', '2014-06-21', 1),
(13, 5, '2', '2014-06-21', 1),
(14, 5, '1', '2014-06-21', 1),
(15, 6, '4th Generation', '2014-06-21', 1),
(16, 6, '3th Generation', '2014-06-21', 1),
(17, 6, '2th Generation', '2014-06-21', 1),
(18, 7, 'Other', '2014-06-21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `checkin_version_color`
--

CREATE TABLE IF NOT EXISTS `checkin_version_color` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `checkin_id` int(20) DEFAULT NULL,
  `checkin_version_id` int(20) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `checkin_version_color`
--

INSERT INTO `checkin_version_color` (`id`, `checkin_id`, `checkin_version_id`, `name`, `date`, `status`) VALUES
(2, 4, 1, 'Gold', '2014-06-21', 1),
(3, 4, 1, 'Silver', '2014-06-21', 1),
(4, 4, 1, 'Gray', '2014-06-21', 1),
(5, 5, 8, 'Silver', '2014-06-21', 1),
(6, 5, 8, 'Gray', '2014-06-21', 1),
(7, 6, 15, 'Black', '2014-06-21', 1),
(8, 6, 15, 'White', '2014-06-21', 1),
(9, 7, 18, 'Black', '2014-06-21', 1),
(10, 7, 18, 'White', '2014-06-21', 1),
(11, 7, 18, 'Gray', '2014-06-21', 1),
(12, 7, 18, 'Other', '2014-06-21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `check_user_price`
--

CREATE TABLE IF NOT EXISTS `check_user_price` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ckeckin_id` varchar(25) DEFAULT NULL,
  `price` varchar(25) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `check_user_price`
--

INSERT INTO `check_user_price` (`id`, `ckeckin_id`, `price`, `date`, `status`) VALUES
(1, '1408319240', '300', '2014-08-18', 1),
(2, '1408397314', '300', '2014-08-18', 1),
(3, '1408477067', '300', '2014-08-19', 1),
(4, '1408490414', '300', '2014-08-20', 1),
(5, '1408492951', '300', '2014-08-20', 1),
(6, '1408756754', '300', '2014-08-23', 1),
(7, '1408757093', '300', '2014-08-23', 1),
(8, '1409093762', '', '2014-08-27', 1),
(9, '1409095813', '', '2014-08-27', 1),
(10, '1409097359', '40', '2014-08-27', 1),
(11, '1409442143', '', '2014-08-31', 1),
(12, '1410205675', '120', '2014-09-08', 1),
(13, '1410208131', '', '2014-09-08', 1),
(14, '1412060771', '', '2014-09-30', 1),
(15, '1412063315', '100', '2014-09-30', 1),
(16, '1412063982', '', '2014-09-30', 1),
(17, '1412064036', '50', '2014-09-30', 1),
(18, '1412193185', '100', '2014-10-01', 1),
(19, '1412205981', '20', '2014-10-02', 1),
(20, '1412206137', '100', '2014-10-02', 1),
(21, '1412206161', '100', '2014-10-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `date`, `status`) VALUES
(2, 'United States', '2014-08-06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `coustomer`
--

CREATE TABLE IF NOT EXISTS `coustomer` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `phonesms` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `invoice_email` varchar(255) NOT NULL,
  `reffered` varchar(255) DEFAULT NULL,
  `businessname` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postalcode` varchar(255) DEFAULT NULL,
  `input_by` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=126 ;

--
-- Dumping data for table `coustomer`
--

INSERT INTO `coustomer` (`id`, `firstname`, `lastname`, `phone`, `phonesms`, `email`, `invoice_email`, `reffered`, `businessname`, `address1`, `address2`, `city`, `country`, `postalcode`, `input_by`, `date`, `status`) VALUES
(1, 'Md Mahamodur Zaman', 'Bhuyian', '01927608261', '01727565570', 'contact@amsitsoft.com', 'mahamod@amsitsoft.com', NULL, 'AMS IT', 'rrggggs', NULL, NULL, NULL, NULL, 1, NULL, NULL),
(121, 'Mahadi', NULL, NULL, NULL, NULL, '', NULL, 'GG', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(122, 'jkhjk', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(123, 'Orin', NULL, NULL, NULL, NULL, '', NULL, 'AA', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(124, 'Mahbub', NULL, NULL, NULL, 'contact@mahabub.com', '', NULL, 'AMS IT', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(125, 'dd', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE IF NOT EXISTS `gender` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `name`, `date`, `status`) VALUES
(1, 'Male', '2014-09-19', 1),
(2, 'Female', '2014-09-19', 1),
(3, 'Not Want to Mention', '2014-09-19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(20) NOT NULL,
  `cid` int(20) DEFAULT NULL,
  `invoice_creator` int(20) DEFAULT NULL,
  `invoice_date` varchar(20) DEFAULT NULL,
  `due_date` varchar(20) DEFAULT NULL,
  `po_number` varchar(30) DEFAULT NULL,
  `paid` int(2) DEFAULT NULL,
  `paid_date` varchar(20) DEFAULT NULL,
  `ref_number` varchar(20) DEFAULT NULL,
  `tech_notes` text,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `doc_type` int(20) NOT NULL,
  `payment_type` int(20) NOT NULL,
  `checkin_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `invoice_id`, `cid`, `invoice_creator`, `invoice_date`, `due_date`, `po_number`, `paid`, `paid_date`, `ref_number`, `tech_notes`, `date`, `status`, `doc_type`, `payment_type`, `checkin_id`) VALUES
(1, 1412105835, NULL, 21, '30-09-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-30', 1, 3, 0, 0),
(2, 1412105905, 121, 21, '30-09-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-30', 1, 3, 4, 0),
(3, 1412105989, 121, 21, '30-09-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-30', 1, 3, 3, 0),
(4, 1412106495, 122, 21, '30-09-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-30', 1, 3, 3, 0),
(5, 1412106565, 121, 21, '30-09-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-30', 1, 3, 3, 0),
(6, 1412108410, 1, 21, '30-09-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-30', 1, 3, 3, 0),
(7, 1412108728, NULL, 21, '30-09-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-30', 1, 3, 0, 0),
(8, 1412108916, 121, 21, '30-09-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-30', 1, 3, 3, 0),
(9, 1412109245, 121, 21, '30-09-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-30', 1, 3, 4, 0),
(10, 1412109360, 1, 21, '30-09-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-30', 1, 3, 4, 0),
(11, 1412109758, 1, 21, '30-09-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-30', 1, 3, 4, 0),
(12, 1412109899, NULL, 21, '30-09-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-30', 1, 3, 0, 0),
(13, 1412201576, 1, 5, '02-10-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-02', 1, 3, 4, 0),
(14, 1412201597, 1, 5, '02-10-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-02', 1, 3, 0, 0),
(15, 1412204644, 1, 5, '02-10-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-02', 1, 3, 3, 0),
(16, 1412205267, 1, 5, '02-10-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-02', 1, 3, 3, 0),
(17, 1412205850, 1, 5, '02-10-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-02', 1, 3, 3, 0),
(18, 1412208713, 121, 5, '02-10-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-02', 1, 3, 3, 0),
(19, 1412209216, 124, 5, '02-10-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-02', 1, 3, 4, 0),
(20, 1412209456, NULL, 5, '02-10-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-02', 1, 3, 0, 0),
(21, 1412271833, 1, 5, '02-10-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-02', 1, 3, 3, 0),
(22, 1412271870, NULL, 5, '02-10-2014', NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-02', 1, 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE IF NOT EXISTS `invoice_detail` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(20) NOT NULL,
  `invoice_id` int(20) DEFAULT NULL,
  `pid` int(20) DEFAULT NULL,
  `tax` int(2) NOT NULL,
  `quantity` int(20) DEFAULT NULL,
  `single_cost` varchar(20) DEFAULT NULL,
  `totalcost` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `invoice_detail`
--

INSERT INTO `invoice_detail` (`id`, `uid`, `invoice_id`, `pid`, `tax`, `quantity`, `single_cost`, `totalcost`, `date`, `status`) VALUES
(1, 1, 1405115930, 16, 1, 3, '70.00', '210', '2014-07-12', 1),
(4, 1, 1405115930, 2, 0, 1, '119.98', '119.98', '2014-07-12', 1),
(6, 1, 1405115930, 6, 1, 1, '191.99', '191.99', '2014-07-12', 1),
(7, 1, 1405115930, 7, 0, 1, '39.00', '39', '2014-07-12', 1),
(8, 1, 1405115930, 8, 1, 1, '99.00', '99', '2014-07-12', 1),
(9, 1, 1405547421, 17, 1, 2, '74.99', '149.98', '2014-07-16', 1),
(10, 1, 1405547421, 15, 0, 1, '128.66', '128.66', '2014-07-17', 1),
(11, 1, 1405547421, 10, 0, 1, '164.99', '164.99', '2014-07-17', 1),
(12, 1, 1405547421, 6, 0, 1, '191.99', '191.99', '2014-07-17', 1),
(13, 1, 1405547421, 4, 0, 1, '139.99', '139.99', '2014-07-17', 1),
(14, 1, 1405547421, 5, 0, 1, '149.94', '149.94', '2014-07-17', 1),
(15, 1, 1405554112, 17, 0, 1, '74.99', '74.99', '2014-07-17', 1),
(16, 1, 1405554112, 16, 0, 1, '70.00', '70', '2014-07-17', 1),
(17, 1, 1405554112, 13, 0, 1, '79.99', '79.99', '2014-07-17', 1),
(18, 1, 1405554112, 12, 0, 1, '134.99', '134.99', '2014-07-17', 1),
(19, 1, 1405554112, 6, 0, 1, '191.99', '191.99', '2014-07-17', 1),
(20, 1, 1405554112, 2, 0, 1, '119.98', '119.98', '2014-07-17', 1),
(21, 1, 1405554112, 3, 0, 1, '79.99', '79.99', '2014-07-17', 1),
(22, 1, 1405554208, 17, 0, 1, '74.99', '74.99', '2014-07-17', 1),
(23, 1, 1405554208, 16, 0, 1, '70.00', '70', '2014-07-17', 1),
(24, 1, 1405554208, 10, 0, 1, '164.99', '164.99', '2014-07-17', 1),
(25, 1, 1405554208, 3, 0, 2, '79.99', '159.98', '2014-07-17', 1),
(26, 1, 1405554208, 2, 0, 1, '119.98', '119.98', '2014-07-17', 1),
(27, 1, 1405554208, 4, 0, 1, '139.99', '139.99', '2014-07-17', 1),
(28, 1, 1405554316, 17, 0, 1, '74.99', '74.99', '2014-07-17', 1),
(29, 1, 1405554316, 16, 0, 1, '70.00', '70', '2014-07-17', 1),
(30, 1, 1405554316, 10, 0, 1, '164.99', '164.99', '2014-07-17', 1),
(31, 1, 1405554316, 2, 0, 1, '119.98', '119.98', '2014-07-17', 1),
(32, 1, 1405554316, 9, 0, 1, '77.99', '77.99', '2014-07-17', 1),
(33, 1, 1405554316, 7, 0, 1, '39.00', '39', '2014-07-17', 1),
(34, 1, 1405554316, 4, 0, 1, '139.99', '139.99', '2014-07-17', 1),
(35, 0, NULL, NULL, 0, NULL, NULL, NULL, '2014-07-17', 1),
(36, 0, NULL, NULL, 0, NULL, NULL, NULL, '2014-07-17', 1),
(37, 1, 1405554461, 13, 0, 1, '79.99', '79.99', '2014-07-17', 1),
(38, 1, 1405554461, 15, 0, 1, '128.66', '128.66', '2014-07-17', 1),
(39, 1, 1405554461, 10, 0, 1, '164.99', '164.99', '2014-07-17', 1),
(40, 1, 1405554461, 8, 0, 1, '99.00', '99', '2014-07-17', 1),
(41, 1, 1405554461, 5, 0, 1, '149.94', '149.94', '2014-07-17', 1),
(42, 1, 1405554461, 17, 0, 1, '74.99', '74.99', '2014-07-17', 1),
(43, 1, 1405554461, 11, 0, 1, '139.99', '139.99', '2014-07-17', 1),
(44, 1, 1405554461, 14, 0, 1, '63.00', '63', '2014-07-17', 1),
(45, 1, 1405554461, 16, 0, 1, '70.00', '70', '2014-07-17', 1),
(46, 1, 1405554231, 8, 0, 1, '99.00', '99', '2014-07-17', 1),
(47, 1, 1405554231, 3, 0, 1, '79.99', '79.99', '2014-07-17', 1),
(48, 1, 1405554231, 6, 0, 2, '191.99', '383.98', '2014-07-17', 1),
(49, 1, 1405554231, 14, 0, 1, '63.00', '63', '2014-07-17', 1),
(50, 1, 1405554231, 11, 0, 1, '139.99', '139.99', '2014-07-17', 1),
(51, 1, 1405554231, 4, 0, 1, '139.99', '139.99', '2014-07-17', 1),
(52, 1, 1405554739, 16, 0, 3, '70.00', '210', '2014-07-17', 1),
(53, 1, 1405554739, 7, 0, 2, '39.00', '78', '2014-07-17', 1),
(54, 1, 1405554739, 9, 0, 1, '77.99', '77.99', '2014-07-17', 1),
(55, 1, 1405554739, 17, 0, 1, '74.99', '74.99', '2014-07-17', 1),
(56, 1, 1406193227, 13, 0, 2, '79.99', '159.98', '2014-07-24', 1),
(57, 1, 1406193227, 10, 0, 1, '164.99', '164.99', '2014-07-24', 1),
(58, 1, 1406193227, 2, 0, 1, '119.98', '119.98', '2014-07-24', 1),
(59, 1, 1406193227, 7, 0, 1, '39.00', '39', '2014-07-24', 1),
(60, 1, 1406193227, 8, 0, 1, '99.00', '99', '2014-07-24', 1),
(61, 1, 1406193294, 15, 0, 1, '128.66', '128.66', '2014-07-24', 1),
(62, 1, 1406193294, 9, 0, 1, '77.99', '77.99', '2014-07-24', 1),
(63, 1, 1406193294, 6, 0, 1, '191.99', '191.99', '2014-07-24', 1),
(64, 1, 1406193294, 4, 0, 2, '139.99', '279.98', '2014-07-24', 1),
(65, 1, 1407337548, 9, 0, 1, '77.99', '77.99', '2014-08-06', 1),
(66, 1, 1407337548, 2, 0, 1, '119.98', '119.98', '2014-08-06', 1),
(67, 1, 1407337548, 17, 0, 1, '74.99', '74.99', '2014-08-06', 1),
(68, 1, 1407337548, 16, 0, 1, '70.00', '70', '2014-08-06', 1),
(69, 4, 1407395825, 18, 0, 1, '100', '100', '2014-08-07', 1),
(70, 4, 1407395825, 17, 0, 1, '74.99', '74.99', '2014-08-07', 1),
(71, 5, 1409106723, 31, 0, 1, '30', '30', '2014-08-27', 1),
(72, 5, 1409106723, 23, 0, 1, '100', '100', '2014-08-27', 1),
(73, 5, 1409106723, 15, 0, 1, '128.66', '128.66', '2014-08-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payment`
--

CREATE TABLE IF NOT EXISTS `invoice_payment` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `payment_type` int(20) NOT NULL,
  `cid` int(20) DEFAULT NULL,
  `invoice_creator` int(20) DEFAULT NULL,
  `invoice_id` int(20) DEFAULT NULL,
  `amount` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `invoice_payment`
--

INSERT INTO `invoice_payment` (`id`, `payment_type`, `cid`, `invoice_creator`, `invoice_id`, `amount`, `date`, `status`) VALUES
(1, 3, 1, 5, 1412063363, '0', '2014-09-30', 1),
(2, 3, 1, 5, 1412063400, '102', '2014-09-30', 1),
(3, 3, 1, 5, 1412064072, '51', '2014-09-30', 1),
(4, 4, 1, 21, 1412094875, '0', '2014-09-30', 1),
(5, 3, 1, 21, 1412094923, '0', '2014-09-30', 1),
(6, 3, 1, 21, 1412104516, '100', '2014-09-30', 1),
(7, 4, 1, 21, 1412105025, '100', '2014-09-30', 1),
(8, 3, 121, 21, 1412105046, '100', '2014-09-30', 1),
(9, 3, 1, 21, 1412105442, '100', '2014-09-30', 1),
(10, 4, 121, 21, 1412105905, '100', '2014-09-30', 1),
(11, 3, 121, 21, 1412105989, '100', '2014-09-30', 1),
(12, 3, 122, 21, 1412106495, '200', '2014-09-30', 1),
(13, 3, 121, 21, 1412106565, '100', '2014-09-30', 1),
(14, 3, 1, 21, 1412108410, '200', '2014-09-30', 1),
(15, 3, 121, 21, 1412108916, '13', '2014-09-30', 1),
(16, 4, 121, 21, 1412109245, '100', '2014-09-30', 1),
(17, 4, 1, 21, 1412109360, '100', '2014-09-30', 1),
(18, 4, 1, 21, 1412109758, '100', '2014-09-30', 1),
(19, 4, 1, 5, 1412201576, '102', '2014-10-02', 1),
(20, 3, 1, 5, 1412204644, '102', '2014-10-02', 1),
(21, 3, 1, 5, 1412205267, '102', '2014-10-02', 1),
(22, 3, 1, 5, 1412205850, '200', '2014-10-02', 1),
(23, 3, 121, 5, 1412208713, '102', '2014-10-02', 1),
(24, 4, 124, 5, 1412209216, '102', '2014-10-02', 1),
(25, 3, 1, 5, 1412271833, '102', '2014-10-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parts_order`
--

CREATE TABLE IF NOT EXISTS `parts_order` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `part_url` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `cost` varchar(255) DEFAULT NULL,
  `retail_customer` varchar(255) DEFAULT NULL,
  `texable` int(1) DEFAULT NULL,
  `shipping` varchar(255) DEFAULT NULL,
  `trackingnum` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `ordered` varchar(255) DEFAULT NULL,
  `received` varchar(255) DEFAULT NULL,
  `store` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `parts_order`
--

INSERT INTO `parts_order` (`id`, `ticket_id`, `description`, `part_url`, `quantity`, `cost`, `retail_customer`, `texable`, `shipping`, `trackingnum`, `notes`, `ordered`, `received`, `store`, `date`, `status`) VALUES
(8, 1405855361, 'Iphone Camera', 'https://www.facebook.com/kaberi.rahman/about', '2', '2', '5', 1, '44/P,Kazi Bhavan,New Zigatola Road Dhanmondi Dhaka', 'Yes', 'Camera Ic ', '2014-08-10', '2014-08-10', '', '2014-07-26', 1),
(9, 1405551294, 'Iphone Camera', 'https://www.facebook.com/kaberi.rahman/about', '2', '2', '5', 1, '44/P,Kazi Bhavan,New Zigatola Road Dhanmondi Dhaka', 'Yes', 'Camera Ic ', '2014-08-10', '2014-08-10', '', '2014-08-06', 1),
(10, 1406014327, 'Iphone Camera', 'https://www.facebook.com/kaberi.rahman/about', '2', '2', '5', 1, '44/P,Kazi Bhavan,New Zigatola Road Dhanmondi Dhaka', 'Yes', 'Camera Ic ', '2014-08-10', '2014-08-10', '', '2014-08-06', 1),
(11, 1408398046, 'Iphone Camera', 'https://www.facebook.com/kaberi.rahman/about', '2', '15', '23', 1, 'sadsad', 'asdasd', 'asdsad', '2014-08-10', '2014-08-10', 'sdsad', '2014-08-31', 1),
(12, 1409476398, 'Marine Guide Coaching', 'https://www.facebook.com/kaberi.rahman/about', '2', '20', '30', 1, '44/P,Kazi Bhavan,New Zigatola Road Dhanmondi Dhaka', 'Yes', 'Camera Ic', '2014-08-10', '2014-08-10', 'AMS IT', '2014-08-31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` int(20) DEFAULT NULL,
  `country` int(1) DEFAULT NULL,
  `phone` int(20) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `subdomain` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `name`, `email`, `image`, `street`, `city`, `state`, `zip`, `country`, `phone`, `website`, `subdomain`, `date`, `status`) VALUES
(3, 'Jazz', 'jfksfsfj@hdhff.com', '', 'down', 'up', 'go', 7200, 1, 1999, 'wwww.com', 'www.bro.com', '2014-06-25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE IF NOT EXISTS `payment_method` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `meth_name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`id`, `meth_name`, `date`, `status`) VALUES
(3, 'Cash', '2014-08-21', 1),
(4, 'Cradit Card', '2014-08-21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payout`
--

CREATE TABLE IF NOT EXISTS `payout` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(20) NOT NULL,
  `cashier_id` int(20) DEFAULT NULL,
  `amount` varchar(29) DEFAULT NULL,
  `reason` text,
  `date` date DEFAULT NULL,
  `datetime` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `payout`
--

INSERT INTO `payout` (`id`, `uid`, `cashier_id`, `amount`, `reason`, `date`, `datetime`, `status`) VALUES
(1, 5, 2, '10', NULL, '2014-10-02', '2014-10-02 19:44', 1),
(2, 5, 2, '-10', NULL, '2014-10-02', '2014-10-02 19:45', 1),
(3, 5, 2, '20', NULL, '2014-10-02', '2014-10-02 21:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_tax`
--

CREATE TABLE IF NOT EXISTS `pos_tax` (
  `id` int(21) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(21) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=188 ;

--
-- Dumping data for table `pos_tax`
--

INSERT INTO `pos_tax` (`id`, `invoice_id`, `date`, `status`) VALUES
(1, 1406417151, '2014-07-27', 1),
(2, 1406474327, '2014-07-27', 1),
(3, 1407174693, '2014-08-04', 0),
(4, 1407183223, '2014-08-04', 1),
(5, 1407225402, '2014-08-05', 0),
(6, 1407246190, '2014-08-05', 1),
(7, 1407246345, '2014-08-05', 0),
(8, 1407363188, '2014-08-07', 1),
(9, 1407671883, '2014-08-10', 1),
(10, 1407972535, '2014-08-14', 0),
(11, 1407982077, '2014-08-14', 0),
(12, 1407982434, '2014-08-14', 1),
(13, 1407983229, '2014-08-14', 0),
(14, 1407983236, '2014-08-14', 0),
(15, 1408294369, '2014-08-17', 0),
(16, 1408294426, '2014-08-17', 0),
(17, 1408366908, '2014-08-18', 0),
(18, 1408399040, '2014-08-18', 0),
(19, 1408399173, '2014-08-18', 0),
(20, 1408399179, '2014-08-18', 0),
(21, 1408399223, '2014-08-19', 1),
(22, 1408573753, '2014-08-21', 0),
(23, 1408574252, '2014-08-21', 1),
(24, 1408580539, '2014-08-21', 0),
(25, 1408727875, '2014-08-22', 1),
(26, 1408736485, '2014-08-22', 1),
(27, 1408742638, '2014-08-22', 1),
(28, 1408752694, '2014-08-23', 0),
(29, 1408752722, '2014-08-23', 0),
(30, 1408752862, '2014-08-23', 0),
(31, 1408752880, '2014-08-23', 0),
(32, 1408752929, '2014-08-23', 0),
(33, 1408752945, '2014-08-23', 1),
(34, 1408753014, '2014-08-23', 0),
(35, 1408754283, '2014-08-23', 1),
(36, 1408754738, '2014-08-23', 1),
(37, 1408756695, '2014-08-23', 1),
(38, 1408821161, '2014-08-23', 0),
(39, 1408822218, '2014-08-23', 1),
(40, 1408822246, '2014-08-23', 1),
(41, 1408822288, '2014-08-23', 0),
(42, 1409056853, '2014-08-26', 0),
(43, 1409095799, '2014-08-27', 0),
(44, 1409095872, '2014-08-27', 0),
(45, 1409097174, '2014-08-27', 0),
(46, 1409097185, '2014-08-27', 0),
(47, 1409097438, '2014-08-27', 0),
(48, 1409101116, '2014-08-27', 0),
(49, 1409101404, '2014-08-27', 0),
(50, 1409101469, '2014-08-27', 0),
(51, 1409102832, '2014-08-27', 0),
(52, 1409102970, '2014-08-27', 0),
(53, 1409103341, '2014-08-27', 0),
(54, 1409103439, '2014-08-27', 0),
(55, 1409103531, '2014-08-27', 0),
(56, 1409103625, '2014-08-27', 0),
(57, 1409104156, '2014-08-27', 0),
(58, 1409104178, '2014-08-27', 0),
(59, 1409104210, '2014-08-27', 0),
(60, 1409104828, '2014-08-27', 0),
(61, 1409105105, '2014-08-27', 0),
(62, 1409105533, '2014-08-27', 0),
(63, 1409105608, '2014-08-27', 0),
(64, 1409105722, '2014-08-27', 0),
(65, 1409105762, '2014-08-27', 0),
(66, 1409105980, '2014-08-27', 0),
(67, 1409106019, '2014-08-27', 0),
(68, 1409106274, '2014-08-27', 0),
(69, 1409106276, '2014-08-27', 0),
(70, 1409106322, '2014-08-27', 0),
(71, 1409106346, '2014-08-27', 0),
(72, 1409106369, '2014-08-27', 0),
(73, 1409107124, '2014-08-27', 0),
(74, 1409107146, '2014-08-27', 0),
(75, 1409173168, '2014-08-27', 0),
(76, 1409175014, '2014-08-27', 0),
(77, 1409175102, '2014-08-27', 0),
(78, 1409175362, '2014-08-27', 0),
(79, 1409175379, '2014-08-27', 0),
(80, 1409442204, '2014-08-31', 0),
(81, 1409442206, '2014-08-31', 0),
(82, 1409442235, '2014-08-31', 0),
(83, 1409490528, '2014-08-31', 0),
(84, 1409490778, '2014-08-31', 0),
(85, 1409490990, '2014-08-31', 0),
(86, 1409491063, '2014-08-31', 0),
(87, 1409491413, '2014-08-31', 0),
(88, 1409493363, '2014-08-31', 0),
(89, 1409493421, '2014-08-31', 0),
(90, 1409493430, '2014-08-31', 0),
(91, 1409493752, '2014-08-31', 0),
(92, 1409493779, '2014-08-31', 0),
(93, 1409493878, '2014-08-31', 0),
(94, 1409493888, '2014-08-31', 0),
(95, 1409494153, '2014-08-31', 0),
(96, 1409494162, '2014-08-31', 0),
(97, 1409494240, '2014-08-31', 0),
(98, 1409494249, '2014-08-31', 0),
(99, 1409494318, '2014-08-31', 0),
(100, 1409494328, '2014-08-31', 0),
(101, 1409494496, '2014-08-31', 0),
(102, 1409494516, '2014-08-31', 0),
(103, 1409494559, '2014-08-31', 0),
(104, 1409494575, '2014-08-31', 0),
(105, 1409494636, '2014-08-31', 0),
(106, 1409494646, '2014-08-31', 0),
(107, 1409494709, '2014-08-31', 0),
(108, 1409494718, '2014-08-31', 0),
(109, 1409676367, '2014-09-02', 0),
(110, 1409934926, '2014-09-05', 0),
(111, 1409935023, '2014-09-05', 0),
(112, 1409935045, '2014-09-05', 0),
(113, 1409936676, '2014-09-05', 0),
(114, 1409936704, '2014-09-05', 0),
(115, 1410037413, '2014-09-06', 1),
(116, 1410037470, '2014-09-06', 0),
(117, 1410037492, '2014-09-06', 0),
(118, 1410037515, '2014-09-06', 1),
(119, 1410037576, '2014-09-06', 0),
(120, 1410205726, '2014-09-08', 0),
(121, 1410207864, '2014-09-08', 0),
(122, 1410207875, '2014-09-08', 0),
(123, 1410285197, '2014-09-09', 0),
(124, 1410890487, '2014-09-16', 0),
(125, 1410989283, '2014-09-17', 0),
(126, 1411072186, '2014-09-18', 0),
(127, 1411143136, '2014-09-19', 1),
(128, 1411143373, '2014-09-19', 0),
(129, 1411143401, '2014-09-19', 0),
(130, 1411167011, '2014-09-20', 1),
(131, 1411167040, '2014-09-20', 0),
(132, 1411167488, '2014-09-20', 0),
(133, 1411167600, '2014-09-20', 1),
(134, 1411167675, '2014-09-20', 1),
(135, 1411167733, '2014-09-20', 1),
(136, 1411167747, '2014-09-20', 1),
(137, 1411167983, '2014-09-20', 1),
(138, 1411353683, '2014-09-22', 1),
(139, 1411356879, '2014-09-22', 1),
(140, 1411356930, '2014-09-22', 1),
(141, 1411357001, '2014-09-22', 1),
(142, 1411498244, '2014-09-23', 1),
(143, 1411608909, '2014-09-25', 2),
(144, 1411609051, '2014-09-25', 2),
(145, 1411680922, '2014-09-25', 2),
(146, 1412063261, '2014-09-30', 2),
(147, 1412063363, '2014-09-30', 2),
(148, 1412063373, '2014-09-30', 2),
(149, 1412063400, '2014-09-30', 2),
(150, 1412063412, '2014-09-30', 2),
(151, 1412064072, '2014-09-30', 2),
(152, 1412064080, '2014-09-30', 2),
(153, 1412094875, '2014-09-30', 2),
(154, 1412094923, '2014-09-30', 2),
(155, 1412103855, '2014-09-30', 2),
(156, 1412104516, '2014-09-30', 2),
(157, 1412104551, '2014-09-30', 2),
(158, 1412105025, '2014-09-30', 2),
(159, 1412105046, '2014-09-30', 2),
(160, 1412105361, '2014-09-30', 2),
(161, 1412105442, '2014-09-30', 2),
(162, 1412105460, '2014-09-30', 2),
(163, 1412105835, '2014-09-30', 2),
(164, 1412105905, '2014-09-30', 2),
(165, 1412105989, '2014-09-30', 2),
(166, 1412106495, '2014-09-30', 2),
(167, 1412106565, '2014-09-30', 2),
(168, 1412108410, '2014-09-30', 2),
(169, 1412108728, '2014-09-30', 2),
(170, 1412108916, '2014-09-30', 2),
(171, 1412109245, '2014-09-30', 2),
(172, 1412109360, '2014-09-30', 2),
(173, 1412109758, '2014-09-30', 2),
(174, 1412109899, '2014-09-30', 2),
(175, 1412197133, '2014-10-01', 2),
(176, 1412200032, '2014-10-01', 2),
(177, 1412201576, '2014-10-02', 2),
(178, 1412201597, '2014-10-02', 2),
(179, 1412204644, '2014-10-02', 1),
(180, 1412205267, '2014-10-02', 2),
(181, 1412205850, '2014-10-02', 2),
(182, 1412208713, '2014-10-02', 2),
(183, 1412209216, '2014-10-02', 1),
(184, 1412209456, '2014-10-02', 2),
(185, 1412271566, '2014-10-02', 1),
(186, 1412271833, '2014-10-02', 1),
(187, 1412271870, '2014-10-02', 2);

-- --------------------------------------------------------

--
-- Table structure for table `problem_type`
--

CREATE TABLE IF NOT EXISTS `problem_type` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `problem_type`
--

INSERT INTO `problem_type` (`id`, `name`, `date`, `status`) VALUES
(1, 'Phone Erase', '2014-07-07', 1),
(2, 'Virus', '2014-07-16', 1),
(3, 'Worm', '2014-07-16', 1),
(4, 'Fire Burn', '2014-07-17', 1),
(5, 'Batery Burn Up', '2014-07-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `price_cost` varchar(255) DEFAULT NULL,
  `price_retail` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `taxable` int(1) DEFAULT NULL,
  `maintain_stock` int(1) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `instock` varchar(255) DEFAULT NULL,
  `reorder` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `conditions` varchar(255) DEFAULT NULL,
  `physical_location` varchar(255) DEFAULT NULL,
  `warranty` int(2) DEFAULT NULL,
  `vendor` int(2) DEFAULT NULL,
  `sort_order` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `barcode`, `price_cost`, `price_retail`, `discount`, `taxable`, `maintain_stock`, `notes`, `instock`, `reorder`, `quantity`, `conditions`, `physical_location`, `warranty`, `vendor`, `sort_order`, `date`, `status`) VALUES
(2, 'NEW Samsung Galaxy', 'drgdgg', '1', '119.98', '120.98', '', 1, 1, 'yys', '4', '-1', '0', 'rysysey4a3 ', 'eryyeryesayh e ytea ', 1, 2, '', '2014-09-10', 1),
(3, 'New Dell Venue Pro', 'trteattart', '2', '79.99', '80.99', '', 1, 1, 'dfgdgd', '3', '4', '20', 'f hxhdrz', 'eryyeryesayh e ytea', 3, 2, '-1', '2014-07-04', 1),
(4, 'Brand New Nokia Lumia', 'drgdgg', '3', '139.99', '142.99', '', 1, 1, 'dfgdgd', '3', '3', '3', 'f hxhdrz', 'errafzd', 3, 2, '1', '2014-07-04', 1),
(6, 'Samsung Galaxy S III SGH-I747', 'trteattart', '5', '191.99', '199.99', '', 1, 1, 'ghyztrdztdzgdtf ', '4', '2', '3', 'f hxhdrz', 'errafzd', 1, 2, '2', '2014-07-04', 1),
(7, 'Samsung Galaxy S Stratosphere ', 'drgdgg', '6', '39.00', '42.00', '', 1, 1, 'dfgdgd', '3', '2', '2', 'rysysey4a3', 'eryyeryesayh e ytea', 2, 2, '2', '2014-07-04', 1),
(8, 'Apple iPhone 4 8GB Black Sprint ', 'trteattart', '7', '99.00', '100.00', '', 1, 1, 'ghyztrdztdzgdtf', '3', '3', '3', 'f hxhdrz', 'eryyeryesayh e ytea', 1, 2, '2', '2014-07-04', 1),
(9, 'LG Optimus F7 LG870 (Latest ', 'drgdgg', '8', '77.99', '82.99', '', 1, 1, 'ghyztrdztdzgdtf', '3', '2', '2', 'f hxhdrz', 'errafzd', 2, 3, '2', '2014-07-04', 1),
(10, 'Nokia Lumia 925 (Latest Model) - ', 'trteattart', '9', '164.99', '170.99', '', 1, 1, 'ghyztrdztdzgdtf', '2', '2', '5', 'f hxhdrz', 'errafzd', 2, 1, '2', '2014-07-04', 1),
(11, 'Brand New Nokia Lumia 822', 'drgdgg', '10', '139.99', '142.99', '', 1, 1, 'ghyztrdztdzgdtf', '3', '5', '2', 'f hxhdrz', 'eryyeryesayh e ytea', 2, 2, '3', '2014-07-04', 1),
(12, 'Samsung Galaxy S Relay', 'trteattart', '11', '134.99', '152.94', '', 1, 1, 'ghyztrdztdzgdtf', '7', '2', '2', 'f hxhdrz', 'eryyeryesayh e ytea', 2, 1, '8', '2014-07-04', 1),
(13, 'New Dell Venue Pro 16GB Black ', 'trteattart', '12', '79.99', '80.99', '', 1, 1, 'ghyztrdztdzgdtf', '2', '3', '3', 'rysysey4a3', 'eryyeryesayh e ytea', 2, 3, '2', '2014-07-04', 1),
(14, 'NEW Nokia N8 Unlocked GSM Original 3G 12MP GPS WIFI Smartphone', 'trteattart', '13', '63.00', '70.00', '', 1, 1, 'ghyztrdztdzgdtf', '1', '-1', '-1', 'rysysey4a3', 'eryyeryesayh e ytea', 2, 2, '1', '2014-07-04', 1),
(15, 'NEW Nokia N8 Unlocked GSM Original 3G 12MP GPS WIFI Smartphone', 'trteattart', '14', '128.66', '130.66', '', 1, 1, 'ghyztrdztdzgdtf', '3', '3', '2', 'f hxhdrz', 'eryyeryesayh e ytea', 1, 4, '2', '2014-07-04', 1),
(16, 'Nokia N8', 'drgdgg', '15', '70.00', '75.99', '', 1, 1, 'ghyztrdztdzgdtf', '2', '3', '3', 'rysysey4a3', 'eryyeryesayh e ytea', 1, 4, '1', '2014-07-04', 1),
(17, 'Nokia N Series N8 - 16GB ', 'drgdgg', '16', '74.99', '80.99', '', 1, 1, 'ghyztrdztdzgdtf', '3', '2', '2', 'f hxhdrz', 'eryyeryesayh e ytea', 2, 2, '3', '2014-07-04', 1),
(18, 'Acecloben 100', 'Iphone Camera', '100', '100', '120', '23%', 1, 1, 'Camera Ic', '45', '2', '34', 'good', 'Store', 1, 1, '1', '2014-08-06', 1),
(23, 'IPad, Mini - Broken Front Camera', NULL, NULL, '100', '100', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-27', 2),
(24, 'IPhone, 3G - Battery Replacement', NULL, NULL, '20', '20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-27', 2),
(25, 'IPhone, 3GS - Broken Screen', NULL, NULL, '30', '30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-27', 2),
(26, 'IPhone, 3G - Broken Screen', NULL, NULL, '60', '60', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-27', 2),
(27, 'IPhone, 3G - Other', NULL, NULL, '20', '20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-27', 2),
(28, 'IPad, 1 - Broken Front Camera', NULL, NULL, '10', '10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-27', 1),
(29, 'IPhone, 5S - Battery Replacement', NULL, NULL, '10', '10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, '2014-08-27', 1),
(30, 'IPhone, 5S - Broken Screen', NULL, NULL, '20', '20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-27', 1),
(31, 'IPhone, 5S - Other', NULL, NULL, '30', '30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-27', 1),
(32, 'Materials Request - 1409488855', 'Product Added From Ticket', 'Materials Request - 1409488855', '20', '30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-31', 3),
(33, 'Fahad wants you to be a farmhand! - 1409489810', 'Product Added From Ticket', 'Fahad wants you to be a farmhand! - 1409489810', '12', '13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-08-31', 3),
(34, 'Hey neighbor, can you lend me some Baby Bottles? - 1409676391', 'Product Added From Ticket', 'Hey neighbor, can you lend me some Baby Bottles? - 1409676391', '12', '30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-02', 3),
(35, 'IPhone, 5S - Broken Microphone', NULL, '1409941918', '100', '100', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-09-05', 1),
(36, 'Demo', 'Demo Description', 'Demo', '12', '13', '12%', 1, 1, 'asdsad', '', '2', '3', 'good', 'Store', 1, 2, '2', '2014-09-06', 1),
(37, 'Fahad wants you to be a farmhand! - 1410205630', 'Product Added From Ticket', '1410206916', '12', '30', NULL, NULL, 0, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, '2014-09-08', 3),
(38, 'IPhone, 5C - Broken Microphone', 'Product Added From Checkin', '1410287703', '200', '200', NULL, NULL, 0, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, '2014-09-09', 1),
(39, 'IPhone, 5S - Cas', 'Product Added From Checkin', '1411599977', '100', '100', NULL, NULL, 0, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, '2014-09-25', 1),
(40, 'Materials Request - 1411614626', 'Product Added From Ticket', '1411614655', '12', '30', NULL, NULL, 0, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, '2014-09-25', 3),
(41, 'Fahad wants you to be a farmhand! - 1411614655', 'Product Added From Ticket', '1411614684', '12', '13', NULL, NULL, 0, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, '2014-09-25', 3),
(42, 'Demo Ticket - 1412059352', 'Product Added From Ticket', '1412059383', '2', '4', NULL, NULL, 0, NULL, NULL, '1', '1', NULL, NULL, 3, NULL, NULL, '2014-09-30', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_stockin`
--

CREATE TABLE IF NOT EXISTS `product_stockin` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `pid` int(20) DEFAULT NULL,
  `price_cost` varchar(20) NOT NULL,
  `price_retail` varchar(20) NOT NULL,
  `quantity` int(2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `product_stockin`
--

INSERT INTO `product_stockin` (`id`, `pid`, `price_cost`, `price_retail`, `quantity`, `date`, `status`) VALUES
(1, 2, '119.98', '120.98', 2, '2014-09-06', 1),
(2, 2, '119', '120', 2, '2014-09-06', 1),
(3, 2, '119.98', '120.98', 12, '2014-09-06', 1),
(4, 3, '79.99', '80.99', 18, '2014-09-06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `vendor` varchar(255) DEFAULT NULL,
  `expec_date` varchar(255) DEFAULT NULL,
  `ship_notes` varchar(255) DEFAULT NULL,
  `gene_notes` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `vendor`, `expec_date`, `ship_notes`, `gene_notes`, `date`, `status`) VALUES
(1, 'dffsdfsfsfsdf', '12-12-12', 'fsdfsdfsdffsdffdf', 'fdfdffsfsfsfdfdsf', '2014-06-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(20) NOT NULL,
  `cashier_id` int(20) NOT NULL,
  `payment_method` int(20) NOT NULL,
  `sales_id` int(20) DEFAULT NULL,
  `pid` int(20) DEFAULT NULL,
  `quantity` int(20) DEFAULT NULL,
  `single_cost` varchar(20) DEFAULT NULL,
  `totalcost` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `datetime` varchar(255) NOT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `uid`, `cashier_id`, `payment_method`, `sales_id`, `pid`, `quantity`, `single_cost`, `totalcost`, `date`, `datetime`, `status`) VALUES
(2, 21, 2, 3, 1412105442, 39, 1, '100', '100', '2014-09-30', '2014-09-30 21:31:00', 1),
(3, 21, 2, 4, 1412105905, 39, 1, '100', '100', '2014-09-30', '2014-09-30 21:39:49', 1),
(4, 21, 2, 3, 1412105989, 39, 1, '100', '100', '2014-09-30', '2014-09-30 21:48:15', 1),
(5, 21, 2, 3, 1412106495, 39, 2, '100', '200', '2014-09-30', '2014-09-30 21:49:25', 1),
(6, 21, 2, 3, 1412106565, 39, 1, '100', '100', '2014-09-30', '2014-09-30 22:20:10', 1),
(7, 21, 2, 3, 1412108410, 39, 2, '100', '200', '2014-09-30', '2014-09-30 22:25', 1),
(8, 21, 2, 3, 1412108916, 36, 1, '13', '13', '2014-09-30', '2014-09-30 22:34', 1),
(9, 21, 2, 4, 1412109245, 39, 1, '100', '100', '2014-09-30', '2014-09-30 22:36', 1),
(10, 21, 2, 4, 1412109360, 39, 1, '100', '100', '2014-09-30', '2014-09-30 22:42', 1),
(11, 21, 2, 4, 1412109758, 39, 1, '100', '100', '2014-09-30', '2014-09-30 22:44', 1),
(13, 5, 2, 4, 1412201576, 39, 1, '100', '100', '2014-10-02', '2014-10-02 00:13', 1),
(15, 5, 2, 3, 1412204644, 39, 1, '100', '100', '2014-10-02', '2014-10-02 01:14', 1),
(16, 5, 2, 3, 1412205267, 39, 1, '100', '100', '2014-10-02', '2014-10-02 01:24', 1),
(17, 5, 2, 3, 1412205850, 39, 2, '100', '200', '2014-10-02', '2014-10-02 02:11', 1),
(18, 5, 2, 3, 1412208713, 39, 1, '100', '100', '2014-10-02', '2014-10-02 02:20', 1),
(20, 5, 2, 4, 1412209216, 39, 1, '100', '100', '2014-10-02', '2014-10-02 02:24', 1),
(22, 5, 2, 3, 1412271833, 39, 1, '100', '100', '2014-10-02', '2014-10-02 19:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting_customer`
--

CREATE TABLE IF NOT EXISTS `setting_customer` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `no_email` int(1) DEFAULT NULL,
  `sms_default` int(1) DEFAULT NULL,
  `multiple_contacts` int(1) DEFAULT NULL,
  `email_activation` int(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `setting_customer`
--

INSERT INTO `setting_customer` (`id`, `no_email`, `sms_default`, `multiple_contacts`, `email_activation`, `date`, `status`) VALUES
(2, 1, 1, 1, 1, '2014-06-25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting_estimates`
--

CREATE TABLE IF NOT EXISTS `setting_estimates` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `enable_estimates` int(1) DEFAULT NULL,
  `donot_inven` int(1) DEFAULT NULL,
  `last_est_num` int(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `setting_estimates`
--

INSERT INTO `setting_estimates` (`id`, `enable_estimates`, `donot_inven`, `last_est_num`, `date`, `status`) VALUES
(1, 1, 1, 55555555, '2014-06-25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting_general`
--

CREATE TABLE IF NOT EXISTS `setting_general` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `time_zone` int(1) DEFAULT NULL,
  `local_region` int(1) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `setting_general`
--

INSERT INTO `setting_general` (`id`, `time_zone`, `local_region`, `admin_email`, `date`, `status`) VALUES
(1, 1, 1, 'hjdhfghf@gmail.com', '2014-06-25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting_inventory`
--

CREATE TABLE IF NOT EXISTS `setting_inventory` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `send_daily_email` int(1) DEFAULT NULL,
  `enable_wholesale` int(1) DEFAULT NULL,
  `enable_purchas_pub` int(1) DEFAULT NULL,
  `list_product_category` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `setting_inventory`
--

INSERT INTO `setting_inventory` (`id`, `send_daily_email`, `enable_wholesale`, `enable_purchas_pub`, `list_product_category`, `date`, `status`) VALUES
(1, 1, 1, 1, 'L1, B2, A1, C3', '2014-06-26', 1),
(2, 1, 1, 1, '', '2014-06-26', 1),
(3, 1, 1, 1, '', '2014-06-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting_invoice`
--

CREATE TABLE IF NOT EXISTS `setting_invoice` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `disable_tax` int(1) DEFAULT NULL,
  `disable_payments` int(1) DEFAULT NULL,
  `enable_diposits` int(1) DEFAULT NULL,
  `enable_multiple` int(1) DEFAULT NULL,
  `save_invoices` int(1) DEFAULT NULL,
  `enable_elec_signatures` int(1) DEFAULT NULL,
  `enable_topaz_signature` int(1) DEFAULT NULL,
  `donot_pdf` int(1) DEFAULT NULL,
  `donot_excel` int(1) DEFAULT NULL,
  `vat_reg_num` varchar(255) DEFAULT NULL,
  `last_invo_num` int(20) DEFAULT NULL,
  `local_tax` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `setting_invoice`
--

INSERT INTO `setting_invoice` (`id`, `disable_tax`, `disable_payments`, `enable_diposits`, `enable_multiple`, `save_invoices`, `enable_elec_signatures`, `enable_topaz_signature`, `donot_pdf`, `donot_excel`, `vat_reg_num`, `last_invo_num`, `local_tax`, `date`, `status`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '552552', 5555252, '2', '2014-06-25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting_parts`
--

CREATE TABLE IF NOT EXISTS `setting_parts` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `parts_email` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `setting_parts`
--

INSERT INTO `setting_parts` (`id`, `parts_email`, `date`, `status`) VALUES
(1, 'kuhfjdgf@gmail.com', '2014-06-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting_pos`
--

CREATE TABLE IF NOT EXISTS `setting_pos` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `enable_pos` int(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `setting_pos`
--

INSERT INTO `setting_pos` (`id`, `enable_pos`, `date`, `status`) VALUES
(1, 1, '2014-06-26', 1),
(2, 1, '2014-06-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting_tickets`
--

CREATE TABLE IF NOT EXISTS `setting_tickets` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `send_diag_daily` int(1) DEFAULT NULL,
  `send_diag_hourly` int(1) DEFAULT NULL,
  `copy_pri_tic_update` int(1) DEFAULT NULL,
  `required_in_form` int(1) DEFAULT NULL,
  `tic_donot_email` int(1) DEFAULT NULL,
  `enable_due_date` int(1) DEFAULT NULL,
  `enable_tic_assi` int(1) DEFAULT NULL,
  `enable_tic_form` int(1) DEFAULT NULL,
  `enable_tic_time` int(1) DEFAULT NULL,
  `enable_recur_tic` int(1) DEFAULT NULL,
  `hide_tic_status` int(1) DEFAULT NULL,
  `show_tic_type` int(1) DEFAULT NULL,
  `enable_tic_priori` int(1) DEFAULT NULL,
  `sub_tic_com_email` varchar(255) DEFAULT NULL,
  `private_sta_email` varchar(255) DEFAULT NULL,
  `inbo_email_alias` varchar(255) DEFAULT NULL,
  `tech_rem_email` varchar(255) DEFAULT NULL,
  `tic_prob_type` varchar(255) DEFAULT NULL,
  `tic_sta_list` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `setting_tickets`
--

INSERT INTO `setting_tickets` (`id`, `send_diag_daily`, `send_diag_hourly`, `copy_pri_tic_update`, `required_in_form`, `tic_donot_email`, `enable_due_date`, `enable_tic_assi`, `enable_tic_form`, `enable_tic_time`, `enable_recur_tic`, `hide_tic_status`, `show_tic_type`, `enable_tic_priori`, `sub_tic_com_email`, `private_sta_email`, `inbo_email_alias`, `tech_rem_email`, `tic_prob_type`, `tic_sta_list`, `date`, `status`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'fhjfh@gmail.com', 'yeap', 'nope', 'he he he he ', 'all bogas', '1000001420', '2014-06-26', 1),
(2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '', '', '', '', '', '', '2014-06-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` int(20) DEFAULT NULL,
  `country` int(1) DEFAULT NULL,
  `phone` int(20) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `subdomain` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `name`, `email`, `username`, `password`, `image`, `street`, `city`, `state`, `zip`, `country`, `phone`, `website`, `subdomain`, `date`, `status`) VALUES
(1, 'Mahamod', 'dfgfdgfdg', '', '', NULL, 'fdgfdgfg', 'fdgfdg', 'fgfgfdg', 456546546, 3, 2147483647, 'gfdgfdgfd', 'fgdfgfd', '2014-06-25', 2),
(4, 'Fahad Bhuyian', 'f.bhuyian@gmail.com', 'amsit', '921781f33d17ead17be3dd919e799122', 'store_140735904720140729_155405.jpg', '44/P, Kazi Bhavan,New Zigatola Road Dhanmondi DHaka', 'Dhaka', 'Dhaka', 1209, 2, 1927608261, 'www.amsitsoft.com', 'pos.amsitsoft.com', '2014-08-06', 1),
(5, 'Wireless Geeks', 'justin_dabish@gmail.com', 'admin', '77d5d7b77bb86c84273f770a398a2e2f', 'store_140753323920140803_175909.jpg', '44/P, Kazi Bhavan,New Zigatola Road Dhanmondi DHaka', 'Dhaka', 'Dhaka', 1209, 2, 1927608261, 'www.amsitsoft.com', 'pos.amsitsoft.com', '2014-08-08', 2);

-- --------------------------------------------------------

--
-- Table structure for table `store_open`
--

CREATE TABLE IF NOT EXISTS `store_open` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `sid` int(20) DEFAULT NULL,
  `opening_cash` varchar(20) DEFAULT NULL,
  `opening_sqaure` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `datetime` varchar(255) NOT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `store_open`
--

INSERT INTO `store_open` (`id`, `sid`, `opening_cash`, `opening_sqaure`, `date`, `datetime`, `status`) VALUES
(1, 5, '100', '0', '2014-10-01', '2014-10-01 23:51', 2),
(2, 5, '20', '', '2014-10-02', '2014-10-02 01:23', 2),
(3, 5, '20', '', '2014-10-02', '2014-10-02 19:39', 2),
(4, 5, '20', '', '2014-10-02', '2014-10-02 20:34', 2),
(5, 5, '20', '', '2014-10-02', '2014-10-02 20:35', 2),
(6, 5, '30', '', '2014-10-02', '2014-10-02 20:56', 2),
(7, 5, '20', '', '2014-10-02', '2014-10-02 21:06', 2),
(8, 5, '20', '', '2014-10-02', '2014-10-02 21:09', 2),
(9, 5, '100', '', '2014-10-02', '2014-10-02 21:21', 2),
(10, 5, '100', '', '2014-10-02', '2014-10-02 21:22', 2),
(11, 5, '20', '', '2014-10-02', '2014-10-02 21:32', 2),
(12, 5, '20', '', '2014-10-02', '2014-10-02 21:50', 2);

-- --------------------------------------------------------

--
-- Table structure for table `store_punch_time`
--

CREATE TABLE IF NOT EXISTS `store_punch_time` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `sid` int(20) DEFAULT NULL,
  `cashier_id` int(20) NOT NULL,
  `indate` date DEFAULT NULL,
  `intime` varchar(255) DEFAULT NULL,
  `outdate` date DEFAULT NULL,
  `outtime` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `store_punch_time`
--

INSERT INTO `store_punch_time` (`id`, `sid`, `cashier_id`, `indate`, `intime`, `outdate`, `outtime`, `date`, `status`) VALUES
(1, 5, 0, '2014-09-19', '00:19:38', '2014-09-19', '19:37:21', '2014-09-19', 2),
(2, 5, 2, '2014-09-21', '19:37:29', '2014-09-30', '09:47:56', '2014-09-19', 2),
(3, 1, 0, '2014-09-20', '00:34:48', '2014-09-20', '00:34:52', '2014-09-20', 2),
(4, 1, 0, '2014-09-20', '00:35:02', '2014-09-20', '00:35:04', '2014-09-20', 2),
(5, 1, 0, '2014-09-20', '00:41:25', '2014-09-20', '00:43:49', '2014-09-20', 2),
(6, 1, 2, '2014-09-20', '01:36:42', '2014-09-20', '01:36:44', '2014-09-20', 2),
(7, 5, 2, '2014-09-30', '09:47:58', NULL, NULL, '2014-09-30', 1),
(8, 21, 2, '2014-09-30', '18:32:43', '2014-09-30', '21:03:49', '2014-09-30', 2),
(9, 21, 2, '2014-09-30', '21:23:09', '2014-09-30', '21:23:11', '2014-09-30', 2),
(10, 21, 2, '2014-09-30', '21:30:22', NULL, NULL, '2014-09-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE IF NOT EXISTS `tax` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(20) DEFAULT NULL,
  `tax` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`id`, `uid`, `tax`, `date`, `status`) VALUES
(6, 1, '2', '2014-07-27', 1),
(7, 5, '2', '2014-08-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tax_status`
--

CREATE TABLE IF NOT EXISTS `tax_status` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tax_status`
--

INSERT INTO `tax_status` (`id`, `date`, `status`) VALUES
(1, '2014-09-24', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `cid` int(20) NOT NULL,
  `ticket_id` int(20) NOT NULL,
  `uid` int(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `problem_type` int(5) DEFAULT NULL,
  `our_cost` varchar(20) NOT NULL,
  `retail_cost` varchar(20) NOT NULL,
  `work_approved` int(1) DEFAULT NULL,
  `diagnostic` int(2) NOT NULL,
  `invoice` int(2) NOT NULL,
  `work_completed` int(2) NOT NULL,
  `type_color` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `carrier` varchar(255) NOT NULL,
  `imei` varchar(255) DEFAULT NULL,
  `even_been` int(1) DEFAULT NULL,
  `tested_before` varchar(255) DEFAULT NULL,
  `dented` int(1) DEFAULT NULL,
  `previously_repaired` int(1) DEFAULT NULL,
  `broken_home` int(1) DEFAULT NULL,
  `broken_volume` int(1) DEFAULT NULL,
  `broken_vibrate` int(1) DEFAULT NULL,
  `broken_charge_port` int(1) DEFAULT NULL,
  `broken_headphone` int(1) DEFAULT NULL,
  `broken_digitizer` int(1) DEFAULT NULL,
  `broken_ear_speaker` int(1) DEFAULT NULL,
  `broken_microphone` int(1) DEFAULT NULL,
  `broken_proximity` int(1) DEFAULT NULL,
  `broken_wifi` int(1) DEFAULT NULL,
  `broken_back_camera` int(1) DEFAULT NULL,
  `broken_front_camera` int(1) DEFAULT NULL,
  `tested_after` varchar(255) DEFAULT NULL,
  `tech_notes` varchar(255) DEFAULT NULL,
  `payment` int(2) NOT NULL,
  `partial_amount` varchar(20) NOT NULL,
  `warrenty` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `cid`, `ticket_id`, `uid`, `title`, `problem_type`, `our_cost`, `retail_cost`, `work_approved`, `diagnostic`, `invoice`, `work_completed`, `type_color`, `password`, `carrier`, `imei`, `even_been`, `tested_before`, `dented`, `previously_repaired`, `broken_home`, `broken_volume`, `broken_vibrate`, `broken_charge_port`, `broken_headphone`, `broken_digitizer`, `broken_ear_speaker`, `broken_microphone`, `broken_proximity`, `broken_wifi`, `broken_back_camera`, `broken_front_camera`, `tested_after`, `tech_notes`, `payment`, `partial_amount`, `warrenty`, `date`, `status`) VALUES
(1, 1, 1409488855, 8, 'Materials Request', 1, '20', '30', 1, 0, 0, 0, 'White', 'F@h@d555ooo', '', '123456', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '', 0, '2014-08-31', 1),
(2, 1, 1409489810, 8, 'Fahad wants you to be a farmhand!', 2, '12', '13', 1, 0, 0, 0, 'Black', 'F@h@d555ooo', '', '35777781023', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '', 0, '2014-08-31', 1),
(3, 1, 1409676391, 5, 'Hey neighbor, can you lend me some Baby Bottles?', 1, '12', '30', 1, 0, 0, 0, 'White', 'asd123', '', '123456', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'I Have Been Facing Serious Virus Problem', 3, '12', 0, '2014-09-02', 1),
(4, 1, 1410205630, 5, 'Fahad wants you to be a farmhand!', 2, '12', '30', 1, 0, 0, 0, 'White', 'asd123', 'AT n T', 'sdfsfdsf', 0, 'sdfsdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '', 0, '2014-09-08', 1),
(5, 1, 1411614626, 5, 'Materials Request', 1, '12', '30', 1, 0, 0, 0, 'White', 'asd123', 'AT  T', '35777781023', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '', 0, '2014-09-25', 1),
(6, 1, 1411614655, 5, 'Fahad wants you to be a farmhand!', 4, '12', '13', 1, 0, 0, 0, 'White', 'asd123', 'AT  T', '35777781023', 0, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '', 0, '2014-09-25', 1),
(7, 1, 1412059352, 5, 'Demo Ticket', 2, '2', '4', 1, 0, 0, 0, 'White', 'asd123', 'AT  T', '35777781023', 1, 'Me', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Wireless Geeks', 'Serious Virus Problem', 0, '', 1, '2014-09-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_asset`
--

CREATE TABLE IF NOT EXISTS `ticket_asset` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(20) DEFAULT NULL,
  `ticket_id` int(20) DEFAULT NULL,
  `asset_id` int(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=120 ;

--
-- Dumping data for table `ticket_asset`
--

INSERT INTO `ticket_asset` (`id`, `uid`, `ticket_id`, `asset_id`, `date`, `status`) VALUES
(1, 1, 0, 12, '2014-07-17', 1),
(2, 1, 0, 13, '2014-07-17', 1),
(3, 1, 0, 14, '2014-07-17', 1),
(4, 1, 0, 15, '2014-07-17', 1),
(5, 1, 0, 20, '2014-07-17', 1),
(6, 1, 0, 21, '2014-07-17', 1),
(7, 1, 0, 8, '2014-07-17', 1),
(22, 1, 1405542319, 8, '2014-07-17', 1),
(23, 1, 1405551253, 12, '2014-07-17', 1),
(24, 1, 1405551253, 14, '2014-07-17', 1),
(25, 1, 1405551253, 13, '2014-07-17', 1),
(26, 1, 1405551253, 20, '2014-07-17', 1),
(27, 1, 1405551253, 15, '2014-07-17', 1),
(28, 1, 1405551294, 12, '2014-07-17', 1),
(29, 1, 1405551294, 14, '2014-07-17', 1),
(30, 1, 1405551294, 20, '2014-07-17', 1),
(31, 1, 1405551294, 21, '2014-07-17', 1),
(32, 1, 1405855361, 12, '2014-07-20', 1),
(33, 1, 1405855361, 13, '2014-07-20', 1),
(34, 1, 1405855361, 15, '2014-07-20', 1),
(35, 1, 1405855361, 14, '2014-07-20', 1),
(36, 1, 1405855361, 21, '2014-07-20', 1),
(37, 1, 1406014241, 13, '2014-07-22', 1),
(38, 1, 1406014241, 14, '2014-07-22', 1),
(39, 1, 1406014241, 15, '2014-07-22', 1),
(40, 1, 1406014241, 12, '2014-07-22', 1),
(41, 1, 1406014241, 20, '2014-07-22', 1),
(42, 1, 1406014241, 21, '2014-07-22', 1),
(44, 1, 1406020363, 14, '2014-07-22', 1),
(45, 1, 1406020363, 15, '2014-07-22', 1),
(46, 1, 1406020363, 21, '2014-07-22', 1),
(47, 1, 1406020363, 13, '2014-07-22', 1),
(48, 1, 1406020363, 20, '2014-07-22', 1),
(49, 1, 1406020363, 22, '2014-07-22', 1),
(50, 1, 1406020363, 8, '2014-07-22', 1),
(51, 1, 1406051641, 12, '2014-07-22', 1),
(52, 1, 1406051641, 13, '2014-07-22', 1),
(53, 1, 1406051641, 14, '2014-07-22', 1),
(54, 1, 1406051641, 15, '2014-07-22', 1),
(55, 1, 1406051641, 20, '2014-07-22', 1),
(56, 1, 1406051641, 21, '2014-07-22', 1),
(57, 1, 1406051641, 22, '2014-07-22', 1),
(58, 1, 18, 12, '2014-07-24', 1),
(59, 1, 18, 13, '2014-07-24', 1),
(60, 1, 18, 15, '2014-07-24', 1),
(61, 1, 18, 20, '2014-07-24', 1),
(62, 1, 18, 21, '2014-07-24', 1),
(63, 1, 18, 14, '2014-07-24', 1),
(64, 1, 1406362010, 23, '2014-07-26', 1),
(65, 1, 1406362010, 12, '2014-07-26', 1),
(66, 1, 1406362010, 13, '2014-07-26', 1),
(67, 1, 1406362010, 14, '2014-07-26', 1),
(68, 1, 1406362010, 15, '2014-07-26', 1),
(69, 1, 1406362010, 20, '2014-07-26', 1),
(70, 1, 1406362010, 21, '2014-07-26', 1),
(71, 1, 1406362010, 8, '2014-07-26', 1),
(72, 1, 1407341035, 8, '2014-08-06', 1),
(73, 1, 1407341035, 12, '2014-08-06', 1),
(74, 1, 1407341035, 13, '2014-08-06', 1),
(75, 1, 1407341035, 14, '2014-08-06', 1),
(76, 1, 1407341035, 15, '2014-08-06', 1),
(77, 1, 1407341035, 20, '2014-08-06', 1),
(78, 1, 1407341035, 22, '2014-08-06', 1),
(79, 1, 1407341035, 21, '2014-08-06', 1),
(80, 1, 1407341035, 23, '2014-08-06', 1),
(81, 5, 1408392826, 8, '2014-08-18', 1),
(82, 5, 1408392826, 13, '2014-08-18', 1),
(83, 5, 1408392826, 12, '2014-08-18', 1),
(84, 5, 1408392826, 14, '2014-08-18', 1),
(85, 5, 1408392826, 21, '2014-08-18', 1),
(86, 5, 1408392826, 20, '2014-08-18', 1),
(89, 5, 1408392826, 23, '2014-08-18', 1),
(94, 5, 1408392826, 24, '2014-08-18', 1),
(95, 5, 1408392826, 22, '2014-08-18', 1),
(96, 5, 1408392826, 15, '2014-08-18', 1),
(97, 5, 1408394942, 8, '2014-08-18', 1),
(98, 5, 1408395090, 12, '2014-08-18', 1),
(99, 5, 1408395121, 12, '2014-08-18', 1),
(100, 5, 1408395540, 24, '2014-08-18', 1),
(103, 5, 1408398046, 13, '2014-08-19', 1),
(104, 5, 1408398046, 8, '2014-08-19', 1),
(105, 5, 1408398046, 15, '2014-08-19', 1),
(106, 5, 1408398046, 20, '2014-08-19', 1),
(107, 5, 1408398046, 21, '2014-08-19', 1),
(108, 5, 1408398046, 14, '2014-08-19', 1),
(109, 5, 1408398046, 22, '2014-08-19', 1),
(110, 5, 1408398046, 23, '2014-08-19', 1),
(111, 5, 1409476398, 8, '2014-08-31', 1),
(112, 5, 1409476398, 13, '2014-08-31', 1),
(113, 5, 1409476398, 15, '2014-08-31', 1),
(114, 5, 1409476398, 20, '2014-08-31', 1),
(115, 5, 1409676391, 8, '2014-09-02', 1),
(116, 5, 1409676391, 12, '2014-09-02', 1),
(117, 5, 1409676391, 15, '2014-09-02', 1),
(118, 5, 1409676391, 20, '2014-09-02', 1),
(119, 5, 1409676391, 14, '2014-09-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_custom_field`
--

CREATE TABLE IF NOT EXISTS `ticket_custom_field` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `ticket_custom_field`
--

INSERT INTO `ticket_custom_field` (`id`, `uid`, `name`, `date`, `status`) VALUES
(1, 1, 'Dented', '2014-07-22', 1),
(2, 1, 'Previously Repaired ', '2014-07-22', 1),
(3, 1, 'Broken Home Button ', '2014-07-22', 1),
(4, 1, 'Broken Volume Buttons ', '2014-07-22', 1),
(5, 1, 'Broken Vibrate Switch ', '2014-07-22', 1),
(6, 1, 'Broken Charge Port ', '2014-07-22', 1),
(7, 1, 'Broken Headphone ', '2014-07-22', 1),
(8, 1, 'Broken Digitizer ', '2014-07-22', 1),
(9, 1, 'Broken Ear Speaker ', '2014-07-22', 1),
(10, 1, 'Broken Microphone ', '2014-07-22', 1),
(11, 1, ' Broken Proximity Sensor ', '2014-07-22', 1),
(12, 1, 'Broken WiFi ', '2014-07-22', 1),
(13, 1, 'Broken Back Camera ', '2014-07-22', 1),
(14, 1, 'Broken Front Camera ', '2014-07-22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_custom_selection`
--

CREATE TABLE IF NOT EXISTS `ticket_custom_selection` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(20) DEFAULT NULL,
  `fid` int(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=371 ;

--
-- Dumping data for table `ticket_custom_selection`
--

INSERT INTO `ticket_custom_selection` (`id`, `ticket_id`, `fid`, `date`, `status`) VALUES
(36, 1406019218, 9, NULL, NULL),
(40, 1406019218, 5, NULL, NULL),
(42, 1406019218, 12, NULL, NULL),
(43, 1406019218, 4, NULL, NULL),
(45, 1406019218, 2, NULL, NULL),
(46, 1406019218, 3, NULL, NULL),
(47, 1406019218, 11, NULL, NULL),
(48, 1406019218, 13, NULL, NULL),
(49, 1406019218, 14, NULL, NULL),
(50, 1406019218, 1, NULL, NULL),
(51, 1406019218, 1, NULL, NULL),
(54, 1406020363, 12, NULL, NULL),
(58, 1406020363, 8, NULL, NULL),
(59, 1406020363, 7, NULL, NULL),
(60, 1406020363, 6, NULL, NULL),
(61, 1406020363, 5, NULL, NULL),
(62, 1406020363, 4, NULL, NULL),
(63, 1406020363, 3, NULL, NULL),
(64, 1406020363, 2, NULL, NULL),
(65, 1406020363, 1, NULL, NULL),
(68, 1406051641, 12, NULL, NULL),
(70, 1406051641, 10, NULL, NULL),
(72, 1406051641, 8, NULL, NULL),
(73, 1406051641, 7, NULL, NULL),
(74, 1406051641, 6, NULL, NULL),
(75, 1406051641, 5, NULL, NULL),
(76, 1406051641, 4, NULL, NULL),
(77, 1406051641, 3, NULL, NULL),
(78, 1406051641, 2, NULL, NULL),
(79, 1406051641, 1, NULL, NULL),
(80, 18, 14, NULL, NULL),
(81, 18, 12, NULL, NULL),
(82, 18, 10, NULL, NULL),
(83, 18, 8, NULL, NULL),
(84, 18, 8, NULL, NULL),
(85, 18, 6, NULL, NULL),
(86, 18, 3, NULL, NULL),
(87, 18, 1, NULL, NULL),
(88, 18, 1, NULL, NULL),
(89, 18, 2, NULL, NULL),
(90, 18, 2, NULL, NULL),
(91, 18, 4, NULL, NULL),
(92, 18, 9, NULL, NULL),
(93, 18, 9, NULL, NULL),
(94, 18, 11, NULL, NULL),
(95, 18, 13, NULL, NULL),
(96, 1405551253, 14, NULL, NULL),
(97, 1405551253, 12, NULL, NULL),
(98, 1405551253, 10, NULL, NULL),
(99, 1405551253, 10, NULL, NULL),
(100, 1405551253, 9, NULL, NULL),
(101, 1405551253, 8, NULL, NULL),
(102, 1405551253, 7, NULL, NULL),
(103, 1405551253, 7, NULL, NULL),
(104, 1405551253, 7, NULL, NULL),
(105, 1405551253, 6, NULL, NULL),
(106, 1405551253, 5, NULL, NULL),
(107, 1405551253, 4, NULL, NULL),
(108, 1405551253, 3, NULL, NULL),
(109, 1405551253, 3, NULL, NULL),
(110, 1405551253, 2, NULL, NULL),
(111, 1405551253, 2, NULL, NULL),
(112, 1405551253, 1, NULL, NULL),
(113, 1405551253, 1, NULL, NULL),
(114, 1405551253, 11, NULL, NULL),
(115, 1405551253, 13, NULL, NULL),
(116, 1406014327, 14, NULL, NULL),
(117, 1406014327, 14, NULL, NULL),
(118, 1406014327, 13, NULL, NULL),
(119, 1406014327, 12, NULL, NULL),
(120, 1406014327, 11, NULL, NULL),
(121, 1406014327, 10, NULL, NULL),
(122, 1406014327, 9, NULL, NULL),
(123, 1406014327, 9, NULL, NULL),
(124, 1406014327, 8, NULL, NULL),
(125, 1406014327, 8, NULL, NULL),
(126, 1406014327, 7, NULL, NULL),
(127, 1406014327, 6, NULL, NULL),
(128, 1406014327, 5, NULL, NULL),
(129, 1406014327, 5, NULL, NULL),
(130, 1406014327, 4, NULL, NULL),
(131, 1406014327, 3, NULL, NULL),
(132, 1406014327, 2, NULL, NULL),
(133, 1406014327, 2, NULL, NULL),
(134, 1406014327, 1, NULL, NULL),
(136, 1406362010, 12, NULL, NULL),
(137, 1406362010, 10, NULL, NULL),
(138, 1406362010, 8, NULL, NULL),
(139, 1406362010, 7, NULL, NULL),
(140, 1406362010, 5, NULL, NULL),
(141, 1406362010, 3, NULL, NULL),
(142, 1406362010, 1, NULL, NULL),
(143, 1406362010, 13, NULL, NULL),
(144, 1406362010, 11, NULL, NULL),
(145, 1406362010, 9, NULL, NULL),
(146, 1406362010, 6, NULL, NULL),
(147, 1406362010, 4, NULL, NULL),
(148, 1407341035, 14, NULL, NULL),
(149, 1407341035, 13, NULL, NULL),
(150, 1407341035, 12, NULL, NULL),
(151, 1407341035, 11, NULL, NULL),
(152, 1407341035, 10, NULL, NULL),
(153, 1407341035, 9, NULL, NULL),
(154, 1407341035, 8, NULL, NULL),
(155, 1407341035, 7, NULL, NULL),
(156, 1407341035, 6, NULL, NULL),
(157, 1407341035, 5, NULL, NULL),
(158, 1407341035, 4, NULL, NULL),
(159, 1407341035, 3, NULL, NULL),
(160, 1407341035, 2, NULL, NULL),
(161, 1407341035, 1, NULL, NULL),
(162, 1408391712, 14, NULL, NULL),
(163, 1408391712, 13, NULL, NULL),
(164, 1408391712, 12, NULL, NULL),
(165, 1408391712, 11, NULL, NULL),
(166, 1408391712, 10, NULL, NULL),
(167, 1408391712, 9, NULL, NULL),
(168, 1408391712, 8, NULL, NULL),
(169, 1408391712, 7, NULL, NULL),
(170, 1408391712, 6, NULL, NULL),
(171, 1408391712, 5, NULL, NULL),
(172, 1408391712, 4, NULL, NULL),
(173, 1408391712, 3, NULL, NULL),
(174, 1408391712, 2, NULL, NULL),
(175, 1408391712, 1, NULL, NULL),
(176, 1408395540, 1, NULL, NULL),
(177, 1408395540, 2, NULL, NULL),
(178, 1408395540, 3, NULL, NULL),
(179, 1408395540, 4, NULL, NULL),
(180, 1408395540, 5, NULL, NULL),
(181, 1408395540, 6, NULL, NULL),
(182, 1408395540, 7, NULL, NULL),
(183, 1408395540, 8, NULL, NULL),
(184, 1408395540, 9, NULL, NULL),
(185, 1408395540, 10, NULL, NULL),
(186, 1408395540, 11, NULL, NULL),
(187, 1408395540, 12, NULL, NULL),
(188, 1408395540, 13, NULL, NULL),
(189, 1408395540, 14, NULL, NULL),
(190, 1408398046, 1, NULL, NULL),
(191, 1408398046, 2, NULL, NULL),
(192, 1408398046, 3, NULL, NULL),
(193, 1408398046, 4, NULL, NULL),
(194, 1408398046, 5, NULL, NULL),
(195, 1408398046, 6, NULL, NULL),
(196, 1408398046, 7, NULL, NULL),
(197, 1408398046, 8, NULL, NULL),
(198, 1408398046, 9, NULL, NULL),
(199, 1408398046, 10, NULL, NULL),
(200, 1408398046, 11, NULL, NULL),
(201, 1408398046, 12, NULL, NULL),
(202, 1408398046, 13, NULL, NULL),
(203, 1408398046, 14, NULL, NULL),
(204, 1408397314, 1, NULL, NULL),
(205, 1408397314, 2, NULL, NULL),
(206, 1408397314, 3, NULL, NULL),
(207, 1408397314, 4, NULL, NULL),
(208, 1408397314, 5, NULL, NULL),
(209, 1408397314, 6, NULL, NULL),
(210, 1408397314, 7, NULL, NULL),
(211, 1408397314, 8, NULL, NULL),
(212, 1408397314, 9, NULL, NULL),
(213, 1408397314, 10, NULL, NULL),
(214, 1408397314, 11, NULL, NULL),
(215, 1408397314, 12, NULL, NULL),
(216, 1408397314, 13, NULL, NULL),
(217, 1408397314, 14, NULL, NULL),
(218, 1408477067, 1, NULL, NULL),
(219, 1408477067, 2, NULL, NULL),
(220, 1408477067, 3, NULL, NULL),
(221, 1408477067, 4, NULL, NULL),
(222, 1408477067, 5, NULL, NULL),
(223, 1408477067, 6, NULL, NULL),
(224, 1408477067, 7, NULL, NULL),
(225, 1408477067, 8, NULL, NULL),
(226, 1408477067, 9, NULL, NULL),
(227, 1408477067, 10, NULL, NULL),
(228, 1408477067, 11, NULL, NULL),
(229, 1408477067, 12, NULL, NULL),
(230, 1408477067, 13, NULL, NULL),
(231, 1408477067, 14, NULL, NULL),
(232, 1408490414, 4, NULL, NULL),
(233, 1408490414, 6, NULL, NULL),
(234, 1408492951, 3, NULL, NULL),
(235, 1408492951, 6, NULL, NULL),
(236, 1408492951, 9, NULL, NULL),
(237, 1408492951, 12, NULL, NULL),
(238, 1408756754, 2, NULL, NULL),
(239, 1408756754, 4, NULL, NULL),
(240, 1408756754, 5, NULL, NULL),
(241, 1408756754, 7, NULL, NULL),
(242, 1408756754, 9, NULL, NULL),
(243, 1408756754, 11, NULL, NULL),
(244, 1408756754, 13, NULL, NULL),
(245, 1408757093, 1, NULL, NULL),
(246, 1408757093, 4, NULL, NULL),
(247, 1408757093, 6, NULL, NULL),
(248, 1408757093, 9, NULL, NULL),
(249, 1408757093, 11, NULL, NULL),
(250, 1409093762, 2, NULL, NULL),
(251, 1409093762, 5, NULL, NULL),
(252, 1409093762, 7, NULL, NULL),
(253, 1409093762, 9, NULL, NULL),
(254, 1409093762, 11, NULL, NULL),
(255, 1409095813, 1, NULL, NULL),
(256, 1409095813, 3, NULL, NULL),
(257, 1409095813, 4, NULL, NULL),
(258, 1409095813, 5, NULL, NULL),
(259, 1409095813, 6, NULL, NULL),
(260, 1409095813, 7, NULL, NULL),
(261, 1409095813, 8, NULL, NULL),
(262, 1409095813, 9, NULL, NULL),
(263, 1409095813, 10, NULL, NULL),
(264, 1409095813, 11, NULL, NULL),
(265, 1409097359, 3, NULL, NULL),
(266, 1409097359, 5, NULL, NULL),
(267, 1409097359, 8, NULL, NULL),
(268, 1409097359, 10, NULL, NULL),
(269, 1409097359, 12, NULL, NULL),
(270, 1409442143, 2, NULL, NULL),
(271, 1409442143, 4, NULL, NULL),
(272, 1409442143, 6, NULL, NULL),
(273, 1409442143, 8, NULL, NULL),
(274, 1409442143, 9, NULL, NULL),
(275, 1409476398, 1, NULL, NULL),
(276, 1409476398, 2, NULL, NULL),
(277, 1409476398, 3, NULL, NULL),
(278, 1409476398, 4, NULL, NULL),
(279, 1409476398, 5, NULL, NULL),
(280, 1409476398, 6, NULL, NULL),
(281, 1409476398, 7, NULL, NULL),
(282, 1409476398, 8, NULL, NULL),
(283, 1409476398, 9, NULL, NULL),
(284, 1409476398, 10, NULL, NULL),
(285, 1409476398, 11, NULL, NULL),
(286, 1409476398, 12, NULL, NULL),
(287, 1409476398, 13, NULL, NULL),
(288, 1409476398, 14, NULL, NULL),
(289, 1409476802, 1, NULL, NULL),
(290, 1409476802, 2, NULL, NULL),
(291, 1409476802, 3, NULL, NULL),
(292, 1409476802, 4, NULL, NULL),
(293, 1409476802, 7, NULL, NULL),
(294, 1409476802, 8, NULL, NULL),
(295, 1409476802, 10, NULL, NULL),
(296, 1409476802, 11, NULL, NULL),
(297, 1409476802, 13, NULL, NULL),
(298, 1409476802, 14, NULL, NULL),
(299, 1409488855, 1, NULL, NULL),
(300, 1409488855, 2, NULL, NULL),
(301, 1409488855, 3, NULL, NULL),
(302, 1409488855, 4, NULL, NULL),
(303, 1409488855, 5, NULL, NULL),
(304, 1409488855, 6, NULL, NULL),
(305, 1409488855, 7, NULL, NULL),
(306, 1409488855, 8, NULL, NULL),
(307, 1409488855, 9, NULL, NULL),
(308, 1409488855, 10, NULL, NULL),
(309, 1409488855, 11, NULL, NULL),
(310, 1409488855, 12, NULL, NULL),
(311, 1409488855, 13, NULL, NULL),
(312, 1409488855, 14, NULL, NULL),
(313, 1409489810, 1, NULL, NULL),
(314, 1409489810, 2, NULL, NULL),
(315, 1409489810, 3, NULL, NULL),
(316, 1409489810, 4, NULL, NULL),
(317, 1409489810, 5, NULL, NULL),
(318, 1409489810, 6, NULL, NULL),
(319, 1409489810, 7, NULL, NULL),
(320, 1409489810, 8, NULL, NULL),
(321, 1409489810, 9, NULL, NULL),
(322, 1409489810, 10, NULL, NULL),
(323, 1409489810, 11, NULL, NULL),
(324, 1409489810, 12, NULL, NULL),
(325, 1409489810, 13, NULL, NULL),
(326, 1409489810, 14, NULL, NULL),
(327, 1409676391, 1, NULL, NULL),
(328, 1409676391, 2, NULL, NULL),
(329, 1409676391, 3, NULL, NULL),
(330, 1409676391, 4, NULL, NULL),
(331, 1409676391, 5, NULL, NULL),
(332, 1409676391, 6, NULL, NULL),
(333, 1409676391, 7, NULL, NULL),
(334, 1409676391, 8, NULL, NULL),
(335, 1409676391, 9, NULL, NULL),
(336, 1409676391, 10, NULL, NULL),
(337, 1409676391, 11, NULL, NULL),
(338, 1409676391, 12, NULL, NULL),
(339, 1409676391, 13, NULL, NULL),
(340, 1409676391, 14, NULL, NULL),
(341, 1410205675, 7, NULL, NULL),
(342, 1410205675, 9, NULL, NULL),
(343, 1410205630, 2, NULL, NULL),
(344, 1410205630, 7, NULL, NULL),
(345, 1410205630, 14, NULL, NULL),
(346, 1410208131, 8, NULL, NULL),
(347, 1411614626, 4, NULL, NULL),
(348, 1411614655, 9, NULL, NULL),
(349, 1411614655, 14, NULL, NULL),
(350, 1412059352, 3, NULL, NULL),
(351, 1412059352, 6, NULL, NULL),
(352, 1412059352, 9, NULL, NULL),
(353, 1412060771, 10, NULL, NULL),
(354, 1412060771, 13, NULL, NULL),
(355, 1412060771, 14, NULL, NULL),
(356, 1412063315, 4, NULL, NULL),
(357, 1412063315, 8, NULL, NULL),
(358, 1412063315, 9, NULL, NULL),
(359, 1412063315, 11, NULL, NULL),
(360, 1412063315, 13, NULL, NULL),
(361, 1412063982, 3, NULL, NULL),
(362, 1412063982, 7, NULL, NULL),
(363, 1412063982, 12, NULL, NULL),
(364, 1412064036, 4, NULL, NULL),
(365, 1412064036, 5, NULL, NULL),
(366, 1412064036, 8, NULL, NULL),
(367, 1412064036, 9, NULL, NULL),
(368, 1412064036, 12, NULL, NULL),
(369, 1412193185, 7, NULL, NULL),
(370, 1412193185, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_log`
--

CREATE TABLE IF NOT EXISTS `transaction_log` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `sid` int(20) NOT NULL,
  `transaction` varchar(30) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(29) DEFAULT NULL,
  `cashier_id` int(20) DEFAULT NULL,
  `customer_id` int(20) DEFAULT NULL,
  `amount` varchar(29) DEFAULT NULL,
  `type` int(3) DEFAULT NULL,
  `tender` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `transaction_log`
--

INSERT INTO `transaction_log` (`id`, `sid`, `transaction`, `date`, `time`, `cashier_id`, `customer_id`, `amount`, `type`, `tender`, `status`) VALUES
(1, 21, '1412105835', '2014-09-30', '21:37:20', 2, NULL, '20', 1, 'Store Open', 1),
(2, 21, '1412105905', '2014-09-30', '21:39:48', 2, 121, '100', 7, '1', 1),
(3, 21, '1412105989', '2014-09-30', '21:45:15', 2, NULL, '20', 1, '3', 1),
(4, 21, '1412105989', '2014-09-30', '21:47:52', 2, NULL, '20', 1, '3', 1),
(5, 21, '1412105989', '2014-09-30', '21:48:15', 2, 121, '100', 7, '1', 1),
(6, 21, '1412106495', '2014-09-30', '21:49:17', 2, NULL, '0', 1, '3', 1),
(7, 21, '1412106495', '2014-09-30', '21:49:25', 2, 122, '200', 7, '1', 1),
(8, 21, '1412106565', '2014-09-30', '22:20:09', 2, 121, '100', 4, '1', 1),
(9, 21, '1412108410', '2014-09-30', '22:25:04', 2, NULL, '20', 1, '3', 1),
(10, 21, '1412108410', '2014-09-30', '22:25:28', 2, 1, '200', 4, '1', 1),
(11, 21, '1412108916', '2014-09-30', '22:34:05', 2, 121, '13', 4, '1', 1),
(12, 21, '1412109245', '2014-09-30', '22:35:00', 2, NULL, '30', 1, '3', 1),
(13, 21, '1412109245', '2014-09-30', '22:35:59', 2, 121, '100', 4, '1', 1),
(14, 21, '1412109360', '2014-09-30', '22:42:18', 2, NULL, '100', 1, '3', 1),
(15, 21, '1412109360', '2014-09-30', '22:42:38', 2, 1, '100', 4, '1', 1),
(16, 21, '1412109758', '2014-09-30', '22:42:52', 2, NULL, '200', 7, '3', 1),
(17, 21, '1412109758', '2014-09-30', '22:44:37', 2, NULL, '100', 1, '3', 1),
(18, 21, '1412109758', '2014-09-30', '22:44:59', 2, 1, '100', 4, '1', 1),
(19, 21, '1412109899', '2014-09-30', '22:45:04', 2, NULL, '-200', 7, '3', 1),
(20, 21, '1412109935', '2014-09-30', '22:45:49', NULL, 1, '-100', 6, '3', 1),
(21, 21, '1412110026', '2014-09-30', '22:47:18', NULL, 1, '-50', 6, '4', 1),
(22, 5, '1412193620', '2014-10-01', '22:00:31', NULL, 1, '-100', 6, '3', 1),
(23, 5, '1412197133', '2014-10-01', '23:07:51', 2, NULL, '20', 1, '3', 1),
(24, 5, '1412199361', '2014-10-01', '23:37:00', NULL, 1, '-100', 6, '3', 1),
(25, 5, '1412200032', '2014-10-01', '23:51:06', 2, NULL, '100', 1, '3', 1),
(26, 5, '1412200032', '2014-10-01', '23:51:33', 2, NULL, '20', 5, '3', 1),
(27, 5, '1412200436', '2014-10-01', '23:54:15', NULL, 1, '-50', 6, '3', 1),
(28, 5, '1412201517', '2014-10-02', '00:12:19', NULL, 1, '-100', 6, '4', 1),
(29, 5, '1412201576', '2014-10-02', '00:13:17', 2, 1, '102', 4, '1', 1),
(30, 5, '1412204644', '2014-10-02', '01:14:27', 2, 1, '102', 4, '1', 1),
(31, 5, '1412205267', '2014-10-02', '01:22:55', 2, NULL, '-150', 7, '3', 1),
(32, 5, '1412205267', '2014-10-02', '01:23:01', 2, NULL, '20', 1, '3', 1),
(33, 5, '1412205267', '2014-10-02', '01:24:10', 2, 1, '102', 4, '1', 1),
(34, 5, '1412208586', '2014-10-02', '02:10:00', NULL, 1, '-100', 6, '3', 1),
(35, 5, '1412208636', '2014-10-02', '02:10:54', NULL, 1, '-100', 6, '4', 1),
(36, 5, '1412205850', '2014-10-02', '02:11:53', 2, 1, '200', 4, '1', 1),
(37, 5, '1412208713', '2014-10-02', '02:20:16', 2, 121, '102', 4, '1', 1),
(38, 5, '1412209216', '2014-10-02', '02:24:16', 2, 124, '102', 4, '1', 1),
(39, 5, '1412271566', '2014-10-02', '19:39:38', 2, NULL, '-422', 7, '3', 1),
(40, 5, '1412271566', '2014-10-02', '19:39:46', 2, NULL, '20', 1, '3', 1),
(41, 5, '1412271670', '2014-10-02', '19:41:42', NULL, 1, '-10', 6, '3', 1),
(42, 5, '1412271833', '2014-10-02', '19:44:29', 2, 1, '102', 4, '1', 1),
(43, 5, '1412271870', '2014-10-02', '19:44:56', 2, NULL, '10', 5, '3', 1),
(44, 5, '1412271870', '2014-10-02', '19:45:21', 2, NULL, '-10', 5, '3', 1),
(45, 5, '1412271870', '2014-10-02', '20:06:48', 2, NULL, '-110', 7, '3', 1),
(46, 5, '1412271870', '2014-10-02', '20:34:37', 2, NULL, '20', 1, '3', 1),
(47, 5, '1412271870', '2014-10-02', '20:34:59', 2, NULL, '-20', 7, '3', 1),
(48, 5, '1412271870', '2014-10-02', '20:35:13', 2, NULL, '20', 1, '3', 1),
(49, 5, '1412271870', '2014-10-02', '20:56:30', 2, NULL, '-20', 7, '3', 1),
(50, 5, '1412271870', '2014-10-02', '20:56:45', 2, NULL, '30', 1, '3', 1),
(51, 5, '1412271870', '2014-10-02', '20:56:49', 2, NULL, '-30', 7, '3', 1),
(52, 5, '1412271870', '2014-10-02', '21:06:40', 2, NULL, '20', 1, '3', 1),
(53, 5, '1412271870', '2014-10-02', '21:06:44', 2, NULL, '-20', 7, '3', 1),
(54, 5, '1412271870', '2014-10-02', '21:09:01', 2, NULL, '20', 1, '3', 1),
(55, 5, '1412271870', '2014-10-02', '21:09:05', 2, NULL, '-20', 7, '3', 1),
(56, 5, '1412271870', '2014-10-02', '21:21:27', 2, NULL, '100', 1, '3', 1),
(57, 5, '1412271870', '2014-10-02', '21:21:34', 2, NULL, '-100', 7, '3', 1),
(58, 5, '1412271870', '2014-10-02', '21:22:39', 2, NULL, '100', 1, '3', 1),
(59, 5, '1412271870', '2014-10-02', '21:22:43', 2, NULL, '-100', 7, '3', 1),
(60, 5, '1412271870', '2014-10-02', '21:32:19', 2, NULL, '20', 1, '3', 1),
(61, 5, '1412271870', '2014-10-02', '21:32:26', 2, NULL, '20', 5, '3', 1),
(62, 5, '1412271870', '2014-10-02', '21:46:09', 2, NULL, '-40', 7, '3', 1),
(63, 5, '1412271870', '2014-10-02', '21:50:20', 2, NULL, '20', 1, '3', 1),
(64, 5, '1412271870', '2014-10-02', '21:51:24', 2, NULL, '-20', 7, '3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE IF NOT EXISTS `vendor` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `account_num` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state_cun` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `name`, `email`, `account_num`, `phone`, `address`, `city`, `state_cun`, `zip`, `web`, `notes`, `date`, `status`) VALUES
(2, 'AMS Information Technologys', 'mdmahamodurzaman@gmail.com', '123456', '01927608261', '44/P, Kazi Bhvan, New Zigatola Road, DHanmondi, Dhaka-1209', 'Dhaka', 'Bangladesh', '1209', 'www.amsitsoft.com', 'ffsdafdsfdsfsdf', '2014-08-27', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
