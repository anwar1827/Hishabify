<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Owner Dashboard</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h1>👑 Welcome, <?php echo $_SESSION['user_name']; ?> (Owner)</h1>
  <p>You have successfully logged in.</p>

  <ul>
    <li><a href="owner_sales_report.php">📊 View Sales</a></li>
    <li><a href="view_login_log.php">🧾 View Login Logs</a></li>
    <li><a href="branch_list.php">🏢 Manage Branches</a></li>
    <li><a href="manager_list.php">👥 Manage Managers</a></li>
    <li><a href="owner_monthly_report.php" class="btn">📅 Monthly Manager Report</a></li>
    <li><a href="logout.php">🚪 Logout</a></li>
    
  </ul>
  <script src="assets/js/script.js"></script>
</body>
</html>
