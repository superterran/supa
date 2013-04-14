<?php

class supa_response extends supa_object {

    const HTTP_RESPONSE_SUCCESS = 200;
    const HTTP_RESPONSE_ERROR = 400;
    const HTTP_RESPONSE_NOTFOUND = 404;
    const HTTP_CONTENT_HEADER = 'Content-Type: text/html; charset=utf-8';

    protected $_responseBody = false;
    protected $_responseCode = 200;

    public function __construct()
    {
        if(is_string($this->getConfig('responseCode')))
        {
            $this->_responseCode = $this->getConfig('responseCode');
        }
    }

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

    public function send()
    {
        $this->attemptRedirect(); // because we want to attempt to do things
        $this->sendResponse();
    }

    protected function sendResponse($output = false, $code = false)
    {
        if(!$code) $code = $this->getResponseCode();
        if(!$output) $output = $this->getResponseBody();

        header(':', true, (int) $code);
//        header(self::HTTP_CONTENT_HEADER);
        echo $output;
        exit;
    }

    public function getResponseBody()
    {
        if(!$this->_responseBody) $this->_responseBody = $this->getModule('layout')->render();
        return $this->_responseBody;
    }

    public function getResponseCode()
    {
        if(!is_array($this->getResponse('responseCode'))) {
            return $this->getResponse('responseCode');
        } elseif(!is_array($this->getConfig('responseCode'))){
            return $this->getConfig('responseCode');
        }

        return self::HTTP_RESPONSE_SUCCESS;
    }

}
