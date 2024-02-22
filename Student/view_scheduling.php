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

$query = "SELECT c.cname AS course_name, s.event_name, s.event_date, s.event_time
          FROM schedule s
          JOIN studentcourses sc ON s.course_id = sc.cid
          JOIN course c ON s.course_id = c.cid
          WHERE sc.sid = '$studentId'";

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Schedule</title>
</head>
<style>
       

       
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        p {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }
    </style>
<body>
   

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<th>Course Name</th><th>Course Description</th><th>Course Date</th><th>Course Time</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";

            echo "<td>" . $row["course_name"] . "</td>";
            echo "<td>" . $row["event_name"] . "</td>";
            echo "<td>" . $row["event_date"] . "</td>";
            echo "<td>" . $row["event_time"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No schedule available.";
    }
    ?>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
