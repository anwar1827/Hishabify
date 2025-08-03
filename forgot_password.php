<!DOCTYPE html>
<html>
<head><title>Forgot Password</title></head>
<body>
  <h2>Forgot Password</h2>
  <form action="reset_password.php" method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>User Type:</label><br>
    <select name="user_type" required>
      <option value="owner">Owner</option>
      <option value="manager">Manager</option>
    </select><br><br>

    <input type="submit" value="Next">
  </form>
</body>
</html>
