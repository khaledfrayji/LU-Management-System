<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stdmanagment";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the triggers already exist
$studentTriggerName = 'after_student_insert';
$blackListTriggerName = 'after_black_list_insert';
$appealsTriggerName = 'after_markregister_delete1';
$reportsTriggerName = 'after_markregister_delete2';
$markRegisterTriggerName = 'after_markregister_delete3';


$checkStudentTriggerSQL = "SELECT trigger_name FROM information_schema.triggers WHERE trigger_schema = '$dbname' AND trigger_name = '$studentTriggerName'";
$checkBlackListTriggerSQL = "SELECT trigger_name FROM information_schema.triggers WHERE trigger_schema = '$dbname' AND trigger_name = '$blackListTriggerName'";
$checkAppealsTriggerSQL = "SELECT trigger_name FROM information_schema.triggers WHERE trigger_schema = '$dbname' AND trigger_name = '$appealsTriggerName'";
$checkReportsTriggerSQL = "SELECT trigger_name FROM information_schema.triggers WHERE trigger_schema = '$dbname' AND trigger_name = '$reportsTriggerName'";
$checkMarkRegisterTriggerSQL = "SELECT trigger_name FROM information_schema.triggers WHERE trigger_schema = '$dbname' AND trigger_name = '$markRegisterTriggerName'";
$checkStudentResult = $conn->query($checkStudentTriggerSQL);
$checkBlackListResult = $conn->query($checkBlackListTriggerSQL);
$checkAppealsResult = $conn->query($checkAppealsTriggerSQL);
$checkReportsResult = $conn->query($checkReportsTriggerSQL);
$checkMarkRegisterResult = $conn->query($checkMarkRegisterTriggerSQL);

if ($checkStudentResult->num_rows > 0) {
    echo "Student trigger already exists";
} else {
    // Create a trigger after insert on student table
    $studentTriggerSQL = "
        CREATE TRIGGER after_student_insert
        AFTER INSERT ON student
        FOR EACH ROW
        BEGIN
            -- Insert logic for studentcourses table based on student's domain and year
            INSERT INTO studentcourses (sid, cid, domaine, year, semester)
            SELECT NEW.sid, c.cid, c.domaine, NEW.year, 1
            FROM course c
            WHERE c.domaine = NEW.domain
            AND c.year = NEW.year;
        END;
    ";

    // Execute the SQL to create the trigger
    if ($conn->multi_query($studentTriggerSQL)) {
        echo "Student trigger created successfully";
    } else {
        echo "Error creating student trigger: " . $conn->error;
    }
}

if ($checkBlackListResult->num_rows > 0) {
    echo "Black List trigger already exists";
} else {
    // Create a trigger after insert on black_list table
    $blackListTriggerSQL = "
        CREATE TRIGGER after_black_list_insert
        AFTER INSERT ON black_list
        FOR EACH ROW
        BEGIN

            -- Delete the student from markregister where sid matches
            DELETE FROM markregister WHERE sid = NEW.student_id;
        END;
    ";

    // Execute the SQL to create the trigger
    if ($conn->multi_query($blackListTriggerSQL)) {
        echo "Black List trigger created successfully";
    } else {
        echo "Error creating black list trigger: " . $conn->error;
    }
}

if ($checkAppealsResult->num_rows > 0) {
    echo "Appeals trigger already exists";
} else {
    // Create a trigger after delete on studentcourses table
    $appealsTriggerSQL = "
        CREATE TRIGGER after_markregister_delete1
        AFTER DELETE ON markregister
        FOR EACH ROW
        BEGIN
            -- Delete the student from appeals where student_id matches
            DELETE FROM appeals WHERE student_id = OLD.sid;
        END;
    ";

    // Execute the SQL to create the trigger
    if ($conn->multi_query($appealsTriggerSQL)) {
        echo "Appeals trigger created successfully";
    } else {
        echo "Error creating appeals trigger: " . $conn->error;
    }
}

if ($checkReportsResult->num_rows > 0) {
    echo "Reports trigger already exists";
} else {
    // Create a trigger after delete on appeals table
    $reportsTriggerSQL = "
        CREATE TRIGGER after_markregister_delete2
        AFTER DELETE ON markregister
        FOR EACH ROW
        BEGIN
            -- Delete the student from reports where student_id matches
            DELETE FROM reports WHERE student_id = OLD.sid;
        END;
    ";

    // Execute the SQL to create the trigger
    if ($conn->multi_query($reportsTriggerSQL)) {
        echo "Reports trigger created successfully";
    } else {
        echo "Error creating reports trigger: " . $conn->error;
    }
}

if ($checkMarkRegisterResult->num_rows > 0) {
    echo "Mark Register trigger already exists";
} else {
    // Create a trigger after delete on reports table
    $markRegisterTriggerSQL = "
        CREATE TRIGGER after_markregister_delete3
        AFTER DELETE ON markregister
        FOR EACH ROW
        BEGIN
            -- Delete the student from studentcourses where sid matches
            DELETE FROM studentcourses WHERE sid = OLD.sid;
        END;
    ";

    // Execute the SQL to create the trigger
    if ($conn->multi_query($markRegisterTriggerSQL)) {
        echo "Mark Register trigger created successfully";
    } else {
        echo "Error creating mark register trigger: " . $conn->error;
    }
}


$conn->close();
//written by khaled frayji
