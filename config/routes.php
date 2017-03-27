<?php

/**
 * Routes.
 */


/**
 * Creates a default composite view layout.
 */
function default_layout($title, $views, $code = 200)
{
    global $app;
    $app->view->add('incl/header', [
        'title' => $title,
        'flash' => 'bg-main.jpg'
    ]);
    if (is_array($views)) {
        foreach ($views as $view) {
            if (is_array($view)) {
                $app->view->add($view['path'], $view['data']);
            } else {
                $app->view->add($view);
            }
        }
    } else {
        $app->view->add($views);
    }
    $app->view->add('incl/footer');
    $app->response->setBody([$app->view, 'render'])->send($code);
}


require 'routes/public.php';
require 'routes/internal.php';
