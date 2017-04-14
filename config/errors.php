<?php

// set error reporting
error_reporting(-1);            // report all errors
ini_set('display_errors', 1);   // display all errors


/**
 * Default exception handler.
 */
set_exception_handler(function ($ex) use ($app) {
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
