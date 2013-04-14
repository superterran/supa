<?php

class supa_modules extends supa_object {

    /**
     * On load, require all abstract classes and load modules to the mediator.
     */
    public function __construct()
    {
        $this->loadModules();
    }

    protected function loadModules()
    {
        foreach(glob(dirname(__FILE__).DS.'*') as $moduledir)
        {

            if(basename($moduledir) == 'abstract') continue;
            elseif(is_dir($moduledir))
            {
                $modulexml = simplexml_load_file($moduledir.DS.'module.xml');
                $this->setModule(basename($moduledir).'/path', $moduledir.DS); //sets a path variable in the module
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
