<?php

use Illuminate\Support\Facades\URL; # not sure why i need this here :c
use Robbo\Presenter\PresentableInterface;

class Cunli extends Eloquent implements PresentableInterface {
    
    public $incrementing = false;

    /**
     * Get the URL to the post.
     *
     * @return string
     */
    public function url() {
        return Url::to($this->slug);
    }

    /**
     * Get the county.
     *
     * @return County
     */
    public function county() {
        return $this->belongsTo('County', 'county_id');
    }

    /**
     * Get the town
     *
     * @return Town
     */
    public function town() {
        return $this->belongsTo('Town', 'town_id');
    }

    public function getPresenter() {
        return new CunliPresenter($this);
    }

}
