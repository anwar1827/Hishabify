<?php
require_once("db.php");


$conn->query("DELETE FROM manager");
$conn->query("DELETE FROM branch");
$conn->query("DELETE FROM owner");

// 🔐 Password hash
$owner_pass = password_hash("admin123", PASSWORD_DEFAULT);
$manager_pass = password_hash("manager123", PASSWORD_DEFAULT);

// ✅ Owner Insert
$conn->query("INSERT INTO owner (name, email, password, phone, address)
VALUES ('Admin Anwar', 'admin@hishabify.com', '$owner_pass', '01711111111', 'Dhaka')");

$owner_id = $conn->insert_id; 


echo "✅ Hashed Owner & Manager inserted successfully!";
?>
