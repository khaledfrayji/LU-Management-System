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

// Query to retrieve courses for semester 1
$sqlSemester1 = "SELECT course.cid,course.ccode, course.cname, course.hours, course.credits
                 FROM studentcourses
                 INNER JOIN course ON studentcourses.cid = course.cid
                 WHERE studentcourses.sid = $studentID AND studentcourses.semester = 1";

$resultSemester1 = $conn->query($sqlSemester1);

// Query to retrieve courses for semester 2
$sqlSemester2 = "SELECT course.cid, course.ccode, course.cname, course.hours, course.credits
                 FROM studentcourses
                 INNER JOIN course ON studentcourses.cid = course.cid
                 WHERE studentcourses.sid = $studentID AND studentcourses.semester = 2";

$resultSemester2 = $conn->query($sqlSemester2);

// Display courses for semester 1
if ($resultSemester1->num_rows > 0) {
    echo "<h2>Courses - Semester 1</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Course Id</th><th>Course Code</th><th>Course Name</th><th>Hours</th><th>Credits</th></tr>";

    while ($row = $resultSemester1->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["cid"] . "</td>";
        echo "<td>" . $row["ccode"] . "</td>";
        echo "<td>" . $row["cname"] . "</td>";
        echo "<td>" . $row["hours"] . "</td>";
        echo "<td>" . $row["credits"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No courses found for Student ID: $studentID in Semester 1";
}

// Display courses for semester 2
if ($resultSemester2->num_rows > 0) {
    echo "<h2>Courses - Semester 2</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Course Id</th><th>Course Code</th><th>Course Name</th><th>Hours</th><th>Credits</th></tr>";

    while ($row = $resultSemester2->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["cid"] . "</td>";
        echo "<td>" . $row["ccode"] . "</td>";
        echo "<td>" . $row["cname"] . "</td>";
        echo "<td>" . $row["hours"] . "</td>";
        echo "<td>" . $row["credits"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No courses found for Student ID: $studentID in Semester 2";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
</head>
<style>
  
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

    h2 {
        margin-top: 40px;
        display: flex;
        justify-content: center;
        color: #002142;
        position: relative;
        right: 50px;
    }
</style>

<body>

</body>

</html>