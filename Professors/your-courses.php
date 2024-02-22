<?php
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

// Assuming you have a session variable for the teacher's ID
$teacher_id = $_SESSION['username'];

// SQL query to retrieve courses for the given teacher
$sql = "SELECT c.cid AS course_id, c.cname AS course_name, c.ccode AS course_code, c.credits AS credits, c.hours AS hours, COUNT(sc.sid) AS enrolled_students
        FROM course c
        LEFT JOIN studentcourses sc ON c.cid = sc.cid
        WHERE c.teacher = $teacher_id
        GROUP BY c.cid, c.cname, c.ccode, c.credits, c.hours;";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Check if there are any courses
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Your Courses</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Course Name</th><th>Course Code</th><th>Credits</th><th>Hours</th><th>Enrolled Students</th><th>View Students</th></tr>";

        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["course_name"] . "</td>";
            echo "<td>" . $row["course_code"] . "</td>";
            echo "<td>" . $row["credits"] . "</td>";
            echo "<td>" . $row["hours"] . "</td>";
            echo "<td>" . $row["enrolled_students"] . "</td>";
            
            // Pass course ID (cid) as a parameter in the URL
            echo "<td><a href='view-student.php?cid=" . $row["course_id"] . "'><button class='button'>View Students</button></a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "You are not assigned to any courses.";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>

<!-- Our HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <style>
       
        h2 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin-top: 20px;
            position: relative;
            left: 40px;
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

        a {
            text-decoration: none;
            color: #007bff;
        }

        .button {
            padding: 8px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

</body>
</html>
