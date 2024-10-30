<!-- Purpose: This file contains the functions that interact with the database. -->

<?php

require_once 'dbConfig.php';

function loginCustomer($pdo, $username, $password) {
  // Fetch the customer record by username
  $customer = getCustomerByUsername($pdo, $username);
  
  // Check if the customer exists
  if ($customer) {
      // Verify the hashed password
      if (password_verify($password, $customer['password'])) {
          // Start the session and set user data
          session_start();
          $_SESSION['user_id'] = $customer['customer_id'];
          $_SESSION['username'] = $customer['username'];
          
          // Redirect to homepage or dashboard
          header('Location: ../index.php');
          echo "test";
          exit();
      } else {
          // Invalid password
          return 'invalid_password';
      }
  } else {
      // Username not found
      return 'not_found';
  }
}

// Function to check if username or email already exists
function checkUserExists($pdo, $username, $email) {
  $stmt = $pdo->prepare("SELECT * FROM customers WHERE username = :username OR email = :email");
  $stmt->execute(['username' => $username, 'email' => $email]);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to register customer
function registerCustomer($pdo, $customer_name, $email, $phone, $date_of_birth, $age, $address, $username, $hashed_password, $added_by) {
  try {
      $stmt = $pdo->prepare("INSERT INTO customers (customer_name, email, phone, date_of_birth, age, address, username, password, added_by) VALUES (:customer_name, :email, :phone, :date_of_birth, :age, :address, :username, :password, :added_by)");
      $stmt->execute([
          ':customer_name' => $customer_name,
          ':email' => $email,
          ':phone' => $phone,
          ':date_of_birth' => $date_of_birth,
          ':age' => $age,
          ':address' => $address,
          ':username' => $username,
          ':password' => $hashed_password,
          ':added_by' => $added_by 
      ]);
      return true;
  } catch (PDOException $e) {
      
      return false;
  }
}


// Function to get a customer by username
function getCustomerByUsername($pdo, $username) {
  $sql = "SELECT * FROM customers WHERE username = ?";
  $stmt = $pdo->prepare($sql);
  if ($stmt->execute(array($username))) {
      return $stmt->fetch();
  }
  return false;
}

// Function to insernt New Customer in Registration
function insertNewCustomer($pdo, $customer_name, $email, $phone, $date_of_birth, $age, $address, $username, $added_by) {
  if (empty($customer_name) || empty($email) || empty($phone)) {
      throw new Exception("Required fields are missing.");
  }
  $stmt = $pdo->prepare("INSERT INTO customers (customer_name, email, phone, date_of_birth, age, address, username, added_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  if (!$stmt->execute([$customer_name, $email, $phone, $date_of_birth, $age, $address, $username, $added_by])) {
      throw new Exception("Failed to insert new customer.");
  }
  return true;
}


// Function for inserting customers with username and password
function insertFullCustomer($pdo, $customer_name, $email, $phone, $created_at, $date_of_birth, $age, $address, $username, $hashed_password) {
  $sql = "INSERT INTO customers (customer_name, email, phone, created_at, date_of_birth, age, address, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $executeQuery = $stmt->execute(array($customer_name, $email, $phone, $created_at, $date_of_birth, $age, $address, $username, $hashed_password));
  return $executeQuery; 
}


// Function to add a new customer into the database
function insertCustomers ($pdo,  $customer_name, $email ,$phone, $created_at) {
  $sql = "INSERT INTO customers (customer_name, email, phone, created_at) VALUES (?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $executeQuery = $stmt->execute(array($customer_name, $email, $phone, $created_at));
  if ($executeQuery) {
    return true;
  }
}

// Function to show all customers from the index
function getAllCustomers($pdo) {
  $sql = "SELECT * FROM customers";
  $stmt = $pdo->prepare($sql);
  $executeQuery = $stmt->execute();
  if ($executeQuery) {
      return $stmt->fetchAll(); 
  }
  return []; 
}

// Function to get a customer by ID 
function getCustomerByID($pdo, $customer_id) {
  $sql = "SELECT * FROM customers WHERE customer_id = ?";
  $stmt = $pdo->prepare($sql);
  if ($stmt->execute(array($customer_id))) {
      return $stmt->fetch(); 
  } else {
      return false; 
  }
}

// Function to update a customer from the databse
function updateCustomers($pdo, $customer_id, $customer_name, $email, $phone, $date_of_birth, $age, $address, $username) {
  $sql = "UPDATE customers 
          SET customer_name = ?, email = ?, phone = ?,
              date_of_birth = ?, age = ?, address = ?, 
              username = ? 
          WHERE customer_id = ?";
  
  $stmt = $pdo->prepare($sql);
  $executeQuery = $stmt->execute(array($customer_name, $email, $phone, $date_of_birth, $age, $address, $username, $customer_id));
  return $executeQuery; 
}


// Function to delete a customer from the database
function deleteCustomers($pdo, $customer_id) {
  $sql = "DELETE FROM customers WHERE customer_id = ?";
  $stmt = $pdo->prepare($sql);
  $executeQuery = $stmt->execute(array($customer_id));
  return $executeQuery; 
}

// Function to show all orders from the table
function getOrderByCustomer($pdo, $customer_id) {
  $sql = "SELECT 
      orders.order_id AS order_id,
      orders.ramen_type AS ramen_type,
      orders.quantity AS quantity,
      orders.total_price AS total_price,
      CONCAT(customers.customer_name, ' ', customers.customer_id) AS customer_order
  FROM orders
  JOIN customers ON orders.customer_id = customers.customer_id
  WHERE customers.customer_id = ?
  GROUP BY orders.order_id"; 
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$customer_id]);
  return $stmt->fetchAll(); 
}

// Function to add orders from the database
function insertOrders(PDO $pdo, $quantity, $ramen_type, $customer_id, $total_price) {
  $sql = "INSERT INTO orders (quantity, ramen_type, customer_id, total_price) VALUES (?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $executeQuery = $stmt->execute(array($quantity, $ramen_type, $customer_id, $total_price));
  if ($executeQuery) {
    return true;
  } else {
    return false;
  }
}

// Function to show all orders from the table
function getOrderbyID($pdo, $order_id) {
    $sql = "SELECT 
        orders.order_id AS order_id,
        orders.ramen_type AS ramen_type,
        orders.quantity AS quantity,
        orders.total_price AS total_price,
        CONCAT(customers.customer_name, ' ', customers.customer_id) AS customer_order
    FROM orders
    JOIN customers ON orders.customer_id = customers.customer_id
    WHERE orders.order_id = ?
    GROUP BY orders.order_id"; 

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(array($order_id));
    if ($executeQuery) {
        return $stmt->fetch(); 
    }
}

// Function to update orders from the database
function updateOrders($pdo, $order_id, $ramen_type, $quantity, $total_price) {
  $sql = "UPDATE orders SET ramen_type = ?, quantity = ?, total_price = ? WHERE order_id = ?";
  $stmt = $pdo->prepare($sql);
  $executeQuery = $stmt->execute(array($ramen_type, $quantity, $total_price, $order_id));  
  if ($executeQuery) {
      return true;
  }
  return false; 
}

// Function to delete orders from the database
function deleteOrders ($pdo, $order_id) {
  $sql = "DELETE FROM orders WHERE order_id = ?";
  $stmt = $pdo->prepare($sql);
  $executeQuery = $stmt->execute(array($order_id));
  if ($executeQuery) {
    return true;
  }
}
?>