<!DOCTYPE html>
<html>
<head>
  <title>Restock Product</title>
</head>
<body>
  <h2>Restock Product</h2>
  <form action="../restock.php" method="POST">
    <label>Product ID:</label><br>
    <input type="number" name="product_id" required><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" required><br><br>

    <label>Manager ID:</label><br>
    <input type="number" name="restocked_by" required><br><br>

    <input type="submit" value="Restock">
  </form>
</body>
</html>
