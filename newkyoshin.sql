-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2026 at 11:50 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newkyoshin`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `is_active` tinyint(1) DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `title_nepali` varchar(225) NOT NULL,
  `slug` varchar(225) NOT NULL,
  `type` varchar(20) NOT NULL,
  `featured_image` varchar(500) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `japanese_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `display_order` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `career`
--

CREATE TABLE `career` (
  `id` int(11) NOT NULL,
  `branch_id` varchar(50) DEFAULT NULL,
  `slug` mediumtext,
  `Title` mediumtext,
  `due_date` date DEFAULT NULL,
  `datevalue` mediumtext,
  `imp_notice` enum('Y','N') DEFAULT 'N',
  `show_pop` enum('Y','N') DEFAULT 'N',
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `DutyStation` mediumtext,
  `JobNumber` mediumtext,
  `Duration` mediumtext,
  `Experience` int(11) DEFAULT NULL,
  `Description` longtext NOT NULL,
  `Responsibilities` longtext,
  `MinRequirements` longtext,
  `RemunerationBenefits` longtext,
  `SelectionPreferences` longtext,
  `Type` mediumtext NOT NULL,
  `fiscal_id` int(11) DEFAULT NULL,
  `MetaKeyword` mediumtext,
  `MetaDescription` mediumtext,
  `Serial` int(11) NOT NULL DEFAULT '0',
  `CoverImage` mediumtext,
  `DocPath` mediumtext,
  `Disabled` int(11) DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `TitleNepali` mediumtext NOT NULL,
  `DescriptionNepali` mediumtext NOT NULL,
  `status` enum('0','1','2','3','4') NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `career_apply`
--

CREATE TABLE `career_apply` (
  `id` int(11) NOT NULL,
  `career_id` int(11) NOT NULL,
  `application_id` varchar(12) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `bod` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `father_name` varchar(150) DEFAULT NULL,
  `mother_name` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `nationality` varchar(150) NOT NULL,
  `religion` varchar(80) NOT NULL,
  `marital_status` varchar(20) NOT NULL,
  `driving_license` varchar(50) DEFAULT NULL,
  `citizenship_no` varchar(50) DEFAULT NULL,
  `citizen_issue_location` varchar(100) DEFAULT NULL,
  `permanent_provience` int(11) NOT NULL,
  `permanent_district` int(11) NOT NULL,
  `permanent_municipality` int(11) NOT NULL,
  `permanent_ward` varchar(100) DEFAULT NULL,
  `temporary_provience` int(11) NOT NULL,
  `temporary_district` int(11) NOT NULL,
  `temporary_municipality` int(11) NOT NULL,
  `temporary_ward` varchar(100) DEFAULT NULL,
  `DocPath` varchar(300) DEFAULT NULL,
  `cv` varchar(255) NOT NULL,
  `application` varchar(255) NOT NULL,
  `certificate` varchar(300) NOT NULL,
  `training_certificate` varchar(255) DEFAULT NULL,
  `citizenship` varchar(255) NOT NULL,
  `experience_letters` varchar(255) DEFAULT NULL,
  `expected_salary` varchar(15) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `career_file`
--

CREATE TABLE `career_file` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `title_nepali` varchar(150) DEFAULT NULL,
  `CoverImage` varchar(500) DEFAULT NULL,
  `description_nepali` longtext,
  `description` longtext,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_interest` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_replies`
--

CREATE TABLE `contact_replies` (
  `id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `reply_message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `replied_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `japanese_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `full_description` text COLLATE utf8mb4_unicode_ci,
  `prerequisites` text COLLATE utf8mb4_unicode_ci,
  `duration` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `display_order` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_items`
--

CREATE TABLE `curriculum_items` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `item_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `module_function`
--

CREATE TABLE `module_function` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `function_name` varchar(255) NOT NULL,
  `display_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `module_function_role`
--

CREATE TABLE `module_function_role` (
  `id` int(11) NOT NULL,
  `module_function_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `news_articles`
--

CREATE TABLE `news_articles` (
  `id` int(11) NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_date` date NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT '1',
  `views_count` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `full_description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `display_order` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `short_name` varchar(50) DEFAULT NULL,
  `site_slogan` varchar(150) DEFAULT NULL,
  `web_url` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `address_np` varchar(150) DEFAULT NULL,
  `mobile` varchar(150) DEFAULT NULL,
  `mobile_np` varchar(150) DEFAULT NULL,
  `telephone` varchar(150) NOT NULL,
  `telephone_np` varchar(150) DEFAULT NULL,
  `map_location` text,
  `contact_detail` text,
  `email` varchar(255) DEFAULT NULL,
  `closing_time` time NOT NULL,
  `opening_time` time NOT NULL,
  `opening_time_friday` time NOT NULL,
  `closing_time_friday` time NOT NULL,
  `holiday_opening` time NOT NULL,
  `holiday_closing` time NOT NULL,
  `help_team` varchar(255) DEFAULT NULL,
  `help_email` varchar(255) DEFAULT NULL,
  `help_address` varchar(255) DEFAULT NULL,
  `help_mobile` varchar(100) DEFAULT NULL,
  `help_telephone` varchar(100) DEFAULT NULL,
  `help_ext` varchar(100) DEFAULT NULL,
  `help_team_np` varchar(255) DEFAULT NULL,
  `help_address_np` varchar(255) DEFAULT NULL,
  `help_mobile_np` varchar(100) DEFAULT NULL,
  `help_telephone_np` varchar(100) DEFAULT NULL,
  `help_ext_np` varchar(50) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `googleplus` varchar(255) DEFAULT NULL,
  `linked_in` varchar(255) DEFAULT NULL,
  `viber` varchar(255) DEFAULT NULL,
  `app_store` varchar(255) DEFAULT NULL,
  `google_play` varchar(255) DEFAULT NULL,
  `CSD` varchar(255) DEFAULT NULL,
  `cash` varchar(255) DEFAULT NULL,
  `privilege_counter` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `swift` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `fav` varchar(255) DEFAULT NULL,
  `default_img` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_key_words` varchar(255) DEFAULT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `staff_infos`
--

CREATE TABLE `staff_infos` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `full_name` varchar(155) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `appointed_date` date DEFAULT NULL,
  `temp_address` varchar(255) DEFAULT NULL,
  `permanent_address` varchar(255) NOT NULL,
  `contact` varchar(155) DEFAULT NULL,
  `email` varchar(155) DEFAULT NULL,
  `created_on` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_infos`
--

INSERT INTO `staff_infos` (`id`, `branch_id`, `full_name`, `slug`, `description`, `featured_image`, `appointed_date`, `temp_address`, `permanent_address`, `contact`, `email`, `created_on`, `created_by`, `updated_on`, `updated_by`, `status`) VALUES
(2, 0, 'Cheleena Maharjan', '', '', 'uploads/staff/SUYOGYAfav3.PNG', '2022-03-01', 'Lalitpur', 'Lalitpur', '9860013046', 'cheleena@nyatapol.biz', '2022-05-26', 3, '2025-01-30', 1, '1'),
(3, 0, 'Nyatapol', '1664365571', '', 'uploads/staff/SUYOGYAfav2.PNG', '2022-09-28', 'Prasuti Marga -509, Kathmandu, Nepal', 'Prasuti Marga -509, Kathmandu, Nepal', '+977-1-4102299, 4102213 ,4102239', 'info@nyatapol.com', '2022-09-28', 1, '2025-01-30', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `auth_code` varchar(100) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `designation_code` varchar(25) DEFAULT NULL,
  `depart_id` int(11) DEFAULT NULL,
  `appointed_date` date DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `temp_address` varchar(255) NOT NULL,
  `permanent_address` varchar(255) NOT NULL,
  `country_code` varchar(10) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_on` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_on` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `currently_working` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `status` enum('0','1','2') NOT NULL DEFAULT '1',
  `psd_changed_date` date NOT NULL,
  `psd_changed` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `auth_code`, `role_id`, `staff_id`, `designation_code`, `depart_id`, `appointed_date`, `full_name`, `profile_image`, `temp_address`, `permanent_address`, `country_code`, `contact`, `description`, `email`, `created_on`, `created_by`, `updated_on`, `updated_by`, `currently_working`, `status`, `psd_changed_date`, `psd_changed`) VALUES
(1, 'nyatapol', 'c7098dd01fd11866dcb79e33d03ecfc5', 'cf16d55601715792047c57fbf18b00b2', 1, 3, 'HRM', 3, NULL, 'Nyatapol', 'https://nyatapol.biz/shine/uploads/logo/download.png', 'Babarmahal', '', 'nepa', '+977 1-4102299', '', 'nyatapol@gmail.com', '2022-01-19', 0, '2022-09-28', 1, 'Yes', '1', '0000-00-00', '0'),
(13, 'ntech', 'c7098dd01fd11866dcb79e33d03ecfc5', '6d5e8f350dafb021448947f012bddce2', 2, 3, NULL, NULL, NULL, '', '', '', '', '', '', '', 'dil@nyatapol.biz', '2024-02-28', 2, '0000-00-00', 0, 'Yes', '1', '0000-00-00', '0'),
(17, 'chelina', 'c7098dd01fd11866dcb79e33d03ecfc5', '05d28f9f75328d041e0efcbd53ba482f', 2, 2, NULL, NULL, NULL, '', NULL, '', '', '', '', '', 'cheleena@nyatapol.biz', '2024-09-24', 1, '0000-00-00', 0, 'Yes', '1', '0000-00-00', '0'),
(1, 'nyatapol', 'c7098dd01fd11866dcb79e33d03ecfc5', '5dd43a1c101a2ac59b897239cd15905e', 1, 3, 'HRM', 3, NULL, 'Nyatapol', 'https://nyatapol.biz/shine/uploads/logo/download.png', 'Babarmahal', '', 'nepa', '+977 1-4102299', '', 'nyatapol@gmail.com', '2022-01-19', 0, '2022-09-28', 1, 'Yes', '1', '0000-00-00', '0'),
(13, 'ntech', 'c7098dd01fd11866dcb79e33d03ecfc5', '6d5e8f350dafb021448947f012bddce2', 2, 3, NULL, NULL, NULL, '', '', '', '', '', '', '', 'dil@nyatapol.biz', '2024-02-28', 2, '0000-00-00', 0, 'Yes', '1', '0000-00-00', '0'),
(17, 'chelina', 'c7098dd01fd11866dcb79e33d03ecfc5', '05d28f9f75328d041e0efcbd53ba482f', 2, 2, NULL, NULL, NULL, '', NULL, '', '', '', '', '', 'cheleena@nyatapol.biz', '2024-09-24', 1, '0000-00-00', 0, 'Yes', '1', '0000-00-00', '0');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `function` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`id`, `module`, `function`, `user_id`, `date_time`) VALUES
(0, 'dashboard', NULL, 1, '2026-02-16 09:57:10'),
(0, 'dashboard', NULL, 1, '2026-02-16 09:58:04'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:35:21'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:35:26'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:35:27'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:35:33'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:35:33'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:35:33'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:38:44'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:38:44'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:38:45'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:39:44'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:39:44'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:39:44'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:57:16'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:57:16'),
(0, 'dashboard', NULL, 1, '2026-02-16 10:57:17'),
(0, 'dashboard', NULL, 1, '2026-02-16 11:31:29'),
(0, 'dashboard', NULL, 1, '2026-02-16 11:31:29'),
(0, 'dashboard', NULL, 1, '2026-02-16 11:31:29'),
(0, 'dashboard', NULL, 1, '2026-02-16 11:31:30'),
(0, 'dashboard', NULL, 1, '2026-02-16 11:31:30'),
(0, 'dashboard', NULL, 1, '2026-02-16 11:31:31'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:20:29'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:20:34'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:20:35'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:23:00'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:23:01'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:23:01'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:23:03'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:23:04'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:23:04'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:23:04'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:23:05'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:23:05'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:53:34'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:53:34'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:53:34'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:53:36'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:53:36'),
(0, 'dashboard', NULL, 1, '2026-02-17 05:53:36'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:45:28'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:45:30'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:45:31'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:45:38'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:45:39'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:45:39'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:45:39'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:45:39'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:45:40'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:47:44'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:47:44'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:47:44'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:47:52'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:47:52'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:47:52'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:48:26'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:48:26'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:48:27'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:48:31'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:48:31'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:48:31'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:48:34'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:48:34'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:48:34'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:48:35'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:48:35'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:48:35'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:49:13'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:49:13'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:49:13'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:50:11'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:50:11'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:50:12'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:50:18'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:50:18'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:50:18'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:50:26'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:50:26'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:50:26'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:50:59'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:50:59'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:50:59'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:02'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:03'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:03'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:03'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:03'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:03'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:04'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:04'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:04'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:06'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:06'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:06'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:09'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:09'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:10'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:50'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:50'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:50'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:54'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:55'),
(0, 'dashboard', NULL, 1, '2026-02-23 04:51:55'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:05'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:06'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:06'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:06'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:06'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:06'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:07'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:07'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:07'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:07'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:07'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:07'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:09'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:10'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:10'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:16'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:16'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:16'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:24'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:25'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:35:25'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:51:33'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:51:33'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:51:33'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:51:36'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:51:37'),
(0, 'dashboard', NULL, 1, '2026-02-23 05:51:37'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:16:53'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:16:53'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:16:54'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:16:56'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:16:56'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:16:57'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:16:57'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:16:57'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:16:58'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:16:59'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:16:59'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:16:59'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:17:00'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:17:01'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:17:01'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:17:01'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:17:01'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:19:16'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:19:16'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:19:16'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:48:46'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:48:47'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:48:47'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:48:49'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:48:49'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:48:50'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:48:59'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:48:59'),
(0, 'dashboard', NULL, 1, '2026-02-23 06:48:59'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:23'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:23'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:23'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:36'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:36'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:36'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:37'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:37'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:37'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:40'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:40'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:40'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:42'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:43'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:43'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:43'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:43'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:44'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:45'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:45'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:45'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:46'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:46'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:52:46'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:59:59'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:59:59'),
(0, 'dashboard', NULL, 1, '2026-02-23 08:59:59'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:03:40'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:03:41'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:03:41'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:11:06'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:11:06'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:11:06'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:11:16'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:11:16'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:11:16'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:11:22'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:11:22'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:11:22'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:48:11'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:48:11'),
(0, 'dashboard', NULL, 1, '2026-02-23 09:48:11');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_on` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `slug`, `name`, `description`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(1, NULL, 'Super Admin', 'Only For Developer', '1', 1, '2022-01-27', 1, '2022-01-27'),
(2, NULL, 'Admin', 'For Admins Only', '1', 1, '2022-01-27', 1, '2022-01-27'),
(3, NULL, 'HRD Admin', '<p>HRD Department</p>\r\n', '2', 1, '2022-01-28', 1, '2024-07-01'),
(4, NULL, 'Finance Admin', '<p>Finance Department</p>\r\n', '2', 1, '2022-01-28', 1, '2024-07-01'),
(5, NULL, 'Grievance Admin', '<p>Grievance Officer</p>\r\n', '2', 1, '2022-10-13', 1, '2024-07-01'),
(6, NULL, 'Business Admin', '<p>Business Development</p>\r\n', '2', 1, '2022-10-13', 1, '2024-07-01'),
(7, NULL, 'Treasury Admin', '<p>Treasury</p>\r\n', '2', 1, '2022-10-13', 1, '2024-07-01'),
(8, NULL, 'Card Admin', '<p>Digital</p>\r\n', '2', 1, '2022-10-13', 1, '2024-07-01'),
(9, NULL, 'Operation Admin', '<p>Operation</p>\r\n', '2', 1, '2022-10-13', 1, '2024-07-01'),
(10, NULL, 'Trade Amin', '<p>Trade</p>\r\n', '2', 1, '2022-10-13', 1, '2024-07-01'),
(11, NULL, 'AML/CFT', '<p>Compliance</p>\r\n', '2', 1, '2022-10-13', 1, '2024-07-01'),
(12, NULL, 'HR User', '', '1', 1, '2024-09-24', 15, '2024-10-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `unique_code` (`code`),
  ADD UNIQUE KEY `unique_slug` (`slug`),
  ADD KEY `idx_active` (`is_active`);

--
-- Indexes for table `career_file`
--
ALTER TABLE `career_file`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `contact_replies`
--
ALTER TABLE `contact_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contact_id` (`contact_id`),
  ADD KEY `idx_admin_id` (`admin_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_code` (`course_code`),
  ADD UNIQUE KEY `unique_course_code` (`course_code`),
  ADD KEY `idx_level` (`level`),
  ADD KEY `idx_active` (`is_active`);

--
-- Indexes for table `curriculum_items`
--
ALTER TABLE `curriculum_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_display_order` (`display_order`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_function`
--
ALTER TABLE `module_function`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_function_role`
--
ALTER TABLE `module_function_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_articles`
--
ALTER TABLE `news_articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `unique_slug` (`slug`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_published_date` (`published_date`),
  ADD KEY `idx_is_published` (`is_published`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_album_id` (`album_id`),
  ADD KEY `idx_sort_order` (`sort_order`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `unique_slug` (`slug`),
  ADD KEY `idx_active` (`is_active`),
  ADD KEY `idx_display_order` (`display_order`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `career_file`
--
ALTER TABLE `career_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_replies`
--
ALTER TABLE `contact_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `curriculum_items`
--
ALTER TABLE `curriculum_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_articles`
--
ALTER TABLE `news_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_replies`
--
ALTER TABLE `contact_replies`
  ADD CONSTRAINT `contact_replies_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `contact_messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contact_replies_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `curriculum_items`
--
ALTER TABLE `curriculum_items`
  ADD CONSTRAINT `curriculum_items_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
