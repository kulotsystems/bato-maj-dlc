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


    public static function all($contingentType)
    {
        $contingent = new Contingent($contingentType);

        $sql = "SELECT id, number, school, logo, is_active FROM $contingent->table ORDER BY number";
        $result = $contingent->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public static function criteria($contingentType)
    {
        $contingent = new Contingent($contingentType);

        $sql = "SELECT id, title, percentage FROM $contingent->table_criteria ORDER BY id";
        $result = $contingent->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
