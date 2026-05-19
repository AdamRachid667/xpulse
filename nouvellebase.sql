-- nouvelle base de donnéess xpulse;

CREATE DATABASE IF NOT EXISTS xpulse CHARACTER SET utf8;
USE xpulse;


CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL DEFAULT 1,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    likes INT DEFAULT 0,
    comments_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO posts (title, content, likes) 
VALUES ('Bienvenue sur XPULSE', 'Ceci est le tout premier post de la plateforme !', 5);