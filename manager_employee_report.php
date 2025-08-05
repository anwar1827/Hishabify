<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$manager_id = $_SESSION['user_id'];

// 🔢 Dropdown থেকে মাস এবং বছর আনো
$month = $_GET['month'] ?? date('n');
$year = $_GET['year'] ?? date('Y');
?>

<!DOCTYPE html>
<html>
<head>
  <title>📅 Monthly Employee Sales Report</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body { font-family: Arial; padding: 20px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background-color: #f2f2f2; }
    label, select, button { font-size: 16px; padding: 6px; margin-right: 10px; }
    h2 { color: #333; }
  </style>
</head>
<body>

<h2>📅 Monthly Employee Sales Report</h2>

<!-- 🔍 Month & Year Filter Form -->
<form method="GET">
  <label>Month:
    <select name="month">
      <?php for ($m = 1; $m <= 12; $m++): ?>
        <option value="<?= $m ?>" <?= ($m == $month) ? 'selected' : '' ?>>
          <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
        </option>
      <?php endfor; ?>
    </select>
  </label>

  <label>Year:
    <select name="year">
      <?php for ($y = 2023; $y <= date('Y'); $y++): ?>
        <option value="<?= $y ?>" <?= ($y == $year) ? 'selected' : '' ?>><?= $y ?></option>
      <?php endfor; ?>
    </select>
  </label>

  <button type="submit">🔍 View</button>
</form>

<?php
// 📊 Query for monthly sales per employee
$query = "
  SELECT e.name, e.employee_id, SUM(sd.quantity) AS total_quantity
  FROM sale s
  JOIN sale_details sd ON s.sale_id = sd.sale_id
  JOIN employee e ON s.employee_id = e.employee_id
  WHERE s.manager_id = $manager_id
    AND MONTH(s.sale_time) = $month
    AND YEAR(s.sale_time) = $year
  GROUP BY e.employee_id
  ORDER BY total_quantity DESC
";

$result = $conn->query($query);
?>

<!-- 🧾 Results Table -->
<table>
  <thead>
    <tr>
      <th>Employee Name</th>
      <th>Employee ID</th>
      <th>Total Quantity Sold</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= $row['employee_id'] ?></td>
          <td><?= $row['total_quantity'] ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="3">❌ No sales found for this month.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<br><a href="manager_dashboard.php" class="btn">⬅️ Back to Dashboard</a>

</body>
</html>
