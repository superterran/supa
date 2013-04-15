<?php

class supa_modules_blog_views_list extends supa_view {

    public function getPosts()
    {
       // echo '<pre>';

        $data = $this->model('blog/posts')->getCollection();
        foreach($data as $item)
        {
            $return = $this->view('blog/item')->setData($item)->toHtml();
        }

        return $return;

    }

}