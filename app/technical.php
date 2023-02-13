<?php
require_once '_init.php';

// get authenticated user
$authUser = getUser();

if(!$authUser)
    denyAccess();

else if($authUser['userType'] !== 'technical')
    denyAccess();

else {
    // get requests
    if(isset($_GET['getDeductionSheet'])) {
        require_once 'models/Technical.php';
        $technical = new Technical($authUser['username'], $_SESSION['pass']);

        if(!$technical->authenticated())
            denyAccess();

        else {
            $portion = strtolower(trim($_GET['getDeductionSheet']));
            $deductionSheet = $technical->getDeductionSheet($portion);

            echo json_encode($deductionSheet);
        }
    }

    // post requests
    else if($POST = json_decode(file_get_contents('php://input'), true)) {
        require_once 'models/Technical.php';
        $technical = new Technical($authUser['username'], $_SESSION['pass']);

        if(!$technical->authenticated())
            denyAccess();

        else {
            // send deductions
            if(isset($POST['deduction'])) {
                $deduction = $POST['deduction'];

                if($deduction['technicalID'] != $authUser['id'])
                    denyAccess();

                else
                    $technical->storeDeduction($deduction);

                echo json_encode([
                    'deduction_sent' => true
                ]);
            }

            // submit final deductions
            else if(isset($POST['finalDeductions'])) {
                $finalDeductions = $POST['finalDeductions'];

                if($finalDeductions['technicalID'] != $authUser['id'])
                    denyAccess();

                else {
                    foreach($finalDeductions['rows'] as $deduction) {
                        $deduction['portion'] = $finalDeductions['portion'];
                        $technical->storeDeduction($deduction, true);
                    }
                }

                echo json_encode([
                    'finalRatings_submitted' => true
                ]);
            }


            else
                denyAccess();
        }
    }

    else
        denyAccess();
}

