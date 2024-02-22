<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams</title>
</head>
<style>
    body {
        background-color: blue;
        overflow-x: hidden;
    }

    .left-right {
        display: flex;
        flex-direction: row;
        position: relative;
        left: 170px;
        align-items: center;
    }

    h1 {
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    table {
        width: 100%;
        border: 1px solid white;
        margin-bottom: 10px;
        position: relative;
        top: 0px;
        color: white;
    }

    table td {
        padding: 5px;
    }

    input {
        position: relative;
        left: 550px;
        margin-bottom: 20px;
    }
</style>
<body>
    <h1>Exams</h1>
    <form method="post" action="">
        <input type="text" name="search" placeholder="Enter Course Code">
        <input type="submit" name="submit" value="Search">
    </form>
</body>
</html>

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

// Assuming you have a session variable for user authentication
// Modify this based on your authentication mechanism
$user_type = $_SESSION['username'];

// Check if the user is a doctor

// Retrieve midterm exam information
$search = isset($_POST['search']) ? $_POST['search'] : '';
$midterm_query = "SELECT cname, ccode, fromdate, todate FROM course c 
                  JOIN markregister mr ON c.cid = mr.cid
                  JOIN exam e ON mr.xid = e.xid 
                  WHERE xlabel = 'Midterm Exam' AND c.ccode LIKE '%$search%'";
$midterm_result = mysqli_query($conn, $midterm_query);

// Retrieve final exam information
$final_query = "SELECT cname, ccode, fromdate, todate FROM course c 
                JOIN markregister mr ON c.cid = mr.cid
                JOIN exam e ON mr.xid = e.xid 
                WHERE xlabel = 'Final Exam' AND c.ccode LIKE '%$search%'";
$final_result = mysqli_query($conn, $final_query);

if ($midterm_result && $final_result) {
    // Check if there are any exams
    $midterm_count = mysqli_num_rows($midterm_result);
    $final_count = mysqli_num_rows($final_result);

    if ($midterm_count > 0 || $final_count > 0) {
        echo "<div class='left-right'>";
        echo "<div class='left'>";
        // Display Midterm Exam Information
        if ($midterm_count > 0) {
           
            echo "<table border='1' style='display: inline-block; margin-right: 20px;'>";
            echo "<tr><th colspan='4'><h3 style='text-align: center;'>Midterm Exam Information</h3></th></tr>";
            echo "<tr><th>Course Name</th><th>Course Code</th><th>From Date</th><th>To Date</th></tr>";

            // Output data of each row
            while ($row = mysqli_fetch_assoc($midterm_result)) {
                echo "<tr>";
                echo "<td>" . $row["cname"] . "</td>";
                echo "<td>" . $row["ccode"] . "</td>";
                echo "<td>" . $row["fromdate"] . "</td>";
                echo "<td>" . $row["todate"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
        echo "</div>";
        // Display Final Exam Information
        echo "<div class='right'>";
        if ($final_count > 0) {
            echo "<table border='1' style='display: inline-block;'>";
            echo "<tr><th colspan='4'><h3 style='text-align: center;'>Final Exam Information</h3></th></tr>";
            echo "<tr><th>Course Name</th><th>Course Code</th><th>From Date</th><th>To Date</th></tr>";

            // Output data of each row
            while ($row = mysqli_fetch_assoc($final_result)) {
                echo "<tr>";
                echo "<td>" . $row["cname"] . "</td>";
                echo "<td>" . $row["ccode"] . "</td>";
                echo "<td>" . $row["fromdate"] . "</td>";
                echo "<td>" . $row["todate"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
        echo "</div>";
        echo "</div>";
    } else {
        echo "No exams available.";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
