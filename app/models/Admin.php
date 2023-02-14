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
        require_once 'Technical.php';
        require_once 'Judge.php';

        $arr_contingents = Contingent::all($contingentType);
        $arr_criteria = Contingent::criteria($contingentType);
        $arr_technicals = Technical::all();
        $arr_judges = Judge::all();


        // get technical total deductions
        for($i = 0; $i < sizeof($arr_technicals); $i++) {
            $arr_technicals[$i]['deductions'] = [];
            for($j = 0; $j < sizeof($arr_contingents); $j++) {
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
                $arr_technicals[$i]['deductions']['c_' . $arr_contingents[$j]['id']] = [
                    'value'  => $deduction['value'],
                    'locked' => $deduction['is_locked']
                ];

                // increment contingent total deduction
                $arr_contingents[$j]['deduction']['total'] += $deduction['value'];
            }
        }


        // get judge total ratings
        for($i = 0; $i < sizeof($arr_judges); $i++) {
            // prepare unique rating values
            $arr_judges_unique_rating_values = [];

            $arr_judges[$i]['ratings'] = [];
            for($j = 0; $j < sizeof($arr_contingents); $j++) {
                // instantiate contingent
                $contingent = $contingentType == 'maj'
                    ? new Majorette($arr_contingents[$j]['id'])
                    : new DrumLyreCorps($arr_contingents[$j]['id']);

                // prepare contingent total and average ratings
                if(!isset($arr_contingents[$j]['rating'])) {
                    $arr_contingents[$j]['rating'] = [
                        'total'   => 0,
                        'average' => 0,
                    ];
                }

                // prepare contingent total and average rank
                if(!isset($arr_contingents[$j]['rank'])) {
                    $arr_contingents[$j]['rank'] = [
                        'dense' => [
                            'total'   => 0,
                            'average' => 0,
                        ],
                        'fraction' => [
                            'total'   => 0,
                            'average' => 0,
                        ]
                    ];
                }

                // get ratings
                $arr_judges[$i]['ratings']['c_' . $arr_contingents[$j]['id']] = [
                    'value'  => 0,
                    'locked' => 0,
                    'rank'   => [
                        'dense'    => null,
                        'fraction' => null
                    ]
                ];
                $value = 0;
                // adjust initial $value with contingent deductions for judge chairman
                if($arr_contingents[$j]['deduction']['total'] > 0) {
                    if($arr_judges[$i]['is_chairman'] == 1)
                        $value = -1 * $arr_contingents[$j]['deduction']['total'];
                }


                $locked = 1;
                foreach($arr_criteria as $criteriaInfo) {
                    $rating = $contingent->getRating($arr_judges[$i]['id'], $criteriaInfo['id']);
                    if($locked == 1) {
                        if($rating['is_locked'] == 0)
                            $locked = 0;
                    }
                    $value += $rating['value'];
                }
                // increment contingent total rating
                $arr_contingents[$j]['rating']['total'] += $value;

                $arr_judges[$i]['ratings']['c_' . $arr_contingents[$j]['id']]['value'] = $value;
                $arr_judges[$i]['ratings']['c_' . $arr_contingents[$j]['id']]['locked'] = $locked;

                // push value to $arr_judges_unique_rating_values
                if(!in_array($value, $arr_judges_unique_rating_values))
                    $arr_judges_unique_rating_values[] = $value;
            }

            // sort $arr_judges_unique_rating_values in descending order
            rsort($arr_judges_unique_rating_values);

            // determine contingent ranks for the judge
            $rank_group = []; // for fractional rank later
            for($j = 0; $j < sizeof($arr_contingents); $j++) {
                // assign dense rank
                $rank = 1 + array_search(
                        $arr_judges[$i]['ratings']['c_' . $arr_contingents[$j]['id']]['value'],
                        $arr_judges_unique_rating_values
                    );
                $arr_judges[$i]['ratings']['c_' . $arr_contingents[$j]['id']]['rank']['dense'] = $rank;

                // push $rank to $rank_group for fractional rank later
                if(!isset($rank_group['r_' . $rank]))
                    $rank_group['r_' . $rank] = [];
                $rank_group['r_' . $rank][] = [
                    'index' => $j,
                    'id'    => 'c_' . $arr_contingents[$j]['id']
                ];

                // add dense rank to contingent
                $arr_contingents[$j]['rank']['dense']['total'] += $rank;
            }

            // get fractional rank
            $ctr = 0;
            for($order = 0; $order < sizeof($arr_judges_unique_rating_values); $order++) {
                $rank_group_index = 'r_' . ($order + 1);
                $rank_group_element = $rank_group[$rank_group_index];
                $rank_group_size = sizeof($rank_group_element);
                $fractional_rank = $ctr + ((($rank_group_size * ($rank_group_size + 1)) / 2) / $rank_group_size);
                $ctr += $rank_group_size;
                for($r = 0; $r < $rank_group_size; $r++) {
                    $arr_judges[$i]['ratings'][$rank_group_element[$r]['id']]['rank']['fraction'] = $fractional_rank;

                    // add fractional rank to contingent
                    $arr_contingents[$rank_group_element[$r]['index']]['rank']['fraction']['total'] += $fractional_rank;
                }
            }
        }

        // compute contingent final ratings, ranks and deductions
        for($i = 0; $i < sizeof($arr_contingents); $i++) {
            $total_judges     = sizeof($arr_judges);
            $total_technicals = sizeof($arr_technicals);

            // contingent average rating
            $arr_contingents[$i]['rating']['average'] = $arr_contingents[$i]['rating']['total'] / $total_judges;

            // contingent average dense rank
            $arr_contingents[$i]['rank']['dense']['average'] = $arr_contingents[$i]['rank']['dense']['total'] / $total_judges;

            // contingent average fractional rank
            $arr_contingents[$i]['rank']['fraction']['average'] = $arr_contingents[$i]['rank']['fraction']['total'] / $total_judges;

            // contingent average deduction
            $arr_contingents[$i]['deduction']['average'] = $arr_contingents[$i]['deduction']['total'] / $total_technicals;

            $arr_contingents[$i]['final'] = [
                'rating_average' => [
                    'less_deduction_total'   => $arr_contingents[$i]['rating']['average'],
                    'less_deduction_average' => $arr_contingents[$i]['rating']['average']
                ]
            ];
        }

        return [
            'contingents' => $arr_contingents,
            'criteria'    => $arr_criteria,
            'technicals'  => $arr_technicals,
            'judges'      => $arr_judges,
        ];
    }
}
