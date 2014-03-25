-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: e_learning
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `verify_code_id` int(11) DEFAULT NULL,
  `verify_code_answer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `primary_verify_code_answer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,15,1,'thang','thang');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bans`
--

DROP TABLE IF EXISTS `bans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `reason` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bans`
--

LOCK TABLES `bans` WRITE;
/*!40000 ALTER TABLE `bans` DISABLE KEYS */;
INSERT INTO `bans` VALUES (1,0,1,'sssss'),(2,2,1,'sssss'),(3,3,1,'sssss');
/*!40000 ALTER TABLE `bans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `course_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (3,'may la thang nao','2014-03-09 08:00:15',25,1),(4,'tao la thang','2014-03-09 08:00:15',25,3);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `course_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (19,2,'Course 1','sss','2014-03-06 14:17:55','active'),(20,2,'aaaa','Aaaaa','2014-03-06 14:18:02','deactive'),(21,1,'course 10','sssss','2014-03-06 14:35:56','active'),(28,1,'ssssss','sdadadadad','2014-03-06 14:35:56','active'),(34,1,'aaaaaa','aaaaaasss','2014-03-06 14:53:41','active'),(35,1,'toan thang','chao ca nha, minh la thang, rat han hanh duoc lam quen :))','2014-03-06 14:54:27','active'),(36,2,'Toi yeu em','Toan lop 1','2014-03-06 15:16:52','active'),(37,2,'Toi yeu em','Toan lop 1','2014-03-06 15:17:35','active');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses_tags`
--

DROP TABLE IF EXISTS `courses_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses_tags`
--

LOCK TABLES `courses_tags` WRITE;
/*!40000 ALTER TABLE `courses_tags` DISABLE KEYS */;
INSERT INTO `courses_tags` VALUES (63,35,62),(92,34,68),(93,34,NULL),(95,35,NULL),(96,35,91);
/*!40000 ALTER TABLE `courses_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `path` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (26,35,NULL,'2014-03-07 02:30:58','/e-learning/files/documents/doc_2_1394117667.pdf',NULL,'sdaa11');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ips`
--

DROP TABLE IF EXISTS `ips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `IP` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ips`
--

LOCK TABLES `ips` WRITE;
/*!40000 ALTER TABLE `ips` DISABLE KEYS */;
INSERT INTO `ips` VALUES (1,15,'127.0.0.1');
/*!40000 ALTER TABLE `ips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (1,21,1),(2,21,2),(3,28,1);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `additional_info` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,12,'aaaaaaaaaaaaaaaaaaaaaa');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students_course_like`
--

DROP TABLE IF EXISTS `students_course_like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students_course_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students_course_like`
--

LOCK TABLES `students_course_like` WRITE;
/*!40000 ALTER TABLE `students_course_like` DISABLE KEYS */;
/*!40000 ALTER TABLE `students_course_like` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students_courses_ban`
--

DROP TABLE IF EXISTS `students_courses_ban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students_courses_ban` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `reason` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students_courses_ban`
--

LOCK TABLES `students_courses_ban` WRITE;
/*!40000 ALTER TABLE `students_courses_ban` DISABLE KEYS */;
/*!40000 ALTER TABLE `students_courses_ban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students_courses_learn`
--

DROP TABLE IF EXISTS `students_courses_learn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students_courses_learn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `buy_date` date DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students_courses_learn`
--

LOCK TABLES `students_courses_learn` WRITE;
/*!40000 ALTER TABLE `students_courses_learn` DISABLE KEYS */;
INSERT INTO `students_courses_learn` VALUES (1,1,21,'2014-03-24','2014-03-17','learning'),(2,1,20,'2014-03-24','2014-03-17','learning');
/*!40000 ALTER TABLE `students_courses_learn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students_courses_report`
--

DROP TABLE IF EXISTS `students_courses_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students_courses_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `content` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students_courses_report`
--

LOCK TABLES `students_courses_report` WRITE;
/*!40000 ALTER TABLE `students_courses_report` DISABLE KEYS */;
/*!40000 ALTER TABLE `students_courses_report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students_documents_report`
--

DROP TABLE IF EXISTS `students_documents_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students_documents_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL,
  `content` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students_documents_report`
--

LOCK TABLES `students_documents_report` WRITE;
/*!40000 ALTER TABLE `students_documents_report` DISABLE KEYS */;
/*!40000 ALTER TABLE `students_documents_report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students_tests`
--

DROP TABLE IF EXISTS `students_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students_tests`
--

LOCK TABLES `students_tests` WRITE;
/*!40000 ALTER TABLE `students_tests` DISABLE KEYS */;
/*!40000 ALTER TABLE `students_tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_params`
--

DROP TABLE IF EXISTS `system_params`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_params`
--

LOCK TABLES `system_params` WRITE;
/*!40000 ALTER TABLE `system_params` DISABLE KEYS */;
INSERT INTO `system_params` VALUES (1,'LOCK_TIME','5'),(2,'WRONG_PASS_LIMIT','5'),(3,'MAX_LENGTH_INPUT','256'),(4,'MIN_LENGTH_PASSWORD','256'),(5,'MAX_AVATAR_SIZE','25'),(6,'MAX_COURSE_FILE_SIZE','25'),(7,'KOMA_COST','20000'),(8,'SESSION_TIMEOUT','60'),(9,'TEACHER_PAY','0.4'),(10,'KOMA_TIMEOUT','7'),(11,'TEXT_SIZE','5000000'),(12,'IMAGE_SIZE','5000000'),(13,'VIDEO_SIZE','200000000'),(14,'AUDIO_SIZE','50000000'),(15,'TEST_SIZE','2000000');
/*!40000 ALTER TABLE `system_params` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_name` (`tag_name`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (90,'h'),(33,'sssss'),(91,'tag1'),(92,'tag2'),(78,'test thu cai xem nao'),(68,'thang'),(62,'価格1');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `verify_code` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verify_code_answer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `primary_verify_code_answer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_session_ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `additional_info` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (1,1,'con vat yeu thich cua ban?','Cat','Cat','127.0.0.1',NULL),(2,3,'hello ca nha','thang','thang','127.0.0.1',NULL),(3,4,'con vat yeu thich cua ban?','aaaa','aaaa','127.0.0.1','dddd'),(4,5,'con vat yeu thich cua ban?','duck','duck','127.0.0.1','aaaaaaaa'),(10,11,'hello ca nha?','hello cai cut','hello cai cut','127.0.0.1','ngo van thang'),(11,12,'dddd','fffff','fffff','127.0.0.1','ddddd'),(12,13,'ban trai la ai?','Thang','Thang','127.0.0.1','toi la co giao hien lanh'),(13,14,'toi la ai','toan','toan','127.0.0.1','toi la ngo van toan\r\nque o hai phong');
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `path` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tests`
--

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
INSERT INTO `tests` VALUES (1,19,'2014-03-07 02:31:52','/e-learning/files/tests/test_2_1394035551.tsv',NULL,'ssss'),(2,20,'2014-03-07 02:31:52','/e-learning/files/tests/test_2_1394036309.tsv',NULL,'ssss'),(5,28,'2014-03-07 02:31:52','/e-learning/files/tests/test_2_1394116071.tsv',NULL,'aaa2'),(7,35,'2014-03-07 02:31:52','/e-learning/files/tests/test_2_1394117621.tsv',NULL,'a'),(8,35,'2014-03-07 02:31:52','/e-learning/files/tests/test_2_1394117667.tsv',NULL,'a3');
/*!40000 ALTER TABLE `tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credit_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_status` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'có 3 loại là on off lock',
  `primary_password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `role` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_status` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'có các trạng thái: banned, actived, inactive',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_active_time` datetime DEFAULT NULL,
  `lock_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'e40d5e3a329ed01c7eb2744c4104417572a6009b','thang','Tiền Phong - Vĩnh Bảo - Hải Phòng','Ngô Văn Thắng','01656070501','12345678-1111-2222-3333-4444','on','24f66ec63b0a18a386cc7dff791550c74948113a','1991-07-10','teacher','actived','thangnvbkhn@gmail.com','/files/Avatar/259.jpg','2014-03-06 15:46:05',NULL),(3,'ac325e14c566a982d45b46a5025eb26e0586a541','thuy','Ha Dong','Le Thanh Thuy','12345678','12345678-1111-2222-3333-4444','on','24f66ec63b0a18a386cc7dff791550c74948113a','1999-07-10','teacher','actived','thangnvbkhn@gmail.com','/files/Avatar/259.jpg','2014-03-06 15:46:05',NULL),(4,'bbc9bfa00c12c4c93e8c18f3e06b703b7e1d2b3e','thang1234','Vinh Bao Hai Phong','Nguyen Minh Thang','01656070501','12345678-1111-2222-3333-4444','off','24f66ec63b0a18a386cc7dff791550c74948113a','2014-03-06','teacher','actived','thangnvbkhn@gmail.com','/files/Avatar/259.jpg','2014-03-06 15:46:05',NULL),(5,'f84052c535816e0322053bb40e1a9fee9b06cbd6','thang12345','Vinh Bao Hai Phong','Nguyễn Minh Thắng','01656070501','12345678-1111-2222-3333-4444','off','24f66ec63b0a18a386cc7dff791550c74948113a','1990-07-10','teacher','actived','ngovanthang68@gmail.com','/files/Avatar/thang12345-splash.png','2014-03-06 15:50:25',NULL),(11,'b98f6bec32bb35b5fe42a66645d9c9ecdb03fe07','thang123','Vinh Bao Hai Phong','Nguyen Minh Thang','01656070501','12345678-1111-2222-3333-4444','off','b98f6bec32bb35b5fe42a66645d9c9ecdb03fe07','2014-03-08','teacher','inactive','thangnvbkhn@gmail.com','/img/Avatar/thang123-promote.jpg','2014-03-06 15:46:05',NULL),(12,'2f9bf97e83a6fe29ba37db3253c4c382eb782246','duc','Vĩnh Bảo Hải Phòng','asdf','01656070501','1111-222-3-4444444','off','2f9bf97e83a6fe29ba37db3253c4c382eb782246','2014-03-08','student','actived','thangnvbkhn@gmail.com','/img/Avatar/duc-icon_app.jpg','2014-03-06 15:46:05',NULL),(13,'f651be522a33dc71f65a01ee34a5dcaf14bab855','lethuy','Hà Đông - Hà Nội','Le Thanh Thuy','01658878541','12345678-1111-2222-3333-4444','off','f651be522a33dc71f65a01ee34a5dcaf14bab855','1993-07-16','teacher','inactive','thuyhnue.k62@gmail.com','/img/Avatar/lethuy-banner.jpg','2014-03-10 22:30:04',NULL),(14,'4a71ae19350300b83ed4638b674ccd37c7c954cc','toan','Tien Phong - Vinh Bao - Hai Phong','Ngo Van Toan','01656053267','12345678-1111-2222-3333-4444','off','4a71ae19350300b83ed4638b674ccd37c7c954cc','1991-07-10','teacher','inactive','toanhp@gmail.com','/img/Avatar/toan-257.jpg','2014-03-10 22:52:40',NULL),(15,'9dce4824b58e8830b62f4cd6145f6923d69f4a2f','admin','Ha Noi','Ngo Van Thang','01656070501','1234-5678','on','9dce4824b58e8830b62f4cd6145f6923d69f4a2f','2014-03-26','admin','actived','nghinv@gmail.com',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_course_comment`
--

DROP TABLE IF EXISTS `users_course_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_course_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `content` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_course_comment`
--

LOCK TABLES `users_course_comment` WRITE;
/*!40000 ALTER TABLE `users_course_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_course_comment` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-25 15:28:13
