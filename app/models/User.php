<?php

require_once 'App.php';

class User extends App
{
    protected $username;
    protected $password;
    protected $fullName;
    protected $avatar;
    protected $number;
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
        $user_info = null;
        if(isset($_SESSION['user']) && isset($_SESSION['pass'])) {
            $authenticated = (new User(
                $_SESSION['user']['username'],
                $_SESSION['pass'],
                'users_'.$_SESSION['user']['userType'],
                $_SESSION['user']['userType']
            ))->signIn();

            if($authenticated)
                $user_info = $authenticated->getInfo();
            else
                session_destroy();
        }
        return $user_info;
    }


    public function signIn()
    {
        $stmt = $this->conn->prepare("SELECT username, password, fullname, avatar, number FROM $this->table WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $this->username, $this->password);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->fullName = $row['fullname'];
            $this->avatar = $row['avatar'];
            $this->number = $row['number'];

            $_SESSION['user'] = $this->getInfo();
            $_SESSION['pass'] = $this->password;
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
            'number'   => $this->number,
            'userType' => $this->userType,
        ];
    }
}
