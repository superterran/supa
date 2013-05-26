<?php

class supa_observe extends supa_object {

    /**
     * Implements an observer system to help modularize codebase
     * @param $event
     * @param mixed $data
     */
    public function event($event, $data = false) //@todo pass data to the observer like an adult
    {
        $observers = $this->getObservers($event);

        if(isset($observers['class']) && isset($observers['method']))
        {
            $this->instantiate($observers['class'])->$observers['method']();
        }
        elseif(is_array($observers))
        {
            foreach($observers as $i => $attr)
            {
                if(isset($attr['class']) && isset($attr['method']))
                {
                    if($i == $event) $this->instantiate($attr['class'])->$attr['method']();

                }
            }
        }
    }
}