<?php

abstract class supa_view extends supa_object {

    protected $phtml = false;

    public function __construct($phtml = null)
    {
        if($phtml) $this->phtml = $phtml;
        $this->phtml = $this->getPhtml(get_class($this));
    }


    public function toHtml()
    {
        if(is_file($this->getPhtml())) {

            // this appears to be the best way to do it
            $output = "";
            ob_start( );
            include($this->getPhtml());
            $output .= ob_get_clean();

            return $output;
        }
    }

    public function getPhtml($classname = null)
    {
        $phtml = $this->phtml;
        if((!$phtml) || (!is_file($phtml)))
        {
            $phtmlname = str_replace('_views_', '_phtml_', $classname);
            $this->phtml = $this->getConfig('path/basedir').str_replace('_',DS, $phtmlname).'.phtml';
        }
        return $this->phtml;
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
            $view['object'] = $this->instantiate($view['class'], $view['phtml']);
        }
        if(isset($view['class'])) return $view['object']; else return false;
    }

    public function getChildHtml($part)
    {
        $_layouts = $this->getLayout();
        $_layout = $this->getPath($_layouts, $part);

        $output = '';
        foreach($_layout as $item) $output = $output.$item->toHtml();
        return $output;


    }
}