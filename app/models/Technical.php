<?php

require_once 'User.php';

class Technical extends User
{
    public function __construct($username, $password)
    {
        parent::__construct($username, $password, 'technical');
    }
}
