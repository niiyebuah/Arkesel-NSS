<?php

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userform"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST["event_id"];
    $num_tickets = $_POST["num_tickets"];

    // Validate the input 
    if (!is_numeric($event_id) || !is_numeric($num_tickets) || $num_tickets <= 0) {
        echo "Invalid input";
        exit;
    }

    // Check if there are enough tickets available for booking
    $sql = "SELECT numberoftickets FROM events WHERE eventid = $event_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $current_tickets = $row["numberoftickets"];

        if ($current_tickets >= $num_tickets) {
            // Update the ticket count
            $new_tickets = $current_tickets - $num_tickets;
            $update_sql = "UPDATE events SET numberoftickets = $new_tickets WHERE eventid = $event_id";

            if ($conn->query($update_sql) === TRUE) {
                echo "success";
            } else {
                echo "Error updating ticket count: " . $conn->error;
            }
        } else {
            echo "Not enough tickets available for booking.";
        }
    } else {
        echo "Event not found.";
    }
} else {
    echo "Invalid request";
}

$conn->close();
?>