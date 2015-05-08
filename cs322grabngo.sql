-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2015 at 08:19 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cs322grabngo`
--

-- --------------------------------------------------------

--
-- Table structure for table `itemlocationjoin`
--

CREATE TABLE IF NOT EXISTS `itemlocationjoin` (
  `itemlocation_pk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_fk` int(10) unsigned NOT NULL,
  `location_fk` int(10) unsigned NOT NULL,
  PRIMARY KEY (`itemlocation_pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;

--
-- Dumping data for table `itemlocationjoin`
--

INSERT INTO `itemlocationjoin` (`itemlocation_pk`, `item_fk`, `location_fk`) VALUES
(1, 1, 2),
(2, 2, 2),
(3, 3, 2),
(4, 4, 2),
(5, 5, 2),
(6, 6, 2),
(7, 7, 2),
(8, 8, 2),
(9, 9, 2),
(10, 10, 2),
(11, 11, 2),
(12, 12, 2),
(13, 13, 2),
(14, 14, 2),
(15, 15, 2),
(16, 16, 2),
(17, 17, 2),
(18, 18, 2),
(19, 19, 2),
(20, 20, 2),
(21, 21, 2),
(22, 22, 2),
(23, 23, 2),
(24, 24, 2),
(25, 25, 2),
(26, 26, 2),
(27, 27, 2),
(28, 28, 2),
(29, 29, 2),
(30, 30, 2),
(31, 31, 2),
(32, 32, 2),
(33, 33, 2),
(34, 34, 2),
(35, 35, 2),
(36, 36, 2),
(37, 37, 2),
(38, 38, 2),
(39, 39, 2),
(40, 40, 2),
(41, 41, 2),
(42, 42, 2),
(43, 43, 2),
(44, 44, 2),
(45, 45, 2),
(46, 46, 2),
(47, 47, 2),
(48, 48, 2);

-- --------------------------------------------------------

--
-- Table structure for table `itemorderjoin`
--

CREATE TABLE IF NOT EXISTS `itemorderjoin` (
  `itemsorder_pk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_fk` int(10) unsigned NOT NULL,
  `order_pk` int(10) unsigned NOT NULL,
  PRIMARY KEY (`itemsorder_pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `item_pk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `item_desc` text COLLATE utf8_unicode_ci,
  `item_point_value` tinyint(3) unsigned NOT NULL,
  `item_allergen_info` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`item_pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=133 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_pk`, `item_name`, `item_desc`, `item_point_value`, `item_allergen_info`) VALUES
(1, 'Soda', 'Pepsi, Mtn Dew, Root Beer, Cherry Pepsi, Coke, Diet Coke', 3, 'None'),
(2, 'Boiled Eggs', '', 2, ''),
(3, 'Assorted Sandwiches', 'Beef and Cheddar, Turkey and Swiss, Italian, Ham and Cheese', 8, 'Dairy'),
(4, 'Cottage Cheese', '', 2, 'Dairy'),
(5, 'Hummus Pretzel Cup', 'Hummus with Pretzels!', 5, ''),
(6, 'Frozen Strawberry Cup', '', 3, ''),
(7, 'Carrots, Celery, Ranch Dip', '', 4, ''),
(8, 'Chocolate Chip Cookie', '', 3, ''),
(9, 'Brownie', '', 3, ''),
(10, 'Applesauce', '', 3, ''),
(11, 'Mandarin Oranges', '', 1, ''),
(12, 'Pudding', '', 1, ''),
(13, 'Trail Mix', '', 2, ''),
(14, 'Fruit Buddies', '', 2, ''),
(15, 'Almonds', '', 4, ''),
(16, 'Dried Fruit', '', 4, ''),
(17, 'Greek Yogurt', '', 3, ''),
(18, 'Uncrustable', 'Peanut Butter and Jelly', 3, ''),
(19, 'Protein Bar', '', 3, ''),
(20, 'Bagel', '', 2, ''),
(21, 'Croissant', '', 2, ''),
(22, 'Clif Bar', '', 4, ''),
(23, 'Apple Dipper', '', 4, ''),
(24, 'Granola Bar', '', 2, ''),
(25, 'Yogurt Bar', '', 2, ''),
(26, 'Assorted Chips', '', 2, ''),
(27, 'Fresh Fruit', '', 1, ''),
(28, 'Fruit roll Ups', '', 1, ''),
(29, 'Cream Cheese', '', 1, ''),
(30, 'Peanut Butter', '', 1, ''),
(31, 'String Cheese', '', 2, ''),
(32, 'Milk', 'Chocolate, Skim, 2% ', 3, ''),
(33, 'Izze', '', 2, ''),
(34, 'Arizona tea', '', 2, ''),
(35, 'Yogurt Smoothies', '', 5, ''),
(36, 'Gatorade', '', 4, ''),
(37, 'Apple Juice', '', 3, ''),
(38, 'Orange Juice', '', 3, ''),
(39, 'Pearl Soy Milk', 'Chocolate or Vanilla', 5, ''),
(40, 'Asst Naked Juice', '', 8, ''),
(41, 'Frappuccino ', 'Mocha or Vanilla', 5, ''),
(42, 'Coffee', '', 2, ''),
(43, 'Hot Tea', '', 2, ''),
(44, 'Hot Cocoa', '', 2, ''),
(45, 'Soda', 'Coke, Diet Coke, Pepsi, Cherri Pepsi, Mountain Dew, Root Beer, Sprite', 3, ''),
(46, 'Water', 'H20', 3, ''),
(47, 'Lemonade', '', 3, ''),
(48, 'Cappuccino', 'Cap-puccino', 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `location_pk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_name` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `location_time_open` time NOT NULL,
  `location_time_closed` time NOT NULL,
  `location_info` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`location_pk`),
  UNIQUE KEY `location_name` (`location_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_pk`, `location_name`, `location_time_open`, `location_time_closed`, `location_info`) VALUES
(1, 'Post Grab And Go Breakfast', '07:30:00', '10:00:00', ''),
(2, 'Post Grab and Go Lunch', '10:30:00', '01:30:00', ''),
(3, 'Seymour Grab and Go Lunch', '11:00:00', '01:30:00', ''),
(4, 'Seymour Grab And Go Breakfast', '07:30:00', '10:00:00', 'In The Oak Room');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_pk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_fk` int(10) unsigned NOT NULL,
  `location_fk` int(10) unsigned NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders_saved`
--

CREATE TABLE IF NOT EXISTS `orders_saved` (
  `ordersaved_pk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_fk` int(10) unsigned NOT NULL,
  `location_fk` int(10) unsigned NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ordersaved_pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_pk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_password` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Could also be username in case of account created by super-admin',
  `account_type` tinyint(3) unsigned NOT NULL COMMENT '1-User/2-Admin/3-SuperAdmin',
  PRIMARY KEY (`user_pk`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_pk`, `user_password`, `user_email`, `account_type`) VALUES
(1, 'a8AYJPgXub7A6', 'grabngoadmin@knox.edu', 2),
(2, 'a8AYJPgXub7A6', 'grabngouser@knox.edu', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
