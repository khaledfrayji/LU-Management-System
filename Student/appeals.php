<?php


if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $courseId = $_POST["course_id"];
    $appealText = $_POST["appeal_text"];

    // Validate form data (add more validation as needed)
    if (empty($courseId) || empty($appealText)) {
        $error = "All fields are required.";
    } else {
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

        $studentId = $_SESSION["username"];
        $status = "Pending";

        // Check if the student ID exists in the student table
        $checkStudentQuery = "SELECT sid FROM student WHERE sid = '$studentId'";
        $resultCheckStudent = mysqli_query($conn, $checkStudentQuery);

        if ($resultCheckStudent && mysqli_num_rows($resultCheckStudent) > 0) {
            // Check if the student has a mark for the specified course
            $checkMarkQuery = "SELECT mark FROM markregister WHERE sid = '$studentId' AND cid = '$courseId'";
            $resultCheckMark = mysqli_query($conn, $checkMarkQuery);

            if ($resultCheckMark && mysqli_num_rows($resultCheckMark) > 0) {
                // Student has a mark for the course, proceed with the appeal insertion
                $insertQuery = "INSERT INTO appeals (student_id, course_id, appeal_text, status) VALUES ('$studentId', '$courseId', '$appealText', '$status')";

                if (mysqli_query($conn, $insertQuery)) {
                    $successMessage = "Appeal submitted successfully.";
                } else {
                    $error = "Error submitting appeal: " . mysqli_error($conn);
                }
            } else {
                // Student does not have a mark for the course
                $error = "Cannot submit appeal. No mark found for the specified course.";
            }
        } else {
            // Student ID does not exist in the student table
            $error = "Invalid student ID.";
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Appeal</title>
</head>
<style>
      
        .form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            position: relative;
            left: 320px;
            top: 100px;
        }

      

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .button:hover {
            background-color: #45a049;
        }

       

        p.success {
            border: 2px solid #28a745;
            background-color: #d4edda;
            color: #218838;
            padding: 10px;
            margin-bottom: 20px;
        }
        p.error{
            border: 2px solid #dc3545;
            background-color: #f8d7da;
            color: #dc3545;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <form method="post" class="form">
        

        <?php
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        } elseif (isset($successMessage)) {
            echo "<p class='success'>$successMessage</p>";
        }
        ?>

        <label for="course_id">Course ID:</label>
        <input type="text" id="course_id" name="course_id" required>

        <label for="appeal_text">Appeal Text:</label>
        <textarea id="appeal_text" name="appeal_text" rows="4" required></textarea>

        <button class="button" type="submit">Submit Appeal</button>
    </form>
</body>
</html>