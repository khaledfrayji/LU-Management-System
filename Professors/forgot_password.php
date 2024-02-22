<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            overflow-x: hidden;
        }

        h2 {
            color: #333;
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
            text-align: center;
            position: relative;
            top: 100px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: red;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: gray;
        }

      
    </style>
</head>
<body>
    <h2>Forgot Password</h2>

    <form method="post" action="">
        <label for="email">Enter your email:</label>
        <input type="email" id="email" name="email" placeholder="Enter a valid email" required>
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "stdmanagment";
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT tid, password FROM teacher WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($tid, $hashedPassword);
        $stmt->fetch();
        echo '<script>
        Swal.fire({
            html: "Your Student ID (SID): ' . $tid . '<br>Your Password: ' . password_hash($hashedPassword, PASSWORD_DEFAULT)  . '<br><br>Please save these details in a secure place.",
            icon: "success",
            confirmButtonText: "OK"
        });
    </script>';
       
    } else {
        echo '<script>
                Swal.fire({
                    text: "Email Not Found !",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            </script>';
    }

    $stmt->close();
    $conn->close();
}
?>
