<?php

class supa_modules_panels_controls_eav extends supa_control {

    public function addAction()
    {
        if($this->model('panels/users')->isLoggedIn()) {

            $entity = $this->instantiate($_POST['entity']);
            $payload = $_POST;
            unset($payload['entity']);
            unset($payload['_wysihtml5_mode']);

//            var_dump($entity->getAttributes());die('boom!');
            foreach($entity->getAttributes() as $key => $val)
            {
                if(isset($payload[$key]['kind'])) {
                    die($payload[$key]['kind']);
                }
            }

//            var_dump($payload); die();
            if(isset($payload['eid'])) {
                $eid = $payload['eid'];
                unset($payload['eid']);
                $entity->updateData($eid, $payload);

            } else {
                $entity->addData($payload);
            }
            $this->getModule('response')->setResponseBody($this->view('panels/eav/collection')->outputBuffer())->send(true);

        }



    }

}