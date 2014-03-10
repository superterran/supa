<?php

class supa_modules_install_models_config extends supa_object
{
    const SAMPLE_FILE = 'config.xml.sample';
    const CONFIG_FILE = 'config.xml';
    protected $blacklist = array('responseCode', 'controls', 'theme');

    public function getDefaultsFromSample()
    {
        $xml = simplexml_load_file($this->getConfig('path/basedir').self::SAMPLE_FILE);

        $installer = array();
        foreach($xml as $part => $data)
        {
            if(in_array($part, $this->blacklist)) continue;
            $installer[$part] = array();
            foreach($data as $key => $val) {
                $installer[$part][$key] = (string) $val;
            }
        }
        return $installer;
    }

    /**
     * performs a core install... this needs to be migrated to a setup script in the EAV module, doing it this way
     * to buld something out. Surely a basic schema build-out here will be useful.
     * @param $data
     * @return bool
     */
    public function runCoreSetupScript($data)
    {
        $sql = file_get_contents($this->getConfig('path/basedir').'modules'.DS.'install'.DS.'install.sql');

        $my = @new mysqli($data['mysql_host'], $data['mysql_user'], $data['mysql_pass'], $data['mysql_database']);
        if($my->connect_error) {
            $this->setConfig('install_error', 'Could not connect to database: '.$my->connect_error); return false;
        }
        $sql = str_replace("{{prefix}}", $data['mysql_prefix']._, $sql);
        $my->query($sql);
        return true;
    }

    public function createConfigXml($data)
    {
        $xml = simplexml_load_file($this->getConfig('path/basedir').self::SAMPLE_FILE);
        unset($data['startinstall']);
        foreach($data as $key => $val) {
            $parts = explode(_, $key);
            $xml->$parts[0]->$parts[1] = $val;
        }

        $file = $this->getConfig('path/basedir').self::CONFIG_FILE;
        @$xml->asXml($file);

        if(file_exists($file)) {
            return true;
        } else {
            $this->setConfig('install_error', 'Could not create config.xml, are you sure the directory is writable?');
            return false;
        }
    }
}