<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['email'])) {
    // Redirect to login if the user is not authenticated
    header('Location: login.php');
    exit();
}

include_once "sidebar.php";

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userform";


//database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Checking the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user inputs
function sanitizeInput($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Function to display success message in JavaScript alert
function displaySuccessMessage($message)
{
    echo '<script type="text/javascript">';
    echo 'alert("' . $message . '");';
    echo 'window.location.href = "index.php";'; // Redirect to the main/index page
    echo '</script>';
}

// Function to display error message in JavaScript alert
function displayErrorMessage($message)
{
    echo '<script type="text/javascript">';
    echo 'alert("' . $message . '");';
    echo '</script>';
}

// Handle form submission for editing an event
if (isset($_POST['edit_event'])) {
    $event_id = sanitizeInput($_POST['event_id']);
    $eventname = sanitizeInput($_POST['edit_eventname']);
    $event_date = sanitizeInput($_POST['edit_event_date']);
    $num_tickets = sanitizeInput($_POST['edit_num_tickets']);
    $ticket_price = sanitizeInput($_POST['edit_ticket_price']);

    $update_sql = "UPDATE events SET eventname='$eventname', Date='$event_date', numberoftickets='$num_tickets', ticketprice='$ticket_price' WHERE eventid='$event_id'";

    if ($conn->query($update_sql) === TRUE) {
        displaySuccessMessage("Event updated successfully.");
    } else {
        displayErrorMessage("Error updating event: " . $conn->error);
    }
}

// Handle form submission for deleting an event
if (isset($_POST['delete_event'])) {
    $event_id = sanitizeInput($_POST['event_id']);
    $eventname = sanitizeInput($_POST['delete_eventname']);

    // Displays a confirmation dialog before deleting
    echo '<script type="text/javascript">';
    echo 'var confirmDelete = confirm("Are you sure you want to delete the event: ' . $eventname . ' ?");';
    echo 'if (confirmDelete) {';
    echo '  window.location.href = "delete_event.php?event_id=' . $event_id . '";';
    echo '} else {';
    echo '  window.location.href = "index.php";';
    echo '}';
    echo '</script>';
    exit;
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
    <!-- Bootstrap CSS -->
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
                        <th cla>Event Name</th>
                        <th>Date</th>
                        <th>Number of Tickets</th>
                        <th>Ticket Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $event_id = $row['eventid'];
                            $eventname = $row['eventname'];
                            $event_date = $row['Date'];
                            $num_tickets = $row['numberoftickets'];
                            $ticket_price = $row['ticketprice'];
                            
                            echo '<tr id="event_row_' . $event_id . '">';
                            echo '<td><span id="event_name_' . $event_id . '">' . $eventname . '</span><input type="text" id="edit_event_name_' . $event_id . '" class="form-control" value="' . $eventname . '" style="display: none;"></td>';
                            echo '<td><span id="event_date_' . $event_id . '">' . $event_date . '</span><input type="text" id="edit_event_date_' . $event_id . '" class="form-control" value="' . $event_date . '" style="display: none;"></td>';
                            echo '<td><span id="num_tickets_' . $event_id . '">' . $num_tickets . '</span><input type="text" id="edit_num_tickets_' . $event_id . '" class="form-control" value="' . $num_tickets . '" style="display: none;"></td>';
                            echo '<td><span id="ticket_price_' . $event_id . '">$' . $ticket_price . '</span><input type="text" id="edit_ticket_price_' . $event_id . '" class="form-control" value="' . $ticket_price . '" style="display: none;"></td>';
                            echo '<td>
                                    <div class="btn-group" role="group" aria-label="Event Actions">
                                        <button class="btn btn-success" id="edit_buttons_' . $event_id . '" onclick="editEvent(\'' . $event_id . '\')">Edit</button>
                                        <button class="btn btn-danger" onclick="deleteEvent(\'' . $event_id . '\', \'' . $eventname . '\')">Delete</button>
                                        <button class="btn btn-primary" id="save_button_' . $event_id . '" style="display: none;" onclick="saveEvent(\'' . $event_id . '\')">Save</button>
                                        <button class="btn btn-secondary" id="cancel_button_' . $event_id . '" style="display: none;" onclick="cancelEdit(\'' . $event_id . '\')">Cancel</button>
                                    </div>
                                </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">No events found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <!-- button to redirect to ticket.php -->
        <a href="ticket.php" class="btn btn-primary">Create</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function editEvent(event_id) {
            // Hide the spans and show the input fields for editing
            $("#event_name_" + event_id).hide();
            $("#event_date_" + event_id).hide();
            $("#num_tickets_" + event_id).hide();
            $("#ticket_price_" + event_id).hide();
            $("#edit_event_name_" + event_id).show();
            $("#edit_event_date_" + event_id).show();
            $("#edit_num_tickets_" + event_id).show();
            $("#edit_ticket_price_" + event_id).show();

            // Hide the Edit button and show the Save and Cancel buttons
            $("#edit_buttons_" + event_id).hide();
            $("#save_button_" + event_id).show();
            $("#cancel_button_" + event_id).show();
        }

        function saveEvent(event_id) {
            // Get the edited values from the input fields
            var eventname = $("#edit_event_name_" + event_id).val();
            var event_date = $("#edit_event_date_" + event_id).val();
            var num_tickets = $("#edit_num_tickets_" + event_id).val();
            var ticket_price = $("#edit_ticket_price_" + event_id).val();

            // logic to save the edited values
            $.ajax({
                type: "POST",
                url: "save_event.php", 
                data: {
                    event_id: event_id,
                    eventname: eventname,
                    event_date: event_date,
                    num_tickets: num_tickets,
                    ticket_price: ticket_price
                },
                success: function (response) {
                    if (response === "success") {
                        $("#event_name_" + event_id).text(eventname);
                        $("#event_date_" + event_id).text(event_date);
                        $("#num_tickets_" + event_id).text(num_tickets);
                        $("#ticket_price_" + event_id).text("$" + ticket_price);
                        $("#edit_event_name_" + event_id).hide();
                        $("#edit_event_date_" + event_id).hide();
                        $("#edit_num_tickets_" + event_id).hide();
                        $("#edit_ticket_price_" + event_id).hide();
                        $("#event_name_" + event_id).show();
                        $("#event_date_" + event_id).show();
                        $("#num_tickets_" + event_id).show();
                        $("#ticket_price_" + event_id).show();
                        $("#edit_buttons_" + event_id).show();
                        $("#save_button_" + event_id).hide();
                        $("#cancel_button_" + event_id).hide();
                        
                        // Show success message
                        displaySuccessMessage("Event updated successfully.");
                    } else {
                        alert("Error updating event: " + response);
                    }
                }
            });
        }

        function cancelEdit(event_id) {
            $("#edit_event_name_" + event_id).hide();
            $("#edit_event_date_" + event_id).hide();
            $("#edit_num_tickets_" + event_id).hide();
            $("#edit_ticket_price_" + event_id).hide();
            $("#event_name_" + event_id).show();
            $("#event_date_" + event_id).show();
            $("#num_tickets_" + event_id).show();
            $("#ticket_price_" + event_id).show();
            $("#edit_buttons_" + event_id).show();
            $("#save_button_" + event_id).hide();
            $("#cancel_button_" + event_id).hide();
        }

        function deleteEvent(event_id, event_name) {
            var confirmDelete = confirm("Are you sure you want to delete the event: " + event_name + " ?");
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "delete_event.php", 
                    data: { event_id: event_id },
                    success: function (data) {
                        if (data === "success") {
                            $("#event_row_" + event_id).remove();
                        } else {
                            alert("Error deleting event: " + data);
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>