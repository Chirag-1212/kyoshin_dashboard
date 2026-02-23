-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2026 at 12:09 PM
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

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `module_name`, `display_name`, `status`) VALUES
(3, 'content', 'Content', '1'),
(13, 'designation', 'Designation', '1'),
(14, 'department', 'Department', '1'),
(29, 'site_settings', 'Site Settings', '1'),
(30, 'staff', 'Staff', '1'),
(31, 'user', 'User', '1'),
(32, 'user_role', 'User Role', '1'),
(33, 'module', 'Module', '1'),
(34, 'staff_dep_deg', 'Staff Department Designation', '1'),
(44, 'banner', 'Banner', '1'),
(48, 'branch', 'Branch', '1'),
(49, 'atm_locations', 'Atm Locations', '1'),
(52, 'calendar', 'Calendar', '2'),
(55, 'faq', 'FAQ', '2'),
(66, 'video', 'Video', '2'),
(67, 'province', 'Province', '1'),
(68, 'district', 'District', '1'),
(70, 'banking_hour', 'Banking Hour', '2'),
(71, 'feedback', 'Feedback', '1'),
(72, 'news', 'News', '2'),
(73, 'gallery', 'Gallery', '1'),
(74, 'report', 'Reports', '1'),
(75, 'report_category', 'Reports Category', '1'),
(76, 'career', 'Career', '2'),
(77, 'csr', 'CSR', '1'),
(78, 'services', 'Services', '2'),
(79, 'digital_services', 'Digital Services', '1'),
(80, 'service', 'Services', '1'),
(81, 'csr_type', 'CSR Category', '2'),
(82, 'popup', 'Popup', '2'),
(83, 'faq_category', 'Faq Category', '2'),
(84, 'notice_career', 'Notice & Career', '1'),
(86, 'remitance', 'Remitance', '2'),
(87, 'forex', 'Forex', '2'),
(88, 'grievance', 'Grivance', '2'),
(89, 'fiscal_year', 'Fiscal Year', '1'),
(90, 'interest_rate_fiscal_year_wise', 'Fiscal Year Interest Rate', '1'),
(91, 'interest_rate', 'Interest Rate', '2'),
(92, 'loans', 'Loans', '2'),
(93, 'other_interest_rate', 'Other Interest Rate', '2'),
(94, 'product_category', 'Product Category', '2'),
(95, 'product', 'Products', '2'),
(96, 'closing_days', 'Closing  Days', '2'),
(97, 'calendar_year', 'Calendar Year', '2'),
(98, 'member_network_category', 'Member Network Category', '2'),
(99, 'member_network', 'Member Network', '2'),
(101, 'count', 'Count', '1'),
(102, 'download_category', 'Download Category', '1'),
(103, 'download', 'Downloaads', '1'),
(104, 'officers', 'Officers', '1'),
(105, 'branch_wise_officers', 'Branch Wise Officers', '2'),
(106, 'group', 'Team Group', '1'),
(107, 'team', 'Team', '1'),
(108, 'epayment_partners', 'E-Payment Partner', '1'),
(109, 'CareerApply', 'Career Apply', '1'),
(110, 'municipality', 'Municipality', '1'),
(111, 'extension_counter', 'Extension Counter', '2'),
(112, 'common', 'Profile', '1'),
(113, 'information_office', 'Information Office', '1'),
(114, 'learning_dev', 'Learning & Development', '1'),
(115, 'service_category', 'Service Category', '1'),
(116, 'rates_category', 'Rates Category', '1'),
(117, 'rates', 'Rates', '1'),
(118, 'deposit_category', 'Deposit Category', '1'),
(119, 'deposit', 'Deposit', '1'),
(120, 'loan_category', 'Loan Category', '1'),
(121, 'loan', 'Loan', '1'),
(122, 'bank_guarantee', 'Bank Guarantee', '1'),
(123, 'upload_img', 'Upload Image', '1'),
(124, 'career_file', 'Vacancy Notice', '1');

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

--
-- Dumping data for table `module_function`
--

INSERT INTO `module_function` (`id`, `module_id`, `function_name`, `display_name`) VALUES
(258, 37, 'view', 'View'),
(259, 37, 'generate_year_end', 'Generate'),
(260, 37, 'all', 'Year End List'),
(261, 36, 'cancel_row', 'Cancel'),
(262, 36, 'change_status', 'Approve'),
(263, 36, 'location_transfer_post', 'Post'),
(264, 36, 'soft_delete', 'Delete'),
(265, 36, 'view', 'View'),
(266, 36, 'form', 'Form'),
(267, 36, 'all', 'List'),
(268, 35, 'cancel_row', 'Cancell'),
(269, 35, 'change_status', 'Approve'),
(270, 35, 'scrap_post', 'Post'),
(271, 35, 'soft_delete', 'Delete'),
(272, 35, 'view', 'View'),
(273, 35, 'form', 'Form'),
(274, 35, 'all', 'List'),
(275, 34, 'soft_delete', 'Delete'),
(276, 34, 'form', 'Form'),
(277, 34, 'all', 'List'),
(282, 32, 'soft_delete', 'Delete'),
(283, 32, 'form', 'Form'),
(284, 32, 'all', 'List'),
(288, 30, 'soft_delete', 'Delete'),
(289, 30, 'form', 'Form'),
(290, 30, 'all', 'List'),
(291, 29, 'index', 'Site Settings'),
(292, 28, 'change_status', 'Approve'),
(293, 28, 'cancel_row', 'Cancell'),
(294, 28, 'all', 'List'),
(295, 28, 'form', 'Form'),
(296, 28, 'view', 'View'),
(297, 27, 'change_status', 'Approve'),
(298, 27, 'cancel_row', 'Cancell'),
(299, 27, 'sales_return_post', 'Post'),
(300, 27, 'soft_delete', 'Delete'),
(301, 27, 'view', 'View'),
(302, 27, 'edit', 'Edit'),
(303, 27, 'add', 'Add'),
(304, 27, 'form', 'Form'),
(305, 27, 'all', 'List'),
(306, 26, 'change_status', 'Approve'),
(307, 26, 'cancel_row', 'Cancell'),
(308, 26, 'sales_post', 'Post'),
(309, 26, 'soft_delete', 'Delete'),
(310, 26, 'view', 'View'),
(311, 26, 'edit', 'Edit'),
(312, 26, 'add', 'Add'),
(313, 26, 'all', 'List'),
(314, 25, 'grn_return_post', 'Post'),
(315, 25, 'all', 'List'),
(316, 25, 'form', 'Form'),
(317, 25, 'add', 'Add'),
(318, 25, 'edit', 'Edit'),
(319, 25, 'view', 'View'),
(320, 25, 'soft_delete', 'Delete'),
(321, 25, 'cancel_row', 'Cancell'),
(322, 25, 'change_status', 'Approve'),
(323, 24, 'change_status', 'Approve'),
(324, 24, 'cancel_row', 'Cancell'),
(325, 24, 'grn_post', 'Post'),
(326, 24, 'soft_delete', 'Delete'),
(327, 24, 'view', 'View'),
(328, 24, 'edit', 'Edit'),
(329, 24, 'add', 'Add'),
(330, 24, 'direct_add', 'Direct Add'),
(331, 24, 'all', 'List'),
(332, 23, 'soft_delete', 'Delete'),
(333, 23, 'form', 'Form'),
(334, 23, 'all', 'List'),
(335, 22, 'change_status', 'Approve'),
(336, 22, 'cancel_row', 'Cancell'),
(337, 22, 'soft_delete', 'Delete'),
(338, 22, 'view', 'View'),
(339, 22, 'edit', 'Edit'),
(340, 22, 'direct_add', 'Direct Add'),
(341, 22, 'add', 'Add'),
(342, 22, 'form', 'Form'),
(343, 22, 'all', 'List'),
(344, 21, 'change_status', 'Approve'),
(345, 21, 'cancel_row', 'Cancell'),
(346, 21, 'soft_delete', 'Delete'),
(347, 21, 'view', 'View'),
(348, 21, 'edit', 'Edit'),
(349, 21, 'add', 'Add'),
(350, 21, 'direct_add', 'Direct Add'),
(351, 21, 'form', 'Form'),
(352, 21, 'all', 'List'),
(353, 20, 'change_status', 'Approve'),
(354, 20, 'cancel_row', 'Cancell'),
(355, 20, 'soft_delete', 'Delete'),
(356, 20, 'view', 'View'),
(357, 20, 'edit', 'Edit'),
(358, 20, 'direct_add', 'Direct Add'),
(359, 20, 'add', 'Add'),
(360, 20, 'form', 'Form'),
(361, 20, 'all', 'List'),
(362, 19, 'change_status', 'Approve'),
(363, 19, 'cancel_row', 'Cancell'),
(364, 19, 'soft_delete', 'Delete'),
(365, 19, 'view', 'View'),
(366, 19, 'form', 'Form'),
(367, 19, 'all', 'List'),
(368, 18, 'change_status', 'Approve'),
(369, 18, 'cancel_row', 'Cancell'),
(370, 18, 'issue_return_post', 'Post'),
(371, 18, 'soft_delete', 'Delete'),
(372, 18, 'edit', 'Edit'),
(373, 18, 'view', 'View'),
(374, 18, 'add', 'Add'),
(375, 18, 'form', 'Form'),
(376, 18, 'all', 'List'),
(377, 17, 'view', 'View'),
(378, 17, 'direct_view', 'Direct View'),
(379, 17, 'change_status', 'Approve'),
(380, 17, 'cancel_row', 'Cancell'),
(381, 17, 'issue_post', 'Post'),
(382, 17, 'soft_delete', 'Delete'),
(383, 17, 'edit', 'Edit'),
(384, 17, 'form', 'Form'),
(385, 17, 'add', 'Add'),
(386, 17, 'direct_add', 'Direct Add'),
(387, 17, 'all', 'List'),
(388, 16, 'change_status', 'Approve'),
(389, 16, 'cancel_row', 'Cancell'),
(390, 16, 'soft_delete', 'Delete'),
(391, 16, 'view', 'View'),
(392, 16, 'form', 'Form'),
(393, 16, 'all', 'List'),
(394, 15, 'view', 'View'),
(395, 15, 'opening_post', 'Post'),
(396, 15, 'change_status', 'Approve'),
(397, 15, 'soft_delete', 'Delete'),
(398, 15, 'form', 'Form'),
(399, 15, 'all', 'List'),
(400, 15, 'cancel_row', 'Cancell'),
(401, 14, 'soft_delete', 'Delete'),
(402, 14, 'form', 'Form'),
(403, 14, 'all', 'List'),
(404, 13, 'soft_delete', 'Delete'),
(405, 13, 'form', 'Form'),
(406, 13, 'all', 'List'),
(407, 12, 'soft_delete', 'Delete'),
(408, 12, 'form', 'form'),
(409, 12, 'all', 'List'),
(410, 11, 'soft_delete', 'Delete'),
(411, 11, 'form', 'Form'),
(412, 11, 'all', 'List'),
(413, 10, 'soft_delete', 'Delete'),
(414, 10, 'form', 'Form'),
(415, 10, 'all', 'List'),
(416, 9, 'soft_delete', 'Delete'),
(417, 9, 'form', 'Form'),
(418, 9, 'all', 'List'),
(419, 8, 'soft_delete', 'Delete'),
(420, 8, 'form', 'Form'),
(421, 8, 'all', 'List'),
(422, 7, 'soft_delete', 'Delete'),
(423, 7, 'form', 'Form'),
(424, 7, 'all', 'List'),
(425, 6, 'soft_delete', 'Delete'),
(426, 6, 'form', 'Form'),
(427, 6, 'all', 'List'),
(428, 5, 'soft_delete', 'Delete'),
(429, 5, 'form', 'Form'),
(430, 5, 'all', 'List'),
(431, 4, 'soft_delete', 'Delete'),
(432, 4, 'form', 'Form'),
(433, 4, 'all', 'List'),
(438, 2, 'soft_delete', 'Delete'),
(439, 2, 'form', 'Form'),
(440, 2, 'all', 'List'),
(441, 1, 'soft_delete', 'Delete'),
(442, 1, 'form', 'Form'),
(443, 1, 'all', 'List'),
(516, 44, 'all', 'List'),
(517, 44, 'form', 'Add/Edit'),
(518, 44, 'soft_delete', 'Delete'),
(531, 48, 'soft_delete', 'Delete'),
(532, 48, 'form', 'Add/Edit'),
(533, 48, 'all', 'List'),
(534, 49, 'all', 'List'),
(535, 49, 'form', 'Add/Edit'),
(536, 49, 'soft_delete', 'Delete'),
(543, 52, 'all', 'List'),
(544, 52, 'form', 'Add/Edit'),
(545, 52, 'soft_delete', 'Delete'),
(555, 55, 'soft_delete', 'Delete'),
(556, 55, 'all', 'List'),
(557, 55, 'form', 'Add/Edit'),
(592, 66, 'all', 'List'),
(593, 66, 'form', 'Add/Edit'),
(594, 66, 'soft_delete', 'Delete'),
(598, 31, 'all', 'List'),
(599, 31, 'form', 'Form'),
(600, 31, 'soft_delete', 'Delete'),
(601, 31, 'changepassword', 'Password Change'),
(602, 67, 'all', 'List'),
(603, 67, 'form', 'Add/Edit'),
(604, 67, 'soft_delete', 'Delete'),
(605, 68, 'all', 'List'),
(606, 68, 'form', 'Add/Edit'),
(607, 68, 'soft_delete', 'Delete'),
(618, 70, 'all', 'List'),
(619, 70, 'form', 'Add/Edit'),
(620, 70, 'soft_delete', 'Delete'),
(621, 71, 'all', 'List'),
(633, 72, 'soft_delete', 'Delete'),
(634, 72, 'all', 'List'),
(635, 72, 'form', 'Add/Edit'),
(636, 73, 'all', 'List'),
(637, 73, 'soft_delete', 'Delete'),
(638, 73, 'form', 'Add/Edit'),
(639, 74, 'all', 'List'),
(640, 74, 'form', 'Add/Edit'),
(641, 74, 'soft_delete', 'Delete'),
(645, 76, 'all', 'List'),
(646, 76, 'form', 'Add/Edit'),
(647, 76, 'soft_delete', 'Delete'),
(648, 77, 'all', 'List'),
(649, 77, 'form', 'Add/Edit'),
(650, 77, 'soft_delete', 'Delete'),
(654, 79, 'all', 'List'),
(655, 79, 'form', 'Add/Edit'),
(656, 79, 'soft_delete', 'Delete'),
(657, 78, 'soft_delete', 'Delete'),
(658, 78, 'form', 'Add/Edit'),
(659, 78, 'all', 'List'),
(660, 80, 'all', 'List'),
(661, 80, 'form', 'Add/Edit'),
(662, 80, 'soft_delete', 'Delete'),
(663, 81, 'all', 'List'),
(664, 81, 'form', 'Add/Edit'),
(665, 81, 'soft_delete', 'Delete'),
(666, 82, 'all', 'List'),
(667, 82, 'soft_delete', 'Delete'),
(668, 82, 'form', 'Add/Edit'),
(669, 83, 'all', 'List'),
(670, 83, 'soft_delete', 'Delete'),
(671, 83, 'form', 'Add/Edit'),
(672, 84, 'all', 'List'),
(673, 84, 'soft_delete', 'Delete'),
(674, 84, 'form', 'Add/Edit'),
(678, 86, 'all', 'List'),
(679, 86, 'form', 'Add/Edit'),
(680, 86, 'soft_delete', 'Delete'),
(681, 87, 'all', 'List'),
(682, 87, 'form', 'Add/Edit'),
(683, 87, 'soft_delete', 'Delete'),
(684, 88, 'all', 'List'),
(685, 88, 'form', 'Add/Edit'),
(686, 88, 'soft_delete', 'Delete'),
(687, 89, 'all', 'List'),
(688, 89, 'form', 'Add/Edit'),
(689, 89, 'soft_delete', 'Delete'),
(690, 90, 'all', 'List'),
(691, 90, 'form', 'Add/Edit'),
(692, 90, 'soft_delete', 'Delete'),
(693, 91, 'all', 'List'),
(694, 91, 'form', 'Add/Edit'),
(695, 91, 'soft_delete', 'Delete'),
(696, 92, 'all', 'List'),
(697, 92, 'form', 'Add/Edit'),
(698, 92, 'soft_delete', 'Delete'),
(699, 93, 'all', 'List'),
(700, 93, 'form', 'Add/Edit'),
(701, 93, 'soft_delete', 'Delete'),
(702, 94, 'all', 'List'),
(703, 94, 'form', 'Add/Edit'),
(704, 94, 'soft_delete', 'Delete'),
(705, 95, 'all', 'List'),
(706, 95, 'form', 'Add/Edit'),
(707, 95, 'soft_delete', 'Delete'),
(708, 96, 'all', 'List'),
(709, 96, 'form', 'Add/Edit'),
(710, 96, 'soft_delete', 'Delete'),
(711, 97, 'all', 'List'),
(712, 97, 'form', 'Add/Edit'),
(713, 97, 'soft_delete', 'Delete'),
(714, 98, 'form', 'Add/Edit'),
(715, 98, 'all', 'List'),
(716, 98, 'soft_delete', 'Delete'),
(717, 99, 'form', 'Add/Edit'),
(718, 99, 'all', 'List'),
(719, 99, 'soft_delete', 'Delete'),
(723, 101, 'all', 'List'),
(724, 101, 'form', 'Add/Edit'),
(725, 101, 'soft_delete', 'Delete'),
(726, 102, 'all', 'List'),
(727, 102, 'form', 'Add/Edit'),
(728, 102, 'soft_delete', 'Delete'),
(729, 103, 'all', 'List'),
(730, 103, 'form', 'Add/Edit'),
(731, 103, 'soft_delete', 'Delete'),
(732, 104, 'all', 'List'),
(733, 104, 'form', 'Add/Edit'),
(734, 104, 'soft_delete', 'Delete'),
(735, 105, 'all', 'List'),
(736, 105, 'form', 'Add/Edit'),
(737, 105, 'soft_delete', 'Delete'),
(738, 106, 'all', 'List'),
(739, 106, 'form', 'Add/Edit'),
(740, 106, 'soft_delete', 'Delete'),
(741, 107, 'all', 'List'),
(742, 107, 'form', 'Add/Edit'),
(743, 107, 'soft_delete', 'Delete'),
(744, 75, 'soft_delete', 'Delete'),
(745, 75, 'add', 'Add'),
(746, 75, 'all', 'List'),
(747, 75, 'edit', 'Edit'),
(748, 108, 'all', 'List'),
(749, 108, 'form', 'Add/Edit'),
(750, 108, 'hard_delete', 'Delete'),
(751, 108, 'soft_delete', 'Trash'),
(767, 3, 'change_show_on_menu_status', 'Delete Menu'),
(768, 3, 'get_menu_detail_for_form', 'Menu Edit'),
(769, 3, 'menu', 'Menu'),
(770, 3, 'soft_delete', 'Delete'),
(771, 3, 'add', 'Add'),
(772, 3, 'all', 'List'),
(773, 3, 'edit', 'Edit'),
(774, 3, 'menu_edit', 'Edit Menu'),
(775, 3, 'save_order', 'Save Ordering'),
(783, 110, 'form', 'Add/Edit'),
(784, 110, 'view', 'Detail'),
(785, 110, 'soft_delete', 'Delete'),
(786, 110, 'all', 'List'),
(787, 110, 'getDistrict', 'AJAX GET DISTRICT'),
(788, 109, 'view', 'Detail'),
(789, 109, 'soft_delete', 'Delete'),
(790, 109, 'all', 'List'),
(791, 109, 'getExport', 'Export'),
(792, 111, 'all', 'List'),
(793, 111, 'form', 'Add/Edit'),
(794, 111, 'soft_delete', 'Delete'),
(795, 72, 'detail_delete', 'Detail Delete'),
(796, 77, 'detail_delete', 'Detail Delete'),
(797, 73, 'detail_delete', 'Detail Delete'),
(798, 112, 'changepasswordown', 'Change Password'),
(803, 113, 'soft_delete', 'Delete'),
(804, 113, 'all', 'List'),
(805, 113, 'form', 'Add/Edit'),
(806, 114, 'all', 'List'),
(807, 114, 'form', 'Add/Edit'),
(808, 114, 'soft_delete', 'Delete'),
(809, 115, 'soft_delete', 'Delete'),
(810, 115, 'form', 'Add/Edit'),
(811, 115, 'all', 'List'),
(812, 116, 'edit', 'Edit'),
(813, 116, 'all', 'List'),
(814, 116, 'add', 'Add'),
(815, 116, 'soft_delete', 'Delete'),
(816, 117, 'soft_delete', 'Delete'),
(817, 117, 'form', 'Add/Edit'),
(818, 117, 'all', 'List'),
(819, 118, 'soft_delete', 'Delete'),
(820, 118, 'add', 'Add'),
(821, 118, 'all', 'List'),
(822, 118, 'edit', 'Edit'),
(823, 119, 'all', 'List'),
(824, 119, 'form', 'Add/Edit'),
(825, 119, 'soft_delete', 'Delete'),
(826, 120, 'edit', 'Edit'),
(827, 120, 'add', 'Add'),
(828, 120, 'all', 'List'),
(829, 120, 'soft_delete', 'Delete'),
(830, 121, 'all', 'List'),
(831, 121, 'form', 'Add/Edit'),
(832, 121, 'soft_delete', 'Delete'),
(833, 107, 'search', 'Search'),
(834, 122, 'search', 'Search'),
(835, 122, 'all', 'List'),
(836, 122, 'form', 'Add'),
(837, 122, 'soft_delete', 'Delete'),
(838, 122, 'import_from_excel', 'Import from excel'),
(839, 122, 'updates_from_excel', 'Update from Excel'),
(840, 71, 'view', 'View'),
(848, 123, 'hard_delete', 'Delete'),
(849, 123, 'all', 'List'),
(850, 123, 'form', 'Add/Edit'),
(851, 123, 'soft_delete', 'Trash'),
(852, 124, 'soft_delete', 'Delete'),
(853, 124, 'all', 'List'),
(854, 124, 'form', 'Add/Edit'),
(855, 33, 'all', 'List'),
(856, 33, 'form', 'Form'),
(857, 33, 'soft_delete', 'Delete'),
(858, 33, 'role_function', 'Role Function'),
(859, 33, 'getForm', 'Permission&Role');

-- --------------------------------------------------------

--
-- Table structure for table `module_function_role`
--

CREATE TABLE `module_function_role` (
  `id` int(11) NOT NULL,
  `module_function_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `module_function_role`
--

INSERT INTO `module_function_role` (`id`, `module_function_id`, `role_id`) VALUES
(11425, 499, 4),
(11426, 498, 4),
(11427, 497, 4),
(11428, 496, 4),
(11429, 495, 4),
(11430, 494, 4),
(11431, 493, 4),
(11432, 492, 4),
(11433, 491, 4),
(11434, 490, 4),
(11435, 489, 4),
(11436, 488, 4),
(11437, 487, 4),
(11438, 486, 4),
(11439, 485, 4),
(11440, 484, 4),
(11441, 483, 4),
(11442, 482, 4),
(11443, 481, 4),
(11444, 480, 4),
(11445, 479, 4),
(11446, 478, 4),
(11447, 477, 4),
(11448, 476, 4),
(11449, 475, 4),
(11450, 474, 4),
(11451, 473, 4),
(11452, 472, 4),
(11453, 471, 4),
(11454, 470, 4),
(11455, 469, 4),
(11456, 468, 4),
(11457, 467, 4),
(11458, 466, 4),
(11459, 465, 4),
(11460, 464, 4),
(11461, 463, 4),
(11462, 462, 4),
(11463, 461, 4),
(11471, 509, 7),
(11472, 508, 7),
(11473, 507, 7),
(11474, 506, 7),
(11475, 505, 7),
(11476, 504, 7),
(11477, 503, 7),
(11478, 588, 8),
(11479, 587, 8),
(11480, 586, 8),
(11481, 536, 8),
(11482, 535, 8),
(11483, 534, 8),
(11484, 502, 9),
(11485, 501, 9),
(11486, 500, 9),
(11487, 502, 10),
(11488, 501, 10),
(11489, 500, 10),
(11490, 502, 11),
(11491, 501, 11),
(11492, 500, 11),
(12143, 615, 6),
(12144, 614, 6),
(12145, 613, 6),
(12146, 612, 6),
(12147, 611, 6),
(13296, 620, 3),
(13297, 619, 3),
(13298, 618, 3),
(13299, 533, 3),
(13300, 532, 3),
(13301, 531, 3),
(27047, 278, 12),
(27745, 854, 1),
(27746, 853, 1),
(27747, 852, 1),
(27748, 851, 1),
(27749, 850, 1),
(27750, 849, 1),
(27751, 848, 1),
(27752, 839, 1),
(27753, 838, 1),
(27754, 837, 1),
(27755, 836, 1),
(27756, 835, 1),
(27757, 834, 1),
(27758, 832, 1),
(27759, 831, 1),
(27760, 830, 1),
(27761, 829, 1),
(27762, 828, 1),
(27763, 827, 1),
(27764, 826, 1),
(27765, 825, 1),
(27766, 824, 1),
(27767, 823, 1),
(27768, 822, 1),
(27769, 821, 1),
(27770, 820, 1),
(27771, 819, 1),
(27772, 818, 1),
(27773, 817, 1),
(27774, 816, 1),
(27775, 815, 1),
(27776, 814, 1),
(27777, 813, 1),
(27778, 812, 1),
(27779, 811, 1),
(27780, 810, 1),
(27781, 809, 1),
(27782, 808, 1),
(27783, 807, 1),
(27784, 806, 1),
(27785, 805, 1),
(27786, 804, 1),
(27787, 803, 1),
(27788, 798, 1),
(27789, 787, 1),
(27790, 786, 1),
(27791, 785, 1),
(27792, 784, 1),
(27793, 783, 1),
(27794, 791, 1),
(27795, 790, 1),
(27796, 789, 1),
(27797, 788, 1),
(27798, 751, 1),
(27799, 750, 1),
(27800, 749, 1),
(27801, 748, 1),
(27802, 833, 1),
(27803, 743, 1),
(27804, 742, 1),
(27805, 741, 1),
(27806, 740, 1),
(27807, 739, 1),
(27808, 738, 1),
(27809, 734, 1),
(27810, 733, 1),
(27811, 732, 1),
(27812, 731, 1),
(27813, 730, 1),
(27814, 729, 1),
(27815, 728, 1),
(27816, 727, 1),
(27817, 726, 1),
(27818, 725, 1),
(27819, 724, 1),
(27820, 723, 1),
(27821, 692, 1),
(27822, 691, 1),
(27823, 690, 1),
(27824, 689, 1),
(27825, 688, 1),
(27826, 687, 1),
(27827, 674, 1),
(27828, 673, 1),
(27829, 672, 1),
(27830, 662, 1),
(27831, 661, 1),
(27832, 660, 1),
(27833, 656, 1),
(27834, 655, 1),
(27835, 654, 1),
(27836, 650, 1),
(27837, 649, 1),
(27838, 648, 1),
(27839, 747, 1),
(27840, 746, 1),
(27841, 745, 1),
(27842, 744, 1),
(27843, 641, 1),
(27844, 640, 1),
(27845, 639, 1),
(27846, 797, 1),
(27847, 638, 1),
(27848, 637, 1),
(27849, 636, 1),
(27850, 840, 1),
(27851, 621, 1),
(27852, 607, 1),
(27853, 606, 1),
(27854, 605, 1),
(27855, 604, 1),
(27856, 603, 1),
(27857, 602, 1),
(27858, 536, 1),
(27859, 535, 1),
(27860, 534, 1),
(27861, 533, 1),
(27862, 532, 1),
(27863, 531, 1),
(27864, 518, 1),
(27865, 517, 1),
(27866, 516, 1),
(27867, 277, 1),
(27868, 276, 1),
(27869, 275, 1),
(27870, 859, 1),
(27871, 858, 1),
(27872, 857, 1),
(27873, 856, 1),
(27874, 855, 1),
(27875, 284, 1),
(27876, 283, 1),
(27877, 282, 1),
(27878, 601, 1),
(27879, 600, 1),
(27880, 599, 1),
(27881, 598, 1),
(27882, 290, 1),
(27883, 289, 1),
(27884, 288, 1),
(27885, 291, 1),
(27886, 403, 1),
(27887, 402, 1),
(27888, 401, 1),
(27889, 406, 1),
(27890, 405, 1),
(27891, 404, 1),
(27892, 775, 1),
(27893, 774, 1),
(27894, 773, 1),
(27895, 772, 1),
(27896, 771, 1),
(27897, 770, 1),
(27898, 769, 1),
(27899, 768, 1),
(27900, 767, 1),
(28052, 854, 2),
(28053, 853, 2),
(28054, 852, 2),
(28055, 851, 2),
(28056, 850, 2),
(28057, 849, 2),
(28058, 839, 2),
(28059, 838, 2),
(28060, 837, 2),
(28061, 836, 2),
(28062, 835, 2),
(28063, 834, 2),
(28064, 832, 2),
(28065, 831, 2),
(28066, 830, 2),
(28067, 829, 2),
(28068, 828, 2),
(28069, 827, 2),
(28070, 826, 2),
(28071, 825, 2),
(28072, 824, 2),
(28073, 823, 2),
(28074, 822, 2),
(28075, 821, 2),
(28076, 820, 2),
(28077, 819, 2),
(28078, 818, 2),
(28079, 817, 2),
(28080, 816, 2),
(28081, 815, 2),
(28082, 814, 2),
(28083, 813, 2),
(28084, 812, 2),
(28085, 811, 2),
(28086, 810, 2),
(28087, 809, 2),
(28088, 808, 2),
(28089, 807, 2),
(28090, 806, 2),
(28091, 805, 2),
(28092, 804, 2),
(28093, 803, 2),
(28094, 798, 2),
(28095, 787, 2),
(28096, 786, 2),
(28097, 785, 2),
(28098, 784, 2),
(28099, 783, 2),
(28100, 791, 2),
(28101, 790, 2),
(28102, 789, 2),
(28103, 788, 2),
(28104, 751, 2),
(28105, 750, 2),
(28106, 749, 2),
(28107, 748, 2),
(28108, 833, 2),
(28109, 743, 2),
(28110, 742, 2),
(28111, 741, 2),
(28112, 740, 2),
(28113, 739, 2),
(28114, 738, 2),
(28115, 734, 2),
(28116, 733, 2),
(28117, 732, 2),
(28118, 731, 2),
(28119, 730, 2),
(28120, 729, 2),
(28121, 728, 2),
(28122, 727, 2),
(28123, 726, 2),
(28124, 725, 2),
(28125, 724, 2),
(28126, 723, 2),
(28127, 692, 2),
(28128, 691, 2),
(28129, 690, 2),
(28130, 689, 2),
(28131, 688, 2),
(28132, 687, 2),
(28133, 674, 2),
(28134, 673, 2),
(28135, 672, 2),
(28136, 662, 2),
(28137, 661, 2),
(28138, 660, 2),
(28139, 656, 2),
(28140, 655, 2),
(28141, 654, 2),
(28142, 796, 2),
(28143, 650, 2),
(28144, 649, 2),
(28145, 648, 2),
(28146, 747, 2),
(28147, 746, 2),
(28148, 745, 2),
(28149, 744, 2),
(28150, 641, 2),
(28151, 640, 2),
(28152, 639, 2),
(28153, 797, 2),
(28154, 638, 2),
(28155, 637, 2),
(28156, 636, 2),
(28157, 840, 2),
(28158, 621, 2),
(28159, 607, 2),
(28160, 606, 2),
(28161, 605, 2),
(28162, 604, 2),
(28163, 603, 2),
(28164, 602, 2),
(28165, 536, 2),
(28166, 535, 2),
(28167, 534, 2),
(28168, 533, 2),
(28169, 532, 2),
(28170, 531, 2),
(28171, 518, 2),
(28172, 517, 2),
(28173, 516, 2),
(28174, 277, 2),
(28175, 276, 2),
(28176, 275, 2),
(28177, 859, 2),
(28178, 858, 2),
(28179, 857, 2),
(28180, 856, 2),
(28181, 855, 2),
(28182, 284, 2),
(28183, 283, 2),
(28184, 282, 2),
(28185, 601, 2),
(28186, 600, 2),
(28187, 599, 2),
(28188, 598, 2),
(28189, 290, 2),
(28190, 289, 2),
(28191, 288, 2),
(28192, 291, 2),
(28193, 403, 2),
(28194, 402, 2),
(28195, 401, 2),
(28196, 406, 2),
(28197, 405, 2),
(28198, 404, 2),
(28199, 775, 2),
(28200, 774, 2),
(28201, 773, 2),
(28202, 772, 2),
(28203, 771, 2),
(28204, 770, 2),
(28205, 769, 2),
(28206, 768, 2),
(28207, 767, 2),
(28208, 854, 12),
(28209, 853, 12),
(28210, 852, 12),
(28211, 804, 12),
(28212, 798, 12),
(28213, 791, 12),
(28214, 790, 12),
(28215, 789, 12),
(28216, 788, 12),
(28217, 674, 12),
(28218, 672, 12),
(28219, 649, 12),
(28220, 648, 12),
(28221, 840, 12),
(28222, 621, 12),
(28223, 531, 12);

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
(0, 'dashboard', NULL, 1, '2026-02-23 09:48:11'),
(0, 'dashboard', NULL, 1, '2026-02-23 10:58:23'),
(0, 'dashboard', NULL, 1, '2026-02-23 10:58:26'),
(0, 'dashboard', NULL, 1, '2026-02-23 10:58:26'),
(0, 'dashboard', NULL, 1, '2026-02-23 10:58:33'),
(0, 'dashboard', NULL, 1, '2026-02-23 10:58:33'),
(0, 'dashboard', NULL, 1, '2026-02-23 10:58:33'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:07:18'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:07:18'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:07:18'),
(0, 'module', 'all', 1, '2026-02-23 11:07:28'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:07:28'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:07:28'),
(0, 'module', 'all', 1, '2026-02-23 11:07:42'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:07:43'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:07:43'),
(0, 'module', 'all', 1, '2026-02-23 11:07:47'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:07:47'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:07:47'),
(0, 'module', 'all', 1, '2026-02-23 11:07:53'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:07:53'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:07:54'),
(0, 'staff', 'all', 1, '2026-02-23 11:08:08'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:08'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:09'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:16'),
(0, 'staff', 'all', 1, '2026-02-23 11:08:20'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:20'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:20'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:28'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:38'),
(0, 'staff', 'all', 1, '2026-02-23 11:08:40'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:40'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:40'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:42'),
(0, 'module', 'all', 1, '2026-02-23 11:08:43'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:43'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:43'),
(0, 'module', 'all', 1, '2026-02-23 11:08:57'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:57'),
(0, 'dashboard', NULL, 1, '2026-02-23 11:08:57');

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
