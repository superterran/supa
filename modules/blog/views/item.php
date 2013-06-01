<?php

class supa_modules_blog_views_item extends supa_view {

    public function getViewUrl()
    {
        if(is_string($this->getData('slug'))) {
            return $this->getConfig('path/baseurl').'blog/view/slug/'.$this->getData('slug');
        } elseif(is_string($this->getData('id'))) {
            return $this->getConfig('path/baseurl').'blog/view/id/'.$this->getData('id');
        } else {
            return '#';
        }
    }

}