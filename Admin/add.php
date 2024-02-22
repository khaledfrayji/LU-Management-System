<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Teacher</title>
    <link rel="stylesheet" href="index.css">
</head>

<style>
 
    .form-container {
        width: 60%;
        margin-top: 50px;
        background-color: #f2f2f2;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        left: 150px;
        background: url("../icons/Lu.jpg");
        object-fit: cover;
    }

    table {
        width: 100%;
        border: 1px solid black;
        border-radius: 6px;
        background-color: #f2f2f2;
    }

    table tr {
        margin-bottom: 20px;
       
    }

    table td {
        padding: 10px;
       
    }

    .button {
        background-color: #3498db;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
    }

    .button:hover {
        background-color: #2980b9;
    }
</style>

<body>
    <!-- Your HTML code for the header, navigation, and right section -->

    <!-- Teacher Registration Form -->
    <div class="form-container">
        <form method="post" action="">
            <table>
                <tr>
                    <td><label for="tname">Teacher Name:</label></td>
                    <td><input type="text" id="tname" name="tname" required></td>
                </tr>
                <tr>
                    <td><label for="address">Address:</label></td>
                    <td><input type="text" id="address" name="address" required></td>
                </tr>
                <tr>
                    <td><label for="phone">Phone:</label></td>
                    <td><input type="text" id="phone" name="phone" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email" required></td>
                </tr>
                
                <tr>
                    <td><label for="speciality">Speciality:</label></td>
                    <td><input type="text" id="speciality" name="speciality" required></td>
                </tr>
            </table>
            <button type="submit" class="button">Register Teacher</button>
        </form>
    </div>

</body>

</html>
