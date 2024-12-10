<?php 
    /**
    * Database connection configuration and initialization.
    *
    * This script sets up the connection to the MySQL database using PDO.
    * It defines the database connection parameters and options, and attempts
    * to create a new PDO instance for database interaction.
    */

    /**
    * Database host.
    * @var string
    */
    $host = 'localhost';

    /**
    * Database name.
    * @var string
    */
    $dbname = 'expense_tracker_db';

    /**
    * Database user.
    * @var string
    */
    $user = 'root';

    /**
    * Database password.
    * @var string
    */
    $password = null;

    /**
    * Database charset.
    * @var string
    */
    $charset = 'utf8mb4';

    /**
    * PDO options for error handling, fetch mode, and prepared statements.
    * @var array
    */
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    // Try to connect
    try {
        /**
        * PDO instance for database connection.
        * @var PDO
        */
        $connection = new PDO(
            "mysql:host={$host};dbname={$dbname};charset={$charset}",
            $user,
            $password,
            $options
        );
    } catch (\PDOException $e) {
        /**
        * Exception handling for PDO connection errors.
        * Throws a new PDOException with the error message and code.
        * @throws \PDOException
        */
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
?>