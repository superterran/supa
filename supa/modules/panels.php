<?php

/**
 * Panels will show an overlay type thing depending on layout handle
 * so there's a public 'frontend' view, and then an augmented edit mode
 * view called a 'panel' you have to be logged in to use.
 */
class supa_panels extends supa_object {


    public function __construct()
    {

        if($this->model('panels/users')->isLoggedIn())
        {

            $this->addLayout('panels', $this->view('panels/main'));

            /**
             * Figuring out what to do based on layout handle...
             */
             $handle = $this->getModule('front')->getLayoutHandle();

        }
    }
}