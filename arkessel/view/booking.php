<?php

// Start session to access user information
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or display an error message
    header("Location: login.php");
    exit();
}

// Get the user's ID from the session
$user_id = $_SESSION['user_id'];

// Query to retrieve booked tickets for the user
$sql = "SELECT b.booking_id, e.eventname, e.Date AS event_date, b.num_tickets, b.booking_date
        FROM bookings b
        INNER JOIN events e ON b.event_id = e.eventid
        WHERE b.user_id = ?";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing the query: " . $conn->error);
}

// Bind the user ID as a parameter
$stmt->bind_param("i", $user_id);

// Execute the query
if ($stmt->execute()) {
    // Get the result
    $result = $stmt->get_result();

    // Check if there are booked tickets
    if ($result->num_rows > 0) {
        // Display booked tickets in a table
        echo '<table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Number of Tickets</th>
                        <th>Booking Date</th>
                    </tr>
                </thead>
                <tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['booking_id'] . '</td>
                    <td>' . $row['eventname'] . '</td>
                    <td>' . $row['event_date'] . '</td>
                    <td>' . $row['num_tickets'] . '</td>
                    <td>' . $row['booking_date'] . '</td>
                  </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo 'No booked tickets found.';
    }
} else {
    echo 'Error executing the query: ' . $stmt->error;
}

$stmt->close();
$conn->close();
?>