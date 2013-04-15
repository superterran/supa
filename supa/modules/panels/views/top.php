<?php

class supa_modules_panels_views_top extends supa_view {

    public function __construct()
    {
        $this->setLayout('supa.js_after', $this->getPanelInit());
        parent::__construct();
    }


    public function getPanelInit()
    {
        if($this->getSession('justLoggedIn') == false)
        {
            $output = "$('panel').show();$('panel').style.top = -30;"; //@todo fix this
        } else {
            $output = "Effect.Appear($('panel'));";
        }

        $this->setSession('justLoggedIn',  'false');

        return $output;
    }

    public function firstLogin()
    {
        $this->setSession('justLoggedIn', 'true');
    }

}