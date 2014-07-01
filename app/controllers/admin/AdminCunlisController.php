<?php

class AdminCunlisController extends AdminController {

    /**
     * Cunli Model
     * @var Cunli
     */
    protected $cunli;

    /**
     * Inject the models.
     * @param Cunli $cunli
     */
    public function __construct(Cunli $cunli) {
        parent::__construct();
        $this->cunli = $cunli;
    }

    /**
     * Show a list of all the cunlis.
     *
     * @return View
     */
    public function getIndex() {
        // Title
        $title = Lang::get('admin/cunlis/title.cunli_management');

        // Grab all the cunlis
        $cunlis = $this->cunli;

        // Show the page
        return View::make('admin/cunlis/index', compact('cunlis', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate() {
        // Title
        $title = Lang::get('admin/cunlis/title.create_a_new_cunli');

        // Counties
        $counties = County::lists('title', 'id');
        
        // Towns
        $towns = Town::lists('title', 'id');

        // Show the page
        return View::make('admin/cunlis/create_edit', compact('title', 'counties', 'towns'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate() {
        // Declare the rules for the form validation
        $rules = array(
            'id' => 'required',
            'title' => 'required',
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            // Create a new cunli
            // Update the cunli data
            $this->cunli->id = Input::get('id');
            $this->cunli->title = Input::get('title');
            $this->cunli->county_id = Input::get('county_id');
            $this->cunli->town_id = Input::get('town_id');

            // Was the cunli created?
            if ($this->cunli->save()) {
                // Redirect to the new cunli page
                return Redirect::to('admin/cunlis/' . $this->cunli->id . '/edit')->with('success', Lang::get('admin/cunlis/messages.create.success'));
            }

            // Redirect to the cunli create page
            return Redirect::to('admin/cunlis/create')->with('error', Lang::get('admin/cunlis/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/cunlis/create')->withInput()->withErrors($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param $cunli
     * @return Response
     */
    public function getShow($cunli) {
        // redirect to the frontend
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $cunli
     * @return Response
     */
    public function getEdit($cunli) {
        // Title
        $title = Lang::get('admin/cunlis/title.cunli_update');

        // Counties
        $counties = County::lists('title', 'id');
        
        // Towns
        $towns = Town::lists('title', 'id');

        // Show the page
        return View::make('admin/cunlis/create_edit', compact('cunli', 'title', 'counties', 'towns'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $cunli
     * @return Response
     */
    public function postEdit($cunli) {

        // Declare the rules for the form validation
        $rules = array(
            'id' => 'required',
            'title' => 'required',
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            // Update the cunli data
            $cunli->id = Input::get('id');
            $cunli->title = Input::get('title');
            $cunli->county_id = Input::get('county_id');
            $cunli->town_id = Input::get('town_id');

            // Was the cunli updated?
            if ($cunli->save()) {
                // Redirect to the new cunli page
                return Redirect::to('admin/cunlis/' . $cunli->id . '/edit')->with('success', Lang::get('admin/cunlis/messages.update.success'));
            }

            // Redirect to the cunlis cunli management page
            return Redirect::to('admin/cunlis/' . $cunli->id . '/edit')->with('error', Lang::get('admin/cunlis/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/cunlis/' . $cunli->id . '/edit')->withInput()->withErrors($validator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $cunli
     * @return Response
     */
    public function getDelete($cunli) {
        // Title
        $title = Lang::get('admin/cunlis/title.cunli_delete');

        // Show the page
        return View::make('admin/cunlis/delete', compact('cunli', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $cunli
     * @return Response
     */
    public function postDelete($cunli) {
        // Declare the rules for the form validation
        $rules = array(
            'id' => 'required'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            $id = $cunli->id;
            $cunli->delete();

            // Was the cunli deleted?
            $cunli = Cunli::find($id);
            if (empty($cunli)) {
                // Redirect to the cunlis management page
                return Redirect::to('admin/cunlis')->with('success', Lang::get('admin/cunlis/messages.delete.success'));
            }
        }
        // There was a problem deleting the cunli
        return Redirect::to('admin/cunlis')->with('error', Lang::get('admin/cunlis/messages.delete.error'));
    }

    /**
     * Show a list of all the cunlis formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData() {
        $cunlis = Cunli::leftJoin('counties', 'counties.id', '=', 'cunlis.county_id')
                ->leftJoin('towns', 'towns.id', '=', 'cunlis.town_id')
                ->select(array('cunlis.id', 'counties.title as county', 'towns.title as town', 'cunlis.title'));

        return Datatables::of($cunlis)
                        ->add_column('actions', '<a href="{{{ URL::to(\'admin/cunlis/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >編輯</a>
                <a href="{{{ URL::to(\'admin/cunlis/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">刪除</a>
            ')
                        ->make();
    }

}
