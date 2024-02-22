<?php


if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

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

$teacherId = $_SESSION["username"];

$coursesQuery = "SELECT cid, cname FROM course WHERE teacher = '$teacherId'";
$coursesResult = mysqli_query($conn, $coursesQuery);

if (!$coursesResult) {
    $error = "Error retrieving courses: " . mysqli_error($conn);
}

// Retrieve appeals and marks related to the teacher's courses
$appealsQuery = "SELECT s.sname, s.sid, a.appeal_id, a.appeal_text, a.course_id, m.mark
                 FROM appeals a
                 JOIN student s ON a.student_id = s.sid
                 LEFT JOIN markregister m ON a.student_id = m.sid AND a.course_id = m.cid
                 WHERE a.course_id IN (SELECT cid FROM course WHERE teacher = '$teacherId')
                 AND a.status = 'Pending'";
$appealsResult = mysqli_query($conn, $appealsQuery);

if (!$appealsResult) {
    $error = "Error retrieving appeals: " . mysqli_error($conn);
}

// Process form submission for updating the mark
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appealIdToUpdate = $_POST["appeal_id"];
    $newMark = $_POST["new_mark"];

    $updateMarkQuery = "UPDATE markregister SET mark = '$newMark' WHERE sid = (SELECT student_id FROM appeals WHERE appeal_id = '$appealIdToUpdate') AND cid = (SELECT course_id FROM appeals WHERE appeal_id = '$appealIdToUpdate')";
    if (mysqli_query($conn, $updateMarkQuery)) {
        $successMessage = "Mark updated successfully.";
    } else {
        $error = "Error updating mark: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appeals</title>
</head>
<style>
      

        h2 {
            color: #333;
        }

     

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
            margin-left: 50px;
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
        input[type="number"] {
            width: 55px;
            height: 25px;
            padding: 6px;
            box-sizing: border-box;
        }

        .button {
            margin-left: 10px;
            padding: 8px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #45a049;
        }

        /* Adjusted width for the Action column */
        td:last-child {
            max-width: 200px;
            overflow: hidden;
            white-space: nowrap;
        }
    </style>
<body>
    <h2>View Appeals</h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>Error: $error</p>";
    } elseif (isset($successMessage)) {
        echo "<p style='color: green;'>$successMessage</p>";
    }
    ?>

   



    <table border="1">
        <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Course ID</th>
            <th>Mark</th>
            <th>Appeal Text</th>
            <th>Contact</th>
            <th>Action</th>
        </tr>

        <?php
        while ($appeal = mysqli_fetch_assoc($appealsResult)) {
            echo "<tr>";
            echo "<td>{$appeal['sid']}</td>";
            echo "<td>{$appeal['sname']}</td>";
            echo "<td>{$appeal['course_id']}</td>";
            echo "<td>{$appeal['mark']}</td>";
            echo "<td>{$appeal['appeal_text']}</td>";
            echo "<td><a href='mailto:{$appeal['sid']}@example.com'>Contact</a></td>";
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='appeal_id' value='{$appeal['appeal_id']}'>";
            echo "<label for='new_mark'>New Mark:</label>";
            echo "<input type='number' id='new_mark' name='new_mark' required min='0' max='100'>";
            echo "<button class='button' type='submit'>Update</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>