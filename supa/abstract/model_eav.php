<?php

/**
 * No idea how to build this... doing it in old school mysql queries, going query-free next
 * Class supa_eav
 */
abstract class supa_model_eav extends supa_model
{
    protected $_tap = false;
    protected $_eid = false;

    const SELECT = "select * from {{eav_table}} ";
    const WHERE = " where entity = '{{eav_entity}}' ";
    const LIMIT = "limit {{limit}}";

    protected $_select = false;
    protected $_where = false;
    protected $_limit = false;

    protected $_sql = false;

    protected $sql_hide_error = false;

    public function __construct()
    {
        $creds = $this->getConfig('mysql');
        if(empty($creds['pass'])) $pass=false; else $pass = $creds['pass'];
        $this->_tap = mysql_connect($creds['host'], $creds['user'], $pass);
        $this->init();

    }

    public function getCollection($part = false)
    {

        $col = $this->sql($this->_sql);

        if($col) {

            $_tmp = array();

            foreach($col as $item) $_tmp[$item['eid']] = $this->load($item['eid']);

            switch($part) {
                case 'first':
                   $return = array_pop($_tmp);
                break;

                default: $return = $_tmp;
            }
            return $return;
        } else {
            return array();
        }
    }

    public function load($eid)
    {
        $this->_eid = $eid;
        $_tmp = array();
        $entity = $this->sql($this->select() , $this->where()." and eid = ".$eid.";");
        $_tmp['eid'] = $eid;
        foreach($entity as $attr)
        {

            $_tmp[$attr['attribute']] = $attr['value'];
        }

        return $_tmp;
    }

    public function setData()
    {

    }

    public function getData()
    {

    }

    public function addData($data)
    {

        $eid = $this->eidGetNew();
        foreach($data as $attr => $val) $this->addSingleAttribute($eid, $attr, $val);
        return $this->load($eid);

    }

    public function eidGetNew()
    {
        $result = $this->sql("select eid from {{eav_table}} order by eid desc limit 1");

        if(isset($result[0]['eid'])) $lasteid = (int) $result[0]['eid']; else $lasteid = 0;
        $lasteid++;
        return $lasteid;

    }

    protected function addSingleAttribute($eid, $attribute, $value)
    {
        return $this->sql("insert into {{eav_table}} (eid, entity, attribute, value) values('$eid', '{{eav_entity}}', '$attribute', '$value');");
    }

    public function sql($sql)
    {
        if(!$this->_tap) {

            var_dump($this->configMysql('host')); die();
            $this->sql = mysql_connect($this->config['mysql']['host'], $this->config['mysql']['user'], $this->config['mysql']['pass']);
            $this->sql('use '.$this->config['mysql']['dbname'].';');
        }

        $list = array(
            '{{eav_table}}'=>$this->getConfig('mysql')['prefix']._.$this->getConfig('mysql')['eav_table'],
            '{{eav_entity}}'=>get_class($this),
            '{{limit}}'=> '100'
        );

        foreach($list as $needle => $replace) $sql = str_replace($needle, $replace, $sql);

     //   var_dump($sql);
        $result = mysql_query($sql, $this->_tap);
        if(!$result && !$this->sql_hide_error) echo ('<span style="color:red">error:</span> '.mysql_error().'<br>'.$sql);

        if(!is_bool($result))
        {
            while($row = mysql_fetch_assoc($result))
            {
                $col[] = (array) $row;
            }

            if(isset($col)) return $col;
            return mysql_fetch_assoc($result);
        }

        return $result;

    }

    protected function init()
    {

        $this->sql("use ".$this->getConfig('mysql/database').";");

       $this->sql("
            CREATE TABLE if not exists `supa_eav` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `eid` int(11) DEFAULT NULL,
              `entity` varchar(45) DEFAULT NULL,
              `attribute` varchar(45) DEFAULT NULL,
              `value` longtext,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1");
    }


    public function filter($attr, $cond, $val)
    {

        $this->_sql = $this->where() . " and attribute = '$attr' and value $cond  '$val' ";
        return $this;

    }

    protected function select()
    {
        if(!$this->_select) $this->_select = self::SELECT;

        $this->_sql = $this->_select;
        return $this->_sql;
    }

    protected function where()
    {
        $this->select();
        if(!$this->_where) $this->_where = self::WHERE;
      //  var_dump($this->_where); die('aa');
        $this->_sql = $this->_sql . $this->_where;
        return $this->_sql;

    }

    protected function limit()
    {
     //   $this->where();
        if(!$this->_limit) $this->_limit = self::LIMIT;
        $this->_sql = $this->_sql . $this->_limit;
        return $this;

    }

}