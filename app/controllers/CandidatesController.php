<?php

class CandidatesController extends BaseController {
    /*
     * to get candidates count in cunli basis under specified town id
     */

    public function getCount($townId = '') {
        $hi = Candidate::select(array('cunli_id', 'COUNT(*) AS count'))->where('town_id', '=', $townId)->groupBy('cunli_id');

        return 's';
        return Response::json(array(
                    'counters' => Candidate::select(array('cunli_id', 'COUNT(*) AS count'))->where('town_id', '=', $townId)->groupBy('cunli_id'),
        ));
    }
    
    /*
     * the form to provide new candidate
     */
    public function getNew() {
        // Title
        $title = '新增';

        return View::make('site/candidates/new', compact('title'));
    }

}
