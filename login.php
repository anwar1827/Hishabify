<!DOCTYPE html>
<html>
<head>
  <title>Login - Hishabify</title>
     <style>
    body { font-family: Arial; padding: 20px; }
    form { max-width: 400px; margin: auto; }
    input, select { width: 100%; padding: 8px; margin: 10px 0; }
    .btn { padding: 10px 15px; background: #007bff; color: white; border: none; cursor: pointer; }
  </style>
    
<h1>Login</h1>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body { font-family: Arial; padding: 20px; }
    form { max-width: 400px; margin: auto; }
    input, select { width: 100%; padding: 8px; margin: 10px 0; }
    .btn { padding: 10px 15px; background: #007bff; color: white; border: none; cursor: pointer; }
  </style>
</head>
<body>
  
  <form method="POST" action="authenticate.php">
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
