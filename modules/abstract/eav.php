<?php

/**
 * No idea how to build this... doing it in old school mysql queries, going query-free next
 * Class supa_eav
 */
require_once('model.php');
abstract class supa_eav extends supa_model
{
    protected $_tap = false;
    protected $_eid = false;

    const SELECT = "select * from {{eav_table}} ";
    const WHERE = " where entity = '{{eav_entity}}' ";
    const ORDER = " order by {{order_attribute}} {{order_sort}} ";

    const LIMIT = "limit {{limit}}";

    const DELETE = "delete from {{eav_table}} where eid = {{eid}}";

    protected $_select = false;
    protected $_where = false;
    protected $_filter = false;
    protected $_limit = false;
//    protected $_meta = false; // this flag determines rather a query gets the attribute values or the attribute meta data


    protected $_sql = false;

    protected $_entityname = false;

    protected $sql_hide_error = false;

    public function __construct()
    {
        $creds = $this->getConfig('mysql');
        if(empty($creds['pass'])) $pass=false; else $pass = $creds['pass'];
        $this->_tap = new mysqli($creds['host'], $creds['user'], $pass, $creds['database']);
        $result = $this->sql("describe {{eav_table}};");
        if(!$result) $this->createTable();
    }

    public function createTable()
    {
        $this->sql("
              CREATE TABLE if not exists `{{eav_table}}` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `eid` int(11) DEFAULT NULL,
                `entity` varchar(45) DEFAULT NULL,
                `meta` varchar(45) DEFAULT NULL,
                `attribute` varchar(45) DEFAULT NULL,
                `value` longtext,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=latin1;
        ");

    }

    public function getCollection($part = false)
    {

        $this->select();
        $this->where();
        $this->order();

        $col = $this->sql($this->_sql);

        if($col) {

            $_tmp = array();

            foreach($col as $item) {
                if($item['eid']) $_tmp[$item['eid']] = $this->load($item['eid']);
            }

            switch($part) {
                case 'first':
                   $return = reset($_tmp);
                break;

                default: $return = $_tmp;
            }
            return $return;
        } else {
            return array();
        }
    }

    public function loadBySlug($slug)
    {
        $entity = $this->sql($this->where()." and attribute = 'slug' and value = '".$this->clean($slug)."'");
        if($entity->fetch_assoc()) {
            //if($entity) return false;
            return $this->load($entity[0]['eid']);
        }
        return false;
    }

    public function load($eid)
    {
        $this->_eid = $eid;
        $_tmp = array();

        $entity = $this->sql($this->where());

        $_tmp['id'] = $eid;
        foreach($entity as $attr) $_tmp[$attr['attribute']] = stripslashes($attr['value']);

        return $_tmp;
    }

    public function delete($eid = null)
    {
        if($eid) $this->_eid = $eid;
        return $this->sql(self::DELETE);
    }

    public function updateData($eid, $data)
    {
        foreach($data as $attribute => $value) {

            $this->updateSingleAttribute($eid, $attribute, $value);

        }
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
//        var_dump($data);
        foreach($data as $attribute => $value) $this->addSingleAttribute($eid, $attribute, $value, 'false');
        return $this->load($eid);

    }

    public function eidGetNew()
    {
        $result = (array) $this->sql("select eid from {{eav_table}} order by eid desc limit 1");
        if(isset($result[0]['eid'])) $lasteid = (int) $result[0]['eid']; else $lasteid = 0;
        $lasteid++;
        return $lasteid;

    }

    protected function addSingleAttribute($eid, $attribute, $value, $meta = 'false')
    {
        return $this->sql("insert into {{eav_table}} (eid, entity, attribute, value, meta) values('$eid', '{{eav_entity}}', '$attribute', '".addslashes($value)."', '".(string) $meta."');");
    }

    protected function updateSingleAttribute($eid, $attribute, $value)
    {
        return $this->sql("update {{eav_table}} set value = '".addslashes($value)."' where attribute = '$attribute' and eid = $eid");
    }

    public function sql($sql, $debug = false)
    {
        $list = array(
            '{{eav_table}}'=>$this->getConfig('mysql/prefix')._.$this->getConfig('mysql/eav_table'),
            '{{eav_entity}}'=>$this->getEntity(),
            '{{eid}}'=>$this->getEid(),

            '{{limit}}'=> '100',
            '{{order_sort}}'=>'desc',
            '{{order_attribute}}'=>'eid'
        );

        foreach($list as $needle => $replace) $sql = str_replace($needle, $replace, $sql);

       if($debug) {
            echo '<pre>';
           var_dump($sql);
           echo '</pre>';

       }
        $result = $this->_tap->query($sql);
        if(!$result && !$this->sql_hide_error) echo ('<span style="color:red">error:</span> '.$this->_tap->error.'<br>'.$sql);

        if(!is_bool($result))
        {
            foreach($result as $row)
            {
                $col[] = (array) $row;
            }

            if(isset($col)) return $col;
            return $result;
        }

        return $result;

    }

    public function filter($attr, $cond, $val)
    {

        $this->_filter .= " and attribute = '$attr' and value $cond  '$val' ";
        $this->where();
        $this->sql($this->_sql);
        return $this;

    }

    public function order()
    {

        $this->_sql = $this->_sql.self::ORDER;
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

        $this->_sql .= $this->_where.$this->_filter;

        if($this->getEid()) $this->_sql.= ' and eid = {{eid}} ';
        return $this->_sql;

    }

    protected function limit()
    {
     //   $this->where();
        if(!$this->_limit) $this->_limit = self::LIMIT;
        $this->_sql = $this->_sql . $this->_limit;
        return $this;

    }

    /**
     * Returns list of EAV entities with labels from eav table
     * @return array
     */
    public function getStoredEntities()
    {
        $entities = $this->sql('select entity from {{eav_table}} group by entity desc');

        $data = array();
        if(!$entities) return false;
        foreach($entities as $entity)
        {
            $label = $this->getEntityLabel($entity['entity']);
            if(is_string($label)) $data[$entity['entity']] = $label;
        }

        return $data;
    }

    /**
     * Returns list of EAV entities with labels from module xml
     * @return array
     */
    public function getEntities()
    {
        $xml = $this->getModules('mergedXml');
        $ent = array();
        foreach($xml[0]['models'] as $key => $val) {
            foreach($val as $node => $data)
            if(isset($data['tap']) && $data['tap'] == 'eav') {
                $ent[$data['class']] = $val;
            }
        }

       // var_dump($ent);

        return $ent;
    }


    public function getEntityLabel($entity = false, $labelonly = false)
    {

        if(!$entity) $entity = $this->getEntity();
        $part = explode(_, $entity);

        if(isset($part[4])) {

            $entitylabel = $part[2].DS.$part[4].DS.'label';

            $stuff = $this->getModels($entitylabel);
            if($stuff) {
                if(is_array($stuff)) {
                    if($labelonly) return false; else return $stuff['class'];
                }
            }

            return $stuff;

        } else {

            return $entity;
        }

    }


    protected function getEntity()
    {
        if(!$this->_entityname) {
            $this->_entityname = get_class($this);
        }
        return $this->_entityname;
    }

    protected function setEntity($value)
    {
        $this->_entityname = $value;
        return $this;
    }

    /**
     * The goddamned attributes, not values!
     *
     * @return array
     */
    public function getAttributes()
    {
        $data = array();
        $sql = $this->sql( $this->where() . " and meta = 'false' ");
        if(!$sql) return false;
        foreach($sql as $attrib) {

            $getmeta = $this->sql($this->where(). " and meta = '".$attrib['attribute']."'");

            if($getmeta) {
                foreach($getmeta as $meta) {
                    $attrib[$meta['attribute']] = $meta['value'];
                }
            }

            /**
             * Format this to only show data about an entity attribute
             */
            unset($attrib['meta']);
            unset($attrib['id']);
            unset($attrib['eid']);
            unset($attrib['value']);
            /**
             * Beautify, adding kind and label if not exists as fallback so rest of panel will work gracefully
             */
            if(!isset($attrib['label'])) $attrib['label'] = ucfirst($attrib['attribute']);
            if(!isset($attrib['kind'])) $attrib['kind'] = 'textfield';
            $data[$attrib['attribute']] = $attrib;

        }

$data = false; // @todo merge above functionality with default from module.xml below. This forces load from module, which is good for now

        /**
         * If no attributes are found in database, load defaults from module xml
         */
        if(!$data) {
            foreach($this->getModules('mergedXml') as $part) {

                if(isset($part['eav'])) {

                    if(isset($part['eav'][$this->getEntity()])) {
                        $data = $part['eav'][$this->getEntity()]['attributes'];

                    }
                }
            }
        }

        return $data;

    }

    /**
     * Grabs Meta data from eav table
     * @param $attribute
     * @return array
     */
    protected function getMeta($attribute)
    {
        $sql = $this->sql($this->where() . ' and meta = "'.$attribute.'" ');
        $data = array();

        if(!empty($sql)) {
            foreach($sql as $var) {
                if($var['meta'] != 'false') $data[$var['attribute']] = $var['value'];
            }
        }
        return $data;
    }


    protected function getEid()
    {
        return $this->_eid;
    }

    public function clean($sql) {

        return addslashes($sql);

    }

}
