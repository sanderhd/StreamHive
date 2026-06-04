-- --------------------------------------------------------
-- StreamHive Database
-- --------------------------------------------------------

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------
-- Table: categories
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categories` (
  `id`   INT(11)      NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `username`   VARCHAR(255) DEFAULT NULL,
  `email`      VARCHAR(255) NOT NULL,
  `google_id`  INT(11)      DEFAULT NULL,
  `password`   VARCHAR(255) NOT NULL,
  `role`       ENUM('admin','user') DEFAULT 'user',
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------
-- Table: password_resets
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11)      NOT NULL,
  `token`      VARCHAR(255) NOT NULL,
  `expires_at` DATETIME     NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `password_resets_ibfk_1`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------
-- Table: videos
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `videos` (
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `user_id`     INT(11)      NOT NULL,
  `title`       VARCHAR(255) NOT NULL,
  `description` TEXT         DEFAULT NULL,
  `filename`    VARCHAR(255) NOT NULL,
  `thumbnail`   VARCHAR(255) DEFAULT NULL,
  `views`       INT(11)      DEFAULT 0,
  `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `videos_ibfk_1`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------
-- Table: video_category
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `video_category` (
  `video_id`    INT(11) NOT NULL,
  `category_id` INT(11) NOT NULL,
  PRIMARY KEY (`video_id`, `category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `video_category_ibfk_1`
    FOREIGN KEY (`video_id`)    REFERENCES `videos`     (`id`) ON DELETE CASCADE,
  CONSTRAINT `video_category_ibfk_2`
    FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------
-- Table: comments
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `comments` (
  `id`         INT(11)   NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11)   NOT NULL,
  `video_id`   INT(11)   NOT NULL,
  `content`    TEXT      NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id`  (`user_id`),
  KEY `video_id` (`video_id`),
  CONSTRAINT `comments_ibfk_1`
    FOREIGN KEY (`user_id`)  REFERENCES `users`  (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2`
    FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------
-- Table: likes
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `likes` (
  `id`         INT(11)   NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11)   NOT NULL,
  `video_id`   INT(11)   DEFAULT NULL,
  `comment_id` INT(11)   DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id`   (`user_id`, `video_id`),
  UNIQUE KEY `user_id_2` (`user_id`, `comment_id`),
  KEY `video_id`   (`video_id`),
  KEY `comment_id` (`comment_id`),
  CONSTRAINT `likes_ibfk_1`
    FOREIGN KEY (`user_id`)    REFERENCES `users`    (`id`) ON DELETE CASCADE,
  CONSTRAINT `likes_ibfk_2`
    FOREIGN KEY (`video_id`)   REFERENCES `videos`   (`id`) ON DELETE CASCADE,
  CONSTRAINT `likes_ibfk_3`
    FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `CONSTRAINT_1` CHECK (
    (`video_id` IS NOT NULL AND `comment_id` IS NULL)
    OR
    (`video_id` IS NULL AND `comment_id` IS NOT NULL)
  )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------
-- Table: history
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `history` (
  `id`         INT(11)  NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11)  NOT NULL,
  `video_id`   INT(11)  NOT NULL,
  `watched_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_video` (`user_id`, `video_id`),
  KEY `video_id` (`video_id`),
  CONSTRAINT `history_ibfk_1`
    FOREIGN KEY (`user_id`)  REFERENCES `users`  (`id`) ON DELETE CASCADE,
  CONSTRAINT `history_ibfk_2`
    FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 1;