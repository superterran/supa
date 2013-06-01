<?php

class supa_modules_pages_controls_index extends supa_control {

    public function indexAction()
    {
        $file = $this->getConfig('path/basedir').'pages/home.phtml';
        $this->setLayout('content', $this->getModule('layout')->outputBuffer($file));
    }

    public function errorAction()
    {

        $url = $this->getModule('front')->getPathFromUrl();

        $file = $this->getConfig('path/basedir').'pages/'.$url[0].'.phtml';

        if(is_file($file)) {

            $this->setLayout('content', $this->getModule('layout')->outputBuffer($file));
        } else {

            $this->setLayout('content', $this->getModule('layout')->outputBuffer($this->getConfig('path/basedir').'pages/404.phtml'));

        }


    }

}