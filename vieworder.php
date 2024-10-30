<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order</title>
  <link rel="stylesheet" href="parent.css">
  <script>
    const ramenPrices = {
      "Shoyu Ramen": 10.00,
      "Miso Ramen": 12.00,
      "Tonkotsu Ramen": 15.00,
      "Aka Ramen": 13.00,
      "Tantanmen Ramen": 9.00
    };

    function calculateTotalPrice() {
      const ramenType = document.getElementById("ramenType").value;
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
  </script>
</head>
<body>
  <div class="wrapper">
    <h1><a href="index.php">Return Home</a></h1>
    <div class="container">
    <form action="core/handleForms.php?customer_id=<?php echo htmlspecialchars($_GET['customer_id']); ?>" method="POST">
      <p>
        <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($_GET['customer_id']); ?>">
      </p>
      <p>
        <label for="ramenType">Ramen Type</label>
        <select name="ramen_type" id="ramenType" required onchange="calculateTotalPrice()" class="input">
          <option value="">Select Ramen Type</option>
          <option value="Shoyu Ramen">Shoyu Ramen</option>
          <option value="Miso Ramen">Miso Ramen</option>
          <option value="Tonkotsu Ramen">Tonkotsu Ramen</option>
          <option value="Aka Ramen">Aka Ramen</option>
          <option value="Tantanmen Ramen">Tantanmen Ramen</option>
        </select>
      </p>

      <p>
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" required min="1" onchange="calculateTotalPrice()" class="input">
      </p>

      <p>
        <label for="totalPrice">Total Price</label>
        <input type="text" id="totalPrice" name="total_price" value="0.00" class="input" readonly>
      </p>
    <button class="btn" style="margin-top: 100%" type="submit" name="addOrderBtn">Add Ramen</button>
</form>

  <table>
    <tr>
      <th>Order ID</th>
      <th>Ramen Type</th>
      <th>Quantity</th>
      <th>Total Price</th>
      <th>Actions</th>
    </tr>
    <?php 
      if (isset($_GET['customer_id'])) {
          $getOrderByCustomer = getOrderByCustomer($pdo, $_GET['customer_id']);
          foreach ($getOrderByCustomer as $row) { 
    ?>
      <tr>
        <td><?php echo ($row['order_id']); ?></td>
        <td><?php echo ($row['ramen_type']); ?></td>
        <td><?php echo ($row['quantity']); ?></td>
        <td><?php echo ($row['total_price']); ?></td>
        <td>
          <li><a class="links" href="editorder.php?order_id=<?php echo ($row['order_id']); ?>&customer_id=<?php echo ($_GET['customer_id']); ?>">Edit</a></li>
          <li><a class="links" href="deleteorder.php?order_id=<?php echo ($row['order_id']); ?>&customer_id=<?php echo ($_GET['customer_id']); ?>">Delete</a></li>
        </td>
      </tr>
    <?php 
          } 
      } else {
          echo "<tr><td colspan='5'>No orders found for this customer.</td></tr>";
      }
    ?>
  </table>
    </div>
  </div>
</body>
</html>
