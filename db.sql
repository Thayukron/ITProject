-- สร้างฐานข้อมูล (ตั้งชื่อว่า project_db)
CREATE DATABASE project_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE project_db;

-- ตารางนักศึกษา
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    class_year VARCHAR(10) NOT NULL
);

-- ตารางอาจารย์
CREATE TABLE teachers (
    teacher_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE
);

-- ตารางโครงงาน
CREATE TABLE projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    abstract TEXT,
    year YEAR NOT NULL,
    category VARCHAR(100),
    cover_image VARCHAR(255),   -- เก็บ path รูปปก
    file_pdf VARCHAR(255),      -- เก็บ path ไฟล์รายงาน PDF
    file_zip VARCHAR(255),      -- เก็บ path ไฟล์ซอร์สโค้ด
    video_link VARCHAR(255)     -- เก็บลิงก์ YouTube/Video
);

-- ตารางเชื่อมโครงงานกับนักศึกษา (N:N)
CREATE TABLE project_students (
    project_id INT,
    student_id INT,
    PRIMARY KEY (project_id, student_id),
    FOREIGN KEY (project_id) REFERENCES projects(project_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
);

-- ตารางเชื่อมโครงงานกับอาจารย์ (N:N)
CREATE TABLE project_teachers (
    project_id INT,
    teacher_id INT,
    PRIMARY KEY (project_id, teacher_id),
    FOREIGN KEY (project_id) REFERENCES projects(project_id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id) ON DELETE CASCADE
);
