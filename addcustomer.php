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
    <link rel="stylesheet" href="child.css">
    <title>RamenLamig Homepage</title>
</head>
<body>
    <div class="wrapper">
        <h1><?php echo isset($_GET['customer_id']) ? 'Edit User' : 'Add User'; ?></h1>
        <div class="container">
            <?php
            // Ensure customer_id is set and fetch customer details if editing
            $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;
            $getCustomerByID = $customer_id ? getCustomerByID($pdo, $customer_id) : null;

            if ($customer_id && $getCustomerByID === null) {
                echo "<p>No customer found with this ID.</p>";
            } else {
            ?>
            <form action="core/handleForms.php" method="POST">
                <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer_id); ?>">
                <input type="hidden" name="added_by" value="<?php echo htmlspecialchars($_SESSION['username']); ?>"> <!-- Use active session username -->

                <p>
                    <label for="customer_name">Customer Name</label>
                    <input type="text" name="customer_name" id="customer_name" value="<?php echo htmlspecialchars($getCustomerByID['customer_name'] ?? ''); ?>" required>
                </p>

                <p>
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo htmlspecialchars($getCustomerByID['age'] ?? ''); ?>" required>
                </p>

                <p>
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo htmlspecialchars($getCustomerByID['date_of_birth'] ?? ''); ?>" required>
                </p>

                <p>
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($getCustomerByID['address'] ?? ''); ?>" required>
                </p>

                <p>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($getCustomerByID['username'] ?? ''); ?>" required>
                </p>

                <p>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($getCustomerByID['email'] ?? ''); ?>" required>
                </p>

                <p>
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($getCustomerByID['phone'] ?? ''); ?>" required>
                </p>
                
                <button class="btn" type="submit" name="submitCustomerButton">Submit</button>
            </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>
