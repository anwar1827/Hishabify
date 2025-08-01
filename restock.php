<?php
require_once("db.php");

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$restocked_by = $_POST['restocked_by'];

$stmt = $conn->prepare("CALL restock_product(?, ?, ?)");
$stmt->bind_param("iii", $product_id, $quantity, $restocked_by);

if ($stmt->execute()) {
    echo "✅ Restock successful.";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
