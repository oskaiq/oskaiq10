CREATE DATABASE IF NOT EXISTS movie_db;
USE movie_db;

-- جدول المستخدمين
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول الأفلام
CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    poster_image VARCHAR(255),
    video_url VARCHAR(500),
    release_year YEAR,
    genre VARCHAR(100),
    director VARCHAR(200),
    cast TEXT,
    rating DECIMAL(3,1),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- إضافة مستخدم أدمن
INSERT INTO users (username, email, password, role) 
VALUES ('admin', 'admin@movies.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- كلمة المرور: password