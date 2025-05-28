-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 02:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marketplace_game`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_title` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_title`, `description`, `price`, `image`, `created_at`, `image2`, `image3`, `game_id`) VALUES
(19, 'AKUN EX IMMO 147 256 SKIN + 28 HERO LIMIT', '0', 1200000.00, 'ml.jpg', '2025-05-26 17:25:35', NULL, NULL, 1),
(24, 'AKUN JUNGLER ', '0', 350000.00, 'WhatsApp Image 2025-05-27 at 08.38.26_158f098f.jpg', '2025-05-27 01:39:51', NULL, NULL, 1),
(25, 'ISENG AJA', '0', 500000.00, 'WhatsApp Image 2025-05-27 at 08.38.27_f3279e74.jpg', '2025-05-27 01:42:09', NULL, NULL, 1),
(26, 'MAU PINDAH GAME', '0', 35000.00, 'WhatsApp Image 2025-05-27 at 08.38.27_eddaf747.jpg', '2025-05-27 01:43:37', NULL, NULL, 1),
(27, 'Jual Santai', '0', 970000.00, 'Screenshot 2025-05-27 084916.png', '2025-05-27 01:50:01', NULL, NULL, 3),
(28, 'AKUN OLD', '0', 1100000.00, 'WhatsApp Image 2025-05-27 at 08.53.01_9ba79e3e.jpg', '2025-05-27 01:54:27', NULL, NULL, 4),
(29, 'Mau ganti Hp', '0', 250000.00, 'WhatsApp Image 2025-05-27 at 08.58.57_e98e7daa.jpg', '2025-05-27 02:00:34', NULL, NULL, 2),
(30, 'gabut', '0', 200000.00, 'WhatsApp Image 2025-05-27 at 08.59.40_2a0a88d3.jpg', '2025-05-27 02:01:26', NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `name`) VALUES
(4, 'Free Fire'),
(2, 'Genshin Impact'),
(1, 'Mobile Legends'),
(5, 'PUBG Mobile'),
(3, 'Valorant');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'Nox', '$2y$10$l3C.GVE3yime54J4mP3/s.b8Zhxyksc3td1XJZlUGCoQPaFFhFwA2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_game_id` (`game_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `fk_game_id` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
