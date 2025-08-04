<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$manager_id = $_SESSION['user_id'];

// Get branch_id
$branch_stmt = $conn->prepare("SELECT branch_id FROM manager WHERE manager_id = ?");
$branch_stmt->bind_param("i", $manager_id);
$branch_stmt->execute();
$branch_result = $branch_stmt->get_result()->fetch_assoc();
$branch_id = $branch_result['branch_id'];

// Get sales for this manager & branch
$sales = $conn->query("
  SELECT s.sale_id, s.sale_time, s.total_price, s.discount_applied,
         c.name AS customer_name, e.name AS employee_name
  FROM sale s
  JOIN customer c ON s.customer_id = c.customer_id
  JOIN employee e ON s.employee_id = e.employee_id
  WHERE s.manager_id = $manager_id AND s.branch_id = $branch_id
  ORDER BY s.sale_time DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>🧾 Sale History</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background-color: #f2f2f2; }
    a.btn { padding: 5px 10px; text-decoration: none; background: #28a745; color: white; border-radius: 4px; }
  </style>
</head>
<body>

<h2>📊 Sale History (Your Branch)</h2>

<table>
  <tr>
    <th>Sale ID</th>
    <th>Customer</th>
    <th>Employee</th>
    <th>Sale Time</th>
    <th>Discount</th>
    <th>Total</th>
    <th>Details</th>
  </tr>

  <?php while($row = $sales->fetch_assoc()): ?>
    <tr>
      <td><?= $row['sale_id'] ?></td>
      <td><?= htmlspecialchars($row['customer_name']) ?></td>
      <td><?= htmlspecialchars($row['employee_name']) ?></td>
      <td><?= $row['sale_time'] ?></td>
      <td><?= $row['discount_applied'] ?>৳</td>
      <td><?= $row['total_price'] ?>৳</td>
      <td><a href="view_invoice.php?sale_id=<?= $row['sale_id'] ?>" class="btn">📄 View</a></td>
    </tr>
  <?php endwhile; ?>

</table>

<br><a href="manager_dashboard.php" style="text-decoration:none; background:#007bff; color:white; padding:8px 16px; border-radius:5px;">⬅️ Back to Dashboard</a>

</body>
</html>
