<?php

require_once 'User.php';

class Admin extends User
{
    public function __construct($username = '', $password = '')
    {
        parent::__construct($username, $password, 'admin');
    }

    /**
     * @param $contingentType : 'maj' | 'dlc'
     */
    public function getResults($contingentType)
    {
        require_once 'Majorette.php';
        require_once 'DrumLyreCorps.php';
        require_once 'Judge.php';
        require_once 'Technical.php';

        $arr_contingents = Contingent::all($contingentType);
        $arr_criteria    = Contingent::criteria($contingentType);
        $arr_judges      = Judge::all();
        $arr_technicals  = Technical::all();

        // get judge total ratings
        for($i=0; $i<sizeof($arr_judges); $i ++) {
            $arr_judges[$i]['ratings'] = [];
            for($j=0; $j<sizeof($arr_contingents); $j++) {
                // instantiate contingent
                $contingent = $contingentType == 'maj'
                    ? new Majorette($arr_contingents[$j]['id'])
                    : new DrumLyreCorps($arr_contingents[$j]['id']);
                
                // prepare contingent total and average ratings
                if(!isset($arr_contingents[$j]['rating'])) {
                    $arr_contingents[$j]['rating'] = [
                        'total'   => 0,
                        'average' => 0
                    ];
                }

                // get ratings
                $arr_judges[$i]['ratings']['c_'.$arr_contingents[$j]['id']]['value']  = 0;
                $arr_judges[$i]['ratings']['c_'.$arr_contingents[$j]['id']]['locked'] = 0;
                $locked = 1;
                foreach($arr_criteria as $criteriaInfo) {
                    $rating = $contingent->getRating($arr_judges[$i]['id'], $criteriaInfo['id']);
                    if($locked == 1) {
                        if($rating['is_locked'] == 0)
                            $locked = 0;
                    }
                    $arr_judges[$i]['ratings']['c_'.$arr_contingents[$j]['id']]['value']  += $rating['value'];
                    $arr_judges[$i]['ratings']['c_'.$arr_contingents[$j]['id']]['locked']  = $locked;

                    // increment contingent total rating
                    $arr_contingents[$j]['rating']['total'] += $rating['value'];
                }
            }
        }

        // get technical total deductions
        for($i=0; $i<sizeof($arr_technicals); $i ++) {
            $arr_technicals[$i]['deductions'] = [];
            for($j=0; $j<sizeof($arr_contingents); $j++) {
                // instantiate contingent
                $contingent = $contingentType == 'maj'
                    ? new Majorette($arr_contingents[$j]['id'])
                    : new DrumLyreCorps($arr_contingents[$j]['id']);

                // prepare contingent total and average deductions
                if(!isset($arr_contingents[$j]['deduction'])) {
                    $arr_contingents[$j]['deduction'] = [
                        'total'   => 0,
                        'average' => 0
                    ];
                }

                // get deduction
                $deduction = $contingent->getDeduction($arr_technicals[$i]['id']);
                $arr_technicals[$i]['deductions']['c_'.$arr_contingents[$j]['id']] = [
                    'value'  => $deduction['value'],
                    'locked' => $deduction['is_locked']
                ];

                // increment contingent total deduction
                $arr_contingents[$j]['deduction']['total'] += $deduction['value'];
            }
        }

        // compute contingent final ratings and deductions
        for($i=0; $i<sizeof($arr_contingents); $i++) {
            // contingent average rating
            $arr_contingents[$i]['rating']['average'] = $arr_contingents[$i]['rating']['total'] / sizeof($arr_judges);

            // contingent average deduction
            $arr_contingents[$i]['deduction']['average'] = $arr_contingents[$i]['deduction']['total'] / sizeof($arr_technicals);

            $arr_contingents[$i]['final'] = [
                'rating_average' => [
                    'less_deduction_total' => $arr_contingents[$i]['rating']['average'] - $arr_contingents[$i]['deduction']['total'],
                    'less_deduction_average' => $arr_contingents[$i]['rating']['average'] - $arr_contingents[$i]['deduction']['average']
                ]
            ];
        }

        return [
            'contingents' => $arr_contingents,
            'criteria'    => $arr_criteria,
            'judges'      => $arr_judges,
            'technicals'  => $arr_technicals
        ];
    }
}
