<!-- Purpose: Handle form data from index.php and insert into database -->

<?php
session_start(); 
require_once 'dbConfig.php';
require_once 'models.php';

if (isset($_POST['loginCustomerButton'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Call the loginCustomer function
  $loginResult = loginCustomer($pdo, $username, $password);
  
  // Handle the login result
  if ($loginResult === 'invalid_password') {
      header('Location: ../login.php?error=invalid_password');
      exit();
  } elseif ($loginResult === 'not_found') {
      header('Location: ../login.php?error=not_found');
      exit();
  }
}

if (isset($_POST['logoutBtn'])) {
  // Unset all session variables
  $_SESSION = array();

  // Destroy the session
  session_destroy();

  // Redirect to login page
  header("Location: ../login.php");
  exit();
}


if (isset($_POST['registerCustomerButton'])) {
  // Sanitize and validate input data
  $customer_name = trim($_POST['customer_name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $date_of_birth = $_POST['date_of_birth'];
  $age = (int)$_POST['age'];
  $address = trim($_POST['address']);
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  // Hash the password for security
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Retrieve the added_by value from the current session
  $added_by = $_SESSION['username'] ?? null;

  // Check if username or email already exists
  $existingUser = checkUserExists($pdo, $username, $email);
  if ($existingUser) {
      echo "Username or email already exists. Please choose another.";
      exit();
  }

  // Insert customer data into the database
  $query = registerCustomer($pdo, $customer_name, $email, $phone, $date_of_birth, $age, $address, $username, $hashed_password, $added_by);


  if ($query) {
      echo "Registration successful!<br><br>";
      echo "<a href='../index.php'>Return to Login</a>";
  } else {
      echo "Registration failed! Please try again.";
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['addBtn'])) {
      // Redirect to addCustomer.php
      header("Location: ../addCustomer.php");
      exit();
  }

  // Add your other handling logic for logout and other actions here
  if (isset($_POST['logoutBtn'])) {
      // Logout logic (if any)
      session_destroy(); // Destroy session
      header("Location: login.php"); // Redirect to login page
      exit();
  }
}

if (isset($_POST['submitCustomerButton'])) {
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date_of_birth = $_POST['date_of_birth'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $added_by = $_POST['added_by']; // Get added_by from form

    if (isset($_POST['customer_id']) && !empty($_POST['customer_id'])) {
        // Update existing customer
        $query = updateCustomers($pdo, $_POST['customer_id'], $customer_name, $email, $phone, $date_of_birth, $age, $address, $username);
        
        if ($query) {
            echo "Customer updated successfully!<br><br>";
            echo "<a href='../index.php'>Return Home</a>";
        } else {
            echo "Failed to update customer!";
        }
    } else {
        // Insert new customer
        $query = insertNewCustomer($pdo, $customer_name, $email, $phone, $date_of_birth, $age, $address, $username, $added_by);
        
        if ($query) {
            echo "Customer added successfully!<br><br>";
            echo "<a href='../index.php'>Return Home</a>";
        } else {
            echo "Failed to add customer!";
        }
    }
}



if (isset($_POST['editCustomerBtn'])) {
  $query = updateCustomers($pdo, $_GET['customer_id'], 
    $_POST['customer_name'], 
    $_POST['email'], $_POST['phone'], 
    $_POST['date_of_birth'], 
    $_POST['age'], $_POST['address'], $_POST['username']);
  if ($query) {
    echo "Customer info updated successfully!<br><br>";
    echo "<a href='../index.php'>Return Home</a>";
  } else {
    echo "Failed to update Customer info!";
  }
}


if (isset($_POST["deleteCustomerBtn"])) {
  $query = deleteCustomers($pdo, $_GET['customer_id']);
  if ($query) {
    echo "Customer info deleted successfully!<br><br>";
    echo "<a href='../index.php'>Return Home</a>";
  } else {
    echo "Failed to delete Customer info!";
  }
}


if (isset($_POST["addOrderBtn"])) {
  $total_price = $_POST['total_price']; 
  $customer_id = $_POST['customer_id']; 
  $query = insertOrders($pdo, $_POST['quantity'], $_POST['ramen_type'], $customer_id, $total_price);
  if ($query) {
      echo "Order added successfully!<br><br>";
      echo '<a href="../vieworder.php?customer_id=' . urlencode($customer_id) . '">Return to View Order</a>';
  } else {
      echo "Failed to add order!";
  }
}


if (isset($_POST['editOrderBtn'])) {
  $order_id = $_POST['order_id'];
  $ramen_type = $_POST['ramen_type'];
  $quantity = $_POST['quantity'];
  $total_price = $_POST['total_price'];
  $customer_id = $_POST['customer_id']; 
  $updateSuccessful = updateOrders($pdo, $order_id, $ramen_type, $quantity, $total_price);
  
  if ($updateSuccessful) {
    echo "Order updated successfully!<br><br>";
    echo '<a href="../vieworder.php?customer_id=' . urlencode($customer_id) . '">Return to View Order</a>';
    exit();
  } else {
      echo "Error updating order.";
  }
}


if (isset($_POST['deleteOrderBtn'])) {
  $order_id = $_GET['order_id'];
  $customer_id = $_GET['customer_id'];
  $deleteSuccessful = deleteOrders($pdo, $order_id);
  if ($deleteSuccessful) { 
    echo 'Order deleted successfully!<br><br>';
    echo '<a href="../vieworder.php?customer_id=' . urlencode($customer_id) . '">Return to View Order</a>';
    exit();
  } else {
    echo 'Failed to delete order!';
  }
}
?>