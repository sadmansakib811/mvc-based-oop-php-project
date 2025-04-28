<?php
// Define the environment.
if (in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1'])) {
    define('ENVIRONMENT', 'development');
} else {
    define('ENVIRONMENT', 'production');
}

// Error reporting configuration.
if (ENVIRONMENT === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //Development database connection:
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'mvc1');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('PUBLIC_UPLOADS', 'uploads/');

} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
    // production Database details:
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'mvc2');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('PUBLIC_UPLOADS', 'uploads/');

}

// Database configuration.

