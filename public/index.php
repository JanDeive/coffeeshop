<?php
/**
 * Entry point of the application.
 * 
 * This script initializes the session, imports necessary files, and handles routing.
 * It ensures that users are redirected to the login page if they are not logged in
 * and are trying to access non-guest routes.
 * 
 * @package App
 */

// Start the session at the very beginning of the application
session_start();

// Import necessary files
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../includes/autoload.php";
require_once __DIR__ . "/../includes/global_functions.php";

use App\Models\User;
use App\Controllers\Controller;
use App\Controllers\ErrorController;

$uri = $_SERVER["REQUEST_URI"];

// Clean URL to get action
$uri = str_replace(BASE_URL, "", parse_url($uri)['path']);

$routes = require_once(__DIR__ . "/../config/routes.php");

$guestRoutes = [
    '/login',
    '/register',
    // Add more routes available to guests
];

// Check if the user is not accessing pages for non-guests
if (!in_array($uri, $guestRoutes)) {
    // Check if user is not logged in and is accessing non-API route
    if (!str_starts_with($uri, '/api') && !User::isLoggedIn()) {
        Controller::redirect('/login');
        exit;
    }
}

if (array_key_exists($uri, $routes)) {
    // Check that $routes[$uri] contains exactly two elements
    if (count($routes[$uri]) === 2) {

        // Extract class and action
        $controllerClass = $routes[$uri][0];
        $action = $routes[$uri][1];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // Create a new instance of the controller class
        $controller = new $controllerClass();

        $params = [];

        // Collect the appropriate request parameters based on the request method
        if ($requestMethod === 'GET') {
            $params = $_GET; // Collect parameters from the query string
        } elseif ($requestMethod === 'POST') {
            $params = $_POST; // Collect parameters from the POST body
        }

        // Add $_FILES values 
        $params = array_merge($params, $_FILES);

        // Add decoded JSON data for API requests
        if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
            // Get the raw JSON input
            $rawData = file_get_contents('php://input');
            // If the request has content
            if (!empty($rawData)) { 
                // Decode the JSON into an associative array
                $data = json_decode($rawData, true);

                // Add it to $params
                $params = array_merge($params, $data);
            }
        }

        // Call the Controller function with collected parameters
        call_user_func([$controller, $action], $params);

    } else {
        // Handle invalid route format (e.g., missing class or action)
        $error = new ErrorController();
        $error->internalServerError();
    }
} else {
    $error = new ErrorController();
    $error->notFound();
}
