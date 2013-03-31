<?php

define('DS', DIRECTORY_SEPARATOR);
define('_', '_');
define('PHP', '.php');

/**
 * Mediator provides a common base so all the parts can work together.
 * It's like a really shitty kernel
 */
require_once(__DIR__ . DS . 'abstract/object.php');
class supa_mediator extends supa_object {

    static $_all = array();

    //load these first
    protected $_order = array(
        'modules'
    );

    const CLASS_PREFIX = 'supa';
    const CONFIG_PATH = 'config.xml';
    const ABSTRACT_DIRNAME = 'abstract';


    public function __construct()
    {


        $this->loadConfig()
            ->setConfig('path/basedir', realpath(__DIR__.DS.'..').DS)
            ->setConfig('path/baseurl',  'http://'.$_SERVER['HTTP_HOST'].DS)
            ->setConfig('path/appdir', $this->getConfig('path/basedir').self::CLASS_PREFIX.DS)
            ->setConfig('path/appurl', $this->getConfig('path/baseurl').self::CLASS_PREFIX.DS)
            ->setConfig('path/absdir', $this->getConfig('path/appdir').self::ABSTRACT_DIRNAME.DS);

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
        foreach(glob($this->getConfig('path/absdir').'*'.PHP) as $file) require_once($file); // load abstract classes

        $loadpath = __DIR__.DS.'modules'.DS;

        foreach(glob($loadpath.'*'.PHP) as $module)
        {
            require_once($module);

            $classname = str_replace(PHP, '', self::CLASS_PREFIX._.basename($module)); // supa_modules, for example
            $name = str_replace(PHP, '', basename($module)); // modules, for example
            if(class_exists($classname)) $this->setModule($name, new $classname());
        }
    }

    /**
     * Loads config.xml into memory
     */
    public function loadConfig()
    {
        $this->setConfig((array) json_decode(json_encode(simplexml_load_file(__DIR__.DS.self::CONFIG_PATH)), true));
        return $this;
    }


}