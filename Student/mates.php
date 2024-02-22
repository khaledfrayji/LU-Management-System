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

// Query to retrieve courses for the logged-in student
$sqlCourses = "SELECT cid
                FROM studentcourses
                WHERE studentcourses.sid = $studentID";

$resultCourses = $conn->query($sqlCourses);

// Retrieve an array of course IDs for the logged-in student
$courseIDs = [];
while ($row = $resultCourses->fetch_assoc()) {
    $courseIDs[] = $row["cid"];
}

// Query to retrieve classmates with the same courses, including email
$sqlClassmates = "SELECT DISTINCT s.sname, s.email
                  FROM studentcourses sc
                  INNER JOIN student s ON sc.sid = s.sid
                  WHERE sc.cid IN (" . implode(',', $courseIDs) . ")
                  AND s.sid <> $studentID";

$resultClassmates = $conn->query($sqlClassmates);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classmates</title>
</head>
<style>
    table {
        width: 90%;
        border-collapse: collapse;
        margin-top: 20px;
        position: relative;
        left: 50px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 15px;
        text-align: left;
        border-radius: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    /* Hover effect on table rows */
    tr:hover {
        background-color: #e0e0e0;
        transition: background-color 0.3s ease-in-out;
    }

    .classmate-name {
        font-size: 18px;
        font-weight: bold;
        color: #002142;
    }

    .classmate-email {
        font-size: 14px;
        color: #555;
    }
</style>
</head>

<body>

    <div class="classmates-section">
        <?php
        if ($resultClassmates->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Name</th><th>Email</th></tr>";
            while ($row = $resultClassmates->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='classmate-name'>{$row['sname']}</td>";
                echo "<td class='classmate-email'>{$row['email']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No classmates found with the same courses.";
        }
        $conn->close();
        ?>
    </div>

</body>

</html>