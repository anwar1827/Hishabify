<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$product_id = $_POST['product_id'];
$add_stock = $_POST['add_stock'];

// Update stock
$stmt = $conn->prepare("UPDATE product SET stock = stock + ? WHERE product_id = ?");
$stmt->bind_param("ii", $add_stock, $product_id);
$stmt->execute();

header("Location: manage_products.php");
