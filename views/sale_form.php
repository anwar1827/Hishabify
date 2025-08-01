<!DOCTYPE html>
<html>
<head>
  <title>Add Sale</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <h2>Add New Sale</h2>
  <form action="../insert_sale.php" method="POST">
    <label>Employee ID:</label><br>
    <input type="number" name="emp_id" required><br><br>

    <label>Product ID:</label><br>
    <input type="number" name="prod_id" required><br><br>

    <label>Manager ID:</label><br>
    <input type="number" name="mgr_id" required><br><br>

    <label>Branch ID:</label><br>
    <input type="number" name="br_id" required><br><br>

    <label>Customer Name:</label><br>
    <input type="text" name="cust_name" required><br><br>

    <label>Customer Contact:</label><br>
    <input type="text" name="cust_contact" required><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="qty" value="1" min="1"><br><br>

    <label>Discount:</label><br>
    <input type="number" name="discount" value="0" step="0.01"><br><br>

    <label>Payment Method:</label><br>
    <select name="method">
      <option value="Cash">Cash</option>
      <option value="Card">Card</option>
      <option value="bKash">bKash</option>
      <option value="Nagad">Nagad</option>
    </select><br><br>

    <input type="submit" value="Submit Sale">
  </form>
</body>
</html>
