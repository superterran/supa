<?php

class supa_response extends supa_object {

//    const HTTP_RESPONSE_SUCCESS = 200;
//    const HTTP_RESPONSE_ERROR = 400;
//    const HTTP_RESPONSE_NOTFOUND = 404;


    protected function attemptRedirect()
    {
        $redirect = $this->getResponse('redirect');

        if($redirect) {
            $this->getModule('session')->saveSession();
            header('location: '. $this->getUrl($redirect));
            exit();
        }

        return false;
    }

    public function render()
    {

        $this->attemptRedirect(); // because we want to attempt to do things
        # http_response_code($this->getConfig('responseCode')); // broken on hostgator

        echo $this->getModule('layout')->render();

    }



}
