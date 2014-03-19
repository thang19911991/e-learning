-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 07, 2014 at 09:35 AM
-- Server version: 5.5.35
-- PHP Version: 5.4.6-1ubuntu1.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `e_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `verify_code_id` int(11) DEFAULT NULL,
  `verify_code_answer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `primary_verify_code_answer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `course_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `teacher_id`, `course_name`, `description`, `created_date`) VALUES
(19, 2, 'Course 1', 'sss', '2014-03-06 14:17:55'),
(20, 2, 'aaaa', 'Aaaaa', '2014-03-06 14:18:02'),
(21, 1, 'course 10', 'sssss', '2014-03-06 14:35:56'),
(25, 1, 'course 10', 'sssss', '2014-03-06 14:35:56'),
(28, 1, 'ssssss', 'sdadadadad', '2014-03-06 14:35:56'),
(33, 1, 'cac', 'asdad', '2014-03-06 14:52:42'),
(34, 1, 'aaaaaa', 'aaaaaasss', '2014-03-06 14:53:41'),
(35, 1, 'aaaaaa', 'aaaaaasss', '2014-03-06 14:54:27'),
(36, 2, 'Toi yeu em', 'Toan lop 1', '2014-03-06 15:16:52'),
(37, 2, 'Toi yeu em', 'Toan lop 1', '2014-03-06 15:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `courses_tags`
--

CREATE TABLE IF NOT EXISTS `courses_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

--
-- Dumping data for table `courses_tags`
--

INSERT INTO `courses_tags` (`id`, `course_id`, `tag_id`) VALUES
(19, 19, 19),
(20, 20, 20),
(21, 21, 21),
(22, 25, NULL),
(23, 25, 22),
(24, 28, 23),
(25, 33, 23),
(26, 34, 24),
(27, 35, 24),
(28, 36, 25),
(29, 36, 26),
(30, 37, 25),
(31, 37, 26),
(32, 37, 27);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `path` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `course_id`, `type`, `upload_date`, `path`, `status`, `name`) VALUES
(19, 19, NULL, '2014-03-07 02:30:58', '/e-learning/files/documents/doc_2_1394035551.pdf', NULL, NULL),
(20, 20, NULL, '2014-03-07 02:30:58', '/e-learning/files/documents/doc_2_1394036309.pdf', NULL, 'aaaa'),
(21, 21, NULL, '2014-03-07 02:30:58', '/e-learning/files/documents/doc_2_1394115769.pdf', NULL, 'asdad'),
(22, 25, NULL, '2014-03-07 02:30:58', '/e-learning/files/documents/doc_2_1394115942.pdf', NULL, 'asdad'),
(23, 28, NULL, '2014-03-07 02:30:58', '/e-learning/files/documents/doc_2_1394116071.pdf', NULL, 'aaaaa'),
(24, 33, NULL, '2014-03-07 02:30:58', '/e-learning/files/documents/doc_2_1394117561.pdf', NULL, 'adad'),
(25, 34, NULL, '2014-03-07 02:30:58', '/e-learning/files/documents/doc_2_1394117621.pdf', NULL, 'sdaa11'),
(26, 35, NULL, '2014-03-07 02:30:58', '/e-learning/files/documents/doc_2_1394117667.pdf', NULL, 'sdaa11'),
(27, 36, NULL, '2014-03-07 02:30:58', '/e-learning/files/documents/doc_2_1394119012.pdf', NULL, 'Chap 1'),
(28, 37, NULL, '2014-03-07 02:30:58', '/e-learning/files/documents/doc_2_1394119055.pdf', NULL, 'Chap 1');

-- --------------------------------------------------------

--
-- Table structure for table `ips`
--

CREATE TABLE IF NOT EXISTS `ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `IP` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `additional_info` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `students_courses_ban`
--

CREATE TABLE IF NOT EXISTS `students_courses_ban` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `reason` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `students_courses_learn`
--

CREATE TABLE IF NOT EXISTS `students_courses_learn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `buy_date` date DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `students_courses_report`
--

CREATE TABLE IF NOT EXISTS `students_courses_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `content` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `students_course_like`
--

CREATE TABLE IF NOT EXISTS `students_course_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `students_documents_report`
--

CREATE TABLE IF NOT EXISTS `students_documents_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL,
  `content` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `students_tests`
--

CREATE TABLE IF NOT EXISTS `students_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `system_params`
--

CREATE TABLE IF NOT EXISTS `system_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag_name`) VALUES
(19, 'Toan'),
(20, 'aaaa'),
(21, 'ssss'),
(22, 'ssss'),
(23, 'adad'),
(24, '11111'),
(25, 'Toan dai cuong'),
(26, 'Ly dai cuong'),
(27, 'Ly dai cuong');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `verify_code` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verify_code_answer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `primary_verify_code_answer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_session_ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `additional_info` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `verify_code`, `verify_code_answer`, `primary_verify_code_answer`, `last_session_ip`, `additional_info`) VALUES
(2, 1, 'where did you sleep last night', 'motel', NULL, NULL, NULL),
(3, 2, 'Do u know me', 'Yep', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `path` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `course_id`, `upload_date`, `path`, `status`, `name`) VALUES
(1, 19, '2014-03-07 02:31:52', '/e-learning/files/tests/test_2_1394035551.tsv', NULL, NULL),
(2, 20, '2014-03-07 02:31:52', '/e-learning/files/tests/test_2_1394036309.tsv', NULL, 'ssss'),
(3, 21, '2014-03-07 02:31:52', '/e-learning/files/tests/test_2_1394115769.tsv', NULL, 'aa'),
(4, 25, '2014-03-07 02:31:52', '/e-learning/files/tests/test_2_1394115942.tsv', NULL, 'aa'),
(5, 28, '2014-03-07 02:31:52', '/e-learning/files/tests/test_2_1394116071.tsv', NULL, 'aaa'),
(6, 33, '2014-03-07 02:31:52', '/e-learning/files/tests/test_2_1394117561.tsv', NULL, 'aaa'),
(7, 34, '2014-03-07 02:31:52', '/e-learning/files/tests/test_2_1394117621.tsv', NULL, 'a'),
(8, 35, '2014-03-07 02:31:52', '/e-learning/files/tests/test_2_1394117667.tsv', NULL, 'a'),
(9, 36, '2014-03-07 02:31:52', '/e-learning/files/tests/test_2_1394119012.tsv', NULL, 'Test 1'),
(10, 37, '2014-03-07 02:31:52', '/e-learning/files/tests/test_2_1394119055.tsv', NULL, 'Test 1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credit_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_status` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `primary_password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `role` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_status` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_active_time` datetime DEFAULT NULL,
  `lock_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `username`, `address`, `full_name`, `phone`, `credit_number`, `login_status`, `primary_password`, `birthday`, `role`, `active_status`, `email`, `profile_img`, `last_active_time`, `lock_time`) VALUES
(1, '24f66ec63b0a18a386cc7dff791550c74948113a', 'duc', 'ss@aa.aa', 'Duc Dep trai', '12345678', '123-345-678', NULL, '123456', '2001-03-05', NULL, '1', 'duc@duc.duc', NULL, NULL, NULL),
(2, '24f66ec63b0a18a386cc7dff791550c74948113a', 'duc2', 'a@a.a', 'duc2 lh', '111111111', NULL, NULL, '123456', '1996-03-05', NULL, '1', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_course_comment`
--

CREATE TABLE IF NOT EXISTS `users_course_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `content` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `verify_codes`
--

CREATE TABLE IF NOT EXISTS `verify_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `verify_codes`
--

INSERT INTO `verify_codes` (`id`, `question`) VALUES
(1, '1+1=');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
