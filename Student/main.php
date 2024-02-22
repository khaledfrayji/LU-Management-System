<?php
session_start(); // Start the session

?>
<?php

include '../database/procedure.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlCreateProcedure = GetStudentDetailsProcedure();
$conn->multi_query($sqlCreateProcedure);

$studentId = isset($_SESSION["username"]) ? $_SESSION["username"] : null;

if ($studentId) {
    $stmt = $conn->prepare("CALL GetStudentId(?)");
    $stmt->bind_param("i", $studentId);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $username = $row["sname"];
    }

    $stmt->close();
}

$conn->close();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main page</title>
    <link rel="stylesheet" href="index.css">

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
                    <a href="main.php?action=notification">
                        <li><img src="../icons/notification.png">Notifications</li>
                    </a>
                    <a href="profile.php">
                        <li><img src="../icons/user.png">Profile</li>
                    </a>
                    <a href="main.php?action=courses">
                        <li><img src="../icons/courses.png">Courses</li>
                    </a>
                    <a href="main.php?action=current">
                        <li><img src="../icons/course.png">Current Courses</li>
                    </a>
                    <a href="main.php?action=marks">
                        <li><img src="../icons/marks.png">Marks</li>
                    </a>
                    <a href="main.php?action=appeals">
                        <li><img src="../icons/refuse.png">Appeals</li>
                    </a>
                    <a href="main.php?action=scheduling">
                        <li><img src="../icons/calendar.png">Scheduling</li>
                    </a>
                    <a href="main.php?action=exams">
                        <li><img src="../icons/exam.png">Exams</li>
                    </a>
                    <a href="main.php?action=classmates">
                        <li><img src="../icons/education.png">Classmates</li>
                    </a>
                    <a href="about-us.php">
                        <li><img src="../icons/about.png">About Us</li>
                    </a>
                    <a href="help.php">
                        <li><img src="../icons/aide.png">Help</li>
                    </a>
                </ul>
            </div>

            <form action="main.php" method="post">


                <div class="login" style="height:70px;">
                    <div class="border2">
                        <?php if (isset($_SESSION['username'])) : ?>
                            <p>Hi, <?php echo $username; ?></p>
                        <?php endif; ?>

                        <button name="logout" style="position: relative; top: 10px; background-color: red; color:white; width:60px;">Logout</button>
                        <?php
                        if (isset($_POST["logout"])) {
                            session_destroy();
                            header("Location:Login_form.php");
                        }

                        ?>
                    </div>
                </div>

            </form>

        </nav>
        <div class="right">
            <div class="title">
                <h5>Faculty of Science &#x2160;</h5>

            </div>
            <h4>#<span class="auto-type">Written</span>by Khaled Frayji</h4>
            <div class="border"></div>
            <table class="mytable" id="mytable">

            </table>
            <?php
            if (isset($_GET['action']) && $_GET['action'] === 'notification') {
                include "notifications.php";
            }
            if (isset($_GET['action']) && $_GET['action'] === 'courses') {
                include "courses.php";
            }
            if (isset($_GET['action']) && $_GET['action'] === 'current') {
                include "current-courses.php";
            }
            if (isset($_GET['action']) && $_GET['action'] === 'marks') {
                include "marks.php";
            }
            if (isset($_GET['action']) && $_GET['action'] === 'appeals') {
                include "appeals.php";
            }
            if (isset($_GET['action']) && $_GET['action'] === 'scheduling') {
                include "view_scheduling.php";
            }
            if (isset($_GET['action']) && $_GET['action'] === 'exams') {
                include "exams.php";
            }
            if (isset($_GET['action']) && $_GET['action'] === 'classmates') {
                include "mates.php";
            }
          
            ?>
        </div><!--end of right -->
    </div> <!--end of left-right -->



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
</body>

</html>