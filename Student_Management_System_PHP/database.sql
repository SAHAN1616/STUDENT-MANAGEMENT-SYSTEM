CREATE DATABASE IF NOT EXISTS student_management;
USE student_management;

CREATE TABLE IF NOT EXISTS students (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 roll_no VARCHAR(50) NOT NULL UNIQUE,
 course VARCHAR(80) NOT NULL,
 year VARCHAR(30) NOT NULL,
 phone VARCHAR(30),
 email VARCHAR(160),
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS attendance (
 id INT AUTO_INCREMENT PRIMARY KEY,
 student_id INT NOT NULL,
 date DATE NOT NULL,
 status VARCHAR(20) NOT NULL DEFAULT 'Present',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_student_date (student_id,date)
);

CREATE TABLE IF NOT EXISTS teachers (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 department VARCHAR(120) NOT NULL,
 subject VARCHAR(120) NOT NULL,
 phone VARCHAR(30),
 email VARCHAR(160),
 status VARCHAR(20) NOT NULL DEFAULT 'Active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS marks (
 id INT AUTO_INCREMENT PRIMARY KEY,
 student_id INT NOT NULL,
 subject VARCHAR(120) NOT NULL,
 marks DECIMAL(5,2) NOT NULL,
 exam VARCHAR(80) NOT NULL DEFAULT 'Semester Exam',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_student_subject_exam (student_id,subject,exam)
);

CREATE TABLE IF NOT EXISTS fees (
 id INT AUTO_INCREMENT PRIMARY KEY,
 student_id INT NOT NULL,
 amount DECIMAL(10,2) NOT NULL,
 paid DECIMAL(10,2) NOT NULL DEFAULT 0,
 due_date DATE NULL,
 status VARCHAR(20) NOT NULL DEFAULT 'Pending',
 note VARCHAR(255),
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS app_settings (
 id INT PRIMARY KEY,
 institute_name VARCHAR(160) NOT NULL DEFAULT 'EduManage College',
 admin_email VARCHAR(160) NOT NULL DEFAULT 'admin@college.edu',
 phone VARCHAR(30) DEFAULT '',
 address VARCHAR(255) DEFAULT ''
);
INSERT INTO app_settings (id,institute_name,admin_email) VALUES (1,'EduManage College','admin@college.edu')
ON DUPLICATE KEY UPDATE id=id;

CREATE TABLE IF NOT EXISTS admins (
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(80) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL
);
INSERT INTO admins(username,password) VALUES ('admin','admin123')
ON DUPLICATE KEY UPDATE username=username;

INSERT INTO teachers(name,department,subject,phone,email,status)
SELECT 'Dr. Priya Mehta','Computer Science','DBMS','','','Active'
WHERE NOT EXISTS (SELECT 1 FROM teachers);
INSERT INTO teachers(name,department,subject,phone,email,status)
SELECT 'Mr. Amit Shah','Computer Science','Operating System','','','Active'
WHERE (SELECT COUNT(*) FROM teachers)=1;

INSERT INTO students(name,roll_no,course,year,phone,email)
SELECT 'Rahul Patel','101','BCA','2nd Year','9876543210','rahul@gmail.com'
WHERE NOT EXISTS (SELECT 1 FROM students WHERE roll_no='101');
INSERT INTO students(name,roll_no,course,year,phone,email)
SELECT 'Ayesha Khan','102','BCA','2nd Year','9876543211','ayesha@gmail.com'
WHERE NOT EXISTS (SELECT 1 FROM students WHERE roll_no='102');
