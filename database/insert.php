<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to check if records exist in a table
function checkRecordsExist($conn, $tableName)
{
    $checkQuery = "SELECT COUNT(*) as count FROM $tableName";
    $result = $conn->query($checkQuery);
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Insert values into the 'student' table
if (checkRecordsExist($conn, 'student') == 0) {
    $sql = "INSERT INTO student (sid, sname, bdate, address, phone, email, password, domain, year)
            VALUES
            (1, 'Khaled Frayji', '2002-11-03', '123 Main St', '555-1234', 'khaled.frayji@edu.lu', '1', 'Computer_Science', 3),
            (2, 'Oussama Ezzedine', '2004-05-15', '456 Oak St', '555-5678', 'oussama.ezzedine@edu.lu', '2', 'Computer_Science', 2),
            (3, 'Jad Chahine', '1988-11-30', '789 Elm St', '555-8765', 'jad.chahine@edu.lu', '3', 'Computer_Science', 4),
            (4, 'Ali Khansa', '1995-08-22', '101 Pine St', '555-4321', 'ali.khansa@edu.lu', '4', 'Computer_Science', 1),
            (5, 'Karam Jammal', '1993-03-10', '202 Cedar St', '555-9876', 'karam.jammal@edu.lu', '5', 'Computer_Science', 2)";

    if ($conn->query($sql) === TRUE) {
        echo "Values inserted into 'student' table successfully.<br>";
    } else {
        echo "Error inserting values into 'student' table: " . $conn->error . "<br>";
    }
} else {
    echo "Records already exist in 'student' table. No insertion performed.<br>";
}

// Insert values into the 'teacher' table
if (checkRecordsExist($conn, 'teacher') == 0) {
    $sql = "INSERT INTO teacher (tid, tname, address, phone, email, password, speciality,salary)
            VALUES
            (1, 'Professor Smith', '111 University Ave', '555-1111', 'prof.smith@example.com', 'teacherpass', 'Computer Science',50000),
            (2, 'Dr. Johnson', '222 College St', '555-2222', 'dr.johnson@example.com', 'drpass', 'Mathematics',50000),
            (3, 'Mrs. Brown', '333 School Rd', '555-3333', 'mrs.brown@example.com', 'mrspass', 'History',50000),
            (4, 'Mr. White', '444 Academy Blvd', '555-4444', 'mr.white@example.com', 'mrpass', 'Physics',50000),
            (5, 'Ms. Davis', '555 Campus Ln', '555-5555', 'ms.davis@example.com', 'mspass', 'Chemistry',50000),
            (6, 'Dr. Jaber', '555 beirut', '555-6666', 'a.jaber@example.com', 'alijaber', 'Computer_Science',50000),
            (7, 'Dr. Faour', '555 beirut', '555-7777', 'a.faour@example.com', 'ahmadfaour', 'Computer_Science',50000),
            (8, 'Dr. Fadlallah', '555 beirut', '555-8888', 'a.fadlallah@example.com', 'ahmadfadlallah', 'Computer_Science',50000),
            (9, 'Dr. Rami', '555 beirut', '555-9999', 'rami@example.com', 'rami', 'Computer_Science'),
            (10, 'Dr. Kamal', '555 beirut', '555-1000', 'k.baydoun@example.com', 'kamalbaydoun', 'Computer_Science',50000)";

    if ($conn->query($sql) === TRUE) {
        echo "Values inserted into 'teacher' table successfully.<br>";
    } else {
        echo "Error inserting values into 'teacher' table: " . $conn->error . "<br>";
    }
} else {
    echo "Records already exist in 'teacher' table. No insertion performed.<br>";
}

// Insert values into the 'course' table
if (checkRecordsExist($conn, 'course') == 0) {
    $sql = "INSERT INTO course (cid, ccode, cname, hours, credits, teacher, domaine, year,semester)
            VALUES
            (1, 'CS101', 'Introduction to Computer Science', 3, 4, 1, 'Computer_Science', 1,1),
            (2, 'MATH201', 'Calculus II', 4, 5, 2, 'Maths', 2,1),
            (3, 'HIST105', 'World History', 3, 3, 3, 'History', 1,2),
            (4, 'PHYS202', 'Modern Physics', 4, 5, 4, 'Physics', 2,2),
            (5, 'CHEM101', 'General Chemistry', 3, 4, 5, 'Chemistry', 1,1),
            (6, '3302', 'Php server-side', 30, 4, 6, 'Computer_Science', 3,1),
            (7, '3303', 'Operating System 2', 60, 4, 7, 'Computer_Science', 3,1),
            (8, '3304', 'Network2', 60, 4, 8, 'Computer_Science', 3,1),
            (9, 'I2208', 'Network1', 60, 4, 8, 'Computer_Science', 2,1),
            (10, 'I2203', 'Operating System 1', 60, 4, 7, 'Computer_Science', 2,1),
            (11, '3350', 'Mobile Application', 60, 5, 9, 'Computer_Science', 3,1),
            (12, '3307', 'Asp', 60, 4, 10, 'Computer_Science', 3,2)";


    if ($conn->query($sql) === TRUE) {
        echo "Values inserted into 'course' table successfully.<br>";
    } else {
        echo "Error inserting values into 'course' table: " . $conn->error . "<br>";
    }
} else {
    echo "Records already exist in 'course' table. No insertion performed.<br>";
}

// Insert values into the 'studentcourses' table
if (checkRecordsExist($conn, 'studentcourses') == 0) {
    $sql = "INSERT INTO studentcourses (sid, cid, domaine, year,semester)
            VALUES
            (1, 6, 'Computer_Science', 3,1),
            (2, 6, 'Computer_Science', 3,1),
            (3, 6, 'Computer_Science', 3,1),
            (4, 6, 'Computer_Science', 3,1),
            (5, 6, 'Computer_Science', 3,1),
            (1, 7, 'Computer_Science', 3,1),
            (2, 7, 'Computer_Science', 3,1),
            (3, 7, 'Computer_Science', 3,1),
            (4, 7, 'Computer_Science', 3,1),
            (5, 7, 'Computer_Science', 3,1),
            (1, 8, 'Computer_Science', 3,1),
            (2, 8, 'Computer_Science', 3,1),
            (3, 8, 'Computer_Science', 3,1),
            (4, 8, 'Computer_Science', 3,1),
            (5, 8, 'Computer_Science', 3,1),
            (1, 11,'Computer_Science', 3,1),
            (2, 11,'Computer_Science', 3,1),
            (3, 11,'Computer_Science', 3,1),
            (4, 11,'Computer_Science', 3,1),
            (5, 11,'Computer_Science', 3,1),
            (1, 12,'Computer_Science', 3,2),
            (2, 12,'Computer_Science', 3,2),
            (3, 12,'Computer_Science', 3,2),
            (4, 12,'Computer_Science', 3,2),
            (5, 12,'Computer_Science', 3,2)";

    if ($conn->query($sql) === TRUE) {
        echo "Values inserted into 'studentcourses' table successfully.<br>";
    } else {
        echo "Error inserting values into 'studentcourses' table: " . $conn->error . "<br>";
    }
} else {
    echo "Records already exist in 'studentcourses' table. No insertion performed.<br>";
}

// Insert values into the 'exam' table
if (checkRecordsExist($conn, 'exams') == 0) {
    $sql = "INSERT INTO exams (course_id, exam_date, start_time, end_time)
    VALUES
        (1, '2023-01-15', '09:00:00', '12:00:00'),
        (2, '2023-01-20', '14:00:00', '17:00:00'),
        (3, '2023-01-25', '10:30:00', '13:30:00'),
        (8, '2023-01-15', '09:00:00', '12:00:00'),
        (6, '2023-01-20', '14:00:00', '17:00:00'),
        (7, '2023-01-25', '10:30:00', '13:30:00');";

    if ($conn->query($sql) === TRUE) {
        echo "Values inserted into 'exam' table successfully.<br>";
    } else {
        echo "Error inserting values into 'exam' table: " . $conn->error . "<br>";
    }
} else {
    echo "Records already exist in 'exam' table. No insertion performed.<br>";
}

// Insert values into the 'markregister' table
if (checkRecordsExist($conn, 'markregister') == 0) {
    $sql = "INSERT INTO markregister (sid, cid,mark)
            VALUES
            (1, 6,85),
            (2, 6,92),
            (3, 6,78),
            (4, 6,90),
            (5, 6,88),
            (1, 7,69),
            (2, 7,76),
            (3, 7,47),
            (4, 7,39),
            (5, 7,22)";

    if ($conn->query($sql) === TRUE) {
        echo "Values inserted into 'markregister' table successfully.<br>";
    } else {
        echo "Error inserting values into 'markregister' table: " . $conn->error . "<br>";
    }
} else {
    echo "Records already exist in 'markregister' table. No insertion performed.<br>";
}

$conn->close();
//written by khaled frayji
?>