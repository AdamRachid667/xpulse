-- base de données xpulse

CREATE DATABASE IF NOT EXISTS xpulse CHARACTER SET utf8;
USE xpulse;


CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    bio TEXT DEFAULT NULL
);


CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL DEFAULT 1,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    likes INT DEFAULT 0,
    comments_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Si tu veux ajouter bio à une table users existante :
-- ALTER TABLE users ADD COLUMN bio TEXT DEFAULT NULL;

-- Post de démo (fonctionne seulement si un user avec id=1 existe)
-- INSERT INTO posts (title, content, likes) VALUES ('Bienvenue sur XPULSE', 'Ceci est le tout premier post de la plateforme !', 5);
