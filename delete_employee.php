<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

if (!isset($_GET['id'])) {
    die("❌ Invalid request");
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM employee WHERE employee_id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    header("Location: manage_employees.php?msg=deleted");
} else {
    echo "❌ Could not delete employee.";
}
?>
