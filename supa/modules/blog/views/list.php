<?php

class supa_modules_blog_views_list extends supa_view {

    public function getPosts()
    {


        var_dump($this->view('blog/item'));

        return 'these are my posts';

    }

}