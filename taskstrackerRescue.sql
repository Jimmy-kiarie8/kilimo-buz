-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: taskstracker
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `audits`
--

DROP TABLE IF EXISTS `audits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `event` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint unsigned NOT NULL,
  `old_values` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `new_values` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(1023) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  KEY `audits_user_id_user_type_index` (`user_id`,`user_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audits`
--

LOCK TABLES `audits` WRITE;
/*!40000 ALTER TABLE `audits` DISABLE KEYS */;
INSERT INTO `audits` VALUES (1,'App\\User',1,'created','App\\User',2,'[]','{\"sirname\":\"Isanya\",\"firstname\":\"L\",\"middlename\":\"Hillary\",\"email\":\"judynyalisi@gmail.com\",\"username\":\"2010000036\",\"password\":\"$2y$10$HjTjkamoMDvmLWvtjL3pLO03YjDdD0T4gvUuUBJNVUiPBtuIZNErS\",\"verification_code\":\"4874I9946533\",\"role_id\":\"Admin\",\"org_id\":1,\"telephone\":\"254708236804\",\"email_verified_at\":\"2024-02-25 12:34:09\",\"user_type\":\"Internal\",\"created_by\":1,\"password_expiry\":\"2024-04-25\",\"id\":2}','http://localhost/tasktracker/public/Admin/Users/Create','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:123.0) Gecko/20100101 Firefox/123.0',NULL,'2024-02-25 09:34:09','2024-02-25 09:34:09'),(2,'App\\User',1,'updated','App\\User',1,'{\"token_2fa_expiry\":null,\"lastlogindate\":null}','{\"token_2fa_expiry\":\"2024-02-26T06:43:42.001909Z\",\"lastlogindate\":\"2024-02-26 06:43:42\"}','http://localhost/tasktracker/public/login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:123.0) Gecko/20100101 Firefox/123.0',NULL,'2024-02-26 03:43:42','2024-02-26 03:43:42'),(3,'App\\User',1,'updated','App\\User',1,'{\"token_2fa_expiry\":\"2024-02-26 06:43:42\",\"lastlogindate\":\"2024-02-26 06:43:42\"}','{\"token_2fa_expiry\":\"2024-02-26T09:16:19.586166Z\",\"lastlogindate\":\"2024-02-26 09:16:19\"}','http://localhost/tasktracker/public/login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:123.0) Gecko/20100101 Firefox/123.0',NULL,'2024-02-26 06:16:19','2024-02-26 06:16:19');
/*!40000 ALTER TABLE `audits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `department_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_status` enum('Active','Disable') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_department_name_unique` (`department_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'PS Office','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:37','2024-02-25 08:43:37',NULL),(2,'ICT','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:37','2024-02-25 08:43:37',NULL),(3,'Planning','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:37','2024-02-25 08:43:37',NULL),(4,'HR','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:37','2024-02-25 08:43:37',NULL),(5,'Supply Chain','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:37','2024-02-25 08:43:37',NULL),(6,'Legal Unit','Active',1,NULL,NULL,NULL,'2024-02-25 11:13:42','2024-02-25 11:13:42',NULL);
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entity_types`
--

DROP TABLE IF EXISTS `entity_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entity_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_status` enum('Active','Disabled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `entity_types_type_name_unique` (`type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity_types`
--

LOCK TABLES `entity_types` WRITE;
/*!40000 ALTER TABLE `entity_types` DISABLE KEYS */;
INSERT INTO `entity_types` VALUES (1,'Office Of The President','01','Active',NULL,1,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 10:33:52',NULL),(2,'Ministry','02','Active',NULL,1,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 10:35:12',NULL),(3,'State Department','03','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(4,'Cabinet','04','Active',NULL,1,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 10:32:28',NULL),(5,'National Assembly','05','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(6,'Senate','06','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(7,'State Agency','07','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(8,'Commision','08','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(9,'State Corporation','09','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(10,'Embassy','10','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(11,'Private Individual','11','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(12,'Judiciary','12','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(13,'Private Firms/Company','12','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(14,'NGO','14','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(15,'County Government','13','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(16,'County Assembly','14','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:11','2024-02-25 08:43:11',NULL),(17,'Internal Department','15','Active',1,NULL,NULL,NULL,'2024-02-25 08:58:47','2024-02-25 08:58:47',NULL),(18,'Internal Dirctorate','16','Active',1,NULL,NULL,NULL,'2024-02-25 08:59:04','2024-02-25 08:59:04',NULL);
/*!40000 ALTER TABLE `entity_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_types`
--

DROP TABLE IF EXISTS `file_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_status` enum('Active','Disable') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_types_type_name_unique` (`type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_types`
--

LOCK TABLES `file_types` WRITE;
/*!40000 ALTER TABLE `file_types` DISABLE KEYS */;
INSERT INTO `file_types` VALUES (1,'Action','Active',NULL,1,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 11:20:57',NULL),(2,'Circular','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL),(3,'Info','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL),(4,'FileAway','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL),(5,'Internal Memo','Active',NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL);
/*!40000 ALTER TABLE `file_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2020_12_07_220729_create_system_logs_table',1),(6,'2021_04_14_073038_create_profiles_table',1),(7,'2023_03_18_124510_create_audits_table',1),(8,'2024_02_07_154608_create_permission_tables',1),(9,'2024_02_22_134932_create_staffs_table',1),(10,'2024_02_22_141049_seed_directors',1),(11,'2024_02_22_145048_create_table_file_types',1),(12,'2024_02_22_150003_create_table_tasks',2),(13,'2024_02_22_151350_create_tabl_task_assignments',2),(14,'2024_02_22_191446_create_departments_table',2),(15,'2024_02_25_130712_adddepartmenttostaffstable',3),(16,'2024_02_25_144514_adddepartmenttostaffstable',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
INSERT INTO `model_has_permissions` VALUES (1,'App\\User',1),(3,'App\\User',1),(4,'App\\User',1),(5,'App\\User',1),(6,'App\\User',1);
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\User',1),(2,'App\\User',2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organizations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `org_type` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_abbr` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_physical_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_postal_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organizations_org_abbr_unique` (`org_abbr`),
  KEY `organizations_org_type_index` (`org_type`),
  CONSTRAINT `organizations_org_type_foreign` FOREIGN KEY (`org_type`) REFERENCES `entity_types` (`type_name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organizations`
--

LOCK TABLES `organizations` WRITE;
/*!40000 ALTER TABLE `organizations` DISABLE KEYS */;
INSERT INTO `organizations` VALUES (1,'State Department','Office of The President','OOP','hisanyad@gmail.com','01000,Harambe Avenue','100303','37664','Active',NULL,1,1,NULL,NULL,'2024-02-25 08:54:10','2024-02-25 10:54:40',NULL),(2,'Internal Department','Human Resource','HR','hisanyad@gmail.com','01000,Harambe Avenue','56335','37664','Active',NULL,1,NULL,NULL,NULL,'2024-02-25 09:01:06','2024-02-25 09:01:06',NULL),(3,'Office Of The President','Public Service,Performance and Delivery Management','MPSPDM','info@sdbnps.go.ke','01000,Harambe Avenue','100303','37664','Active',NULL,1,1,NULL,NULL,'2024-02-25 09:36:25','2024-02-25 10:54:52',NULL),(4,'State Department','State Department For Public Service','SDPS','info@sdbnps.go.ke','01000,Harambe Avenue','100303','37664','Active',NULL,1,NULL,NULL,NULL,'2024-02-25 11:22:06','2024-02-25 11:22:06',NULL),(5,'State Corporation','Kenya Revenue Authority','KRA','info@sdbnps.go.ke','Times Towers','1003030','1000100','Active',NULL,1,NULL,NULL,NULL,'2024-02-25 12:06:30','2024-02-25 12:06:30',NULL);
/*!40000 ALTER TABLE `organizations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `perm_category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'User Management','Add Users','web','2024-02-25 08:44:56','2024-02-25 08:44:56'),(2,'User Management','View System Users','web','2024-02-25 08:44:56','2024-02-25 08:44:56'),(3,'User Management','Delete Users','web','2024-02-25 08:44:56','2024-02-25 08:44:56'),(4,'User Management','Block Users','web','2024-02-25 08:44:56','2024-02-25 08:44:56'),(5,'User Management','Edit Users','web','2024-02-25 08:44:56','2024-02-25 08:44:56'),(6,'User Management','Reset User Passwords','web','2024-02-25 08:44:56','2024-02-25 08:44:56'),(7,'Dashboard Management','View Admin Dashboard','web','2024-02-25 08:44:56','2024-02-25 08:44:56');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `dob` date DEFAULT NULL,
  `county_name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcounty` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sublocation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `town` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_user_id_foreign` (`user_id`),
  KEY `profiles_county_name_index` (`county_name`),
  CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:44:57','2024-02-25 08:44:57',NULL);
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'SuperAdmin','web','2024-02-25 08:44:56','2024-02-25 08:44:56'),(2,'Admin','web','2024-02-25 08:44:56','2024-02-25 08:44:56');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_details`
--

DROP TABLE IF EXISTS `staff_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `staff_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_designation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_status` enum('Active','Disable') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `dep_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_details_staff_number_unique` (`staff_number`),
  KEY `staff_details_user_id_foreign` (`user_id`),
  KEY `staff_details_dep_name_index` (`dep_name`),
  CONSTRAINT `staff_details_dep_name_foreign` FOREIGN KEY (`dep_name`) REFERENCES `departments` (`department_name`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `staff_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_details`
--

LOCK TABLES `staff_details` WRITE;
/*!40000 ALTER TABLE `staff_details` DISABLE KEYS */;
INSERT INTO `staff_details` VALUES (1,'1987001964','MR. OKUMU LEONARD','254708236804','hisanyad@gmail.com','Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 09:03:22',NULL,NULL),(2,'1990016392','MRS. SHIROKO ELIANA NEKULU ONGULU',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(3,'1991022508','MR. ODONGO JAMES',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(4,'1991027605','MR. KIMANI BENSON K',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(5,'1991056866','MR. KATUMO JOSEPH MUTUKU',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(6,'1991090022','MR. NYALIECH RICHARD ORARO',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(7,'1992046474','MR. MWAREMA RICHARD OWEN',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(8,'1994029509','MR. KIBOI DAVID W',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(9,'1995012343','MR. RATEMO ALOYCE MARUBE',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(10,'1995028823','MRS. ONGWAE PAMELLA NYAMBOKE',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(11,'1995028920','MR. MUCHELE BENSON MAPESA',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(12,'1997011238','MR. MAINA JAMES KIUMU',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(13,'1997011254','MR. OKONDO KENNEDY NYABUTO',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(14,'2004001252','MR. MUTHAMIA LAWRENCE MWITI',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(15,'2005002918','DR OTIENO JACKSON ONGONG\'A','254708236804','erick@gmail.com','Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 10:16:57',NULL,'PS Office'),(16,'2005003621','MR. MUTHYOI ALEXANDER',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(17,'2005003639','MR. NDUATI RAPHAEL NJUGUNA',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(18,'2006067987','MR. NDUNGU CHARLES NDERITU',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(19,'2006068381','DR OTINGA HESBON NANGABO',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(20,'2008035457','MR. ONDIENG\'A PENUEL NYAANGA',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(21,'2008035685','MR. MUKINDIA MWIRIGI SAMWEL',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(22,'2008035863','MR. WAIGI JOHN KARANJA',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(23,'2008036055','MR. KAMAU JOSEPH MWANGI',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(24,'2010054784','MR. WAINAINA MUIGAI S',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(25,'2010055154','MRS. KIMONYE TERRY GATWIRI',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(26,'2010056223','MR. LEKARAM VICTOR SEMEREN',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(27,'2018108168','MR. EKUNOIT LORE AMBROSE',NULL,NULL,'Director - Planning','Active',NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:43:12','2024-02-25 08:43:12',NULL,NULL),(28,'202208849','Erick Mugo','254708236804','erick@gmail.com','Head ICT','Active',NULL,1,NULL,NULL,NULL,'2024-02-25 10:01:34','2024-02-25 10:17:14',NULL,'ICT'),(29,'4567646','Mary Ann','254708236804','hisanyad@gmail.comm','Deputy Director ICT','Active',NULL,1,NULL,NULL,NULL,'2024-02-25 10:03:06','2024-02-25 10:03:06',NULL,NULL);
/*!40000 ALTER TABLE `staff_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_logs`
--

DROP TABLE IF EXISTS `system_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `event_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `severity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `financial_year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quarter_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_logs_user_id_event_date_index` (`user_id`,`event_date`),
  KEY `system_logs_event_name_index` (`event_name`),
  KEY `system_logs_quarter_name_financial_year_index` (`quarter_name`,`financial_year`),
  CONSTRAINT `system_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_logs`
--

LOCK TABLES `system_logs` WRITE;
/*!40000 ALTER TABLE `system_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_assignments`
--

DROP TABLE IF EXISTS `task_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task_assignments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `task_id` bigint unsigned NOT NULL,
  `staff_id` bigint unsigned NOT NULL,
  `task_date` datetime DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `assignment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Ongoing',
  `task_completion_date` datetime DEFAULT NULL,
  `mins_Taken` int NOT NULL DEFAULT '0',
  `time_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignment_closing_remarks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_assignments_task_id_foreign` (`task_id`),
  KEY `task_assignments_staff_id_foreign` (`staff_id`),
  CONSTRAINT `task_assignments_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff_details` (`id`),
  CONSTRAINT `task_assignments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_assignments`
--

LOCK TABLES `task_assignments` WRITE;
/*!40000 ALTER TABLE `task_assignments` DISABLE KEYS */;
INSERT INTO `task_assignments` VALUES (1,1,3,'2024-02-01 00:00:00','2024-02-25','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 09:02:27','2024-02-25 09:02:27',NULL),(2,1,4,'2024-02-01 00:00:00','2024-02-25','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 09:02:27','2024-02-25 09:02:27',NULL),(3,2,2,'2024-02-01 00:00:00','2024-03-28','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 09:37:14','2024-02-25 09:37:14',NULL),(4,2,5,'2024-02-01 00:00:00','2024-03-28','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 09:37:14','2024-02-25 09:37:14',NULL),(5,3,28,'2024-02-01 00:00:00','2024-02-29','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 10:19:21','2024-02-25 10:19:21',NULL),(6,4,28,'2024-02-01 00:00:00','2024-02-29','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 11:14:57','2024-02-25 11:14:57',NULL),(7,4,29,'2024-02-01 00:00:00','2024-02-29','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 11:14:57','2024-02-25 11:14:57',NULL),(8,5,2,'2024-02-01 00:00:00','2024-02-29','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 11:24:02','2024-02-25 11:24:02',NULL),(9,5,10,'2024-02-01 00:00:00','2024-02-29','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 11:24:02','2024-02-25 11:24:02',NULL),(10,5,12,'2024-02-01 00:00:00','2024-02-29','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 11:24:02','2024-02-25 11:24:02',NULL),(11,6,1,'2024-02-01 00:00:00','2024-02-28','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 11:51:21','2024-02-25 11:51:21',NULL),(12,6,2,'2024-02-01 00:00:00','2024-02-28','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 11:51:21','2024-02-25 11:51:21',NULL),(13,7,25,'2024-02-01 00:00:00','2024-03-29','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 11:56:52','2024-02-25 11:56:52',NULL),(14,7,26,'2024-02-01 00:00:00','2024-03-29','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 11:56:52','2024-02-25 11:56:52',NULL),(15,7,27,'2024-02-01 00:00:00','2024-03-29','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 11:56:52','2024-02-25 11:56:52',NULL),(16,7,28,'2024-02-01 00:00:00','2024-03-29','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 11:56:52','2024-02-25 11:56:52',NULL),(17,8,1,'2024-02-21 00:00:00','2024-03-06','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 12:07:25','2024-02-25 12:07:25',NULL),(18,8,2,'2024-02-21 00:00:00','2024-03-06','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 12:07:25','2024-02-25 12:07:25',NULL),(19,9,1,'2024-02-21 00:00:00','2024-02-25','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 12:13:38','2024-02-25 12:13:38',NULL),(20,9,5,'2024-02-21 00:00:00','2024-02-25','Ongoing',NULL,0,NULL,NULL,1,NULL,NULL,NULL,'2024-02-25 12:13:38','2024-02-25 12:13:38',NULL);
/*!40000 ALTER TABLE `task_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `task_ticket_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_priority` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_type` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_ref` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'State Department For Economic Planning',
  `task_status` enum('Active','Closed','Completed','OverDue','Due Today') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `task_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `task_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `closing_date` datetime DEFAULT NULL,
  `financial_year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quarter_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mins_Taken` int NOT NULL DEFAULT '0',
  `task_participant_names` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `closing_remarks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `task_counter` bigint NOT NULL DEFAULT '1',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_task_type_index` (`task_type`),
  CONSTRAINT `fk_task_category` FOREIGN KEY (`task_type`) REFERENCES `file_types` (`type_name`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,'TK-0001','High','Internal Memo','MCS/0001/26/20224','Staff Medical Cover Renewal','HR -Director','Human Resource','Active','Test Test','2024-02-01','2024-02-25',NULL,NULL,NULL,NULL,0,' MR. ODONGO JAMES, MR. KIMANI BENSON K',NULL,1,1,NULL,NULL,NULL,'2024-02-25 09:02:27','2024-02-25 09:02:27',NULL),(2,'TK-0002','High','Action','MCS/0031/26/20224','Staff Appraisals','CS Moses Kuria','Public Service,Performance and Delivery Management','Active','djhdjhjhdhdhjhd','2024-02-01','2024-03-28',NULL,NULL,NULL,NULL,0,' MRS. SHIROKO ELIANA NEKULU ONGULU, MR. KATUMO JOSEPH MUTUKU',NULL,2,1,NULL,NULL,NULL,'2024-02-25 09:37:14','2024-02-25 09:37:14',NULL),(3,'TK-0003','High','Action','MCS/0001/30/20224','Perimeter Firewal','PS James Muhati','Human Resource','Active','jhdhjhff','2024-02-01','2024-02-29',NULL,NULL,NULL,NULL,0,' Erick Mugo',NULL,3,1,NULL,NULL,NULL,'2024-02-25 10:19:21','2024-02-25 10:19:21',NULL),(4,'TK-0004','High','Action','MCS/0036/26/20224','Framework Agreement','PS James Muhati','Public Service,Performance and Delivery Management','Active','dhdgddghdgd','2024-02-01','2024-02-29',NULL,NULL,NULL,NULL,0,' Erick Mugo, Mary Ann',NULL,4,1,NULL,NULL,NULL,'2024-02-25 11:14:57','2024-02-25 11:14:57',NULL),(5,'TK-0005','High','Circular','MCS/0001/050/20224','Staff Insurance Cover','SA,Mwachala','State Department For Public Service','Completed','Take necessary Action','2024-02-01','2024-02-29','2024-02-25 14:48:30',NULL,NULL,NULL,0,' MRS. SHIROKO ELIANA NEKULU ONGULU, MRS. ONGWAE PAMELLA NYAMBOKE, MR. MAINA JAMES KIUMU','Closed with some remarks',5,1,1,NULL,NULL,'2024-02-25 11:24:02','2024-02-25 11:48:30',NULL),(6,'TK-0006','High','Action','MCS/0001/056/20224','ICT Security Policy','PS','State Department For Public Service','Active','Review and Update ICT security policy accordingly','2024-02-01','2024-02-28','2024-02-25 15:30:12','2023-2024','Q3','202402',0,' MR. OKUMU LEONARD, MRS. SHIROKO ELIANA NEKULU ONGULU',NULL,6,1,1,NULL,NULL,'2024-02-25 11:51:21','2024-02-25 12:30:12',NULL),(7,'TK-0007','High','Internal Memo','MCS/0001/106/20224','Staff Attendance Biometric','HR -Director','State Department For Public Service','Active','Ensure staffs clock in using the new  bio-metric devices','2024-02-01','2024-03-29',NULL,'2023-2024','Q3','2024,Feb',0,' MRS. KIMONYE TERRY GATWIRI, MR. LEKARAM VICTOR SEMEREN, MR. EKUNOIT LORE AMBROSE, Erick Mugo',NULL,7,1,NULL,NULL,NULL,'2024-02-25 11:56:52','2024-02-25 11:56:52',NULL),(8,'TK-0008','Low','Action','MCS/0012/050/20224','New Payee Tax Slabs','Comm Were','Kenya Revenue Authority','Active','Review and advice','2024-02-21','2024-03-06','2024-02-25 15:29:59','2023-2024','Q3','2024,Feb',0,' MR. OKUMU LEONARD, MRS. SHIROKO ELIANA NEKULU ONGULU',NULL,8,1,1,NULL,NULL,'2024-02-25 12:07:25','2024-02-25 12:29:59',NULL),(9,'TK-0009','Medium','Action','MCS/0045/050/20224','Overdue Reminders','Test Author','State Department For Public Service','Active','hdddhd','2024-02-21','2024-02-25',NULL,'2023-2024','Q3','2024,Feb',0,' MR. OKUMU LEONARD, MR. KATUMO JOSEPH MUTUKU',NULL,9,1,NULL,NULL,NULL,'2024-02-25 12:13:38','2024-02-25 12:13:38',NULL);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sirname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middlename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_type` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_id` bigint unsigned NOT NULL,
  `branch_id` int DEFAULT NULL,
  `role_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `verification_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `token_2fa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_2fa_expiry` datetime DEFAULT NULL,
  `user_status` enum('Active','Blocked') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `user_type` enum('Internal','External') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Internal',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `lastlogindate` datetime DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `password_expiry` date DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_org_type_foreign` (`org_type`),
  CONSTRAINT `users_org_type_foreign` FOREIGN KEY (`org_type`) REFERENCES `entity_types` (`type_name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'System',NULL,'Admin','admin@sdep.com','20220328713','254708236804',NULL,NULL,1,NULL,'SuperAdmin',NULL,'123456905','2024-02-25 08:44:57',NULL,'2024-02-26 09:16:19','Active','Internal','$2y$10$/T27ShMG5OwP/Dw.29IwueJminPirzA81m7dAwiL.JDqtoNXKp6TO',NULL,NULL,'2024-02-26 09:16:19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-02-25 08:44:57','2024-02-26 06:16:19'),(2,'Isanya','Hillary','L','judynyalisi@gmail.com','2010000036','254708236804',NULL,NULL,1,NULL,'Admin','2024-02-25 09:34:09','4874I9946533',NULL,NULL,NULL,'Active','Internal','$2y$10$HjTjkamoMDvmLWvtjL3pLO03YjDdD0T4gvUuUBJNVUiPBtuIZNErS',NULL,NULL,NULL,1,NULL,'2024-04-25',NULL,NULL,NULL,NULL,'2024-02-25 09:34:09','2024-02-25 09:34:09');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-16 15:21:51
