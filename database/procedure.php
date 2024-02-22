<?php

function GetStudentDetailsProcedure() {
    $procedureName = 'GetStudentId';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stdmanagment";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    // Drop the procedure if it exists
    $dropQuery = "DROP PROCEDURE IF EXISTS $procedureName";
    $dropResult = mysqli_query($conn, $dropQuery);
    $sql = "
    CREATE PROCEDURE  GetStudentId(IN student_id INT)
    BEGIN
        SELECT * FROM student WHERE sid = student_id;
    END;
";

    return $sql;
}
function GetTeacherDetailsProcedure() {
    $procedureName = 'GetTeacherId';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stdmanagment";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    // Drop the procedure if it exists,كرمال اذا كان موجود من قبل
    $dropQuery = "DROP PROCEDURE IF EXISTS $procedureName";
    $dropResult = mysqli_query($conn, $dropQuery);
    $sql = "
    CREATE PROCEDURE  GetTeacherId(IN teacher_id INT)
    BEGIN
        SELECT * FROM teacher WHERE tid = teacher_id;
    END;
";
    return $sql;
}



//written by khaled frayji
?>
