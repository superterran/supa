<?php

/**
 * No idea how to build this... doing it in old school mysql queries, going query-free next
 * Class supa_eav
 */
abstract class supa_model_eav extends supa_model
{
    protected $_tap = false;

    public function __construct()
    {
        $creds = $this->getConfig('mysql');
        if(empty($creds['pass'])) $pass=false; else $pass = $creds['pass'];
        $this->_tap = mysql_connect($creds['host'], $creds['user'], $pass);
        $this->init();

    }

    public function getCollection()
    {
        return $this->sql("select * from {{eav_table}} where entity = '{{eav_entity}}'");
    }

    public function getData()
    {

    }

    public function addData($data)
    {

        var_dump($data); die();

    }


    protected function sql($sql)
    {

        $list = array(
            '{{eav_table}}'=>$this->getConfig('mysql')['prefix']._.$this->getConfig('mysql')['eav_table'],
            '{{eav_entity}}'=>get_class($this),
        );

        foreach($list as $needle => $replace) $sql = str_replace($needle, $replace, $sql);

        var_dump($sql);
        return (array) mysql_query($sql, $this->_tap) or die ('<pre>'.mysql_error().'</php>');
    }

    protected function init()
    {

        $this->sql("use ".$this->getConfig('mysql/database').";");

       $this->sql("CREATE TABLE IF NOT EXISTS `{{eav_table}}` (
                      `id` int(11) NOT NULL,
                      `eid` int(11) DEFAULT NULL,
                      `entity` varchar(45) DEFAULT NULL,
                      `attribute` varchar(45) DEFAULT NULL,
                      `value` longtext,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    }
}