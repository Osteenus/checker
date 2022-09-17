<?php

require_once __DIR__ . '/database/Database.php';

// print_r($_SERVER['REQUEST_URI']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$segments = explode('/', trim($uri, '/'));
$method = $_SERVER['REQUEST_METHOD'];

$routes = include_once __DIR__ . '/routes/api.php';

$database = new Database();
$connection = $database->getConnection();

foreach($routes as $route => $value) {
    print_r($route['pattern'] == $segments[0]);
    if ($route['pattern'] == $segments[0] && $route['method'] == $method) {
        echo "Route found";
    }
};

echo phpinfo();

// echo '<pre>';
// print_r($routes);
// echo '</pre>';

// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';
