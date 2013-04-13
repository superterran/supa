<?php

class supa_modules_panels_controls_users extends supa_control {

    public function indexAction()
    {
        $this->addLayout('content', $this->view('panels/login'));
    }

    public function addAction()
    {
        $this->addLayout('content', $this->view('panels/add'));
    }

    public function newAction()
    {
        // for the time being, assume all new users should be added indiscrimately...

        $creds = $this->getDo();
        $errors = array();


        if(!$creds['email']) $errors[] = array('error'=>'email is a required field.');
        if($creds['password'] != $creds['password_confirm']) $errors[] = array('error'=>'passwords must match.');
        if($this->model('panels/users')->filter('email', '=', $creds['email'])->getCollection()) $errors[] = array('error'=>'email already registered.');

        if(empty($errors)) {
            $this->model('panels/users')->addUser($creds['email'], $creds['password']);
       //     var_dump($creds); die();
        } else {
            $this->setRequest('messages', $errors);
        }

        $this->loginAction();

    }

    public function loginAction()
    {
        if($this->model('panels/users')->login($this->getDo('email'), $this->getDo('password')));
    }

    public function logoutAction()
    {
        return $this->model('panels/users')->logout();
    }
}