CREATE TABLE `articles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `author_id` INT UNSIGNED NULL,  -- Allow NULL values now
  `image_path` VARCHAR(255) DEFAULT NULL,  -- For image upload (if applicable)
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`author_id`)
      REFERENCES `users` (`id`)
      ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','user','editor') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
