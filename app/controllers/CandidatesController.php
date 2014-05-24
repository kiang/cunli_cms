<?php

class CandidatesController extends BaseController {
    /*
     * to get candidates count in cunli basis under specified town id
     */

    public function getCount($townId = '') {
        $hi = Candidate::select(array('cunli_id', 'COUNT(*) AS count'))->where('town_id', '=', $townId)->groupBy('cunli_id');

        return 'hi';
        return Response::json(array(
                    'counters' => Candidate::select(array('cunli_id', 'COUNT(*) AS count'))->where('town_id', '=', $townId)->groupBy('cunli_id'),
        ));
    }

}
