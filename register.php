<?php 
session_start(); // Start the session
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="child.css">
<title>Register</title>
<style>
    .wrapper {
    height: auto;
    }

    form {
    margin-bottom: 10px;
    }
</style>
</head>
<body>
<div class="wrapper" >
    <h1>Register</h1>
    <div class="container">
    <form action="core/handleForms.php" method="POST">

            <p>
                <label for="customer_name">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name" required>
            </p>
            <p>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </p>
            <p>
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" required>
            </p>
            <p>
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth" required>
            </p>
            <p>
                <label for="age">Age</label>
                <input type="number" name="age" id="age" required>
            </p>
            <p>
                <label for="address">Address</label>
                <input type="text" name="address" id="address" required>
            </p>
            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </p>
            <p>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </p>
            <button type="submit" name="registerCustomerButton">Register</button>
        </form>
    </div>
</div>
</body>
</html>
