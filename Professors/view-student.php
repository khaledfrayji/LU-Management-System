<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "stdmanagment";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve course ID (cid) from the URL
$course_id = $_GET['cid'];

// SQL query to retrieve enrolled students for the selected course
$sql_students = "SELECT s.sid AS student_id, s.sname AS student_name, s.email
                FROM studentcourses sc
                JOIN student s ON sc.sid = s.sid
                WHERE sc.cid = $course_id";
$result_students = mysqli_query($conn, $sql_students);

if ($result_students) {
    // Check if there are any enrolled students
    if (mysqli_num_rows($result_students) > 0) {
        echo "<h2>Enrolled Students</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Student ID</th><th>Student Name</th><th>Email</th></tr>";

        // Output data of each enrolled student
        while ($row_student = mysqli_fetch_assoc($result_students)) {
            echo "<tr>";
            echo "<td>" . $row_student["student_id"] . "</td>";
            echo "<td>" . $row_student["student_name"] . "</td>";
            echo "<td>" . $row_student["email"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No students enrolled in this course.";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <style>
      

        h2 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

</body>
</html>
