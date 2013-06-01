<?php

/**
 * by convention, layout is in $this->getLayout()
 * Class supa_layout
 */
class supa_layout extends supa_view {

    public function curtainLogic()
    {
        $curtain = $this->view('curtain/sitedisabled');

        if($this->getConfig('app/password') == $this->getDo('curtain')) $this->setSession('curtain', 'true');

        if($curtain->isActive()) {
            if($this->getSession('curtain') != 'true') {
                echo $this->view('curtain/sitedisabled')->outputBuffer(); die();
            }
        }

    }

    public function render()
    {

        $this->curtainLogic();

        $themefile = $this->getConfig('path/appdir').'themes'.DS.$this->getConfig('theme').DS.'theme.phtml';

        // sets theme paths
        $this->setConfig('path/themedir', $this->getConfig('path/appdir').'themes'.DS.$this->getConfig('theme').DS);
        $this->setConfig('path/themeurl', $this->getConfig('path/appurl').'themes'.DS.$this->getConfig('theme').DS);

        return $this->outputBuffer($themefile);

    }

}