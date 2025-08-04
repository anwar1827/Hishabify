<?php
require_once("db.php");

$id = intval($_GET['id']);

// Optional: delete related employees/sales if needed (handle dependencies first!)
$conn->query("DELETE FROM manager WHERE manager_id = $id");

header("Location: manager_list.php?deleted=1");
exit;
?>
