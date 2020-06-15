<?php
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__); // get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Authentication', 'action' => 'index']);
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('user/{controller}/{action}', ['namespace' => 'User']);
$router->add('user/{controller}/{id:\d+}/{action}', ['namespace' => 'User']);
$router->add('user/{controller}', ['namespace' => 'User', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');

if (array_key_exists('QUERY_STRING', $_SERVER)) {
    $router->dispatch($_SERVER['QUERY_STRING']);
} else {
    $router->dispatch('');
}