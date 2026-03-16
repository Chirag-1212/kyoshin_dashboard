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

ALTER TABLE `service` 
ADD CONSTRAINT `fk_service_to_category` 
FOREIGN KEY (`service_category_id`) REFERENCES `service_category`(`id`) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- Main gallery table
CREATE TABLE gallery (
    id INT(11) NOT NULL AUTO_INCREMENT,
    title_en VARCHAR(255) NOT NULL,
    title_jp VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    coverimage VARCHAR(255) DEFAULT NULL,
    status ENUM('0', '1', '2') DEFAULT '1' COMMENT '0: Inactive, 1: Active, 2: Soft Delete',
    created DATE DEFAULT NULL,
    created_by INT(11) DEFAULT NULL,
    updated DATE DEFAULT NULL,
    updated_by INT(11) DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Multi-image storage for gallery
CREATE TABLE gallery_images (
    id INT(11) NOT NULL AUTO_INCREMENT,
    gallery_id INT(11) NOT NULL,
    docpath VARCHAR(255) NOT NULL,
    status ENUM('0', '1', '2') DEFAULT '1',
    created_on DATETIME DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 1. Add the slug column if it doesn't exist
-- Using 191 is a safe length for indexing in modern MySQL/MariaDB
ALTER TABLE job_category 
ADD COLUMN IF NOT EXISTS slug VARCHAR(191) NULL DEFAULT NULL AFTER title_jp;

-- 2. Ensure all column names are strictly lowercase (renaming if necessary)
-- If your 'desc_en' was accidentally 'Description', this fixes it:
ALTER TABLE job_category 
CHANGE COLUMN IF EXISTS Description desc_en TEXT NULL DEFAULT NULL,
CHANGE COLUMN IF EXISTS description_jp desc_jp TEXT NULL DEFAULT NULL;

-- 3. Update existing records to have a slug (optional but recommended)
-- This replaces spaces with dashes and makes everything lowercase
UPDATE job_category 
SET slug = LOWER(REPLACE(title_en, ' ', '-')) 
WHERE slug IS NULL OR slug = '';

-- table to store news articles
create table news (
    id int auto_increment primary key,
    title_en varchar(255),
    title_jp varchar(255),
    slug varchar(255),
    desc_en text,
    desc_jp text,
    docpath varchar(255),
    status tinyint default 1, -- 1: active, 2: deleted
    created_on datetime,
    created_by int,
    updated_on datetime,
    updated_by int
);

create table news_images (
    id int auto_increment primary key,
    news_id int,
    docpath varchar(255),
    status tinyint default 1, -- 1: active, 2: deleted
    created_on datetime,
    created_by int,
    foreign key (news_id) references news(id) on delete cascade
);


CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submitdt` date DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(191) NOT NULL, 
  `docpath` varchar(255) DEFAULT NULL,
  `target` varchar(50) DEFAULT NULL,
  `border` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `type` varchar(10) DEFAULT 'ba',
  `file_type` varchar(50) DEFAULT NULL,
  `created_on` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `count` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `title_jp` VARCHAR(255) DEFAULT NULL,
  `number` VARCHAR(100) DEFAULT NULL,
  `number_jp` VARCHAR(100) DEFAULT NULL,
  `slug` VARCHAR(191) NOT NULL, -- Reduced to 191
  `status` TINYINT(1) DEFAULT 1,
  `created_on` DATE DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_on` DATE DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE testimonials (
    id INT(11) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    title_jp VARCHAR(255) DEFAULT NULL,
    sub_title VARCHAR(255) DEFAULT NULL,
    sub_title_jp VARCHAR(255) DEFAULT NULL,
    slug VARCHAR(255) NOT NULL,
    doc_path VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    description_nepali TEXT DEFAULT NULL,
    status TINYINT(1) DEFAULT 1 COMMENT '0:inactive, 1:active, 2:deleted',
    created_on DATE DEFAULT NULL,
    created_by INT(11) DEFAULT NULL,
    updated_on DATE DEFAULT NULL,
    updated_by INT(11) DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY unique_slug (slug(191)) -- Added (191) to fix the key length error
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;