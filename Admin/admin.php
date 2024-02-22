<?php
session_start();


if (!isset($_SESSION["admin_username"])) {
    header("Location: admin_login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "stdmanagment";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add Teacher
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_teacher"])) {
    $teacher_name = $_POST["teacher_name"];
    $teacher_email = $_POST["teacher_email"];

    $add_teacher_query = "INSERT INTO teacher (name, email) VALUES ('$teacher_name', '$teacher_email')";

    if ($conn->query($add_teacher_query) === TRUE) {
        echo "<p style='color: green;'>Teacher added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error adding teacher: " . $conn->error . "</p>";
    }
}

// View Number of Students
$view_students_query = "SELECT COUNT(*) AS student_count FROM student";
$student_count_result = $conn->query($view_students_query);
$student_count_row = $student_count_result->fetch_assoc();
$student_count = $student_count_row["student_count"];

// View Statistics about Courses and Marks
$course_statistics_query = "SELECT c.cname AS course_name, AVG(m.mark) AS average_mark
                           FROM course c
                           LEFT JOIN markregister m ON c.cid = m.cid
                           GROUP BY c.cid";

$course_statistics_result = $conn->query($course_statistics_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-top: 30px;
        }

        p {
            margin-top: 15px;
            font-weight: bold;
        }

        form {
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

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        th, td {
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
    <h2>Welcome, Admin!</h2>

    <p>Number of Students: <?php echo $student_count; ?></p>

    <form method="post">
        <h3>Add Teacher</h3>
        <label for="teacher_name">Teacher Name:</label>
        <input type="text" id="teacher_name" name="teacher_name" required>
        <label for="teacher_email">Teacher Email:</label>
        <input type="text" id="teacher_email" name="teacher_email" required>
        <button type="submit" name="add_teacher">Add Teacher</button>
    </form>

    <h3>Course Statistics</h3>
    <?php
    if ($course_statistics_result && $course_statistics_result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Course Name</th><th>Average Mark</th></tr>";

        while ($row = $course_statistics_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["course_name"] . "</td>";
            echo "<td>" . round($row["average_mark"], 2) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No course statistics available.";
    }
    ?>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
