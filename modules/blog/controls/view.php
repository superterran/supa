<?php

class supa_modules_blog_controls_view extends supa_control {

    public function slugAction()
    {
        $slug = $this->getModule('front')->getParamsFromUrl();
        $this->addLayout('content', $this->view('blog/view')->getBySlug($slug));
    }

    public function idAction()
    {
        $id = $this->getModule('front')->getParamsFromUrl();
        $this->addLayout('content', $this->view('blog/view')->getById($id));
    }

}