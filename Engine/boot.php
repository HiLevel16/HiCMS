<?php 

require 'defines.php';

if (DEBUG == 1)
error_reporting(E_ALL);

\Engine\Cms::defineEnvironment();

$router = new Engine\Core\Route\Router();

$cms = new Engine\Cms($router);