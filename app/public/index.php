<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\PageController;
use App\Controllers\SearchController;
use App\Domain\Documents\DocumentRepositoryFactory;
use App\Domain\Documents\HeadlineExtractor;
use App\Markdown\ParserFactory;
use App\Services\Container;
use App\Services\FrontController;
use App\Services\RequestFactory;
use App\Services\Response;
use App\Services\ResponseFactory;
use App\Services\Router;
use App\Services\TemplateRenderer;

$startTime = microtime(true);

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container(
    require_once __DIR__ . '/../config.php',
);

$container
    ->define('RequestFactory', function (Container $container) {
        return new RequestFactory();
    })
    ->define('ResponseFactory', function (Container $container) {
        return new ResponseFactory();
    })
    ->define('TemplateRenderer', function (Container $container) {
        return new TemplateRenderer(
            $container->getConfig()['templates'],
            [
                '_link' => function (string $name, array $params = []) use ($container) {
                    return $container->get('Router')->link($name, $params);
                }
            ]
        );
    })
    ->define('MarkdownParser', function (Container $container) {
        return (new ParserFactory())->create();
    })
    ->define('HeadlineExtractor', function (Container $container) {
        return new HeadlineExtractor();
    })
    ->define('DocumentRepositoryFactory', function (Container $container) {
        return new DocumentRepositoryFactory(
            $container,
            $container->get('MarkdownParser'),
            $container->get('HeadlineExtractor')
        );
    })
    ->define('HomeController', function (Container $container) {
        return new HomeController(
            $container->get('TemplateRenderer'),
            $container->get('DocumentRepositoryFactory')
        );
    })
    ->define('PageController', function (Container $container) {
        return new PageController(
            $container->get('TemplateRenderer'),
            $container->get('DocumentRepositoryFactory')
        );
    })
    ->define('SearchController', function (Container $container) {
        return new SearchController(
            $container->get('TemplateRenderer'),
            $container->get('DocumentRepositoryFactory')
        );
    })
    ->define('Router', function (Container $container) {
        return new Router([
            'home'   => ['/', $container->get('HomeController'), ['default' => true]],
            'page'   => ['/page', $container->get('PageController')],
            'search' => ['/search', $container->get('SearchController')],
        ]);
    })
    ->define('FrontController', function (Container $container) {
        return new FrontController(
            $container->get('Router'),
            $container->get('ResponseFactory')
        );
    })
;


$request  = $container->get('RequestFactory')->createFromGlobals();
$response = $container->get('FrontController')->handle($request);
/** @var Response $response */
$response->send($startTime);
