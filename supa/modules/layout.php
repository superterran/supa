<?php

class supa_layout extends supa_view {

    public function render()
    {
        $themefile = $this->getConfig('path/appdir').'themes'.DS.$this->getConfig('theme').DS.'theme.phtml';

        // sets theme paths
        $this->setConfig('path/themedir', $this->getConfig('path/appdir').'themes'.DS.$this->getConfig('theme').DS);
        $this->setConfig('path/themeurl', $this->getConfig('path/appurl').'themes'.DS.$this->getConfig('theme').DS);

        return $this->getOutput($themefile);

    }

    protected function getOutput($file)
    {
        ob_start();
        require_once($file);
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

}