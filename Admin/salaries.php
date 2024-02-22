
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salaries</title>
</head>
<style>
     .salaries {
        border-collapse: collapse;
        width: 80%;
        margin-top: 20px;
        position: relative;
        left: 100px;
        height: 200px;
    }

    .salaries th,
    .salaries td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    .salaries th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .salaries tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .update-button {
        background-color: #3498db;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 8px 12px;
        cursor: pointer;
        font-size: 14px;
        position: relative;
        left: 30px;
    }

    .update-button:hover {
        background-color: #2980b9;
    }

</style>
<body>
<table class="salaries">
<thead>
    <tr>
        <th>Teacher ID</th>
        <th>Teacher Name</th>
        <th>Salary</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php
    // Fetch data from the view
    $fetch_salaries_query = "SELECT * FROM view_teacher_salary";
    $result = $conn->query($fetch_salaries_query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["tid"] . '</td>';
            echo '<td>' . $row["tname"] . '</td>';
            echo '<td>$' . number_format($row["salary"], 2) . '</td>'; // Format salary as currency
            echo '<td>';
            echo '<form method="post" action="main.php?action=update_salary">';
            echo '<input type="hidden" name="teacher_id" value="' . $row["tid"] . '">';
            echo '<input type="number" name="new_salary" placeholder="New Salary" required>';
            echo '<button type="submit" class="update-button">Update</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="4">No data found.</td></tr>';
    }
    ?>
</tbody>
</table>
</body>
</html>