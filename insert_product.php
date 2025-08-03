<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$manager_id = $_SESSION['user_id'];

// Manager এর branch বের করি
$branch_result = $conn->query("SELECT branch_id FROM manager WHERE manager_id = $manager_id");
$branch_id = $branch_result->fetch_assoc()['branch_id'];

$name = $_POST['name'];
$brand = $_POST['brand'];
$model = $_POST['model'];
$price = $_POST['price'];
$stock = $_POST['stock'];

// Insert query
$stmt = $conn->prepare("INSERT INTO product (name, brand, model, price, stock, branch_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiii", $name, $brand, $model, $price, $stock, $branch_id);
$stmt->execute();

header("Location: manage_products.php");
