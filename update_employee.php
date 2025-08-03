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

    $stmt = $conn->prepare("UPDATE employee SET name=?, designation=?, nid=?, phone=? WHERE employee_id=?");
    $stmt->bind_param("ssssi", $name, $designation, $nid, $phone, $id);

    if ($stmt->execute()) {
        header("Location: manage_employees.php?msg=updated");
    } else {
        echo "❌ Error updating employee.";
    }
}
?>
