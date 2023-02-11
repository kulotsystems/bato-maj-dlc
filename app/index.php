<?php
header('Access-Control-Allow-Origin: http://localhost:5175');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
session_start();
require_once 'config/database.php';

if(isset($_GET['getUser']))
{
    require_once 'models/User.php';
    echo json_encode([
        'user' => User::getUser()
    ]);
}

else if($POST = json_decode(file_get_contents('php://input'), true))
{
    // user sign-in
    if(isset($POST['username']) && isset($POST['password'])) {
        require_once 'models/Admin.php';
        require_once 'models/Judge.php';
        require_once 'models/Technical.php';

        // todo: validate input
        $username = trim(strtolower($POST['username']));
        $password = trim(strtolower($POST['password']));

        $user = (new Admin($username, $password))->signIn();
        if(!$user) {
            $user = (new Judge($username, $password))->signIn();
            if(!$user)
                $user = (new Technical($username, $password))->signIn();
        }

        if($user) {
            $userData = $user->getInfo();
            $_SESSION['user'] = $userData;

            // successfully logged in
            echo json_encode([
                'user' => $userData
            ]);
        }
        else
            App::returnError('HTTP/1.1 401', 'Invalid Username or Password');
    }

    // user sign out
    else if(isset($POST['signOut'])) {
        session_destroy();
        echo json_encode([
            'signedOut' => true
        ]);
    }

    else {
        echo json_encode([
            'data' => 'Invalid Request'
        ]);
    }
}
