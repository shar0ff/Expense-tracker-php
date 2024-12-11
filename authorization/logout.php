<?php 

    /**
    * User logout script.
    *
    * This script handles user logout requests. It destroys the current session,
    * removing any associated user data, and returns a JSON response confirming
    * that the logout was successful.
    */

    /**
    * Starts a new session or resumes the existing session.
    * 
    * @return void
    */
    session_start();

    /**
    * Destroys all data registered to a session.
    * 
    * @return void
    */
    session_destroy();

    /**
    * Outputs a JSON encoded message indicating successful logout.
    * 
    * @return void
    */
    echo json_encode(["message" => "Logout successful."]);
?>