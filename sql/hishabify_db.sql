-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2025 at 10:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hishabify_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `audit_id` int(11) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `performed_by` enum('Owner','Manager') DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`, `location`, `contact_number`, `open_time`, `close_time`, `owner_id`) VALUES
(1, 'Main Branch', 'Dhanmondi', '01712345678', '09:00:00', '21:00:00', 5),
(2, 'Dhanmondi Branch', 'Dhanmondi', '015xxxxxxx', '11:23:00', '23:23:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`) VALUES
(1, 'SmartPhone'),
(2, 'Feature Phones'),
(3, 'Phone Cases'),
(4, 'Screen Protectors'),
(5, 'Chargers'),
(6, 'Power Banks'),
(7, 'Bluetooth Headsets'),
(8, 'Wired Earphones'),
(9, 'Mobile Speakers'),
(10, 'SIM Cards'),
(11, 'Mobile Repair'),
(12, 'Mobile Recharge'),
(13, 'Memory Cards'),
(14, 'Cables & Connectors'),
(15, 'Smartwatches');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `address`, `phone`) VALUES
(1, 'anwar', 'dhaka', NULL),
(2, 'anwar', 'dhaka', 'd'),
(3, 'xxx', 'x', '015xxxxxxxx'),
(4, 'fdqwf', 'fqwefqfe', 'faefae');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `nid` varchar(20) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `total_sales` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `name`, `phone`, `nid`, `join_date`, `designation`, `manager_id`, `branch_id`, `total_sales`) VALUES
(1, 'afridi', '96786', '231212', '2025-08-05', 'salesman', 1, 1, 1),
(2, 'rupom', 'xxxxxxxxx', '2412', '2025-08-05', 'salesman', 2, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

CREATE TABLE `login_log` (
  `log_id` int(11) NOT NULL,
  `user_type` enum('Owner','Manager') DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `login_time` datetime DEFAULT current_timestamp(),
  `ip_address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_log`
--

INSERT INTO `login_log` (`log_id`, `user_type`, `user_id`, `login_time`, `ip_address`) VALUES
(1, 'Owner', 5, '2025-08-05 10:45:36', '::1'),
(2, 'Manager', 1, '2025-08-05 10:46:37', '::1'),
(3, 'Manager', 1, '2025-08-05 11:23:02', '::1'),
(4, 'Owner', 5, '2025-08-05 11:23:15', '::1'),
(5, 'Manager', 2, '2025-08-05 11:28:00', '::1'),
(6, 'Owner', 5, '2025-08-05 11:35:17', '::1'),
(7, 'Owner', 5, '2025-08-05 13:28:12', '::1'),
(8, 'Owner', 5, '2025-08-05 13:35:03', '::1'),
(9, 'Owner', 5, '2025-08-05 13:48:49', '::1'),
(10, 'Manager', 1, '2025-08-05 13:49:22', '::1'),
(11, 'Owner', 5, '2025-08-05 13:50:31', '::1'),
(12, 'Manager', 2, '2025-08-05 14:19:06', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `manager_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `total_sales` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`manager_id`, `name`, `email`, `password`, `phone`, `hire_date`, `branch_id`, `total_sales`) VALUES
(1, 'Manager Rakin', 'manager@hishabify.com', '$2y$10$SFF7jQoBWr0VHJbWozPnqu2J7hOMj75r9/r0v.v5C0chJw25Zz1LC', '01722222222', '2024-01-01', 1, 1),
(2, 'swapnil', 'swapnil@hishabify.com', '$2y$10$K2lmjFB6yH0oJV8VvTve2OYiTxPsh2MRyb1kLHDWi1/tbqWHBCRi.', 'xxxxxxxxx', '2025-08-05', 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`owner_id`, `name`, `email`, `password`, `phone`, `address`) VALUES
(5, 'Admin Anwar', 'admin@hishabify.com', '$2y$10$lf1oTxGCGQM4seROJ77L4esC3BLwsyGzM2.T1alW743xLzZJSNcau', '01711111111', 'Dhaka');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `method` enum('Cash','Card','bKash','Nagad') DEFAULT 'Cash',
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `sale_id`, `method`, `amount`) VALUES
(1, 2, 'Cash', 45000.00),
(2, 3, 'Cash', 5400.00),
(3, 4, 'Cash', 450000.00);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `warranty_months` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `brand`, `model`, `price`, `stock`, `warranty_months`, `description`, `branch_id`, `category_id`) VALUES
(1, 'mobile', 'samsung', 'a35', 45000.00, -6, 24, 'brand new', 1, 1),
(2, 'earphone', 'qcy', 'anc2', 1800.00, 5, 24, 'brand new', 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `restock_history`
--

CREATE TABLE `restock_history` (
  `restock_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `restocked_by` int(11) DEFAULT NULL,
  `restock_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `sale_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sale_time` datetime DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `discount_applied` decimal(5,2) DEFAULT 0.00,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`sale_id`, `employee_id`, `product_id`, `manager_id`, `branch_id`, `customer_id`, `sale_time`, `quantity`, `discount_applied`, `total_price`) VALUES
(2, 1, NULL, 1, 1, 2, '2025-08-05 07:11:23', 1, 0.00, 45000.00),
(3, 2, NULL, 2, 2, 3, '2025-08-05 07:34:24', 1, 0.00, 7200.00),
(4, 1, NULL, 1, 1, 4, '2025-08-05 09:50:00', 1, 0.00, 450000.00);

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `sale_detail_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_line_price` decimal(10,2) NOT NULL,
  `warranty_expire_date` date NOT NULL,
  `discount_applied` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`sale_detail_id`, `sale_id`, `product_id`, `quantity`, `unit_price`, `total_line_price`, `warranty_expire_date`, `discount_applied`) VALUES
(1, 2, 1, 1, 45000.00, 45000.00, '2027-08-05', 0.00),
(2, 3, 2, 3, 1800.00, 5400.00, '2027-08-05', 0.00),
(3, 3, 2, 1, 1800.00, 1800.00, '2027-08-05', 0.00),
(4, 4, 1, 10, 45000.00, 450000.00, '2027-08-05', 0.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `manager_id` (`manager_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`manager_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `branch_id` (`branch_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `sale_id` (`sale_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `restock_history`
--
ALTER TABLE `restock_history`
  ADD PRIMARY KEY (`restock_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `restocked_by` (`restocked_by`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `manager_id` (`manager_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`sale_detail_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login_log`
--
ALTER TABLE `login_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `manager_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `restock_history`
--
ALTER TABLE `restock_history`
  MODIFY `restock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `sale_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`manager_id`),
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);

--
-- Constraints for table `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `manager_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`sale_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `restock_history`
--
ALTER TABLE `restock_history`
  ADD CONSTRAINT `restock_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `restock_history_ibfk_2` FOREIGN KEY (`restocked_by`) REFERENCES `manager` (`manager_id`);

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `sale_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`),
  ADD CONSTRAINT `sale_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `sale_ibfk_3` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`manager_id`),
  ADD CONSTRAINT `sale_ibfk_4` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `sale_ibfk_5` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD CONSTRAINT `sale_details_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`sale_id`),
  ADD CONSTRAINT `sale_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
