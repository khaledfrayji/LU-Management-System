<?php


if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$studentId = $_SESSION["username"];

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

// Query to retrieve exams related to courses taken by the student
$query = "SELECT  c.cname AS course_name, e.exam_date, e.start_time,e.end_time
          FROM exams e
          JOIN course c ON e.course_id = c.cid
          JOIN studentcourses sc ON c.cid = sc.cid
          WHERE sc.sid = '$studentId'";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4caf50;
            color: #fff;
        }
    </style>
</head>

<body>


    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Course Name</th><th>Exam Date</th><th>Start Time</th><th>End Time</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["course_name"] . "</td>";
            echo "<td>" . $row["exam_date"] . "</td>";
            echo "<td>" . $row["start_time"] . "</td>";
            echo "<td>" . $row["end_time"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No exams available for your courses.";
    }
    ?>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>