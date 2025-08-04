<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$id = $_GET['id'];

// ✅ Get product info
$result = $conn->query("SELECT * FROM product WHERE product_id = $id");
$product = $result->fetch_assoc();

// ✅ Get all categories (for dropdown)
$categories = $conn->query("SELECT * FROM category");
?>

<h2>✏️ Edit Product</h2>

<form method="POST" action="update_product.php">
  <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

  <label>Name: <input type="text" name="name" value="<?= $product['name'] ?>" required></label><br>
  <label>Brand: <input type="text" name="brand" value="<?= $product['brand'] ?>" required></label><br>
  <label>Model: <input type="text" name="model" value="<?= $product['model'] ?>" required></label><br>
  <label>Price: <input type="number" name="price" value="<?= $product['price'] ?>" required></label><br>
  <label>Stock: <input type="number" name="stock" value="<?= $product['stock'] ?>" required></label><br>

  <!-- ✅ Category Dropdown -->
  <label>Category:
    <select name="category_id" required>
      <option value="">-- Select Category --</option>
      <?php while ($cat = $categories->fetch_assoc()): ?>
        <option value="<?= $cat['category_id'] ?>" <?= $cat['category_id'] == $product['category_id'] ? 'selected' : '' ?>>
          <?= $cat['name'] ?>
        </option>
      <?php endwhile; ?>
    </select>
  </label><br>

  <!-- ✅ Warranty & Description -->
  <label>Warranty (months): <input type="number" name="warranty_months" value="<?= $product['warranty_months'] ?>" required></label><br>
  <label>Description: <input type="text" name="description" value="<?= $product['description'] ?>" required></label><br>

  <button type="submit">✅ Update</button>
</form>

<br><a href="manage_products.php">⬅️ Back to Products</a>
