<?php
session_start();
require_once("db.php");

$email = $_POST['email'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];

if ($user_type == 'owner') {
    $query = "SELECT * FROM owner WHERE email = ?";
} else {
    $query = "SELECT * FROM manager WHERE email = ?";
}

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user[$user_type . '_id'];
        $_SESSION['user_type'] = $user_type;
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['last_activity'] = time(); // For timeout

        // Log login
        $ip = $_SERVER['REMOTE_ADDR'];
        $uid = $_SESSION['user_id'];
        $conn->query("INSERT INTO login_log (user_type, user_id, ip_address) VALUES ('$user_type', $uid, '$ip')");

        // Redirect
        header("Location: {$user_type}_dashboard.php");
    } else {
        echo "❌ Incorrect password.";
    }
} else {
    echo "❌ User not found.";
}
