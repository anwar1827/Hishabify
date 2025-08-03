<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$manager_id = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT branch_id FROM manager WHERE manager_id = ?");
$stmt->bind_param("i", $manager_id);
$stmt->execute();
$result = $stmt->get_result();
$branch_id = $result->fetch_assoc()['branch_id'];


$emp_stmt = $conn->prepare("SELECT * FROM employee WHERE manager_id = ? AND branch_id = ?");
$emp_stmt->bind_param("ii", $manager_id, $branch_id);
$emp_stmt->execute();
$employees = $emp_stmt->get_result();
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($search)) {
    $like = "%$search%";
    $emp_stmt = $conn->prepare("SELECT * FROM employee WHERE manager_id = ? AND branch_id = ? AND (name LIKE ? OR phone LIKE ?)");
    $emp_stmt->bind_param("iiss", $manager_id, $branch_id, $like, $like);
    $emp_stmt->execute();
    $employees = $emp_stmt->get_result();
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Employees</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    th { background-color: #f2f2f2; }
    input, select {
      padding: 6px; margin-right: 10px;
    }
  </style>
</head>
<body>

<h2>👨‍💼 Manage Employees</h2>

<form method="GET" style="margin-bottom: 20px;">
  <input type="text" name="search" placeholder="Search by name or phone" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
  <button type="submit">🔍 Search</button>
</form>


<form method="POST" action="insert_employee.php">
  <input type="text" name="name" placeholder="Full Name" required>
  <input type="text" name="designation" placeholder="Designation" required>
  <input type="text" name="nid" placeholder="NID Number" required>
  <input type="tel" name="phone" placeholder="Phone Number" required>
  <button type="submit">➕ Add Employee</button>
</form>

<!-- 📋 Employee Table -->
<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Designation</th>
    <th>NID</th>
    <th>Phone</th>
    <th>Join Date</th>
    <th>Total Sales</th>
    <th>Actions</th>
  </tr>
  <?php while($row = $employees->fetch_assoc()): ?>
  <tr>
    <td><?= $row['employee_id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['designation'] ?></td>
    <td><?= $row['nid'] ?></td>
    <td><?= $row['phone'] ?></td>
    <td><?= $row['join_date'] ?></td>
    <td><?= $row['total_sales'] ?></td>
    <td>
      <a href="edit_employee.php?id=<?= $row['employee_id'] ?>">✏️ Edit</a> |
      <a href="delete_employee.php?id=<?= $row['employee_id'] ?>"
         onclick="return confirm('Are you sure?')">🗑️ Delete</a>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

<br><a href="manager_dashboard.php">⬅️ Back to Dashboard</a>

</body>
</html>
