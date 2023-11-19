<?php
session_start();

if (!isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    header('Location: login.php');
    exit();
}
include_once "sidebar.php";

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userform";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
} else {
    header('Location: login.php');
    exit();
}

$successMessage = "";

// form submission
if (isset($_POST['submit'])) {
    $eventName = $_POST['eventname'];
    $eventLocation = $_POST['location'];
    $eventDate = $_POST['Date'];
    $numberOfTickets = $_POST['num_tickets'];
    $ticketPrice = $_POST['ticket_price'];

    $eventInsertSql = "INSERT INTO events (eventname, location, Date, numberoftickets, ticketprice, id) VALUES ('$eventName', '$eventLocation', '$eventDate', '$numberOfTickets', '$ticketPrice', '$userId')";
    
    if ($conn->query($eventInsertSql) === TRUE) {
        $successMessage = "Event added successfully: $eventName"; 
        echo "Error adding event: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Event and Tickets - Mini Ticketing System</title>
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
<main class="d-flex justify-content-center align-items-center min-vh-100 py-3 py-md-0" style="padding-left: 225px;">
    <div class="container">
        <div class="card login-card">
            <div class="row no-gutters">
                <div class="col-md-7">
                    <img src="../images/ticket.jpg" alt="login" class="login-card-img">
                </div>
                <div class="col-md-5">
                    <div class="card-body">
                        <div class="brand-wrapper">
                            <h6>Mini Ticketing System</h6>
                        </div>
                        <p class="login-card-description">Add Event</p>
                        <form method="post">
                            <div class="form-group">
                                <label for="eventname">Event Name</label>
                                <input class="form-control" type="text" name="eventname" required>
                            </div>
                            <div class="form-group">
                                <label for="location">Event Location</label>
                                <input class="form-control" type="text" name="location" required>
                            </div>
                            <!-- Number of Tickets -->
                            <div class="form-group">
                                <label for="num_tickets">Number of Tickets</label>
                                <input class="form-control" type="number" name="num_tickets" required>
                            </div>
                            <!-- Date -->
                            <div class="form-group">
                                <label for="Date">Event Date</label>
                                <input class="form-control" type="date" name="Date" required>
                            </div>
                            <!-- Ticket Price -->
                            <div class="form-group">
                                <label for="ticket_price">Ticket Price</label>
                                <input class="form-control" type="text" name="ticket_price" required>
                            </div>
                            <!-- Ticket IDs -->
                            <!-- <div class="form-group">
                                <label for="ticket_ids">Ticket IDs (comma-separated)</label>
                                <input class="form-control" type="text" name="ticket_ids" required>
                            </div> -->
                            <input class="btn btn-block login-btn mb-4" type="submit" name="submit" value="Add Event">
                        </form>
                        <?php
                        if (!empty($successMessage)) {
                            echo '<script>alert("' . $successMessage . '");</script>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>