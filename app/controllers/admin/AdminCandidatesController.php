<?php

class AdminCandidatesController extends AdminController {

    /**
     * Candidate Model
     * @var Candidate
     */
    protected $candidate;

    /**
     * Inject the models.
     * @param Candidate $candidate
     */
    public function __construct(Candidate $candidate) {
        parent::__construct();
        $this->candidate = $candidate;
    }

    /**
     * Show a list of all the candidates.
     *
     * @return View
     */
    public function getIndex() {
        // Title
        $title = Lang::get('admin/candidates/title.candidate_management');

        // Grab all the candidates
        $candidates = $this->candidate;

        // Show the page
        return View::make('admin/candidates/index', compact('candidates', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate() {
        // Title
        $title = Lang::get('admin/candidates/title.create_a_new_candidate');

        // Counties
        $counties = County::lists('title', 'id');
        
        // Towns
        $towns = Town::lists('title', 'id');
        
        // Cunlis
        $cunlis = Cunli::lists('title', 'id');

        // Show the page
        return View::make('admin/candidates/create_edit', compact('title', 'counties', 'towns', 'cunlis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate() {
        // Declare the rules for the form validation
        $rules = array(
            'name' => 'required',
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            // Create a new candidate
            // Update the candidate data
            $this->candidate->id = \J20\Uuid\Uuid::v4();
            $this->candidate->county_id = Input::get('county_id');
            $this->candidate->town_id = Input::get('town_id');
            $this->candidate->cunli_id = Input::get('cunli_id');
            $this->candidate->name = Input::get('name');
            $this->candidate->head = Input::get('head');
            $this->candidate->gender = Input::get('gender');
            $this->candidate->dob = Input::get('dob');
            $this->candidate->data = Input::get('data');

            // Was the candidate created?
            if ($this->candidate->save()) {
                // Redirect to the new candidate page
                return Redirect::to('admin/candidates/' . $this->candidate->id . '/edit')->with('success', Lang::get('admin/candidates/messages.create.success'));
            }

            // Redirect to the candidate create page
            return Redirect::to('admin/candidates/create')->with('error', Lang::get('admin/candidates/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/candidates/create')->withInput()->withErrors($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param $candidate
     * @return Response
     */
    public function getShow($candidate) {
        // redirect to the frontend
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $candidate
     * @return Response
     */
    public function getEdit($candidate) {
        // Title
        $title = Lang::get('admin/candidates/title.candidate_update');

        // Counties
        $counties = County::lists('title', 'id');
        
        // Towns
        $towns = Town::lists('title', 'id');
        
        // Cunlis
        $cunlis = Cunli::lists('title', 'id');

        // Show the page
        return View::make('admin/candidates/create_edit', compact('candidate', 'title', 'counties', 'towns', 'cunlis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $candidate
     * @return Response
     */
    public function postEdit($candidate) {

        // Declare the rules for the form validation
        $rules = array(
            'name' => 'required',
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            // Update the candidate data
            $candidate->county_id = Input::get('county_id');
            $candidate->town_id = Input::get('town_id');
            $candidate->cunli_id = Input::get('cunli_id');
            $candidate->name = Input::get('name');
            $candidate->head = Input::get('head');
            $candidate->gender = Input::get('gender');
            $candidate->dob = Input::get('dob');
            $candidate->data = Input::get('data');

            // Was the candidate updated?
            if ($candidate->save()) {
                // Redirect to the new candidate page
                return Redirect::to('admin/candidates/' . $candidate->id . '/edit')->with('success', Lang::get('admin/candidates/messages.update.success'));
            }

            // Redirect to the candidates candidate management page
            return Redirect::to('admin/candidates/' . $candidate->id . '/edit')->with('error', Lang::get('admin/candidates/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/candidates/' . $candidate->id . '/edit')->withInput()->withErrors($validator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $candidate
     * @return Response
     */
    public function getDelete($candidate) {
        // Title
        $title = Lang::get('admin/candidates/title.candidate_delete');

        // Show the page
        return View::make('admin/candidates/delete', compact('candidate', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $candidate
     * @return Response
     */
    public function postDelete($candidate) {
        // Declare the rules for the form validation
        $rules = array(
            'id' => 'required'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            $id = $candidate->id;
            $candidate->delete();

            // Was the candidate deleted?
            $candidate = Candidate::find($id);
            if (empty($candidate)) {
                // Redirect to the candidates management page
                return Redirect::to('admin/candidates')->with('success', Lang::get('admin/candidates/messages.delete.success'));
            }
        }
        // There was a problem deleting the candidate
        return Redirect::to('admin/candidates')->with('error', Lang::get('admin/candidates/messages.delete.error'));
    }

    /**
     * Show a list of all the candidates formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData() {
        $candidates = Candidate::leftJoin('counties', 'counties.id', '=', 'candidates.county_id')
                ->leftJoin('towns', 'towns.id', '=', 'candidates.town_id')
                ->leftJoin('cunlis', 'cunlis.id', '=', 'candidates.cunli_id')
                ->select(array('candidates.id', 'counties.title as county', 'towns.title as town', 'cunlis.title as cunli', 'candidates.name'));

        return Datatables::of($candidates)
                        ->add_column('actions', '<a href="{{{ URL::to(\'admin/candidates/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/candidates/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')
                ->remove_column('id')
                        ->make();
    }

}