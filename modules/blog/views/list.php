<?php

class supa_modules_blog_views_list extends supa_view {

    public function getPosts()
    {
        $posts = '';

        foreach($this->model('blog/posts')->getCollection() as $item)
        {
            $posts .= $this->view('blog/item')->setData($item)->toHtml();
        }

        return $posts;

    }

}