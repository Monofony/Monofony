<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

if (method_exists(Dotenv::class, 'bootEnv')) {
    require dirname(__DIR__).'/vendor/autoload.php';

    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
} else {
    require dirname(__DIR__).'/config/bootstrap.php';
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
