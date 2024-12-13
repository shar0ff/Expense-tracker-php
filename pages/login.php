<?php 

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title> Log In | Expense Tracker </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles/index.css">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="wrapper">
            <div class="title"> Log In  </div>
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
                <div class="reset-link">
                    <a href="#"> Forgot password? </a>
                </div>
                <div class="input-field">
                    <input type="submit" value="Log In">
                </div>
                <div class="signup-link">
                    Not a member?
                    <a href="../pages/register.php">  Sign up now</a>
                </div>
            </form>
        </div>
        <script src="../scripts/user-service.js"></script>
        <script src="../scripts/login.js"></script>
        <script src="../scripts/common.js"></script>
        <script src="../scripts/navbar.js"></script>
    </body>
</html>