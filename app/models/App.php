<?php

class App
{
    protected $conn;

    public function __construct()
    {
        // connect to the database
        $env_db = ENV['database'];
        $this->conn = new mysqli($env_db['host'], $env_db['user'], $env_db['pass'], $env_db['dbname']);

        // check connection
        if($this->conn->connect_error) {
            die('connection failed: ' . $this->conn->connect_error);
        }
    }
}
