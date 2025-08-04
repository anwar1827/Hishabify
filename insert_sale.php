<?php
require_once("includes/session_check.php");
$required_role = 'manager';
require_once("includes/role_guard.php");
require_once("db.php");

$manager_id = $_SESSION['user_id'];

// Step 1: Get Branch ID
$branch_stmt = $conn->prepare("SELECT branch_id FROM manager WHERE manager_id = ?");
$branch_stmt->bind_param("i", $manager_id);
$branch_stmt->execute();
$branch_result = $branch_stmt->get_result()->fetch_assoc();
$branch_id = $branch_result['branch_id'];

// Step 2: Insert Customer Info
$name = $_POST['customer_name'];
$phone = $_POST['customer_phone'];
$address = $_POST['customer_address'];

$insert_customer = $conn->prepare("INSERT INTO customer (name, phone, address) VALUES (?, ?, ?)");
$insert_customer->bind_param("sss", $name, $phone, $address);
$insert_customer->execute();
$customer_id = $conn->insert_id;

// Step 3: Create Sale Record
$sale_time = date("Y-m-d H:i:s");
$employee_id = $_POST['employee_id'];

$insert_sale = $conn->prepare("INSERT INTO sale (employee_id, manager_id, branch_id, customer_id, sale_time, discount_applied, total_price) VALUES (?, ?, ?, ?, ?, 0, 0)");
$insert_sale->bind_param("iiiis", $employee_id, $manager_id, $branch_id, $customer_id, $sale_time);
$insert_sale->execute();
$sale_id = $conn->insert_id;

// Step 4: Sale Details Processing
$product_ids = $_POST['product_id'];
$quantities = $_POST['quantity'];
$discounts = $_POST['discount'];

$grand_total = 0;
$total_discount = 0;

for ($i = 0; $i < count($product_ids); $i++) {
    $pid = $product_ids[$i];
    $qty = $quantities[$i];
    $disc = $discounts[$i];

    // Product Info
    $product_q = $conn->prepare("SELECT price, warranty_months FROM product WHERE product_id = ?");
    $product_q->bind_param("i", $pid);
    $product_q->execute();
    $product_data = $product_q->get_result()->fetch_assoc();

    $unit_price = $product_data['price'];
    $warranty = $product_data['warranty_months'];

    $line_price = $unit_price * $qty;
    $line_total = $line_price - $disc;
    $warranty_expiry = date("Y-m-d", strtotime("+$warranty months", strtotime($sale_time)));

    // Insert into sale_details
    $insert_detail = $conn->prepare("INSERT INTO sale_details (sale_id, product_id, quantity, unit_price, total_line_price, warranty_expire_date, discount_applied) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert_detail->bind_param("iiiddsi", $sale_id, $pid, $qty, $unit_price, $line_total, $warranty_expiry, $disc);
    $insert_detail->execute();

    // Stock Update
    $update_stock = $conn->prepare("UPDATE product SET stock = stock - ? WHERE product_id = ?");
    $update_stock->bind_param("ii", $qty, $pid);
    $update_stock->execute();

    // Total update
    $grand_total += $line_total;
    $total_discount += $disc;
}

// Step 5: Final Update of Sale
$update_sale = $conn->prepare("UPDATE sale SET total_price = ?, discount_applied = ? WHERE sale_id = ?");
$update_sale->bind_param("dii", $grand_total, $total_discount, $sale_id);
$update_sale->execute();

// Step 6: Update total sales count
$conn->query("UPDATE employee SET total_sales = total_sales + 1 WHERE employee_id = $employee_id");
$conn->query("UPDATE manager SET total_sales = total_sales + 1 WHERE manager_id = $manager_id");

// Done
header("Location: record_sale.php?success=1");
?>
