<?php

class supa_front extends supa_object {

    /**
     * Implements a Front Controller pattern to determine what output to render
     */
    public function control()
    {
        // grab data from URL
        if(isset($_SERVER['REDIRECT_URL'])) {
            $action = explode(DS, substr($_SERVER['REDIRECT_URL'], 1));
        } else {
            $action = explode(_, $this->getConfig('control_default'));
        }

        $controls = $this->getControls();

        /*
         * Figures out what controller action we want from URL array
         */
        if(isset($controls[$action[0]][$action[1]])) {
            $classname = $controls[$action[0]][$action[1]];
        } elseif($controls[$action[0]]) {
            $classname = $controls[$action[0]];
        } else {
            $classname = $this->getConfig('default_controlaction');
        }

        require_once(str_replace(_, DS, $classname).'.php'); // get controller path from classname
        $controller = new $classname(); // instantiate controller

        /*
         * deterimine what action to use
         */
        if(isset($action[2])) {
            $actionMethod = $action[2].'Action';
        }else {
            $actionMethod = 'indexAction';
        }

        $controller->$actionMethod(); // fire method
        return $this;
    }

}