<?php

require_once 'User.php';

class Judge extends User
{
    public function __construct($username, $password)
    {
        parent::__construct($username, $password, 'judge');
    }

    /**
     * @param $contingentType: 'maj' | 'dlc'
     */
    public function getScoreSheet($contingentType)
    {
        require_once 'Contingent.php';

        $contingents = Contingent::all($contingentType);
        $criteria    = Contingent::criteria($contingentType);


        return [
            'contingents' => $contingents,
            'criteria'    => $criteria
        ];
    }
}
