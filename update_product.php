<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$product_id = $_POST['product_id'];
$name = $_POST['name'];
$brand = $_POST['brand'];
$model = $_POST['model'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$category_id = $_POST['category_id'];
$warranty = $_POST['warranty_months'];
$description = $_POST['description'];

$stmt = $conn->prepare("CALL UpdateProduct(?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiiiisi", $product_id, $name, $brand, $model, $price, $stock, $category_id, $warranty, $description);
$stmt->execute();
$stmt->close();

header("Location: manage_products.php");

?>
