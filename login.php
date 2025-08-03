<!DOCTYPE html>
<html>
<head>
  <title>Login - Hishabify</title>
</head>
<body>
  <h2>Login</h2>
  <form action="authenticate.php" method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <label>User Type:</label><br>
    <select name="user_type">
      <option value="owner">Owner</option>
      <option value="manager">Manager</option>
    </select><br><br>
    <input type="submit" value="Login">
  </form>
</body>
</html>
