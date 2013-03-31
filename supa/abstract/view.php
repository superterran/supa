<?php

abstract class supa_view extends supa_object {

    public $phtml = false;

    public function __construct($phtml = null)
    {
        if($phtml) $this->phtml = $phtml;
        $this->getPhtml(get_class($this));
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
        if((!$phtml) || !is_file($phtml) && ($classname))
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
        $_output = $this->getLayout($part);
        if(is_string($_output)) return $_output;
        elseif(is_array($_output)) { //Likely a view we can parse...
            $_buffer = '';
            foreach($_output as $__out) {
                if(isset($_output['class'])) {
                    return $this->instantiate($_output['class'], $_output['phtml'])->toHtml();
                } elseif (isset($__out['class'])) {
                    return $this->instantiate($__out['class'], $__out['phtml'])->toHtml();
                }
            }
        }
    }
//                    foreach($__out as $_xout)
//                    {
//                        return $this->instantiate($_output['class'], $_output['phtml'])->toHtml();
//                    }

//            foreach($_output as $section)
//            {
//                if(is_array($section)) // a View, instantiate class, pass template if available
//                {
//                    $classPath = $this->getConfig('path/basedir').str_replace(_, DS, $section['class']).'.php';
//                    var_dump($classPath);
//                    require_once($classPath);
//                    $class = new $section['class']($section['phtml']);
//                    $_buffer = $_buffer.$class->toHtml();
//
//                } elseif(is_string($section)){ // a block of HTML
//                    $_buffer = $_buffer.$section;
//                }
//
//            }
//            return $_buffer;



}