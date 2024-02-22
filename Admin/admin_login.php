<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["admin_login"])) {
    $admin_username = $_POST["admin_username"];
    $admin_password = $_POST["admin_password"]; // Password should be securely hashed in a real-world scenario

    // Your authentication logic goes here
    // For simplicity, let's assume a hardcoded admin username and password
    $hardcoded_admin_username = "admin";
    $hardcoded_admin_password = "admin123"; // Hash this password in a real-world scenario

    if ($admin_username === $hardcoded_admin_username && $admin_password === $hardcoded_admin_password) {
        $_SESSION["admin"] = $admin_username;
        header("Location: main.php");
    } else {
        $error_message = "Invalid admin credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: red;
        }

        h2 {
            color: #f2f2f2;
            text-align: center;
            margin-top: 30px;
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

        p.error {
            color: #d9534f;
        }
    </style>
</head>
<body>
    <h2>Admin Login</h2>

    <form method="post">
        <?php if (isset($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>

        <label for="admin_username">Username:</label>
        <input type="text" id="admin_username" name="admin_username" required>

        <label for="admin_password">Password:</label>
        <input type="password" id="admin_password" name="admin_password" required>

        <button type="submit" name="admin_login">Login</button>
    </form>
</body>
</html>
