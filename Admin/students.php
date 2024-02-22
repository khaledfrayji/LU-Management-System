<?php
// Your database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve student information from the database
$retrieveStudentsQuery = "SELECT * FROM view_student_info";
$result = $conn->query($retrieveStudentsQuery);

if ($result && $result->num_rows > 0) {
    $students = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $students = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator - Student Management</title>
    <style>
       

        h2 {
            color: #333;
            margin-top: 20px;
        }

        /* Add styles for the search bar */
        .search-container {
            margin-top: 20px;
        }

       
        .button {
            padding: 8px;
            cursor: pointer;
            position: relative;
            left: 600px;
            bottom: 17px;
            border-radius: 60px;
            background-color: purple;
            color: white;
        }
        .button:hover{
            background-color: plum;
            color: white;
            transition: 1.8;
        }
        /* Add styles for the student table */
        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
            background-color: #fff;
            position: relative;
            left: 100px;
        }

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
        .student-details {
            margin-top: 30px;
        }

        .courses-table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
            background-color: #fff;
        }

        .courses-table th,
        .courses-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .courses-table th {
            background-color: #4caf50;
            color: #fff;
        }

        .courses-table tr:hover {
            background-color: #f5f5f5;
        }
        .form button {
  border: none;
  background: none;
  color: #8b8ba7;
}
/* styling of whole input container */
.form {
  --timing: 0.3s;
  --width-of-input: 200px;
  --height-of-input: 40px;
  --border-height: 2px;
  --input-bg: #fff;
  --border-color: #2f2ee9;
  --border-radius: 30px;
  --after-border-radius: 1px;
  position: relative;
  width: var(--width-of-input);
  height: var(--height-of-input);
  display: flex;
  align-items: center;
  padding-inline: 0.8em;
  border-radius: var(--border-radius);
  transition: border-radius 0.5s ease;
  background: var(--input-bg,#fff);
  left: 360px;
  top: 20px;
}
/* styling of Input */
.input {
  font-size: 0.9rem;
  background-color: transparent;
  width: 100%;
  height: 100%;
  padding-inline: 0.5em;
  padding-block: 0.7em;
  border: none;
}
/* styling of animated border */
.form:before {
  content: "";
  position: absolute;
  background: var(--border-color);
  transform: scaleX(0);
  transform-origin: center;
  width: 100%;
  height: var(--border-height);
  left: 0;
  bottom: 0;
  border-radius: 1px;
  transition: transform var(--timing) ease;
}
/* Hover on Input */
.form:focus-within {
  border-radius: var(--after-border-radius);
}

input:focus {
  outline: none;
}
/* here is code of animated border */
.form:focus-within:before {
  transform: scale(1);
}
/* styling of close button */
/* == you can click the close button to remove text == */
.reset {
  border: none;
  background: none;
  opacity: 0;
  visibility: hidden;
}
/* close button shown when typing */
input:not(:placeholder-shown) ~ .reset {
  opacity: 1;
  visibility: visible;
}
/* sizing svg icons */
.form svg {
  width: 17px;
  margin-top: 3px;
}
    </style>
</head>

<body>
 
   

    <!-- Add the search bar with a button -->
    <div class="search-container">
    <form class="form">
      <button>
          <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
              <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
      </button>
      <input class="input" id="studentSearch" placeholder="Enter Student ID..." required="" type="text">
      <button class="reset" type="reset">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
      </button>
  </form>
       
        <button class="button" onclick="filterStudents()">Search</button>
    </div>

    <!-- Student Table -->
    <table border="1">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Domain</th>
                <th>Year</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student) : ?>
                <tr>
                    <td><?php echo $student['sid']; ?></td>
                    <td><?php echo $student['sname']; ?></td>
                    <td><?php echo $student['domain']; ?></td>
                    <td><?php echo $student['year']; ?></td>
                    <td>
                    <a href="student_details.php?id=<?php echo $student['sid']; ?>">View Details</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        function filterStudents() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("studentSearch");
            filter = input.value.toUpperCase();
            table = document.querySelector("table");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0]; // Assuming Student ID is in the first column

                if (td) {
                    txtValue = td.textContent || td.innerText;

                    // Toggle the visibility of rows based on the filter
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>

</html>
