<?php
require_once("db.php");

$month = $_POST['month'];
$year = $_POST['year'];

$stmt = $conn->prepare("CALL monthly_sales_report(?, ?)");
$stmt->bind_param("ii", $month, $year);

$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Monthly Report</h2>";
echo "<table border='1'>
<tr><th>Date</th><th>Total Sales</th><thTotal Revenue</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['sale_date']}</td>
    <td>{$row['total_sales']}</td>
    <td>{$row['total_revenue']}</td>
    </tr>";
}

echo "</table>";

$stmt->close();
$conn->close();
?>
