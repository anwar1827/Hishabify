<?php
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != $required_role) {
    echo "❌ Unauthorized Access!";
    exit();
}
