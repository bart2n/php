-- Creates the database and table used by the to-do app.
-- You can also paste this into phpMyAdmin's "SQL" tab.

CREATE DATABASE IF NOT EXISTS learning CHARACTER SET utf8mb4;

USE learning;

CREATE TABLE IF NOT EXISTS todos (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    title      VARCHAR(255) NOT NULL,
    done       TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
