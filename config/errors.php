<?php

// set error reporting
error_reporting(-1);            // report all errors
ini_set('display_errors', 1);   // display all errors


/**
 * Default exception handler.
 */
set_exception_handler(function ($ex) use ($app) {
    // reset partially rendered views, if any
    ob_clean();
    $app->view = new \Anax\View\ViewContainer();
    $app->view->setApp($app);
    $app->view->configure('view.php');
    
    // show error page
    $app->defaultLayout('Ett fel har inträffat', [
        [
            'path' => 'exception',
            'data' => [
                'msg' => $ex->getMessage(),
                'code' => $ex->getCode(),
                'trace' => $ex->getTraceAsString()
            ]
        ]
    ]);
});
