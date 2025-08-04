<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
require_once("db.php");

$query = "
SELECT 
    m.manager_id,
    m.name AS manager_name,
    b.branch_name,
    DATE_FORMAT(s.sale_time, '%Y-%m') AS sale_month,
    COUNT(s.sale_id) AS total_sales,
    SUM(s.total_price) AS total_amount
FROM sale s
JOIN manager m ON s.manager_id = m.manager_id
JOIN branch b ON m.branch_id = b.branch_id
GROUP BY m.manager_id, sale_month
ORDER BY sale_month DESC, total_sales DESC
";

$results = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>📅 Monthly Manager Performance</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background: #f2f2f2; }
  </style>
</head>
<body>

<h2>📅 Monthly Performance Report (Managers)</h2>

<table>
  <thead>
    <tr>
      <th>Month</th>
      <th>Manager Name</th>
      <th>Branch</th>
      <th>Total Sales</th>
      <th>Total Amount (৳)</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($results->num_rows > 0): ?>
      <?php while ($row = $results->fetch_assoc()): ?>
        <tr>
          <td><?= $row['sale_month'] ?></td>
          <td><?= htmlspecialchars($row['manager_name']) ?></td>
          <td><?= htmlspecialchars($row['branch_name']) ?></td>
          <td><?= $row['total_sales'] ?></td>
          <td><?= number_format($row['total_amount'], 2) ?>৳</td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5">❌ No performance data found.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<br><a href="owner_dashboard.php">⬅️ Back to Dashboard</a>

</body>
</html>
