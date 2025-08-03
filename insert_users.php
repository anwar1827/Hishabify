<?php
require_once("db.php");

// Optional: পুরাতন ডাটা ক্লিয়ার
$conn->query("DELETE FROM manager");
$conn->query("DELETE FROM branch");
$conn->query("DELETE FROM owner");

// 🔐 Password hash
$owner_pass = password_hash("admin123", PASSWORD_DEFAULT);
$manager_pass = password_hash("manager123", PASSWORD_DEFAULT);

// ✅ Owner Insert
$conn->query("INSERT INTO owner (name, email, password, phone, address)
VALUES ('Admin Anwar', 'admin@hishabify.com', '$owner_pass', '01711111111', 'Dhaka')");

$owner_id = $conn->insert_id; // 🟢 get generated owner_id

// ✅ Branch Insert
$conn->query("INSERT INTO branch (branch_name, location, contact_number, open_time, close_time, owner_id)
VALUES ('Main Branch', 'Dhanmondi', '01712345678', '09:00:00', '21:00:00', $owner_id)");

$branch_id = $conn->insert_id; // 🟢 get generated branch_id

// ✅ Manager Insert
$conn->query("INSERT INTO manager (name, email, password, phone, hire_date, branch_id)
VALUES ('Manager Rakin', 'manager@hishabify.com', '$manager_pass', '01722222222', '2024-01-01', $branch_id)");

echo "✅ Hashed Owner & Manager inserted successfully!";
?>
