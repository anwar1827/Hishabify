<?php
require_once("db.php");

$conn->query("INSERT INTO category (name) VALUES 
('Smartphones'),
('Feature Phones'),
('Chargers'),
('Earphones'),
('Phone Covers'),
('Screen Protectors'),
('SIM Cards'),
('Mobile Recharge'),
('Repair Service'),
('Power Banks')");

echo "✅ Mobile shop-specific categories inserted!";
?>
