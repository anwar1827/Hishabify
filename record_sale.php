<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$manager_id = $_SESSION['user_id'];
$branch = $conn->query("SELECT branch_id FROM manager WHERE manager_id = $manager_id")->fetch_assoc();
$branch_id = $branch['branch_id'];

$categories = $conn->query("SELECT * FROM category");
$employees = $conn->query("SELECT * FROM employee WHERE manager_id = $manager_id");
?>

<!DOCTYPE html>
<html>
<head>
  <title>🛒 New Sale</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    input, select { padding: 6px; margin: 5px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    .btn { padding: 6px 12px; }
  </style>
  <script>
    function addRow() {
      const row = document.querySelector("#row_template").cloneNode(true);
      row.removeAttribute("id");
      row.style.display = "";
      document.querySelector("#product_rows").appendChild(row);
    }

    function updateRow(select) {
      const option = select.options[select.selectedIndex];
      const row = select.closest("tr");
      row.querySelector(".price").value = option.dataset.price;
      row.querySelector(".warranty").value = option.dataset.warranty;
    }
  </script>
</head>
<body>

<h2>🛒 New Sale</h2>

<form method="POST" action="insert_sale.php">
  <label>Customer Name: <input type="text" name="customer_name" required></label><br>
  <label>Contact: <input type="text" name="customer_phone" required></label><br>
  <label>Address: <input type="text" name="customer_address" required></label><br>

  <label>👨‍💼 Employee:
    <select name="employee_id" required>
      <option value="">-- Select Employee --</option>
      <?php while($emp = $employees->fetch_assoc()): ?>
        <option value="<?= $emp['employee_id'] ?>"><?= $emp['name'] ?> (<?= $emp['designation'] ?>)</option>
      <?php endwhile; ?>
    </select>
  </label>

  <h3>🧾 Products</h3>
  <table>
    <thead>
      <tr>
        <th>Product</th><th>Price</th><th>Warranty (months)</th><th>Quantity</th><th>Discount</th>
      </tr>
    </thead>
    <tbody id="product_rows"></tbody>
  </table>

  <button type="button" class="btn" onclick="addRow()">➕ Add Product</button><br><br>
  <button type="submit" class="btn">✅ Confirm Sale</button>
</form>

<!-- 🔁 Hidden row template -->
<table style="display:none;">
  <tr id="row_template">
    <td>
      <select name="product_id[]" onchange="updateRow(this)" required>
        <option value="">-- Select Product --</option>
        <?php
        $categories = $conn->query("SELECT * FROM category");
        while ($cat = $categories->fetch_assoc()):
          echo "<optgroup label='{$cat['name']}'>";
          $cat_id = $cat['category_id'];
          $products = $conn->query("SELECT * FROM product WHERE branch_id = $branch_id AND category_id = $cat_id");
          while ($p = $products->fetch_assoc()):
        ?>
        <option value="<?= $p['product_id'] ?>" data-price="<?= $p['price'] ?>" data-warranty="<?= $p['warranty_months'] ?>">
          <?= $p['name'] ?> - <?= $p['brand'] ?> <?= $p['model'] ?>
        </option>
        <?php endwhile; echo "</optgroup>"; endwhile; ?>
      </select>
    </td>
    <td><input type="number" class="price" name="price[]" readonly></td>
    <td><input type="number" class="warranty" name="warranty_months[]" readonly></td>
    <td><input type="number" name="quantity[]" required></td>
    <td><input type="number" name="discount[]" value="0"></td>
  </tr>
</table>

<br><a href="manager_dashboard.php">⬅️ Back to Dashboard</a>

</body>
</html>
