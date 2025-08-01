<!DOCTYPE html>
<html>
<head>
  <title>Monthly Sales Report</title>
</head>
<body>
  <h2>Generate Monthly Report</h2>
  <form action="../monthly_report.php" method="POST">
    <label>Month (1–12):</label>
    <input type="number" name="month" required><br><br>
    <label>Year (e.g., 2025):</label>
    <input type="number" name="year" required><br><br>
    <input type="submit" value="Generate">
  </form>
</body>
</html>
