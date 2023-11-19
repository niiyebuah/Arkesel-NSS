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

// Retrieve events data from the database
$sql = "SELECT eventname as title, Date as start FROM events"; 
$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($events);
?>