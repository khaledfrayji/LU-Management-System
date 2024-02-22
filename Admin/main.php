<?php
session_start();
// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

// Your existing database connection code here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET['action']) && $_GET['action'] === 'add_teacher') {
    $tname = $_POST["tname"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $speciality = $_POST["speciality"];

    // Generate teacher ID (1 + last teacher ID)
    $get_last_id_query = "SELECT MAX(tid) AS max_tid FROM teacher";
    $result = $conn->query($get_last_id_query);
    $row = $result->fetch_assoc();
    $last_id = $row["max_tid"];
    $teacher_id = $last_id + 1;

    // Generate a simple password (you may use a more secure method)
    $password = uniqid();

    // Insert teacher data into the database
    $insert_query = "INSERT INTO teacher (tid, tname, address, phone, email, speciality, password) 
                     VALUES ('$teacher_id', '$tname', '$address', '$phone', '$email', '$speciality', '$password')";

    if ($conn->query($insert_query) === TRUE) {
        $notification = "Your new information: $teacher_id,Password: $password";
    } else {
        $notification = "Error adding teacher." . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET['action']) && $_GET['action'] === 'update_salary') {
    // Process the form submission to update the salary
    $teacher_id = $_POST["teacher_id"];
    $new_salary = $_POST["new_salary"];

    // Update the salary in the database
    $update_salary_query = "UPDATE teacher SET salary = '$new_salary' WHERE tid = '$teacher_id'";
    if ($conn->query($update_salary_query) === TRUE) {
        $notification = "Salary updated successfully.";
    } else {
        $notification = "Error updating salary: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main page</title>
    <link rel="stylesheet" href="index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
</head>

<body>

    <header>
        <div class="header_left header_div">
            <h1>Lebanese university</h1> <img src="../icons/graduation.png" alt="">
        </div>
        <div class="header_right">
            <div class="header_div" id="date">Current Date</div>
            <div class="header_div" id="time">Current Time</div>
            <div class="header_icon"></div>
        </div>
    </header>
    <div class="left-right">
        <nav>
            <div class="menu">
                <div class="main">
                    <h3>Main Menu</h3>
                </div>
                <ul>
                    <a href="main.php">
                        <li><img src="../icons/house.png">Home</li>
                    </a>
                    <a href="main.php?action=notifications"> 
                        <li><img src="../icons/notification.png">Notifications</li>
                    </a>
                    <a href="main.php?action=add_teacher"> 
                        <li><img src="../icons/add.png">Add Teacher</li>
                    </a>
                    <a href="main.php?action=salaries">
                        <li><img src="../icons/salary.png">Salaries</li>
                    </a>
                    <a href="main.php?action=students">
                        <li><img src="../icons/students.png">Students</li>
                    </a>
                    <a href="main.php?action=statistics">
                        <li><img src="../icons/statistic.png">Statistics</li>
                    </a>
                    <a href="main.php?action=contact">
                        <li><img src="../icons/contact.png">Contact Teachers</li>
                    </a>
                    <a href="main.php?action=reports">
                        <li><img src="../icons/marks.png">Reports</li>
                    </a>
            </div>
          
            <form action="main.php" method="post">
                <div class="login" style="height:70px;">
                    <div class="border2">
                        <?php if (isset($_SESSION['admin'])) : ?>
                            <p>Hi, <?php echo $_SESSION["admin"]; ?></p>
                        <?php endif; ?>
                        <button name="logout" style="position: relative; top: 10px; background-color:black; color:white; width:60px;">Logout</button>
                        <?php
                        if (isset($_POST["logout"])) {
                            session_destroy();
                            exit();
                        }
                        ?>
                    </div>
                </div>
            </form>
        </nav>
        <div class="right" >
            <div class="title" >
                <h5>Faculty of Science &#x2160;</h5>
            </div>
            <h4>#<span class="auto-type">Written</span>by Khaled Frayji</h4>
            <div class="border"></div>

            <?php if (isset($notification) && $notification != "Error adding teacher.") : ?>
                <?php echo '<script>
        Swal.fire({
            html: "' . $notification . ' ",
            icon: "success",
            confirmButtonText: "OK"
        });
    </script>'; ?>

            <?php endif; ?>
            <?php

            if (isset($_GET['action']) && $_GET['action'] === 'add_teacher') {
                include "add.php";
            }
            if (isset($_GET['action']) && $_GET['action'] === 'salaries') {
                include "salaries.php";
            }
            if (isset($_GET['action']) && $_GET['action'] === 'statistics') {

                include "statistics.php";
            }
            if (isset($_GET['action']) && $_GET['action'] === 'reports') {
                include 'adminstrator.php';
            }
            if (isset($_GET['action']) && $_GET['action'] === 'contact') {
                include 'contact.php';
            }
            if (isset($_GET['action']) && $_GET['action'] === 'students') {
                include 'students.php';
            }
            if (isset($_GET['action']) && $_GET['action'] === 'notifications') {
                include 'sendNotification.php';
                
            }
            
            ?>
            
        </div><!--end of right -->

    </div> <!--end of left-right-->

    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script>
        var typed = new Typed(".auto-type", {
            strings: ["Designed"],
            typeSpeed: 100,
            backSpeed: 100,
            loop: true
        })
    </script>
    <script src="index.js"></script>
    <footer>
        <div class="footer-content">
            <p>&copy; <?php echo date("Y"); ?> Lebanese University. All rights reserved.</p>
            <p>Designed by Khaled Frayji</p>
        </div>
    </footer>
    <script src="../Student/index.js"></script>
</body>
</html>
<?php
// Close the database connection
$conn->close();
?>