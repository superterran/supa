<?php
/**
 * Panel user model, user authentication
 * Class supa_modules_panels_models_users
 */
class supa_modules_panels_models_eav extends supa_eav {


    public function getCollectionByEntity($entity)
    {

        $col = $this->model('panels/eav')->setEntity($entity)->getCollection();
        return $col;

    }

    public function getAllAttributes($entity = false, $ismeta = false)
    {
        if($entity) $this->setEntity($entity);
        return $this->getAttributes($ismeta);
    }

}
