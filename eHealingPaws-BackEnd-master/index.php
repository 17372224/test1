<?php
header('X-Powered-By:BunnyFramework');
// change this value before final deployment
header("Access-Control-Allow-Origin: http://localhost:8000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Expose-Headers: *");
define('APP_PATH', __DIR__ . '/');
define('APP_DEBUG', true);
define("IN_TWIMI_PHP", "True", TRUE);
date_default_timezone_set('PRC');
require 'vendor/autoload.php';
(new BunnyPHP\BunnyPHP())->run();