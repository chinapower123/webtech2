<?php

require_once __DIR__ . '/vendor/autoload.php';

use Framework\Http\Request;
use Framework\DependencyInjection\Container;
use Framework\Database\Connection;

$dbPath = __DIR__ . '/database.sqlite';
$db = new Connection($dbPath);
$container = new Container();

$kernel = $container->createKernel();
$request = Request::fromGlobals();
$response = $kernel->handle($request);

echo $response->getBody();