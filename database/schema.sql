-- InternTrack database schema
-- Target: MySQL / MariaDB via XAMPP
-- Usage: import via phpMyAdmin, or `mysql -u root -p < database/schema.sql`

CREATE DATABASE IF NOT EXISTS `interntrack`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `interntrack`;

-- =====================================================================
-- STUDENT PROFILE (Spec Section 6)
-- =====================================================================

CREATE TABLE IF NOT EXISTS `students` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `display_name` VARCHAR(150) NOT NULL,
  `institution_name` VARCHAR(150) NOT NULL,
  `qualification_level` VARCHAR(60) DEFAULT NULL,
  `faculty` VARCHAR(150) DEFAULT NULL,
  `course_name` VARCHAR(150) DEFAULT NULL,
  `course_code` VARCHAR(30) DEFAULT NULL,
  `study_year` TINYINT UNSIGNED DEFAULT NULL,
  `current_semester` TINYINT UNSIGNED DEFAULT NULL,
  `expected_graduation_date` DATE DEFAULT NULL,
  `internship_start_date` DATE DEFAULT NULL,
  `internship_end_date` DATE DEFAULT NULL,
  `internship_duration_weeks` SMALLINT UNSIGNED DEFAULT NULL,
  `current_cgpa` DECIMAL(4,2) DEFAULT NULL,
  `cgpa_scale` DECIMAL(3,2) NOT NULL DEFAULT 4.00,
  `latest_semester_gpa` DECIMAL(4,2) DEFAULT NULL,
  `portfolio_url` VARCHAR(255) DEFAULT NULL,
  `github_url` VARCHAR(255) DEFAULT NULL,
  `linkedin_url` VARCHAR(255) DEFAULT NULL,
  `preferred_work_mode` ENUM('onsite','remote','hybrid','flexible') DEFAULT 'flexible',
  `minimum_allowance` DECIMAL(8,2) DEFAULT NULL,
  `willing_to_relocate` TINYINT(1) NOT NULL DEFAULT 0,
  `transport_availability` VARCHAR(100) DEFAULT NULL,
  `preferred_company_size` VARCHAR(50) DEFAULT NULL,
  `photo_path` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `student_subjects` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT UNSIGNED NOT NULL,
  `subject_name` VARCHAR(150) NOT NULL,
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `student_academic_projects` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `description` TEXT,
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `student_skills` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT UNSIGNED NOT NULL,
  `skill_type` ENUM('technical_skill','software_tool','soft_skill','language') NOT NULL,
  `skill_name` VARCHAR(100) NOT NULL,
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `student_preferences` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT UNSIGNED NOT NULL,
  `preference_type` ENUM('industry','job_role','state') NOT NULL,
  `preference_value` VARCHAR(150) NOT NULL,
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- COMPANY DIRECTORY (Spec Section 2.A)
-- =====================================================================

CREATE TABLE IF NOT EXISTS `companies` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(200) NOT NULL,
  `industry` VARCHAR(150) DEFAULT NULL,
  `state` VARCHAR(100) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `website` VARCHAR(255) DEFAULT NULL,
  `profile_summary` TEXT,
  `source_label` ENUM('Demo','Manually added','Public source','Employer feed') NOT NULL DEFAULT 'Demo',
  `source_url` VARCHAR(255) DEFAULT NULL,
  `verified_at` DATE DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- INTERNSHIP OPPORTUNITIES (Spec Section 2.B, 4, 5)
-- =====================================================================

CREATE TABLE IF NOT EXISTS `opportunities` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `description` TEXT,
  `requirements` TEXT,
  `min_cgpa` DECIMAL(4,2) DEFAULT NULL COMMENT 'NULL = not specified, no penalty',
  `location_state` VARCHAR(100) DEFAULT NULL,
  `location_city` VARCHAR(100) DEFAULT NULL,
  `work_mode` ENUM('onsite','remote','hybrid') DEFAULT 'onsite',
  `duration_weeks` SMALLINT UNSIGNED DEFAULT NULL,
  `start_date` DATE DEFAULT NULL,
  `end_date` DATE DEFAULT NULL,
  `closing_date` DATE DEFAULT NULL,
  `amount_min` DECIMAL(8,2) DEFAULT NULL,
  `amount_max` DECIMAL(8,2) DEFAULT NULL,
  `currency` VARCHAR(10) NOT NULL DEFAULT 'MYR',
  `pay_period` ENUM('monthly','daily','hourly','one_off','unknown') NOT NULL DEFAULT 'unknown',
  `allowance_type` ENUM('paid','unpaid','not_disclosed','negotiable') NOT NULL DEFAULT 'not_disclosed',
  `salary_source_url` VARCHAR(255) DEFAULT NULL,
  `salary_last_verified_at` DATE DEFAULT NULL,
  `salary_confidence` ENUM('high','medium','low') DEFAULT NULL,
  `application_url` VARCHAR(255) DEFAULT NULL,
  `record_label` ENUM('Demo','Manually added','Public source','Employer feed') NOT NULL DEFAULT 'Demo',
  `status` ENUM('open','closed','unknown') NOT NULL DEFAULT 'open',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `opportunity_required_skills` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `opportunity_id` INT UNSIGNED NOT NULL,
  `skill_name` VARCHAR(100) NOT NULL,
  FOREIGN KEY (`opportunity_id`) REFERENCES `opportunities`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- MATCHING RESULT (Spec Section 2.D, 8)
-- =====================================================================

CREATE TABLE IF NOT EXISTS `matches` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT UNSIGNED NOT NULL,
  `opportunity_id` INT UNSIGNED NOT NULL,
  `course_score` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'max 30',
  `skills_score` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'max 20',
  `cgpa_score` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'max 15',
  `industry_score` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'max 10',
  `location_score` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'max 10',
  `date_score` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'max 10',
  `allowance_score` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'max 5',
  `total_score` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'sum, max 100',
  `label` ENUM('Excellent match','Strong match','Potential match','Low match','Weak match') NOT NULL,
  `cgpa_requirement_status` ENUM('meets','does_not_meet','not_specified') NOT NULL DEFAULT 'not_specified',
  `ai_explanation` TEXT DEFAULT NULL,
  `ai_generated_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uniq_student_opportunity` (`student_id`, `opportunity_id`),
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`opportunity_id`) REFERENCES `opportunities`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- APPLICATION TRACKING (Spec Section 10, modules 6-7-8)
-- =====================================================================

CREATE TABLE IF NOT EXISTS `applications` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT UNSIGNED NOT NULL,
  `opportunity_id` INT UNSIGNED NOT NULL,
  `status` ENUM('saved','applied','interview','offer','rejected','withdrawn') NOT NULL DEFAULT 'saved',
  `applied_at` DATE DEFAULT NULL,
  `interview_at` DATETIME DEFAULT NULL,
  `decision_at` DATE DEFAULT NULL,
  `notes` TEXT,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uniq_student_application` (`student_id`, `opportunity_id`),
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`opportunity_id`) REFERENCES `opportunities`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `application_timeline` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `application_id` INT UNSIGNED NOT NULL,
  `event_type` VARCHAR(50) NOT NULL,
  `event_date` DATETIME NOT NULL,
  `description` TEXT,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`application_id`) REFERENCES `applications`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `reminders` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT UNSIGNED NOT NULL,
  `application_id` INT UNSIGNED DEFAULT NULL,
  `title` VARCHAR(200) NOT NULL,
  `reminder_date` DATETIME NOT NULL,
  `reminder_type` ENUM('interview','follow_up','deadline','other') NOT NULL DEFAULT 'other',
  `is_done` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`application_id`) REFERENCES `applications`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
