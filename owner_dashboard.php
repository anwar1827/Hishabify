<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
?>

<!DOCTYPE html>
<html>
<head>
  <title>👑 Owner Dashboard - Hishabify</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h1 style="text-align:center;">👑 Welcome, <?php echo $_SESSION['user_name']; ?> (Owner)</h1>

  <div class="dashboard-container">

    <div class="dashboard-card" onclick="location.href='owner_sales_report.php'">
      <h3>📊 View Sales</h3>
      <p>See all sales from every branch</p>
    </div>

    <div class="dashboard-card" onclick="location.href='view_login_log.php'">
      <h3>🧾 Login Logs</h3>
      <p>Track system login history</p>
    </div>

    <div class="dashboard-card" onclick="location.href='branch_list.php'">
      <h3>🏢 Manage Branches</h3>
      <p>Add, edit or remove your branches</p>
    </div>

    <div class="dashboard-card" onclick="location.href='manager_list.php'">
      <h3>👥 Manage Managers</h3>
      <p>Assign or update branch managers</p>
    </div>

    <div class="dashboard-card" onclick="location.href='owner_monthly_report.php'">
      <h3>📅 Monthly Report</h3>
      <p>Compare manager performance</p>
    </div>

    <div class="dashboard-card" onclick="location.href='logout.php'">
      <h3>🚪 Logout</h3>
      <p>Exit the dashboard securely</p>
    </div>

  </div>

  <script src="assets/js/script.js"></script>
</body>
</html>
