<?php

abstract class supa_view extends supa_object {

    protected $phtml = false;
    public $_active = true;

    public function __construct($phtml = null)
    {
        if($phtml) $this->phtml = $phtml;
        $this->phtml = $this->getPhtml(get_class($this));
    }


    public function toHtml()
    {
        if(is_file($this->getPhtml())) {

            $_data = $this->getData();
      //      var_dump($_data);
            if(!isset($_data['eid']) || !$_data['eid']) return $this->outputBuffer();// using view individually

            $output = '';

            foreach($this->getData() as $item) // iterating through collection
            {
                 $output .= $this->setData($item)->outputBuffer();
            }
            return $output;

          //  return $this->__output(); // fallback
        }
    }

    protected function outputBuffer($file = false)
    {
        if(!$file) $file = $this->getPhtml();

        $output = "";
        ob_start( );
        include($file);
        $output .= ob_get_clean();
        return $output;
    }

    public function getPhtml($classname = null)
    {
        $phtml = $this->phtml;
        if((!$phtml) || (!is_file($phtml)))
        {
            $phtmlname = str_replace('_views_', '_phtml_', $classname);
            $this->phtml = $this->getConfig('path/basedir').str_replace('_',DS, $phtmlname).'.phtml';
        }

        if($this->isActive()) {
            return $this->phtml;
        } else {
            return false;
        }

    }



    /**
     * Returns HTML formatted output for template from any part of Layout
     * @param $part
     * @return string
     */
    public function getView($part)
    {
        $_views = $this->getViews();
        $view = $this->getPath($_views, $part);
        if(!isset($view['object']) && isset($view['class'])) {
            if(!isset($view['phtml'])) $view['phtml'] = false;
            $view['object'] = $this->instantiate($view['class'], $view['phtml']);
        }
        if(isset($view['class'])) return $view['object']; else return false;
    }

    public function getChildHtml($part)
    {
        $_layouts = $this->getLayout();
        $_layout = $this->getPath($_layouts, $part);

        $output = '';

        if(is_array($_layout)) {
            foreach($_layout as $item) {
                if(is_object($item)) $output = $output.$item->toHtml();
            }
        }  elseif(is_string($_layout)) { // because, presumably, some pages just want to dump text to layout
            $output = $_layout;
        }

        return $output;
    }

    public function hasChildHtml($part)
    {

        $_layouts = $this->getLayout();
        $_layout = $this->getPath($_layouts, $part);

        $count = 0;

        if(is_array($_layout)) {
            foreach($_layout as $item) {
                if(is_object($item)) $count++;
            }
        }  elseif(is_string($_layout)) { // because, presumably, some pages just want to dump text to layout
            $count = 1;
        }

//        var_dump(count($_layout), $count); die();

        return $count;

    }


    public function hasMessages()
    {
        if(!is_array($this->getSession('messages'))) return false; else return count($this->getSession('messages'));
    }

    public function grabMessages()
    {
        $_msg = $this->getSession('messages');
        $this->setSession('messages', 'empty');
        if(is_array($_msg)) return $_msg; else return false;

    }

    /**
     * is the loaded view active?
     * @return bool
     */
    public function isActive()
    {
        return $this->_active;
    }

    public function setActive($bool = true)
    {
        $this->_active = $bool;
        return $this;
    }

    public function echoHtml()
    {
        echo $this->toHtml();
    }

}