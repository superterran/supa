<?php

class supa_modules_install_controls_index extends supa_control {

    /**
     * This will provide a basic installer support... needs to show love for all modules, be flexible (i.e. if I need
     * to build an installer for a custom app based on this, the install module will help), and be removable after install
     */
    public function indexAction()
    {
        $config = $this->model('install/config');

        if(isset($_POST['startinstall'])) {
            if($config->runCoreSetupScript($_POST)) {
                if($config->createConfigXml($_POST)) {
                    header('location: '.$this->getConfig('path/baseurl')); exit;
                }
            }
        }

        $this->setConfig('theme', 'install');
        $this->setConfig('install_data', $config->getDefaultsFromSample());
        $this->addLayout('install', '<h2>License</h2><div class="license">'.file_get_contents($this->getConfig('path/basedir').'license.txt').'</div>');
    }
}