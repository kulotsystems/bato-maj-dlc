<?php

require_once 'User.php';

class Technical extends User
{
    public function __construct($username = '', $password = '')
    {
        parent::__construct($username, $password, 'technical');
    }


    /**
     * @param $contingentType : 'maj' | 'dlc'
     */
    public function getDeductionSheet($contingentType)
    {
        require_once 'Majorette.php';
        require_once 'DrumLyreCorps.php';

        $contingentsInfos = Contingent::all($contingentType);
        $deductions = [];
        foreach($contingentsInfos as $contingentsInfo) {
            // instantiate contingent
            $contingent = $contingentType == 'maj'
                ? new Majorette($contingentsInfo['id'])
                : new DrumLyreCorps($contingentsInfo['id']);

            // get deductions
            // key pattern: `d_${contingentID}`
            $deductions['d_'.$contingentsInfo['id']] = $contingent->getDeduction($this->id);
        }

        return [
            'contingents' => $contingentsInfos,
            'deductions'  => $deductions
        ];
    }


    public static function all()
    {
        $technical = new Technical();
        $sql = "SELECT id, number, fullname, avatar FROM $technical->table ORDER BY number";
        $result = $technical->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function storeDeduction($deduction, $lock=false)
    {
        require_once 'Majorette.php';
        require_once 'DrumLyreCorps.php';

        $contingent = $deduction['portion'] == 'maj'
            ? new Majorette($deduction['contingentID'])
            : new DrumLyreCorps($deduction['contingentID']);

        $contingent->setDeduction($this->id, $deduction['value'], $lock);
    }
}
