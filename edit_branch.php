<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
require_once("db.php");

$branch_id = intval($_GET['id'] ?? 0);

// Fetch current branch
$branch = $conn->query("SELECT * FROM branch WHERE branch_id = $branch_id")->fetch_assoc();

// Update handle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['branch_name'];
    $location = $_POST['location'];
    $contact = $_POST['contact_number'];
    $open = $_POST['open_time'];
    $close = $_POST['close_time'];

    $stmt = $conn->prepare("CALL UpdateBranch(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $branch_id, $name, $location, $contact, $open, $close);
    $stmt->execute();
    $stmt->close();

    header("Location: branch_list.php?updated=1");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head><title>✏️ Edit Branch</title></head>
<body>
<h2>✏️ Edit Branch</h2>

<form method="POST">
  <label>Branch Name:</label><br>
  <input type="text" name="branch_name" value="<?= htmlspecialchars($branch['branch_name']) ?>" required><br><br>

  <label>Location:</label><br>
  <input type="text" name="location" value="<?= htmlspecialchars($branch['location']) ?>" required><br><br>

  <label>Contact Number:</label><br>
  <input type="text" name="contact_number" value="<?= htmlspecialchars($branch['contact_number']) ?>" required><br><br>

  <label>Open Time:</label><br>
  <input type="time" name="open_time" value="<?= $branch['open_time'] ?>" required><br><br>

  <label>Close Time:</label><br>
  <input type="time" name="close_time" value="<?= $branch['close_time'] ?>" required><br><br>

  <input type="submit" value="✅ Update Branch">
</form>

<br><a href="branch_list.php">⬅️ Back to Branch List</a>
</body>
</html>
