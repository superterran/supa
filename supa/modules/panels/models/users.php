<?php
/**
 * Panel user model, user authentication
 * Class supa_modules_panels_models_users
 */
class supa_modules_panels_models_users extends supa_model_eav {

    /**
     * @todo this needs a stronger login check
     * @param bool $kick
     * @return bool
     */
    public function isLoggedIn($kick = false)
    {

        if($this->getSession('user') && !$this->getSession('user\email')) {
            return true;
        } else {
            if($kick == true) {
                $this->redirect($this->getConfig('path/baseurl'));
            }
        }

        return false;
    }

    public function logout()
    {
        $this->setSession('user','false');
        $this->setSession('messages', array('success'=>'You have been logged out.'));
        $this->setResponse('redirect',$this->getConfig('paths/baseurl'));
    }

    public function login($email, $password)
    {

        if(!$email || !$password) {
            $this->setSession('messages', array('error'=>'Please supply credentials.'));
            $this->setSession('user','false');
            $this->setResponse('redirect', 'panels/users');
            return false;
        }

        $password = $this->hash($password);

        $user = $this->model('panels/users')
            ->filter('email', '=', $email)
            ->filter('password', '=', $password)
            ->getCollection('first');

        if($user) {

            unset($user['password']);
            $this->setSession('user', $user);

            $this->setSession('messages', array('success'=>"Hey! you just logged in!"));
            $this->setResponse('redirect', $this->getConfig('paths/baseurl'));

            return true;

        } else {

            $this->setSession('messages', array('error'=>'Sorry, invalid username or password. Please try again!'));
            $this->setResponse('redirect','panels/users');

            return false;
        }
    }

    public function addUser($email, $password, $level = 1)
    {
        $data = array(
            'email'=>$email,
            'password'=>$this->hash($password),
            'level'=>$level,
        );

        return $this->addData($data);
    }

    /**
     * Add salt
     * @param $string
     * @return string
     */
    protected function hash($string)
    {
        return md5($string);
    }

    public function getUser()
    {
        return $this->getSession('user');
    }

}
