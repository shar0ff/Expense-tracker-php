<?php

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title> Expense Tracker | Sign Up </title>
        <link rel="stylesheet" href="./styles/index.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
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
                    <a href="#">  Log in </a>
                </div>
            </form>
        </div>
        <script src="#"></script>
    </body>
</html>