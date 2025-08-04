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

$stmt = $conn->prepare("UPDATE product SET name=?, brand=?, model=?, price=?, stock=?, category_id=?, warranty_months=?, description=? WHERE product_id=?");
$stmt->bind_param("sssiiiisi", $name, $brand, $model, $price, $stock, $category_id, $warranty, $description, $product_id);
$stmt->execute();

header("Location: manage_products.php");
?>
