<?php

require_once 'User.php';

class Judge extends User
{
    public function __construct($username, $password)
    {
        parent::__construct($username, $password, 'judge');
    }
}
