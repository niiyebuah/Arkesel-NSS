<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userform"; 

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user inputs
function sanitizeInput($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Handle event deletion
if (isset($_POST['event_id'])) {
    $event_id = sanitizeInput($_POST['event_id']);

    // database deletion
    $delete_sql = "DELETE FROM events WHERE eventid='$event_id'";

    if ($conn->query($delete_sql) === TRUE) {
        echo "success";
    } else {
        echo "Error deleting event: " . $conn->error;
    }
}

$conn->close();
?>