<?php

require_once 'vendor/autoload.php';

use Framework\HTTP\Request;

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/books?page=2';

$request = Request::fromGlobals();

var_dump($request->getMethod());
var_dump($request->getUri());
var_dump($request->getUri()->getPath());