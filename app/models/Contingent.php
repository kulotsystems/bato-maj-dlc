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


    public function __construct($contingentType, $id = 0)
    {
        parent::__construct();
        $this->contingentType = $contingentType;
        $this->table = 'contingents_' . $contingentType;
        $this->table_criteria = 'criteria_' . $contingentType;
        $this->table_rating = 'ratings_' . $contingentType;

        // get other info
        $this->id = $id;
        if($id > 0) {
            $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->number = $row['number'];
                $this->school = $row['school'];
                $this->logo = $row['logo'];
                $this->is_active = $row['is_active'];
            }
        }
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


    public function getInfo()
    {
        return [
            'id'        => $this->id,
            'number'    => $this->number,
            'school'    => $this->school,
            'logo'      => $this->logo,
            'is_active' => $this->is_active,
        ];
    }


    public function getRating($judge_id, $criteria_id)
    {
        $ratingInfo = [
            'id'            => 0,
            'value'         => 0,
            'is_locked'     => 0,
            'judge_id'      => $judge_id,
            'criteria_id'   => $criteria_id,
            'contingent_id' => $this->id
        ];

        // check if rating exists for judge
        $query = "SELECT id, value, is_locked FROM $this->table_rating WHERE judge_id = ? AND criteria_id = ? AND contingent_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $judge_id, $criteria_id, $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            // rating found
            $row = $result->fetch_assoc();
            $ratingInfo['id'] = $row['id'];
            $ratingInfo['value'] = $row['value'];
            $ratingInfo['is_locked'] = $row['is_locked'];
        }
        else {
            // rating not found, insert it
            $query = "INSERT INTO $this->table_rating (judge_id, criteria_id, contingent_id, value) VALUES (?, ?, ?, 0)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iii", $judge_id, $criteria_id, $this->id);
            $stmt->execute();
            $ratingInfo['id'] = $this->conn->insert_id;
        }

        return $ratingInfo;
    }


    public function setRating($judge_id, $criteria_id, $value)
    {
        $query = "UPDATE $this->table_rating SET value = ? WHERE judge_id = ? AND criteria_id = ? AND contingent_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("diii", $value, $judge_id, $criteria_id, $this->id);
        $stmt->execute();
        $stmt->close();
    }

}
