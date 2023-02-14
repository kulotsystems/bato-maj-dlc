<?php

require_once 'User.php';

class Judge extends User
{
    public function __construct($username = '', $password = '')
    {
        parent::__construct($username, $password, 'judge');
    }

    /**
     * @param $contingentType : 'maj' | 'dlc'
     */
    public function getScoreSheet($contingentType)
    {
        require_once 'Majorette.php';
        require_once 'DrumLyreCorps.php';

        $contingentsInfos = Contingent::all($contingentType);
        $criteriaInfos = Contingent::criteria($contingentType);
        $ratings = [];
        foreach($contingentsInfos as $contingentsInfo) {
            // instantiate contingent
            $contingent = $contingentType == 'maj'
                ? new Majorette($contingentsInfo['id'])
                : new DrumLyreCorps($contingentsInfo['id']);

            // get ratings
            foreach($criteriaInfos as $criteriaInfo) {
                // key pattern: contingentID_criteriaID
                $ratings[$contingentsInfo['id'].'_'.$criteriaInfo['id']]
                    = $contingent->getRating($this->id, $criteriaInfo['id']);
            }
        }

        return [
            'contingents' => $contingentsInfos,
            'criteria'    => $criteriaInfos,
            'ratings'     => $ratings
        ];
    }


    public static function all()
    {
        $judge = new Judge();
        $sql = "SELECT id, number, fullname, avatar, is_chairman FROM $judge->table ORDER BY number";
        $result = $judge->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function storeRatings($ratings, $lock=false)
    {
        require_once 'Majorette.php';
        require_once 'DrumLyreCorps.php';

        $contingent = $ratings['portion'] == 'maj'
            ? new Majorette($ratings['contingentID'])
            : new DrumLyreCorps($ratings['contingentID']);

        foreach($ratings['values'] as $rating) {
            $contingent->setRating($this->id, $rating['criteriaID'], $rating['value'], $lock);
        }
    }
}
