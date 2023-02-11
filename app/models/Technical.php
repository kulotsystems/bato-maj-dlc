<?php

require_once 'User.php';

class Technical extends User
{
    protected $table = 'users_technical';


    public function __construct($username, $password)
    {
        parent::__construct($username, $password, $this->table, 'technical');
    }
}
