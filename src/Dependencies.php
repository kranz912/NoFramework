<?php declare(strict_types=1);

use Sabre\HTTP;

$injector =  new \Auryn\Injector;

$request = HTTP\Sapi::getRequest();
$response = new HTTP\Response();

$injector->share($request);
$injector->share($response);




return $injector;