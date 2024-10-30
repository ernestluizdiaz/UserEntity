<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="child.css">
    <title>Login</title>
</head>
<body>
  <div class="wrapper">
    <h1>Login</h1>
    <div class="container">
    <!-- Check for error messages -->
    <?php if (isset($_GET['error'])): ?>
        <div class="error-message">
            <?php 
                if ($_GET['error'] === 'not_found') {
                    echo "Username not found! Please <a href='register.php'>register first</a>.";
                } elseif ($_GET['error'] === 'invalid_password') {
                    echo "Invalid password! Please try again.";
                }
            ?>
        </div>
    <?php endif; ?>

    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </p>

        <button type="submit" name="loginCustomerButton">Login</button>

        <!-- Create Account button -->
    <p>Don't have an account? <a href="register.php" class="create-account-button">Create Account</a></p>
    </form>
</div>
  </div>
</body>
</html>
