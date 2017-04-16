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
    
    /*// prevent stack trace from leaking parameter values
    $trace = $ex->getTrace();
    $trace2 = '';
    foreach ($trace as $num => $line) {
        $trace2 .= "#$num " . (isset($line['file']) ? $line['file'] . '(' . $line['line'] . '): ' : '[internal function]: ');
        if (isset($line['class'])) {
            $trace2 .= $line['class'] . $line['type'];
        }
        $trace2 .= $line['function'] . "()\n";
    }
    $trace2 .= '#' . ($num + 1) . ' {main}';*/
    
    // show error page
    $app->defaultLayout('Ett fel har inträffat', [
        [
            'path' => 'exception',
            'data' => [
                'msg' => $ex->getMessage(),
                'code' => $ex->getCode(),
                'trace' => preg_replace('/(PDO->__construct\().+?\)/', '\\1****)', $ex->getTraceAsString())
            ]
        ]
    ]);
});
