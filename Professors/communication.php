<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Communication</h2>
    <form action="communication.php" method="post">
        <label for="course_name">Course Name:</label>
        <input type="text" id="course_name" name="course_name" required>
        <br>
        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" required></textarea>
        <br>
        <input type="submit" value="Send Message" name=submit>
    </form>
</body>
</html>

<?php
// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$database = "stdmanagment";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
if(isset($_POST["submit"])){
    if(!empty($_POST['course_name']) && !empty($_POST['message'])){
        $course_name = $_POST['course_name'];
        $message = $_POST['message'];
    }
}


// Fetch student emails for the specified course
$sql = "SELECT s.sname, s.email
        FROM student s
        INNER JOIN studentcourses sc ON s.sid = sc.sid
        INNER JOIN course c ON sc.cid = c.cid
        WHERE c.cname = '$course_name'";

$result = mysqli_query($conn, $sql);

if ($result) {
    // Send email to each student
    while ($row = mysqli_fetch_assoc($result)) {
        $student_name = $row['sname'];
        $student_email = $row['email'];

        // Adjust the email content as needed
        $subject = "Message from Teacher";
        $body = "Dear $student_name,\n\n$message";

        // Uncomment the line below to send the email (make sure your server is configured for sending mail)
         mail($student_email, $subject, $body);
    }

    echo "Messages sent successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
