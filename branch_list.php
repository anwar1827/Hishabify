<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
require_once("db.php");

// Stored procedure call
$owner_id = $_SESSION['user_id'];
$stmt = $conn->prepare("CALL GetOwnerBranches(?)");
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();

$branches = [];
while($row = $result->fetch_assoc()) {
    $branches[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>🏢 All Branches</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body { font-family: Arial; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    .btn { padding: 5px 10px; text-decoration: none; background: #28a745; color: white; border-radius: 4px; }
    .btn-danger { background: #dc3545; }
  </style>
</head>
<body>

<h1>🏢 Branch List</h1>
<h2><a href="add_branch.php" class="btn">➕ Add New Branch</a></h2>

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
    <?php foreach($branches as $row): ?>
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
    <?php endforeach; ?>
  </tbody>
</table>

<br>
<a href="owner_dashboard.php" class="btn" style="text-decoration:none; background:#007bff; color:white; padding:8px 16px; border-radius:5px;">⬅️ Back to Dashboard</a>

<script src="assets/js/script.js"></script>
</body>
</html>
