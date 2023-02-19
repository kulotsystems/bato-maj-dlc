<?php

/*
|-----------------------------------------------------------------------
| Database
|-----------------------------------------------------------------------
| Enter the configuration for your MySQL Database
|
|    host    ->  your database host
|    user    ->  your database username
|    pass    ->  your database password
|    dbname  ->  your database name
|
*/

$config = [
    'host'   => 'localhost',
    'user'   => 'root',
    'pass'   => '',
    'dbname' => 'bato-maj-dlc'
];

$conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['dbname']);

if($conn->connect_error) {
    die(json_encode([
        'error' => $conn->connect_error
    ]));
}
