<?php
require_once("includes/session_check.php");
$required_role = 'owner';
require_once("includes/role_guard.php");
require_once("db.php");

// Branch Dropdown Data
$branches = $conn->query("SELECT branch_id, branch_name FROM branch");

// Branch filter handling
$selected_branch = isset($_GET['branch_id']) ? intval($_GET['branch_id']) : 0;

$query = "
SELECT 
    s.sale_id, s.sale_time, s.total_price, s.discount_applied,
    c.name AS customer_name, c.phone AS customer_phone,
    m.name AS manager_name,
    b.branch_name
FROM sale s
JOIN customer c ON s.customer_id = c.customer_id
JOIN manager m ON s.manager_id = m.manager_id
JOIN branch b ON s.branch_id = b.branch_id
";

if ($selected_branch > 0) {
    $query .= " WHERE s.branch_id = $selected_branch";
}

$query .= " ORDER BY s.sale_time DESC";

$sales = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>📊 Owner - All Sales Report</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        select, button { padding: 6px; margin-right: 10px; }
    </style>
</head>
<body>

<h2>📊 All Sales Report (Owner View)</h2>

<!-- 🔍 Branch Filter Form -->
<form method="GET">
    <label>Filter by Branch:</label>
    <select name="branch_id" onchange="this.form.submit()">
        <option value="0">-- All Branches --</option>
        <?php while($branch = $branches->fetch_assoc()): ?>
            <option value="<?= $branch['branch_id'] ?>" <?= ($branch['branch_id'] == $selected_branch) ? 'selected' : '' ?>>
                <?= $branch['branch_name'] ?>
            </option>
        <?php endwhile; ?>
    </select>
    <noscript><button type="submit">Filter</button></noscript>
</form>

<!-- 🧾 Sales Table -->
<table>
    <thead>
        <tr>
            <th>Sale ID</th>
            <th>Date & Time</th>
            <th>Branch</th>
            <th>Manager</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Discount (৳)</th>
            <th>Total Price (৳)</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($sales->num_rows > 0): ?>
            <?php while($row = $sales->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['sale_id'] ?></td>
                    <td><?= $row['sale_time'] ?></td>
                    <td><?= $row['branch_name'] ?></td>
                    <td><?= $row['manager_name'] ?></td>
                    <td><?= $row['customer_name'] ?></td>
                    <td><?= $row['customer_phone'] ?></td>
                    <td><?= $row['discount_applied'] ?>৳</td>
                    <td><?= $row['total_price'] ?>৳</td>
                    
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8">❌ No sales found for this branch.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<br><a href="owner_dashboard.php">⬅️ Back to Dashboard</a>

</body>
</html>
