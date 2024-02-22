<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve teacher information from the database
$retrieveTeachersQuery = "SELECT * FROM view_teacher_info";
$result = $conn->query($retrieveTeachersQuery);

if ($result && $result->num_rows > 0) {
    $teachers = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $teachers = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator - Contact Teachers</title>
    <style>
 
       

       

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .contact-button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
        }

        .contact-button:hover {
            background-color: #2980b9;
        }
        .search-container {
            margin-top: 20px;
            position: relative;
            left: 120px;
        }

        input[type=text] {
            width: 200px;
            padding: 8px;
            box-sizing: border-box;
        }

        /* Adjust the table position */
        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
            background-color: #fff;
            position: relative;
            left: 120px;
        }

        /* Add new style for filtered rows */
        .filtered-row {
            background-color: red;
        }
    </style>
</head>

<body>
    <!-- Add the search bar -->
    <div class="search-container">
        <label for="teacherSearch">Search by Teacher ID:</label>
        <input type="text" id="teacherSearch" oninput="filterTeachers()" placeholder="Enter Teacher ID...">
    </div>
    <table border="1">
        <thead>
            <tr>
                <th>Teacher ID</th>
                <th>Teacher Name</th>
                <th>Email</th>
                <th>Speciality</th>
                <th>Contact</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teachers as $teacher) : ?>
                <tr>
                    <td><?php echo $teacher['tid']; ?></td>
                    <td><?php echo $teacher['tname']; ?></td>
                    <td><?php echo $teacher['email']; ?></td>
                    <td><?php echo $teacher['speciality']; ?></td>
                    <td>
                       <a href="mailto:<?php echo $teacher['email']; ?>"><button class="contact-button">Contact</button></a> 
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        function filterTeachers() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("teacherSearch");
            filter = input.value.toUpperCase();
            table = document.querySelector("table");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0]; // Assuming Teacher ID is in the first column

                if (td) {
                    txtValue = td.textContent || td.innerText;

                    // Toggle the visibility of rows based on the filter
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].classList.remove("filtered-row");
                    } else {
                        tr[i].classList.add("filtered-row");
                    }
                }
            }
        }

     
    </script>
</body>

</html>
 
</body>

</html>
