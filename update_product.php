<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$id = $_POST['id'];
$name = $_POST['name'];
$brand = $_POST['brand'];
$model = $_POST['model'];
$price = $_POST['price'];
$stock = $_POST['stock'];

$stmt = $conn->prepare("UPDATE product SET name=?, brand=?, model=?, price=?, stock=? WHERE product_id=?");
$stmt->bind_param("sssiii", $name, $brand, $model, $price, $stock, $id);
$stmt->execute();

header("Location: manage_products.php");
