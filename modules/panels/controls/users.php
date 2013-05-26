<?php

class supa_modules_panels_controls_users extends supa_control {

    public function indexAction()
    {
        $this->addLayout('content', $this->view('panels/users/login'));
    }

    public function registerAction()
    {
        $this->addLayout('content', $this->view('panels/users/register'));
    }

    public function attemptRegisterAction()
    {
        // for the time being, assume all new users should be added indiscrimately...

        $creds = $this->getDo();
        $errors = array();

        if(!$creds['email']) $errors[] = array('error'=>'email is a required field.');
        if($creds['password'] != $creds['password_confirm']) $errors[] = array('error'=>'passwords must match.');
        if($this->model('panels/users')->filter('email', '=', $creds['email'])->getCollection()) $errors[] = array('error'=>'email already registered.');

        if(empty($errors)) {
            $this->model('panels/users')->addUser($creds['email'], $creds['password']);
        } else {
            $this->setRequest('messages', $errors);
        }

        $this->attemptAction();
    }

    public function attemptAction()
    {
        $this->model('panels/users')->login($this->getDo('email'), $this->getDo('password'));
    }

    public function logoutAction()
    {
        return $this->model('panels/users')->logout();
    }
}