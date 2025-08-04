<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
require_once("db.php");

$id = intval($_GET['id']);
$manager = $conn->query("SELECT * FROM manager WHERE manager_id = $id")->fetch_assoc();
$branches = $conn->query("SELECT branch_id, branch_name FROM branch");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];
    $branch_id = $_POST['branch_id'];
    $hire_date = $_POST['hire_date'];

    $stmt = $conn->prepare("UPDATE manager SET name=?, email=?, phone=?, branch_id=?, hire_date=? WHERE manager_id=?");
    $stmt->bind_param("sssisi", $name, $email, $phone, $branch_id, $hire_date, $id);
    $stmt->execute();

    header("Location: manager_list.php?updated=1");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>✏️ Edit Manager</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    form { max-width: 400px; margin: auto; }
    input, select { width: 100%; padding: 8px; margin: 10px 0; }
    .btn { padding: 10px 15px; background: #007bff; color: white; border: none; cursor: pointer; }
  </style>
</head>
<body>

<h2>✏️ Edit Manager</h2>

<form method="POST">
  <input type="text" name="name" value="<?= $manager['name'] ?>" required>
  <input type="email" name="email" value="<?= $manager['email'] ?>" required>
  <input type="text" name="phone" value="<?= $manager['phone'] ?>" required>

  <label>Branch</label>
  <select name="branch_id" required>
    <?php while($b = $branches->fetch_assoc()): ?>
      <option value="<?= $b['branch_id'] ?>" <?= ($b['branch_id'] == $manager['branch_id']) ? 'selected' : '' ?>>
        <?= $b['branch_name'] ?>
      </option>
    <?php endwhile; ?>
  </select>

  <label>Hire Date</label>
  <input type="date" name="hire_date" value="<?= $manager['hire_date'] ?>" required>

  <button type="submit" class="btn">💾 Update Manager</button>

</form>
 

</body>
</html>
