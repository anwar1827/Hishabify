<?php
require_once("db.php");

$branch_id = intval($_GET['id']);

// Stored procedure call
$stmt = $conn->prepare("CALL DeleteBranch(?)");
$stmt->bind_param("i", $branch_id);
$stmt->execute();
$stmt->close();

header("Location: branch_list.php?deleted=1");
exit;
?>
