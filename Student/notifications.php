<?php
// Initialize the notifications array (you can replace this with database storage)
$notifications = isset($_COOKIE['notifications']) ? json_decode($_COOKIE['notifications'], true) : [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["send"])) {
    // Get the input value from the form
    $notificationText = $_POST["notifications"];

    // Add the new notification to the array
    $notifications[] = $notificationText;

    // Save the updated notifications array to the cookie
    setcookie('notifications', json_encode($notifications), time() + (86400 * 365), '/'); // Cookie expires in 1 yeqr
}

// Loop through notifications and display them in table rows
if (isset($notifications) && is_array($notifications) && !empty($notifications)) {
    foreach ($notifications as $notification) {
        echo "<p class='p'>_$notification</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
</head>
<style>
    .p {
        color: red;
        position: relative;
        top: 100px;
        left: 50px;
    }
</style>

<body>

</body>

</html>