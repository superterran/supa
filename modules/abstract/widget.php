<?php

abstract class supa_widget extends supa_view {

    public $_subblock = false;

    public function outputBuffer($file = false)
    {
        $this->_subblock = $this->phtml;

//        var_dump($this->_subblock);

        echo parent::outputBuffer($this->getConfig('path/basedir').'themes/default/widget.phtml');


    }

    public function getWidgetContent() {

        $this::getPhtml();
        return parent::outputBuffer($this->_subblock);
    }

    public function getSelectorClass()
    {
        $tmp = str_replace('supa_modules_', '', get_class($this));
        $tmp = str_replace('_views_', '_', $tmp);
        $tmp = str_replace('_', '-', $tmp);
        return $tmp;
    }

}