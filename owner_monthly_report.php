<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
require_once("db.php");

// 📅 Get selected month & year or current
$month = $_GET['month'] ?? date('n');
$year = $_GET['year'] ?? date('Y');
?>

<!DOCTYPE html>
<html>
<head>
  <title>📅 Monthly Manager Sales Report</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body { font-family: Arial; padding: 20px; }
    h2 { color: #333; }
    form { margin-bottom: 20px; }
    select, button { font-size: 16px; padding: 6px; margin-right: 10px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>

<h2>📅 Manager Monthly Sales Report (Owner View)</h2>

<!-- 🔍 Month-Year Filter -->
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
// 📊 Query: Count all quantities sold by each manager this month
$query = "
  SELECT m.name AS manager_name, b.branch_name, SUM(sd.quantity) AS total_quantity
  FROM sale s
  JOIN sale_details sd ON s.sale_id = sd.sale_id
  JOIN manager m ON s.manager_id = m.manager_id
  JOIN branch b ON s.branch_id = b.branch_id
  WHERE MONTH(s.sale_time) = $month AND YEAR(s.sale_time) = $year
  GROUP BY m.manager_id
  ORDER BY total_quantity DESC
";

$result = $conn->query($query);
?>

<!-- 🧾 Report Table -->
<table>
  <thead>
    <tr>
      <th>Manager Name</th>
      <th>Branch</th>
      <th>Total Quantity Sold</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['manager_name']) ?></td>
          <td><?= htmlspecialchars($row['branch_name']) ?></td>
          <td><?= $row['total_quantity'] ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="3">❌ No data found for this month.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<br><a href="owner_dashboard.php" class="btn">⬅️ Back to Dashboard</a>

</body>
</html>
