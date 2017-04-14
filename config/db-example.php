<?php
/**
 * Config file for database connection.
 */

// differentiate between local and published environment
if (strpos($_SERVER['HTTP_HOST'], 'student.bth.se') === false) {
    return [
        'dsn' => 'mysql:host=localhost;dbname=XXXXXX',
        'user' => 'XXXXXX',
        'pass' => 'XXXXXXXXXXXX'
    ];
} else {
    return [
        'dsn' => 'mysql:host=YYYYY.YYYYY.YY;dbname=YYYYYY',
        'user' => 'YYYYYY',
        'pass' => 'YYYYYYYYYYYY'
    ];
}
