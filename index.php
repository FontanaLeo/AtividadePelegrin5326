<?php
require_once __DIR__ . '/vendor/autoload.php';

use Aura\Di\ContainerBuilder;
use Aura\Router\RouterContainer;
use Laminas\Diactoros\ServerRequestFactory;

$builder = new ContainerBuilder();
$di = $builder->newInstance();
$di->set('home_controller', $di->lazyNew(\App\HomeController::class));

$request = ServerRequestFactory::fromGlobals();

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

$map->get('hello', '/hello', function ($request) use ($di) {
    $params = $request->getQueryParams();
    $name = $params['name'] ?? 'World';
    
    $controller = $di->get('home_controller');
    return $controller->hello($name);
});

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if ($route) {
    $callable = $route->handler;
    $response = $callable($request);
} else {
    $response = new \Symfony\Component\HttpFoundation\Response('Página não encontrada', 404);
}

$response->send();