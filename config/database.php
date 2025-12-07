<?php
/**
 * Database Configuration
 * Provides database connection using PDO with singleton pattern
 * 
 * @return PDO Database connection instance
 * @throws Exception If environment variables are not set
 */

use Dotenv\Dotenv;

function db() {
    // Use static variable to maintain single connection instance (singleton pattern)
    static $pdo = null;
    
    // Return existing connection if available
    if ($pdo) {
        return $pdo;
    }

    // Load environment variables
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    
    // Ensure required environment variables are set
    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER']);

    // Get database configuration from environment variables
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $dbname = $_ENV['DB_NAME'] ?? 'event_ticketing';
    $user = $_ENV['DB_USER'] ?? 'root';
    $pass = $_ENV['DB_PASS'] ?? 'mysql';

    // Validate required environment variables
    if (empty($host) || empty($dbname) || empty($user)) {
        throw new Exception('Database configuration is incomplete. Please check your .env file.');
    }

    // Create Data Source Name (DSN) for PDO connection
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    
    // PDO connection options
    $opts = [
        // Throw exceptions on errors for better error handling
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Return associative arrays by default
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Disable prepared statement emulation for better security
        PDO::ATTR_EMULATE_PREPARES => false,
        // Set connection timeout to 5 seconds
        PDO::ATTR_TIMEOUT => 5,
    ];
    
    try {
        // Create and return PDO connection instance
        $pdo = new PDO($dsn, $user, $pass, $opts);
        return $pdo;
    } catch (PDOException $e) {
        // Log the error and throw a generic message in production
        error_log('Database connection failed: ' . $e->getMessage());
        throw new Exception('Could not connect to the database. Please check your configuration.');
    }
}