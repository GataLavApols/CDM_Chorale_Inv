-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2025 at 12:58 PM
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
-- Database: `inv`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

CREATE TABLE `accessories` (
  `deco_id` int(11) NOT NULL,
  `deco_name` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `condition` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`deco_id`, `deco_name`, `quantity`, `condition`, `image_path`) VALUES
(1, 'Bamboo Bilao', 4, '', 'picture-1.png'),
(2, 'Metal Hoop', 1, 'GOOD', NULL),
(3, 'Vine Decoration', 2, 'GOOD', NULL),
(4, 'Portable Booth', 1, 'GOOD', NULL),
(5, 'Tarpaulin', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `clothing`
--

CREATE TABLE `clothing` (
  `clothing_id` int(11) NOT NULL,
  `clothing_name` varchar(45) DEFAULT NULL,
  `quantity` varchar(45) DEFAULT NULL,
  `clothing_color` varchar(45) DEFAULT NULL,
  `clothing_size_id` varchar(11) DEFAULT NULL,
  `condition` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clothing`
--

INSERT INTO `clothing` (`clothing_id`, `clothing_name`, `quantity`, `clothing_color`, `clothing_size_id`, `condition`, `image_path`) VALUES
(1, 'Barong (Brown Small)', '2', 'Black', 'S', 'GOOD', 'picture-1.png'),
(2, 'Barong (Black Medium)', '5', 'Black', 'M', 'GOOD', 'picture-1.png'),
(3, 'Barong (Black Large)', '3', 'Black', 'L', 'GOOD', 'picture-1.png'),
(4, 'Barong (Black XL)', '3', 'Black', 'XL', 'GOOD', 'picture-1.png'),
(5, 'Barong (Cream Small)', '3', 'Cream', 'S', 'GOOD', 'picture-1.png'),
(6, 'Infinity Dress (Shiny Royal Blue)', '4', 'Shiny Royal Blue', '0', 'GOOD', 'picture-1.png'),
(7, 'Infinity Dress (Matte Royal Blue)', '6', 'Matte Royal Blue', 'n/a', 'GOOD', 'picture-1.png'),
(8, 'Infinity Dress (Light Blue)', '6', 'Light Blue', 'N/A', 'GOOD', 'picture-1.png'),
(9, 'Scarf (Red)', '15', 'Red', 'N/A', 'GOOD', 'picture-1.png'),
(10, 'Scarf (Green)', '9', 'Green', 'n/a', 'GOOD', 'picture-1.png'),
(11, 'Skirt', '10', 'Gold', NULL, 'GOOD', NULL),
(12, 'Alampay', '8', NULL, NULL, 'GOOD', NULL),
(13, 'Shawl', '10', NULL, NULL, 'GOOD', NULL),
(14, 'Filipiniana Detachable', '8', NULL, NULL, 'GOOD', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clothing_size`
--

CREATE TABLE `clothing_size` (
  `size_id` int(11) NOT NULL,
  `clothing_size` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clothing_size`
--

INSERT INTO `clothing_size` (`size_id`, `clothing_size`) VALUES
(0, 'S'),
(1, 'M'),
(2, 'L'),
(3, 'XL'),
(4, '2XL');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_accessories`
--

CREATE TABLE `deleted_accessories` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `condition_status` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deleted_clothing`
--

CREATE TABLE `deleted_clothing` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `condition_status` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deleted_instruments`
--

CREATE TABLE `deleted_instruments` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `condition_status` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deleted_items`
--

CREATE TABLE `deleted_items` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_type` varchar(20) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `condition_status` varchar(100) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_by` varchar(100) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_items`
--

INSERT INTO `deleted_items` (`id`, `item_id`, `item_name`, `item_type`, `quantity`, `condition_status`, `image_path`, `deleted_at`, `deleted_by`, `reason`, `details`) VALUES
(38, 21, 'Guitar', '0', 1, '0', '', '2025-05-19 08:52:04', 'Tamara Verdan', 'awdawd', '{\"original_table\":\"instruments\",\"original_id\":\"21\",\"instrument_name\":\"Guitar\",\"condition\":\"\",\"quantity\":1}'),
(39, 13, 'Tambol', '0', 10, '0', '', '2025-05-19 08:52:10', 'Tamara Verdan', 'adwad', '{\"original_table\":\"accessories\",\"original_id\":\"13\",\"deco_name\":\"Tambol\",\"condition\":\"\",\"quantity\":10}'),
(41, 23, 'Guitar', '0', 1, '0', '', '2025-05-19 09:32:03', 'Tamara Verdan', 'awdawd', '{\"original_table\":\"instruments\",\"original_id\":\"23\",\"instrument_name\":\"Guitar\",\"condition\":\"GOOD\",\"quantity\":1}');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_members`
--

CREATE TABLE `deleted_members` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `details` text DEFAULT NULL,
  `program` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `given_name` varchar(255) DEFAULT NULL,
  `middle_initial` varchar(10) DEFAULT NULL,
  `extension` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `history_id` int(11) NOT NULL,
  `type` enum('BORROW','REPORT','ADD','DELETE') NOT NULL,
  `borrowed_by` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `date_return` date DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sn` varchar(50) DEFAULT NULL,
  `condition` varchar(50) NOT NULL DEFAULT 'good',
  `status` enum('needs replacement','needs repair','not working','repaired','working') DEFAULT 'working',
  `remarks` text DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`history_id`, `type`, `borrowed_by`, `date`, `date_return`, `category`, `item_name`, `quantity`, `sn`, `condition`, `status`, `remarks`, `is_approved`, `created_at`) VALUES
(32, 'BORROW', 'Hans', '2025-05-20', '2025-05-21', 'Instruments', 'Korg KROSS2-88 Keyboard', 1, '20231020406', 'good', 'working', '', 1, '2025-05-20 10:56:20');

-- --------------------------------------------------------

--
-- Table structure for table `instruments`
--

CREATE TABLE `instruments` (
  `instru_id` int(11) NOT NULL,
  `instrument_name` varchar(75) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `condition` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instruments`
--

INSERT INTO `instruments` (`instru_id`, `instrument_name`, `quantity`, `condition`, `image_path`) VALUES
(1, 'Korg KROSS2-88 Keyboard', 0, 'GOOD', 'picture-1.png'),
(3, 'Korg KROSS2-88 Charger', 1, 'GOOD', NULL),
(4, 'Keyboard Stand', 1, 'GOOD', NULL),
(5, 'Keyboard Case', 1, 'GOOD', NULL),
(6, 'Music Sheet Stand', 1, 'GOOD', 'picture-1.png'),
(7, 'CREATIVE Speakers', 1, 'Good', 'picture-1.png');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT '',
  `email` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `username`, `password`, `full_name`, `email`) VALUES
(1, 'admin', 'admin', 'VERDAN, TAMARA ARIELLE C.', 'maamtammy@edu.ph'),
(2, 'user', 'password', 'Rinnel Pacinos', 'kuyarinnel@cdm.edu.ph'),
(3, 'admin2', 'password', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `given_name` varchar(50) DEFAULT NULL,
  `middle_initial` char(1) DEFAULT NULL,
  `extension` varchar(10) DEFAULT NULL,
  `program` varchar(50) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  `birthdate` varchar(50) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `last_name`, `given_name`, `middle_initial`, `extension`, `program`, `position`, `birthdate`, `address`, `image_path`) VALUES
(2, 'BACULINAO', 'REGINA MARIE', 'L', '', 'Civil Engineering', 'Member', '', '145 CALAMANSI ST. TRAMO HEIGHTS PUROK 6, BRGY. SUCAT, MUNTINLUPA CITY', ''),
(3, 'BARCELON', 'JOHN BRYAN', 'J', '', 'Computer Engineering', 'Member', '', 'LIRIO #3 EXTENSION ST., BRGY. CAA, LAS PIÑAS CITY', NULL),
(4, 'CARPIZ', 'LEMUEL JAY', 'I', '', 'Architecture', 'Member', '2006-05-17', 'BLK 1 LOT 15 GENESIS ST. TEOSEJO SUBDIVISION, BRGY. TUNASAN, MUNTINLUPA CITY', 'member_profiles/member_4_1745846904.jpg'),
(5, 'CONSTANTINO', 'MIKAELA COLEEN', 'D', '', 'Computer Engineering', 'Member', '', '#95 NATIONAL ROAD, BRGY. PUTATAN, MUNTINLUPA CITY', ''),
(6, 'DAYPUYART', 'REUBEN', 'B', '', 'Electronics Engineering', 'Trainee', '2006-01-02', 'ST. CATHERINE COMPOUND, BRGY. PUTATAN, MUNTINLUPA CITY', 'member_profiles/member_6_1745847220.jpg'),
(7, 'DE CASTRO', 'JUSTIN ALLEN', 'M', '', 'Architecture', 'Member', '2005-09-05', 'PHASE 1 BLOCK 10 LOT 29 SOUTHVILLE3', 'member_profiles/member_7_1745847256.png'),
(8, 'ENCARNACION', 'LADYMAE', 'A', '', 'Civil Engineering', 'Member', '', 'SOUTHVILLE 3A EXT, BRGY. SAN ANTONIO, SAN PEDRO  CITY, LAGUNA', NULL),
(9, 'FAJARDO', 'ENRICO CHARLES', 'E', '', 'Civil Engineering', 'Member', '2002-02-12', '#25 151 LUBACON APARTMENT PUROK 2, BRGY. CUPANG, MUNTINLUPA CITY', 'member_profiles/member_9_1745847279.png'),
(10, 'GACUTAN', 'KIMMI VICTORIA', 'P', '', 'Electronics Engineering', 'Trainee', '2006-10-07', '136 WALING-WALING ST. LODORA VILLAGE, BRGY. TUNASAN, MUNTINLUPA CITY', 'member_profiles/member_10_1745847298.png'),
(11, 'GALICA', 'CLARK KENT', 'C', '', 'Civil Engineering', 'Member', '', '#3-G PUROK 1 ADIA ST., BRGY. BAGUMBAYAN, TAGUIG CITY', NULL),
(12, 'ILAGAN', 'ROGELIO I', 'I', '', 'Computer Engineering', 'Member', '2003-02-02', 'B5 L26, VERONA ST., CAMELLA HOMES 2D, SOLDIERS HILLS VILLAGE, PUTATAN, MUNTINLUPA CITY', 'member_profiles/member_12_1745847318.png'),
(13, 'MANUEL', 'UKRAINE KIEV', 'V', '', 'Industrial Engineering', 'Trainee', '2005-04-11', '162 ESTEHONOR COMPOUND WAWA STREET, BRGY. ALABANG, MUNTINLUPA CITY', 'member_profiles/member_13_1745847337.png'),
(14, 'NOBLEZA', 'JOHN MICHAEL', 'C', '', 'Electronics Engineering', 'Member', '2004-06-14', '15 CAMIA ST L & B COMPOUND 1, BRGY. ALABANG MUNTINLUPA CITY', 'member_profiles/member_14_1745847364.png'),
(15, 'PACINOS', 'JOHN RINNEL', 'L', '', 'Electronics Engineering', 'Member', '2002-09-13', '295 MONTILLANO ST., BRGY. ALABANG, MUNTINLUPA CITY', 'member_profiles/member_15_1745847420.png'),
(16, 'QUIZON', 'JILL ERIKA', 'D', '', 'Architecture', 'Member', '2005-02-16', 'LOT 31 ACACIA COMPOUND ORCHIDS ST. SGHV, BRGY. PUTATAN MUNTINLUPA', 'member_profiles/member_16_1745847449.png'),
(17, 'RAMIREZ', 'KIM', 'D', '', 'Electronics Engineering', 'Trainee', '2005-05-18', '218 VIÑALON ST. BRGY. CUPANG, MUNTINLUPA CITY', 'member_profiles/member_17_1745847470.png'),
(18, 'RED', 'CLIFFORD KEN', 'A', '', 'Civil Engineering', 'Trainee', '2003-12-01', 'BLK 4 LOT 11 BRGY. MAGSAYSAY, SAN PEDRO CITY, LAGUNA', 'member_profiles/member_18_1745847500.png'),
(19, 'RIVERA', 'RONNIE', 'S', 'JR.', 'Civil Engineering', 'Member', '2004-08-31', '782 BERGANTIÑOS COMPOUND, BRGY. CUYAB, SAN PEDRO CITY, LAGUNA.', 'member_profiles/member_19_1745847525.png'),
(20, 'ROSAURO', 'BENEDICT', 'M', '', 'Mechanical Engineering', 'Member', '2005-06-25', 'PH. 3, BLOCK 49, LOT 16, SOUTHVILLE 3, POBLACION, MUNT. CITY', 'member_profiles/member_20_1745847541.png'),
(21, 'TOLEDO', 'PRECIOUS MAE', 'G', '', 'Civil Engineering', 'Trainee', '', 'BRGY. BULI, MUNTINLUPA CITY', NULL),
(22, 'TORRELIZA', 'JANRHEY', 'G', '', 'Civil Engineering', 'Member', '2005-01-02', 'BLK 31 LOT 17 LINDEN ST. BRGY. LANGGAM, SAN PEDRO, LAGUNA.', 'member_profiles/member_22_1745847560.png'),
(24, 'ALDAYA', 'ALEXANDRA LIEN', 'S', '', 'Architecture', 'Member', '2006-12-29', 'BLK 78 LOT 4 A MABINI ST., BRGY. LARAM, SAN PEDRO CITY', 'member_profiles/member_1745846421_7615.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pending_users`
--

CREATE TABLE `pending_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` varchar(50) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_users`
--

INSERT INTO `pending_users` (`id`, `username`, `password`, `email`, `full_name`, `requested_at`, `status`, `approved_by`, `approved_at`) VALUES
(11, 'newuser', 'password', 'vinceluces@cdm.edu', 'Vince Luces', '2025-05-15 07:49:15', 'approved', 'user', '2025-05-15 07:50:00'),
(14, 'hellopo', 'password', 'hansipe0413@yahoo.com.ph', 'Vince Luces', '2025-05-16 02:23:12', 'approved', 'admin', '2025-05-16 02:23:46'),
(15, 'nagu', 'nagu04', 'vinceluces@cdm.edu', 'Vince Luces', '2025-05-16 06:36:50', 'approved', 'admin', '2025-05-16 06:37:02'),
(16, 'donnlingo', 'password', 'pogiako123@yahoo.com', 'Sir Donn Lingo Pogi', '2025-05-16 07:30:04', 'approved', 'admin', '2025-05-16 07:31:52'),
(17, 'hanssese', 'hanssmosh13', 'hanssese@yahoo.com', 'Hans Sese', '2025-05-20 09:49:07', 'approved', 'admin', '2025-05-20 09:49:18'),
(18, 'newuser', 'password', 'hanssese@yahoo.com', 'Hans Sese', '2025-05-20 10:15:10', 'approved', 'admin', '2025-05-20 10:15:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id_user_login` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT '',
  `email` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id_user_login`, `username`, `password`, `full_name`, `email`) VALUES
(8, 'user', 'user', 'Hans', 'hanssese@yahoo.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`deco_id`);

--
-- Indexes for table `clothing`
--
ALTER TABLE `clothing`
  ADD PRIMARY KEY (`clothing_id`);

--
-- Indexes for table `clothing_size`
--
ALTER TABLE `clothing_size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `deleted_accessories`
--
ALTER TABLE `deleted_accessories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_clothing`
--
ALTER TABLE `deleted_clothing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_instruments`
--
ALTER TABLE `deleted_instruments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_items`
--
ALTER TABLE `deleted_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_members`
--
ALTER TABLE `deleted_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`history_id`);

--
-- Indexes for table `instruments`
--
ALTER TABLE `instruments`
  ADD PRIMARY KEY (`instru_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `pending_users`
--
ALTER TABLE `pending_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`) USING BTREE,
  ADD KEY `email` (`email`) USING BTREE;

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id_user_login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `deco_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `clothing`
--
ALTER TABLE `clothing`
  MODIFY `clothing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `deleted_accessories`
--
ALTER TABLE `deleted_accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `deleted_clothing`
--
ALTER TABLE `deleted_clothing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deleted_instruments`
--
ALTER TABLE `deleted_instruments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `deleted_items`
--
ALTER TABLE `deleted_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `deleted_members`
--
ALTER TABLE `deleted_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `instruments`
--
ALTER TABLE `instruments`
  MODIFY `instru_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `pending_users`
--
ALTER TABLE `pending_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id_user_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
