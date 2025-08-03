<?php
require_once("../db.php");
session_start();
$required_role = 'owner';
require_once("../includes/role_guard.php");
?>
