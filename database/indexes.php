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

// Function to check if an index already exists
function indexExists($conn, $table, $indexName) {
    $result = $conn->query("SHOW INDEX FROM $table WHERE Key_name = '$indexName'");
    return ($result && $result->num_rows > 0);
}

// Create index on sname if it doesn't exist
$snameIndexName = 'idx_sname';
if (!indexExists($conn, 'student', $snameIndexName)) {
    $conn->query("CREATE INDEX $snameIndexName ON student(sname)");
    echo "Index on sname created successfully.\n";
} else {
    echo "Index on sname already exists.\n";
}

// Create index on tname if it doesn't exist
$tnameIndexName = 'idx_tname';
if (!indexExists($conn, 'teacher', $tnameIndexName)) {
    $conn->query("CREATE INDEX $tnameIndexName ON teacher(tname)");
    echo "Index on tname created successfully.\n";
} else {
    echo "Index on tname already exists.\n";
}

// Create index on cname if it doesn't exist
$cnameIndexName = 'idx_cname';
if (!indexExists($conn, 'course', $cnameIndexName)) {
    $conn->query("CREATE INDEX $cnameIndexName ON course(cname)");
    echo "Index on cname created successfully.\n";
} else {
    echo "Index on cname already exists.\n";
}

// Close connection
$conn->close();
?>
