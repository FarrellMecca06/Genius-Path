-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 04, 2026 at 09:38 AM
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
-- Database: `GeniusPath`
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
(1, 'Software Engineer', 'Saintek', 'Building and maintaining software systems, applications, and networks.', 'Problem Solving, Logic, Programming Languages (Python, JS)', 'BSc Computer Science/Informatics', 'Rp 10 Million - Rp 30 Million+', 'High'),
(2, 'Data Scientist', 'Saintek', 'Analyzing large datasets to find patterns and make predictions.', 'Mathematics, Statistics, Machine Learning, Python', 'BSc/MSc Statistics/Data Science', 'Rp 12 Million - Rp 40 Million+', 'High'),
(3, 'Marketing Manager', 'Soshum', 'Planning and executing marketing strategies to increase sales.', 'Communication, Strategy, Market Analysis', 'BSc Management/Business', 'Rp 8 Million - Rp 25 Million', 'Medium'),
(5, 'Medical Doctor', 'Saintek', 'Diagnosing and treating human illnesses and injuries.', 'Biology, Attention to Detail, Ethics, Communication', 'Medical Degree + Specialization', 'Rp 15 Million - Rp 50 Million+', 'High'),
(6, 'Social Worker', 'Soshum', 'Helping individuals and communities overcome problems and improve quality of life.', 'Empathy, Counselling, Case Management', 'BSc Social Welfare', 'Rp 5 Million - Rp 12 Million', 'Medium'),
(7, 'Software Engineer', 'Saintek', 'Building and maintaining software systems, applications, and networks.', 'Problem Solving, Logic, Programming Languages (Python, JS)', 'BSc Computer Science/Informatics', 'Rp 10 Million - Rp 30 Million+', 'High'),
(8, 'Data Scientist', 'Saintek', 'Analyzing large datasets to find patterns and make predictions.', 'Mathematics, Statistics, Machine Learning, Python', 'BSc/MSc Statistics/Data Science', 'Rp 12 Million - Rp 40 Million+', 'High'),
(9, 'Marketing Manager', 'Soshum', 'Planning and executing marketing strategies to increase sales.', 'Communication, Strategy, Market Analysis', 'BSc Management/Business', 'Rp 8 Million - Rp 25 Million', 'Medium'),
(10, 'Economist', 'Soshum', 'Analyzing economic trends, researching data, and developing forecasts.', 'Econometrics, Data Analysis, Critical Thinking', 'BSc/MSc Economics', 'Rp 10 Million - Rp 35 Million', 'High'),
(11, 'Professional Translator', 'Bahasa', 'Converting documents or conversations from one language to another with high accuracy.', 'Foreign Language Fluency (Verbal & Written), Cultural Understanding, Attention to Detail.', 'BSc Literature/Foreign Language Studies', 'Rp 7 Million - Rp 15 Million', 'Medium'),
(12, 'Content Writer & Journalist', 'Bahasa', 'Creating compelling and informative articles, news, or digital content for various media.', 'Strong Writing Skills, Research, Interviewing, Journalism Ethics.', 'BSc Communication Science/Literature', 'Rp 5 Million - Rp 12 Million', 'High'),
(13, 'UI/UX Designer', 'Seni', 'Designing intuitive and engaging user interfaces and experiences for digital products.', 'Graphic Design, Empathic Thinking, Prototyping (Figma), Visual Aesthetics.', 'BSc Visual Communication Design', 'Rp 7 Million - Rp 20 Million', 'High'),
(14, 'Curator & Gallery Manager', 'Seni', 'Managing art collections, designing exhibitions, and interpreting works for the public.', 'Art History, Curatorial Studies, Project Management, Public Speaking.', 'BSc/MSc Fine Arts/Art History', 'Rp 6 Million - Rp 14 Million', 'Medium'),
(15, 'Cyber Security Analyst', 'Saintek', 'Protecting computer networks and systems from hackers and cyber attacks.', 'Networking, Ethical Hacking, Python, Security Protocols', 'BSc Computer Science/IT', 'Rp 15 Million - Rp 40 Million+', 'High'),
(16, 'Robotics Engineer', 'Saintek', 'Designing and building robots for manufacturing, medicine, or exploration.', 'Mechanical Engineering, Programming (C++), AI, Electronics', 'BSc/MSc Robotics or Electrical Engineering', 'Rp 12 Million - Rp 35 Million+', 'High'),
(17, 'Data Engineer', 'Saintek', 'Building systems that collect, manage, and convert raw data into usable information.', 'SQL, Big Data (Hadoop), Cloud Computing (AWS/GCP)', 'BSc Computer Science/Software Engineering', 'Rp 15 Million - Rp 45 Million+', 'High'),
(18, 'Environmental Scientist', 'Saintek', 'Researching environmental issues and developing solutions to protect the planet.', 'Data Analysis, Lab Research, Policy Knowledge', 'BSc Environmental Science/Biology', 'Rp 8 Million - Rp 20 Million+', 'Medium'),
(19, 'AI Research Scientist', 'Saintek', 'Developing new AI models and algorithms to advance the field of machine learning.', 'Advanced Math, Deep Learning, Python/PyTorch', 'MSc/PhD Artificial Intelligence/Computer Science', 'Rp 20 Million - Rp 60 Million+', 'High'),
(20, 'Clinical Psychologist', 'Soshum', 'Diagnosing and treating mental, emotional, and behavioral disorders.', 'Empathy, Active Listening, Psychological Assessment', 'BSc Psychology + Professional Degree', 'Rp 10 Million - Rp 30 Million+', 'High'),
(21, 'Financial Analyst', 'Soshum', 'Providing guidance to businesses and individuals making investment decisions.', 'Accounting, Data Analysis, Economic Knowledge', 'BSc Finance/Economics', 'Rp 12 Million - Rp 35 Million+', 'High'),
(22, 'Corporate Lawyer', 'Soshum', 'Advising businesses on their legal rights, responsibilities, and duties.', 'Legal Writing, Negotiation, Critical Thinking', 'Bachelor of Law (SH) + Bar Certification', 'Rp 15 Million - Rp 50 Million+', 'High'),
(23, 'Digital Marketing Specialist', 'Soshum', 'Creating and managing online campaigns to promote brands and products.', 'SEO/SEM, Copywriting, Social Media Analytics', 'BSc Marketing/Communication', 'Rp 8 Million - Rp 25 Million+', 'High'),
(24, 'Sociologist', 'Soshum', 'Studying society and social behavior through research and data analysis.', 'Qualitative Research, Statistics, Analytical Thinking', 'BSc/MSc Sociology', 'Rp 7 Million - Rp 18 Million+', 'Medium'),
(25, 'International Journalist', 'Bahasa', 'Reporting news from around the world for TV, print, or digital media.', 'News Writing, Foreign Languages, Interviewing', 'BSc Journalism/Communication', 'Rp 8 Million - Rp 25 Million+', 'Medium'),
(26, 'Copywriter', 'Bahasa', 'Writing persuasive text for advertisements and marketing materials.', 'Creative Writing, Marketing, Brand Voice Analysis', 'BSc Communication/English/Indonesian Literature', 'Rp 7 Million - Rp 20 Million+', 'High'),
(27, 'Diplomatic Officer', 'Bahasa', 'Representing the country interests in international relations and negotiations.', 'Negotiation, Multiple Languages, Political Science', 'BSc International Relations/Law', 'Rp 15 Million - Rp 40 Million+', 'High'),
(28, 'Technical Writer', 'Bahasa', 'Creating complex manuals and documents for technical products or software.', 'Simplifying Complex Info, Tech Literacy, Grammar', 'BSc English/IT/Communication', 'Rp 10 Million - Rp 25 Million+', 'High'),
(29, 'Audiovisual Translator', 'Bahasa', 'Translating and adapting scripts for movies, TV shows, and video games.', 'Translation, Subtitling Software, Cultural Nuance', 'BSc Literature/Translation Studies', 'Rp 8 Million - Rp 20 Million+', 'High'),
(30, 'Game Artist', 'Seni', 'Creating the visual elements of video games, including characters and worlds.', '3D Modeling, Digital Illustration, Animation', 'BSc Game Design/Visual Communication', 'Rp 10 Million - Rp 30 Million+', 'High'),
(31, 'Architect', 'Seni', 'Designing buildings and structures that are functional, safe, and aesthetic.', 'AutoCAD, SketchUp, Physics, Design Thinking', 'Bachelor of Architecture (S.Ars)', 'Rp 12 Million - Rp 40 Million+', 'High'),
(32, 'Film Director', 'Seni', 'Leading the creative vision of a film, from script to screen.', 'Storytelling, Leadership, Cinematography Knowledge', 'BSc Film/Television Production', 'Project-based (Rp 15 Million - 100 Million+)', 'Medium'),
(33, 'Fashion Designer', 'Seni', 'Creating original clothing, accessories, and footwear designs.', 'Sketching, Sewing, Trend Analysis, Adobe Illustrator', 'BSc Fashion Design', 'Rp 8 Million - Rp 30 Million+', 'High'),
(34, 'Interior Designer', 'Seni', 'Planning and furnishing the interiors of private homes and commercial spaces.', 'Spatial Planning, Aesthetic Eye, Project Management', 'BSc Interior Design', 'Rp 9 Million - Rp 25 Million+', 'High');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `career_paths`
--
ALTER TABLE `career_paths`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `career_paths`
--
ALTER TABLE `career_paths`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
