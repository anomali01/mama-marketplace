SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` VALUES 
(1,'Elektronik','Laptop, HP, Charger, Earphone, dll','💻','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(2,'Buku & Alat Tulis','Buku kuliah, novel, ATK, dll','📚','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(3,'Fashion','Pakaian, tas, sepatu, aksesoris','👕','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(4,'Makanan & Minuman','Snack, minuman, makanan ringan','🍔','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(5,'Kost & Furniture','Perabotan kost, kasur, meja, kursi','🛏️','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(6,'Jasa','Jasa ketik, desain, programming, dll','🛠️','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(7,'Olahraga','Alat olahraga, jersey, sepatu sport','⚽','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(8,'Kecantikan','Skincare, makeup, parfum','💄','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(9,'Kendaraan','Motor, sepeda, helm, aksesoris','🏍️','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(10,'Lainnya','Barang lain yang tidak masuk kategori','📦','2025-12-27 16:58:53','2025-12-27 16:58:53');

DROP TABLE IF EXISTS `prodis`;
CREATE TABLE `prodis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `faculty` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `prodis` VALUES 
(1,'Teknik Informatika','Fakultas Teknik','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(2,'Sistem Informasi','Fakultas Teknik','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(3,'Teknik Elektro','Fakultas Teknik','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(4,'Teknik Mesin','Fakultas Teknik','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(5,'Teknik Sipil','Fakultas Teknik','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(6,'Manajemen','Fakultas Ekonomi dan Bisnis','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(7,'Akuntansi','Fakultas Ekonomi dan Bisnis','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(8,'Ekonomi Pembangunan','Fakultas Ekonomi dan Bisnis','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(9,'Ilmu Hukum','Fakultas Hukum','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(10,'Kedokteran','Fakultas Kedokteran','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(11,'Keperawatan','Fakultas Kedokteran','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(12,'Farmasi','Fakultas Kedokteran','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(13,'Ilmu Komunikasi','Fakultas Ilmu Sosial dan Politik','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(14,'Administrasi Publik','Fakultas Ilmu Sosial dan Politik','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(15,'Hubungan Internasional','Fakultas Ilmu Sosial dan Politik','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(16,'Psikologi','Fakultas Psikologi','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(17,'Pendidikan Matematika','Fakultas Keguruan dan Ilmu Pendidikan','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(18,'Pendidikan Bahasa Inggris','Fakultas Keguruan dan Ilmu Pendidikan','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(19,'Pendidikan Bahasa Indonesia','Fakultas Keguruan dan Ilmu Pendidikan','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(20,'Agroteknologi','Fakultas Pertanian','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(21,'Agribisnis','Fakultas Pertanian','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(22,'Arsitektur','Fakultas Teknik','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(23,'Desain Komunikasi Visual','Fakultas Desain','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(24,'Desain Interior','Fakultas Desain','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(25,'Sastra Inggris','Fakultas Sastra','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(26,'Sastra Indonesia','Fakultas Sastra','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(27,'Matematika','Fakultas MIPA','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(28,'Fisika','Fakultas MIPA','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(29,'Kimia','Fakultas MIPA','2025-12-27 16:58:53','2025-12-27 16:58:53'),
(30,'Biologi','Fakultas MIPA','2025-12-27 16:58:53','2025-12-27 16:58:53');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','validator','admin') NOT NULL DEFAULT 'mahasiswa',
  `nim` varchar(20) DEFAULT NULL,
  `prodi` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `shop_description` text,
  `shop_address` text,
  `shop_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nim_unique` (`nim`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` VALUES 
(1,'Abinaya','abinaya@gmail.com','$2y$12$XuNH/aE5P1NhzwP46bxOY.wuqpfB4RpROVTn35WCZvnDJZR5OiqN6','mahasiswa','22TK12312','Teknik Informatika','085156347252',1,NULL,'E0hwAaOtKz34fFLMl1OJTnlCPfAJ2PZGWjILZ4MLuMMlLFhwH99MCHdU2mYe','2025-12-27 16:58:54','2025-12-30 04:53:02',NULL,NULL,NULL,NULL),
(10,'Dinda','dinda@gmail.com','$2y$12$cQYxWdNR.pv3L9.j0tU7g.zJRrxoP8lFMbVJCbE0YGKS3LsD4K22e','mahasiswa','22TK039','Teknik Informatika','09182323',1,NULL,NULL,'2025-12-28 13:27:53','2025-12-28 13:27:53',NULL,NULL,NULL,NULL),
(11,'admin','admin@mama.com','$2y$12$g8LxFJl5T8YJkT0gq4ORe.NvF6fXVBgXBcNY8hL1QLVKF6dZb8SKK','admin',NULL,NULL,NULL,1,NULL,NULL,'2025-12-28 13:36:58','2025-12-28 13:36:58',NULL,NULL,NULL,NULL);

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(12,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '1',
  `image` varchar(255) DEFAULT NULL,
  `seller_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending_verif',
  `rejection_reason` text,
  `condition` enum('new','second') NOT NULL DEFAULT 'second',
  `views` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_seller_id_foreign` (`seller_id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` VALUES 
(1,'Laptop bekas Asus','baru dipake 2 minggu',4000000.00,1,'products/product_1_1735365565.jpg',1,1,'verified',NULL,'second',8,'2025-12-28 02:39:25','2025-12-29 12:49:31'),
(2,'Charger 25 watt','charger baru dibeli',50000.00,3,'products/product_1_1735365652.png',1,1,'verified',NULL,'new',1,'2025-12-28 02:40:52','2025-12-29 04:31:13'),
(3,'Jam Fossil Original','jam tangan ori, masih baru',1500000.00,1,'products/product_1_1735365884.jpg',1,3,'verified',NULL,'new',5,'2025-12-28 02:44:44','2025-12-29 04:31:18'),
(4,'Earphone Gaming','earphone buat gaming',250000.00,2,'products/product_10_1735405038.png',10,1,'verified',NULL,'new',0,'2025-12-28 13:37:18','2025-12-28 13:52:50');

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint unsigned NOT NULL,
  `seller_id` bigint unsigned NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `status` enum('pending','processing','shipped','completed','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT 'unpaid',
  `paid_at` timestamp NULL DEFAULT NULL,
  `shipping_address` text,
  `shipping_method` varchar(50) DEFAULT NULL,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping_tracking` varchar(100) DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_buyer_id_foreign` (`buyer_id`),
  KEY `orders_seller_id_foreign` (`seller_id`),
  CONSTRAINT `orders_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `orders` VALUES 
(1,10,1,4000000.00,'completed',NULL,'2025-12-28 13:39:25','2025-12-29 04:21:29','Transfer Bank','paid','2025-12-28 13:46:13',NULL,NULL,0.00,NULL,NULL,NULL),
(2,10,1,1500000.00,'shipped',NULL,'2025-12-29 04:07:28','2025-12-29 05:00:07','COD','paid','2025-12-29 04:13:39','kampus merdeka, Blok J','JNE Regular',15000.00,'JNE123456789','2025-12-29 05:00:07',NULL);

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `order_items` VALUES 
(1,1,1,1,4000000.00,'2025-12-28 13:39:25','2025-12-28 13:39:25'),
(2,2,3,1,1500000.00,'2025-12-29 04:07:28','2025-12-29 04:07:28');

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint unsigned NOT NULL,
  `receiver_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `message` text,
  `attachment` varchar(255) DEFAULT NULL,
  `attachment_type` varchar(255) DEFAULT NULL,
  `attachment_name` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_order_id_foreign` (`order_id`),
  KEY `messages_sender_id_receiver_id_index` (`sender_id`,`receiver_id`),
  KEY `messages_receiver_id_is_read_index` (`receiver_id`,`is_read`),
  CONSTRAINT `messages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `messages` VALUES (1,10,1,NULL,'halo abinaya',NULL,NULL,NULL,1,'2025-12-29 05:08:21','2025-12-29 05:09:39');

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `data` text,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_read_at_index` (`user_id`,`read_at`),
  KEY `notifications_user_id_type_index` (`user_id`,`type`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `discount_percent` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promotions_product_id_foreign` (`product_id`),
  CONSTRAINT `promotions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `verifications`;
CREATE TABLE `verifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `document_path` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verifications_user_id_foreign` (`user_id`),
  CONSTRAINT `verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
