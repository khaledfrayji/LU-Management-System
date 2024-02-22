<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login_form</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    body{
         background-color: #002142;
         margin: 0;
         overflow-x: hidden;
    }
    .parent{
        display: flex;
        flex-direction: column;
        position: relative;
        left: 420px;
        top: 10px;
        width: 500px;
        height: 210px;
        background-color: white;
        padding: 8px 5px 5px 5px;
        border: 1px solid white;
        border-radius: 6px;
        box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
    }
    .parent h2{
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
    .parent p{
        color: black;
        position: relative;
        bottom: 36px;
        margin: 3px 0 3px 0;
        padding-left: 5px;
        background-color:#D9D9D9;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 12px;
    }
    .parent input{
        width:200px;
        height: 24px;
        position: relative;
        left: 1px;
        top: 1px;
        border: 1px solid black;
    }
    .parent .username h3{
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
    .parent .username{
        background-color:  #D9D9D9;
        display: flex;
        flex-direction: row;
        height: 30px;
        position: relative;
       bottom: 38px;
        margin-bottom: 1px;
    }
    p a{
        color: red;
        text-decoration: none;
    }
    img{
        width: 70px;
        height: 70px;
        position: relative;
        left: 500px;
        top: 70px;
    }
    .logo{
        display: flex;
        flex-direction: row;
    }
     h1{
        color: white;
        position: relative;
        bottom: 5px;
        left: 570px;
        
    }
    h4{
        color: white;
        position: relative;
        font-family: cursive;
        font-weight: 100;
        bottom: 35px;
        left: 570px;
    }
    .username a{
        text-decoration: none;
        color: red;
        font-size: 14px;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }
</style>
<body>
    <form action="Login_form.php" method="post">
        <div class="logo"></div>
        <img src="../icons/logo.png" alt="">
        <h1>LU</h1><h4>Lebanese University</h4>
        <div class="parent">
            <div class="bar"><h2>Lebanese University</h2></div>
            <p>If you are an <a href="applicant.php">Applicant</a> and not yet a student,please <a href="applicant.php">Go To Lebanese University Applicant Section</a></p>
            <div class="username"> <div style="visibility: hidden;">hidden content</div></div>
                <div class="username"><h3>Username:</h3><input type="text" name="user" required></div>
                <div class="username"><h3>Password:</h3><input type="password" name="pass" required></div>
                <div class="username"><button name="login">Login</button></div>
                <div class="username"> <div style="visibility: hidden;">hidden content</div></div>
                <div class="username"><a href="forgot_password.php">Forgot Your Id/Password?</a></div>
                <div class="username"> <div style="visibility: hidden;">hidden content</div></div>
 
        </div>
    </form>
</body>
</html>
<?php
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
if (isset($_POST["login"])) {
    if (!empty($_POST["user"] && !empty($_POST["pass"]))) {
        $id = $_POST["user"];
        $password = $_POST["pass"];
    }

    // Retrieve the hashed password from the database based on the provided username
    $query = "SELECT sid, password FROM student WHERE sid = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];

        // Verify the entered password against the stored hash
        if (password_verify($password, $hashedPassword) || $hashedPassword==$password) {
            // Password is correct
            $_SESSION["username"] = $id;
            $_SESSION["password"] = $hashedPassword; // Save the hashed password in the session if needed
            //go to the main page
            echo '<meta http-equiv="refresh" content="0;url=main.php">';
        } else {
            // Password is incorrect
            echo '<script>
                Swal.fire({
                    text: "Invalid Id/Password",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            </script>';
        }
    } else {
        // User not found
        echo '<script>
            Swal.fire({
                text: "Invalid Id/Password",
                icon: "error",
                confirmButtonText: "OK"
            });
        </script>';
    }
}
       
           
        ?>