<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manager Dashboard</title>
</head>
<body>
  <h1>👨‍💼 Welcome, <?php echo $_SESSION['user_name']; ?> (Manager)</h1>
  <p>You have successfully logged in.</p>

  <ul>
    <li><a href="record_sale.php">🛒 Record New Sale</a></li>
    <li><a href="manage_products.php">📦 Manage Products</a></li>
    <li><a href="manage_employees.php">👨‍💼 Manage Employees</a></li>
    <li><a href="logout.php">🚪 Logout</a></li>
  </ul>
</body>
</html>
