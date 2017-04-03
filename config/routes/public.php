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
    default_layout('Om webbplatsen', ['about', 'byline']);
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
    default_layout('Test', 'test');
});


/**
 * Another test page.
 */
$app->router->add('test/test2/test3/test4', function () use ($app) {
    default_layout('Test igen', 'test');
});


/**
 * Yet another test page.
 */
$app->router->add('test/test2/test5/test6', function () use ($app) {
    default_layout('Test ytterligare en gång', 'test');
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
    default_layout('Månadskalender', [
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
        default_layout('Månadskalender', [
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
        $app->response->redirect($app->url->create('calendar'));
    }
});


include 'session.php';
