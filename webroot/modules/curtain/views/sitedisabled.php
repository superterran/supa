<?php

class supa_modules_curtain_views_sitedisabled extends supa_view {

//
//
//    public function getPanelInit()
//    {
//        if($this->getSession('justLoggedIn') == false)
//        {
//            $output = "$('panel').show();$('panel').style.top = -30;"; //@todo fix this
//        } else {
//            $output = "Effect.Appear($('panel'));";
//        }
//
//        $this->setSession('justLoggedIn',  'false');
//
//        return $output;
//    }
//
    public function isActive() {
        if($this->getConfig('app/password') != 'false') {
            if(!is_string($this->getSession('curtain'))) $this->setSession('curtain', 'true');
        }

        return $this->getSession('curtain');
    }

}