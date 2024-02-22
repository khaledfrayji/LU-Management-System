<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create tables , if not exists to be always safe if the table already exist.
$tables = array(
    "student" => "CREATE TABLE IF NOT EXISTS student (
                    sid INT PRIMARY KEY,
                    sname VARCHAR(255),
                    bdate DATE,
                    address VARCHAR(255),
                    phone VARCHAR(20),
                    email VARCHAR(255),
                    password VARCHAR(255),
                    domain VARCHAR(255),
                    year INT
                )",
    "teacher" => "CREATE TABLE IF NOT EXISTS teacher (
                    tid INT PRIMARY KEY,
                    tname VARCHAR(255),
                    address VARCHAR(255),
                    phone VARCHAR(20),
                    email VARCHAR(255),
                    password VARCHAR(255),
                    speciality VARCHAR(255),
                    salary INT
                )",
    "course" => "CREATE TABLE IF NOT EXISTS course (
        cid INT PRIMARY KEY,
        ccode VARCHAR(20),
        cname VARCHAR(255), 
        hours INT,
        credits INT,
        teacher INT,
        domaine VARCHAR(255),
        year INT,
        semester INT,
        FOREIGN KEY (teacher) REFERENCES teacher(tid),
        UNIQUE KEY (cid, teacher)  -- bas mn 3ena
    )",
    "studentcourses" => "CREATE TABLE IF NOT EXISTS studentcourses (
                            sid INT,
                            cid INT,
                            domaine VARCHAR(255),
                            year INT,
                            semester INT,
                            FOREIGN KEY (sid) REFERENCES student(sid),
                            FOREIGN KEY (cid) REFERENCES course(cid)
                        )",
    "markregister" => "CREATE TABLE IF NOT EXISTS markregister (
                            sid INT,
                            cid INT,
                            mark INT,
                            FOREIGN KEY (sid) REFERENCES student(sid),
                            FOREIGN KEY (cid) REFERENCES course(cid)
                          
                        )",
    "appeals" => "CREATE TABLE IF NOT EXISTS appeals ( -- للطعن
        appeal_id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT,
        course_id INT,
        appeal_text TEXT,
        status VARCHAR(50) DEFAULT 'Pending',
        FOREIGN KEY (student_id) REFERENCES student(sid),
        FOREIGN KEY (course_id) REFERENCES course(cid),
        UNIQUE KEY (appeal_id, student_id)-- ممنوع اكثر من طعن لكل كورس
    )",
    "reports" => "CREATE TABLE IF NOT EXISTS reports (
        report_id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT,
        teacher_id INT,
        report_date DATE,
        course_id INT,
        report_text TEXT,
        FOREIGN KEY (student_id) REFERENCES student(sid),
        FOREIGN KEY (teacher_id) REFERENCES teacher(tid),
        FOREIGN KEY (course_id) REFERENCES course(cid)
    )",
    "black_list" => "CREATE TABLE IF NOT EXISTS black_list (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT,
        blacklist_date DATE DEFAULT CURRENT_DATE,
        FOREIGN KEY (student_id) REFERENCES student(sid)
    )",
    "schedule" => "CREATE TABLE IF NOT EXISTS schedule (
        schedule_id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT,
        event_name VARCHAR(255) NOT NULL,
        event_date DATE NOT NULL,
        event_time TIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (course_id) REFERENCES course (cid)
    )",
    "exams" => "CREATE TABLE IF NOT EXISTS exams (
        exam_id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT,
        exam_date DATE,
        start_time TIME,
        end_time TIME,
        FOREIGN KEY (course_id) REFERENCES course (cid)
    );"
                        
);

foreach ($tables as $tableName => $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "Table '{$tableName}' created successfully<br>";
    } else {
        echo "Error creating table '{$tableName}': " . $conn->error . "<br>";
    }
}

$conn->close();
?>
