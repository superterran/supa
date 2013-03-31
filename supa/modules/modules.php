<?php

class supa_modules extends supa_object {

    const ABSTRACT_DIR = 'abstract';

    /**
     * On load, require all abstract classes and load modules to the mediator.
     */
    public function __construct()
    {
        $this->loadAbstract();
        $this->loadModules();
    }

    protected function loadAbstract()
    {
        foreach(glob(__DIR__.DS.self::ABSTRACT_DIR.DS.'*') as $file) require_once($file);
    }

    protected function loadModules()
    {
        foreach(glob(__DIR__.DS.'*') as $module)
        {

            if(basename($module) == 'abstract') continue;
            elseif(is_dir($module))
            {
                $modulexml = simplexml_load_file($module.DS.'module.xml');

                foreach($modulexml as $module => $data) {

                    $getterMethod = 'get'.ucfirst($module);

                    $current = $this->$getterMethod();

                    $setterMethod = 'set'.ucfirst($module);
                    $this->$setterMethod(array_merge_recursive((array) $current,(array) json_decode(json_encode($data), true)));
                }
            }
        }
    }
}