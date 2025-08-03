<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$id = $_GET['id'];
$conn->query("DELETE FROM product WHERE product_id = $id");

header("Location: manage_products.php");
