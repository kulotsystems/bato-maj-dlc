<?php
require_once '_init.php';

// get authenticated user
$authUser = getUser();

if(!$authUser)
    denyAccess();

else if($authUser['userType'] !== 'admin')
    denyAccess();

else {
    // get requests
    if(isset($_GET['getResults'])) {
        require_once 'models/Admin.php';
        $admin = new Admin($authUser['username'], $_SESSION['pass']);

        if(!$admin->authenticated())
            denyAccess();

        else {
            $portion = strtolower(trim($_GET['getResults']));

            $results = $admin->getResults($portion);

            echo json_encode([
                'portion' => $portion,
                'results' => $results
            ]);
        }
    }

    else
        denyAccess();
}
