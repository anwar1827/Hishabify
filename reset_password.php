<?php
require_once("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];

    echo "<h3>Reset Password for $email ($user_type)</h3>
    <form method='POST'>
      <input type='hidden' name='email' value='$email'>
      <input type='hidden' name='user_type' value='$user_type'>
      <label>New Password:</label><br>
      <input type='password' name='new_password' required><br><br>
      <input type='submit' name='reset' value='Reset Password'>
    </form>";
}
elseif (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $table = $user_type;
    $stmt = $conn->prepare("UPDATE $table SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_password, $email);

    if ($stmt->execute()) {
        echo "✅ Password reset successful. <a href='login.php'>Login Now</a>";
    } else {
        echo "❌ Failed to reset password.";
    }
}
?>
