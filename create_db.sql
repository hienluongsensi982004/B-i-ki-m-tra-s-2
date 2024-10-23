-- Tạo database theo cú pháp db_[ho_ten], ví dụ db_nguyen_phu_duc
CREATE DATABASE IF NOT EXISTS db_nguyen_thi_hien_luong;

-- Sử dụng database
USE db_nguyen_thi_hien_luong;

-- Tạo bảng khóa học (course)
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    imageUrl VARCHAR(255)
);

-- Insert dữ liệu mẫu
INSERT INTO courses (title, description) VALUES 
('PHP for Beginners', 'An introductory course for PHP programming'),
('Web Design 101', 'Basics of web design principles'),
('Database Management', 'Introduction to managing databases');
