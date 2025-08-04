<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
require_once("db.php");

$managers = $conn->query("
    SELECT m.*, b.branch_name 
    FROM manager m
    JOIN branch b ON m.branch_id = b.branch_id
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>📋 Manager List</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    .btn { padding: 5px 10px; text-decoration: none; background: #28a745; color: white; border-radius: 4px; }
    .btn-danger { background: #dc3545; }
  </style>
</head>
<body>

<h2>👨‍💼 All Managers</h2>
<a href="add_manager.php" class="btn">➕ Add Manager</a>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Branch</th>
      <th>Hire Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($m = $managers->fetch_assoc()): ?>
      <tr>
        <td><?= $m['manager_id'] ?></td>
        <td><?= $m['name'] ?></td>
        <td><?= $m['email'] ?></td>
        <td><?= $m['phone'] ?></td>
        <td><?= $m['branch_name'] ?></td>
        <td><?= $m['hire_date'] ?></td>
        <td>
          <a href="edit_manager.php?id=<?= $m['manager_id'] ?>" class="btn">✏️ Edit</a>
          <a href="delete_manager.php?id=<?= $m['manager_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">🗑️ Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<br><a href="owner_dashboard.php" style="text-decoration:none; background:#007bff; color:white; padding:8px 16px; border-radius:5px;">⬅️ Back to Dashboard</a>

</body>
</html>
