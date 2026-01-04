-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Jan 04, 2026 at 06:35 AM
-- Server version: 11.4.9-MariaDB-ubu2404
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `full_name`, `email`, `password_hash`, `created_at`) VALUES
(1, 'Administrator', 'admin@sjk.local', '$2y$10$r2rayk51YXhrsSunOx4nouQloqw2IWEcuZt9ellK/lx4RrXBohJR.', '2026-01-03 18:39:10');

-- --------------------------------------------------------

--
-- Table structure for table `career_paths`
--

CREATE TABLE `career_paths` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `required_skills` text DEFAULT NULL,
  `education_path` varchar(255) DEFAULT NULL,
  `salary_range` varchar(100) DEFAULT NULL,
  `outlook` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `name` varchar(255) GENERATED ALWAYS AS (`title`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `career_paths`
--

INSERT INTO `career_paths` (`id`, `title`, `category`, `description`, `required_skills`, `education_path`, `salary_range`, `outlook`, `created_at`, `updated_at`) VALUES
(1, 'Data Scientist', 'Technology', 'Menganalisis data untuk menghasilkan insight dan keputusan bisnis.', 'Python, SQL, Statistics, Machine Learning', 'S1 Informatika / Statistika / Matematika', '10 – 25 juta', 'Very High', '2026-01-04 06:21:07', NULL),
(2, 'Software Engineer', 'Technology', 'Mengembangkan dan memelihara aplikasi perangkat lunak.', 'PHP, JavaScript, Git, OOP', 'S1 Informatika / Sistem Informasi', '8 – 20 juta', 'High', '2026-01-04 06:21:07', NULL),
(3, 'UI/UX Designer', 'Design', 'Merancang antarmuka dan pengalaman pengguna.', 'Figma, UX Research, Prototyping', 'S1 Desain / Bootcamp UI UX', '7 – 18 juta', 'High', '2026-01-04 06:21:07', NULL);

--
-- Triggers `career_paths`
--
DELIMITER $$
CREATE TRIGGER `sync_career_name` BEFORE INSERT ON `career_paths` FOR EACH ROW SET NEW.name = NEW.title
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sync_career_name_update` BEFORE UPDATE ON `career_paths` FOR EACH ROW SET NEW.name = NEW.title
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `education_level` varchar(100) DEFAULT NULL,
  `grade_or_major` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `gender`, `email`, `password_hash`, `education_level`, `grade_or_major`, `created_at`) VALUES
(1, 'Tes', 'Male', 'Candra@Uii.c', '$2y$10$qxJFwiKV/3T3ZlOSRmKjEuFlVlwD76Yq4mXAEY2BjDyyJkP12sbj.', 'High School', '11', '2026-01-03 18:45:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_assessments`
--

CREATE TABLE `user_assessments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `favorite_subject` varchar(100) DEFAULT NULL,
  `interest_area` varchar(100) DEFAULT NULL,
  `personality_type` varchar(100) DEFAULT NULL,
  `top_skill` varchar(150) DEFAULT NULL,
  `career_values` text DEFAULT NULL,
  `career_path_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_assessments`
--

INSERT INTO `user_assessments` (`id`, `user_id`, `favorite_subject`, `interest_area`, `personality_type`, `top_skill`, `career_values`, `career_path_id`, `score`, `completed_at`) VALUES
(5, 1, 'Assessment-Saintek', 'Saintek', 'Strong Match (100%)', 'Medical Doctor', 'Interest determined via Saintek path assessment.', NULL, NULL, '2026-01-04 06:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assessment_id` int(11) DEFAULT NULL,
  `progress_percentage` int(11) DEFAULT NULL,
  `last_updated` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `career_paths`
--
ALTER TABLE `career_paths`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_title` (`title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_assessments`
--
ALTER TABLE `user_assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assessment_id` (`assessment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `career_paths`
--
ALTER TABLE `career_paths`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_assessments`
--
ALTER TABLE `user_assessments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_assessments`
--
ALTER TABLE `user_assessments`
  ADD CONSTRAINT `user_assessments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_progress_ibfk_2` FOREIGN KEY (`assessment_id`) REFERENCES `user_assessments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
