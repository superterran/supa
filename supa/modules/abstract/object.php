<?php

abstract class supa_object {

    /**
     * Implements a getter/setter system that allows for a nifty
     * global data structure.
     *
     * Hopefully, doing $this->getModule('mailer')->someMethod(); will
     * always hit the main object. Good glue.
     *
     * @param $name
     * @param $params
     * @return mixed
     */
    public function __call($name, $params) {

        $prefix = strlen(preg_replace("/^([a-z]*)[A-Z].*$/", "$1", $name));
        $action = '_'.lcfirst(substr($name, $prefix));

        $obj =&supa_mediator::$_all;

        switch(substr($name, 0, $prefix))
        {
            case "get":
                //var_dump($obj, $action);
                if(isset($obj[$action])) {

                    if($action) $_obj =& $obj[$action];
                    if(!$params) return $_obj; elseif(isset($_obj[$params[0]])) {

//                        var_dump($name, $action, $params, $_obj[$params[0]]); echo '<br><br>';
                        if(is_string($_obj[$params[0]])) {
                            return $_obj[$params[0]];
                        } else {
                            return $_obj[$params[0]];
                        }
                    } else {
                        $_cfg = $this->getConfig();
                        foreach(explode(DS, $params[0]) as $part) {
                            if(isset($_cfg[$part])) $_cfg = $_cfg[$part];
                        }
                        return $_cfg;
                    }
                }
                return;
                break;

            case "set":
                if(isset($params[0]) && isset($params[1])) {
                    if(!isset($obj[$action])) {
                        $obj[$action] = array();
                    }

                    $parts = explode(DS, $params[0]);

                    if(!isset($parts[1])) {
                        $obj[$action][$params[0]] = $params[1];
                    } else {
                        $uri = explode('/', $params[0]);
                        $front  = false;
                        $back   = false;
                        foreach($uri as $part)
                        {
                            $front .= '{ "'.$part.'" : ';
                            $back  = " }".$back;
                        }
                        $new = json_decode($front.'"'.$params[1].'"'.$back, 1);
                        $obj[$action] = array_merge_recursive($obj[$action], $new);
                    }


                } elseif(isset($params[0])) {
                    $obj[$action] =  $params[0];
                }
                return $this;
                break;
        }


        echo 'method does not exist:'. $name.'<br>';
        var_dump(debug_backtrace());
        die();
    }
}