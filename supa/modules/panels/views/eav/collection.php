<?php

class supa_modules_panels_views_eav_collection extends supa_view {

    public function grabEntityLabel()
    {
        return $this->model('panels/eav')->getEntityLabel($this->getDo('entity'));
    }

    public function grabAttributes()
    {
        return $attributes = $this->model('panels/eav')->getAllAttributes($this->getDo('entity'));
    }

    public function grabCollection()
    {
        return $collection = $this->model('panels/eav')->getCollectionByEntity($this->getDo('entity'));
    }

}