<?php

class supa_modules_blog_views_widget_recent extends supa_widget {

    public function getTitle()
    {
        return 'Recent Posts';
    }

    public function getRecentPosts() {

        return $this->model('blog/posts')->getCollection();

    }

    public function getViewUrl($data)
    {
        if(isset($data['slug'])) $ident = (string) $data['slug']; else $ident = (int) $data['id'];
        return $this->model('blog/posts')->getViewUrl($ident);
    }

}