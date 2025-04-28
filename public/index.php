<?php
require_once __DIR__ . '/../App/core/config.php';
use Pecee\SimpleRouter\SimpleRouter;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

// Optional: Enable error display for debugging during development.
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// (If your project runs in a subfolder, you might need to adjust the URI manually)
// For example, if accessing via http://localhost/mvc_project/public/, you can strip the subfolder:
// $basePath = '/mvc_project/public';
// if (strpos($_SERVER['REQUEST_URI'], $basePath) === 0) {
//     $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($basePath));
// }
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// Set the default namespace for controllers.
SimpleRouter::setDefaultNamespace('\App\Controllers');

// Load the routes file.
require_once __DIR__ . '/../app/routes.php';

// Start the routing process.
SimpleRouter::start();
