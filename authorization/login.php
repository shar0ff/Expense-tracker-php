<?php 

    /**
    * User login script.
    *
    * This script handles user login requests. It expects an email and password via a POST request.
    * If the credentials are valid, it starts a session for the user and returns a success message.
    * Otherwise, it returns an appropriate HTTP error code and message.
    */

    session_start();
    require '../database/database.php';

    /**
    * Sends an HTTP response with a specified status code and a JSON-encoded message.
    *
    * @param int $statusCode The HTTP status code to set for the response.
    * @param mixed $message The message to encode as JSON and send in the response body.
    */
    function respondWithJson($statusCode, $message)
    {
        http_response_code($statusCode);
        echo json_encode($message);
        exit(); 
    }   
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        /**
        * @var string $email The user-provided email address.
        */
        $email = trim($_POST['email'] ?? '');

        /**
        * @var string $password The user-provided password.
        */
        $password = trim($_POST['password'] ?? '');

        /**
        * Validate that both email and password fields are provided.
        */
        if (empty($password) || empty($email)) {
            respondWithJson(400, ["error" => "Username and password are required."]);
        }

        /**
        * Validate the format of the email address.
        */
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            respondWithJson(400, ["error" => "Invalid email format."]);
        }

        /**
        * Prepare a SQL statement to select the user by email.
        * 
        * @var PDOStatement $query A prepared statement to fetch user information.
        */
        $query = $pdo->prepare("SELECT * FROM User WHERE email = :email");
        $query->execute([':email' => $email]);

        /**
        * @var array|null $user The fetched user record as an associative array, or null if not found.
        */
        $user = $query->fetch();

        /**
        * Verify that a user was found and that the provided password matches the stored hash.
        */
        if (!$user || !password_verify($password, $user['password'])) {
            respondWithJson(400, ["error" => "Invalid username or password."]);
        }
        
        /**
        * Store user session data after successful login.
        *
        * @var int    $user['id']   The user's unique identifier.
        * @var string $user['role'] The user's role within the application.
        */
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        
        respondWithJson(200, ["message" => "Login successful."]);
    }
?>