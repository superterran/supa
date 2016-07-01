<?php

class supa_modules_pages_views_page extends supa_view {

    public function getBySlug($slug)
    {

        $posts = '';

        $collection = $this->model('pages/page')->filter('slug', '=', $slug)->getCollection();

        foreach($this->model('pages/page')->filter('slug', '=', $slug)->getCollection() as $item)
        {
            $posts .= $this->view('pages/page')->setData($this->model('pages/page')->load($item['id']))->toHtml();
        }

        if($posts) $this->setData('content', $posts);
        return $this;

    }

    public function getById($id)
    {

        $this->setData('content', $this->view('blog/item')->setData($this->model('pages/page')->load($id))->toHtml());
        return $this;

    }
}