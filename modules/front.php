<?php

class supa_front extends supa_object {


    /**
     * Implements a Front Controller pattern to determine what output to render
     */
    public function control()
    {
        $controls = $this->getControls();
        $ctrlaction = $this->getLayoutHandle();

        $classname = $controls[$ctrlaction[0]][$ctrlaction[1]];

        require_once($this->getClassFilepath($classname)); // get controller path from classname
        $controller = new $classname(); // instantiate controller

        if(isset($ctrlaction[2])) // deterimine what action to use
        {
            $actionMethod = $ctrlaction[2].'Action';
        }else {
            $actionMethod = 'indexAction';
        }

        $controller->$actionMethod(); // fire method

        return $this;

    }

    public function getLayoutHandle($handle = 'fromUrl')
    {
        $_default = explode(_, $this->getConfig('controls/default/index'));

        if($handle == 'fromUrl') {
            if(isset($_SERVER['REDIRECT_URL'])) {
                $_handle = $this->getPathFromUrl();
            } else {
                $_handle = $_default;
            }
        }

        foreach($_default as $key=>$val)
        {
            if((!isset($_handle[$key])) ||( $_handle[$key] == "")) $_handle[$key] = $val;
        }

        /**
         * Determines if what generated is valid, if not, use layout handle for error
         */

        $controls = $this->getControls();

        if(!isset($controls[$_handle[0]][$_handle[1]])) // detects if a valid ctrlaction
        {
            $_handle = explode(_, $this->getConfig('controls/default/error'));
            $this->setConfig('responseCode', 404);
        }

        return $_handle;
    }

    public function getPathFromUrl()
    {
        return $_handle = explode(DS, substr($_SERVER['REDIRECT_URL'], 1));
    }

    public function getParamsFromUrl()
    {
        $_url = explode(DS, substr($_SERVER['REDIRECT_URL'], 1));

//        unset($_url[0]);
//        unset($_url[1]);
//        unset($_url[2]);

       return $_url[3];

    }

}