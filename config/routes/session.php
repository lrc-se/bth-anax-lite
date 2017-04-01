<?php

/**
 * Session routes.
 */


/**
 * Session test index.
 */
$app->router->add('session', function () use ($app) {
    $app->session->start();
    $msg = $app->session->getOnce('msg');
    default_layout('Sessionstest', [
        [
            'path' => 'session',
            'data' => ['msg' => $msg]
        ]
    ]);
});


/**
 * Increment session variable.
 */
$app->router->add('session/increment', function () use ($app) {
    $app->session->start();
    $app->session->set('number', $app->session->get('number', 0) + 1);
    $app->session->set('msg', 'Värdet har ökats med 1.');
    $app->response->redirect($app->url->create('session'));
});

/**
 * Decrement session variable.
 */
$app->router->add('session/decrement', function () use ($app) {
    $app->session->start();
    $app->session->set('number', $app->session->get('number', 0) - 1);
    $app->session->set('msg', 'Värdet har minskats med 1.');
    $app->response->redirect($app->url->create('session'));
});

/**
 * Return session info as JSON.
 */
$app->router->add('session/status', function () use ($app) {
    $app->session->start();
    $app->response->sendJson([
        'id' => session_id(),
        'name' => session_name(),
        'status' => session_status(),
        'cache_expire' => session_cache_expire(),
        'cookie_params' => session_get_cookie_params(),
        'save_path' => session_save_path()
    ]);
});


/**
 * Dump session contents.
 */
$app->router->add('session/dump', function () use ($app) {
    $app->session->start();
    $msg = $app->session->getOnce('msg');
    default_layout('Sessionsinnehåll', [
        [
            'path' => 'session-dump',
            'data' => ['msg' => $msg]
        ]
    ]);
});


/**
 * Clear session.
 */
$app->router->add('session/destroy', function () use ($app) {
    $app->session->start();
    $app->session->clear();
    $app->session->start();
    $app->session->set('msg', 'Sessionen har rensats.');
    $app->response->redirect($app->url->create('session/dump'));
});
