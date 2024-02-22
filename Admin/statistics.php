<?php
// Get the number of students
$num_students_query = "SELECT COUNT(*) AS num_students FROM student";
$result_students = $conn->query($num_students_query);
$row_students = $result_students->fetch_assoc();
$num_students = $row_students['num_students'];

// Display the number of students in a table
echo '<table class="statistics-table">';
echo '<tr><th>Statistic</th><th>Value</th></tr>';
echo '<tr><td>Total Number of Students in the Faculty</td><td>' . $num_students . '</td></tr>';

// Fetch and display the percentage of success in each course
$success_percentage_query = "SELECT course.cname, COUNT(*) AS num_students,
                                          AVG(CASE WHEN marks.mark >= 50 THEN 1 ELSE 0 END) * 100 AS success_percentage
                                    FROM markregister marks
                                    JOIN course ON marks.cid = course.cid
                                    GROUP BY marks.cid";

$result_success = $conn->query($success_percentage_query);

while ($row_success = $result_success->fetch_assoc()) {
    $formatted_percentage = number_format($row_success['success_percentage'], 2);
    echo '<tr><td>Success Percentage ' . $row_success['cname'] . '</td><td>' . $formatted_percentage . '%</td></tr>';
}

echo '</table>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
      .statistics-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .statistics-card {
            width: 300px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .statistics-card h3 {
            color: #333;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .statistics-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .statistics-table th,
        .statistics-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .statistics-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .statistics-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
</style>

<body>

</body>

</html>
