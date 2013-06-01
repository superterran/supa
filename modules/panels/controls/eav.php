<?php

class supa_modules_panels_controls_eav extends supa_control {

    public function addAction()
    {
        if($this->model('panels/users')->isLoggedIn()) {

            $entity = $this->instantiate($_POST['entity']);
            $payload = $_POST;
            unset($payload['entity']);

            $entity->addData($payload);

            $this->getModule('response')->setResponseBody($this->view('panels/eav/collection')->outputBuffer())->send(true);

        }



    }

}