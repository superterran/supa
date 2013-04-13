<?php
/**
 * Panel user model, user authentication
 * Class supa_modules_panels_models_users
 */
class supa_modules_panels_models_eav extends supa_model_eav {


    public function getCollectionByEntity($entity)
    {
        return $this->model('panels/eav')->setEntity($entity)->getCollection();

    }

    public function getAllAttributes($entity = false)
    {
        if($entity) $this->setEntity($entity);
        return $this->getAttributes();
    }

}
