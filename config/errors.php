<?php

// set error reporting
error_reporting(-1);            // report all errors
ini_set('display_errors', 1);   // display all errors


/**
 * Default exception handler.
 */
set_exception_handler(function ($ex) {
    echo <<<HTML
<h1>Ett fel har inträffat</h1>
<h3><em>Anax Lite</em> har stött på ett undantag.</h3>
<p>
    <strong>Meddelande:</strong> <em>{$ex->getMessage()}</em><br>
    <strong>Felkod:</strong> {$ex->getCode()}
</p>
<strong>Stackhistorik:</strong><br>
<pre>{$ex->getTraceAsString()}</pre>
HTML;
});
