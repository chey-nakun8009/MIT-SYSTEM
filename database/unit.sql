-- Database: MySQL / MariaDB
-- Table structure for table `units` with default store_id = 1

DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT '1',
  `name` varchar(100) NOT NULL,
  `symbol` varchar(20) NOT NULL,
  `type` varchar(30) NOT NULL,
  `decimal_places` tinyint unsigned NOT NULL DEFAULT '3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `units_store_id_foreign` (`store_id`),
  KEY `units_store_id_symbol_index` (`store_id`, `symbol`),
  CONSTRAINT `units_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;