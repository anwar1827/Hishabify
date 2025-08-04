<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
?>

<!DOCTYPE html>
<html>
<head>
  <title>👨‍💼 Manager Dashboard</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h1 style="text-align:center;">👨‍💼 Welcome, <?php echo $_SESSION['user_name']; ?> (Manager)</h1>

  <div class="dashboard-container">

    <div class="dashboard-card" onclick="location.href='record_sale.php'">
      <h3>🛒 Record New Sale</h3>
      <p>Sell products and log customer info</p>
    </div>

    <div class="dashboard-card" onclick="location.href='sale_history.php'">
      <h3>📊 Sale History</h3>
      <p>View all previous sales records</p>
    </div>

    <div class="dashboard-card" onclick="location.href='manage_products.php'">
      <h3>📦 Manage Products</h3>
      <p>Add, edit or delete inventory items</p>
    </div>

    <div class="dashboard-card" onclick="location.href='manage_employees.php'">
      <h3>👨‍💼 Manage Employees</h3>
      <p>Hire or manage shop employees</p>
    </div>

    <div class="dashboard-card" onclick="location.href='manager_employee_report.php'">
      <h3>📈 Monthly Employee Report</h3>
      <p>Check employee performance</p>
    </div>

    <div class="dashboard-card" onclick="location.href='logout.php'">
      <h3>🚪 Logout</h3>
      <p>Exit your dashboard securely</p>
    </div>

  </div>

  <script src="assets/js/script.js"></script>
</body>
</html>
