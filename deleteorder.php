<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="child.css">
</head>
<body>
  <!-- <?php $getOrderByID = getOrderByID($pdo, $_GET['order_id']); ?>
  <table>
    <tr>
      <th>Order ID</th>
      <th>Ramen Type</th>
      <th>Quantity</th>
      <th>Total Price</th>
    </tr>
    <tr>
      <td><?php echo $getOrderByID['order_id']; ?></td>
      <td><?php echo $getOrderByID['ramen_type']; ?></td>
      <td><?php echo $getOrderByID['quantity']; ?></td>
      <td><?php echo $getOrderByID['total_price']; ?></td>
    </tr>
  </table> -->

  <div class="wrapper">
    <a class="links" href="vieworder.php?customer_id=<?php echo htmlspecialchars($_GET['customer_id']); ?>">Back to Order</a>
    <h1 style="font-size: 3rem" !important; >Are you sure you want to delete this order?</h1>
    <div class="container">
      <form action="core/handleForms.php?order_id=<?php echo $_GET['order_id']; ?>&customer_id=<?php echo $_GET['customer_id']; ?>" method="POST">
        <input class="input" type="hidden" name="order_id" id="order_id" value="<?php echo $getOrderByID['order_id']; ?>" readonly>
        <p>
          <label for="ramen_type">Ramen Type</label>
          <input class="input" type="text" name="ramen_type" id="ramen_type" value="<?php echo $getOrderByID['ramen_type']; ?>" readonly>
        </p>
        <p>
          <label for="quantity">Quantity</label>
          <input class="input" type="number" name="quantity" id="quantity" value="<?php echo $getOrderByID['quantity']; ?>" readonly>
        </p>
        <p>
          <label for="total_price">Total Price</label>
          <input class="input" type="number" name="total_price" id="total_price" value="<?php echo $getOrderByID['total_price']; ?>" readonly>
        </p>

        <button class="btn"  type="submit" name="deleteOrderBtn" >Delete Order</button>
        
    </form>
    </div>
  </div>
</body>
</html>
