-- ============================================================
-- Base de données : xpulse
-- ============================================================

CREATE DATABASE IF NOT EXISTS xpulse
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE xpulse;

-- ------------------------------------------------------------
-- Table : users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
  id           INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  username     VARCHAR(50)     NOT NULL,
  email        VARCHAR(191)    NOT NULL,
  password     VARCHAR(255)    NOT NULL,
  bio          TEXT            DEFAULT NULL,
  avatar       VARCHAR(255)    DEFAULT NULL,
  created_at   DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE KEY uq_users_email    (email),
  UNIQUE KEY uq_users_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Table : posts
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS posts (
  id             INT UNSIGNED   NOT NULL AUTO_INCREMENT,
  user_id        INT UNSIGNED   NOT NULL,
  title          VARCHAR(255)   NOT NULL,
  content        TEXT           NOT NULL,
  image          VARCHAR(255)   DEFAULT NULL,
  likes          INT UNSIGNED   NOT NULL DEFAULT 0,
  comments_count INT UNSIGNED   NOT NULL DEFAULT 0,
  created_at     DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  KEY idx_posts_user_id    (user_id),
  KEY idx_posts_created_at (created_at),

  CONSTRAINT fk_posts_user
    FOREIGN KEY (user_id) REFERENCES users (id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Table : comments
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS comments (
  id         INT UNSIGNED   NOT NULL AUTO_INCREMENT,
  post_id    INT UNSIGNED   NOT NULL,
  user_id    INT UNSIGNED   NOT NULL,
  content    TEXT           NOT NULL,
  created_at DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  KEY idx_comments_post_id (post_id),
  KEY idx_comments_user_id (user_id),

  CONSTRAINT fk_comments_post
    FOREIGN KEY (post_id) REFERENCES posts (id)
    ON DELETE CASCADE ON UPDATE CASCADE,

  CONSTRAINT fk_comments_user
    FOREIGN KEY (user_id) REFERENCES users (id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Table : likes  (évite les doubles likes)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS likes (
  id         INT UNSIGNED   NOT NULL AUTO_INCREMENT,
  post_id    INT UNSIGNED   NOT NULL,
  user_id    INT UNSIGNED   NOT NULL,
  created_at DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  UNIQUE KEY uq_likes_post_user (post_id, user_id),

  CONSTRAINT fk_likes_post
    FOREIGN KEY (post_id) REFERENCES posts (id)
    ON DELETE CASCADE ON UPDATE CASCADE,

  CONSTRAINT fk_likes_user
    FOREIGN KEY (user_id) REFERENCES users (id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
