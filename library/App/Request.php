<?php

namespace App;

class Request
{
    /**
     * The Requested Url
     *
     * @var string
     */
    public $redirectUrl;


    /**
     * Array representation of the Requested Url
     *
     * @var array
     */
    private $parts = array();


    /**
     * Controller to invoke
     * @var string
     */
    public $controller;


    /**
     * Action to Invoke
     * @var string
     */
    public $action;


    private $params = array();


    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->parseUrl();
    }

    public function getParam($key)
    {
        return $this->params[$key];
    }


    public function addParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }



    /**
     * @return App_Request
     */
    private function parseUrl()
    {
        if (false === isset($_SERVER['REDIRECT_URL'])) {
            $_SERVER['REDIRECT_URL'] = "/";
            //throw new Exception('RedirectUrl does nog exist in the SERVER array');
        }

        $this->redirectUrl = strtolower($_SERVER['REDIRECT_URL']);

        $urlParts = explode(
            '/',
            trim($this->redirectUrl, "/")
        );

        $this->controller = $this->doShizzle(
            array_shift($urlParts)
        );
        $this->action = $this->doShizzle(
            array_shift($urlParts)
        );

        $this->params = $urlParts;
        $this->params += $_GET;

        return $this;
    }


    private function doShizzle($var)
    {
        return (!empty($var)) ? strtolower($var) : 'index';
    }


    /**
     * Get the Controller to invoke
     *
     * @return string
     */
    public function getControllerName()
    {
        return $this->controller;
    }


    /**
     * Get the action to invoke
     *
     * @return string
     */
    public function getActionName()
    {
        return $this->action;
    }
}