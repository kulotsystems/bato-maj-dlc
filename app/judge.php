<?php
require_once '_init.php';

// get authenticated user
$authUser = getUser();

if(!$authUser)
    denyAccess();

else if($authUser['userType'] !== 'judge')
    denyAccess();

else {
    // get requests
    if(isset($_GET['getScoreSheet'])) {
        require_once 'models/Judge.php';
        $judge = new Judge($authUser['username'], $_SESSION['pass']);

        if(!$judge->authenticated())
            denyAccess();

        else {
            $portion = strtolower(trim($_GET['getScoreSheet']));
            $scoreSheet = $judge->getScoreSheet($portion);

            echo json_encode($scoreSheet);
        }
    }

    else
        denyAccess();
}

