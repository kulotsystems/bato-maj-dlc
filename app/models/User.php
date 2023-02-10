<?php

require_once 'App.php';

class User extends App
{
    protected $username;
    protected $password;
    protected $fullName;
    protected $avatar;
    protected $table;
    protected $userType;


    public function __construct($username, $password, $table, $userType)
    {
        parent::__construct();
        $this->username = $username;
        $this->password = $password;
        $this->table = $table;
        $this->userType = $userType;
    }

    public static function getUser()
    {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    public function signIn()
    {
        $stmt = $this->conn->prepare("SELECT username, password, fullname, avatar FROM users_$this->userType WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $this->username, $this->password);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->fullName = $row['fullname'];
            $this->avatar = $row['avatar'];
            return $this;
        }
        return false;
    }

    public function getInfo()
    {
        return [
            'username' => $this->username,
            'fullName' => $this->fullName,
            'avatar'   => $this->avatar,
            'userType' => $this->userType,
        ];
    }
}
