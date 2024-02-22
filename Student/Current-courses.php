<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Courses</title>
</head>
<style>

    h2 {
        color: #002142;
        margin-top: 40px;
        display: flex;
        justify-content: center;
        position: relative;
        right: 50px;
    }

    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #002142;
        color: white;
    }

    tr:hover {
        background-color: #f5f5f5;
    }
</style>

<body>

</body>

</html>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the student ID from the session
$studentID = $_SESSION["username"];

// Query to retrieve courses for semester 1 with teacher information
$sql = "SELECT course.ccode, course.cname, course.hours, course.credits, teacher.tname
        FROM studentcourses
        INNER JOIN course ON studentcourses.cid = course.cid
        LEFT JOIN teacher ON course.teacher = teacher.tid
        WHERE studentcourses.sid = $studentID AND studentcourses.semester = 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display courses for semester 1
    echo "<h2>Courses - Semester 1</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Course Code</th><th>Course Name</th><th>Hours</th><th>Credits</th><th>Doctor Name</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["ccode"] . "</td>";
        echo "<td>" . $row["cname"] . "</td>";
        echo "<td>" . $row["hours"] . "</td>";
        echo "<td>" . $row["credits"] . "</td>";
        echo "<td>" . $row["tname"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No courses found for Student ID: $studentID in Semester 1";
}

$conn->close();
?>
