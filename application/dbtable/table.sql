ADDED
CREATE TABLE `about_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `title_jp` varchar(255) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL,
  
  -- Changed desc_en to MEDIUMTEXT to support long content
  `desc_en` mediumtext DEFAULT NULL,
  `desc_jp` mediumtext DEFAULT NULL,
  
  `docpath` varchar(255) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  
  -- Audit Logs
  `created_by` int(11) DEFAULT NULL,
  `created_on` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT 0,
  `updated_on` date DEFAULT NULL,

  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `job_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) NOT NULL,
  `title_jp` varchar(255) DEFAULT NULL,
  `desc_en` text DEFAULT NULL,
  `desc_jp` text DEFAULT NULL,
  `docpath` varchar(255) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `job_category`
ADD COLUMN `slug` VARCHAR(191) DEFAULT NULL,
ADD UNIQUE KEY `slug` (`slug`);

CREATE TABLE `our_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `title_jp` varchar(255) DEFAULT NULL,
  `slug` varchar(191) NOT NULL,
  `sub_level` varchar(255) DEFAULT NULL,
  `sub_text_en` varchar(255) DEFAULT NULL,
  `sub_text_jp` varchar(255) DEFAULT NULL,
  `desc_en` text DEFAULT NULL,
  `desc_jp` text DEFAULT NULL,
  `docpath` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8 NOT NULL,
  `category` varchar(100) NOT NULL, -- To distinguish between visa, career, etc.
  `title_en` varchar(255) NOT NULL,
  `title_jp` varchar(255) DEFAULT NULL,
  `desc_en` longtext DEFAULT NULL,
  `desc_jp` longtext DEFAULT NULL,
  `docpath` varchar(255) DEFAULT NULL,
  `coverimage` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `serial` int(11) DEFAULT NULL,
  `service_category_id` int(11) DEFAULT NULL,
  `datevalue` date DEFAULT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1',
  `created_on` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `service_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT 0,
  `slug` varchar(191) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1',
  `created_on` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;