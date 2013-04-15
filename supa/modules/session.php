<?php

class supa_session extends supa_object {


    public function __construct()
    {
        session_start();
        $this->setSession($_SESSION);

    }

    public function __destruct()
    {
        $this->saveSession();
    }

    public function saveSession()
    {
        $_SESSION = array();
        $_SESSION = $this->getSession();
    }



}