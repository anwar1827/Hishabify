<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$manager_id = $_SESSION['user_id'];

// Branch ID
$branch_id = $conn->query("SELECT branch_id FROM manager WHERE manager_id = $manager_id")->fetch_assoc()['branch_id'];

// Month filter
$selected_month = $_GET['month'] ?? date("Y-m");

// Get sales count per employee for selected month
$stmt = $conn->prepare("
SELECT e.employee_id, e.name, e.phone, e.designation, COUNT(s.sale_id) AS total_sales
FROM employee e
LEFT JOIN sale s ON e.employee_id = s.employee_id 
    AND DATE_FORMAT(s.sale_time, '%Y-%m') = ?
WHERE e.branch_id = ?
GROUP BY e.employee_id
ORDER BY total_sales DESC
");
$stmt->bind_param("si", $selected_month, $branch_id);
$stmt->execute();
$results = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>📊 Employee Sales Performance</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    select { padding: 6px; margin-bottom: 10px; }
  </style>
</head>
<body>

<h2>📊 Monthly Employee Sales Report</h2>

<form method="GET">
  <label>Select Month:</label>
  <input type="month" name="month" value="<?= $selected_month ?>" onchange="this.form.submit()">
</form>

<table>
  <thead>
    <tr>
      <th>Employee ID</th>
      <th>Name</th>
      <th>Phone</th>
      <th>Designation</th>
      <th>Total Sales (<?= $selected_month ?>)</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($results->num_rows > 0): ?>
      <?php while($emp = $results->fetch_assoc()): ?>
        <tr>
          <td><?= $emp['employee_id'] ?></td>
          <td><?= $emp['name'] ?></td>
          <td><?= $emp['phone'] ?></td>
          <td><?= $emp['designation'] ?></td>
          <td><?= $emp['total_sales'] ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5">❌ No data found for selected month.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<br><a href="manager_dashboard.php">⬅️ Back to Dashboard</a>

</body>
</html>
