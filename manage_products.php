<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

// ✅ Get manager's branch_id
$manager_id = $_SESSION['user_id'];
$branch_query = $conn->query("SELECT branch_id FROM manager WHERE manager_id = $manager_id");
$branch_id = $branch_query->fetch_assoc()['branch_id'];

// ✅ Get inputs
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_filter = isset($_GET['category_filter']) ? $_GET['category_filter'] : '';
$like = "%$search%";

// ✅ Base query
$query = "SELECT * FROM product WHERE branch_id = ?";
$params = [$branch_id];
$types = "i";

// ✅ Apply search filter
if (!empty($search)) {
    $query .= " AND (name LIKE ? OR brand LIKE ? OR model LIKE ?)";
    $params[] = $like; $params[] = $like; $params[] = $like;
    $types .= "sss";
}

// ✅ Apply category filter
if (!empty($category_filter)) {
    $query .= " AND category_id = ?";
    $params[] = $category_filter;
    $types .= "i";
}

// ✅ Final prepare and run
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// ✅ For dropdown
$category_result = $conn->query("SELECT * FROM category");
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
  
  <select name="category_id" required>
  <option value="">-- Select Category --</option>
  <?php while($cat = $category_result->fetch_assoc()): ?>
    <option value="<?= $cat['category_id'] ?>"><?= $cat['name'] ?></option>
  <?php endwhile; ?>
  </select>
  <input type="number" name="stock" placeholder="Stock" required>
  <input type="number" name="warranty_months" placeholder="Warranty (months)" required>
<input type="text" name="description" placeholder="Description" required>

 <br><br> <button type="submit" style="text-decoration:none; background:#007bff; color:white; padding:8px 16px; border-radius:5px;">➕ Add Product</button>
</form>
<br><br>

<form method="GET" style="margin-bottom: 10px;">
  <label>Category: </label>
  <select name="category_filter" onchange="this.form.submit()">
    <option value="">-- All Categories --</option>
    <?php
    $cats = $conn->query("SELECT * FROM category");
    while($c = $cats->fetch_assoc()):
      $selected = (isset($_GET['category_filter']) && $_GET['category_filter'] == $c['category_id']) ? 'selected' : '';
    ?>
      <option value="<?= $c['category_id'] ?>" <?= $selected ?>><?= $c['name'] ?></option>
    <?php endwhile; ?>
  </select>
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
    <th>Warranty</th>
    <th>Description</th>

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
    <td><?= $row['warranty_months'] ?> months</td>
<td><?= $row['description'] ?></td>

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




<br><a href="manager_dashboard.php" style="text-decoration:none; background:#007bff; color:white; padding:8px 16px; border-radius:5px;">⬅️ Back to Dashboard</a>

</body>
</html>
