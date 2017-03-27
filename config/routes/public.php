<?php

/**
 * Public routes.
 */


/**
 * Index page.
 */
$app->router->add('', function () use ($app) {
    default_layout('Start', 'index');
});


/**
 * About page.
 */
$app->router->add('about', function () use ($app) {
    default_layout('Om kursen', ['about', 'byline']);
});


/**
 * Report page.
 */
$app->router->add('report', function () use ($app) {
    default_layout('Redovisning', 'report');
});


/**
 * Test page.
 */
$app->router->add('test/test1', function () use ($app) {
    /*default_layout('Test', [
        [
            'path' => 'incl/flash',
            'data' => [
                'img' => 'bg-main.png'
            ]
        ],
        'test'
    ]);*/
    default_layout('Test', 'test');
});


/**
 * Server data as JSON.
 */
$app->router->add('server', function () use ($app) {
    $app->response->sendJson($_SERVER);
});
