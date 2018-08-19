<?php

namespace DShumkov\MagicNumbers;

use DShumkov\Micra\Router\Router;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/*
 * Autoloader
 */

define('VENDOR', __DIR__ . '/../vendor');
define('VIEWS_DIR', __DIR__ . '/../src/views/');
require VENDOR . '/autoload.php';

$router = new Router();
$request = Request::createFromGlobals();

$router->get('/', function () use ($request) {
    $template = VIEWS_DIR . 'main.html';
    if (file_exists($template)) {
        $response = new Response(file_get_contents($template));
        $response->send();
    } else {
        $response = new Response('Template error');
        $response->setStatusCode(500);
        $response->send();
    }
});

$router->get('/api/calc/evens', function () use ($request) {
    $response = new JsonResponse();

    $num = validate($request);
    if (false === $num) {
        $response->setStatusCode(400);
        $response->setData([
            'message' => 'Invalid input',
        ]);
        $response->send();
        return;
    }
    $result = 0;
    $digits = array_map('intval', str_split($num));

    for ($i = 1; $i < count($digits); $i = $i + 2) {
        $result = $result + $digits[$i];
    }

    $response->setData([
        'result' => $result,
    ]);

    $response->send();

});
$router->get('/api/calc/odds', function () use ($request) {
    $response = new JsonResponse();

    $num = validate($request);
    if (false === $num) {
        $response->setStatusCode(400);
        $response->setData([
            'message' => 'Invalid input',
        ]);
        $response->send();
        return;

    }
    $result = 0;
    $digits = array_map('intval', str_split($num));

    for ($i = 0; $i < count($digits); $i = $i + 2) {
        $result = $result + $digits[$i];
    }

    $response->setData([
        'result' => $result,
    ]);
    $response->send();

});
$router->get('/api/calc/row', function () use ($request) {
    $response = new JsonResponse();

    $num = validate($request);
    if (false === $num) {
        $response->setStatusCode(400);
        $response->setData([
            'message' => 'Invalid input',
        ]);
        $response->send();

        return;

    }
    $result = 0;
    for ($i = 0; $i <= $num; $i++) {
        $result = $result + $i;
    }

    $response->setData([
        'result' => $result,
    ]);

    $response->send();

});

function validate($req)
{
    return filter_var(
        $req->get('num'),
        FILTER_VALIDATE_INT,
        ['options' => [
            'default' => false,
            'min_range' => 0],
        ]
    );

}

$router->setError(404, function () use ($request) {
    $response = new Response('');
    $response->setStatusCode(404);
    $response->send();
});

$router->run();

function getEnv()
{
    switch (gethostname()) {
        case "live":
            return "production";
            break;
        case "staging":
            return "staging";
            break;
        default:
            return "local";
    }
};
