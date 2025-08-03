<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$manager_id = $_SESSION['user_id'];
$customer_name = $_POST['customer_name'];
$customer_contact = $_POST['customer_contact'];
$product_id = $_POST['product_id'];
$employee_id = $_POST['employee_id'];

// Insert Sale
$stmt = $conn->prepare("CALL insert_sale(?, ?, ?, ?, ?)");
$stmt->bind_param("iiiss", $employee_id, $product_id, $manager_id, $customer_name, $customer_contact);
$stmt->execute();

echo "✅ Sale recorded successfully.";
echo "<br><a href='record_sale.php'>🔁 Sell Again</a>";

