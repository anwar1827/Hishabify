<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

// ✅ Get manager's branch ID
$manager_id = $_SESSION['user_id'];
$branch_result = $conn->query("SELECT branch_id FROM manager WHERE manager_id = $manager_id");
$branch_id = $branch_result->fetch_assoc()['branch_id'];

// ✅ Get POST data
$name = $_POST['name'];
$brand = $_POST['brand'];
$model = $_POST['model'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$category_id = $_POST['category_id'];
$warranty = $_POST['warranty_months'];
$description = $_POST['description'];

// ✅ Insert Query
$stmt = $conn->prepare("INSERT INTO product (name, brand, model, price, stock, branch_id, category_id, warranty_months, description) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiiiiss", $name, $brand, $model, $price, $stock, $branch_id, $category_id, $warranty, $description);
$stmt->execute();

header("Location: manage_products.php");
?>
