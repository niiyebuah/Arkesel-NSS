<?php
session_start();
require_once 'dbconnection.php';

if ($_SESSION["user_id"]) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $event_id = $_POST["event_id"];
        
        try {
            $stmt = $db->prepare("DELETE FROM events WHERE id = ?");
            $stmt->execute([$event_id]);
            header("Location: dashboard.php");
            exit;
        } catch (PDOException $e) {
            die("Event deletion failed: " . $e->getMessage());
        }
    } else {
        $event_id = $_GET["id"];
    }
} else {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Event</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Delete Event</h2>
        <p>Are you sure you want to delete this event?</p>
        <form method="post">
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
            <button type="submit" class="btn btn-danger">Yes, Delete Event</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <!-- Add Bootstrap JavaScript (optional, only if needed) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>