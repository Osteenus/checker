<?php

// FRONT CONTROLLER
// Общие настройки
use App\components\Router;

ini_set('display_errors',1);

session_start();

// Подключение файлов системы
define('ROOT', dirname(__FILE__));
include(ROOT.'/vendor/Autoload.php');
require_once(ROOT . '/App/Components/Router.php');

// Вызов Router
$router = new Router();
$router->run();
