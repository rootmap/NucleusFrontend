-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2014 at 03:34 AM
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
-- Stand-in structure for view `cashier_list`
--
CREATE TABLE IF NOT EXISTS `cashier_list` (
`id` int(20)
,`name` varchar(255)
,`username` varchar(255)
,`password` varchar(255)
,`email` varchar(255)
,`sex` varchar(255)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `checkin_list`
--
CREATE TABLE IF NOT EXISTS `checkin_list` (
`id` int(20)
,`checkin_id` int(20)
,`fullname` varchar(510)
,`email` varchar(255)
,`phone` varchar(255)
,`device` varchar(255)
,`model` varchar(255)
,`color` varchar(20)
,`network` varchar(255)
,`problem` varchar(255)
,`warrenty` int(20)
,`lcdstatus` bigint(11)
,`date` date
,`status` int(20)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `highest_sales`
--
CREATE TABLE IF NOT EXISTS `highest_sales` (
`id` int(20)
,`cashier` varchar(255)
,`sales` bigint(21)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `max_sales`
--
CREATE TABLE IF NOT EXISTS `max_sales` (
`id` bigint(20)
,`cashier` varchar(255)
,`max_sales` bigint(21)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `product_report`
--
CREATE TABLE IF NOT EXISTS `product_report` (
`id` int(20)
,`barcode` varchar(255)
,`name` varchar(255)
,`ourcost` varchar(255)
,`retailcost` varchar(255)
,`reorder` varchar(255)
,`quantity` varchar(255)
,`soldquantity` decimal(41,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `sales_list`
--
CREATE TABLE IF NOT EXISTS `sales_list` (
`id` int(20)
,`sales_id` int(20)
,`payment_method` int(20)
,`cashier_id` int(20)
,`cashier` varchar(255)
,`product` varchar(255)
,`quantity` int(20)
,`single_cost` varchar(20)
,`our_cost` varchar(255)
,`totalcost` varchar(20)
,`our_totalcost` double
,`profit` double
,`date` date
,`datetime` varchar(255)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `tender_payment`
--
CREATE TABLE IF NOT EXISTS `tender_payment` (
`id` int(20)
,`pm` int(20)
,`name` varchar(255)
,`cid` int(20)
,`customer` varchar(255)
,`creator` int(20)
,`invoice_id` int(20)
,`amount` varchar(20)
,`date` date
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `tender_report`
--
CREATE TABLE IF NOT EXISTS `tender_report` (
`id` int(20)
,`name` varchar(255)
,`amount` double
,`date` date
);
-- --------------------------------------------------------

--
-- Structure for view `cashier_list`
--
DROP TABLE IF EXISTS `cashier_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cashier_list` AS select `cashier`.`id` AS `id`,`cashier`.`name` AS `name`,`cashier`.`username` AS `username`,`cashier`.`password` AS `password`,`cashier`.`email` AS `email`,(select `gender`.`name` from `gender` where (`gender`.`id` = `cashier`.`gender`)) AS `sex` from `cashier`;

-- --------------------------------------------------------

--
-- Structure for view `checkin_list`
--
DROP TABLE IF EXISTS `checkin_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `checkin_list` AS select `checkin_request`.`id` AS `id`,`checkin_request`.`checkin_id` AS `checkin_id`,concat(`checkin_request`.`first_name`,`checkin_request`.`last_name`) AS `fullname`,`checkin_request`.`email` AS `email`,`checkin_request`.`phone` AS `phone`,(select `checkin`.`name` from `checkin` where (`checkin`.`id` = `checkin_request`.`device_id`)) AS `device`,(select `checkin_version`.`name` from `checkin_version` where (`checkin_version`.`id` = `checkin_request`.`model_id`)) AS `model`,(select `checkin_version_color`.`name` from `checkin_version_color` where (`checkin_version_color`.`id` = `checkin_request`.`color_id`)) AS `color`,(select `checkin_network`.`name` from `checkin_network` where (`checkin_network`.`id` = `checkin_request`.`network_id`)) AS `network`,(select `checkin_problem`.`name` from `checkin_problem` where (`checkin_problem`.`id` = `checkin_request`.`problem_id`)) AS `problem`,`checkin_request`.`warrenty` AS `warrenty`,(select `checkin_request_ticket`.`lcdstatus` from `checkin_request_ticket` where (`checkin_request_ticket`.`checkin_id` = `checkin_request`.`checkin_id`)) AS `lcdstatus`,`checkin_request`.`date` AS `date`,`checkin_request`.`status` AS `status` from `checkin_request`;

-- --------------------------------------------------------

--
-- Structure for view `highest_sales`
--
DROP TABLE IF EXISTS `highest_sales`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `highest_sales` AS select distinct `sales_list`.`cashier_id` AS `id`,`sales_list`.`cashier` AS `cashier`,count(`sales_list`.`cashier_id`) AS `sales` from `sales_list` group by `sales_list`.`cashier_id`;

-- --------------------------------------------------------

--
-- Structure for view `max_sales`
--
DROP TABLE IF EXISTS `max_sales`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `max_sales` AS select `highest_sales`.`id` AS `id`,`highest_sales`.`cashier` AS `cashier`,max(`highest_sales`.`sales`) AS `max_sales` from `highest_sales`;

-- --------------------------------------------------------

--
-- Structure for view `product_report`
--
DROP TABLE IF EXISTS `product_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product_report` AS select `product`.`id` AS `id`,`product`.`barcode` AS `barcode`,`product`.`name` AS `name`,`product`.`price_cost` AS `ourcost`,`product`.`price_retail` AS `retailcost`,`product`.`reorder` AS `reorder`,`product`.`quantity` AS `quantity`,(select sum(`sales`.`quantity`) from `sales` where (`sales`.`pid` = `product`.`id`)) AS `soldquantity` from `product`;

-- --------------------------------------------------------

--
-- Structure for view `sales_list`
--
DROP TABLE IF EXISTS `sales_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sales_list` AS select `sales`.`id` AS `id`,`sales`.`sales_id` AS `sales_id`,`sales`.`payment_method` AS `payment_method`,`sales`.`cashier_id` AS `cashier_id`,(select `cashier_list`.`name` from `cashier_list` where (`cashier_list`.`id` = `sales`.`cashier_id`)) AS `cashier`,(select `product`.`name` from `product` where (`product`.`id` = `sales`.`pid`)) AS `product`,`sales`.`quantity` AS `quantity`,`sales`.`single_cost` AS `single_cost`,(select `product`.`price_cost` from `product` where (`product`.`id` = `sales`.`pid`)) AS `our_cost`,`sales`.`totalcost` AS `totalcost`,((select `product`.`price_cost` from `product` where (`product`.`id` = `sales`.`pid`)) * `sales`.`quantity`) AS `our_totalcost`,(`sales`.`totalcost` - ((select `product`.`price_cost` from `product` where (`product`.`id` = `sales`.`pid`)) * `sales`.`quantity`)) AS `profit`,`sales`.`date` AS `date`,`sales`.`datetime` AS `datetime` from `sales`;

-- --------------------------------------------------------

--
-- Structure for view `tender_payment`
--
DROP TABLE IF EXISTS `tender_payment`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tender_payment` AS select `invoice_payment`.`id` AS `id`,`invoice_payment`.`payment_type` AS `pm`,(select `payment_method`.`meth_name` from `payment_method` where (`payment_method`.`id` = `invoice_payment`.`payment_type`)) AS `name`,`invoice_payment`.`cid` AS `cid`,(select `coustomer`.`firstname` from `coustomer` where (`coustomer`.`id` = `invoice_payment`.`cid`)) AS `customer`,`invoice_payment`.`invoice_creator` AS `creator`,`invoice_payment`.`invoice_id` AS `invoice_id`,`invoice_payment`.`amount` AS `amount`,`invoice_payment`.`date` AS `date` from `invoice_payment`;

-- --------------------------------------------------------

--
-- Structure for view `tender_report`
--
DROP TABLE IF EXISTS `tender_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tender_report` AS select `payment_method`.`id` AS `id`,`payment_method`.`meth_name` AS `name`,(select sum(`invoice_payment`.`amount`) from `invoice_payment` where (`invoice_payment`.`payment_type` = `payment_method`.`id`)) AS `amount`,`payment_method`.`date` AS `date` from `payment_method`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
