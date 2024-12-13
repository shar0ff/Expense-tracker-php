<?php

    /**
    * User registration script.
    *
    * This script handles user registration by validating input, checking if the user already exists,
    * and inserting a new record into the database if all criteria are met. Responses are returned
    * as JSON for easy handling by a front-end.
    */

    session_start();

    require '../database/database.php';

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
            respond_with_errors(400, $errors);
        }

        /**
        * Create a secure password hash using a recommended algorithm (e.g., bcrypt).
        *
        * @var string $password_hash The hashed password.
        */
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        /**
        * Handles the user registration process and responds accordingly.
        *
        * @param PDO $pdo The PDO instance for database operations.
        * @param string $password_hash The hashed password of the user.
        * @param string $email The email address of the user.
        */
        if (register_user($pdo, $password_hash, $email)) {
            respond_with_message("User registered successfully.");
        } else {
            // If insertion failed for an unexpected reason, return a 500 error.
            respond_with_errors(500, ["User registration failed."]);
        }
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

        if (user_exists($pdo, 'email', $email)) {
            $errors[] = 'Email already registered.';
        }
    
        return $errors;
    }    

    /**
    * Checks if a user exists in the database based on a specified field and value.
    *
    * @param PDO $pdo The PDO instance for database operations.
    * @param string $field The database field to check (e.g., "email").
    * @param string $value The value to look for in the specified field.
    *
    * @return bool Returns true if the user exists, false otherwise.
    */
    function user_exists($pdo, $field, $value) {
        $query = $pdo->prepare("SELECT COUNT(*) FROM User WHERE $field = :field");
        $query->execute([':field' => $field]);
        return $query->fetchColumn() > 0;
    }

    /**
    * Registers a new user in the database.
    *
    * @param PDO $pdo The PDO instance for database operations.
    * @param string $password_hash The hashed password of the user.
    * @param string $email The email address of the user.
    *
    * @return bool Returns true if the user was successfully registered, false otherwise.
    */
    function register_user($pdo, $password_hash, $email) {
        $query = $pdo->prepare("INSERT INTO User (password, email) VALUES (:password, :email)");
        return $query->execute([':password' => $password_hash,
                                ':email' => $email]);
    }

    /**
    * Sends an HTTP response with a specified status code and a JSON-encoded array of errors.
    *
    * @param int $status_code The HTTP status code to set for the response.
    * @param array $errors The array of error messages to encode as JSON.
    */
    function respond_with_errors($status_code, $errors) {
        http_response_code($status_code);
        echo json_encode(["errors" => $errors]);
        exit;
    }

    /**
    * Sends a JSON-encoded success message to the client.
    *
    * @param string $message The success message to encode as JSON.
    */
    function respond_with_message($message) {
        echo json_encode(["message" => $message]);
        exit;
    }

?>