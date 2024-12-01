-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 04:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopcart`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyers`
--

CREATE TABLE `buyers` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(12) NOT NULL,
  `address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buyers`
--

INSERT INTO `buyers` (`id`, `fname`, `lname`, `email`, `password`, `contact_number`, `address`) VALUES
(71, 'Mathew', 'Laresma', 'matl@gmail.com', '$2y$10$qvyWz2RSVzjrcyrrIB4AbuQM6L3X07hLh0BMbjUrVnl4z4D2pe/jm', '9100005146', 'Talisay'),
(72, 'Mathew', 'Laresma', 'mat@gmail.com', '$2y$10$xTt.nVcGmTFfPNh7nNMwjOowaFv3v55iuUmUDmVaCpKa/3Yc5vwM2', '9100005146', 'Aloguinsan');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `product_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_image` longblob NOT NULL,
  `item_price` int(11) NOT NULL,
  `item_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `total_products` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `name`, `contact_number`, `email`, `payment_method`, `address`, `total_products`, `total_price`) VALUES
(66, 'Laresma Mathew', '', '', 'cash on delivery', '', 'shoes (1), laptop (1)', '1799'),
(67, 'Laresma Mathew', '', '', 'cash on delivery', '', 'laptop (3)', '2997'),
(68, '', '', '', 'gcash', '', 'shoes (1)', '800'),
(69, '', '', '', 'cash on delivery', '', 'shoes (1)', '800'),
(70, 'Laresma Mathew', '', '', 'cash on delivery', '', 'laptop (1), shoes (1)', '1799'),
(71, 'Laresma Mathew', '', '', 'cash on delivery', '', 'laptop (1)', '999'),
(72, 'Laresma Mathew', '', '', 'cash on delivery', '', 'shoes (1)', '800'),
(73, 'Laresma Mathew', '9100005146', '', 'cash on delivery', '', 'laptop (1)', '999'),
(74, 'Laresma Mathew', '9770287882', '', 'cash on delivery', '', 'laptop (1)', '999'),
(75, 'Laresma Mathew', '9770287882', '', 'cash on delivery', '', 'laptop (1), shoes (1)', '1799'),
(76, 'Laresma Mathew', '9770287882', '', 'cash on delivery', 'Aloguinsan', 'shoes (1)', '800'),
(77, 'Laresma Mathew', '9770287882', 'laresma@gmail.com', 'cash on delivery', 'Aloguinsan', 'laptop (1)', '999'),
(78, 'Laresma Mathew', '9770287882', 'laresma@gmail.com', 'cash on delivery', 'Aloguinsan', 'shoes (1)', '800'),
(79, 'Laresma Mathew', '9770287882', 'laresma@gmail.com', 'cash on delivery', 'Aloguinsan', 'shoes (1), laptop (1)', '1799'),
(80, 'Laresma Mathew', '9770287882', 'laresma@gmail.com', 'cash on delivery', 'Aloguinsan', 'laptop (1), shoes (1)', '1799'),
(81, 'Laresma Mathew', '9770287882', 'laresma@gmail.com', 'cash on delivery', 'Aloguinsan', 'shoes (6)', '4800'),
(82, 'Laresma Mathew', '9770287882', 'laresma@gmail.com', 'cash on delivery', 'Aloguinsan', 'laptop (1), shoes (1)', '1799'),
(83, 'Laresma Mathew', '9770287882', 'laresma@gmail.com', 'cash on delivery', 'Aloguinsan', 'shoes (2), laptop (1)', '2599'),
(84, 'Laresma Mathew', '9770287882', 'laresma@gmail.com', 'cash on delivery', 'Aloguinsan', 'laptop (1)', '999'),
(85, 'Laresma Mathew', '9770287882', 'laresma@gmail.com', 'cash on delivery', 'Aloguinsan', 'laptop (1)', '999'),
(86, 'Laresma Mathew', '9770287882', 'laresma@gmail.com', 'cash on delivery', 'Aloguinsan', 'shoes (1)', '800'),
(87, 'Laresma Mathew', '9100005146', 'laresma@gmail.com', 'cash on delivery', 'Talisay', 'laptop (1), shoes (1)', '1799'),
(88, 'Laresma Mathew', '9100005146', 'laresma@gmail.com', 'cash on delivery', 'Talisay', 'shoes (6)', '4800'),
(89, 'Laresma Mathew', '9100005146', 'laresma@gmail.com', 'cash on delivery', 'Talisay', 'shoes (1), laptop (3)', '3797'),
(90, 'Laresma Mathew', '9100005146', 'laresma@gmail.com', 'cash on delivery', 'Talisay', 'shoes (2)', '1600'),
(91, 'Laresma Mathew', '9100005146', 'laresma@gmail.com', 'cash on delivery', 'Talisay', 'laptop (1)', '999'),
(92, 'Laresma Mathew', '9100005146', 'laresma@gmail.com', 'cash on delivery', 'Talisay', 'laptop (1)', '999'),
(93, 'Laresma Mathew', '9100005146', 'laresma@gmail.com', 'cash on delivery', 'Talisay', 'shoes (1), laptop (1)', '1799'),
(94, 'Laresma Mathew', '9100005146', 'laresma@gmail.com', 'cash on delivery', 'Talisay', 'shoes (1)', '800'),
(95, 'Mathew Laresma', '9332874674', 'mat3@gmail.com', 'cash on delivery', 'Aloguinsan', 'shoes (1), laptop (1)', '1799'),
(96, 'Mathew Laresma', '9332874674', 'mat3@gmail.com', 'cash on delivery', 'Aloguinsan', 'laptop (1), shoes (2)', '2599'),
(97, 'Mathew Laresma', '9332874674', 'mat3@gmail.com', 'cash on delivery', 'Aloguinsan', 'shoes (1)', '800'),
(98, 'Mathew Laresma', '9100005146', 'mat@gmail.com', 'cash on delivery', 'Aloguinsan', 'Wilson Basketball (1), Steph Curry x Bruce Lee Basketball shoes (1), Herschel Backpack (1)', '2098'),
(99, 'Mathew Laresma', '9100005146', 'matl@gmail.com', 'gcash', 'Talisay', 'Wilson Basketball (1), Steph Curry x Bruce Lee Basketball shoes (1), Herschel Backpack (1)', '2098'),
(100, 'Mathew Laresma', '9100005146', 'mat@gmail.com', 'cash on delivery', 'Aloguinsan', 'Wilson Basketball (1), Steph Curry x Bruce Lee Basketball shoes (1), Herschel Backpack (1)', '2098');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_image` longblob NOT NULL,
  `item_desc` varchar(255) NOT NULL,
  `item_price` int(11) NOT NULL,
  `stocks` int(11) NOT NULL,
  `product_category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `item_name`, `item_image`, `item_desc`, `item_price`, `stocks`, `product_category`) VALUES
(46, 'Wilson Basketball', 0x696d6167657320283132292e6a7067, 'durable and has original weight', 500, 17, 'sports and hobbies'),
(47, 'Steph Curry x Bruce Lee Basketball shoes', 0x6375727279206272756365206c65652073686f652e6a7067, 'durable and high traction', 999, 97, 'sports and hobbies'),
(48, 'Herschel Backpack', 0x696d61676573202834292e6a7067, 'durable ', 599, 196, 'Bags');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `seller_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(12) NOT NULL,
  `address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`seller_id`, `first_name`, `last_name`, `email`, `password`, `contact_number`, `address`) VALUES
(17, 'Mathew', 'Laresma', 'mat@gmail.com', '$2y$10$KhiqNOQGORZgER3LqiYAS.MJOJ4IsRlnDtmog6AGUpiRksYZ3fVs6', '0', ''),
(18, 'Mathew', 'Laresma', 'matt@gmail.com', '$2y$10$QvIiFghxv8aidEJPeU9tM.gDRDY1zq6IjzDF0mhVdg9woM78YWGOW', '', ''),
(19, 'Math', 'Laresma', 'math@gmail.com', '$2y$10$nslP7/4ix/BysF/t5cze1uBQSjXABK/I8KDOZYmCzE8AlOdk26cmq', '', ''),
(20, 'Mathwe', 'Laresma', 'mat8@gmail.com', '$2y$10$28IKMgChT3f4/QtpulqURe2QaVLdwH2x0i5oa4.ufBGnnz4XsOTi6', '', ''),
(21, 'Mathwe', 'Laresma', 'mth@gmail.com', '$2y$10$sKq7tlJ4H12WGM0n/zToq.YAO6HPOj3yM1BdRqbiwRCQrRF9g84jC', '', ''),
(22, 'Math', 'Laresma', 'mate@gmail.com', '$2y$10$FqVvyW52xwRhaZF0tZlz/urHSyStykLA/LlkxV6LzeJ8ICu89jze6', '', ''),
(23, 'Math', 'Laresma', 't@gmail.com', '$2y$10$VIJFikuJmqRGErRrI8Fke.AWYWV/dk6iiZKQlZkHv6OVphvTw3c5y', '123-456-7890', '123 Main St, Anytown, USA'),
(24, 'Math', 'Laresma', 'tam@gmail.com', '$2y$10$WcmHgbHcCrND3V7SMtQcLuBS4LJx77zboHTrY3q2A9HkmpnMWF1KK', '123-456-7890', '123 Main St, Anytown, USA'),
(25, 'Mathew', 'Laresma', 'mathewll@gmail.com', '$2y$10$JdpUo2q3Pf0Wvlu5ptWBjem5zfYxRf.XZBVAziYU6645WbPRYsVXu', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `name` varchar(255) NOT NULL,
  `contact_number` int(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyers`
--
ALTER TABLE `buyers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`seller_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyers`
--
ALTER TABLE `buyers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
