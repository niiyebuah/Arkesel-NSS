<?php
include_once "sidebar.php";

session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['email'])) {
    // Redirect to login if the user is not authenticated
    header('Location: login.php');
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userform"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the user's name from the database
$userId = $_SESSION['id'];
$sql = "SELECT name FROM usertable WHERE id = $userId"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userName = $row['name'];
} else {
    // Handle the case where the user's name is not found
    $userName = "Unknown User";
}

// Set the 'name' key in the $_SESSION array
$_SESSION['name'] = $userName;

// Retrieve events data from the database
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="jumbotron">
            <div class="row">
                <!-- <div class="col-md-3">
                    <img src="<?php echo $userProfilePicture; ?>" alt="Profile Picture" class="img-fluid rounded-circle">
                </div> -->
                <div class="col-md-9">
                    <h1 class="display-4">Welcome, <?php echo $_SESSION['name']; ?>!</h1>
                    <p class="lead">Email: <?php echo $_SESSION['email']; ?></p>
                    <hr class="my-4">
                    <p>This is your event dashboard.</p>
                    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
                </div>
            </div>
        </div>
        <div id="eventCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $active = true; //mark first item as active
                foreach ($events as $event) {
                    $eventname = $event['eventname'];
                    $event_date = $event['Date'];
                    $num_tickets = $event['numberoftickets'];
                    $ticket_price = $event['ticketprice'];

                    // Output each event as a carousel item
                    echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $eventname . '</h5>';
                    echo '<p class="card-text">Date: ' . $event_date . '</p>';
                    echo '<p class="card-text">Number of Tickets: ' . $num_tickets . '</p>';
                    echo '<p class="card-text">Ticket Price: $' . $ticket_price . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    $active = false; // Set to false for subsequent items
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#eventCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#eventCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <!--pagination controls -->
        <div class="text-center mt-3">
            <button class="btn btn-primary" id="prevBtn">Previous</button>
            <button class="btn btn-primary" id="nextBtn">Next</button>
        </div>
    </div>

    <script>
        // Initialize the carousel
        $('#eventCarousel').carousel();

        //changes slide every 6 seconds
        setInterval(function () {
            $('#eventCarousel').carousel('next');
        }, 6000);

        // Handle previous and next button clicks
        $('#prevBtn').click(function () {
            $('#eventCarousel').carousel('prev');
        });

        $('#nextBtn').click(function () {
            $('#eventCarousel').carousel('next');
        });
    </script>
</body>
</html>