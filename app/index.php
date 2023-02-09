<?php

header("Access-Control-Allow-Origin: http://localhost:5175");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");


echo json_encode([
    'data' => 'Hello World'
]);