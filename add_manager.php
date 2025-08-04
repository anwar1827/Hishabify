<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
require_once("db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $branch_id = $_POST['branch_id'];
    $hire_date = $_POST['hire_date'];

    $stmt = $conn->prepare("INSERT INTO manager (name, email, phone, password, branch_id, hire_date)
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $name, $email, $phone, $password, $branch_id, $hire_date);
    $stmt->execute();

    header("Location: manager_list.php?added=1");
    exit;
}

// Get branch list
$branches = $conn->query("SELECT branch_id, branch_name FROM branch");
?>

<!DOCTYPE html>
<html>
<head>
  <title>➕ Add Manager</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    form { max-width: 400px; margin: auto; }
    input, select { width: 100%; padding: 8px; margin: 10px 0; }
    .btn { padding: 10px 15px; background: #28a745; color: white; border: none; cursor: pointer; }
  </style>
</head>
<body>

<h2>➕ Add New Manager</h2>

<form method="POST">
  <input type="text" name="name" placeholder="Name" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="text" name="phone" placeholder="Phone" required>
  <input type="password" name="password" placeholder="Password" required>

  <label>Branch</label>
  <select name="branch_id" required>
    <option value="">-- Select Branch --</option>
    <?php while($b = $branches->fetch_assoc()): ?>
      <option value="<?= $b['branch_id'] ?>"><?= $b['branch_name'] ?></option>
    <?php endwhile; ?>
  </select>

  <label>Hire Date</label>
  <input type="date" name="hire_date" required>

  <button type="submit" class="btn">➕ Add Manager</button>
</form>

</body>
</html>
