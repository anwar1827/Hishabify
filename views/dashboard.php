<?php
require_once("../db.php");

$result = $conn->query("SELECT * FROM top_employees");

echo "<h2>Top Performing Employees</h2>";
echo "<table border='1'>
<tr><th>Employee ID</th><th>Name</th><th>Total Sales</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['employee_id']}</td>
    <td>{$row['name']}</td>
    <td>{$row['total_sales']}</td>
    </tr>";
}

echo "</table>";

$conn->close();
?>
