<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userform";

// database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user inputs
function sanitizeInput($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the event details from the POST data
    $event_id = sanitizeInput($_POST['event_id']);
    $eventname = sanitizeInput($_POST['eventname']);
    $event_date = sanitizeInput($_POST['event_date']);
    $num_tickets = sanitizeInput($_POST['num_tickets']);
    $ticket_price = sanitizeInput($_POST['ticket_price']);

    // Create an SQL query to update the event in the database
    $update_sql = "UPDATE events SET eventname='$eventname', Date='$event_date', numberoftickets='$num_tickets', ticketprice='$ticket_price' WHERE eventid='$event_id'";

    if ($conn->query($update_sql) === TRUE) {
        echo "success";
    } else {
        echo "Error updating event: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>