<?php declare(strict_types = 1);

namespace NoFramework;

use Sabre\HTTP;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
$environment = 'development';

/**
 * Error hanlder register
 */

$whoops = new \Whoops\Run;

if($environment !== 'production'){
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else{
    $whoops->pushHandler(function ($e){
        echo 'Todo: error handler
         handler';
    });
 }
$whoops->register();



$request = HTTP\Sapi::getRequest();
$response = new HTTP\Response();


$routeDefinitionCallback = function (\FastRoute\RouteCollector $r) {
    $routes = include('Routes.php');
    
    foreach ($routes as $route) {

        $r->addRoute($route[0], $route[1], $route[2]);
    }
};



$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());

switch ($routeInfo[0]) {

    case \FastRoute\Dispatcher::NOT_FOUND:
        // handle 404

        $response->setStatus(404);
        break;
        
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        // handle 405

        $response->setStatus(405);
        break;

    case \FastRoute\Dispatcher::FOUND:
        // handle 200
        
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];
        
        $class = new $className($response);
        $class->$method($vars);
        break;
}



HTTP\Sapi::sendResponse($response);