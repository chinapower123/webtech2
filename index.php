<?php

require_once __DIR__ . '/vendor/autoload.php';

use Framework\Http\Request;
use Framework\Kernel\Kernel;

$kernel = new Kernel();
$request = Request::fromGlobals();
$response = $kernel->handle($request);

echo $response->getBody();
