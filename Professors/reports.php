<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";
$conn = new mysqli($servername, $username, $password, $dbname);

// Ensure a teacher is logged in
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("Location: Login_form.php"); 
    exit();
}

$teacher_id = $_SESSION["username"];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_report"])) {
    $student_id = $_POST['student_id'];
    $report_text = $_POST['report_text'];

    // Insert report into the database
    $insertReportQuery = "INSERT INTO reports (student_id, teacher_id, report_text) VALUES ('$student_id', '$teacher_id', '$report_text')";

    if ($conn->query($insertReportQuery) === TRUE) {
        // Report submitted successfully
        echo '<script>alert("Report submitted successfully.");</script>';
    } else {
        // Error submitting report
        echo '<script>alert("Error submitting report. Please try again.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Report Submission</title>
</head>
<style>
    /* reports.php styles */
   

    .form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        position: relative;
        left: 190px;
        width: 50%;
    }

    label {
        display: block;
        margin: 10px 0;
        font-weight: bold;
    }

    input,
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .button {
        background-color: #4caf50;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .button:hover {
        background-color: #45a049;
    }

    h2 {
        color: #333;
        position: relative;
        bottom: 200px;
        left: 150px;
    }
</style>
<body>
    <h2>Submit Report</h2>
    <form action="" method="post" class="form">
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>

        <label for="report_text">Report Text:</label>
        <textarea id="report_text" name="report_text" rows="4" required></textarea>

        <button class="button" type="submit" name="submit_report">Submit Report</button>
    </form>
</body>

</html>
