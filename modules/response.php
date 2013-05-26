<?php

class supa_response extends supa_object {

    const HTTP_RESPONSE_SUCCESS = 200;
    const HTTP_RESPONSE_ERROR = 400;
    const HTTP_RESPONSE_NOTFOUND = 404;

    protected $_responseCode;
    protected $_responseBody = false;

    public function __construct()
    {
        if(is_string($this->getConfig('responseCode')))
        {
            $this->_responseCode = $this->getConfig('responseCode');
        }
    }

    public function redirect($url)
    {
        $this->setResponse($url);
        $this->attemptRedirect();
    }

    protected function attemptRedirect()
    {
        $redirect = $this->getResponse('redirect');
        if($redirect) {

            $this->observe('redirect_before');
            header('location: '. $this->getUrl($redirect)); exit; // @todo kill the exit
            return true;
        }
        return false;
    }

    public function send()
    {
        $this->observe('page_render_before');
        $this->sendResponse();
        $this->observe('page_render_after');
    }

    protected function sendResponse($output = false, $code = false)
    {
        if(!$code) $code = $this->getResponseCode();
        if(!$this->attemptRedirect()) {
            header(':', true, $code);
            if(!$output) $output = $this->getResponseBody();
            echo $output;
        }
    }

    public function getResponseBody()
    {
        if(!$this->_responseBody) $this->_responseBody = $this->getModule('layout')->render();
        return $this->_responseBody;
    }

    public function setResponseBody($body)
    {
        return $this->_responseBody .= $body;
    }

    public function getResponseCode()
    {
        if(is_string($this->getResponse('responseCode'))) {
            return $this->getResponse('responseCode');
        } elseif(is_string($this->getConfig('responseCode'))){
            return $this->getConfig('responseCode');
        }

        return self::HTTP_RESPONSE_SUCCESS;
    }

}
