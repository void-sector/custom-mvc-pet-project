<?php

session_start();

defined('ROOT') || define('ROOT', realpath(dirname(__FILE__) . '/../'));
defined('LIBRARY_PATH') || define('LIBRARY_PATH', realpath(dirname(__FILE__) . '/../library'));
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

include(LIBRARY_PATH . '/App/Autoloader.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    \App\Cache::load();
}

$startTime = microtime(true);

$frontController = new App\FrontController(
    App\Config::getInstance(APPLICATION_PATH . '/configs/application.ini')
);

$frontController->run();
echo '<!-- ' . (microtime(true) - $startTime) . ' -->';