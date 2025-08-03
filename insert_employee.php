<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $designation = trim($_POST['designation']);
    $nid = trim($_POST['nid']);
    $phone = trim($_POST['phone']);
    $manager_id = $_SESSION['user_id'];
    $join_date = date("Y-m-d"); // current date
    $total_sales = 0;


    $stmt = $conn->prepare("SELECT branch_id FROM manager WHERE manager_id = ?");
    $stmt->bind_param("i", $manager_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $branch_id = $result->fetch_assoc()['branch_id'];


    $insert = $conn->prepare("INSERT INTO employee (name, designation, nid, phone, join_date, total_sales, branch_id, manager_id)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("sssssiii", $name, $designation, $nid, $phone, $join_date, $total_sales, $branch_id, $manager_id);

    if ($insert->execute()) {
        header("Location: manage_employees.php?msg=success");
        exit;
    } else {
        echo "❌ Error inserting employee.";
    }
} else {
    echo "❌ Invalid access.";
}
?>
