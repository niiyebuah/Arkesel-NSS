<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['email'])) {
    // Redirect to login if the user is not authenticated
    header('Location: login.php');
    exit();
}

include_once "sidebar.php";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userform"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve events data from the database
$sql = "SELECT * FROM events";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Events - Mini Ticketing System</title>
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
   
</head>
<body>
    <div class="content">
        <h1 class="login-card-description">All Events</h1>
        <div class="form-group">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Number of Tickets</th>
                        <th>Ticket Price</th>
                        <th>Booking</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // Fetch and display events data
                        while ($row = $result->fetch_assoc()) {
                            $eventname = $row['eventname'];
                            $event_date = $row['Date'];
                            $num_tickets = $row['numberoftickets'];
                            $ticket_price = $row['ticketprice'];
                            $event_id = $row['eventid'];

                            // Display the data in the table with a "Book" button
                            echo '<tr>';
                            echo '<td>' . $eventname . '</td>';
                            echo '<td>' . $event_date . '</td>';
                            echo '<td id="num_tickets_' . $event_id . '">' . $num_tickets . '</td>';
                            echo '<td>$' . $ticket_price . '</td>';
                            echo '<td><button class="btn btn-primary" onclick="bookEvent(\'' . $eventname . '\', \'' . $event_date . '\', ' . $event_id . ', ' . $num_tickets . ')">Book</button></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">No events found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function bookEvent(eventName, eventDate, eventId, availableTickets) {
            if (availableTickets <= 0) {
                //pop-up message
                alert("Sorry, " + eventName + " tickets are sold out.");
                return;
            }

            var name = prompt("Please enter your name:");
            if (name === null || name === "") {
                return; // User canceled the prompt or didn't enter a name
            }

            var tickets = prompt("How many tickets would you like to book?");
            if (tickets === null || isNaN(tickets) || tickets <= 0) {
                alert("Invalid number of tickets. Please enter a valid number.");
                return;
            }

            if (tickets > availableTickets) {
                alert("Sorry, there are only " + availableTickets + " tickets available for " + eventName);
                return;
            }

            var message = "Hello, " + name + "! You have successfully booked " + tickets + " ticket(s) to the event '" + eventName + "' scheduled for " + eventDate + ".";
            alert(message);

            // AJAX request to update the ticket count in the database
            $.ajax({
                type: "POST",
                url: "update_tickets.php", 
                data: {
                    event_id: eventId,
                    num_tickets: tickets
                },
                success: function (response) {
                    if (response === "success") {
                        // Update the displayed ticket count
                        var updatedTickets = parseInt($("#num_tickets_" + eventId).text()) - parseInt(tickets);
                        $("#num_tickets_" + eventId).text(updatedTickets);

                        // Refresh the page after a short delay
                        setTimeout(function () {
                            location.reload();
                        }, 2000); // 2000 milliseconds (2 seconds).
                    } else {
                        alert("Error updating ticket count: " + response);
                    }
                }
            });
        }
    </script>
</body>
</html>

<?php

// Close the database connection
$conn->close();
?>
