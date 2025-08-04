<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
require_once("db.php");

$branches = $conn->query("SELECT * FROM branch WHERE owner_id = " . $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
  <title>🏢 All Branches</title>
  <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    .success { color: green; }
  </style>
</head>
<body>

<h2>🏢 Branch List</h2>

<?php
if (isset($_GET['added'])) echo "<p class='success'>✅ Branch added successfully!</p>";
if (isset($_GET['updated'])) echo "<p class='success'>✅ Branch updated successfully!</p>";
if (isset($_GET['deleted'])) echo "<p class='success'>🗑️ Branch deleted successfully!</p>";
?>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Location</th>
      <th>Contact</th>
      <th>Time</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = $branches->fetch_assoc()): ?>
      <tr>
        <td><?= $row['branch_id'] ?></td>
        <td><?= htmlspecialchars($row['branch_name']) ?></td>
        <td><?= htmlspecialchars($row['location']) ?></td>
        <td><?= htmlspecialchars($row['contact_number']) ?></td>
        <td><?= $row['open_time'] ?> - <?= $row['close_time'] ?></td>
        <td>
          <a href="edit_branch.php?id=<?= $row['branch_id'] ?>">✏️ Edit</a> |
          <a href="delete_branch.php?id=<?= $row['branch_id'] ?>" onclick="return confirm('Are you sure you want to delete this branch?');">🗑️ Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<br>
<a href="add_branch.php">➕ Add New Branch</a> | 
<a href="owner_dashboard.php">⬅️ Back to Dashboard</a>

</body>
</html>
