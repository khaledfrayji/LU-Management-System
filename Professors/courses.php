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

// Get the speciality of the logged-in teacher
$teacher_speciality_query = "SELECT speciality FROM teacher WHERE tid = '$teacher_id'";
$teacher_speciality_result = mysqli_query($conn, $teacher_speciality_query);

if ($teacher_speciality_result && mysqli_num_rows($teacher_speciality_result) > 0) {
    $teacher_speciality_row = mysqli_fetch_assoc($teacher_speciality_result);
    $teacher_speciality = $teacher_speciality_row['speciality'];

    // SQL query to retrieve course information along with the teacher's name and phone number for semester 1
    $query_semester1 = "SELECT c.cid AS course_id, c.cname AS course_name, c.ccode AS course_code,
                         c.credits, t.tid AS teacher_id, t.tname AS teacher_name, t.speciality, t.phone
                  FROM course c
                  JOIN teacher t ON c.teacher = t.tid
                  WHERE t.speciality = '$teacher_speciality' AND c.semester = 1";

    $result_semester1 = mysqli_query($conn, $query_semester1);

    // SQL query to retrieve course information along with the teacher's name and phone number for semester 2
    $query_semester2 = "SELECT c.cid AS course_id, c.cname AS course_name, c.ccode AS course_code,
                         c.credits, t.tid AS teacher_id, t.tname AS teacher_name, t.speciality, t.phone
                  FROM course c
                  JOIN teacher t ON c.teacher = t.tid
                  WHERE t.speciality = '$teacher_speciality' AND c.semester = 2";

    $result_semester2 = mysqli_query($conn, $query_semester2);

    function displayCourses($result)
    {
        if ($result && mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Course ID</th><th>Course Name</th><th>Course Code</th><th>Credits</th><th>Doctor Name</th><th>Speciality</th><th>Contact</th></tr>";

            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["course_id"] . "</td>";
                echo "<td>" . $row["course_name"] . "</td>";
                echo "<td>" . $row["course_code"] . "</td>";
                echo "<td>" . $row["credits"] . "</td>";
                echo "<td>" . $row["teacher_name"] . "</td>";
                echo "<td>" . $row["speciality"] . "</td>";

                // Add a button with a tel: link for each teacher
                echo "<td>";
                echo "<a href='tel:" . $row["phone"] . "'><button>Contact Teacher</button></a>";
                echo "</td>";

                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No courses available.";
        }
    }

    // Display courses for Semester 1
    echo "<h2>Courses - Semester 1</h2>";
    displayCourses($result_semester1);

    // Display courses for Semester 2
    echo "<h2>Courses - Semester 2</h2>";
    displayCourses($result_semester2);
} else {
    echo "Error fetching teacher speciality.";
}

// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <style>
       

        h2 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin-top: 20px;
            position: relative;
            left: 30px;
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

        button {
            padding: 8px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
   
</body>
</html>
