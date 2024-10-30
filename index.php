<?php 
session_start(); // Start the session
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (!isset($_SESSION['username'])) {
  // Redirect to login page if not logged in
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="parent.css">
  <title>RamenLamig Homepage</title>
  <style>
    .button-container {
      display: flex; /* Use flexbox for layout */
      justify-content: flex-end; /* Align items to the right */
      margin-top: 20px; /* Add some margin at the top */
      gap: 10px; /* Add space between buttons */
    }

    form {
      margin: 0; /* Reset margin */
      padding: 0; /* Reset padding */
      background-color: transparent; /* Reset background color */
      border: none; /* Remove any border */
      font-family: inherit; /* Reset font family */
      color: inherit; /* Reset text color */
      width: 5%;
      box-shadow: none;
    }

    /* Style for buttons */
    button {
    padding: 10px 12px; /* Adjust padding for a smaller button */
    width: 100px; /* Set a fixed width for buttons */
    background-color: #f44336; /* Red background color */
    color: white; /* White text color */
    border: none; /* Remove border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Change cursor to pointer on hover */
    font-size: 16px; /* Keep font size */
    margin-left: 10px; /* Space between buttons */
    transition: background-color 0.3s; /* Smooth transition for background color */
    }

    /* Hover effect */
    button:hover {
        background-color: #d32f2f; /* Darker red on hover */
    }

    #add {
      background-color: #218838;
    }

    #logout {
      background-color: #d32f2f;
    }

    h3 {
      font-size: small;
      color: #f44336;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <h3>Active User: <?php echo htmlspecialchars($_SESSION['username']); ?></h3>
    <h1>Welcome to RamenLamig <br> Order Your Favourite Ramen! 🍜</h1>
    <?php $getAllCustomers = getAllCustomers($pdo); ?>
    <table>
      <thead>
        <tr>
          <th>Customer Name</th>
          <th>Age</th>
          <th>Date of Birth</th>
          <th>Address</th>
          <th>Phone Number</th>
          <th>Email</th>
          <th>Username</th>
          <th>Added By</th>
          <th>Date Created:</th>
          <th>Last Updated</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($getAllCustomers as $row) { ?>
          <tr>
            <td><?php echo $row['customer_name']; ?></td>
            <td><?php echo $row['age']; ?></td>
            <td><?php echo $row['date_of_birth']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['added_by']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td><?php echo $row['last_updated']; ?></td>

            
            <td>
              <li><a class="links" href="vieworder.php?customer_id=<?php echo $row['customer_id']; ?>">View Order</a></li>
              <li><a class="links" href="editcustomer.php?customer_id=<?php echo $row['customer_id']; ?>">Edit</a></li>
              <li><a class="links" href="deletecustomer.php?customer_id=<?php echo $row['customer_id']; ?>">Delete</a></li>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    
    <div class="button-container">
      <form action="core/handleForms.php" method="POST">
        <button type="submit" name="addBtn" id="add">Add</button>
      </form>

      <form action="core/handleForms.php" method="POST">
        <button type="submit" name="logoutBtn" id="logout">Logout</button>
      </form>
    </div>
  </div>
  
</body>
</html>
