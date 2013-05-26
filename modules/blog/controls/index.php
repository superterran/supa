<?php

class supa_modules_blog_controls_index extends supa_control {

    public function indexAction()
    {
        $this->addLayout('content', $this->view('blog/list'));
    }
}