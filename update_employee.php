<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['employee_id'];
    $name = trim($_POST['name']);
    $designation = trim($_POST['designation']);
    $nid = trim($_POST['nid']);
    $phone = trim($_POST['phone']);

    $stmt = $conn->prepare("CALL UpdateEmployee(?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id, $name, $designation, $nid, $phone);
    

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: manage_employees.php?msg=updated");
    } else {
        echo "❌ Error updating employee.";
    }
}
?>
