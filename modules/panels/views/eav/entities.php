<?php

class supa_modules_panels_views_eav_entities extends supa_view {

    public function getEntities()
    {
        return $this->model('panels/users')->getEntities();
    }

    public function grabEntityLabel($entity)
    {
        return $this->model('panels/eav')->getEntityLabel($entity, true);
    }

}