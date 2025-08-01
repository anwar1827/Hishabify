<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "Hishabify_DB"; // তোমার DB নাম যদি আলাদা হয়, সেটাও ঠিক করো

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ DB Connection failed: " . $conn->connect_error);
}
?>
