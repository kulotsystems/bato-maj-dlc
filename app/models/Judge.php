<?php

require_once 'User.php';

class Judge extends User
{
    protected $table = 'users_judge';


    public function __construct($username, $password)
    {
        parent::__construct($username, $password, $this->table, 'judge');
    }
}
