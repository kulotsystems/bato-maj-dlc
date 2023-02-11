<?php

require_once 'App.php';

class Contingent extends App
{
    protected $id;
    protected $number;
    protected $school;
    protected $logo;
    protected $is_active;
    protected $contingentType;
    protected $table;
    protected $table_criteria;
    protected $table_rating;

    public function __construct($contingentType)
    {
        parent::__construct();
        $this->contingentType = $contingentType;
        $this->table = 'contingents_'.$contingentType;
        $this->table_criteria = 'criteria_'.$contingentType;
        $this->table_rating   = 'rating_'.$contingentType;
    }
}
