<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

if (!isset($_GET['id'])) {
    die("❌ Invalid employee ID");
}
$id = $_GET['id'];

// Get employee info
$stmt = $conn->prepare("SELECT * FROM employee WHERE employee_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$emp = $result->fetch_assoc();

if (!$emp) {
    die("❌ Employee not found");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Employee</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    input { padding: 6px; margin-bottom: 10px; width: 300px; }
    button { padding: 6px 12px; }
  </style>
</head>
<body>
<h2>✏️ Edit Employee</h2>

<form method="POST" action="update_employee.php">
  <input type="hidden" name="employee_id" value="<?= $emp['employee_id'] ?>">
  <input type="text" name="name" value="<?= $emp['name'] ?>" required><br>
  <input type="text" name="designation" value="<?= $emp['designation'] ?>" required><br>
  <input type="text" name="nid" value="<?= $emp['nid'] ?>" required><br>
  <input type="text" name="phone" value="<?= $emp['phone'] ?>" required><br>
  <button type="submit">💾 Update</button>
</form>

<br><a href="manage_employees.php">⬅️ Back</a>
</body>
</html>
