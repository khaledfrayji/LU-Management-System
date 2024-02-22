<?php

// Your existing database connection code here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//Salaries View Location: Admin/salaries.php
// Check if the view already exists
$check_view_query = "SHOW TABLES LIKE 'view_teacher_salary'";
$result = $conn->query($check_view_query);

if ($result->num_rows == 0) {
    // Create the view if it does not exist
    $create_view_query = "
        CREATE VIEW view_teacher_salary AS
        SELECT tid, tname, salary
        FROM teacher;
    ";

    if ($conn->query($create_view_query) === TRUE) {
        echo "View created successfully.";
    } else {
        echo "Error creating view: " . $conn->error;
    }
} else {
    echo "The view already exists.";
}
//Student View Location: Admin/students.php
$check_view_query = "SHOW TABLES LIKE 'view_student_info'";
$result = $conn->query($check_view_query);

if ($result->num_rows == 0) {
    // Create the view if it does not exist
    $create_view_query = "
        CREATE VIEW view_student_info AS
        SELECT sid, sname, domain, year
        FROM student;
    ";

    if ($conn->query($create_view_query) === TRUE) {
        echo "View created successfully.";
    } else {
        echo "Error creating view: " . $conn->error;
    }
} else {
    echo "The view already exists.";
}
//Teacher view Location: Admin/contact.php
$check_view_query = "SHOW TABLES LIKE 'view_teacher_info'";
$result = $conn->query($check_view_query);

if ($result->num_rows == 0) {
    // Create the view if it does not exist
    $create_view_query = "
        CREATE VIEW view_teacher_info AS
        SELECT *
        FROM teacher;
    ";

    if ($conn->query($create_view_query) === TRUE) {
        echo "View created successfully.";
    } else {
        echo "Error creating view: " . $conn->error;
    }
} else {
    echo "The view already exists.";
}
// Close the database connection
#Written by Khaled Frayji
$conn->close();
?>
