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

    // post requests
    else if($POST = json_decode(file_get_contents('php://input'), true)) {
        require_once 'models/Judge.php';
        $judge = new Judge($authUser['username'], $_SESSION['pass']);

        if(!$judge->authenticated())
            denyAccess();

        else {
            // submit ratings
            if(isset($POST['ratings'])) {
                $ratings = $POST['ratings'];

                if($ratings['judgeID'] != $authUser['id'])
                    denyAccess();

                else
                    $judge->storeRatings($ratings);
            }
        }
    }

    else
        denyAccess();
}

