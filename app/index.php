<?php
require_once '_init.php';

// get requests
if(isset($_GET['getUser'])) {
    echo json_encode([
        'user' => getUser()
    ]);
}

// post requests
else if($POST = json_decode(file_get_contents('php://input'), true)) {

    // user sign-in
    if(isset($POST['username']) && isset($POST['password'])) {
        require_once 'models/Admin.php';
        require_once 'models/Judge.php';
        require_once 'models/Technical.php';

        // todo: validate input
        $username = trim(strtolower($POST['username']));
        $password = $POST['password'];

        $user = (new Admin($username, $password))->signIn();
        if(!$user) {
            $user = (new Judge($username, $password))->signIn();
            if(!$user)
                $user = (new Technical($username, $password))->signIn();
        }

        if($user) {
            // successfully logged in
            echo json_encode([
                'user' => $user->getInfo()
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

    else
        denyAccess();
}
