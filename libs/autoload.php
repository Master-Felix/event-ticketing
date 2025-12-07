<?php
/**
 * Simple autoloader for the event ticketing application
 * Automatically loads classes from their respective directories
 */

spl_autoload_register(function ($class) {
    // Define base directory
    $baseDir = __DIR__ . '/../';
    
    // Map class names to directories
    $directories = [
        'app/controllers/',
        'models/',
        'libs/'
    ];
    
    // Try to find the class in each directory
    foreach ($directories as $dir) {
        $file = $baseDir . $dir . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

