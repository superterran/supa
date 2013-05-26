<?php

/**
 * by convention, layout is in $this->getLayout()
 * Class supa_layout
 */
class supa_layout extends supa_view {


    public function render()
    {
        $themefile = $this->getConfig('path/appdir').'themes'.DS.$this->getConfig('theme').DS.'theme.phtml';

        // sets theme paths
        $this->setConfig('path/themedir', $this->getConfig('path/appdir').'themes'.DS.$this->getConfig('theme').DS);
        $this->setConfig('path/themeurl', $this->getConfig('path/appurl').'themes'.DS.$this->getConfig('theme').DS);

        return $this->outputBuffer($themefile);

    }

}