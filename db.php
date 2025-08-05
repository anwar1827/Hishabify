<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "hishabify_db";

// Connection
$conn = new mysqli($host, $user, $password, $database);

// Check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
