<?php
class Database {
    private static $connection = null;

    public static function getConnection() {
        // Check if a connection already exists
        if (self::$connection === null) {
            // Load the configuration
            $config = include __DIR__ . '/../../config/config.php';
            
            // Try to connect
            try {
                self::$connection = new PDO(
                    "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
                    $config['db']['user'],
                    $config['db']['password']
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Handle connection error
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
?>
