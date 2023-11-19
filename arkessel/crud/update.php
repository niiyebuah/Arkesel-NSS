<?php
session_start();
require_once 'dbconnection.php';

if ($_SESSION["user_id"]) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $event_id = $_POST["event_id"];
        $name = $_POST["name"];
        $date = $_POST["date"];
        
        try {
            $stmt = $db->prepare("UPDATE events SET name = ?, date = ? WHERE id = ?");
            $stmt->execute([$name, $date, $event_id]);
            header("Location: dashboard.php");
            exit;
        } catch (PDOException $e) {
            die("Event update failed: " . $e->getMessage());
        }
    } else {
        $event_id = $_GET["id"];

        try {
            $stmt = $db->prepare("SELECT id, name, date FROM events WHERE id = ?");
            $stmt->execute([$event_id]);
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database query failed: " . $e->getMessage());
        }
    }
} else {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Event</title>
</head>
<body>
    <h2>Update Event</h2>
    <form method="post">
        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
        <label for="name">Event Name:</label>
        <input type="text" name="name" value="<?php echo $event["name"]; ?>" required><br>
        <label for="date">Event Date:</label>
        <input type="date" name="date" value="<?php echo $event["date"]; ?>" required><br>
        <input type="submit" value="Update Event">
    </form>
</body>
</html>