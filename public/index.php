<?php
/**
 * Main entry point for the Event Ticketing Application
 * Handles routing and initializes the application
 * 
 * @version 1.0.0
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


// Set default timezone
date_default_timezone_set('UTC');

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Error reporting based on environment
if ($_ENV['APP_ENV'] === 'development' || ($_ENV['APP_DEBUG'] ?? false)) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// Start session with secure settings
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_samesite' => 'Lax',
    'use_strict_mode' => true
]);

// Load application configuration and dependencies
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../libs/autoload.php';
require_once __DIR__ . '/../libs/helpers.php';

// Simple router using ?page= query parameter
$page = $_GET['page'] ?? 'home';

// Route requests to appropriate controllers
switch ($page) {
    case 'register':
        require __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController())->register();
        break;

    case 'login':
        require __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController())->login();
        break;

    case 'logout':
        require __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController())->logout();
        break;

    case 'event':
        require __DIR__ . '/../app/controllers/EventController.php';
        (new EventController())->show($_GET['id'] ?? null);
        break;

    case 'buy':
        require __DIR__ . '/../app/controllers/OrderController.php';
        (new OrderController())->buy($_GET['id'] ?? null);
        break;

    case 'order':
        require __DIR__ . '/../app/controllers/OrderController.php';
        (new OrderController())->show($_GET['id'] ?? null);
        break;

    case 'my-orders':
        require __DIR__ . '/../app/controllers/OrderController.php';
        (new OrderController())->myOrders();
        break;

    default:
        require __DIR__ . '/../app/controllers/EventController.php';
        (new EventController())->home();
}
