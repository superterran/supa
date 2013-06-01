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
        echo parent::outputBuffer($this->_subblock);
    }

}