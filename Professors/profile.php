<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tid = $_SESSION["username"];

$retrieveStudentQuery = "SELECT * FROM teacher WHERE tid = '$tid'";
$result = $conn->query($retrieveStudentQuery);

if ($result && $result->num_rows > 0) {
    $fetch_info = $result->fetch_assoc();

    // Store student information in the session
    $_SESSION['tid'] = $fetch_info['tid'];
    $_SESSION['tname'] = $fetch_info['tname'];
    $_SESSION['profile_picture'] = $fetch_info['profile_picture'];
} else {
    $_SESSION['errors'][] = "Error retrieving student information: " . $conn->error;
}

$errors = [];
$successMessage = "";
$targetFilePath = "";

if (isset($_POST["update_picture"])) {
    $uploadedFileName = basename($_FILES["profilePic"]["name"]);
    $targetFilePath = "uploads/" . $uploadedFileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (!empty($uploadedFileName) && move_uploaded_file($_FILES["profilePic"]["tmp_name"], $targetFilePath)) {
        $updateQuery = "UPDATE teacher SET profile_picture = '$targetFilePath' WHERE tid = '$tid'";

        if ($conn->query($updateQuery) === TRUE) {
            $successMessage = "Profile picture updated successfully.";
            $_SESSION['profile_picture'] = $targetFilePath;
        } else {
            $errors[] = "Error updating profile picture: " . $conn->error;
        }
    } else {
        $errors[] = "File upload failed.";
    }
}

if (isset($_POST['change_password'])) {
    // Get form data
    $currentPassword = htmlspecialchars($_POST["current_Password"]);
    $newPassword = htmlspecialchars($_POST["new_Password"]);
    $retypePassword = htmlspecialchars($_POST["retype_Password"]);

    // Validate input data
    if (empty($currentPassword) || empty($newPassword) || empty($retypePassword)) {
        $errors[] = "All fields are required.";
    }

    $checkCurrentPasswordQuery = "SELECT password FROM teacher WHERE tid = '$tid'";
    $result = mysqli_query($conn, $checkCurrentPasswordQuery);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $storedPasswordHash = $row['password'];

        // Verify the current password
        if (password_verify($currentPassword, $storedPasswordHash) || $currentPassword==$storedPasswordHash) {
            // Check if the new passwords match
            if ($newPassword !== $retypePassword) {
                $errors[] = "New passwords do not match.";
            } else {
                // Hash the new password
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the hashed password in the database
                $updateQuery = "UPDATE teacher SET password = '$hashedNewPassword' WHERE tid = '$tid'";

                if ($conn->query($updateQuery) === TRUE) {
                    $successMessage = "Password changed successfully.";
                } else {
                    $errors[] = "Error updating password: " . $conn->error;
                }
            }
        } else {
            $errors[] = "Current password is incorrect.";
        }
    } else {
        $errors[] = "Error checking current password. Please try again.";
    }
}

if (isset($_POST['update_email'])) {
    // Get new email from form data
    $newEmail = htmlspecialchars($_POST["newEmail"]);

    // Validate input data
    if (empty($newEmail)) {
        $errors[] = "New email is required.";
    } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Check if the email is already used
    $checkEmailQuery = "SELECT tid FROM teacher WHERE email = '$newEmail'";
    $result = $conn->query($checkEmailQuery);

    if ($result !== FALSE) {
        if ($result->num_rows > 0) {
            $errors[] = "Email is already used by another user.";
        }
    } else {
        $errors[] = "Error checking email: " . $conn->error;
    }

    // Update email in the database if no errors
    if (empty($errors)) {
        $updateEmailQuery = "UPDATE teacher SET email = '$newEmail' WHERE tid = '$tid'";

        if ($conn->query($updateEmailQuery) === TRUE) {
            $successMessage = "Email updated successfully.";
        } else {
            $errors[] = "Error updating email: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Your Website</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            overflow-x: hidden;
        }

        main {
            padding: 20px;
            position: relative;
            bottom: 180px;
        }

       

        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #495057;
        }

        input {
            width: 60%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        button {
            background-color: #28a745;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        .success-message {
            border: 2px solid #28a745;
            background-color: #d4edda;
            color: #218838;
            padding: 10px;
            width: 60%;
            margin-bottom: 20px;
        }

        .error-message {
            border: 2px solid #dc3545;
            background-color: #f8d7da;
            color: #dc3545;
            padding: 10px;
            margin-bottom: 20px;
            width: 60%;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            position: relative;
            left: 600px;
            bottom: 200px;
        }

        .cover {
            width: 100%;
            height: 300px; /* Adjust the height as needed */
            position: relative;
            background: url("../icons/lu.jpg") no-repeat center center;
            text-align: center;
            margin-bottom: 40px;
            color: #fff;
            padding: 20px;
            background-size: cover;
            border: 5px solid black;
   
        }

        h3 {
            font-size: 24px;
            margin-bottom: 20px;
            position: relative;
            left: 625px;
            bottom: 90px;
        }

        .info {
            margin-bottom: 40px;
        }

        h1 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        h1 span {
            color: #007bff;
        }
    </style>

</head>

<body>
    <a id="error-anchor1"></a>
    <div class="cover">
      
    </div>

    <img src="<?php echo isset($fetch_info['profile_picture']) ? $fetch_info['profile_picture'] : ''; ?>" alt="Profile Picture" class="profile-picture">
    <main>
        <div class="info">
            <h1>Hi, <span><?php echo isset($fetch_info['tname']) ? $fetch_info['tname'] : ''; ?></span></h1>
            <h1>Your Id is: <span><?php echo isset($fetch_info['tid']) ? $fetch_info['tid'] : ''; ?></span></h1>
            <h1>Your email is:<span> <?php echo isset($fetch_info['email']) ? $fetch_info['email'] : ''; ?></span></h1>
        </div>
        <section>
            <h2>Change Profile</h2>
            <form enctype="multipart/form-data" method="post">
                <input type="file" id="profilePic" name="profilePic" accept="image/*">
                <?php
                // Display error for the profile picture input
                if (!empty($errors) && in_array("File upload failed.", $errors)) {
                    echo '<p class="error-message">File upload failed.</p>';
                    // Redirect to the anchor when an error occurs
                    echo '<script>window.location.href = "#error-anchor1";</script>';
                }
                ?>
                <br><button type="submit" name="update_picture">Update</button>
            </form>
        </section>
        <br>

        <section>
            <h2>Change Email</h2>
            <form method="post">
                <label for="newEmail">New Email:</label>
                <input type="email" id="newEmail" name="newEmail" required>
                <?php
                // Display error for the newEmail input
                if (!empty($errors) && in_array("New email is required.", $errors)) {
                    echo '<p class="error-message">New email is required.</p>';
                    // Redirect to the anchor when an error occurs
                    echo '<script>window.location.href = "#error-anchor3";</script>';
                } elseif (!empty($errors) && in_array("Invalid email format.", $errors)) {
                    echo '<p class="error-message">Invalid email format.</p>';
                    // Redirect to the anchor when an error occurs
                    echo '<script>window.location.href = "#error-anchor3";</script>';
                } elseif (!empty($errors) && in_array("Email is already used by another user.", $errors)) {
                    echo '<p class="error-message">Email is already used by another user.</p>';
                    // Redirect to the anchor when an error occurs
                    echo '<script>window.location.href = "#error-anchor3";</script>';
                }
                ?>
                <a id="error-anchor3"></a>
                <br><button type="submit" name="update_email">Submit</button>
            </form>
        </section>

        <br>

        <section>
            <h2>Change Password</h2>
            <form method="post">
                <label for="currentPassword">Current Password:</label>
                <input type="password" id="currentPassword" name="current_Password" required>
                <?php
                // Display error for the currentPassword input
                if (!empty($errors) && in_array("Current password is incorrect.", $errors)) {
                    echo '<p class="error-message">Current password is incorrect.</p>';
                    // Redirect to the anchor when an error occurs
                    echo '<script>window.location.href = "#error-anchor2";</script>';
                }
                ?>
                <a id="error-anchor2"></a>
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" name="new_Password" required>
                <label for="retypePassword">Retype Password:</label>
                <input type="password" id="retypePassword" name="retype_Password" required>
                <?php
                // Display error for the currentPassword input
                if (!empty($errors) && in_array("New passwords do not match.", $errors)) {
                    echo '<p class="error-message">New passwords do not match.</p>';
                    // Redirect to the anchor when an error occurs
                    echo '<script>window.location.href = "#error-anchor4";</script>';
                }
                ?>
                <a id="error-anchor3"></a>
                <br> <button type="submit" name="change_password">Submit</button>
            </form>
        </section>
    </main>

</body>

</html>