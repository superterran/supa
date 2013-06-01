<?php

class supa_modules_blog_views_item extends supa_view {

    public function getViewUrl()
    {
        if(is_string($this->getData('slug'))) $ident = $this->getData('slug'); else $ident = $this->getData('id');
        return $this->model('blog/posts')->getViewUrl($ident);
    }

}