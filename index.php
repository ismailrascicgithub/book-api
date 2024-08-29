<?php

require_once __DIR__ . '/config/bootstrap.php';

$router = new Router();

require_once __DIR__ . '/api/routes.php';

$router->run();
