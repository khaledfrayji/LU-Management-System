<!-- student_details.php -->

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $studentID = $_GET['id'];

    // Retrieve student information
    $getStudentQuery = "SELECT * FROM student WHERE sid = '$studentID'";
    $studentResult = $conn->query($getStudentQuery);

    if ($studentResult && $studentResult->num_rows > 0) {
        $studentDetails = $studentResult->fetch_assoc();
    }

    // Retrieve courses taken by the student
    $getCoursesQuery = "SELECT c.cid, c.cname FROM studentcourses sc
                        JOIN course c ON sc.cid = c.cid
                        WHERE sc.sid = '$studentID'";
    $coursesResult = $conn->query($getCoursesQuery);

    if ($coursesResult && $coursesResult->num_rows > 0) {
        $courses = $coursesResult->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!-- student_details.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            width: 50%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
        }

        .student-details {
            margin-top: 30px;
        }

        .student-details p {
            margin-bottom: 10px;
        }

        .courses-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .courses-table th,
        .courses-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .courses-table th {
            background-color: #4caf50;
            color: #fff;
        }

        .courses-table tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Student Details</h2>

        <!-- Display student information -->
        <div class="student-details">
            <p><strong>Student ID:</strong> <?php echo $studentDetails['sid']; ?></p>
            <p><strong>Name:</strong> <?php echo $studentDetails['sname']; ?></p>
            <p><strong>Birthdate:</strong> <?php echo $studentDetails['bdate']; ?></p>
            <p><strong>address:</strong> <?php echo $studentDetails['address']; ?></p>
            <p><strong>Domain:</strong> <?php echo $studentDetails['domain']; ?></p>
            <p><strong>Year:</strong> <?php echo $studentDetails['year']; ?></p>
        </div>

        <!-- Display courses taken by the student -->
        <table class="courses-table">
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course) : ?>
                    <tr>
                        <td><?php echo $course['cid']; ?></td>
                        <td><?php echo $course['cname']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
