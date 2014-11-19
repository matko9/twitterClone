<?php
use Phalcon\DI,
  Phalcon\DI\FactoryDefault;

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT_PATH', __DIR__);
define('PATH_LIBRARY', __DIR__ . '/../app/library/');
define('PATH_SERVICES', __DIR__ . '/../app/services/');
define('PATH_RESOURCES', __DIR__ . '/../app/resources/');

set_include_path(
  ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

// required for phalcon/incubator
include __DIR__ . "/../vendor/autoload.php";

// use the application autoloader to autoload the classes
// autoload the dependencies found in composer
$loader = new \Phalcon\Loader();

$loader->registerDirs(array(
  ROOT_PATH,
  '../apps/controllers/',
  '../apps/models/',
  '../apps/forms/',
  '../apps/library/'
));

$loader->registerNamespaces(
  array(
    'TwitterClone\Forms' => "../apps/forms/",
    'TwitterClone\Models' => "../apps/models/",
    'TwitterClone\Auth' => "../apps/library/Auth",
  )
);

$loader->register();
