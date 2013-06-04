<?php class supa_modules_pages_models_page extends supa_eav {

    public function getViewUrl($unique)
    {

        if(is_string($unique)) {
            $output = $this->getConfig('path/baseurl').(string) $unique;
        } elseif(is_int($unique)) {
            $output = $this->getConfig('path/baseurl').'pages/view/id/'. (string) $unique;
        } else {
            $output = '#';
        }

        return $output;

    }

}