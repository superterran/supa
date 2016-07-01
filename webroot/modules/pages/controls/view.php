<?php

class supa_modules_pages_controls_view extends supa_control {

    public function slugAction()
    {
        $slug = $this->getModule('front')->getParamsFromUrl();
        $this->addLayout('content', $this->view('pages/page')->getBySlug($slug));
    }

    public function idAction()
    {
        $id = $this->getModule('front')->getParamsFromUrl();
        $this->addLayout('content', $this->view('pages/page')->getById($id));
    }

}