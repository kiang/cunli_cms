<?php

use Illuminate\Support\Facades\URL; # not sure why i need this here :c
use Robbo\Presenter\PresentableInterface;

class Town extends Eloquent implements PresentableInterface {
    
    public $timestamps = false;

    /**
     * Get the URL to the post.
     *
     * @return string
     */
    public function url() {
        return Url::to($this->slug);
    }

    public function getPresenter() {
        return new TownPresenter($this);
    }

}
