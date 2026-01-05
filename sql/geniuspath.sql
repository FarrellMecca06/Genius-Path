-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Jan 04, 2026 at 04:05 PM
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
(1, 'Administrator', 'admin@sjk.local', '$2y$12$SjHxPGh8chxuRZAmLRdVmuA7arASZGSAsPn17b0zKmLK2GmgCnL0C', '2026-01-04 14:04:58');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `career_paths`
--

INSERT INTO `career_paths` (`id`, `title`, `category`, `description`, `required_skills`, `education_path`, `salary_range`, `outlook`, `created_at`, `updated_at`) VALUES
(1, 'Software Engineer', 'Saintek', 'Building and maintaining software systems, applications, and networks.', 'Problem Solving, Logic, Programming Languages (Python, JS)', 'BSc Computer Science/Informatics', 'Rp 10 Million - Rp 30 Million+', 'High', '2026-01-04 14:04:58', NULL),
(2, 'Data Scientist', 'Saintek', 'Analyzing large datasets to find patterns and make predictions.', 'Mathematics, Statistics, Machine Learning, Python', 'BSc/MSc Statistics/Data Science', 'Rp 12 Million - Rp 40 Million+', 'High', '2026-01-04 14:04:58', NULL),
(3, 'Marketing Manager', 'Soshum', 'Planning and executing marketing strategies to increase sales.', 'Communication, Strategy, Market Analysis', 'BSc Management/Business', 'Rp 8 Million - Rp 25 Million', 'Medium', '2026-01-04 14:04:58', NULL),
(5, 'Medical Doctor', 'Saintek', 'Diagnosing and treating human illnesses and injuries.', 'Biology, Attention to Detail, Ethics, Communication', 'Medical Degree + Specialization', 'Rp 15 Million - Rp 50 Million+', 'High', '2026-01-04 14:04:58', NULL),
(6, 'Social Worker', 'Soshum', 'Helping individuals and communities overcome problems and improve quality of life.', 'Empathy, Counselling, Case Management', 'BSc Social Welfare', 'Rp 5 Million - Rp 12 Million', 'Medium', '2026-01-04 14:04:58', NULL),
(10, 'Economist', 'Soshum', 'Analyzing economic trends, researching data, and developing forecasts.', 'Econometrics, Data Analysis, Critical Thinking', 'BSc/MSc Economics', 'Rp 10 Million - Rp 35 Million', 'High', '2026-01-04 14:04:58', NULL),
(11, 'Professional Translator', 'Bahasa', 'Converting documents or conversations from one language to another with high accuracy.', 'Foreign Language Fluency (Verbal & Written), Cultural Understanding, Attention to Detail.', 'BSc Literature/Foreign Language Studies', 'Rp 7 Million - Rp 15 Million', 'Medium', '2026-01-04 14:04:58', NULL),
(12, 'Content Writer & Journalist', 'Bahasa', 'Creating compelling and informative articles, news, or digital content for various media.', 'Strong Writing Skills, Research, Interviewing, Journalism Ethics.', 'BSc Communication Science/Literature', 'Rp 5 Million - Rp 12 Million', 'High', '2026-01-04 14:04:58', NULL),
(13, 'UI/UX Designer', 'Seni', 'Designing intuitive and engaging user interfaces and experiences for digital products.', 'Graphic Design, Empathic Thinking, Prototyping (Figma), Visual Aesthetics.', 'BSc Visual Communication Design', 'Rp 7 Million - Rp 20 Million', 'High', '2026-01-04 14:04:58', NULL),
(14, 'Curator & Gallery Manager', 'Seni', 'Managing art collections, designing exhibitions, and interpreting works for the public.', 'Art History, Curatorial Studies, Project Management, Public Speaking.', 'BSc/MSc Fine Arts/Art History', 'Rp 6 Million - Rp 14 Million', 'Medium', '2026-01-04 14:04:58', NULL),
(15, 'Cyber Security Analyst', 'Saintek', 'Protecting computer networks and systems from hackers and cyber attacks.', 'Networking, Ethical Hacking, Python, Security Protocols', 'BSc Computer Science/IT', 'Rp 15 Million - Rp 40 Million+', 'High', '2026-01-04 14:04:58', NULL),
(16, 'Robotics Engineer', 'Saintek', 'Designing and building robots for manufacturing, medicine, or exploration.', 'Mechanical Engineering, Programming (C++), AI, Electronics', 'BSc/MSc Robotics or Electrical Engineering', 'Rp 12 Million - Rp 35 Million+', 'High', '2026-01-04 14:04:58', NULL),
(17, 'Data Engineer', 'Saintek', 'Building systems that collect, manage, and convert raw data into usable information.', 'SQL, Big Data (Hadoop), Cloud Computing (AWS/GCP)', 'BSc Computer Science/Software Engineering', 'Rp 15 Million - Rp 45 Million+', 'High', '2026-01-04 14:04:58', NULL),
(18, 'Environmental Scientist', 'Saintek', 'Researching environmental issues and developing solutions to protect the planet.', 'Data Analysis, Lab Research, Policy Knowledge', 'BSc Environmental Science/Biology', 'Rp 8 Million - Rp 20 Million+', 'Medium', '2026-01-04 14:04:58', NULL),
(19, 'AI Research Scientist', 'Saintek', 'Developing new AI models and algorithms to advance the field of machine learning.', 'Advanced Math, Deep Learning, Python/PyTorch', 'MSc/PhD Artificial Intelligence/Computer Science', 'Rp 20 Million - Rp 60 Million+', 'High', '2026-01-04 14:04:58', NULL),
(20, 'Clinical Psychologist', 'Soshum', 'Diagnosing and treating mental, emotional, and behavioral disorders.', 'Empathy, Active Listening, Psychological Assessment', 'BSc Psychology + Professional Degree', 'Rp 10 Million - Rp 30 Million+', 'High', '2026-01-04 14:04:58', NULL),
(21, 'Financial Analyst', 'Soshum', 'Providing guidance to businesses and individuals making investment decisions.', 'Accounting, Data Analysis, Economic Knowledge', 'BSc Finance/Economics', 'Rp 12 Million - Rp 35 Million+', 'High', '2026-01-04 14:04:58', NULL),
(22, 'Corporate Lawyer', 'Soshum', 'Advising businesses on their legal rights, responsibilities, and duties.', 'Legal Writing, Negotiation, Critical Thinking', 'Bachelor of Law (SH) + Bar Certification', 'Rp 15 Million - Rp 50 Million+', 'High', '2026-01-04 14:04:58', NULL),
(23, 'Digital Marketing Specialist', 'Soshum', 'Creating and managing online campaigns to promote brands and products.', 'SEO/SEM, Copywriting, Social Media Analytics', 'BSc Marketing/Communication', 'Rp 8 Million - Rp 25 Million+', 'High', '2026-01-04 14:04:58', NULL),
(24, 'Sociologist', 'Soshum', 'Studying society and social behavior through research and data analysis.', 'Qualitative Research, Statistics, Analytical Thinking', 'BSc/MSc Sociology', 'Rp 7 Million - Rp 18 Million+', 'Medium', '2026-01-04 14:04:58', NULL),
(25, 'International Journalist', 'Bahasa', 'Reporting news from around the world for TV, print, or digital media.', 'News Writing, Foreign Languages, Interviewing', 'BSc Journalism/Communication', 'Rp 8 Million - Rp 25 Million+', 'Medium', '2026-01-04 14:04:58', NULL),
(26, 'Copywriter', 'Bahasa', 'Writing persuasive text for advertisements and marketing materials.', 'Creative Writing, Marketing, Brand Voice Analysis', 'BSc Communication/English/Indonesian Literature', 'Rp 7 Million - Rp 20 Million+', 'High', '2026-01-04 14:04:58', NULL),
(27, 'Diplomatic Officer', 'Bahasa', 'Representing the country interests in international relations and negotiations.', 'Negotiation, Multiple Languages, Political Science', 'BSc International Relations/Law', 'Rp 15 Million - Rp 40 Million+', 'High', '2026-01-04 14:04:58', NULL),
(28, 'Technical Writer', 'Bahasa', 'Creating complex manuals and documents for technical products or software.', 'Simplifying Complex Info, Tech Literacy, Grammar', 'BSc English/IT/Communication', 'Rp 10 Million - Rp 25 Million+', 'High', '2026-01-04 14:04:58', NULL),
(29, 'Audiovisual Translator', 'Bahasa', 'Translating and adapting scripts for movies, TV shows, and video games.', 'Translation, Subtitling Software, Cultural Nuance', 'BSc Literature/Translation Studies', 'Rp 8 Million - Rp 20 Million+', 'High', '2026-01-04 14:04:58', NULL),
(30, 'Game Artist', 'Seni', 'Creating the visual elements of video games, including characters and worlds.', '3D Modeling, Digital Illustration, Animation', 'BSc Game Design/Visual Communication', 'Rp 10 Million - Rp 30 Million+', 'High', '2026-01-04 14:04:58', NULL),
(31, 'Architect', 'Seni', 'Designing buildings and structures that are functional, safe, and aesthetic.', 'AutoCAD, SketchUp, Physics, Design Thinking', 'Bachelor of Architecture (S.Ars)', 'Rp 12 Million - Rp 40 Million+', 'High', '2026-01-04 14:04:58', NULL),
(32, 'Film Director', 'Seni', 'Leading the creative vision of a film, from script to screen.', 'Storytelling, Leadership, Cinematography Knowledge', 'BSc Film/Television Production', 'Project-based (Rp 15 Million - 100 Million+)', 'Medium', '2026-01-04 14:04:58', NULL),
(33, 'Fashion Designer', 'Seni', 'Creating original clothing, accessories, and footwear designs.', 'Sketching, Sewing, Trend Analysis, Adobe Illustrator', 'BSc Fashion Design', 'Rp 8 Million - Rp 30 Million+', 'High', '2026-01-04 14:04:58', NULL),
(34, 'Interior Designer', 'Seni', 'Planning and furnishing the interiors of private homes and commercial spaces.', 'Spatial Planning, Aesthetic Eye, Project Management', 'BSc Interior Design', 'Rp 9 Million - Rp 25 Million+', 'High', '2026-01-04 14:04:58', NULL);

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
(2, 'Tes', 'Male', 'Candra@Uii.c', '$2y$10$Jx0Oe1/mRAxIzGuF1o5fTe/m6uItAXPc/BNpfP/PXZ1r1ZMDF0bq6', 'High School', '11', '2026-01-04 14:12:58');

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
  `career_path_id` int(10) UNSIGNED DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_career_path` (`career_path_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_assessments`
--
ALTER TABLE `user_assessments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
ALTER TABLE `user_assessments`å
  ADD CONSTRAINT `user_assessments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_assessments_ibfk_2` FOREIGN KEY (`career_path_id`) REFERENCES `career_paths` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_progress_ibfk_2` FOREIGN KEY (`assessment_id`) REFERENCES `user_assessments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
