<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', '1');


// Define path to application directory
defined('PROJECT_ROOT')
|| define('PROJECT_ROOT', realpath(__DIR__ . '/../../'));

define('APP_ENVIRONMENT', 'testing');

$loader = require __DIR__ . '/../../vendor/autoload.php';

if (! isset($loader)) {
    throw new Exception('Unable to load autoload.php. Try running `php composer.phar install`');
}
