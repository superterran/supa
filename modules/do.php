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

    const DO_REQUEST_SUCCESS = 200;
    const DO_REQUEST_FAIL = 400;

    public function __construct()
    {

        $do = array_merge_recursive($_GET, $_POST);
        if(isset($do['params']) && json_decode($do['params'])) {
            foreach(json_decode($do['params']) as $key => $val) $do[$key] = $val;
        }
        unset($do['params']);
        $this->setDo($do);

    }

    public function action()
    {

        $do = $this->getDo();

        if($this->getDo('action') && $_SERVER['REQUEST_URI'] == DS)
        {
            $result = false;

            if(isset($do['perform']))
            {
                $perform = $do['perform'];
                $result = $this->$perform[0]($perform[1])->$perform[2]($perform[3]);  //perform action!
            }

            if(isset($do['do'])) {
                $view = $do['do'];
                $result = $this->view($view)->toHtml();
            }

            $this->getModule('session')->saveSession();

            if($result) {
                $this->setResponse('requestCode', self::DO_REQUEST_SUCCESS);
                echo $result;
                exit;
            } else {
                $this->setResponse('requestCode', self::DO_REQUEST_FAIL);
                exit;
            }


        }
    }

}