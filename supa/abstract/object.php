<?php

abstract class supa_object {

    /**
     * Implements a getter/setter system that allows for a nifty
     * global data structure.
     *
     * Doing $this->getModule('mailer')->someMethod(); will
     * always hit the main object. Good glue.
     *
     * @param $methodName
     * @param $params
     * @return mixed
     */
    public function __call($methodName, $params) {

        $mainObj =&supa_mediator::$_all; // This works, but it needs to be more modular. Set in config sorta thing
        $methodPrefix = substr($methodName, 0, strlen(preg_replace("/^([a-z]*)[A-Z].*$/", "$1", $methodName))); // the 'get'Module part of getModule();
        $spineKey = '_'.strtolower(substr($methodName, strlen(preg_replace("/^([a-z]*)[A-Z].*$/", "$1", $methodName)))); // the key of the $mainObj we're trying to access

        $path = false; if(isset($params[0])) $path = $params[0];
        $value = false; if(isset($params[1])) $value = $params[1];

//        if(!$params[1] = 'observe') $this->observe('supa_call_'.$methodName); // calling observer manually so not to cause recursion
//        var_dump($methodPrefix, $spineKey, $path, $value); echo '<br><br>';
//
        switch($methodPrefix)
        {
            /**
             * Specific getters/setters for pretty parts of the implementation.
             * I'm seperating these two with comments because I know these need to
             * be super modular.
             *
             * let's $this->getView('blog/item') return an instantiated class
             */
            case "observe": // Show a view object
                return $this->getModule('observe')->event($path, $value);
            break;

            case "view": // Show a view object
                return $this->getModule('layout')->getView($path);
            break;

            case "html": // Show a view object
                return $this->getModule('layout')->getChildHtml($path);
            break;

            case "class": // Returns the appropriate thing based on classname
                return $this->fetchFromClassname($path);
            break;

            case "model": // provide a model singleton
           //     var_dump($path); die();
                $model = $this->getModels($path);

                if(!isset($model['object'])) {
                    $class = $this->instantiate($model['class']);
                    $model['object'] =& $class;
                }
                return $model['object'];
            break;


            /**
             * Global Getters and Setters,
             * calling $this->getWhatever() anywhere inside any class extending
             * off of this object will get data from the mediator object, where 'whatever'
             * is part of the $_all spine. This provides the plumbing that makes the framework useful.
             *
             * $this->setWhatever('name', 'value'); will populate this data object.
             * if I have a new section of data I want to add, like Modules or Layout,
             * I can create my new global data object by $this->setNewdataobj($allmydata)
             * and add to it with $this->setNewdataobj('partofallmydata', 'value');
             *
             * Hoping 'Models' will simply supply persistance and filtering to this so
             * we have the one interface to do damn near everything.
             */
            case "get":
//                var_dump($methodName.'+'.$path, $params);
                if(isset($mainObj[$spineKey])) return $this->getPath($mainObj[$spineKey], $path); else return false;
            break;

            case "set":

                if($path && $value) {
                    if(!isset($mainObj[$spineKey])) {
                        $mainObj[$spineKey] = array();
                    }

                    $parts = explode(DS, $path);

                    if(!isset($parts[1])) {
//                        var_dump($value);
                        $mainObj[$spineKey][$path] = $value;
                    } else {
                        /**
                         * Setter's merge an assostive array containning the data
                         * into the target spine array. It's a painless and powerful way to update
                         * an array en mass. Building the nested array as a string and converting it to an
                         * array with json because doing it the right way is really hard.
                         */
                        $uri = explode('/', $path);
                        $front  = false; $back   = false;
                        foreach($uri as $part) {
                            $front .= '{ "'.$part.'" : '; $back  = " }".$back;
                        }

                        $new = json_decode($front.'"'.$value.'"'.$back, 1);

                        $mainObj[$spineKey] = array_merge_recursive($mainObj[$spineKey], $new);
                    }

                } elseif(isset($path)) $mainObj[$spineKey] =  $path; // if 'path' is populated only, assume this is an assoaitive array of values

            return $this;
            break;

            case "add":
//                var_dump($params[0], $params[1]);
                if(isset($params[1])) {
                    $mainObj[$spineKey][$params[0]][] = $params[1];
                } elseif(isset($params[0])) {
                    if(is_string($mainObj[$spineKey][$params[0]]))
                    {
                        $mainObj[$spineKey][$params[0]] = array($mainObj[$spineKey][$params[0]]);
                    }
                } else {
                    $mainObj[$spineKey][$params[0]] = array();
                }
                return $this;
            die();
            break;

            case 'merge':
            if(isset($params[0]) && isset($params[1])) {
                $mainObj[$spineKey][$params[0]] = array_merge_recursive($mainObj[$spineKey][$params[0]], $params[1]);
            }

        }

        // better error handling
        if(strtolower(substr($methodName, -6)) == 'action') { // if a control action, we probably want a 404 page

            return $this;

        }

        echo '<pre><h3>method does not exist:'. $methodName.'<h3>';
        var_dump(debug_backtrace());
        echo '</pre>';
    //    die();
    }


    /**
     * Gets part of an object based on a string 'path' representing a
     * point in our supa data object
     * @param $obj
     * @param $path
     * @return mixed
     */
    protected function getPath(&$obj, $path)
    {
        $path = explode(DS, $path);
        $_obj = $obj;
        if(is_array($path)):
            foreach($path as $part) if(isset($_obj[$part])) $_obj = $_obj[$part];
        endif;

        // sanitization

        if(empty($_obj)) return false;
        if(is_string($_obj) && $_obj == 'false') return (bool) false; // thank god
        if(is_string($_obj) && $_obj == 'true') return (bool) true; // thank god

        return $_obj;
    }

    /**
     * Instantiates a class, because it does a lot of that.
     * @param $classname
     * @param bool $params
     * @return mixed
     */
    protected function instantiate($classname, $params = false)
    {
        require_once($this->getClassFilepath($classname));
        return new $classname($params);

    }

    /**
     * returns the php file for a given class name.
     * @param $classname
     * @return string
     */
    protected function getClassFilepath($classname)
    {
        return $this->getConfig('path/basedir').str_replace(_, DS, $classname.PHP);
    }

    /**
     * pass in a path 'example/index/index', get a url.
     * @param $path
     * @return string
     */
    public function getUrl($path)
    {

        if(!is_string($path)) return $this->getConfig('path/baseurl');

        $path = explode(DS, $path);

        $url = $this->getConfig('path/baseurl');
        if(array($path)) {

            foreach($path as $part)

            $url = $url . $part . DS;

        } else {

            $url = $url . $path;

        }

        return $url;
    }

}
