<?php

class supa_modules_blog_views_list extends supa_view {

    public function getPosts()
    {

        var_dump($this->model('blog/posts')->getCollection());


        $data = array(

            'title'=>'My First Blog Post',
            'byline'=>'Douglas Shawnan Hatcher, Esq.',
            'status'=>'live',
            'content'=>'<p>This is a test of my super awesome data model</p>'
        );
        $this->model('blog/posts')->addData($data);

        return $this->view('blog/item')->toHtml();
    }

}