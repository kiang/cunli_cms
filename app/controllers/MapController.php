<?php

class MapController extends BaseController {

    /**
     * Returns all the blog posts.
     *
     * @return View
     */
    public function getIndex() {
        // Show the page
        return View::make('site/map/index');
    }

}
