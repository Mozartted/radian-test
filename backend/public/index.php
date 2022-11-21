<?php
declare(strict_types=1);

use DI\ContainerBuilder;
// use ExampleApp\HelloWorld;
// use ExampleApp\MainPage;
use Radian\CsvManager;
use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;

use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
    CsvManager::class => create(CsvManager::class)->constructor(get('Response')),
    'Response' => function() {
        return new Response();
    },
]);

/** @noinspection PhpUnhandledExceptionInspection */
$container = $containerBuilder->build();

$routes = simpleDispatcher(function (RouteCollector $r) {
    $r->get('/items', [CsvManager::class, 'getItems']);
    $r->put('/items/{id}', [CsvManager::class, 'updateItem']);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

/** @noinspection PhpUnhandledExceptionInspection */
$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();
/** @noinspection PhpVoidFunctionResultUsedInspection */
return $emitter->emit($response);
