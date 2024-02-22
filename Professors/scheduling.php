<?php
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Your database connection code
$servername = "localhost";
$username = "root";
$password = "";
$database = "stdmanagment";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a session variable for user authentication
$teacher_id = $_SESSION['username'];

// Retrieve courses taught by the teacher
$course_query = "SELECT cid, cname FROM course WHERE teacher = '$teacher_id'";
$course_result = mysqli_query($conn, $course_query);

if (!$course_result) {
    echo "Error: " . mysqli_error($conn);
}

// Retrieve existing events
$existing_events_query = "SELECT course_id, event_name, event_date, event_time FROM schedule";
$existing_events_result = mysqli_query($conn, $existing_events_query);

if (!$existing_events_result) {
    echo "Error: " . mysqli_error($conn);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_id = $_POST["course_id"];
    $event_name = $_POST["event_name"];
    $event_date = $_POST["event_date"];
    $event_time = $_POST["event_time"];

    // Check if the selected time slot is available
    $check_availability_query = "SELECT * FROM schedule WHERE event_date = '$event_date' AND event_time = '$event_time'";
    $availability_result = mysqli_query($conn, $check_availability_query);

    // Check if the teacher can schedule after 1.5 hours
    $proposed_timestamp = strtotime("$event_date $event_time");
    $min_time_diff = 90 * 60; // 1.5 hours in seconds

    while ($row = mysqli_fetch_assoc($existing_events_result)) {
        $existing_timestamp = strtotime("{$row['event_date']} {$row['event_time']}");
        $time_diff = abs($proposed_timestamp - $existing_timestamp);

        if ($time_diff < $min_time_diff) {
            echo "<p class='p' style='color: red;'>Error scheduling course. You can only schedule after 1.5 hours of the previous course.</p>";
            exit;
        }
    }

    // Check if the teacher can schedule a day after the created day of the scheduling
    $created_at_query = "SELECT MAX(created_at) as max_created_at FROM schedule";
    $created_at_result = mysqli_query($conn, $created_at_query);
    $created_at_row = mysqli_fetch_assoc($created_at_result);
    $max_created_at = $created_at_row['max_created_at'];

    if (strtotime($event_date) <= strtotime($max_created_at)) {
        echo "<p  class='p' style='color: red;'>Error scheduling course. You must schedule a day after the created day of the scheduling.</p>";
    } else {
        // Insert the event into the database
        $insert_query = "INSERT INTO schedule (course_id, event_name, event_date, event_time, created_at) 
                         VALUES ('$course_id', '$event_name', '$event_date', '$event_time', NOW())";

        if (mysqli_query($conn, $insert_query)) {
            echo "<p class='p' style='color: green; position:relative; left:50px;'>Course scheduled successfully!</p>";
        } else {
            echo "<p class='p' style='color: red; position:relative; left:50px;'>Error scheduling course: " . mysqli_error($conn) . "</p>";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Courses</title>
</head>
<style>
        .form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select, input[type="text"], input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .button:hover {
            background-color: #45a049;
        }

        h3 {
            color: #333;
            margin-top: 30px;
        }

        table {
            width: 60%;
            border-collapse: collapse;
            margin-top: 15px;
            position: relative;
            left: 200px;
            margin-bottom: 40px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: #fff;
        }

        .p {
            margin-top: 15px;
            font-weight: bold;
        }

        .p.error {
            color: #d9534f;
        }

        .p.success {
            color: #5bc0de;
        }
    </style>
<body>
    
    <form method="post" class="form">
        <label for="course_id">Select Course:</label>
        <select id="course_id" name="course_id" required>
            <?php
            while ($row = mysqli_fetch_assoc($course_result)) {
                echo "<option value='{$row['cid']}'>{$row['cname']}</option>";
            }
            ?>
        </select>
        <br>
        <label for="event_name">Course Name:</label>
        <input type="text" id="event_name" name="event_name" required>
        <br>
        <label for="event_date">Course Date:</label>
        <input type="date" id="event_date" name="event_date" required>
        <br>
        <label for="event_time">Course Time:</label>
        <input type="time" id="event_time" name="event_time" required>
        <br>
        <button type="submit" class="button">Schedule Course</button>
    </form>


    <?php
    if ($existing_events_result && mysqli_num_rows($existing_events_result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Course ID</th><th>Course Date</th><th>Course Time</th></tr>";

        while ($row = mysqli_fetch_assoc($existing_events_result)) {
            echo "<tr>";
            echo "<td>" . $row["course_id"] . "</td>";
            echo "<td>" . $row["event_date"] . "</td>";
            echo "<td>" . $row["event_time"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No existing events.";
    }
    ?>

</body>
</html>
