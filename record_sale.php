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
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 900px;
      margin: 40px auto;
      background: #fff;
      padding: 30px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      border-radius: 8px;
    }

    h2, h3 {
      text-align: center;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 15px;
      color: #444;
    }

    input[type="text"],
    input[type="number"],
    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
      margin-top: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: #fff;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: center;
    }

    th {
      background-color: #f1f1f1;
    }

    .btn {
      background: #28a745;
      color: white;
      padding: 10px 20px;
      border: none;
      font-size: 15px;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .btn:hover {
      background: #218838;
    }

    .btn-secondary {
      background: #007bff;
    }

    .btn-secondary:hover {
      background: #0069d9;
    }

    .btn-add {
      display: block;
      margin: 20px auto;
      background: #ffc107;
      color: #212529;
    }

    .form-section {
      margin-bottom: 30px;
    }

    .center {
      text-align: center;
    }

    a.btn-secondary {
      display: inline-block;
      text-align: center;
      text-decoration: none;
    }
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

<div class="container">
  <h2>🛒 New Sale Entry</h2>

  <form method="POST" action="insert_sale.php">
    <div class="form-section">
      <label>Customer Name:
        <input type="text" name="customer_name" required>
      </label>
      <label>Contact:
        <input type="text" name="customer_phone" required>
      </label>
      <label>Address:
        <input type="text" name="customer_address" required>
      </label>
      <label>👨‍💼 Employee:
        <select name="employee_id" required>
          <option value="">-- Select Employee --</option>
          <?php while($emp = $employees->fetch_assoc()): ?>
            <option value="<?= $emp['employee_id'] ?>"><?= $emp['name'] ?> (<?= $emp['designation'] ?>)</option>
          <?php endwhile; ?>
        </select>
      </label>
    </div>

    <div class="form-section">
      <h3>🧾 Products</h3>
      <table>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Warranty (months)</th>
            <th>Quantity</th>
            <th>Discount</th>
          </tr>
        <tbody id="product_rows"></tbody>
      </table>
     <button type="button" class="btn btn-add" onclick="addRow()">➕ Add Product</button>
    </div>

    <div class="form-section">
      <h3>💵 Payment Info</h3>
      <label>Payment Method:
        <select name="payment_method" required>
          <option value="">-- Select Method --</option>
          <option value="Cash">Cash</option>
          <option value="Bkash">Bkash</option>
          <option value="Nagad">Nagad</option>
          <option value="Bank">Bank</option>
        </select>
      </label>
      <label>Amount Paid:
        <input type="number" step="0.01" name="amount_paid" required>
      </label>
    </div>

    <div class="center">
      <button type="submit" class="btn">✅ Confirm Sale</button>
    </div>
  </form>

  <br>
  <div class="center">
    <a href="manager_dashboard.php" class="btn btn-secondary">⬅️ Back to Dashboard</a>
  </div>
</div>

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

<script src="assets/js/script.js"></script>
</body>
</html>
