<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$sale_id = $_GET['sale_id'] ?? 0;

// Get Sale Summary
$sale = $conn->query("
  SELECT s.sale_id, s.sale_time, s.total_price, s.discount_applied,
         c.name AS customer_name, c.phone, c.address,
         e.name AS employee_name,
         m.name AS manager_name
  FROM sale s
  JOIN customer c ON s.customer_id = c.customer_id
  JOIN employee e ON s.employee_id = e.employee_id
  JOIN manager m ON s.manager_id = m.manager_id
  WHERE s.sale_id = $sale_id
")->fetch_assoc();

// Get Sale Details (Products)
$items = $conn->query("
  SELECT sd.*, p.name AS product_name, p.brand, p.model
  FROM sale_details sd
  JOIN product p ON sd.product_id = p.product_id
  WHERE sd.sale_id = $sale_id
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>🧾 Invoice #<?= $sale_id ?></title>
  <style>
    body { font-family: Arial; padding: 20px; }
    h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background-color: #f2f2f2; }
    .info { margin-bottom: 20px; }
    .info div { margin-bottom: 5px; }
    .btn { padding: 8px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; }
  </style>
</head>
<body>

<h2>🧾 Sale Invoice #<?= $sale_id ?></h2>

<div class="info">
  <div><strong>🧑 Customer:</strong> <?= htmlspecialchars($sale['customer_name']) ?> (📞 <?= $sale['phone'] ?>)</div>
  <div><strong>🏠 Address:</strong> <?= htmlspecialchars($sale['address']) ?></div>
  <div><strong>🧍‍♂️ Employee:</strong> <?= htmlspecialchars($sale['employee_name']) ?> | <strong>Manager:</strong> <?= htmlspecialchars($sale['manager_name']) ?></div>
  <div><strong>🕒 Sale Time:</strong> <?= $sale['sale_time'] ?></div>
</div>

<table>
  <thead>
    <tr>
      <th>Product</th>
      <th>Brand</th>
      <th>Model</th>
      <th>Quantity</th>
      <th>Unit Price</th>
      <th>Line Total</th>
      <th>Discount</th>
      <th>Warranty Expire</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($item = $items->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($item['product_name']) ?></td>
        <td><?= $item['brand'] ?></td>
        <td><?= $item['model'] ?></td>
        <td><?= $item['quantity'] ?></td>
        <td><?= $item['unit_price'] ?>৳</td>
        <td><?= $item['total_line_price'] ?>৳</td>
        <td><?= $item['discount_applied'] ?>৳</td>
        <td><?= $item['warranty_expire_date'] ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<br>
<h3>💰 Total Paid: <?= $sale['total_price'] ?>৳ (Discount: <?= $sale['discount_applied'] ?>৳)</h3>

<br><br>
<button onclick="window.print()" class="btn">🖨️ Print</button>
<a href="sale_history.php" class="btn" style="background:#007bff;">⬅️ Back</a>

</body>
</html>
