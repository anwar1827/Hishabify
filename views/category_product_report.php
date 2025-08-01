<?php
require_once("../db.php");

$result = $conn->query("SELECT * FROM view_category_product_stock");

$current_category = "";
echo "<h2>📦 Product by Category</h2>";

echo "<ul>";

while ($row = $result->fetch_assoc()) {
    if ($current_category != $row['category_name']) {
        if ($current_category != "") echo "</ul>";
        $current_category = $row['category_name'];
        echo "<li><strong>{$current_category}</strong><ul>";
    }
    echo "<li>{$row['product_name']} - Stock: {$row['stock']}</li>";
}

echo "</ul></ul>";

$conn->close();
?>
