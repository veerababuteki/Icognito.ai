-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2025 at 05:32 AM
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
-- Database: `chatwidget`
--

-- --------------------------------------------------------

--
-- Table structure for table `custom_themes`
--

CREATE TABLE `custom_themes` (
  `id` int(11) NOT NULL,
  `settings_id` int(11) DEFAULT NULL,
  `primary_color` varchar(20) DEFAULT NULL,
  `secondary_color` varchar(20) DEFAULT NULL,
  `header_bg` varchar(20) DEFAULT NULL,
  `header_text` varchar(20) DEFAULT NULL,
  `button_bg` varchar(20) DEFAULT NULL,
  `button_text` varchar(20) DEFAULT NULL,
  `chat_bubble_user` varchar(20) DEFAULT NULL,
  `chat_bubble_bot` varchar(20) DEFAULT NULL,
  `input_border` varchar(20) DEFAULT NULL,
  `input_focus` varchar(20) DEFAULT NULL,
  `font_family` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `background_img` varchar(1000) NOT NULL,
  `api_url` varchar(255) DEFAULT NULL,
  `initial_message` text DEFAULT NULL,
  `theme_type` enum('solid','gradient','glassmorphism','custom') DEFAULT 'solid',
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company_name`, `background_img`, `api_url`, `initial_message`, `theme_type`, `status`, `created_at`, `updated_at`) VALUES
(3, 'New York', '697586702_image (3).png', 'http://3.230.115.210:5003/ask', 'Hello! How can I help you?', 'glassmorphism', 1, '2025-03-07 11:15:19', '2025-03-07 06:45:19'),
(4, 'muthoot chat', '', 'http://3.230.115.210:5010/ask', 'Hello? How i can help You', 'solid', 1, '2025-03-07 10:12:11', '2025-03-07 05:42:11'),
(5, 'Pranaam Hospitals', '917380314_image (3).jfif', 'http://3.230.115.210:5005/ask', 'Hello! How can I help you?', 'solid', 1, '2025-03-07 11:13:46', '2025-03-07 06:43:46'),
(6, 'Ankura Hospital', '784900157_image (2).jfif', 'http://3.230.115.210:5006/ask', 'Hello! How can I help you?', 'gradient', 1, '2025-03-07 11:12:59', '2025-03-07 06:42:59'),
(7, 'Smiline', '533714307_image (1).jfif', 'http://3.230.115.210:5002/ask', 'Hello! How can I help you?', 'glassmorphism', 1, '2025-03-07 11:11:53', '2025-03-07 06:41:53'),
(8, 'Swarnagiri Temple', '745739015_image (4).jfif', 'http://3.230.115.210:5000/ask', 'Hello! How can I help you?', 'solid', 1, '2025-03-07 11:10:32', '2025-03-07 06:40:32'),
(9, 'Zoological Park', '362351080_image.jfif', 'http://3.230.115.210:5004/ask', 'Hello! How can I help you?', 'solid', 1, '2025-03-07 11:09:25', '2025-03-07 06:39:25'),
(10, 'dwarika Temple', '229703336_image.png', 'http://3.230.115.210:5001/ask', 'Hello! How can I help you?', 'gradient', 1, '2025-03-07 11:07:54', '2025-03-07 06:37:54'),
(11, '9M Fertility', '926387149_Screenshot 2025-03-07 163109.png', 'http://3.230.115.210:5007/ask', 'Hello! How can I help you?', 'gradient', 1, '2025-03-07 11:04:26', '2025-03-07 06:34:26'),
(12, 'Russh Hospital', '909887241_Screenshot 2025-03-07 162752.png', 'http://3.230.115.210:5008/ask', 'Hello! How can I help you?', 'gradient', 1, '2025-03-07 10:58:10', '2025-03-07 06:28:10'),
(13, 'Ramoji film city', '796979846_image (2).png', 'http://3.230.115.210:5009/ask', 'Hello! How can I help you?', 'glassmorphism', 1, '2025-03-10 04:27:25', '2025-03-09 23:57:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `custom_themes`
--
ALTER TABLE `custom_themes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_id` (`settings_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `custom_themes`
--
ALTER TABLE `custom_themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `custom_themes`
--
ALTER TABLE `custom_themes`
  ADD CONSTRAINT `custom_themes_ibfk_1` FOREIGN KEY (`settings_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
