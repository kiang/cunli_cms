<?php

use Illuminate\Support\Facades\URL; # not sure why i need this here :c
use Robbo\Presenter\PresentableInterface;

class Candidate extends Eloquent implements PresentableInterface {
    
    public $incrementing = false;

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

    /**
     * Get the cunli
     *
     * @return Cunli
     */
    public function cunli() {
        return $this->belongsTo('Cunli', 'cunli_id');
    }

    public function getPresenter() {
        return new CandidatePresenter($this);
    }

}
