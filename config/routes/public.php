<?php

/**
 * Public routes.
 */


/**
 * Index page.
 */
$app->router->add('', function () use ($app) {
    $app->defaultLayout('Start', 'index');
});


/**
 * About page.
 */
$app->router->add('about', function () use ($app) {
    $app->defaultLayout('Om webbplatsen', ['about', 'byline']);
});


/**
 * Report page.
 */
$app->router->add('report', function () use ($app) {
    $app->defaultLayout('Redovisning', 'report');
});


/**
 * Test page.
 */
$app->router->add('test/test1', function () use ($app) {
    $app->defaultLayout('Test', 'test');
});


/**
 * Another test page.
 */
$app->router->add('test/test2/test3/test4', function () use ($app) {
    $app->defaultLayout('Test igen', 'test');
});


/**
 * Yet another test page.
 */
$app->router->add('test/test2/test5/test6', function () use ($app) {
    $app->defaultLayout('Test ytterligare en gång', 'test');
});


/**
 * Server data as JSON.
 */
$app->router->add('server', function () use ($app) {
    $app->response->sendJson($_SERVER);
});


/**
 * Month calendar (default).
 */
$app->router->add('calendar', function () use ($app) {
    $now = new DateTime();
    $month = new \LRC\Calendar\Month($now->format('Y'), $now->format('n'));
    $app->defaultLayout('Månadskalender', [
        [
            'path' => 'calendar',
            'data' => [
                'month' => $month,
                'small' => $app->request->getGet('small', false),
                'noImage' => $app->request->getGet('noimage', false)
            ]
        ]
    ]);
});


/**
 * Month calendar (with parameters).
 */
$app->router->add('calendar/{year:digit}/{monthNum:digit}', function ($year, $monthNum) use ($app) {
    try {
        $month = new \LRC\Calendar\Month($year, $monthNum);
        $app->defaultLayout('Månadskalender', [
            [
                'path' => 'calendar',
                'data' => [
                    'month' => $month,
                    'small' => $app->request->getGet('small', false),
                    'noImage' => $app->request->getGet('noimage', false)
                ]
            ]
        ]);
    } catch (Exception $ex) {
        $app->redirect('calendar');
    }
});


include 'session.php';
include 'user.php';
