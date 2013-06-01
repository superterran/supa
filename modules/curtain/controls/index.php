<?php

class supa_modules_curtain_controls_index extends supa_control {

    public function indexAction()
    {
        echo $this->view('curtain/sitedisabled')->outputBuffer(); die();
    }
}