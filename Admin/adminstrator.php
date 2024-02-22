<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle blacklisting
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["blacklist_student"])) {
    $blacklistedStudentId = $_POST['blacklisted_student_id'];

    // Insert the student into the black_list table
    $insertBlackListQuery = "INSERT INTO black_list (student_id) VALUES ('$blacklistedStudentId')";

    if ($conn->query($insertBlackListQuery) === TRUE) {
        // Student blacklisted successfully
        echo '<script>
                    Swal.fire({
                       
                        html: "Student Blacklisted successfully!",
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                </script>';
    } else {
        // Error blacklisting student
        echo '<script>
        Swal.fire({
            html: "Error blacklisting student. Please try again.",
            icon: "error",
            confirmButtonText: "OK"
        });
    </script>';
    }
}

// Retrieve reports with teacher ID from the database
$retrieveReportsQuery = "SELECT r.report_id, r.student_id, r.report_text, r.teacher_id
                         FROM reports r;";
$result = $conn->query($retrieveReportsQuery);

if ($result && $result->num_rows > 0) {
    $reports = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $reports = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator - Reports</title>
</head>
<style>
    /* administrator.php styles */




    table {
        border-collapse: collapse;
        width: 80%;
        margin-top: 20px;
        background-color: #fff;
        position: relative;
        left: 60px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #4caf50;
        color: #fff;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    .blacklist-button {
        background-color: red;
        color: white;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
    }

    .blacklist-button:hover {
        background-color: darkred;
    }
</style>

<body>

    <table border="1">
        <thead>
            <tr>
                <th>Report ID</th>
                <th>Student ID</th>
                <th>Teacher ID</th>
                <th>Report Text</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report) : ?>
                <tr>
                    <td><?php echo $report['report_id']; ?></td>
                    <td><?php echo $report['student_id']; ?></td>
                    <td><?php echo $report['teacher_id']; ?></td>
                    <td><?php echo $report['report_text']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="blacklisted_student_id" value="<?php echo $report['student_id']; ?>">
                            <button type="submit" name="blacklist_student" class="blacklist-button">Blacklist</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>