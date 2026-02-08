<?php

session_start();

require_once __DIR__ . '/../app/libs/Auth.php';
require_once __DIR__ . '/../app/libs/Router.php';

$router = new Router();
$router->run();