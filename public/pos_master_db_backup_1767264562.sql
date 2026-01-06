

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

INSERT INTO admins VALUES("1","Super Admin","admin@taxbridge.pk","$2y$12$PfHLRFbUZPo/CO01xWnfCeY9H20mDBTlpvQiX83JNXEdah7Ls45ay","","2025-10-24 11:14:28","2025-10-24 11:50:33");



CREATE TABLE `business_configurations` (
  `bus_config_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bus_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `db_host` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bus_ntn_cnic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bus_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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

INSERT INTO business_configurations VALUES("1","Secureism Pvt Ltd","127.0.0.1","8923980","F3 Center of Technology, Zaraj Society, Islamabad Pakistan","PUNJAB","company/1765775503.svg","SECUREISM (PRIVATE) LIMITED","0010109016750017","0119999","03001234567","ZEESHAN QAMAR","PK44ABPA0010109016750017","ABPAPKKA","ABL CHAKLALA SCHEME 3 RAWALPINDI","0757","25a88e58a92bf1aa5e3261df0c7fcee4","2025-07-04 17:02:41","2025-12-15 12:44:37","tax_bridge_pos","root","Admin","sandbox","2ebe4443-4c22-341f-8f4e-aa4002fcffcb","");
INSERT INTO business_configurations VALUES("2","Madina Cash & Carry","127.0.0.1","874587","Zarraj Society, Islamabad Pakistan","PUNJAB","company/1765775503.svg","MCC","0010454534017","0145454549","03001234567","ZEESHAN QAMAR","PK44ABPA0342234324016750017","ABPAHJJHA","UBL Zarraj","7847","25a88fsafsaf5e3261df0c7fcee4","2025-07-04 17:02:41","2025-12-15 12:44:37","madinacashandcarry","root","Admin","sandbox","2ebe4443-4c22-341f-8f4e-aa4002fcffcb","");



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

INSERT INTO business_feature_usage VALUES("9","1","5","invoices","2025-11-18","2025-12-18","30");
INSERT INTO business_feature_usage VALUES("11","1","7","invoices","2025-12-18","2026-01-18","4");



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

INSERT INTO business_package_features VALUES("9","5","invoices","monthly","50");
INSERT INTO business_package_features VALUES("10","6","invoices","monthly","50");
INSERT INTO business_package_features VALUES("11","7","invoices","monthly","50");



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

INSERT INTO business_packages VALUES("5","1","5","2025-11-18","2025-12-18","0.00","0.00","0","0","");
INSERT INTO business_packages VALUES("7","1","5","2025-12-18","2026-01-18","0.00","0.00","1","0","");



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

INSERT INTO business_scenarios VALUES("16","1","18","2025-10-07 16:04:00","2025-10-07 16:04:00");
INSERT INTO business_scenarios VALUES("38","1","19","2025-11-17 09:24:01","2025-11-17 09:24:01");



CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




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
  PRIMARY KEY (`id`),
  KEY `idx_bus_config_id` (`bus_config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO general_settings VALUES("1","1","TaxBridgePOS","tax-bridgePOS-logo.svg","","0","4","","","warehouse","no","d-m-Y","TaxBridge","standard","2","1","default.css","manufacturing","2018-07-06 11:13:11","2025-12-29 09:44:41","prefix","","days","0","0","0","Tax Bridge","98098007","1","000000","","0","0","25.00","Asia/Karachi","","","","","0","0","0");
INSERT INTO general_settings VALUES("2","2","Madina Cash & Carry","20251229044528.png","","0","4","","","warehouse","no","d-m-Y","TaxBridge","standard","2","1","default.css","manufacturing","2018-07-06 11:13:11","2025-12-29 16:45:28","prefix","","days","0","0","0","MCC","444","1","000000","","0","0","25.00","Asia/Karachi","","","","","0","0","0");



CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO migrations VALUES("3","2025_11_27_000100_create_client_ledgers_and_payments_tables","1");
INSERT INTO migrations VALUES("4","2025_11_27_000200_create_credit_notes_and_refunds_tables","2");
INSERT INTO migrations VALUES("5","2025_11_27_000300_create_payment_reminders_tables","3");
INSERT INTO migrations VALUES("9","2025_11_27_999000_add_invoice_computed_and_reminder_columns","4");



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

INSERT INTO package_features VALUES("14","5","invoices","monthly","1");



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

INSERT INTO packages VALUES("5","starter","starter","1000.00","monthly","2025-11-18 15:05:18","2025-11-18 15:05:18");



CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO password_reset_tokens VALUES("hammad.ali@f3technologies.eu","$2y$12$fjeeLDMshmzz3zQxu4sE0eRROAzjevI5S8ag0I7izmtrq.FxGhAY6","2025-11-18 12:02:52");



CREATE TABLE `permissions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permissions VALUES("4","products-edit","web","2018-06-03 06:00:09","2018-06-03 06:00:09");
INSERT INTO permissions VALUES("5","products-delete","web","2018-06-04 03:54:22","2018-06-04 03:54:22");
INSERT INTO permissions VALUES("6","products-add","web","2018-06-04 05:34:14","2018-06-04 05:34:14");
INSERT INTO permissions VALUES("7","products-index","web","2018-06-04 08:34:27","2018-06-04 08:34:27");
INSERT INTO permissions VALUES("8","purchases-index","web","2018-06-04 13:03:19","2018-06-04 13:03:19");
INSERT INTO permissions VALUES("9","purchases-add","web","2018-06-04 13:12:25","2018-06-04 13:12:25");
INSERT INTO permissions VALUES("10","purchases-edit","web","2018-06-04 14:47:36","2018-06-04 14:47:36");
INSERT INTO permissions VALUES("11","purchases-delete","web","2018-06-04 14:47:36","2018-06-04 14:47:36");
INSERT INTO permissions VALUES("12","sales-index","web","2018-06-04 15:49:08","2018-06-04 15:49:08");
INSERT INTO permissions VALUES("13","sales-add","web","2018-06-04 15:49:52","2018-06-04 15:49:52");
INSERT INTO permissions VALUES("14","sales-edit","web","2018-06-04 15:49:52","2018-06-04 15:49:52");
INSERT INTO permissions VALUES("15","sales-delete","web","2018-06-04 15:49:53","2018-06-04 15:49:53");
INSERT INTO permissions VALUES("16","quotes-index","web","2018-06-05 03:05:10","2018-06-05 03:05:10");
INSERT INTO permissions VALUES("17","quotes-add","web","2018-06-05 03:05:10","2018-06-05 03:05:10");
INSERT INTO permissions VALUES("18","quotes-edit","web","2018-06-05 03:05:10","2018-06-05 03:05:10");
INSERT INTO permissions VALUES("19","quotes-delete","web","2018-06-05 03:05:10","2018-06-05 03:05:10");
INSERT INTO permissions VALUES("20","transfers-index","web","2018-06-05 03:30:03","2018-06-05 03:30:03");
INSERT INTO permissions VALUES("21","transfers-add","web","2018-06-05 03:30:03","2018-06-05 03:30:03");
INSERT INTO permissions VALUES("22","transfers-edit","web","2018-06-05 03:30:03","2018-06-05 03:30:03");
INSERT INTO permissions VALUES("23","transfers-delete","web","2018-06-05 03:30:03","2018-06-05 03:30:03");
INSERT INTO permissions VALUES("24","returns-index","web","2018-06-05 03:50:24","2018-06-05 03:50:24");
INSERT INTO permissions VALUES("25","returns-add","web","2018-06-05 03:50:24","2018-06-05 03:50:24");
INSERT INTO permissions VALUES("26","returns-edit","web","2018-06-05 03:50:25","2018-06-05 03:50:25");
INSERT INTO permissions VALUES("27","returns-delete","web","2018-06-05 03:50:25","2018-06-05 03:50:25");
INSERT INTO permissions VALUES("28","customers-index","web","2018-06-05 04:15:54","2018-06-05 04:15:54");
INSERT INTO permissions VALUES("29","customers-add","web","2018-06-05 04:15:55","2018-06-05 04:15:55");
INSERT INTO permissions VALUES("30","customers-edit","web","2018-06-05 04:15:55","2018-06-05 04:15:55");
INSERT INTO permissions VALUES("31","customers-delete","web","2018-06-05 04:15:55","2018-06-05 04:15:55");
INSERT INTO permissions VALUES("32","suppliers-index","web","2018-06-05 04:40:12","2018-06-05 04:40:12");
INSERT INTO permissions VALUES("33","suppliers-add","web","2018-06-05 04:40:12","2018-06-05 04:40:12");
INSERT INTO permissions VALUES("34","suppliers-edit","web","2018-06-05 04:40:12","2018-06-05 04:40:12");
INSERT INTO permissions VALUES("35","suppliers-delete","web","2018-06-05 04:40:12","2018-06-05 04:40:12");
INSERT INTO permissions VALUES("36","product-report","web","2018-06-25 04:05:33","2018-06-25 04:05:33");
INSERT INTO permissions VALUES("37","purchase-report","web","2018-06-25 04:24:56","2018-06-25 04:24:56");
INSERT INTO permissions VALUES("38","sale-report","web","2018-06-25 04:33:13","2018-06-25 04:33:13");
INSERT INTO permissions VALUES("39","customer-report","web","2018-06-25 04:36:51","2018-06-25 04:36:51");
INSERT INTO permissions VALUES("40","due-report","web","2018-06-25 04:39:52","2018-06-25 04:39:52");
INSERT INTO permissions VALUES("41","users-index","web","2018-06-25 05:00:10","2018-06-25 05:00:10");
INSERT INTO permissions VALUES("42","users-add","web","2018-06-25 05:00:10","2018-06-25 05:00:10");
INSERT INTO permissions VALUES("43","users-edit","web","2018-06-25 05:01:30","2018-06-25 05:01:30");
INSERT INTO permissions VALUES("44","users-delete","web","2018-06-25 05:01:30","2018-06-25 05:01:30");
INSERT INTO permissions VALUES("45","profit-loss","web","2018-07-15 02:50:05","2018-07-15 02:50:05");
INSERT INTO permissions VALUES("46","best-seller","web","2018-07-15 03:01:38","2018-07-15 03:01:38");
INSERT INTO permissions VALUES("47","daily-sale","web","2018-07-15 03:24:21","2018-07-15 03:24:21");
INSERT INTO permissions VALUES("48","monthly-sale","web","2018-07-15 03:30:41","2018-07-15 03:30:41");
INSERT INTO permissions VALUES("49","daily-purchase","web","2018-07-15 03:36:46","2018-07-15 03:36:46");
INSERT INTO permissions VALUES("50","monthly-purchase","web","2018-07-15 03:48:17","2018-07-15 03:48:17");
INSERT INTO permissions VALUES("51","payment-report","web","2018-07-15 04:10:41","2018-07-15 04:10:41");
INSERT INTO permissions VALUES("52","warehouse-stock-report","web","2018-07-15 04:16:55","2018-07-15 04:16:55");
INSERT INTO permissions VALUES("53","product-qty-alert","web","2018-07-15 04:33:21","2018-07-15 04:33:21");
INSERT INTO permissions VALUES("54","supplier-report","web","2018-07-30 08:00:01","2018-07-30 08:00:01");
INSERT INTO permissions VALUES("55","expenses-index","web","2018-09-05 06:07:10","2018-09-05 06:07:10");
INSERT INTO permissions VALUES("56","expenses-add","web","2018-09-05 06:07:10","2018-09-05 06:07:10");
INSERT INTO permissions VALUES("57","expenses-edit","web","2018-09-05 06:07:10","2018-09-05 06:07:10");
INSERT INTO permissions VALUES("58","expenses-delete","web","2018-09-05 06:07:11","2018-09-05 06:07:11");
INSERT INTO permissions VALUES("59","general_setting","web","2018-10-20 04:10:04","2018-10-20 04:10:04");
INSERT INTO permissions VALUES("60","mail_setting","web","2018-10-20 04:10:04","2018-10-20 04:10:04");
INSERT INTO permissions VALUES("61","pos_setting","web","2018-10-20 04:10:04","2018-10-20 04:10:04");
INSERT INTO permissions VALUES("62","hrm_setting","web","2019-01-02 15:30:23","2019-01-02 15:30:23");
INSERT INTO permissions VALUES("63","purchase-return-index","web","2019-01-03 02:45:14","2019-01-03 02:45:14");
INSERT INTO permissions VALUES("64","purchase-return-add","web","2019-01-03 02:45:14","2019-01-03 02:45:14");
INSERT INTO permissions VALUES("65","purchase-return-edit","web","2019-01-03 02:45:14","2019-01-03 02:45:14");
INSERT INTO permissions VALUES("66","purchase-return-delete","web","2019-01-03 02:45:14","2019-01-03 02:45:14");
INSERT INTO permissions VALUES("67","account-index","web","2019-01-03 03:06:13","2019-01-03 03:06:13");
INSERT INTO permissions VALUES("68","balance-sheet","web","2019-01-03 03:06:14","2019-01-03 03:06:14");
INSERT INTO permissions VALUES("69","account-statement","web","2019-01-03 03:06:14","2019-01-03 03:06:14");
INSERT INTO permissions VALUES("70","department","web","2019-01-03 03:30:01","2019-01-03 03:30:01");
INSERT INTO permissions VALUES("71","attendance","web","2019-01-03 03:30:01","2019-01-03 03:30:01");
INSERT INTO permissions VALUES("72","payroll","web","2019-01-03 03:30:01","2019-01-03 03:30:01");
INSERT INTO permissions VALUES("73","employees-index","web","2019-01-03 03:52:19","2019-01-03 03:52:19");
INSERT INTO permissions VALUES("74","employees-add","web","2019-01-03 03:52:19","2019-01-03 03:52:19");
INSERT INTO permissions VALUES("75","employees-edit","web","2019-01-03 03:52:19","2019-01-03 03:52:19");
INSERT INTO permissions VALUES("76","employees-delete","web","2019-01-03 03:52:19","2019-01-03 03:52:19");
INSERT INTO permissions VALUES("77","user-report","web","2019-01-16 11:48:18","2019-01-16 11:48:18");
INSERT INTO permissions VALUES("78","stock_count","web","2019-02-17 15:32:01","2019-02-17 15:32:01");
INSERT INTO permissions VALUES("79","adjustment","web","2019-02-17 15:32:02","2019-02-17 15:32:02");
INSERT INTO permissions VALUES("80","sms_setting","web","2019-02-22 10:18:03","2019-02-22 10:18:03");
INSERT INTO permissions VALUES("81","create_sms","web","2019-02-22 10:18:03","2019-02-22 10:18:03");
INSERT INTO permissions VALUES("82","print_barcode","web","2019-03-07 10:02:19","2019-03-07 10:02:19");
INSERT INTO permissions VALUES("83","empty_database","web","2019-03-07 10:02:19","2019-03-07 10:02:19");
INSERT INTO permissions VALUES("84","customer_group","web","2019-03-07 10:37:15","2019-03-07 10:37:15");
INSERT INTO permissions VALUES("85","unit","web","2019-03-07 10:37:15","2019-03-07 10:37:15");
INSERT INTO permissions VALUES("86","tax","web","2019-03-07 10:37:15","2019-03-07 10:37:15");
INSERT INTO permissions VALUES("87","gift_card","web","2019-03-07 11:29:38","2019-03-07 11:29:38");
INSERT INTO permissions VALUES("88","coupon","web","2019-03-07 11:29:38","2019-03-07 11:29:38");
INSERT INTO permissions VALUES("89","holiday","web","2019-10-19 13:57:15","2019-10-19 13:57:15");
INSERT INTO permissions VALUES("90","warehouse-report","web","2019-10-22 11:00:23","2019-10-22 11:00:23");
INSERT INTO permissions VALUES("91","warehouse","web","2020-02-26 11:47:32","2020-02-26 11:47:32");
INSERT INTO permissions VALUES("92","brand","web","2020-02-26 11:59:59","2020-02-26 11:59:59");
INSERT INTO permissions VALUES("93","billers-index","web","2020-02-26 12:11:15","2020-02-26 12:11:15");
INSERT INTO permissions VALUES("94","billers-add","web","2020-02-26 12:11:15","2020-02-26 12:11:15");
INSERT INTO permissions VALUES("95","billers-edit","web","2020-02-26 12:11:15","2020-02-26 12:11:15");
INSERT INTO permissions VALUES("96","billers-delete","web","2020-02-26 12:11:15","2020-02-26 12:11:15");
INSERT INTO permissions VALUES("97","money-transfer","web","2020-03-02 10:41:48","2020-03-02 10:41:48");
INSERT INTO permissions VALUES("98","category","web","2020-07-13 17:13:16","2020-07-13 17:13:16");
INSERT INTO permissions VALUES("99","delivery","web","2020-07-13 17:13:16","2020-07-13 17:13:16");
INSERT INTO permissions VALUES("100","send_notification","web","2020-10-31 11:21:31","2020-10-31 11:21:31");
INSERT INTO permissions VALUES("101","today_sale","web","2020-10-31 11:57:04","2020-10-31 11:57:04");
INSERT INTO permissions VALUES("102","today_profit","web","2020-10-31 11:57:04","2020-10-31 11:57:04");
INSERT INTO permissions VALUES("103","currency","web","2020-11-09 05:23:11","2020-11-09 05:23:11");
INSERT INTO permissions VALUES("104","backup_database","web","2020-11-15 05:16:55","2020-11-15 05:16:55");
INSERT INTO permissions VALUES("105","reward_point_setting","web","2021-06-27 09:34:42","2021-06-27 09:34:42");
INSERT INTO permissions VALUES("106","revenue_profit_summary","web","2022-02-08 18:57:21","2022-02-08 18:57:21");
INSERT INTO permissions VALUES("107","cash_flow","web","2022-02-08 18:57:22","2022-02-08 18:57:22");
INSERT INTO permissions VALUES("108","monthly_summary","web","2022-02-08 18:57:22","2022-02-08 18:57:22");
INSERT INTO permissions VALUES("109","yearly_report","web","2022-02-08 18:57:22","2022-02-08 18:57:22");
INSERT INTO permissions VALUES("110","discount_plan","web","2022-02-16 14:12:26","2022-02-16 14:12:26");
INSERT INTO permissions VALUES("111","discount","web","2022-02-16 14:12:38","2022-02-16 14:12:38");
INSERT INTO permissions VALUES("112","product-expiry-report","web","2022-03-30 10:39:20","2022-03-30 10:39:20");
INSERT INTO permissions VALUES("113","purchase-payment-index","web","2022-06-05 19:12:27","2022-06-05 19:12:27");
INSERT INTO permissions VALUES("114","purchase-payment-add","web","2022-06-05 19:12:28","2022-06-05 19:12:28");
INSERT INTO permissions VALUES("115","purchase-payment-edit","web","2022-06-05 19:12:28","2022-06-05 19:12:28");
INSERT INTO permissions VALUES("116","purchase-payment-delete","web","2022-06-05 19:12:28","2022-06-05 19:12:28");
INSERT INTO permissions VALUES("117","sale-payment-index","web","2022-06-05 19:12:28","2022-06-05 19:12:28");
INSERT INTO permissions VALUES("118","sale-payment-add","web","2022-06-05 19:12:28","2022-06-05 19:12:28");
INSERT INTO permissions VALUES("119","sale-payment-edit","web","2022-06-05 19:12:28","2022-06-05 19:12:28");
INSERT INTO permissions VALUES("120","sale-payment-delete","web","2022-06-05 19:12:28","2022-06-05 19:12:28");
INSERT INTO permissions VALUES("121","all_notification","web","2022-06-05 19:12:29","2022-06-05 19:12:29");
INSERT INTO permissions VALUES("122","sale-report-chart","web","2022-06-05 19:12:29","2022-06-05 19:12:29");
INSERT INTO permissions VALUES("123","dso-report","web","2022-06-05 19:12:29","2022-06-05 19:12:29");
INSERT INTO permissions VALUES("124","product_history","web","2022-08-25 19:04:05","2022-08-25 19:04:05");
INSERT INTO permissions VALUES("125","supplier-due-report","web","2022-08-31 14:46:33","2022-08-31 14:46:33");
INSERT INTO permissions VALUES("126","custom_field","web","2023-05-02 12:41:35","2023-05-02 12:41:35");
INSERT INTO permissions VALUES("127","incomes-index","web","2024-08-11 09:50:59","2024-08-11 09:50:59");
INSERT INTO permissions VALUES("128","incomes-add","web","2024-08-11 09:50:59","2024-08-11 09:50:59");
INSERT INTO permissions VALUES("129","incomes-edit","web","2024-08-11 09:50:59","2024-08-11 09:50:59");
INSERT INTO permissions VALUES("130","incomes-delete","web","2024-08-11 09:50:59","2024-08-11 09:50:59");
INSERT INTO permissions VALUES("131","packing_slip_challan","web","2024-08-11 09:51:00","2024-08-11 09:51:00");
INSERT INTO permissions VALUES("132","biller-report","web","2024-08-26 04:30:44","2024-08-26 04:30:44");
INSERT INTO permissions VALUES("133","payment_gateway_setting","web","2025-01-29 11:10:49","2025-01-29 11:10:49");
INSERT INTO permissions VALUES("134","barcode_setting","web","2025-01-29 15:26:14","2025-01-29 15:26:14");
INSERT INTO permissions VALUES("135","language_setting","web","2025-01-29 15:35:47","2025-01-29 15:35:47");
INSERT INTO permissions VALUES("136","addons","web","2025-02-02 16:25:47","2025-02-02 16:25:47");
INSERT INTO permissions VALUES("137","account-selection","web","2025-02-03 17:54:05","2025-02-03 17:54:05");
INSERT INTO permissions VALUES("138","invoice_setting","web","2025-06-03 11:04:51","2025-06-03 11:04:51");
INSERT INTO permissions VALUES("139","invoice_create_edit_delete","web","2025-06-03 11:04:51","2025-06-03 11:04:51");
INSERT INTO permissions VALUES("141","handle_discount","web","2025-06-03 11:37:55","2025-06-03 11:37:55");
INSERT INTO permissions VALUES("142","muri_khur","web","2025-08-02 09:41:09","2025-08-02 09:41:09");
INSERT INTO permissions VALUES("145","products-import","web","","");
INSERT INTO permissions VALUES("146","purchases-import","web","","");
INSERT INTO permissions VALUES("147","sales-import","web","","");
INSERT INTO permissions VALUES("148","customers-import","web","","");
INSERT INTO permissions VALUES("149","billers-import","web","","");
INSERT INTO permissions VALUES("150","suppliers-import","web","","");
INSERT INTO permissions VALUES("151","categories-add","web","","");
INSERT INTO permissions VALUES("152","categories-import","web","","");
INSERT INTO permissions VALUES("153","categories-index","web","","");
INSERT INTO permissions VALUES("154","categories-edit","web","","");
INSERT INTO permissions VALUES("155","categories-delete","web","","");
INSERT INTO permissions VALUES("156","role_permission","web","","");
INSERT INTO permissions VALUES("157","cart-product-update","web","","");
INSERT INTO permissions VALUES("158","transfers-import","web","","");
INSERT INTO permissions VALUES("159","change_sale_date","web","","");
INSERT INTO permissions VALUES("160","sidebar_product","web","","");
INSERT INTO permissions VALUES("161","sidebar_purchase","web","","");
INSERT INTO permissions VALUES("162","sidebar_sale","web","","");
INSERT INTO permissions VALUES("163","sidebar_quotation","web","","");
INSERT INTO permissions VALUES("164","sidebar_transfer","web","","");
INSERT INTO permissions VALUES("165","sidebar_expense","web","","");
INSERT INTO permissions VALUES("166","sidebar_income","web","","");
INSERT INTO permissions VALUES("167","sidebar_accounting","web","","");
INSERT INTO permissions VALUES("168","sidebar_hrm","web","","");
INSERT INTO permissions VALUES("169","sidebar_people","web","","");
INSERT INTO permissions VALUES("170","sidebar_reports","web","","");
INSERT INTO permissions VALUES("171","sidebar_settings","web","","");
INSERT INTO permissions VALUES("172","sale_export","web","","");
INSERT INTO permissions VALUES("173","product_export","web","","");
INSERT INTO permissions VALUES("174","purchase_export","web","","");
INSERT INTO permissions VALUES("175","designations","web","","");
INSERT INTO permissions VALUES("176","shift","web","","");
INSERT INTO permissions VALUES("177","overtime","web","","");
INSERT INTO permissions VALUES("178","leave-type","web","","");
INSERT INTO permissions VALUES("179","leave","web","","");
INSERT INTO permissions VALUES("180","hrm-panel","web","","");
INSERT INTO permissions VALUES("181","sale-agents","web","","");



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

INSERT INTO personal_access_tokens VALUES("10","App\Models\User","2","api-token","937d120e182f263841cbb4bd2c031f4b51975bfc63804f131de1fb9b76a34274","["*"]","2025-11-07 10:33:35","","2025-11-07 10:20:10","2025-11-07 10:33:35");
INSERT INTO personal_access_tokens VALUES("12","App\Models\User","2","refresh","ea5fefb2f19b721d2a81688a908967397e12ae6eb1a6d574fd97dab5c1258a87","["*"]","","2025-12-07 10:46:30","2025-11-07 10:46:30","2025-11-07 10:46:30");
INSERT INTO personal_access_tokens VALUES("14","App\Models\User","2","refresh","b03635de5b419673353110e7212be80a4119709b551f4b58b96717fb277b26af","["*"]","","2025-12-07 10:49:26","2025-11-07 10:49:26","2025-11-07 10:49:26");
INSERT INTO personal_access_tokens VALUES("16","App\Models\User","2","refresh","17c6ec03c8d81d140163fc570b38403d1a0ff2c815537b9b70b349646998fe71","["*"]","","2025-12-07 10:51:54","2025-11-07 10:51:54","2025-11-07 10:51:54");
INSERT INTO personal_access_tokens VALUES("18","App\Models\User","2","refresh","adbd8ad10efe99d8811bfed477c803845507dff40d58ffb7a09808f6af7b8c8c","["*"]","","2025-12-07 11:10:38","2025-11-07 11:10:38","2025-11-07 11:10:38");
INSERT INTO personal_access_tokens VALUES("20","App\Models\User","2","refresh","af0ee894135c4ea475f0f440b2b6270fde633bfbac9809fe7f19d24d4d68104c","["*"]","","2025-12-07 16:11:22","2025-11-07 16:11:22","2025-11-07 16:11:22");
INSERT INTO personal_access_tokens VALUES("22","App\Models\User","2","refresh","2e884345c906ed5ee793bf49ded3a289f5d414257e84fb090d415c83dbfe755c","["*"]","","2025-12-07 16:30:53","2025-11-07 16:30:53","2025-11-07 16:30:53");
INSERT INTO personal_access_tokens VALUES("24","App\Models\User","2","refresh","3442ce6fade32e0e676eeece8742e0a92a6816d5f9ad7767363578753bc7adda","["*"]","","2025-12-07 17:34:54","2025-11-07 17:34:54","2025-11-07 17:34:54");
INSERT INTO personal_access_tokens VALUES("26","App\Models\User","2","refresh","61634eb4d62fabac524d99d6251e91b74737b33eff81bc2059f5728319248a81","["*"]","","2025-12-10 09:58:35","2025-11-10 09:58:35","2025-11-10 09:58:35");
INSERT INTO personal_access_tokens VALUES("28","App\Models\User","2","refresh","d3f20d4fab009c8d830485b96230af4a91532b577ed4ca8b0c4bd4bd4a2c7f6a","["*"]","","2025-12-10 11:23:57","2025-11-10 11:23:57","2025-11-10 11:23:57");
INSERT INTO personal_access_tokens VALUES("30","App\Models\User","2","refresh","3b47eeea3fc4f8406afad9deed809d01138d3a52fc7bacb54c2db5b450e3a478","["*"]","","2025-12-10 15:40:37","2025-11-10 15:40:37","2025-11-10 15:40:37");
INSERT INTO personal_access_tokens VALUES("32","App\Models\User","2","refresh","ba123349898beb5ffda805defb22e3b99abe5772faef6d696bd68df4d30dcf8f","["*"]","2025-11-10 17:22:01","2025-12-10 17:08:50","2025-11-10 17:08:50","2025-11-10 17:22:01");
INSERT INTO personal_access_tokens VALUES("35","App\Models\User","2","refresh","ced1110f0638a7bb533d58be99a8027fabe220446bb97dec3fa5977889f2a666","["*"]","","2025-12-10 17:23:12","2025-11-10 17:23:12","2025-11-10 17:23:12");
INSERT INTO personal_access_tokens VALUES("37","App\Models\User","2","refresh","454272dc8944dd93f605c3783dfa5099558baebae2f156699fdc178434fde846","["*"]","","2025-12-10 20:09:43","2025-11-10 20:09:43","2025-11-10 20:09:43");
INSERT INTO personal_access_tokens VALUES("39","App\Models\User","2","refresh","250f59e05ad01e7c038190bc56e505ef8a9871406dc9dcc38dd13385deb0ced1","["*"]","","2025-12-10 20:10:17","2025-11-10 20:10:17","2025-11-10 20:10:17");
INSERT INTO personal_access_tokens VALUES("41","App\Models\User","2","refresh","9ec9cb1cf18c04ac2486e3d2b734cfdde979258651c79a71c3f30e8212838fd3","["*"]","","2025-12-11 15:35:22","2025-11-11 15:35:22","2025-11-11 15:35:22");
INSERT INTO personal_access_tokens VALUES("43","App\Models\User","2","refresh","72e474037474cd6fbc7eba9061df22642a542aa7a232bd369c512eb8a684b014","["*"]","","2025-12-11 15:35:39","2025-11-11 15:35:39","2025-11-11 15:35:39");
INSERT INTO personal_access_tokens VALUES("45","App\Models\User","2","refresh","7d93c9a325ef87fbdce85ed3fe5f5de9db57da8b35524a40f17851a95b7ff8b1","["*"]","","2025-12-11 15:35:50","2025-11-11 15:35:50","2025-11-11 15:35:50");
INSERT INTO personal_access_tokens VALUES("47","App\Models\User","2","refresh","26c0f801dabd1a73d211da853638ca434a6ad24424ced1a815acdf207e2792cd","["*"]","","2025-12-11 15:40:35","2025-11-11 15:40:35","2025-11-11 15:40:35");
INSERT INTO personal_access_tokens VALUES("49","App\Models\User","2","refresh","ac9cf98c3c636df3e50f5fae26a6e05300146a028f2a2d6f97d4938610cbf132","["*"]","","2025-12-11 17:06:20","2025-11-11 17:06:20","2025-11-11 17:06:20");
INSERT INTO personal_access_tokens VALUES("51","App\Models\User","2","refresh","c113791f9cfe5e5b014845663f2578d2bf3cdb95159447e530b7d64d5dc18154","["*"]","","2025-12-11 17:11:44","2025-11-11 17:11:44","2025-11-11 17:11:44");
INSERT INTO personal_access_tokens VALUES("53","App\Models\User","2","refresh","a74f1af5bee7d23447349f1aa0c9fd1ead5ce59856584c7f20ba75d640521988","["*"]","","2025-12-11 17:17:22","2025-11-11 17:17:22","2025-11-11 17:17:22");
INSERT INTO personal_access_tokens VALUES("55","App\Models\User","2","refresh","1140121b6945ced6a5d74d973eed8dd9b0c276caf8ffd08cd40bdf156b9add5b","["*"]","","2025-12-11 17:21:01","2025-11-11 17:21:01","2025-11-11 17:21:01");
INSERT INTO personal_access_tokens VALUES("57","App\Models\User","2","refresh","3078da78d59b0e0a58459396af35a0c5781f1c36b168e5ebe3c29b7f77a499c4","["*"]","","2025-12-11 18:09:21","2025-11-11 18:09:21","2025-11-11 18:09:21");
INSERT INTO personal_access_tokens VALUES("59","App\Models\User","2","refresh","c3603b58b54d83feb5dc13550f8db99751f8de3d2166bf5a7f0307a31173c3cd","["*"]","","2025-12-11 18:44:08","2025-11-11 18:44:08","2025-11-11 18:44:08");
INSERT INTO personal_access_tokens VALUES("61","App\Models\User","2","refresh","e8b18cbb43b4c37112dddedec5d60e2635004bcf0d801e076dde55e78f7db397","["*"]","","2025-12-11 18:44:48","2025-11-11 18:44:48","2025-11-11 18:44:48");
INSERT INTO personal_access_tokens VALUES("63","App\Models\User","2","refresh","28958d4cb6f5d55f6c03aa2bd86aec88681d505a892608b7f33bd9ec0c76687e","["*"]","","2025-12-11 18:50:55","2025-11-11 18:50:55","2025-11-11 18:50:55");
INSERT INTO personal_access_tokens VALUES("65","App\Models\User","2","refresh","88ab1b057b4aad4265b7c2d359325e34a0907e1434968288b7127d23e2db6737","["*"]","","2025-12-11 19:00:48","2025-11-11 19:00:48","2025-11-11 19:00:48");
INSERT INTO personal_access_tokens VALUES("67","App\Models\User","2","refresh","651459877077d75aa4baae0c38a90b1b7af641ca3f340cdccdfc9e19f51dd8e7","["*"]","","2025-12-11 19:01:38","2025-11-11 19:01:38","2025-11-11 19:01:38");
INSERT INTO personal_access_tokens VALUES("69","App\Models\User","2","refresh","f0af2e1069dcaeba4f566d877174f138655033a3ca44aef85eecd592b7579098","["*"]","","2025-12-11 19:06:58","2025-11-11 19:06:58","2025-11-11 19:06:58");
INSERT INTO personal_access_tokens VALUES("71","App\Models\User","2","refresh","f2d4986ce155530e729fa2630b61fdd7969b2c6422d507c6dfb15e3a76f17ec5","["*"]","","2025-12-11 19:38:19","2025-11-11 19:38:19","2025-11-11 19:38:19");
INSERT INTO personal_access_tokens VALUES("73","App\Models\User","2","refresh","db293b52136d70251779d9b086a9fb20464c6a8649673ec1a2cb7c1b950abe33","["*"]","","2025-12-12 09:21:22","2025-11-12 09:21:22","2025-11-12 09:21:22");
INSERT INTO personal_access_tokens VALUES("75","App\Models\User","2","refresh","f94f987b7034ecb5cbc9cd755f5706d262d7dd3515cb914e970df60558e70484","["*"]","","2025-12-12 09:23:46","2025-11-12 09:23:46","2025-11-12 09:23:46");
INSERT INTO personal_access_tokens VALUES("77","App\Models\User","2","refresh","1ce09836cb51c0bbf0a0d2dda563b22b82ffe3d1d7f9190d735a98af1c4b8fa0","["*"]","","2025-12-12 09:30:33","2025-11-12 09:30:33","2025-11-12 09:30:33");
INSERT INTO personal_access_tokens VALUES("79","App\Models\User","2","refresh","84062b09488284d54008b320f9c812ca672d745fecb3dcf9e186e5e5b9eb7e3d","["*"]","","2025-12-12 09:49:11","2025-11-12 09:49:11","2025-11-12 09:49:11");
INSERT INTO personal_access_tokens VALUES("81","App\Models\User","2","refresh","44b7e904221e4320dd61805dd0aa5eb35c734810ad4545cc9569a187d86f9f9c","["*"]","","2025-12-12 09:54:18","2025-11-12 09:54:18","2025-11-12 09:54:18");
INSERT INTO personal_access_tokens VALUES("83","App\Models\User","2","refresh","cf27cd9f314f0398ba0865000a5ce13ce4400a2d98bb226dcdca490ec11f9ce4","["*"]","","2025-12-12 09:59:07","2025-11-12 09:59:07","2025-11-12 09:59:07");
INSERT INTO personal_access_tokens VALUES("85","App\Models\User","2","refresh","69ab147fb3edfc488c303fcc0c8b6949cce3a98fadd0b37f24337fb351409868","["*"]","","2025-12-12 10:06:35","2025-11-12 10:06:35","2025-11-12 10:06:35");
INSERT INTO personal_access_tokens VALUES("87","App\Models\User","2","refresh","3c9e0a8b8cbcd2cc3482427061c1cfcdbde96419f35be670b27f5bc158f4345e","["*"]","","2025-12-12 10:15:10","2025-11-12 10:15:10","2025-11-12 10:15:10");
INSERT INTO personal_access_tokens VALUES("89","App\Models\User","2","refresh","70d0109582965fbf93ebf4cb8801a42748fa69091f39b6a1b54d4e68b98909d1","["*"]","","2025-12-12 10:16:14","2025-11-12 10:16:14","2025-11-12 10:16:14");
INSERT INTO personal_access_tokens VALUES("91","App\Models\User","2","refresh","658825ae5c3656c3bde81107212a67d4dcf8ace4ae77478cc2df188847dc38f3","["*"]","","2025-12-12 10:22:27","2025-11-12 10:22:27","2025-11-12 10:22:27");
INSERT INTO personal_access_tokens VALUES("93","App\Models\User","2","refresh","b24614c2d6d89dda80dbce6055c42abede66b8010747a510339b6a755f55ce34","["*"]","","2025-12-12 10:28:32","2025-11-12 10:28:32","2025-11-12 10:28:32");
INSERT INTO personal_access_tokens VALUES("95","App\Models\User","2","refresh","5e76dccef079d719cc223f64761af5156828d20fd9165498cb9523d25545de7e","["*"]","","2025-12-12 10:35:37","2025-11-12 10:35:37","2025-11-12 10:35:37");
INSERT INTO personal_access_tokens VALUES("97","App\Models\User","2","refresh","b5ab54969d5b4e8df63a4b0387ae6ee15da386496760dcbfbbfa08b0bb1620d9","["*"]","","2025-12-12 10:36:40","2025-11-12 10:36:40","2025-11-12 10:36:40");
INSERT INTO personal_access_tokens VALUES("99","App\Models\User","2","refresh","e40ea9edbd01e3b25562581a86e09d7d4bf3cb846d27580c652647283f6b8610","["*"]","","2025-12-12 10:45:08","2025-11-12 10:45:08","2025-11-12 10:45:08");
INSERT INTO personal_access_tokens VALUES("101","App\Models\User","2","refresh","e4bfcfb8b377fd122512f8536fb1d88202c2f327ec1b3cdac925bf229d7539fb","["*"]","","2025-12-12 10:53:22","2025-11-12 10:53:22","2025-11-12 10:53:22");
INSERT INTO personal_access_tokens VALUES("103","App\Models\User","2","refresh","b9382f57d5fd4ffd5229b9d72c974cbe3ce5f482efdd4cd0a0ca263fced3ea8d","["*"]","","2025-12-12 10:53:52","2025-11-12 10:53:52","2025-11-12 10:53:52");
INSERT INTO personal_access_tokens VALUES("105","App\Models\User","2","refresh","0b53cd4a033da536ddb0bac89627b39f2baa0f0822ec827f5af388b76792bba7","["*"]","","2025-12-12 11:02:07","2025-11-12 11:02:07","2025-11-12 11:02:07");
INSERT INTO personal_access_tokens VALUES("107","App\Models\User","2","refresh","70c770aad10349837d0f1c32f46aad218be20dd83206900a655088656ac5511f","["*"]","","2025-12-12 11:08:55","2025-11-12 11:08:55","2025-11-12 11:08:55");
INSERT INTO personal_access_tokens VALUES("109","App\Models\User","2","refresh","b7d112188083ac4cd9293f147c1c6a37bddea8c662c6eb58807ef94ea022581a","["*"]","","2025-12-12 11:12:30","2025-11-12 11:12:30","2025-11-12 11:12:30");
INSERT INTO personal_access_tokens VALUES("111","App\Models\User","2","refresh","5aeb3d6a49f8ec13d5dee6dc1bb23cb9a4542823c7dbe12f9318b2f86b6e7930","["*"]","","2025-12-12 11:35:50","2025-11-12 11:35:50","2025-11-12 11:35:50");
INSERT INTO personal_access_tokens VALUES("113","App\Models\User","2","refresh","77fa773731f7aefd2f6b84d173e5f4160f6360b49bc5dd0d4d7d8ccf2823f75f","["*"]","","2025-12-12 11:55:40","2025-11-12 11:55:40","2025-11-12 11:55:40");
INSERT INTO personal_access_tokens VALUES("115","App\Models\User","2","refresh","bcd479f70e0863df1e56667fdc806c6b01e322e8166abdc42f268aba4d384c5f","["*"]","","2025-12-12 12:03:49","2025-11-12 12:03:49","2025-11-12 12:03:49");
INSERT INTO personal_access_tokens VALUES("117","App\Models\User","2","refresh","bca78d502dec00ab535f7e2d5c4beba6f249e547bc02a22ccaf523eb72ee26f7","["*"]","","2025-12-12 12:21:25","2025-11-12 12:21:25","2025-11-12 12:21:25");
INSERT INTO personal_access_tokens VALUES("119","App\Models\User","2","refresh","939f35b69dfda44f4ba1818539c113e000cf43463514f971bc1e35602f09beb6","["*"]","","2025-12-12 12:55:03","2025-11-12 12:55:03","2025-11-12 12:55:03");
INSERT INTO personal_access_tokens VALUES("121","App\Models\User","2","refresh","221fb0794a17824ed246b85e36436493f3be36be764ec265ab19638832569547","["*"]","","2025-12-12 14:05:59","2025-11-12 14:05:59","2025-11-12 14:05:59");
INSERT INTO personal_access_tokens VALUES("123","App\Models\User","2","refresh","cc3224cd8186c2084175a50d3d3089fc64bced142db903783b40fa4f27309f48","["*"]","","2025-12-12 14:13:15","2025-11-12 14:13:15","2025-11-12 14:13:15");
INSERT INTO personal_access_tokens VALUES("125","App\Models\User","2","refresh","fb0a6d033bdfb4439d1b96fc90fd871cd42301aba15bf60b872938356f8a3960","["*"]","","2025-12-12 14:58:54","2025-11-12 14:58:54","2025-11-12 14:58:54");
INSERT INTO personal_access_tokens VALUES("127","App\Models\User","2","refresh","d2d45b3a23994a92ca567f86c9af00a4c035b901b7c2d17400f67128bad72947","["*"]","","2025-12-12 14:59:25","2025-11-12 14:59:25","2025-11-12 14:59:25");
INSERT INTO personal_access_tokens VALUES("129","App\Models\User","2","refresh","2315cda43dded868dc6e72c4b429f3eb210a32602f64480a71e5a4a4892cbce3","["*"]","","2025-12-12 15:33:25","2025-11-12 15:33:25","2025-11-12 15:33:25");
INSERT INTO personal_access_tokens VALUES("131","App\Models\User","2","refresh","695e523b37f82c946eb581d9db6006414294b1cd8d02464e11036b2769cbfd45","["*"]","","2025-12-12 15:36:37","2025-11-12 15:36:37","2025-11-12 15:36:37");
INSERT INTO personal_access_tokens VALUES("133","App\Models\User","2","refresh","13a9e03a86d74a49feb3aa725f18092798451d2ac959942b21a0e9cb074d0a47","["*"]","","2025-12-12 15:44:08","2025-11-12 15:44:08","2025-11-12 15:44:08");
INSERT INTO personal_access_tokens VALUES("135","App\Models\User","2","refresh","38a91c51bd29f7ae5939c6c7d6aa487f78ec3ba7db82fb24ff369bc54e9218ae","["*"]","","2025-12-12 15:44:20","2025-11-12 15:44:20","2025-11-12 15:44:20");
INSERT INTO personal_access_tokens VALUES("137","App\Models\User","2","refresh","6b19ac3b81ca322ddf03fd08bf6b8da7d5eb452097bb0c8f9ef339660e7673c6","["*"]","","2025-12-12 15:46:01","2025-11-12 15:46:01","2025-11-12 15:46:01");
INSERT INTO personal_access_tokens VALUES("139","App\Models\User","2","refresh","f02532f3db58708241dfa0cb381fe0a8ea1a5260ca80357e38dbb20032503721","["*"]","","2025-12-12 15:53:43","2025-11-12 15:53:43","2025-11-12 15:53:43");
INSERT INTO personal_access_tokens VALUES("141","App\Models\User","2","refresh","910ac28d3a9335bbb9b7eed256c3eef2b2f8b1f91982510c69c0717a400551ed","["*"]","","2025-12-12 16:08:17","2025-11-12 16:08:17","2025-11-12 16:08:17");
INSERT INTO personal_access_tokens VALUES("143","App\Models\User","2","refresh","9bfa930675a8482eead1d240564d322168345a150791ea0a71460c156a550f00","["*"]","","2025-12-12 16:41:13","2025-11-12 16:41:13","2025-11-12 16:41:13");
INSERT INTO personal_access_tokens VALUES("145","App\Models\User","2","refresh","2dbef446935041af0ec31ee294c29c9a35f5fa287834bda5759d7f50ec222067","["*"]","","2025-12-12 17:08:51","2025-11-12 17:08:51","2025-11-12 17:08:51");
INSERT INTO personal_access_tokens VALUES("147","App\Models\User","2","refresh","b953a5253b93d013cb8467c7bc77d601e7306fd6c923c692230ce2e6281b82b6","["*"]","","2025-12-12 17:12:09","2025-11-12 17:12:09","2025-11-12 17:12:09");
INSERT INTO personal_access_tokens VALUES("149","App\Models\User","2","refresh","ba02f260a0d63bc7e554fdac915b8ccdf2ce9048f8ddf7ea13ac6a949a05d237","["*"]","","2025-12-12 17:15:07","2025-11-12 17:15:07","2025-11-12 17:15:07");
INSERT INTO personal_access_tokens VALUES("151","App\Models\User","2","refresh","377d073dd8e6a3dab9ba3fb9c533e0fd7a85ac1317810bdcb8c36b712ad91b1b","["*"]","","2025-12-12 17:17:12","2025-11-12 17:17:12","2025-11-12 17:17:12");
INSERT INTO personal_access_tokens VALUES("153","App\Models\User","2","refresh","31346d9d1187fc034b0758db1e779e7b8c7aadfdf6ef25423ee1aa4004b471b1","["*"]","","2025-12-12 17:20:27","2025-11-12 17:20:27","2025-11-12 17:20:27");
INSERT INTO personal_access_tokens VALUES("155","App\Models\User","2","refresh","5f6c44d9c6c02e76facfd7a9a1b987912ecd04aa6e1236d71d8f77014806ba3d","["*"]","","2025-12-12 17:46:10","2025-11-12 17:46:10","2025-11-12 17:46:10");
INSERT INTO personal_access_tokens VALUES("157","App\Models\User","2","refresh","b04ae9e08e6808c31eb7d457d586908dfa1006a624ef653f690d930beccba411","["*"]","","2025-12-12 17:46:40","2025-11-12 17:46:40","2025-11-12 17:46:40");
INSERT INTO personal_access_tokens VALUES("159","App\Models\User","2","refresh","5a31a97fd74c70a269b0e17462be092c8519349ca31bdbdae17713afefb2e5d6","["*"]","","2025-12-12 18:06:49","2025-11-12 18:06:49","2025-11-12 18:06:49");
INSERT INTO personal_access_tokens VALUES("161","App\Models\User","2","refresh","4eb195b6822fe7cbd87380b2c1416bdd80fec359114032d6c76184bb8b7c72e4","["*"]","","2025-12-12 18:08:27","2025-11-12 18:08:27","2025-11-12 18:08:27");
INSERT INTO personal_access_tokens VALUES("163","App\Models\User","2","refresh","233635aa8edb69f713e49525f8f93c69b923c91a21671438a36ad798857231f8","["*"]","","2025-12-12 18:33:55","2025-11-12 18:33:55","2025-11-12 18:33:55");
INSERT INTO personal_access_tokens VALUES("165","App\Models\User","2","refresh","91b129ad7f9aefe6dcb89b1a0e2f811c6ebe398eca29cc06e9ef3058b84d7475","["*"]","","2025-12-12 19:00:29","2025-11-12 19:00:29","2025-11-12 19:00:29");
INSERT INTO personal_access_tokens VALUES("167","App\Models\User","2","refresh","f414371e1ff72aceb04cc60ea10bab5d8a15480a0828d0bdc0278b313bd65308","["*"]","","2025-12-13 09:16:28","2025-11-13 09:16:28","2025-11-13 09:16:28");
INSERT INTO personal_access_tokens VALUES("169","App\Models\User","2","refresh","6fdaad36f8a11780c1c5b1e2728cbe55be1e80a411e3b22780a8e1e35959fb75","["*"]","","2025-12-13 09:32:43","2025-11-13 09:32:43","2025-11-13 09:32:43");
INSERT INTO personal_access_tokens VALUES("171","App\Models\User","2","refresh","dea1ebaef0613d87678008402ddcf30c49fab394b4cafb3376330e98d1c1cbfe","["*"]","","2025-12-13 09:37:52","2025-11-13 09:37:52","2025-11-13 09:37:52");
INSERT INTO personal_access_tokens VALUES("173","App\Models\User","2","refresh","94925619abe7fb3993ccaf4e33ece55f48b338aa36906ccf0aa412b6c0888c12","["*"]","","2025-12-13 09:39:40","2025-11-13 09:39:40","2025-11-13 09:39:40");
INSERT INTO personal_access_tokens VALUES("175","App\Models\User","2","refresh","766769f8a84c3fe09af3f2ef17d9c689bb2e02f2b552569d22d3eb4e72b29d44","["*"]","","2025-12-13 10:33:12","2025-11-13 10:33:12","2025-11-13 10:33:12");
INSERT INTO personal_access_tokens VALUES("177","App\Models\User","2","refresh","cdef352da536e3a2807d4e4517f7f7c9403b5d3e9aa9e3bcc66e15b4b79f389a","["*"]","","2025-12-13 11:10:05","2025-11-13 11:10:05","2025-11-13 11:10:05");
INSERT INTO personal_access_tokens VALUES("179","App\Models\User","2","refresh","956185cd652f4706afded865049fd0934f610e104c054ae468f1754f99c50bf8","["*"]","","2025-12-13 11:26:50","2025-11-13 11:26:50","2025-11-13 11:26:50");
INSERT INTO personal_access_tokens VALUES("181","App\Models\User","2","refresh","595c2c8323222669690bacb5973ce789d236f0c1482a416ffb88a4ed84209024","["*"]","","2025-12-13 11:47:22","2025-11-13 11:47:22","2025-11-13 11:47:22");
INSERT INTO personal_access_tokens VALUES("183","App\Models\User","2","refresh","966d861597cd687a8cf8076a9f364a8206d41d3c4a38e3f09a5bfaeee1d8bfde","["*"]","","2025-12-13 11:57:53","2025-11-13 11:57:53","2025-11-13 11:57:53");
INSERT INTO personal_access_tokens VALUES("185","App\Models\User","2","refresh","ecd4e893932fbf0d611888e24969db1283d19a72dd38904846115b1a1d0b1e4c","["*"]","","2025-12-13 12:38:43","2025-11-13 12:38:43","2025-11-13 12:38:43");
INSERT INTO personal_access_tokens VALUES("187","App\Models\User","2","refresh","2ed39e7f2eedeb5c08e7f72fb0c0a765fb40e5c0b4ff040793cad7ec562d9d65","["*"]","","2025-12-13 12:46:01","2025-11-13 12:46:01","2025-11-13 12:46:01");
INSERT INTO personal_access_tokens VALUES("189","App\Models\User","2","refresh","f9bef04ebedb34b9e81245d91eeb2b682c8e75616036a5d2dc8cdc4c23d8231e","["*"]","","2025-12-13 12:58:13","2025-11-13 12:58:13","2025-11-13 12:58:13");
INSERT INTO personal_access_tokens VALUES("191","App\Models\User","2","refresh","7b5e52464e4aba74eb169a37b27e1d5bab58c07f49760abbdf97a1ff7d45b47f","["*"]","","2025-12-13 13:09:19","2025-11-13 13:09:19","2025-11-13 13:09:19");
INSERT INTO personal_access_tokens VALUES("193","App\Models\User","2","refresh","956c49800790b7543a430f4d1538772b6a31aef2f085e5943f120f5db4f14141","["*"]","","2025-12-13 14:18:07","2025-11-13 14:18:07","2025-11-13 14:18:07");
INSERT INTO personal_access_tokens VALUES("195","App\Models\User","2","refresh","6d565b3f9989242994238debaec0be154d5861f2b78762ef71223599cf010829","["*"]","","2025-12-13 14:20:03","2025-11-13 14:20:03","2025-11-13 14:20:03");
INSERT INTO personal_access_tokens VALUES("197","App\Models\User","2","refresh","e9e966463a2320c0a004ff4416c11d927d69f436c5db3a1bf8a688dc39876d17","["*"]","","2025-12-13 14:20:52","2025-11-13 14:20:52","2025-11-13 14:20:52");
INSERT INTO personal_access_tokens VALUES("199","App\Models\User","2","refresh","d6e8d7e47ba904fc07a0f9d2b4a7fe9f50640c8bb699689fceb9f0118b796098","["*"]","","2025-12-13 14:32:51","2025-11-13 14:32:51","2025-11-13 14:32:51");
INSERT INTO personal_access_tokens VALUES("201","App\Models\User","2","refresh","bae632a2bf5290bc1b5f2e4748a9c7fdb541f52a565297c34ecb9284b6ef877e","["*"]","","2025-12-13 14:42:31","2025-11-13 14:42:31","2025-11-13 14:42:31");
INSERT INTO personal_access_tokens VALUES("203","App\Models\User","2","refresh","c1b30c64946824f6b5c6c073c7c22d982e45428723a37097c061a82270f0f87b","["*"]","","2025-12-13 14:52:15","2025-11-13 14:52:15","2025-11-13 14:52:15");
INSERT INTO personal_access_tokens VALUES("205","App\Models\User","2","refresh","07df6fb834b6770bd91b0fe7e07f8a5708d93150481a3e338bb3f1fef7f0b05d","["*"]","","2025-12-13 14:57:55","2025-11-13 14:57:55","2025-11-13 14:57:55");
INSERT INTO personal_access_tokens VALUES("207","App\Models\User","2","refresh","003295f47f2f95038b9062f7fd68971f6f243ba701773927765a1c0465785472","["*"]","","2025-12-13 15:53:25","2025-11-13 15:53:25","2025-11-13 15:53:25");
INSERT INTO personal_access_tokens VALUES("209","App\Models\User","2","refresh","a10a75077d6618d96e896e5592ecfd9fd81cda6e1c35d04c3475d111a29d95f0","["*"]","","2025-12-13 15:58:13","2025-11-13 15:58:13","2025-11-13 15:58:13");
INSERT INTO personal_access_tokens VALUES("211","App\Models\User","2","refresh","a25fae18ebe0b5be03903a40cfc5f3f7724b5a6e650122fdee8904f00f2aa076","["*"]","","2025-12-13 16:19:49","2025-11-13 16:19:49","2025-11-13 16:19:49");
INSERT INTO personal_access_tokens VALUES("213","App\Models\User","2","refresh","3ee6de41dbd0d82c41619fdbf5f5bce0f8a08819fe8eed91e5be1965d1619753","["*"]","","2025-12-13 16:43:17","2025-11-13 16:43:17","2025-11-13 16:43:17");
INSERT INTO personal_access_tokens VALUES("215","App\Models\User","2","refresh","0bd9228d1f4c478189bb0ae61d80241d4602ab57c7251b7efd0be6e881cddbfd","["*"]","","2025-12-13 16:52:32","2025-11-13 16:52:32","2025-11-13 16:52:32");
INSERT INTO personal_access_tokens VALUES("217","App\Models\User","2","refresh","a44d6f32a46718950a76cb38e126ab423f0dfdfd800ad53895842bdc61e6ae98","["*"]","","2025-12-13 17:14:58","2025-11-13 17:14:58","2025-11-13 17:14:58");
INSERT INTO personal_access_tokens VALUES("219","App\Models\User","2","refresh","47f13bec27ec9d28206968fe5148fccc355c228ab7d6573130058a3bd8ab465a","["*"]","","2025-12-13 17:24:46","2025-11-13 17:24:46","2025-11-13 17:24:46");
INSERT INTO personal_access_tokens VALUES("221","App\Models\User","2","refresh","811ead45ac3b3efa79eeaff090dda72522215ce2686bfe41867681ffec4dbf56","["*"]","","2025-12-13 17:33:34","2025-11-13 17:33:34","2025-11-13 17:33:34");
INSERT INTO personal_access_tokens VALUES("223","App\Models\User","2","refresh","ab3c020b231bc8e108b0980a59fcffe12bd4cfd6a36a186c0d7047017d8aac0a","["*"]","","2025-12-13 17:36:14","2025-11-13 17:36:14","2025-11-13 17:36:14");
INSERT INTO personal_access_tokens VALUES("225","App\Models\User","2","refresh","739cdc8bfe1213bc58e507a26817bc4087abba9d4afd5915abde4d13163f35b0","["*"]","","2025-12-13 17:38:41","2025-11-13 17:38:41","2025-11-13 17:38:41");
INSERT INTO personal_access_tokens VALUES("227","App\Models\User","2","refresh","9b5757976ec9223f8dfc4fd7a6b0d0cf689294c84afee55553d716a08c099e24","["*"]","","2025-12-13 17:38:51","2025-11-13 17:38:51","2025-11-13 17:38:51");
INSERT INTO personal_access_tokens VALUES("229","App\Models\User","2","refresh","5d7bceb644525999e90cf2069f879ef4e651ad7a905578247473f014ae47d29c","["*"]","","2025-12-13 17:45:32","2025-11-13 17:45:32","2025-11-13 17:45:32");
INSERT INTO personal_access_tokens VALUES("231","App\Models\User","2","refresh","bab96a3121c528cc8e3dc7f0288dbff87aeccb308a6c04b5862d375f206c4858","["*"]","","2025-12-13 17:50:52","2025-11-13 17:50:51","2025-11-13 17:50:52");
INSERT INTO personal_access_tokens VALUES("233","App\Models\User","2","refresh","2a557af56288cd4219092c0c3a26d1bc2e5b3f143ad6428fdfaf1240a8cb5ef1","["*"]","","2025-12-13 18:15:02","2025-11-13 18:15:02","2025-11-13 18:15:02");
INSERT INTO personal_access_tokens VALUES("235","App\Models\User","2","refresh","d177862f5110bf2f297e158e971ce46baecc9903f83820731c4db585e9458259","["*"]","","2025-12-13 18:24:22","2025-11-13 18:24:22","2025-11-13 18:24:22");
INSERT INTO personal_access_tokens VALUES("237","App\Models\User","2","refresh","f74e57288daabb9eaa62ba5d7ebfedfab424653712ed1edbc3dddb94f86c1323","["*"]","","2025-12-13 18:28:26","2025-11-13 18:28:26","2025-11-13 18:28:26");
INSERT INTO personal_access_tokens VALUES("239","App\Models\User","2","refresh","4fcfd25370764c4b4171d30024adc2379a9e6c982676ed9cb1b0beffd3dc39c6","["*"]","","2025-12-13 18:37:07","2025-11-13 18:37:07","2025-11-13 18:37:07");
INSERT INTO personal_access_tokens VALUES("241","App\Models\User","2","refresh","c740cd019b8f54b1dcdcb511a5264fbe0766863513dae72f1267bf17e877fc30","["*"]","","2025-12-13 18:40:57","2025-11-13 18:40:57","2025-11-13 18:40:57");
INSERT INTO personal_access_tokens VALUES("243","App\Models\User","2","refresh","696ea9be01520924798b78decadef21ecb03e11ea2423f7a03a7f763651abd56","["*"]","","2025-12-13 18:50:56","2025-11-13 18:50:56","2025-11-13 18:50:56");
INSERT INTO personal_access_tokens VALUES("245","App\Models\User","2","refresh","99d0365a37dd9dc2bab11f41ad132982215e4dc196bfb9b33c928f7951030c3d","["*"]","","2025-12-13 18:55:01","2025-11-13 18:55:01","2025-11-13 18:55:01");
INSERT INTO personal_access_tokens VALUES("247","App\Models\User","2","refresh","5d81dd69792b7e3a9dd0ba97497bd5e906e9dce2efc557421928a7a39d002acb","["*"]","","2025-12-13 19:01:34","2025-11-13 19:01:34","2025-11-13 19:01:34");
INSERT INTO personal_access_tokens VALUES("249","App\Models\User","2","refresh","149d5623eb757d0554a1660325cf6d2acf239a60a7b878b77cadf75ca15ad404","["*"]","","2025-12-13 19:02:36","2025-11-13 19:02:36","2025-11-13 19:02:36");
INSERT INTO personal_access_tokens VALUES("251","App\Models\User","2","refresh","e56a69ccc0b2aee890a593b27126b90755e159d82ddbab17b352c0baf3fd8db0","["*"]","","2025-12-13 19:11:19","2025-11-13 19:11:19","2025-11-13 19:11:19");
INSERT INTO personal_access_tokens VALUES("253","App\Models\User","2","refresh","e2acbe42de116c73cce788b643c526104e66acbc808f0bfc804588bb36c54437","["*"]","","2025-12-13 19:46:45","2025-11-13 19:46:45","2025-11-13 19:46:45");
INSERT INTO personal_access_tokens VALUES("255","App\Models\User","2","refresh","5e65ac9a4c71c3771938a9101092832c001b080df7fdf47103c6ed9d8b53ae1a","["*"]","","2025-12-14 09:38:32","2025-11-14 09:38:32","2025-11-14 09:38:32");
INSERT INTO personal_access_tokens VALUES("257","App\Models\User","2","refresh","a6a88be657b96e484b9bc0a0cca5f2be973c425eea96c6b81b9c06cfa67b106b","["*"]","","2025-12-14 09:53:14","2025-11-14 09:53:14","2025-11-14 09:53:14");
INSERT INTO personal_access_tokens VALUES("259","App\Models\User","2","refresh","958ddec8f3ce9b040404f4517fb77d5c7164104b872cb50aeda8147316dbba9b","["*"]","","2025-12-14 10:31:44","2025-11-14 10:31:44","2025-11-14 10:31:44");
INSERT INTO personal_access_tokens VALUES("261","App\Models\User","2","refresh","329573bd68436e26824355e707dc6905e9ae9293f4eb456d427b988af6af7cd1","["*"]","","2025-12-14 10:32:45","2025-11-14 10:32:45","2025-11-14 10:32:45");
INSERT INTO personal_access_tokens VALUES("263","App\Models\User","2","refresh","1285a751187dd7bca49ba3d2d42edfc94f1a1dc2dcfb2429ba2ac89c6c5f54a0","["*"]","","2025-12-14 10:47:34","2025-11-14 10:47:34","2025-11-14 10:47:34");
INSERT INTO personal_access_tokens VALUES("265","App\Models\User","2","refresh","eafa0e022e40ae415ea0cb0091a0cb9f142707d9390df92812f4714ec085af35","["*"]","","2025-12-14 10:53:43","2025-11-14 10:53:43","2025-11-14 10:53:43");
INSERT INTO personal_access_tokens VALUES("267","App\Models\User","2","refresh","04f7f68bed1264397e80b12569b49a946d08f57f756dc2849c5d7b832a694707","["*"]","","2025-12-14 11:03:58","2025-11-14 11:03:58","2025-11-14 11:03:58");
INSERT INTO personal_access_tokens VALUES("269","App\Models\User","2","refresh","f64c05616469a5407fb0a49600490230f1331327c439d865e1e58b3750e81f7c","["*"]","","2025-12-14 11:17:19","2025-11-14 11:17:19","2025-11-14 11:17:19");
INSERT INTO personal_access_tokens VALUES("271","App\Models\User","2","refresh","a6e2db7b78c058957554227e989047d2ddc3a02d5cf790c2e6c702fea150d208","["*"]","","2025-12-14 11:38:43","2025-11-14 11:38:43","2025-11-14 11:38:43");
INSERT INTO personal_access_tokens VALUES("273","App\Models\User","2","refresh","1b7799b8b7ed75fe8b59708a93fc1e6463e283105c18f4ca013094fa30498ac4","["*"]","","2025-12-14 11:45:22","2025-11-14 11:45:22","2025-11-14 11:45:22");
INSERT INTO personal_access_tokens VALUES("275","App\Models\User","2","refresh","3b26def03255e43dcd70278025415552e04e75be058408f79717ad574eee7662","["*"]","","2025-12-14 11:54:02","2025-11-14 11:54:02","2025-11-14 11:54:02");
INSERT INTO personal_access_tokens VALUES("277","App\Models\User","2","refresh","9ec18fb6fca88188410e42350129a382dd9c142f212b970823aab10780a4edd6","["*"]","","2025-12-14 11:59:50","2025-11-14 11:59:50","2025-11-14 11:59:50");
INSERT INTO personal_access_tokens VALUES("279","App\Models\User","2","refresh","ebe0c261c48d88704b37f566c5693ba7694e020ce891937038644865b6564615","["*"]","","2025-12-14 12:07:04","2025-11-14 12:07:04","2025-11-14 12:07:04");
INSERT INTO personal_access_tokens VALUES("281","App\Models\User","2","refresh","17b58263a5cd230522a46e8d7e7d7baa1e87d2e4090f010e251798e5062b6740","["*"]","","2025-12-14 12:11:01","2025-11-14 12:11:01","2025-11-14 12:11:01");
INSERT INTO personal_access_tokens VALUES("283","App\Models\User","2","refresh","9cdbcdc64ff5584abda90363b59fe7da154917f72d33f6e67d0a37d7c2484b3f","["*"]","","2025-12-14 12:19:37","2025-11-14 12:19:37","2025-11-14 12:19:37");
INSERT INTO personal_access_tokens VALUES("285","App\Models\User","2","refresh","af4ac1c68d00d9d6a99ff17c011b669b6c9b64ed5d5bba4d9f1ce05fd2ad79ba","["*"]","","2025-12-14 12:24:45","2025-11-14 12:24:45","2025-11-14 12:24:45");
INSERT INTO personal_access_tokens VALUES("287","App\Models\User","2","refresh","6ddc39439eadf91263cb2a94326959c9de03d88a6849b78a06826f6b3ae027e0","["*"]","","2025-12-14 12:27:39","2025-11-14 12:27:39","2025-11-14 12:27:39");
INSERT INTO personal_access_tokens VALUES("289","App\Models\User","2","refresh","db048f640dd662480083981f0cecfc82da09efad40ba8c021c3f7fb7c1c096b9","["*"]","","2025-12-14 12:35:07","2025-11-14 12:35:07","2025-11-14 12:35:07");
INSERT INTO personal_access_tokens VALUES("291","App\Models\User","2","refresh","a58d45a564f99283be3127bb42eb6a036592f07b4916fc9809ab081996968a50","["*"]","","2025-12-14 12:36:51","2025-11-14 12:36:51","2025-11-14 12:36:51");
INSERT INTO personal_access_tokens VALUES("293","App\Models\User","2","refresh","cf76bce4d81a5c952c8d7628eefd6378c36cf9a09def0ab4afbe5cc265782ee5","["*"]","","2025-12-14 12:43:39","2025-11-14 12:43:39","2025-11-14 12:43:39");
INSERT INTO personal_access_tokens VALUES("295","App\Models\User","2","refresh","590c6cc7d8904e596aec982d4703e70bd20a6698242f4cd88097cccd5d4e2243","["*"]","","2025-12-14 12:52:01","2025-11-14 12:52:01","2025-11-14 12:52:01");
INSERT INTO personal_access_tokens VALUES("297","App\Models\User","2","refresh","82dff29d3abe76494560d8a554d77c5e39ad61666425925c95359f23d5399e1e","["*"]","","2025-12-14 12:58:33","2025-11-14 12:58:33","2025-11-14 12:58:33");
INSERT INTO personal_access_tokens VALUES("299","App\Models\User","2","refresh","7dc6c708fa7e91cf0bf981915cf9ca928f50c2364b4c298f0578651158adf120","["*"]","","2025-12-14 13:08:44","2025-11-14 13:08:44","2025-11-14 13:08:44");
INSERT INTO personal_access_tokens VALUES("301","App\Models\User","2","refresh","ea6a8779e01c022ecc63258b4e4201ed4ae44e3684c112c992ddeb73a2722e15","["*"]","","2025-12-14 13:09:52","2025-11-14 13:09:52","2025-11-14 13:09:52");
INSERT INTO personal_access_tokens VALUES("303","App\Models\User","2","refresh","1b05973aa414a6592e0d21a6593f4ad7b96f44482fc1002925ad8159bbc83733","["*"]","","2025-12-14 13:13:06","2025-11-14 13:13:06","2025-11-14 13:13:06");
INSERT INTO personal_access_tokens VALUES("305","App\Models\User","2","refresh","b4d1f318de3f8f121c97d1e49534523a02be6c57644eb4dc9d5f9d28eff69af1","["*"]","","2025-12-14 14:00:16","2025-11-14 14:00:16","2025-11-14 14:00:16");
INSERT INTO personal_access_tokens VALUES("307","App\Models\User","2","refresh","7ecdc01e890a9cce6d08fab161d12bdc8334b91d69a35297dee96e51d5a1bb73","["*"]","","2025-12-14 14:04:35","2025-11-14 14:04:35","2025-11-14 14:04:35");
INSERT INTO personal_access_tokens VALUES("309","App\Models\User","2","refresh","512c93813f005dd1b3783816ac112db918d75e05dcfee3406e0f43da6cc92c94","["*"]","","2025-12-14 14:10:15","2025-11-14 14:10:15","2025-11-14 14:10:15");
INSERT INTO personal_access_tokens VALUES("311","App\Models\User","2","refresh","127729bccc87363abb3cda52290315877725e247eff609bb739cba002ca1e5d0","["*"]","","2025-12-14 14:22:14","2025-11-14 14:22:14","2025-11-14 14:22:14");
INSERT INTO personal_access_tokens VALUES("313","App\Models\User","2","refresh","2b4d35ae7b58676db37a3386b6ab09bd364916baf5625254ef0932b57a5c9ed4","["*"]","","2025-12-14 14:32:42","2025-11-14 14:32:42","2025-11-14 14:32:42");
INSERT INTO personal_access_tokens VALUES("315","App\Models\User","2","refresh","d974344afac7efe5f0e3f49e2f434b403b68d76aa8cad1b1c40fa0597d867f33","["*"]","","2025-12-14 14:40:14","2025-11-14 14:40:14","2025-11-14 14:40:14");
INSERT INTO personal_access_tokens VALUES("317","App\Models\User","2","refresh","649fed5bd51ccc2e0cb799b20469a613f2d715ef3f63f6797af9b650d5fc79df","["*"]","","2025-12-14 14:45:28","2025-11-14 14:45:28","2025-11-14 14:45:28");
INSERT INTO personal_access_tokens VALUES("319","App\Models\User","2","refresh","bc4a9a9b1d9b8cc07f51d0900bebdb8a6ea8782bc059b1fff8d9949c78d2373d","["*"]","","2025-12-14 14:48:27","2025-11-14 14:48:27","2025-11-14 14:48:27");
INSERT INTO personal_access_tokens VALUES("321","App\Models\User","2","refresh","b7ef3ca0fc3678972d8f1f4806e854899f1fa318bc6d3c03bf9aac9773da8577","["*"]","","2025-12-14 14:52:41","2025-11-14 14:52:41","2025-11-14 14:52:41");
INSERT INTO personal_access_tokens VALUES("323","App\Models\User","2","refresh","04a28c3fea207b8f5b50292adb93e920b4d87adb10e4313cdf34035523e8279c","["*"]","","2025-12-14 15:00:04","2025-11-14 15:00:04","2025-11-14 15:00:04");
INSERT INTO personal_access_tokens VALUES("325","App\Models\User","2","refresh","1f6c3e5e5035b624bfc5cf28c5107a04bc8ee65d95849c684ad07d611c79400d","["*"]","","2025-12-14 15:14:26","2025-11-14 15:14:26","2025-11-14 15:14:26");
INSERT INTO personal_access_tokens VALUES("327","App\Models\User","2","refresh","8cbed626354d7bb3cbc3d5ef543ab3408dce8f4935c6b79382863877424c8755","["*"]","","2025-12-14 15:17:51","2025-11-14 15:17:51","2025-11-14 15:17:51");
INSERT INTO personal_access_tokens VALUES("329","App\Models\User","2","refresh","2b6dc62432e8da28e04990324feef4050a3ee73a04b02576569d490132fc0649","["*"]","","2025-12-14 15:21:35","2025-11-14 15:21:35","2025-11-14 15:21:35");
INSERT INTO personal_access_tokens VALUES("331","App\Models\User","2","refresh","d6014c07c0c67afb98642683ae84dfbf7b9838f0b1e93ac5872adb989d43f22e","["*"]","","2025-12-14 15:24:06","2025-11-14 15:24:06","2025-11-14 15:24:06");
INSERT INTO personal_access_tokens VALUES("333","App\Models\User","2","refresh","2a5ade9ea374587774165c01697b2a1910fa3c3ceb2e939f876f6372d225d48c","["*"]","","2025-12-14 15:27:44","2025-11-14 15:27:44","2025-11-14 15:27:44");
INSERT INTO personal_access_tokens VALUES("335","App\Models\User","2","refresh","2dbab6c4891488076cd37cfd83dcba978a05711a85f81c50cc8d2cf9d93d29fb","["*"]","","2025-12-14 15:31:53","2025-11-14 15:31:53","2025-11-14 15:31:53");
INSERT INTO personal_access_tokens VALUES("337","App\Models\User","2","refresh","f1cd940396b5285921f60eb66b2d1bb4ae9ede58cb2ff2481c41018e092d6a2b","["*"]","","2025-12-14 15:43:44","2025-11-14 15:43:44","2025-11-14 15:43:44");
INSERT INTO personal_access_tokens VALUES("339","App\Models\User","2","refresh","4694a28146d741b6271fe9c0ed2ebb1f5299dd1e8b07f314951e5c7fb01a0918","["*"]","","2025-12-14 15:59:45","2025-11-14 15:59:45","2025-11-14 15:59:45");
INSERT INTO personal_access_tokens VALUES("341","App\Models\User","2","refresh","1548930ec339c816884d997e7c2fce80177a7ba54fa479c476b5f01e6c897585","["*"]","","2025-12-14 16:01:42","2025-11-14 16:01:42","2025-11-14 16:01:42");
INSERT INTO personal_access_tokens VALUES("343","App\Models\User","2","refresh","22d2b68c2b914b1c77dcf449944dc8449e202e4b2b8f9fd062655e8def780f9b","["*"]","","2025-12-14 16:06:55","2025-11-14 16:06:55","2025-11-14 16:06:55");
INSERT INTO personal_access_tokens VALUES("345","App\Models\User","2","refresh","3e86f716cc28df698ca195c221dda2d17cfaf558507756c72ea3529c82d467a1","["*"]","","2025-12-14 16:19:06","2025-11-14 16:19:06","2025-11-14 16:19:06");
INSERT INTO personal_access_tokens VALUES("347","App\Models\User","2","refresh","38241351bcace16ee366b40c61c02bff9043377208c22a321e6223577b8a8cd2","["*"]","","2025-12-14 16:21:33","2025-11-14 16:21:33","2025-11-14 16:21:33");
INSERT INTO personal_access_tokens VALUES("349","App\Models\User","2","refresh","18549be92aec823d6f7f84838e130fae7f3c40635153500a0017ebd39070e729","["*"]","","2025-12-14 16:27:01","2025-11-14 16:27:01","2025-11-14 16:27:01");
INSERT INTO personal_access_tokens VALUES("351","App\Models\User","2","refresh","951d9f6085cdddcd003b6283ffa655f998ad51feec5d7ea6a594403ef0a18e9b","["*"]","","2025-12-14 16:31:46","2025-11-14 16:31:46","2025-11-14 16:31:46");
INSERT INTO personal_access_tokens VALUES("353","App\Models\User","2","refresh","1c6e129dc2c585e60d9780e0e3f63df76afa0c3c0019c54cee0432f915cd17b1","["*"]","","2025-12-14 16:37:52","2025-11-14 16:37:52","2025-11-14 16:37:52");
INSERT INTO personal_access_tokens VALUES("355","App\Models\User","2","refresh","61e4626de2ad0abe1a4c38594d717e9ee5c2c9fba0145fda5993af2e3d3777e9","["*"]","","2025-12-14 16:43:51","2025-11-14 16:43:51","2025-11-14 16:43:51");
INSERT INTO personal_access_tokens VALUES("357","App\Models\User","2","refresh","c9d8c16f95b38e9e154ee7d418cba80e11607201c6374ffa318d31837e57e8f7","["*"]","","2025-12-14 16:57:20","2025-11-14 16:57:20","2025-11-14 16:57:20");
INSERT INTO personal_access_tokens VALUES("359","App\Models\User","2","refresh","d0cd71612010df852626993e6db17719e16a16c21bce8e5f707df66313130ab0","["*"]","","2025-12-14 16:57:48","2025-11-14 16:57:48","2025-11-14 16:57:48");
INSERT INTO personal_access_tokens VALUES("361","App\Models\User","2","refresh","c86b64dd9ae31a5c3948d1f929eaaf6c05f4b92d4a21bb9d299f9aef7600af72","["*"]","","2025-12-14 17:03:30","2025-11-14 17:03:30","2025-11-14 17:03:30");
INSERT INTO personal_access_tokens VALUES("363","App\Models\User","2","refresh","021a016f6e9ddfe6a2df8aff75201e95e4ec5de8ae6e5e62932a1045bccd8491","["*"]","","2025-12-14 17:06:53","2025-11-14 17:06:53","2025-11-14 17:06:53");
INSERT INTO personal_access_tokens VALUES("365","App\Models\User","2","refresh","30f7f647dc86f024be5fb3dd0556ee367676aa97020f726e3b8cf536d5f14882","["*"]","","2025-12-14 17:26:16","2025-11-14 17:26:16","2025-11-14 17:26:16");
INSERT INTO personal_access_tokens VALUES("367","App\Models\User","2","refresh","5a93c67715f87529a41331718655191e369777597419f9c5f40674755b5519d7","["*"]","","2025-12-14 17:29:47","2025-11-14 17:29:47","2025-11-14 17:29:47");
INSERT INTO personal_access_tokens VALUES("369","App\Models\User","2","refresh","7b812714784b9cb5e700dd65dc04df97191d09db4cc9054ad1e33be485849352","["*"]","","2025-12-14 17:36:48","2025-11-14 17:36:48","2025-11-14 17:36:48");
INSERT INTO personal_access_tokens VALUES("371","App\Models\User","2","refresh","63a693f9a94a3be1811c73d8ddf3a293feb78dc4995f2d90800896f0e976f703","["*"]","","2025-12-14 17:45:56","2025-11-14 17:45:56","2025-11-14 17:45:56");
INSERT INTO personal_access_tokens VALUES("373","App\Models\User","2","refresh","8a69685c3142032a4802055c43f0d7ee698fb4fbcd39a9d8eca0f048481a687d","["*"]","","2025-12-14 18:06:12","2025-11-14 18:06:12","2025-11-14 18:06:12");
INSERT INTO personal_access_tokens VALUES("375","App\Models\User","2","refresh","6930b0788eae3aaa27faa9af658a0bcfd2da9b837a7749316d60cffd1cb87478","["*"]","","2025-12-14 18:11:48","2025-11-14 18:11:48","2025-11-14 18:11:48");
INSERT INTO personal_access_tokens VALUES("377","App\Models\User","2","refresh","f7d20bead9f2a82409a4bc6d65c22308fb86a8c6a9bc4de6f2da38034c31dd4b","["*"]","","2025-12-14 18:17:34","2025-11-14 18:17:34","2025-11-14 18:17:34");
INSERT INTO personal_access_tokens VALUES("379","App\Models\User","2","refresh","4f4cd2c5001bbe85e27d073208805aebf6e962cb7dc08dd907efa071502722a9","["*"]","","2025-12-14 18:23:34","2025-11-14 18:23:34","2025-11-14 18:23:34");
INSERT INTO personal_access_tokens VALUES("381","App\Models\User","2","refresh","10e933a3467bf47cf39b28ae4154807758bdf26db020ce415be56f3ecff3f0ef","["*"]","","2025-12-14 18:47:41","2025-11-14 18:47:41","2025-11-14 18:47:41");
INSERT INTO personal_access_tokens VALUES("383","App\Models\User","2","refresh","17e3895d8728feed0040b5e89ed7e79ef81c2ed3ba30a2bed40b03c848039bc8","["*"]","","2025-12-14 18:55:32","2025-11-14 18:55:32","2025-11-14 18:55:32");
INSERT INTO personal_access_tokens VALUES("385","App\Models\User","2","refresh","7dd40aa3f05d2b1c26de624cef21043d555937d640ee63b4b936c40143e30b13","["*"]","","2025-12-14 19:01:11","2025-11-14 19:01:11","2025-11-14 19:01:11");
INSERT INTO personal_access_tokens VALUES("387","App\Models\User","2","refresh","0e84dbf8f7104683fca16f93956d1662beee1f4842333924bf0268f7f4db3d25","["*"]","","2025-12-14 19:05:04","2025-11-14 19:05:04","2025-11-14 19:05:04");
INSERT INTO personal_access_tokens VALUES("389","App\Models\User","2","refresh","e5484da16048cae22d8ad050f06b6c0fb727f2fbfc79ad5b959559984c5919cf","["*"]","","2025-12-15 20:09:03","2025-11-15 20:09:03","2025-11-15 20:09:03");
INSERT INTO personal_access_tokens VALUES("391","App\Models\User","2","refresh","4de0634a44e75dd3c9b54cafa646f03eefe79639fce9167ba9bdf1dad00d27a6","["*"]","","2025-12-15 20:16:20","2025-11-15 20:16:20","2025-11-15 20:16:20");
INSERT INTO personal_access_tokens VALUES("393","App\Models\User","2","refresh","62084978d3b5d47a427bbbc02bae31d46a1a320df4c36a3a77b442381ef6d27f","["*"]","","2025-12-15 20:29:49","2025-11-15 20:29:49","2025-11-15 20:29:49");
INSERT INTO personal_access_tokens VALUES("395","App\Models\User","2","refresh","f8a06056350ea5d94c1c9ca18d75efd07765e60822c20ba9cea950369d9fc867","["*"]","","2025-12-15 20:32:45","2025-11-15 20:32:45","2025-11-15 20:32:45");
INSERT INTO personal_access_tokens VALUES("397","App\Models\User","2","refresh","228bbcba0efbf3d3359c583b4d3028820e7019101f8d1742dac7ee3ce28f9c71","["*"]","","2025-12-15 20:40:23","2025-11-15 20:40:23","2025-11-15 20:40:23");
INSERT INTO personal_access_tokens VALUES("399","App\Models\User","2","refresh","a88dd33e421670adc078001107e87996312f538e4c56b7ca348d61033f973b0e","["*"]","","2025-12-15 21:24:38","2025-11-15 21:24:38","2025-11-15 21:24:38");
INSERT INTO personal_access_tokens VALUES("401","App\Models\User","2","refresh","9cb235fe128bec8c15adffac7f94979038be997be2a9e63552149ce2963fd1bd","["*"]","","2025-12-15 21:28:30","2025-11-15 21:28:30","2025-11-15 21:28:30");
INSERT INTO personal_access_tokens VALUES("403","App\Models\User","2","refresh","9446323c34e52f99c3aa117c59c31d69e73cda0eeb7fe0e6426628deab347801","["*"]","","2025-12-15 21:30:26","2025-11-15 21:30:26","2025-11-15 21:30:26");
INSERT INTO personal_access_tokens VALUES("405","App\Models\User","2","refresh","580587585dcc23c925e14dfb4e3965250ecacc2fcd4a3220e136352abf85d315","["*"]","","2025-12-15 21:38:20","2025-11-15 21:38:20","2025-11-15 21:38:20");
INSERT INTO personal_access_tokens VALUES("407","App\Models\User","2","refresh","6197b62607fc218a3972f88b271c8bc319f1c91a979717a74619664cfdc8aa09","["*"]","","2025-12-15 21:42:29","2025-11-15 21:42:29","2025-11-15 21:42:29");
INSERT INTO personal_access_tokens VALUES("409","App\Models\User","2","refresh","eadcf9aa132da8bc685d3b1d0c99d18797c987f007d5abf5bb2c899ae795bc5f","["*"]","","2025-12-15 21:56:39","2025-11-15 21:56:39","2025-11-15 21:56:39");
INSERT INTO personal_access_tokens VALUES("411","App\Models\User","2","refresh","ad6558fb44eb1ac2d330b9ecb4f10a85651d285c1b575e8bd0c0ba7e61f1b78f","["*"]","","2025-12-15 22:02:25","2025-11-15 22:02:25","2025-11-15 22:02:25");
INSERT INTO personal_access_tokens VALUES("413","App\Models\User","2","refresh","3d1a4acd53703128dbe303d98d1b0929a8a946cd5a443cd8ed98876a17b627eb","["*"]","","2025-12-15 22:05:32","2025-11-15 22:05:32","2025-11-15 22:05:32");
INSERT INTO personal_access_tokens VALUES("415","App\Models\User","2","refresh","aaef99db8e0774bf89ae26e69c77783883073e11630ba9203afe394e09dbd603","["*"]","","2025-12-17 09:06:06","2025-11-17 09:06:06","2025-11-17 09:06:06");
INSERT INTO personal_access_tokens VALUES("417","App\Models\User","2","refresh","3f468251d54e77c8159c1ac7bf0ae57166a5957ac4b80049420c1790a5d75e62","["*"]","","2025-12-17 09:22:05","2025-11-17 09:22:05","2025-11-17 09:22:05");
INSERT INTO personal_access_tokens VALUES("419","App\Models\User","2","refresh","bb83d64e592324594b7b43e4e075926fdf9cf4cbe448b8ff6a149ab60928a3f8","["*"]","","2025-12-17 09:31:08","2025-11-17 09:31:08","2025-11-17 09:31:08");
INSERT INTO personal_access_tokens VALUES("421","App\Models\User","2","refresh","9940c2e6604cfaef47cbbd8f21eae2bf0645365b81c37497988121cf57a7b28d","["*"]","","2025-12-17 09:33:41","2025-11-17 09:33:41","2025-11-17 09:33:41");
INSERT INTO personal_access_tokens VALUES("423","App\Models\User","2","refresh","09c4e48289c6d913f42e9ffd317805f8a4854d4d1fb189489f2b4a590cb093c3","["*"]","","2025-12-17 09:41:34","2025-11-17 09:41:34","2025-11-17 09:41:34");
INSERT INTO personal_access_tokens VALUES("425","App\Models\User","2","refresh","42fd4e48e8194dae938b1adb129b004d63d8bc83c9344a5d03128e2012e141e1","["*"]","","2025-12-17 09:45:53","2025-11-17 09:45:53","2025-11-17 09:45:53");
INSERT INTO personal_access_tokens VALUES("427","App\Models\User","2","refresh","beb783e5bea183de96b736c0f669bd50a6b1955ef346b215722fae9ebbff9683","["*"]","","2025-12-17 09:54:17","2025-11-17 09:54:17","2025-11-17 09:54:17");
INSERT INTO personal_access_tokens VALUES("429","App\Models\User","2","refresh","c99aa015ef14b792b8e4c1276a68bea1f06d63deb0e8bc26a2d8552bf600cab6","["*"]","","2025-12-17 09:56:04","2025-11-17 09:56:04","2025-11-17 09:56:04");
INSERT INTO personal_access_tokens VALUES("431","App\Models\User","2","refresh","74042db57a4b466bd31234d7f47d7d561ebfc543aea2f3dabd789c6a04a5c279","["*"]","","2025-12-17 09:58:13","2025-11-17 09:58:13","2025-11-17 09:58:13");
INSERT INTO personal_access_tokens VALUES("433","App\Models\User","2","refresh","70192240528265094ce8ca6c14bf8d514918f6f9d692e3c2cd14dc631ebc9e5e","["*"]","","2025-12-17 09:58:27","2025-11-17 09:58:27","2025-11-17 09:58:27");
INSERT INTO personal_access_tokens VALUES("435","App\Models\User","2","refresh","2adefa67ebfcf9404739d30f5cc687493b227fb87247eaa13bac63d5f08b1ec0","["*"]","","2025-12-17 10:27:06","2025-11-17 10:27:06","2025-11-17 10:27:06");
INSERT INTO personal_access_tokens VALUES("437","App\Models\User","2","refresh","749a08f2bb68d0d648b853c399e834fbb0adc9c0913fcd5886751f3082c9b1ac","["*"]","","2025-12-17 10:27:37","2025-11-17 10:27:37","2025-11-17 10:27:37");
INSERT INTO personal_access_tokens VALUES("439","App\Models\User","2","refresh","ddd972cd5aa9e4d83625b997f81bdae4291ef4b7a876f3d7ccf6b52213379bc1","["*"]","","2025-12-17 10:33:00","2025-11-17 10:33:00","2025-11-17 10:33:00");
INSERT INTO personal_access_tokens VALUES("441","App\Models\User","2","refresh","0b8bfb5d82e3821c4910388b25cc855c2d85c6317d542f98ac205adeaa5365f3","["*"]","","2025-12-17 10:50:43","2025-11-17 10:50:43","2025-11-17 10:50:43");
INSERT INTO personal_access_tokens VALUES("443","App\Models\User","2","refresh","63eea6ec2e1116fc0c7cac4b4e5dbacae9219bd9514baf6e8a9f602630df3fe9","["*"]","","2025-12-17 11:06:14","2025-11-17 11:06:14","2025-11-17 11:06:14");
INSERT INTO personal_access_tokens VALUES("445","App\Models\User","2","refresh","48f2c5aab1834cfd5aa6b6bb47769980cc25fbd7a56d83a1fdcd7a528a702a8d","["*"]","","2025-12-17 11:07:37","2025-11-17 11:07:37","2025-11-17 11:07:37");
INSERT INTO personal_access_tokens VALUES("447","App\Models\User","2","refresh","e4bbf64382a2c8789dffead1ccee51338cfb08ed48ea907f647b819fced8a78c","["*"]","","2025-12-17 11:12:37","2025-11-17 11:12:37","2025-11-17 11:12:37");
INSERT INTO personal_access_tokens VALUES("449","App\Models\User","2","refresh","e9d5ccfcc294385b0317de0c84d8ca9a10d665e6de03e7e38a391619776254f5","["*"]","","2025-12-17 11:18:48","2025-11-17 11:18:48","2025-11-17 11:18:48");
INSERT INTO personal_access_tokens VALUES("451","App\Models\User","2","refresh","2b8576bc9efad304ff9e93d403d922dc59f6cc334209d617a08d61104a1ae912","["*"]","","2025-12-17 11:29:21","2025-11-17 11:29:21","2025-11-17 11:29:21");
INSERT INTO personal_access_tokens VALUES("453","App\Models\User","2","refresh","1d9c6c267cd763d8123466fe09236f00253c802a7a9ef61e0219944e1b7ba898","["*"]","","2025-12-17 11:47:15","2025-11-17 11:47:15","2025-11-17 11:47:15");
INSERT INTO personal_access_tokens VALUES("455","App\Models\User","2","refresh","4afa296b8cc53dd20c433d622665cd4c49bd6dcec3c5894c2757d0419cb00bf8","["*"]","","2025-12-17 11:49:23","2025-11-17 11:49:23","2025-11-17 11:49:23");
INSERT INTO personal_access_tokens VALUES("457","App\Models\User","2","refresh","44c4f5442939f215f12fa9f5878296c7071feb3d704f1c667d6633e2f9a28b24","["*"]","","2025-12-17 11:53:32","2025-11-17 11:53:32","2025-11-17 11:53:32");
INSERT INTO personal_access_tokens VALUES("459","App\Models\User","2","refresh","8908c835840982a6b779082526628d18e98b68dd46791641cce3aa7a5838b946","["*"]","","2025-12-17 12:27:42","2025-11-17 12:27:42","2025-11-17 12:27:42");
INSERT INTO personal_access_tokens VALUES("461","App\Models\User","2","refresh","a5986e1400d059881ef341169d05a80751100f45881a54f75aafbe712ae008c9","["*"]","","2025-12-17 12:35:56","2025-11-17 12:35:56","2025-11-17 12:35:56");
INSERT INTO personal_access_tokens VALUES("463","App\Models\User","2","refresh","56c32ab7ead66c6e69fef23a82f8a34faf2bac44dccefae2f04abbee41ea1b4f","["*"]","","2025-12-17 13:00:03","2025-11-17 13:00:03","2025-11-17 13:00:03");
INSERT INTO personal_access_tokens VALUES("465","App\Models\User","2","refresh","6bc96986d948688b651e97875395a93d1a4701d768b950191b1b3b69c14fb286","["*"]","","2025-12-17 14:05:34","2025-11-17 14:05:34","2025-11-17 14:05:34");
INSERT INTO personal_access_tokens VALUES("467","App\Models\User","2","refresh","5f4c3448be39c68ef53f4348632b9c8cf948deab028370c0874a3ab82561d41f","["*"]","","2025-12-17 14:39:31","2025-11-17 14:39:31","2025-11-17 14:39:31");
INSERT INTO personal_access_tokens VALUES("469","App\Models\User","2","refresh","6e8d85b92b38d28f9340b915ca9e7266951cf9f2c257bae332f700eedd57c1ae","["*"]","","2025-12-17 14:45:01","2025-11-17 14:45:01","2025-11-17 14:45:01");
INSERT INTO personal_access_tokens VALUES("471","App\Models\User","2","refresh","3c8c31f1a5ed3a722d3dd7d9ef9e09764ee9f742d9d66a0cac4c9aa66bc20a0f","["*"]","","2025-12-17 15:17:41","2025-11-17 15:17:41","2025-11-17 15:17:41");
INSERT INTO personal_access_tokens VALUES("473","App\Models\User","2","refresh","465849aee0266682ca3186f4fbe40fa4ee3516ac497facaac92ce4980d462a8a","["*"]","2025-11-17 15:19:25","2025-12-17 15:18:22","2025-11-17 15:18:22","2025-11-17 15:19:25");
INSERT INTO personal_access_tokens VALUES("476","App\Models\User","2","refresh","e39d6b126e1a14a08b8481a5f8098fddb9ce78728845932f5726bd410c6d1c13","["*"]","","2025-12-17 15:21:37","2025-11-17 15:21:37","2025-11-17 15:21:37");
INSERT INTO personal_access_tokens VALUES("478","App\Models\User","2","refresh","e3a23b88d794dd727eb8cae563012465a33b6c0e4313ee264936061c3b3b1c51","["*"]","","2025-12-17 15:25:50","2025-11-17 15:25:50","2025-11-17 15:25:50");
INSERT INTO personal_access_tokens VALUES("480","App\Models\User","2","refresh","7006c361fb2f04710299d45cb49840f53f825ebd00dc6f4400f85fac1124155f","["*"]","","2025-12-17 15:38:19","2025-11-17 15:38:19","2025-11-17 15:38:19");
INSERT INTO personal_access_tokens VALUES("482","App\Models\User","2","refresh","bfcfab1f228452ec993131994e503c054c3bfe6b4981dd3de1a080d014ffb2d2","["*"]","","2025-12-17 15:39:20","2025-11-17 15:39:20","2025-11-17 15:39:20");
INSERT INTO personal_access_tokens VALUES("484","App\Models\User","2","refresh","a4f6c68fe635ebd3554f36b2ba0874151d86160abebdcbb83690cbfbce93c6d3","["*"]","","2025-12-17 15:39:55","2025-11-17 15:39:55","2025-11-17 15:39:55");
INSERT INTO personal_access_tokens VALUES("486","App\Models\User","2","refresh","d3ce3fa611b6fe0cf33bc6a62e3fdb6f5a80138a019ffcff95e2d31a4c6c9a02","["*"]","","2025-12-17 15:48:10","2025-11-17 15:48:10","2025-11-17 15:48:10");
INSERT INTO personal_access_tokens VALUES("488","App\Models\User","2","refresh","26ab346621deeb411255dcd0123290ae4e6e6dfa94c931953715302eff5cc5c7","["*"]","","2025-12-17 15:54:12","2025-11-17 15:54:12","2025-11-17 15:54:12");
INSERT INTO personal_access_tokens VALUES("490","App\Models\User","2","refresh","3289d6b3ba4bc47a6743b5b34640da2c81e1355cd915b649b0a27955dafa61d7","["*"]","","2025-12-17 15:57:37","2025-11-17 15:57:37","2025-11-17 15:57:37");
INSERT INTO personal_access_tokens VALUES("492","App\Models\User","2","refresh","60c83dc0a0102c54a86cbd0c748f8707c74b29ffe44e3f5908a5d3db5c01a915","["*"]","","2025-12-17 16:02:34","2025-11-17 16:02:34","2025-11-17 16:02:34");
INSERT INTO personal_access_tokens VALUES("494","App\Models\User","2","refresh","92c5ae548be6a79db17a5e2472cb0d1281a048ad01a0f3de99c40d417aec19b0","["*"]","","2025-12-17 16:23:52","2025-11-17 16:23:52","2025-11-17 16:23:52");
INSERT INTO personal_access_tokens VALUES("496","App\Models\User","2","refresh","3b1df8ac9fe22468b94dab26cd68757ce4961442740991e18af050d0b4ee1452","["*"]","","2025-12-17 16:38:24","2025-11-17 16:38:24","2025-11-17 16:38:24");
INSERT INTO personal_access_tokens VALUES("498","App\Models\User","2","refresh","f750f0bbeb2727b57ea7a3521b285506fc5f33b32f56db167b1a29f41a883693","["*"]","","2025-12-17 16:50:31","2025-11-17 16:50:31","2025-11-17 16:50:31");
INSERT INTO personal_access_tokens VALUES("500","App\Models\User","2","refresh","00ace1baab4b5f0513ac71be4af81df1bea73587ad93dae141a6c28afeccdb96","["*"]","","2025-12-17 16:52:41","2025-11-17 16:52:41","2025-11-17 16:52:41");
INSERT INTO personal_access_tokens VALUES("502","App\Models\User","2","refresh","f5b3e3b18ea6470d27b448b0dc8e21954bd8a3b2b2a3858387bf66ed2dc7d419","["*"]","","2025-12-17 16:52:47","2025-11-17 16:52:47","2025-11-17 16:52:47");
INSERT INTO personal_access_tokens VALUES("504","App\Models\User","2","refresh","ee5c665988fc95534160290fe8c564785f2d2fc96e5532f5281d151d60af053f","["*"]","","2025-12-17 17:11:27","2025-11-17 17:11:27","2025-11-17 17:11:27");
INSERT INTO personal_access_tokens VALUES("506","App\Models\User","2","refresh","91d879c53f686167186a36e47fcf92f16ee55984da7a6da369e2debe75589ad1","["*"]","","2025-12-17 17:32:27","2025-11-17 17:32:27","2025-11-17 17:32:27");
INSERT INTO personal_access_tokens VALUES("508","App\Models\User","2","refresh","30ab9316a23e012bd2700cec32ee3021c37b362a0252c58a989655bfc64287ef","["*"]","","2025-12-17 17:38:50","2025-11-17 17:38:50","2025-11-17 17:38:50");
INSERT INTO personal_access_tokens VALUES("510","App\Models\User","2","refresh","7372a0701d81ad8f4ec9423145879dad625b35859712490efd7bd3436a5e70ea","["*"]","","2025-12-17 17:44:07","2025-11-17 17:44:07","2025-11-17 17:44:07");
INSERT INTO personal_access_tokens VALUES("512","App\Models\User","2","refresh","884390c8bfe58e9e7a92b54b5116b1eb042243c6a427e5792b88aeca84993f3e","["*"]","","2025-12-17 18:01:12","2025-11-17 18:01:12","2025-11-17 18:01:12");
INSERT INTO personal_access_tokens VALUES("514","App\Models\User","2","refresh","4d473d796db02ff6022633f5f19d5534ecacd8e5cebcad66f5db1ba9279f6dac","["*"]","","2025-12-17 18:12:37","2025-11-17 18:12:37","2025-11-17 18:12:37");
INSERT INTO personal_access_tokens VALUES("516","App\Models\User","2","refresh","0b0233440bb27ffb6a16fd2669dd32ba0e0edd5a2e9a1eff8bfa4aa37500c97d","["*"]","","2025-12-17 18:19:48","2025-11-17 18:19:48","2025-11-17 18:19:48");
INSERT INTO personal_access_tokens VALUES("518","App\Models\User","2","refresh","75b0479281cf5156d6475ca628032a7840322139437c841abfa09193823f19d4","["*"]","","2025-12-17 18:23:51","2025-11-17 18:23:51","2025-11-17 18:23:51");
INSERT INTO personal_access_tokens VALUES("520","App\Models\User","2","refresh","47353c9ccd4b9b928b9e4e14b8575162816c28f7adea51cf232e8bfcf7a2376e","["*"]","","2025-12-17 18:26:32","2025-11-17 18:26:32","2025-11-17 18:26:32");
INSERT INTO personal_access_tokens VALUES("522","App\Models\User","2","refresh","d9658e7037a962e67c5b76e1f028c2b42e4b401627ccee7ef08a5b31e90c5081","["*"]","","2025-12-17 18:29:01","2025-11-17 18:29:01","2025-11-17 18:29:01");
INSERT INTO personal_access_tokens VALUES("524","App\Models\User","2","refresh","e199af1c17b2eb1225a5d73446f15b62e54dd89587d6bf33b2bdd58f86fe5255","["*"]","","2025-12-17 18:34:17","2025-11-17 18:34:17","2025-11-17 18:34:17");
INSERT INTO personal_access_tokens VALUES("526","App\Models\User","2","refresh","74730612ac9f1b5c19913e0ecd5dff7cb580488a2ade54f24c7bb422dbeaed7e","["*"]","","2025-12-17 18:35:32","2025-11-17 18:35:32","2025-11-17 18:35:32");
INSERT INTO personal_access_tokens VALUES("528","App\Models\User","2","refresh","8f8db35548b20ecad49f06abe9cc61b0d2156fcb26dde2d43f1bdd2f0c22a682","["*"]","","2025-12-17 18:38:11","2025-11-17 18:38:11","2025-11-17 18:38:11");
INSERT INTO personal_access_tokens VALUES("530","App\Models\User","2","refresh","6a617adde503497a6facdeab7dbabd238f5f31d4da4fdd1613517faa8c5eb18c","["*"]","","2025-12-18 09:43:04","2025-11-18 09:43:04","2025-11-18 09:43:04");
INSERT INTO personal_access_tokens VALUES("532","App\Models\User","2","refresh","b03780f9dbe4e1d265c3aab0b836302b9bcb26ae2fa267fb2bcb0c2ef125f11c","["*"]","","2025-12-18 09:46:46","2025-11-18 09:46:46","2025-11-18 09:46:46");
INSERT INTO personal_access_tokens VALUES("534","App\Models\User","2","refresh","56e8bdcdd1a2a905116cfadf2b0d2b56beb6e929396fe3046f562fa5d7648744","["*"]","","2025-12-18 09:55:57","2025-11-18 09:55:57","2025-11-18 09:55:57");
INSERT INTO personal_access_tokens VALUES("536","App\Models\User","2","refresh","0a0aab5f9f3e517f62f4a5d24411ddfa4145e1e06947783c2f0df1be865e6c23","["*"]","","2025-12-18 09:57:20","2025-11-18 09:57:20","2025-11-18 09:57:20");
INSERT INTO personal_access_tokens VALUES("538","App\Models\User","2","refresh","460eef8978b38cc639271c8fe6c9daf7762de1bff6307ed1fb5b11d555433c06","["*"]","","2025-12-18 10:09:34","2025-11-18 10:09:34","2025-11-18 10:09:34");
INSERT INTO personal_access_tokens VALUES("540","App\Models\User","2","refresh","8b0f08228fc427ab72a4809d12cc6f3c1220135d386bf1ed76c8cbe32c95252a","["*"]","","2025-12-18 10:17:17","2025-11-18 10:17:17","2025-11-18 10:17:17");
INSERT INTO personal_access_tokens VALUES("542","App\Models\User","2","refresh","c44f615d1322de4604c4a54235c27e41e927cf8757a23eee80e2b3d340dd0268","["*"]","","2025-12-18 10:19:20","2025-11-18 10:19:20","2025-11-18 10:19:20");
INSERT INTO personal_access_tokens VALUES("544","App\Models\User","2","refresh","8d42d03e23652e4d2e6b4034626d5bdf93e9ca66c1ac002e075f944ff8bb482d","["*"]","","2025-12-18 10:49:19","2025-11-18 10:49:19","2025-11-18 10:49:19");
INSERT INTO personal_access_tokens VALUES("546","App\Models\User","2","refresh","e268da37f957c3871461d74fc0cd9637fa2ecb3ee2c62ed9c05f279d45dc0658","["*"]","","2025-12-18 10:51:08","2025-11-18 10:51:08","2025-11-18 10:51:08");
INSERT INTO personal_access_tokens VALUES("548","App\Models\User","2","refresh","4c0953b0e29dd810dfcdfa3880b9ab9f8778d2ad57e3afdab9926907a328b82e","["*"]","","2025-12-18 10:52:10","2025-11-18 10:52:10","2025-11-18 10:52:10");
INSERT INTO personal_access_tokens VALUES("550","App\Models\User","2","refresh","bf8d4c5cad110c5cf43ea7c07141f79f6bbf19f75eea0c8d3d15f77aa885dbb2","["*"]","","2025-12-18 11:06:43","2025-11-18 11:06:43","2025-11-18 11:06:43");
INSERT INTO personal_access_tokens VALUES("552","App\Models\User","2","refresh","4028495d1446e9aeb38d635ba851f4297cb51d3ae4d33f6ccf96422a9aa7e176","["*"]","","2025-12-18 11:07:31","2025-11-18 11:07:31","2025-11-18 11:07:31");
INSERT INTO personal_access_tokens VALUES("554","App\Models\User","2","refresh","02ee84afcb811ca48ea7f0b7180bd740baf348f763f83ee239ffee37551c46dc","["*"]","","2025-12-18 11:08:03","2025-11-18 11:08:03","2025-11-18 11:08:03");
INSERT INTO personal_access_tokens VALUES("556","App\Models\User","2","refresh","fc354281bec1bf8fe583ecff95c3e0a5b573ecfa382ac4bad2326b008bb8eb71","["*"]","","2025-12-18 11:12:43","2025-11-18 11:12:43","2025-11-18 11:12:43");
INSERT INTO personal_access_tokens VALUES("558","App\Models\User","2","refresh","de741c2aed961f7086fe17782469f7aad4000e528945c7d34a61b4ec3f9bad01","["*"]","","2025-12-18 11:16:07","2025-11-18 11:16:07","2025-11-18 11:16:07");
INSERT INTO personal_access_tokens VALUES("560","App\Models\User","2","refresh","b4cc3a92b1b0ef0d688463e0a98d68408efff890189d34cdf1e2332345876756","["*"]","","2025-12-18 11:22:36","2025-11-18 11:22:36","2025-11-18 11:22:36");
INSERT INTO personal_access_tokens VALUES("562","App\Models\User","2","refresh","c107f950e6ee7c2c4cb75b47878c9819a81fff77a1b607522ab3a3a41dbe1b9a","["*"]","","2025-12-18 11:23:06","2025-11-18 11:23:06","2025-11-18 11:23:06");
INSERT INTO personal_access_tokens VALUES("564","App\Models\User","2","refresh","37ce201cc2b32ac8894b4e8b6b57a2b2ee406d83b606ced5744237edf42f40c2","["*"]","","2025-12-18 11:25:12","2025-11-18 11:25:12","2025-11-18 11:25:12");
INSERT INTO personal_access_tokens VALUES("566","App\Models\User","2","refresh","42d5d17e70b550986fd56aa0f0309cb96e12f69ad2644691f92313cafe95b0f0","["*"]","","2025-12-18 11:36:47","2025-11-18 11:36:47","2025-11-18 11:36:47");
INSERT INTO personal_access_tokens VALUES("568","App\Models\User","2","refresh","3128984379799f0ddcb2a795cdcab0b5671e806ee42abad1ceb40ab19a17d99e","["*"]","","2025-12-18 11:37:27","2025-11-18 11:37:27","2025-11-18 11:37:27");
INSERT INTO personal_access_tokens VALUES("570","App\Models\User","2","refresh","965d140f4b844d5d4c409d8a4c6a13f1abb20b1107d7ad8492982550aff16c2f","["*"]","","2025-12-18 12:25:04","2025-11-18 12:25:04","2025-11-18 12:25:04");
INSERT INTO personal_access_tokens VALUES("571","App\Models\User","13","access","e0d39696389deae5b094b359438b6f20db112f079a8d6100e77340cb68e43274","["*"]","2025-11-18 12:52:32","2025-11-18 13:49:19","2025-11-18 12:49:19","2025-11-18 12:52:32");
INSERT INTO personal_access_tokens VALUES("572","App\Models\User","13","refresh","cb49c3b02dffbea6fc306725867750e50025d1e2709c2a32345002ef71031a4a","["*"]","","2025-12-18 12:49:19","2025-11-18 12:49:19","2025-11-18 12:49:19");
INSERT INTO personal_access_tokens VALUES("574","App\Models\User","2","refresh","1dda669726249269ed8cb07523dda8bd83c75e3c4aeb6cceff477a3dd813b07b","["*"]","","2025-12-18 12:52:57","2025-11-18 12:52:57","2025-11-18 12:52:57");
INSERT INTO personal_access_tokens VALUES("576","App\Models\User","2","refresh","434e987ba4dc7ca4b8ca880dced421be3b14aaaa2447f053848aab515d378457","["*"]","","2025-12-18 15:46:43","2025-11-18 15:46:43","2025-11-18 15:46:43");
INSERT INTO personal_access_tokens VALUES("578","App\Models\User","2","refresh","8c829dbdd43e67a850231e31e701f4a0c51810a3211708b61bbfc7aaa4b1c639","["*"]","","2025-12-18 15:52:46","2025-11-18 15:52:46","2025-11-18 15:52:46");
INSERT INTO personal_access_tokens VALUES("580","App\Models\User","2","refresh","d9eb0e86e019dfaa3523cb82caf6f60d431720c1e05ccf5410a43fcdc2ad6e57","["*"]","","2025-12-26 13:00:03","2025-11-26 13:00:03","2025-11-26 13:00:03");
INSERT INTO personal_access_tokens VALUES("582","App\Models\User","2","refresh","8af81ab3a2a98134c82496ab92cc6623d2098bdba812d3226ff5342198c01e28","["*"]","","2025-12-26 13:09:03","2025-11-26 13:09:03","2025-11-26 13:09:03");
INSERT INTO personal_access_tokens VALUES("584","App\Models\User","2","refresh","43b8daa9114e1e50ce17ea1cbe9610c953f1ded8a8f4a4ca1a100f08791edbf7","["*"]","","2025-12-26 17:28:24","2025-11-26 17:28:24","2025-11-26 17:28:24");
INSERT INTO personal_access_tokens VALUES("586","App\Models\User","2","refresh","1c17a540d161584e8176fa82a8ac3ec21f031c3049cd1567064515d82a591ccc","["*"]","","2025-12-26 17:51:54","2025-11-26 17:51:54","2025-11-26 17:51:54");
INSERT INTO personal_access_tokens VALUES("588","App\Models\User","2","refresh","1cbde0b6b6b2ca65f894a8281fb538445ad90d5b3b0abf672bf14295572b7b42","["*"]","","2025-12-26 18:17:48","2025-11-26 18:17:48","2025-11-26 18:17:48");
INSERT INTO personal_access_tokens VALUES("590","App\Models\User","2","refresh","96e808d380b73148803ff001cbced4ea9750ed6522c3a984659c8d71db47d3be","["*"]","","2025-12-26 18:18:10","2025-11-26 18:18:10","2025-11-26 18:18:10");
INSERT INTO personal_access_tokens VALUES("592","App\Models\User","2","refresh","1536b75e395d47412595c147506359439bc2ec6f0087a97beea73188861a0922","["*"]","","2025-12-26 18:19:14","2025-11-26 18:19:14","2025-11-26 18:19:14");
INSERT INTO personal_access_tokens VALUES("594","App\Models\User","2","refresh","5d790133b0f448724e61cdaaa58ded3dd2714cf07f5dc74383aa9e4e7ea7cd51","["*"]","","2025-12-26 18:25:49","2025-11-26 18:25:49","2025-11-26 18:25:49");
INSERT INTO personal_access_tokens VALUES("596","App\Models\User","2","refresh","3e7a41dc7444671b05e737e9702c0d0236a2f54db5e5a10f6df6c9c66b8d23cf","["*"]","","2025-12-26 18:37:04","2025-11-26 18:37:04","2025-11-26 18:37:04");
INSERT INTO personal_access_tokens VALUES("598","App\Models\User","2","refresh","31bd34f3dcea5255c2d593c901ba3e196f4dc1d9664ffff391e60327e18db5bf","["*"]","","2026-01-10 12:58:19","2025-12-11 12:58:19","2025-12-11 12:58:19");
INSERT INTO personal_access_tokens VALUES("600","App\Models\User","2","refresh","ca4954312bd1532fa357fc4b28859a508178461ebf1b724040719ab4675dcf03","["*"]","","2026-01-10 14:44:04","2025-12-11 14:44:04","2025-12-11 14:44:04");
INSERT INTO personal_access_tokens VALUES("602","App\Models\User","2","refresh","49911b2da4e225681e93c28b5149335481077136e3d130ceb791586592df3b96","["*"]","","2026-01-10 15:45:42","2025-12-11 15:45:42","2025-12-11 15:45:42");
INSERT INTO personal_access_tokens VALUES("604","App\Models\User","2","refresh","8b841e7f48c314122fc5292059a9443965ad673b11d5573219f0607ed42d99f3","["*"]","","2026-01-10 16:49:56","2025-12-11 16:49:56","2025-12-11 16:49:56");
INSERT INTO personal_access_tokens VALUES("606","App\Models\User","2","refresh","2ba243fb132a21e5bf075afd77f10f30ea03e7f4ab56f91817ec97db23e8f5cd","["*"]","","2026-01-10 18:08:15","2025-12-11 18:08:15","2025-12-11 18:08:15");
INSERT INTO personal_access_tokens VALUES("608","App\Models\User","2","refresh","46af93a18f4b62e51ecd51f269a91f441f48cbd8116ef6291b44fac3809bb4c1","["*"]","","2026-01-11 11:57:18","2025-12-12 11:57:18","2025-12-12 11:57:18");
INSERT INTO personal_access_tokens VALUES("610","App\Models\User","2","refresh","6390b615aabd7f2fd987703b9068159b455383b8f5faa59eff6ee6dcadcb10b7","["*"]","","2026-01-11 13:13:03","2025-12-12 13:13:03","2025-12-12 13:13:03");
INSERT INTO personal_access_tokens VALUES("612","App\Models\User","2","refresh","feb3766772026bc165ed56379b55fba3e2d4984661838b3603db02405608ed42","["*"]","","2026-01-11 14:14:35","2025-12-12 14:14:35","2025-12-12 14:14:35");
INSERT INTO personal_access_tokens VALUES("613","App\Models\User","2","access","5a3a90e228e554e1b099d0ae650e6ba2d68cb55389c5cc0231ca20213caf2906","["*"]","2025-12-12 16:54:01","2025-12-12 17:50:11","2025-12-12 16:50:11","2025-12-12 16:54:01");
INSERT INTO personal_access_tokens VALUES("614","App\Models\User","2","refresh","950ffb69e9ab5f706a6a8f8749e2453a5c213605c4440f1649d1d107d95f52ba","["*"]","","2026-01-11 16:50:11","2025-12-12 16:50:11","2025-12-12 16:50:11");



CREATE TABLE `role_has_permissions` (
  `permission_id` int unsigned NOT NULL,
  `role_id` int unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO role_has_permissions VALUES("4","1");
INSERT INTO role_has_permissions VALUES("5","1");
INSERT INTO role_has_permissions VALUES("6","1");
INSERT INTO role_has_permissions VALUES("7","1");
INSERT INTO role_has_permissions VALUES("8","1");
INSERT INTO role_has_permissions VALUES("9","1");
INSERT INTO role_has_permissions VALUES("10","1");
INSERT INTO role_has_permissions VALUES("11","1");
INSERT INTO role_has_permissions VALUES("12","1");
INSERT INTO role_has_permissions VALUES("13","1");
INSERT INTO role_has_permissions VALUES("14","1");
INSERT INTO role_has_permissions VALUES("15","1");
INSERT INTO role_has_permissions VALUES("16","1");
INSERT INTO role_has_permissions VALUES("17","1");
INSERT INTO role_has_permissions VALUES("18","1");
INSERT INTO role_has_permissions VALUES("19","1");
INSERT INTO role_has_permissions VALUES("20","1");
INSERT INTO role_has_permissions VALUES("21","1");
INSERT INTO role_has_permissions VALUES("22","1");
INSERT INTO role_has_permissions VALUES("23","1");
INSERT INTO role_has_permissions VALUES("24","1");
INSERT INTO role_has_permissions VALUES("25","1");
INSERT INTO role_has_permissions VALUES("26","1");
INSERT INTO role_has_permissions VALUES("27","1");
INSERT INTO role_has_permissions VALUES("28","1");
INSERT INTO role_has_permissions VALUES("29","1");
INSERT INTO role_has_permissions VALUES("30","1");
INSERT INTO role_has_permissions VALUES("31","1");
INSERT INTO role_has_permissions VALUES("32","1");
INSERT INTO role_has_permissions VALUES("33","1");
INSERT INTO role_has_permissions VALUES("34","1");
INSERT INTO role_has_permissions VALUES("35","1");
INSERT INTO role_has_permissions VALUES("36","1");
INSERT INTO role_has_permissions VALUES("37","1");
INSERT INTO role_has_permissions VALUES("38","1");
INSERT INTO role_has_permissions VALUES("39","1");
INSERT INTO role_has_permissions VALUES("40","1");
INSERT INTO role_has_permissions VALUES("41","1");
INSERT INTO role_has_permissions VALUES("42","1");
INSERT INTO role_has_permissions VALUES("43","1");
INSERT INTO role_has_permissions VALUES("44","1");
INSERT INTO role_has_permissions VALUES("45","1");
INSERT INTO role_has_permissions VALUES("46","1");
INSERT INTO role_has_permissions VALUES("47","1");
INSERT INTO role_has_permissions VALUES("48","1");
INSERT INTO role_has_permissions VALUES("49","1");
INSERT INTO role_has_permissions VALUES("50","1");
INSERT INTO role_has_permissions VALUES("51","1");
INSERT INTO role_has_permissions VALUES("52","1");
INSERT INTO role_has_permissions VALUES("53","1");
INSERT INTO role_has_permissions VALUES("54","1");
INSERT INTO role_has_permissions VALUES("55","1");
INSERT INTO role_has_permissions VALUES("56","1");
INSERT INTO role_has_permissions VALUES("57","1");
INSERT INTO role_has_permissions VALUES("58","1");
INSERT INTO role_has_permissions VALUES("59","1");
INSERT INTO role_has_permissions VALUES("60","1");
INSERT INTO role_has_permissions VALUES("61","1");
INSERT INTO role_has_permissions VALUES("62","1");
INSERT INTO role_has_permissions VALUES("63","1");
INSERT INTO role_has_permissions VALUES("64","1");
INSERT INTO role_has_permissions VALUES("65","1");
INSERT INTO role_has_permissions VALUES("66","1");
INSERT INTO role_has_permissions VALUES("67","1");
INSERT INTO role_has_permissions VALUES("68","1");
INSERT INTO role_has_permissions VALUES("69","1");
INSERT INTO role_has_permissions VALUES("70","1");
INSERT INTO role_has_permissions VALUES("71","1");
INSERT INTO role_has_permissions VALUES("72","1");
INSERT INTO role_has_permissions VALUES("73","1");
INSERT INTO role_has_permissions VALUES("74","1");
INSERT INTO role_has_permissions VALUES("75","1");
INSERT INTO role_has_permissions VALUES("76","1");
INSERT INTO role_has_permissions VALUES("77","1");
INSERT INTO role_has_permissions VALUES("78","1");
INSERT INTO role_has_permissions VALUES("79","1");
INSERT INTO role_has_permissions VALUES("80","1");
INSERT INTO role_has_permissions VALUES("81","1");
INSERT INTO role_has_permissions VALUES("82","1");
INSERT INTO role_has_permissions VALUES("83","1");
INSERT INTO role_has_permissions VALUES("84","1");
INSERT INTO role_has_permissions VALUES("85","1");
INSERT INTO role_has_permissions VALUES("86","1");
INSERT INTO role_has_permissions VALUES("87","1");
INSERT INTO role_has_permissions VALUES("88","1");
INSERT INTO role_has_permissions VALUES("89","1");
INSERT INTO role_has_permissions VALUES("90","1");
INSERT INTO role_has_permissions VALUES("91","1");
INSERT INTO role_has_permissions VALUES("92","1");
INSERT INTO role_has_permissions VALUES("93","1");
INSERT INTO role_has_permissions VALUES("94","1");
INSERT INTO role_has_permissions VALUES("95","1");
INSERT INTO role_has_permissions VALUES("96","1");
INSERT INTO role_has_permissions VALUES("97","1");
INSERT INTO role_has_permissions VALUES("98","1");
INSERT INTO role_has_permissions VALUES("99","1");
INSERT INTO role_has_permissions VALUES("100","1");
INSERT INTO role_has_permissions VALUES("101","1");
INSERT INTO role_has_permissions VALUES("102","1");
INSERT INTO role_has_permissions VALUES("103","1");
INSERT INTO role_has_permissions VALUES("104","1");
INSERT INTO role_has_permissions VALUES("105","1");
INSERT INTO role_has_permissions VALUES("106","1");
INSERT INTO role_has_permissions VALUES("107","1");
INSERT INTO role_has_permissions VALUES("108","1");
INSERT INTO role_has_permissions VALUES("109","1");
INSERT INTO role_has_permissions VALUES("110","1");
INSERT INTO role_has_permissions VALUES("111","1");
INSERT INTO role_has_permissions VALUES("112","1");
INSERT INTO role_has_permissions VALUES("113","1");
INSERT INTO role_has_permissions VALUES("114","1");
INSERT INTO role_has_permissions VALUES("115","1");
INSERT INTO role_has_permissions VALUES("116","1");
INSERT INTO role_has_permissions VALUES("117","1");
INSERT INTO role_has_permissions VALUES("118","1");
INSERT INTO role_has_permissions VALUES("119","1");
INSERT INTO role_has_permissions VALUES("120","1");
INSERT INTO role_has_permissions VALUES("121","1");
INSERT INTO role_has_permissions VALUES("122","1");
INSERT INTO role_has_permissions VALUES("123","1");
INSERT INTO role_has_permissions VALUES("124","1");
INSERT INTO role_has_permissions VALUES("125","1");
INSERT INTO role_has_permissions VALUES("126","1");
INSERT INTO role_has_permissions VALUES("127","1");
INSERT INTO role_has_permissions VALUES("128","1");
INSERT INTO role_has_permissions VALUES("129","1");
INSERT INTO role_has_permissions VALUES("130","1");
INSERT INTO role_has_permissions VALUES("131","1");
INSERT INTO role_has_permissions VALUES("132","1");
INSERT INTO role_has_permissions VALUES("133","1");
INSERT INTO role_has_permissions VALUES("134","1");
INSERT INTO role_has_permissions VALUES("135","1");
INSERT INTO role_has_permissions VALUES("136","1");
INSERT INTO role_has_permissions VALUES("137","1");
INSERT INTO role_has_permissions VALUES("138","1");
INSERT INTO role_has_permissions VALUES("139","1");
INSERT INTO role_has_permissions VALUES("140","1");
INSERT INTO role_has_permissions VALUES("141","1");
INSERT INTO role_has_permissions VALUES("145","1");
INSERT INTO role_has_permissions VALUES("146","1");
INSERT INTO role_has_permissions VALUES("147","1");
INSERT INTO role_has_permissions VALUES("148","1");
INSERT INTO role_has_permissions VALUES("149","1");
INSERT INTO role_has_permissions VALUES("150","1");
INSERT INTO role_has_permissions VALUES("151","1");
INSERT INTO role_has_permissions VALUES("152","1");
INSERT INTO role_has_permissions VALUES("153","1");
INSERT INTO role_has_permissions VALUES("154","1");
INSERT INTO role_has_permissions VALUES("155","1");
INSERT INTO role_has_permissions VALUES("156","1");
INSERT INTO role_has_permissions VALUES("157","1");
INSERT INTO role_has_permissions VALUES("158","1");
INSERT INTO role_has_permissions VALUES("159","1");
INSERT INTO role_has_permissions VALUES("160","1");
INSERT INTO role_has_permissions VALUES("161","1");
INSERT INTO role_has_permissions VALUES("162","1");
INSERT INTO role_has_permissions VALUES("163","1");
INSERT INTO role_has_permissions VALUES("164","1");
INSERT INTO role_has_permissions VALUES("165","1");
INSERT INTO role_has_permissions VALUES("166","1");
INSERT INTO role_has_permissions VALUES("167","1");
INSERT INTO role_has_permissions VALUES("168","1");
INSERT INTO role_has_permissions VALUES("169","1");
INSERT INTO role_has_permissions VALUES("170","1");
INSERT INTO role_has_permissions VALUES("171","1");
INSERT INTO role_has_permissions VALUES("172","1");
INSERT INTO role_has_permissions VALUES("173","1");
INSERT INTO role_has_permissions VALUES("174","1");
INSERT INTO role_has_permissions VALUES("175","1");
INSERT INTO role_has_permissions VALUES("176","1");
INSERT INTO role_has_permissions VALUES("177","1");
INSERT INTO role_has_permissions VALUES("178","1");
INSERT INTO role_has_permissions VALUES("179","1");
INSERT INTO role_has_permissions VALUES("180","1");
INSERT INTO role_has_permissions VALUES("181","1");
INSERT INTO role_has_permissions VALUES("4","2");
INSERT INTO role_has_permissions VALUES("5","2");
INSERT INTO role_has_permissions VALUES("6","2");
INSERT INTO role_has_permissions VALUES("7","2");
INSERT INTO role_has_permissions VALUES("8","2");
INSERT INTO role_has_permissions VALUES("9","2");
INSERT INTO role_has_permissions VALUES("10","2");
INSERT INTO role_has_permissions VALUES("11","2");
INSERT INTO role_has_permissions VALUES("12","2");
INSERT INTO role_has_permissions VALUES("13","2");
INSERT INTO role_has_permissions VALUES("14","2");
INSERT INTO role_has_permissions VALUES("15","2");
INSERT INTO role_has_permissions VALUES("16","2");
INSERT INTO role_has_permissions VALUES("17","2");
INSERT INTO role_has_permissions VALUES("18","2");
INSERT INTO role_has_permissions VALUES("19","2");
INSERT INTO role_has_permissions VALUES("20","2");
INSERT INTO role_has_permissions VALUES("21","2");
INSERT INTO role_has_permissions VALUES("22","2");
INSERT INTO role_has_permissions VALUES("23","2");
INSERT INTO role_has_permissions VALUES("24","2");
INSERT INTO role_has_permissions VALUES("25","2");
INSERT INTO role_has_permissions VALUES("26","2");
INSERT INTO role_has_permissions VALUES("27","2");
INSERT INTO role_has_permissions VALUES("28","2");
INSERT INTO role_has_permissions VALUES("29","2");
INSERT INTO role_has_permissions VALUES("30","2");
INSERT INTO role_has_permissions VALUES("31","2");
INSERT INTO role_has_permissions VALUES("32","2");
INSERT INTO role_has_permissions VALUES("33","2");
INSERT INTO role_has_permissions VALUES("34","2");
INSERT INTO role_has_permissions VALUES("35","2");
INSERT INTO role_has_permissions VALUES("36","2");
INSERT INTO role_has_permissions VALUES("37","2");
INSERT INTO role_has_permissions VALUES("38","2");
INSERT INTO role_has_permissions VALUES("39","2");
INSERT INTO role_has_permissions VALUES("40","2");
INSERT INTO role_has_permissions VALUES("41","2");
INSERT INTO role_has_permissions VALUES("42","2");
INSERT INTO role_has_permissions VALUES("43","2");
INSERT INTO role_has_permissions VALUES("44","2");
INSERT INTO role_has_permissions VALUES("45","2");
INSERT INTO role_has_permissions VALUES("46","2");
INSERT INTO role_has_permissions VALUES("47","2");
INSERT INTO role_has_permissions VALUES("48","2");
INSERT INTO role_has_permissions VALUES("49","2");
INSERT INTO role_has_permissions VALUES("50","2");
INSERT INTO role_has_permissions VALUES("51","2");
INSERT INTO role_has_permissions VALUES("52","2");
INSERT INTO role_has_permissions VALUES("53","2");
INSERT INTO role_has_permissions VALUES("54","2");
INSERT INTO role_has_permissions VALUES("55","2");
INSERT INTO role_has_permissions VALUES("56","2");
INSERT INTO role_has_permissions VALUES("57","2");
INSERT INTO role_has_permissions VALUES("58","2");
INSERT INTO role_has_permissions VALUES("59","2");
INSERT INTO role_has_permissions VALUES("60","2");
INSERT INTO role_has_permissions VALUES("61","2");
INSERT INTO role_has_permissions VALUES("62","2");
INSERT INTO role_has_permissions VALUES("63","2");
INSERT INTO role_has_permissions VALUES("64","2");
INSERT INTO role_has_permissions VALUES("65","2");
INSERT INTO role_has_permissions VALUES("66","2");
INSERT INTO role_has_permissions VALUES("67","2");
INSERT INTO role_has_permissions VALUES("68","2");
INSERT INTO role_has_permissions VALUES("69","2");
INSERT INTO role_has_permissions VALUES("70","2");
INSERT INTO role_has_permissions VALUES("71","2");
INSERT INTO role_has_permissions VALUES("72","2");
INSERT INTO role_has_permissions VALUES("73","2");
INSERT INTO role_has_permissions VALUES("74","2");
INSERT INTO role_has_permissions VALUES("75","2");
INSERT INTO role_has_permissions VALUES("76","2");
INSERT INTO role_has_permissions VALUES("77","2");
INSERT INTO role_has_permissions VALUES("78","2");
INSERT INTO role_has_permissions VALUES("79","2");
INSERT INTO role_has_permissions VALUES("80","2");
INSERT INTO role_has_permissions VALUES("81","2");
INSERT INTO role_has_permissions VALUES("82","2");
INSERT INTO role_has_permissions VALUES("83","2");
INSERT INTO role_has_permissions VALUES("84","2");
INSERT INTO role_has_permissions VALUES("85","2");
INSERT INTO role_has_permissions VALUES("86","2");
INSERT INTO role_has_permissions VALUES("87","2");
INSERT INTO role_has_permissions VALUES("88","2");
INSERT INTO role_has_permissions VALUES("89","2");
INSERT INTO role_has_permissions VALUES("90","2");
INSERT INTO role_has_permissions VALUES("91","2");
INSERT INTO role_has_permissions VALUES("92","2");
INSERT INTO role_has_permissions VALUES("93","2");
INSERT INTO role_has_permissions VALUES("94","2");
INSERT INTO role_has_permissions VALUES("95","2");
INSERT INTO role_has_permissions VALUES("96","2");
INSERT INTO role_has_permissions VALUES("97","2");
INSERT INTO role_has_permissions VALUES("98","2");
INSERT INTO role_has_permissions VALUES("99","2");
INSERT INTO role_has_permissions VALUES("100","2");
INSERT INTO role_has_permissions VALUES("101","2");
INSERT INTO role_has_permissions VALUES("102","2");
INSERT INTO role_has_permissions VALUES("103","2");
INSERT INTO role_has_permissions VALUES("104","2");
INSERT INTO role_has_permissions VALUES("105","2");
INSERT INTO role_has_permissions VALUES("106","2");
INSERT INTO role_has_permissions VALUES("107","2");
INSERT INTO role_has_permissions VALUES("108","2");
INSERT INTO role_has_permissions VALUES("109","2");
INSERT INTO role_has_permissions VALUES("110","2");
INSERT INTO role_has_permissions VALUES("111","2");
INSERT INTO role_has_permissions VALUES("112","2");
INSERT INTO role_has_permissions VALUES("113","2");
INSERT INTO role_has_permissions VALUES("114","2");
INSERT INTO role_has_permissions VALUES("115","2");
INSERT INTO role_has_permissions VALUES("116","2");
INSERT INTO role_has_permissions VALUES("117","2");
INSERT INTO role_has_permissions VALUES("118","2");
INSERT INTO role_has_permissions VALUES("119","2");
INSERT INTO role_has_permissions VALUES("120","2");
INSERT INTO role_has_permissions VALUES("121","2");
INSERT INTO role_has_permissions VALUES("122","2");
INSERT INTO role_has_permissions VALUES("123","2");
INSERT INTO role_has_permissions VALUES("124","2");
INSERT INTO role_has_permissions VALUES("125","2");
INSERT INTO role_has_permissions VALUES("126","2");
INSERT INTO role_has_permissions VALUES("127","2");
INSERT INTO role_has_permissions VALUES("128","2");
INSERT INTO role_has_permissions VALUES("129","2");
INSERT INTO role_has_permissions VALUES("130","2");
INSERT INTO role_has_permissions VALUES("131","2");
INSERT INTO role_has_permissions VALUES("132","2");
INSERT INTO role_has_permissions VALUES("133","2");
INSERT INTO role_has_permissions VALUES("134","2");
INSERT INTO role_has_permissions VALUES("135","2");
INSERT INTO role_has_permissions VALUES("136","2");
INSERT INTO role_has_permissions VALUES("137","2");
INSERT INTO role_has_permissions VALUES("138","2");
INSERT INTO role_has_permissions VALUES("139","2");
INSERT INTO role_has_permissions VALUES("141","2");
INSERT INTO role_has_permissions VALUES("4","4");
INSERT INTO role_has_permissions VALUES("6","4");
INSERT INTO role_has_permissions VALUES("7","4");
INSERT INTO role_has_permissions VALUES("8","4");
INSERT INTO role_has_permissions VALUES("9","4");
INSERT INTO role_has_permissions VALUES("12","4");
INSERT INTO role_has_permissions VALUES("13","4");
INSERT INTO role_has_permissions VALUES("14","4");
INSERT INTO role_has_permissions VALUES("20","4");
INSERT INTO role_has_permissions VALUES("21","4");
INSERT INTO role_has_permissions VALUES("22","4");
INSERT INTO role_has_permissions VALUES("24","4");
INSERT INTO role_has_permissions VALUES("25","4");
INSERT INTO role_has_permissions VALUES("28","4");
INSERT INTO role_has_permissions VALUES("29","4");
INSERT INTO role_has_permissions VALUES("55","4");
INSERT INTO role_has_permissions VALUES("56","4");
INSERT INTO role_has_permissions VALUES("57","4");
INSERT INTO role_has_permissions VALUES("63","4");
INSERT INTO role_has_permissions VALUES("64","4");
INSERT INTO role_has_permissions VALUES("89","4");
INSERT INTO role_has_permissions VALUES("106","4");



CREATE TABLE `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bus_config_id` int NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO roles VALUES("1","Admin","admin can access all data...","web","1","1","2018-06-02 04:46:44","2018-06-03 04:13:05");
INSERT INTO roles VALUES("2","Owner","Staff of shop","web","1","1","2018-10-22 07:38:13","2022-02-01 18:13:30");
INSERT INTO roles VALUES("4","staff","staff has specific acess...","web","1","1","2018-06-02 05:05:27","2022-02-01 18:13:04");
INSERT INTO roles VALUES("5","Customer","","web","1","1","2020-11-05 11:43:16","2025-01-29 16:40:54");
INSERT INTO roles VALUES("6","Test 1","test","web","1","0","2026-01-01 14:52:55","2026-01-01 15:06:51");
INSERT INTO roles VALUES("7","test","dsaf","web","1","0","2026-01-01 15:07:05","2026-01-01 15:12:49");



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

INSERT INTO sandbox_scenarios VALUES("1","SN001","Goods at standard rate to registered buyers","Goods at standard rate (default)","","");
INSERT INTO sandbox_scenarios VALUES("2","SN002","Goods at standard rate to unregistered buyers","Goods at standard rate (default)","","");
INSERT INTO sandbox_scenarios VALUES("3","SN003","Sale of Steel (Melted and Re-Rolled)","Steel Melting and re-rolling","","");
INSERT INTO sandbox_scenarios VALUES("4","SN004","Sale by Ship Breakers","Ship breaking","","");
INSERT INTO sandbox_scenarios VALUES("5","SN005","Reduced rate sale","Goods at Reduced Rate","","");
INSERT INTO sandbox_scenarios VALUES("6","SN006","Exempt goods sale","Exempt Goods","","");
INSERT INTO sandbox_scenarios VALUES("7","SN007","Zero rated sale","Goods at zero-rate","","");
INSERT INTO sandbox_scenarios VALUES("8","SN008","Sale of 3rd schedule goods","3rd Schedule Goods","","");
INSERT INTO sandbox_scenarios VALUES("9","SN009","Cotton Spinners purchase from Cotton Ginners (Textile Sector)","Cotton Ginners","","");
INSERT INTO sandbox_scenarios VALUES("10","SN010","Mobile Operators adds Sale (Telecom Sector)","Telecommunication services","","");
INSERT INTO sandbox_scenarios VALUES("11","SN011","Toll Manufacturing sale by Steel sector","Toll Manufacturing","","");
INSERT INTO sandbox_scenarios VALUES("12","SN012","Sale of Petroleum products","Petroleum Products","","");
INSERT INTO sandbox_scenarios VALUES("13","SN013","Electricity Supply to Retailers","Electricity Supply to Retailers","","");
INSERT INTO sandbox_scenarios VALUES("14","SN014","Sale of Gas to CNG stations","Gas to CNG stations","","");
INSERT INTO sandbox_scenarios VALUES("15","SN015","Sale of mobile phones","Mobile Phones","","");
INSERT INTO sandbox_scenarios VALUES("16","SN016","Processing / Conversion of Goods","Processing/ Conversion of Goods","","");
INSERT INTO sandbox_scenarios VALUES("17","SN017","Sale of Goods where FED is charged in ST mode","Goods (FED in ST Mode)","","");
INSERT INTO sandbox_scenarios VALUES("18","SN018","Sale of Services where FED is charged in ST mode","Services (FED in ST Mode)","","");
INSERT INTO sandbox_scenarios VALUES("19","SN019","Sale of Services","Services","","");
INSERT INTO sandbox_scenarios VALUES("20","SN020","Sale of Electric Vehicles","Electric Vehicle","","");
INSERT INTO sandbox_scenarios VALUES("21","SN021","Sale of Cement /Concrete Block","Cement /Concrete Block","","");
INSERT INTO sandbox_scenarios VALUES("22","SN022","Sale of Potassium Chlorate","Potassium Chlorate","","");
INSERT INTO sandbox_scenarios VALUES("23","SN023","Sale of CNG","CNG Sales","","");
INSERT INTO sandbox_scenarios VALUES("24","SN024","Goods sold that are listed in SRO 297(1)/2023","Goods as per SRO.297(1)/2023","","");
INSERT INTO sandbox_scenarios VALUES("25","SN025","Drugs sold at fixed ST rate under serial 81 of Eighth Schedule Table 1","Non-Adjustable Supplies","","");
INSERT INTO sandbox_scenarios VALUES("26","SN026","Sale to End Consumer by retailers","Goods at Standard Rate (default)","","");
INSERT INTO sandbox_scenarios VALUES("27","SN027","Sale to End Consumer by retailers","3rd Schedule Goods","","");
INSERT INTO sandbox_scenarios VALUES("28","SN028","Sale to End Consumer by retailers","Goods at Reduced Rate","","");



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

INSERT INTO sessions VALUES("FTTTfcMkuybBlCiaHN8FklInKzRm4NOzHl3EJR80","2","127.0.0.1","Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36","YToxMzp7czo2OiJfdG9rZW4iO3M6NDA6Ikl5VlBaR0RyS3FEakFwYXNxcmZON2ZHRFdWZlV5SVRZTVFPMzZiQjMiO3M6MzoidXJsIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xlZGdlciI7czo1OiJyb3V0ZSI7czoxMjoibGVkZ2VyLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6InRlbmFudF9pZCI7aToxO3M6MTM6ImJ1c19jb25maWdfaWQiO2k6MTtzOjk6InRlbmFudF9kYiI7czoxMDoidGF4X2JyaWRnZSI7czo4OiJidXNfbmFtZSI7czoxNzoiU2VjdXJlaXNtIFB2dCBMdGQiO3M6ODoiaXNfdHJpYWwiO2k6MDtzOjE0OiJ0cmlhbF9lbmRfZGF0ZSI7TjtzOjEwOiJzdGFydF9kYXRlIjtzOjEwOiIyMDI1LTEyLTE4IjtzOjg6ImVuZF9kYXRlIjtzOjEwOiIyMDI2LTAxLTE4Ijt9","1766122215");



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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users VALUES("1","admin","admin@admin.com","$2y$10$D3NNYjFpxZ/7ve5fTVs.k.6cH5AfPyPC1JL7/G8NQoVcTPvt9nZoa","qtvG6pTQ5tpPnVf8HClb6DcEOCQvDEh26xSzpjNGZuFdg8bBfGJ5E4kajFQF","12112","TaxBridge","1","","","1","1","0","2018-06-02 03:24:15","2026-01-01 15:48:48");
INSERT INTO users VALUES("50","Hammad Ali","hammad.ali@f3technologies.eu","$2y$10$p.zK0AkgDiBJGVwqxkeLdehN8g9261PYaeaP2QMT/23MhYlNA8Nbm","","03005325195","Secureism Pvt Ltd","1","","","2","1","0","2025-12-26 06:13:51","2025-12-26 06:13:51");

