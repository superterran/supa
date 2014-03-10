<?php

/**
 * Mediator provides a common base so all the parts can work together.
 * It's like a really shitty kernel
 */
require_once(dirname(__FILE__) . DS . 'object.php');
class supa_mediator extends supa_object {

    static $_all = array();

    //load these first
    protected $_order = array();

    const CLASS_PREFIX = 'supa';
    const CONFIG_PATH = 'config.xml';
    const ABSTRACT_DIRNAME = 'abstract';


    public function __construct()
    {
       $this->setConfig('path/appdir', realpath(dirname(__FILE__)).DS)
            ->setConfig('path/basedir', $this->getConfig('path/appdir').DS)
            ->setConfig('path/baseurl',  'http://'.$_SERVER['HTTP_HOST'].DS)
            ->setConfig('path/appurl', $this->getConfig('path/baseurl').DS)
            ->setConfig('path/modulesdir', $this->getConfig('path/appdir').'modules'.DS)
            ->setConfig('path/absdir', $this->getConfig('path/modulesdir').self::ABSTRACT_DIRNAME.DS)
            ->setConfig('path/configxml', $this->getConfig('path/appdir').self::CONFIG_PATH);

        $this->loadConfigXml();

        $this->_order[] = $this->getConfig('path/modulesdir').'session.php';
        $this->_order[] = $this->getConfig('path/modulesdir').'modules.php';

        $this->loadModules();
    }

    /**
    * Loads root of modules. This doens't actually manage the module
    * directories, that's done by the 'modules' module. Any other top
    * level files will also be auto-instantiated and can provide low
    * level functionality
    */
    protected function loadModules()
    {
        $loadpath = $this->getConfig('path/modulesdir');
        $_sorted = array_merge_recursive($this->_order, glob($loadpath.'*'.PHP));

	    foreach($_sorted as $module)
        {
            if(require_once($module))
            {
                $classname = str_replace(PHP, '', self::CLASS_PREFIX._.basename($module)); // supa_modules, for pages
                $name = str_replace(PHP, '', basename($module)); // modules, for pages
                if(class_exists($classname) && !is_object($this->getModule($name))) $this->setModule($name, new $classname());
            }
        }
    }

    /**
    * Loads config.xml into memory
    */
    public function loadConfigXml()
    {
        if(file_exists($this->getConfig('path/configxml'))) {
            $current_config = $this->getConfig();
            $xml = simplexml_load_file($this->getConfig('path/configxml'));
            $new_config = json_decode(json_encode($xml), true);
            $this->setConfig(array_merge_recursive($new_config, $current_config));
            return $this;
        } elseif(file_exists($this->getConfig('path/configxml').'.sample')) {
            if($_SERVER['REQUEST_URI'] != '/install/') {
                header('location: '.$this->getConfig('path/baseurl').'install/'); exit();
            } else {
            //    die('installer');
            }
        } else  {
            $this->log("Couldn't load configuration, config.xml does not exist."); exit();
        }

        return $this;
    }

}
