<?php

class supa_modules_panels_models_kinds extends supa_model_eav {


    public function grab($kind, $data = array())
    {
        return $this->view('panels/kinds/'.$kind)->setData($data);
    }


}
