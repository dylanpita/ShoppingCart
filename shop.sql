-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 11, 2019 at 05:43 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `store_categories`
--

DROP TABLE IF EXISTS `store_categories`;
CREATE TABLE IF NOT EXISTS `store_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(50) DEFAULT NULL,
  `cat_desc` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_categories`
--

INSERT INTO `store_categories` (`id`, `cat_title`, `cat_desc`) VALUES
(1, 'Hats', 'Funky hats in all shapes and sizes!'),
(2, 'Shirts', 'From t-shirts to sweatshirts to polo shirts and beyond'),
(3, 'Books', 'Paperback, hardback, books for school or play ');

-- --------------------------------------------------------

--
-- Table structure for table `store_items`
--

DROP TABLE IF EXISTS `store_items`;
CREATE TABLE IF NOT EXISTS `store_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `item_title` varchar(75) DEFAULT NULL,
  `item_price` float DEFAULT NULL,
  `item_desc` text,
  `item_image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_items`
--

INSERT INTO `store_items` (`id`, `cat_id`, `item_title`, `item_price`, `item_desc`, `item_image`) VALUES
(1, 1, 'Baseball Hat', 12, 'Fancy, low-profile baseball hat.', 'baseballhat.jpg'),
(2, 1, 'Cowboy hat', 52, '10 gallon variety', 'cowboyhat.jpg'),
(3, 1, 'Top Hat', 102, 'good for costumes', 'tophat.jpg'),
(4, 2, 'Short-Sleeved T-Shirt', 12, '100% cotton, pre-shrunk', 'sstshirt.jpg'),
(5, 2, 'Long-Sleeved T-Shirt', 15, 'Just like the short-sleeved shirt, with longer sleeves', 'lstshirt.gif'),
(6, 2, 'Sweatshirt', 22, 'Heavy and warm', 'sweatshirt.jpg'),
(7, 3, 'Jane\\\'s Self-Help Book ', 12, 'Jane gives advice', 'selfhelpbook.gif'),
(8, 3, 'Generic Academic Book', 35, 'Some required reading for school, will put you to sleep.', 'boringbook.jpg'),
(9, 3, 'Chicago Manual of Style', 9.99, 'Good for copywriters', 'chicagostyle.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `store_item_color`
--

DROP TABLE IF EXISTS `store_item_color`;
CREATE TABLE IF NOT EXISTS `store_item_color` (
  `item_id` int(11) NOT NULL,
  `item_color` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_item_color`
--

INSERT INTO `store_item_color` (`item_id`, `item_color`) VALUES
(1, 'red'),
(1, 'black'),
(1, 'blue');

-- --------------------------------------------------------

--
-- Table structure for table `store_item_qty`
--

DROP TABLE IF EXISTS `store_item_qty`;
CREATE TABLE IF NOT EXISTS `store_item_qty` (
  `item_id` int(11) NOT NULL,
  `item_color` varchar(25) DEFAULT NULL,
  `item_size` varchar(25) DEFAULT NULL,
  `item_qty` int(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_item_qty`
--

INSERT INTO `store_item_qty` (`item_id`, `item_color`, `item_size`, `item_qty`) VALUES
(1, 'red', 'One Size Fits All', 63),
(1, 'blue', 'One Size Fits All', 49),
(1, 'black', 'One Size Fits All', 0),
(2, 'N/A', 'One Size Fits All', 45),
(3, 'N/A', 'One Size Fits All', 0),
(4, 'N/A', 'L', 0),
(5, 'N/A', 'N/A', 50),
(6, 'N/A', 'N/A', 25),
(7, 'N/A', 'N/A', 18),
(8, 'N/A', 'N/A', 0),
(9, 'N/A', 'N/A', 1),
(4, 'N/A', 'XL', 58),
(4, 'N/A', 'M', 50),
(4, 'N/A', 'S', 95);

-- --------------------------------------------------------

--
-- Table structure for table `store_item_size`
--

DROP TABLE IF EXISTS `store_item_size`;
CREATE TABLE IF NOT EXISTS `store_item_size` (
  `item_id` int(11) NOT NULL,
  `item_size` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_item_size`
--

INSERT INTO `store_item_size` (`item_id`, `item_size`) VALUES
(1, 'One Size Fits All'),
(2, 'One Size Fits All'),
(3, 'One Size Fits All'),
(4, 'S'),
(4, 'M'),
(4, 'L'),
(4, 'XL');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
