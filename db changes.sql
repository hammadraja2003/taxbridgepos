ALTER TABLE pos_master_db.users
ADD COLUMN `two_factor_enabled` TINYINT(1) NOT NULL DEFAULT 0 AFTER `is_deleted`,
ADD COLUMN `two_factor_secret` TEXT NULL AFTER `two_factor_enabled`,
ADD COLUMN `two_factor_recovery_codes` TEXT NULL AFTER `two_factor_secret`,
ADD COLUMN `two_factor_confirmed_at` TIMESTAMP NULL DEFAULT NULL AFTER `two_factor_recovery_codes`;