<?php

class supa_modules_panels_views_debug extends supa_view {

    public function __construct()
    {
        parent::__construct();

        if($this->getConfig('app/debug') != 'true') {
            $this->setActive(false);
        }

        if(!$this->model('panels/users')->isLoggedIn())
        {
            $this->setActive(false);
        }

    }

}