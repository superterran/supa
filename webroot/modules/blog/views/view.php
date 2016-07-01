<?php

class supa_modules_blog_views_view extends supa_view {

    public function getBySlug($slug)
    {

        $posts = '';

        $collection = $this->model('blog/posts')->filter('slug', '=', $slug)->getCollection();

        foreach($this->model('blog/posts')->filter('slug', '=', $slug)->getCollection() as $item)
        {
            $posts .= $this->view('blog/item')->setData($this->model('blog/posts')->load($item['id']))->toHtml();
        }

        if($posts) $this->setData('content', $posts);
        return $this;

    }

    public function getById($id)
    {

        $this->setData('content', $this->view('blog/item')->setData($this->model('blog/posts')->load($id))->toHtml());
        return $this;

    }
}