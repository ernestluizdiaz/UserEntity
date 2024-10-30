<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="child.css">
  <title>Edit Order</title>
  <script>
    const ramenPrices = {
      "Shoyu Ramen": 10.00,
      "Miso Ramen": 12.00,
      "Tonkotsu Ramen": 15.00,
      "Aka Ramen": 13.00,
      "Tantanmen Ramen": 9.00
    };

    function calculateTotalPrice() {
      const ramenType = document.getElementById("ramen_type").value;
      const quantity = document.getElementById("quantity").value;
      const totalPriceElement = document.getElementById("totalPrice");

      if (ramenType && quantity) {
        const price = ramenPrices[ramenType];
        const totalPrice = price * quantity;
        totalPriceElement.value = totalPrice.toFixed(2);
      } else {
        totalPriceElement.value = "";
      }
    }

    // Call this function on page load to set the initial total price
    window.onload = function() {
      calculateTotalPrice();
    }
  </script>
</head>
<body>
  <div class="wrapper">
    <a class="links" href="vieworder.php?customer_id=<?php echo htmlspecialchars($_GET['customer_id']); ?>">Back to Order</a>
    <h1>Edit Order</h1>
    <?php $getOrderByID = getOrderByID($pdo, $_GET['order_id']); ?>
    <div class="container">
      <form action="core/handleForms.php?order_id=<?php echo $_GET['order_id']; ?>&customer_id=<?php echo $_GET['customer_id']; ?>" method="POST">
      <p>
      <input type="hidden" name="order_id" id="order_id" value="<?php echo htmlspecialchars($getOrderByID['order_id']); ?>">
      <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($_GET['customer_id']); ?>">
      </p>
      <p>
        <label for="ramen_type">Ramen Type</label>
        <select name="ramen_type" id="ramen_type" onchange="calculateTotalPrice()"  class="input" required>
          <option value="">Select Ramen Type</option>
          <option value="Shoyu Ramen" <?php echo ($getOrderByID['ramen_type'] == "Shoyu Ramen") ? "selected" : ""; ?>>Shoyu Ramen</option>
          <option value="Miso Ramen" <?php echo ($getOrderByID['ramen_type'] == "Miso Ramen") ? "selected" : ""; ?>>Miso Ramen</option>
          <option value="Tonkotsu Ramen" <?php echo ($getOrderByID['ramen_type'] == "Tonkotsu Ramen") ? "selected" : ""; ?>>Tonkotsu Ramen</option>
          <option value="Aka Ramen" <?php echo ($getOrderByID['ramen_type'] == "Aka Ramen") ? "selected" : ""; ?>>Aka Ramen</option>
          <option value="Tantanmen Ramen" <?php echo ($getOrderByID['ramen_type'] == "Tantanmen Ramen") ? "selected" : ""; ?>>Tantanmen Ramen</option>
        </select>
      </p>

      <p>
        <label for="quantity">Quantity</label>
        <input class="input" type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($getOrderByID['quantity']); ?>" required min="1" onchange="calculateTotalPrice()">
      </p>

      <p>
        <label for="totalPrice">Total Price</label>
        <input class="input" type="text" id="totalPrice" name="total_price" value="<?php echo number_format($getOrderByID['total_price'], 2); ?>" readonly>
      </p>

      <button class="btn" type="submit" name="editOrderBtn">Edit Order</button>
    </form>
    </div>
  </div>
</body>
</html>
