-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: pos_master_db
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Super Admin','admin@taxbridge.pk','$2y$12$PfHLRFbUZPo/CO01xWnfCeY9H20mDBTlpvQiX83JNXEdah7Ls45ay',NULL,'2025-10-24 06:14:28','2025-10-24 06:50:33');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_configurations`
--

DROP TABLE IF EXISTS `business_configurations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_configurations` (
  `bus_config_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bus_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `db_host` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bus_ntn_cnic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_account_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_account_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_reg_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_contact_num` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_contact_person` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_IBAN` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_swift_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bus_acc_branch_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_acc_branch_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `db_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fbr_env` enum('sandbox','production') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sandbox',
  `fbr_api_token_sandbox` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fbr_api_token_prod` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`bus_config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_configurations`
--

LOCK TABLES `business_configurations` WRITE;
/*!40000 ALTER TABLE `business_configurations` DISABLE KEYS */;
INSERT INTO `business_configurations` VALUES (1,'Secureism Pvt Ltd','127.0.0.1','8923980','F3 Center of Technology, Zaraj Society, Islamabad Pakistan','PUNJAB','SECUREISM (PRIVATE) LIMITED','0010109016750017','0119999','03001234567','ZEESHAN QAMAR','PK44ABPA0010109016750017','ABPAPKKA','ABL CHAKLALA SCHEME 3 RAWALPINDI','0757','25a88e58a92bf1aa5e3261df0c7fcee4','2025-07-04 12:02:41','2025-12-15 07:44:37','tax_bridge_pos','root','Admin','sandbox','2ebe4443-4c22-341f-8f4e-aa4002fcffcb',NULL);
/*!40000 ALTER TABLE `business_configurations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_feature_usage`
--

DROP TABLE IF EXISTS `business_feature_usage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_feature_usage` (
  `business_feature_usage_id` int unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `business_package_id` bigint unsigned DEFAULT NULL,
  `feature_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `period_start_date` date NOT NULL,
  `period_end_date` date NOT NULL,
  `used_count` int unsigned DEFAULT '0',
  PRIMARY KEY (`business_feature_usage_id`),
  KEY `business_id` (`business_id`),
  KEY `feature_key` (`feature_key`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_feature_usage`
--

LOCK TABLES `business_feature_usage` WRITE;
/*!40000 ALTER TABLE `business_feature_usage` DISABLE KEYS */;
INSERT INTO `business_feature_usage` VALUES (9,1,5,'invoices','2025-11-18','2025-12-18',30),(11,1,7,'invoices','2025-12-18','2026-01-18',4);
/*!40000 ALTER TABLE `business_feature_usage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_package_features`
--

DROP TABLE IF EXISTS `business_package_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_package_features` (
  `business_package_features_id` int unsigned NOT NULL AUTO_INCREMENT,
  `business_package_id` int unsigned NOT NULL,
  `feature_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `limit_type` enum('monthly','quarterly','yearly','total') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthly',
  `limit_value` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`business_package_features_id`),
  KEY `business_package_id` (`business_package_id`),
  CONSTRAINT `business_package_features_ibfk_1` FOREIGN KEY (`business_package_id`) REFERENCES `business_packages` (`business_packages_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_package_features`
--

LOCK TABLES `business_package_features` WRITE;
/*!40000 ALTER TABLE `business_package_features` DISABLE KEYS */;
INSERT INTO `business_package_features` VALUES (9,5,'invoices','monthly',50),(10,6,'invoices','monthly',50),(11,7,'invoices','monthly',50);
/*!40000 ALTER TABLE `business_package_features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_packages`
--

DROP TABLE IF EXISTS `business_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_packages` (
  `business_packages_id` int unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `package_id` int unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `discount` decimal(10,2) DEFAULT '0.00',
  `price_after_discout` decimal(15,2) DEFAULT '0.00',
  `is_active` tinyint(1) DEFAULT '1',
  `is_trial` tinyint(1) NOT NULL DEFAULT '0',
  `trial_end_date` date DEFAULT NULL,
  PRIMARY KEY (`business_packages_id`),
  KEY `business_id` (`business_id`),
  KEY `package_id` (`package_id`),
  CONSTRAINT `business_packages_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_packages`
--

LOCK TABLES `business_packages` WRITE;
/*!40000 ALTER TABLE `business_packages` DISABLE KEYS */;
INSERT INTO `business_packages` VALUES (5,1,5,'2025-11-18','2025-12-18',0.00,0.00,0,0,NULL),(7,1,5,'2025-12-18','2026-01-18',0.00,0.00,1,0,NULL);
/*!40000 ALTER TABLE `business_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_scenarios`
--

DROP TABLE IF EXISTS `business_scenarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_scenarios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bus_config_id` bigint unsigned NOT NULL,
  `scenario_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bus_config_id` (`bus_config_id`),
  KEY `scenario_id` (`scenario_id`),
  CONSTRAINT `business_scenarios_ibfk_1` FOREIGN KEY (`bus_config_id`) REFERENCES `business_configurations` (`bus_config_id`),
  CONSTRAINT `business_scenarios_ibfk_2` FOREIGN KEY (`scenario_id`) REFERENCES `sandbox_scenarios` (`scenario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_scenarios`
--

LOCK TABLES `business_scenarios` WRITE;
/*!40000 ALTER TABLE `business_scenarios` DISABLE KEYS */;
INSERT INTO `business_scenarios` VALUES (16,1,1,'2025-10-07 11:04:00','2025-10-07 11:04:00'),(38,1,19,'2025-11-17 04:24:01','2025-11-17 04:24:01');
/*!40000 ALTER TABLE `business_scenarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_settings`
--

DROP TABLE IF EXISTS `general_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `general_settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `bus_config_id` int unsigned DEFAULT NULL,
  `site_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_rtl` tinyint(1) DEFAULT NULL,
  `currency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_id` int DEFAULT NULL,
  `subscription_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_access` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `without_stock` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `date_format` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `developed_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_format` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `decimal` int DEFAULT '2',
  `state` int DEFAULT NULL,
  `theme` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `modules` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency_position` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `expiry_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'days',
  `expiry_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `expiry_alert_days` int unsigned NOT NULL DEFAULT '0' COMMENT 'Number of days before expiry to show alert',
  `is_zatca` tinyint(1) DEFAULT NULL,
  `company_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_registration_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_packing_slip` tinyint(1) NOT NULL DEFAULT '0',
  `app_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_products_details_in_sales_table` tinyint NOT NULL DEFAULT '0',
  `show_products_details_in_purchase_table` tinyint NOT NULL DEFAULT '0',
  `default_margin_value` decimal(8,2) NOT NULL DEFAULT '25.00',
  `timezone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `font_css` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `auth_css` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pos_css` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `custom_css` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `disable_signup` int NOT NULL DEFAULT '0',
  `disable_forgot_password` int NOT NULL DEFAULT '0',
  `margin_type` int NOT NULL DEFAULT '0',
  `default_fbr_scenario` int DEFAULT NULL,
  `default_fbr_scenario_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_bus_config_id` (`bus_config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_settings`
--

LOCK TABLES `general_settings` WRITE;
/*!40000 ALTER TABLE `general_settings` DISABLE KEYS */;
INSERT INTO `general_settings` VALUES (1,1,'TaxBridgePOS','20260102113229.svg','20260102113426fav.ico',0,'4',NULL,NULL,'own','no','d-m-Y','TaxBridge','gst',2,1,'default.css','manufacturing','2018-07-06 06:13:11','2026-01-22 12:35:55','prefix',NULL,'days','0',0,0,'Tax Bridge','98098007',1,'',NULL,0,0,10.00,'Asia/Karachi',NULL,NULL,NULL,NULL,1,1,0,1,'Goods at standard rate (default)'),(2,2,'Madina Cash & Carry','20251229044528.png',NULL,0,'4',NULL,NULL,'warehouse','no','d-m-Y','TaxBridge','standard',2,1,'default.css','manufacturing','2018-07-06 06:13:11','2025-12-29 11:45:28','prefix',NULL,'days','0',0,0,'MCC','444',1,'000000',NULL,0,0,25.00,'Asia/Karachi',NULL,NULL,NULL,NULL,0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `general_settings` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (3,'2025_11_27_000100_create_client_ledgers_and_payments_tables',1),(4,'2025_11_27_000200_create_credit_notes_and_refunds_tables',2),(5,'2025_11_27_000300_create_payment_reminders_tables',3),(9,'2025_11_27_999000_add_invoice_computed_and_reminder_columns',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `package_features`
--

DROP TABLE IF EXISTS `package_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `package_features` (
  `package_features_id` int unsigned NOT NULL AUTO_INCREMENT,
  `package_id` int unsigned NOT NULL,
  `feature_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `limit_type` enum('monthly','quarterly','yearly','total') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthly',
  `limit_value` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`package_features_id`),
  KEY `package_id` (`package_id`),
  CONSTRAINT `package_features_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_features`
--

LOCK TABLES `package_features` WRITE;
/*!40000 ALTER TABLE `package_features` DISABLE KEYS */;
INSERT INTO `package_features` VALUES (14,5,'invoices','monthly',1);
/*!40000 ALTER TABLE `package_features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `packages` (
  `package_id` int unsigned NOT NULL AUTO_INCREMENT,
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `package_price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `package_billing_cycle` enum('monthly','quarterly','yearly','custom') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthly',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packages`
--

LOCK TABLES `packages` WRITE;
/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
INSERT INTO `packages` VALUES (5,'starter','starter',1000.00,'monthly','2025-11-18 15:05:18','2025-11-18 15:05:18');
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('hammad.ali@f3technologies.eu','$2y$12$fjeeLDMshmzz3zQxu4sE0eRROAzjevI5S8ag0I7izmtrq.FxGhAY6','2025-11-18 07:02:52');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (4,'products-edit','web','2018-06-03 01:00:09','2018-06-03 01:00:09'),(5,'products-delete','web','2018-06-03 22:54:22','2018-06-03 22:54:22'),(6,'products-add','web','2018-06-04 00:34:14','2018-06-04 00:34:14'),(7,'products-index','web','2018-06-04 03:34:27','2018-06-04 03:34:27'),(8,'purchases-index','web','2018-06-04 08:03:19','2018-06-04 08:03:19'),(9,'purchases-add','web','2018-06-04 08:12:25','2018-06-04 08:12:25'),(10,'purchases-edit','web','2018-06-04 09:47:36','2018-06-04 09:47:36'),(11,'purchases-delete','web','2018-06-04 09:47:36','2018-06-04 09:47:36'),(12,'sales-index','web','2018-06-04 10:49:08','2018-06-04 10:49:08'),(13,'sales-add','web','2018-06-04 10:49:52','2018-06-04 10:49:52'),(14,'sales-edit','web','2018-06-04 10:49:52','2018-06-04 10:49:52'),(15,'sales-delete','web','2018-06-04 10:49:53','2018-06-04 10:49:53'),(16,'quotes-index','web','2018-06-04 22:05:10','2018-06-04 22:05:10'),(17,'quotes-add','web','2018-06-04 22:05:10','2018-06-04 22:05:10'),(18,'quotes-edit','web','2018-06-04 22:05:10','2018-06-04 22:05:10'),(19,'quotes-delete','web','2018-06-04 22:05:10','2018-06-04 22:05:10'),(20,'transfers-index','web','2018-06-04 22:30:03','2018-06-04 22:30:03'),(21,'transfers-add','web','2018-06-04 22:30:03','2018-06-04 22:30:03'),(22,'transfers-edit','web','2018-06-04 22:30:03','2018-06-04 22:30:03'),(23,'transfers-delete','web','2018-06-04 22:30:03','2018-06-04 22:30:03'),(24,'returns-index','web','2018-06-04 22:50:24','2018-06-04 22:50:24'),(25,'returns-add','web','2018-06-04 22:50:24','2018-06-04 22:50:24'),(26,'returns-edit','web','2018-06-04 22:50:25','2018-06-04 22:50:25'),(27,'returns-delete','web','2018-06-04 22:50:25','2018-06-04 22:50:25'),(28,'customers-index','web','2018-06-04 23:15:54','2018-06-04 23:15:54'),(29,'customers-add','web','2018-06-04 23:15:55','2018-06-04 23:15:55'),(30,'customers-edit','web','2018-06-04 23:15:55','2018-06-04 23:15:55'),(31,'customers-delete','web','2018-06-04 23:15:55','2018-06-04 23:15:55'),(32,'suppliers-index','web','2018-06-04 23:40:12','2018-06-04 23:40:12'),(33,'suppliers-add','web','2018-06-04 23:40:12','2018-06-04 23:40:12'),(34,'suppliers-edit','web','2018-06-04 23:40:12','2018-06-04 23:40:12'),(35,'suppliers-delete','web','2018-06-04 23:40:12','2018-06-04 23:40:12'),(36,'product-report','web','2018-06-24 23:05:33','2018-06-24 23:05:33'),(37,'purchase-report','web','2018-06-24 23:24:56','2018-06-24 23:24:56'),(38,'sale-report','web','2018-06-24 23:33:13','2018-06-24 23:33:13'),(39,'customer-report','web','2018-06-24 23:36:51','2018-06-24 23:36:51'),(40,'due-report','web','2018-06-24 23:39:52','2018-06-24 23:39:52'),(41,'users-index','web','2018-06-25 00:00:10','2018-06-25 00:00:10'),(42,'users-add','web','2018-06-25 00:00:10','2018-06-25 00:00:10'),(43,'users-edit','web','2018-06-25 00:01:30','2018-06-25 00:01:30'),(44,'users-delete','web','2018-06-25 00:01:30','2018-06-25 00:01:30'),(45,'profit-loss','web','2018-07-14 21:50:05','2018-07-14 21:50:05'),(46,'best-seller','web','2018-07-14 22:01:38','2018-07-14 22:01:38'),(47,'daily-sale','web','2018-07-14 22:24:21','2018-07-14 22:24:21'),(48,'monthly-sale','web','2018-07-14 22:30:41','2018-07-14 22:30:41'),(49,'daily-purchase','web','2018-07-14 22:36:46','2018-07-14 22:36:46'),(50,'monthly-purchase','web','2018-07-14 22:48:17','2018-07-14 22:48:17'),(51,'payment-report','web','2018-07-14 23:10:41','2018-07-14 23:10:41'),(52,'warehouse-stock-report','web','2018-07-14 23:16:55','2018-07-14 23:16:55'),(53,'product-qty-alert','web','2018-07-14 23:33:21','2018-07-14 23:33:21'),(54,'supplier-report','web','2018-07-30 03:00:01','2018-07-30 03:00:01'),(55,'expenses-index','web','2018-09-05 01:07:10','2018-09-05 01:07:10'),(56,'expenses-add','web','2018-09-05 01:07:10','2018-09-05 01:07:10'),(57,'expenses-edit','web','2018-09-05 01:07:10','2018-09-05 01:07:10'),(58,'expenses-delete','web','2018-09-05 01:07:11','2018-09-05 01:07:11'),(59,'general_setting','web','2018-10-19 23:10:04','2018-10-19 23:10:04'),(60,'mail_setting','web','2018-10-19 23:10:04','2018-10-19 23:10:04'),(61,'pos_setting','web','2018-10-19 23:10:04','2018-10-19 23:10:04'),(62,'hrm_setting','web','2019-01-02 10:30:23','2019-01-02 10:30:23'),(63,'purchase-return-index','web','2019-01-02 21:45:14','2019-01-02 21:45:14'),(64,'purchase-return-add','web','2019-01-02 21:45:14','2019-01-02 21:45:14'),(65,'purchase-return-edit','web','2019-01-02 21:45:14','2019-01-02 21:45:14'),(66,'purchase-return-delete','web','2019-01-02 21:45:14','2019-01-02 21:45:14'),(67,'account-index','web','2019-01-02 22:06:13','2019-01-02 22:06:13'),(68,'balance-sheet','web','2019-01-02 22:06:14','2019-01-02 22:06:14'),(69,'account-statement','web','2019-01-02 22:06:14','2019-01-02 22:06:14'),(70,'department','web','2019-01-02 22:30:01','2019-01-02 22:30:01'),(71,'attendance','web','2019-01-02 22:30:01','2019-01-02 22:30:01'),(72,'payroll','web','2019-01-02 22:30:01','2019-01-02 22:30:01'),(73,'employees-index','web','2019-01-02 22:52:19','2019-01-02 22:52:19'),(74,'employees-add','web','2019-01-02 22:52:19','2019-01-02 22:52:19'),(75,'employees-edit','web','2019-01-02 22:52:19','2019-01-02 22:52:19'),(76,'employees-delete','web','2019-01-02 22:52:19','2019-01-02 22:52:19'),(77,'user-report','web','2019-01-16 06:48:18','2019-01-16 06:48:18'),(78,'stock_count','web','2019-02-17 10:32:01','2019-02-17 10:32:01'),(79,'adjustment','web','2019-02-17 10:32:02','2019-02-17 10:32:02'),(80,'sms_setting','web','2019-02-22 05:18:03','2019-02-22 05:18:03'),(81,'create_sms','web','2019-02-22 05:18:03','2019-02-22 05:18:03'),(82,'print_barcode','web','2019-03-07 05:02:19','2019-03-07 05:02:19'),(83,'empty_database','web','2019-03-07 05:02:19','2019-03-07 05:02:19'),(84,'customer_group','web','2019-03-07 05:37:15','2019-03-07 05:37:15'),(85,'unit','web','2019-03-07 05:37:15','2019-03-07 05:37:15'),(86,'tax','web','2019-03-07 05:37:15','2019-03-07 05:37:15'),(87,'gift_card','web','2019-03-07 06:29:38','2019-03-07 06:29:38'),(88,'coupon','web','2019-03-07 06:29:38','2019-03-07 06:29:38'),(89,'holiday','web','2019-10-19 08:57:15','2019-10-19 08:57:15'),(90,'warehouse-report','web','2019-10-22 06:00:23','2019-10-22 06:00:23'),(91,'warehouse','web','2020-02-26 06:47:32','2020-02-26 06:47:32'),(92,'brand','web','2020-02-26 06:59:59','2020-02-26 06:59:59'),(93,'billers-index','web','2020-02-26 07:11:15','2020-02-26 07:11:15'),(94,'billers-add','web','2020-02-26 07:11:15','2020-02-26 07:11:15'),(95,'billers-edit','web','2020-02-26 07:11:15','2020-02-26 07:11:15'),(96,'billers-delete','web','2020-02-26 07:11:15','2020-02-26 07:11:15'),(97,'money-transfer','web','2020-03-02 05:41:48','2020-03-02 05:41:48'),(98,'category','web','2020-07-13 12:13:16','2020-07-13 12:13:16'),(99,'delivery','web','2020-07-13 12:13:16','2020-07-13 12:13:16'),(100,'send_notification','web','2020-10-31 06:21:31','2020-10-31 06:21:31'),(101,'today_sale','web','2020-10-31 06:57:04','2020-10-31 06:57:04'),(102,'today_profit','web','2020-10-31 06:57:04','2020-10-31 06:57:04'),(103,'currency','web','2020-11-09 00:23:11','2020-11-09 00:23:11'),(104,'backup_database','web','2020-11-15 00:16:55','2020-11-15 00:16:55'),(105,'reward_point_setting','web','2021-06-27 04:34:42','2021-06-27 04:34:42'),(106,'revenue_profit_summary','web','2022-02-08 13:57:21','2022-02-08 13:57:21'),(107,'cash_flow','web','2022-02-08 13:57:22','2022-02-08 13:57:22'),(108,'monthly_summary','web','2022-02-08 13:57:22','2022-02-08 13:57:22'),(109,'yearly_report','web','2022-02-08 13:57:22','2022-02-08 13:57:22'),(110,'discount_plan','web','2022-02-16 09:12:26','2022-02-16 09:12:26'),(111,'discount','web','2022-02-16 09:12:38','2022-02-16 09:12:38'),(112,'product-expiry-report','web','2022-03-30 05:39:20','2022-03-30 05:39:20'),(113,'purchase-payment-index','web','2022-06-05 14:12:27','2022-06-05 14:12:27'),(114,'purchase-payment-add','web','2022-06-05 14:12:28','2022-06-05 14:12:28'),(115,'purchase-payment-edit','web','2022-06-05 14:12:28','2022-06-05 14:12:28'),(116,'purchase-payment-delete','web','2022-06-05 14:12:28','2022-06-05 14:12:28'),(117,'sale-payment-index','web','2022-06-05 14:12:28','2022-06-05 14:12:28'),(118,'sale-payment-add','web','2022-06-05 14:12:28','2022-06-05 14:12:28'),(119,'sale-payment-edit','web','2022-06-05 14:12:28','2022-06-05 14:12:28'),(120,'sale-payment-delete','web','2022-06-05 14:12:28','2022-06-05 14:12:28'),(121,'all_notification','web','2022-06-05 14:12:29','2022-06-05 14:12:29'),(122,'sale-report-chart','web','2022-06-05 14:12:29','2022-06-05 14:12:29'),(123,'dso-report','web','2022-06-05 14:12:29','2022-06-05 14:12:29'),(124,'product_history','web','2022-08-25 14:04:05','2022-08-25 14:04:05'),(125,'supplier-due-report','web','2022-08-31 09:46:33','2022-08-31 09:46:33'),(126,'custom_field','web','2023-05-02 07:41:35','2023-05-02 07:41:35'),(127,'incomes-index','web','2024-08-11 04:50:59','2024-08-11 04:50:59'),(128,'incomes-add','web','2024-08-11 04:50:59','2024-08-11 04:50:59'),(129,'incomes-edit','web','2024-08-11 04:50:59','2024-08-11 04:50:59'),(130,'incomes-delete','web','2024-08-11 04:50:59','2024-08-11 04:50:59'),(131,'packing_slip_challan','web','2024-08-11 04:51:00','2024-08-11 04:51:00'),(132,'biller-report','web','2024-08-25 23:30:44','2024-08-25 23:30:44'),(133,'payment_gateway_setting','web','2025-01-29 06:10:49','2025-01-29 06:10:49'),(134,'barcode_setting','web','2025-01-29 10:26:14','2025-01-29 10:26:14'),(135,'language_setting','web','2025-01-29 10:35:47','2025-01-29 10:35:47'),(136,'addons','web','2025-02-02 11:25:47','2025-02-02 11:25:47'),(137,'account-selection','web','2025-02-03 12:54:05','2025-02-03 12:54:05'),(138,'invoice_setting','web','2025-06-03 06:04:51','2025-06-03 06:04:51'),(139,'invoice_create_edit_delete','web','2025-06-03 06:04:51','2025-06-03 06:04:51'),(141,'handle_discount','web','2025-06-03 06:37:55','2025-06-03 06:37:55'),(142,'muri_khur','web','2025-08-02 04:41:09','2025-08-02 04:41:09'),(145,'products-import','web',NULL,NULL),(146,'purchases-import','web',NULL,NULL),(147,'sales-import','web',NULL,NULL),(148,'customers-import','web',NULL,NULL),(149,'billers-import','web',NULL,NULL),(150,'suppliers-import','web',NULL,NULL),(151,'categories-add','web',NULL,NULL),(152,'categories-import','web',NULL,NULL),(153,'categories-index','web',NULL,NULL),(154,'categories-edit','web',NULL,NULL),(155,'categories-delete','web',NULL,NULL),(156,'role_permission','web',NULL,NULL),(157,'cart-product-update','web',NULL,NULL),(158,'transfers-import','web',NULL,NULL),(159,'change_sale_date','web',NULL,NULL),(160,'sidebar_product','web',NULL,NULL),(161,'sidebar_purchase','web',NULL,NULL),(162,'sidebar_sale','web',NULL,NULL),(163,'sidebar_quotation','web',NULL,NULL),(164,'sidebar_transfer','web',NULL,NULL),(165,'sidebar_expense','web',NULL,NULL),(166,'sidebar_income','web',NULL,NULL),(167,'sidebar_accounting','web',NULL,NULL),(168,'sidebar_hrm','web',NULL,NULL),(169,'sidebar_people','web',NULL,NULL),(170,'sidebar_reports','web',NULL,NULL),(171,'sidebar_settings','web',NULL,NULL),(172,'sale_export','web',NULL,NULL),(173,'product_export','web',NULL,NULL),(174,'purchase_export','web',NULL,NULL),(175,'designations','web',NULL,NULL),(176,'shift','web',NULL,NULL),(177,'overtime','web',NULL,NULL),(178,'leave-type','web',NULL,NULL),(179,'leave','web',NULL,NULL),(180,'hrm-panel','web',NULL,NULL),(181,'sale-agents','web',NULL,NULL),(182,'customer_export','web','2026-01-08 05:44:47','2026-01-08 05:44:47');
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
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`(64)),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=615 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (10,'App\\Models\\User',2,'api-token','937d120e182f263841cbb4bd2c031f4b51975bfc63804f131de1fb9b76a34274','[\"*\"]','2025-11-07 05:33:35',NULL,'2025-11-07 05:20:10','2025-11-07 05:33:35'),(12,'App\\Models\\User',2,'refresh','ea5fefb2f19b721d2a81688a908967397e12ae6eb1a6d574fd97dab5c1258a87','[\"*\"]',NULL,'2025-12-07 05:46:30','2025-11-07 05:46:30','2025-11-07 05:46:30'),(14,'App\\Models\\User',2,'refresh','b03635de5b419673353110e7212be80a4119709b551f4b58b96717fb277b26af','[\"*\"]',NULL,'2025-12-07 05:49:26','2025-11-07 05:49:26','2025-11-07 05:49:26'),(16,'App\\Models\\User',2,'refresh','17c6ec03c8d81d140163fc570b38403d1a0ff2c815537b9b70b349646998fe71','[\"*\"]',NULL,'2025-12-07 05:51:54','2025-11-07 05:51:54','2025-11-07 05:51:54'),(18,'App\\Models\\User',2,'refresh','adbd8ad10efe99d8811bfed477c803845507dff40d58ffb7a09808f6af7b8c8c','[\"*\"]',NULL,'2025-12-07 06:10:38','2025-11-07 06:10:38','2025-11-07 06:10:38'),(20,'App\\Models\\User',2,'refresh','af0ee894135c4ea475f0f440b2b6270fde633bfbac9809fe7f19d24d4d68104c','[\"*\"]',NULL,'2025-12-07 11:11:22','2025-11-07 11:11:22','2025-11-07 11:11:22'),(22,'App\\Models\\User',2,'refresh','2e884345c906ed5ee793bf49ded3a289f5d414257e84fb090d415c83dbfe755c','[\"*\"]',NULL,'2025-12-07 11:30:53','2025-11-07 11:30:53','2025-11-07 11:30:53'),(24,'App\\Models\\User',2,'refresh','3442ce6fade32e0e676eeece8742e0a92a6816d5f9ad7767363578753bc7adda','[\"*\"]',NULL,'2025-12-07 12:34:54','2025-11-07 12:34:54','2025-11-07 12:34:54'),(26,'App\\Models\\User',2,'refresh','61634eb4d62fabac524d99d6251e91b74737b33eff81bc2059f5728319248a81','[\"*\"]',NULL,'2025-12-10 04:58:35','2025-11-10 04:58:35','2025-11-10 04:58:35'),(28,'App\\Models\\User',2,'refresh','d3f20d4fab009c8d830485b96230af4a91532b577ed4ca8b0c4bd4bd4a2c7f6a','[\"*\"]',NULL,'2025-12-10 06:23:57','2025-11-10 06:23:57','2025-11-10 06:23:57'),(30,'App\\Models\\User',2,'refresh','3b47eeea3fc4f8406afad9deed809d01138d3a52fc7bacb54c2db5b450e3a478','[\"*\"]',NULL,'2025-12-10 10:40:37','2025-11-10 10:40:37','2025-11-10 10:40:37'),(32,'App\\Models\\User',2,'refresh','ba123349898beb5ffda805defb22e3b99abe5772faef6d696bd68df4d30dcf8f','[\"*\"]','2025-11-10 12:22:01','2025-12-10 12:08:50','2025-11-10 12:08:50','2025-11-10 12:22:01'),(35,'App\\Models\\User',2,'refresh','ced1110f0638a7bb533d58be99a8027fabe220446bb97dec3fa5977889f2a666','[\"*\"]',NULL,'2025-12-10 12:23:12','2025-11-10 12:23:12','2025-11-10 12:23:12'),(37,'App\\Models\\User',2,'refresh','454272dc8944dd93f605c3783dfa5099558baebae2f156699fdc178434fde846','[\"*\"]',NULL,'2025-12-10 15:09:43','2025-11-10 15:09:43','2025-11-10 15:09:43'),(39,'App\\Models\\User',2,'refresh','250f59e05ad01e7c038190bc56e505ef8a9871406dc9dcc38dd13385deb0ced1','[\"*\"]',NULL,'2025-12-10 15:10:17','2025-11-10 15:10:17','2025-11-10 15:10:17'),(41,'App\\Models\\User',2,'refresh','9ec9cb1cf18c04ac2486e3d2b734cfdde979258651c79a71c3f30e8212838fd3','[\"*\"]',NULL,'2025-12-11 10:35:22','2025-11-11 10:35:22','2025-11-11 10:35:22'),(43,'App\\Models\\User',2,'refresh','72e474037474cd6fbc7eba9061df22642a542aa7a232bd369c512eb8a684b014','[\"*\"]',NULL,'2025-12-11 10:35:39','2025-11-11 10:35:39','2025-11-11 10:35:39'),(45,'App\\Models\\User',2,'refresh','7d93c9a325ef87fbdce85ed3fe5f5de9db57da8b35524a40f17851a95b7ff8b1','[\"*\"]',NULL,'2025-12-11 10:35:50','2025-11-11 10:35:50','2025-11-11 10:35:50'),(47,'App\\Models\\User',2,'refresh','26c0f801dabd1a73d211da853638ca434a6ad24424ced1a815acdf207e2792cd','[\"*\"]',NULL,'2025-12-11 10:40:35','2025-11-11 10:40:35','2025-11-11 10:40:35'),(49,'App\\Models\\User',2,'refresh','ac9cf98c3c636df3e50f5fae26a6e05300146a028f2a2d6f97d4938610cbf132','[\"*\"]',NULL,'2025-12-11 12:06:20','2025-11-11 12:06:20','2025-11-11 12:06:20'),(51,'App\\Models\\User',2,'refresh','c113791f9cfe5e5b014845663f2578d2bf3cdb95159447e530b7d64d5dc18154','[\"*\"]',NULL,'2025-12-11 12:11:44','2025-11-11 12:11:44','2025-11-11 12:11:44'),(53,'App\\Models\\User',2,'refresh','a74f1af5bee7d23447349f1aa0c9fd1ead5ce59856584c7f20ba75d640521988','[\"*\"]',NULL,'2025-12-11 12:17:22','2025-11-11 12:17:22','2025-11-11 12:17:22'),(55,'App\\Models\\User',2,'refresh','1140121b6945ced6a5d74d973eed8dd9b0c276caf8ffd08cd40bdf156b9add5b','[\"*\"]',NULL,'2025-12-11 12:21:01','2025-11-11 12:21:01','2025-11-11 12:21:01'),(57,'App\\Models\\User',2,'refresh','3078da78d59b0e0a58459396af35a0c5781f1c36b168e5ebe3c29b7f77a499c4','[\"*\"]',NULL,'2025-12-11 13:09:21','2025-11-11 13:09:21','2025-11-11 13:09:21'),(59,'App\\Models\\User',2,'refresh','c3603b58b54d83feb5dc13550f8db99751f8de3d2166bf5a7f0307a31173c3cd','[\"*\"]',NULL,'2025-12-11 13:44:08','2025-11-11 13:44:08','2025-11-11 13:44:08'),(61,'App\\Models\\User',2,'refresh','e8b18cbb43b4c37112dddedec5d60e2635004bcf0d801e076dde55e78f7db397','[\"*\"]',NULL,'2025-12-11 13:44:48','2025-11-11 13:44:48','2025-11-11 13:44:48'),(63,'App\\Models\\User',2,'refresh','28958d4cb6f5d55f6c03aa2bd86aec88681d505a892608b7f33bd9ec0c76687e','[\"*\"]',NULL,'2025-12-11 13:50:55','2025-11-11 13:50:55','2025-11-11 13:50:55'),(65,'App\\Models\\User',2,'refresh','88ab1b057b4aad4265b7c2d359325e34a0907e1434968288b7127d23e2db6737','[\"*\"]',NULL,'2025-12-11 14:00:48','2025-11-11 14:00:48','2025-11-11 14:00:48'),(67,'App\\Models\\User',2,'refresh','651459877077d75aa4baae0c38a90b1b7af641ca3f340cdccdfc9e19f51dd8e7','[\"*\"]',NULL,'2025-12-11 14:01:38','2025-11-11 14:01:38','2025-11-11 14:01:38'),(69,'App\\Models\\User',2,'refresh','f0af2e1069dcaeba4f566d877174f138655033a3ca44aef85eecd592b7579098','[\"*\"]',NULL,'2025-12-11 14:06:58','2025-11-11 14:06:58','2025-11-11 14:06:58'),(71,'App\\Models\\User',2,'refresh','f2d4986ce155530e729fa2630b61fdd7969b2c6422d507c6dfb15e3a76f17ec5','[\"*\"]',NULL,'2025-12-11 14:38:19','2025-11-11 14:38:19','2025-11-11 14:38:19'),(73,'App\\Models\\User',2,'refresh','db293b52136d70251779d9b086a9fb20464c6a8649673ec1a2cb7c1b950abe33','[\"*\"]',NULL,'2025-12-12 04:21:22','2025-11-12 04:21:22','2025-11-12 04:21:22'),(75,'App\\Models\\User',2,'refresh','f94f987b7034ecb5cbc9cd755f5706d262d7dd3515cb914e970df60558e70484','[\"*\"]',NULL,'2025-12-12 04:23:46','2025-11-12 04:23:46','2025-11-12 04:23:46'),(77,'App\\Models\\User',2,'refresh','1ce09836cb51c0bbf0a0d2dda563b22b82ffe3d1d7f9190d735a98af1c4b8fa0','[\"*\"]',NULL,'2025-12-12 04:30:33','2025-11-12 04:30:33','2025-11-12 04:30:33'),(79,'App\\Models\\User',2,'refresh','84062b09488284d54008b320f9c812ca672d745fecb3dcf9e186e5e5b9eb7e3d','[\"*\"]',NULL,'2025-12-12 04:49:11','2025-11-12 04:49:11','2025-11-12 04:49:11'),(81,'App\\Models\\User',2,'refresh','44b7e904221e4320dd61805dd0aa5eb35c734810ad4545cc9569a187d86f9f9c','[\"*\"]',NULL,'2025-12-12 04:54:18','2025-11-12 04:54:18','2025-11-12 04:54:18'),(83,'App\\Models\\User',2,'refresh','cf27cd9f314f0398ba0865000a5ce13ce4400a2d98bb226dcdca490ec11f9ce4','[\"*\"]',NULL,'2025-12-12 04:59:07','2025-11-12 04:59:07','2025-11-12 04:59:07'),(85,'App\\Models\\User',2,'refresh','69ab147fb3edfc488c303fcc0c8b6949cce3a98fadd0b37f24337fb351409868','[\"*\"]',NULL,'2025-12-12 05:06:35','2025-11-12 05:06:35','2025-11-12 05:06:35'),(87,'App\\Models\\User',2,'refresh','3c9e0a8b8cbcd2cc3482427061c1cfcdbde96419f35be670b27f5bc158f4345e','[\"*\"]',NULL,'2025-12-12 05:15:10','2025-11-12 05:15:10','2025-11-12 05:15:10'),(89,'App\\Models\\User',2,'refresh','70d0109582965fbf93ebf4cb8801a42748fa69091f39b6a1b54d4e68b98909d1','[\"*\"]',NULL,'2025-12-12 05:16:14','2025-11-12 05:16:14','2025-11-12 05:16:14'),(91,'App\\Models\\User',2,'refresh','658825ae5c3656c3bde81107212a67d4dcf8ace4ae77478cc2df188847dc38f3','[\"*\"]',NULL,'2025-12-12 05:22:27','2025-11-12 05:22:27','2025-11-12 05:22:27'),(93,'App\\Models\\User',2,'refresh','b24614c2d6d89dda80dbce6055c42abede66b8010747a510339b6a755f55ce34','[\"*\"]',NULL,'2025-12-12 05:28:32','2025-11-12 05:28:32','2025-11-12 05:28:32'),(95,'App\\Models\\User',2,'refresh','5e76dccef079d719cc223f64761af5156828d20fd9165498cb9523d25545de7e','[\"*\"]',NULL,'2025-12-12 05:35:37','2025-11-12 05:35:37','2025-11-12 05:35:37'),(97,'App\\Models\\User',2,'refresh','b5ab54969d5b4e8df63a4b0387ae6ee15da386496760dcbfbbfa08b0bb1620d9','[\"*\"]',NULL,'2025-12-12 05:36:40','2025-11-12 05:36:40','2025-11-12 05:36:40'),(99,'App\\Models\\User',2,'refresh','e40ea9edbd01e3b25562581a86e09d7d4bf3cb846d27580c652647283f6b8610','[\"*\"]',NULL,'2025-12-12 05:45:08','2025-11-12 05:45:08','2025-11-12 05:45:08'),(101,'App\\Models\\User',2,'refresh','e4bfcfb8b377fd122512f8536fb1d88202c2f327ec1b3cdac925bf229d7539fb','[\"*\"]',NULL,'2025-12-12 05:53:22','2025-11-12 05:53:22','2025-11-12 05:53:22'),(103,'App\\Models\\User',2,'refresh','b9382f57d5fd4ffd5229b9d72c974cbe3ce5f482efdd4cd0a0ca263fced3ea8d','[\"*\"]',NULL,'2025-12-12 05:53:52','2025-11-12 05:53:52','2025-11-12 05:53:52'),(105,'App\\Models\\User',2,'refresh','0b53cd4a033da536ddb0bac89627b39f2baa0f0822ec827f5af388b76792bba7','[\"*\"]',NULL,'2025-12-12 06:02:07','2025-11-12 06:02:07','2025-11-12 06:02:07'),(107,'App\\Models\\User',2,'refresh','70c770aad10349837d0f1c32f46aad218be20dd83206900a655088656ac5511f','[\"*\"]',NULL,'2025-12-12 06:08:55','2025-11-12 06:08:55','2025-11-12 06:08:55'),(109,'App\\Models\\User',2,'refresh','b7d112188083ac4cd9293f147c1c6a37bddea8c662c6eb58807ef94ea022581a','[\"*\"]',NULL,'2025-12-12 06:12:30','2025-11-12 06:12:30','2025-11-12 06:12:30'),(111,'App\\Models\\User',2,'refresh','5aeb3d6a49f8ec13d5dee6dc1bb23cb9a4542823c7dbe12f9318b2f86b6e7930','[\"*\"]',NULL,'2025-12-12 06:35:50','2025-11-12 06:35:50','2025-11-12 06:35:50'),(113,'App\\Models\\User',2,'refresh','77fa773731f7aefd2f6b84d173e5f4160f6360b49bc5dd0d4d7d8ccf2823f75f','[\"*\"]',NULL,'2025-12-12 06:55:40','2025-11-12 06:55:40','2025-11-12 06:55:40'),(115,'App\\Models\\User',2,'refresh','bcd479f70e0863df1e56667fdc806c6b01e322e8166abdc42f268aba4d384c5f','[\"*\"]',NULL,'2025-12-12 07:03:49','2025-11-12 07:03:49','2025-11-12 07:03:49'),(117,'App\\Models\\User',2,'refresh','bca78d502dec00ab535f7e2d5c4beba6f249e547bc02a22ccaf523eb72ee26f7','[\"*\"]',NULL,'2025-12-12 07:21:25','2025-11-12 07:21:25','2025-11-12 07:21:25'),(119,'App\\Models\\User',2,'refresh','939f35b69dfda44f4ba1818539c113e000cf43463514f971bc1e35602f09beb6','[\"*\"]',NULL,'2025-12-12 07:55:03','2025-11-12 07:55:03','2025-11-12 07:55:03'),(121,'App\\Models\\User',2,'refresh','221fb0794a17824ed246b85e36436493f3be36be764ec265ab19638832569547','[\"*\"]',NULL,'2025-12-12 09:05:59','2025-11-12 09:05:59','2025-11-12 09:05:59'),(123,'App\\Models\\User',2,'refresh','cc3224cd8186c2084175a50d3d3089fc64bced142db903783b40fa4f27309f48','[\"*\"]',NULL,'2025-12-12 09:13:15','2025-11-12 09:13:15','2025-11-12 09:13:15'),(125,'App\\Models\\User',2,'refresh','fb0a6d033bdfb4439d1b96fc90fd871cd42301aba15bf60b872938356f8a3960','[\"*\"]',NULL,'2025-12-12 09:58:54','2025-11-12 09:58:54','2025-11-12 09:58:54'),(127,'App\\Models\\User',2,'refresh','d2d45b3a23994a92ca567f86c9af00a4c035b901b7c2d17400f67128bad72947','[\"*\"]',NULL,'2025-12-12 09:59:25','2025-11-12 09:59:25','2025-11-12 09:59:25'),(129,'App\\Models\\User',2,'refresh','2315cda43dded868dc6e72c4b429f3eb210a32602f64480a71e5a4a4892cbce3','[\"*\"]',NULL,'2025-12-12 10:33:25','2025-11-12 10:33:25','2025-11-12 10:33:25'),(131,'App\\Models\\User',2,'refresh','695e523b37f82c946eb581d9db6006414294b1cd8d02464e11036b2769cbfd45','[\"*\"]',NULL,'2025-12-12 10:36:37','2025-11-12 10:36:37','2025-11-12 10:36:37'),(133,'App\\Models\\User',2,'refresh','13a9e03a86d74a49feb3aa725f18092798451d2ac959942b21a0e9cb074d0a47','[\"*\"]',NULL,'2025-12-12 10:44:08','2025-11-12 10:44:08','2025-11-12 10:44:08'),(135,'App\\Models\\User',2,'refresh','38a91c51bd29f7ae5939c6c7d6aa487f78ec3ba7db82fb24ff369bc54e9218ae','[\"*\"]',NULL,'2025-12-12 10:44:20','2025-11-12 10:44:20','2025-11-12 10:44:20'),(137,'App\\Models\\User',2,'refresh','6b19ac3b81ca322ddf03fd08bf6b8da7d5eb452097bb0c8f9ef339660e7673c6','[\"*\"]',NULL,'2025-12-12 10:46:01','2025-11-12 10:46:01','2025-11-12 10:46:01'),(139,'App\\Models\\User',2,'refresh','f02532f3db58708241dfa0cb381fe0a8ea1a5260ca80357e38dbb20032503721','[\"*\"]',NULL,'2025-12-12 10:53:43','2025-11-12 10:53:43','2025-11-12 10:53:43'),(141,'App\\Models\\User',2,'refresh','910ac28d3a9335bbb9b7eed256c3eef2b2f8b1f91982510c69c0717a400551ed','[\"*\"]',NULL,'2025-12-12 11:08:17','2025-11-12 11:08:17','2025-11-12 11:08:17'),(143,'App\\Models\\User',2,'refresh','9bfa930675a8482eead1d240564d322168345a150791ea0a71460c156a550f00','[\"*\"]',NULL,'2025-12-12 11:41:13','2025-11-12 11:41:13','2025-11-12 11:41:13'),(145,'App\\Models\\User',2,'refresh','2dbef446935041af0ec31ee294c29c9a35f5fa287834bda5759d7f50ec222067','[\"*\"]',NULL,'2025-12-12 12:08:51','2025-11-12 12:08:51','2025-11-12 12:08:51'),(147,'App\\Models\\User',2,'refresh','b953a5253b93d013cb8467c7bc77d601e7306fd6c923c692230ce2e6281b82b6','[\"*\"]',NULL,'2025-12-12 12:12:09','2025-11-12 12:12:09','2025-11-12 12:12:09'),(149,'App\\Models\\User',2,'refresh','ba02f260a0d63bc7e554fdac915b8ccdf2ce9048f8ddf7ea13ac6a949a05d237','[\"*\"]',NULL,'2025-12-12 12:15:07','2025-11-12 12:15:07','2025-11-12 12:15:07'),(151,'App\\Models\\User',2,'refresh','377d073dd8e6a3dab9ba3fb9c533e0fd7a85ac1317810bdcb8c36b712ad91b1b','[\"*\"]',NULL,'2025-12-12 12:17:12','2025-11-12 12:17:12','2025-11-12 12:17:12'),(153,'App\\Models\\User',2,'refresh','31346d9d1187fc034b0758db1e779e7b8c7aadfdf6ef25423ee1aa4004b471b1','[\"*\"]',NULL,'2025-12-12 12:20:27','2025-11-12 12:20:27','2025-11-12 12:20:27'),(155,'App\\Models\\User',2,'refresh','5f6c44d9c6c02e76facfd7a9a1b987912ecd04aa6e1236d71d8f77014806ba3d','[\"*\"]',NULL,'2025-12-12 12:46:10','2025-11-12 12:46:10','2025-11-12 12:46:10'),(157,'App\\Models\\User',2,'refresh','b04ae9e08e6808c31eb7d457d586908dfa1006a624ef653f690d930beccba411','[\"*\"]',NULL,'2025-12-12 12:46:40','2025-11-12 12:46:40','2025-11-12 12:46:40'),(159,'App\\Models\\User',2,'refresh','5a31a97fd74c70a269b0e17462be092c8519349ca31bdbdae17713afefb2e5d6','[\"*\"]',NULL,'2025-12-12 13:06:49','2025-11-12 13:06:49','2025-11-12 13:06:49'),(161,'App\\Models\\User',2,'refresh','4eb195b6822fe7cbd87380b2c1416bdd80fec359114032d6c76184bb8b7c72e4','[\"*\"]',NULL,'2025-12-12 13:08:27','2025-11-12 13:08:27','2025-11-12 13:08:27'),(163,'App\\Models\\User',2,'refresh','233635aa8edb69f713e49525f8f93c69b923c91a21671438a36ad798857231f8','[\"*\"]',NULL,'2025-12-12 13:33:55','2025-11-12 13:33:55','2025-11-12 13:33:55'),(165,'App\\Models\\User',2,'refresh','91b129ad7f9aefe6dcb89b1a0e2f811c6ebe398eca29cc06e9ef3058b84d7475','[\"*\"]',NULL,'2025-12-12 14:00:29','2025-11-12 14:00:29','2025-11-12 14:00:29'),(167,'App\\Models\\User',2,'refresh','f414371e1ff72aceb04cc60ea10bab5d8a15480a0828d0bdc0278b313bd65308','[\"*\"]',NULL,'2025-12-13 04:16:28','2025-11-13 04:16:28','2025-11-13 04:16:28'),(169,'App\\Models\\User',2,'refresh','6fdaad36f8a11780c1c5b1e2728cbe55be1e80a411e3b22780a8e1e35959fb75','[\"*\"]',NULL,'2025-12-13 04:32:43','2025-11-13 04:32:43','2025-11-13 04:32:43'),(171,'App\\Models\\User',2,'refresh','dea1ebaef0613d87678008402ddcf30c49fab394b4cafb3376330e98d1c1cbfe','[\"*\"]',NULL,'2025-12-13 04:37:52','2025-11-13 04:37:52','2025-11-13 04:37:52'),(173,'App\\Models\\User',2,'refresh','94925619abe7fb3993ccaf4e33ece55f48b338aa36906ccf0aa412b6c0888c12','[\"*\"]',NULL,'2025-12-13 04:39:40','2025-11-13 04:39:40','2025-11-13 04:39:40'),(175,'App\\Models\\User',2,'refresh','766769f8a84c3fe09af3f2ef17d9c689bb2e02f2b552569d22d3eb4e72b29d44','[\"*\"]',NULL,'2025-12-13 05:33:12','2025-11-13 05:33:12','2025-11-13 05:33:12'),(177,'App\\Models\\User',2,'refresh','cdef352da536e3a2807d4e4517f7f7c9403b5d3e9aa9e3bcc66e15b4b79f389a','[\"*\"]',NULL,'2025-12-13 06:10:05','2025-11-13 06:10:05','2025-11-13 06:10:05'),(179,'App\\Models\\User',2,'refresh','956185cd652f4706afded865049fd0934f610e104c054ae468f1754f99c50bf8','[\"*\"]',NULL,'2025-12-13 06:26:50','2025-11-13 06:26:50','2025-11-13 06:26:50'),(181,'App\\Models\\User',2,'refresh','595c2c8323222669690bacb5973ce789d236f0c1482a416ffb88a4ed84209024','[\"*\"]',NULL,'2025-12-13 06:47:22','2025-11-13 06:47:22','2025-11-13 06:47:22'),(183,'App\\Models\\User',2,'refresh','966d861597cd687a8cf8076a9f364a8206d41d3c4a38e3f09a5bfaeee1d8bfde','[\"*\"]',NULL,'2025-12-13 06:57:53','2025-11-13 06:57:53','2025-11-13 06:57:53'),(185,'App\\Models\\User',2,'refresh','ecd4e893932fbf0d611888e24969db1283d19a72dd38904846115b1a1d0b1e4c','[\"*\"]',NULL,'2025-12-13 07:38:43','2025-11-13 07:38:43','2025-11-13 07:38:43'),(187,'App\\Models\\User',2,'refresh','2ed39e7f2eedeb5c08e7f72fb0c0a765fb40e5c0b4ff040793cad7ec562d9d65','[\"*\"]',NULL,'2025-12-13 07:46:01','2025-11-13 07:46:01','2025-11-13 07:46:01'),(189,'App\\Models\\User',2,'refresh','f9bef04ebedb34b9e81245d91eeb2b682c8e75616036a5d2dc8cdc4c23d8231e','[\"*\"]',NULL,'2025-12-13 07:58:13','2025-11-13 07:58:13','2025-11-13 07:58:13'),(191,'App\\Models\\User',2,'refresh','7b5e52464e4aba74eb169a37b27e1d5bab58c07f49760abbdf97a1ff7d45b47f','[\"*\"]',NULL,'2025-12-13 08:09:19','2025-11-13 08:09:19','2025-11-13 08:09:19'),(193,'App\\Models\\User',2,'refresh','956c49800790b7543a430f4d1538772b6a31aef2f085e5943f120f5db4f14141','[\"*\"]',NULL,'2025-12-13 09:18:07','2025-11-13 09:18:07','2025-11-13 09:18:07'),(195,'App\\Models\\User',2,'refresh','6d565b3f9989242994238debaec0be154d5861f2b78762ef71223599cf010829','[\"*\"]',NULL,'2025-12-13 09:20:03','2025-11-13 09:20:03','2025-11-13 09:20:03'),(197,'App\\Models\\User',2,'refresh','e9e966463a2320c0a004ff4416c11d927d69f436c5db3a1bf8a688dc39876d17','[\"*\"]',NULL,'2025-12-13 09:20:52','2025-11-13 09:20:52','2025-11-13 09:20:52'),(199,'App\\Models\\User',2,'refresh','d6e8d7e47ba904fc07a0f9d2b4a7fe9f50640c8bb699689fceb9f0118b796098','[\"*\"]',NULL,'2025-12-13 09:32:51','2025-11-13 09:32:51','2025-11-13 09:32:51'),(201,'App\\Models\\User',2,'refresh','bae632a2bf5290bc1b5f2e4748a9c7fdb541f52a565297c34ecb9284b6ef877e','[\"*\"]',NULL,'2025-12-13 09:42:31','2025-11-13 09:42:31','2025-11-13 09:42:31'),(203,'App\\Models\\User',2,'refresh','c1b30c64946824f6b5c6c073c7c22d982e45428723a37097c061a82270f0f87b','[\"*\"]',NULL,'2025-12-13 09:52:15','2025-11-13 09:52:15','2025-11-13 09:52:15'),(205,'App\\Models\\User',2,'refresh','07df6fb834b6770bd91b0fe7e07f8a5708d93150481a3e338bb3f1fef7f0b05d','[\"*\"]',NULL,'2025-12-13 09:57:55','2025-11-13 09:57:55','2025-11-13 09:57:55'),(207,'App\\Models\\User',2,'refresh','003295f47f2f95038b9062f7fd68971f6f243ba701773927765a1c0465785472','[\"*\"]',NULL,'2025-12-13 10:53:25','2025-11-13 10:53:25','2025-11-13 10:53:25'),(209,'App\\Models\\User',2,'refresh','a10a75077d6618d96e896e5592ecfd9fd81cda6e1c35d04c3475d111a29d95f0','[\"*\"]',NULL,'2025-12-13 10:58:13','2025-11-13 10:58:13','2025-11-13 10:58:13'),(211,'App\\Models\\User',2,'refresh','a25fae18ebe0b5be03903a40cfc5f3f7724b5a6e650122fdee8904f00f2aa076','[\"*\"]',NULL,'2025-12-13 11:19:49','2025-11-13 11:19:49','2025-11-13 11:19:49'),(213,'App\\Models\\User',2,'refresh','3ee6de41dbd0d82c41619fdbf5f5bce0f8a08819fe8eed91e5be1965d1619753','[\"*\"]',NULL,'2025-12-13 11:43:17','2025-11-13 11:43:17','2025-11-13 11:43:17'),(215,'App\\Models\\User',2,'refresh','0bd9228d1f4c478189bb0ae61d80241d4602ab57c7251b7efd0be6e881cddbfd','[\"*\"]',NULL,'2025-12-13 11:52:32','2025-11-13 11:52:32','2025-11-13 11:52:32'),(217,'App\\Models\\User',2,'refresh','a44d6f32a46718950a76cb38e126ab423f0dfdfd800ad53895842bdc61e6ae98','[\"*\"]',NULL,'2025-12-13 12:14:58','2025-11-13 12:14:58','2025-11-13 12:14:58'),(219,'App\\Models\\User',2,'refresh','47f13bec27ec9d28206968fe5148fccc355c228ab7d6573130058a3bd8ab465a','[\"*\"]',NULL,'2025-12-13 12:24:46','2025-11-13 12:24:46','2025-11-13 12:24:46'),(221,'App\\Models\\User',2,'refresh','811ead45ac3b3efa79eeaff090dda72522215ce2686bfe41867681ffec4dbf56','[\"*\"]',NULL,'2025-12-13 12:33:34','2025-11-13 12:33:34','2025-11-13 12:33:34'),(223,'App\\Models\\User',2,'refresh','ab3c020b231bc8e108b0980a59fcffe12bd4cfd6a36a186c0d7047017d8aac0a','[\"*\"]',NULL,'2025-12-13 12:36:14','2025-11-13 12:36:14','2025-11-13 12:36:14'),(225,'App\\Models\\User',2,'refresh','739cdc8bfe1213bc58e507a26817bc4087abba9d4afd5915abde4d13163f35b0','[\"*\"]',NULL,'2025-12-13 12:38:41','2025-11-13 12:38:41','2025-11-13 12:38:41'),(227,'App\\Models\\User',2,'refresh','9b5757976ec9223f8dfc4fd7a6b0d0cf689294c84afee55553d716a08c099e24','[\"*\"]',NULL,'2025-12-13 12:38:51','2025-11-13 12:38:51','2025-11-13 12:38:51'),(229,'App\\Models\\User',2,'refresh','5d7bceb644525999e90cf2069f879ef4e651ad7a905578247473f014ae47d29c','[\"*\"]',NULL,'2025-12-13 12:45:32','2025-11-13 12:45:32','2025-11-13 12:45:32'),(231,'App\\Models\\User',2,'refresh','bab96a3121c528cc8e3dc7f0288dbff87aeccb308a6c04b5862d375f206c4858','[\"*\"]',NULL,'2025-12-13 12:50:52','2025-11-13 12:50:51','2025-11-13 12:50:52'),(233,'App\\Models\\User',2,'refresh','2a557af56288cd4219092c0c3a26d1bc2e5b3f143ad6428fdfaf1240a8cb5ef1','[\"*\"]',NULL,'2025-12-13 13:15:02','2025-11-13 13:15:02','2025-11-13 13:15:02'),(235,'App\\Models\\User',2,'refresh','d177862f5110bf2f297e158e971ce46baecc9903f83820731c4db585e9458259','[\"*\"]',NULL,'2025-12-13 13:24:22','2025-11-13 13:24:22','2025-11-13 13:24:22'),(237,'App\\Models\\User',2,'refresh','f74e57288daabb9eaa62ba5d7ebfedfab424653712ed1edbc3dddb94f86c1323','[\"*\"]',NULL,'2025-12-13 13:28:26','2025-11-13 13:28:26','2025-11-13 13:28:26'),(239,'App\\Models\\User',2,'refresh','4fcfd25370764c4b4171d30024adc2379a9e6c982676ed9cb1b0beffd3dc39c6','[\"*\"]',NULL,'2025-12-13 13:37:07','2025-11-13 13:37:07','2025-11-13 13:37:07'),(241,'App\\Models\\User',2,'refresh','c740cd019b8f54b1dcdcb511a5264fbe0766863513dae72f1267bf17e877fc30','[\"*\"]',NULL,'2025-12-13 13:40:57','2025-11-13 13:40:57','2025-11-13 13:40:57'),(243,'App\\Models\\User',2,'refresh','696ea9be01520924798b78decadef21ecb03e11ea2423f7a03a7f763651abd56','[\"*\"]',NULL,'2025-12-13 13:50:56','2025-11-13 13:50:56','2025-11-13 13:50:56'),(245,'App\\Models\\User',2,'refresh','99d0365a37dd9dc2bab11f41ad132982215e4dc196bfb9b33c928f7951030c3d','[\"*\"]',NULL,'2025-12-13 13:55:01','2025-11-13 13:55:01','2025-11-13 13:55:01'),(247,'App\\Models\\User',2,'refresh','5d81dd69792b7e3a9dd0ba97497bd5e906e9dce2efc557421928a7a39d002acb','[\"*\"]',NULL,'2025-12-13 14:01:34','2025-11-13 14:01:34','2025-11-13 14:01:34'),(249,'App\\Models\\User',2,'refresh','149d5623eb757d0554a1660325cf6d2acf239a60a7b878b77cadf75ca15ad404','[\"*\"]',NULL,'2025-12-13 14:02:36','2025-11-13 14:02:36','2025-11-13 14:02:36'),(251,'App\\Models\\User',2,'refresh','e56a69ccc0b2aee890a593b27126b90755e159d82ddbab17b352c0baf3fd8db0','[\"*\"]',NULL,'2025-12-13 14:11:19','2025-11-13 14:11:19','2025-11-13 14:11:19'),(253,'App\\Models\\User',2,'refresh','e2acbe42de116c73cce788b643c526104e66acbc808f0bfc804588bb36c54437','[\"*\"]',NULL,'2025-12-13 14:46:45','2025-11-13 14:46:45','2025-11-13 14:46:45'),(255,'App\\Models\\User',2,'refresh','5e65ac9a4c71c3771938a9101092832c001b080df7fdf47103c6ed9d8b53ae1a','[\"*\"]',NULL,'2025-12-14 04:38:32','2025-11-14 04:38:32','2025-11-14 04:38:32'),(257,'App\\Models\\User',2,'refresh','a6a88be657b96e484b9bc0a0cca5f2be973c425eea96c6b81b9c06cfa67b106b','[\"*\"]',NULL,'2025-12-14 04:53:14','2025-11-14 04:53:14','2025-11-14 04:53:14'),(259,'App\\Models\\User',2,'refresh','958ddec8f3ce9b040404f4517fb77d5c7164104b872cb50aeda8147316dbba9b','[\"*\"]',NULL,'2025-12-14 05:31:44','2025-11-14 05:31:44','2025-11-14 05:31:44'),(261,'App\\Models\\User',2,'refresh','329573bd68436e26824355e707dc6905e9ae9293f4eb456d427b988af6af7cd1','[\"*\"]',NULL,'2025-12-14 05:32:45','2025-11-14 05:32:45','2025-11-14 05:32:45'),(263,'App\\Models\\User',2,'refresh','1285a751187dd7bca49ba3d2d42edfc94f1a1dc2dcfb2429ba2ac89c6c5f54a0','[\"*\"]',NULL,'2025-12-14 05:47:34','2025-11-14 05:47:34','2025-11-14 05:47:34'),(265,'App\\Models\\User',2,'refresh','eafa0e022e40ae415ea0cb0091a0cb9f142707d9390df92812f4714ec085af35','[\"*\"]',NULL,'2025-12-14 05:53:43','2025-11-14 05:53:43','2025-11-14 05:53:43'),(267,'App\\Models\\User',2,'refresh','04f7f68bed1264397e80b12569b49a946d08f57f756dc2849c5d7b832a694707','[\"*\"]',NULL,'2025-12-14 06:03:58','2025-11-14 06:03:58','2025-11-14 06:03:58'),(269,'App\\Models\\User',2,'refresh','f64c05616469a5407fb0a49600490230f1331327c439d865e1e58b3750e81f7c','[\"*\"]',NULL,'2025-12-14 06:17:19','2025-11-14 06:17:19','2025-11-14 06:17:19'),(271,'App\\Models\\User',2,'refresh','a6e2db7b78c058957554227e989047d2ddc3a02d5cf790c2e6c702fea150d208','[\"*\"]',NULL,'2025-12-14 06:38:43','2025-11-14 06:38:43','2025-11-14 06:38:43'),(273,'App\\Models\\User',2,'refresh','1b7799b8b7ed75fe8b59708a93fc1e6463e283105c18f4ca013094fa30498ac4','[\"*\"]',NULL,'2025-12-14 06:45:22','2025-11-14 06:45:22','2025-11-14 06:45:22'),(275,'App\\Models\\User',2,'refresh','3b26def03255e43dcd70278025415552e04e75be058408f79717ad574eee7662','[\"*\"]',NULL,'2025-12-14 06:54:02','2025-11-14 06:54:02','2025-11-14 06:54:02'),(277,'App\\Models\\User',2,'refresh','9ec18fb6fca88188410e42350129a382dd9c142f212b970823aab10780a4edd6','[\"*\"]',NULL,'2025-12-14 06:59:50','2025-11-14 06:59:50','2025-11-14 06:59:50'),(279,'App\\Models\\User',2,'refresh','ebe0c261c48d88704b37f566c5693ba7694e020ce891937038644865b6564615','[\"*\"]',NULL,'2025-12-14 07:07:04','2025-11-14 07:07:04','2025-11-14 07:07:04'),(281,'App\\Models\\User',2,'refresh','17b58263a5cd230522a46e8d7e7d7baa1e87d2e4090f010e251798e5062b6740','[\"*\"]',NULL,'2025-12-14 07:11:01','2025-11-14 07:11:01','2025-11-14 07:11:01'),(283,'App\\Models\\User',2,'refresh','9cdbcdc64ff5584abda90363b59fe7da154917f72d33f6e67d0a37d7c2484b3f','[\"*\"]',NULL,'2025-12-14 07:19:37','2025-11-14 07:19:37','2025-11-14 07:19:37'),(285,'App\\Models\\User',2,'refresh','af4ac1c68d00d9d6a99ff17c011b669b6c9b64ed5d5bba4d9f1ce05fd2ad79ba','[\"*\"]',NULL,'2025-12-14 07:24:45','2025-11-14 07:24:45','2025-11-14 07:24:45'),(287,'App\\Models\\User',2,'refresh','6ddc39439eadf91263cb2a94326959c9de03d88a6849b78a06826f6b3ae027e0','[\"*\"]',NULL,'2025-12-14 07:27:39','2025-11-14 07:27:39','2025-11-14 07:27:39'),(289,'App\\Models\\User',2,'refresh','db048f640dd662480083981f0cecfc82da09efad40ba8c021c3f7fb7c1c096b9','[\"*\"]',NULL,'2025-12-14 07:35:07','2025-11-14 07:35:07','2025-11-14 07:35:07'),(291,'App\\Models\\User',2,'refresh','a58d45a564f99283be3127bb42eb6a036592f07b4916fc9809ab081996968a50','[\"*\"]',NULL,'2025-12-14 07:36:51','2025-11-14 07:36:51','2025-11-14 07:36:51'),(293,'App\\Models\\User',2,'refresh','cf76bce4d81a5c952c8d7628eefd6378c36cf9a09def0ab4afbe5cc265782ee5','[\"*\"]',NULL,'2025-12-14 07:43:39','2025-11-14 07:43:39','2025-11-14 07:43:39'),(295,'App\\Models\\User',2,'refresh','590c6cc7d8904e596aec982d4703e70bd20a6698242f4cd88097cccd5d4e2243','[\"*\"]',NULL,'2025-12-14 07:52:01','2025-11-14 07:52:01','2025-11-14 07:52:01'),(297,'App\\Models\\User',2,'refresh','82dff29d3abe76494560d8a554d77c5e39ad61666425925c95359f23d5399e1e','[\"*\"]',NULL,'2025-12-14 07:58:33','2025-11-14 07:58:33','2025-11-14 07:58:33'),(299,'App\\Models\\User',2,'refresh','7dc6c708fa7e91cf0bf981915cf9ca928f50c2364b4c298f0578651158adf120','[\"*\"]',NULL,'2025-12-14 08:08:44','2025-11-14 08:08:44','2025-11-14 08:08:44'),(301,'App\\Models\\User',2,'refresh','ea6a8779e01c022ecc63258b4e4201ed4ae44e3684c112c992ddeb73a2722e15','[\"*\"]',NULL,'2025-12-14 08:09:52','2025-11-14 08:09:52','2025-11-14 08:09:52'),(303,'App\\Models\\User',2,'refresh','1b05973aa414a6592e0d21a6593f4ad7b96f44482fc1002925ad8159bbc83733','[\"*\"]',NULL,'2025-12-14 08:13:06','2025-11-14 08:13:06','2025-11-14 08:13:06'),(305,'App\\Models\\User',2,'refresh','b4d1f318de3f8f121c97d1e49534523a02be6c57644eb4dc9d5f9d28eff69af1','[\"*\"]',NULL,'2025-12-14 09:00:16','2025-11-14 09:00:16','2025-11-14 09:00:16'),(307,'App\\Models\\User',2,'refresh','7ecdc01e890a9cce6d08fab161d12bdc8334b91d69a35297dee96e51d5a1bb73','[\"*\"]',NULL,'2025-12-14 09:04:35','2025-11-14 09:04:35','2025-11-14 09:04:35'),(309,'App\\Models\\User',2,'refresh','512c93813f005dd1b3783816ac112db918d75e05dcfee3406e0f43da6cc92c94','[\"*\"]',NULL,'2025-12-14 09:10:15','2025-11-14 09:10:15','2025-11-14 09:10:15'),(311,'App\\Models\\User',2,'refresh','127729bccc87363abb3cda52290315877725e247eff609bb739cba002ca1e5d0','[\"*\"]',NULL,'2025-12-14 09:22:14','2025-11-14 09:22:14','2025-11-14 09:22:14'),(313,'App\\Models\\User',2,'refresh','2b4d35ae7b58676db37a3386b6ab09bd364916baf5625254ef0932b57a5c9ed4','[\"*\"]',NULL,'2025-12-14 09:32:42','2025-11-14 09:32:42','2025-11-14 09:32:42'),(315,'App\\Models\\User',2,'refresh','d974344afac7efe5f0e3f49e2f434b403b68d76aa8cad1b1c40fa0597d867f33','[\"*\"]',NULL,'2025-12-14 09:40:14','2025-11-14 09:40:14','2025-11-14 09:40:14'),(317,'App\\Models\\User',2,'refresh','649fed5bd51ccc2e0cb799b20469a613f2d715ef3f63f6797af9b650d5fc79df','[\"*\"]',NULL,'2025-12-14 09:45:28','2025-11-14 09:45:28','2025-11-14 09:45:28'),(319,'App\\Models\\User',2,'refresh','bc4a9a9b1d9b8cc07f51d0900bebdb8a6ea8782bc059b1fff8d9949c78d2373d','[\"*\"]',NULL,'2025-12-14 09:48:27','2025-11-14 09:48:27','2025-11-14 09:48:27'),(321,'App\\Models\\User',2,'refresh','b7ef3ca0fc3678972d8f1f4806e854899f1fa318bc6d3c03bf9aac9773da8577','[\"*\"]',NULL,'2025-12-14 09:52:41','2025-11-14 09:52:41','2025-11-14 09:52:41'),(323,'App\\Models\\User',2,'refresh','04a28c3fea207b8f5b50292adb93e920b4d87adb10e4313cdf34035523e8279c','[\"*\"]',NULL,'2025-12-14 10:00:04','2025-11-14 10:00:04','2025-11-14 10:00:04'),(325,'App\\Models\\User',2,'refresh','1f6c3e5e5035b624bfc5cf28c5107a04bc8ee65d95849c684ad07d611c79400d','[\"*\"]',NULL,'2025-12-14 10:14:26','2025-11-14 10:14:26','2025-11-14 10:14:26'),(327,'App\\Models\\User',2,'refresh','8cbed626354d7bb3cbc3d5ef543ab3408dce8f4935c6b79382863877424c8755','[\"*\"]',NULL,'2025-12-14 10:17:51','2025-11-14 10:17:51','2025-11-14 10:17:51'),(329,'App\\Models\\User',2,'refresh','2b6dc62432e8da28e04990324feef4050a3ee73a04b02576569d490132fc0649','[\"*\"]',NULL,'2025-12-14 10:21:35','2025-11-14 10:21:35','2025-11-14 10:21:35'),(331,'App\\Models\\User',2,'refresh','d6014c07c0c67afb98642683ae84dfbf7b9838f0b1e93ac5872adb989d43f22e','[\"*\"]',NULL,'2025-12-14 10:24:06','2025-11-14 10:24:06','2025-11-14 10:24:06'),(333,'App\\Models\\User',2,'refresh','2a5ade9ea374587774165c01697b2a1910fa3c3ceb2e939f876f6372d225d48c','[\"*\"]',NULL,'2025-12-14 10:27:44','2025-11-14 10:27:44','2025-11-14 10:27:44'),(335,'App\\Models\\User',2,'refresh','2dbab6c4891488076cd37cfd83dcba978a05711a85f81c50cc8d2cf9d93d29fb','[\"*\"]',NULL,'2025-12-14 10:31:53','2025-11-14 10:31:53','2025-11-14 10:31:53'),(337,'App\\Models\\User',2,'refresh','f1cd940396b5285921f60eb66b2d1bb4ae9ede58cb2ff2481c41018e092d6a2b','[\"*\"]',NULL,'2025-12-14 10:43:44','2025-11-14 10:43:44','2025-11-14 10:43:44'),(339,'App\\Models\\User',2,'refresh','4694a28146d741b6271fe9c0ed2ebb1f5299dd1e8b07f314951e5c7fb01a0918','[\"*\"]',NULL,'2025-12-14 10:59:45','2025-11-14 10:59:45','2025-11-14 10:59:45'),(341,'App\\Models\\User',2,'refresh','1548930ec339c816884d997e7c2fce80177a7ba54fa479c476b5f01e6c897585','[\"*\"]',NULL,'2025-12-14 11:01:42','2025-11-14 11:01:42','2025-11-14 11:01:42'),(343,'App\\Models\\User',2,'refresh','22d2b68c2b914b1c77dcf449944dc8449e202e4b2b8f9fd062655e8def780f9b','[\"*\"]',NULL,'2025-12-14 11:06:55','2025-11-14 11:06:55','2025-11-14 11:06:55'),(345,'App\\Models\\User',2,'refresh','3e86f716cc28df698ca195c221dda2d17cfaf558507756c72ea3529c82d467a1','[\"*\"]',NULL,'2025-12-14 11:19:06','2025-11-14 11:19:06','2025-11-14 11:19:06'),(347,'App\\Models\\User',2,'refresh','38241351bcace16ee366b40c61c02bff9043377208c22a321e6223577b8a8cd2','[\"*\"]',NULL,'2025-12-14 11:21:33','2025-11-14 11:21:33','2025-11-14 11:21:33'),(349,'App\\Models\\User',2,'refresh','18549be92aec823d6f7f84838e130fae7f3c40635153500a0017ebd39070e729','[\"*\"]',NULL,'2025-12-14 11:27:01','2025-11-14 11:27:01','2025-11-14 11:27:01'),(351,'App\\Models\\User',2,'refresh','951d9f6085cdddcd003b6283ffa655f998ad51feec5d7ea6a594403ef0a18e9b','[\"*\"]',NULL,'2025-12-14 11:31:46','2025-11-14 11:31:46','2025-11-14 11:31:46'),(353,'App\\Models\\User',2,'refresh','1c6e129dc2c585e60d9780e0e3f63df76afa0c3c0019c54cee0432f915cd17b1','[\"*\"]',NULL,'2025-12-14 11:37:52','2025-11-14 11:37:52','2025-11-14 11:37:52'),(355,'App\\Models\\User',2,'refresh','61e4626de2ad0abe1a4c38594d717e9ee5c2c9fba0145fda5993af2e3d3777e9','[\"*\"]',NULL,'2025-12-14 11:43:51','2025-11-14 11:43:51','2025-11-14 11:43:51'),(357,'App\\Models\\User',2,'refresh','c9d8c16f95b38e9e154ee7d418cba80e11607201c6374ffa318d31837e57e8f7','[\"*\"]',NULL,'2025-12-14 11:57:20','2025-11-14 11:57:20','2025-11-14 11:57:20'),(359,'App\\Models\\User',2,'refresh','d0cd71612010df852626993e6db17719e16a16c21bce8e5f707df66313130ab0','[\"*\"]',NULL,'2025-12-14 11:57:48','2025-11-14 11:57:48','2025-11-14 11:57:48'),(361,'App\\Models\\User',2,'refresh','c86b64dd9ae31a5c3948d1f929eaaf6c05f4b92d4a21bb9d299f9aef7600af72','[\"*\"]',NULL,'2025-12-14 12:03:30','2025-11-14 12:03:30','2025-11-14 12:03:30'),(363,'App\\Models\\User',2,'refresh','021a016f6e9ddfe6a2df8aff75201e95e4ec5de8ae6e5e62932a1045bccd8491','[\"*\"]',NULL,'2025-12-14 12:06:53','2025-11-14 12:06:53','2025-11-14 12:06:53'),(365,'App\\Models\\User',2,'refresh','30f7f647dc86f024be5fb3dd0556ee367676aa97020f726e3b8cf536d5f14882','[\"*\"]',NULL,'2025-12-14 12:26:16','2025-11-14 12:26:16','2025-11-14 12:26:16'),(367,'App\\Models\\User',2,'refresh','5a93c67715f87529a41331718655191e369777597419f9c5f40674755b5519d7','[\"*\"]',NULL,'2025-12-14 12:29:47','2025-11-14 12:29:47','2025-11-14 12:29:47'),(369,'App\\Models\\User',2,'refresh','7b812714784b9cb5e700dd65dc04df97191d09db4cc9054ad1e33be485849352','[\"*\"]',NULL,'2025-12-14 12:36:48','2025-11-14 12:36:48','2025-11-14 12:36:48'),(371,'App\\Models\\User',2,'refresh','63a693f9a94a3be1811c73d8ddf3a293feb78dc4995f2d90800896f0e976f703','[\"*\"]',NULL,'2025-12-14 12:45:56','2025-11-14 12:45:56','2025-11-14 12:45:56'),(373,'App\\Models\\User',2,'refresh','8a69685c3142032a4802055c43f0d7ee698fb4fbcd39a9d8eca0f048481a687d','[\"*\"]',NULL,'2025-12-14 13:06:12','2025-11-14 13:06:12','2025-11-14 13:06:12'),(375,'App\\Models\\User',2,'refresh','6930b0788eae3aaa27faa9af658a0bcfd2da9b837a7749316d60cffd1cb87478','[\"*\"]',NULL,'2025-12-14 13:11:48','2025-11-14 13:11:48','2025-11-14 13:11:48'),(377,'App\\Models\\User',2,'refresh','f7d20bead9f2a82409a4bc6d65c22308fb86a8c6a9bc4de6f2da38034c31dd4b','[\"*\"]',NULL,'2025-12-14 13:17:34','2025-11-14 13:17:34','2025-11-14 13:17:34'),(379,'App\\Models\\User',2,'refresh','4f4cd2c5001bbe85e27d073208805aebf6e962cb7dc08dd907efa071502722a9','[\"*\"]',NULL,'2025-12-14 13:23:34','2025-11-14 13:23:34','2025-11-14 13:23:34'),(381,'App\\Models\\User',2,'refresh','10e933a3467bf47cf39b28ae4154807758bdf26db020ce415be56f3ecff3f0ef','[\"*\"]',NULL,'2025-12-14 13:47:41','2025-11-14 13:47:41','2025-11-14 13:47:41'),(383,'App\\Models\\User',2,'refresh','17e3895d8728feed0040b5e89ed7e79ef81c2ed3ba30a2bed40b03c848039bc8','[\"*\"]',NULL,'2025-12-14 13:55:32','2025-11-14 13:55:32','2025-11-14 13:55:32'),(385,'App\\Models\\User',2,'refresh','7dd40aa3f05d2b1c26de624cef21043d555937d640ee63b4b936c40143e30b13','[\"*\"]',NULL,'2025-12-14 14:01:11','2025-11-14 14:01:11','2025-11-14 14:01:11'),(387,'App\\Models\\User',2,'refresh','0e84dbf8f7104683fca16f93956d1662beee1f4842333924bf0268f7f4db3d25','[\"*\"]',NULL,'2025-12-14 14:05:04','2025-11-14 14:05:04','2025-11-14 14:05:04'),(389,'App\\Models\\User',2,'refresh','e5484da16048cae22d8ad050f06b6c0fb727f2fbfc79ad5b959559984c5919cf','[\"*\"]',NULL,'2025-12-15 15:09:03','2025-11-15 15:09:03','2025-11-15 15:09:03'),(391,'App\\Models\\User',2,'refresh','4de0634a44e75dd3c9b54cafa646f03eefe79639fce9167ba9bdf1dad00d27a6','[\"*\"]',NULL,'2025-12-15 15:16:20','2025-11-15 15:16:20','2025-11-15 15:16:20'),(393,'App\\Models\\User',2,'refresh','62084978d3b5d47a427bbbc02bae31d46a1a320df4c36a3a77b442381ef6d27f','[\"*\"]',NULL,'2025-12-15 15:29:49','2025-11-15 15:29:49','2025-11-15 15:29:49'),(395,'App\\Models\\User',2,'refresh','f8a06056350ea5d94c1c9ca18d75efd07765e60822c20ba9cea950369d9fc867','[\"*\"]',NULL,'2025-12-15 15:32:45','2025-11-15 15:32:45','2025-11-15 15:32:45'),(397,'App\\Models\\User',2,'refresh','228bbcba0efbf3d3359c583b4d3028820e7019101f8d1742dac7ee3ce28f9c71','[\"*\"]',NULL,'2025-12-15 15:40:23','2025-11-15 15:40:23','2025-11-15 15:40:23'),(399,'App\\Models\\User',2,'refresh','a88dd33e421670adc078001107e87996312f538e4c56b7ca348d61033f973b0e','[\"*\"]',NULL,'2025-12-15 16:24:38','2025-11-15 16:24:38','2025-11-15 16:24:38'),(401,'App\\Models\\User',2,'refresh','9cb235fe128bec8c15adffac7f94979038be997be2a9e63552149ce2963fd1bd','[\"*\"]',NULL,'2025-12-15 16:28:30','2025-11-15 16:28:30','2025-11-15 16:28:30'),(403,'App\\Models\\User',2,'refresh','9446323c34e52f99c3aa117c59c31d69e73cda0eeb7fe0e6426628deab347801','[\"*\"]',NULL,'2025-12-15 16:30:26','2025-11-15 16:30:26','2025-11-15 16:30:26'),(405,'App\\Models\\User',2,'refresh','580587585dcc23c925e14dfb4e3965250ecacc2fcd4a3220e136352abf85d315','[\"*\"]',NULL,'2025-12-15 16:38:20','2025-11-15 16:38:20','2025-11-15 16:38:20'),(407,'App\\Models\\User',2,'refresh','6197b62607fc218a3972f88b271c8bc319f1c91a979717a74619664cfdc8aa09','[\"*\"]',NULL,'2025-12-15 16:42:29','2025-11-15 16:42:29','2025-11-15 16:42:29'),(409,'App\\Models\\User',2,'refresh','eadcf9aa132da8bc685d3b1d0c99d18797c987f007d5abf5bb2c899ae795bc5f','[\"*\"]',NULL,'2025-12-15 16:56:39','2025-11-15 16:56:39','2025-11-15 16:56:39'),(411,'App\\Models\\User',2,'refresh','ad6558fb44eb1ac2d330b9ecb4f10a85651d285c1b575e8bd0c0ba7e61f1b78f','[\"*\"]',NULL,'2025-12-15 17:02:25','2025-11-15 17:02:25','2025-11-15 17:02:25'),(413,'App\\Models\\User',2,'refresh','3d1a4acd53703128dbe303d98d1b0929a8a946cd5a443cd8ed98876a17b627eb','[\"*\"]',NULL,'2025-12-15 17:05:32','2025-11-15 17:05:32','2025-11-15 17:05:32'),(415,'App\\Models\\User',2,'refresh','aaef99db8e0774bf89ae26e69c77783883073e11630ba9203afe394e09dbd603','[\"*\"]',NULL,'2025-12-17 04:06:06','2025-11-17 04:06:06','2025-11-17 04:06:06'),(417,'App\\Models\\User',2,'refresh','3f468251d54e77c8159c1ac7bf0ae57166a5957ac4b80049420c1790a5d75e62','[\"*\"]',NULL,'2025-12-17 04:22:05','2025-11-17 04:22:05','2025-11-17 04:22:05'),(419,'App\\Models\\User',2,'refresh','bb83d64e592324594b7b43e4e075926fdf9cf4cbe448b8ff6a149ab60928a3f8','[\"*\"]',NULL,'2025-12-17 04:31:08','2025-11-17 04:31:08','2025-11-17 04:31:08'),(421,'App\\Models\\User',2,'refresh','9940c2e6604cfaef47cbbd8f21eae2bf0645365b81c37497988121cf57a7b28d','[\"*\"]',NULL,'2025-12-17 04:33:41','2025-11-17 04:33:41','2025-11-17 04:33:41'),(423,'App\\Models\\User',2,'refresh','09c4e48289c6d913f42e9ffd317805f8a4854d4d1fb189489f2b4a590cb093c3','[\"*\"]',NULL,'2025-12-17 04:41:34','2025-11-17 04:41:34','2025-11-17 04:41:34'),(425,'App\\Models\\User',2,'refresh','42fd4e48e8194dae938b1adb129b004d63d8bc83c9344a5d03128e2012e141e1','[\"*\"]',NULL,'2025-12-17 04:45:53','2025-11-17 04:45:53','2025-11-17 04:45:53'),(427,'App\\Models\\User',2,'refresh','beb783e5bea183de96b736c0f669bd50a6b1955ef346b215722fae9ebbff9683','[\"*\"]',NULL,'2025-12-17 04:54:17','2025-11-17 04:54:17','2025-11-17 04:54:17'),(429,'App\\Models\\User',2,'refresh','c99aa015ef14b792b8e4c1276a68bea1f06d63deb0e8bc26a2d8552bf600cab6','[\"*\"]',NULL,'2025-12-17 04:56:04','2025-11-17 04:56:04','2025-11-17 04:56:04'),(431,'App\\Models\\User',2,'refresh','74042db57a4b466bd31234d7f47d7d561ebfc543aea2f3dabd789c6a04a5c279','[\"*\"]',NULL,'2025-12-17 04:58:13','2025-11-17 04:58:13','2025-11-17 04:58:13'),(433,'App\\Models\\User',2,'refresh','70192240528265094ce8ca6c14bf8d514918f6f9d692e3c2cd14dc631ebc9e5e','[\"*\"]',NULL,'2025-12-17 04:58:27','2025-11-17 04:58:27','2025-11-17 04:58:27'),(435,'App\\Models\\User',2,'refresh','2adefa67ebfcf9404739d30f5cc687493b227fb87247eaa13bac63d5f08b1ec0','[\"*\"]',NULL,'2025-12-17 05:27:06','2025-11-17 05:27:06','2025-11-17 05:27:06'),(437,'App\\Models\\User',2,'refresh','749a08f2bb68d0d648b853c399e834fbb0adc9c0913fcd5886751f3082c9b1ac','[\"*\"]',NULL,'2025-12-17 05:27:37','2025-11-17 05:27:37','2025-11-17 05:27:37'),(439,'App\\Models\\User',2,'refresh','ddd972cd5aa9e4d83625b997f81bdae4291ef4b7a876f3d7ccf6b52213379bc1','[\"*\"]',NULL,'2025-12-17 05:33:00','2025-11-17 05:33:00','2025-11-17 05:33:00'),(441,'App\\Models\\User',2,'refresh','0b8bfb5d82e3821c4910388b25cc855c2d85c6317d542f98ac205adeaa5365f3','[\"*\"]',NULL,'2025-12-17 05:50:43','2025-11-17 05:50:43','2025-11-17 05:50:43'),(443,'App\\Models\\User',2,'refresh','63eea6ec2e1116fc0c7cac4b4e5dbacae9219bd9514baf6e8a9f602630df3fe9','[\"*\"]',NULL,'2025-12-17 06:06:14','2025-11-17 06:06:14','2025-11-17 06:06:14'),(445,'App\\Models\\User',2,'refresh','48f2c5aab1834cfd5aa6b6bb47769980cc25fbd7a56d83a1fdcd7a528a702a8d','[\"*\"]',NULL,'2025-12-17 06:07:37','2025-11-17 06:07:37','2025-11-17 06:07:37'),(447,'App\\Models\\User',2,'refresh','e4bbf64382a2c8789dffead1ccee51338cfb08ed48ea907f647b819fced8a78c','[\"*\"]',NULL,'2025-12-17 06:12:37','2025-11-17 06:12:37','2025-11-17 06:12:37'),(449,'App\\Models\\User',2,'refresh','e9d5ccfcc294385b0317de0c84d8ca9a10d665e6de03e7e38a391619776254f5','[\"*\"]',NULL,'2025-12-17 06:18:48','2025-11-17 06:18:48','2025-11-17 06:18:48'),(451,'App\\Models\\User',2,'refresh','2b8576bc9efad304ff9e93d403d922dc59f6cc334209d617a08d61104a1ae912','[\"*\"]',NULL,'2025-12-17 06:29:21','2025-11-17 06:29:21','2025-11-17 06:29:21'),(453,'App\\Models\\User',2,'refresh','1d9c6c267cd763d8123466fe09236f00253c802a7a9ef61e0219944e1b7ba898','[\"*\"]',NULL,'2025-12-17 06:47:15','2025-11-17 06:47:15','2025-11-17 06:47:15'),(455,'App\\Models\\User',2,'refresh','4afa296b8cc53dd20c433d622665cd4c49bd6dcec3c5894c2757d0419cb00bf8','[\"*\"]',NULL,'2025-12-17 06:49:23','2025-11-17 06:49:23','2025-11-17 06:49:23'),(457,'App\\Models\\User',2,'refresh','44c4f5442939f215f12fa9f5878296c7071feb3d704f1c667d6633e2f9a28b24','[\"*\"]',NULL,'2025-12-17 06:53:32','2025-11-17 06:53:32','2025-11-17 06:53:32'),(459,'App\\Models\\User',2,'refresh','8908c835840982a6b779082526628d18e98b68dd46791641cce3aa7a5838b946','[\"*\"]',NULL,'2025-12-17 07:27:42','2025-11-17 07:27:42','2025-11-17 07:27:42'),(461,'App\\Models\\User',2,'refresh','a5986e1400d059881ef341169d05a80751100f45881a54f75aafbe712ae008c9','[\"*\"]',NULL,'2025-12-17 07:35:56','2025-11-17 07:35:56','2025-11-17 07:35:56'),(463,'App\\Models\\User',2,'refresh','56c32ab7ead66c6e69fef23a82f8a34faf2bac44dccefae2f04abbee41ea1b4f','[\"*\"]',NULL,'2025-12-17 08:00:03','2025-11-17 08:00:03','2025-11-17 08:00:03'),(465,'App\\Models\\User',2,'refresh','6bc96986d948688b651e97875395a93d1a4701d768b950191b1b3b69c14fb286','[\"*\"]',NULL,'2025-12-17 09:05:34','2025-11-17 09:05:34','2025-11-17 09:05:34'),(467,'App\\Models\\User',2,'refresh','5f4c3448be39c68ef53f4348632b9c8cf948deab028370c0874a3ab82561d41f','[\"*\"]',NULL,'2025-12-17 09:39:31','2025-11-17 09:39:31','2025-11-17 09:39:31'),(469,'App\\Models\\User',2,'refresh','6e8d85b92b38d28f9340b915ca9e7266951cf9f2c257bae332f700eedd57c1ae','[\"*\"]',NULL,'2025-12-17 09:45:01','2025-11-17 09:45:01','2025-11-17 09:45:01'),(471,'App\\Models\\User',2,'refresh','3c8c31f1a5ed3a722d3dd7d9ef9e09764ee9f742d9d66a0cac4c9aa66bc20a0f','[\"*\"]',NULL,'2025-12-17 10:17:41','2025-11-17 10:17:41','2025-11-17 10:17:41'),(473,'App\\Models\\User',2,'refresh','465849aee0266682ca3186f4fbe40fa4ee3516ac497facaac92ce4980d462a8a','[\"*\"]','2025-11-17 10:19:25','2025-12-17 10:18:22','2025-11-17 10:18:22','2025-11-17 10:19:25'),(476,'App\\Models\\User',2,'refresh','e39d6b126e1a14a08b8481a5f8098fddb9ce78728845932f5726bd410c6d1c13','[\"*\"]',NULL,'2025-12-17 10:21:37','2025-11-17 10:21:37','2025-11-17 10:21:37'),(478,'App\\Models\\User',2,'refresh','e3a23b88d794dd727eb8cae563012465a33b6c0e4313ee264936061c3b3b1c51','[\"*\"]',NULL,'2025-12-17 10:25:50','2025-11-17 10:25:50','2025-11-17 10:25:50'),(480,'App\\Models\\User',2,'refresh','7006c361fb2f04710299d45cb49840f53f825ebd00dc6f4400f85fac1124155f','[\"*\"]',NULL,'2025-12-17 10:38:19','2025-11-17 10:38:19','2025-11-17 10:38:19'),(482,'App\\Models\\User',2,'refresh','bfcfab1f228452ec993131994e503c054c3bfe6b4981dd3de1a080d014ffb2d2','[\"*\"]',NULL,'2025-12-17 10:39:20','2025-11-17 10:39:20','2025-11-17 10:39:20'),(484,'App\\Models\\User',2,'refresh','a4f6c68fe635ebd3554f36b2ba0874151d86160abebdcbb83690cbfbce93c6d3','[\"*\"]',NULL,'2025-12-17 10:39:55','2025-11-17 10:39:55','2025-11-17 10:39:55'),(486,'App\\Models\\User',2,'refresh','d3ce3fa611b6fe0cf33bc6a62e3fdb6f5a80138a019ffcff95e2d31a4c6c9a02','[\"*\"]',NULL,'2025-12-17 10:48:10','2025-11-17 10:48:10','2025-11-17 10:48:10'),(488,'App\\Models\\User',2,'refresh','26ab346621deeb411255dcd0123290ae4e6e6dfa94c931953715302eff5cc5c7','[\"*\"]',NULL,'2025-12-17 10:54:12','2025-11-17 10:54:12','2025-11-17 10:54:12'),(490,'App\\Models\\User',2,'refresh','3289d6b3ba4bc47a6743b5b34640da2c81e1355cd915b649b0a27955dafa61d7','[\"*\"]',NULL,'2025-12-17 10:57:37','2025-11-17 10:57:37','2025-11-17 10:57:37'),(492,'App\\Models\\User',2,'refresh','60c83dc0a0102c54a86cbd0c748f8707c74b29ffe44e3f5908a5d3db5c01a915','[\"*\"]',NULL,'2025-12-17 11:02:34','2025-11-17 11:02:34','2025-11-17 11:02:34'),(494,'App\\Models\\User',2,'refresh','92c5ae548be6a79db17a5e2472cb0d1281a048ad01a0f3de99c40d417aec19b0','[\"*\"]',NULL,'2025-12-17 11:23:52','2025-11-17 11:23:52','2025-11-17 11:23:52'),(496,'App\\Models\\User',2,'refresh','3b1df8ac9fe22468b94dab26cd68757ce4961442740991e18af050d0b4ee1452','[\"*\"]',NULL,'2025-12-17 11:38:24','2025-11-17 11:38:24','2025-11-17 11:38:24'),(498,'App\\Models\\User',2,'refresh','f750f0bbeb2727b57ea7a3521b285506fc5f33b32f56db167b1a29f41a883693','[\"*\"]',NULL,'2025-12-17 11:50:31','2025-11-17 11:50:31','2025-11-17 11:50:31'),(500,'App\\Models\\User',2,'refresh','00ace1baab4b5f0513ac71be4af81df1bea73587ad93dae141a6c28afeccdb96','[\"*\"]',NULL,'2025-12-17 11:52:41','2025-11-17 11:52:41','2025-11-17 11:52:41'),(502,'App\\Models\\User',2,'refresh','f5b3e3b18ea6470d27b448b0dc8e21954bd8a3b2b2a3858387bf66ed2dc7d419','[\"*\"]',NULL,'2025-12-17 11:52:47','2025-11-17 11:52:47','2025-11-17 11:52:47'),(504,'App\\Models\\User',2,'refresh','ee5c665988fc95534160290fe8c564785f2d2fc96e5532f5281d151d60af053f','[\"*\"]',NULL,'2025-12-17 12:11:27','2025-11-17 12:11:27','2025-11-17 12:11:27'),(506,'App\\Models\\User',2,'refresh','91d879c53f686167186a36e47fcf92f16ee55984da7a6da369e2debe75589ad1','[\"*\"]',NULL,'2025-12-17 12:32:27','2025-11-17 12:32:27','2025-11-17 12:32:27'),(508,'App\\Models\\User',2,'refresh','30ab9316a23e012bd2700cec32ee3021c37b362a0252c58a989655bfc64287ef','[\"*\"]',NULL,'2025-12-17 12:38:50','2025-11-17 12:38:50','2025-11-17 12:38:50'),(510,'App\\Models\\User',2,'refresh','7372a0701d81ad8f4ec9423145879dad625b35859712490efd7bd3436a5e70ea','[\"*\"]',NULL,'2025-12-17 12:44:07','2025-11-17 12:44:07','2025-11-17 12:44:07'),(512,'App\\Models\\User',2,'refresh','884390c8bfe58e9e7a92b54b5116b1eb042243c6a427e5792b88aeca84993f3e','[\"*\"]',NULL,'2025-12-17 13:01:12','2025-11-17 13:01:12','2025-11-17 13:01:12'),(514,'App\\Models\\User',2,'refresh','4d473d796db02ff6022633f5f19d5534ecacd8e5cebcad66f5db1ba9279f6dac','[\"*\"]',NULL,'2025-12-17 13:12:37','2025-11-17 13:12:37','2025-11-17 13:12:37'),(516,'App\\Models\\User',2,'refresh','0b0233440bb27ffb6a16fd2669dd32ba0e0edd5a2e9a1eff8bfa4aa37500c97d','[\"*\"]',NULL,'2025-12-17 13:19:48','2025-11-17 13:19:48','2025-11-17 13:19:48'),(518,'App\\Models\\User',2,'refresh','75b0479281cf5156d6475ca628032a7840322139437c841abfa09193823f19d4','[\"*\"]',NULL,'2025-12-17 13:23:51','2025-11-17 13:23:51','2025-11-17 13:23:51'),(520,'App\\Models\\User',2,'refresh','47353c9ccd4b9b928b9e4e14b8575162816c28f7adea51cf232e8bfcf7a2376e','[\"*\"]',NULL,'2025-12-17 13:26:32','2025-11-17 13:26:32','2025-11-17 13:26:32'),(522,'App\\Models\\User',2,'refresh','d9658e7037a962e67c5b76e1f028c2b42e4b401627ccee7ef08a5b31e90c5081','[\"*\"]',NULL,'2025-12-17 13:29:01','2025-11-17 13:29:01','2025-11-17 13:29:01'),(524,'App\\Models\\User',2,'refresh','e199af1c17b2eb1225a5d73446f15b62e54dd89587d6bf33b2bdd58f86fe5255','[\"*\"]',NULL,'2025-12-17 13:34:17','2025-11-17 13:34:17','2025-11-17 13:34:17'),(526,'App\\Models\\User',2,'refresh','74730612ac9f1b5c19913e0ecd5dff7cb580488a2ade54f24c7bb422dbeaed7e','[\"*\"]',NULL,'2025-12-17 13:35:32','2025-11-17 13:35:32','2025-11-17 13:35:32'),(528,'App\\Models\\User',2,'refresh','8f8db35548b20ecad49f06abe9cc61b0d2156fcb26dde2d43f1bdd2f0c22a682','[\"*\"]',NULL,'2025-12-17 13:38:11','2025-11-17 13:38:11','2025-11-17 13:38:11'),(530,'App\\Models\\User',2,'refresh','6a617adde503497a6facdeab7dbabd238f5f31d4da4fdd1613517faa8c5eb18c','[\"*\"]',NULL,'2025-12-18 04:43:04','2025-11-18 04:43:04','2025-11-18 04:43:04'),(532,'App\\Models\\User',2,'refresh','b03780f9dbe4e1d265c3aab0b836302b9bcb26ae2fa267fb2bcb0c2ef125f11c','[\"*\"]',NULL,'2025-12-18 04:46:46','2025-11-18 04:46:46','2025-11-18 04:46:46'),(534,'App\\Models\\User',2,'refresh','56e8bdcdd1a2a905116cfadf2b0d2b56beb6e929396fe3046f562fa5d7648744','[\"*\"]',NULL,'2025-12-18 04:55:57','2025-11-18 04:55:57','2025-11-18 04:55:57'),(536,'App\\Models\\User',2,'refresh','0a0aab5f9f3e517f62f4a5d24411ddfa4145e1e06947783c2f0df1be865e6c23','[\"*\"]',NULL,'2025-12-18 04:57:20','2025-11-18 04:57:20','2025-11-18 04:57:20'),(538,'App\\Models\\User',2,'refresh','460eef8978b38cc639271c8fe6c9daf7762de1bff6307ed1fb5b11d555433c06','[\"*\"]',NULL,'2025-12-18 05:09:34','2025-11-18 05:09:34','2025-11-18 05:09:34'),(540,'App\\Models\\User',2,'refresh','8b0f08228fc427ab72a4809d12cc6f3c1220135d386bf1ed76c8cbe32c95252a','[\"*\"]',NULL,'2025-12-18 05:17:17','2025-11-18 05:17:17','2025-11-18 05:17:17'),(542,'App\\Models\\User',2,'refresh','c44f615d1322de4604c4a54235c27e41e927cf8757a23eee80e2b3d340dd0268','[\"*\"]',NULL,'2025-12-18 05:19:20','2025-11-18 05:19:20','2025-11-18 05:19:20'),(544,'App\\Models\\User',2,'refresh','8d42d03e23652e4d2e6b4034626d5bdf93e9ca66c1ac002e075f944ff8bb482d','[\"*\"]',NULL,'2025-12-18 05:49:19','2025-11-18 05:49:19','2025-11-18 05:49:19'),(546,'App\\Models\\User',2,'refresh','e268da37f957c3871461d74fc0cd9637fa2ecb3ee2c62ed9c05f279d45dc0658','[\"*\"]',NULL,'2025-12-18 05:51:08','2025-11-18 05:51:08','2025-11-18 05:51:08'),(548,'App\\Models\\User',2,'refresh','4c0953b0e29dd810dfcdfa3880b9ab9f8778d2ad57e3afdab9926907a328b82e','[\"*\"]',NULL,'2025-12-18 05:52:10','2025-11-18 05:52:10','2025-11-18 05:52:10'),(550,'App\\Models\\User',2,'refresh','bf8d4c5cad110c5cf43ea7c07141f79f6bbf19f75eea0c8d3d15f77aa885dbb2','[\"*\"]',NULL,'2025-12-18 06:06:43','2025-11-18 06:06:43','2025-11-18 06:06:43'),(552,'App\\Models\\User',2,'refresh','4028495d1446e9aeb38d635ba851f4297cb51d3ae4d33f6ccf96422a9aa7e176','[\"*\"]',NULL,'2025-12-18 06:07:31','2025-11-18 06:07:31','2025-11-18 06:07:31'),(554,'App\\Models\\User',2,'refresh','02ee84afcb811ca48ea7f0b7180bd740baf348f763f83ee239ffee37551c46dc','[\"*\"]',NULL,'2025-12-18 06:08:03','2025-11-18 06:08:03','2025-11-18 06:08:03'),(556,'App\\Models\\User',2,'refresh','fc354281bec1bf8fe583ecff95c3e0a5b573ecfa382ac4bad2326b008bb8eb71','[\"*\"]',NULL,'2025-12-18 06:12:43','2025-11-18 06:12:43','2025-11-18 06:12:43'),(558,'App\\Models\\User',2,'refresh','de741c2aed961f7086fe17782469f7aad4000e528945c7d34a61b4ec3f9bad01','[\"*\"]',NULL,'2025-12-18 06:16:07','2025-11-18 06:16:07','2025-11-18 06:16:07'),(560,'App\\Models\\User',2,'refresh','b4cc3a92b1b0ef0d688463e0a98d68408efff890189d34cdf1e2332345876756','[\"*\"]',NULL,'2025-12-18 06:22:36','2025-11-18 06:22:36','2025-11-18 06:22:36'),(562,'App\\Models\\User',2,'refresh','c107f950e6ee7c2c4cb75b47878c9819a81fff77a1b607522ab3a3a41dbe1b9a','[\"*\"]',NULL,'2025-12-18 06:23:06','2025-11-18 06:23:06','2025-11-18 06:23:06'),(564,'App\\Models\\User',2,'refresh','37ce201cc2b32ac8894b4e8b6b57a2b2ee406d83b606ced5744237edf42f40c2','[\"*\"]',NULL,'2025-12-18 06:25:12','2025-11-18 06:25:12','2025-11-18 06:25:12'),(566,'App\\Models\\User',2,'refresh','42d5d17e70b550986fd56aa0f0309cb96e12f69ad2644691f92313cafe95b0f0','[\"*\"]',NULL,'2025-12-18 06:36:47','2025-11-18 06:36:47','2025-11-18 06:36:47'),(568,'App\\Models\\User',2,'refresh','3128984379799f0ddcb2a795cdcab0b5671e806ee42abad1ceb40ab19a17d99e','[\"*\"]',NULL,'2025-12-18 06:37:27','2025-11-18 06:37:27','2025-11-18 06:37:27'),(570,'App\\Models\\User',2,'refresh','965d140f4b844d5d4c409d8a4c6a13f1abb20b1107d7ad8492982550aff16c2f','[\"*\"]',NULL,'2025-12-18 07:25:04','2025-11-18 07:25:04','2025-11-18 07:25:04'),(571,'App\\Models\\User',13,'access','e0d39696389deae5b094b359438b6f20db112f079a8d6100e77340cb68e43274','[\"*\"]','2025-11-18 07:52:32','2025-11-18 08:49:19','2025-11-18 07:49:19','2025-11-18 07:52:32'),(572,'App\\Models\\User',13,'refresh','cb49c3b02dffbea6fc306725867750e50025d1e2709c2a32345002ef71031a4a','[\"*\"]',NULL,'2025-12-18 07:49:19','2025-11-18 07:49:19','2025-11-18 07:49:19'),(574,'App\\Models\\User',2,'refresh','1dda669726249269ed8cb07523dda8bd83c75e3c4aeb6cceff477a3dd813b07b','[\"*\"]',NULL,'2025-12-18 07:52:57','2025-11-18 07:52:57','2025-11-18 07:52:57'),(576,'App\\Models\\User',2,'refresh','434e987ba4dc7ca4b8ca880dced421be3b14aaaa2447f053848aab515d378457','[\"*\"]',NULL,'2025-12-18 10:46:43','2025-11-18 10:46:43','2025-11-18 10:46:43'),(578,'App\\Models\\User',2,'refresh','8c829dbdd43e67a850231e31e701f4a0c51810a3211708b61bbfc7aaa4b1c639','[\"*\"]',NULL,'2025-12-18 10:52:46','2025-11-18 10:52:46','2025-11-18 10:52:46'),(580,'App\\Models\\User',2,'refresh','d9eb0e86e019dfaa3523cb82caf6f60d431720c1e05ccf5410a43fcdc2ad6e57','[\"*\"]',NULL,'2025-12-26 08:00:03','2025-11-26 08:00:03','2025-11-26 08:00:03'),(582,'App\\Models\\User',2,'refresh','8af81ab3a2a98134c82496ab92cc6623d2098bdba812d3226ff5342198c01e28','[\"*\"]',NULL,'2025-12-26 08:09:03','2025-11-26 08:09:03','2025-11-26 08:09:03'),(584,'App\\Models\\User',2,'refresh','43b8daa9114e1e50ce17ea1cbe9610c953f1ded8a8f4a4ca1a100f08791edbf7','[\"*\"]',NULL,'2025-12-26 12:28:24','2025-11-26 12:28:24','2025-11-26 12:28:24'),(586,'App\\Models\\User',2,'refresh','1c17a540d161584e8176fa82a8ac3ec21f031c3049cd1567064515d82a591ccc','[\"*\"]',NULL,'2025-12-26 12:51:54','2025-11-26 12:51:54','2025-11-26 12:51:54'),(588,'App\\Models\\User',2,'refresh','1cbde0b6b6b2ca65f894a8281fb538445ad90d5b3b0abf672bf14295572b7b42','[\"*\"]',NULL,'2025-12-26 13:17:48','2025-11-26 13:17:48','2025-11-26 13:17:48'),(590,'App\\Models\\User',2,'refresh','96e808d380b73148803ff001cbced4ea9750ed6522c3a984659c8d71db47d3be','[\"*\"]',NULL,'2025-12-26 13:18:10','2025-11-26 13:18:10','2025-11-26 13:18:10'),(592,'App\\Models\\User',2,'refresh','1536b75e395d47412595c147506359439bc2ec6f0087a97beea73188861a0922','[\"*\"]',NULL,'2025-12-26 13:19:14','2025-11-26 13:19:14','2025-11-26 13:19:14'),(594,'App\\Models\\User',2,'refresh','5d790133b0f448724e61cdaaa58ded3dd2714cf07f5dc74383aa9e4e7ea7cd51','[\"*\"]',NULL,'2025-12-26 13:25:49','2025-11-26 13:25:49','2025-11-26 13:25:49'),(596,'App\\Models\\User',2,'refresh','3e7a41dc7444671b05e737e9702c0d0236a2f54db5e5a10f6df6c9c66b8d23cf','[\"*\"]',NULL,'2025-12-26 13:37:04','2025-11-26 13:37:04','2025-11-26 13:37:04'),(598,'App\\Models\\User',2,'refresh','31bd34f3dcea5255c2d593c901ba3e196f4dc1d9664ffff391e60327e18db5bf','[\"*\"]',NULL,'2026-01-10 07:58:19','2025-12-11 07:58:19','2025-12-11 07:58:19'),(600,'App\\Models\\User',2,'refresh','ca4954312bd1532fa357fc4b28859a508178461ebf1b724040719ab4675dcf03','[\"*\"]',NULL,'2026-01-10 09:44:04','2025-12-11 09:44:04','2025-12-11 09:44:04'),(602,'App\\Models\\User',2,'refresh','49911b2da4e225681e93c28b5149335481077136e3d130ceb791586592df3b96','[\"*\"]',NULL,'2026-01-10 10:45:42','2025-12-11 10:45:42','2025-12-11 10:45:42'),(604,'App\\Models\\User',2,'refresh','8b841e7f48c314122fc5292059a9443965ad673b11d5573219f0607ed42d99f3','[\"*\"]',NULL,'2026-01-10 11:49:56','2025-12-11 11:49:56','2025-12-11 11:49:56'),(606,'App\\Models\\User',2,'refresh','2ba243fb132a21e5bf075afd77f10f30ea03e7f4ab56f91817ec97db23e8f5cd','[\"*\"]',NULL,'2026-01-10 13:08:15','2025-12-11 13:08:15','2025-12-11 13:08:15'),(608,'App\\Models\\User',2,'refresh','46af93a18f4b62e51ecd51f269a91f441f48cbd8116ef6291b44fac3809bb4c1','[\"*\"]',NULL,'2026-01-11 06:57:18','2025-12-12 06:57:18','2025-12-12 06:57:18'),(610,'App\\Models\\User',2,'refresh','6390b615aabd7f2fd987703b9068159b455383b8f5faa59eff6ee6dcadcb10b7','[\"*\"]',NULL,'2026-01-11 08:13:03','2025-12-12 08:13:03','2025-12-12 08:13:03'),(612,'App\\Models\\User',2,'refresh','feb3766772026bc165ed56379b55fba3e2d4984661838b3603db02405608ed42','[\"*\"]',NULL,'2026-01-11 09:14:35','2025-12-12 09:14:35','2025-12-12 09:14:35'),(613,'App\\Models\\User',2,'access','5a3a90e228e554e1b099d0ae650e6ba2d68cb55389c5cc0231ca20213caf2906','[\"*\"]','2025-12-12 11:54:01','2025-12-12 12:50:11','2025-12-12 11:50:11','2025-12-12 11:54:01'),(614,'App\\Models\\User',2,'refresh','950ffb69e9ab5f706a6a8f8749e2453a5c213605c4440f1649d1d107d95f52ba','[\"*\"]',NULL,'2026-01-11 11:50:11','2025-12-12 11:50:11','2025-12-12 11:50:11');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` int unsigned NOT NULL,
  `role_id` int unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(83,1),(84,1),(85,1),(86,1),(87,1),(88,1),(89,1),(90,1),(91,1),(92,1),(93,1),(94,1),(95,1),(96,1),(97,1),(98,1),(99,1),(100,1),(101,1),(102,1),(103,1),(104,1),(105,1),(106,1),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(113,1),(114,1),(115,1),(116,1),(117,1),(118,1),(119,1),(120,1),(121,1),(122,1),(123,1),(124,1),(125,1),(126,1),(127,1),(128,1),(129,1),(130,1),(131,1),(132,1),(133,1),(134,1),(135,1),(136,1),(137,1),(138,1),(139,1),(140,1),(141,1),(145,1),(146,1),(147,1),(148,1),(149,1),(150,1),(151,1),(152,1),(153,1),(154,1),(155,1),(156,1),(157,1),(158,1),(159,1),(160,1),(161,1),(162,1),(163,1),(164,1),(165,1),(166,1),(167,1),(168,1),(169,1),(170,1),(172,1),(173,1),(174,1),(175,1),(176,1),(177,1),(178,1),(179,1),(180,1),(181,1),(182,1),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(18,2),(19,2),(20,2),(21,2),(22,2),(23,2),(24,2),(25,2),(26,2),(27,2),(28,2),(29,2),(30,2),(31,2),(32,2),(33,2),(34,2),(35,2),(36,2),(37,2),(38,2),(39,2),(40,2),(41,2),(42,2),(43,2),(44,2),(45,2),(46,2),(47,2),(48,2),(49,2),(50,2),(51,2),(52,2),(53,2),(54,2),(55,2),(56,2),(57,2),(58,2),(59,2),(60,2),(61,2),(62,2),(63,2),(64,2),(65,2),(66,2),(67,2),(68,2),(69,2),(70,2),(71,2),(72,2),(73,2),(74,2),(75,2),(76,2),(77,2),(78,2),(79,2),(80,2),(81,2),(82,2),(83,2),(84,2),(85,2),(86,2),(87,2),(88,2),(89,2),(90,2),(91,2),(92,2),(93,2),(94,2),(95,2),(96,2),(97,2),(98,2),(99,2),(100,2),(101,2),(102,2),(103,2),(104,2),(105,2),(106,2),(107,2),(108,2),(109,2),(110,2),(111,2),(112,2),(113,2),(114,2),(115,2),(116,2),(117,2),(118,2),(119,2),(120,2),(121,2),(122,2),(123,2),(124,2),(125,2),(126,2),(127,2),(128,2),(129,2),(130,2),(131,2),(132,2),(133,2),(134,2),(135,2),(136,2),(137,2),(138,2),(139,2),(141,2),(4,4),(6,4),(7,4),(8,4),(9,4),(12,4),(13,4),(14,4),(20,4),(21,4),(22,4),(24,4),(25,4),(28,4),(29,4),(55,4),(56,4),(57,4),(63,4),(64,4),(89,4),(106,4),(4,9),(5,9),(6,9),(7,9),(8,9),(9,9),(10,9),(11,9),(12,9),(13,9),(14,9),(15,9),(16,9),(17,9),(18,9),(19,9),(24,9),(25,9),(26,9),(27,9),(28,9),(29,9),(30,9),(31,9),(32,9),(33,9),(34,9),(35,9),(38,9),(41,9),(42,9),(43,9),(44,9),(46,9),(47,9),(48,9),(49,9),(50,9),(51,9),(52,9),(53,9),(59,9),(61,9),(63,9),(64,9),(65,9),(66,9),(82,9),(85,9),(86,9),(90,9),(91,9),(92,9),(93,9),(94,9),(95,9),(96,9),(98,9),(100,9),(103,9),(105,9),(106,9),(107,9),(108,9),(109,9),(110,9),(111,9),(112,9),(113,9),(114,9),(115,9),(116,9),(117,9),(118,9),(119,9),(120,9),(121,9),(122,9),(135,9),(138,9),(141,9),(151,9),(153,9),(154,9),(155,9),(156,9),(157,9),(160,9),(161,9),(162,9),(163,9),(169,9),(170,9);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bus_config_id` int NOT NULL,
  `role_type` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Admin, 2=Owner, 3=Staff, 4=Customer',
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','admin can access all data...','web',1,'1',1,'2018-06-01 23:46:44','2018-06-02 23:13:05'),(2,'Owner','Staff of shop','web',1,'2',1,'2018-10-22 02:38:13','2022-02-01 13:13:30'),(4,'staff','staff has specific acess...','web',1,'3',1,'2018-06-02 00:05:27','2022-02-01 13:13:04'),(5,'Customer','customer','web',1,'4',1,'2020-11-05 06:43:16','2026-01-09 05:15:51'),(9,'Sub Admin',NULL,'web',1,'3',1,'2026-01-13 11:07:18','2026-01-22 12:30:48');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sandbox_scenarios`
--

DROP TABLE IF EXISTS `sandbox_scenarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sandbox_scenarios` (
  `scenario_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `scenario_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `scenario_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`scenario_id`),
  UNIQUE KEY `sandbox_scenarios_scenario_code_unique` (`scenario_code`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sandbox_scenarios`
--

LOCK TABLES `sandbox_scenarios` WRITE;
/*!40000 ALTER TABLE `sandbox_scenarios` DISABLE KEYS */;
INSERT INTO `sandbox_scenarios` VALUES (1,'SN001','Goods at standard rate to registered buyers','Goods at standard rate (default)',NULL,NULL),(2,'SN002','Goods at standard rate to unregistered buyers','Goods at standard rate (default)',NULL,NULL),(3,'SN003','Sale of Steel (Melted and Re-Rolled)','Steel Melting and re-rolling',NULL,NULL),(4,'SN004','Sale by Ship Breakers','Ship breaking',NULL,NULL),(5,'SN005','Reduced rate sale','Goods at Reduced Rate',NULL,NULL),(6,'SN006','Exempt goods sale','Exempt Goods',NULL,NULL),(7,'SN007','Zero rated sale','Goods at zero-rate',NULL,NULL),(8,'SN008','Sale of 3rd schedule goods','3rd Schedule Goods',NULL,NULL),(9,'SN009','Cotton Spinners purchase from Cotton Ginners (Textile Sector)','Cotton Ginners',NULL,NULL),(10,'SN010','Mobile Operators adds Sale (Telecom Sector)','Telecommunication services',NULL,NULL),(11,'SN011','Toll Manufacturing sale by Steel sector','Toll Manufacturing',NULL,NULL),(12,'SN012','Sale of Petroleum products','Petroleum Products',NULL,NULL),(13,'SN013','Electricity Supply to Retailers','Electricity Supply to Retailers',NULL,NULL),(14,'SN014','Sale of Gas to CNG stations','Gas to CNG stations',NULL,NULL),(15,'SN015','Sale of mobile phones','Mobile Phones',NULL,NULL),(16,'SN016','Processing / Conversion of Goods','Processing/ Conversion of Goods',NULL,NULL),(17,'SN017','Sale of Goods where FED is charged in ST mode','Goods (FED in ST Mode)',NULL,NULL),(18,'SN018','Sale of Services where FED is charged in ST mode','Services (FED in ST Mode)',NULL,NULL),(19,'SN019','Sale of Services','Services',NULL,NULL),(20,'SN020','Sale of Electric Vehicles','Electric Vehicle',NULL,NULL),(21,'SN021','Sale of Cement /Concrete Block','Cement /Concrete Block',NULL,NULL),(22,'SN022','Sale of Potassium Chlorate','Potassium Chlorate',NULL,NULL),(23,'SN023','Sale of CNG','CNG Sales',NULL,NULL),(24,'SN024','Goods sold that are listed in SRO 297(1)/2023','Goods as per SRO.297(1)/2023',NULL,NULL),(25,'SN025','Drugs sold at fixed ST rate under serial 81 of Eighth Schedule Table 1','Non-Adjustable Supplies',NULL,NULL),(26,'SN026','Sale to End Consumer by retailers','Goods at Standard Rate (default)',NULL,NULL),(27,'SN027','Sale to End Consumer by retailers','3rd Schedule Goods',NULL,NULL),(28,'SN028','Sale to End Consumer by retailers','Goods at Reduced Rate',NULL,NULL);
/*!40000 ALTER TABLE `sandbox_scenarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('FTTTfcMkuybBlCiaHN8FklInKzRm4NOzHl3EJR80',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','YToxMzp7czo2OiJfdG9rZW4iO3M6NDA6Ikl5VlBaR0RyS3FEakFwYXNxcmZON2ZHRFdWZlV5SVRZTVFPMzZiQjMiO3M6MzoidXJsIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xlZGdlciI7czo1OiJyb3V0ZSI7czoxMjoibGVkZ2VyLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6InRlbmFudF9pZCI7aToxO3M6MTM6ImJ1c19jb25maWdfaWQiO2k6MTtzOjk6InRlbmFudF9kYiI7czoxMDoidGF4X2JyaWRnZSI7czo4OiJidXNfbmFtZSI7czoxNzoiU2VjdXJlaXNtIFB2dCBMdGQiO3M6ODoiaXNfdHJpYWwiO2k6MDtzOjE0OiJ0cmlhbF9lbmRfZGF0ZSI7TjtzOjEwOiJzdGFydF9kYXRlIjtzOjEwOiIyMDI1LTEyLTE4IjtzOjg6ImVuZF9kYXRlIjtzOjEwOiIyMDI2LTAxLTE4Ijt9',1766122215);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_business`
--

DROP TABLE IF EXISTS `user_business`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_business` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `bus_config_id` bigint unsigned NOT NULL,
  `role_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_user_business` (`user_id`,`bus_config_id`),
  KEY `bus_config_id` (`bus_config_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_business_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_business_ibfk_2` FOREIGN KEY (`bus_config_id`) REFERENCES `business_configurations` (`bus_config_id`) ON DELETE CASCADE,
  CONSTRAINT `user_business_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_business`
--

LOCK TABLES `user_business` WRITE;
/*!40000 ALTER TABLE `user_business` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_business` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int NOT NULL,
  `biller_id` int DEFAULT NULL,
  `warehouse_id` int DEFAULT NULL,
  `bus_config_id` int NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@admin.com','$2y$10$D3NNYjFpxZ/7ve5fTVs.k.6cH5AfPyPC1JL7/G8NQoVcTPvt9nZoa','6vsuZOFVPW5p7RyrxZAopbpzCgBLqnSD3eqF5CaS2kMsClSmnMJl5etPufga','12112','TaxBridge',1,NULL,NULL,1,1,0,'2018-06-01 22:24:15','2026-01-14 07:16:15'),(51,'ahmedkhan','ahmedkhan@testing.com','$2y$10$5PGvZKkxTQmneVMe9qyGReBpZoFtOK5nFnVErVLtPRZ0iN7JAHP0W',NULL,'0354874874','Khan Traders',5,NULL,NULL,1,1,0,'2026-01-05 12:07:11','2026-01-05 12:07:11'),(52,'adeel123','adeel.ahmed@secureism.com','$2y$10$Xrvh.Rsw0jtnO486A8kxeexCSNS2hKJBuEyQfcapP4/XcgH8gs8ie',NULL,'03005487458','Siddique Traders',5,1,1,1,1,0,'2026-01-05 12:21:07','2026-01-14 07:12:35'),(53,'Hammad Ali','hammad.ali@f3technologies.eu','$2y$10$/OkkDRWh62tfMx22S31QX.HysehgXGg99hcGEWoqZnZMSDa57jr1q',NULL,'030012367748',NULL,9,NULL,NULL,1,1,0,'2026-01-13 12:19:17','2026-01-13 12:19:17');
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

-- Dump completed on 2026-01-22 17:38:10
