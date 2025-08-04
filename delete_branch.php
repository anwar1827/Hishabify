<?php
require_once("db.php");

$branch_id = intval($_GET['id']);

// Step 1: Delete sale_details (using product.branch_id)
$conn->query("DELETE sd FROM sale_details sd
              JOIN product p ON sd.product_id = p.product_id
              WHERE p.branch_id = $branch_id");

// Step 2: Delete sales
$conn->query("DELETE FROM sale WHERE branch_id = $branch_id");

// Step 3: Delete products
$conn->query("DELETE FROM product WHERE branch_id = $branch_id");

// Step 4: Delete employees
$conn->query("DELETE FROM employee WHERE branch_id = $branch_id");

// Step 5: Delete managers
$conn->query("DELETE FROM manager WHERE branch_id = $branch_id");

// Step 6: Delete branch
$conn->query("DELETE FROM branch WHERE branch_id = $branch_id");

header("Location: branch_list.php?deleted=1");
exit;
?>
