<?php

/**
 * Internal routes.
 */


/**
 * 404 page.
 */
$app->router->addInternal('404', function () use ($app) {
    $app->defaultLayout('Sidan kunde inte hittas', '404', 404);
});
