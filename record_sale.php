<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$manager_id = $_SESSION['user_id'];

// Get manager's branch
$branch_result = $conn->query("SELECT branch_id FROM manager WHERE manager_id = $manager_id");
$branch_id = $branch_result->fetch_assoc()['branch_id'];

// Get products for that branch
$products = $conn->query("SELECT * FROM product WHERE branch_id = $branch_id");

// Get employees under this manager
$employees = $conn->query("SELECT * FROM employee WHERE manager_id = $manager_id");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Record Sale</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    label { display: block; margin-top: 10px; }
    input, select { width: 300px; padding: 8px; margin-top: 5px; }
    button { padding: 10px 20px; margin-top: 20px; }
  </style>
</head>
<body>
  <h2>🛒 Record a Sale</h2>
  <form method="POST" action="insert_sale.php">
    <label>Customer Name:</label>
    <input type="text" name="customer_name" required>

    <label>Customer Contact:</label>
    <input type="text" name="customer_contact" required>

    <label>Select Product:</label>
    <select name="product_id" required>
      <option value="">-- Select Product --</option>
      <?php while($row = $products->fetch_assoc()): ?>
        <option value="<?= $row['product_id'] ?>">
          <?= $row['name'] ?> (<?= $row['stock'] ?> in stock)
        </option>
      <?php endwhile; ?>
    </select>

    <label>Select Employee:</label>
    <select name="employee_id" required>
      <option value="">-- Select Employee --</option>
      <?php while($row = $employees->fetch_assoc()): ?>
        <option value="<?= $row['employee_id'] ?>"><?= $row['name'] ?></option>
      <?php endwhile; ?>
    </select>

    <button type="submit">✅ Confirm Sale</button>
  </form>
</body>
</html>
