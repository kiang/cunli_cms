<?php

class AdminCountiesController extends AdminController {

    /**
     * County Model
     * @var County
     */
    protected $county;

    /**
     * Inject the models.
     * @param County $county
     */
    public function __construct(County $county) {
        parent::__construct();
        $this->county = $county;
    }

    /**
     * Show a list of all the county counties.
     *
     * @return View
     */
    public function getIndex() {
        // Title
        $title = Lang::get('admin/counties/title.county_management');

        // Grab all the county counties
        $counties = $this->county;

        // Show the page
        return View::make('admin/counties/index', compact('counties', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate() {
        // Title
        $title = Lang::get('admin/counties/title.create_a_new_county');

        // Show the page
        return View::make('admin/counties/create_edit', compact('title'));
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
            // Create a new county county
            $user = Auth::user();

            // Update the county county data
            $this->county->title = Input::get('title');
            $this->county->slug = Str::slug(Input::get('title'));

            // Was the county county created?
            if ($this->county->save()) {
                // Redirect to the new county county page
                return Redirect::to('admin/counties/' . $this->county->id . '/edit')->with('success', Lang::get('admin/counties/messages.create.success'));
            }

            // Redirect to the county county create page
            return Redirect::to('admin/counties/create')->with('error', Lang::get('admin/counties/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/counties/create')->withInput()->withErrors($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param $county
     * @return Response
     */
    public function getShow($county) {
        // redirect to the frontend
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $county
     * @return Response
     */
    public function getEdit($county) {
        // Title
        $title = Lang::get('admin/counties/title.county_update');

        // Show the page
        return View::make('admin/counties/create_edit', compact('county', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $county
     * @return Response
     */
    public function postEdit($county) {

        // Declare the rules for the form validation
        $rules = array(
            'title' => 'required',
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            // Update the county county data
            $county->title = Input::get('title');
            $county->slug = Str::slug(Input::get('title'));

            // Was the county county updated?
            if ($county->save()) {
                // Redirect to the new county county page
                return Redirect::to('admin/counties/' . $county->id . '/edit')->with('success', Lang::get('admin/counties/messages.update.success'));
            }

            // Redirect to the counties county management page
            return Redirect::to('admin/counties/' . $county->id . '/edit')->with('error', Lang::get('admin/counties/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/counties/' . $county->id . '/edit')->withInput()->withErrors($validator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $county
     * @return Response
     */
    public function getDelete($county) {
        // Title
        $title = Lang::get('admin/counties/title.county_delete');

        // Show the page
        return View::make('admin/counties/delete', compact('county', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $county
     * @return Response
     */
    public function postDelete($county) {
        // Declare the rules for the form validation
        $rules = array(
            'id' => 'required|integer'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            $id = $county->id;
            $county->delete();

            // Was the county county deleted?
            $county = County::find($id);
            if (empty($county)) {
                // Redirect to the county counties management page
                return Redirect::to('admin/counties')->with('success', Lang::get('admin/counties/messages.delete.success'));
            }
        }
        // There was a problem deleting the county county
        return Redirect::to('admin/counties')->with('error', Lang::get('admin/counties/messages.delete.error'));
    }

    /**
     * Show a list of all the county counties formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData() {
        $counties = County::select(array('counties.id', 'counties.title'));

        return Datatables::of($counties)
                        ->add_column('actions', '<a href="{{{ URL::to(\'admin/counties/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >編輯</a>
                <a href="{{{ URL::to(\'admin/towns/create/\' . $id ) }}}" class="btn btn-default btn-xs iframe" >新增鄉鎮市區</a>
                <a href="{{{ URL::to(\'admin/counties/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">刪除</a>
            ')
                        ->make();
    }

}