<?php

class AdminTownsController extends AdminController {

    /**
     * Town Model
     * @var Town
     */
    protected $town;

    /**
     * Inject the models.
     * @param Town $town
     */
    public function __construct(Town $town) {
        parent::__construct();
        $this->town = $town;
    }

    /**
     * Show a list of all the town towns.
     *
     * @return View
     */
    public function getIndex() {
        // Title
        $title = Lang::get('admin/towns/title.town_management');

        // Grab all the town towns
        $towns = $this->town;

        // Show the page
        return View::make('admin/towns/index', compact('towns', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate($countyId = '') {
        // Title
        $title = Lang::get('admin/towns/title.create_a_new_town');

        // Counties
        $counties = County::lists('title', 'id');

        // Show the page
        return View::make('admin/towns/create_edit', compact('title', 'counties', 'countyId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate() {
        // Declare the rules for the form validation
        $rules = array(
            'title' => 'required',
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            // Create a new town town
            $user = Auth::user();

            // Update the town town data
            $this->town->title = Input::get('title');
            $this->town->slug = Str::slug(Input::get('title'));
            $this->town->county_id = Input::get('county_id');

            // Was the town town created?
            if ($this->town->save()) {
                // Redirect to the new town town page
                return Redirect::to('admin/towns/' . $this->town->id . '/edit')->with('success', Lang::get('admin/towns/messages.create.success'));
            }

            // Redirect to the town town create page
            return Redirect::to('admin/towns/create')->with('error', Lang::get('admin/towns/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/towns/create')->withInput()->withErrors($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param $town
     * @return Response
     */
    public function getShow($town) {
        // redirect to the frontend
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $town
     * @return Response
     */
    public function getEdit($town) {
        // Title
        $title = Lang::get('admin/towns/title.town_update');

        // Counties
        $counties = County::lists('title', 'id');

        // Show the page
        return View::make('admin/towns/create_edit', compact('town', 'title', 'counties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $town
     * @return Response
     */
    public function postEdit($town) {

        // Declare the rules for the form validation
        $rules = array(
            'title' => 'required',
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            // Update the town town data
            $town->title = Input::get('title');
            $town->slug = Str::slug(Input::get('title'));
            $town->county_id = Input::get('county_id');

            // Was the town town updated?
            if ($town->save()) {
                // Redirect to the new town town page
                return Redirect::to('admin/towns/' . $town->id . '/edit')->with('success', Lang::get('admin/towns/messages.update.success'));
            }

            // Redirect to the towns town management page
            return Redirect::to('admin/towns/' . $town->id . '/edit')->with('error', Lang::get('admin/towns/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/towns/' . $town->id . '/edit')->withInput()->withErrors($validator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $town
     * @return Response
     */
    public function getDelete($town) {
        // Title
        $title = Lang::get('admin/towns/title.town_delete');

        // Show the page
        return View::make('admin/towns/delete', compact('town', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $town
     * @return Response
     */
    public function postDelete($town) {
        // Declare the rules for the form validation
        $rules = array(
            'id' => 'required|integer'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            $id = $town->id;
            $town->delete();

            // Was the town town deleted?
            $town = Town::find($id);
            if (empty($town)) {
                // Redirect to the town towns management page
                return Redirect::to('admin/towns')->with('success', Lang::get('admin/towns/messages.delete.success'));
            }
        }
        // There was a problem deleting the town town
        return Redirect::to('admin/towns')->with('error', Lang::get('admin/towns/messages.delete.error'));
    }

    /**
     * Show a list of all the town towns formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData() {
        $towns = Town::leftJoin('counties', 'counties.id', '=', 'towns.county_id')
                ->select(array('towns.id', 'counties.title as county', 'towns.title'));

        return Datatables::of($towns)
                        ->add_column('actions', '<a href="{{{ URL::to(\'admin/towns/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >編輯</a>
                <a href="{{{ URL::to(\'admin/cunlis/create/\' . $id ) }}}" class="btn btn-default btn-xs iframe" >新增村里</a>
                <a href="{{{ URL::to(\'admin/towns/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">刪除</a>
            ')
                        ->make();
    }

}
