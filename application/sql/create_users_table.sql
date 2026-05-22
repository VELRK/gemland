-- Create users table for frontend login
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `country_code` varchar(10) DEFAULT '+91',
  `address` text DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expires_at` datetime DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`, `country_code`),
  KEY `phone_index` (`phone`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

