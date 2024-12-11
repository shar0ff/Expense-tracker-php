<?php

    /**
    * User registration script.
    *
    * This script handles user registration by validating input, checking if the user already exists,
    * and inserting a new record into the database if all criteria are met. Responses are returned
    * as JSON for easy handling by a front-end.
    */

    session_start();

    require './database/database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        /**
        * @var string $email User-provided email address.
        */
        $email = validate_input($_POST['email']);

        /**
        * @var string $password User-provided password (or empty string if not provided).
        */
        $password = $_POST['password'] ?? '';

        /**
        * Validate the user’s input.
        *
        * @var array<string> $errors An array of validation error messages (if any).
        */
        $errors = validate_registration($email, $password);

        // If no validation errors, check if the user already exists.
        if (empty($errors)) {
            $errors = check_existing_user($pdo, $email);
        }

        // If there are any errors (either from validation or existing user checks), return them.
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(["errors" => $errors]);
            exit;
        }

        /**
        * Create a secure password hash using a recommended algorithm (e.g., bcrypt).
        *
        * @var string $password_hash The hashed password.
        */
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        /**
        * Prepare and execute an INSERT query to add the user to the database.
        *
        * @var PDOStatement $query A prepared statement to insert the new user.
        */
        $query = $pdo->prepare("INSERT INTO User (email, password) VALUES (:email, :password)");
        if ($query->execute([':email' => $email,
                            ':password' => $password_hash])) {
            // If the user was successfully registered.
            echo json_encode(["message" => "User registered successfully."]);
            exit();
        }

        // If insertion failed for an unexpected reason, return a 500 error.
        http_response_code(500);
        echo json_encode(["errors" => ["User registration failed."]]);
    }

    
    /**
    * Trim and sanitize user input.
    *
    * @param mixed $data The input data.
    *
    * @return string The trimmed string or an empty string if null.
    */
    function validate_input($data) {
        return trim($data ?? '');
    }

    /**
    * Validate the registration parameters.
    *
    * @param string $email    The user’s email address.
    * @param string $password The user’s password.
    *
    * @return array<string> An array of error messages. Empty if no errors.
    */
    function validate_registration($email, $password) {
        $errors = [];

        if (empty($email)) {
            $errors[] = 'Email is required.';
        } 

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }    
        
        if (empty($password)) {
            $errors[] = 'Password is required.';
        }

        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        
        // Require uppercase, lowercase, and number
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter, one lowercase letter, and one number.";
        }
        
        return $errors;
    }

    /**
    * Check if the user already exists in the database.
    *
    * @param PDO    $pdo   The PDO database connection object.
    * @param string $email The email address to check for existence.
    *
    * @return array<string> An array of errors. If the user exists, returns an error message;
    *                       otherwise, returns an empty array.
    */
    function check_existing_user($pdo, $email) {
        $errors = [];

        $query = $pdo->prepare("SELECT COUNT(*) FROM User WHERE email = :email");
        $query->execute([':email' => $email]);
        if ($query->fetchColumn() > 0) {
            $errors[] = 'Email already registered.';
        }
        
        return $errors;
    }    
?>