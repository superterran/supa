<?php
require('view.php');
class supa_modules_blog_controls_rss extends supa_modules_blog_controls_view {

    public function listAction()
    {
        $this->getModule('response')->setResponseBody($this->view('blog/rss')->outputBuffer())->send(true);
    }


}