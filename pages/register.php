<?php ?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title> Sign Up | Expense Tracker </title>
        <link rel="stylesheet" href="../styles/index.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="wrapper">
            <div class="title"> Sign Up  </div>
            <form action="#" method="POST">
                <div class="input-field">
                    <input type="text"  name="email" required>
                    <span class="error-message"></span>
                    <label> Email: </label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <span class="error-message"></span>
                    <label> Password: </label>
                </div>
                <div class="input-field">
                    <input type="password" name="password-confirmation" required>
                    <span class="error-message"></span>
                    <label> Confirm Password: </label>
                </div>
                <div class="input-field">
                    <input type="submit" value="Sign Up">
                </div>
                <div class="login-link">
                    Already have an account?
                    <a href="../pages/login.php">  Log in </a>
                </div>
            </form>
        </div>
        <script src="../scripts/user-service.js"></script>
        <script src="../scripts/register.js"></script>
        <script src="../scripts/common.js"></script>
        <script src="../scripts/navbar.js"></script>
    </body>
</html>