<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM product WHERE product_id = $id");
$product = $result->fetch_assoc();
?>

<h2>✏️ Edit Product</h2>

<form method="POST" action="update_product.php">
  <input type="hidden" name="id" value="<?= $product['product_id'] ?>">

  <label>Name: <input type="text" name="name" value="<?= $product['name'] ?>"></label><br>
  <label>Brand: <input type="text" name="brand" value="<?= $product['brand'] ?>"></label><br>
  <label>Model: <input type="text" name="model" value="<?= $product['model'] ?>"></label><br>
  <label>Price: <input type="number" name="price" value="<?= $product['price'] ?>"></label><br>
  <label>Stock: <input type="number" name="stock" value="<?= $product['stock'] ?>"></label><br>

  <button type="submit">✅ Update</button>
</form>
