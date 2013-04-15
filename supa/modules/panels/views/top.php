<?php

class supa_modules_panels_views_top extends supa_view {

    public function __construct()
    {
        $this->setLayout('supa.js_after', $this->getPanelInit());
        parent::__construct();
    }


    public function getPanelInit()
    {
        if(!$this->getSession('panels/lastload') == true)
        {
            return "$('panel').show();"; //@todo fix this
        } else {
            $this->setSession('panels/lastload',  true);
            return "Effect.Appear($('panel'));";
        }


    }

}