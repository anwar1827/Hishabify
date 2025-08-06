<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
require_once("db.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['branch_name'];
    $location = $_POST['location'];
    $contact = $_POST['contact_number'];
    $open = $_POST['open_time'];
    $close = $_POST['close_time'];
    $owner_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO branch (branch_name, location, contact_number, open_time, close_time, owner_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $name, $location, $contact, $open, $close, $owner_id);
    $stmt->execute();

    header("Location: branch_list.php?added=1");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>➕ Add Branch</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h2>➕ Add New Branch</h2>
  <form method="POST">
    <label>Branch Name:</label><br>
    <input type="text" name="branch_name" required><br><br>

    <label>Location:</label><br>
    <input type="text" name="location" required><br><br>

    <label>Contact Number:</label><br>
    <input type="text" name="contact_number" required><br><br>

    <label>Open Time:</label><br>
    <input type="time" name="open_time" required><br><br>

    <label>Close Time:</label><br>
    <input type="time" name="close_time" required><br><br>

    <input type="submit" value="➕ Add Branch">
  </form>
  <br><a href="owner_dashboard.php">⬅️ Back to Dashboard</a>
  <script src="assets/js/script.js"></script>
</body>
</html>
