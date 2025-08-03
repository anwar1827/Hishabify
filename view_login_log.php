<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
require_once("db.php");

$result = $conn->query("SELECT * FROM login_log ORDER BY login_time DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login History</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">🧾 Login History</h2>
    <table>
        <tr>
            <th>#</th>
            <th>User Type</th>
            <th>User ID</th>
            <th>IP Address</th>
            <th>Login Time</th>
        </tr>
        <?php $i=1; while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= ucfirst($row['user_type']) ?></td>
            <td><?= $row['user_id'] ?></td>
            <td><?= $row['ip_address'] ?></td>
            <td><?= $row['login_time'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div style="text-align:center;">
        <a href="owner_dashboard.php">⬅️ Back to Dashboard</a>
    </div>
</body>
</html>
