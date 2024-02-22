<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Form</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    body {
        background-color: #002142;
        margin: 0;
        overflow-x: hidden;
    }

    .parent {
        display: flex;
        flex-direction: column;
        position: relative;
        left: 420px;
        width: 500px;
        height: 290px;
        background-color: white;
        padding: 8px 5px 5px 5px;
        border: 1px solid white;
        border-radius: 6px;
        box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
        margin-bottom: 50px;
    }

    .parent h2 {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        padding: 2px 0 2px 0;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-weight: 100;
        color: white;
        border: 1px solid black;
        background: linear-gradient(to top, #3366cc 30%, #ffffff 200%);
        position: relative;
        bottom: 20px;
    }

    .parent p {
        color: black;
        position: relative;
        bottom: 36px;
        margin: 3px 0 3px 0;
        padding-left: 5px;
        background-color: #D9D9D9;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 12px;
    }

    .parent input {
        width: 200px;
        height: 24px;
        position: relative;
        left: 1px;
        top: 1px;
        border: 1px solid black;
        margin-bottom: 5px;
    }

    .parent .username h3 {
        color: white;
        background-color: #3366cc;
        width: 120px;
        height: 16px;
        position: relative;
        bottom: 15px;
        font-size: 16px;
        font-weight: 100;
        padding: 5px;
        border: 1px solid black;
    }

    .parent .username {
        background-color: #D9D9D9;
        display: flex;
        flex-direction: row;
        height: 30px;
        position: relative;
        bottom: 38px;
        margin-bottom: 1px;
    }

    p a {
        color: red;
        text-decoration: none;
    }

    img {
        width: 70px;
        height: 70px;
        position: relative;
        left: 500px;
        top: 70px;
    }

    .logo {
        display: flex;
        flex-direction: row;
    }

    h1 {
        color: white;
        position: relative;
        bottom: 5px;
        left: 570px;
    }

    h4 {
        color: white;
        position: relative;
        font-family: cursive;
        font-weight: 100;
        bottom: 35px;
        left: 570px;
    }

    .username a {
        text-decoration: none;
        color: red;
        font-size: 14px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding-bottom: 5px;
        font-weight: bold;
    }
    
    select{
        position: relative;
        left: 1px;
    }
    button{
        background-color: green;
        color: white;
    }
</style>
<body>
    <div class="logo"></div>
    <img src="../icons/logo.png" alt="">
    <h1>LU</h1>
    <h4>Lebanese University</h4>
    <div class="parent">
        <div class="bar"><h2>Applicant Form</h2></div>
        <form action="" method="post">
            <div class="username"><h3>Name:</h3><input type="text" placeholder="Enter your full name" name="name" required></div>
            <div class="username"><h3>Birthday:</h3><input type="date" name="birthday" required pattern="(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/\d{4}" title="Please enter a valid date in the format DD/MM/YYYY"></div>
            <div class="username"><h3>Address:</h3><input  placeholder="City-street" type="text" name="address" required></div>
            <div class="username"><h3>Phone:</h3><input placeholder="+961 --------" type="tel" name="phone" required   title="Please enter a valid Lebanese phone number starting with +961 and followed by 8 digits"></div>
            <div class="username"><h3>Email:</h3><input type="email" placeholder="user@exemple.com" name="email" required></div>
            <div class="username">
                <h3>Speciality:</h3>
                <select name="speciality" required>
                    <option value="Computer_Science">Computer Science</option>
                    <option value="Physics">Physics</option>
                    <option value="Maths">Maths</option>
                    <option value="Chemistry">Chemistry</option>
                    <option value="Biology">Biology</option>
                    <option value="Bio_Chemistry">Bio-Chemistry</option>
                    <option value="Art">Art</option>
                </select>
            </div>
            <div class="username">
                <h3>Year</h3>
                <select name="year" required >
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                </select>
            </div>
            <div class="username"><button name="submit" type="submit">Submit Application</button></div>
        </form>
        <div class="username"><a href="Login_form.php">Already a student? Login here.</a></div>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stdmanagment";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST["submit"])) {
        // Retrieve values from the form
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $speciality = $_POST['speciality'];
        $year = $_POST['year'];

        // Generate new sid (1 + the last sid in the database)
        $result = $conn->query("SELECT MAX(sid) AS maxSid FROM student");
        $row = $result->fetch_assoc();
        $newSid = ($row['maxSid'] ?? 0) + 1;

        // Generate a random password
        $newPassword = generateRandomPassword();

        // Hash the password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Insert the new applicant into the database
        $insertQuery = "INSERT INTO student (sid, password, sname, bdate, address, phone, email, domain, year)
                        VALUES ('$newSid', '$hashedPassword', '$name', '$birthday', '$address', '$phone', '$email', '$speciality', '$year')";

        if ($conn->query($insertQuery) === TRUE) {
            // Display success message with SID and password
            echo '<script>
                    Swal.fire({
                        title: "Registration Successful!",
                        html: "Your Student ID (SID): ' . $newSid . '<br>Your Password: ' . $newPassword . '<br><br>Please save these details in a secure place.",
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                </script>';
        } else {
            // Display error message
            echo '<script>
                    Swal.fire({
                        text: "Error during registration. Please try again.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                </script>';
        }
    }

    function generateRandomPassword($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
    }
    ?>
</body>
</html>
