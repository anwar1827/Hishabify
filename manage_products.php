<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$manager_id = $_SESSION['user_id'];

// Find branch_id
$branch_query = $conn->query("SELECT branch_id FROM manager WHERE manager_id = $manager_id");
$branch_id = $branch_query->fetch_assoc()['branch_id'];

// Search logic
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$like = "%$search%";

if (!empty($search)) {
    $stmt = $conn->prepare("SELECT * FROM product WHERE branch_id = ? AND (name LIKE ? OR brand LIKE ? OR model LIKE ?)");
    $stmt->bind_param("isss", $branch_id, $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->prepare("SELECT * FROM product WHERE branch_id = ?");
    $result->bind_param("i", $branch_id);
    $result->execute();
    $result = $result->get_result();
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Manage Products</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    th { background-color: #f2f2f2; }
    form input { padding: 5px; margin-right: 5px; }
  </style>
</head>
<body>

<h2>📦 Manage Products (Your Branch)</h2>

<form method="GET" style="margin-bottom: 20px;">
  <input type="text" name="search" placeholder="Search by name, brand, model" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
  <button type="submit">🔍 Search</button>
</form>

<!-- Add Product Form -->
<form method="POST" action="insert_product.php">
  <input type="text" name="name" placeholder="Product Name" required>
  <input type="text" name="brand" placeholder="Brand" required>
  <input type="text" name="model" placeholder="Model" required>
  <input type="number" name="price" placeholder="Price" required>
  <input type="number" name="stock" placeholder="Stock" required>
  <button type="submit">➕ Add Product</button>
</form>

<!-- Product Table -->
<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Brand</th>
    <th>Model</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Action</th>
  </tr>
  <?php while($row = $result->fetch_assoc()): ?>

  <tr>
    <td><?= $row['product_id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['brand'] ?></td>
    <td><?= $row['model'] ?></td>
    <td><?= $row['price'] ?>৳</td>
        <td>
      <?= $row['stock'] ?>
      <?= $row['stock'] < 5 ? '<span style="color:red;"> ⚠️ Low</span>' : '' ?>
    </td>
    <td>
  <a href="edit_product.php?id=<?= $row['product_id'] ?>">✏️ Edit</a>
  |
  <a href="delete_product.php?id=<?= $row['product_id'] ?>" onclick="return confirm('Are you sure you want to delete this product?')">🗑️ Delete</a>

</td>

    <td>
      <form method="POST" action="restock_product.php" style="display:inline;">
        <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
        <input type="number" name="add_stock" min="1" placeholder="+stock" required>
        <button type="submit">🔁 Restock</button>
      </form>
    </td>
  </tr>
  <?php endwhile; ?>
</table>




<br><a href="manager_dashboard.php">⬅️ Back to Dashboard</a>

</body>
</html>
