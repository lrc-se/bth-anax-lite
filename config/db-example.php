<?php
/**
 * Config file for database connection.
 */

if (strpos($_SERVER['HTTP_HOST'], 'student.bth.se') !== false) {
    // published environment
    return [
        'dsn' => 'mysql:host=YYYYY.YYYYY.YY;port=3306;dbname=YYYYYY',
        'user' => 'YYYYYY',
        'pass' => 'YYYYYYYYYYYY'
    ];
} else {
    // local environment
    return [
        'dsn' => 'mysql:host=localhost;dbname=XXXXXX',
        'user' => 'XXXXXX',
        'pass' => 'XXXXXXXXXXXX'
    ];
}
