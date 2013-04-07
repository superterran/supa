<?php

/**
 * Do is a simple idea, we need decent ajax and web api chops but
 * the whole point of this framework is to cut down on plumbing.
 * So, do provides simple ajax plumbing. Instead of writing massive
 * javascript clases to handle frontend functinality, your ajax
 * observer or button can just call soemthing like
 *
 *      ui.doAction('thing/to_do', {'data':{'part':'whatever'}});
 *
 * and do will fire that control action, passing those parameters.
 * if it returns true, it returns a successful http response with
 * perhaps some callback output. if false, it returns a 400 with
 * perhaps some callback output.
 *
 * The UI js/prototype object will add a success or error class on to
 * the element that initated the action, or alternaitvely any selector passed
 * as a third parameter to ui.doAction().
 *
 * Class supa_modules_do
 */
class supa_do extends supa_object {

    public function __construct()
    {
        $do = array_merge_recursive($_GET, $_POST);
        $this->setDo($do);
    }

    public function action()
    {
//        if($this->getDo('action'))
//        {
//
//
//
//
//        }
    }

}