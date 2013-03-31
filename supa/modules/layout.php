<?php

class supa_layout extends supa_view {
//
//    const HTTP_RESPONSE_SUCCESS = 200;
//    const HTTP_RESPONSE_ERROR = 400;
//    const HTTP_RESPONSE_NOTFOUND = 404;

    public function render()
    {
        $theme_path = $this->getConfig('path/appdir').'themes'.DS.$this->getConfig('theme').DS.'theme.phtml';

        // sets theme paths
        $this->setConfig('path/themedir', $this->getConfig('path/appdir').'themes'.DS.$this->getConfig('theme').DS);
        $this->setConfig('path/themeurl', $this->getConfig('path/appurl').'themes'.DS.$this->getConfig('theme').DS);

        http_response_code($this->getConfig('responseCode'));
        require_once($theme_path);

    }

}