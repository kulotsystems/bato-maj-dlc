<?php

require_once 'User.php';

class Admin extends User
{
    protected $table = 'users_admin';


    public function __construct($username, $password)
    {
        parent::__construct($username, $password, $this->table, 'admin');
    }
}
