<?php
require_once("db.php"); // Database connection

// Collect form data
$emp_id = $_POST['emp_id'];
$prod_id = $_POST['prod_id'];
$mgr_id = $_POST['mgr_id'];
$br_id = $_POST['br_id'];
$cust_name = $_POST['cust_name'];
$cust_contact = $_POST['cust_contact'];
$qty = $_POST['qty'];
$discount = $_POST['discount'];
$method = $_POST['method'];

// Procedure call
$stmt = $conn->prepare("CALL insert_sale(?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiiissids", $emp_id, $prod_id, $mgr_id, $br_id, $cust_name, $cust_contact, $qty, $discount, $method);

if ($stmt->execute()) {
    echo "✅ Sale successfully inserted.";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
