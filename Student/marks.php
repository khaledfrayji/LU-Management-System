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

// Query to retrieve courses and marks for semester 1
$sql = "SELECT course.cid, course.ccode, course.cname, markregister.mark, course.credits
        FROM studentcourses
        INNER JOIN course ON studentcourses.cid = course.cid
        LEFT JOIN markregister ON studentcourses.sid = markregister.sid AND studentcourses.cid = markregister.cid
        WHERE studentcourses.sid = $studentID AND studentcourses.semester = 1";

$result = $conn->query($sql);

// Initialize variables for calculating average
$totalMarks = 0;
$totalCredits = 0;
$missingMark = false;

if ($result->num_rows > 0) {
    // Display courses and marks
    echo "<h2>Marks - Semester 1</h2>";
    echo "<table class='marks-table'>";
    echo "<tr><th>Course Code</th><th>Course Name</th><th>Mark</th><th class='compensation-column'>Compensation</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["ccode"] . "</td>";
        echo "<td>" . $row["cname"] . "</td>";

        // Check if mark is missing
        if ($row["mark"] === null) {
            $missingMark = true;
            echo "<td>No mark</td>";
        } else {
            echo "<td>" . $row["mark"] . "</td>";

            // Calculate average
            $totalMarks += ($row["mark"] * $row["credits"]);
            $totalCredits += $row["credits"];
        }

        // Determine compensation and display star symbol
        $compensation = false;
        if ($row["mark"] >= 40 && $row["mark"] <= 49 && calculateAverage($totalMarks, $totalCredits) > 55) {
            $compensation = true;
            echo "<td class='compensation-cell'>&#9733;</td>"; // Star symbol
        } else {
            echo "<td class='compensation-cell'></td>"; // Empty cell
        }

        echo "</tr>";
    }

    // Display the final average
    $finalAverage = $missingMark ? 0.0 : calculateAverage($totalMarks, $totalCredits);
    echo "<tr><td colspan='3'><strong>Final Average:</strong></td><td>$finalAverage</td></tr>";

    echo "</table>";
} else {
    echo "No courses found for Student ID: $studentID in Semester 1";
}

$conn->close();

// Function to calculate average
function calculateAverage($totalMarks, $totalCredits)
{
    if ($totalCredits == 0) {
        return 0;
    }
    return number_format($totalMarks / $totalCredits, 2);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks - Semester 1</title>
    <style>
  
    h2 {
        color: #333;
        margin-top: 20px;
        position: relative;
        left: 100px;
    }

    .marks-table {
        border-collapse: collapse;
        width: 90%;
        margin-top: 20px;
        position: relative;
        left: 80px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #002142;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .compensation-column {
        width: 80px; /* Adjust the width as needed */
    }

    .compensation-cell {
        text-align: center;
        color: goldenrod;
        font-weight: bolder;
    }

    strong {
        color: #002142;
    }
    tr:hover {
        background-color: #f5f5f5;
    }

</style>

</head>
<body>

</body>
</html>
