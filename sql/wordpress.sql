-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 22, 2025 at 06:34 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `career_paths`
--

CREATE TABLE `career_paths` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text,
  `required_skills` text,
  `education_path` varchar(255) DEFAULT NULL,
  `salary_range` varchar(100) DEFAULT NULL,
  `outlook` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `career_paths`
--

INSERT INTO `career_paths` (`id`, `title`, `category`, `description`, `required_skills`, `education_path`, `salary_range`, `outlook`) VALUES
(1, 'Software Engineer', 'Technology', 'Building and maintaining software systems, applications, and networks.', 'Problem Solving, Logic, Programming Languages (Python, JS)', 'BSc Computer Science/Informatics', 'Rp 10 Million - Rp 30 Million+', 'High'),
(2, 'Data Scientist', 'Technology', 'Analyzing large datasets to find patterns and make predictions.', 'Mathematics, Statistics, Machine Learning, Python', 'BSc/MSc Statistics/Data Science', 'Rp 12 Million - Rp 40 Million+', 'High'),
(3, 'Marketing Manager', 'Business', 'Planning and executing marketing strategies to increase sales.', 'Communication, Strategy, Market Analysis', 'BSc Management/Business', 'Rp 8 Million - Rp 25 Million', 'Medium'),
(4, 'UI/UX Designer', 'Design', 'Designing intuitive and engaging user interfaces and experiences.', 'Graphic Design, Empathic Thinking, Prototyping (Figma)', 'BSc Visual Communication Design', 'Rp 7 Million - Rp 20 Million', 'High'),
(5, 'Medical Doctor', 'Science', 'Diagnosing and treating human illnesses and injuries.', 'Biology, Attention to Detail, Ethics, Communication', 'Medical Degree + Specialization', 'Rp 15 Million - Rp 50 Million+', 'High'),
(6, 'Social Worker', 'Social', 'Helping individuals and communities overcome problems and improve quality of life.', 'Empathy, Counselling, Case Management', 'BSc Social Welfare', 'Rp 5 Million - Rp 12 Million', 'Medium'),
(7, 'Software Engineer', 'Saintek', 'Building and maintaining software systems, applications, and networks.', 'Problem Solving, Logic, Programming Languages (Python, JS)', 'BSc Computer Science/Informatics', 'Rp 10 Million - Rp 30 Million+', 'High'),
(8, 'Data Scientist', 'Saintek', 'Analyzing large datasets to find patterns and make predictions.', 'Mathematics, Statistics, Machine Learning, Python', 'BSc/MSc Statistics/Data Science', 'Rp 12 Million - Rp 40 Million+', 'High'),
(9, 'Marketing Manager', 'Soshum', 'Planning and executing marketing strategies to increase sales.', 'Communication, Strategy, Market Analysis', 'BSc Management/Business', 'Rp 8 Million - Rp 25 Million', 'Medium'),
(10, 'Economist', 'Soshum', 'Analyzing economic trends, researching data, and developing forecasts.', 'Econometrics, Data Analysis, Critical Thinking', 'BSc/MSc Economics', 'Rp 10 Million - Rp 35 Million', 'High'),
(11, 'Professional Translator', 'Bahasa', 'Converting documents or conversations from one language to another with high accuracy.', 'Foreign Language Fluency (Verbal & Written), Cultural Understanding, Attention to Detail.', 'BSc Literature/Foreign Language Studies', 'Rp 7 Million - Rp 15 Million', 'Medium'),
(12, 'Content Writer & Journalist', 'Bahasa', 'Creating compelling and informative articles, news, or digital content for various media.', 'Strong Writing Skills, Research, Interviewing, Journalism Ethics.', 'BSc Communication Science/Literature', 'Rp 5 Million - Rp 12 Million', 'High'),
(13, 'UI/UX Designer', 'Seni', 'Designing intuitive and engaging user interfaces and experiences for digital products.', 'Graphic Design, Empathic Thinking, Prototyping (Figma), Visual Aesthetics.', 'BSc Visual Communication Design', 'Rp 7 Million - Rp 20 Million', 'High'),
(14, 'Curator & Gallery Manager', 'Seni', 'Managing art collections, designing exhibitions, and interpreting works for the public.', 'Art History, Curatorial Studies, Project Management, Public Speaking.', 'BSc/MSc Fine Arts/Art History', 'Rp 6 Million - Rp 14 Million', 'Medium');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `education_level` varchar(50) DEFAULT 'High School',
  `grade_or_major` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password_hash`, `education_level`, `grade_or_major`, `created_at`) VALUES
(1, 'Farrell Abhivandya Mecca', 'farrellmecca@gmail.com', '$2y$10$ckPgDd7H8o4bdajYMkpT7uUs9EnieCDB3LNhDKMjrK55nVezqUXt2', 'University', 'Informatics', '2025-12-15 15:23:12'),
(2, 'Candra', 'Candra@Uii', '$2y$10$ipAk503a6Iup.AUaANlwbuL0M7.dkb27.VHEUA1HdMI7jQN.i2Quy', 'University', '11 / Informatics', '2025-12-16 03:35:59');

-- --------------------------------------------------------

--
-- Table structure for table `user_assessments`
--

CREATE TABLE `user_assessments` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `favorite_subject` varchar(100) DEFAULT NULL,
  `interest_area` varchar(100) DEFAULT NULL,
  `personality_type` varchar(100) DEFAULT NULL,
  `top_skill` varchar(150) DEFAULT NULL,
  `career_values` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_assessments`
--

INSERT INTO `user_assessments` (`id`, `user_id`, `favorite_subject`, `interest_area`, `personality_type`, `top_skill`, `career_values`, `created_at`) VALUES
(2, 1, 'Assessment-Saintek', 'Saintek', 'Moderate Match (53%)', 'Assessment Score: 8/15', 'Interest determined via Saintek path assessment.', '2025-12-15 15:38:12'),
(3, 1, 'Assessment-Soshum', 'Soshum', 'Strong Match (100%)', 'Assessment Score: 15/15', 'Interest determined via Soshum path assessment.', '2025-12-15 15:38:51'),
(4, 1, 'Assessment-Bahasa', 'Bahasa', 'Low Match (33%)', 'Assessment Score: 5/15', 'Interest determined via Bahasa path assessment.', '2025-12-15 23:49:02'),
(5, 1, 'Assessment-Saintek', 'Saintek', 'Moderate Match (53%)', 'Assessment Score: 8/15', 'Interest determined via Saintek path assessment.', '2025-12-16 02:24:28'),
(6, 2, 'Assessment-Saintek', 'Saintek', 'Moderate Match (60%)', 'Assessment Score: 9/15', 'Interest determined via Saintek path assessment.', '2025-12-16 03:38:10'),
(7, 2, 'Assessment-Soshum', 'Soshum', 'Moderate Match (47%)', 'Assessment Score: 7/15', 'Interest determined via Soshum path assessment.', '2025-12-16 03:49:13'),
(8, 1, 'Assessment-Saintek', 'Saintek', 'Strong Match (73%)', 'Assessment Score: 11/15', 'Interest determined via Saintek path assessment.', '2025-12-16 14:55:05');

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `academic_score` int DEFAULT '0',
  `skill_score` int DEFAULT '0',
  `consistency_score` int DEFAULT '0',
  `readiness_score` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `career_paths`
--
ALTER TABLE `career_paths`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `career_paths`
--
ALTER TABLE `career_paths`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_assessments`
--
ALTER TABLE `user_assessments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_assessments`
--
ALTER TABLE `user_assessments`
  ADD CONSTRAINT `user_assessments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
